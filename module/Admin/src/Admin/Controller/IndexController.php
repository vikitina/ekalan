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
            foreach ($set_material['result'] as $key => $item) {
                $set_material['result'][$key]['url'] = ((isset($item['url']) && $item['url'] != '' && $item['url'] !=null)?"/assets/application/samples/".trim($item['url']):"/assets/application/img/no_photo.png");
            }

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
            $textureSrv       = $this -> getServiceLocator()->get('texture');
            $colorSrv         = $this -> getServiceLocator()->get('color');
            $sampleSrv        = $this -> getServiceLocator()->get('sample');
            $analogSrv        = $this -> getServiceLocator()->get('analogs');
            $collectionSrv    = $this -> getServiceLocator()->get('collection');



            $material = $materialSrv ->  getMaterial((int)$material_id); 

            $lists['manufacturers'] = $manufacturerSrv->getAllManufacturers();
            $lists['textures']      = $textureSrv->getAllTextures();
            $lists['colors']        = $colorSrv->getAllColors();
            $lists['samples']       = $sampleSrv->getAllSamples();
            $lists['collections']   = $collectionSrv->getCollectionByManuf($material['set']['id_manufacturer']);
            $set_material           = $materialSrv->getSpecOrder(array('exclude' => $material_id));


            $material['set']['url'] = ((isset($material['set']['url']) && $material['set']['url'] != '' && $material['set']['url'] !=null)?"/assets/application/samples/".trim($material['set']['url']):"/assets/application/img/no_photo.png");

            $list_materials_for_analogs = $set_material['result'];
            $i = 0; 
            foreach($list_materials_for_analogs as $item){
                    $list_materials_for_analogs[$i]['url'] = ((isset($item['url']) && $item['url'] != '' && $item['url'] !=null)?"/assets/application/samples/".trim($item['url']):"/assets/application/img/no_photo.png");
                    $i += 1;
            }
            $lists['materials']      = $list_materials_for_analogs;
            

            foreach ($lists['samples'] as $key => $item) {
                $lists['samples'][$key]['url'] = ((isset($item['url']) && $item['url'] != '' && $item['url'] !=null)?"/assets/application/samples/".trim($item['url']):"/assets/application/img/no_photo.png");
            }

            $set_analogs_id = $analogSrv->getAnalogForId($material_id);
            
            $i = 0;

            $str_analogs = '';
            foreach ($set_analogs_id as $analog_id) {
                $set = $materialSrv ->  getMaterial((int)$analog_id['id_2']);
                $key = $analog_id['id_2'].'';
                $list_analog_for_check[$key] = 1;
                $str_analogs .= (($i > 0)?',':''). $analog_id['id_2'];
                $analogs[$i] = $set['set'];
                $analogs[$i]['url'] = ((isset($analogs[$i]['url']) && $analogs[$i]['url'] != '' && $analogs[$i]['url'] !=null)?"/assets/application/samples/".trim($analogs[$i]['url']):"/assets/application/img/no_photo.png");
                $i += 1;
            }
            $lists['analogs'] = $analogs;
            $hash_collections = $this->createHashCollections($lists['manufacturers'],$collectionSrv);
            $lists['list_analog_for_check'] = $list_analog_for_check;
            $lists['str_analogs'] = $str_analogs;
        return new ViewModel(array(
             
                'material'           => $material['set'],
                'lists'              => $lists,
                'hash_collections'   => $hash_collections,
        ));
    } 

public function delmaterialAction()
    {
            $id = $this->getEvent()->getRouteMatch()->getParam('id');
        
            $materialSrv      = $this -> getServiceLocator()->get('material');
            $sampleSrv        = $this -> getServiceLocator()->get('sample');
            $analogSrv        = $this -> getServiceLocator()->get('analogs');
            

            $material = $materialSrv->getMaterial($id);
            $materialSrv->delMaterial($id);
            $id_sample = $material['set']['id_sample'];
            $sampleSrv -> delSample($id_sample);

            $analogSrv->delAllAboutId($id);


            $this->redirect()->toRoute('zfcadmin/admin_materials');
           //  return new ViewModel(array());
    }     

  public function addmaterialAction(){

            $materialSrv      = $this -> getServiceLocator()->get('material');
            $manufacturerSrv  = $this -> getServiceLocator()->get('manufacturer');
            $textureSrv       = $this -> getServiceLocator()->get('texture');
            $colorSrv         = $this -> getServiceLocator()->get('color');
            $sampleSrv        = $this -> getServiceLocator()->get('sample');
            $analogSrv        = $this -> getServiceLocator()->get('analogs');
            $collectionSrv    = $this -> getServiceLocator()->get('collection');

          if($_POST)  {
              $data = $_POST;
              //$sample = $this->uploadfile($_FILES);
              //add sample
              //$sample_data['url'] = $sample;
              //$id_sample = $sampleSrv->insertSample($sample_data);
              //var_dump($id_sample);
//var_dump($data);
            if($data['new_sample'] != '0'){

                $id_sample = $sampleSrv->insertSample(array('url' => $data['new_sample']));
            }else{
                $id_sample = $data['id_sample'];

            }
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

              
              $list_analogs = $data['analogs'];
              $arr_analogs = explode(',', $list_analogs);

              foreach ($arr_analogs as $item) {
                
                if (!$analogSrv->getAnalog($id_material,$item)){
                     $analogSrv->insertAnalog(array(
                        'id_1' => $id_material,
                        'id_2' => $item
                    ));
                 }
                 
                if (!$analogSrv->getAnalog($item,$id_material)){
                     $analogSrv->insertAnalog(array(
                        'id_2' => $id_material,
                        'id_1' => $item
                    ));
                 }                 

              }
                   $this->redirect()->toRoute('zfcadmin/admin_materials');
            }

            $lists['manufacturers'] = $manufacturerSrv->getAllManufacturers();
            $set_material           = $materialSrv->getSpecOrder();
            $lists['textures']      = $textureSrv->getAllTextures();
            $lists['colors']        = $colorSrv->getAllColors();
            $lists['samples']       = $sampleSrv->getAllSamples();

            foreach ($lists['samples'] as $key => $item) {
                $lists['samples'][$key]['url'] = ((isset($item['url']) && $item['url'] != '' && $item['url'] !=null)?"/assets/application/samples/".trim($item['url']):"/assets/application/img/no_photo.png");
            }


            $lists['collections']   = $collectionSrv->getCollectionByManuf('1');
           
            $list_materials_for_analogs = $set_material['result'];
            $i = 0; 
            foreach($list_materials_for_analogs as $item){
                    $list_materials_for_analogs[$i]['url'] = ((isset($item['url']) && $item['url'] != '' && $item['url'] !=null)?"/assets/application/samples/".trim($item['url']):"/assets/application/img/no_photo.png");
                    $i += 1;
            }
            $lists['materials']      = $list_materials_for_analogs;
            $hash_collections = $this->createHashCollections($lists['manufacturers'],$collectionSrv);


//name_material=name&sample=bul.png&articul=art&id_manufacturer=1&id_color=1&id_texture=1&articul=123&analogs=%2C4%2C5%2C7%2C8%2C9

            
     
         //   $modal_material_list_html

         return new ViewModel(array(

                  'lists'                => $lists,
                  'hash_collections'     => $hash_collections,
            ));

  } 


  public function updatematerialAction(){

/*
<input type="hidden" value="477" name="id">
<input id="name_material" type="hidden" value="aaaaa" name="name_material">
<input id="articul" type="hidden" value="aaaa" name="articul">
<input id="price_material" type="hidden" value="12333" name="price_material">
<input id="id_manufacturer" type="hidden" value="1" name="id_manufacturer">
<input id="id_manufacturer" type="hidden" value="1" name="id_manufacturer">
<input id="id_collection" type="hidden" value="1" name="id_collection">
<input id="id_color" type="hidden" value="1" name="id_color">
<input id="id_sample" type="hidden" value="1" name="id_sample">
<input id="new_sample" type="hidden" value="0" name="new_sample">
<input id="id_texture" type="hidden" value="1" name="id_texture">
<input id="form_analogs_list" type="hidden" value="5,6,8,9,10,12,13" name="analogs">


*/
            $materialSrv      = $this -> getServiceLocator()->get('material');
            $sampleSrv        = $this -> getServiceLocator()->get('sample');
            $analogSrv        = $this -> getServiceLocator()->get('analogs');

            $data_post = $_POST;

            if($data_post['new_sample'] != '0'){

                $id_sample = $sampleSrv->insertSample(array('url' => $data_post['new_sample']));
            }else{
                $id_sample = $data_post['id_sample'];

            }
            
            $data = array(
                     'id'                =>   $data_post['id'],
                     'name_material'     =>   $data_post['name_material'],
                     'articul'           =>   $data_post['articul'],
                     'price_material'    =>   $data_post['price_material'],
                     'id_manufacturer'   =>   $data_post['id_manufacturer'],
                     'id_collection'     =>   $data_post['id_collection'],       
                     'id_color'          =>   $data_post['id_color'], 
                     'id_sample'         =>   $id_sample,
                     'id_texture'        =>   $data_post['id_texture'],  
                     'describe_material' =>   $data_post['describe_material']                   


                );  
               
            $materialSrv->updateMaterial($data);
            if($data_post['analogs'] != 0){

                $analogSrv->delAllAboutId((int)$data_post['id']);

                $analogs = explode(',',$data_post['analogs']);
                foreach ($analogs as $analog) {
                    $analogSrv->insertAnalog(array(
                        'id_1' => $data_post['id'],
                        'id_2' => $analog
                    )); 
                    $analogSrv->insertAnalog(array(
                        'id_2' => $data_post['id'],
                        'id_1' => $analog
                    )); 

                }
            }

            $this->redirect()->toRoute('zfcadmin/admin_materials');

  }
function createHashCollections($list,$collectionSrv){


            $hash_collections = '{';
            $f1 = 0;
            foreach ($list as $manuf){

                 if($f1 > 0){$hash_collections .= ',';}

                 $hash_collections .=  "'".$manuf['id']."':{'name':'".$manuf['name_manufacturer']."','collections':{";
                 $f2 = 0;
                 $collections = $collectionSrv->getCollectionByManuf($manuf['id']);
                 foreach ($collections as $collect) {
                     if ($f2 > 0){
                          $hash_collections .= ',';
                     }
                      $hash_collections .= "'".$collect['id']."':'".$collect['name_collection']."'";
                     $f2 = 1;
                  } 

                 $hash_collections .= "}}";
                 $f1 = 1;
            }
            $hash_collections .= "}";
            return   $hash_collections;  
}

function uploadfile($data){


      $constantsSrv       = $this -> getServiceLocator()->get('constants');
      $upload_dir         = trim($constantsSrv->getConstantByName('upload_dir'));
      $path_to_upload_dir = trim($constantsSrv->getConstantByName('path_to_upload_dir'));




      $target_dir = $path_to_upload_dir.$upload_dir;

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
    $new_file_name = time().".".$imageFileType;
    $new_file = $target_dir.$new_file_name;
    if (move_uploaded_file($data["sample"]["tmp_name"], $new_file)) {
        echo "The file ". basename( $data["sample"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
$new_file_url = $upload_dir.$new_file_name;
return $new_file_url;
  }      

}
