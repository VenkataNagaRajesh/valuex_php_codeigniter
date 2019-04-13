CREATE TABLE `vx_aln_data_defns` (
  `vx_aln_data_defnsID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `aln_data_typeID` int(11) NOT NULL,
  `aln_data_value` varchar(60) NOT NULL,
  `parentID` int(11) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `alias` varchar(50) DEFAULT NULL,
  `create_userID` int(11) NOT NULL,  
  `modify_userID` int(11) NOT NULL,  
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `create_date` int(11) NOT NULL,
  `modify_date` int(11) NOT NULL,
  PRIMARY KEY (`vx_aln_data_defnsID`),
  KEY `type_indx` (`aln_data_typeID`),
  KEY `parent_indx` (`parentID`),  
  KEY `code_indx` (`code`),
  KEY `active_indx` (`active`),
  KEY `createdate_indx` (`create_date`),
  KEY `modifydate_indx` (`modify_date`) 
)

CREATE TABLE `vx_aln_master_data` (
  `vx_amdID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `airportID` int(11) NOT NULL,
  `stateID` int(11) NOT NULL,
  `countryID` int(11) NOT NULL,
  `regionID` int(11) NOT NULL,
  `areaID` int(11) NOT NULL,
  `create_userID` int(11) NOT NULL,  
  `modify_userID` int(11) NOT NULL,  
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `create_date` int(11) NOT NULL,
  `modify_date` int(11) NOT NULL,
  PRIMARY KEY (`vx_amdID`),
  KEY `state_indx` (`stateID`),
  KEY `country_indx` (`countryID`),
  KEY `region_indx` (`regionID`),
  KEY `area_indx` (`areaID`),
  KEY `active_indx` (`active`),
  KEY `createdate_indx` (`create_date`),
  KEY `modifydate_indx` (`modify_date`)    
)



