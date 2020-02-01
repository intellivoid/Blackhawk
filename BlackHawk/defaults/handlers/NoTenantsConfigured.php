<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: NoTenantsConfigured.php
 *
 *
 * Created: 2/1/20, 12:25 PM
 * Last modified: 1/24/20, 6:54 PM
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
use BlackHawk\objects\Route;
use BlackHawk\objects\RouteHandler;

class NoTenantsConfigured extends RouteHandler
{
    private $clientId;
    private $requestId;

    /**
     * NoTenantsConfigured constructor.
     * @param BlackHawk $main
     */
    public function __construct(BlackHawk $main)
    {
        parent::__construct(false, $main);
    }

    public function onReceive(array $Params, array $IPStackData = []): bool
    {

    }
}