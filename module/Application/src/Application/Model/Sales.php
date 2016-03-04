<?php

namespace Application\Model;


use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;

class Sales extends TableGateway
{
    protected $tableName  = 't_sales';
    protected $idCol = 'id';
 

    public function __construct($adapter)
    {
        parent::__construct(
            $this->tableName,
            $adapter,
            new RowGatewayFeature($this->idCol)
        );

 
    }

    public function getAllSales()
    { 

        $query = "SELECT * from t_sales";

    
                            
         $adapter = $this->getAdapter();
		     $results = $this->FetchAll($adapter, $query);                            
        return $results;
    } 
   public function getSale($id)
    { 

        $query = "SELECT * from `t_sales` where id ='".$id."'";

    
                            
         $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query);                            
        return $results[0];
    }     
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function getActiveSale(){

        $query = "SELECT sales_markup as c, name_sales from t_sales where sales_active='1'";

    
                            
         $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query);                            
        // var_dump($results);
        return $results[0]["c"];

    }
    //==========================================================================================================


  
  public function updateSales($data=null)
    { 
      $id = $data['id'];
      $data['sales_markup'] = preg_replace("|[\s]+|s", " ", $data['sales_markup']);
      $data['sales_active'] = ($data['sales_active']  == 'on')?'1':'0';
    
        parent::update($data, array('id' => $id));
    }


public function updatemarkupSales($data){


        $query = "UPDATE t_sales SET sales_markup = '".$data['markup']."' where id='".$data['id']."'";

         $adapter = $this->getAdapter();
                                    
         $statement = $adapter->createStatement($query);
         $results = $statement->execute();
return $query;

}
public function updateactiveSales($data){


        $query = "UPDATE t_sales SET sales_active = '".$data['active']."' where id='".$data['id']."'";

         $adapter = $this->getAdapter();
                                    
         $statement = $adapter->createStatement($query);
         $results = $statement->execute();
return $query;

}

public function updateoffallactiveSales(){


        $query = "UPDATE t_sales SET sales_active = '0'";

         $adapter = $this->getAdapter();
                                    
         $statement = $adapter->createStatement($query);
         $results = $statement->execute();
return $query;

}
  
  public function insertSales($data)
    {


      parent::insert($data);
 
    }   
      
  public function delSales($id)
    {
         $query = sprintf("DELETE FROM t_sales WHERE id='%s'",$id);

                            
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
