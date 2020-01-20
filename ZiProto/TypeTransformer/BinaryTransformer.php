<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: BinaryTransformer.php
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
    use ZiProto\Type\Binary;

    /**
     * Class BinaryTransformer
     * @package ZiProto\TypeTransformer
     */
    abstract class BinaryTransformer
    {
        /**
         * @param Packet $packer
         * @param $value
         * @return string
         */
        public function pack(Packet $packer, $value): string
        {
            if ($value instanceof Binary)
            {
                return $packer->encodeBin($value->data);
            }
            else
            {
                return null;
            }
        }
    }