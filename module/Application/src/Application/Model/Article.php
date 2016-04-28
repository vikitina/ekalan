<?php

namespace Application\Model;


use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;

class Article extends TableGateway
{
    protected $tableName  = 't_article';
    protected $idCol = 'id';
 

    public function __construct($adapter)
    {
        parent::__construct(
            $this->tableName,
            $adapter,
            new RowGatewayFeature($this->idCol)
        );
/*  `t_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title_article` varchar(255) NOT NULL,
  `short_article` text NOT NULL,
  `full_article` text NOT NULL,
  PRIMARY KEY (`id`)*/
 
    }

    public function getAllArticles()
    { 
         $query = "SELECT * from t_article";

    
                            
         $adapter = $this->getAdapter();
		 $results = $this->FetchAll($adapter, $query); 
         //var_dump($results)                           ;
        return $results;
    } 

   public function getArticle($id)
    { 

         $query = "SELECT * from `t_article` where id ='".$id."'";
         $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query);                            
        return $results[0];
    }  

    public function getAllPublished(){
         $query = "SELECT * from `t_article` where public ='1'";                          
         $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query);                            
         return $results;
    }    

    public function getForHome(){
         $query = "SELECT * from `t_article` where on_home ='1'";                          
         $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query);                            
         return $results;
    }  

  public function updateArticle($data)
    { 
        $id = (int)$data['id']; 
        parent::update($data, array('id' => $id));
        
    }



  public function insertArticle($data)
    {


      parent::insert($data);
      $adapter = $this->getAdapter();
      $id = $adapter->getDriver()->getLastGeneratedValue();

 return $id;
 
    }   
      
  public function delArticle($id)
    {
         $query = sprintf("DELETE FROM t_folio WHERE id='%s'",$id);

                            
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
