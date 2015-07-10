<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 30/06/2015
 * Time: 17:05
 */

namespace CSV\Render;



class FileRender {
    private $file;
    public function __construct($path){
        $file = fopen($path,"w");
        fclose($file);
        $this->file = fopen($path,"a");
    }


    public function fileArrayWriter($array){
//        foreach($array as $item){
//            $newLine[] = array(
//                'nameProv' => $item['nameProv'],
//                'codIstat' => $item['codIstat'],
//                'nameCom'  => $item['nameCom']
//            );

//            $newLine[]=$item['nameProv'];
//            $newLine[]=$item['codIstat'];
//            $newLine[]=$item['nameCom'];

       $this->printCsvFile($this->quickSort($array));

    }


    /**
     * Vecchio metodo senza Sort
     * @param $codIst
     * @param $nameProv
     * @param $nameCom
     */
    public function fileParamWriter($codIst,$nameProv,$nameCom){
        $newLine[$codIst] = array(
            'nameProv' => $nameProv,
            'codIstat' => $codIst,
            'nameCom'  => $nameCom
        );
    }

    /**
     * Controllo dell'array
     * @param $array
     */
    public function fileArrayNoDbWriter($array){
        $newLine = array();
        foreach(array_keys( $array ) as $index=>$key ){
            $newLine[$key] = array(
                    'nameProv' => $array[$key]['nameProv'],
                    'codIstat' => $key,
                    'nameCom'  => $array[$key]['nameCom']
            );
        }

        $this->sortArray($newLine);

    }

    /**
     * Sort e Scrittura su File
     * @param $array
     */
    public function sortArray($array){
       //Ordinamento Array
        
        $this->printCsvFile($this->quickSort($array));
//        usort($array, function($a , $b){
//            //Province Uguali
//            if (strcmp($a['nameProv'] , $b['nameProv']) == 0 ){
//                //Comune prima
//                return strcmp($b['nameCom'],$a['nameCom']);
//            }
//
//            //Provincia prima
//            return strcmp($a['nameProv'],$b['nameProv']);
//        });
//
//        return $array;
    }

    public function oldSortArray($array){
                usort($array, function($a , $b){
            //Province Uguali
            if (strcmp($a['nameProv'] , $b['nameProv']) == 0 ){
                //Comune prima
                return strcmp($b['nameCom'],$a['nameCom']);
            }

            //Provincia prima
            return strcmp($a['nameProv'],$b['nameProv']);
        });

        $this->printCsvFile($array);
    }

    private function quickSort($array)
    {

        if( count( $array ) < 2 ) {
            return $array;
        }

        $left = array();
        $right = array();

        reset( $array );

        $pivot_key  = key( $array );

        $pivot = array_shift($array);

        foreach( $array as $k => $v){

            if(strcmp($v['nameProv'],$pivot['nameProv']) == 0){
                    if(strcmp($v['nameCom'],$pivot['nameCom']) < 1){
                        $right[$k] = $v;
                    }
                    else{
                        $left[$k] = $v;
                    }
            }
            else if (strcmp($v['nameProv'],$pivot['nameProv']) > 1 ){
                $right[$k] = $v;

            }
            elseif(strcmp($v['nameProv'],$pivot['nameProv']) < 1){
                $left[$k] = $v;
            }
            else{
                $right[$k] = $v;
            }
        }

        return array_merge($this->quickSort($left),array($pivot_key => $pivot),$this->quickSort($right));



    }

    private function printCsvFile($array){
        foreach(array_keys( $array ) as $index=>$key ){
            fputcsv($this->file,$array[$key],";");
        }
    }





    private function qsort($array)
    {
        $stack = array($array);

        $sorted = array();

        while (count($stack) > 0) {

            $temp = array_pop($stack);

            if (count($temp) == 1) {
                $sorted[] = $temp[0];
                continue;
            }

            $pivot = $temp[0];
            $left = $right = array();

            for ($i = 1; $i < count($temp); $i++) {
                if ($pivot > $temp[$i]) {
                    $left[] = $temp[$i];
                } else {
                    $right[] = $temp[$i];
                }
            }

            $left[] = $pivot;

            if (count($right))
                array_push($stack, $right);
            if (count($left))
                array_push($stack, $left);
        }

        return $sorted;
    }


}