<?php
namespace Magento\EventsReminder\Cron;
use \Psr\Log\LoggerInterface;

class Test {
    protected $logger;
	protected $_objectManager = null;
	protected $_customerFactory;
	
    public function __construct(LoggerInterface $logger,
		\Magento\Framework\ObjectManagerInterface $objectManager,
		\Magento\Customer\Model\CustomerFactory $customerFactory
	) {
		$this->_objectManager = $objectManager;
        $this->logger = $logger;
		$this->_customerFactory = $customerFactory;
    }

/**
   * Write to system.log
   *
   * @return void
   */

   public function getCustomerById($id) {
        return $this->_customerFactory->create()->load($id);
    }
	public function isToday($time) // midnight second
		{
			return (strtotime($time) === strtotime('today'));
		}

	
    public function execute() {
		/* Here we prepare data for our email  */
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
		$resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
		$connection = $resource->getConnection();
		$eventemail = $resource->getTableName('utshob_evens_reminder');
		$sql = "Select * FROM " . $eventemail;
		$result = $connection->fetchAll($sql);
		
		foreach ($result as $row) {
			//print $row["name"] . "-" . $row["events_reminder_date"] ."<br/>";
			
			$today = date("Y-m-d"); 
			$expiry = date("Y-m-d",strtotime($row["events_reminder_date"]));
		if($today==$expiry){
			print $expiry;
		/* Receiver Detail  */
		$receiverInfo = [
			'name' => $row["name"],
			'email' => $row["friend_email"]
		];
		 
		 
		/* Sender Detail  */
		$senderInfo = [
			'name' => 'Sender Name',
			'email' => $row["friend_email"],
		];
		 
		 
		/* Assign values for your template variables  */
		$emailTemplateVariables = array();
		$emailTempVariables['myvar1'] = $row["name"];
		$emailTempVariables['myvar2'] = $row["event_message"];
								 
		/* We write send mail function in helper because if we want to 
		   use same in other action then we can call it directly from helper */ 
		 
		/* call send mail method from helper or where you define it*/ 
		$this->_objectManager->get('Magento\EventsReminder\Helper\Email')->eventMailSendMethod(
			  $emailTempVariables,
			  $senderInfo,
			  $receiverInfo
		  );
        $this->logger->info('Cron Works');
		}
    }
	}

}