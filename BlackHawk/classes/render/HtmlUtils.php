<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: HtmlUtils.php
 *
 *
 * Created: 2/1/20, 12:25 PM
 * Last modified: 1/26/20, 6:23 PM
 * Modified by: intellivoid/antiengineer
 *
 * @copyright 2020 (C) Nighthawk Media Group
 * @author Diederik Noordhuis, Zi Xing Narrakas
 *
 * For more information, contact diederikn@intellivoid.info.
 * No modifications allowed. Distribution is prohibited.
 *
 */

namespace BlackHawk\classes\render;


class HtmlUtils
{
    /**
     * Prints HTML output
     *
     * @param string $output
     * @param bool $escape_html
     */
    public static function print(string $output, bool $escape_html = true)
    {
        if($escape_html == true)
        {
            $output = htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
        }

        print($output);
    }
}