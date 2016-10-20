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
              ." t_collection.name_collection as collection,"
              ." t_color.name_color as color,"
              ." t_color.color_color as num_color,"
              ." t_texture.name_texture as texture,"
              ." t_manufacturer.name_manufacturer as manufacturer"
              ." FROM `t_material` "
              ." LEFT JOIN t_collection on t_material.id_collection = t_collection.id"
              ." LEFT JOIN t_sample on t_material.id_sample = t_sample.id"
              ." LEFT JOIN t_color on t_material.id_color = t_color.id"
              ." LEFT JOIN t_texture on t_material.id_texture = t_texture.id"
              ." LEFT JOIN t_manufacturer on t_material.id_manufacturer = t_manufacturer.id"


               ." WHERE 1"
               .((isset($data['id_manufacturer']) && $data['id_manufacturer'] != '' && $data['id_manufacturer'] != null && $data['id_manufacturer'] != '0')?" AND t_material.id_manufacturer = '".$data['id_manufacturer']."'":"")
               .((isset($data['id_color']) && $data['id_color'] != '' && $data['id_color'] != null && $data['id_color'] != '0')?" AND t_material.id_color = '".$data['id_color']."'":"")
               .((isset($data['id_texture']) && $data['id_texture'] != '' && $data['id_texture'] != null && $data['id_texture'] != '0')?" AND t_material.id_texture = '".$data['id_texture']."'":"")
               .((isset($data['articul']) && $data['articul'] != '0')?" AND t_material.articul like '".$data['articul']."%'":"")
               .((isset($data['exclude']) && $data['exclude'] !='0')?" AND t_material.id <>'".$data['exclude']."'":"")
               .((isset($data['id_collection']) && $data['id_collection'] != '' && $data['id_collection'] != null && $data['id_collection'] != '0')?" AND t_material.id_collection = '".$data['id_collection']."'":"")
               .' ORDER BY t_material.price_material asc';

      $adapter = $this->getAdapter();
      $result = $this->FetchAll($adapter, $query); 
      $rowcount = count($result);


      $query .= (($data['limit'] != 0) ? " limit ".(($data['start'] != 0)? ($data['start']-1)*$data['limit'].", " : "0, ").$data['limit']:"");

      $adapter = $this->getAdapter();
      $result = $this->FetchAll($adapter, $query); 
         //var_dump($results)                           ;
     return $results = array(
                 'result' => $result,
                 'query' => $query,
                 'rowcount' => $rowcount
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
   public function getMaterial($id = null, $start = null)
    {        
        $query =  "SELECT t_material.*, "
                 ."t_sample.url as url, "
                 ."t_manufacturer.name_manufacturer as manufacturer, "
                 ."t_texture.name_texture as texture, "
                 ."t_color.name_color as color, "
                 ."t_collection.name_collection as collection "
                 ."FROM `t_material` "
                 ."left join t_sample on t_material.id_sample=t_sample.id "
                 ."left join t_manufacturer on t_material.id_manufacturer = t_manufacturer.id "
                 ."left join t_texture on t_material.id_texture = t_texture.id "
                 ."left join t_color on t_material.id_color = t_color.id "
                 ."left join t_collection on t_material.id_collection = t_collection.id "
                 ."where 1"
                 .(($id != null)?" and t_material.id = '".$id."'":"");
    
                            
         $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query);                            
        return array ('set' =>$results[0],'query'=>$query,'all'=>$results);
    }   


//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    //==========================================================================================================
   public function getMaterialByManufacturer($id)
    {        
        $query =  "SELECT t_material.* "
                 ."FROM `t_material` "
                 ."where id_manufacturer = '".$id."'";
    
                            
         $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query);                            
        return $results;
    } 
   public function getMaterialByCollection($id)
    {        
        $query =  "SELECT t_material.*, t_collection.id as id_collection "
                 ."FROM `t_material` "
                 ."LEFT JOIN t_collection ON t_material.id_manufacturer = t_collection.id_manufacturer "
                 ."where id_collection = '".$id."'";
    
                            
         $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query);                            
        return $results;
    } 
   public function getMaterialByColor($id)
    {        
        $query =  "SELECT t_material.* "
                 ."FROM `t_material` "
                 ."where id_color = '".$id."'";
    
                            
         $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query);                            
        return $results;
    } 

   public function getMaterialByTexture($id)
    {        
        $query =  "SELECT t_material.* "
                 ."FROM `t_material` "
                 ."where id_texture = '".$id."'";
    
                            
         $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query);                            
        return $results;
    }          
  
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
public function updatePriceMaterial($data){


        $query = "UPDATE t_material SET price_material = '".$data['price']."',processing_price_material = '".$data['processing_price']."' where id='".$data['id']."'";

         $adapter = $this->getAdapter();
                                    
         $statement = $adapter->createStatement($query);
         $results = $statement->execute();
return $query;

}


  public function insertMaterial($data)
    {

         parent::insert($data);
         $adapter = $this->getAdapter();
         $id = $adapter->getDriver()->getLastGeneratedValue();
      return $id;
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
