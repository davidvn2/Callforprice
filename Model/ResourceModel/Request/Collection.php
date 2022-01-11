<?php
namespace Magehit\Callforprice\Model\ResourceModel\Request;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('Magehit\Callforprice\Model\Request', 'Magehit\Callforprice\Model\ResourceModel\Request');
    }
}
