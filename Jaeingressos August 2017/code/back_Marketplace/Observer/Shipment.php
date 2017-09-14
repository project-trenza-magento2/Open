<?php
/**
 * Apptha
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.apptha.com/LICENSE.txt
 *
 * ==============================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * ==============================================================
 * This package designed for Magento COMMUNITY edition
 * Apptha does not guarantee correct work of this extension
 * on any other Magento edition except Magento COMMUNITY edition.
 * Apptha does not provide extension support in case of
 * incorrect edition usage.
 * ==============================================================
 *
 * @category    Apptha
 * @package     Apptha_Marketplace
 * @version     1.2
 * @author      Apptha Team <developers@contus.in>
 * @copyright   Copyright (c) 2017 Apptha. (http://www.apptha.com)
 * @license     http://www.apptha.com/LICENSE.txt
 *
 */
namespace Apptha\Marketplace\Observer;

use Magento\Framework\Event\ObserverInterface;
use Apptha\Marketplace\Helper\Data;

/**
 * This class contains seller approval/disapproval functions
 */
class Shipment implements ObserverInterface {
    /**
     *
     * @var $marketplaceData
     */
    protected $marketplaceData;
    
    /**
     * Constructor
     * 
     * @param Data $marketplaceData            
     */
    public function __construct(Data $marketplaceData) {
        $this->marketplaceData = $marketplaceData;
    }
    /**
     * Execute the result
     * 
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer) {
        $shipment = $observer->getEvent ()->getShipment ();
        $order = $shipment->getOrder ();
        $invoice = $order->canInvoice ();
        if ($invoice) {
            $orderStatus = 'processing';
        } else {
            $orderStatus = 'completed';
        }
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance ();
        $sellerOrderCollection = $objectManager->get ( 'Apptha\Marketplace\Model\Order' )->getCollection ()->addFieldToFilter ( 'order_id', $order->getId () );
        $sellerOrderCollectionDatas = $sellerOrderCollection->getData ();
        foreach ( $sellerOrderCollectionDatas as $sellerOrderCollectionData ) {
            $objectManager->get ( 'Apptha\Marketplace\Model\Order' )->load ( $sellerOrderCollectionData ['id'] )->setStatus($orderStatus)->save();
          }
    }
}