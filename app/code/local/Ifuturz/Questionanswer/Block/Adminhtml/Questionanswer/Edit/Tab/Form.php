<?php
/**
 * @package Ifuturz_Questionanswer
 */
class Ifuturz_Questionanswer_Block_Adminhtml_Questionanswer_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	public function __construct()
    {
      parent::__construct();
      $this->setTemplate('questionanswer/form.phtml');	 
	}
		
    protected function _prepareForm()
    {  
	  $form = new Varien_Data_Form();
      $this->setForm($form);
	  $registerData = Mage::registry('questionanswer_data');
      $fieldset = $form->addFieldset('questionanswer_form', array('legend'=>Mage::helper('questionanswer')->__('Questionanswer information')));
		 	$yesno = array(
		array(
			'value' => 'yes',
			'label' => Mage::helper('questionanswer')->__('Yes'),
			),
			array(
			'value' => 'no',
			'label' => Mage::helper('questionanswer')->__('No'),
			)); 
      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('questionanswer')->__('Name'),
          'class'     => 'required-entry countries',
          'required'  => true,
          'name'      => 'name',
		  'values'    => $name ,
		  'disabled' => true,		 		
      ));

	  
	  $fieldset->addField('email', 'text', array(
          'label'     => Mage::helper('questionanswer')->__('Email Address'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'email',
		  'values'    => $email,
		  'disabled' => true, 	
		 )); 
		 
		$fieldset->addField('location', 'text', array(
          'label'     => Mage::helper('questionanswer')->__('Location'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'location',
		  'values'    => $location,
		  'disabled' => true,	
		 ));  
		 
		 $fieldset->addField('question', 'text', array(
          'label'     => Mage::helper('questionanswer')->__('Question'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'question',
		  'values'    => $question,		   	
		 ));   
		 
		  $fieldset->addField('question_description', 'textarea', array(
          'label'     => Mage::helper('questionanswer')->__('Question Description'),          
          'name'      => 'question_description',
		  'values'    => $question_description,
		  'disabled' => true, 	
		 ));      
	  
	  	if (!Mage::app()->isSingleStoreMode()) {
		$fieldset->addField('store_id', 'multiselect', array(
			'name' => 'stores[]',
			'label' => Mage::helper('questionanswer')->__('Store View'),
			'title' => Mage::helper('questionanswer')->__('Store View'),
			'required' => true,
			'values' => Mage::getSingleton('adminhtml/system_store')
						 ->getStoreValuesForForm(false, true),
			));
		}
		else {
			$fieldset->addField('store_id', 'hidden', array(
				'name' => 'stores[]',
				'value' => Mage::app()->getStore(true)->getId()
			));
		}
	
		$fieldset->addField('answer', 'textarea', array(
                'label'        => Mage::helper('questionanswer')->__('Answer'),
				 'class'     => 'required-entry',
                'name'         => 'answer',
                'required'     => true,
                
            ));
			
			if($registerData['is_private']=='yes')
			{
				$fieldset->addField('enabled_on_frontend', 'select', array(
                'label'        => Mage::helper('questionanswer')->__('Enable On Frontend'),
				'class'     => 'required-entry',
                'name'         => 'enabled_on_frontend',
                'required'     => true,				
				'values'    => $yesno,
				'disabled' => true,				           
            	));
			}
			else
			{
				$fieldset->addField('enabled_on_frontend', 'select', array(
                'label'        => Mage::helper('questionanswer')->__('Enable On Frontend'),
				'class'     => 'required-entry',
                'name'         => 'enabled_on_frontend',
                'required'     => true,				
				'values'    => $yesno,                
           	 ));
			}
						
			
			$fieldset->addField('send_mail', 'select', array(
                'label'        => Mage::helper('questionanswer')->__('Send Mail to User?'),				
                'name'         => 'send_mail',  
				'values'    => $yesno,
				'after_element_html' => '<small>select yes if you want to send mail to the user that the answer is given for his/her question.</small>',             				
                
            ));
			$fieldset->addField('is_private', 'select', array(
                'label'        => Mage::helper('questionanswer')->__('Is Private?'),				
                'name'         => 'is_private', 
				'values'    => $yesno,				
				'disabled' => true,			
				'after_element_html' => "<small>yes means user wants to keep this question as private, so don't enable it on frontend.</small>",				              		
                
            ));
			
			$fieldset->addField('created_at', 'hidden', array(
                'label'        => Mage::helper('questionanswer')->__('Created'),				
                'name'         => 'created_at',               		
                
            ));
			$fieldset->addField('updated_at', 'hidden', array(
                'label'        => Mage::helper('questionanswer')->__('Updated'),				
                'name'         => 'updated_at',               				
                
            ));
			$fieldset->addField('product_id', 'hidden', array(
                'label'        => Mage::helper('questionanswer')->__('Product Id'),				
                'name'         => 'product_id',               		
                
            ));
			
   
      if ( Mage::getSingleton('adminhtml/session')->getquestionanswerData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getquestionanswerData());
          Mage::getSingleton('adminhtml/session')->setquestionanswerData(null);
      } elseif ( Mage::registry('questionanswer_data') ) {
          $form->setValues(Mage::registry('questionanswer_data')->getData());
      }
      return parent::_prepareForm();
  }
}