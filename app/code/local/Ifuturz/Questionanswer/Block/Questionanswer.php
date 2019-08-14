<?php
/**
 * @package Ifuturz_Questionanswer
 */
class Ifuturz_Questionanswer_Block_Questionanswer extends Mage_Core_Block_Template
{
	public function __construct()
    {
        parent::__construct();
		$userId = Mage::getSingleton('customer/session')->getId();
		
		$collection = $this->getQuestionanswermodel()->getCollection()->addFieldToFilter('qa_asked_user_id',$userId)->addStoreFilter($this->getStoreId())->setOrder('created_at', 'desc');       
        $this->setCollection($collection);		
    }
	protected function _prepareLayout()
	{
		parent::_prepareLayout();
 
        $pager = $this->getLayout()->createBlock('page/html_pager', 'custom.pager');
        $pager->setAvailableLimit(array(5=>5,10=>10,20=>20,'all'=>'all'));
        $pager->setCollection($this->getCollection());
        $this->setChild('pager', $pager);
        $this->getCollection()->load();
        return $this;       
	}
	public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
	
	public function getStoreId()
	{
		return Mage::app()->getStore()->getStoreId();
	}
	public function getQuestionanswer()
	{
		if(!$this->hasData('questionanswer'))
		{
			$this->setData('questionanswer',Mage::registry('questionanswer'));
		}
		return $this->getData('questionanswer');
	}
	
	public function getQuestionanswermodel()
	{
		return Mage::getModel('questionanswer/questionanswer');		
		
	}
	public function getLikedislikemodel()
	{
		return Mage::getModel('questionanswer/likedislike');		
		
	}	
	
	public function getCurrentQuestionanswer($id)
	{
		return $this->getQuestionanswermodel()->getCollection()->addFieldToFilter('product_id',$id)->addFieldToFilter('enabled_on_frontend','yes')->addStoreFilter($this->getStoreId())->setOrder('created_at', 'desc')->getData();		
		
	}
	public function getQALikes($id)
	{
		$countDisLike = $this->getLikedislikemodel()->getCollection()->addFieldToFilter('questionanswer_fk_id',$id)->addFieldToFilter('que_like',1);		
		if(count($countDisLike)>0)
		{
			return count($countDisLike);
		}
		return 0;
	}
	public function getQADisLikes($id)
	{
		$countDisLike = $this->getLikedislikemodel()->getCollection()->addFieldToFilter('questionanswer_fk_id',$id)->addFieldToFilter('dislike',1);
		if(count($countDisLike)>0)
		{
			return count($countDisLike);
		}
		return 0;		
	}
	
	public function getProductDetail($pid)
	{
		return Mage::getModel('catalog/product')->load($pid);
	}

}