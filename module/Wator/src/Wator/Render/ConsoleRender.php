<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 17/06/2015
 * Time: 16:01
 */

namespace Wator\Render;


use Wator\Fish\FishInterface;
use Wator\Wator;
use Zend\Console\Adapter\AdapterInterface as ConsoleAdapter;

class ConsoleRender extends Render implements RenderInterface
{

    protected $rendering;
    protected $console;
    protected $wator;
    private $chronons;

    public function getTime()
    {
        return $this->time->getTime();
    }

    /**
     * @param Wator $wator
     * @param ConsoleAdapter $adapter
     */
    public function __construct(Wator $wator, ConsoleAdapter $adapter)
    {
        $this->setRender($wator);
        $this->time = new Time();
        $this->console = $adapter;
        $this->console->clearScreen();
    }

    /**
     * Avvio rendering e updating di Wator.
     * @param $chronons
     * @param Wator $wator
     */
    public function getConsoleWrite($chronons, Wator $wator)
    {
        $this->chronons = $chronons;
        $this->setWator($wator);
        $this->updateMap();
        $this->renderWorld();

    }

    /**
     * Rendering del mondo con mappa aggiornata.
     */

    private function renderWorld()
    {
        $map = $this->getMap();

        $redFish = 0;
        $shark = 0;
        $fish = 0;

        $this->time->startTimer();

        for ($x = 0; $x < $this->getW(); $x++) {
            for ($y = 0; $y < $this->getH(); $y++) {
                $obj = $map[$x][$y];
                if ($obj instanceof FishInterface) {
                    $fish += 1;
                    if ($obj->getSpecies() === "S") {
                        $shark += 1;
                    } elseif ($obj->getSpecies() === "RF") {
                        $redFish += 1;

                    }
                }
            }
        }

        $this->time->stopTimer();

        $time = $this->time->getTime();

        $updateTime = $time / $fish;

        $format = "[%' 05d]:%' 11s %' 10d";
        $type = 'Pesci rossi';
        $this->console->writeLine(sprintf($format, $this->chronons, $type, $redFish));
        $type = 'Squali';
        $this->console->writeLine(sprintf($format, $this->chronons, $type, $shark));
        $type = 'Render Pesce';
        $format = "[%'.05d]:%'. 11s %' 10f";
        $this->console->writeLine(sprintf($format, $this->chronons, $type, $updateTime));


    }
}