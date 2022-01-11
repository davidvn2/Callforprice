<?php
namespace Magehit\Callforprice\Controller\Adminhtml\Request;
class Index extends \Magehit\Callforprice\Controller\Adminhtml\Request
{
    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        return $resultPage;
    }
}
