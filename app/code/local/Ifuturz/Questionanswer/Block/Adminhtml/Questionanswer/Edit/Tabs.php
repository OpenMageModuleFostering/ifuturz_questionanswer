<?php
/**
 * @package Ifuturz_Questionanswer
 */
class Ifuturz_Questionanswer_Block_Adminhtml_Questionanswer_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('questionanswer_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('questionanswer')->__('Questionanswer Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('questionanswer')->__('Questionanswer Information'),
          'title'     => Mage::helper('questionanswer')->__('Questionanswer Information'),
          'content'   => $this->getLayout()->createBlock('questionanswer/adminhtml_questionanswer_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}