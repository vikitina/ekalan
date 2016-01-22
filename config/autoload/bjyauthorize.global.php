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
                                   array('route' => 'zfcadmin/admin_pages', 'roles' => array('admin')),  
                                   array('route' => 'zfcadmin/admin_page', 'roles' => array('admin')),  
                                   array('route' => 'zfcadmin/admin_ajax_up', 'roles' => array('admin')),  
                                   array('route' => 'zfcadmin/admin_ajax_down', 'roles' => array('admin')), 
                                   array('route' => 'zfcadmin/admin_update_page', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_ajax_del', 'roles' => array('admin')), 
                                   array('route' => 'zfcadmin/admin_msgs', 'roles' => array('admin')), 
                                   array('route' => 'zfcadmin/admin_msg_open', 'roles' => array('admin')), 
                                   array('route' => 'zfcadmin/admin_ajax_msgread', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_ajax_updatesystem', 'roles' => array('admin')),
                                    array('route' => 'test\mail', 'roles' => array('guest','user')),
                                   
                                

                
),
              ),
           ),


);

