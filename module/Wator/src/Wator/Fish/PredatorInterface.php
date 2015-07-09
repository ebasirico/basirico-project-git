<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 11/06/2015
 * Time: 12:29
 */

namespace Wator\Fish;


interface PredatorInterface
{


    /**
     * @param FoodInterface $food
     */
    public function eat(FoodInterface $food);

}
