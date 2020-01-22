<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: Route.php
 *
 *
 * Created: 1/22/20, 5:16 AM
 * Last modified: 1/22/20, 5:12 AM
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

/**
 * Class Route
 * @package BlackHawk\objects
 */
class Route
{
    /**
     * @var string Piped request method
     */
    public $requestMethod;

    /**
     * @var string URI Path for Route
     */
    public $route;

    /**
     * @var RouteHandler Route Handler
     */
    public $handler;

    /**
     * @var string Route Name
     */
    public $name;

    /**
     * Route constructor.
     * @param string $rm
     * @param string $r
     * @param RouteHandler $h
     * @param string $n
     */
    public function __construct(string $rm = "", string $r = "", RouteHandler $h = null, string $n = "")
    {
        $this->requestMethod = $rm;
        $this->route = $r;
        $this->handler = $h;
        $this->name = $n;
    }
}