<?php
namespace Magento\EventsReminder\Controller\Account;

class Events extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;
	protected $helperData;
	
	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\EventsReminder\Helper\Data $helperData,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		\Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Framework\App\Response\Http $response,
        \Magento\Framework\UrlFactory $urlFactory,
        \Magento\Framework\App\ActionFlag $actionFlag )
	{
		$this->_pageFactory = $pageFactory;
		$this->helperData = $helperData;
		$this->_response = $response;
        $this->_urlFactory = $urlFactory;
        $this->_actionFlag = $actionFlag;
		return parent::__construct($context);
	}

	public function execute()
	{		
		//echo $this->helperData->getGeneralConfig('enable');
		//echo $this->helperData->getGeneralConfig('display_text');	
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$customerSession = $objectManager->create("Magento\Customer\Model\Session");
		if($customerSession->isLoggedIn()){
			return $this->_pageFactory->create();
		}else{
			$this->_response->setRedirect($this->_urlFactory->create()->getUrl('customer/account/login'));
		}
	}
}