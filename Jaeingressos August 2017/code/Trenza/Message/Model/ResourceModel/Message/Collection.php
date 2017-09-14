<?php
namespace Trenza\Message\Model\ResourceModel\Message;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
public function _construct()
{
$this->_init('Trenza\Message\Model\Message', 'Trenza\Message\Model\ResourceModel\Message');
}
}