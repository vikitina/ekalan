<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;


class SystemEmail extends AbstractHelper
{
    protected $system; 

    public function __invoke()
    {
        return $this->system;
    }

    public function getSystemEmail($systemTable)
    {
        $this->system = $systemTable->getSystemEmail();
        return $this->system;        
    }
   public function getSystemAddress($systemTable)
    {
        $this->system = $systemTable->getSystemAddress();
        return $this->system;        
    }    
}
 
 
 
