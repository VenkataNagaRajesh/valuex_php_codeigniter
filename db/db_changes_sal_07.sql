CREATE TABLE `VX_aln_eligibility_excl_rules` (
  `eexcl_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `excl_reason_desc` varchar(250) NOT NULL,
  `orig_market_id` int(11) NOT NULL,
  `dest_market_id` int(11) NOT NULL,
  `flight_efec_date` int(11) NOT NULL,
  `flight_disc_date` int(11) NOT NULL,
   `flight_dep_start` varchar(100) NOT NULL,
 `flight_dep_end` varchar(100) NOT NULL,
`flight_nbr_start` varchar(100) NOT NULL,
 `flight_nbr_end` varchar(100) NOT NULL,
  `upgrade_from_class_type` int(11) NOT NULL,
`upgrade_to_class_type` int(11) NOT NULL,

  `frequency` varchar(100) NOT NULL,
`future_use` tinyint(1) NOT NULL DEFAULT '1',
   
    `active` tinyint(1) NOT NULL DEFAULT '1',
  `create_userID` int(11) NOT NULL,
  `modify_userID` int(11) NOT NULL,
  `create_date` int(11) NOT NULL,
  `modify_date` int(11) NOT NULL,
  PRIMARY KEY (`eexcl_id`),
  KEY `desc_indx` (`excl_reason_desc`),
  KEY `orig_market_id_indx` (`orig_market_id`),
   KEY `dest_market_id_indx` (`dest_market_id`),
  KEY `flight_efec_date_indx` (`flight_efec_date`),
  KEY `flight_disc_date_indx` (`flight_disc_date`),
  KEY `flight_dep_start_indx` (`flight_dep_start`),
  KEY `flight_dep_end_indx` (`flight_dep_end`),
  KEY `flight_nbr_start_indx` (`flight_nbr_start`),
 KEY `flight_nbr_end_indx` (`flight_nbr_end`),
  KEY `upgrade_from_class_type_indx` (`upgrade_from_class_type`),
  KEY `upgrade_to_class_type_indx` (`upgrade_to_class_type`),
  KEY `furture_use_indx` (`future_use`),
  KEY `frequency_indx` (`frequency`),
  KEY `active_indx` (`active`),
  KEY `createuser_indx` (`create_userID`),
  KEY `modifyuser_indx` (`modify_userID`),
  KEY `createdate_indx` (`create_date`),
  KEY `modifydate_indx` (`modify_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;







insert into vx_aln_data_types (name,create_userID,modify_userID,active,create_date,modify_date) values   ('airline_cabin_class',1,1,1,1554788423,1554788423);


insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,create_userID,modify_userID,create_date,modify_date) values ('13','Economy','1','1','1554788423','1554788423');
insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,create_userID,modify_userID,create_date,modify_date) values ('13','Premium ECO','1','1','1554788423','1554788423');
insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,create_userID,modify_userID,create_date,modify_date) values ('13','Business','1','1','1554788423','1554788423');
insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,create_userID,modify_userID,create_date,modify_date) values ('13','First','1','1','1554788423','1554788423');


insert into vx_aln_data_types (name,create_userID,modify_userID,active,create_date,modify_date) values   ('days_of_week',1,1,1,1554788423,1554788423);



insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,create_userID,modify_userID,create_date,modify_date) values ('14','Monday','1','1','1554788423','1554788423');
insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,create_userID,modify_userID,create_date,modify_date) values ('14','Tuesday','1','1','1554788423','1554788423');
insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,create_userID,modify_userID,create_date,modify_date) values ('14','Wednesday','1','1','1554788423','1554788423');
insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,create_userID,modify_userID,create_date,modify_date) values ('14','Thursday','1','1','1554788423','1554788423');
insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,create_userID,modify_userID,create_date,modify_date) values ('14','Friday','1','1','1554788423','1554788423');
insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,create_userID,modify_userID,create_date,modify_date) values ('14','Saturday','1','1','1554788423','1554788423');
insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,create_userID,modify_userID,create_date,modify_date) values ('14','Sunday','1','1','1554788423','1554788423');

insert into vx_aln_data_types (name,create_userID,modify_userID,active,create_date,modify_date) values   ('time_24_hr_format',1,1,1,1554788423,1554788423);




insert into menu (menuName,link,icon,status,parentID,priority) values ('eligibility_exclusion','eligibility_exclusion','icon-template','1','0','1000');
insert into permissions (description,name,active) values ('Eligibility Exclusion Rules','eligibility_exclusion','yes');

insert into permissions (description,name,active) values ('Eligibility Exclusion Rules Add','eligibility_exclusion_add','yes');
insert into permissions (description,name,active) values ('Eligibility Exclusion Rules Delete','eligibility_exclusion_delete','yes');

insert into permissions (description,name,active) values ('Eligibility Exclusion Rules Edit','eligibility_exclusion_edit','yes');

