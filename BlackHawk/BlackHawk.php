<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: BlackHawk.php
 *
 *
 * Created: 2/1/20, 12:25 PM
 * Last modified: 1/30/20, 8:56 PM
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
use BlackHawk\classes\render\Runtime;
use BlackHawk\classes\render\WebRender;
use BlackHawk\classes\Utilities;
use BlackHawk\defaults\handlers\NoTenantsConfigured;
use BlackHawk\defaults\handlers\TenantNotFound;
use BlackHawk\objects\Configuration;
use BlackHawk\objects\SecureStorage;
use BlackHawk\objects\Tenant;
use Exception;
use IPStack\IPStack;

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
     * @var SecureStorage
     */
    private $_secureStorage;

    /**
     * @var string
     */
    public $mainDir;

    /**
     * @var object
     */
    public $_IPStack;

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
        $this->mainDir = getcwd();
        $this->_configObj = new Configuration();
        $this->_secureStorage = new SecureStorage($this);
        if(isset(getallheaders()["X-BlackHawkDebug"])){
            if(getallheaders()["X-BlackHawkDebug"] == $this->getConfig()->get("debug")["debug_trigger_tag"]) {
                $autocfg = $this->getConfig()->configuration;
                $autocfg["debug"]["dev"] = true;
                $this->getConfig()->configuration = $autocfg;
            }
        }
        $this->defineVariables();
        if($this->_configObj->get("providers")["IPStack"]["enabled"]) {
            $this->_IPStack = new IPStack($this->_configObj->get("providers")["IPStack"]["key"]);
        } else {
            $this->_IPStack = null;
        }
        try {
            $this->_tenantManager = new TenantManager($this);
        } catch (Exception $e) {
            Runtime::handleException($this, $e, $this->isIPStackEnabled() ? $this->_IPStack->lookup(Utilities::getClientIP())->toArray() : []);
        }
    }

    /**
     * Starts BlackHawk Engine, along with the respective tenant manager, and begins with request processing.
     *
     * @return void
     */
    public function init() {
        $tenants = $this->getSecureStorage()->getTenants();
        $ipstack = $this->isIPStackEnabled() ? $this->_IPStack->lookup(Utilities::getClientIP())->toArray() : [];
        try {
            if(count($tenants) == 0) {
                WebRender::loadHandler(new NoTenantsConfigured($this), $this->getConfig(), $ipstack);
            } else {
                if(isset($tenants[$_SERVER["HTTP_HOST"]])) {
                    /** @var Tenant $target */

                    $target = $tenants[$_SERVER["HTTP_HOST"]];
                    $target->processIncomingRequest($ipstack);
                } else {
                    if(isset($tenants[$this->getConfig()->get("render")["defaultTenant"]])) {
                        /** @var Tenant $target */

                        $target = $tenants[$this->getConfig()->get("render")["defaultTenant"]];
                        $target->processIncomingRequest($ipstack);
                    } else {
                        // TODO: Debug log event
                        WebRender::loadHandler(new TenantNotFound($this), $this->getConfig(), $ipstack);
                    }
                };
            }
        } catch (Exception $e) {
            Runtime::handleException($this, $e, $ipstack);
        }

    }

    /**
     * Returns a defined variable, returns null if it doesn't exist
     *
     * @param string $var
     * @return mixed|null
     */
    public static function getDefinedVariable(string $var)
    {
        if(defined($var))
        {
            return constant($var);
        }

        return null;
    }

    /**
     * Returns an array of "system" defined variables created by DynamicalWeb
     *
     * @return array
     */
    public static function getDefinedVariables()
    {
        return array(
            'BLACKHAWK_VERSION' => self::getDefinedVariable('BLACKHAWK_VERSION'),
            'CLIENT_REMOTE_HOST' => self::getDefinedVariable('CLIENT_REMOTE_HOST'),
            'CLIENT_USER_AGENT' => self::getDefinedVariable('CLIENT_USER_AGENT'),
            'CLIENT_PLATFORM' => self::getDefinedVariable('CLIENT_PLATFORM'),
            'CLIENT_BROWSER' => self::getDefinedVariable('CLIENT_BROWSER'),
            'CLIENT_VERSION' => self::getDefinedVariable('CLIENT_VERSION'),
            'TENANT_IDENTIFIER' => self::getDefinedVariable('TENANT_IDENTIFIER'),
            'TENANT_HOME_PAGE' => self::getDefinedVariable('TENANT_HOME_PAGE'),
            'TENANT_PRIMARY_LANGUAGE' => self::getDefinedVariable('TENANT_PRIMARY_LANGUAGE'),
            'TENANT_CURRENT_PAGE' => self::getDefinedVariable('TENANT_CURRENT_PAGE'),
            'TENANT_SELECTED_LANGUAGE' => self::getDefinedVariable('TENANT_SELECTED_LANGUAGE'),
            'TENANT_SELECTED_LANGUAGE_FILE' => self::getDefinedVariable('TENANT_SELECTED_LANGUAGE_FILE'),
            'TENANT_FALLBACK_LANGUAGE_FILE' => self::getDefinedVariable('TENANT_FALLBACK_LANGUAGE_FILE'),
            'TENANT_LANGUAGE_ISO_639' => self::getDefinedVariable('TENANT_LANGUAGE_ISO_639')
        );
    }

    /**
     * Defines critical variables for BlackHawk
     * @return void
     */
    private function defineVariables()
    {
        $UserIP = Utilities::getClientIP();
        if($UserIP === "::1")
        {
            $UserIP = "127.0.0.1";
        }

        define("CLIENT_REMOTE_HOST", $UserIP);
        define("CLIENT_USER_AGENT", Utilities::getUserAgentRaw());

        try
        {
            $UserAgentParsed = Utilities::parse_user_agent(CLIENT_USER_AGENT);
        }
        catch(Exception $exception)
        {
            $UserAgentParsed = array();
        }

        if($UserAgentParsed['platform'])
        {
            define("CLIENT_PLATFORM", $UserAgentParsed['platform']);
        }
        else
        {
            define("CLIENT_PLATFORM", 'Unknown');
        }

        if($UserAgentParsed['browser'])
        {
            define("CLIENT_BROWSER", $UserAgentParsed['browser']);
        }
        else
        {
            define("CLIENT_BROWSER", 'Unknown');
        }

        if($UserAgentParsed['version'])
        {
            define("CLIENT_VERSION", $UserAgentParsed['version']);
        }
        else
        {
            define("CLIENT_VERSION", 'Unknown');
        }

        define("BLACKHAWK_VERSION", $this->getConfig()->get("version"));
        return;
    }

    /**
     * Checks if IPStack is enabled
     *
     * @return bool
     */
    public function isIPStackEnabled() {
        return !is_null($this->_IPStack);
    }
}