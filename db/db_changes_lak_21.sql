CREATE TABLE `VX_client_airline` (
  `client_airlineID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `clientID` int(11) NOT NULL,
  `airlineID` int(11) NOT NULL,
  `create_date` int(11) NOT NULL,
  `modify_date` int(11) NOT NULL,
  `create_userID` int(11) NOT NULL,  
  `modify_userID` int(11) NOT NULL,   
  PRIMARY KEY (`client_airlineID`)
);
alter table VX_aln_client add column mail_logo varchar(200) NOT NULL;
alter table VX_aln_client drop column airlineID;