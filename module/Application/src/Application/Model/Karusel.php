<?php

namespace Application\Model;


use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;

class Karusel extends TableGateway
{
    protected $tableName  = 't_karusel';
    protected $idCol = 'id';

 /*`t_karusel` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_karusel` tinyint(4) NOT NULL,
  `text_karusel` text,
  `window_karusel` int(11) NOT NULL,
  `numframe_karusel` int(11) NOT NULL,
  `id_photo` int(11) DEFAULT NULL,
  `id_folio` int(11) DEFAULT NULL,
  `title_karusel` varchar(255) DEFAULT NULL,
  `subtitle_karusel` varchar(255) DEFAULT NULL,*/

    public function __construct($adapter)
    {
        parent::__construct(
            $this->tableName,
            $adapter,
            new RowGatewayFeature($this->idCol)
        );

 
    }

    public function getAllKarusel()
    { 
         $query = "SELECT * FROM t_karusel GROUP BY window_karusel, numframe_karusel";

    
                            
         $adapter = $this->getAdapter();
		     $results = $this->FetchAll($adapter, $query); 
         //var_dump($results)                           ;
        return $results;
    } 
  public function getAllKaruselWindows()
    { 
         $query = "SELECT DISTINCT `window_karusel`, t_windowkarusel.title_windowkarusel "
                  ."FROM `t_karusel` "
                  ."JOIN t_windowkarusel ON t_karusel.window_karusel=t_windowkarusel.id";

    
                            
         $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query); 
         //var_dump($results)                           ;
        return $results;
    } 
  public function getKaruselByWind($wind){ 
         
         $query = "SELECT t_karusel.*,t_karusel.id as id_karusel, t_photos.* "
                  ."FROM `t_karusel` "
                  ."LEFT JOIN t_photos ON t_karusel.id_photo=t_photos.id "
                  ."WHERE window_karusel='".$wind."' order by numframe_karusel"; 

         $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query); 
         //var_dump($results)                           ;
        return $results;
    } 

   public function getKarusel($id)
    { 

        $query = "SELECT * from `t_karusel` where id ='".$id."'";
        
    
                            
         $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query);                            
        return $results[0];
    }     
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    //==========================================================================================================


  
  public function updateKarusel($data)
    { 
      $id = (int)$data['id'];

    
        parent::update($data, array('id' => $id));
        return array('id' => $id, 'name' => $data['name_texture']);
    }



  public function insertKarusel($data)
    {


      parent::insert($data);
      $adapter = $this->getAdapter();
      $id = $adapter->getDriver()->getLastGeneratedValue();

 return $id;      
 
    }   
      
  public function delKarusel($id)
    {
         $query = sprintf("DELETE FROM t_karusel WHERE id='%s'",$id);

                            
         $adapter = $this->getAdapter();
                                    
         $statement = $adapter->createStatement($query);
         $results = $statement->execute();
         
        return $results;
    }     
    
   function FetchAll($adapter, $sql, $params=null)
    {
        $statement = $adapter->createStatement($sql, $params);
        $results = $statement->execute();
        /*echo('<pre>');
        var_dump($statement);
        echo('</pre>');*/
        $return_arr = array();
        foreach ($results as $result) {
            $return_arr[] = $result;
        }

        return $return_arr;
    }
    
     function FetchOne($adapter, $sql, $params=null)
    {
        $return_arr = self::FetchAll($adapter, $sql, $params);
        return $return_arr ? $return_arr[0] : null;
    } 
        
}
