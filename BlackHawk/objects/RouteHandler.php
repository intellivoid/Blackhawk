<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: RouteHandler.php
 *
 *
 * Created: 1/22/20, 5:26 AM
 * Last modified: 1/21/20, 7:01 AM
 * Modified by: intellivoid/antiengineer
 *
 * @copyright 2020 (C) Nighthawk Media Group
 * @author Diederik Noordhuis, Zi Xing Narrakas
 *
 * For more information, contact diederikn@intellivoid.info.
 * No modifications allowed. Distribution is prohibited.
 *
 */

namespace BlackHawk\objects;


use BlackHawk\abstracts\RequestStatus;
use BlackHawk\exceptions\runtime\RequestException;
use BlackHawk\exceptions\runtime\ServerErrorException;
use BlackHawk\interfaces\IRouteHandler;
use Exception;

/**
 * Class RouteHandler
 * @package BlackHawk\objects
 */
class RouteHandler implements IRouteHandler
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
     * RouteHandler constructor.
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