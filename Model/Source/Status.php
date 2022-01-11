<?php
namespace Magehit\Callforprice\Model\Source;

class Status implements \Magento\Framework\Data\OptionSourceInterface
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
