<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 24/06/2015
 * Time: 17:27
 */

namespace CSV\Render;
use Zend\Console\Adapter\AdapterInterface as ConsoleAdapter ;
use Zend\Console\ColorInterface;

class ConsoleRender {

    protected  $console;
    protected  $csv;

    public function __construct( ConsoleAdapter $console){
        $this->console = $console;
    }

    public function viewCsv($viewArray){
        //Return di un array contentente i dati che mi servono per l'output
        foreach( $viewArray as $line ) {
            $this->firstCsvViewer($line);
        }

    }

    /**
     * Stampa del Csv secondo cio' che c'è dentro l'array
     * @param $viewArray
     */
    public function viewCsvNoDb($viewArray){
        //Return di un array contentente i dati che mi servono per l'output
        foreach( array_keys( $viewArray ) as $index=>$key ) {
            $nameC = $viewArray[$key];
            $codSt = $key;

            $format = "[%'06d]- Nome comune: %'12s";
            $this->console->writeLine(sprintf($format,$codSt,$nameC));
           }
//            $this->firstCsvViewer($line);

    }

    /**
     * Vecchio metodo per estrarre i dati dalla linea
     * @param $line array da dove estrarremo i dati
//     */
    private function firstCsvViewer($line){

        $nameC = $line['nameCom'];
        $codSt = $line['codIstat'];

        $format = "[%'06d]- Nome comune: %'12s";
        $this->console->writeLine(sprintf($format,$codSt,$nameC));

    }

    public function writeCsv($nameC , $codSt){

        $format = "[%'06d]- Nome comune: %'12s";
        $this->console->writeLine(sprintf($format,$codSt,$nameC));
    }



    public function compareCsv($array1,$array2){
        $format = "%' 25s : %'02f";
        $type = 'Tempo CallBack(s)';
        $this->console->writeLine(sprintf($format,$type, $array1['time']),$this->winnerColor($array1['time'],$array2['time']));

        $format = "%' 25s : %'02d";
        $type = 'Memory Usage Callback(KB)';
        $this->console->writeLine(sprintf($format,$type, $array1['memUs']),$this->winnerColor($array1['memUs'],$array2['memUs']));

        $format = "%' 25s : %'02d";
        $type = 'Line Per Second Callback';
        $this->console->writeLine(sprintf($format,$type, $array1['linePerSec']),$this->winnerColor($array2['linePerSec'],$array1['linePerSec']));


        $this->console->writeLine("");

        $format = "%' 25s : %'02f";
        $type = 'Tempo Normal(s)';
        $this->console->writeLine(sprintf($format,$type, $array2['time']),$this->winnerColor($array2['time'],$array1['time']));

        $format = "%' 25s : %'02d";
        $type = 'Memory Usage Normal(KB)';
        $this->console->writeLine(sprintf($format,$type, $array2['memUs']),$this->winnerColor($array2['memUs'],$array1['memUs']));

        $format = "%' 25s : %'02d";
        $type = 'Line Per Second Normal';
        $this->console->writeLine(sprintf($format,$type, $array2['linePerSec']),$this->winnerColor($array1['linePerSec'],$array2['linePerSec']));



        $this->console->writeLine("");
        $this->console->writeLine("");
    }


    /**
     * @param $array
     * Render della misurazione del tempo.
     */
    public function csvTimeStamp($array){
        $format = "%' 20s : %'02f";
        $type = 'Tempo (s)';
        $this->console->writeLine(sprintf($format,$type, $array['time']));

        $format = "%' 20s : %'02d";
        $type = 'Memory Usage(KB)';
        $this->console->writeLine(sprintf($format,$type, $array['memUs']));

        $format = "%' 20s : %'02d";
        $type = 'Line Per Second ';
        $this->console->writeLine(sprintf($format,$type, $array['linePerSec']));



        $this->console->writeLine("");
    }

    private function winnerColor($a , $b){
        if ($a < $b ){
            return ColorInterface::GREEN;
        }
        else{
            return ColorInterface::RED;
        }
    }

}