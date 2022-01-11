<?php
/**
 * Copyright © 2019 V2Agency . All rights reserved.
 * 
 */
namespace V2Agency\Callforprice\Controller;
abstract class Request extends \Magento\Backend\App\Action
{
    /**
     * Post Factory
     * 
     * @var \V2Agency\Callforprice\Model\RequestFactory
     */
    protected $_requestFactory;
    /**
     * Core registry
     * 
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * constructor
     * 
     * @param \V2Agency\Callforprice\Model\RequestFactory $requestFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\Model\View\Result\RedirectFactory $resultRedirectFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \V2Agency\Callforprice\Model\RequestFactory $requestFactory,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->_requestFactory        = $requestFactory;
        $this->_coreRegistry          = $coreRegistry;
        parent::__construct($context);
    }
    /**
     * Init Request
     *
     * @return \V2Agency\Callforprice\Model\Request
     */
    protected function _initRequest()
    {
        $requestId  = (int) $this->getRequest()->getParam('id');
        /** @var \V2Agency\Callforprice\Model\Request $request */
        $request    = $this->_requestFactory->create();
        if ($requestId) {
            $request->load($requestId);
        }
        $this->_coreRegistry->register('v2agency_callforprice_request', $request);
        return $request;
    }
}