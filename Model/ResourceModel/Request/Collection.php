<?php
/**
 * Copyright © 2019 V2Agency . All rights reserved.
 * 
 */
namespace V2Agency\Callforprice\Model\ResourceModel\Request;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init('V2Agency\Callforprice\Model\Request', 'V2Agency\Callforprice\Model\ResourceModel\Request');
    }
}