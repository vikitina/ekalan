<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;


class GetActiveSale extends AbstractHelper
{
    protected $sales; 


    public function __invoke()
    {
        return $this->sales;
    }


    public function getActiveSale($salesTable)
    {
        $this->sales = $salesTable->getActiveSale();
        return $this->sales;

    }
}
 
 
 
