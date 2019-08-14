<?php
/**
 * @package Ifuturz_Questionanswer
 */
class Ifuturz_Questionanswer_Model_Mysql4_Likedislike extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the questionanswer_id refers to the key field in your database table.
        $this->_init('questionanswer/likedislike', 'like_dislike_id');
    }
	
}