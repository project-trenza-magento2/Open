<?php

    namespace Trenza\Customprice\Observer;
 
    use Magento\Framework\Event\ObserverInterface;
    use Magento\Framework\App\RequestInterface;
 
    class CustomPrice implements ObserverInterface
    {
        public function execute(\Magento\Framework\Event\Observer $observer) {
            
            //echo 'test';exit;
            
            $item = $observer->getEvent()->getData('quote_item');         
            $item = ( $item->getParentItem() ? $item->getParentItem() : $item );
            
            
            $objectManager =  \Magento\Framework\App\ObjectManager::getInstance();
            $productRepository = $objectManager->get('\Magento\Catalog\Model\ProductRepository');
            $product = $productRepository->get($item->getSku());
            
            
            if($product->getInitialdeposit() == 1):
                $additionalOptions = array(array(
                     'code' => 'option_code',
                     'label' => 'Payment Notice',
                     'value' => 'You will be charged the remaining amount at the time of delivery.',
                ));
                $item->addOption(array(
                     'code' => 'additional_options',
                     'value' => serialize($additionalOptions),
                ));
                $price = 100; //set your price here
                $item->setCustomPrice($price);
                $item->setOriginalCustomPrice($price);
                $item->getProduct()->setIsSuperMode(true);
            endif;
            
                      
        }
 
    }