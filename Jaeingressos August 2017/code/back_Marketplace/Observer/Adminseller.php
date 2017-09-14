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
class Adminseller implements ObserverInterface {
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

       $customer = $observer->getRequest ()->getPost ( 'customer' );
       $groupId = $customer['group_id'];
       $customerEmail = $customer['email'];
         /**
         * Checking for is seller group or not
         */
        if ($groupId == 4) {

                    $objectManager = \Magento\Framework\App\ObjectManager::getInstance ();
                    $registeredCustomers = $objectManager->create('Magento\Customer\Model\Customer')->getCollection();
                    foreach($registeredCustomers as $customers){
                        if($customers->getEmail() == $customerEmail){
                            $customerId = $customers->getId();
                      }
                    }
                    /**
                     * Load seller object
                     */
                    $sellerModel = $objectManager->get ( 'Apptha\Marketplace\Model\Seller' );
                    /**
                     * To set seller data
                     */
                    $sellerModel->setEmail ( $customerEmail )->setStatus ( 1 )->setCustomerId ( $customerId )->save ();
        }
    }
}
