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

class KaruselController extends AbstractActionController
{
    public function updatekaruselAction()
    {
             $data = $_POST;
             
/* ["title_windowkarusel"]=>
  string(6) "??????"
  ["id_window"]=>
  string(1) "1"
  ["data"]=>
  array(6) {
    [0]=>
    array(8) {
      ["id"]=>
      string(1) "1"
      ["type_karusel"]=>
      string(1) "1"
      ["url_picture"]=>
      string(27) "data/uploads/1459143614.jpg"
      ["id_photo"]=>
      string(2) "11"
      ["id_folio"]=>
      string(1) "0"
      ["title_karusel"]=>
      string(0) ""
      ["subtitle_karusel"]=>
      string(0) ""
      ["text_karusel"]=>
      string(0) ""
    } */
       $windowkaruselSrv = $this -> getServiceLocator()->get('windowkarusel');
       $windowkaruselSrv -> updateWindowkarusel(array(
                     "id"                    => $data["id_window"],
                     "title_windowkarusel"   => $data["title_windowkarusel"]
        ));

       foreach ($data["data"] as $i => $set) {
         $newdata[$i] = $set;
                   if ($set["type_karusel"] == "1"){

                             if(isset($set["url_photo"]) && $set["url_photo"]){
                                     $photoSrv = $this -> getServiceLocator()->get('photos');
                                     $id_photo = $photoSrv -> insertPhoto(array(
                                          "url_photo" => $set["url_photo"],
                                          "id_folio"  => 0,

                                      ));
                             }else{
                                      $id_photo = $set["id_photo"];
                             }
                           }

        $karuselSrv  = $this -> getServiceLocator()->get('karusel');

        $karuselSrv -> updateKarusel(array(                
                                  "id"                => $set["id"],
                                  "type_karusel"      => $set["type_karusel"],
                                  "text_karusel"      => $set["text_karusel"],
                                  "window_karusel"    => $data["id_window"],
                                  "numframe_karusel"  => $set["numframe_karusel"],
                                  "id_photo"          => $id_photo,
                                  "id_folio"          => $set["id_folio"],
                                  "title_karusel"     => $set["title_karusel"],
                                  "subtitle_karusel"  => $set["subtitle_karusel"],
                          ));


       }

        return new JsonModel ( array (
              
                  'data' => $newdata,
                  
                
        ) );
             
                
    }

    public function ajaxdelkaruselAction(){

           $data = $_POST;
           $karuselSrv  = $this -> getServiceLocator()->get('karusel');

           $karuselSrv -> delKaruselByWind($data["id"]);
           $windowkaruselSrv = $this -> getServiceLocator()->get('windowkarusel');
           $windowkaruselSrv->delWindowkarusel($data["id"]);           
          /* $karusels = $karuselSrv -> getKaruselByWind($data["id"]);
           foreach ($karusels as $key => $value) {
                   $karuselSrv->delKarusel($value['id']);
           }
           $windowkaruselSrv = $this -> getServiceLocator()->get('windowkarusel');
           $windowkaruselSrv->delWindowkarusel($data["id"]);*/
            return new JsonModel ( array (
              
                  'id' => $data['id'],
                  
                
        ) );
    }
public function addkaruselAction(){

         $data = $_POST;

         /*

{"data":{"title_windowkarusel":"qweqweqwe",
          "data"             :[{
                 "numframe_karusel":"1",
                 "type_karusel":"1",
                 "url_photo":"data\/uploads\/1461515575.jpeg",
                 "id_photo":"0",
                 "id_folio":"1",
                 "title_karusel":"qwe",
                 "subtitle_karusel":"qwe",
                 "text_karusel":""
                 },
                 {"numframe_karusel":"1",
                 "type_karusel":"2",
                 "id_folio":"0",
                 "title_karusel":"",
                 "subtitle_karusel":"",
                 "text_karusel":"qweqweqweqwe qweqweqwe "
                 },
                 {"numframe_karusel":"1",
                 "type_karusel":"1",
                 "url_photo":"0","id_photo":"3","id_folio":"2","title_karusel":"qwe","subtitle_karusel":"qwe","text_karusel"
:""},{"numframe_karusel":"1","type_karusel":"2","id_folio":"0","title_karusel":"","subtitle_karusel"
:"","text_karusel":"qweqweqwe"},{"numframe_karusel":"1","type_karusel":"2","id_folio":"0","title_karusel"
:"","subtitle_karusel":"","text_karusel":"qweqweqwe"},{"numframe_karusel":"1","type_karusel":"2","id_folio"
:"0","title_karusel":"","subtitle_karusel":"","text_karusel":"qweqweqwe"}]}}
         */

       $windowkaruselSrv = $this -> getServiceLocator()->get('windowkarusel');
       $id_window = $windowkaruselSrv -> insertWindowkarusel(array(
                     "title_windowkarusel"   => $data["title_windowkarusel"]
        ));
      foreach ($data["data"] as $i => $set) {
         $newdata[$i] = $set;
                   if ($set["type_karusel"] == "1"){

                             if(isset($set["url_photo"]) && $set["url_photo"]){
                                     $photoSrv = $this -> getServiceLocator()->get('photos');
                                     $id_photo = $photoSrv -> insertPhoto(array(
                                          "url_photo" => $set["url_photo"],
                                          "id_folio"  => 0,

                                      ));
                             }else{
                                      $id_photo = $set["id_photo"];
                             }
                           }

        $karuselSrv  = $this -> getServiceLocator()->get('karusel');

        $karuselSrv -> insertKarusel(array(                
                                 
                                  "type_karusel"      => $set["type_karusel"],
                                  "text_karusel"      => $set["text_karusel"],
                                  "window_karusel"    => $id_window,
                                  "numframe_karusel"  => $set["numframe_karusel"],
                                  "id_photo"          => $id_photo,
                                  "id_folio"          => $set["id_folio"],
                                  "title_karusel"     => $set["title_karusel"],
                                  "subtitle_karusel"  => $set["subtitle_karusel"],
                          ));


       }

         return new JsonModel(array(

             'data'       => $data,
             'window_id'  => $id_window
          ));

}
    
 
         
 
}
