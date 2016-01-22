<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class AjaxController extends AbstractActionController
{
    public function indexAction()
    {
                  $data = $_POST;
        
                  $pagesSrv    = $this -> getServiceLocator()->get('pages');
                  $pages = array();
                  $pages = $pagesSrv ->  setNumOnePosUp($data['id']); 

    	            $result = new JsonModel ( array (
                
    	          	'res' => $pages,

                
        ) );
       

         
   return $result;
    }

    public function movedownAction()
    {
                  $data = $_POST;
                  $pagesSrv    = $this -> getServiceLocator()->get('pages');
                  $pages = array();
                  $pages = $pagesSrv ->  setNumOnePosDown($data['id']); 

                  $result = new JsonModel ( array (
              
                  'res' => $pages,
                  
                
        ) );
       

         
   return $result;
    }

   public function delpageAction(){

               $param = array();
               $param = $_POST;
             
              $pagesSrv = $this -> getServiceLocator()->get('pages');
               if (isset($param['id'])&&$param['id']){
                       $page =     $pagesSrv ->  deletePages($param);
               }
              $result = new JsonModel ( array (
              
                  'res' => $param,
                  
                
        ) );
return $result;

        }  


        //msgread            
   public function msgreadAction(){

               $param = array();
               $param = $_POST;
             
              $msgSrv = $this -> getServiceLocator()->get('message');
              
              $msgSrv ->  updateMsg($param);
              $unread_msg = $msgSrv -> getUnreadMessages();
              
              $result = new JsonModel ( array (
              
                  'new_count_unread_msgs' => $unread_msg,
                  
                
        ) );
return $result;

        }  

//updatesystem        

  public function updatesystemAction(){

               $param = array();
               $param = $_POST;          
               $systSrv = $this -> getServiceLocator()->get('system');             
               $systSrv ->  updateSystem($param);
               $result = new JsonModel ( array (
              
               //   'new_count_unread_msgs' => $unread_msg,
                  
                
        ) );
return $result;

        }  

}