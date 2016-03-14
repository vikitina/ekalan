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

/*      
      [0] - manufacturer
      [1] - texture
      [2] - color

*/               
               $data = $_POST;
               $user_filter = $data['id_manufacturer'].'&'.$data['id_color'].'&'.$data['id_texture'];
               $materialSrv = $this -> getServiceLocator()->get('material');
               $set_material = $materialSrv->getSpecOrder($data);
               foreach ($set_material['result'] as $key => $item) {
                $set_material['result'][$key]['url'] = ((isset($item['url']) && $item['url'] != '' && $item['url'] !=null)?"/assets/application/samples/".trim($item['url']):"/assets/application/img/no_photo.png");
               }
               $partial = $this->getServiceLocator()->get('viewhelpermanager')->get('partial');
               $set_material_html = $partial('material/adminmaterialset', array("key" => $set_material['result'],'hash_filter'=>$user_filter));   
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


   public function uploadAction(){

            $request = $this->getRequest();
            // $data = [];

             if ($request->isXmlHttpRequest()) {
             $url = $this->uploadFile($_FILES);
    }

    return new JsonModel(array('url' => $url['new_file_url'],
                              'name' => $url['new_file_name']));
}      



function uploadfile($data){


      $constantsSrv       = $this -> getServiceLocator()->get('constants');
      $upload_dir         = trim($constantsSrv->getConstantByName('upload_dir'));
      $path_to_upload_dir = trim($constantsSrv->getConstantByName('path_to_upload_dir'));




      $target_dir = $path_to_upload_dir.$upload_dir;

      $target_file = $target_dir . basename($data["sample"]["name"]);
      //echo '<br>'.$target_file;
      $uploadOk = 1;
      $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
      //echo '<br>'.$imageFileType;
// Check if image file is a actual image or fake image

      $check = getimagesize($data["sample"]["tmp_name"]);
      if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        //echo "File is not an image.";
        $uploadOk = 0;
    }

// Check if file already exists
if (file_exists($target_file)) {
   // echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($data["sample"]["size"] > 5000000) {
   // echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
  //  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    //echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    $new_file_name = time().".".$imageFileType;
    $new_file = $target_dir.$new_file_name;
    if (move_uploaded_file($data["sample"]["tmp_name"], $new_file)) {
      //  echo "The file ". basename( $data["sample"]["name"]). " has been uploaded.";
    } else {
       // echo "Sorry, there was an error uploading your file.";
    }
}
$new_file_url = $upload_dir.$new_file_name;
return array('new_file_name' =>$new_file_url,
              'new_file_url' => '/assets/application/samples/'.$upload_dir.$new_file_name);
  }     



}

/*

private function prepareImages()
{
    $adapter = new Http();

    $size = new Size(array('min' => '10kB', 'max' => '5MB','useByteString' => true));
    $extension = new Extension(array('jpg','gif','png','jpeg','bmp','webp','svg'), true);

    if (extension_loaded('fileinfo')) {
        $adapter->setValidators([new IsImage()]);
    }

    $adapter->setValidators([$size, $extension]);

    $adapter->setDestination('public/userfiles/images/');

    return $this->uploadFiles($adapter);
}


private function uploadFiles(Http $adapter)
{
    $uploadStatus = [];

    foreach ($adapter->getFileInfo() as $key => $file) {
        if (!$adapter->isValid($file["name"])) {
            foreach ($adapter->getMessages() as $key => $msg) {
                $uploadStatus["errorFiles"][] = $file["name"]." ".strtolower($msg);
            }
        }

        if (!$adapter->receive($file["name"])) {
            $uploadStatus["errorFiles"][] = $file["name"]." was not uploaded";
        } else {
            $uploadStatus["successFiles"][] = $file["name"]." was successfully uploaded";
        }
    }
    return $uploadStatus;
}


*/