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
namespace Apptha\Marketplace\Controller\Adminhtml\Payments;

use Apptha\Marketplace\Controller\Adminhtml\Payments;

/**
 * This class contains the seller payments grid action
 */
class Grid extends Payments {
    /**
     * Prepare seller payments collection
     */
    protected function _prepareCollection() {
        /**
         * Getting factory collection for grid
         */
        $sellerPayments = $this->_gridFactory->create ()->getCollection ();
        $this->setCollection ( $sellerPayments );
        /**
         * Call parent collection
         */
        parent::_prepareCollection ();
        /**
         * Return current scope
         */
        return $this;
    }
    /**
     * Execute result page factory
     *
     * @return object
     */
    public function execute() {
        /**
         * Create result page factory
         */
        return $this->_resultPageFactory->create ();
    }
}
