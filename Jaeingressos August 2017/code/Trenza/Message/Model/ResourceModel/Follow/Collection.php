<?php
namespace Trenza\Message\Model\ResourceModel\Follow;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
public function _construct()
{
$this->_init('Trenza\Message\Model\Follow', 'Trenza\Message\Model\ResourceModel\Follow');
}
}