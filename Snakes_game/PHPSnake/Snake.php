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
    private $steps_count = 50;

    private $is_alive = false;
    private $is_bited = false;
    private $is_crashed = false;

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
    public function _construct($id, $x, $y){

        $this->id = $id;

        $this->head = new Location($x, $y);

        for ($i = 1; $i <= 3; $i++){
            $this->body[$i] = new Location($x + $i, $y);
        }

        $this->tail = new Location($x + 4, $y);
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

    public function testBoard(){

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
        // если делать в консоли, надо почистить клетку, где змея была, сделать ее пустой
        }
    }

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

    private function eatSnake(){

    }

}

/*
    function move($dir){
        switch ($dir){
            case 'LEFT':
                $this.x -= 1;
            break;
            ....
        }
    }
}*/

    /*public function move(string $input)
{
    $this->changeDirection($input);
    $row = $this->points[0]->getRow();
    $col = $this->points[0]->getCol();
    switch ($this->direction) {
        case Direction::RIGHT:
            $col++;
            break;
        case Direction::LEFT:
            $col--;
            break;
        case Direction::UP:
            $row--;
            break;
        case Direction::DOWN:
            $row++;
            break;
    }
    if ($col >= $this->boardCols - 1) {
        $col = 1;
    } elseif ($col < 1) {
        $col = $this->boardCols - 2;
    }
    if ($row >= $this->boardRows - 1) {
        $row = 1;
    } elseif ($row < 1) {
        $row = $this->boardRows - 2;
    }
    $this->points[0]->setChar(Char::shadeBlock());
    $next = new Location($row, $col, Char::block());
    $this->checkCollision($next);
    array_unshift($this->points, $next);
    $this->lastPoint = array_pop($this->points);
}*/
