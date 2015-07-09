<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 16/06/2015
 * Time: 16:08
 */

namespace Wator\Render;


use Wator\Fish\FishInterface;
use Wator\Wator;

class PngRender extends Render implements RenderInterface,RenderFileInterface {
    protected $rendering;


    public function __construct(Wator $wator){
        $this->setRender($wator);
        $this->time = new Time();
    }

    public function getTime()
    {
        return $this->time->getTime();
    }


    /**
     * @param Wator $wator
     * @return mixed
     * Updating di Wator e return del suo rendering
     */
    public function getFile(Wator $wator){
        $this->time->startTimer();
        $this->setWator($wator);
        $this->updateMap();
        $this->renderWorld();
        $this->time->stopTimer();
        return imagepng($this->rendering,'/tmp/map.png',0);

    }

    /**
     * Rendering della mappa ,contrassegnazione dei pesci con
     * colori diversi .
     */
    private function renderWorld()
    {
        $map = $this->getMap();
        $this->rendering = @imagecreate($this->getW(), $this->getH());
        $ocean = imagecolorallocate( $this->rendering, 0, 102, 204);
        $black = imagecolorallocate($this->rendering, 0, 0, 0);
        $red   = imagecolorallocate($this->rendering, 255, 0, 0);
        imagefilledrectangle($this->rendering, 0, 0, $this->getW() - 1, $this->getH() - 1, $ocean);


        for ($x = 0; $x < $this->getW(); $x++) {
            for ($y = 0; $y < $this->getH(); $y++) {
                $obj = $map[$x][$y];
                if ($obj instanceof FishInterface ){
                    $color = null ;
                    if ($obj->getSpecies() == "S") {
                        $color = $black;
                    } elseif ($obj->getSpecies() == "RF") {
                        $color = $red;
                    }
                    if( $color != null ) {
                        imagefilledrectangle($this->rendering, $x, $y, $x + 1, $y + 1, $color);
                    }

                }
            }
        }
    }
}