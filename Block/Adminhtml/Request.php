<?php 
/**
 * Copyright © 2019 V2Agency . All rights reserved.
 * 
 */
namespace V2Agency\Callforprice\Block\Adminhtml;
class Request extends \Magento\Backend\Block\Widget\Grid\Container
{
   /**
     * Constructor
     *
     * @return void
     */
   protected function _construct()
    {
        $this->_controller = 'adminhtml_request';
        $this->_blockGroup = 'V2Agency_Callforprice';
        $this->_headerText = __('Manage Request');
        $this->_addButtonLabel = __('Add Request');
        parent::_construct();
    }
}