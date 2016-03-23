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


class IndexController extends AbstractActionController
{
    public function indexAction()
    {
       		
        $manufacturerSrv = $this -> getServiceLocator()->get('manufacturer');
        $manufacturers = $manufacturerSrv->getAllManufacturers();

        
        return new ViewModel(array(
            'manufacturers' => $manufacturers
        
        ));
    }

    public function portfolioAction()
    {
       		     $groupSrv                   = $this -> getServiceLocator()->get('groups');
                 $lists['groups']            = $groupSrv->getAllGroups();

                 $folioSrv                   = $this -> getServiceLocator()->get('folio');
                 $folios = $folioSrv -> getAllFolios();

                 $photosSrv                  = $this -> getServiceLocator()->get('photos');

                 foreach ($folios as $key => $folio) {
                     $res = $photosSrv->getMainPhoto(array('id_folio' => $folio['id']));
                     $folios[$key]['main_photo'] = ((isset($res["url_photo"]) && $res["url_photo"] != '' && $res["url_photo"] !=null)?"/assets/application/samples/".trim($res["url_photo"]):"/assets/application/img/no_photo.png");
                 }

                $lists['folios'] = $folios;
       return new ViewModel(array(
                          'lists'    => $lists,
       ));
        
    }    


}
