<?php
 
namespace Trenza\Message\Controller\Index;
 
use Magento\Framework\App\Action\Context;
 
class Send extends \Magento\Framework\App\Action\Action
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

        $message_filter = $objectManager->create('Trenza\Message\Helper\Data')->getConfig('message_settings/general/message_filter');
        
        $message_filter = nl2br(trim($message_filter));
        $message_filter = explode("<br />", $message_filter);

        $the_message = $this->getRequest()->getParam('message');
        $patterns = $message_filter;

        $the_final_message =  preg_replace($patterns, ' <span>removed</span> ' , $the_message);

       
        $sender_id = $customerSession->getId ();
        $receiver_id = $this->getRequest()->getParam('receiver_id');
        $seller_id = $this->getRequest()->getParam('seller_id');
        if(!$seller_id){
            $seller_id = 0;
        }

        $product_id = $this->getRequest()->getParam('product_id');
        $parent_id = $this->getRequest()->getParam('parent_id');

        $created_at = date("Y-m-d H:i:s");
        
        
        if($sender_id && $receiver_id && $the_message)
        {
    	    try
            {
                $message_model->setProductId($product_id);
                $message_model->setSellerId($seller_id);
                $message_model->setBuyerId(0);
                $message_model->setParentId($parent_id);
                $message_model->setMessage($the_final_message);
                
                $message_model->setSenderReadFlg(0);
                $message_model->setReceiverReadFlg(0);
                $message_model->setReceiverDeleteFlg(0);
                $message_model->setSenderId($sender_id);
                $message_model->setReceiverId($receiver_id);
                $message_model->setCreatedAt($created_at);
        		$message_model->setUpdatedAt($created_at);
                
                $message_model->save();

            }
            catch(Exception $e) 
            {
              echo 'fail';
            }
        }
        else
        {
        }
    }
    
    
}