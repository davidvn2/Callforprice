<?php
/**
 * Copyright © 2019 V2Agency . All rights reserved.
 * 
 */
namespace V2Agency\Callforprice\Model\Source;
class Status implements \Magento\Framework\Data\OptionSourceInterface
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
        $options[] = ['label' => '', 'value' => ''];
        $availableOptions = $this->request->getAvailableStatuses();
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}