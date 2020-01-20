<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: ThreatLevel.php
 *
 *
 * Created: 1/20/20, 1:04 PM
 * Last modified: 1/18/20, 2:41 PM
 * Modified by: intellivoid/antiengineer
 *
 * @copyright 2020 (C) Nighthawk Media Group
 * @author Diederik Noordhuis, Zi Xing Narrakas
 *
 * For more information, contact diederikn@intellivoid.info.
 * No modifications allowed. Distribution is prohibited.
 *
 */

namespace IPStack\Abstracts;

    /**
     * Class ThreatLevel
     * @package IPStack\Abstracts
     */
    abstract class ThreatLevel
    {
        /**
         * Low Risk
         */
        const Low = 'low';

        /**
         * Medium Risk
         */
        const Medium = 'medium';

        /**
         * High Risk
         */
        const High = 'high';

        const Unknown = 'unknown';
    }