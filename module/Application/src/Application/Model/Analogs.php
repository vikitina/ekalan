<?php

namespace Application\Model;


use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;

class Analogs extends TableGateway
{
    protected $tableName  = 't_analogs';
    protected $idCol = 'id';
 

    public function __construct($adapter)
    {
        parent::__construct(
            $this->tableName,
            $adapter,
            new RowGatewayFeature($this->idCol)
        );

 
    }


   public function getAnalogsById($id)
    { 

           $query = "SELECT * from `t_analogs` where id_1 ='".$id."' or id_2 = '".$id."'";                           
           $adapter = $this->getAdapter();
           $results = $this->FetchAll($adapter, $query);                            
           return $results;
    }     
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    //==========================================================================================================


  
  public function updateAnalog($data=null)
    { 
      $id = $data['id'];

    
        parent::update($data, array('id' => $id));
    }



  public function insertAnalog($data)
    {
           parent::insert($data);

    }   
      
  public function delAnalog($id)
    {
         $query = sprintf("DELETE FROM t_analogs WHERE id='%s'",$id);

                            
         $adapter = $this->getAdapter();
                                    
         $statement = $adapter->createStatement($query);
         $results = $statement->execute();
         
        return $results;
    }    

   
      public function delAllAboutId($id)
    {
         $query = sprintf("DELETE FROM t_analogs WHERE id_1='%s' or id_2='%s'",$id,$id);                   
         $adapter = $this->getAdapter();                           
         $statement = $adapter->createStatement($query);
         $results = $statement->execute();

         
        
    } 
    //getAnalog($id_material,$item)
      public function getAnalog($id_1,$id_2)
    {
         $query = "SELECT * FROM t_analogs WHERE id_1='".$id_1."' AND id_2='".$id_2."'";                   
         $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query); 

       return $results;
        
    } 
//getAnalogForId
  public function getAnalogForId($id_1)
    {
         $query = "SELECT * FROM t_analogs WHERE id_1='".$id_1."'";
         $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query); 

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
