<?php

namespace Application\Model;


use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;

class Calcprice extends TableGateway
{

/*

`t_calc_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `calc_name` varchar(255) NOT NULL,
  `calc_title` varchar(255) NOT NULL,
  `calc-cprice` int(11) NOT NULL,
  `calc_unit` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `calc_name` (`calc_name`)
*/

    protected $tableName  = 't_calc_price';
    protected $idCol = 'id';
 

    public function __construct($adapter)
    {
        parent::__construct(
            $this->tableName,
            $adapter,
            new RowGatewayFeature($this->idCol)
        );

 
    }

    public function getAllCalcprice()
    { 
          $query = "SELECT * FROM t_calc_price";
        

    
                            
         $adapter = $this->getAdapter();
		     $results = $this->FetchAll($adapter, $query); 
         //var_dump($results)                           ;
        return $results;
    } 




//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    //==========================================================================================================
         
  
public function updateCalcprice($data){

        $id = (int)$data['id']; 
        parent::update($data, array('id' => $id));

}


  public function insertCalcprice($data)
    {

         parent::insert($data);
         $adapter = $this->getAdapter();
         $id = $adapter->getDriver()->getLastGeneratedValue();
      return $id;
    }   
      
  public function delCalcprice($id)
    {
         $query = sprintf("DELETE FROM t_calc_price WHERE id='%s'",$id);

                            
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
