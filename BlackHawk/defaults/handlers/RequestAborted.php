<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: RequestAborted.php
 *
 *
 * Created: 1/22/20, 4:56 PM
 * Last modified: 1/22/20, 4:39 PM
 * Modified by: intellivoid/antiengineer
 *
 * @copyright 2020 (C) Nighthawk Media Group
 * @author Diederik Noordhuis, Zi Xing Narrakas
 *
 * For more information, contact diederikn@intellivoid.info.
 * No modifications allowed. Distribution is prohibited.
 *
 */

namespace BlackHawk\defaults\handlers;


use BlackHawk\classes\Utilities;
use BlackHawk\objects\Route;
use BlackHawk\objects\RouteHandler;

class RequestAborted extends RouteHandler
{
    private $clientId;
    private $requestId;

    private $failedHandler;
    private $route;

    /**
     * RequestAborted constructor.
     * @param Route $route
     * @param RouteHandler $failedHandler
     */
    public function __construct(Route $route, RouteHandler $failedHandler)
    {
        $this->route = $route;
        $this->failedHandler = $failedHandler;
        parent::__construct(true);
    }

    /**
     * @param array $Params
     * @return bool
     */
    protected function onReceive(array $Params): bool
    {
        $this->clientId = Utilities::createDeviceFingerprint();
        $this->requestId = Utilities::createUUID();

        return true;
    }

    /**
     * @param array $Params
     * @return bool
     */
    protected function onComplete(array $Params): bool
    {
        http_response_code(500);
        echo json_encode([
            "_v" => "BlackHawk.InternalServerError",
            "_tme" => [
                "usr" => $this->clientId,
                "req" => $this->requestId
            ],
            "info" => [
                "affected_type" => get_class($this->route),
                "affected_resource" => $this->route->name,
                "handlers" => [
                    0 => [
                        "status" => $this->failedHandler->getRequestStatus(),
                        "parameters" => $Params,
                        "error" => $this->failedHandler->error
                    ]
                ],
                "message" => "The resource '{$this->route->name}' had a unexpected Exception, leading to a Internal Server Error\n\nIf you are the administrator, make sure the server does not have a misconfiguration.\nIf you're an user, the server is unable to fulfill your request. Try again later."
            ]
        ], JSON_PRETTY_PRINT);
        return true;
    }
}