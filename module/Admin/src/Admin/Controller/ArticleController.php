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
        $articles      =  $articleSrv    -> getAllArticles();
        return new ViewModel ( array (
              
                'articles'  =>  $articles,
                  
                
        ) );
             
                
    }

    public function openarticleAction(){
           $art_id = $this->getEvent()->getRouteMatch()->getParam('id');
           $articleSrv    =  $this -> getServiceLocator()->get('article');
           $article = $articleSrv -> getArticle((int)$art_id);
           return new ViewModel ( array (
                    'article' => $article       
                 
                
        ) );
    }
    public function updatearticleAction(){
            $data = $_POST;
            $articleSrv    =  $this -> getServiceLocator()->get('article');
            $articleSrv -> updateArticle($data);
            $this->redirect()->toRoute('zfcadmin/admin_articles');
            return new ViewModel ( array (
              
                 
                
        ) );
    }    
public function addarticleAction(){

  
  if($_POST){
        $data = $_POST;
        $articleSrv    =  $this -> getServiceLocator()->get('article');
        $articleSrv -> insertArticle($data);

        $this->redirect()->toRoute('zfcadmin/admin_articles');
      }
         return new ViewModel(array(

          ));

}

public function delarticleAction(){
   
       if ($art_id = $this->getEvent()->getRouteMatch()->getParam('id')){
                 $articleSrv    =  $this -> getServiceLocator()->get('article');
                 $articleSrv -> delArticle((int)$art_id);

                 $this->redirect()->toRoute('zfcadmin/admin_articles');

       }

}   

public function ajaxdelarticleAction(){
            if ($_POST){

                 $data = $_POST;
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
 
}
