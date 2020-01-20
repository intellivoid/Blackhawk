<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: Options.php
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

namespace ZiProto\Abstracts;

    /**
     * Class Options
     * @package ZiProto\Abstracts
     */
    abstract class Options
    {
        const BIGINT_AS_STR = 0b001;
        const BIGINT_AS_GMP = 0b010;
        const BIGINT_AS_EXCEPTION = 0b100;
        const FORCE_STR = 0b00000001;
        const FORCE_BIN = 0b00000010;
        const DETECT_STR_BIN = 0b00000100;
        const FORCE_ARR = 0b00001000;
        const FORCE_MAP = 0b00010000;
        const DETECT_ARR_MAP = 0b00100000;
        const FORCE_FLOAT32 = 0b01000000;
        const FORCE_FLOAT64 = 0b10000000;
    }