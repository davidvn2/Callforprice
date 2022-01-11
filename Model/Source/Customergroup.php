<?php
namespace Magehit\Callforprice\Model\Source;

class Customergroup implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var \Magehit\Callforprice\Model\Request
     */
    protected $request;

    /**
     * Constructor
     *
     * @param \Magehit\Callforprice\Model\Request $request
     */
    public function __construct(\Magehit\Callforprice\Model\Request $request)
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
