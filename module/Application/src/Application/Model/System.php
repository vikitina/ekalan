<?php

namespace Application\Model;


use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;





class System extends TableGateway
{
    protected $tableName  = 't_system';
    protected $idCol = 'id';
    protected $tableGateway;

    public function __construct($adapter)
    {
        parent::__construct(
            $this->tableName,
            $adapter,
            new RowGatewayFeature($this->idCol)
        );
       // $this->tableGateway = $tableGateway;

    }

public function updateSystem($data)
{

         
     $id = (int)$data['id'];
      parent::update($data, array('id' => $id));
                      
 }

//deletePages
public function deletePages($data)
{
      $id = $data['id'];
      var_dump($id);
      parent::delete("id = '".$id."'");
       
         
}

    public function getSystem($id=null)
    { 

        $query = "
            SELECT * from t_system ".(($id)? "where id='".$id."'": "");

    
                            
         $adapter = $this->getAdapter();
		 $results = $this->FetchAll($adapter, $query);                            
        return $results;
    } 
  public function getSystemByName($name)
    { 

        $query = "SELECT * from t_system where name='".$name."'";
        $adapter = $this->getAdapter();
        $results = $this->FetchAll($adapter, $query);                            
        return $results[0]['data'];
    }
  
  public function getSystemEmail()
    { 

        $query = "SELECT * from t_system where name='email'";
        $adapter = $this->getAdapter();
        $results = $this->FetchAll($adapter, $query);                            
        return $results[0]['data'];
    }
  public function getSystemAddress()
    { 

        $query = "SELECT * from t_system where name='address'";
        $adapter = $this->getAdapter();
        $results = $this->FetchAll($adapter, $query);                            
        return $results[0]['data'];
    }

  private function getPagesLo($id=null)
    { 

        $query = "
            SELECT * from t_pages ".(($id)? "where id='".$id."'": "order by num");

    
                            
         $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query);                            
        return $results;
    } 

 
    private function updatePageNumLo($data=null)
    { 
         $query = sprintf("UPDATE t_pages SET num='%s' ".(($data) ? " WHERE id='%s'" : ''),
              
              $data['num'],
              $data['id']
            );
  
                            
         $adapter = $this->getAdapter();
                                    
         $statement = $adapter->createStatement($query);
         $results = $statement->execute();
         
        return $results;


    } 

private function getPrevPos($num)
    { 
         $query = "select * from t_pages where num < ".$num." order by num desc limit 1";


         $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query);                            
        return $results[0];

    }

private function getNextPos($num)
    { 
         $query = "select * from t_pages where num > ".$num." order by num asc limit 1";


         $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query);                            
        return $results[0];

    }    

  public function setNumOnePosUp($id)
    { 
         
        $cur_page_tmp = $this->getPagesLo($id);
        $cur_page = $cur_page_tmp[0];
        $cur_num = $cur_page['num'];
        
        $prev_page = $this->getPrevPos($cur_num);
   
          
        $cur_page_data = array(
              'id'    => $id,
              'num' =>   $prev_page['num']
         );
        $prev_page_data = array(
              'id'    => $prev_page['id'],
              'num' =>   $cur_num
        );

          $this->updatePageNumLo($cur_page_data);
          $this->updatePageNumLo($prev_page_data);

    }  


 public function setNumOnePosDown($id)
    { 
         
        $cur_page_tmp = $this->getPagesLo($id);
        $cur_page = $cur_page_tmp[0];
        $cur_num = $cur_page['num'];
        
        $next_page = $this->getNextPos($cur_num);
   
          
        $cur_page_data = array(
              'id'    => $id,
              'num' =>   $next_page['num']
         );
        $next_page_data = array(
              'id'    => $next_page['id'],
              'num' =>   $cur_num
        );

          $this->updatePageNumLo($cur_page_data);
          $this->updatePageNumLo($next_page_data);

    } 

   
  
  public function insertPages($data)
    {
         $query = sprintf("INSERT INTO t_pages (title,content,num) VALUES ('%s', '%s', '%s')",
           
              $data['title'],
              $data['content'],
              $data['num']
              
            );

                            
         $adapter = $this->getAdapter();
                                    
         $statement = $adapter->createStatement($query);
         $results = $statement->execute();
         
        return $results;
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
