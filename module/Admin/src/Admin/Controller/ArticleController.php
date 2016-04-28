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
       $art_id = $this->getEvent()->getRouteMatch()->getParam('id');
       

}   

public function ajaxdelarticleAction(){




}
 
public function ajaxpublicart(){

        $data = $_POST;

        switch ($data['type']) {
          case 'public':
            # code...
            break;
          case 'public_and_on_home':
            # code...
            break;
          case 'on_home':
            # code...
            break;
                                
          default:
            # code...
            break;
        }
}         
 
}
