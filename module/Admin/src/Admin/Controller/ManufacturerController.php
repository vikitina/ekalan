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

class ManufacturerController extends AbstractActionController
{


  public function manufacturersAction(){
                $manufacturerSrv    =  $this -> getServiceLocator()->get('manufacturer');  
                $manufacturers      =  $manufacturerSrv->getAllManufacturers();
         return new ViewModel(array(
                'manufacturers'   => $manufacturers,
            ));
  }
  public function manufactureropenAction(){


         $id               = $this->getEvent()->getRouteMatch()->getParam('id');
         $manufacturerSrv  =  $this -> getServiceLocator()->get('manufacturer');  
         $collectionSrv    = $this -> getServiceLocator()->get('collection');
         $manufacturer     =  $manufacturerSrv->getManufacturer((int)$id);
         $collections      = $collectionSrv->getCollectionByManuf((int)$id);

         $manufacturer['url_picture_prepared'] = ((isset($manufacturer['url_picture']) &&  $manufacturer['url_picture'] != '' &&  $manufacturer['url_picture'] !=null)?"/assets/application/samples/".trim($manufacturer['url_picture']):"/assets/application/img/no_photo.png");


      if ($_POST){
                  $data = $_POST;
                  


                  if (isset($data['id_picture']) && $data['id_picture']){

                         /* $picturesSrv ->updatePicture(array(
                                    "id"          => (int)$data['id_picture'],
                                    "url_picture" => ($data["url_picture"][0])?$data["url_picture"][0]:0
                            ));*/
                        $id_picture = $data['id_picture'];

                  }else{

                  $url_picture = ($data["url_picture"][0])?$data["url_picture"][0]:0;
                  if($data["url_picture"] && isset($data["url_picture"])) {
                           $picture_data = array(
                                    "url_picture" => $url_picture,
                            );
                             $picturesSrv = $this -> getServiceLocator()->get('pictures');
                             $id_picture = $picturesSrv -> insertPicture($picture_data);
                  }

                  $id_picture = ($id_picture) ? $id_picture : 0;

                  }      
                  $manufacturerSrv -> updateManufacturer(array(
                         'id'                  => $data['id'],
                         'name_manufacturer'   => $data['name_manufacturer'],
                         'id_picture'          => $id_picture

                    ));

$this->redirect()->toRoute('zfcadmin/admin_manufacturers');

  }

           return new ViewModel(array(
                'manufacturer'   => $manufacturer,
                'collections'    => $collections 

            )); 
         }
 
}
