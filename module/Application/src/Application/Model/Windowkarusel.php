<?php

namespace Application\Model;


use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;

class Windowkarusel extends TableGateway
{
    protected $tableName  = 't_windowkarusel';
    protected $idCol = 'id';



    public function __construct($adapter)
    {
        parent::__construct(
            $this->tableName,
            $adapter,
            new RowGatewayFeature($this->idCol)
        );

 
    }

    public function getAllWindowkarusel()
    { 
         $query = "SELECT * FROM t_windowkarusel GROUP BY window_karusel, numframe_karusel";

    
                            
         $adapter = $this->getAdapter();
		     $results = $this->FetchAll($adapter, $query); 
         //var_dump($results)                           ;
        return $results;
    } 
 

    
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    //==========================================================================================================


  
  public function updateWindowkarusel($data)
    { 
      $id = (int)$data['id'];

    
        parent::update($data, array('id' => $id));
        return array('id' => $id, 'name' => $data['name_texture']);
    }



  public function insertWindowkarusel($data)
    {


      parent::insert($data);
      $adapter = $this->getAdapter();
      $id = $adapter->getDriver()->getLastGeneratedValue();

 return $id;      
 
    }   
      
  public function delWindowkarusel($id)
    {
         $query = sprintf("DELETE FROM t_windowkarusel WHERE id='%s'",$id);

                            
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
