<?php
/**
 * Created by PhpStorm.
 * User: Regina
 * Date: 20.05.2018
 * Time: 22:58
 */

namespace PHPSnake;


class RequestWithId
{
    /**
     * RequestWithId constructor.
     * @param int $getSnakeId
     * @param int $getBattleId
     */

    private $snake_id;
    private $battle_id;

    public function __construct($snakeId, $battleId)
    {
        $this->battle_id = $battleId;
        $this->snake_id = $snakeId;
    }

    public function createRequestJson(){
        $request = array(
            "answer" => 42
        );
        $request_string = json_encode($request);
        return $request_string;
    }

    public function createJsonWithId(){
        $json = array("snake_id" => $this->getSnakeId(), "battle_id" => $this->getBattleId());
        $json_string = json_encode($json);
        return $json_string;
    }

    public function requestServer(){
        $ch = curl_init('http://localhost:****/');
        while (true){
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->createRequestJson());
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($this->createRequestJson()))
            );
            $result = curl_exec($ch);
        }
        curl_close($ch);
        return $result;
    }

    /**
     * @return mixed
     */
    public function getSnakeId()
    {
        return $this->snake_id;
    }

    /**
     * @param mixed $snake_id
     */
    public function setSnakeId($snake_id): void
    {
        $this->snake_id = $snake_id;
    }

    /**
     * @return mixed
     */
    public function getBattleId()
    {
        return $this->battle_id;
    }

    /**
     * @param mixed $battle_id
     */
    public function setBattleId($battle_id): void
    {
        $this->battle_id = $battle_id;
    }
}