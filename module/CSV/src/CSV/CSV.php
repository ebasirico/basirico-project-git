<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 24/06/2015
 * Time: 16:40
 */

namespace CSV;


class CSV {
    protected  $file;
    protected  $path;
    protected  $csv;

    public function __construct($path){
        $this->path = $path;
    }

    public function getPath(){
        return $this->path;
    }

    public function setFile($file){
        $this->file = $file;
    }




}