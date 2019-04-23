CREATE TABLE `VX_aln_season` (
  `VX_aln_seasonID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `season_name` varchar(250) NOT NULL,
  `ams_orig_levelID` int(11) NOT NULL,
  `ams_orig_level_value` varchar(100) NOT NULL,
  `ams_dest_levelID` int(11) DEFAULT NULL,
  `ams_dest_level_value` varchar(100) NOT NULL,
  `ams_season_start_date` int(11) NOT NULL,
  `ams_season_end_date` int(11) NOT NULL, 
  `is_return_inclusive` tinyint(1) NOT NULL,
  `season_color` varchar(100) NOT NULL,     
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `create_userID` int(11) NOT NULL,  
  `modify_userID` int(11) NOT NULL,
  `create_date` int(11) NOT NULL,
  `modify_date` int(11) NOT NULL,
  PRIMARY KEY (`VX_aln_seasonID`), 
  KEY `sesname_indx` (`season_name`),
  KEY `origlevel_indx` (`ams_orig_levelID`),  
  KEY `origlevel_value_indx` (`ams_orig_level_value`),
  KEY `destlavel_indx` (`ams_dest_levelID`),
  KEY `destlavel__value_indx` (`ams_dest_level_value`),  
  KEY `startdate_indx` (`ams_season_start_date`),
  KEY `enddate_indx` (`ams_season_end_date`),  
  KEY `rtn_incls_indx` (`is_return_inclusive`),
  KEY `color_indx` (`season_color`),
  KEY `active_indx` (`active`),
  KEY `createuser_indx` (`create_userID`),
  KEY `modifyuser_indx` (`modify_userID`),
  KEY `createdate_indx` (`create_date`),
  KEY `modifydate_indx` (`modify_date`)    
);


insert into menu (menuName,link,icon,status,parentID,priority) values ('season','season','fa-sun-o','1','0','1000');

insert into permissions (description,name,active) values ('Season','season','yes');
insert into permissions (description,name,active) values ('Season Add','season_add','yes');
insert into permissions (description,name,active) values ('Season Edit','season_edit','yes');
insert into permissions (description,name,active) values ('Season Delete','season_delete','yes');
insert into permissions (description,name,active) values ('Season View','season_view','yes');

