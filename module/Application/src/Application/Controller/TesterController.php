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



public function testerAction(){

// 1. t_color
 /* $colorSrv = $this -> getServiceLocator()->get('color');

  $d = array("Белый моно","Белый +","Бежевый","Серый","Синий, голубой","Зеленый, салатовый","Красный, желтый","Коричневый, фиол.","Черный","Прочее");

  foreach ($d as $value) {
                $data = array(

                'name_color' => $value,
                'color_color' => '#faf2f6',
                
              );
                $colorSrv->insertColor($data);
  }*/
  
// 2. t_texture
/*  $textureSrv = $this -> getServiceLocator()->get('texture');

  $d = array("Без включений","Мелкая","Средняя","Крупная","Гранитная","Мраморная","С кристаллами","С блестками");

  foreach ($d as $value) {
                $data = array(

                'name_texture' => $value,
                
                
              );
                $textureSrv->insertTexture($data);
  }  
*/
  // 3. t_manufacturer

 /* $manufacturerSrv = $this -> getServiceLocator()->get('manufacturer');

  $d = array("Staron","Tristone","HI-MACS","Neomarm","Montelli");

  foreach ($d as $value) {
                $data = array(

                'name_manufacturer' => $value,
                
                
              );
                $manufacturerSrv->insertManufacturer($data);
  }  */

  // 4. collection
 /* $collectionSrv = $this -> getServiceLocator()->get('collection');

  $d = array(
    "Boreal Light" => "1",
    "Citi Life" => "1",

    "Country Paths" => "1",

    "Earth Heritage" => "1",
    "Metropolis" => "1",
    "Mountain Rocks" => "1",
    "Night Time" => "1",
    "Urban Freedom" => "1",
    "Solid" => "2",
    "Solid Pop" => "2",
    "Sanded" => "2",
    "Aspen" => "2",
    "Pebble" => "2",
    "Metallic" => "2",
    "Quarry" => "2",
    "Mosaic" => "2",
    "Tempest" => "2",

    "Романтик" => "3",
    "Ренесанс" => "3",
    "Модерн" => "3",
    "Классик" => "3",
    "Византия" => "3",
    "Барокко" => "3",

    "Гранит" => "4",
    "Вулканиты" => "4",
    "Астра" => "4",
    "Мармо" => "4",
    "Светящийся" => "4",
    "Люсия" => "4",
    "Твердые" => "4",

    "Neomarm" => "5",

    "Basic" => "6",
    "Ultra" => "6");

  foreach ($d as $key => $value) {
                $data = array(

                'name_collection' => $key,
                'id_manufacturer' => $value
                
                
              );
                $collectionSrv->insertCollection($data);
  }  
*/
// 5. t_material

 /*    $materialSrv    = $this -> getServiceLocator()->get('material');
         $f_names = fopen("/var/www/ekalan/public/data/materials/list_file", "r");
         $i = 0;
         $stri = '';
         while(!feof($f_names)) { 
               $name = trim(fgets($f_names));
               if(($name != null) && ($name != '')){
               $params = explode('_', $name);
               $id_manufacturer = $params[0];
               $id_collection = $params[1];
echo '<br>--<br>--name : '.$name.' id_manuf: '.$id_manufacturer.' id_collection: '.$id_collection.'<br />';
               $s = $this->f_insert($name,$id_manufacturer,$id_collection,$materialSrv);
                $i = $i +1;
                $stri .= '<br>-----'.$name.' * '.$s;
             }
         }
         fclose($f_names);
echo "<br><br>*******************************<br>$i раз обернулись<br>$stri";
*/

// 6. t_sample
 
/*
CREATE TABLE IF NOT EXISTS `t_sample` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
)
*/
/*
//залить все образцы
//взять все материалы
//искать поле t_sample.url like %sample%, взять id from t_sample - записать в t_material.id_sample
*/
 /*    $sampleSrv    = $this -> getServiceLocator()->get('sample');
         $f = fopen("/var/www/ekalan/public/assets/application/samples/list_file", "r");
         while(!feof($f)) { 
              echo fgets($f) . "<br />";
              $data = array(

                'url' => fgets($f),
  
              );
        $sampleSrv->insertSample($data);
  }
  fclose($f);
*/

/* 
 $materialSrv    = $this -> getServiceLocator()->get('material');
  $sampleSrv    = $this -> getServiceLocator()->get('sample');
  
  $materials = $materialSrv -> getAllMaterials1();
  foreach ($materials as $item) {
    echo $item['sample'].'<br>';
    //$word = str_replace(" ", "%", $item['name_material']);
    $word = trim(preg_replace('/ +/', '%', $item['sample']));
    //echo $word.'<br>';
    $res = $sampleSrv -> getSampleByUrl($word );
    echo $res['id'].'<br>';
    $data = array(
       'id' => $item['id'],
       'id_sample' => $res['id']
      );
    $materialSrv -> updateSampleMaterial($data);
  }
*/
//return new ViewModel();
 
$partial = $this->getServiceLocator()->get('viewhelpermanager')->get('partial');
$value = array('1','2','3','4');
$html = $partial('tester/some', array("key" => $value));
return new ViewModel(array(
     'some' => $html
  )

  );

}
function f_insert($name,$id_manufacturer,$id_collection,$materialSrv){
  
         echo $full_name = "/var/www/ekalan/public/data/materials/".$name.".csv";
         echo '<br>';
         $f = fopen($full_name, "r");
        echo "<br><br>new collection $id_manufacturer -$id_collection <br>===============================================<br>";
        $i = 0;
         while(!feof($f)) { 
              $str = trim(fgets($f));
            
              if(($str != null) && ($str !='')){
              echo $str.'<br>';
              $arr = explode(';',$str);
              echo '<br>++++++++++++++++++++++++++++++++++++<br>';
              echo 'name_material '.$arr[0] . '<br />';
              echo 'articul '.$arr[1] . '<br />';
              echo 'sample '.$arr[2] . '<br />';
              echo 'id_color '.$arr[3] . '<br />';
              echo 'id_texture '.$arr[4] . '<br />';
             $data = array(

                'name_material' => $arr[0],
                'articul'  => $arr[1],
                'sample' => $arr[2],
                'id_color' => $arr[3],
                'id_texture' => $arr[4],

                'price_material' => '100',

                'id_manufacturer' => $id_manufacturer,
                'id_collection' => $id_collection,

              );
         $i = $i +1;     
        $materialSrv->insertMaterial($data);
      }
  }
  fclose($f);
return $i;
}

}


/*

CREATE TABLE IF NOT EXISTS `t_material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `articul` varchar(255) NOT NULL,
  `name_material` varchar(255) NOT NULL,
  `price_material` int(11) NOT NULL,
  `id_manufacturer` int(11) NOT NULL,
  `id_sample` int(11) NOT NULL,
  `sample` varchar(255) NOT NULL,
  `id_color` int(11) NOT NULL,
  `id_texture` int(11) NOT NULL,
  `id_collection` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `articul` (`articul`,`id_manufacturer`,`id_sample`,`id_color`,`id_texture`,`id_collection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

*/