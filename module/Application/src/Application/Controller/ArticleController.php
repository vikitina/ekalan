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



class ArticleController extends AbstractActionController
{
    public function allarticlesAction()
    {
        $articleSrv    =  $this -> getServiceLocator()->get('article');
        $articles      =  $articleSrv    -> getAllPublished();

        return new ViewModel(array(
          'articles' => $articles 
                 
        ));
        
    }

    public function openarticleAction()
    {         
        $art_id = $this->getEvent()->getRouteMatch()->getParam('id');
        $articleSrv    =  $this -> getServiceLocator()->get('article');
        $article      =  $articleSrv    -> getArticle((int)$art_id);

        $illustratesSrv = $this -> getServiceLocator()->get('illustrate');
        $illustrates = $illustratesSrv -> getAllIllustratesForArt($art_id);  

            if ($illustrates){
              foreach ($illustrates as $key => $value) {
                  $illustrates[$key]['url_illustrates_prepared'] = ((isset($value['url_illustrates']) && $value['url_illustrates'] != '' && $value['url_illustrates'] !=null)?"/assets/application/samples/".trim($value['url_illustrates']):"");
              }


           }       

        /*
         * about
         * causes
         * work_planning

        */
        if ($article['artfirst'] == 1 ) { $anchor = 'about';}
        if ($article['artfour'] == 1 ) { $anchor = 'causes';}
        if ($article['arthow'] == 1 ) { $anchor = 'work_planning';}
           return   new ViewModel ( array (
      
               'article'     => $article,
               'anchor'      => $anchor,
               'illustrates' => $illustrates
       
             
        ) );

 }


       

        


}
