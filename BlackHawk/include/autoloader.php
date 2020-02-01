<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: autoloader.php
 *
 *
 * Created: 2/1/20, 12:25 PM
 * Last modified: 1/30/20, 8:19 PM
 * Modified by: intellivoid/antiengineer
 *
 * @copyright 2020 (C) Nighthawk Media Group
 * @author Diederik Noordhuis, Zi Xing Narrakas
 *
 * For more information, contact diederikn@intellivoid.info.
 * No modifications allowed. Distribution is prohibited.
 *
 */

include_once(__DIR__.DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php");
function autoload($class) {
    $fullPath = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . str_replace("\\", "/", $class) . ".php";
    if(file_exists(__DIR__.DIRECTORY_SEPARATOR.str_replace("\\", "/", $class) . ".php")) {
        /** @var string  */
        require(__DIR__.DIRECTORY_SEPARATOR.str_replace("\\", "/", $class) . ".php");
    } else {
        if (file_exists($fullPath))
            /** @var string $fullPath */
            require($fullPath);
    }
    if(file_exists(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "tenants" . DIRECTORY_SEPARATOR .str_replace("\\", "/", $class) . ".php")) {
        /** @var string  */
        require(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR .  "tenants" . DIRECTORY_SEPARATOR .str_replace("\\", "/", $class) . ".php");
    }


}

spl_autoload_register("autoload");
