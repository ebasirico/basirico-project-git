<?php
/**
 * Created by PhpStorm.
 * User: Ivano Pomatto <i.pomatto@visiotrade.it>
 * Date: 19/06/2015
 * Time: 23:44
 */

namespace Wator\HS;


use Wator\Fish\FishInterface;
use Wator\Fish\FoodInterface;
use Wator\Fish\PredatorInterface;
use Wator\Fish\RedFish;
use Wator\Fish\Shark;
use Wator\World\Map\Matrix;
use Wator\World\MovableInterface;
use Wator\World\Movement;
use Wator\World\Position;

class LifeHS {


    const EDEN_SHARK_FACTOR = 0.05 ;
    const EDEN_RED_FISH_FACTOR = 0.10 ;

    /**
     * @var Matrix
     */
    protected $worldMap;

    /**
     * Popola il mondo di wator.
     *
     * @param $width
     * @param $height
     *
     * @return Matrix
     */
    public function startEden($width, $height)
    {
        $this->worldMap = new Matrix($width,$height);
        $fishFactor = (self::EDEN_RED_FISH_FACTOR + self::EDEN_SHARK_FACTOR);
        $fishProc =  $fishFactor * 1000.0 ;
        $sharkProc = 1000.0 / $fishFactor * self::EDEN_SHARK_FACTOR;
        foreach( $this->worldMap->getMatrix() as $x => $rows ) {
            foreach( $rows as $y => $cell ) {
                $proc = rand(0,1000) ;
                if( $proc < $fishProc ) {
                    if( rand(0,1000) <= $sharkProc ) {
                        $this->worldMap->put(new Shark(),new Position($x,$y) );
                    }else {
                        $this->worldMap->put(new RedFish(),new Position($x,$y) );
                    }
                }
            }
        }
        return $this->worldMap ;
    }


    /**
     * Inserito per compatibilità
     */
    public function decreaseAllHealth() {

    }

    /**
     * @param MovableInterface $fish
     * @param Position         $current
     *
     * @return Position
     */
    protected function moveFish( MovableInterface $fish, Position $current ) {
        $mov = $fish->getMovement();
        $next = $current->calculateNewPoint($mov);
        $destination = $this->worldMap->get($next);
        if( $destination === null ) {
            // Destinazione vuota: mi sposto
            $this->worldMap->put($fish,$next);
            $this->worldMap->put(null,$current);
            $current = $next ;
        } else {
            // Destinazione occupata: se posso mangio
            if ($fish instanceof PredatorInterface AND $destination instanceof FoodInterface){
                $fish->eat($destination);
                $this->worldMap->put($fish,$next);
                $this->worldMap->put(null,$current);
                $current = $next ;
                unset( $destination );
            }
        }
        return $current ;
    }


    /**
     * Faccio passare il tempo per il pesce
     *
     * @param FishInterface $fish
     * @param Position      $current
     */
    protected function aging( FishInterface $fish, Position $current ){
        $fish->setHealth($fish->getHealth() - 1);
        $sons = $fish->getChildren();

        // la vita è zero: muore
        if ($fish->getHealth() == 0) {
            $this->worldMap->put(null,$current);
            unset($fish);
        }

        // se ci sono dei figli: gli aggiungo alla mappa
        foreach( $sons as $son ) {
            $sonPos = $this->getFreePosition($current);
            if( $sonPos !== null ) {
                $this->worldMap->put($son,$sonPos);
            }
        }
    }

    /**
     * Sono state accorpate qui tutte le funzioni per una gestione più efficiente
     */
    public function moveAllFish(){
        $matrix = $this->worldMap->getMatrix();
        foreach( $matrix as $x => $rows ) {
            foreach( $rows as $y => $fish ) {
                $current = new Position($x,$y);
                // Gestisco il Movimento
                if ($fish instanceof MovableInterface){
                    $current = $this->moveFish($fish,$current);
                }
                // Gestisco la vita
                if ($fish instanceof FishInterface) {
                    $this->aging($fish,$current);
                }
            }
        }
    }

    /**
     * Restituisco una posizione libera nei dintorni
     *
     * @param Position $position
     *
     * @return null|Position null se non vi sono posti liberi
     *
     *
     */
    public function getFreePosition( Position $position ) {
        $map = $this->worldMap;
        if( $map->get($position) === null ) {
            return $position;
        }
        $move = new Movement();
        foreach( $move->getDirections() as $direction ) {
            $move->setDirection($direction);
            $destination = $position->calculateNewPoint($move);
            if( $map->get($destination) === null ) {
                return $destination;
            }
        }
        return null ;
    }

}