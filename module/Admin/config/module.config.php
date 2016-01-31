<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
            'Admin\Controller\Ajax' => 'Admin\Controller\AjaxController'
        ),
    ),
    'router' => array(
        'routes' => array(
               'zfcadmin' => array(
                      'child_routes' => array(
      
     

                                'admin_main_page' => array(
                                  'type' => 'Zend\Mvc\Router\Http\Segment',
                                          'options' => array(
                                              
                                                    'route' => '/page/main',
                                                    

                                                    'defaults' => array(
                                                          'controller' => 'Admin\Controller\Index',
                                                          'action'     => 'mainpage',
                                                      ),
                                            ),
                                    ),

                                'admin_msgs' => array(
                                  'type' => 'Zend\Mvc\Router\Http\Segment',
                                          'options' => array(
                                              
                                                    'route' => '/msgs[/]',
                                                    

                                                    'defaults' => array(
                                                          'controller' => 'Admin\Controller\Index',
                                                          'action'     => 'msgs',
                                                      ),
                                            ),
                                    ),         
                               'admin_msg_open' => array(
                                  'type' => 'Zend\Mvc\Router\Http\Segment',
                                          'options' => array(
                                              
                                                    'route' => '/msg/:id',
                                                    

                                                    'defaults' => array(
                                                          'controller' => 'Admin\Controller\Index',
                                                          'action'     => 'msgopen',
                                                      ),
                                            ),
                                    ),       
               'admin_ajax_salesupdate' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/ajax/sales',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Ajax',
                        'action'     => 'salesupdate',
                    ),
                ),
            ),


              'admin_ajax_salesmarkupupdate' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/ajax/updatemarkupsales',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Ajax',
                        'action'     => 'salesmarkupupdate',
                    ),
                ),
            ),

              'admin_ajax_salesactiveupdate' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/ajax/updateactivesales',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Ajax',
                        'action'     => 'salesactiveupdate',
                    ),
                ),
            ),              

         

 


                               ///ajax/msgread                                                        
                              'admin_ajax_msgread' => array(
                                       'type' => 'Zend\Mvc\Router\Http\Literal',
                                        'options' => array(
                                         'route'    => '/ajax/msgread',
                                        'defaults' => array(
                                                  'controller' => 'Admin\Controller\Ajax',
                                                  'action'     => 'msgread',
                                           ),
                                         ),
                               ), 


                               // /ajax/updatesystem
                            'admin_ajax_updatesystem' => array(
                                       'type' => 'Zend\Mvc\Router\Http\Literal',
                                        'options' => array(
                                         'route'    => '/ajax/updatesystem',
                                        'defaults' => array(
                                                  'controller' => 'Admin\Controller\Ajax',
                                                  'action'     => 'updatesystem',
                                           ),
                                         ),
                               ),                               

                        ),
                 ),
            ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),

        'strategies' => array (            
                                           
                        'ViewJsonStrategy' 
                ),           
    ),
);


