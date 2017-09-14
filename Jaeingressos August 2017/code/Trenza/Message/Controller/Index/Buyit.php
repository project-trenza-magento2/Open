<?php
namespace Trenza\Message\Controller\Index;
 
use Magento\Framework\App\Action\Context;

class Buyit extends \Magento\Framework\App\Action\Action {

         /**
          * @var \Magento\Checkout\Model\Cart
          */
         protected $cart;
         /**
          * @var \Magento\Catalog\Model\Product
          */
         protected $product;

         public function __construct(
             \Magento\Framework\App\Action\Context $context,
             \Magento\Framework\View\Result\PageFactory $resultPageFactory,
             \Magento\Catalog\Model\Product $product,
             \Magento\Checkout\Model\Cart $cart
         ) {
            
             $this->resultPageFactory = $resultPageFactory;
             $this->cart = $cart;
             $this->product = $product;
             parent::__construct($context);
         }
         public function execute()
         {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $customerSession = $objectManager->create('Magento\Customer\Model\Session');

    
            $product_id = $this->getRequest()->getParam('id'); 
            $qty = $this->getRequest()->getParam('qty'); 
            if($qty == 0 || $qty <0){
                $qty = 1;
            }

             try {
                 $params = array();
                 $params['qty'] = $qty;//product quantity
                 $_product = $this->product->load($product_id);
                 if ($_product) {
                     $this->cart->addProduct($_product, $params);
                     $this->cart->save();
                 }

                 $this->messageManager->addSuccess(__('Add to cart successfully..'));
             } catch (\Magento\Framework\Exception\LocalizedException $e) {
                 $this->messageManager->addException(
                     $e,
                     __('%1', $e->getMessage())
                 );
             } catch (\Exception $e) {
                 $this->messageManager->addException($e, __('error.'));
             }
             /*cart page*/
             $this->getResponse()->setRedirect('/checkout/');


         }
    }