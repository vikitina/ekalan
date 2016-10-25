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
use Zend\View\Model\JsonModel;



class MaterialController extends AbstractActionController
{
    public function indexAction()
    {
       	$get_data = $this->getEvent()->getRouteMatch()->getParam('name_material');	
        $param = explode(('&'), $get_data);
        $keys = array('manufacturer','id_color','id_texture','id_collection');
        $i = 0;
        foreach ($param as $value) {
            $in_data[$keys[$i]] = $value;
            $i +=1;

        }




        $manufacturerSrv = $this -> getServiceLocator()->get('manufacturer');
        $colorSrv = $this -> getServiceLocator()->get('color');
        $textureSrv = $this -> getServiceLocator()->get('texture');
        $materialSrv    = $this -> getServiceLocator()->get('material');
        $collectionSrv    = $this -> getServiceLocator()->get('collection');

        $id_manufacturer = $manufacturerSrv->getManufacturerByName($in_data['manufacturer']);
        //echo 'id_manuf  ==  '.$id_manufacturer;
        $data['id_manufacturer'] = $id_manufacturer;
        $data['id_color'] = isset($in_data['id_color'])?$in_data['id_color']:0;
        $data['id_texture'] = isset($in_data['id_texture'])?$in_data['id_texture']:0;
        $data['id_collection'] = isset($in_data['id_collection'])?$in_data['id_collection']:0;

//for filter form
        $data_array['id_manufacturer'] = $id_manufacturer;
        $data_array['manufacturer'] = $in_data['manufacturer'];
        $data_array['id_color'] = isset($in_data['id_color'])?$in_data['id_color']:0;
        $data_array['id_texture'] = isset($in_data['id_texture'])?$in_data['id_texture']:0;
        $data_array['id_collection'] = isset($in_data['id_collection'])?$in_data['id_collection']:0;
        $limit = 12;
        $data['limit'] = $limit;
        
        $set_material = $materialSrv->getSpecOrder($data);

        $blocks['manufacturers'] = $manufacturerSrv->getAllManufacturers();
        $blocks['collections'] = $collectionSrv->getCollectionByManuf($id_manufacturer);
        $blocks['colors'] = $colorSrv->getAllColors();
        $blocks['textures'] = $textureSrv->getAllTextures();

        $partial = $this->getServiceLocator()->get('viewhelpermanager')->get('partial');
           
        $set_material_html = $partial('material/materialset', array("key" => $set_material['result']));  
        $rowcount = $set_material['rowcount'];
        return new ViewModel(array(
                     'set_material_html' => $set_material_html,
                     'data'              => $data_array,
                     'blocks'            => $blocks,
                     'rowcount'          => $rowcount,
                     'limit'             => $limit       
        ));
        
    }

    public function ajaxAction()
    {/**/
       		
           $data = $_POST;

           $materialSrv         = $this -> getServiceLocator()->get('material');
           $set_material        = $materialSrv->getMaterial($data['id']);
           
           $data['id_color']    = $set_material['set']['id_color'];
           $data['id_texture']  = $set_material['set']['id_texture'];
           $data['limit'] = 0;
           $set_analogs         = $materialSrv->getSpecOrder($data);

           $materialsinfolioSrv = $this -> getServiceLocator()->get('materialsinfolio');
           $analogsSrv          = $this -> getServiceLocator()->get('analogs');

           $folios              = $materialsinfolioSrv -> getByMaterial($data['id']);
           $manualAnalogsIds    = $analogsSrv -> getAnalogsForId($data['id']);


           if($manualAnalogsIds){
                foreach ($manualAnalogsIds as $i => $item){
                           $manualAnalog      = $materialSrv->getMaterial($item['id_2']);
                           $manualAnalogs[$i] = $manualAnalog['set'];
                }

           }           
            
           $partial = $this->getServiceLocator()->get('viewhelpermanager')->get('partial');
           $html = $partial('material/materialmodal', array(
                                "material"       => $set_material['set'],
                                "analogs"        => (isset($set_analogs)) ? $set_analogs['result'] : null,
                                "folios"         => (isset($folios)) ? $folios : null,
                                "manualanalogs"  => (isset($manualAnalogs)) ? $manualAnalogs : null
                                ));           
           return   new JsonModel ( array (
      
                  'html'  =>   $html,
                  'query' =>   $set_material['query'],
                  
                  
               
               
        ) );


    }    

    public function materialsetAction()
    {/**/

           $data = $_POST;
           //var_dump($data);
           foreach ($data as $key => $value) {
               if(isset($data[$key])) {
                       $data[$key] .='';

               }
           }
           $materialSrv    = $this -> getServiceLocator()->get('material');
           $set_material = $materialSrv->getSpecOrder($data);


           $partial = $this->getServiceLocator()->get('viewhelpermanager')->get('partial');

           $html = $partial('material/materialset', array("key" => $set_material['result']));  

           //взять коллекции, по производителю
           $collectionSrv    = $this -> getServiceLocator()->get('collection');
           $set_collections  = $collectionSrv -> getCollectionByManuf($data['id_manufacturer']);   


           return   new JsonModel ( array (

                  'res'              => $html,
                  'query'            => $set_material['query'],
                  'id_color'         => $data['id_color'],
                  'rowcount'         => $set_material['rowcount'],
                  'set_collections'  => $set_collections





        ) );



    }      


}
