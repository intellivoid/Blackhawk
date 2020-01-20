<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: SecureStorage.php
 *
 *
 * Created: 1/20/20, 1:04 PM
 * Last modified: 1/20/20, 5:30 AM
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
    private $_globalObjects;

    /**
     * Array containing global variables during runtime.
     * ENCRYPTED
     *
     * @var array
     */
    private $_globalVariables;

    /**
     * Array containing provisioned tenants during runtime.
     * UNENCRYPTED
     *
     * @var array
     */
    private $_tenants;

    /**
     * @var BlackHawk
     */
    private $bhMain;

    public function __construct(BlackHawk $main)
    {
        $this->bhMain = $main;
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
        $this->_globalObjects[$variable_name] = $object;
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

        return $this->_globalObjects[$variable_name];
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