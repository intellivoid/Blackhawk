<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: ThreatType.php
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
     * Class ThreatType
     * @package IPStack\Abstracts
     */
    abstract class ThreatType
    {
        /**
         * Tor System
         */
        const Tor = 'tor';

        /**
         * Fake Crawler
         */
        const FakeCrawler = 'fake_crawler';

        /**
         * Web Scraper
         */
        const WebScraper = 'web_scraper';

        /**
         * Attack Source identified: HTTP
         */
        const AttackSource = 'attack_source';

        /**
         * Attack Source identified: HTTP
         */
        const AttackSourceHTTP = 'attack_source_http';

        /**
         * Attack Source identified: Mail
         */
        const AttackSourceMail = 'attack_source_mail';

        /**
         * Attack Source identified: SSH
         */
        const AttackSourceSSH = 'attack_source_ssh';
    }