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
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
use Zend\Mail\Transport\SmtpOptions;
class AjaxController extends AbstractActionController
{
    public function indexAction()
    {



                  $data = $_POST;
                  $messageSrv    = $this -> getServiceLocator()->get('message');

                  $db_data = array(
                      'name'        => $data['sc_name'],
                     // 'discount'     => $data['sc_discount'],
                      'email'       => $data['sc_mail'],
                      'phone'       => $data['sc_phone'],
                      'content'     => $data['sc_text'],
                      
                  	);

                   $db_data['once_opened'] = 0;
                   $db_data['already_read'] = 0;                  
                   $message = $messageSrv ->  insertMessages($db_data);
                  

    	          $result = new JsonModel ( array (
    	          	'res' => $db_data['name'].' '.$db_data['email'].' '.$db_data['phone']
        ) );
       

         
   return $result;
    }



}
