<?php
/**
 * Created by PhpStorm.
 * User: Regina
 * Date: 20.05.2018
 * Time: 19:46
 */

namespace PHPSnake;


class ClassForGetParams
{

    public static function getRequestIdForGame(Game $game){
        $requestByAnswer = new RequestAnswer();
        $params = json_encode(array("answer" => 42));
        $result_json = json_decode($requestByAnswer->requestServer($params));
        $game->setBattleId($result_json['battle_id']);
        $game->setSnakeId($result_json['snake_id']);
    }


    public static function getRequestParamsForGettingGameData(Game $game)
    {
        $req = new RequestWithId($game->getSnakeId(), $game->getBattleId());
        $params = json_encode(['snake_id' => $game->getSnakeId(), 'battle_id' => $game->getBattleId()]);
        $req -> requestServer($params);
        $result_params = json_decode($req);
        $info = $req -> getInfo();
        return array("params" => $result_params, "info" => $info);
    }

    public static function getRequestParamsWithStep(Game $game)
    {
        $req = new RequestWithStep($game->getSnakeId(), $game->getBattleId(), $game->getStep());
        $params = json_encode(['snake_id' => $game->getSnakeId(), 'battle_id' => $game->getBattleId(), 'step'=>$game->getStep()]);
        $req -> requestServerWithStep($params);
        $result_params = json_decode($req);
        $info = $req -> getInfo();
        return array("params" => $result_params, "info" => $info);
    }
}
