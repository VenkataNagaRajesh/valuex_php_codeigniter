CREATE TABLE `VX_airline_aircraft` (
  `airline_aircraftID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `airlineID` int(11) NOT NULL,
  `aircraftID` int(11) NOT NULL,
  `create_date` int(11) NOT NULL,
  `modify_date` int(11) NOT NULL,
  `create_userID` int(11) NOT NULL,
  `modify_userID` int(11) NOT NULL,
  PRIMARY KEY (`airline_aircraftID`)
);