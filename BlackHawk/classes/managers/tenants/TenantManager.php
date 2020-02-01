<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: TenantManager.php
 *
 *
 * Created: 2/1/20, 12:25 PM
 * Last modified: 1/30/20, 9:00 PM
 * Modified by: intellivoid/antiengineer
 *
 * @copyright 2020 (C) Nighthawk Media Group
 * @author Diederik Noordhuis, Zi Xing Narrakas
 *
 * For more information, contact diederikn@intellivoid.info.
 * No modifications allowed. Distribution is prohibited.
 *
 */

namespace BlackHawk\classes\managers\tenants;


use BlackHawk\BlackHawk;
use BlackHawk\exceptions\tenants\provisioning\TenantFolderNotFoundException;
use BlackHawk\exceptions\tenants\reflect\TenantClassNotFoundException;

/**
 * Class TenantManager
 * @package BlackHawk\classes\managers\tenants
 */
class TenantManager
{
    /**
     * @var BlackHawk
     */
    private $bhMain;

    /**
     * TenantManager constructor.
     * @param BlackHawk $main
     */
    public function __construct(BlackHawk $main)
    {
        $this->bhMain = $main;
        $this->searchForTenants();
    }

    /**
     * Searches for tenants, and provisions them respectively
     *
     * @return void
     */
    protected function searchForTenants(){
        $possibleTenants = [];
        $folderPath = $this->bhMain->getConfig()->get("render")["tenantFolder"];
        $folderPath = str_replace("{MAIN_DIR}", $this->bhMain->mainDir, $folderPath);
        if(!is_dir($folderPath)) {
            throw new TenantFolderNotFoundException("The tenant folder '$folderPath' could not be located, read, or queried. Make sure correct permissions are set.");
        }
        $tenantFolder = array_diff(scandir($folderPath), array(".",".."));
        foreach ($tenantFolder as $ptenant) {
            if(is_dir($folderPath.DIRECTORY_SEPARATOR.$ptenant)) {
                if(file_exists($folderPath.DIRECTORY_SEPARATOR.$ptenant.DIRECTORY_SEPARATOR."tenant.json")) {
                    $TC = file_get_contents($folderPath.DIRECTORY_SEPARATOR.$ptenant.DIRECTORY_SEPARATOR."tenant.json");
                    $TCfg = json_decode($TC, true);

                        if (is_null($TCfg)) {
                            echo "parsefail";
                            // TODO: Debug log parse failure
                        } else {
                            if(!isset($possibleTenants[$TCfg["info"]["hostname"]])) {
                                if(file_exists($folderPath . DIRECTORY_SEPARATOR . $ptenant . DIRECTORY_SEPARATOR . $TCfg["mainClass"] . ".php") && is_readable($folderPath . DIRECTORY_SEPARATOR . $ptenant . DIRECTORY_SEPARATOR . $TCfg["mainClass"] . ".php")) {
                                    $state = include_once($folderPath . DIRECTORY_SEPARATOR . $ptenant . DIRECTORY_SEPARATOR . $TCfg["mainClass"] . ".php");
                                    if (!$state) {
                                        echo "inc err";
                                        // TODO: Debug log include error
                                    } else {
                                        $tenantObj = new $TCfg["mainClass"]($this->bhMain, $folderPath.DIRECTORY_SEPARATOR.$ptenant);
                                        $possibleTenants[$TCfg["info"]["hostname"]] = $tenantObj;
                                        $this->bhMain->getSecureStorage()->addTenant($tenantObj);
                                    }
                                } else {
                                    if($_SERVER["HTTP_HOST"] == $TCfg["info"]["hostname"]) {
                                        throw new TenantClassNotFoundException("The main class for this tenant could not be found. Please check the path and try again later.");
                                    }
                                    // TODO: Debug log mainclass reflect not found
                                }
                            } else {
                                echo "t exs";
                                // TODO: Debug log tenant exists already
                            }
                        }

                } else {
                    echo "f d e".$folderPath.DIRECTORY_SEPARATOR.$ptenant.DIRECTORY_SEPARATOR."tenant.json";
                    // TODO: Debug log
                }
            }
        }
    }
}