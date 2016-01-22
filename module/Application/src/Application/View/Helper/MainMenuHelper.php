<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;


class MainMenuHelper extends AbstractHelper
{
    protected $menu; 

    public function __invoke()
    {
        return $this->menu;
    }

    public function getMainMenu($myPagesTable)
    {
        $this->menu = $myPagesTable->getPages();
        return $this->menu;        
    }
}
 
 
 
