<?php
namespace Trenza\Message\Block;
 
class Message extends \Magento\Framework\View\Element\Template
{

	public function custom_connection(){
		$this->_resources = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Framework\App\ResourceConnection');
		$connection= $this->_resources->getConnection();
		return $connection;
	}
    
	public function view_message_data()
    {
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $msg_model = $objectManager->create('\Trenza\Message\Model\Message');
        $message_id = $this->getRequest()->getParam('id');
        
        $message_details = $msg_model->load($message_id);
        
        return $message_details;
	}
    
    public function read_message(){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $msg_model = $objectManager->create('\Trenza\Message\Model\Message');
        $message_id = $this->getRequest()->getParam('id');
        
        $message_details = $msg_model->load($message_id);
        $receiver_id = $message_details->getReceiverId();
        $sender_id = $message_details->getSenderId();
        
        
        $read_message_collection = $msg_model->getCollection();
        $read_message_collection = $read_message_collection->addFieldToFilter('sender_id', $sender_id)->addFieldToFilter('receiver_id', $receiver_id)->addFieldToFilter('receiver_read_flg', 0);
        
        foreach($read_message_collection as $v){
            $id = $v->getId();
            $message_read = $msg_model->load($id)->setReceiverReadFlg(1);
            $message_read->save();
            
        }
        //$msg_model->setReceiverReadFlg(1);
        //$msg_model->save();

    }
    
    public function message_allready_read($id){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $msg_model = $objectManager->create('\Trenza\Message\Model\Message');
        
        $message_details = $msg_model->load($id);
        $receiver_id = $message_details->getReceiverId();
        $sender_id = $message_details->getSenderId();
        
        $read_message_collection = $msg_model->getCollection();
        $read_message_collection = $read_message_collection->addFieldToFilter('sender_id', $sender_id)->addFieldToFilter('receiver_id', $receiver_id)->addFieldToFilter('receiver_read_flg', 0);
        return count($read_message_collection);
        
    }
    
    
    public function view_sub_message_data($parent_id)
    {
		 
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $msg_model = $objectManager->create('\Trenza\Message\Model\Message');
        
        $collection = $msg_model->getCollection()->addFieldToFilter('parent_id' , $parent_id);
        $collection->getSelect()->order('id ASC');
        
        /*
        $recever_id = $this->getRequest()->getParam('rcv_');
        $sender_id = $this->getRequest()->getParam('snd_');


        
        $collection = $model->getCollection();
        $collection->addFieldToFilter(array('sender_id','receiver_id'),
               array(array('eq'=>$sender_id),array('eq'=>$recever_id)));
        $collection->addFieldToFilter(array('sender_id','receiver_id'),
               array(array('eq'=>$recever_id),array('eq'=>$sender_id)));
        $collection->addFieldToFilter('receiver_delete_flg', 0);
        */
        
        return $collection;
	}
 
    public function seller_inbox($seller_id)
    {
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance(); 
        $objectManager->get('Magento\CatalogSearch\Model\ResourceModel\Advanced\Collection');
		$model = $objectManager->create('Trenza\Message\Model\Message');
                
        $collection = $model->getCollection();
        $collection->addFieldToFilter('receiver_id', $seller_id)->addFieldToFilter('receiver_delete_flg', 0)->getSelect()->group('sender_id')->order('id DESC');
        
        return $collection;
	}

    public function buyer_inbox($buyer_id){
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance(); 
        $objectManager->get('Magento\CatalogSearch\Model\ResourceModel\Advanced\Collection');
		$model = $objectManager->create('Trenza\Message\Model\Message');

        $collection = $model->getCollection();
        $collection->addFieldToFilter('receiver_id', $seller_id);
        $collection->addFieldToFilter('receiver_delete_flg', 0);            
        $collection->getSelect()->group('sender_id')->order('id DESC');
        
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
		$model->setSenderReadFlg($seller_read_flg);
		$model->setReceiverReadFlg($buyer_read_flg);
		$model->setSenderDeleteFlg($seller_delete_flg);
		$model->setReceiverDeleteFlg($buyer_delete_flg);
		$model->setSenderId($sender_id);
		$model->setReceiverId($reciver_id);
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
            $result[] = array('Id'=>$val->getId(),'Parent_id'=>$val->getParentId(),'Reciever_Id'=>$val->getReceiverId(),'Sender_Id'=>$val->getSenderId(),
            'Sender_Delete_Flg'=>$val->getSenderDeleteFlg(),'Buyer_Delete_Flg'=>$val->getReceiverDeleteFlg(),'Sender_Read_Flg'=>$val->getSenderReadFlg(),
            'Reciever_Read_Flg'=>$val->getReceiverReadFlg(),'Sender_Id'=>$val->getSenderId());

        }
        
        /*echo '<pre>';
        echo print_r($result);
        echo '</pre>';*/
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
        $customer = $objectGroupManager->create('Magento\Customer\Model\Customer')->load($customerId);                
        $status = $customer->getGroupId();                      
         if ($status == 1) {
            return 'customer';
         } else if ($status == 4) {
            return 'seller';
         }
    }
    
    public function is_seller($customerId){        
        $objectGroupManager = \Magento\Framework\App\ObjectManager::getInstance ();
        $customerGroupSession = $objectGroupManager->get ( 'Magento\Customer\Model\Group' );
        $customerGroupSession = $objectGroupManager->get ( 'Apptha\Marketplace\Model\Seller' );
        $status = $customerGroupSession->load ( $customerId, 'customer_id' )->getStatus ();                      
         if ($status == 1) {
            return 'seller';
         } else if ($status == 0) {
            return 'customer';
         }
    }
    
    public function follow_or_not($customer_id,$seller_id){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); $objectManager->get('Magento\CatalogSearch\Model\ResourceModel\Advanced\Collection');
		$model = $objectManager->create('Trenza\Message\Model\Follow');
		$collection = $model->getCollection()->addFieldToFilter('follow_id', $seller_id);
		$collection = $collection->addFieldToFilter('follower_id', $customer_id);
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
			$result[] = $item->getFollowerId();
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
        $collection = $model->getCollection()->addFieldToFilter('receiver_read_flg',0)->addFieldToFilter('receiver_id',$reciver_id);
        $i = 0;
        foreach($collection as $val){
            if($val->getSenderId() != $val->getReceiverId()){
                $i++;
                            
            }
        }        
        return $i;
    }
    
    
    public function getMessage()
    {
        echo 'Test Message';
    }
    
    public function getParentId($sender_id,$receiver_id){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $msg_model = $objectManager->create('\Trenza\Message\Model\Message');
        
        $send_receive = $msg_model->getCollection()->addFieldToFilter('sender_id', $sender_id)->addFieldToFilter('receiver_id', $receiver_id);
        $receive_send = $msg_model->getCollection()->addFieldToFilter('sender_id', $receiver_id)->addFieldToFilter('receiver_id', $sender_id);
        
        if(count($send_receive) == 0)
        {
            // autoincrement_id
            return 0;

        }
        elseif(count($send_receive) != 0)
        {
            foreach($send_receive as $data)
            {
                $id = $data->getId();
            }
            
        }
        elseif(count($receive_send) != 0)
        {
            foreach($receive_send as $data)
            {
                $id = $data->getId();
            }
            
        }
        
        
        return $id;
        
    }
    
    public function parentFirstMessage($sender_id,$receiver_id){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $msg_model = $objectManager->create('\Trenza\Message\Model\Message');
        
        $send_receive = $msg_model->getCollection()->addFieldToFilter('sender_id', $sender_id)->addFieldToFilter('receiver_id', $receiver_id);
        //$receive_send = $msg_model->getCollection()->addFieldToFilter('sender_id', $receiver_id)->addFieldToFilter('receiver_id', $receiver_id);
        
        if(count($send_receive) == 0)
        {
            // autoincrement_id
            return 0;

        }
        elseif(count($send_receive) != 0)
        {
            foreach($send_receive as $data)
            {
                $id = $data->getId();
            }
            
        }

        return $id;
    }
    
    
    public function Buyit(){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $cart = $objectManager->create('\Magento\Checkout\Model\Cart');
        $product = $objectManager->create('\Magento\Catalog\Model');
        $messageManager = $objectManager->get('Magento\Framework\Message\ManagerInterface');
        $messageManager->addError(__("Error"));
        
        try {
                 $params = array();
                 $params['qty'] = '1';//product quantity
                 /*get product id*/
                 $pId = '1';//productId
                 $_product = $product->load($pId);
                 if ($_product) {
                     $cart->addProduct($_product, $params);
                     $cart->save();
                 }

                 $messageManager->addSuccess(__('Add to cart successfully.'));
             } catch (\Magento\Framework\Exception\LocalizedException $e) {
                 $messageManager->addException(
                     $e,
                     __('%1', $e->getMessage())
                 );
             } catch (\Exception $e) {
                 $messageManager->addException($e, __('error.'));
             }
             /*cart page*/
             $this->getResponse()->setRedirect('/checkout/cart/index');
        
    }
    
    public function seller_information(){
        
    }
    
    public function random_name(){
        $names = array(
            'Christopher',
            'Ryan',
            'Ethan',
            'John',
            'Zoey',
            'Sarah',
            'Michelle',
            'Samantha',
        	'Walker',
            'Thompson',
            'Anderson',
            'Johnson',
            'Tremblay',
            'Peltier',
            'Cunningham',
            'Simpson',
            'Mercado',
            'Sellers'
        );
        
        $random_name = $names[mt_rand(0, sizeof($names) - 1)];
        return $random_name;
    }

    
    
}