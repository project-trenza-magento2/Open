<?php
namespace Bold\OrderComment\Observer;

use Bold\OrderComment\Model\Data\OrderComment;
use Magento\Catalog\Api\ProductRepositoryInterface;

class AddOrderCommentToOrder implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * transfer the order comment from the quote object to the order object during the
     * sales_model_service_quote_submit_before event
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    private $productFactory; 
    public function __construct(\Magento\Catalog\Model\ProductFactory $productFactory)
    {
        $this->productFactory = $productFactory;
    }    
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /* @var $order \Magento\Sales\Model\Order */
        $order = $observer->getEvent()->getOrder();
        
        /** @var $quote \Magento\Quote\Model\Quote $quote */
        $quote = $observer->getEvent()->getQuote();

        $initial_deposite_flg = 0;
        
        $items = $quote->getAllItems();
        foreach($items as $item):            
            //$product = $productRepository->getById($item->getId());
            
            $product = $this->productFactory->create();
            $product->load($product->getIdBySku($item->getSku()));
            
            
            #mail('faroque.golam@gmail.com' , 'sku' , $product->getSku());
            #mail('faroque.golam@gmail.com' , 'getInitialdeposit' , $product->getInitialdeposit());
            
            if($product->getInitialdeposit() == 1):
                $initial_deposite_flg = 1;
                break;
            endif;
        endforeach; 
        
        if($initial_deposite_flg == 1):
            $comment = 'Payment Notice: You will be charged the remaining amount at the time of delivery.';
            $order->setData(OrderComment::COMMENT_FIELD_NAME, $comment);
        endif;
        
    }
}
