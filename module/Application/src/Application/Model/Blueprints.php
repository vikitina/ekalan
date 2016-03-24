<?php

namespace Application\Model;


use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;

class Blueprints extends TableGateway
{
    protected $tableName  = 't_blueprint';
    protected $idCol = 'id';
 

    public function __construct($adapter)
    {
        parent::__construct(
            $this->tableName,
            $adapter,
            new RowGatewayFeature($this->idCol)
        );
/*CREATE TABLE IF NOT EXISTS `t_blueprint` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url_blueprint` varchar(255) NOT NULL,
  `id_folio` int(11) NOT NULL,
  PRIMARY KEY (`id`)
)*/
 
    }

    public function getAllBlueprints()
    { 
         $query = "SELECT * from t_blueprint";

    
                            
         $adapter = $this->getAdapter();
		     $results = $this->FetchAll($adapter, $query); 
         //var_dump($results)                           ;
        return $results;
    } 

   public function getBlueprint($id)
    { 

        $query = "SELECT * from `t_blueprint` where id ='".$id."'";
        
    
                            
         $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query);                            
        return $results[0];
    }     
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    //==========================================================================================================
   public function getByFolio($id){

         $query = "SELECT * from `t_blueprint` where id_folio ='".$id."'";
         $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query);                            
        return $results;

   }

  
  public function updateBlueprint($data)
    { 
      $id = (int)$data['id'];

    
        parent::update($data, array('id' => $id));
        
    }



  public function insertBlueprint($data)
    {


      parent::insert($data);
      $adapter = $this->getAdapter();
      $id = $adapter->getDriver()->getLastGeneratedValue();

 return $id;
 
    }   
      
  public function delBlueprint($id)
    {
         $query = sprintf("DELETE FROM t_blueprint WHERE id='%s'",$id);

                            
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
