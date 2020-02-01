<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: Runtime.php
 *
 *
 * Created: 2/1/20, 12:25 PM
 * Last modified: 1/26/20, 2:54 AM
 * Modified by: intellivoid/antiengineer
 *
 * @copyright 2020 (C) Nighthawk Media Group
 * @author Diederik Noordhuis, Zi Xing Narrakas
 *
 * For more information, contact diederikn@intellivoid.info.
 * No modifications allowed. Distribution is prohibited.
 *
 */

namespace BlackHawk\classes\render;


use BlackHawk\BlackHawk;
use BlackHawk\defaults\handlers\ServerException;
use BlackHawk\defaults\handlers\TenantNotFound;

class Runtime
{
    public static function handleException(BlackHawk $main, \Exception $e, array $ipstack){
        WebRender::loadHandler(new ServerException($main), $main->getConfig(), $ipstack, ["exception" => $e]);
    }
}