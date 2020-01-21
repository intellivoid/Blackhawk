<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: Ext.php
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

    /**
     * Class Ext
     * @package ZiProto
     */
    final class Ext
    {
        /**
         * @var int
         */
        public $type;

        /**
         * @var string
         */
        public $data;

        /**
         * Ext constructor.
         * @param int $type
         * @param string $data
         */
        public function __construct(int $type, string $data)
        {
            $this->type = $type;
            $this->data = $data;
        }
    }