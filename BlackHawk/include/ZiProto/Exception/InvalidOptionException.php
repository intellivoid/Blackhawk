<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: InvalidOptionException.php
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

    use function array_pop;
    use function count;
    use function implode;
    use InvalidArgumentException;
    use function sprintf;

    /**
     * Class InvalidOptionException
     * @package ZiProto\Exception
     */
    class InvalidOptionException extends InvalidArgumentException
    {
        /**
         * @param string $invalidOption
         * @param array $validOptions
         * @return InvalidOptionException
         */
        public static function outOfRange(string $invalidOption, array $validOptions) : self
        {
            $use = count($validOptions) > 2
                ? sprintf('one of %2$s or %1$s', array_pop($validOptions), implode(', ', $validOptions))
                : implode(' or ', $validOptions);
            return new self("Invalid option $invalidOption, use $use.");
        }
    }