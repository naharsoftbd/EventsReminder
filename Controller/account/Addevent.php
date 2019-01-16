<?php
namespace Magento\EventsReminder\Controller\Account;
use Magento\Framework\Controller\ResultFactory;
class Addevent extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;
	protected $_postFactory;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		\Magento\EventsReminder\Model\PostFactory $postFactory,
		\Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Framework\App\Response\Http $response,
        \Magento\Framework\UrlFactory $urlFactory,
        \Magento\Framework\App\ActionFlag $actionFlag)
	{
		$this->_pageFactory = $pageFactory;
		$this->_postFactory = $postFactory;
		$this->_response = $response;
        $this->_urlFactory = $urlFactory;
        $this->_actionFlag = $actionFlag;
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
		
		if (!empty($post)) {
            // Retrieve your form data
            $eventname   = $post['eventname'];
			$dob = $post['dob'];
			//$dob = date("Y-d-m",strtotime($post['dob']));
			//$notificationdate = date("Y-d-m",strtotime($post['notificationdate']));
			$notificationdate = $post['notificationdate'];
			$eventmessage   = $post['eventmessage'];
			$friendemail   = $post['friendemail'];
            // Doing-something with...
			$model = $this->_postFactory->create();
			$model->setName($eventname);
			$model->setCustomerId($customeremail);
			$model->setEventsDate($dob);
			$model->setEventsReminderDate($notificationdate);
			$model->setFriendEmail($friendemail);
			$model->setEventMessage($eventmessage);
            // Display the succes form validation message
			if($model->save()){
				$this->messageManager->addSuccessMessage('My '. $eventname . $dob . ' Event Created Successfully !');
			}

            // Redirect to your form page (or anywhere you want...)
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->getBaseUrl('/customer/account/events/');

            return $resultRedirect;
        }
		//$resultPage = $this->_pageFactory->create();
		
		 $this->_view->loadLayout();
         $this->_view->renderLayout();
		}else{
			$this->_response->setRedirect($this->_urlFactory->create()->getUrl('customer/account/login'));
		}
	}
}