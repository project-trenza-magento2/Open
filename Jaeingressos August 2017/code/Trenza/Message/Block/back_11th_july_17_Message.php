<?php
namespace Trenza\Message\Block;
 
class Message extends \Magento\Framework\View\Element\Template
{
    public function getMessage()
    {
        echo 'Test Message';
    }

	public function custom_connection(){
		$this->_resources = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Framework\App\ResourceConnection');
		$connection= $this->_resources->getConnection();
		return $connection;
	}
    
	public function view_message_data()
    {
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance(); 
        $objectManager->get('Magento\CatalogSearch\Model\ResourceModel\Advanced\Collection');
		$model = $objectManager->create('Trenza\Message\Model\Message');
		$collection = $model->getCollection();
        $collection->setOrder('id', 'DESC');
        return $collection;
	}
 
    public function seller_inbox($seller_id)
    {
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance(); 
        $objectManager->get('Magento\CatalogSearch\Model\ResourceModel\Advanced\Collection');
		$model = $objectManager->create('Trenza\Message\Model\Message');
		
        
        ### The following code was written by mahbub ###
        
        #$collection = $model->getCollection();
        #$collection = $model->getCollection()->addFieldToFilter('receiver_id', $seller_id);
        #$collection = $model->getCollection()->addFieldToFilter('sender_delete_flg', 0);
        #$collection->setOrder('id', 'DESC');
        
        
        
        
        $collection = $model->getCollection();
        $collection->addFieldToFilter('receiver_id', $seller_id);
        $collection->addFieldToFilter('sender_delete_flg', 0);            
        $collection->getSelect()->group('sender_id')->order('id DESC');
        
        
        
        return $collection;
	}

    public function buyer_inbox($buyer_id){
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance(); 
        $objectManager->get('Magento\CatalogSearch\Model\ResourceModel\Advanced\Collection');
		$model = $objectManager->create('Trenza\Message\Model\Message');
		$collection = $model->getCollection();
        $collection = $model->getCollection()->addFieldToFilter('receiver_id', $buyer_id);
        $collection = $model->getCollection()->addFieldToFilter('receiver_delete_flg', 0);
        $collection->setOrder('id', 'DESC');
        return $collection;
	}
    
	public function save_message_data($pid,$seller_id,$buyer_id,$parent_id,$message,$seller_read_flg,$buyer_read_flg,$seller_delete_flg,$buyer_delete_flg,$sender_id,$reciver_id,$created_at,$updated_at){
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance(); $objectManager->get('Magento\CatalogSearch\Model\ResourceModel\Advanced\Collection');
		$model = $objectManager->create('Trenza\Message\Model\Message');
		$model->setProductId($pid);
		$model->setSellerId(0);
		$model->setBuyerId(0);
		$model->setParentId($parent_id);
		$model->setMessage($message);
		$model->setSellerReadFlg($seller_read_flg);
		$model->setBuyerReadFlg($buyer_read_flg);
		$model->setSellerDeleteFlg($seller_delete_flg);
		$model->setBuyerDeleteFlg($buyer_delete_flg);
		$model->setSenderId($sender_id);
		$model->setReciverId($reciver_id);
		$model->setCreatedAt($created_at);
		$model->setUpdatedAt($updated_at);
		$model->save();
		echo 'done';
	}
    public function delete_message_data($id){
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance(); $objectManager->get('Magento\CatalogSearch\Model\ResourceModel\Advanced\Collection');
		// $id = $this->getRequest()->getParam('id');
		$model = $objectManager->create('Trenza\Message\Model\Message');
		try {
		        $model->setId($id)->delete();
		        //echo "Data deleted successfully.";
		    } catch (Exception $e){
		       //echo $e->getMessage(); 
			}
	}
    
    
    public function printMessage(){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); $objectManager->get('Magento\CatalogSearch\Model\ResourceModel\Advanced\Collection');
		$model = $objectManager->create('Trenza\Message\Model\Message');
        $collection = $model->getCollection();
        foreach($collection as $val){
            //$result[]['Id'] = array('id' => $val->getId());
            $result[] = array('Id'=>$val->getId(),'Reciever_Id'=>$val->getReciverId(),'Sender_Id'=>$val->getSenderId(),
            'Sender_Delete_Flg'=>$val->getSellerDeleteFlg(),'Buyer_Delete_Flg'=>$val->getBuyerDeleteFlg(),'Sender_Read_Flg'=>$val->getSellerReadFlg(),
            'Reciever_Read_Flg'=>$val->getBuyerReadFlg(),'Sender_Id'=>$val->getSenderId());

        }
        
        echo '<pre>';
        echo print_r($result);
        echo '</pre>';
    }

	public function view_follow_data(){
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance(); $objectManager->get('Magento\CatalogSearch\Model\ResourceModel\Advanced\Collection');
		$model = $objectManager->create('Trenza\Message\Model\Follow');
		$collection = $model->getCollection();
	}

    public function is_customer_seller($customerId){
        $objectGroupManager = \Magento\Framework\App\ObjectManager::getInstance ();
        $customerGroupSession = $objectGroupManager->get ( 'Magento\Customer\Model\Group' );
        $customerGroupSession = $objectGroupManager->get ( 'Apptha\Marketplace\Model\Seller' );
        $status = $customerGroupSession->load ( $customerId, 'customer_id' )->getStatus (); 
         if ($status == 0) {
            return 'customer';
         } else if ($status == 1) {
            return 'seller';
         }
    }
    
    public function follow_or_not($customer_id,$seller_id){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); $objectManager->get('Magento\CatalogSearch\Model\ResourceModel\Advanced\Collection');
		$model = $objectManager->create('Trenza\Message\Model\Follow');
		$collection = $model->getCollection()->addFieldToFilter('follow_id', $seller_id);
		$collection = $model->getCollection()->addFieldToFilter('follower_id', $customer_id);
        foreach($collection as $item){
            if($item->getId()){
                return $item->getId();
            }else{
                return 0;
            }
		}
    }
    
    public function get_customer_data_by_id($customerId){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerObj = $objectManager->create('Magento\Customer\Model\Customer')
        ->load($customerID); 
        return $customerObj;
    }
    
    public function count_followers($id){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); $objectManager->get('Magento\CatalogSearch\Model\ResourceModel\Advanced\Collection');
		$model = $objectManager->create('Trenza\Message\Model\Follow');
		$collection = $model->getCollection()->addFieldToFilter('follow_id', $id);
        return count($collection);
    }
    
    
     public function all_follower_id($id){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); $objectManager->get('Magento\CatalogSearch\Model\ResourceModel\Advanced\Collection');
		$model = $objectManager->create('Trenza\Message\Model\Follow');
		$collection = $model->getCollection()->addFieldToFilter('follow_id', $id);
        foreach($collection as $item){
			$result[] = $item->getId();
		}
        return $result;
    }
    
    public function is_customer_login(){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->get('Magento\Customer\Model\Session');
        $customerDatas = $customerSession->getCustomer ();
        if ($customerSession->isLoggedIn ()) {
             $customerId = $customerSession->getId ();
             return $customerId;
        }else{
            return 0;
        } 
    }
    
    public function message_unread_count($reciver_id){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $model = $objectManager->create('Trenza\Message\Model\Message');
        $collection = count($model->getCollection()->addFieldToFilter('receiver_read_flg',0)->addFieldToFilter('receiver_id',$reciver_id));
        return $collection;
    }
    
    
    
}