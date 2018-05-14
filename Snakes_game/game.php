<?php


spl_autoload_register(function ($class_name) {
    include_once "$class_name.php";
});

// передать серваку json, получить json противника
$ch = curl_init('server');
$json = ""; // передать json из Snake;

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($json))
);
