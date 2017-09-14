<?php
 
namespace Trenza\Message\Controller\Index;
 
use Magento\Framework\App\Action\Context;
 
class View extends \Magento\Framework\App\Action\Action
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
        $customerSession = $objectManager->get('Magento\Customer\Model\Session');
        
        if(!$customerSession->isLoggedIn()) {
           //$this->redirect('customer/account/login');
           $this->_redirect('customer/account/login');
        }
        else
        {
            $resultPage = $this->_resultPageFactory->create();
        return $resultPage;   
        }
        
        
        
    }
    
}