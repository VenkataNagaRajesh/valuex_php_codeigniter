CREATE TABLE `VX_order` (
  `orderID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`orderID`)
);

alter table UP_bid add column productID tinyint(1) NOT NULL;
alter table UP_bid add column orderID int(11) NOT NULL;
alter table VX_card_data add column orderID int(11) NOT NULL;

alter table UP_bid_history add column orderID int(11) NOT NULL;
alter table UP_bid_history add column productID int(11) NOT NULL;

CREATE TABLE `BG_baggage` (
  `baggageID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `offer_id` int(11) NOT NULL,
  `bclr_id` int(11) NOT NULL,
  `orderID` int(11) NOT NULL,
  `weight` int(11) DEFAULT NULL,
  `baggage_value` int(11) NOT NULL,
  `miles` int(11) NOT NULL,
  `cash` int(11) NOT NULL,
  `cash_percentage` decimal(10,2) NOT NULL,
  `productID` int(11) NOT NULL,
  `submit_date` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`baggageID`)
);

CREATE TABLE `BG_baggage_history` (
  `baggage_historyID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `baggageID` int(11) NOT NULL,
  `offer_id` int(11) NOT NULL,
  `bclr_id` int(11) NOT NULL,
  `orderID` int(11) NOT NULL,
  `weight` int(11) DEFAULT NULL,
  `baggage_value` int(11) NOT NULL,
  `miles` int(11) NOT NULL,
  `cash` int(11) NOT NULL,
  `cash_percentage` decimal(10,2) NOT NULL,
  `productID` int(11) NOT NULL,
  `submit_date` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`baggage_historyID`)
);