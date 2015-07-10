<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 24/06/2015
 * Time: 17:00
 */

namespace CSV\Imex;

use SplFileObject;

use CSV\CSV;

class Import {
    protected $csv;
    private $array;
    private $path;
    private $file;


    public function __construct( $path){
        $this->csv = new CSV($path);
        $this->path = $path;
    }

    /**
     * Preleva i dati dal CSV
     * @return array 'nomeCommune' , 'codIstat'
     */
    public function getArray(){
        $this->path = $this->csv->getPath();

        $this->file = new SplFileObject($this->path);

        $this->array = array();

        //Ciclo fino alla fine del file
        while (!$this->file->eof()) {
            //Prendo la linea
            $line = $this->file->fgetcsv(";");
            if ($line[0] != ''){
                $key = $line[Structure::CSV_ISTAT_CODE];

                $this->array[$key] = array(
                        'nameProv'=> $line[Structure::CSV_PROVINCE_NAME],
                        'codIstat'=> $line[Structure::CSV_ISTAT_CODE],
                        'nameCom' => $line[Structure::CSV_DISTRICT_NAME]

                );
            }


        }
        return $this->array;
    }


    /**
     * Vecchio viewArray senza rimozione dei duplicati
     * @return array
     */
    public function createArray(){
        $this->path = $this->csv->getPath();
        $this->file = new SplFileObject($this->path);

        $this->array= array();
        //Ciclo fino alla fine del file
        while (!$this->file->eof()) {
            $line = $this->file->fgetcsv(";");
            if ($line[0] != ''){
                $this->array[] = array(
                    'nameProv'=> $line[Structure::CSV_PROVINCE_NAME],
                    'codIstat'=> $line[Structure::CSV_ISTAT_CODE],
                    'nameCom' => $line[Structure::CSV_DISTRICT_NAME]
                );
            }
        }
        return $this->array;
    }


    /**
     * Preleva i dati dal CSV
     * @param callable $callback
     * Stampa del file Csv senza i duplicati
     */
    public function parseFileNoDouble( callable $callback ){
        $this->path = $this->csv->getPath();

        $this->file = new SplFileObject($this->path);
        $this->array = array();
        //Ciclo fino alla fine del file
        while (!$this->file->eof()) {
            //Prendo la linea
            $line = $this->file->fgetcsv(";");
            if ($line[0] != ''){
                    $key = $line[Structure::CSV_ISTAT_CODE];
                    //Controllo se la Key esiste
                    if(array_key_exists($key,$this->array) === false){
                        // Aggiungo la Key
                        $this->array[$key] = array(
                            'nameProv'=> $line[Structure::CSV_PROVINCE_NAME],
                            'codIstat'=> $key,
                            'nameCom' => $line[Structure::CSV_DISTRICT_NAME]
                        );

                    }
            }
        }
        call_user_func($callback,$this->array);
    }


    /**
     * Vecchio metodo senza la rimozione dei duplicati
     * @param callable $callback
     * @return array
     */
    public function parseFile( callable $callback ){
        $this->path = $this->csv->getPath();
        $this->array = array();
        $this->file = new SplFileObject($this->path);

        //Ciclo fino alla fine del file
        while (!$this->file->eof()) {
            //Prendo la linea
            $line = $this->file->fgetcsv(";");
            if ($line[0] != ''){
                //Estraggo i dati e li associo
                $this->array[] = array(
                    'nameProv'=> $line[Structure::CSV_PROVINCE_NAME],
                    'codIstat'=> $line[Structure::CSV_ISTAT_CODE],
                    'nameCom' => $line[Structure::CSV_DISTRICT_NAME]
                );
            }
        }

        call_user_func($callback,$this->array);
    }

    /**
     * Ritorna un Array senza doppioni
     * @param $viewArray
     * @return array
     */
    public function noDoubleArray($viewArray){
        $newArray = array();

        foreach($viewArray as $item){
            if($this->existInArray($newArray,$item) != true){
                $newArray[] = $item;
            }
        }
        return $newArray;
    }


    /**
     * @return bool
     * return true se il file esiste
     * return false se il file non esiste
     */
    public function fileExist(){
        return file_exists($this->path);
    }

    /**
     * Ricerca Item dentro array
     * @param $array
     * @param $item
     * @return true|false
     * true se esiste
     * false se non esiste
     */
    public function existInArray($array , $item){
        foreach($array as $element){
            if ($element === $item){
                return true;
            }
        }
        return false;
    }

    public function getLineSec($profiler){

        return array(
                'time' => $profiler['time'],
                'memUs'=> $profiler['memUs'],
                'linePerSec' => count($this->createArray())/$profiler['time'],
        );
    }


}