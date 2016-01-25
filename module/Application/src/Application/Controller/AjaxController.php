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

        //amount=%241000+-+%243299   firstName=name    company=company   email=asd%40gmail.com    phone=asda%40asdas.xcv  msg_text=
        //amount=%241000+-+%243299   firstName=asdasdasd  company=asdasdasd  email=asd%40gmail.com  phone=123123123123  msg_text=asdasdasdasdasd#

        //может быть забираем сообщение аяксом, говорим спасибо, ждем 5 сек, убираем "спасибо", очищаем форму


                  $data = $_POST;
                  $messageSrv    = $this -> getServiceLocator()->get('message');
        
               //   $content = '';
               //   $fl = 0;
               //   if (is_array($data['services'])) {
               //        $content .= '<h3> The necessary work:</h3><ul>'	;
               //        $fl = 1;
               //   	   foreach ($data['services'] as $serv){

              //    		         $content .= '<li>' .$serv. '</li>';
              //    	    }
                        
             //    }
            //      if (is_array($data['solutions'])) {
             //           $content .= (($fl==0)?'<h3> The necessary work:</h3><ul>':'');
            ///            $fl = 1;
             //           foreach ($data['solutions'] as $solu){

            //      		         $content .= '<li>' .$solu. '</li>';
            //      	    }
           //       }
           //       $content .= (($fl>0)?'</ul>':'');
           //       $content .= (isset($data['amount']) && $data['amount'])?('<h3>Budget:</h3>'.'<p>'.$data['amount'].'</p>'):'';
                  $db_data = array(
                      'name'        => $data['sc_name'],
                     // 'discount'     => $data['sc_discount'],
                      'email'       => $data['sc_mail'],
                      'phone'       => $data['sc_phone'],
                      
                  	);

                   //$this->  sendMail($db_data);

                   $db_data['once_opened'] = 0;
                   $db_data['already_read'] = 0;                  
                   $message = $messageSrv ->  insertMessages($db_data);
                  

    	          $result = new JsonModel ( array (
                //'text'                   => $ajaxSrv->getResponce($filter),
    	          	'res' => $db_data['name'].' '.$db_data['email'].' '.$db_data['phone']
        ) );
       

         
   return $result;
    }



private function sendMail($data){


	      $message = new Message();
          $message->addTo('tarawebstudio@gmail.com')
                  ->addFrom('tarawebstudio@gmail.ru')
                  ->setSubject('Сообщение с сайта TARA');
     
// Setup SMTP transport using LOGIN authentication
          $transport = new SmtpTransport();
          $options   = new SmtpOptions(array(
                  'host'              => 'smtp.gmail.com',
                  'connection_class'  => 'login',
                  'connection_config' => array(
                  'ssl'       => 'tls',
                  'username' => 'tarawebstudio@gmail.com',
                  'password' => 'Bricks_7782'


            ),

          'port' => 587,
//'port' => 465,
          ));
          $p = '';
          foreach ($data as $val){
                
                         $p .= '<p>'.$val.'</p>';

                }
               
          $html = new MimePart($p);
          $html->type = "text/html";

          $body = new MimeMessage();
          $body->addPart($html);

          $message->setBody($body);

          $transport->setOptions($options);
          $transport->send($message);
}

}
