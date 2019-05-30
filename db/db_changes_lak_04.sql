CREATE TABLE `VX_aln_daily_inv_feed` (
  `invfeedID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `airline_code` char(3) NOT NULL,
  `flight_no` varchar(50) NOT NULL,
  `dept_date` int(11) unsigned NOT NULL,
  `origin` varchar(50) NOT NULL,
  `destination` varchar(50) NOT NULL,
  `cabin` int(11) NOT NULL,
  `empty_seats` int(11) NOT NULL,
  `sold_seats` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `create_userID` int(11) unsigned NOT NULL,
  `modify_userID` int(11) unsigned NOT NULL,
  `create_date` int(11) unsigned NOT NULL,
  `modify_date` int(11) unsigned NOT NULL,
  PRIMARY KEY (`invfeedID`),  
  KEY `airline_code_indx` (`airline_code`),
  KEY `flight_no_indx` (`flight_no`),
  KEY `dept_date_indx` (`dept_date`),
  KEY `origin_indx` (`origin`),
  KEY `destination_indx` (`destination`),
  KEY `cabin_indx` (`cabin`),
  KEY `empty_seats_indx` (`empty_seats`),
  KEY `sold_seats_indx` (`sold_seats`),
  KEY `active_indx` (`active`),
  KEY `createuser_indx` (`create_userID`),
  KEY `modifyuser_indx` (`modify_userID`),
  KEY `createdate_indx` (`create_date`),
  KEY `modifydate_indx` (`modify_date`)
);


CREATE TABLE `VX_daily_inv_feed_ext` (
  `invfeedextID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `airlineID` int(11) unsigned NOT NULL,
  `flightID` int(11) unsigned NOT NULL,
  `dept_date` int(11) unsigned NOT NULL,
  `originID` int(11) unsigned NOT NULL,
  `destinationID` int(11) unsigned NOT NULL,
  `cabinID` int(11) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `create_userID` int(11) unsigned NOT NULL,
  `modify_userID` int(11) unsigned NOT NULL,
  `create_date` int(11) unsigned NOT NULL,
  `modify_date` int(11) unsigned NOT NULL,
  PRIMARY KEY (`invfeedextID`),  
  KEY `airline_indx` (`airlineID`),
  KEY `flight_indx` (`flightID`),
  KEY `dept_date_indx` (`dept_date`),
  KEY `origin_indx` (`originID`),
  KEY `destination_indx` (`destinationID`),
  KEY `cabin_indx` (`cabinID`),
  KEY `active_indx` (`active`),
  KEY `createuser_indx` (`create_userID`),
  KEY `modifyuser_indx` (`modify_userID`),
  KEY `createdate_indx` (`create_date`),
  KEY `modifydate_indx` (`modify_date`)
);


CREATE TABLE `VX_aln_fclr` (
  `fclrID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `airline_code` char(3) NOT NULL,
  `flight_no` varchar(50) NOT NULL,
  `dept_date` int(11) unsigned NOT NULL,
  `origin` varchar(50) NOT NULL,
  `destination` varchar(50) NOT NULL,
  `cabin` int(11) NOT NULL,
  `empty_seats` int(11) NOT NULL,
  `sold_seats` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `create_userID` int(11) unsigned NOT NULL,
  `modify_userID` int(11) unsigned NOT NULL,
  `create_date` int(11) unsigned NOT NULL,
  `modify_date` int(11) unsigned NOT NULL,
  PRIMARY KEY (`fclrID`),  
  KEY `airline_code_indx` (`airline_code`),
  KEY `flight_no_indx` (`flight_no`),
  KEY `dept_date_indx` (`dept_date`),
  KEY `origin_indx` (`origin`),
  KEY `destination_indx` (`destination`),
  KEY `cabin_indx` (`cabin`),
  KEY `empty_seats_indx` (`empty_seats`),
  KEY `sold_seats_indx` (`sold_seats`),  
  KEY `active_indx` (`active`),
  KEY `createuser_indx` (`create_userID`),
  KEY `modifyuser_indx` (`modify_userID`),
  KEY `createdate_indx` (`create_date`),
  KEY `modifydate_indx` (`modify_date`)
);


CREATE TABLE `VX_dtpf_ext` (
  `dtpfextID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `dtpfID` int(11) unsigned NOT NULL,
  `airlineID` int(11) unsigned NOT NULL,
  `booking_status` int(11) unsigned NOT NULL,
  `classID` int(11) unsigned NOT NULL,
  `from_airportID` int(11) unsigned NOT NULL,
  `to_airportID` int(11) unsigned NOT NULL,
  `depature_date` int(11) unsigned NOT NULL,
  `fclrID` int(11) unsigned NOT NULL,
  `min` decimal(6,2) NOT NULL,
  `slider_start` decimal(6,2) NOT NULL,
  `max` decimal(6,2) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `create_userID` int(11) unsigned NOT NULL,
  `modify_userID` int(11) unsigned NOT NULL,
  `create_date` int(11) unsigned NOT NULL,
  `modify_date` int(11) unsigned NOT NULL,
  PRIMARY KEY (`dtpfextID`),  
  KEY `dtpf_indx` (`dtpfID`),
  KEY `airline_indx` (`airlineID`),
  KEY `booking_status_indx` (`booking_status`),
  KEY `class_indx` (`classID`),
  KEY `from_airport_indx` (`from_airportID`),
  KEY `to_airport_indx` (`to_airportID`),
  KEY `depature_date_indx` (`depature_date`),
  KEY `fclr_indx` (`fclrID`),
  KEY `min_indx` (`min`),
  KEY `slider_start_indx` (`slider_start`),
  KEY `max_indx` (`max`),  
  KEY `active_indx` (`active`),
  KEY `createuser_indx` (`create_userID`),
  KEY `modifyuser_indx` (`modify_userID`),
  KEY `createdate_indx` (`create_date`),
  KEY `modifydate_indx` (`modify_date`)
);

 CREATE TABLE `VX_event_status` (
  `esID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `current_status` int(11) NOT NULL,
  `next_status` int(11) NOT NULL,
  `eventID` int(11) unsigned NOT NULL,
  `isInternalStatus` tinyint(1) NOT NULL,
  `create_userID` int(11) unsigned NOT NULL,
  `modify_userID` int(11) unsigned NOT NULL, 
  `create_date` int(11) unsigned NOT NULL,
  `modify_date` int(11) unsigned NOT NULL,
  PRIMARY KEY (`esID`),
  KEY `current_status_indx` (`current_status`),
  KEY `next_status_indx` (`next_status`),
  KEY `event_indx` (`eventID`),  
  KEY `isInternalStatus_indx` (`isInternalStatus`),
  KEY `createuser_indx` (`create_userID`),
  KEY `modifyuser_indx` (`modify_userID`),
  KEY `createdate_indx` (`create_date`),
  KEY `modifydate_indx` (`modify_date`)
);


 CREATE TABLE `VX_dtpf_tracker` (
  `dtpf_trackerID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `dtpfID` int(11) unsigned NOT NULL,
  `comment` text DEFAULT NULL,
  `booking_status_from` int(11) unsigned NOT NULL,
  `booking_status_to` int(1) unsigned NOT NULL,
  `modified_by` int(11) unsigned NOT NULL,
  `modify_date` int(11) unsigned NOT NULL,
  PRIMARY KEY (`dtpf_trackerID`),
  KEY `dtpf_indx` (`dtpfID`),
  KEY `booking_status_from_indx` (`booking_status_from`),  
  KEY `booking_status_to_indx` (`booking_status_to`),
  KEY `modifiedby_indx` (`modified_by`),  
  KEY `modifydate_indx` (`modify_date`)
);


CREATE TABLE `VX_feedback_messages_status` (
  `fbmsgsID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fbmsgID` int(11) unsigned NOT NULL,
  `social_medial_channelID` int(11) NOT NULL,
  `msg_send_status` int(11) NOT NULL,  
  PRIMARY KEY (`fbmsgsID`),
  KEY `fbmsg_indx` (`fbmsgID`),
  KEY `social_medial_channel_indx` (`social_medial_channelID`),  
  KEY `msg_send_status_indx` (`msg_send_status`)
);

CREATE TABLE `VX_feedback_messages` (
  `fbmsgID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customerID` int(11) unsigned NOT NULL,
  `message` text NOT NULL,
  `status` tinyint(1) NOT NULL,  
  PRIMARY KEY (`fbmsgID`),
  KEY `customer_indx` (`customerID`),
  KEY `status_indx` (`status`)  
);

CREATE TABLE `VX_customer_payment_cards` (
  `cardID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customerID` int(11) unsigned NOT NULL,
  `card_type` varchar(50) NOT NULL,
  `cc_nbr` int(11) NOT NULL,
  `cc_expiry_date` int(11) unsigned NOT NULL,
  `cvs_nbr` int(11) NOT NULL, 
  `isdefault` tinyint(1) NOT NULL,  
  PRIMARY KEY (`cardID`),
  KEY `customer_indx` (`customerID`) 
);
