<?php
namespace Magehit\Callforprice\Controller\Index;
class Load extends \Magento\Framework\App\Action\Action
{
    protected $_resultPageFactory;
    protected $_scopeConfig;
    protected $_helper;
    protected $_json;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
		\Magehit\Callforprice\Helper\Data $helper,
		\Magento\Framework\Controller\Result\JsonFactory $json
    )
    {
        $this->_scopeConfig 		  = $scopeConfig;
        $this->_resultPageFactory 	  = $resultPageFactory;
		$this->_helper 				  = $helper;
        $this->_json 	 			  = $json;
        parent::__construct($context);
    }
	
	public function execute()
    {
        $success = true;
		$productId = $this->getRequest()->getPost('proId');
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$product = $objectManager->get('Magento\Catalog\Model\Product')->load($productId);
		$resultPage = $this->_resultPageFactory->create();
		$form = $resultPage->getLayout()->createBlock('Magento\Framework\View\Element\Template')->assign('product',$product)->setTemplate('Magehit_Callforprice::callforprice_form.phtml')->toHtml();
		$resultJson = $this->_json->create();
		return $resultJson->setData($form);
    }

}
