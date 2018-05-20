<?php
/**
 * Created by PhpStorm.
 * User: Regina
 * Date: 20.05.2018
 * Time: 19:54
 */

namespace PHPSnake;
use PHPSnake\Snake;

class Game
{
    private $snake_id;
    private $battle_id;

    //функция получения json-a


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