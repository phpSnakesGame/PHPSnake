<?php
/**
 * Created by PhpStorm.
 * User: Regina
 * Date: 20.05.2018
 * Time: 19:46
 */

namespace PHPSnake;


class WorkWithServer
{
    public static function getRequestParamsForGettingGameData(Game $game)
    {
        $params = json_decode(new SecondRequestParamForm($game->getSnakeId(), $game->getBattleId()));
        return $params;
    }

    public static function getRequestParamsWithStep(Game $game, string $step)
    {
        $params = json_decode(new RequestParamWithStepForm($game->getSnakeId(), $game->getBattleId(), $step));
        return $params;
    }
}