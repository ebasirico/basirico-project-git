<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 24/06/2015
 * Time: 16:24
 */

namespace CSV;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleBannerProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\Console\Adapter\AdapterInterface as Console;

class Module implements  ConsoleBannerProviderInterface,ConsoleUsageProviderInterface,AutoloaderProviderInterface, ConfigProviderInterface{


    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getConsoleBanner(Console $console){

        return "CSV Module 1.0.0";
    }

    public function getConsoleUsage(Console $console)
    {
        return array(
            // Describe available commands
            'csv import path to newpath'    => 'Visualizzazione di un file CSV ed Esportazione.' ,

            array( 'path',     '(required) inserire path file csv.'),
            array( 'newpath',     '(required) inserire path nuovo file csv.'),

            'csv import cb path to newpath' => 'Visualizzazione di un file CSV ed Esportazione. ',

            array( 'path',     '(required) inserire path file csv.'),
            array( 'newpath',     '(required) inserire path nuovo file csv.'),

            'csv import compare path to newpath'    => 'Comparazione tra il primo e secondo metodo sull esportazione di un  file CSV .' ,

            array( 'path',     '(required) inserire path file csv.'),
            array( 'newpath',     '(required) inserire path nuovo file csv.'),



            'csv import nodup path to new newpath'    => 'Visualizzazione di un file CSV senza duplicati ed Esportazione.' ,

            array( 'path',     '(required) inserire path file csv.'),
            array( 'newpath',     '(required) inserire path nuovo file csv.'),

            'csv import cb nodup path to new file path' => 'Visualizzazione di un file CSV senza duplicati ed Esportazione.  ',

            array( 'path',     '(required) inserire path file csv.'),
            array( 'newpath',     '(required) inserire path nuovo file csv.'),

            'csv import compare nodup path to newpath'    => 'Comparazione tra il primo e secondo metodo sull esportazione di un  file CSV  senza duplicati  .' ,

            array( 'path',     '(required) inserire path file csv.'),
            array( 'newpath',     '(required) inserire path nuovo file csv.'),


        );
    }

}