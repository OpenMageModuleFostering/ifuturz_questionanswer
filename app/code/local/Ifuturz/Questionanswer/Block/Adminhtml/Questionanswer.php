<?php
/**
 * @package Ifuturz_Questionanswer
 */
class Ifuturz_Questionanswer_Block_Adminhtml_Questionanswer extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
	
    $this->_controller = 'adminhtml_questionanswer';
    $this->_blockGroup = 'questionanswer';
    $this->_headerText = Mage::helper('questionanswer')->__('Questionanswer Management');
    $this->_addButtonLabel = Mage::helper('questionanswer')->__('Add Question');
    parent::__construct();
	$this->_removeButton('add');
  }
}