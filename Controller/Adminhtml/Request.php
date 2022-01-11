<?php
/**
 * Copyright © 2019 V2Agency . All rights reserved.
 * 
 */
 
namespace V2Agency\Callforprice\Controller\Adminhtml;
abstract class Request extends \V2Agency\Callforprice\Controller\Adminhtml\AbstractAction
{
    const PARAM_CRUD_ID = 'id';
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('V2Agency_Callforprice::request');
    }
}