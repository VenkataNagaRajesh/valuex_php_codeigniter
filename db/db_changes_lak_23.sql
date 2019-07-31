CREATE TABLE `VX_aln_airline` (
  `VX_aln_airlineID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `airlineID` int(11) NOT NULL,
  `logo` varchar(200) NOT NULL,
  `video_links` varchar(200) NOT NULL,
  `create_date` int(11) NOT NULL,
  `modify_date` int(11) NOT NULL,
  `create_userID` int(11) NOT NULL,
  `modify_userID` int(11) NOT NULL,
  PRIMARY KEY (`VX_aln_airlineID`)
);