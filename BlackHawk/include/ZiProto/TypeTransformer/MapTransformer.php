<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: MapTransformer.php
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

namespace ZiProto\TypeTransformer;

    use ZiProto\Packet;
    use ZiProto\Type\Map;

    /**
     * Class MapTransformer
     * @package ZiProto\TypeTransformer
     */
    abstract class MapTransformer
    {
        /**
         * @param Packet $packer
         * @param $value
         * @return string
         */
        public function encode(Packet $packer, $value): string
        {
            if ($value instanceof Map)
            {
                return $packer->encodeMap($value->map);
            }
            else
            {
                return null;
            }
        }
    }