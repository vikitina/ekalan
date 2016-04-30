<?php

namespace Application\Model;


use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;

class Manufacturer extends TableGateway
{
    protected $tableName  = 't_manufacturer';
    protected $idCol = 'id';
 

    public function __construct($adapter)
    {
        parent::__construct(
            $this->tableName,
            $adapter,
            new RowGatewayFeature($this->idCol)
        );

 
    }

    public function getAllManufacturers()
    { 
         $query = "SELECT t_manufacturer.*, t_pictures.url_picture as url_picture "
                 ."FROM t_manufacturer "
                 ."LEFT JOIN t_pictures ON t_manufacturer.id_picture = t_pictures.id";
         $adapter = $this->getAdapter();
		 $results = $this->FetchAll($adapter, $query); 
         return $results;
    } 

    public function getManufacturerByName($name_manufacturer){
          
           $query = sprintf("SELECT t_manufacturer.*, t_pictures.url_picture as url_picture "
                            ."FROM t_manufacturer "
                            ."LEFT JOIN t_pictures ON t_manufacturer.id_picture = t_pictures.id "
                            ."WHERE name_manufacturer='%s'",$name_manufacturer);

           $adapter = $this->getAdapter();
           $results = $this->FetchAll($adapter, $query); 
         //var_dump($results)                           ;
           return $results[0]['id'];

    }

   public function getManufacturer($id)
    { 

        $query = "SELECT t_manufacturer.*, t_pictures.url_picture as url_picture "
                ."FROM t_manufacturer "
                ."LEFT JOIN t_pictures ON t_manufacturer.id_picture = t_pictures.id "
                ."WHERE t_manufacturer.id ='".$id."'";                            
         $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query);                            
        return $results[0];
    }     
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    //==========================================================================================================


  
  public function updateManufacturer($data=null)
    { 
      $id = $data['id'];

    
        parent::update($data, array('id' => $id));
    }



  public function insertManufacturer($data)
    {


      parent::insert($data);
 
    }   
      
  public function delManufacturer($id)
    {
         $query = sprintf("DELETE FROM t_manufacturer WHERE id='%s'",$id);

                            
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
