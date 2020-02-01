<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: RequestAborted.php
 *
 *
 * Created: 2/1/20, 12:25 PM
 * Last modified: 1/31/20, 3:29 PM
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
use BlackHawk\classes\render\Runtime;
use BlackHawk\classes\render\WebRender;
use BlackHawk\classes\Utilities;
use BlackHawk\objects\Route;
use BlackHawk\objects\RouteHandler;

class RequestAborted extends RouteHandler
{
    private $clientId;
    private $requestId;

    private $failedHandler;
    private $route;
    private $debug = false;
    private $bhMain;
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
        $this->bhMain = $main;
        if($main->getConfig()->get("debug")["dev"]) {
            $this->debug = true;
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
        return true;
    }

    /**
     * @param array $Params
     * @param array $IPStackData
     * @return bool
     */
    protected function onComplete(array $Params, array $IPStackData = []): bool
    {
        Runtime::handleException($this->bhMain, $this->failedHandler->error, $IPStackData);
        return true;
    }
}