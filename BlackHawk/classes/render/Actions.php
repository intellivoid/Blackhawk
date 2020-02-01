<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: Actions.php
 *
 *
 * Created: 2/1/20, 12:25 PM
 * Last modified: 1/25/20, 12:52 AM
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


class Actions
{
    /**
     * Redirects the client to another location, this only
     * works if the server hasn't sent any data back yet
     *
     * Using this function will terminate the process
     *
     * @param string $location
     */
    public static function redirect(string $location)
    {
        header("Location: $location");
        exit();
    }

    /**
     * Same as redirect but with a delay, this function will
     * terminate the process
     *
     * @param string $location
     * @param int $time
     */
    public static function delayed_redirect(string $location, int $time)
    {
        header('Refresh: ' . $time . ' URL=' . $location);
        exit();
    }
}