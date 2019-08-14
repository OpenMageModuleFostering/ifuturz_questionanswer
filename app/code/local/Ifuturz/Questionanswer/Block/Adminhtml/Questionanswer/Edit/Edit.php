<?php
/**
 * @package Ifuturz_Questionanswer
 */ 
class Ifuturz_Questionanswer_Block_Adminhtml_Questionanswer_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'questionanswer';
        $this->_controller = 'adminhtml_questionanswer';
       
        $this->_updateButton('save', 'label', Mage::helper('questionanswer')->__('Save Question'));
        $this->_updateButton('delete', 'label', Mage::helper('questionanswer')->__('Delete Question'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('questionanswer_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'questionanswer_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'questionanswer_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('questionanswer_data') && Mage::registry('questionanswer_data')->getId() ) 
		{			
            return Mage::helper('questionanswer')->__("Edit Question");
        } 
		else 
		{
            return Mage::helper('questionanswer')->__('Add Question');
        }
	}
}