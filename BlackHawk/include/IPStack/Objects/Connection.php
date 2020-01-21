<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: Connection.php
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

namespace IPStack\Objects;

    /**
     * Class Connection
     * @package IPStack\Objects
     */
    class Connection
    {
        /**
         * 	Returns the Autonomous System Number associated with the IP.
         *
         * @var string
         */
        public $ASN;

        /**
         * 	Returns the name of the ISP associated with the IP.
         *
         * @var string
         */
        public $ISP;

        /**
         * Creates array from object
         *
         * @return array
         */
        public function toArray(): array
        {
            return array(
                'asn' => $this->ASN,
                'isp' => $this->ISP
            );
        }

        /**
         * Creates object from array
         *
         * @param array $data
         * @return Connection
         */
        public static function fromArray(array $data): Connection
        {
            $ConnectionObject = new Connection();

            if(isset($data['asn']))
            {
                $ConnectionObject->ASN = $data['asn'];
            }

            if(isset($data['isp']))
            {
                $ConnectionObject->ISP = $data['isp'];
            }

            return $ConnectionObject;
        }
    }