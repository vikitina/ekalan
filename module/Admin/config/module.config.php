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
                                  'admin_pages' => array(
                                  'type' => 'Zend\Mvc\Router\Http\Segment',
                                          'options' => array(
                                              
                                                    'route' => '/page[/]',
                                                    

                                                    'defaults' => array(
                                                          'controller' => 'Admin\Controller\Index',
                                                          'action'     => 'index',
                                                      ),
                                            ),
                                    ),
                                  'admin_page' => array(
                                  'type' => 'Zend\Mvc\Router\Http\Segment',
                                          'options' => array(
                                              
                                                    'route' => '/page/:id',
                                                    

                                                    'defaults' => array(
                                                          'controller' => 'Admin\Controller\Index',
                                                          'action'     => 'page',
                                                      ),
                                            ),
                                    ),    


                                    // /admin/updatepage/    


                                'admin_update_page' => array(
                                  'type' => 'Zend\Mvc\Router\Http\Segment',
                                          'options' => array(
                                              
                                                    'route' => '/updatepage[/]',
                                                    

                                                    'defaults' => array(
                                                          'controller' => 'Admin\Controller\Index',
                                                          'action'     => 'updatepage',
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

                               'admin_ajax_up' => array(
                                       'type' => 'Zend\Mvc\Router\Http\Literal',
                                        'options' => array(
                                         'route'    => '/ajax/up',
                                        'defaults' => array(
                                                  'controller' => 'Admin\Controller\Ajax',
                                                  'action'     => 'index',
                                           ),
                                         ),
                               ),
                               'admin_ajax_down' => array(
                                       'type' => 'Zend\Mvc\Router\Http\Literal',
                                        'options' => array(
                                         'route'    => '/ajax/down',
                                        'defaults' => array(
                                                  'controller' => 'Admin\Controller\Ajax',
                                                  'action'     => 'movedown',
                                           ),
                                         ),
                               ),    

                               'admin_ajax_del' => array(
                                       'type' => 'Zend\Mvc\Router\Http\Literal',
                                        'options' => array(
                                         'route'    => '/ajax/del',
                                        'defaults' => array(
                                                  'controller' => 'Admin\Controller\Ajax',
                                                  'action'     => 'delpage',
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


