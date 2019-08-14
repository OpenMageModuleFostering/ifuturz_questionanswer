<?php 
/**
 * @package Ifuturz_Questionanswer
 */
$installer = $this;

$installer->startSetup();

$installer->run("
ALTER TABLE {$this->getTable('questionanswer')} 
ADD COLUMN `store_id` varchar(100) NOT NULL default '0';
");

$installer->endSetup(); 