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


        public function salesupdateAction()
    {

                  $data = $_POST;
                  $salesSrv    = $this -> getServiceLocator()->get('sales');

                  $salesSrv->updateSales($data);
                  $result = new JsonModel ( array (
                       
             
                
        ) );
       

         
   return $result;


}   
        public function salesmarkupupdateAction()
    {

                  $data = $_POST;
                  $salesSrv    = $this -> getServiceLocator()->get('sales');

                  $q = $salesSrv->updatemarkupSales($data);
                  $result = new JsonModel ( array (
                       
             'res' => $q
                
        ) );
       

         
   return $result;


}  

        public function salesactiveupdateAction()
    {

                  $data = $_POST;
                  //$data['sales_active'] = ($data['sales_active']  == 'on')?'1':'0';

                  $salesSrv    = $this -> getServiceLocator()->get('sales');
                  $salesSrv -> updateoffallactiveSales();
                  
                  $q = $salesSrv->updateactiveSales($data);
                  $result = new JsonModel ( array (
                       
             'res' => $q
                
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

   public function materialfilterAction(){

               
               $data = $_POST;
               $materialSrv = $this -> getServiceLocator()->get('material');
               $set_material = $materialSrv->getSpecOrder($data);

               $partial = $this->getServiceLocator()->get('viewhelpermanager')->get('partial');
               $set_material_html = $partial('material/adminmaterialset', array("key" => $set_material['result']));   
               $rowcount = $set_material['rowcount'];

               $limit = 10;
            return  $result = new JsonModel ( array (
              
                       'html'      => $set_material_html,
                       'rowcount'  => $rowcount,
                       'limit'     => $limit,
                       'query'     => $set_material['query']
                
               ) );


        }   


   public function windowanalogsAction(){

         $data = $_POST;
         $materialSrv = $this -> getServiceLocator()->get('material');
         $set_material = $materialSrv->getSpecOrder($data);     


         $partial = $this->getServiceLocator()->get('viewhelpermanager')->get('partial');
         $modal_material_list_html = $partial('material/modalmateriallist', array("key" => $set_material['result']));   


         return  $result = new JsonModel ( array (
              
                       'modal_material_list_html'      => $modal_material_list_html,
                       
                
               ) );   

   } 

 

    public function deletematerialAction(){

         $data = $_POST;
         $id = $data['id'];
         $materialSrv      = $this -> getServiceLocator()->get('material');
         $sampleSrv        = $this -> getServiceLocator()->get('sample');
         $analogSrv        = $this -> getServiceLocator()->get('analogs');
            

         $material = $materialSrv->getMaterial($id);
         $materialSrv->delMaterial($id);
         $id_sample = $material['set']['id_sample'];
         $sampleSrv -> delSample($id_sample);

         $analogSrv->delAllAboutId($id);
  


         return  $result = new JsonModel ( array (
              
                      'id_sample' => $id_sample,
                      'query' => $material['query']

                       
                
               ) );   

   }        

}