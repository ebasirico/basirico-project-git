<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 11/06/2015
 * Time: 12:02
 */

namespace Wator\Fish;
use Wator\World\MovableInterface;
use Wator\World\Movement;
use Wator\Fate\Life;

/**
 * Class Fish
 * @package Wator
 * E' una classe astratta del tipo Fish
 */
abstract class FishAbstract implements FishInterface, MovableInterface {
    /**
     * @integer health rappresenta la vita del pesce
     */
    private $health ;

    /**
     * @integer health rappresenta la specie del pesce
     */
    private $species;

    /**
     * @return int
     *
     */

    public function getHealth(){
        return $this->health;
    }

    /**
     * @param $health
     */
    public function setHealth( $health ) {
        $this->health = $health ;
    }

    /**
     * il pesce ritorna la direzione che vuole intraprendere .
     * @return Movement
     */
    public function getMovement()
    {
        $move = new Movement();
        $dirs = $move->getDirections();
        $dir = rand(0,count($dirs)-1);
        $move->setDirection($dirs[$dir]);

        return $move;
    }

    /**
     * @param $species
     */
    public function setSpecies($species){
        $this->species = $species;
    }

    /**
     * @return string species.
     */
    public function getSpecies(){
        return $this->species;
    }

}



