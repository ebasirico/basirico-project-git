<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 11/06/2015
 * Time: 12:21
 */

namespace Wator\Fish;

/**
 * Se un pesce implementa questa interfaccia allora può essere mangiato
 */
interface FoodInterface {

    /**
     * @return integer
     */
    public function getHealthWhenEat() ;
}