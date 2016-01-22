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
class TesterController extends AbstractActionController
{
    public function mailAction()
    {

        //amount=%241000+-+%243299   firstName=name    company=company   email=asd%40gmail.com    phone=asda%40asdas.xcv  msg_text=
        //amount=%241000+-+%243299   firstName=asdasdasd  company=asdasdasd  email=asd%40gmail.com  phone=123123123123  msg_text=asdasdasdasdasd#

        //может быть забираем сообщение аяксом, говорим спасибо, ждем 5 сек, убираем "спасибо", очищаем форму


                
                  $content = 'qweqweqweqwe';
                
                  $content .= '<h3> The necessary work:</h3><ul>'	;
                  $content .= '<li>asdasdasdasd</li>';
                  $content .= '</ul>';
                  $this->  sendMail($content);

 }



private function sendMail($data){

/*
	      $message = new Message();
          $message->addTo('vikitina@gmail.com')
                  ->addFrom('vikitina@gmail.ru')
                  ->setSubject('Сообщение с сайта TARA');
     
// Setup SMTP transport using LOGIN authentication
          $transport = new SmtpTransport();
          $options   = new SmtpOptions(array(
                  'host'              => 'smtp.gmail.com',
                  'connection_class'  => 'login',
                  'connection_config' => array(
                 'ssl'       => 'tls',
                //  'username' => 'tarawebstudio@gmail.com',
                //  'password' => 'qwerty7782'
                  'username' => 'vikitina@gmail.com',
                  'password' => 'vikabibika0987654321'

            ),
          'port' => 587,
          ));
          $p = $data;
        
               
          $html = new MimePart($p);
          $html->type = "text/html";

          $body = new MimeMessage();
          $body->addPart($html);

          $message->setBody($body);

          $transport->setOptions($options);
          $transport->send($message);
*/

  $message = new Message();
  $message->setBody($data);
$message->setFrom('kinjalshah96@gmail.com');
$message->addTo('vikitina@gmail.com');
$message->setSubject('Test subject');
$smtpOptions = new SmtpOptions();
$smtpOptions->setHost('smtp.gmail.com')                                             
            ->setName('smtp.gmail.com')
            ->setPort(587)
            ->setConnectionClass('login')
            ->setConnectionConfig(array(
                               'username' => 'tarawebstudio@gmail.com',
                               'password' => 'Bricks_7782',
                               'ssl' => 'tls',
                              // 'host'=>'localhost:8080',                                                                 
                             )
                  );
$transport = new SmtpTransport($smtpOptions);
$transport->send($message);

}

}
