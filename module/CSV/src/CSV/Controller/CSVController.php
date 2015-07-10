<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 24/06/2015
 * Time: 16:34
 */

namespace CSV\Controller;

use CSV\Imex\Chrono;
use CSV\Imex\Import;
use CSV\Imex\TestQuickSort;
use CSV\Render\ConsoleRender;
use CSV\Render\FileRender;
use Zend\Mvc\Controller\AbstractConsoleController;

class CSVController extends AbstractConsoleController{

    public function arrayImportAction(){

        $console = $this->getConsole();

        $path  = $this->params()->fromRoute('p');

        $newPath = $this->params()->fromRoute('newp');

        $import = new Import($path);

        $file = $import->fileExist();

        if ($file == true){
            $fileRender = new FileRender($newPath);
            $test = new Chrono();
            $array = $test->profiler(
                function()use($import,$fileRender){
                    $viewArray = $import->createArray();
                    $fileRender->sortArray($viewArray);
//                    $fileRender->oldSortArray($viewArray);

                }
            );
            $array  = $import->getLineSec($array);
            $render = new ConsoleRender($console);
            $render->csvTimeStamp($array);


        }
        else {

            $console->writeLine("ERRORE FILE NON ESISTENTE ! ");
        }


    }


    public function callbackImportAction(){
        $console = $this->getConsole();

        $path  = $this->params()->fromRoute('p');
        $newPath = $this->params()->fromRoute('newp');


        $import = new Import($path);
        $file = $import->fileExist();
        $render = new ConsoleRender($console);
        $fileRender = new FileRender($newPath);

        if ($file == true){
            $test= new Chrono();
            $array = $test->profiler(
                function()use($import,$fileRender){
                    $import->parseFile(
                      function($viewArray)use($fileRender){
                            $fileRender->sortArray($viewArray);
                        });
                }
            );
            $array  = $import->getLineSec($array);
            $render->csvTimeStamp($array);

        }
        else {
            $console->writeLine("ERRORE FILE NON ESISTENTE ! ");
        }

    }

    public function compareImportAction(){
        $console = $this->getConsole();

        $path  = $this->params()->fromRoute('p');
        $newPath = $this->params()->fromRoute('newp');


        $import = new Import($path);
        $file = $import->fileExist();

        $render = new ConsoleRender($console);
        $fileRender = new FileRender($newPath);

        $console->writeLine("");

        if($file == true) {
            $test1= new Chrono();

             $array1 = $test1->profiler(
                function()use($import,$fileRender){
//                    $import->parseFile(
//                        function($codSt,$nameC,$nameProv)use($fileRender){
//                            $fileRender->fileParamWriter($codSt,$nameProv,$nameC);
//                        });
                    $import->parseFile(
                        function($viewArray)use($fileRender){
                            $fileRender->sortArray($viewArray);
                        });
                }
            );

            $import = new Import($path);
            $test2 = new Chrono();
            $fileRender = new FileRender($newPath);

            $array2 = $test2->profiler(

                function()use($import,$fileRender){
                    $viewArray = $import->createArray();
//                    $fileRender->fileArrayWriter($viewArray);
                    $fileRender->sortArray($viewArray);
                }
            );


            $array1  =$import->getLineSec($array1);
            $array2  =$import->getLineSec($array2);
            $render->compareCsv($array1,$array2);

        }
    }

    public function arrayNoDupImportAction(){

        $console = $this->getConsole();

        $path  = $this->params()->fromRoute('p');
        $newPath = $this->params()->fromRoute('newp');

        $import = new Import($path);
        $file = $import->fileExist();
        $render = new ConsoleRender($console);
        $fileRender = new FileRender($newPath);

        if ($file == true){

            $test = new Chrono();
            $console->clearScreen();
            $array = $test->profiler(
                function()use($import,$fileRender){
                    $viewArray = $import->getArray();
                    $fileRender->sortArray($viewArray);
                }
            );
            $array  = $import->getLineSec($array);
            $render->csvTimeStamp($array);


        }
        else {

            $console->writeLine("ERRORE FILE NON ESISTENTE ! ");
        }

    }

    public function callbackNoDupImportAction(){

        $console = $this->getConsole();

        $path  = $this->params()->fromRoute('p');
        $newPath = $this->params()->fromRoute('newp');

        $import = new Import($path);
        $file = $import->fileExist();

        $render = new ConsoleRender($console);
        $fileRender = new FileRender($newPath);

        $console->writeLine("");

        if($file == true) {
            $time = new Chrono();

            $array = $time->profiler(
                function () use ($import, $fileRender) {
                    $import->parseFileNoDouble(
                        function($viewArray)use($fileRender) {
                            //$fileRender->fileParamWriter(key($viewArray),$viewArray[key($viewArray)]['nameProv'],$viewArray[key($viewArray)]['nameCom']);
                            $fileRender->sortArray($viewArray);
                        });
                }
            );
            $array  = $import->getLineSec($array);
            $render->csvTimeStamp($array);

        }
    }

    public function compareNoDupImportAction()
    {

        $console = $this->getConsole();

        $path = $this->params()->fromRoute('p');
        $newPath = $this->params()->fromRoute('newp');

        $import = new Import($path);
        $file = $import->fileExist();

        $render = new ConsoleRender($console);
        $fileRender = new FileRender($newPath);
        $console->writeLine("");

        if ($file == true) {
            $test1 = new Chrono();

            $array1 = $test1->profiler(
                function () use ($import, $fileRender) {
                    $import->parseFileNoDouble(
                        function ($viewArray) use ($fileRender) {
//                            $fileRender->fileParamWriter(key($viewArray),$viewArray[key($viewArray)]['nameProv'],$viewArray[key($viewArray)]['nameCom']);
                            $fileRender->sortArray($viewArray);
                        });
                }
            );

            $import = new Import($path);
            $test2 = new Chrono();
            $fileRender = new FileRender($newPath);

            $array2 = $test2->profiler(
                function () use ($import, $fileRender) {
                    $viewArray = $import->getArray();
                    $fileRender->sortArray($viewArray);
                }
            );


            $array1 = $import->getLineSec($array1);
            $array2 = $import->getLineSec($array2);
            $render->compareCsv($array1, $array2);

        }
    }

    public function quickSortTestAction(){

        $quick = new TestQuickSort();
        $quick->quickSortStart();
    }


}