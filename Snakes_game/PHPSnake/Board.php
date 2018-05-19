<?php
/**
 * Created by PhpStorm.
 * User: Regina
 * Date: 02.05.2018
 * Time: 21:12
 */
namespace PHPSnake;

class Board
{
    private $width;
    private $height;
    private $map;

    public function _construct(int $width, int $height){
        $this->width = $width;
        $this->height=$height;
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return mixed
     */
    public function getMap()
    {
        return $this->map;
    }
}