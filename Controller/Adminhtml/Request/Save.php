<?php
namespace Magehit\Callforprice\Controller\Adminhtml\Request;

use Magento\Backend\App\Action;
use Magento\TestFramework\ErrorLog\Logger;

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
        return $this->_authorization->isAllowed('Magehit_Callforprice::save');
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data =  $this->getRequest()->getParam('request');
		$reply = @$data['reply'];
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            /** @var \Magehit\Callforprice\Model\Request $model */
            $model = $this->_objectManager->create('Magehit\Callforprice\Model\Request');
			$id = $data['id'];
            if ($id) {
                $model->load($id);
            }
			$data['status'] = $reply ? 2 : $data['status'];
            $model->setData($data);

            $this->_eventManager->dispatch(
                'callforprice_request_prepare_save',
                ['requestModel' => $model, 'request' => $this->getRequest()]
            );

            try {
				$model->save();	
				$this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
				if($reply){
					/* call send mail method from helper or where you define it*/ 
					$receiverInfo  = $model->getCustomerEmail();
					$senderInfo = $this->_objectManager->get('Magehit\Callforprice\Helper\Data')->getConfigValue('callforprice_settings/callforprice/email_from');
					$replyEmailTemplateId = $this->_objectManager->get('Magehit\Callforprice\Helper\Data')->getConfigValue('callforprice_settings/callforprice/email_reply');
					
					$data = array();
					$data['name'] = $model->getCustomerName();
					$data['email'] = $receiverInfo;
					$data['telephone'] = $model->getCustomerTelephone();
					$data['details'] = $model->getProductName();
					$data['detailsreplied'] = $model->getReplyDetail();
					$this->_objectManager->get('Magehit\Callforprice\Helper\Email')->sendMail($replyEmailTemplateId,$data,$senderInfo,$receiverInfo);
					
					
					$this->messageManager->addSuccess(__('You saved this request and send reply email'));
					return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
				}else{
					
					$this->messageManager->addSuccess(__('You saved this Request.'));
					if ($this->getRequest()->getParam('back')) {
						return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
					}
					return $resultRedirect->setPath('*/*/');
				}
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
