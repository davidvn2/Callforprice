<?php
/**
 * Copyright © 2019 V2Agency . All rights reserved.
 * 
 */
namespace V2Agency\Callforprice\Controller\Adminhtml\Request;
use Magento\Backend\App\Action;
class Save extends \Magento\Backend\App\Action
{
    /**
     * @param Action\Context $context
     */
    public function __construct(Action\Context $context)
    {
        parent::__construct($context);
    }
    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('V2Agency_Callforprice::save');
    }
    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getParam('request');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            /** @var \V2Agency\Callforprice\Model\Request $model */
            $model = $this->_objectManager->create('V2Agency\Callforprice\Model\Request');
            $id = $data['id'];
            if ($id) {
                $model->load($id);
            }
            $data['status'] = 2;
            $model->setData($data);
            $this->_eventManager->dispatch(
                'callforprice_request_prepare_save',
                ['requestModel' => $model, 'request' => $this->getRequest()]
            );
            try {
                $model->save();
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                /* call send mail method from helper or where you define it*/
                $receiverInfo = $model->getCustomerEmail();
                $senderInfo = $this->_objectManager->get('V2Agency\Callforprice\Helper\Data')->getConfigValue('callforprice_settings/callforprice/email_from');
                $replyEmailTemplateId = $this->_objectManager->get('V2Agency\Callforprice\Helper\Data')->getConfigValue('callforprice_settings/callforprice/email_reply');
                $data = array();
                $data['name'] = $model->getCustomerName();
                $data['email'] = $receiverInfo;
                $data['telephone'] = $model->getCustomerTelephone();
                $data['details'] = $model->getProductName();
                $data['detailsreplied'] = $model->getReplyDetail();
                $this->_objectManager->get('V2Agency\Callforprice\Helper\Email')->sendMail($replyEmailTemplateId, $data, $senderInfo, $receiverInfo);
                $this->messageManager->addSuccess(__('You saved this request and send reply email'));
                return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the request.'));
            }
            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}