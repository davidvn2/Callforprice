<?php
/**
 * Copyright © 2019 V2Agency . All rights reserved.
 * 
 */
namespace V2Agency\Callforprice\Controller\Adminhtml\Request;
class Index extends \V2Agency\Callforprice\Controller\Adminhtml\Request
{
    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        return $resultPage;
    }
}