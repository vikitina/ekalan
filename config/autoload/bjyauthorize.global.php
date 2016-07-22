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
                                   array('route' => 'open_project', 'roles' => array('guest','user','admin')),
                                  
                                   array('route' => 'material', 'roles' => array('guest', 'user')),
                                   array('route' => 'material_ajax', 'roles' => array('guest', 'user')),
                                   array('route' => 'materialset_ajax', 'roles' => array('guest', 'user')), 
                                   //delmaterial

                                   array('route' => 'articles', 'roles' => array('guest', 'user')),
                                   array('route' => 'openarticle', 'roles' => array('guest', 'user')),
                                   array('route' => 'calculator', 'roles' => array('guest', 'user')),
                                   

                                   array('route' => 'zfcadmin/admin_main_page', 'roles' => array('admin')),  
                           
                         
                                   array('route' => 'zfcadmin/admin_msgs', 'roles' => array('admin')), 
                                   array('route' => 'zfcadmin/admin_msg_open', 'roles' => array('admin')), 
                                   array('route' => 'zfcadmin/admin_materials', 'roles' => array('admin')),                                   
                                   array('route' => 'zfcadmin/admin_folios', 'roles' => array('admin')), 
                                   array('route' => 'zfcadmin/admin_delfolio', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_ajax_delcategory', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_ajax_deletingcategory', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_updatefolio', 'roles' => array('admin')), 
                                   array('route' => 'zfcadmin/admin_testimonials', 'roles' => array('admin')), 
                                   array('route' => 'zfcadmin/admin_testimonial', 'roles' => array('admin')),  
                                   array('route' => 'zfcadmin/admin_addtestimonial', 'roles' => array('admin')),     
                                   array('route' => 'zfcadmin/admin_articles', 'roles' => array('admin')), 
                                   array('route' => 'zfcadmin/admin_ajaxdelarticle', 'roles' => array('admin')), 
                                   array('route' => 'zfcadmin/admin_ajaxpublicart', 'roles' => array('admin')),                                    
                                   array('route' => 'zfcadmin/admin_openarticle', 'roles' => array('admin')), 
                                   array('route' => 'zfcadmin/admin_updatearticle', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_addarticle', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_delarticle', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_artfirst', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_addartfirst', 'roles' => array('admin')),    
                                   array('route' => 'zfcadmin/admin_artfour', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_addartfour', 'roles' => array('admin')),     
                                   array('route' => 'zfcadmin/admin_arthow', 'roles' => array('admin')), 
                                   array('route' => 'zfcadmin/admin_addarthow', 'roles' => array('admin')), 

                              
                                   array('route' => 'zfcadmin/admin_ajaxdelarticle', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_ajax_deltestimonial', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_deltestimonial', 'roles' => array('admin')),
                                                                           

                                   array('route' => 'zfcadmin/admin_material_open', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_addmaterial', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_updatematerial', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_manufacturers', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_texturers', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_colors', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_addfolio', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_updatekarusel', 'roles' => array('admin')),   
                                   array('route' => 'zfcadmin/admin_addkarusel', 'roles' => array('admin')),            
                                   array('route' => 'zfcadmin/admin_ajax_materialfilter', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_ajax_msgread', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_ajax_updatesystem', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_ajax_salesupdate', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_ajax_salesmarkupupdate', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_ajax_salesactiveupdate', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_ajax_window_analogs', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_ajax_deletematerial', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_delmaterial', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_ajax_upload', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_ajax_pricinggroup', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_ajax_deletinggroup', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_ajax_cropimg', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_ajax_textureupdate', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_ajax_manufupdate', 'roles' => array('admin')),  
                                   array('route' => 'zfcadmin/admin_ajax_colorupdate', 'roles' => array('admin')),  
                                   array('route' => 'zfcadmin/admin_groups', 'roles' => array('admin')), 
                                   array('route' => 'zfcadmin/admin_ajax_addgroup', 'roles' => array('admin')), 
                                   array('route' => 'zfcadmin/admin_ajax_groupupdate', 'roles' => array('admin')), 
                                   array('route' => 'zfcadmin/admin_ajax_addphoto', 'roles' => array('admin')), 
                                   array('route' => 'zfcadmin/admin_ajax_addtexture', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_ajax_addcolor', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_ajax_delfolio', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_ajax_delkarusel', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_mp', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_help', 'roles' => array('admin')),
                                   array('route' => 'zfcadmin/admin_help_folio', 'roles' => array('admin')),
                                                                      


                                   //admin_ajax_groupupdate
                                   array('route' => 'test\mail', 'roles' => array('guest','user')),
                                   
                                

                
),
              ),
           ),


);

