<?php
/**
 * Created by PhpStorm.
 * User: Enrico
 * Date: 09/06/2015
 * Time: 14:56
 */

return array(
    'controllers' => array(
        'invokables' => array(
            'Wator\Controller\Wator' => 'Wator\Controller\WatorController',
            'Wator\Controller\ConsoleWator' => 'Wator\Controller\ConsoleWatorController'

        ),
    ),

    'router'=>array(
        'routes' => array(
            'wator' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/wator[/:action]',
                    'constrains' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Wator\Controller\Wator',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'console' => array(
        'router' => array(
            'routes' => array(
                'wator-monitor'  => array(
                    'options' => array(
                        'route'    => 'wator monitor [<w>] [<h>]',
                        'defaults' => array(
                            'controller' => 'Wator\Controller\ConsoleWator',
                            'action'     => 'monitor'
                        )
                    )
                ),
                'wator-interactive'  => array(
                   'options' => array(
                       'route'    => 'wator interactive [<w>] [<h>]',
                       'defaults' => array(
                           'controller' => 'Wator\Controller\ConsoleWator',
                           'action'     => 'interactive'
                       )
                   )
                ),
                'wator-log' => array(
                    'options' => array(
                        'route'    => 'wator log [<w>] [<h>]',
                        'defaults' => array(
                            'controller' => 'Wator\Controller\ConsoleWator',
                            'action'    =>  'log'
                        ),
                    ),
                ),

            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'wator' => __DIR__ . '/../view',
        ),
    ),

);
