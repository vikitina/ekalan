<?php

namespace Application\Model;


use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;





class Pages extends TableGateway
{
    protected $tableName  = 't_pages';
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

public function updatePages($data)
{

         if (!isset($data['id'])) {
                          parent::insert($data);
         } else {
                         $id = $data['id'];
                         if ($this->getPagesLo($id)) {
         
                                  //var_dump($data['id']);
              
                                  parent::update($data, array('id' => $id));
                         } else {
                                   throw new \Exception('User ID does not exist');
                                 }
                  }
 }

//deletePages
public function deletePages($data)
{
      $id = $data['id'];
      var_dump($id);
      parent::delete("id = '".$id."'");
       
         
}

    public function getPages($id=null)
    { 

        $query = "
            SELECT * from t_pages ".(($id)? "where id='".$id."'": "order by num");

    
                            
         $adapter = $this->getAdapter();
		 $results = $this->FetchAll($adapter, $query);                            
        return $results;
    } 
  private function getPagesLo($id=null)
    { 

        $query = "
            SELECT * from t_pages ".(($id)? "where id='".$id."'": "order by num");

    
                            
         $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query);                            
        return $results;
    } 

  
 /* public function updatePages($data=null)
    { 
         /*$query = sprintf("UPDATE t_pages SET title='%s', content='%s', num='%s' ".(($data) ? " WHERE id='%s'" : ''),
              mysql_real_escape_string($data['title']),
              mysql_real_escape_string($data['content']),
              $data['num'],
              $data['id']
            );
  
$query = "UPDATE t_pages SET title = :title,
                             content = :content,
                             num = :num  WHERE id=:id";

     
echo '<br />------------------';
echo '<br />data (model - update pages ):<br>';
        var_dump($data)   ;
 echo '<br />------------------';
        $adapter = $this->getAdapter();
                                    
         //$statement = $adapter->createStatement($query);

        $adapter = $this->getAdapter();
        $statement = $adapter->prepare($query);
        $statement->bind(':title', $data['title']);
        $statement->bind(':content', $data['content']);
        $statement->bind(':num', $data['num']);
        $statement->bind(':id', $data['id']);


        /*

$stmt = $this->db->prepare("SELECT * FROM ".$this->db_table." WHERE username=:user LIMIT 1";
$stmt->bind(':user', $username);
$stmt->execute();

       
         $results = $statement->execute();
         
        return $results;

/*

array(4) { ["id"]=> string(2) "15" ["title"]=> string(5) "Start" ["content"]=> string(10543) " 

  `main_page` tinyint(4) DEFAULT NULL,
  `link` varchar(250) NOT NULL,
  `in_menu` tinyint(1) NOT NULL,
  `title` text NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL,
  `etc` text NOT NULL,
  `sections_class` varchar(250) NOT NULL,
  `num` int(11) NOT NULL,

*/

  //  } 
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
