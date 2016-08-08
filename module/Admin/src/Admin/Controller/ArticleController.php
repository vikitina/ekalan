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

class ArticleController extends AbstractActionController
{
    public function indexAction(){
        $articleSrv    =  $this -> getServiceLocator()->get('article');
        //$articles      =  $articleSrv    -> getAllArticles();
        $articles      =  $articleSrv    -> getAllInfoArticles();
        return new ViewModel ( array (
              
                'articles'  =>  $articles,
                  
                
        ) );
             
                
    }

    public function openarticleAction(){
           $art_id = $this->getEvent()->getRouteMatch()->getParam('id');
           $articleSrv    =  $this -> getServiceLocator()->get('article');
           $article = $articleSrv -> getArticle((int)$art_id);

           $illustratesSrv = $this -> getServiceLocator()->get('illustrate');
           $illustrates = $illustratesSrv -> getAllIllustratesForArt($art_id);

           if ($illustrates){
              foreach ($illustrates as $key => $value) {
                  $illustrates[$key]['url_ill_prepared'] = ((isset($value['url_illustrates']) && $value['url_illustrates'] != '' && $value['url_illustrates'] !=null)?"/assets/application/samples/".trim($value['url_illustrates']):"");
              }


           }

           return new ViewModel ( array (
                    'article'      => $article,
                    'illustrates'  => $illustrates,     
                 
                
        ) );
    }
    public function updatearticleAction(){
            $data = $_POST;
            $articleSrv    =  $this -> getServiceLocator()->get('article');
            $articleSrv -> updateArticle(array(
                     'id'             =>   $data['id'],
                     'title_article'  =>   $data['title_article'],
                     'short_article'  =>   $data['short_article'],
                     'full_article'   =>   $data['full_article']

                ));

            $illustratesSrv = $this -> getServiceLocator()->get('illustrate');
            $illustratesSrv -> delByArticle((int)$data['id']);

            if(isset($data["url_picture"]) && $data["url_picture"]){

                           foreach ($data["url_picture"] as $value) {
                            
                                    $illustratesSrv ->  insertIllustrate(array(
                                             "url_illustrates"    => $value,
                                             "id_article"     => (int)$data['id'],
                                      ));
                           }
            } 


            $case = 'info';
            if ($data['artfirst'] == 1) {$case = 'artfirst';}
            if ($data['arthow'] == 1) {$case = 'arthow';}
            if ($data['artfour'] == 1) {$case = 'artfour';}
            switch ($case) {
                case 'info':
                    $this->redirect()->toRoute('zfcadmin/admin_articles');
                    break;
                case 'artfirst':
                    $this->redirect()->toRoute('zfcadmin/admin_artfirst');
                    break;
                case 'arthow':
                    $this->redirect()->toRoute('zfcadmin/admin_arthow');
                    break;
                case 'artfour':
                    $this->redirect()->toRoute('zfcadmin/admin_artfour');
                    break;

            }
 
            return new ViewModel ( array () );
    } 

public function addarticleAction(){

  
  if($_POST){
        $data = $_POST;
        $articleSrv    =  $this -> getServiceLocator()->get('article');
        $id_article = $articleSrv -> insertArticle($data);
         
        $illustratesSrv = $this -> getServiceLocator()->get('illustrate');

        if(isset($data["url_picture"]) && $data["url_picture"]){

                           foreach ($data["url_picture"] as $value) {

                                    $illustratesSrv ->  insertIllustrate(array(
                                             "illustrates"    => $value,
                                             "id_article"     => $id_article,
                                      ));
                           }
        } 

        $this->redirect()->toRoute('zfcadmin/admin_articles');
      }
         return new ViewModel(array(

          ));

}

public function delarticleAction(){
   
       if ($art_id = $this->getEvent()->getRouteMatch()->getParam('id')){


             $articleSrv    =  $this -> getServiceLocator()->get('article');
             $data = $articleSrv -> getArticle($art_id);

             $case = 'info';
             if ($data['artfirst'] == 1) {$case = 'artfirst';}
             if ($data['arthow'] == 1) {$case = 'arthow';}
             if ($data['artfour'] == 1) {$case = 'artfour';}

                 $illustratesSrv = $this -> getServiceLocator()->get('illustrate');
                 $illustratesSrv -> delByArticle((int)$art_id);   

                 
                 $articleSrv -> delArticle((int)$art_id);


            switch ($case) {
                case 'info':
                    $this->redirect()->toRoute('zfcadmin/admin_articles');
                    break;
                case 'artfirst':
                    $this->redirect()->toRoute('zfcadmin/admin_artfirst');
                    break;
                case 'arthow':
                    $this->redirect()->toRoute('zfcadmin/admin_arthow');
                    break;
                case 'artfour':
                    $this->redirect()->toRoute('zfcadmin/admin_artfour');
                    break;
             }
                

       }

}   

public function ajaxdelarticleAction(){
            if ($_POST){

                 $data = $_POST;

                 $illustratesSrv = $this -> getServiceLocator()->get('illustrate');
                 $illustratesSrv -> delByArticle((int)$data['id']);  

                 $articleSrv    =  $this -> getServiceLocator()->get('article');
                 $articleSrv -> delArticle((int)$data['id']);
                    return new JsonModel(array(
                            'res'    => $data['id']
                    )); 

            }



}
 
public function ajaxpublicartAction(){
/* Object { on_home="1",  public="1",  type="public_and_on_home"}

Object { on_home="0",  type="on_home"}

Object { on_home="0",  public="0",  type="public_and_on_home"}
 
Object { on_home="1",  public="1",  type="public_and_on_home"}

 Object { public="1",  type="public"}*/

        $data = $_POST;
        $articleSrv    =  $this -> getServiceLocator()->get('article');
        
        switch ($data['type']) {
             case 'public':
                 $update_data = array(
                         'id'        => $data['id'],
                         'public'    => $data['public']
                  );
                 $articleSrv -> updatePublicArticle($update_data);  
             break;
             case 'public_and_on_home':
                 $update_data = array(
                         'id'        => $data['id'],
                         'public'    => $data['public'],
                         'on_home'   => $data['on_home']
                  );             
                 $articleSrv -> updatePublicAndOnHomeArticle($update_data);
             break;
             case 'on_home':
                 $update_data = array(
                         'id'        => $data['id'],
                         'on_home'   => $data['on_home']
                  );                
                 $articleSrv -> updateOnHomeArticle($update_data);
             break;
        }

   return new JsonModel(array(
        'res'    => $data
   ));     
}

public function artfirstAction(){
        $articleSrv    =  $this -> getServiceLocator()->get('article');
        $articles      =  $articleSrv    -> getArtfirstArticles();
        return new ViewModel ( array (
              
                'articles'  =>  $articles,
                  
                
        ) );

}         

public function addartfirstAction(){
         return new ViewModel(array(

          ));

}  


public function artfourAction(){
        $articleSrv    =  $this -> getServiceLocator()->get('article');
        $articles      =  $articleSrv    -> getArtfourArticles();
        return new ViewModel ( array (
              
                'articles'  =>  $articles,
                  
                
        ) );

}         

public function addartfourAction(){
         return new ViewModel(array(

          ));
}     

public function arthowAction(){
        $articleSrv    =  $this -> getServiceLocator()->get('article');
        $articles      =  $articleSrv    -> getArthowArticles();
        return new ViewModel ( array (
              
                'articles'  =>  $articles,
                  
                
        ) );

}     

public function addarthowAction(){
         return new ViewModel(array(

          ));

}       
 
}
