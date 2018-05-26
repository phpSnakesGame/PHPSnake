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
    $response_array = json_decode(ClassForGetParams::getRequestParamsForGettingGameData($game)["params"]);
    if ($response_array['info'] == 202) {
        $response_array = json_decode(ClassForGetParams::getRequestParamsForGettingGameData($game)["params"]);
    }

    $game->setEnemyHead($response_array->snakes->enemy->head);
    $game->setEnemyBody($response_array->snakes->enemy->body);
    $game->setEnemyTail($response_array->snakes->enemy->tail);
    $game->setEnemyIsBited($response_array->snakes->enemy->is_bited);

    $game->setBody($response_array->snakes->ally->body);
    $game->setHead($response_array->snakes->ally->head);
    $game->setTail($response_array->snakes->ally->tail);
    $game->setIsBited($response_array->snakes->ally->is_bited);

    //

    $game->initSnake();

    //4 запрос

    $second_response_array = ClassForGetParams::getRequestParamsWithStep($game);
    if ($second_response_array['info'] == 200){
        // вызываю функцию заново, начиная со второго запроса
    }















    requestWithoutStep();

    function requestWithoutStep(){
        $ok = true;
        while ($ok){
            global $game;
            $params = ClassForGetParams::getRequestParamsForGettingGameData($game);





            $game->initSnake();
            $step = constant($game->getStep());
            $info = ClassForGetParams::getRequestParamsWithStep($game, $step);

            if (!$info[http_response_code(200)]){
                $ok = false;
            }
        }
    }

    /*function requestWithStep()
    {
        global $game;
        while (true) {
            $game->initSnake();
            $step = $game->getStep();
            ClassForGetParams::getRequestParamsWithStep($game, $step);
            requestWithStep();
        }
    }*/

    /*function requestWithoutStep()
    {
        global $snakeId;
        global $battleId;
        global $game;

        $requestWithId= new RequestWithId();
        $params = $requestWithId->createJson($snakeId, $battleId);
        while (true) {
            $result = $requestWithId->requestServer($params);

            if ($requestWithId->getInfo() == 202) {
                $result = $requestWithId->requestServer($params);
            }

            $decoded_json = json_decode($result);
            $game->setEnemyBody($decoded_json->snakes->enemy->body);
            $game->setEnemyHead($decoded_json->snakes->enemy->head);
            $game->setEnemyTail($decoded_json->snakes->enemy->tail);
            $game->setEnemyIsBited($decoded_json->snakes->enemy->is_bited);

            $game->setBody($decoded_json->snakes->ally->body);
            $game->setHead($decoded_json->snakes->ally->head);
            $game->setTail($decoded_json->snakes->ally->tail);
            $game->setIsBited($decoded_json->snakes->ally->is_bited);
        }
    }
    function requestWithStep(){
        global $game;
        global $snakeId;
        global $battleId;
        while (true){
            $game->initSnake();
            $step = constant($game->getStep());
            $requestWithStep = new RequestWithStep();
            $step_params = $requestWithStep->createJsonWithStep($snakeId, $battleId, $step);
            $result_step = $requestWithStep->requestServerWithStep($step_params);
            if ($requestWithStep->getInfo() == 200){

            }
        }
    }*/


