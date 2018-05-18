<?php
/**
 * Created by PhpStorm.
 * User: Regina
 * Date: 02.05.2018
 * Time: 1:22
 */

namespace PHPSnake;

use PHPSnake\Board\Location;

class Snake
{
    private $id;
    private $head, $body, $tail;
    private $length = 5;

    private $is_alive = false; // для каждой змеи, в общем классе проверять, если одна из змей умерла, game over

    private $is_bited = false;
    private $is_crashed = false;
    private $steps_count = 50;

    private $score = 0;
    private $json;
    private $direction = Direction::RIGHT;

    //с false на true, когда съедена(тело = 0 или только голова), врезалась, кол-во шагов
    public function checkAlive(){
        if ($this->is_bited = true || $this->is_crashed = true || $this->steps_count = 0){
            $this->is_crashed = true;
        }
        return $this->is_alive;
    }

    public function _construct($id, $k){

        $this->id = $id;

        if ($k == 1){
            $this->head = $this->generateLocationForFirstSnake();
        }
        elseif ($k == 2){
            $this->head = $this->generateLocationForSecondSnake();
        }

        $x = $this->head->getX();
        $y = $this->head->getY();

        //проверка рандома для разного положения змей
        for ($i = 1; $i <= 3; $i++){
            $this->body[$i] = new Location($x + $i, $y);
        }

        $this->tail = new Location($x + 4, $y);
    }

    /**
     * @return Location
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * @return Location
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return Location
     */
    public function getTail()
    {
        return $this->tail;
    }

    /**
     * @param Location $head
     */
    public function setHead($head): void
    {
        $this->head = $head;
    }

    /**
     * @param Location $body
     */
    public function setBody($body): void
    {
        $this->body = $body;
    }

    /**
     * @param Location $tail
     */
    public function setTail($tail): void
    {
        $this->tail = $tail;
    }


    // расположение рандомное: одна змея (х:0 до 6; у:0 до 4), другая змея (х:4 до 10; у:6 до 10)
    //проверка рандома на границе
    public function generateLocationForFirstSnake(){
        $x = rand(0,6);
        $y = rand(0,4);
        $location = new Location($x, $y);
        return $location;
    }

    public function generateLocationForSecondSnake(){
        $x = rand(4,10);
        $y = rand(6,10);
        $location = new Location($x, $y);
        return $location;
    }

    public function getId()
    {
        return $this->id;
    }

    public function makeJson(){
        $this->json = array("id"=>$this->id, "head"=>$this->head, "body"=>$this->body, "tail"=>$this->tail,
            "is_bited"=>$this->is_bited);
        $json_string = json_encode($this->json);
        return $json_string;
    }

    //проверка границ
    public function testBoard()
    {
        $this->head = $this->getHead();
        $x = $this->head->getX();
        $y = $this->head->getY();
        if ($x == 0 || $y == 0 || $x == 10 || $y == 10){
            $this->is_crashed = true;
        }
        return $this->is_crashed;
    }


    private function testDirection($temp, $direction)
    {
        if ($direction == Direction::UP){
            if ($temp == Direction::DOWN){
                return false;
            }
        }

        elseif ($direction == Direction::DOWN){
            if ($temp == Direction::UP){
                return false;
            }
        }

        elseif ($direction == Direction::LEFT){
            if ($temp == Direction::RIGHT){
                return false;
            }
        }

        elseif ($direction == Direction::RIGHT){
            if ($temp == Direction::LEFT){
                return false;
            }
        }
        return true;
    }


    private function move($direction){
        /* х, у только для примера, надо взять старые значения голова, тела, хвоста*/
        $x = 0;
        $y = 0;

        switch ($direction){
            case (Direction::LEFT):
                $this->head = new Location( $x - 1,$y);
                // сдвинуть все тело
                $this->tail = new Location($x - 1, $y);
                break;
            case (Direction::RIGHT):
                $this->head = new Location($x + 1, $y);
                $this->tail = new Location($x + 1, $y);
                break;
            case (Direction::UP):
                $this->head = new Location($x, $y - 1);
                $this->tail = new Location($x, $y - 1);
                break;
            case (Direction::DOWN):
                $this->head = new Location($x, $y + 1);
                $this->tail = new Location($x, $y + 1);
                break;
        }
    }

    // подумать как взять координаты змей
    private function snake_choose_dir(){
        $x_snake = 0;
        $y_snake = 0;

        $enemy_x = 1;
        $enemy_y = 1;

        if ($x_snake > $enemy_x && $y_snake > $enemy_y){
            if ($this->direction == Direction::RIGHT)
            {
                $this->direction = Direction::UP;
            }
            elseif ($this->direction == Direction::LEFT)
            {
                $this->direction = Direction::UP;
            }
            elseif ($this->direction == Direction::UP)
            {
                $this->direction = Direction::LEFT;
            }
            elseif ($this->direction == Direction::DOWN)
            {
                $this->direction = Direction::LEFT;
            }
        }
        elseif ($x_snake > $enemy_x && $y_snake < $enemy_y) {
            if ($this->direction == Direction:: RIGHT) {
                $this->direction = Direction::DOWN;
            } elseif ($this->direction == Direction::LEFT) {
                $this->direction = Direction::DOWN;
            } elseif ($this->direction == Direction::UP) {
                $this->direction = Direction::LEFT;
            } elseif ($this->direction == Direction::DOWN) {
                $this->direction = Direction::LEFT;
            }
        }

        elseif ($x_snake < $enemy_x && $y_snake > $enemy_y){
            if ($this->direction == Direction::RIGHT) {
                $this->direction = Direction::UP;
            } elseif ($this->direction == Direction::LEFT) {
                $this->direction = Direction::UP;
            } elseif($this->direction == Direction::UP) {
                $this->direction = Direction::RIGHT;
            } elseif ($this->direction == Direction::DOWN)
            {
                $this->direction = Direction::RIGHT;
            }
        }

        elseif ($x_snake < $enemy_x && $y_snake < $enemy_y){
            if ($this->direction == Direction::RIGHT) {
                $this->direction = Direction::DOWN;
            }
            elseif ($this->direction == Direction::LEFT){
                $this->direction = Direction::DOWN;
            }
            elseif ($this->direction == Direction::UP){
                $this->direction = Direction::RIGHT;
            }
            elseif ($this->direction == Direction::DOWN){
                $this->direction = Direction::RIGHT;
            }
        }
    }

    //если координаты головы одной змеи равны координатам хвоста другой змеи, то откусываем
    private function eatSnake(){

    }

}

