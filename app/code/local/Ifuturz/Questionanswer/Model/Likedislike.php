<?php
/**
 * @package Ifuturz_Questionanswer
 */
class Ifuturz_Questionanswer_Model_Likedislike extends Mage_Core_Model_Abstract
{
	public function _construct()
	{
		parent::_construct();
		$this->_init('questionanswer/likedislike');
	}
   
}