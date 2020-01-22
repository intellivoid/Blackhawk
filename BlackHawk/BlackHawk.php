<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: BlackHawk.php
 *
 *
 * Created: 1/22/20, 4:58 PM
 * Last modified: 1/22/20, 12:12 PM
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
use BlackHawk\objects\SecureStorage;

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

    /**
     * @var SecureStorage
     */
    private $_secureStorage;

    /**
     * @return Configuration
     */
    public function getConfig(): Configuration
    {
        return $this->_configObj;
    }

    /**
     * @return TenantManager
     */
    public function getTenantManager(): TenantManager
    {
        return $this->_tenantManager;
    }


    /**
     * @return SecureStorage
     */
    public function getSecureStorage(): SecureStorage
    {
        return $this->_secureStorage;
    }

    /**
     * BlackHawk constructor.
     */
    public function __construct(){
        $this->_configObj = new Configuration();
        $this->_tenantManager = new TenantManager();
        $this->_cryptoManager = new CryptoManager();
        $this->_secureStorage = new SecureStorage($this);
    }
}