<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'CSV\Controller\CSV' => 'CSV\Controller\CSVController',
        ),
    ),

    'console' => array(
        'router' => array(
            'routes' => array(
                'csv-import-array'  => array(
                    'options' => array(
                        'route'    => 'csv import <p> to <newp>',
                        'defaults' => array(
                            'controller' => 'CSV\Controller\CSV',
                            'action'     => 'array-import'
                        )
                    )
                ),
                'csv-import-callback'  => array(
                    'options' => array(
                        'route'    => 'csv import cb <p> to <newp>',
                        'defaults' => array(
                            'controller' => 'CSV\Controller\CSV',
                            'action'     => 'callback-import'
                        )
                    )
                ),
                'csv-import-compare'  => array(
                    'options' => array(
                        'route'    => 'csv import compare <p> to <newp>',
                        'defaults' => array(
                            'controller' => 'CSV\Controller\CSV',
                            'action'     => 'compare-import'
                        )
                    )
                ),
                'csv-import-array-no-dup'  => array(
                    'options' => array(
                        'route'    => 'csv import array nodup <p> to <newp>',
                        'defaults' => array(
                            'controller' => 'CSV\Controller\CSV',
                            'action'     => 'array-no-dup-import'
                        )
                    )
                ),
                'csv-import-callback-no-dup'  => array(
                    'options' => array(
                        'route'    => 'csv import cb nodup <p> to <newp>',
                        'defaults' => array(
                            'controller' => 'CSV\Controller\CSV',
                            'action'     => 'callback-no-dup-import'
                        )
                    )
                ),
                'csv-import-compare-no-dup'  => array(
                    'options' => array(
                        'route'    => 'csv import compare nodup <p> to <newp>',
                        'defaults' => array(
                            'controller' => 'CSV\Controller\CSV',
                            'action'     => 'compare-no-dup-import'
                        )
                    )
                ),
                'test-quick-sort'  => array(
                    'options' => array(
                        'route'    => 'quick sort',
                        'defaults' => array(
                            'controller' => 'CSV\Controller\CSV',
                            'action'     => 'quick-sort-test'
                        )
                    )
                ),
            )
        )
    ),





    'view_manager' => array(
        'template_path_stack' => array(
            'wator' => __DIR__ . '/../view',
        ),
    ),

);
