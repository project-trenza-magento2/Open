<?php
 
namespace Trenza\Message\Controller\Index;
 
use Magento\Framework\App\Action\Context;
 
class Follow extends \Magento\Framework\App\Action\Action
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
        $model = $objectManager->create('Trenza\Message\Model\Follow');
        $model->setFollowId($follow_id);
        $model->setFollowerId($follower_id);
        $model->save();
        echo $follow_id  .'=>'.$follower_id;
        die();
    }
 
}