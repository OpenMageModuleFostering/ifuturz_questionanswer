<?php
/**
 * @package Ifuturz_Questionanswer
 */
class Ifuturz_Questionanswer_IndexController extends Mage_Core_Controller_Front_Action
{

	public function indexAction()
	{
		$this->loadLayout()->renderLayout();
	}
	public function saveAction()
	{
	
		if ($data = $this->getRequest()->getPost()) 
		{	
			$pageurl = $this->getRequest()->getParam('currenturl');
			$producturl = explode('index.php/',$pageurl);			
			$model = Mage::getModel('questionanswer/questionanswer');		
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try 
			{
				if ($model->getCreatedAt() == NULL)
				{
					$model->setCreatedAt(now());						
				} 
				else
				{
					$model->setUpdatedAt(now());
				}
				
				$model->save();
				Mage::getSingleton('core/session')->addSuccess(Mage::helper('questionanswer')->__('Question was successfully Submitted'));
				Mage::getSingleton('core/session')->setFormData(false);
				//$this->_redirect('*/*/');
				$this->_redirect($producturl[1]);
				return;
            }
			catch (Exception $e) 
			{
                Mage::getSingleton('core/session')->addError($e->getMessage());
                Mage::getSingleton('core/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('core/session')->addError(Mage::helper('questionanswer')->__('Unable to find Question to save'));
        //$this->_redirect('*/*/');	
		$this->_redirect($producturl[1]);
	}
	
	public function filterAction()
	{
		$id = $this->getRequest()->getPost('proid');

		if($this->getRequest()->getPost('sortingval')=='dateold')
		{
			$quecollections = Mage::getModel('questionanswer/questionanswer')->getCollection()->addFieldToFilter('product_id',$id)->addFieldToFilter('enabled_on_frontend','yes')->setOrder('created_at', 'asc')->getData();		
		
		}
		elseif($this->getRequest()->getPost('sortingval')=='datenew')
		{
			$quecollections = Mage::getModel('questionanswer/questionanswer')->getCollection()->addFieldToFilter('product_id',$id)->addFieldToFilter('enabled_on_frontend','yes')->setOrder('created_at', 'desc')->getData();		
		
		}
		else
		{
			
		}
		?>		
		<?php if($quecollections):?>
            <?php $i=1; ?>
            <?php foreach($quecollections as $quedata):?>
                <?php if($quedata['answer']!=''):?>        
                    <?php if($i%2==0):?>
                        <div class="q-a alternate">
                    <?php else:?>
                        <div class="q-a"> 
                    <?php endif;?>              
                        
                        <?php $createddate = date('F-d-Y',strtotime($quedata['created_at']));
                        $finaldate = str_replace('-',', ',preg_replace('/-/',' ',$createddate,1));			
                        ?>
                        <p><span class="right"><?php echo $finaldate?></span><strong><?php echo $quedata['name']; ?></strong><?php echo " from ".$quedata['location']." asked:"; ?> <br></p>
                        <p class="clear-line"></p>
                        <p>
                            <span class="qa-title">Q</span>
                            <span class="qa-info"><strong><?php echo $quedata['question']; ?></strong></span>
                        </p>
                        <p class="clear-line"></p>
                        <p>
                            <span class="qa-title">A</span>
                            <span class="qa-info"><?php echo $quedata['answer']; ?></span>
                        </p>
                        <p class="clear-line"></p>              
                    </div>
                   <?php $i++;?>
               <?php endif;?>
            <?php endforeach; ?>
        
        <?php endif;?>
        <?php
	}
	public function searchquestionAction()
	{
		$id = $this->getRequest()->getPost('proid');

		$searchtext = $this->getRequest()->getPost('searchvalue');		
		
		$quecollections = Mage::getModel('questionanswer/questionanswer')->getCollection()->addFieldToFilter('product_id',$id)->addFieldToFilter('enabled_on_frontend','yes');		
		
		$quecollections->getSelect()->where("question like '%$searchtext%' or answer  like '%$searchtext%'");

		$quecollections->load()->getData();
		?>		
		<?php if($quecollections):?>
            <?php $i=1; ?>
            <?php foreach($quecollections as $quedata):?>
                <?php if($quedata['answer']!=''):?>        
                    <?php if($i%2==0):?>
                        <div class="q-a alternate">
                    <?php else:?>
                        <div class="q-a"> 
                    <?php endif;?>              
                        
                        <?php $createddate = date('F-d-Y',strtotime($quedata['created_at']));
                        $finaldate = str_replace('-',', ',preg_replace('/-/',' ',$createddate,1));			
                        ?>
                        <p><span class="right"><?php echo $finaldate?></span><strong><?php echo $quedata['name']; ?></strong><?php echo " from ".$quedata['location']." asked:"; ?> <br></p>
                        <p class="clear-line"></p>
                        <p>
                            <span class="qa-title">Q</span>
                            <span class="qa-info"><strong><?php echo $quedata['question']; ?></strong></span>
                        </p>
                        <p class="clear-line"></p>
                        <p>
                            <span class="qa-title">A</span>
                            <span class="qa-info"><?php echo $quedata['answer']; ?></span>
                        </p>
                        <p class="clear-line"></p>              
                    </div>
                   <?php $i++;?>
               <?php endif;?>
            <?php endforeach; ?>
        
        <?php endif;?>
        <?php
	}
	public function setLikeAction()
	{
		$customerId = $this->getRequest()->getPost('customerId');
		$queId = $this->getRequest()->getPost('questionId');
		
		$FirstItemcollection = Mage::getModel('questionanswer/likedislike')->getCollection()->addFieldToFilter('customer_id',$customerId)->addFieldToFilter('questionanswer_fk_id',$queId);			
		if(count($FirstItemcollection)>0)
		{
			$likeModelLoad = Mage::getModel('questionanswer/likedislike')->load($FirstItemcollection->getFirstItem()->getLikeDislikeId());
			if($likeModelLoad->getQueLike()==0)
			{
				$likeModelLoad->setQueLike(1);
				$likeModelLoad->setDislike(0);
				$likeModelLoad->save();
			}
			else
			{
				$likeModelLoad->setQueLike(0);				
				$likeModelLoad->save();						
			}
			
		}
		else
		{		
			$likeModel = Mage::getModel('questionanswer/likedislike');	
			$likeModel->setQuestionanswerFkId($queId);
			$likeModel->setQueLike(1);
			$likeModel->setCustomerId($customerId);
			$likeModel->save();			
		}
		
		$countLike = $this->getLayout()->getBlockSingleton('questionanswer/questionanswer')->getQALikes($queId); 	
		$countDisLike = $this->getLayout()->getBlockSingleton('questionanswer/questionanswer')->getQADisLikes($queId);
		$arr = array('dislike' => $countDisLike, 'like' => $countLike);
		echo json_encode($arr);
	}
	public function setDisLikeAction()
	{
		
		$customerId = $this->getRequest()->getPost('customerId');
		$queId = $this->getRequest()->getPost('questionId');
		
		$FirstItemcollection = Mage::getModel('questionanswer/likedislike')->getCollection()->addFieldToFilter('customer_id',$customerId)->addFieldToFilter('questionanswer_fk_id',$queId);	
		
		if(count($FirstItemcollection)>0)
		{
			$likeModelLoad = Mage::getModel('questionanswer/likedislike')->load($FirstItemcollection->getFirstItem()->getLikeDislikeId());
			if($likeModelLoad->getDislike()==0)
			{
				$likeModelLoad->setDislike(1);
				$likeModelLoad->setQueLike(0);
				$likeModelLoad->save();
			}
			else
			{
				$likeModelLoad->setDislike(0);				
				$likeModelLoad->save();				
			}				
		}
		else
		{		
			$likeModel = Mage::getModel('questionanswer/likedislike');	
			$likeModel->setQuestionanswerFkId($queId);
			$likeModel->setDislike(1);
			$likeModel->setCustomerId($customerId);
			$likeModel->save();			
		}	
		
		$countLike = $this->getLayout()->getBlockSingleton('questionanswer/questionanswer')->getQALikes($queId); 	
		$countDisLike = $this->getLayout()->getBlockSingleton('questionanswer/questionanswer')->getQADisLikes($queId);
		$arr = array('dislike' => $countDisLike, 'like' => $countLike);
		echo json_encode($arr);
	}
	
	public function listqaAction()
	{					
		Mage::getSingleton('customer/session');
		parent::preDispatch();
        if (!Mage::getSingleton('customer/session')->authenticate($this)) 
		{
        	$this->setFlag('', 'no-dispatch', true);
        }
		$this->loadLayout();
        $this->renderLayout();
	}
}