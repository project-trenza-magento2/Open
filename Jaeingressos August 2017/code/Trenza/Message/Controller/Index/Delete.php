<?php
 
namespace Trenza\Message\Controller\Index;
 
use Magento\Framework\App\Action\Context;
 
class Delete extends \Magento\Framework\App\Action\Action
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
        $msg_model = $objectManager->create('\Trenza\Message\Model\Message');
        $customerSession = $objectManager->get('Magento\Customer\Model\Session');
       
       $receiver_id = $customerSession->getId ();
        

        $checkbox = $this->getRequest()->getParam('checkbox');
        foreach($checkbox as $v){
            //$parent_id = 12;
            //$parent_id = 3;
            //$parent_id = 1;
            $parent_id = $v;
            $parent =$msg_model->load($parent_id);

            $message_collection = $msg_model->getCollection();
            
            
            
            $sender_id = $parent->getSenderId();
            
            $data_message = $message_collection->addFieldToFilter('sender_id', $sender_id)->addFieldToFilter('receiver_id', $receiver_id);
            
            foreach($data_message as $message){
                echo $id = $message->getId();
                echo '>'.$message->getReceiverDeleteFlg().'<br>';
                $message_delete = $msg_model->load($id)->setReceiverDeleteFlg(1);
                $message_delete->save();
                
            }
            
            
            
        }
        
        
        $collection = $msg_model->getCollection();
        foreach($collection as $val){
            //$result[]['Id'] = array('id' => $val->getId());
            $result[] = array('Id'=>$val->getId(),'Parent_id'=>$val->getParentId(),'Reciever_Id'=>$val->getReceiverId(),'Sender_Id'=>$val->getSenderId(),
            'Sender_Delete_Flg'=>$val->getSenderDeleteFlg(),'Buyer_Delete_Flg'=>$val->getReceiverDeleteFlg(),'Sender_Read_Flg'=>$val->getSenderReadFlg(),
            'Reciever_Read_Flg'=>$val->getReceiverReadFlg(),'Sender_Id'=>$val->getSenderId());

        }
        echo '<pre>';
        print_r($result);
        echo '</pre>';
        
        exit();
        //$follower_id = $this->getRequest()->getParam('follower_id');

        if(false){
            $objectManager->get('Magento\CatalogSearch\Model\ResourceModel\Advanced\Collection');
            $data = array('follow_id'=>2,'follower_id'=>8,'status'=>1,'follow_status'=>1);
            $model = $objectManager->create('Trenza\Message\Model\Follow');
		    $model->setId($status)->delete();

        }
    }
    
   
    
}