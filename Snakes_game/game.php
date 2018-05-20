<?php

spl_autoload_register(function ($class_name) {
    include "$class_name.php";
});

use PHPSnake\Snake;


while (true){
    // обращение к методам запроса на сервак
}

while (true){
    // отправка / получение ходов змей
    $ch = curl_init('http://localhost:****/');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($request_string))
    );
    $result = curl_exec($ch);
    curl_close($ch);
}

//запросы вынесены отдельно: инициализация, отправка ходов змеи, контроль хода игры
$request = array(
    "answer" => 42
);
$request_string = json_encode($request);

// отправляем json

// result - ответный json

//получаем ответ (battle_id, snake_id)
//ответ (battle_id, snake_id) отправляем как запрос серваку
// получаем ответ 202
//отправляем json, получаем json с картой и змеями
