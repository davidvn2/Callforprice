<?php
/**
 * Copyright © 2019 V2Agency . All rights reserved.
 * 
 */
namespace V2Agency\Callforprice\Helper;
use Magento\Framework\App\Helper\Context;
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
	protected $_objectManager;
	protected $_timezoneInterface;
	protected $_registry;
	protected $_resultPageFactory;
	protected $_request;
	protected $_transportBuilder;
    /**
     * Block constructor.
     *
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(Context $context,
		\Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\Registry $registry,
		\Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezoneInterface,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
		\Magento\Framework\App\Request\Http $request,
		\Magento\Framework\Mail\Template\TransportBuilder $transportBuilder
    ) {
		$this->_objectManager 		= $objectManager;
        $this->_registry 			= $registry;
		$this->_timezoneInterface 	= $timezoneInterface;
		$this->_resultPageFactory 	= $resultPageFactory;
		$this->_request 			= $request;
		$this->_transportBuilder 	= $transportBuilder;
        parent::__construct($context);
    }
    public function loadFormUrl()
    {
        return $this->_urlBuilder->getUrl('callforprice/index/load');
    }
    public function submitFormUrl()
    {
        return $this->_urlBuilder->getUrl('callforprice/index/submit');
    }
    public function getButtonTitle()
    {
		return $this->getConfigValue('callforprice_settings/callforprice/button_text');
    }
	public function enableModule(){
		return $this->getConfigValue('callforprice_settings/callforprice/enable');
	}
    public function allowedCustomerGroup()
    {
		return $this->getConfigValue('callforprice_settings/callforprice/customer_groups');
    }
    public function getClassSelector()
    {
		return $this->getConfigValue('callforprice_settings/callforprice/class_selector');
    }
    public function getSpecificDateRange()
    {
		return $this->getConfigValue('callforprice_settings/callforprice/date_range');
    }
    public function getFromDate()
    {
		return $this->getConfigValue('callforprice_settings/callforprice/date_from');
    }
    public function getToDate()
    {
		return $this->getConfigValue('callforprice_settings/callforprice/date_to');
    }
    public function getCapchaStatus()
    {
		return $this->getConfigValue('callforprice_settings/callforprice/capcha');
    }
    public function getCapchaSiteId()
    {
		return $this->getConfigValue('callforprice_settings/callforprice/capcha_appid');
    }
	public function getConfigValue($path)
    {
        return $this->scopeConfig->getValue($path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
	public function getActionHandle(){
		return $this->_request->getFullActionName();
	}
	public function isModuleEnabled($moduleName)
    {
        return $this->_moduleManager->isEnabled($moduleName);
    }
    public function getCurrentCustomerGroup()
    {
		$groupId = 0;
		$customerSession = $this->_objectManager->get('Magento\Customer\Model\Session');
		$login = $customerSession->isLoggedIn();
        if($login){
            $groupId = $customerSession->getCustomerGroupId(); //Get Customers Group ID
        }
		return $groupId;
    }
    public function getDateToShowButton()
    {
        if($this->getSpecificDateRange()==1)
        {
			$fromDate = $this->_timezoneInterface->date(new \DateTime($this->getFromDate()))->format('m/d/Y');
            $toDate = $this->_timezoneInterface->date(new \DateTime($this->getToDate()))->format('m/d/Y');
            $todayDate = $this->_timezoneInterface->date()->format('m/d/Y');
            if(strtotime($todayDate)>=strtotime($fromDate) && strtotime($todayDate)<=strtotime($toDate)){
                return 1;
            }
            else return 0;
        }
        return 1;        
    }
	public function getAllowCustomerGroup(){
		$allowed_customer_groups = array();
        $c_group = $this->getCurrentCustomerGroup(); // current customer group id
        $customer_groups = $this->allowedCustomerGroup();  // list customer group allow
        if($customer_groups != ""){
            $allowed_customer_groups = explode(',',$customer_groups);
        }
		if(count($allowed_customer_groups) > 0){
			if(in_array($c_group,$allowed_customer_groups) || in_array('32000',$allowed_customer_groups)){
				return 1;  
			}
		}else{
			return 0;
		}  
	}
    public function showCallForPriceButton($_product)
    {      
		$cats = array();
        $callpriceflag = 0;
        $callpriceflagparent = 0;
        $callforprice = 0;
        $showCallForPriceButton = 0;
		$checkRangeDate = $this->getDateToShowButton(); 
        $checkCustomerGroup = $this->getAllowCustomerGroup();
        $currentCategory = @$this->_registry->registry('current_category'); // check for current category
        if($currentCategory)
        {
            $cat = $this->_objectManager->get('Magento\Catalog\Model\Category')->load($currentCategory->getId());
            $callpriceflag = $cat->getCallForPriceActive();
            /* if($cat->getParentCategory()){
                $callpriceflagparent = $cat->getParentCategory()->getCallForPriceActive();
            } */
			/* $logger->info($_product->getId() . ' -- ' . $_cat->getId() . ' -- ' .$_cat->getCallForPriceActive()); */
			/* foreach($_cat->getParentIds() as $_parentCatId){
				$parentCat = $this->_objectManager->get('Magento\Catalog\Model\Category')->load($_parentCatId) ;
				if($parentCat->getId()){
					$callpriceflagparent = $parentCat->getCallForPriceActive()
				}
			} */
			
        }
        $cats = $_product->getCategoryIds();
        foreach ($_product->getCategoryIds() as $category_id) {
            $_cat = $this->_objectManager->get('Magento\Catalog\Model\Category')->load($category_id) ;
			
			if($_cat->getId() && $_cat->getCallForPriceActive()){
				$callpriceflagparent = 1;
			}
        } 
        $callforprice = $_product->getCallForPriceActive(); // Check for product 
        if($callforprice ==1 || $callpriceflagparent == 1||$callpriceflag == 1)
        {    
			// Finaly checking date range and allow customer group.
			if($checkRangeDate == 1 && $checkCustomerGroup == 1){
				$showCallForPriceButton = 1;
			}
        }
        return $showCallForPriceButton;
    }
	public function loadCatsByProductId($productId)
    {
		$_product 		= $this->_objectManager->get('Magento\Catalog\Model\Product')->load($productId);
		return $_product->getCategoryIds();
    }
    public function getButtonCallPriceTemplate($product){
		$resultPage = $this->_resultPageFactory->create();
        return $resultPage->getLayout()->createBlock('Magento\Framework\View\Element\Template')->assign('product',$product)->setTemplate('V2Agency_Callforprice::button.phtml')->toHtml();
    }
}