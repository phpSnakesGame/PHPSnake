<?php
/**
 * Created by PhpStorm.
 * User: Regina
 * Date: 21.05.2018
 * Time: 4:50
 */

namespace PHPSnake;

use PHPSnake\ClassForGetParams;

    spl_autoload_register(function ($class_name) {
        include "$class_name.php";
    });

    $game = new Game();
    ClassForGetParams::getRequestIdForGame($game);

    //2 - 3 запросы

    $ok = true;
    while ($ok) {
        $response_array = json_decode(ClassForGetParams::getRequestParamsForGettingGameData($game)["params"]);
        print_r($response_array);
        while ($response_array['info'] == 202) {
            $response_array = json_decode(ClassForGetParams::getRequestParamsForGettingGameData($game)["params"]);
        }
        print_r($response_array);
        $game->setEnemyHead($response_array->snakes->enemy->head);
        $game->setEnemyBody($response_array->snakes->enemy->body);
        $game->setEnemyTail($response_array->snakes->enemy->tail);
        $game->setEnemyIsBited($response_array->snakes->enemy->is_bited);

        $game->setBody($response_array->snakes->ally->body);
        $game->setHead($response_array->snakes->ally->head);
        $game->setTail($response_array->snakes->ally->tail);
        $game->setIsBited($response_array->snakes->ally->is_bited);

        $snake = $game->initSnake();
        $game->moveSnake($snake);

        //4 запрос

        $second_response_array = ClassForGetParams::getRequestParamsWithStep($game);
        print_r($second_response_array);
        if ($second_response_array['info'] == 200) {
            $ok = true;
        }
        else {
            $ok = false;
        }
    }

