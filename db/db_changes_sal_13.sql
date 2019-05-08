 CREATE TABLE `VX_aln_daily_tkt_pax_feed` (
  `dtpf_id` bigint(16) unsigned NOT NULL AUTO_INCREMENT,
`airline_code` int(11) NOT NULL,
  `pnr_ref` varchar(60) NOT NULL,
  `pax_nbr`  varchar(60) NOT NULL,
  `first_name` varchar(60) NOT NULL,
   `last_name` varchar(60) NOT NULL,
   `ptc` varchar(60) NOT NULL,
   `fqtv` varchar(60) NOT NULL,
   `carrier_code` int(11) NOT NULL,
   `seg_nbr` varchar(60) NOT NULL,
`flight_number` varchar(60) NOT NULL,
`dep_date`  int(11) NOT NULL,
`class` varchar(60) NOT NULL,
`from_city` int(11) NOT NULL,
`to_city` int(11) NOT NULL,
`pax_contact_email` varchar(60) NOT NULL,
`phone` varchar(60) NOT NULL,
  `booking_country` int(11) NOT NULL,
  `booking_city` int(11) NOT NULL,
  `office_id` varchar(60) NOT NULL,
  `channel` varchar(60) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `create_userID` int(11) NOT NULL,
  `modify_userID` int(11) NOT NULL,
  `create_date` int(11) NOT NULL,
  `modify_date` int(11) NOT NULL,
  PRIMARY KEY (`dtpf_id`),
     KEY `pnr_ref_indx` (`pnr_ref`),
  KEY `pax_nbr_indx` (`pax_nbr`),
  KEY `first_name_indx` (`first_name`),
   KEY `last_name_indx` (`last_name`),
  KEY `ptc_indx` (`ptc`),
  KEY `fqtv_indx` (`fqtv`),
  KEY `carrier_code_indx` (`carrier_code`),
  KEY `seg_nbr_indx` (`seg_nbr`),
  KEY `flight_number_indx` (`flight_number`),
   KEY `dep_date_indx` (`dep_date`),
 KEY `class_indx` (`class`),
  KEY `from_city_indx` (`from_city`),
  KEY `to_city_indx` (`to_city`),
  KEY `pax_contact_email_indx` (`pax_contact_email`),
  KEY `phone_indx` (`phone`),
KEY `booking_country_indx` (`booking_country`),
  KEY `booking_city_indx` (`booking_city`),
    KEY `channel_indx` (`channel`),
  KEY `office_id_indx` (`office_id`),
  KEY `active_indx` (`active`),
  KEY `createuser_indx` (`create_userID`),
  KEY `modifyuser_indx` (`modify_userID`),
  KEY `createdate_indx` (`create_date`),
  KEY `modifydate_indx` (`modify_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



insert into menu (menuName,link,icon,status,parentID,priority) values ('paxfeed','paxfeed','icon-template','1','0','1000');
insert into permissions set description='Paxfeed',name='paxfeed';
insert into permissions set description='Paxfeed Edit',name='paxfeed_edit';
insert into permissions set description='Paxfeed Delete',name='paxfeed_delete';
insert into permissions set description='Paxfeed Upload',name='paxfeed_upload';

