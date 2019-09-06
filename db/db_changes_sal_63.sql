CREATE TABLE `VX_aln_airline_cabin_def` (
  `map_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `carrier` int(11) NOT NULL,
  `cabin` varchar(60) NOT NULL,
  `level` tinyint(1) NOT NULL DEFAULT '0',
  `desc` varchar(60) NOT NULL,
  `create_date` int(11) unsigned NOT NULL,
  `modify_date` int(11) unsigned NOT NULL,
  `create_userID` int(11) unsigned NOT NULL,
  `modify_userID` int(11) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`map_id`),
  KEY `carrier_index` (`carrier`),
  KEY `level_index` (`level`),
  KEY `cabin_index` (`cabin`),
  KEY `desc_index` (`desc`),
 KEY `modify_date_index` (`modify_date`),
  KEY `create_date_index` (`create_date`),
  KEY `create_userID_index` (`create_userID`),
  KEY `modify_userID_index` (`modify_userID`),
  KEY `active_index` (`active`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

insert into menu (menuName,link,icon,status,parentID,priority) values ('airline_cabin_def','airline_cabin_def','icon-template','1','0','1000');
insert into permissions (description,name,active) values ('Carrier Cabin Definition','airline_cabin_def','yes');
insert into permissions (description,name,active) values ('Carrier Cabin Definition Add','airline_cabin_def_add','yes');
insert into permissions (description,name,active) values ('Carrier Cabin Definition Delete','airline_cabin_def_delete','yes');
insert into permissions (description,name,active) values ('Carrier Cabin Definition Edit','airline_cabin_def_edit','yes');
