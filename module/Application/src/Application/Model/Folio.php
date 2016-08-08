<?php

namespace Application\Model;


use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature\RowGatewayFeature;

class Folio extends TableGateway
{
    protected $tableName  = 't_folio';
    protected $idCol = 'id';
 

    public function __construct($adapter)
    {
        parent::__construct(
            $this->tableName,
            $adapter,
            new RowGatewayFeature($this->idCol)
        );
/*  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_group` int(11) NOT NULL,
  `number_folio` varchar(255) NOT NULL,
  `name_folio` varchar(255) NOT NULL,
  `describe_folio` text NOT NULL,
  `id_testimonials` int(11) NOT NULL,
  `price_folio` int(11) NOT NULL,*/
 
    }

    public function getAllFolios()
    { 
         $query = "SELECT * from t_folio";

    
                            
         $adapter = $this->getAdapter();
		     $results = $this->FetchAll($adapter, $query); 
         //var_dump($results)                           ;
        return $results;
    } 

        public function getAllFoliosByDate()
    { 
         $query = "SELECT * from t_folio order by id desc";

    
                            
         $adapter = $this->getAdapter();
             $results = $this->FetchAll($adapter, $query); 
         //var_dump($results)                           ;
        return $results;
    } 

   public function getFolio($id)
    { 

        $query = "SELECT * from `t_folio` where id ='".$id."'";
        
    
                            
         $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query);                            
        return $results ? $results[0] : null;
    }  


//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

public function getSpecFolioById($id){

        $query = "SELECT t_folio.*,t_folio.id as folio_id, t_testimonials.*, t_pictures.url_picture, t_pictures.id as id_picture "
                ."FROM t_folio "
                ."LEFT JOIN t_testimonials ON t_folio.id_testimonials=t_testimonials.id "
                ."LEFT JOIN t_pictures ON t_testimonials.id_picture=t_pictures.id "
                ."WHERE t_folio.id='".(int)$id."'";

         $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query);
                                     
        return $results ? $results[0] : null;                


}
//==========================================================================================================

public function getFolioIdByTestimonialId($id){
         $query = "SELECT id from `t_folio` where id_testimonials ='".$id."'";
         $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query);                            
        return ($results) ? $results[0]['id'] : 0;

}
 public function getFolioByGroup($id){
         $query = "SELECT * from `t_folio` where id_group ='".$id."'";                         
         $adapter = $this->getAdapter();
         $results = $this->FetchAll($adapter, $query);                            
    return $results;

} 
  public function updateFolio($data)
    { 
        $id = (int)$data['id']; 
        parent::update($data, array('id' => $id));
        
    }



  public function insertFolio($data)
    {


      parent::insert($data);
      $adapter = $this->getAdapter();
      $id = $adapter->getDriver()->getLastGeneratedValue();

 return $id;
 
    }   
      
  public function delFolio($id)
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
