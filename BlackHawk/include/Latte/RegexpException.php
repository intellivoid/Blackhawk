<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: RegexpException.php
 *
 *
 * Created: 2/1/20, 12:25 PM
 * Last modified: 1/31/20, 6:40 PM
 * Modified by: intellivoid/antiengineer
 *
 * @copyright 2020 (C) Nighthawk Media Group
 * @author Diederik Noordhuis, Zi Xing Narrakas
 *
 * For more information, contact diederikn@intellivoid.info.
 * No modifications allowed. Distribution is prohibited.
 *
 */

namespace Latte;


class RegexpException extends \Exception
{
    public const MESSAGES = [
        PREG_INTERNAL_ERROR => 'Internal error',
        PREG_BACKTRACK_LIMIT_ERROR => 'Backtrack limit was exhausted',
        PREG_RECURSION_LIMIT_ERROR => 'Recursion limit was exhausted',
        PREG_BAD_UTF8_ERROR => 'Malformed UTF-8 data',
        PREG_BAD_UTF8_OFFSET_ERROR => 'Offset didn\'t correspond to the begin of a valid UTF-8 code point',
        6 => 'Failed due to limited JIT stack space', // PREG_JIT_STACKLIMIT_ERROR
    ];


    public function __construct($message, $code = null)
    {
        parent::__construct($message ?: (self::MESSAGES[$code] ?? 'Unknown error'), $code);
    }
}