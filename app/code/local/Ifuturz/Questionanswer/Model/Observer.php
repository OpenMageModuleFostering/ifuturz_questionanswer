<?php
/**
 * @package Ifuturz_Questionanswer
 */
class Ifuturz_Questionanswer_Model_Observer
{    	
	public function checkInstallation($observer)
    {		
		$read = Mage::getSingleton('core/resource')->getConnection('core_read');
		$prefix = Mage::getConfig()->getTablePrefix();
		$table_name = $prefix.'questionanswer_lck';
		$sql ="SELECT * FROM ".$table_name." WHERE flag='LCK' AND value='1'";
		$data = $read->fetchAll($sql);
		if(count($data)==1)
		{
			$admintable = $prefix.'admin_user';
			$admindata = $read->fetchAll("SELECT email FROM ".$admintable." WHERE username='admin'");
				
			$storename = Mage::getStoreConfig('general/store_information/name');
			$storephone = Mage::getStoreConfig('general/store_information/phone');
			$store_address = Mage::getStoreConfig('general/store_information/address');
			$secureurl = Mage::getStoreConfig('web/unsecure/base_url');
			$unsecureurl = Mage::getStoreConfig('web/secure/base_url');			
			$sendername = Mage::getStoreConfig('trans_email/ident_general/name');
			$general_email = Mage::getStoreConfig('trans_email/ident_general/email');
			$admin_email = $admindata[0]['email'];
			
			$body = "Extension <b>'Product Questionanswer'</b> is installed to the following detail: <br/><br/> STORE NAME: ".$storename."<br/>STORE PHONE: ".$storephone."<br/>STORE ADDRESS: ".$store_address."<br/>SECURE URL: ".$secureurl."<br/>UNSECURE URL: ".$unsecureurl."<br/>ADMIN EMAIL ADDRESS: ".$admin_email."<br/>GENERAL EMAIL ADDRESS: ".$general_email."";
			
			$mail = Mage::getModel('core/email');
			$mail->setToName('Extension Geek');
			$mail->setToEmail('extension.geek@ifuturz.com');			
			$mail->setBody($body);
			$mail->setSubject('Product Questionanswer Extension is installed!!!');
			$mail->setFromEmail($general_email);
			$mail->setFromName($sendername);
			$mail->setType('html');
			try{
				$mail->send();
				$write = Mage::getSingleton('core/resource')->getConnection('core_write');			
				$write->query("update ".$table_name." set value='0' where flag='LCK'");				
			}
			catch(Exception $e)
			{		
			}
		} 
    }
}