CREATE TABLE `VX_aln_fare_control_range` (
  `fclr_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `carrier_code` int(11) NOT NULL,
  `flight_number` varchar(50) NOT NULL,
  `departure_date` int(11) unsigned NOT NULL,
  `boarding_point` int(11) NOT NULL,
  `off_point` int(11) NOT NULL,
   `season_id` int(11) NOT NULL,
    `frequency` int(11) NOT NULL,
  `from_cabin` varchar(50) NOT NULL,
   `to_cabin` varchar(50) NOT NULL,
  `min` varchar(50) NOT NULL,
  `max` varchar(50) NOT NULL,
  `average` varchar(50) NOT NULL,
`slider_start` varchar(50) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `create_userID` int(11) unsigned NOT NULL,
  `modify_userID` int(11) unsigned NOT NULL,
  `create_date` int(11) unsigned NOT NULL,
  `modify_date` int(11) unsigned NOT NULL,
  PRIMARY KEY (`fclr_id`),
  KEY `carrier_code_indx` (`carrier_code`),
  KEY `flight_number_indx` (`flight_number`),
  KEY `departure_date_indx` (`departure_date`),
  KEY `boarding_point_indx` (`boarding_point`),
  KEY `off_point_indx` (`off_point`),
  KEY `season_id_indx` (`season_id`),
  KEY `from_cabin_indx` (`from_cabin`),
  KEY `to_cabin_indx` (`to_cabin`),
  KEY `min_indx` (`min`),
  KEY `max_indx` (`max`),
  KEY `average_indx` (`average`),
  KEY `active_indx` (`active`),
  KEY `createuser_indx` (`create_userID`),
  KEY `modifyuser_indx` (`modify_userID`),
  KEY `createdate_indx` (`create_date`),
  KEY `modifydate_indx` (`modify_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ;


