CREATE TABLE `VX_user_airline` (
  `user_airlineID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `airlineID` int(11) NOT NULL,
  `create_date` int(11) NOT NULL,
  `modify_date` int(11) NOT NULL,
  `create_userID` int(11) NOT NULL,
  `modify_userID` int(11) NOT NULL,
  PRIMARY KEY (`user_airlineID`)
)