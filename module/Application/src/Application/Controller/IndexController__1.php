<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class IndexController extends AbstractActionController
{
    public function indexAction()
    {
       		
		$pagesSrv    = $this -> getServiceLocator()->get('pages');
        $systemSrv    = $this -> getServiceLocator()->get('system');
        $pages  = array();
        $system = array();
        $pages  = $pagesSrv ->  getPages(); 
        $system = $systemSrv -> getSystem(); 

        foreach ($system as $item){
              $sys[$item['name']] = $item['data'];

        }
       // var_dump($sys);
        
        return new ViewModel(array(
             
                'pages'  => $pages,
                'system' => $sys
        ));
    }


}
