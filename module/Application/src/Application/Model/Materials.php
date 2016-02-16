<?php

namespace Application\Model;


use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;

class Materials extends TableGateway
{
    protected $tableName  = 't_material';
    protected $idCol = 'id';
 

    public function __construct($adapter)
    {
        parent::__construct(
            $this->tableName,
            $adapter,
            new RowGatewayFeature($this->idCol)
        );

 
    }
    public function getSpecOrder($data){
     $query = "SELECT t_material.*,"
              ." t_sample.url as url,"
              ." t_collection.name_collection as collection"
              ." FROM `t_material` "
              ." LEFT JOIN t_collection on t_material.id_collection = t_collection.id"
              ." LEFT JOIN t_sample on t_material.id_sample = t_sample.id"

               ." WHERE 1"
               .((isset($data['id_manufacturer']) && $data['id_manufacturer'] != '' && $data['id_manufacturer'] != null && $data['id_manufacturer'] != '0')?" AND t_material.id_manufacturer = '".$data['id_manufacturer']."'":"")
               .((isset($data['id_color']) && $data['id_color'] != '' && $data['id_color'] != null && $data['id_color'] != '0')?" AND t_material.id_color = '".$data['id_color']."'":"")
               .((isset($data['id_texture']) && $data['id_texture'] != '' && $data['id_texture'] != null && $data['id_texture'] != '0')?" AND t_material.id_texture = '".$data['id_texture']."'":"")
               ;


     $adapter = $this->getAdapter();
     $result = $this->FetchAll($adapter, $query); 
         //var_dump($results)                           ;
     return $results = array(
                 'result' => $result,
                 'query' => $query
         );

    }
    public function getAllMaterials()
    { 
$query = "SELECT t_material.*,t_sample.url as url FROM `t_material` join t_sample on t_material.id_sample=t_sample.id";
        //$query = "SELECT * from t_material";

    
                            
         $adapter = $this->getAdapter();
		     $results = $this->FetchAll($adapter, $query); 
         //var_dump($results)                           ;
        return $results;
    } 
    public function getAllMaterials1()
    { 

        $query = "SELECT * from t_material";

    
                            
         $adapter = $this->getAdapter();
             $results = $this->FetchAll($adapter, $query); 
         //var_dump($results)                           ;
        return $results;
    } 
   public function getMaterial($id)
    { 

        //$query = "SELECT * from `t_material` where id ='".$id."'";
        $query = "SELECT t_material.*,t_sample.url as url, t_manufacturer.name_manufacturer as manufacturer FROM `t_material` join t_sample on t_material.id_sample=t_sample.id join t_manufacturer on t_material.id_manufacturer = t_manufacturer.id where t_material.id = '".$id."'";
    
                            
         $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query);                            
        return $results[0];
    }     
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    //==========================================================================================================


  
  public function updateMaterial($data=null)
    { 
      $id = $data['id'];

    
        parent::update($data, array('id' => $id));
    }
public function updateSampleMaterial($data){


        $query = "UPDATE t_material SET id_sample = '".$data['id_sample']."' where id='".$data['id']."'";

         $adapter = $this->getAdapter();
                                    
         $statement = $adapter->createStatement($query);
         $results = $statement->execute();
return $query;

}


  public function insertMaterial($data)
    {


      parent::insert($data);
 
    }   
      
  public function delMaterial($id)
    {
         $query = sprintf("DELETE FROM t_material WHERE id='%s'",$id);

                            
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
