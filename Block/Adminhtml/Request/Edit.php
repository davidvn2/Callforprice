<?php

namespace Magehit\Callforprice\Block\Adminhtml\Request;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * Core registry
     * 
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * constructor
     * 
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\Block\Widget\Context $context,
        array $data = []
    )
    {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context, $data);
    }

    /**
     * Initialize Request edit block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'Magehit_Callforprice';
        $this->_controller = 'adminhtml_request';
        parent::_construct();
		$this->buttonList->add('reply',[
            'label' 	=> __('Reply'),
			'class'     => 'save',
			'onclick'   => 'replyAndContinueEdit()',
			 -110
        ]);
        $this->buttonList->update('save', 'label', __('Save Request'));
        $this->buttonList->add(
            'save-and-continue',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => [
                            'event' => 'saveAndContinueEdit',
                            'target' => '#edit_form'
                        ]
                    ]
                ]
            ],
            -100
        );
        $this->buttonList->update('delete', 'label', __('Delete Request'));
		$this->_formScripts[] = " function replyAndContinueEdit(){
			var hidden = document.createElement('input');
			hidden.type = 'hidden';
			hidden.name = 'request[reply]';
			hidden.value = '1';
			var f = document.getElementById('edit_form');
			f.appendChild(hidden);
			f.submit();
        }
		";
    }
    /**
     * Retrieve text for header element depending on loaded Request
     *
     * @return string
     */
    public function getHeaderText()
    {
        /** @var \Magehit\Callforprice\Model\Request $request */
        $request = $this->_coreRegistry->registry('magehit_callforprice_request');
        if ($request->getId()) {
            return __("Edit Request '%1'", $this->escapeHtml($request->getName()));
        }
        return __('New Request');
    }
}
