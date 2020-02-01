<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: index.php
 *
 *
 * Created: 2/1/20, 12:25 PM
 * Last modified: 1/31/20, 3:56 PM
 * Modified by: intellivoid/antiengineer
 *
 * @copyright 2020 (C) Nighthawk Media Group
 * @author Diederik Noordhuis, Zi Xing Narrakas
 *
 * For more information, contact diederikn@intellivoid.info.
 * No modifications allowed. Distribution is prohibited.
 *
 */
ini_set("expose_php", "Off");

include __DIR__.DIRECTORY_SEPARATOR."BlackHawk".DIRECTORY_SEPARATOR."include".DIRECTORY_SEPARATOR."autoloader.php";
use BlackHawk\BlackHawk;
ini_set('xdebug.var_display_max_depth', '4');
ini_set('xdebug.var_display_max_children', '256');
ini_set('xdebug.var_display_max_data', '512');
$bh = new BlackHawk();
$bh->init();