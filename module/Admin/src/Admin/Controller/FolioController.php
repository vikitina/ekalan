<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class FolioController extends AbstractActionController
{
    public function ajaxdelfolioAction()
    {
             $data = $_POST;
             
             $folioSrv    =  $this -> getServiceLocator()->get('folio');
             $blueprintSrv = $this -> getServiceLocator()->get('blueprints');
             $materialsinfolioSrv = $this -> getServiceLocator()->get('materialsinfolio');

             $blueprintSrv -> delByFolio((int)$data['id']);
             $folioSrv -> delFolio((int)$data['id']);
             $materialsinfolioSrv -> delByFolio((int)$data['id']);

             return new JsonModel ( array (
              
                 'res' => $data['id']
                
               ) );
              
                
    }


     public function delfolioAction()
    {
             $data['id'] = $this->getEvent()->getRouteMatch()->getParam('id');
             
             $folioSrv    =  $this -> getServiceLocator()->get('folio');
             $blueprintSrv = $this -> getServiceLocator()->get('blueprints');
             $materialsinfolioSrv = $this -> getServiceLocator()->get('materialsinfolio');

             $blueprintSrv -> delByFolio((int)$data['id']);
             $folioSrv -> delFolio((int)$data['id']);
             $materialsinfolioSrv -> delByFolio((int)$data['id']);

             $this->redirect()->toRoute('zfcadmin/admin_folios');



              
                
    }
         
 
}
