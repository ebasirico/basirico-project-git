<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 10/06/2015
 * Time: 10:54
 */

namespace Wator;

use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleBannerProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;

class Module implements ConsoleBannerProviderInterface, ConsoleUsageProviderInterface, AutoloaderProviderInterface, ConfigProviderInterface
{

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

    public function getConsoleBanner(Console $console)
    {

        return "Wator Module 0.0.1";
    }

    public function getConsoleUsage(Console $console)
    {
        return array(
            // Describe available commands
            'wator log' => 'Log di ciò che succede nella mappa.',

//            array( 'EMAIL',            'Email of the user for a password reset' ),
            array('w', '(optional) inserire larghezza della mappa '),
            array('h', '(optional) inserire altezza della mappa '),

            'wator interactive' => 'Render Interattivo della mappa di Wator'
        );
    }


}