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

    private $is_alive = true; // для каждой змеи, в общем классе проверять, если одна из змей умерла, game over

    private $is_bited = false;
    private $is_crashed = false;
    private $steps_count = 50;

    private $score = 0;
    private $json;
    private $direction = Direction::RIGHT;

    /*TODO определиться, когда змея считается съеденной: когда тело = 0 или когда остается только голова*/

    //переменную is_alive меняем с false на true, когда съедена, врезалась в границы поля или в голову / тело
    // змеи - противника, обнулился счетчик, отвечающий за кол-во шагов
    public function checkAlive(){
        if ($this->length == 1 || $this->is_crashed = true || $this->steps_count = 0){
            $this->is_alive = false;
        }
        else {
            $this->is_alive = true;
        }
        return $this->is_alive;
    }

    //при создании змеи, задаем ей "собственнный идентификатор": 1 или 2
    // если k = 1, генерируем ее первоначальное появление в поле (x: 0 -> 6; y: 0 -> 4)
    // если k = 2, генерируем первоначальное появление в поле (х: 4 -> 10; y: 6 -> 10)
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

        for ($i = 1; $i <= 3; $i++){
            $this->body[$i] = new Location($x + $i, $y);
        }

        $this->tail = new Location($x + 4, $y);
    }


    /*TODO расположение змеи с k = 1: head[x,y], где {x: 4 -> 6; y: 0 -> 4}, тело и хвост располагаются слева от головы, направление дефолтное направо */
    /*TODO расположение змеи с k = 2: head[x,y], где {x: 3 -> 5; y: 6 -> 9}, тело и хвост располагаются справа от головы, направление дефолтное влево*/

    public function generateLocationForFirstSnake(){
        $x = rand(4,6);
        $y = rand(0,4);
        $location = new Location($x, $y);
        return $location;
    }

    public function generateLocationForSecondSnake(){
        $x = rand(3,5);
        $y = rand(6,9);
        $location = new Location($x, $y);
        return $location;
    }


    public function makeJson(){
        $this->json = array("id"=>$this->id, "head"=>$this->head, "body"=>$this->body, "tail"=>$this->tail,
            "is_bited"=>$this->is_bited);
        $json_string = json_encode($this->json);
        return $json_string;
    }

    // проверка границ поля
    public function testBoardOfMap()
    {
        $x = $this->getHead()->getX();
        $y = $this->getHead()->getY();
        if ($x < 0 || $y < 0 || $x > 9 || $y > 9){
            $this->is_crashed = true;
        }
        else {
            $this->is_crashed = false;
        }
        return $this->is_crashed;
    }


    private function testDirectionOfSnake($previous_direction, $direction)
    {
        if ($direction == Direction::UP){
            if ($previous_direction == Direction::DOWN){
                return false;
            }
        }

        elseif ($direction == Direction::DOWN){
            if ($previous_direction == Direction::UP){
                return false;
            }
        }

        elseif ($direction == Direction::LEFT){
            if ($previous_direction == Direction::RIGHT){
                return false;
            }
        }

        elseif ($direction == Direction::RIGHT){
            if ($previous_direction == Direction::LEFT){
                return false;
            }
        }
        return true;
    }

    /*TODO брать координаты частей змеи и сдвигать*/
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

    /*TODO реализовать алгоритм для движения змеи */
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

    public function getId()
    {
        return $this->id;
    }


}

