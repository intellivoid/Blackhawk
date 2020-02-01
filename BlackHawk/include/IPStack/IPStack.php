<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: IPStack.php
 *
 *
 * Created: 2/1/20, 12:25 PM
 * Last modified: 1/24/20, 6:45 PM
 * Modified by: intellivoid/antiengineer
 *
 * @copyright 2020 (C) Nighthawk Media Group
 * @author Diederik Noordhuis, Zi Xing Narrakas
 *
 * For more information, contact diederikn@intellivoid.info.
 * No modifications allowed. Distribution is prohibited.
 *
 */

namespace IPStack;

    use IPStack\Exceptions\LookupException;
    use IPStack\Objects\IPAddress;


    /**
     * Class IPStack
     * @package IPStack
     */
    class IPStack
    {
        /**
         * @var string
         */
        private $AccessKey;

        /**
         * @var string
         */
        private $Host;

        /**
         * @var bool
         */
        private $UseSSL;

        /**
         * IPStack constructor.
         * @param string $access_key
         * @param bool $ssl
         * @param string $host
         */
        public function __construct(string $access_key, bool $ssl = false, string $host = "api.ipstack.com")
        {
            $this->Host = $host;
            $this->UseSSL = $ssl;
            $this->AccessKey = $access_key;
        }

        /**
         * Performs a lookup
         *
         * @param string $ip_address
         * @return IPAddress
         * @throws LookupException
         */
        public function lookup(string $ip_address): IPAddress
        {
            $Protocol = 'http';
            if($this->UseSSL == true)
            {
                $Protocol = 'https';
            }
            $ch = curl_init($Protocol . '://' . $this->Host . '/'. $ip_address . '?access_key='. $this->AccessKey);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $Results = json_decode(curl_exec($ch), true);
            curl_close($ch);

            if(isset($Results['success']))
            {
                if($Results['success'] == false)
                {
                    throw new LookupException($Results['error']['info'], (int)$Results['error']['code']);
                }
            }

           return IPAddress::fromArray($Results);
        }
    }