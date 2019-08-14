<?php

$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();
$installer->run("
CREATE TABLE IF NOT EXISTS `{$this->getTable('socialshare_entity')}` (
  `entity_id` int(10) unsigned NOT NULL auto_increment,
  `entity_type_id` smallint(8) unsigned NOT NULL default '0',
  `attribute_set_id` smallint(5) unsigned NOT NULL default '0',
  `website_id` smallint(5) unsigned default NULL,
  `email` varchar(255) NOT NULL default '',
  `group_id` smallint(3) unsigned NOT NULL default '0',
  `increment_id` varchar(50) NOT NULL default '', `parent_id` int(10) unsigned NOT NULL default '0',
  `store_id` smallint(5) unsigned default '0',
  `created_at` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_at` datetime NOT NULL default '0000-00-00 00:00:00',
  `is_active` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`entity_id`),
  KEY `FK_socialshare_ENTITY_STORE` (`store_id`),
  KEY `IDX_ENTITY_TYPE` (`entity_type_id`),
  KEY `IDX_AUTH` (`email`,`website_id`),
  KEY `FK_socialshare_WEBSITE` (`website_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='Customer Entityies' AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `{$this->getTable('socialshare_entity_datetime')}` (
  `value_id` int(11) NOT NULL auto_increment,
  `entity_type_id` smallint(8) unsigned NOT NULL default '0',
  `attribute_id` smallint(5) unsigned NOT NULL default '0',
  `entity_id` int(10) unsigned NOT NULL default '0',
  `value` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`value_id`),
  KEY `FK_SOCIALSHARE_DATETIME_ENTITY_TYPE` (`entity_type_id`),
  KEY `FK_SOCIALSHARE_DATETIME_ATTRIBUTE` (`attribute_id`),
  KEY `FK_SOCIALSHARE_DATETIME_ENTITY` (`entity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `{$this->getTable('socialshare_entity_decimal')}` (
  `value_id` int(11) NOT NULL auto_increment,
  `entity_type_id` smallint(8) unsigned NOT NULL default '0',
  `attribute_id` smallint(5) unsigned NOT NULL default '0',
  `entity_id` int(10) unsigned NOT NULL default '0',
  `value` decimal(12,4) NOT NULL default '0.0000',
  PRIMARY KEY  (`value_id`),
  KEY `FK_SOCIALSHARE_DECIMAL_ENTITY_TYPE` (`entity_type_id`),
  KEY `FK_SOCIALSHARE_DECIMAL_ATTRIBUTE` (`attribute_id`),
  KEY `FK_SOCIALSHARE_DECIMAL_ENTITY` (`entity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `{$this->getTable('socialshare_entity_int')}` (
  `value_id` int(11) NOT NULL auto_increment,
  `entity_type_id` smallint(8) unsigned NOT NULL default '0',
  `attribute_id` smallint(5) unsigned NOT NULL default '0',
  `entity_id` int(10) unsigned NOT NULL default '0',
  `value` int(11) NOT NULL default '0',
  PRIMARY KEY  (`value_id`),
  KEY `FK_SOCIALSHARE_INT_ENTITY_TYPE` (`entity_type_id`),
  KEY `FK_SOCIALSHARE_INT_ATTRIBUTE` (`attribute_id`),
  KEY `FK_SOCIALSHARE_INT_ENTITY` (`entity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `{$this->getTable('socialshare_entity_text')}` (
  `value_id` int(11) NOT NULL auto_increment,
  `entity_type_id` smallint(8) unsigned NOT NULL default '0',
  `attribute_id` smallint(5) unsigned NOT NULL default '0',
  `entity_id` int(10) unsigned NOT NULL default '0',
  `value` text NOT NULL,
  PRIMARY KEY  (`value_id`),
  KEY `FK_SOCIALSHARE_TEXT_ENTITY_TYPE` (`entity_type_id`),
  KEY `FK_SOCIALSHARE_TEXT_ATTRIBUTE` (`attribute_id`),
  KEY `FK_SOCIALSHARE_TEXT_ENTITY` (`entity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `{$this->getTable('socialshare_entity_varchar')}` (
  `value_id` int(11) NOT NULL auto_increment,
  `entity_type_id` smallint(8) unsigned NOT NULL default '0',
  `attribute_id` smallint(5) unsigned NOT NULL default '0',
  `entity_id` int(10) unsigned NOT NULL default '0',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`value_id`),
  KEY `FK_SOCIALSHARE_VARCHAR_ENTITY_TYPE` (`entity_type_id`),
  KEY `FK_SOCIALSHARE_VARCHAR_ATTRIBUTE` (`attribute_id`),
  KEY `FK_SOCIALSHARE_VARCHAR_ENTITY` (`entity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


ALTER TABLE `{$this->getTable('socialshare_entity')}`
  ADD CONSTRAINT `FK_SOCIALSHARE_ENTITY_STORE` FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core_store')}` (`store_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SOCIALSHARE_WEBSITE` FOREIGN KEY (`website_id`) REFERENCES `{$this->getTable('core_website')}` (`website_id`) ON DELETE SET NULL ON UPDATE CASCADE;


ALTER TABLE `{$this->getTable('socialshare_entity_datetime')}`
  ADD CONSTRAINT `FK_SOCIALSHARE_DATETIME_ATTRIBUTE` FOREIGN KEY (`attribute_id`) REFERENCES `{$this->getTable('eav_attribute')}` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SOCIALSHARE_DATETIME_ENTITY` FOREIGN KEY (`entity_id`) REFERENCES `{$this->getTable('socialshare_entity')}` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SOCIALSHARE_DATETIME_ENTITY_TYPE` FOREIGN KEY (`entity_type_id`) REFERENCES `{$this->getTable('eav_entity_type')}` (`entity_type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `{$this->getTable('socialshare_entity_decimal')}`
  ADD CONSTRAINT `FK_SOCIALSHARE_DECIMAL_ATTRIBUTE` FOREIGN KEY (`attribute_id`) REFERENCES `{$this->getTable('eav_attribute')}` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SOCIALSHARE_DECIMAL_ENTITY` FOREIGN KEY (`entity_id`) REFERENCES `{$this->getTable('socialshare_entity')}` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SOCIALSHARE_DECIMAL_ENTITY_TYPE` FOREIGN KEY (`entity_type_id`) REFERENCES `{$this->getTable('eav_entity_type')}` (`entity_type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `{$this->getTable('socialshare_entity_int')}`
  ADD CONSTRAINT `FK_SOCIALSHARE_INT_ATTRIBUTE` FOREIGN KEY (`attribute_id`) REFERENCES `{$this->getTable('eav_attribute')}` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SOCIALSHARE_INT_ENTITY` FOREIGN KEY (`entity_id`) REFERENCES `{$this->getTable('socialshare_entity')}` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SOCIALSHARE_INT_ENTITY_TYPE` FOREIGN KEY (`entity_type_id`) REFERENCES `{$this->getTable('eav_entity_type')}` (`entity_type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `{$this->getTable('socialshare_entity_text')}`
  ADD CONSTRAINT `FK_SOCIALSHARE_TEXT_ATTRIBUTE` FOREIGN KEY (`attribute_id`) REFERENCES `{$this->getTable('eav_attribute')}` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SOCIALSHARE_TEXT_ENTITY` FOREIGN KEY (`entity_id`) REFERENCES `{$this->getTable('socialshare_entity')}` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SOCIALSHARE_TEXT_ENTITY_TYPE` FOREIGN KEY (`entity_type_id`) REFERENCES `{$this->getTable('eav_entity_type')}` (`entity_type_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `{$this->getTable('socialshare_entity_varchar')}`
  ADD CONSTRAINT `FK_SOCIALSHARE_VARCHAR_ATTRIBUTE` FOREIGN KEY (`attribute_id`) REFERENCES `{$this->getTable('eav_attribute')}` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SOCIALSHARE_VARCHAR_ENTITY` FOREIGN KEY (`entity_id`) REFERENCES `{$this->getTable('socialshare_entity')}` (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SOCIALSHARE_VARCHAR_ENTITY_TYPE` FOREIGN KEY (`entity_type_id`) REFERENCES `{$this->getTable('eav_entity_type')}` (`entity_type_id`) ON DELETE CASCADE ON UPDATE CASCADE;
	");

$installer->installEntities();

$installer->endSetup();
