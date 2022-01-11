<?php
namespace Magehit\Callforprice\Controller\Adminhtml\Request;
use Magento\Backend\App\Action;
class Edit extends \Magento\Backend\App\Action
{
	protected $_coreRegistry = null;
	protected $resultPageFactory;

    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }
	
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magehit_Callforprice::save');
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
		// load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Magehit_Callforprice::request')
            ->addBreadcrumb(__('Request'), __('Request'))
            ->addBreadcrumb(__('Manage Request'), __('Manage Request'));
        return $resultPage;
    }

    /**
     * Edit Request
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->_objectManager->create('Magehit\Callforprice\Model\Request');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This request no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        $this->_coreRegistry->register('magehit_callforprice_request', $model);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Request') : __('New Request'),
            $id ? __('Edit Request') : __('New Request')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Request'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('New Request'));

        return $resultPage;
    }
}
