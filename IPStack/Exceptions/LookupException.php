<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: LookupException.php
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

namespace IPStack\Exceptions;

    use Exception;

    /**
     * Class LookupException
     * @package IPStack\Exceptions
     */
    class LookupException extends Exception
    {
        /**
         * LookupException constructor.
         * @param $message
         * @param $code
         */
        public function __construct($message, $code)
        {
            parent::__construct($message, $code, null);
        }
    }