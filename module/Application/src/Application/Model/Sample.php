<?php

namespace Application\Model;


use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;

class Sample extends TableGateway
{
    protected $tableName  = 't_sample';
    protected $idCol = 'id';
 

    public function __construct($adapter)
    {
        parent::__construct(
            $this->tableName,
            $adapter,
            new RowGatewayFeature($this->idCol)
        );

 
    }

    public function getAllSamples()
    { 

        $query = "SELECT * from t_sample";

    
                            
         $adapter = $this->getAdapter();
		     $results = $this->FetchAll($adapter, $query);                            
        return $results;
    } 

   public function getSample($id)
    { 

        $query = "SELECT * from `t_sample` where id ='".$id."'";

    
                            
         $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query);                            
        return $results[0];
    }     
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    //==========================================================================================================


  
  public function updateSample($data=null)
    { 
      $id = $data['id'];

    
        parent::update($data, array('id' => $id));
    }

public function getSampleByUrl($url){

    $query="SELECT id from `t_sample` WHERE url like '%".$url."%'";
    //echo $query;
            $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query);     
        // var_dump($results)                       ;
        return $results[0];
}

  public function insertSample($data)
    {


      parent::insert($data);

        //$data = array()// Your data to be saved;
        //$this->tableGateway->insert($data);
        $id = $this->tableGateway->lastInsertValue;
 return $id;
    }   
      
  public function delSample($id)
    {
         $query = sprintf("DELETE FROM t_sample WHERE id='%s'",$id);

                            
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
