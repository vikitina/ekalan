<?php

namespace Application\Model;


use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;

class Illustrates extends TableGateway
{
    protected $tableName  = 't_illustrates';
    protected $idCol = 'id';
 

    public function __construct($adapter)
    {
        parent::__construct(
            $this->tableName,
            $adapter,
            new RowGatewayFeature($this->idCol)
        );
/*t_illustrates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url_illustrates` varchar(255) NOT NULL,
  `id_article` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_article` (`id_article`)
)*/
 
    }

    public function getAllIllustratesForArt($id)
    { 
        
         $query = "SELECT * from t_illustrates where id_article = '". $id ."'";
         $adapter = $this->getAdapter();
		 $results = $this->FetchAll($adapter, $query); 
         //var_dump($results)                           ;
         return $results;
    } 

 //==========================================================================================================

  public function insertIllustrate($data)
    {
        parent::insert($data);
        $adapter = $this->getAdapter();
        $id = $adapter->getDriver()->getLastGeneratedValue();
        return $id;
 
    }   
      
  public function delIllustrate($id)
    {
         $query = sprintf("DELETE FROM t_illustrates WHERE id='%s'",$id);
         $adapter = $this->getAdapter();                                
         $statement = $adapter->createStatement($query);
         $results = $statement->execute();
         return $results;
    }     
  public function delByArticle($id_art){
         $query = sprintf("DELETE FROM t_illustrates WHERE id_article = '%s'",$id_art);
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
