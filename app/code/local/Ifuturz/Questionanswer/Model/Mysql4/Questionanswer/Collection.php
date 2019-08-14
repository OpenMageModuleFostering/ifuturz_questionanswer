<?php
/**
 * @package Ifuturz_Questionanswer
 */
class Ifuturz_Questionanswer_Model_Mysql4_Questionanswer_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	public function _construct()
	{
		parent::_construct();
		$this->_init('questionanswer/questionanswer');
	}	
	public function addStoreFilter($store)
	{
		$filter = $this->addFieldToFilter('store_id', array(
		array('regexp'=>$store), 
		array('eq'=>'0')
		));		
		return $filter;	
	}
	
}