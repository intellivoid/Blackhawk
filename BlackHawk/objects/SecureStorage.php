<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: SecureStorage.php
 *
 *
 * Created: 2/1/20, 12:25 PM
 * Last modified: 1/30/20, 5:20 PM
 * Modified by: intellivoid/antiengineer
 *
 * @copyright 2020 (C) Nighthawk Media Group
 * @author Diederik Noordhuis, Zi Xing Narrakas
 *
 * For more information, contact diederikn@intellivoid.info.
 * No modifications allowed. Distribution is prohibited.
 *
 */

namespace BlackHawk\objects;
use BlackHawk\BlackHawk;
use BlackHawk\classes\managers\security\CryptoManager;
use ZiProto\ZiProto;

/**
 * Class SecureStorage
 * @package BlackHawk\objects
 */
class SecureStorage
{
    /**
     * Array containing global objects during runtime.
     * ENCRYPTED
     *
     * @var array
     */
    public $_globalObjects;

    /**
     * Array containing global variables during runtime.
     * UNENCRYPTED
     *
     * @var array
     */
    public $_globalVariables;

    /**
     * Array containing provisioned tenants during runtime.
     * ENCRYPTED
     *
     * @var array
     */
    public $_tenants;

    /**
     * @var BlackHawk
     */
    private $bhMain;

    public function __construct(BlackHawk $main)
    {
        $this->bhMain = $main;
        $this->_tenants = [];
        $this->_globalObjects = [];
        $this->_globalVariables = [];
    }


    /**
     * Adds a new tenant to memory, and returns boolean representing action status
     *
     * @param Tenant $tenant
     * @return void
     */
    public function addTenant(Tenant $tenant) {
        $hostname = $tenant->getTenantInfo()["hostname"];
        $this->_tenants[$hostname] = CryptoManager::AesEncrypt($this->bhMain->getConfig()->get("security")["encryptionKey"], ZiProto::encode(serialize($tenant)), $this->bhMain->getConfig()->get("security")["salts"]["VX1"], $this->bhMain->getConfig()->get("security")["salts"]["VX2"], $this->bhMain->getConfig()->get("security")["salts"]["VX1*X2"]);
    }

    /**
     * Returns encrypted tenants
     *
     * @return array
     */
    public function getTenants(){
        //return $this->_tenants;
        $tenants = [];
        foreach ($this->_tenants as $hostname => $tenantEnc) {
            $tenants[$hostname] = unserialize(ZiProto::decode(CryptoManager::AesDecrypt($this->bhMain->getConfig()->get("security")["encryptionKey"], $tenantEnc, $this->bhMain->getConfig()->get("security")["salts"]["VX1"], strlen($this->bhMain->getConfig()->get("security")["salts"]["VX2"]), strlen($this->bhMain->getConfig()->get("security")["salts"]["VX1*X2"]))));
        }
        return $tenants;
    }

    /**
     * Returns requested tenant
     *
     * @param string $tenantHostname
     * @return bool|mixed
     */
    public function getTenant(string $tenantHostname) {
        if(!isset($this->_tenants[$tenantHostname])) {
            return false;
        } else {
            return ZiProto::decode(CryptoManager::AesDecrypt($this->bhMain->getConfig()->get("security")["encryptionKey"], $this->_tenants[$tenantHostname], $this->bhMain->getConfig()->get("security")["encryptionKey"]["salts"]["VX1"], $this->bhMain->getConfig()->get("security")["encryptionKey"]["salts"]["VX2"], $this->bhMain->getConfig()->get("security")["encryptionKey"]["salts"]["VX1*X2"]));
        }
    }

    /**
     * Sets an object to memory, and returns the object that's stored in memory
     *
     * @param string $variable_name
     * @param $object
     * @return mixed
     */
    public  function setMemoryObject(string $variable_name, $object)
    {
        $this->_globalObjects[$variable_name] = CryptoManager::AesEncrypt($this->bhMain->getConfig()->get("security")["encryptionKey"], ZiProto::encode($object), $this->bhMain->getConfig()->get("security")["encryptionKey"]["salts"]["VX1"], $this->bhMain->getConfig()->get("security")["encryptionKey"]["salts"]["VX2"], $this->bhMain->getConfig()->get("security")["encryptionKey"]["salts"]["VX1*X2"]);
        return $this->_globalObjects[$variable_name];
    }

    /**
     * Gets an object from memory, if not set then it will return null
     *
     * @param string $variable_name
     * @return mixed|null
     */
    public  function getMemoryObject(string $variable_name)
    {
        if(isset($this->_globalObjects[$variable_name]) == false)
        {
            return null;
        }

        return ZiProto::decode(CryptoManager::AesDecrypt($this->bhMain->getConfig()->get("security")["encryptionKey"], $this->_globalObjects[$variable_name], $this->bhMain->getConfig()->get("security")["encryptionKey"]["salts"]["VX1"], $this->bhMain->getConfig()->get("security")["encryptionKey"]["salts"]["VX2"], $this->bhMain->getConfig()->get("security")["encryptionKey"]["salts"]["VX1*X2"]));
    }

    /**
     * Sets a global string variable and returns the value from memory
     *
     * @param string $name
     * @param string $value
     * @return string
     */
    public  function setString(string $name, string $value): string
    {
        $this->_globalVariables['db 0x77'][$name] = $value;
        return $this->_globalVariables['db 0x77'][$name];
    }

    /**
     * Returns an existing global string variable
     *
     * @param string $name
     * @return string
     * @throws Exception
     */
    public  function getString(string $name): string
    {
        if(isset($this->_globalVariables['db 0x77'][$name]) == false)
        {
            throw new Exception('"' . $name . '" is not defined in globalObjects[db 0x77]');
        }

        return $this->_globalVariables['db 0x77'][$name];
    }

    /**
     * Sets a global integer variable and returns the value from memory
     *
     * @param string $name
     * @param int $value
     * @return int
     */
    public  function setInt32(string $name, int $value): int
    {
        $this->_globalVariables['db 0x26'][$name] = $value;
        return $this->_globalVariables['db 0x26'][$name];
    }

    /**
     * returns an existing global integer variable
     *
     * @param string $name
     * @return int
     * @throws Exception
     */
    public  function getInt32(string $name): int
    {
        if(isset($this->_globalVariables['db 0x26'][$name]) == false)
        {
            throw new Exception('"' . $name . '" is not defined in globalObjects[db 0x26]');
        }

        return $this->_globalVariables['db 0x26'][$name];
    }

    /**
     * Sets a global float variable and returns the value from memory
     *
     * @param string $name
     * @param float $value
     * @return float
     */
    public  function setFloat(string $name, float $value): float
    {
        $this->_globalVariables['db 0x29'][$name] = $value;
        return $this->_globalVariables['db 0x29'][$name];
    }

    /**
     * Returns an existing global float variable
     *
     * @param string $name
     * @return float
     * @throws Exception
     */
    public  function getFloat(string $name): float
    {
        if(isset($this->_globalVariables['db 0x29'][$name]) == false)
        {
            throw new Exception('"' . $name . '" is not defined in globalObjects[db 0x29]');
        }

        return $this->_globalVariables['db 0x29'][$name];
    }

    /**
     * Sets a global boolean variable and returns the value from memory
     *
     * @param string $name
     * @param bool $value
     * @return bool
     */
    public  function setBoolean(string $name, bool $value): bool
    {
        $this->_globalVariables['db 0x43'][$name] = (int)$value;
        return (bool)$this->_globalVariables['db 0x43'][$name];
    }

    /**
     * Returns an existing global boolean variable
     *
     * @param string $name
     * @return bool
     * @throws Exception
     */
    public  function getBoolean(string $name): bool
    {
        if(isset($this->_globalVariables['db 0x43'][$name]) == false)
        {
            throw new Exception('"' . $name . '" is not defined in globalObjects[db 0x43]');
        }

        return (bool)$this->_globalVariables['db 0x43'][$name];
    }

    /**
     * Sets a global array variable and returns the value from memory
     *
     * @param string $name
     * @param array $value
     * @return array
     */
    public  function setArray(string $name, array $value): array
    {
        $this->_globalVariables['db 0x83'][$name] = $value;
        return $this->_globalVariables['db 0x83'][$name];
    }

    /**
     * Returns an existing global array variable
     *
     * @param string $name
     * @return bool
     * @throws Exception
     */
    public  function getArray(string $name): array
    {
        if(isset($this->_globalVariables['db 0x83'][$name]) == false)
        {
            throw new Exception('"' . $name . '" is not defined in globalObjects[db 0x83]');
        }

        return $this->_globalVariables['db 0x83'][$name];
    }
}