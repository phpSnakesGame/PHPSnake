<?php
/**
 * Created by PhpStorm.
 * User: Regina
 * Date: 21.05.2018
 * Time: 10:15
 */

namespace PHPSnake;
use PHPSnake\Snake;

class Game
{
    private $snake_id;
    private $battle_id;

    private $step;

    private $enemy_head, $enemy_body, $enemy_tail;
    private $head, $body, $tail;

    private $enemy_is_bited, $is_bited;

    private $snake;

    public function initSnake(){
        $this->snake = new Snake($this->snake_id, $this->head, $this->body, $this->tail);
        return $this->snake;
    }

    /**
     * @return Snake
     */
    public function getSnake()
    {
        return $this->snake;
    }

    /**
     * @param Snake $snake
     */
    public function setSnake($snake): void
    {
        $this->snake = $snake;
    }


    public function moveSnake(Snake $snake){
        $this->step = $snake->snake_choose_dir($this->enemy_tail, $this->enemy_head, $this->enemy_body);
        $snake->move($this->step);
        if ($snake->enemySnakeIsBited($this->enemy_tail)){
            $snake->rebuildSnakeIfItBite();
        }
        if ($snake->ourSnakeIsBited($this->enemy_head)){
            $snake->rebuildSnakeIfItBited();
        }
        $this->tail = $snake->getTail();
        $this->body = $snake->getBody();
        $this->head = $snake->getHead();
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

    /**
     * @return array
     */
    public function getEnemyHead()
    {
        return $this->enemy_head;
    }

    /**
     * @param array $enemy_head
     */
    public function setEnemyHead($enemy_head): void
    {
        $this->enemy_head = $enemy_head;
    }

    /**
     * @return array
     */
    public function getEnemyBody()
    {
        return $this->enemy_body;
    }

    /**
     * @param array $enemy_body
     */
    public function setEnemyBody($enemy_body): void
    {
        $this->enemy_body = $enemy_body;
    }

    /**
     * @return array
     */
    public function getEnemyTail()
    {
        return $this->enemy_tail;
    }

    /**
     * @param array $enemy_tail
     */
    public function setEnemyTail($enemy_tail): void
    {
        $this->enemy_tail = $enemy_tail;
    }

    /**
     * @return array
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * @param array $head
     */
    public function setHead($head): void
    {
        $this->head = $head;
    }

    /**
     * @return array
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param array $body
     */
    public function setBody($body): void
    {
        $this->body = $body;
    }

    /**
     * @return array
     */
    public function getTail()
    {
        return $this->tail;
    }

    /**
     * @param array $tail
     */
    public function setTail($tail): void
    {
        $this->tail = $tail;
    }

    /**
     * @return Direction
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * @param Direction $step
     */
    public function setStep($step): void
    {
        $this->step = $step;
    }

    /**
     * @return boolean
     */
    public function getEnemyIsBited()
    {
        return $this->enemy_is_bited;
    }

    /**
     * @param boolean $enemy_is_bited
     */
    public function setEnemyIsBited($enemy_is_bited): void
    {
        $this->enemy_is_bited = $enemy_is_bited;
    }

    /**
     * @return boolean
     */
    public function getisBited()
    {
        return $this->is_bited;
    }

    /**
     * @param boolean $is_bited
     */
    public function setIsBited($is_bited): void
    {
        $this->is_bited = $is_bited;
    }



}