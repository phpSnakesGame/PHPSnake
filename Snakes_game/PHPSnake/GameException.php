<?php
/**
 * Created by PhpStorm.
 * User: Regina
 * Date: 02.05.2018
 * Time: 20:21
 */

namespace PHPSnake;

class GameException extends \Exception
{
    /**
     * @return GameException
     */
    public static function snakeCollision()
    {
        return new self('Змеи столкнулись');
    }
}