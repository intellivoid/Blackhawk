<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: BlackHawk.php
 *
 *
 * Created: 1/21/20, 3:43 AM
 * Last modified: 1/21/20, 2:27 AM
 * Modified by: intellivoid/antiengineer
 *
 * @copyright 2020 (C) Nighthawk Media Group
 * @author Diederik Noordhuis, Zi Xing Narrakas
 *
 * For more information, contact diederikn@intellivoid.info.
 * No modifications allowed. Distribution is prohibited.
 *
 */

namespace BlackHawk;

use BlackHawk\classes\managers\security\CryptoManager;
use BlackHawk\classes\managers\tenants\TenantManager;
use BlackHawk\objects\Configuration;

/**
 * Class BlackHawk
 * @package BlackHawk
 */
class BlackHawk
{
    /**
     * @var Configuration
     */
    private $_configObj;

    /**
     * @var TenantManager
     */
    private $_tenantManager;

    /**
     * @var CryptoManager
     */
    private $_cryptoManager;


}