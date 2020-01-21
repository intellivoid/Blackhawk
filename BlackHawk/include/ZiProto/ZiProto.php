<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: ZiProto.php
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

namespace ZiProto;

    use ZiProto\Exception\DecodingFailedException;
    use ZiProto\Exception\EncodingFailedException;
    use ZiProto\Exception\InvalidOptionException;

    /**
     * ZiProto Class
     *
     * Class ZiProto
     * @package ZiProto
     */
    class ZiProto
    {
        /**
         * @param mixed $value
         * @param EncodingOptions|int|null $options
         *
         * @throws InvalidOptionException
         * @throws EncodingFailedException
         *
         * @return string
         */
        public static function encode($value, $options = null) : string
        {
            return (new Packet($options))->encode($value);
        }

        /**
         * @param string $data
         * @param DecodingOptions|int|null $options
         *
         * @throws InvalidOptionException
         * @throws DecodingFailedException
         *
         * @return mixed
         */
        public static function decode(string $data, $options = null)
        {
            return (new BufferStream($data, $options))->decode();
        }
    }