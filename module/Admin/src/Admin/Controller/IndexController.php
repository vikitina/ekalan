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

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $pagesSrv    = $this -> getServiceLocator()->get('pages');
        $pages = array();
        $pages = $pagesSrv ->  getPages(); 
        //var_dump($pages);

        
        return new ViewModel(array(
             
                'pages'  => $pages
        ));
    }
    public function mainpageAction(){


      
    }
   public function pageAction()
    {
        $page_id = $this->getEvent()->getRouteMatch()->getParam('id');
        //var_dump($page_id);
        $pagesSrv    = $this -> getServiceLocator()->get('pages');
        $pages = array();
        $pages = $pagesSrv ->  getPages($page_id); 
        $page = $pages[0];


        return new ViewModel(array(
             
                'page'  => $page
        ));
    }

   public function updatepageAction(){

               $param = array();
               $param = $this->params()->fromPost();
             
               $pagesSrv = $this -> getServiceLocator()->get('pages');
               if (isset($param['id'])&&$param['id']){
                       $page =     $pagesSrv ->  updatePages($param);
               }else{
                      $page =     $pagesSrv ->  insertPages($param);

               }
              
               $this->redirect()->toRoute('zfcadmin/admin_pages');
              
        } 

  public function msgsAction()
    {
    
        $msgSrv    = $this -> getServiceLocator()->get('message');
        $msgs = array();
        $msgs = $msgSrv ->  getMessages(); 
        


        return new ViewModel(array(
             
                'msgs'  => $msgs
        ));
    }     

public function msgopenAction()
    {
        $msg_id = $this->getEvent()->getRouteMatch()->getParam('id');
        
        $msgSrv    = $this -> getServiceLocator()->get('message');
        $msgs = array();
        $msg = $msgSrv ->  getMessage((int)$msg_id); 
        $msg['already_read'] = 1;
        $msg['once_opened'] = 1;
        $msgSrv->updateMsg( $msg);
        
//var_dump($msg);

        return new ViewModel(array(
             
                'msg'  => $msg
        ));
    }    

public function materialsAction()
    {
        $materialSrv    = $this -> getServiceLocator()->get('material');
        $manufacturerSrv    = $this -> getServiceLocator()->get('manufacturer');
        $colorSrv    = $this -> getServiceLocator()->get('color');
        $textureSrv    = $this -> getServiceLocator()->get('texture');

        $filters['manufacturers'] = $manufacturerSrv->getAllManufacturers();
        $filters['colors'] = $colorSrv->getAllColors();
        $filters['textures'] = $textureSrv->getAllTextures();        
        
        $limit = 10;
        $data['limit'] = $limit;
        $set_material = $materialSrv->getSpecOrder($data);
        $partial = $this->getServiceLocator()->get('viewhelpermanager')->get('partial');
        $set_material_html = $partial('material/adminmaterialset', array("key" => $set_material['result']));  
     
        $rowcount = $set_material['rowcount'];

       
             
        return new ViewModel(array(
            'materials' => $set_material_html,
            'filters'   => $filters,
            'rowcount'  => $rowcount,
            'limit'     => $limit            
        ));
    }

public function materialopenAction()
    {
        $material_id = $this->getEvent()->getRouteMatch()->getParam('id');
        
        $materialSrv      = $this -> getServiceLocator()->get('material');
        $manufacturerSrv  = $this -> getServiceLocator()->get('manufacturer');
        $material = $materialSrv ->  getMaterial((int)$material_id); 

        $lists['manufacturers'] = $manufacturerSrv->getAllManufacturers();
 

        return new ViewModel(array(
             
                'material'  => $material['set'],
                'lists'     => $lists,
        ));
    } 

  public function addmaterialAction(){

            $materialSrv      = $this -> getServiceLocator()->get('material');
            $manufacturerSrv  = $this -> getServiceLocator()->get('manufacturer');
            $textureSrv       = $this -> getServiceLocator()->get('texture');
            $colorSrv         = $this -> getServiceLocator()->get('color');
            $sampleSrv        = $this -> getServiceLocator()->get('sample');
            $analogSrv        = $this -> getServiceLocator()->get('analogs');

          if($_POST)  {
              $data = $_POST;
              $sample = $this->uploadfile($_FILES);
              //add sample

              $id_sample = $sampleSrv->insertSample($sample);
              $new_material = array(
                     'articul'             => $data['articul'],
                     'name_material'       => $data['name_material'],
                     'price_material'      => $data['price_material'],
                     'id_manufacturer'     => $data['id_manufacturer'],
                     'id_sample'           => $id_sample,
                     'id_color'            => $data['id_color'],
                     'id_texture'          => $data['id_texture'],
                     'id_collection'       => $data['id_collection'],
              );
              $id_material = $materialSrv->insertMaterial($new_material);

              //if isset !!!
              $list_analogs = $data['analogs'];
              $arr_analogs = explode(',', $list_analogs);

              foreach ($arr_analogs as $item) {
                  $analogSrv->insertAnalog(array(
                        'id_1' => $id_material,
                        'id_2' => $item
                    ));
              }

            }
            $lists['manufacturers'] = $manufacturerSrv->getAllManufacturers();
            $set_material           = $materialSrv->getSpecOrder();
            $lists['textures']      = $textureSrv->getAllTextures();
            $lists['colors']        = $colorSrv->getAllColors();
            $lists['samples']       = $sampleSrv->getAllSamples();

//name_material=name&sample=bul.png&articul=art&id_manufacturer=1&id_color=1&id_texture=1&articul=123&analogs=%2C4%2C5%2C7%2C8%2C9

            
     
         //   $modal_material_list_html

         return new ViewModel(array(

                  'lists'     => $lists,
                  
            ));

  } 


function uploadfile($data){






      $target_dir = "/var/www/ekalan/public/data/uploads/";

      $target_file = $target_dir . basename($data["sample"]["name"]);
      echo '<br>'.$target_file;
      $uploadOk = 1;
      $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
      echo '<br>'.$imageFileType;
// Check if image file is a actual image or fake image

      $check = getimagesize($data["sample"]["tmp_name"]);
      if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($data["sample"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    $new_file = $target_dir.'asdasdasd'.".".$imageFileType;
    if (move_uploaded_file($data["sample"]["tmp_name"], $new_file)) {
        echo "The file ". basename( $data["sample"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

return $new_file;
  }      

}
