<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: RouteHandler.php
 *
 *
 * Created: 2/1/20, 12:25 PM
 * Last modified: 1/31/20, 6:32 PM
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
use BlackHawk\BlackHawk;
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
     * @var BlackHawk
     */
    private $bhMain;

    /**
     * @var string
     */
    protected $tenantPath;
    /**
     * RouteHandler constructor.
     * @param bool $isAPI
     * @param BlackHawk $main
     * @param string $tenantPath
     */
    public function __construct(bool $isAPI, BlackHawk $main, string $tenantPath = "")
    {
        $this->isAPI = $isAPI;
        $this->bhMain = $main;
        $this->tenantPath = $tenantPath;
    }

    public function getRequestStatus() : int
    {
        return $this->status;
    }

    protected function getView(string $view) {
        $view = str_replace("/", DIRECTORY_SEPARATOR, $view);
        return $this->tenantPath.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR.$view;
    }
    /**
     * @param array $Params
     * @param array $IPStackData
     * @return void
     */
    public function processRequest(array $Params, array $IPStackData = []): void
    {
        if($this->isAPI){
            header("Content-Type: application/json");
        }
        $this->status = RequestStatus::Received;
        try {
            $this->status = RequestStatus::Processing;
            if (!$this->onReceive($Params, $IPStackData)) {
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
            if (!$this->onComplete($Params, $IPStackData)) {
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
     * @param array $IPStackData
     * @return bool
     */
    protected function onReceive(array $Params, array $IPStackData): bool
    {
        return false;
    }

    /**
     * Function executed after the request was completed
     *
     * @param array $Params
     * @param array $IPStackData
     * @return bool
     */
    protected function onComplete(array $Params, array $IPStackData): bool
    {
        return false;
    }
}