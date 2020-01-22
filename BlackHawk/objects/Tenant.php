<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: Tenant.php
 *
 *
 * Created: 1/22/20, 4:58 PM
 * Last modified: 1/22/20, 4:43 PM
 * Modified by: intellivoid/antiengineer
 *
 * @copyright 2020 (C) Nighthawk Media Group
 * @author Diederik Noordhuis, Zi Xing Narrakas
 *
 * For more information, contact diederikn@intellivoid.info.
 * No modifications allowed. Distribution is prohibited.
 *
 */

namespace BlackHawk\objects;


use BlackHawk\abstracts\RequestStatus;
use BlackHawk\defaults\handlers\RequestAborted;
use BlackHawk\defaults\handlers\RequestFailed;
use BlackHawk\exceptions\configuration\ConfigParseException;
use BlackHawk\exceptions\configuration\ConfigReadException;
use BlackHawk\exceptions\tenants\router\RouteExistsException;
use BlackHawk\exceptions\tenants\router\RouteNotFoundException;
use BlackHawk\interfaces\ITenant;
use BlackHawk\objects\RouteHandler;
use BlackHawk\objects\Route;

class Tenant implements ITenant
{
    /**
     * @var array
     */
    private $tenantConfig;

    /**
     * @var array
     */
    private $routes;

    /**
     * @var array
     */
    private $namedRoutes;

    /**
     * @var array Array of defaults match types (regex helpers)
     */
    protected $matchTypes = [
        'i'  => '[0-9]++',
        'a'  => '[0-9A-Za-z]++',
        'h'  => '[0-9A-Fa-f]++',
        '*'  => '.+?',
        '**' => '.++',
        ''   => '[^/\.]++'
    ];

    /**
     * @inheritDoc
     */
    public function getTenantInfo(): array
    {
        return $this->tenantConfig["info"];
    }

    /**
     * Dummy function executed when a route is not located.
     */
    private function RouteNotFound() {
        /*
         * TODO: Customize this route to provide a result in the case a Route is not found
         */
    }

    /**
     * @inheritDoc
     */
    public function processIncomingRequest(): void
    {
        if(!$this->getRouteByRequest()) {
            $this->RouteNotFound();
        } else {
            $route = $this->getRouteByRequest();
            $route["handler"]->processRequest($route["params"]);

            if($route["handler"]->GetRequestStatus() == RequestStatus::Failed) {
                $rf = new RequestFailed($this->namedRoutes[$route["name"]], $route["handler"]);
                $rf->processRequest($route["params"]);
            }

            if($route["handler"]->GetRequestStatus() == RequestStatus::Aborted) {
                $rf = new RequestAborted($this->namedRoutes[$route["name"]], $route["handler"]);
                $rf->processRequest($route["params"]);
            }
        }
    }

    /**
     * Tenant constructor.
     */
    public function __construct()
    {
        if(!file_exists(__DIR__.DIRECTORY_SEPARATOR."tenant.json")) {
            throw new ConfigReadException("Unable to read tenant configuration. Make sure tenant.json is present and try again.");
        }
        $tCfg = file_get_contents(__DIR__.DIRECTORY_SEPARATOR."tenant.json");
        $tCfgD = json_decode($tCfg, false);
        if(is_null($tCfgD)){
            throw new ConfigParseException("Unable to parse tenant configuration. Are you sure the configuration is not malformed?");
        }
        $this->tenantConfig = $tCfgD;
        $this->onTenantLoad();
    }

    /**
     * Function executed during tenant load.
     * Declare routes, and such into the scope of this function
     *
     * @return void
     */
    protected function onTenantLoad() {
        /**
         * Override with route adding, etc
         */
        return;
    }
    /**
     * Adds a route to a specific handler
     *
     * @param string $routeName Specifies route name
     * @param string $routeRequestMethod One of 5 HTTP Methods, or a pipe-separated list of multiple HTTP Methods (GET|POST|PATCH|PUT|DELETE)
     * @param string $routeFormat The route regex, custom regex must start with an @. You can use multiple pre-set regex filters, like [i:id]
     * @param RouteHandler $routeHandler The handler where this route should point to. Can be anything.
     * @throws RouteExistsException
     */
    private function addRoute(string $routeName, string $routeRequestMethod, string $routeFormat, RouteHandler $routeHandler) : void
    {
        $route = new Route();
        $route->name = $routeName;
        $route->requestMethod = $routeRequestMethod;
        $route->route = $routeFormat;
        $route->handler = $routeHandler;

        $this->routes[] = $route;

        if ($routeName) {
            if (isset($this->namedRoutes[$routeName])) {
                throw new RouteExistsException("Unable to redeclare route '{$routeName}'");
            }
            $this->namedRoutes[$routeName] = $route;
        }
        return;
    }

    /**
     * Reversed routing
     *
     * Generate the URL for a named route. Replace regex with supplied parameters
     *
     * @param string $routeName The name of the route.
     * @param array @params Associative array of parameters to replace placeholders with.
     * @return string The URL of the route with named parameters in place.
     * @throws RouteNotFoundException
     */
    public function reverseRoute(string $routeName, array $params = []) : string
    {
        // Check if named route exists
        if (!isset($this->namedRoutes[$routeName])) {
            throw new RouteNotFoundException("Route '{$routeName}' does not exist.");
        }

        // Replace named parameters
        $route = $this->namedRoutes[$routeName];

        // prepend base path to route url again
        $url = $route;
        if (preg_match_all('`(/|\.|)\[([^:\]]*+)(?::([^:\]]*+))?\](\?|)`', $route, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $index => $match) {
                list($block, $pre, $type, $param, $optional) = $match;
                if ($pre) {
                    $block = substr($block, 1);
                }
                if (isset($params[$param])) {
                    // Part is found, replace for param value
                    $url = str_replace($block, $params[$param], $url);
                } elseif ($optional && $index !== 0) {
                    // Only strip preceding slash if it's not at the base
                    $url = str_replace($pre . $block, '', $url);
                } else {
                    // Strip match block
                    $url = str_replace($block, '', $url);
                }
            }
        }
        return $url;
    }

    /**
     * Compile the regex for a given route (EXPENSIVE)
     * @param $route
     * @return string
     */
    public function compileRoute($route)
    {
        if (preg_match_all('`(/|\.|)\[([^:\]]*+)(?::([^:\]]*+))?\](\?|)`', $route, $matches, PREG_SET_ORDER)) {
            $matchTypes = $this->matchTypes;
            foreach ($matches as $match) {
                list($block, $pre, $type, $param, $optional) = $match;
                if (isset($matchTypes[$type])) {
                    $type = $matchTypes[$type];
                }
                if ($pre === '.') {
                    $pre = '\.';
                }
                $optional = $optional !== '' ? '?' : null;
                //Older versions of PCRE require the 'P' in (?P<named>)
                $pattern = '(?:'
                    . ($pre !== '' ? $pre : null)
                    . '('
                    . ($param !== '' ? "?P<$param>" : null)
                    . $type
                    . ')'
                    . $optional
                    . ')'
                    . $optional;
                $route = str_replace($block, $pattern, $route);
            }
        }
        return "`^$route$`u";
    }

    /**
     * Gets target route from request
     *
     * @return array|boolean Array with route information on success, false on failure (no match).
     */
    protected function getRouteByRequest()
    {
        $requestUrl = null;
        $requestMethod = null;
        $params = [];

        // set Request Url if it isn't passed as parameter
        if ($requestUrl === null) {
            $requestUrl = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
        }

        // Strip query string (?a=b) from Request Url
        if (($strPos = strpos($requestUrl, '?')) !== false) {
            $requestUrl = substr($requestUrl, 0, $strPos);
        }

        $lastRequestUrlChar = $requestUrl[strlen($requestUrl)-1];
        // set Request Method if it isn't passed as a parameter
        if ($requestMethod === null) {
            $requestMethod = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
        }
        foreach ($this->routes as $route) {
            $routeName = $route->name;
            $routeMethods = $route->requestMethod;
            $routeHandler = $route->handler;
            $routeFormat = $route->route;
            $method_match = (stripos($routeMethods, $requestMethod) !== false);
            // Method did not match, continue to next route.
            if (!$method_match) {
                continue;
            }

            if ($routeFormat === '*') {
                // * wildcard (matches all)
                $match = true;
            } elseif (isset($routeFormat[0]) && $routeFormat[0] === '@') {
                // @ regex delimiter
                $pattern = '`' . substr($route, 1) . '`u';
                $match = preg_match($pattern, $requestUrl, $params) === 1;
            } elseif (($position = strpos($routeFormat, '[')) === false) {

                // No params in url, do string comparison
                $match = strcmp($requestUrl, $routeFormat) === 0;
            } else {
                // Compare longest non-param string with url before moving on to regex
                // Check if last character before param is a slash, because it could be optional if param is optional too
                if (strncmp($requestUrl, $routeFormat, $position) !== 0 && ($lastRequestUrlChar === '/' || $routeFormat[$position-1] !== '/')) {
                    continue;
                }
                $regex = $this->compileRoute($routeFormat);
                $match = preg_match($regex, $requestUrl, $params) === 1;
            }
            if ($match) {

                if ($params) {
                    foreach ($params as $key => $value) {
                        if (is_numeric($key)) {
                            unset($params[$key]);
                        }
                    }
                }
                return [
                    'handler' => $routeHandler,
                    'params' => $params,
                    'name' => $routeName
                ];
            }
        }
        return false;
    }

    /**
     * Gets array of routes
     *
     * @return array
     */
    public function GetRoutes(){
        return $this->routes;
    }
}