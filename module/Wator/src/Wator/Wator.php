<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 11/06/2015
 * Time: 11:41
 */

namespace Wator;
use Wator\Fate\Life;



/**
 * Gestore unico di tutto il mondo di wator
 */
class Wator {
    protected $life;
    protected $world;
    protected $chronons;

    /**
     * Creazione del mondo Wator
     * @param $width
     * @param $height
     */
    public function  __construct($width,$height){
        $this->life = new Life();
        $this->world = $this->life->startEden($width,$height);
        $this->chronons = 0;

    }

    /**
     * @return array mappa del mondo
     */
    public function getWorldMap() {
        return $this->world->getMap();

    }

    /**
     * @return integer worldWidth
     */
    public function getWorldMapWidth() {
        return $this->world->getWidth();
    }
    /**
     * @return integer worldHeight
     */
    public function getWorldMapHeight() {
        return $this->world->getHeight();
    }

    /**
     * Aggiornamento del mondo tramite Life.
     */
    public function updateWorld(){
        $this->chronons++;
        $this->life->moveAllFish();
        $this->life->decreaseAllHealth();
    }
    public function getChronons(){
        return $this->chronons;
    }

    /**
     * @param $chronon integer permette il Set dei Chronon
     */
}