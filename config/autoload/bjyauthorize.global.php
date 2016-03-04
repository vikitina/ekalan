<?php
return array(
'bjyauthorize' => array(

           'default_role' => 'guest',
           'identity_provider' => 'BjyAuthorize\Provider\Identity\ZfcUserZendDb',
           'role_providers' => array(
                          'BjyAuthorize\Provider\Role\ZendDb' => array(
                              'table' => 'user_role',
                              'role_id_field' => 'roleId',
                              'parent_role_field' => 'parent_id',
                             ),           
           ),
           'template' => 'errors/403',

'resource_providers' => array(
    'BjyAuthorize\Provider\Resource\Config' => array(
        'admin_button' => array(),
    ),
),
'rule_providers' => array(
    'BjyAuthorize\Provider\Rule\Config' => array(
        'allow' => array(
            /*
            [0] -> role
            [1] -> resource
            [2] -> rule
            */
            array( array( 'admin' ), 'admin_button', 'see_button' ),

        ),
    ),
),           
           'guards' => array(
        /*    'BjyAuthorize\Guard\Controller' => array(
                       array(
                             'controller' => 'Application\Controller\Index', 
                             'roles' => array('guest', 'user')
                             ),
                       array(
                              'controller' => 'zfcuser',
                              'action' => array('index'),
                              'roles' => array('guest', 'user'),
                           ),
                       array(
                              'controller' => 'zfcuser',
                              'action' => array('login', 'authenticate', 'register'),
                              'roles' => array('guest','user'),
                           ),
                      array(
                                'controller' => 'zfcuser',
                               'action' => array('logout'),
                              'roles' => array('user'),
                ),

            */

'BjyAuthorize\Guard\Route' => array(                   

                                   
                                   array('route' => 'home', 'roles' => array('guest', 'user')),
                                   
                                   array('route' => 'zfcuser', 'roles' => array('guest','user')),  
                                   array('route' => 'zfcuser/login', 'roles' => array('guest')),  
                                   array('route' => 'zfcuser/logout', 'roles' => array('user','admin')),  
                                   array('route' => 'zfcuser/register', 'roles' => array('guest')),  
                                   array('route' => 'zfcuser/changepassword', 'roles' => array('user','admin')),  
                                   array('route' => 'zfcuser/changeemail', 'roles' => array('user','admin')),  
                                   array('route' => 'application\ajax', 'roles' => array('guest','user')),

                                   array('route' => 'msg', 'roles' => array('guest')),

                                   array('route' => 'inners_service', 'roles' => array('guest','user','admin')),
                                   array('route' => 'inners_service_getmaterial', 'roles' => array('guest','user','admin')),
                                   array('route' => 'tester', 'roles' => array('guest','user','admin')),

                                   array('route' => 'portfolio', 'roles' => array('guest','user','admin')),
                                   array('route' => 'material', 'roles' => array('guest', 'user')),
                                   array('route' => 'material_ajax', 'roles' => array('guest', 'user')),
                                   array('route' => 'materialset_ajax', 'roles' => array('guest', 'user')),                                   
                                   array('route' => 'zfcadmin/admin_main_page', 'roles' => array('admin')),  
                           
                         
                                   array('route' => 'zfcadmin/admin_msgs', 'roles' => array('admin')), 
                                   array('route' => 'zfcadmin/admin_msg_open', 'roles' => array('admin')), 
                                   array('route' => 'zfcadmin/admin_materials', 'roles' => array('admin')), 
                                   array('route' => 'zfcadmin/admin_material_open', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_addmaterial', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_ajax_materialfilter', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_ajax_msgread', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_ajax_updatesystem', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_ajax_salesupdate', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_ajax_salesmarkupupdate', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_ajax_salesactiveupdate', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_ajax_window_analogs', 'roles' => array('admin')),
                                   
                                   
                                  array('route' => 'test\mail', 'roles' => array('guest','user')),
                                   
                                

                
),
              ),
           ),


);

