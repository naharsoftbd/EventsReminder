<?php
namespace Magento\EventsReminder\Model\ResourceModel\Post;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'id';
	protected $_eventPrefix = 'utshob_evens_reminder_collection';
	protected $_eventObject = 'reminder_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Magento\EventsReminder\Model\Post', 'Magento\EventsReminder\Model\ResourceModel\Post');
	}

}