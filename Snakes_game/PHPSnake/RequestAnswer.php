<?php
/**
 * Created by PhpStorm.
 * User: Regina
 * Date: 21.05.2018
 * Time: 4:57
 */

namespace PHPSnake;

class RequestAnswer
{
    private $curl;

    private $snake_id;
    private $battle_id;


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
        curl_close($this->curl);

        return $result;
    }


    /**
     * @return int
     */
    public function getSnakeId()
    {
        return $this->snake_id;
    }

    /**
     * @param int $snake_id
     */
    public function setSnakeId($snake_id): void
    {
        $this->snake_id = $snake_id;
    }

    /**
     * @return int
     */
    public function getBattleId()
    {
        return $this->battle_id;
    }

    /**
     * @param int $battle_id
     */
    public function setBattleId($battle_id): void
    {
        $this->battle_id = $battle_id;
    }
}