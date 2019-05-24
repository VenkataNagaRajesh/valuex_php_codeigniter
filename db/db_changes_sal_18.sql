
CREATE TABLE `VX_aln_daily_tkt_pax_feed_raw` (
  `dtpfraw_id` bigint(16) unsigned NOT NULL AUTO_INCREMENT,
  `airline_code` varchar(3) NOT NULL,
  `pnr_ref` varchar(60) NOT NULL,
  `pax_nbr` varchar(60) NOT NULL,
  `first_name` varchar(60) NOT NULL,
  `last_name` varchar(60) NOT NULL,
  `ptc` varchar(60) NOT NULL,
  `fqtv` varchar(60) NOT NULL,
  `carrier_code` varchar(11) NOT NULL,
  `seg_nbr` varchar(60) NOT NULL,
  `flight_number` varchar(60) NOT NULL,
  `dep_date` varchar(50) NOT NULL,
  `class` varchar(60) NOT NULL,
  `from_city` varchar(50) NOT NULL,
  `to_city` varchar(50) NOT NULL,
  `pax_contact_email` varchar(60) NOT NULL,
  `phone` varchar(60) NOT NULL,
  `booking_country` varchar(50) NOT NULL,
  `booking_city` varchar(11) NOT NULL,
  `office_id` varchar(60) NOT NULL,
  `channel` varchar(60) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `create_userID` int(11) NOT NULL,
  `modify_userID` int(11) NOT NULL,
  `create_date` int(11) NOT NULL,
  `modify_date` int(11) NOT NULL,
  PRIMARY KEY (`dtpfraw_id`),
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



ALTER TABLE VX_aln_daily_tkt_pax_feed ADD COLUMN  dtpfraw_id int(11) NOT NULL AFTER dtpf_id;
ALTER  table VX_aln_eligibility_excl_rules change upgrade_to_class_type upgrade_to_cabin_type int(11) NOT NULL ;
ALTER  table VX_aln_eligibility_excl_rules change upgrade_from_class_type upgrade_from_cabin_type int(11) NOT NULL ;

ALTER TABLE VX_aln_eligibility_excl_rules DROP INDEX upgrade_from_class_type_indx;
ALTER TABLE VX_aln_eligibility_excl_rules DROP INDEX upgrade_to_class_type_indx;
CREATE INDEX upgrade_to_cabin_type_indx ON VX_aln_eligibility_excl_rules(upgrade_to_cabin_type);
CREATE INDEX upgrade_from_cabin_type_indx ON VX_aln_eligibility_excl_rules(upgrade_from_cabin_type);
