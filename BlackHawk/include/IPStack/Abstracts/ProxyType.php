<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: ProxyType.php
 *
 *
 * Created: 1/21/20, 3:42 AM
 * Last modified: 1/20/20, 1:04 PM
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
     * Class ProxyType
     * @package IPStack\Abstracts
     */
    abstract class ProxyType
    {
        /**
         * CGI Proxy
         */
        const CGI = 'cgi';

        /**
         * Web Proxy
         */
        const Web = 'web';

        /**
         * VPN Proxy
         */
        const VPN = 'vpn';
    }