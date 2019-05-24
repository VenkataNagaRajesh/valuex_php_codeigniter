
insert into menu (menuName,link,icon,status,parentID,priority) values ('offer_eligibility','offer_eligibility','fa-sun-o','1','0','1000');

insert into permissions (description,name,active) values ('Offer Eligibility','offer_eligibility','yes');



CREATE TABLE `VX_aln_dtpf_ext` (
  `dtpfext_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `dtpf_id` int(11) NOT NULL,
  `fclr_id` int(11) NOT NULL,
  `booking_status` int(11) NOT NULL,
  `exclusion_id` int(11) NOT NULL DEFAULT '0',
   `coupon_code` varchar(128) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `create_userID` int(11) NOT NULL,
  `modify_userID` int(11) NOT NULL,
  `create_date` int(11) NOT NULL,
  `modify_date` int(11) NOT NULL,
  PRIMARY KEY (`dtpfext_id`),
  KEY `dtpf_id_indx` (`dtpf_id`),
  KEY `fclr_id_indx` (`fclr_id`),
   KEY `exclusion_id_indx` (`exclusion_id`),
  KEY `coupon_code_indx` (`coupon_code`),
  KEY `booking_status_indx` (`booking_status`),
  KEY `active_indx` (`active`),
  KEY `createuser_indx` (`create_userID`),
  KEY `modifyuser_indx` (`modify_userID`),
  KEY `createdate_indx` (`create_date`),
  KEY `modifydate_indx` (`modify_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


insert into vx_aln_data_types (name,alias,create_userID,modify_userID,create_date,modify_date) values ('aln_booking_status','Booking Status', '1','1','1554788423','1554788423');


insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,code,create_userID,modify_userID,create_date,modify_date) values ('20','New','New','1','1','1554788423','1554788423');
insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,code,create_userID,modify_userID,create_date,modify_date) values ('20','Excluded','Excl','1','1','1554788423','1554788423');



