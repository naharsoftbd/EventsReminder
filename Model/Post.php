<?php
namespace Magento\EventsReminder\Model;

class Post extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'utshob_evens_reminder';

	protected $_cacheTag = 'utshob_evens_reminder';

	protected $_eventPrefix = 'utshob_evens_reminder';

	protected function _construct()
	{
		$this->_init('Magento\EventsReminder\Model\ResourceModel\Post');
	}

	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	public function getDefaultValues()
	{
		$values = [];

		return $values;
	}
}