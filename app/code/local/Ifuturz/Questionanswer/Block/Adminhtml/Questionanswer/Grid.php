<?php
/**
 * @package Ifuturz_Questionanswer
 */
class Ifuturz_Questionanswer_Block_Adminhtml_Questionanswer_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      
	  parent::__construct();
      $this->setId('questionanswerGrid');
      $this->setDefaultSort('questionanswer_id');
      $this->setDefaultDir('DESC');
      $this->setSaveParametersInSession(true);
  }
	
  protected function _filterStoreCondition($collection, $column)
  {
		if (!$value = $column->getFilter()->getValue()) {
			return;
		}
		$this->getCollection()->addStoreFilter($value);
 }
  protected function _prepareCollection()
  {
      $collection = Mage::getModel('questionanswer/questionanswer')->getCollection();
	 		
      $this->setCollection($collection);
      parent::_prepareCollection();
	  foreach($collection as $link)
		{
			if($link->getStoreId() && $link->getStoreId() != 0 )
			{
				$link->setStoreId(explode(',',$link->getStoreId()));
			}
			else
			{
				$link->setStoreId(array('0'));
			}
		}
		return $this;		
  }

  protected function _prepareColumns()
  { 
      
      $this->addColumn('questionanswer_id', array(
          'header'    => Mage::helper('questionanswer')->__('ID'),
          'align'     =>'left',
          'index'     => 'questionanswer_id',
      ));
	  $this->addColumn('name', array(
          'header'    => Mage::helper('questionanswer')->__('Name'),
          'align'     =>'left',
          'index'     => 'name',
      ));
	  
	  $this->addColumn('email', array(
          'header'    => Mage::helper('questionanswer')->__('Email'),
          'align'     =>'left',
          'index'     => 'email',
      ));
	  
	  $this->addColumn('location', array(
          'header'    => Mage::helper('questionanswer')->__('Location'),
          'align'     =>'left',
          'index'     => 'location',		
      ));
	  $this->addColumn('product_id', array(
          'header'    => Mage::helper('questionanswer')->__('Product ID'),
          'align'     =>'left',
          'index'     => 'product_id',		
      ));
	   $this->addColumn('question', array(
          'header'    => Mage::helper('questionanswer')->__('Question'),
          'align'     =>'left',
          'index'     => 'question',  		  

      ));  
	  
	   $this->addColumn('answer', array(
          'header'    => Mage::helper('questionanswer')->__('Answer'),
          'align'     =>'left',
          'index'     => 'answer',

      )); 
	  $this->addColumn('enabled_on_frontend', array(
            'header' => Mage::helper('sales')->__('Enabled'),
            'index' => 'enabled_on_frontend',
            'type'  => 'options',
            'width' => '70px',
            'options' => array(
							'yes' => 'Yes',
							'no' => 'No',
							),
        ));
		$this->addColumn('is_private', array(
            'header' => Mage::helper('sales')->__('Is Private?'),
            'index' => 'is_private',
            'type'  => 'options',
            'width' => '70px',
            'options' => array(
							'yes' => 'Yes',
							'no' => 'No',
							),
        ));
	   $this->addColumn('created_at', array(
          'header'    => Mage::helper('questionanswer')->__('Created At'),
          'align'     =>'left',
          'index'     => 'created_at',
  		 'type'      => 'date',

      ));  
	   $this->addColumn('updated_at', array(
          'header'    => Mage::helper('questionanswer')->__('Update At'),
          'align'     =>'left',
          'index'     => 'updated_at',
  		  'type'      => 'date',

      ));  
	 
	 if (!Mage::app()->isSingleStoreMode()) 
	 {
		$this->addColumn('store_id', array(
			'header'        => Mage::helper('questionanswer')->__('Store View'),
			'index'         => 'store_id',
			'type'          => 'store',
			'store_all'     => true,
			'store_view'    => true,
			'sortable'      => true,
			'filter_condition_callback' => array($this,
				'_filterStoreCondition'),
		));
	 }
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('questionanswer')->__('Edit'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('questionanswer')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )					
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));	  		
		
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('questionanswer_id');
        $this->getMassactionBlock()->setFormFieldName('questionanswer');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('questionanswer')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('questionanswer')->__('Are you sure?')
        ));       
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}