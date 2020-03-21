CREATE TABLE `BG_cwt` (
  `cwt_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `bclr_id` int(11) NOT NULL,
  `name` varchar(60) DEFAULT NULL,
  `cum_wt` int(11) NOT NULL,
  `price_per_kg` decimal(10,2) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `create_date` int(11) NOT NULL,
  `create_userID` int(11) NOT NULL,
  PRIMARY KEY (`cwt_id`)
);