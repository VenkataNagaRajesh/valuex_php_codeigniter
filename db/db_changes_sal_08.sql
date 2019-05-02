CREATE TABLE `VX_aln_ra_feed` (
  `rafeed_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ticket_number` bigint(15) NOT NULL,
  `airline_code`  int(11) NOT NULL,
  `cpn_number` int(11) NOT NULL,
  `cpn_value` int(11) NOT NULL,
  `carrier` int(11) NOT NULL,
   `flight_number`  varchar(60) NOT NULL,
 `boarding_point`  int(11) NOT NULL,
`off_point`  int(11) NOT NULL,
 `cabin`  varchar(60) NOT NULL,
  `class`  int(11) NOT NULL,
`flight_date`  int(11) NOT NULL,
 `fare_basis`  int(11)  NOT NULL,
  `booking_country`  int(11) NOT NULL,
`booking_city`  int(11) NOT NULL ,
   `office_id`  int(11) NOT NULL ,
`channel`  int(11) NOT NULL ,
   `pax_type`  int(11) NOT NULL ,
    `active` tinyint(1) NOT NULL DEFAULT '1',
  `create_userID` int(11) NOT NULL,
  `modify_userID` int(11) NOT NULL,
  `create_date` int(11) NOT NULL,
  `modify_date` int(11) NOT NULL,
  PRIMARY KEY (`rafeed_id`),
  KEY `ticket_number_indx` (`ticket_number`),
  KEY `airline_code_indx` (`airline_code`),
   KEY `cpn_number_indx` (`cpn_number`),
  KEY `cpn_value_indx` (`cpn_value`),
  KEY `carrier_indx` (`carrier`),
  KEY `flight_number_indx` (`flight_number`),
  KEY `boarding_point_indx` (`boarding_point`),
  KEY `off_point_indx` (`off_point`),
 KEY `class_indx` (`class`),
 KEY `flight_date_indx` (`flight_date`),
 KEY `fare_basis_indx` (`fare_basis`),
  KEY `cabin_indx` (`cabin`),
  KEY `office_id_indx` (`office_id`),
  KEY `channel_indx` (`channel`),
  KEY `pax_type_indx` (`pax_type`),
  KEY `active_indx` (`active`),
  KEY `createuser_indx` (`create_userID`),
  KEY `modifyuser_indx` (`modify_userID`),
  KEY `createdate_indx` (`create_date`),
  KEY `modifydate_indx` (`modify_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;





insert into menu (menuName,link,icon,status,parentID,priority) values ('rafeed','rafeed','icon-template','1','0','1000');
insert into permissions set description='RAfeed',name='rafeed';
insert into permissions set description='RAfeed Edit',name='rafeed_edit';
insert into permissions set description='RAfeed Delete',name='rafeed_delete';
insert into permissions set description='RAfeed Upload',name='rafeed_upload';
