<?php
namespace Magento\EventsReminder\Controller\Account;
use Magento\Framework\Controller\ResultFactory;
class Editevent extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;
	protected $_postFactory;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		\Magento\EventsReminder\Model\PostFactory $postFactory)
	{
		$this->_pageFactory = $pageFactory;
		$this->_postFactory = $postFactory;
		return parent::__construct($context);
	}

	public function execute()
	{
		$post = (array) $this->getRequest()->getPost();
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$customerSession = $objectManager->create("Magento\Customer\Model\Session");
	
		if($customerSession->isLoggedIn()){
		  $customer_id = $customerSession->getCustomerId();
		  $customeremail = $customerSession->getCustomer()->getEmail(); 
		}
		
		if (!empty($post)) {
            // Retrieve your form data
            $eventname   = $post['eventname'];
			$dob = $post['dob'];
			$id = $post['eventid'];
			$notificationdate = $post['notificationdate'];
			$eventmessage   = $post['eventmessage'];
			$friendemail   = $post['friendemail'];
            // Doing-something with...
			$model = $this->_postFactory->create();
			$postUpdate = $model->load($id);
			
			$postUpdate->addData([
			"name" => $eventname,
			"customer_id" =>$customeremail,
			"events_date" => $dob,
			"event_message" => $eventmessage,
			"friend_email" => $friendemail,
			"events_reminder_date" => $notificationdate,
				]);
			if($postUpdate->setId(intval($id))->save()){
				$this->messageManager->addSuccessMessage('My '.$eventname . ' Event Updated Successfully !');
			}

            // Redirect to your form page (or anywhere you want...)
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->getBaseUrl('/customer/account/events/');

            return $resultRedirect;
        }
		//$resultPage = $this->_pageFactory->create();
		
		 $this->_view->loadLayout();
         $this->_view->renderLayout();
	}
}