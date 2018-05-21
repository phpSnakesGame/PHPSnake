<?php
/**
 * Created by PhpStorm.
 * User: Regina
 * Date: 20.05.2018
 * Time: 22:59
 */

namespace PHPSnake;


class RequestWithStep
{

    /**
     * RequestWithStep constructor.
     * @param int $getSnakeId
     * @param int $getBattleId
     * @param string $step
     */

    private $snakeID;
    private $battleId;
    private $step;

    public function __construct($snakeId, $battleId, $step)
    {
        $this->battleId = $battleId;
        $this->snakeID = $snakeId;
        $this->step = $step;
    }


    public function createJsonWithStep(){
        $json = array("snake_id" => $this->getSnakeID(), "battle_id" => $this->getBattleId(), "step" => $this->getStep());
        $json_string = json_encode($json);
        return $json_string;
    }

    public function requestServerWithStep(){
        $ch = curl_init('http://localhost:****/');
        while (true){
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->createJsonWithStep());
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($this->createJsonWithStep()))
            );
            $result = curl_exec($ch);
        }
        curl_close($ch);
        return $result;
    }

    /**
     * @return mixed
     */
    public function getSnakeID()
    {
        return $this->snakeID;
    }

    /**
     * @param mixed $snakeID
     */
    public function setSnakeID($snakeID): void
    {
        $this->snakeID = $snakeID;
    }

    /**
     * @return mixed
     */
    public function getBattleId()
    {
        return $this->battleId;
    }

    /**
     * @param mixed $battleId
     */
    public function setBattleId($battleId): void
    {
        $this->battleId = $battleId;
    }

    /**
     * @return mixed
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * @param mixed $step
     */
    public function setStep($step): void
    {
        $this->step = $step;
    }


}