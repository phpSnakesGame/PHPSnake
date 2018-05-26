<?php
/**
 * Created by PhpStorm.
 * User: Regina
 * Date: 25.05.2018
 * Time: 21:39
 */

$array = array(
    "snakes"=>array(
        "enemy"=>array(
            "head"=>[0,1]
        )
    )
);
$array_encode = json_encode($array);
$head = (json_decode($array_encode))->snakes->enemy->head;
print_r($head);