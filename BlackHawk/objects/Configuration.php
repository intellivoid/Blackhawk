<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: Configuration.php
 *
 *
 * Created: 1/20/20, 1:04 PM
 * Last modified: 1/20/20, 12:40 PM
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

/**
 * Class Configuration
 * @package BlackHawk\objects
 */
class Configuration
{
    /**
     * Path containing the configuration file
     *
     * @var string
     */
    private $configurationPath = __dir__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."BlackHawk.json";

    private function loadConfig() {
        if(!file_exists($this->configurationPath)) {
            file_put_contents($this->configurationPath, )
        }
    }

    /**
     * Configuration constructor.
     */
    public function  __construct()
    {
        $this->loadConfig();
    }
}