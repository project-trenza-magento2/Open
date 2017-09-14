<?php
namespace Trenza\Message\Model\ResourceModel;

class Follow extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
public function _construct()
{
    $this->_init('trenza_follow', 'id');
}
}