<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: CrawlerType.php
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
     * Class CrawlerType
     * @package IPStack\Abstracts
     */
    abstract class CrawlerType
    {
        /**
         * Unrecognized
         */
        const Unrecognized = 'unrecognized';

        /**
         * Search Engine Bot
         */
        const SearchEngineBot = 'search_engine_bot';

        /**
         * Site Monitor
         */
        const SiteMonitor = 'site_monitor';

        /**
         * Screenshot Creator
         */
        const ScreenshotCreator = 'screenshot_creator';

        /**
         * Link Checker
         */
        const LinkChecker = 'link_checker';

        /**
         * Wearable Computer
         */
        const WearableComputer = 'wearable_computer';

        /**
         * Web Scraper
         */
        const WebScraper = 'web_scraper';

        /**
         * Vulnerability Scanner
         */
        const VulnerabilityScanner = 'vulnerability_scanner';

        /**
         * Virus Scanner
         */
        const VirusScanner = 'virus_scanner';

        /**
         * Speed Tester
         */
        const SpeedTester = 'speed_tester';

        /**
         * Tool
         */
        const Tool = 'tool';

        /**
         * Marketing
         */
        const Marketing = 'marketeing';
    }