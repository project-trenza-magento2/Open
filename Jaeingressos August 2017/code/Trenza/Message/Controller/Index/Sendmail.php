<?php
 
namespace Trenza\Message\Controller\Index;
 
use Magento\Framework\App\Action\Context;
 
class Sendmail extends \Magento\Framework\App\Action\Action
{
    protected $_resultPageFactory;
 
    public function __construct(Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {
        $this->_resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }
 
    public function execute()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); 
        
        $message_model = $objectManager->create('Trenza\Message\Model\Message');
        $customerSession = $objectManager->get('Magento\Customer\Model\Session');
        $sender_email = $this->getRequest()->getParam('sender_email');
        $sender_name = $this->getRequest()->getParam('sender_name');
        $message = $this->getRequest()->getParam('message');
        
        $store_mail = $objectManager->create('Trenza\Message\Helper\Data')->getConfig('trans_email/ident_general/email');

        $message = "Sender Email: ".$sender_email."\r\nSender Name: ".$sender_name."\r\nSender Message: \r\n$message";
        $message = wordwrap($message, 70, "\r\n");
        
        try {
            mail($store_mail, 'Promotion', $message);
        } catch (Exception $e) { 
            echo 'fail';
        }
        
        
        
    }
    
    
}