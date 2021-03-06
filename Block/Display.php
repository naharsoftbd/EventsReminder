<?php
namespace Magento\EventsReminder\Block;

class Display extends \Magento\Framework\View\Element\Template
{
	protected $_postFactory;
	protected $customerSession;
		
	 public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
		\Magento\Customer\Model\Session $customerSession,		
		\Magento\EventsReminder\Model\PostFactory $postFactory
    ) {
		$this->_postFactory = $postFactory;
		$this->customerSession = $customerSession;
		
        parent::__construct($context);

    }
			
	public function getPostCollection(){
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$customerSession = $objectManager->create("Magento\Customer\Model\Session");
		$customerid = $customerSession->getCustomer()->getEmail();
		$post = $this->_postFactory->create();
		return $post->getCollection()->addFieldToFilter('customer_id',$customerid);
	}
	
}