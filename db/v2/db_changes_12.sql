CREATE TABLE `VX_reportdata` (
  `dataID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `carrier` int(11) NOT NULL,  
  `type` tinyint(2) NOT NULL,  
  `month` tinyint(2) NOT NULL,  
  `year` int(11) NOT NULL,  
  `from_cabin` int(11) NOT NULL,  
  `to_cabin` int(11) NOT NULL,  
  `passenger_count` int(11) NOT NULL,  
  `accept_revenue` int(11) NOT NULL,  
  `reject_revenue` int(11) NOT NULL,  
  `create_date` int(11) NOT NULL,
  `modify_date` int(11) NOT NULL,  
  PRIMARY KEY (`dataID`)
);