<?php
namespace Coolryan\ObserverTest\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;


class CustomerLogin implements ObserverInterface {

	/** @var \Magento\Framework\Logger\Monolog */
	protected $logger;
	
	public function __construct(
		\Psr\Log\LoggerInterface $loggerInterface
	) {
		$this->logger = $loggerInterface;
	}

	/**
	 * This is the method that fires when the event runs. 
	 * 
	 * @param Observer $observer
	 */
	public function execute( Observer $observer ) {
		//$customer = $observer->getCustomer();
		//$this->logger->debug($customer->getName());
        
        //echo "Customer LoggedIn";
        /*
        $customer = $observer->getEvent()->getCustomer();
        echo $customer->getName(); //Get customer name
        $data = $observer->getRequest()->getPost(); //Get customer name
        $data = $data['login'];
        print_r($data);
        exit;
        */

        
	}
}