<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 11/06/2015
 * Time: 16:24
 */

namespace Wator\Fate;


use Wator\Fish\FishInterface;
use Wator\Fish\FoodInterface;
use Wator\Fish\PredatorInterface;
use Wator\Fish\RedFish;
use Wator\Fish\Shark;
use Wator\World\MovableInterface;
use Wator\World\WorldMap;

class Life
{

    const EDEN_SHARK_FACTOR = 0.02;
    const EDEN_RED_FISH_FACTOR = 0.15;

    /**
     * @var WorldMap
     */
    protected $worldMap;
    /**
     * @param $width
     * @param $height
     *
     * @return WorldMap
     */


    /**
     * Creazione della popolazione di Wator.
     * @param $width
     * @param $height
     * @return WorldMap
     */
    public function startEden($width, $height)
    {
        $this->worldMap = new WorldMap($width, $height);

        $this->populateRedFish();
        $this->populateSharks();

        return $this->worldMap;
    }

    /**
     * Aggiunta degli Squali.
     */

    protected function populateSharks()
    {

        $size = $this->worldMap->getHeight() * $this->worldMap->getWidth();
        $num = $size * self::EDEN_SHARK_FACTOR;
        for ($i = 0; $i < $num; $i++) {
            $this->worldMap->add(new Shark());
        }

    }

    /**
     * Aggiunta Pesci Rossi.
     */
    protected function populateRedFish()
    {
        $size = $this->worldMap->getHeight() * $this->worldMap->getWidth();
        $num = $size * self::EDEN_RED_FISH_FACTOR;
        for ($i = 0; $i < $num; $i++) {
            $this->worldMap->add(new RedFish());
        }

    }

    /**
     * Aggiunta dei figli vicini al Padre.
     * @param FishInterface $father
     * @param array $sons
     */

    public function breeding(FishInterface $father, array $sons)
    {
        foreach ($sons as $son) {
            if ($son instanceof FishInterface) {
                $this->worldMap->addNearFather($father, $son);
            }
        }
    }

    /**
     * Funzione di Movimento di tutti i pesci . Con Gestione Cibo.
     */
    public function moveAllFish()
    {
        $items = $this->worldMap->getFishList();
        foreach ($items as $fish) {

            if ($fish instanceof MovableInterface) {
                $mov = $fish->getMovement();
                $res = $this->worldMap->move($fish, $mov);
                if ($res !== true) {
                    if ($fish instanceof PredatorInterface AND $res instanceof FoodInterface) {
                        $fish->eat($res);
                        $dead = new Dead($this->worldMap);
                        $dead->kill($res);
                    }
                }
            }

        }
    }

    /**
     * Controlla se il pesce puo' avere figli
     * Controlla se la sua vita e' uguale a 0 se lo e' il pesce muore .
     */
    public function decreaseAllHealth()
    {
        $items = $this->worldMap->getFishList();

        $lun = count($items);

        for ($i = 0; $i < $lun; $i++) {
            $fish = $items[$i];
            if ($fish instanceof FishInterface) {
                $fish->setHealth($fish->getHealth() - 1);

                $sons = $fish->getChildren();

                if (!empty($sons)) {
                    $this->breeding($fish, $sons);
                }
                if ($fish->getHealth() == 0) {
                    $dead = new Dead($this->worldMap);
                    $dead->kill($fish);
                }
            }

        }

    }


}