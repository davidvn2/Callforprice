<?php
namespace Magehit\Callforprice\Controller;

abstract class Request extends \Magento\Backend\App\Action
{
    /**
     * Post Factory
     * 
     * @var \Magehit\Callforprice\Model\RequestFactory
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
     * @param \Magehit\Callforprice\Model\RequestFactory $requestFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\Model\View\Result\RedirectFactory $resultRedirectFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magehit\Callforprice\Model\RequestFactory $requestFactory,
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
     * @return \Magehit\Callforprice\Model\Request
     */
    protected function _initRequest()
    {
        $requestId  = (int) $this->getRequest()->getParam('id');
        /** @var \Magehit\Callforprice\Model\Request $request */
        $request    = $this->_requestFactory->create();
        if ($requestId) {
            $request->load($requestId);
        }
        $this->_coreRegistry->register('magehit_callforprice_request', $request);
        return $request;
    }

}
