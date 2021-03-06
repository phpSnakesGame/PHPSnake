<?php
/**
 * Created by PhpStorm.
 * User: Regina
 * Date: 02.05.2018
 * Time: 1:22
 */

namespace PHPSnake;
use PHPSnake\Game;

class Snake
{
    private $id;
    private $head, $body, $tail;

    private $is_bited = false;
    private $is_bite = false;

   /* //переменную is_alive меняем с false на true, когда съедена, врезалась в границы поля или в голову / тело
    // змеи - противника, обнулился счетчик, отвечающий за кол-во шагов
    public function checkAlive(){
        if ((count($this->head) + count($this->body) + count($this->tail)) == 1 || $this->is_crashed = true || $this->steps_count = 0){
            $this->is_alive = false;
        }
        else {
            $this->is_alive = true;
        }
        return $this->is_alive;
    }*/

    //при создании змеи, задаем ей "собственнный идентификатор": 1 или 2
    // если k = 1, генерируем ее первоначальное появление в поле (x: 0 -> 6; y: 0 -> 4)
    // если k = 2, генерируем первоначальное появление в поле (х: 4 -> 10; y: 6 -> 10)
    public function __construct($id, $head, $body, $tail){
        $this->id = $id;

        $this->head = $head;
        $this->body = $body;
        $this->tail = $tail;
       /* $x = $this->head[0];
        $y = $this->head[1];

        $this->body = [[$x - 1, $y], [$x - 2, $y], [$x - 3, $y]];
        $this->tail = [$x - 4, $y];

        $this->direction = Direction::RIGHT;*/

    }

    // проверка границ поля
    public function testBoardOfMap($x, $y)
    {

        if ($x > 0 && $y > 0 && $x < 9 && $y < 9){
            return true;
        }
        return false;
    }

    public function testDirectionOfSnake($direction)
    {
        $previous_direction = $this->direction;

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

    public function move($direction){

        $x_head = $this->getHead()[0];
        $y_head = $this->getHead()[1];

        $array_body = $this->getBody();
        $x_tail = $this->getTail()[0];
        $y_tail = $this->getTail()[1];

        switch ($direction){
            case (Direction::LEFT):
                $this->head = [$x_head - 1,$y_head];
                for ($i = 0; $i < count($array_body); $i ++){
                    $x_body = ($array_body[$i])[0];
                    $y_body = ($array_body[$i])[1];
                    $array_body[$i] = [$x_body - 1, $y_body];
                }
                $this->tail = [$x_tail - 1, $y_tail];
                break;
            case (Direction::RIGHT):
                $this->head = [$x_head + 1, $y_head];
                for ($i = 0; $i < count($array_body); $i ++){
                    $x_body = ($array_body[$i])[0];
                    $y_body = ($array_body[$i])[1];
                    $array_body[$i] = [$x_body + 1, $y_body];
                }
                $this->tail = [$x_tail + 1, $y_tail];
                break;
            case (Direction::DOWN):
                $this->head = [$x_head, $y_head - 1];
                for ($i = 0; $i < count($array_body); $i ++){
                    $x_body = ($array_body[$i])[0];
                    $y_body = ($array_body[$i])[1];
                    $array_body[$i] = [$x_body, $y_body - 1];
                }
                $this->tail = [$x_tail, $y_tail - 1];
                break;
            case (Direction::UP):
                $this->head = [$x_head, $y_head + 1];
                for ($i = 0; $i < count($array_body); $i ++){
                    $x_body = ($array_body[$i])[0];
                    $y_body = ($array_body[$i])[1];
                    $array_body[$i] = [$x_body, $y_body + 1];
                }
                $this->tail = [$x_tail, $y_tail + 1];
                break;
        }
    }

    public function snake_choose_dir($tail_enemy, $head_enemy, $body_enemy){

        $x_snake = $this->head[0];
        $y_snake = $this->head[1];


        //координаты последнего элемента тела
        if (($head_enemy[0] == $tail_enemy[0] && abs($head_enemy[1] - $tail_enemy[1])== 1) || ($head_enemy[1] == $tail_enemy[1] && abs($head_enemy[0] - $tail_enemy[0])== 1)){
            $enemy_x = $head_enemy[0];
            $enemy_y = $head_enemy[1];
        }else {
            $enemy_x = $body_enemy[count($body_enemy) - 1][0];
            $enemy_y = $body_enemy[count($body_enemy) - 1][1];
        }
        // разность между координатами змей

        $x_dif = $x_snake-$enemy_x;
        $y_dif = $y_snake-$enemy_y;

        $dir_1 = Direction::LEFT;
        $dir_2 = Direction::UP;

        if ($x_snake < $enemy_x){
            $dir_1 = Direction::RIGHT;
        }

        if ($y_snake > $enemy_y){
            $dir_2 = Direction::DOWN;
        }


        if(abs($x_dif) > abs($y_dif) && $this->testDirectionOfSnake($dir_1)){

            $this->direction = $dir_1;
        }elseif ($this->testDirectionOfSnake($dir_2)){
            $this->direction = $dir_2;
        }
        else {
            $this->direction = $dir_1;
        }
        return $this->direction;
    }


    //если координаты головы одной змеи равны координатам хвоста другой змеи, то откусываем
  
    public function enemySnakeIsBited($tail_enemy){
        if($this->head[0] == $tail_enemy[0] && $this->head[1] == $tail_enemy[1]){
            $this->rebuildSnakeIfItBite();
            return $this->is_bite = true;
        }
        return false;
    }

    public function ourSnakeIsBited($head_enemy){
        if ($head_enemy[0] == $this->tail[0] && $head_enemy[1] == $this->tail[1]){
            $this->rebuildSnakeIfItBited();
            return $this->is_bited = true;
        }
        return false;
    }

    public function rebuildSnakeIfItBite(){
        $body = $this->getBody();
        if (!$body){
            $last_element = $this->getHead();
        }

        else {
            $last_element = $body[count($body) - 1];
        }
        $x_tail = $this->getTail()[0];
        $y_tail = $this->getTail()[1];

        if ($x_tail == $last_element[0] && $y_tail > $last_element[1]) {
            $this->body[count($body)] = [$x_tail, $y_tail];
            if  ($y_tail < 9  && $y_tail > 0 && $x_tail > 0 && $x_tail < 9) {
                $this->tail = [$x_tail, $y_tail + 1];
            }
            elseif ($y_tail == 9 && $x_tail >= 0 && $x_tail < 9){
                $this->tail = [$x_tail + 1, $y_tail];
            }
            elseif ($y_tail == 9 && $x_tail == 9){
                 $this->tail = [$x_tail - 1, $y_tail];
            }
        }

        elseif ($x_tail == $last_element[0] && $y_tail < $last_element[1]){
            $this->body[count($body)] = [$x_tail, $y_tail];
            if ($y_tail > 0 && $y_tail < 9 && $x_tail > 0 && $x_tail < 9){
                $this->tail = [$x_tail, $y_tail - 1];
            }
            elseif ($y_tail == 0 && $x_tail >= 0 && $x_tail < 9){
                $this->tail = [$x_tail + 1, $y_tail];
            }
            elseif ($y_tail ==0 && $x_tail == 9){
                $this->tail = [$x_tail - 1, $y_tail];
            }
        }

        elseif ($x_tail < $last_element[0] && $y_tail == $last_element[1]){
            $this->body[count($body)] = [$x_tail, $y_tail];
            if ($x_tail > 0 && $x_tail < 9 && $y_tail > 0 && $y_tail < 9){
                $this->tail = [$x_tail - 1, $y_tail];
            }
            elseif ($x_tail == 0 && $y_tail >= 0 && $y_tail < 9 ){
                $this->tail = [$x_tail, $y_tail + 1];
            }
            elseif ($x_tail == 0 && $y_tail == 9){
                $this->tail = [$x_tail, $y_tail - 1];
            }
        }
        elseif ($x_tail > $last_element[0] && $y_tail == $last_element[1]){
            $this->body[count($body)] = [$x_tail, $y_tail];
            if ($x_tail > 0 && $x_tail < 9 && $y_tail > 0 && $y_tail < 9){
                $this->tail = [$x_tail + 1, $y_tail];
            }
            elseif ($x_tail == 9 && $y_tail >= 0 && $y_tail < 9){
                $this->tail = [$x_tail, $y_tail + 1];
            }
            elseif ($x_tail == 9 && $y_tail == 9){
                $this->tail = [$x_tail, $y_tail - 1];
            }
        }
    }


    public function rebuildSnakeIfItBited(){
        if (!$this->body){
            array_pop($this->tail);
        }

        else{
            $x_last_element = $this->body[(count($this->body) - 1)][0];
            $y_last_element = $this->body[(count($this->body) - 1)][1];
            array_pop($this->body);
            array_pop($this->tail);
            $this->tail = [$x_last_element, $y_last_element];
        }
    }

    /**
     * @return array
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * @return array
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return array
     */
    public function getTail()
    {
        return $this->tail;
    }

    /**
     * @param array $head
     */
    public function setHead($head): void
    {
        $this->head = $head;
    }

    /**
     * @param array $body
     */
    public function setBody($body): void
    {
        $this->body = $body;
    }

    /**
     * @param array $tail
     */
    public function setTail($tail): void
    {
        $this->tail = $tail;
    }

    public function getId()
    {
        return $this->id;
    }

    private $direction;

    /**
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction;
    }
}

