<?php 

namespace Magento\EventsReminder\Controller\Account;
use Magento\Framework\Controller\ResultFactory;
class Deleteevent extends \Magento\Framework\App\Action\Action
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
		$id = $this->getRequest()->getParam('eventid');
        try {
            $model = $this->_postFactory->create();
            $model->load($id);
            $model->delete();
			$this->messageManager->addSuccessMessage('My Event Deleted Successfully !');
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }
    }
}