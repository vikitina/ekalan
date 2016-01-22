<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;


class UnreadMessages extends AbstractHelper
{
    protected $messages; 


    public function __invoke()
    {
        return $this->messages;
    }


    public function getUnreadMessages($messagesTable)
    {
        $this->messages = $messagesTable->getUnreadMessages();
        return $this->messages;

    }
}
 
 
 
