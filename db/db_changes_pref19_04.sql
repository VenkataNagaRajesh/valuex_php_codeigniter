CREATE TABLE `VX_aln_preference` (
  `VX_aln_preferenceID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `categoryID` int(11) NOT NULL,
  `pref_type` int(11) NOT NULL,
  `pref_code` varchar(50) NOT NULL,
  `pref_display_name` varchar(250) DEFAULT NULL,
  `pref_value` varchar(50) NOT NULL,
  `pref_get_value_type` int(11) NOT NULL,
  `pref_get_value` int(11) NOT NULL, 
  `create_userID` int(11) NOT NULL,  
  `modify_userID` int(11) NOT NULL,  
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `create_date` int(11) NOT NULL,
  `modify_date` int(11) NOT NULL,
  PRIMARY KEY (`VX_aln_preferenceID`),
  KEY `cat_indx` (`categoryID`),
  KEY `type_indx` (`pref_type`),  
  KEY `code_indx` (`pref_code`),
  KEY `value_indx` (`pref_value`),
  KEY `get_value_type_indx` (`pref_get_value_type`),  
  KEY `get_value_indx` (`pref_get_value`),
  KEY `active_indx` (`active`),
  KEY `createuser_indx` (`create_userID`),
  KEY `modifyuser_indx` (`modify_userID`),
  KEY `createdate_indx` (`create_date`),
  KEY `modifydate_indx` (`modify_date`)    
);

insert into menu (menuName,link,icon,status,parentID,priority) values ('Preference','preference','fa-cogs','1','0','500');
insert into permissions (description,name,active) values ('Preference','preference','yes');
insert into permissions (description,name,active) values ('Preference Add','preference_add','yes');
insert into permissions (description,name,active) values ('Preference Edit','preference_edit','yes');
insert into permissions (description,name,active) values ('Preference Delete','preference_delete','yes');
insert into permissions (description,name,active) values ('Preference View','preference_view','yes');


insert into vx_aln_data_types (name,create_userID,modify_userID,active,create_date,modify_date) values('pref_category',1,1,1,1554788423,1554788423);
insert into vx_aln_data_types (name,create_userID,modify_userID,active,create_date,modify_date) values('pref_type',1,1,1,1554788423,1554788423);
insert into vx_aln_data_types (name,create_userID,modify_userID,active,create_date,modify_date) values('pref_bolean',1,1,1,1554788423,1554788423);
into vx_aln_data_types (name,create_userID,modify_userID,active,create_date,modify_date) values('pref_text',1,1,1,1554788423,1554788423);
insert into vx_aln_data_types (name,create_userID,modify_userID,active,create_date,modify_date) values('pref_list',1,1,1,1554788423,1554788423);

