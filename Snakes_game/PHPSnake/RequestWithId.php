<?php
/**
 * Created by PhpStorm.
 * User: Regina
 * Date: 20.05.2018
 * Time: 22:58
 */

namespace PHPSnake;
use PHPSnake\RequestAnswer;

class RequestWithId
{
    /**
     * RequestWithId constructor.
     * @param int $getSnakeId
     * @param int $getBattleId
     */


    private $curl;
    private $info;

    private $snake_id;
    private $battle_id;


    public function __construct($snake_id, $battle_id )
    {
        $this->snake_id = $snake_id;
        $this->battle_id = $battle_id;
    }


    public function requestServer($params){
        $url = 'http://80.211.132.97:8888/snake';
        $this->curl = curl_init();
        curl_setopt_array($this->curl, array(
            CURLOPT_USERAGENT =>
                'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'),
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $params
        ));

        $result = curl_exec($this->curl);
        $this->info = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        curl_close($this->curl);
        return $result;
    }

    /**
     * @return mixed
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @param mixed $info
     */
    public function setInfo($info): void
    {
        $this->info = $info;
    }





}