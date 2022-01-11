<?php
namespace Magehit\Callforprice\Model\ResourceModel;

class Request extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * construct
     * @return void
     */
    protected function _construct()
    {
        $this->_init('magehit_callforprice_request', 'id');
    }
}
