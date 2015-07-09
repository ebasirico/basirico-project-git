<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 16/06/2015
 * Time: 16:05
 */

namespace Wator\Render;


use Wator\Wator;

interface RenderInterface
{


    public function getWator();


    public function setWator(Wator $wator);

}