<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: ServerException.php
 *
 *
 * Created: 2/1/20, 12:25 PM
 * Last modified: 1/31/20, 4:24 PM
 * Modified by: intellivoid/antiengineer
 *
 * @copyright 2020 (C) Nighthawk Media Group
 * @author Diederik Noordhuis, Zi Xing Narrakas
 *
 * For more information, contact diederikn@intellivoid.info.
 * No modifications allowed. Distribution is prohibited.
 *
 */

namespace BlackHawk\defaults\handlers;

use BlackHawk\BlackHawk;
use BlackHawk\classes\render\WebRender;
use BlackHawk\classes\Utilities;
use BlackHawk\objects\RouteHandler;
use DynamicalWeb\DynamicalWeb;
use DynamicalWeb\Page;

class ServerException extends RouteHandler
{
    private $bhMain;

    /**
     * TenantNotFound constructor.
     * @param BlackHawk $main
     */
    public function __construct(BlackHawk $main)
    {
        $this->bhMain = $main;
        parent::__construct(false, $main);
    }

    public function onReceive(array $Params, array $IPStackData = []): bool
    {
        $Replacer = [
            "DNS_HOST" => $_SERVER["HTTP_HOST"],
            "CLIENT_IP" => Utilities::getClientIP(),
            "OS" => php_uname("s"),
            "BUILD_DATE" => date(DATE_RFC3339_EXTENDED, microtime(true)),
            "CYEAR" => date('Y'),
            "DEVFINGER" => Utilities::createDeviceFingerprint(),
            "CORRELATION" => Utilities::createUUID(),
            "ERR_CODE" => "500",
            "EXCEPTION_OBJ" => print_r($Params["exception"], true),
            "VARS" => print_r(BlackHawk::getDefinedVariables(), true)
        ];

        foreach ($Replacer as $tag => $value) {
            if(!defined("BLACKHAWK_$tag"))
                define("BLACKHAWK_$tag", $value);
        }
        return true;
    }

    public function onComplete(array $Params, array $IPStackData): bool
    {
        if($this->bhMain->getConfig()->get("debug")["dev"]) {

            $Body = $Params["exception"]->getMessage()."<br/>More information about this exception is available below:<br>\n";

            $Body .= "<h3>Exception Details</h3>\n";
            $Body .= "<pre>";
            $Body .= print_r($Params["exception"], true);
            $Body .= "</pre>\n";
            $Body .= "<h3>Secure Object Memory</h3>\n";
            $Body .= "<pre>";
            $Body .= print_r($this->bhMain->getSecureStorage()->_globalObjects, true);
            $Body .= "</pre>\n";

            $Body .= "<h3>Secure Tenant Memory</h3>\n";
            $Body .= "<pre>";
            $Body .= "SecurityTenants Object (\n";
            foreach($this->bhMain->getSecureStorage()->_tenants as $name=>$val) {
                $Body .= "  [Tenant:protected] => \"$name\"\n";
            }
            $Body .= ")</pre>\n";

                $Body .= "<h3>Blackhawk Details</h3>\n";
                $Body .= "<pre>";
                $Body .= print_r(BlackHawk::getDefinedVariables(), true);
                $Body .= "</pre>";

                $Body = str_ireplace('.php', '.go', $Body);
                $Body = str_ireplace('.json', '.ziproto', $Body);
            WebRender::staticResponse(
                "[DEBUG] Internal Server Error",
                BLACKHAWK_ERR_CODE,
                "Server Error",
                $Body,
                true
            );
        } else {
            WebRender::staticResponse(
                "Internal Server Error",
                BLACKHAWK_ERR_CODE,
                "Server Error",
                "An uncontrolled fatal exception has occurred in the application.<br>Please try again later, or contact the website administrator if the error persists.",
                true
            );
        }


        die();
        return true;
    }
}