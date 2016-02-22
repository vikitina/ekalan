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
        $keys = array('manufacturer','id_color','id_texture','id_material');
        $i = 0;
        foreach ($param as $value) {
            $in_data[$keys[$i]] = $value;
            $i +=1;

        }




        $manufacturerSrv = $this -> getServiceLocator()->get('manufacturer');
        $colorSrv = $this -> getServiceLocator()->get('color');
        $textureSrv = $this -> getServiceLocator()->get('texture');

        $id_manufacturer = $manufacturerSrv->getManufacturerByName($in_data['manufacturer']);
        //echo 'id_manuf  ==  '.$id_manufacturer;
        $data['id_manufacturer'] = $id_manufacturer;
        $data['id_color'] = isset($in_data['id_color'])?$in_data['id_color']:0;
        $data['id_texture'] = isset($in_data['id_texture'])?$in_data['id_texture']:0;


//for filter form
        $data_array['id_manufacturer'] = $id_manufacturer;
        $data_array['manufacturer'] = $in_data['manufacturer'];
        $data_array['id_color'] = isset($in_data['id_color'])?$in_data['id_color']:0;
        $data_array['id_texture'] = isset($in_data['id_texture'])?$in_data['id_texture']:0;


        $materialSrv    = $this -> getServiceLocator()->get('material');
        $set_material = $materialSrv->getSpecOrder($data);

        $blocks['manufacturers'] = $manufacturerSrv->getAllManufacturers();
        $blocks['colors'] = $colorSrv->getAllColors();
        $blocks['textures'] = $textureSrv->getAllTextures();

           $partial = $this->getServiceLocator()->get('viewhelpermanager')->get('partial');
           
           $set_material_html = $partial('material/materialset', array("key" => $set_material['result']));  
        return new ViewModel(array(
                     'set_material_html' => $set_material_html,
                     'data'         => $data_array,
                     'blocks'       => $blocks
        ));
        
    }

    public function ajaxAction()
    {/**/
       		
           $data = $_POST;
           //var_dump($data);
        /*   foreach ($data as $key => $value) {
               if(isset($data[$key])) {
                       $data[$key] .='';

               }
           }*/
           $materialSrv    = $this -> getServiceLocator()->get('material');
           $set_material = $materialSrv->getMaterial($data['id']);


         //  $partial = $this->getServiceLocator()->get('viewhelpermanager')->get('partial');
           
        //   $html = $partial('material/materialset', array("key" => $set_material['result']));           
           return   new JsonModel ( array (
      
                  'res' => $set_material['set'],
                  'query' => $set_material['query']
                 // 'query' => $set_material['query'],
                 // 'id_color' => $data['id_color']
               
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
           return   new JsonModel ( array (

                  'res' => $html,
                  'query' => $set_material['query'],
                  'id_color' => $data['id_color']






        ) );



    }      


}
