<?php
/**
 * Created by PhpStorm.
 * User: Regina
 * Date: 02.05.2018
 * Time: 1:22
 */

namespace PHPSnake;

class Snake
{
    private $id;
    private $head, $body, $tail;
    private $head_enemy,$body_enemy, $tail_enemy;
    private $length = 5;

    private $is_alive = true; // для каждой змеи, в общем классе проверять, если одна из змей умерла, game over

    private $is_bited = false;
    private $is_bite = false;
    private $is_crashed = false;
    private $steps_count = 50;

    private $score = 0;
    private $direction;

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
            $x = $this->head[0];
            $y = $this->head[1];
            /*TODO подумать насчет того, чтобы переделать сделать создание тела в цикле*/
            $this->body = [[$x - 1, $y], [$x - 2, $y], [$x - 3, $y]];
            $this->tail = [$x - 4, $y];

            $this->direction = Direction::RIGHT;
        }
        elseif ($k == 2){
            $this->head = $this->generateLocationForSecondSnake();
            $x = $this->head[0];
            $y = $this->head[1];

            $this->body = [[$x + 1, $y], [$x + 2, $y], [$x + 3, $y]];
            $this->tail = [$x + 4, $y];
            $this->direction = Direction::LEFT;
        }
    }

    public function generateLocationForFirstSnake(){
        $x = rand(4,6);
        $y = rand(0,4);
        $location = [$x, $y];
        return $location;
    }

    public function generateLocationForSecondSnake(){
        $x = rand(3,5);
        $y = rand(6,9);
        $location = [$x, $y];
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
        $x = $this->getHead()[0];
        $y = $this->getHead()[1];
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

    private function move($direction){

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
            case (Direction::UP):
                $this->head = [$x_head, $y_head - 1];
                for ($i = 0; $i < count($array_body); $i ++){
                    $x_body = ($array_body[$i])[0];
                    $y_body = ($array_body[$i])[1];
                    $array_body[$i] = [$x_body, $y_body - 1];
                }
                $this->tail = [$x_tail, $y_tail - 1];
                break;
            case (Direction::DOWN):
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

    //TODO потестить
    //TODO проверять testDirection
    private function snake_choose_dir(){
        $x_snake = $this->head[0];
        $y_snake = $this->head[1];
        //TODO уточнить каким образом хранится инфа о сопернике

        //координаты последнего элемента тела
        //TODO проверять, если есть тело, брать эти значения, если нет - головы. подумать, точно ли не врежется змея в тело, если целью будет не хвост
        $enemy_x = $this->body_enemy[count($this->body_enemy)-1][0];
        $enemy_y = $this->body_enemy[count($this->body_enemy)-1][1];

        // разность между координатами змей
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
        return $this->direction;
    }


    //если координаты головы одной змеи равны координатам хвоста другой змеи, то откусываем
    private function eatSnake(){
        if($this->head[0] == $this->tail_enemy[0] && $this->head[1] == $this->tail_enemy[1]){
        }
    }

    private function rebuldSnakeIfItBite(){
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

    private function rebuildSnakeIfItBited(){
        if (!$this->body){
            array_pop($this->tail);
            $this->is_bited = true;
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
}

