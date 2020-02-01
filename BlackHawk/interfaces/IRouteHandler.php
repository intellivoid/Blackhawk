<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: IRouteHandler.php
 *
 *
 * Created: 2/1/20, 12:25 PM
 * Last modified: 1/24/20, 6:07 PM
 * Modified by: intellivoid/antiengineer
 *
 * @copyright 2020 (C) Nighthawk Media Group
 * @author Diederik Noordhuis, Zi Xing Narrakas
 *
 * For more information, contact diederikn@intellivoid.info.
 * No modifications allowed. Distribution is prohibited.
 *
 */

namespace BlackHawk\interfaces;

use Exception;

/**
 * Interface IRouteHandler
 * @package BlackHawk\interfaces
 */
interface IRouteHandler
{
    /**
     * Processes the request in the first place
     *
     * @param array $Params
     * @param array $IPStackData
     * @return void
     */
    public function processRequest(array $Params, array $IPStackData = []) : void;
}