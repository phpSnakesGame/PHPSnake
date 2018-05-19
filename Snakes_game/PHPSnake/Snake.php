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

    private $head_enemy,$body_enemy, $tail_enemy;
    private $is_alive = true; // для каждой змеи, в общем классе проверять, если одна из змей умерла, game over

    private $is_bited = false;
    private $is_crashed = false;
    private $steps_count = 50;

    private $score = 0;
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
    public function __construct($id, $k){
        $this->id = $id;

        if ($k == 1){
            $this->head = $this->generateLocationForFirstSnake();
            $x = $this->head->getX();
            $y = $this->head->getY();
            /*TODO подумать насчет того, чтобы переделать сделать создание тела в цикле*/
            $this->body = [new Location($x - 1, $y), new Location($x - 2, $y), new Location($x - 3, $y)];
            $this->tail = new Location($x - 4, $y);

            $this->direction = Direction::RIGHT;
        }
        elseif ($k == 2){
            $this->head = $this->generateLocationForSecondSnake();
            $x = $this->head->getX();
            $y = $this->head->getY();

            $this->body = [new Location($x + 1, $y), new Location($x + 2, $y), new Location($x + 3, $y)];
            $this->tail = new Location($x + 4, $y);
            $this->direction = Direction::LEFT;
        }
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
        $json = array("id"=>$this->getId(), "head"=>$this->getHead(), "body"=>$this->getBody(), "tail"=>$this->getTail(),
            "is_bited"=>$this->is_bited);
        $json_string = json_encode($json);
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
        $x_snake = $this->head->getX();
        $y_snake = $this->head->getY();

        //TODO уточнить каким образом хранится инфа о сопернике
        $enemy_x = $this->body_enemy[count(body_enemy)-1][0];
        $enemy_y = $this->body_enemy[count(body_enemy)-1][1];

        $x_dif = $x_snake-$enemy_x;
        $y_dif = $y_snake-$enemy_y;

        $dir_1 = Direction::LEFT;
        $dir_2 = Direction::DOWN;


        if ($x_snake < $enemy_x){
            $dir_1 = Direction::RIGHT;
        }
        if ($y_snake > $enemy_y){
            $dir_2 = Direction::UP;
        }
        if(abs($x_dif) > abs($y_dif)){
            $this->direction = $dir_1;
        }else{
            $this->direction = $dir_2;
        }
    }

    //если координаты головы одной змеи равны координатам хвоста другой змеи, то откусываем
    private function eatSnake(){
        if($this->head->getX() == $this->tail_enemy[0] && $this->head->getY() == $this->tail_enemy[1]){

        }
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

