<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: RequestStatus.php
 *
 *
 * Created: 1/22/20, 5:11 AM
 * Last modified: 1/21/20, 6:41 AM
 * Modified by: intellivoid/antiengineer
 *
 * @copyright 2020 (C) Nighthawk Media Group
 * @author Diederik Noordhuis, Zi Xing Narrakas
 *
 * For more information, contact diederikn@intellivoid.info.
 * No modifications allowed. Distribution is prohibited.
 *
 */

namespace BlackHawk\abstracts;

/**
 * Class RequestStatus
 * @package BlackHawk\abstracts
 */
abstract class RequestStatus
{
    const Aborted = 0;
    const Received = 8;
    const Processing = 2;
    const Processed = 3;
    const Completed = 4;
    const Failed = 5;
}