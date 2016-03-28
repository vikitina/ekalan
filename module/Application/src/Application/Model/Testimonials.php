<?php

namespace Application\Model;


use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;

class Testimonials extends TableGateway
{
    protected $tableName  = 't_testimonials';
    protected $idCol = 'id';
 

    public function __construct($adapter)
    {
        parent::__construct(
            $this->tableName,
            $adapter,
            new RowGatewayFeature($this->idCol)
        );
/*`t_testimonials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_testimonials` varchar(255) NOT NULL,
  `organization` varchar(255) NOT NULL,
  `id_picture` int(11) NOT NULL,
  `text_testimonials` text NOT NULL,
  `short_text_testimonials` text NOT NULL,
  `public_on_home_testimonials` tinyint(4) NOT NULL,*/
 
    }

    public function getAllTestimonials()
    { 
         $query = "SELECT * from t_testimonials";

    
                            
         $adapter = $this->getAdapter();
		     $results = $this->FetchAll($adapter, $query); 
         //var_dump($results)                           ;
        return $results;
    } 

   public function getTestimonial($id)
    { 

        $query = "SELECT * from `t_testimonials` where id ='".$id."'";
        
    
                            
         $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query);                            
        return $results[0];
    }  
   public function getHomeTestimonials()
    { 

        $query = "SELECT *, t_pictures.* "
                ."FROM `t_testimonials` "
                ."LEFT JOIN t_pictures ON t_testimonials.id_picture = t_pictures.id "
                ."WHERE  public_on_home_testimonials = 1";
        
    
                            
         $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query);                            
        return $results;
    } 

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    //==========================================================================================================


  
  public function updateTestimonial($data)
    { 
      $id = (int)$data['id'];

    
        parent::update($data, array('id' => $id));
        
    }



  public function insertTestimonial($data)
    {


      parent::insert($data);
      $adapter = $this->getAdapter();
      $id = $adapter->getDriver()->getLastGeneratedValue();

 return $id;
 
    }   
      
  public function delTestimonial($id)
    {
         $query = sprintf("DELETE FROM t_testimonials WHERE id='%s'",$id);

                            
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
