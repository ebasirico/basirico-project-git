<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 11/06/2015
 * Time: 16:25
 */

namespace Wator\Fate;


use Wator\Fish\FishInterface;
use Wator\Fish\PredatorInterface;
use Wator\World\Map\Matrix;
use Wator\World\WorldMap;

class Dead {
    protected  $worldMap;

    /**
     * Aggiornamento Mappa
     * @param WorldMap $worldMap
     */
    public function __construct(WorldMap $worldMap){
        $this->worldMap = $worldMap;
    }

    /**
     * Distruzione Mondo Wator.
     * @param Matrix $matrix
     *
     */


    public function startNuke(Matrix $matrix){

        $w = $matrix->getWidth();
        $h = $matrix->getHeight();

        $matrix = new Matrix($w,$h);

    }

    /**
     * Eliminazione Oggetto dalla Matrice.
     * @param FishInterface $fish
     */
    public function kill(FishInterface $fish){
           $this->worldMap->delete($fish);
    }


}