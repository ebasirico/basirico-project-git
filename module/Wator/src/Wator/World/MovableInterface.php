<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 11/06/2015
 * Time: 12:40
 */

namespace Wator\World;


interface MovableInterface
{

    /**
     * @return Movement che viene deciso in modo casuale dal pesce
     */
    public function getMovement();

}