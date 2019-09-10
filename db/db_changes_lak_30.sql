CREATE TABLE `vx_aln_bid_history` (
  `bid_history_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `bid_id` int(11) NOT NULL,
  `offer_id` int(11) NOT NULL,
  `flight_number` int(11) NOT NULL,
  `upgrade_type` int(11) NOT NULL,
  `bid_value` int(11) NOT NULL DEFAULT '0',
  `bid_markup_val` int(11) NOT NULL DEFAULT '0',
  `bid_avg` int(11) NOT NULL DEFAULT '0',
  `rank` int(11) NOT NULL DEFAULT '0',
  `bid_submit_date` int(11) NOT NULL DEFAULT '0',
  `fclr_id` int(11) NOT NULL,
  `cash` int(11) DEFAULT NULL,
  `miles` int(11) DEFAULT NULL,
  `cash_percentage` decimal(10,2) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `date` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`bid_history_id`),
  KEY `offer_id_indx` (`offer_id`),
  KEY `bid_id_indx` (`bid_id`),
  KEY `flight_number_indx` (`flight_number`),
  KEY `bid_value_indx` (`bid_value`),
  KEY `bid_submit_date_indx` (`bid_submit_date`),
  KEY `upgrade_type_indx` (`upgrade_type`)
 );
 
 alter table VX_aln_dtpf_tracker modify column create_userID int(11) DEFAULT NULL;
 alter table VX_aln_dtpf_tracker modify column modify_userID int(11) DEFAULT NULL;
 
 insert into mailandsmscategory set name="Bid Resubmit",alias='bid_resubmit';
 insert into mailandsmscategory set name="Bid Cancel",alias='bid_cancel';