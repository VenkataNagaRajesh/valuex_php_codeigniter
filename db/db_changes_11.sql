CREATE TABLE `VX_aln_daily_inv_feed` (
  `invfeed_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `airline_id` int(11) NOT NULL,
  `flight_nbr`  varchar(60) NOT NULL,
  `departure_date`  int(11) NOT NULL,
 `origin_airport`  int(11)  NOT NULL,
  `dest_airport`  int(11) NOT NULL,
`cabin`  int(11) NOT NULL ,
   `empty_seats`  int(11) NOT NULL ,
`sold_seats`  int(11) NOT NULL ,
 `active` tinyint(1) NOT NULL DEFAULT '1',
  `create_userID` int(11) NOT NULL,
  `modify_userID` int(11) NOT NULL,
  `create_date` int(11) NOT NULL,
  `modify_date` int(11) NOT NULL,
  PRIMARY KEY (`invfeed_id`),
  KEY `airline_id_indx` (`airline_id`),
    KEY `flight_nbr_indx` (`flight_nbr`),
  KEY `departure_date_indx` (`departure_date`),
  KEY `origin_airport_indx` (`origin_airport`),
  KEY `dest_airport_indx` (`dest_airport`),
  KEY `cabin_indx` (`cabin`),
  KEY `empty_seats_indx` (`empty_seats`),
  KEY `sold_seats_indx` (`sold_seats`),
  KEY `active_indx` (`active`),
  KEY `createuser_indx` (`create_userID`),
  KEY `modifyuser_indx` (`modify_userID`),
  KEY `createdate_indx` (`create_date`),
  KEY `modifydate_indx` (`modify_date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


insert into menu (menuName,link,icon,status,parentID,priority) values ('invfeed','invfeed','icon-template','1','0','1000');
insert into permissions set description='Invfeed',name='invfeed';
insert into permissions set description='Invfeed Edit',name='invfeed_edit';
insert into permissions set description='Invfeed Delete',name='invfeed_delete';
insert into permissions set description='Invfeed Upload',name='invfeed_upload';
