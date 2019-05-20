CREATE TABLE `VX_aln_auto_confirm_setup_rules` (
  `acsr_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `orig_market_id` int(11) NOT NULL,
  `dest_market_id` int(11) NOT NULL,
  `flight_nbr_start` int(11) NOT NULL,
  `flight_nbr_end` int(11) NOT NULL,
  `flight_dep_date_start` int(11) NOT NULL,
  `flight_dep_date_end` int(11) NOT NULL,
 `flight_dep_time_start` varchar(100) NOT NULL,
  `flight_dep_time_end` varchar(100) NOT NULL,
  `upgrade_from_cabin_type` int(11) NOT NULL,
  `upgrade_to_cabin_type` int(11) NOT NULL,
  `frequency` varchar(100) NOT NULL,
  `future_use` tinyint(1) NOT NULL DEFAULT '1',
   `season_id` int(11) NOT NULL,
  `memp` int(11) NOT NULL,
  `min_bid_price` varchar(100) NOT NULL,
  `action_type` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `create_userID` int(11) NOT NULL,
  `modify_userID` int(11) NOT NULL,
  `create_date` int(11) NOT NULL,
  `modify_date` int(11) NOT NULL,
  PRIMARY KEY (`acsr_id`),
  KEY `orig_market_id_indx` (`orig_market_id`),
  KEY `dest_market_id_indx` (`dest_market_id`),
  KEY `flight_dep_date_start_indx` (`flight_dep_date_start`),
  KEY `flight_dep_date_end_indx` (`flight_dep_date_end`),
  KEY `flight_dep_time_start_indx` (`flight_dep_time_start`),
  KEY `flight_dep_time_end_indx` (`flight_dep_time_end`),
  KEY `flight_nbr_start_indx` (`flight_nbr_start`),
  KEY `flight_nbr_end_indx` (`flight_nbr_end`),
  KEY `upgrade_from_cabin_type_indx` (`upgrade_from_cabin_type`),
  KEY `upgrade_to_cabin_type_indx` (`upgrade_to_cabin_type`),
  KEY `furture_use_indx` (`future_use`),
  KEY `memp_indx` (`memp`),
  KEY `min_bid_price_indx` (`min_bid_price`),
  KEY `action_type_indx` (`action_type`),
  KEY `frequency_indx` (`frequency`),
  KEY `active_indx` (`active`),
  KEY `createuser_indx` (`create_userID`),
  KEY `modifyuser_indx` (`modify_userID`),
  KEY `createdate_indx` (`create_date`),
  KEY `modifydate_indx` (`modify_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;


insert into menu (menuName,link,icon,status,parentID,priority) values ('acsr','acsr','icon-template','1','0','1000');
insert into permissions (description,name,active) values ('Acsr','acsr','yes');

insert into permissions (description,name,active) values ('Acsr Add','acsr_add','yes');
insert into permissions (description,name,active) values ('Acsr Delete','acsr_delete','yes');

insert into permissions (description,name,active) values ('Acsr Edit','acsr_edit','yes');


insert into vx_aln_data_types (name,create_userID,modify_userID,active,create_date,modify_date,alias) values   ('action_types',1,1,1,1554788423,1554788423,'Action Types');



insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,create_userID,modify_userID,create_date,modify_date) values ('19','Accept & confirm','1','1','1554788423','1554788423');
insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,create_userID,modify_userID,create_date,modify_date) values ('19','Reject and send regrets','1','1','1554788423','1554788423');

