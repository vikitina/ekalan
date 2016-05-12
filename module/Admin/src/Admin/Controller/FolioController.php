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

class FolioController extends AbstractActionController
{
    public function ajaxdelfolioAction()
    {
             $data = $_POST;
             
             $folioSrv    =  $this -> getServiceLocator()->get('folio');
             $blueprintSrv = $this -> getServiceLocator()->get('blueprints');
             $materialsinfolioSrv = $this -> getServiceLocator()->get('materialsinfolio');
             $testimonialsSrv = $this -> getServiceLocator()->get('testimonials');


             $blueprintSrv -> delByFolio((int)$data['id']);
             //id_testimonials
             $folio = $folioSrv -> getFolio((int)$data['id']);
             $testimonialsSrv -> delTestimonial((int)$folio['id_testimonials']);
             $karuselSrv = $this -> getServiceLocator()->get('karusel');
             $karusels = $karuselSrv -> getKaruselByFolio((int)$data['id']);
             if ($karusels){
                    foreach($karusels as $karusel){
                    	 $karusel['id_folio'] = 0;
                         $karuselSrv -> updateKarusel($karusel);
                      }   
              }
             $folioSrv -> delFolio((int)$data['id']);
             $materialsinfolioSrv -> delByFolio((int)$data['id']);

             return new JsonModel ( array (
              
                 'res' => $data['id']
                
               ) );
              
                
    }


     public function delfolioAction()
    {
             $data['id'] = $this->getEvent()->getRouteMatch()->getParam('id');
             
             $folioSrv    =  $this -> getServiceLocator()->get('folio');
             $blueprintSrv = $this -> getServiceLocator()->get('blueprints');
             $materialsinfolioSrv = $this -> getServiceLocator()->get('materialsinfolio');
             $testimonialsSrv = $this -> getServiceLocator()->get('testimonials');


             $blueprintSrv -> delByFolio((int)$data['id']);
             //id_testimonials
             $folio = $folioSrv -> getFolio((int)$data['id']);
             $testimonialsSrv -> delTestimonial((int)$folio['id_testimonials']);
             $karuselSrv = $this -> getServiceLocator()->get('karusel');
             $karusels = $karuselSrv -> getKaruselByFolio((int)$data['id']);
             if ($karusels){
                    foreach($karusels as $karusel){
                    	 $karusel['id_folio'] = 0;
                         $karuselSrv -> updateKarusel($karusel);
                      }   
              }
             $folioSrv -> delFolio((int)$data['id']);
             $materialsinfolioSrv -> delByFolio((int)$data['id']);

             $this->redirect()->toRoute('zfcadmin/admin_folios');



              
                
    }

     public function ajaxdeltestimonialAction()
    {
             $data = $_POST;
             
             $testimonialSrv    =  $this -> getServiceLocator()->get('testimonials');
             $folioSrv    =  $this -> getServiceLocator()->get('folio');             

             $folio = $folioSrv -> getFolioIdByTestimonialId((int)$data['id']);
             if ($folio){
                   $testimonialSrv -> updateTestimonial(array(
                           "id"                            => (int)$data['id'],
                           "name_testimonials"             => "",
                           "organization"                  => "",
                           "id_picture"                    => "",
                           "text_testimonials"             => "",
                           "short_text_testimonials"       => "",
                           "public_on_home_testimonials"   => 0                         
                   	));

             } else {
                   $testimonialSrv -> delTestimonial((int)$data['id']);

             }
             return new JsonModel ( array (
              
                 'res' => $data['id']
                
               ) );
              
                
    }
   public function deltestimonialAction()
    {
             $data['id'] = $this->getEvent()->getRouteMatch()->getParam('id');
             
             $testimonialSrv    =  $this -> getServiceLocator()->get('testimonials');
             $folioSrv    =  $this -> getServiceLocator()->get('folio');             

             $folio = $folioSrv -> getFolioIdByTestimonialId((int)$data['id']);
             if ($folio){
                   $testimonialSrv -> updateTestimonial(array(
                           "id"                            => (int)$data['id'],
                           "name_testimonials"             => "",
                           "organization"                  => "",
                           "id_picture"                    => "",
                           "text_testimonials"             => "",
                           "short_text_testimonials"       => "",
                           "public_on_home_testimonials"   => 0                         
                   	));

             } else {
                   $testimonialSrv -> delTestimonial((int)$data['id']);

             }
             return new JsonModel ( array (
              
                 'res' => $data['id']
                
               ) );
              
                
    }

         
 
}
