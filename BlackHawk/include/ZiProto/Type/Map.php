<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: Map.php
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
     * Class Map
     * @package ZiProto\Type
     */
    final class Map
    {
        /**
         * @var array
         */
        public $map;

        /**
         * Map constructor.
         * @param array $map
         */
        public function __construct(array $map)
        {
            $this->map = $map;
        }
    }