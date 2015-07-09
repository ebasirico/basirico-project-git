<?php
/**
 * Created by PhpStorm.
 * User: Ivano Pomatto <i.pomatto@visiotrade.it>
 * Date: 19/06/2015
 * Time: 23:08
 */

namespace Wator\Render;


use Wator\Fish\RedFish;
use Wator\Fish\Shark;
use Wator\Wator;
use Zend\Console\Adapter\AdapterInterface as ConsoleAdapter;

class MonitorConsoleRender
{


    private $console;
    private $wator;
    private $sharkCounter = 0;
    private $redFishCounter = 0;
    private $updateTime = 0;

    function __construct(Wator $wator, ConsoleAdapter $console)
    {
        $this->console = $console;
        $this->wator = $wator;
    }


    public function render()
    {

        $start = microtime(true) * 1000;
        $this->wator->updateWorld();
        $end = microtime(true) * 1000;
        $this->updateTime = round($end - $start, 2);

        $map = $this->wator->getWorldMap();
        $shark = 0;
        $redFish = 0;
        foreach ($map as $row) {
            foreach ($row as $cell) {
                if ($cell !== null) {
                    if ($cell instanceof Shark) {
                        $shark++;
                    } elseif ($cell instanceof RedFish) {
                        $redFish++;
                    }
                }
            }
        }
        $this->sharkCounter = $shark;
        $this->redFishCounter = $redFish;
    }

    public function consoleUpdate()
    {

        $x = 2;
        $y = 2;
        $console = $this->console;
        $console->clearScreen();
        $console->writeBox($x, $y, $x + 38, $y + 11);

        $memory = memory_get_usage(true);
        $fishTime = $this->updateTime / ($this->sharkCounter + $this->redFishCounter);

        $console->writeAt(
            sprintf("%20s : %' 10d", 'CHRONONOS', $this->wator->getChronons()),
            $x + 1,
            $y + 2
        );

        $console->writeAt(
            sprintf("%20s : %' 10d", 'Shark', $this->sharkCounter),
            $x + 1,
            $y + 4
        );
        $console->writeAt(
            sprintf("%20s : %' 10d", 'RedFish', $this->redFishCounter),
            $x + 1,
            $y + 5
        );
        $console->writeAt(
            sprintf("%20s : %' 10d", 'Total', $this->sharkCounter + $this->redFishCounter),
            $x + 1,
            $y + 6
        );
        $console->writeAt(
            sprintf("%20s : %' 10d", 'Update Time (ms)', $this->updateTime),
            $x + 1,
            $y + 8
        );
        $console->writeAt(
            sprintf("%20s : %' 10f", 'Time/Fish (ms)', $fishTime),
            $x + 1,
            $y + 9
        );
        $console->writeAt(
            sprintf("%20s : %' 10f", 'Memory (MB)', $memory / 1024 / 1024),
            $x + 1,
            $y + 10
        );
    }
}