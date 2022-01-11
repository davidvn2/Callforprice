<?php
/**
 * Copyright © 2019 V2Agency . All rights reserved.
 * 
 */
namespace V2Agency\Callforprice\Model;
class Request extends \Magento\Framework\Model\AbstractModel
{
	const STATUS_NEW = 1;
    const STATUS_REPLIED = 2;
    protected $_requestCollectionFactory;
    protected $_storeViewId = null;
    protected $_requestFactory;
    protected $_formFieldHtmlIdPrefix = 'page_';
    protected $_storeManager;
    protected $_monolog;
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \V2Agency\Callforprice\Model\ResourceModel\Request $resource,
        \V2Agency\Callforprice\Model\ResourceModel\Request\Collection $resourceCollection,
        \V2Agency\Callforprice\Model\RequestFactory $requestFactory,
        \V2Agency\Callforprice\Model\ResourceModel\Request\CollectionFactory $requestCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Logger\Monolog $monolog
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection
        );
        $this->_requestFactory = $requestFactory;
        $this->_storeManager = $storeManager;
        $this->_requestCollectionFactory = $requestCollectionFactory;
        $this->_monolog = $monolog;
        if ($storeViewId = $this->_storeManager->getStore()->getId()) {
            $this->_storeViewId = $storeViewId;
        }
    }
	public function getAvailableStatuses()
    {
        return [self::STATUS_NEW => __('New'), self::STATUS_REPLIED => __('Replied')];
    }
}
