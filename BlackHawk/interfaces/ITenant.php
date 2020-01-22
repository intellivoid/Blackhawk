<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: ITenant.php
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

use BlackHawk\exceptions\configuration\ConfigReadException;

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