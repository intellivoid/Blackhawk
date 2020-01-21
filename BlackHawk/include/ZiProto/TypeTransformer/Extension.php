<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: Extension.php
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

namespace ZiProto\TypeTransformer;

    use ZiProto\BufferStream;

    /**
     * Interface Extension
     * @package ZiProto\TypeTransformer
     */
    interface Extension
    {
        /**
         * @return int
         */
        public function getType() : int;

        /**
         * @param BufferStream $stream
         * @param int $extLength
         * @return mixed
         */
        public function decode(BufferStream $stream, int $extLength);
    }