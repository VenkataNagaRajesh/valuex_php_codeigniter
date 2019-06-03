CREATE TABLE `VX_aln_offer_ref` (
  `offer_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pnr_ref` varchar(60) NOT NULL,
  `coupon_code` varchar(128) NOT NULL DEFAULT 0,
  `bid_value`  int(11) NOT NULL DEFAULT 0,
  `offer_status`  int(11) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `create_userID` int(11) NOT NULL,
  `modify_userID` int(11) NOT NULL,
  `create_date` int(11) NOT NULL,
  `modify_date` int(11) NOT NULL,
  PRIMARY KEY (`offer_id`),
  KEY `offer_ref_indx` (`pnr_ref`),
   KEY `coupon_code_indx` (`coupon_code`),
  KEY `bid_value_indx` (`bid_value`),
 KEY `offer_status_indx` (`offer_status`),
  KEY `active_indx` (`active`),
  KEY `createuser_indx` (`create_userID`),
  KEY `modifyuser_indx` (`modify_userID`),
  KEY `createdate_indx` (`create_date`),
  KEY `modifydate_indx` (`modify_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;

 ALTER TABLE VX_aln_dtpf_ext DROP COLUMN coupon_code;
