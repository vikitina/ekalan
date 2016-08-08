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



class CalculatorController extends AbstractActionController
{
    public function indexAction()
    {
              
              $cookie_name = 'ekalan_calculator';


               $db_model = $this -> getServiceLocator()->get('calcsess');
               if (! $this->checksess($cookie_name)){                      
                           $date = date_create();
                           $sess_id = date_timestamp_get($date);
                           $this->startsess($db_model, $cookie_name, $sess_id);
                           $msg = 'no session and will start';
               }
               $sess = $this->getsess($db_model,$cookie_name);
               $calc_data_array = unserialize($sess['calc_data']);
       	       $get_data = $this->getEvent()->getRouteMatch()->getParam('id_material');	
               
               if($get_data){

                          $materialSrv         = $this -> getServiceLocator()->get('material');
                          $materialset         = $materialSrv -> getMaterial($get_data);
                          $material            = $materialset['set'];

                               
          
                          $material['url_prepared']= ((isset($material['url']) && $material['url'] != '' && $material['url'] !=null)?"/assets/application/samples/".trim($material['url']):"");
           
                          if ($calc_data_array){
                                        $calc_data_array['cf_material_id'] = $material['id'];
                                        $sess['calc_data'] = serialize($calc_data_array);
                                        $this->updatesess($db_model,$sess);
                                        //var_dump($sess);

                          }


                    }else{


                         if($calc_data_array['cf_material_id']){

                          $materialSrv         = $this -> getServiceLocator()->get('material');
                          $materialset         = $materialSrv -> getMaterial($calc_data_array['cf_material_id']);
                          $material            = $materialset['set'];
                               
          
                          $material['url_prepared']= ((isset($material['url']) && $material['url'] != '' && $material['url'] !=null)?"/assets/application/samples/".trim($material['url']):"");                          

                         }
                    }

        $systemSrv = $this -> getServiceLocator()->get('system');
        $systems = $systemSrv->getSystem();        
        foreach ($systems as $key => $value) {
          $system[$value['name']] = $value['data'];
        }          
        return new ViewModel(array(
                     'msg'         => $msg,
                     'material'    => $material,
                     'cf_form'     => $calc_data_array,
                     'systems'     => $system
                        
        ));
        
    }


//*************************functions****************************



function startsess($db_model, $name_sess, $val){

       //calk_sess!!!! - create
       setcookie($name_sess,$val,time()+60*4);
       $date = date_create();

       $data_array = array(
            'cf_sess_id'        => $val,
            'cf_material_id'    => ''
        );
       $data = serialize($data_array);

       return $sess_id = $db_model -> insertCalcSess(array(
                        'calc_sess' => $val,
                        'calc_date' => date_timestamp_get($date),
                        'calc_data' => $data


        ));

}             

function checksess($cookie_name){

       
       return ($_COOKIE[$cookie_name] ? true : false);

}

function getsess($db_model,$cookie_name){

       $sess_name = $_COOKIE[$cookie_name];
       $sess = $db_model -> getCalcSess($sess_name);

       return $sess;

}

function updatesess($db_model,$data){
        //setcookie("color","red");
         $db_model->updateCalcSess($data);

}

function killsess($db_model){

         //unset($_COOKIE["yourcookie"]);
         /*Or*/
         //setcookie("yourcookie","yourvalue",time()-1);
         //$db_model -> delCalcSess($id)
   
}




}
