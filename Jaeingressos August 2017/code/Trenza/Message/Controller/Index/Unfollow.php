<?php
 
namespace Trenza\Message\Controller\Index;
 
use Magento\Framework\App\Action\Context;
 
class Unfollow extends \Magento\Framework\App\Action\Action
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
        $objectManager->get('Magento\CatalogSearch\Model\ResourceModel\Advanced\Collection');
        $follow_id = $this->getRequest()->getParam('follow_id');
        $follower_id = $this->getRequest()->getParam('follower_id');
        $status = $this->follow_or_not($follower_id,$follow_id);
        if($status){
            $objectManager->get('Magento\CatalogSearch\Model\ResourceModel\Advanced\Collection');
            $data = array('follow_id'=>2,'follower_id'=>8,'status'=>1,'follow_status'=>1);
            $model = $objectManager->create('Trenza\Message\Model\Follow');
		    $model->setId($status)->delete();

        }
    }
    
    protected function follow_or_not($follower_id,$follow_id){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); 
        $objectManager->get('Magento\CatalogSearch\Model\ResourceModel\Advanced\Collection');
        $model = $objectManager->create('Trenza\Message\Model\Follow');
        $collection = $model->getCollection()->addFieldToFilter('follow_id', $follow_id)->addFieldToFilter('follower_id', $follower_id);
        foreach($collection as $item){
            if($item->getId()){
                return $item->getId();
            }else{
                return '';
            }
        }
    }
    
}