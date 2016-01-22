<?php

namespace Application\Model;


use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;

class Messages extends TableGateway
{
    protected $tableName  = 't_message';
    protected $idCol = 'id';
 

    public function __construct($adapter)
    {
        parent::__construct(
            $this->tableName,
            $adapter,
            new RowGatewayFeature($this->idCol)
        );

 
    }

    public function getMessages()
    { 

        $query = "SELECT * from t_message order by date desc";

    
                            
         $adapter = $this->getAdapter();
		     $results = $this->FetchAll($adapter, $query);                            
        return $results;
    } 
   public function getMessage($id)
    { 

        $query = "SELECT * from `t_message` where id ='".$id."'";

    
                            
         $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query);                            
        return $results[0];
    }     

    public function getUnreadMessages(){

        $query = "SELECT count(id) as c from t_message where already_read <> '1'";

    
                            
         $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query);                            
       //  var_dump($results);
        return $results[0]["c"];

    }
  
  public function updateMsg($data=null)
    { 
      $id = $data['id'];
        parent::update($data, array('id' => $id));
    } 

  
  public function insertMessages($data)
    {


      parent::insert($data);
 
    }   
      
  public function delPages($id)
    {
         $query = sprintf("DELETE FROM t_pages WHERE id='%s'",$id);

                            
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
