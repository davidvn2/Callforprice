<?php
/**
 * Copyright © 2019 V2Agency . All rights reserved.
 * 
 */
namespace V2Agency\Callforprice\Model\Source;
class Customergroup implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var \V2Agency\Callforprice\Model\Request
     */
    protected $request;
    /**
     * Constructor
     *
     * @param \V2Agency\Callforprice\Model\Request $request
     */
    public function __construct(\V2Agency\Callforprice\Model\Request $request)
    {
        $this->request = $request;
    }
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$customerGroups = $objectManager->get('\Magento\Customer\Model\ResourceModel\Group\Collection')->toOptionArray();
		return $customerGroups;
    }
}