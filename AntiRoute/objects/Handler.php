<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: Handler.php
 *
 *
 * Created: 1/20/20, 1:03 PM
 * Last modified: 12/29/19, 4:46 PM
 * Modified by: intellivoid/antiengineer
 *
 * @copyright 2020 (C) Nighthawk Media Group
 * @author Diederik Noordhuis, Zi Xing Narrakas
 *
 * For more information, contact diederikn@intellivoid.info.
 * No modifications allowed. Distribution is prohibited.
 *
 */

/**
 * AntiRoute Handler Object
 *
 * @author Diederik Noordhuis
 * (C) 2019 AntiEngineer
 */

namespace AntiRoute\objects;


use AntiRoute\abstracts\RequestStatus;
use AntiRoute\exception\RequestException;
use AntiRoute\exception\ServerErrorException;
use AntiRoute\interfaces\IHandler;
use Exception;

/**
 * Class Handler
 * @package AntiRoute\objects
 */
class Handler implements IHandler
{
    /**
     * @var int
     */
    private $status;

    /**
     * @var Exception
     */
    public $error;

    /**
     * @var bool
     */
    private $isAPI;


    /**
     * Handler constructor.
     * @param bool $isAPI
     */
    public function __construct(bool $isAPI)
    {
        $this->isAPI = $isAPI;
    }

    public function getRequestStatus() : int
    {
        return $this->status;
    }
    /**
     * @param array $Params
     * @return void
     * @throws ServerErrorException
     */
    public function processRequest(array $Params): void
    {
        if($this->isAPI){
            header("Content-Type: application/json");
        }
        $this->status = RequestStatus::Received;
        try {
            $this->status = RequestStatus::Processing;
            if (!$this->onReceive($Params)) {
                $this->status = RequestStatus::Failed;
                return;
            }
            $this->status = RequestStatus::Processed;
        } catch (RequestException $e) {
            $this->status = RequestStatus::Aborted;
            $this->error = $e;
            return;
        } catch (Exception $e) {
            $this->status = RequestStatus::Aborted;
            $this->error = $e;
            return;
        }

        try {
            if (!$this->onComplete($Params)) {
                $this->status = RequestStatus::Failed;
                return;
            }
            $this->status = RequestStatus::Completed;
        } catch (RequestException $e) {
            $this->status = RequestStatus::Aborted;
            $this->error = $e;
            return;
        } catch (Exception $e) {
            $this->status = RequestStatus::Aborted;
            $this->error = $e;
            return;
        }
    }

    /**
     * Function executed after the request is received
     *
     * @param array $Params
     * @return bool
     * @throws Exception
     */
    protected function onReceive(array $Params): bool
    {
        return false;
    }

    /**
     * Function executed after the request was completed
     *
     * @param array $Params
     * @return bool
     * @throws Exception
     */
    protected function onComplete(array $Params): bool
    {
        return false;
    }
}