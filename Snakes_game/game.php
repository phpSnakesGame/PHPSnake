<?php

use PHPSnake\Snake;

spl_autoload_register(function ($class_name) {
    include_once "$class_name.php";
});

/*TODO отправка и получение json-a, в цикле ?*/
// json

$request = array(
    "answer" => 42
);
$request_string = json_encode($request);



// отправляем json

$ch = curl_init('http://localhost:****/');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $request_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($request_string))
);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
$result = curl_exec($ch);
curl_close($ch);


// result - ответный json


//получаем ответ (battle_id, snake_id)
//ответ (battle_id, snake_id) отправляем как запрос серваку
// получаем ответ 202
//отправляем json, получаем json с картой и змеями

