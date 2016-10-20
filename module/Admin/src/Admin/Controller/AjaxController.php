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

public function delcategoryAction(){

         $data = $_POST;
         $status_dict = array('candel','cannotdel');
         switch ($data['name_cat']) {
           case 'manufacturer':
                  $materialSrv    = $this -> getServiceLocator()->get('material');
                  $result = $materialSrv -> getMaterialByManufacturer((int)$data['id_cat']);
                  
                break;
           case 'collection':
                  $materialSrv    = $this -> getServiceLocator()->get('material');
                  $result = $materialSrv -> getMaterialByCollection((int)$data['id_cat']);
             break;
           case 'color':
                  $materialSrv    = $this -> getServiceLocator()->get('material');
                  $result = $materialSrv -> getMaterialByColor((int)$data['id_cat']);             
             break;
            case 'texture':
                  $materialSrv    = $this -> getServiceLocator()->get('material');
                  $result = $materialSrv -> getMaterialByTexture((int)$data['id_cat']);              
             break;
           case 'group':
                 $folioSrv    = $this -> getServiceLocator()->get('folio');
                 $result = $folioSrv -> getFolioByGroup((int)$data['id_cat']);
             break;
          
           default:
             # code...
             break;
         }

             $status = ($result) ? $status_dict[1] : $status_dict[0];

             return  $status = new JsonModel ( array (
              
                       'status'      => $status,
                       'res'         => $result
                      
                
               ) );

      /*  $manufacturerSrv    = $this -> getServiceLocator()->get('manufacturer');
          $colorSrv    = $this -> getServiceLocator()->get('color');
          $textureSrv    = $this -> getServiceLocator()->get('texture');    
          $groupSrv                   = $this -> getServiceLocator()->get('groups');
          $collectionSrv    = $this -> getServiceLocator()->get('collection');
            */
}  
public function deletingcategoryAction(){

         $data = $_POST;
         $status_dict = array('candel','cannotdel');
         switch ($data['name_cat']) {
           case 'manufacturer':
                  $manufacturerSrv    = $this -> getServiceLocator()->get('manufacturer');
                  $manufacturerSrv -> delManufacturer($data['id_cat']);
                break;
           case 'collection':
                 $collectionSrv  = $this -> getServiceLocator()->get('collection');
                 $collectionSrv -> delCollection($data['id_cat']);
             break;
           case 'color':
                  $colorSrv      = $this -> getServiceLocator()->get('color'); 
                  $colorSrv -> delColor($data['id_cat']);         
             break;
            case 'texture':
                  $textureSrv    = $this -> getServiceLocator()->get('texture');     
                  $textureSrv -> delTexture($data['id_cat']);          
             break;
           case 'group':
                 $groupSrv       = $this -> getServiceLocator()->get('groups');
                 $groupSrv -> delGroup($data['id_cat']);
             break;
          
           default:
             # code...
             break;
         }

             $status = ($result) ? $status_dict[1] : $status_dict[0];

             return  $status = new JsonModel ( array (
              
                       'status'      => $status,
                       'res'         => $result
                      
                
               ) );

      /*  $manufacturerSrv    = $this -> getServiceLocator()->get('manufacturer');
          $colorSrv    = $this -> getServiceLocator()->get('color');
          $textureSrv    = $this -> getServiceLocator()->get('texture');    
          $groupSrv                   = $this -> getServiceLocator()->get('groups');
          $collectionSrv    = $this -> getServiceLocator()->get('collection');
            */
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
   public function reloadcollectionsAction(){
          $data = $_POST;
          $collectionSrv    = $this -> getServiceLocator()->get('collection');
          $collections = $collectionSrv->getCollectionByManuf((int)$data['id']);
          return  $result = new JsonModel ( array (
              
                       'collections'      => $collections
                       
                
               ) );   

   }

   public function getmanufacturerbycollectionAction(){

          $data = $_POST;
          $collectionSrv    = $this -> getServiceLocator()->get('collection');
          $collection = $collectionSrv -> getCollection($data['id']);
          return  $result = new JsonModel ( array (
              
                       'id_manufacturer'   => $collection['id_manufacturer']
                       
                
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
   public function pricinggroupAction(){

         $data = $_POST;
         $materialSrv = $this -> getServiceLocator()->get('material');
         $ids_arr = explode(',',$data['pricing_list']);

         foreach ($ids_arr as $id) {
               $materialSrv -> updatePriceMaterial(array(
                       'id'               => (int)$id,
                       'price'            => $data['price'],
                       'processing_price' => $data['processing_price']
                   ));
        
         } }

   //deletinggroup
   public function deletinggroupAction(){

         $data = $_POST;
         $materialSrv      = $this -> getServiceLocator()->get('material');
         $analogSrv        = $this -> getServiceLocator()->get('analogs');
         $ids_arr = explode(',',$data['deleting_list']);

         foreach ($ids_arr as $id) {  
          
               $analogSrv->delAllAboutId((int)$id);         
               $materialSrv->delMaterial((int)$id);
       } }
 

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


public function ajaxtextureupdateAction(){

      $data = $_POST;
      $d['id'] = $data['id'];
      $d['name_texture'] = $data['name_texture'];
      var_dump($data);
      $textureSrv    = $this -> getServiceLocator()->get('texture');
      $res = $textureSrv->updateTexture($d);
      return new JsonModel(array());

}
public function ajaxmanufupdateAction(){

      $data = $_POST;
      $manufSrv    = $this -> getServiceLocator()->get('manufacturer');
      $res = $manufSrv->updateManufacturer($data);
      return new JsonModel(array());


}
public function ajaxcolorupdateAction(){

      $data['id'] = (int)$_POST['id'];
      $data['name_color'] = $_POST['name_color'];
      $data['color_color'] = $_POST['color_color'];
      $colorSrv    = $this -> getServiceLocator()->get('color');
      $res = $colorSrv->updateColor($data);
      return new JsonModel(array());


}

public function ajaxgroupupdateAction(){

      $data = $_POST;
      $d['id'] = $data['id'];
      $d['name_group'] = $data['name_group'];
      $groupSrv    = $this -> getServiceLocator()->get('groups');
      $res = $groupSrv->updateGroup($d);
      return new JsonModel(array('res' => 1));


}

public function ajaxaddgroupAction(){
      $data = $_POST;
      $groupSrv    = $this -> getServiceLocator()->get('groups');
      $id = $groupSrv->insertGroup($data);
      $partial = $this->getServiceLocator()->get('viewhelpermanager')->get('partial');
      $group_data = array("id" => $id,'name_group'=>$data['name_group']);
      $li = $partial('newgroupelement', array('key' => $group_data));       
      return new JsonModel(array(
             'li' => $li
        ));  
}
public function ajaxaddtextureAction(){
       $data = $_POST;
       $textureSrv    = $this -> getServiceLocator()->get('texture');
       $id = $textureSrv -> insertTexture($data);
       $partial = $this->getServiceLocator()->get('viewhelpermanager')->get('partial');
       $texture_data = array("id" => $id,'name_texture'=>$data['name_texture']);
       $li = $partial('newtextureelement', array('key' => $texture_data)); 
             return new JsonModel(array(
             'li' => $li
        )); 
}

public function ajaxaddcolorAction(){

       $data = $_POST;
       $colorSrv    = $this -> getServiceLocator()->get('color');

       $data['color_color']='#dddeee';
       $id = $colorSrv -> insertColor($data);
       $partial = $this->getServiceLocator()->get('viewhelpermanager')->get('partial');
       $color_data = array("id" => $id,"name_color"=>$data['name_color']);
       $li = $partial('newcolorelement', array('key' => $color_data)); 
       return new JsonModel(array(
             'li' => $li
        )); 

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

   public function addphotoAction(){

             $request = $this->getRequest();
            // $data = [];

             if ($request->isXmlHttpRequest()) {
             $url = $this->uploadFile($_FILES);
    }

    return new JsonModel(array('url' => $url['new_file_url'],
                              'name' => $url['new_file_name']));
}    
   

public function ajaxcropingAction(){
       $data = $_POST;

       $params = json_decode(stripslashes($data['data']));
       $src = $data['src'];
       $r = $this->crop($src, $src, $params);
   return new JsonModel(array( 
         'r' => $r,
         'p' => $params,
         'r1' => $src
    ));  
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

   //   $check = getimagesize($data["sample"]["tmp_name"]);
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
if ($data["sample"]["size"] > 5000000000) {
   // echo "Sorry, your file is too large.";
    //$uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
  //  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
//if ($uploadOk == 0) {
    //echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
//} else {
    $new_file_name = time().".".$imageFileType;
    $new_file = $target_dir.$new_file_name;
    if (move_uploaded_file($data["sample"]["tmp_name"], $new_file)) {
      //  echo "The file ". basename( $data["sample"]["name"]). " has been uploaded.";
    } else {
       // echo "Sorry, there was an error uploading your file.";
//    }
}
$new_file_url = $upload_dir.$new_file_name;
return array('new_file_name' =>$new_file_url,
              'new_file_url' => '/assets/application/samples/'.$upload_dir.$new_file_name);
  }     


function crop($src, $dst, $data) {
$src1 = $src;
     $constantsSrv       = $this -> getServiceLocator()->get('constants');
      $upload_dir         = trim($constantsSrv->getConstantByName('upload_dir'));
      $src = $upload_dir.$src;


    if (!empty($src) && !empty($dst) && !empty($data)) {
      $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
      switch ($imageFileType) {
        case "gif":
          $src_img = imagecreatefromgif($src);
          break;

        case "jpeg":
          $src_img = imagecreatefromjpeg($src);
          break;

        case "png":
          $src_img = imagecreatefrompng($src);
          break;
      }

      if (!$src_img) {
        $msg = "Failed to read the image file";
        return;
      }
/*
      $size = getimagesize($src);
      $size_w = $size[0]; // natural width
      $size_h = $size[1]; // natural height

      $src_img_w = $size_w;
      $src_img_h = $size_h;

      $degrees = $data -> rotate;

      // Rotate the source image
      if (is_numeric($degrees) && $degrees != 0) {
        // PHP's degrees is opposite to CSS's degrees
        $new_img = imagerotate( $src_img, -$degrees, imagecolorallocatealpha($src_img, 0, 0, 0, 127) );

        imagedestroy($src_img);
        $src_img = $new_img;

        $deg = abs($degrees) % 180;
        $arc = ($deg > 90 ? (180 - $deg) : $deg) * M_PI / 180;

        $src_img_w = $size_w * cos($arc) + $size_h * sin($arc);
        $src_img_h = $size_w * sin($arc) + $size_h * cos($arc);

        // Fix rotated image miss 1px issue when degrees < 0
        $src_img_w -= 1;
        $src_img_h -= 1;
      }

      $tmp_img_w = $data -> width;
      $tmp_img_h = $data -> height;
      $dst_img_w = 220;
      $dst_img_h = 220;

      $src_x = $data -> x;
      $src_y = $data -> y;

      if ($src_x <= -$tmp_img_w || $src_x > $src_img_w) {
        $src_x = $src_w = $dst_x = $dst_w = 0;
      } else if ($src_x <= 0) {
        $dst_x = -$src_x;
        $src_x = 0;
        $src_w = $dst_w = min($src_img_w, $tmp_img_w + $src_x);
      } else if ($src_x <= $src_img_w) {
        $dst_x = 0;
        $src_w = $dst_w = min($tmp_img_w, $src_img_w - $src_x);
      }

      if ($src_w <= 0 || $src_y <= -$tmp_img_h || $src_y > $src_img_h) {
        $src_y = $src_h = $dst_y = $dst_h = 0;
      } else if ($src_y <= 0) {
        $dst_y = -$src_y;
        $src_y = 0;
        $src_h = $dst_h = min($src_img_h, $tmp_img_h + $src_y);
      } else if ($src_y <= $src_img_h) {
        $dst_y = 0;
        $src_h = $dst_h = min($tmp_img_h, $src_img_h - $src_y);
      }

      // Scale to destination position and size
      $ratio = $tmp_img_w / $dst_img_w;
      $dst_x /= $ratio;
      $dst_y /= $ratio;
      $dst_w /= $ratio;
      $dst_h /= $ratio;

      $dst_img = imagecreatetruecolor($dst_img_w, $dst_img_h);

      // Add transparent background to destination image
      imagefill($dst_img, 0, 0, imagecolorallocatealpha($dst_img, 0, 0, 0, 127));
      imagesavealpha($dst_img, true);

      $result = imagecopyresampled($dst_img, $src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);

      if ($result) {
        if (!imagepng($dst_img, $dst)) {
          $msg = "Failed to save the cropped image file";
        }
      } else {
        $msg = "Failed to crop the image file";
      }

      imagedestroy($src_img);
      imagedestroy($dst_img);
   */ }

    return $src;
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