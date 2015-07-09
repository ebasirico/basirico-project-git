<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 16/06/2015
 * Time: 16:02
 */

namespace Wator\Render;


use Wator\Wator;

abstract class Render implements RenderInterface
{

    private $h;
    private $w;
    private $wator;
    private $map;

    /**
     * @return mixed
     */
    public function getWator()
    {
        return $this->wator;
    }

    public function getMap()
    {
        return $this->map;
    }

    public function updateMap()
    {
        if ($this->wator instanceof Wator) {
            $this->map = $this->wator->getWorldMap();
        }
    }

    /**
     * @param mixed $wator
     */
    public function setWator(Wator $wator)
    {
        $this->wator = $wator;
    }

    /**
     * @return mixed
     */
    public function getH()
    {
        return $this->h;
    }

    /**
     * @param mixed $h
     */
    public function setH($h)
    {
        $this->h = $h;
    }

    /**
     * @return mixed
     */
    public function getW()
    {
        return $this->w;
    }

    /**
     * @param mixed $w
     */
    public function setW($w)
    {
        $this->w = $w;
    }

    public function setRender(Wator $wator)
    {
        $this->setH($wator->getWorldMapHeight());
        $this->setW($wator->getWorldMapWidth());
        $this->setWator($wator);
    }
}