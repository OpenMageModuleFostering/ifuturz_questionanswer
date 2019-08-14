<?php 
/**
 * @package Ifuturz_Questionanswer
 */
$installer = $this;

$installer->startSetup();


$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('questionanswer')};
CREATE TABLE {$this->getTable('questionanswer')} (
  `questionanswer_id` int(11) unsigned NOT NULL auto_increment,
	`name` varchar(50) NULL,
	`email` varchar(255) NULL,
	`product_id` int(10),
	`qa_asked_user_id` int(10) unsigned NOT NULL default '0',	
	`enabled_on_frontend` enum('yes','no') NOT NULL default 'no',
	`location` varchar(50) NULL,
	`question` varchar(120) NULL,
	`question_description` text,
	`answer` text,
	`created_at` datetime default NULL,
	`updated_at` datetime default NULL,	
	`helpful` enum('yes','no') NOT NULL default 'no',
	`send_mail` enum('yes','no') NOT NULL default 'no',	
	`is_private` enum('yes','no') NOT NULL default 'no',
  PRIMARY KEY (`questionanswer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('questionanswer_lck')};
CREATE TABLE {$this->getTable('questionanswer_lck')} ( 	
	`flag` varchar(4),
	`value` ENUM('0','1') DEFAULT '0' NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `{$installer->getTable('questionanswer_lck')}` VALUES ('LCK','1');
");

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('questionanswer_like_dislike')};
CREATE TABLE {$this->getTable('questionanswer_like_dislike')} (  
  `like_dislike_id` int(11) unsigned NOT NULL auto_increment,
  `questionanswer_fk_id` int(11) unsigned NOT NULL default '0',
  `customer_id` int(10) unsigned NOT NULL default '0',  
  `que_like` enum('0','1') NOT NULL default '0',
  `dislike` enum('0','1') NOT NULL default '0',
   PRIMARY KEY (`like_dislike_id`),
   KEY `QUESTIONANSWER_LIKE_DISLIKE_CUST` (`customer_id`),
   KEY `QUESTIONANSWER_LIKE_DISLIKE_QA` (`questionanswer_fk_id`),
   CONSTRAINT `QUESTIONANSWER_LIKE_DISLIKE_CUST` FOREIGN KEY (`customer_id`) REFERENCES {$this->getTable('customer_entity')} (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `QUESTIONANSWER_LIKE_DISLIKE_QA` FOREIGN KEY (`questionanswer_fk_id`) REFERENCES {$this->getTable('questionanswer')} (`questionanswer_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup(); 