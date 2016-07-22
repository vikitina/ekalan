<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;



class CalculatorController extends AbstractActionController
{
    public function indexAction()
    {
       	$get_data = $this->getEvent()->getRouteMatch()->getParam('id_material');	
       
        

        return new ViewModel(array(
                     'set_material_html' => $set_material_html,
                     'data'              => $data_array,
                     'blocks'            => $blocks,
                     'rowcount'          => $rowcount,
                     'limit'             => $limit       
        ));
        
    }










}
