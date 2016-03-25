<?php
ini_set("memory_limit", "35M");
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

                             'admin_materials' => array(
                                  'type' => 'Zend\Mvc\Router\Http\Segment',
                                          'options' => array(
                                              
                                                    'route' => '/materials[/:filter]',
                                                    

                                                    'defaults' => array(
                                                          'controller' => 'Admin\Controller\Index',
                                                          'action'     => 'materials',
                                                      ),
                                            ),
                                    ),  
                             'admin_folios' => array(
                                  'type' => 'Zend\Mvc\Router\Http\Literal',
                                          'options' => array(
                                              
                                                    'route' => '/folios',
                                                    

                                                    'defaults' => array(
                                                          'controller' => 'Admin\Controller\Index',
                                                          'action'     => 'folios',
                                                      ),
                                            ),
                                    ),                              
                             'admin_material_open' => array(
                                  'type' => 'Zend\Mvc\Router\Http\Segment',
                                          'options' => array(
                                              
                                                    'route' => '/material/:id[/[:filter]]',
                                                    

                                                    'defaults' => array(
                                                          'controller' => 'Admin\Controller\Index',
                                                          'action'     => 'materialopen',
                                                      ),
                                            ),
                                    ),        
                             'admin_addmaterial' => array(
                                  'type' => 'Zend\Mvc\Router\Http\Segment',
                                          'options' => array(
                                              
                                                    'route' => '/addmaterial',
                                                    

                                                    'defaults' => array(
                                                          'controller' => 'Admin\Controller\Index',
                                                          'action'     => 'addmaterial',
                                                      ),
                                            ),
                                    ),     
                             'admin_updatematerial' => array(
                                  'type' => 'Zend\Mvc\Router\Http\Literal',
                                          'options' => array(
                                              
                                                    'route' => '/updatematerial',
                                                    

                                                    'defaults' => array(
                                                          'controller' => 'Admin\Controller\Index',
                                                          'action'     => 'updatematerial',
                                                      ),
                                            ),
                                    ),     
                             'admin_manufacturers' => array(
                                  'type' => 'Zend\Mvc\Router\Http\Literal',
                                          'options' => array(
                                              
                                                    'route' => '/manufacturers',
                                                    

                                                    'defaults' => array(
                                                          'controller' => 'Admin\Controller\Index',
                                                          'action'     => 'manufacturers',
                                                      ),
                                            ),
                                    ),     
                             'admin_texturers' => array(
                                  'type' => 'Zend\Mvc\Router\Http\Literal',
                                          'options' => array(
                                              
                                                    'route' => '/texturers',
                                                    

                                                    'defaults' => array(
                                                          'controller' => 'Admin\Controller\Index',
                                                          'action'     => 'texturers',
                                                      ),
                                            ),
                                    ), 
                             'admin_colors' => array(
                                  'type' => 'Zend\Mvc\Router\Http\Literal',
                                          'options' => array(
                                              
                                                    'route' => '/colors',
                                                    

                                                    'defaults' => array(
                                                          'controller' => 'Admin\Controller\Index',
                                                          'action'     => 'colors',
                                                      ),
                                            ),
                                    ),   
                             'admin_addfolio' => array(
                                  'type' => 'Zend\Mvc\Router\Http\Literal',
                                          'options' => array(
                                              
                                                    'route' => '/addfolio',
                                                    

                                                    'defaults' => array(
                                                          'controller' => 'Admin\Controller\Index',
                                                          'action'     => 'addfolio',
                                                      ),
                                            ),
                                    ),    
                             'admin_updatefolio' => array(
                                  'type' => 'Zend\Mvc\Router\Http\Segment',
                                          'options' => array(
                                              
                                                    'route' => '/updatefolio[/:id]',
                                                    

                                                    'defaults' => array(
                                                          'controller' => 'Admin\Controller\Index',
                                                          'action'     => 'updatefolio',
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
                             'admin_ajax_materialfilter' => array(
                                  'type' => 'Zend\Mvc\Router\Http\Literal',
                                  'options' => array(
                                  'route'    => '/ajax/materialfilter',
                                  'defaults' => array(
                                        'controller' => 'Admin\Controller\Ajax',
                                        'action'     => 'materialfilter',
                                        ),
                                   ),
                               ),   
                             'admin_ajax_pricinggroup' => array(
                                  'type' => 'Zend\Mvc\Router\Http\Literal',
                                  'options' => array(
                                  'route'    => '/ajax/pricinggroup',
                                  'defaults' => array(
                                        'controller' => 'Admin\Controller\Ajax',
                                        'action'     => 'pricinggroup',
                                        ),
                                   ),
                               ), 
                             'admin_ajax_deletinggroup' => array(
                                  'type' => 'Zend\Mvc\Router\Http\Literal',
                                  'options' => array(
                                  'route'    => '/ajax/deletinggroup',
                                  'defaults' => array(
                                        'controller' => 'Admin\Controller\Ajax',
                                        'action'     => 'deletinggroup',
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

                               //window_analogs                              
                            'admin_ajax_window_analogs' => array(
                                       'type' => 'Zend\Mvc\Router\Http\Literal',
                                        'options' => array(
                                         'route'    => '/ajax/windowanalogs',
                                        'defaults' => array(
                                                  'controller' => 'Admin\Controller\Ajax',
                                                  'action'     => 'windowanalogs',
                                           ),
                                         ),
                               ), 


///admin/ajax/deletematerial       

                            'admin_ajax_deletematerial' => array(
                                       'type' => 'Zend\Mvc\Router\Http\Literal',
                                        'options' => array(
                                         'route'    => '/ajax/deletematerial',
                                        'defaults' => array(
                                                  'controller' => 'Admin\Controller\Ajax',
                                                  'action'     => 'deletematerial',
                                           ),
                                         ),
                               ),
                             'admin_delmaterial' => array(
                                  'type' => 'Zend\Mvc\Router\Http\Segment',
                                          'options' => array(                                              
                                                    'route' => '/delmaterial/:id[/:filter]',
                                                    'defaults' => array(
                                                          'controller' => 'Admin\Controller\Index',
                                                          'action'     => 'delmaterial',
                                                      ),
                                            ),
                            ), 
                             'admin_groups' => array(
                                  'type' => 'Zend\Mvc\Router\Http\Segment',
                                          'options' => array(                                              
                                                    'route' => '/groups',
                                                    'defaults' => array(
                                                          'controller' => 'Admin\Controller\Index',
                                                          'action'     => 'groups',
                                                      ),
                                            ),
                            ), 
                            'admin_ajax_addphoto'  => array(
                                  'type' => 'Zend\Mvc\Router\Http\Literal',
                                          'options' => array(                                              
                                                    'route' => '/ajaxaddphoto',
                                                    'defaults' => array(
                                                          'controller' => 'Admin\Controller\Ajax',
                                                          'action'     => 'addphoto',
                                                      ),
                                            ),
                            ), 

                            'admin_ajax_upload'  => array(
                                  'type' => 'Zend\Mvc\Router\Http\Literal',
                                          'options' => array(                                              
                                                    'route' => '/ajaxuploadimg',
                                                    'defaults' => array(
                                                          'controller' => 'Admin\Controller\Ajax',
                                                          'action'     => 'upload',
                                                      ),
                                            ),
                            ), 


                            'admin_ajax_cropimg'  => array(
                                  'type' => 'Zend\Mvc\Router\Http\Literal',
                                          'options' => array(                                              
                                                    'route' => '/ajaxcroping',
                                                    'defaults' => array(
                                                          'controller' => 'Admin\Controller\Ajax',
                                                          'action'     => 'ajaxcroping',
                                                      ),
                                            ),
                            ),
                            ///admin/ajaxtextureupdate
                           'admin_ajax_textureupdate'  => array(
                                  'type' => 'Zend\Mvc\Router\Http\Literal',
                                          'options' => array(                                              
                                                    'route' => '/ajaxtextureupdate',
                                                    'defaults' => array(
                                                          'controller' => 'Admin\Controller\Ajax',
                                                          'action'     => 'ajaxtextureupdate',
                                                      ),
                                            ),
                            ), 
                            //ajaxmanufupdate 
                           'admin_ajax_manufupdate'  => array(
                                  'type' => 'Zend\Mvc\Router\Http\Literal',
                                          'options' => array(                                              
                                                    'route' => '/ajaxmanufupdate',
                                                    'defaults' => array(
                                                          'controller' => 'Admin\Controller\Ajax',
                                                          'action'     => 'ajaxmanufupdate',
                                                      ),
                                            ),
                            ), 
                           'admin_ajax_colorupdate'  => array(
                                  'type' => 'Zend\Mvc\Router\Http\Literal',
                                          'options' => array(                                              
                                                    'route' => '/ajaxcolorupdate',
                                                    'defaults' => array(
                                                          'controller' => 'Admin\Controller\Ajax',
                                                          'action'     => 'ajaxcolorupdate',
                                                      ),
                                            ),
                            ),  

                           'admin_ajax_addgroup'  => array(
                                  'type' => 'Zend\Mvc\Router\Http\Literal',
                                          'options' => array(                                              
                                                    'route' => '/ajaxaddgroup',
                                                    'defaults' => array(
                                                          'controller' => 'Admin\Controller\Ajax',
                                                          'action'     => 'ajaxaddgroup',
                                                      ),
                                            ),
                            ), 
                            //admin/ajaxaddtexture  
                           'admin_ajax_addtexture'  => array(
                                  'type' => 'Zend\Mvc\Router\Http\Literal',
                                          'options' => array(                                              
                                                    'route' => '/ajaxaddtexture',
                                                    'defaults' => array(
                                                          'controller' => 'Admin\Controller\Ajax',
                                                          'action'     => 'ajaxaddtexture',
                                                      ),
                                            ),
                            ),         
                          'admin_ajax_groupupdate'  => array(
                                  'type' => 'Zend\Mvc\Router\Http\Literal',
                                          'options' => array(                                              
                                                    'route' => '/ajaxgroupupdate',
                                                    'defaults' => array(
                                                          'controller' => 'Admin\Controller\Ajax',
                                                          'action'     => 'ajaxgroupupdate',
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

        'template_map' => array(

            'material/adminmaterialset'     => __DIR__ . '/../view/admin/index/adminmaterialset.twig',
            'material/modalmateriallist'    => __DIR__ . '/../view/admin/index/modalmateriallist.twig',

            'newgroupelement'               => __DIR__ . '/../view/admin/index/newgroupelement.twig',
            'newtextureelement'             => __DIR__ . '/../view/admin/index/newtextureelement.twig',

            


        ),         

        'strategies' => array (            
                                           
                        'ViewJsonStrategy' 
                ),           
    ),
);


