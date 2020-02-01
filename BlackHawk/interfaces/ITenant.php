<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: ITenant.php
 *
 *
 * Created: 2/1/20, 12:25 PM
 * Last modified: 1/24/20, 6:59 PM
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
     * @param array $IPStackData
     */
    public function processIncomingRequest(array $IPStackData) : void;

}