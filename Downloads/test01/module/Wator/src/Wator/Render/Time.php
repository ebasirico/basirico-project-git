<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 16/06/2015
 * Time: 17:14
 */

namespace Wator\Render;

/**
 * Class Time
 * @package Wator\Render
 */
class Time {
        private $timeStart;
        private $timeEnd;

        public function __construct(){
            $this->time = 0;
        }

        public function startTimer(){
            $this->timeStart = microtime(true)*1000;

        }

        public function stopTimer(){
            $this->timeEnd = microtime(true)*1000;
        }

        public function getTime(){
            return $this->timeEnd - $this->timeStart;
        }
}