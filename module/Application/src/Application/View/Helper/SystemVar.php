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

    public function getSystemVars($systemTable)
    {
        $this->system = $systemTable->getSystem();
        return $this->system;        
    }
}
 
 
 
