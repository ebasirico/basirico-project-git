<?php
/**
 * Created by PhpStorm.
 * User: Sirio
 * Date: 02/07/15
 * Time: 16:58
 */

namespace CSV\Imex;


class TestQuickSort
{

    public function __construct()
    {

    }

    public function quickSortStart()
    {
        $array = array(3,2,5,6,8,1,0,9,7,8);
        print_r($this->sortArray($array));
    }

    private function sortArray($array)
    {
//
//        if( count( $array ) < 2 ) {
//            return $array;
//        }
//
//        $left = array();
//        $right = array();
//        reset( $array );
//
//        $pivot_key  = key( $array );
//
//        $pivot = array_shift($array);
//
//        foreach( $array as $k => $v){
//            if($v < $pivot){
//                $left[$k] = $v;
//            }
//            else{
//                $right[$k] = $v;
//            }
//        }
//
//        return array_merge($this->sortArray($left),array($pivot_key=> $pivot),$this->sortArray($right));
//
//
        if( count( $array ) < 2 ) {
            return $array;
        }

        $left = array();
        $right = array();

        reset( $array );

        $pivot_key  = key( $array );

        $pivot = array_shift($array);

        foreach( $array as $k => $v){

            if($v < $pivot){
                $left[$k] = $v;
            }
            else{
                $right[$k] = $v;
            }
        }

        echo "LEFT ";
        var_dump($left);

        echo "RIGHT ";
        var_dump($right);

        return array_merge($this->sortArray($left),array($pivot_key => $pivot),$this->sortArray($right));

    }

}