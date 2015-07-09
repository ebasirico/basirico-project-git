<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 11/06/2015
 * Time: 12:11
 */
namespace Wator\Fish;

/**
 * Class Shark
 * @package Wator
 * La classe Shark estende la classe Fish in quanto rappresenta una variante della specie essa puo' mangiare e riprodursi ma non puo' essere mangiata.
 */
class Shark extends FishAbstract implements PredatorInterface, FishInterface{
    const MAX_SHARK_HEALTH = 80;

    /**
     * @param string $species
     *
     */
    function __construct( $species = "S")
    {
        $this->setSpecies($species);
        $this->setHealth(20);
    }

    /**
     * @param FoodInterface $food cibo da mangiare
     */
    public function eat(FoodInterface $food)
    {
        $this->setHealth($this->getHealth()+$food->getHealthWhenEat());
    }

    /**
     * @return array
     */
    public function getChildren(){
        if ( $this->getHealth() > self::MAX_SHARK_HEALTH){
            return array
            (
                new Shark(),

            );
        }
        return array();
    }

}
