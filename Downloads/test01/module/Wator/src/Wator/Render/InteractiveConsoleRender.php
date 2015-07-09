<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 17/06/2015
 * Time: 16:01
 */

namespace Wator\Render;


use Wator\Fish\FishInterface;
use Zend\Console\Adapter\AdapterInterface as ConsoleAdapter ;
use Wator\Wator;

class InteractiveConsoleRender extends Render implements RenderInterface{

    protected  $rendering;
    protected  $console;
    protected  $wator;
    private $chronons;

    public function getTime()
    {
        return $this->time->getTime();
    }

    /**
     * Costruzione del Box per Monitor.
     * @param Wator $wator
     * @param ConsoleAdapter $adapter
     */
    public function __construct(Wator $wator , ConsoleAdapter $adapter)
    {
        $this->setRender($wator);
        $this->time = new Time();
        $this->console = $adapter;
        $this->console->clearScreen();
        $this->console->writeBox(2,2,38,11);

    }

    /**
     * Setting di Wator e Update della Console .
     * @param $chronons
     * @param Wator $wator
     */
    public function getConsoleWrite($chronons, Wator $wator){
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
        $memory = array();
        $redFish = 0;
        $shark = 0;
        $fish = 0;

        $start = microtime(true)*1000;
        for ($x = 0; $x < $this->getW(); $x++) {
            for ($y = 0; $y < $this->getH(); $y++) {
                $obj = $map[$x][$y];
                if ($obj instanceof FishInterface) {
                    $fish +=1;
                    if ($obj->getSpecies() == "S") {
                        $shark += 1;
                    } elseif ($obj->getSpecies() == "RF") {
                        $redFish += 1;

                    }
                }
            }
            $memory[] = memory_get_usage();
        }
        $peakMemory = memory_get_peak_usage();

        $peakMemory = $peakMemory/1024;

        $this->time->stopTimer();

        $time = $this->time->getTime();

        $updateTime = $time/$fish ;



        $type = 'Cronoma';
        $format = "%20s : %' 10d";
        $this->console->writeAt(sprintf($format, $type, $this->chronons), 3, 3);
        $type = 'Shark';
        $this->console->writeAt(sprintf($format, $type, $shark), 3, 4);
        $type = 'Red Fish';
        $this->console->writeAt(sprintf($format, $type, $redFish), 3, 5);
        $type = 'Total Fish';
        $this->console->writeAt(sprintf($format, $type, $fish), 3, 6);
        $type = 'Peak Memory (KB)';
        $this->console->writeAt(sprintf($format, $type, $peakMemory), 3, 7);
        $this->getMemory($memory);
        $type = 'Render Pesce';
        $format = "%20s : %' 10f";
        $this->console->writeAt(sprintf($format,$type,$updateTime),3,9);

        $this->console->writeLine("");
        $this->console->writeLine("");
        $this->console->writeLine("");
        $this->console->writeLine("");


    }

    /**
     * Stampa la memoria che viene utilizzata ogni
     * volta che viene controllato un pesce nella mappa .
     * @param array $memory
     */

    public function getMemory(array $memory){
        $type = 'Current Memory (KB)';
        $format = "%20s : %' 10d";
       for($i=0; $i< count($memory) ; $i++){
           $this->console->writeAt(sprintf($format, $type,$memory[$i]/1024), 3, 8);
       }
    }



}