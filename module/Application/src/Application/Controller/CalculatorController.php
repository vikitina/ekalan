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
              $srvCalcprice =  $this -> getServiceLocator()->get('calcprice');
              $calcprice_set= $srvCalcprice -> getAllCalcprice();
              foreach ($calcprice_set as $key => $value) {
                     $calcprice[$value['calc_name']] = array('calc-cprice' => $value['calc-cprice'], 'calc_unit' => $value['calc_unit']);
              }
               if (! $this->checksess($cookie_name)){                      
                           $date = date_create();
                           $sess_id = date_timestamp_get($date);
                           $calc_data_array = $this->startsess($db_model, $cookie_name, $sess_id);
                           

                           
               }else{

                           $sess = $this->getsess($db_model,$cookie_name);
                           $calc_data_array = unserialize($sess['calc_data']);

               }
          
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
                    
                     'material'    => $material,
                     'cf_form'     => $calc_data_array,
                     'systems'     => $system,
                     'calcprice'   => $calcprice
                        
        ));
        
    }



public function ajaxupdaterAction(){

     $data = $_POST;
     $db_model = $this -> getServiceLocator()->get('calcsess');
     $db_model->updateCalcSess(array(
            'cf_sess_id' => $data['cf_sess_id'],
            'calc_data' => serialize($data)
      ));

     $result = new JsonModel ( array ('data' => $data) );

}

//*************************functions****************************



function startsess($db_model, $name_sess, $val){

       //calk_sess!!!! - create
       setcookie($name_sess,$val,time()+60*20);
       $date = date_create();

       $data_array = array(
            'cf_sess_id'        => $val,
            'cf_material_id'    => '0',
            'cf_type'           => 'u',
            'u_wall_1'          => '0',
            'u_wall_2'          => '0',
            'u_wall_3'          => '0',
            'u_wall_4'          => '0',
            'u_wall_5'          => '0',
            'u_wall_6'          => '0',
            'u_wall_7'          => '0',
            'u_wall_8'          => '0',

            'u_corner_1'        => '0',
            'u_corner_2'        => '0',
            'u_corner_3'        => '0',
            'u_corner_4'        => '0',
            'u_corner_5'        => '0',
            'u_corner_6'        => '0',
            'u_corner_7'        => '0',
            'u_corner_8'        => '0',                                                                    

            'u_sink'            => '0',
            'u_stove'           => '0',                                  

                                                                          
            'u_length_2'        => '1000',
            'u_length_3'        => '300',
            'u_length_4'        => '200',                                      
            'u_length_5'        => '100', 
            'u_length_7'        => '500',
            'u_length_8'        => '300',  

            'i_wall_left'       => '0',
            'i_wall_top'        => '0',
            'i_wall_right'      => '0',
            'i_wall_bottom'     => '0',

            'i_corner_1'        => '0',
            'i_corner_2'        => '0',
            'i_corner_3'        => '0',
            'i_corner_4'        => '0',  

            'i_sink'            => '0',
            'i_stove'           => '0',                                  

                                                                          
            'i_length_1'        => '1000',
            'i_length_2'        => '3000',

            'l_wall_1'          => '0',
            'l_wall_2'          => '0',
            'l_wall_3'          => '0',
            'l_wall_4'          => '0',
            'l_wall_5'          => '0',
            'l_wall_6'          => '0', 

            'l_corner_1'        => '0',
            'l_corner_2'        => '0',
            'l_corner_3'        => '0',
            'l_corner_4'        => '0', 
            'l_corner_5'        => '0',
            'l_corner_6'        => '0',                                                 

            'l_sink'            => '0',
            'l_stove'           => '0', 

            'l_length_1'        => '3000', 
            'l_length_2'        => '3000',  
            'l_length_3'        => '1000', 
            'l_length_4'        => '2000'            

        );
       $data = serialize($data_array);

       $id = $db_model -> insertCalcSess(array(
                        'calc_sess' => $val,
                        'calc_date' => date_timestamp_get($date),
                        'calc_data' => $data


        ));
       $data_array['id'] = $id;

       return $data_array;



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
