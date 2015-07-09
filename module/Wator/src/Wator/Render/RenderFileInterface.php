<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 22/06/2015
 * Time: 14:57
 */

namespace Wator\Render;


use Wator\Wator;

interface RenderFileInterface
{
    /**
     * @param Wator $wator
     * @return mixed
     *
     * return File renderizzato.
     */
    public function getFile(Wator $wator);

}