<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: IRouteHandler.php
 *
 *
 * Created: 1/22/20, 5:11 AM
 * Last modified: 1/21/20, 6:32 AM
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
     * @return void
     * @throws Exception
     */
    public function processRequest(array $Params) : void;
}