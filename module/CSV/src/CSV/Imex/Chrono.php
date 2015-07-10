<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 25/06/2015
 * Time: 17:51
 */

namespace CSV\Imex;


class Chrono {
    public function profiler(callable $callback){
        $start  = microtime(true);
        $memStart = (memory_get_peak_usage()/1024);
        call_user_func($callback);
        $memStop = (memory_get_peak_usage()/1024);
        $end    = microtime(true);

        return array(
            'time' =>  $end - $start,
            'memUs'=>  $memStop - $memStart  ,

        );
    }

}