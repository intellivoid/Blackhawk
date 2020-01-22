<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: ITenant.php
 *
 *
 * Created: 1/22/20, 4:57 PM
 * Last modified: 1/22/20, 4:31 PM
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

use BlackHawk\exceptions\configuration\ConfigReadException;
use BlackHawk\objects\RouteHandler;

/**
 * Interface ITenant
 * @package BlackHawk\interfaces
 */
interface ITenant
{
    /**
     * Gets Tenant Information
     *
     * @return array
     * @throws ConfigReadException
     */
    public function getTenantInfo() : array;

    /**
     * Processes incoming request for the specific tenant.
     */
    public function processIncomingRequest() : void;

}