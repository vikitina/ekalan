<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),


           'application\ajax' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/application/ajax',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Ajax',
                        'action'     => 'index',
                    ),
                ),
            ),
 

           'msg' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/msg',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'msg',
                    ),
                ),
            ),    

           'material' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/material/:name_material',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Material',
                        'action'     => 'index',
                    ),
                ),
            ),  

//materialset  

          'materialset_ajax' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/materialajax',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Material',
                        'action'     => 'materialset',
                    ),
                ),
            ),                   
          'material_ajax' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/sampleajax',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Material',
                        'action'     => 'ajax',
                    ),
                ),
            ),    
           'portfolio' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/portfolio',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'portfolio',
                    ),
                ),
            ), 
           'open_project' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/project[/:id]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'project',
                    ),
                ),
            ),           



           'inners_service' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/inners',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Tester',
                        'action'     => 'index',
                    ),
                ),
            ),   

                  
           'inners_service_getmaterial' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/inners/getmaterial',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Tester',
                        'action'     => 'getmaterial',
                    ),
                ),
            ),   
           'tester' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/tester',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Tester',
                        'action'     => 'tester',
                    ),
                ),
            ), 


           'articles' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/infos',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Article',
                        'action'     => 'allarticles',
                    ),
                ),
            ),  

           'openarticle' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route'    => '/info[/:id]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Article',
                        'action'     => 'openarticle',
                    ),
                ),
            ),  
                  


        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
         'factories' => array(
            'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',
       
       
            'Zend\Db\Adapter\Adapter' => function ($sm) {
                $config = $sm->get('Config');
                
                $dbParams = $config['db'];

                return new Zend\Db\Adapter\Adapter(
                    array(
                        'driver'    => 'Pdo',
                        'dsn'       => $dbParams['dsn'],
                        'database'  => $dbParams['database'],
                        'username'  => $dbParams['username'],
                        'password'  => $dbParams['password']
                    )
                );
            },
      
    /*        'users' => function ($sm) {
                return new \Users\Model\Users(
                    $sm->get('Zend\Db\Adapter\Adapter')
                );
            },   */
            'pages' => function ($sm) {
                return new \Application\Model\Pages(
                    $sm->get('Zend\Db\Adapter\Adapter')
                );
            },
            'message' => function ($sm) {
                return new \Application\Model\Messages(
                    $sm->get('Zend\Db\Adapter\Adapter')
                );
            }, 
           'system' => function ($sm) {
                return new \Application\Model\System(
                    $sm->get('Zend\Db\Adapter\Adapter')
                );
            }, 
          'sales' => function ($sm) {
                return new \Application\Model\Sales(
                    $sm->get('Zend\Db\Adapter\Adapter')
                );
            },             
          'material' => function ($sm) {
                return new \Application\Model\Materials(
                    $sm->get('Zend\Db\Adapter\Adapter')
                );
            },    
          'sample' => function ($sm) {
                return new \Application\Model\Sample(
                    $sm->get('Zend\Db\Adapter\Adapter')
                );
            },    
         'color' => function ($sm) {
                return new \Application\Model\Color(
                    $sm->get('Zend\Db\Adapter\Adapter')
                );
            },      
         'texture' => function ($sm) {
                return new \Application\Model\Texture(
                    $sm->get('Zend\Db\Adapter\Adapter')
                );
            },    
          'manufacturer' => function ($sm) {
                return new \Application\Model\Manufacturer(
                    $sm->get('Zend\Db\Adapter\Adapter')
                );
            },  
          'collection' => function ($sm) {
                return new \Application\Model\Collection(
                    $sm->get('Zend\Db\Adapter\Adapter')
                );
            },    
          'analogs' => function ($sm) {
                return new \Application\Model\Analogs(
                    $sm->get('Zend\Db\Adapter\Adapter')
                );
            }, 
           'constants' => function ($sm) {
                return new \Application\Model\Constants(
                    $sm->get('Zend\Db\Adapter\Adapter')
                );
            },  
           'groups' => function ($sm) {
                return new \Application\Model\Group(
                    $sm->get('Zend\Db\Adapter\Adapter')
                );
            },   
           'folio' => function ($sm) {
                return new \Application\Model\Folio(
                    $sm->get('Zend\Db\Adapter\Adapter')
                );
            },  
            'pictures' => function ($sm) {
                return new \Application\Model\Pictures(
                    $sm->get('Zend\Db\Adapter\Adapter')
                );
            },  
            'photos' => function ($sm) {
                return new \Application\Model\Photos(
                    $sm->get('Zend\Db\Adapter\Adapter')
                );
            }, 
           'blueprints' => function ($sm) {
                return new \Application\Model\Blueprints(
                    $sm->get('Zend\Db\Adapter\Adapter')
                );
            },  
           'testimonials' => function ($sm) {
                return new \Application\Model\Testimonials(
                    $sm->get('Zend\Db\Adapter\Adapter')
                );
            },       
           'materialsinfolio' => function ($sm) {
                return new \Application\Model\Materialsinfolio(
                    $sm->get('Zend\Db\Adapter\Adapter')
                );
            }, 
            'karusel' => function ($sm) {
                return new \Application\Model\Karusel(
                    $sm->get('Zend\Db\Adapter\Adapter')
                );
            },
            'windowkarusel' => function ($sm) {
                return new \Application\Model\Windowkarusel(
                    $sm->get('Zend\Db\Adapter\Adapter')
                );
            },
           'article' => function ($sm) {
                return new \Application\Model\Article(
                    $sm->get('Zend\Db\Adapter\Adapter')
                );
            },

                     
    ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            'Application\Controller\Ajax' => 'Application\Controller\AjaxController',
            'Application\Controller\Tester' => 'Application\Controller\TesterController',
            'Application\Controller\Material' => 'Application\Controller\MaterialController',
            'Application\Controller\Article' => 'Application\Controller\ArticleController',

        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.twig',
            'layout/portfolio'        => __DIR__ . '/../view/layout/portfolio.twig',
            'layout/material'        => __DIR__ . '/../view/layout/material.twig',
            'layout/article'        => __DIR__ . '/../view/layout/article.twig',

            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.twig',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
            'errors/403'              => __DIR__ . '/../view/error/403.twig',
            'user/login'              => __DIR__ . '/../view/application/user/login.twig',
            'tester/some'             => __DIR__ . '/../view/application/tester/some.twig',
            'material/materialset'    => __DIR__ . '/../view/application/material/materialset.twig',
            'material/materialmodal'    => __DIR__ . '/../view/application/material/materialmodal.twig',

        ), 
        'template_path_stack' => array(
            __DIR__ . '/../view',
        'zfc-user' => __DIR__ . '/../view',
        ),
        'strategies' => array (            
                                           
                        'ViewJsonStrategy' 
                ),        
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),

   'view_helpers' => array(

              
     'factories' => array(
                'MainMenuHelper' => function($sm) {
                    $helper = new \Application\View\Helper\MainMenuHelper();
                    $helper->getMainMenu($sm -> getServiceLocator()->get('pages'));

                    return $helper;
                },   


               'Messages' => function($sm) {
                    $helper = new \Application\View\Helper\Messages();
                    $helper->getMessages($sm -> getServiceLocator()->get('message'));

                    return $helper;
                },                     
               'System' => function($sm) {
                    $helper = new \Application\View\Helper\System();
                    $helper->getSystemVars($sm -> getServiceLocator()->get('system'));

                    return $helper;
                },   
                 
                'UnreadMessages'=> function($sm) {
                    $helper = new \Application\View\Helper\UnreadMessages();
                    $helper->getUnreadMessages($sm -> getServiceLocator()->get('message'));

                    return $helper;
                }, 
               'GetActiveSale'=> function($sm) {
                    $helper = new \Application\View\Helper\GetActiveSale();
                    $helper->getActiveSale($sm -> getServiceLocator()->get('sales'));

                    return $helper;
                },                 
                
               'GetAllSales'=> function($sm) {
                    $helper = new \Application\View\Helper\GetAllSales();
                    $helper->getAllSales($sm -> getServiceLocator()->get('sales'));

                    return $helper;
                },                 
                
        )


        ),
);
