<?php

namespace Magehit\Callforprice\Controller\Adminhtml\Request;

class InlineEdit extends \Magento\Backend\App\Action
{
    /**
     * JSON Factory
     * 
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $_jsonFactory;

    /**
     * Post Factory
     * 
     * @var \Magehit\Callforprice\Model\RequestFactory
     */
    protected $_requestFactory;

    /**
     * constructor
     * 
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     * @param \Magehit\Callforprice\Model\RequestFactory $requestFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Magehit\Callforprice\Model\RequestFactory $requestFactory,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->_jsonFactory = $jsonFactory;
        $this->_requestFactory = $requestFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->_jsonFactory->create();
        $error = false;
        $messages = [];
        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }
        foreach (array_keys($postItems) as $requestId) {
            /** @var \\Magehit\Callforprice\\Model\Request $request */
            $request = $this->_requestFactory->create()->load($requestId);
            try {
                $requestData = $postItems[$requestId];//todo: handle dates
                $request->addData($requestData);
                $request->save();
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithRequestId($request, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithRequestId($request, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithRequestId(
                    $request,
                    __('Something went wrong while saving the Request.')
                );
                $error = true;
            }
        }
        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Add Request id to error message
     *
     * @param \Magehit\Callforprice\Model\Request $request
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithRequestId(\Magehit\Callforprice\Model\Request $request, $errorText)
    {
        return '[Request ID: ' . $request->getId() . '] ' . $errorText;
    }
}
