<?php
/**
 * Created by PhpStorm.
 * User: Regina
 * Date: 02.05.2018
 * Time: 20:36
 */

namespace PHPSnake\Board;

class Location
{
    private $x;
    private $y;

    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y=$y;
    }

    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * @param int $x
     */
    public function setX(int $x): void
    {
        $this->x = $x;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * @param int $y
     */
    public function setY(int $y): void
    {
        $this->y = $y;
    }


    public function getLocation(){
        return array(
            "x"=>$this->x,
            "y"=>$this->y
        );
    }

    public function setLocation(int $x, int $y){
        $this->x=$x;
        $this->y=$y;
    }
}