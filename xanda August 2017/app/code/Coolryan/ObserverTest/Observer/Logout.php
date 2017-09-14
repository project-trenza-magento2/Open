<?php 
namespace Coolryan\ObserverTest\Observer;


class Logout implements \Magento\Framework\Event\ObserverInterface 
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        echo 'done';
        
        setcookie("phpbb3_9mm8b_sid", '', time() - 1, "/",'.xanda.sg');
        setcookie("phpbb3_9mm8b_u", '', time() - 1, "/",'.xanda.sg');
        setcookie("phpbb3_9mm8b_ki", '', time() - 1, "/",'.xanda.sg');
    }
}