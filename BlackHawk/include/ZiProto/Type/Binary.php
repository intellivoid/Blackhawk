<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: Binary.php
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

namespace ZiProto\Type;

    /**
     * Class Binary
     * @package ZiProto\Type
     */
    final class Binary
    {
        /**
         * @var string
         */
        public $data;

        /**
         * Binary constructor.
         * @param string $data
         */
        public function __construct(string $data)
        {
            $this->data = $data;
        }
    }