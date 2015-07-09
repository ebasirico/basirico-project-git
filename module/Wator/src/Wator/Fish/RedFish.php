<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 11/06/2015
 * Time: 12:06
 */

namespace Wator\Fish;


class RedFish extends FishAbstract implements FoodInterface, FishInterface
{
    const MAX_RED_FISH_HEALTH = 0;

    function __construct($species = "RF")
    {

        $this->setSpecies($species);
//        list($usec, $sec) = explode(' ', microtime());
//        $seed =  (float) $sec + ((float) $usec * 100000);
//        srand($seed);

        $this->setHealth(30);
    }


    /**
     * @return integer ritorna la sua vita prima che venisse mangiato e la divide.
     */
    public function getHealthWhenEat()
    {
        // TODO: Implement getHealthWhenEat() method.
        return $this->getHealth() / 2;
    }


    public function getChildren()
    {
        if ($this->getHealth() <= self::MAX_RED_FISH_HEALTH) {
            return array(
                new RedFish(),
                new RedFish(),
            );
        }
        return array();
    }

}