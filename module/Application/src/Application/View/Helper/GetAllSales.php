<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;


class GetAllSales extends AbstractHelper
{
    protected $sales; 


    public function __invoke()
    {
        return $this->sales;
    }


    public function getAllSales($salesTable)
    {
        $this->sales = $salesTable->getAllSales();
        return $this->sales;

    }
}
 
 
 
