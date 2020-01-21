<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: InsufficientDataException.php
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

namespace ZiProto\Exception;

    use function strlen;

    /**
     * Class InsufficientDataException
     * @package ZiProto\Exception
     */
    class InsufficientDataException extends DecodingFailedException
    {
        /**
         * @param string $buffer
         * @param int $offset
         * @param int $expectedLength
         * @return InsufficientDataException
         */
        public static function unexpectedLength(string $buffer, int $offset, int $expectedLength) : self
        {
            $actualLength = strlen($buffer) - $offset;
            $message = "Not enough data to unpack: expected $expectedLength, got $actualLength.";
            return new self($message);
        }
    }