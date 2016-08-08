<?php

namespace Application\Model;


use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;

class Calcsess extends TableGateway
{
    protected $tableName  = 't_calc_sess';
    protected $idCol = 'id';
 

    public function __construct($adapter)
    {
        parent::__construct(
            $this->tableName,
            $adapter,
            new RowGatewayFeature($this->idCol)
        );
/*`t_calc_sess` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `calc_sess` varchar(255) NOT NULL,
  `calc_date` date NOT NULL,
  `calc_data` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `calc_sess` (`calc_sess`)
)*/
 
    }

    public function getCalcSess($id)
    { 
        
         $query = "SELECT * from t_calc_sess where calc_sess = '". $id ."'";
         $adapter = $this->getAdapter();
		 $results = $this->FetchAll($adapter, $query); 
         //var_dump($results)                           ;
         return ($results ? $results[0] : false);
    } 

 //==========================================================================================================

  public function insertCalcSess($data)
    {
        parent::insert($data);
        $adapter = $this->getAdapter();
        $id = $adapter->getDriver()->getLastGeneratedValue();
        return $id;
 
    }   
      
  public function delCalcSess($id)
    {
         $query = sprintf("DELETE FROM t_calc_sess WHERE calc_sess='%s'",$id);
         $adapter = $this->getAdapter();                                
         $statement = $adapter->createStatement($query);
         $results = $statement->execute();
         return $results;
    }  

  public function updateCalcSess($data)
    { 
        $id = $data['id'];
        parent::update($data, array('id' => $id));
    }

   function FetchAll($adapter, $sql, $params=null)
    {
        $statement = $adapter->createStatement($sql, $params);
        $results = $statement->execute();
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
