<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 11/06/2015
 * Time: 15:57
 */

namespace Wator\World;

/**
 * Class Position
 * Classe per effettuare i calcoli e la gestione di una posizione sulla mappa
 *
 * @package Wator\World
 */
class Position
{

    /**
     * @var int
     */
    private $x;

    /**
     * @var int
     */
    private $y;


    function __construct($x, $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @param Movement $move
     * @return Position
     * return Posizione di Move.
     */
    public function calculateNewPoint(Movement $move)
    {
        $destination = new Position($this->x, $this->y);

        switch ($move->getDirection()) {
            case Movement::NORTH:
                $destination->setY($destination->getY() + $move->getSpeed());
                break;
            case Movement::SOUTH:
                $destination->setY($destination->getY() - $move->getSpeed());
                break;
            case Movement::WEST:
                $destination->setX($destination->getX() - $move->getSpeed());
                break;
            case Movement::EAST:
                $destination->setX($destination->getX() + $move->getSpeed());
                break;
            default :
                throw new \RuntimeException('errore direzione');
        }

        return $destination;
    }

    /**
     * @return int
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @param int $x
     */
    public function setX($x)
    {
        $this->x = $x;
    }

    /**
     * @return int
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * @param int $y
     */
    public function setY($y)
    {
        $this->y = $y;
    }


}