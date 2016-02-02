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
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
use Zend\Mail\Transport\SmtpOptions;
class TesterController extends AbstractActionController
{
    public function indexAction()
    {
 


  /*    $materialSrv    = $this -> getServiceLocator()->get('material');
         $f = fopen("/var/www/ekalan/public/data/materials.csv", "r");
         while(!feof($f)) { 
              echo fgets($f) . "<br />";
              $data = array(

                'name_material' => fgets($f),
                'price_material' => '100',
                'id_manufacturer' => '1',
                'id_sample' => '1'
              );
        $materialSrv->insertMaterial($data);
  }
  fclose($f);

*/
 

/*
     $sampleSrv    = $this -> getServiceLocator()->get('sample');
         $f = fopen("/var/www/ekalan/public/assets/application/samples/list_file.txt", "r");
         while(!feof($f)) { 
              echo fgets($f) . "<br />";
              $data = array(

                'url' => fgets($f),
  
              );
        $sampleSrv->insertSample($data);
  }
  fclose($f);

*/
 
/* $materialSrv    = $this -> getServiceLocator()->get('material');
  $sampleSrv    = $this -> getServiceLocator()->get('sample');
  
  $materials = $materialSrv -> getAllMaterials();
  foreach ($materials as $item) {
    //$word = str_replace(" ", "%", $item['name_material']);
    $word = trim(preg_replace('/ +/', '%', $item['name_material']));
    //echo $word.'<br>';
    $res = $sampleSrv -> getSampleByUrl($word );
    //echo $res['id'].'<br>';
    $data = array(
       'id' => $item['id'],
       'id_sample' => $res['id']
      );
    $materialSrv -> updateSampleMaterial($data);
  }

return new ViewModel();
*/

  //выбрать все материалы

  // вернуть аяксом
 $materialSrv    = $this -> getServiceLocator()->get('material');
  
          header('Access-Control-Allow-Origin: *');
     //   header('Access-Control-Allow-Methods: GET, POST, PUT');
     //   header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");
  $materials = $materialSrv -> getAllMaterials();

              return  $result = new JsonModel ( array (
      
                  'res' => $materials
               // 'res'=> '123'
        ) );

 }

public function getmaterialAction(){
         $data = $_POST;
         header('Access-Control-Allow-Origin: *');
         $materialSrv    = $this -> getServiceLocator()->get('material');
         $material = $materialSrv -> getMaterial($data['id']);
return   new JsonModel ( array (
      
                  'res' => $material
               
        ) );

}



}
