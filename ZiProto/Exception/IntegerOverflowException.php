<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: IntegerOverflowException.php
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

    use function sprintf;

    /**
     * Class IntegerOverflowException
     * @package ZiProto\Exception
     */
    class IntegerOverflowException extends DecodingFailedException
    {
        /**
         * @var int
         */
        private $value;

        /**
         * IntegerOverflowException constructor.
         * @param int $value
         */
        public function __construct(int $value)
        {
            parent::__construct(sprintf('The value is too big: %u.', $value));
            $this->value = $value;
        }

        /**
         * @return int
         */
        public function getValue() : int
        {
            return $this->value;
        }
    }