<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: DecodingFailedException.php
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

namespace ZiProto\Exception;

    use RuntimeException;
    use function sprintf;

    /**
     * Class DecodingFailedException
     * @package ZiProto\Exception
     */
    class DecodingFailedException extends RuntimeException
    {
        /**
         * @param int $code
         * @return DecodingFailedException
         */
        public static function unknownCode(int $code) : self
        {
            return new self(sprintf('Unknown code: 0x%x.', $code));
        }

        /**
         * @param int $code
         * @param string $type
         * @return DecodingFailedException
         */
        public static function unexpectedCode(int $code, string $type) : self
        {
            return new self(sprintf('Unexpected %s code: 0x%x.', $type, $code));
        }
    }