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
       	$name_manufacturer = $this->getEvent()->getRouteMatch()->getParam('name_material');	
        $manufacturerSrv = $this -> getServiceLocator()->get('manufacturer');
        $colorSrv = $this -> getServiceLocator()->get('color');
        $textureSrv = $this -> getServiceLocator()->get('texture');

        $id_manufacturer = $manufacturerSrv->getManufacturerByName($name_manufacturer);
        
        $data['id_manufacturer'] = $id_manufacturer;

        $data_array['id_manufacturer'] = $id_manufacturer;

        $materialSrv    = $this -> getServiceLocator()->get('material');
        $set_material = $materialSrv->getSpecOrder($data);

        $blocks['manufacturers'] = $manufacturerSrv->getAllManufacturers();
        $blocks['colors'] = $colorSrv->getAllColors();
        $blocks['textures'] = $textureSrv->getAllTextures();

        return new ViewModel(array(
                     'set_material' => $set_material,
                     'data'         => $data_array,
                     'blocks'       => $blocks
        ));
    }

    public function ajaxAction()
    {
       		
           $data = $_POST;
           $materialSrv    = $this -> getServiceLocator()->get('material');
           $set_material = $materialSrv->getSpecOrder($data);


           $partial = $this->getServiceLocator()->get('viewhelpermanager')->get('partial');
           
           $html = $partial('material/materialset', array("key" => $set_material));           
           return   new JsonModel ( array (
      
                  'res' => $html
               
        ) );

return new ViewModel(array());

    }    


}
