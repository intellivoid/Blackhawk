<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: EncodingFailedException.php
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

    use function get_class;
    use function gettype;
    use function is_object;
    use RuntimeException;
    use function sprintf;
    use Throwable;

    /**
     * Class EncodingFailedException
     * @package ZiProto\Exception
     */
    class EncodingFailedException extends RuntimeException
    {
        /**
         * @var mixed
         */
        private $value;

        /**
         * EncodingFailedException constructor.
         * @param $value
         * @param string $message
         * @param Throwable|null $previous
         */
        public function __construct($value, string $message = '', Throwable $previous = null)
        {
            parent::__construct($message, 0, $previous);
            $this->value = $value;
        }

        /**
         * @return mixed
         */
        public function getValue()
        {
            return $this->value;
        }

        /**
         * @param $value
         * @return EncodingFailedException
         */
        public static function unsupportedType($value) : self
        {
            $message = sprintf('Unsupported type: %s.',
                is_object($value) ? get_class($value) : gettype($value)
            );
            return new self($value, $message);
        }
    }