<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: Configuration.php
 *
 *
 * Created: 1/21/20, 3:42 AM
 * Last modified: 1/21/20, 2:22 AM
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

use BlackHawk\exceptions\configuration\ConfigParameterNotExistentException;
use BlackHawk\exceptions\configuration\ConfigParseException;
use BlackHawk\exceptions\configuration\ConfigReadException;

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

    /**
     * Raw configuration (JSON-array)
     *
     * @var array
     */
    private $configuration;

    /**
     * Loads/creates configuration if it does not exist
     *
     * @return void
     * @throws ConfigReadException|ConfigParseException
     */
    private function loadConfig() : void
    {
        if(!file_exists($this->configurationPath)) {
            file_put_contents($this->configurationPath, base64_decode("ewogICJ2ZXJzaW9uIjogInYxLjAuMCIsCiAgImRlYnVnIjogewogICAgImVycm9yX3JlcG9ydGluZyI6IGZhbHNlLAogICAgImxvZ2dpbmciOiB0cnVlLAogICAgInNlbnRyeSI6IHsKICAgICAgImVuYWJsZWQiOiBmYWxzZSwKICAgICAgImtleSI6ICIiCiAgICB9CiAgfSwKICAicHJvdmlkZXJzIjogewogICAgIklQU3RhY2siOiB7CiAgICAgICJrZXkiOiAiIgogICAgfQogIH0sCiAgInJlbmRlciIgOiB7CiAgICAiZGVmYXVsdFRlbmFudCI6ICJibGFja2hhd2subG9jYWwiCiAgfSwKICAic2VjdXJpdHkiOiB7CiAgICAiZW5jcnlwdGlvbktleSI6ICIiLAogICAgInNhbHRzIjogewogICAgICAiZGVmYXVsdCI6IHRydWUsCiAgICAgICJWWDEiOiAiQXhCZTIxI0YpMSY4MzRtYk5DOTJ+IiwKICAgICAgIlZYMiI6ICJaZWhBbjEtdk1TQTJuKysiLAogICAgICAiVlgxKlgyIjogInhOYmwyMD8/PjJtZ0AiCiAgICB9CiAgfQp9"));
        }
        $cnt = file_get_contents($this->configurationPath);
        if(!$cnt) {
            throw new ConfigReadException("The configuration file '$this->configurationPath' could not be read.");
        }
        $cntp = json_decode($cnt, true);
        if(is_null($cntp)) {
            throw new ConfigParseException("The configuration file '$this->configurationPath' is malformed and could not be parsed.");
        }
        $this->configuration = $cntp;
        return;
    }

    /**
     * Configuration constructor.
     */
    public function  __construct()
    {
        $this->loadConfig();
    }

    /**
     * Get configuration parameter
     *
     * @param string $section
     * @return mixed
     * @throws ConfigParameterNotExistentException
     */
    public function getConfig(string $section) {
        if(isset($this->configuration[$section])) {
            return $this->configuration[$section];
        } else {
            throw new ConfigParameterNotExistentException("The parameter specified does not exist");
        }
    }
}