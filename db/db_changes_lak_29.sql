 CREATE TABLE `VX_aln_feedback` (
  `feedbackID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pnr_ref` char(10) DEFAULT NULL, 
  `overall_experience` varchar(30) DEFAULT NULL,
  `time_response` varchar(30) DEFAULT NULL,
  `our_support` varchar(30) DEFAULT NULL,
  `overall_satisfaction` varchar(30) DEFAULT NULL,
  `customer_service` tinyint(1) NOT NULL DEFAULT '0',
  `message` text DEFAULT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`feedbackID`)  
);
insert into permissions set name='feedback',description='Feedback';