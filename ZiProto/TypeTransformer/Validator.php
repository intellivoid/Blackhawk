<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: Validator.php
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

namespace ZiProto\TypeTransformer;

    use ZiProto\Packet;

    /**
     * Interface Validator
     * @package ZiProto\TypeTransformer
     */
    interface Validator
    {
        /**
         * @param Packet $packer
         * @param $value
         * @return string
         */
        public function check(Packet $packer, $value) :string;
    }