<?php
 
namespace Magehit\Callforprice\Controller\Adminhtml;

abstract class Request extends \Magehit\Callforprice\Controller\Adminhtml\AbstractAction
{
    const PARAM_CRUD_ID = 'id';

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magehit_Callforprice::request');
    }
}