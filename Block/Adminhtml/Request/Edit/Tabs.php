<?php
namespace Magehit\Callforprice\Block\Adminhtml\Request\Edit;

/**
 * @method Tabs setTitle(\string $title)
 */
class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('request_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Request Information'));
    }
}