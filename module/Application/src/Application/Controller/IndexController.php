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
        $testimonialsSrv  = $this -> getServiceLocator()->get('testimonials'); 
        $testimonials = $testimonialsSrv -> getHomeTestimonials();

        $karuselSrv  = $this -> getServiceLocator()->get('karusel'); 
        $karusel_windows = $karuselSrv -> getAllKaruselWindows();
        foreach ($karusel_windows as $key => $wind) {

                   $karusel[$key] = $karuselSrv -> getKaruselByWind($wind["window_karusel"]);
                 
                   foreach ($karusel[$key] as $id => $item) {
                            $karusel[$key][$id]['url_photo'] = ((isset($item['url_photo']) && $item['url_photo'] != '' && $item['url_photo'] !=null)?"/assets/application/samples/".trim($item['url_photo']):"");
 
                   }                   
                   $karusel[$key]['title_windowkarusel'] = $wind['title_windowkarusel'];

        }
       

        $folioSrv                   = $this -> getServiceLocator()->get('folio');        
        $i = 0;
        foreach ($testimonials as $testimonial){
             $testimonials[$i]['url_picture'] = ((isset($testimonial['url_picture']) && $testimonial['url_picture'] != '' && $testimonial['url_picture'] !=null)?"/assets/application/samples/".trim($testimonial['url_picture']):"");  
             $folio_id = $folioSrv -> getFolioIdByTestimonialId($testimonial['id']);
             $testimonials[$i]['url_folio'] = ($folio_id) ? '/project/'.$folio_id : 0;
             $i += 1;
        }

        $systemSrv = $this -> getServiceLocator()->get('system');
        $systems = $systemSrv->getSystem();        
        foreach ($systems as $key => $value) {
          $system[$value['name']] = $value['data'];
        }

        
        return new ViewModel(array(

            'manufacturers'         => $manufacturers,
            'testimonials'          => $testimonials,
            'karusel_windows'       => $karusel,
            'systems'               => $system

        
        ));
    }

    public function portfolioAction()
    {
       		       $groupSrv        = $this -> getServiceLocator()->get('groups');
                 $list_groups     = $groupSrv->getAllGroups();
                 $folioSrv        = $this -> getServiceLocator()->get('folio'); 

                  foreach ($list_groups as $key => $group) {
                    $foliosByGroup = null;
                    $foliosByGroup = $folioSrv -> getFolioByGroup($group['id']);
                           if($foliosByGroup){
                               $list_active_group[$key] = $group;

                           }
                  }

                  $lists['groups'] = $list_active_group;

                 $folioSrv          = $this -> getServiceLocator()->get('folio');
                 $folios            = $folioSrv -> getAllFolios();

                 $photosSrv         = $this -> getServiceLocator()->get('photos');

                 foreach ($folios as $key => $folio) {
                     $res = $photosSrv->getMainPhoto(array('id_folio' => $folio['id']));
                     $folios[$key]['main_photo'] = ((isset($res["url_photo"]) && $res["url_photo"] != '' && $res["url_photo"] !=null)?"/assets/application/samples/".trim($res["url_photo"]):"/assets/application/img/no_photo.png");
                 }

                $lists['folios'] = $folios;


       return new ViewModel(array(
                          'lists'    => $lists,
       ));
        
    } 



    public function projectAction(){


        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        $folioSrv = $this -> getServiceLocator()->get('folio');
        $project = $folioSrv->getSpecFolioById($id);

 
        $project['url_picture'] = ((isset($project['url_picture']) && $project['url_picture'] != '' && $project['url_picture'] !=null)?"/assets/application/samples/".trim($project['url_picture']):"/assets/application/img/no_photo.png");
                 

        $materials = array();
        $materialsinfolioSrv        = $this -> getServiceLocator()->get('materialsinfolio');
        $materials_list = $materialsinfolioSrv->getByFolio($id);
        $materialSrv    = $this -> getServiceLocator()->get('material');
        $i = 0;
        if($materials_list){
                  foreach ($materials_list as $material) {
                           $m = $materialSrv->getMaterial($material['id_material']);
                           //echo $material['id_material']."   -- id<br>-----$m----------<br>";
                           //var_dump($m);
                           
                           $set_material[$i] = $m['set']; 
                           
                           
                           $set_material[$i]['url'] = ((isset($set_material[$i]['url']) && $set_material[$i]['url'] != '' && $set_material[$i]['url'] !=null)?"/assets/application/samples/".trim($set_material[$i]['url']):"/assets/application/img/no_photo.png");
                           
                           
                           $i +=1;
                  }
         } 

         $photosSrv                  = $this -> getServiceLocator()->get('photos');
         $blueprintsSrv              = $this -> getServiceLocator()->get('blueprints');    
         $i = 0;
         $photos     = $photosSrv->getByFolio($id);
              foreach($photos as $photo){
                   $photos[$i]['url_photo'] = ((isset($photo['url_photo']) && $photo['url_photo'] != '' && $photo['url_photo'] !=null)?"/assets/application/samples/".trim($photo['url_photo']):"/assets/application/img/no_photo.png");
                   $i += 1;

              }
         $i = 0;
         $blueprints = $blueprintsSrv->getByFolio($id); 
              foreach($blueprints as $blueprint){
                   $blueprints[$i]['url_blueprint'] = ((isset($blueprint['url_blueprint']) && $blueprint['url_blueprint'] != '' && $blueprint['url_blueprint'] !=null)?"/assets/application/samples/".trim($blueprint['url_blueprint']):"/assets/application/img/no_photo.png");
                   $i += 1;

              }              

  

          return new ViewModel(array(
                          'project'    => $project,
                          'materials'  => $set_material,
                          'photos'     => $photos,
                          'blueprints' => $blueprints
       ));     

    }   


}
