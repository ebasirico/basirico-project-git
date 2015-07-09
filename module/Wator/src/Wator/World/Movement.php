<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 11/06/2015
 * Time: 12:36
 */

namespace Wator\World;


class Movement
{
    private $speed;
    private $direction;

    const NORTH = 'n';
    const SOUTH = 's';
    const EAST = 'e';
    const WEST = 'w';

    /**
     * @param int $speed
     * Numero di caselle consentite nello spostamento
     */

    public function __construct($speed = 1)
    {
        $this->speed = $speed;
        $this->direction = self::NORTH;
    }

    public function setDirection($direction)
    {
        $this->direction = $direction;
    }

    /**
     * @return string questa funzione ritorna la direzione intrapresa dal pesce
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * @return array di possibili direzioni da intraprendere.
     */
    public function getDirections()
    {
        return [
            self::NORTH,
            self::EAST,
            self::SOUTH,
            self::WEST
        ];
    }

    /**
     * @return int
     */
    public function getSpeed()
    {
        return $this->speed;
    }

}