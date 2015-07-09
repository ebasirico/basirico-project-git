<?php
namespace Wator\HS;
/**
 * Created by PhpStorm.
 * User: Ivano Pomatto <i.pomatto@visiotrade.it>
 * Date: 19/06/2015
 * Time: 23:43
 */

class Wator extends \Wator\Wator
{
    public function  __construct($width, $height)
    {
        $this->life = new LifeHS();
        $this->world = $this->life->startEden($width, $height);

        $this->chronons = 0;
    }

    public function getWorldMap()
    {
        return $this->world->getMatrix();
    }
}