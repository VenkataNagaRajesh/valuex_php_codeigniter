CREATE TABLE `VX_aln_bid` (
  `bid_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `offer_id` int(11) NOT NULL,
  `flight_number` int(11) NOT NULL ,
  `upgrade_type` int(11) NOT NULL ,
  `bid_value` int(11) NOT NULL DEFAULT '0',
  `cash` int(11) NOT NULL DEFAULT '0',
  `miles` int(11) NOT NULL DEFAULT '0',
  `bid_submit_date` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `create_userID` int(11) NOT NULL,
  `modify_userID` int(11) NOT NULL,
  `create_date` int(11) NOT NULL,
  `modify_date` int(11) NOT NULL,
  PRIMARY KEY (`bid_id`),
  KEY `offer_id_indx` (`offer_id`),
  KEY `flight_number_indx` (`flight_number`),
  KEY `bid_value_indx` (`bid_value`),
  KEY `cash_indx` (`cash`),
  KEY `miles_indx` (`miles`),
  KEY `bid_submit_date_indx` (`bid_submit_date`),
  KEY `upgrade_type_indx` (`upgrade_type`),
  KEY `active_indx` (`active`),
  KEY `createuser_indx` (`create_userID`),
  KEY `modifyuser_indx` (`modify_userID`),
  KEY `createdate_indx` (`create_date`),
  KEY `modifydate_indx` (`modify_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;



 ALTER TABLE VX_aln_offer_ref DROP COLUMN bid_value;

 ALTER TABLE VX_aln_offer_ref DROP COLUMN cash;
 ALTER TABLE VX_aln_offer_ref DROP COLUMN miles;
ALTER TABLE VX_aln_offer_ref DROP COLUMN bid_submit_date;

DROP TABLE VX_daily_inv_feed_ext;
DROP TABLE VX_aln_fclr;
DROP TABLE VX_dtpf_ext;
DROP TABLE VX_dtpf_tracker;

DROP TABLE VX_event_status;



