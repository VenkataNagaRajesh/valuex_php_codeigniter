CREATE TABLE `mailandsmstemplate` (
  `mailandsmstemplateID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `usertypeID` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `template` text NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`mailandsmstemplateID`)
);

CREATE TABLE `mailandsms` (
  `mailandsmsID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `usertypeID` int(11) unsigned NOT NULL,
  `userID` int(11) NOT NULL,
  `users` text NOT NULL,
  `type` varchar(10) NOT NULL,
  `senderusertypeID` int(11) NOT NULL,
  `senderID` int(11) NOT NULL,
  `message` text NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `year` year(4) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`mailandsmsID`)
);

 CREATE TABLE `mailandsmstemplatetag` (
  `mailandsmstemplatetagID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `usertypeID` int(11) NOT NULL,
  `tagname` varchar(128) NOT NULL,
  `mailandsmstemplatetag_extra` varchar(255) DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`mailandsmstemplatetagID`)
);