<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 11/06/2015
 * Time: 11:56
 */

namespace Wator\World;
use Wator\Fish\FishInterface;
use Wator\World\Map\Matrix;
use Zend\View\Helper\PaginationControl;


/**
 * Class World
 * @package Wator
 *
 */
class WorldMap {
    const OCEAN = null ;

    public $population;
    /**
     * @var Matrix
     */
    protected $matrix;

    function __construct($width, $height)
    {
        $this->matrix = new Matrix($width,$height);
        $this->population = array();
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->matrix->getWidth();
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->matrix->getHeight();
    }




    /**
     * @return array mappa intera del mondo con le posizioni
     */
    public function getMap(){
        return $this->matrix->getMatrix();
    }

    /**
     * Inserimento vicino ad un pesce Padre.
     * @param FishInterface $fish
     * @param FishInterface $son
     * @return false|FishInterface
     *
     */
    public function addNearFather(FishInterface $fish , FishInterface $son ){
        $pos = $this->matrix->search($fish);
        $newPos = $this->getNearFreePosition($pos);
            if ($newPos instanceof Position  ){
                $this->add($son,$this->getNearFreePosition($newPos));
            }

        }

    /**
     * Aggiunta del pesce nella mappa
     * @param FishInterface $fish
     * @param Position $pos|null
     * @return FishInterface
     */
    public function add( FishInterface $fish , Position $pos=null){

        if ($pos == null){
            $pos = $this->getFreeRandomPosition();
            if( $pos == null ) {
                $this->copyArrayWithoutFish($fish);
            }
        }

        $this->matrix->put($fish,$pos);
        $this->population[] = $fish ;
        return $fish ;
    }


    /**
     *
     * Movimento del pesce se possibile altrimenti restituisco chi mi blocca
     * @param FishInterface $fish
     * @param Movement $move
     * @return true|FishInterface
     *
     */
    public function move( FishInterface $fish, Movement $move) {

            $pos = $this->matrix->search($fish);
            if ($pos == null ){
               $this->copyArrayWithoutFish($fish);
                return null;
            }

            $dest = $pos->calculateNewPoint($move);
                if( $this->isFreePosition($dest) ) {
                    $this->matrix->put($fish,$dest);
                    $this->matrix->put(self::OCEAN,$pos);
                    return true;
                }
                else{
                    return $this->matrix->get($dest);
                }




    }



    public function getFishList(){
        return $this->population;
    }

    /**
     * Ricerca di posizione libera
     * @return null|Position
     */
    public function getFreeRandomPosition(){

        $w= $this->getWidth();
        $h= $this->getHeight();

        $i = 0 ;
        $pos = new Position(rand(0,$w-1),rand(0,$h-1));
        $pos = $this->getNearFreePosition($pos);

        while ($pos === null AND $i<50 ) {
            $i++;
            $pos = new Position(rand(0,$w-1),rand(0,$h-1));
            $pos = $this->getNearFreePosition($pos);
        }
        return new Position($pos->getX() , $pos->getY());
    }

    /**
     *
     * @param Position $pos
     *
     * @return boolean  True se la posizione indicata è libera
     */
    protected function isFreePosition(Position $pos){

        return ($this->matrix->get($pos) === self::OCEAN );
    }

    /**
     * Restituisce una posizione libera (se disponibile) nei dintorni
     *
     * @param Position $position
     * @return null|Position Null
     *
     * @internal param FishInterface $fish
     */


    public function getNearFreePosition( Position $position ){
        $pos = new Position($position->getX(),$position->getY());
        $x = $pos->getX() -1 ;
        $y = $pos->getY() -1 ;

        for($i=0; $i<3 ; $i++){
            $pos->setX($x + $i);

            for($j=0; $j<3; $j++){
                $pos->setY($y+$j);
                if( $this->isFreePosition($pos) == true ){
                    return new Position($pos->getX(),$pos->getY());
                }
            }
        }

        return null;
    }

    /**
     * Eliminazione elemento da Matrice
     * @param FishInterface $fish
     * @return null
     */
    public function delete(FishInterface $fish){
        $pos = $this->matrix->search($fish);
        if ($pos ==null){return null;}
        $this->population = $this->copyArrayWithoutFish($fish);
        $this->matrix->put(self::OCEAN,$pos);
    }

    /**
     * Eliminazione elemento dall'array
     * @param FishInterface $fish
     * @return array
     */
    protected  function copyArrayWithoutFish(FishInterface $fish){
        $count = count($this->population);
        $newList = array();
        for ($i = 0; $i < $count; $i++) {
            if ($this->population[$i] !== $fish){
                $newList[] = $this->population[$i];
            }
        }
        return $newList;
    }

}