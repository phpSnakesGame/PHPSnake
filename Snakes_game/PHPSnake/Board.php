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

    public function generateMap()
    {
        for ($i = 0; $i < $this->height; ++ $i){
            $this->map[$i] = array_fill(0, $this->width, ' ');
        }
    }

   /* private function generateOutline()
    {
        $this->map[0][0] = Char::boxTopLeft();
        $this->map[0][$this->width - 1] = Char::boxTopRight();
        $this->generateHLine(0, 1, $this->width - 2, Char::boxHorizontal());
        $this->generateHLine($this->height - 1, 1, $this->width - 2, Char::boxHorizontal());
        $this->generateVLine(0, 1, $this->height - 2, Char::boxVertical());
        $this->generateVLine($this->width - 1, 1, $this->height - 2, Char::boxVertical());
        $this->map[$this->height - 1][0] = Char::boxBottomLeft();
        $this->map[$this->height - 1][$this->width - 1] = Char::boxBottomRight();
    }*/



}