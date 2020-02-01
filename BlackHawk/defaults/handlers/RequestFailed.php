<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: RequestFailed.php
 *
 *
 * Created: 2/1/20, 12:25 PM
 * Last modified: 1/31/20, 3:17 PM
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


use BlackHawk\BlackHawk;
use BlackHawk\classes\render\WebRender;
use BlackHawk\classes\Utilities;
use BlackHawk\objects\Route;
use BlackHawk\objects\RouteHandler;

class RequestFailed extends RouteHandler
{
    private $clientId;
    private $requestId;

    private $failedHandler;
    private $route;
    private $debug = false;

    /**
     * RequestFailed constructor.
     * @param Route $route
     * @param RouteHandler $failedHandler
     * @param BlackHawk $main
     */
    public function __construct(Route $route, RouteHandler $failedHandler, BlackHawk $main)
    {
        $this->route = $route;
        $this->failedHandler = $failedHandler;
        if($main->getConfig()->get("debug")["dev"]) {
            $this->debug = true;
            parent::__construct(true, $main);
        } else {
            parent::__construct(false, $main);
        }

    }

    /**
     * @param array $Params
     * @param array $IPStackData
     * @return bool
     */
    protected function onReceive(array $Params, array $IPStackData = []): bool
    {
        $this->clientId = Utilities::createDeviceFingerprint();
        $this->requestId = Utilities::createUUID();

        return true;
    }

    /**
     * @param array $Params
     * @param array $IPStackData
     * @return bool
     */
    protected function onComplete(array $Params, array $IPStackData = []): bool
    {
        if ($this->debug) {
            echo json_encode([
                "_v" => "BlackHawk.ReqFailed",
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
                            "parameters" => $Params
                        ]
                    ],
                    "message" => "The resource '{$this->route->name}' has reported a failed status during the request.\n\nIf you are the administrator, make sure to properly setup the Handlers (non-false return) on the respective resource.\nIf you're an user, the server is unable to fulfill your request. Try again later."
                ]
            ], JSON_PRETTY_PRINT);
        } else {
            WebRender::staticResponse(
                "Server Error",
                500,
                "Internal Server Error",
                "An application error has occurred and your request was not processed. Check the logs for more information.<br>Try performing this request in a few minutes; If this error message is persistent, contact the website administrator.",
                true
            );
        }
        return true;
    }
}