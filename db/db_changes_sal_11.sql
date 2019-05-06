CREATE TABLE `VX_aln_airline_cabin_class` (
  `map_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `carrier` int(11) NOT NULL,
  `airline_class` varchar(60) NOT NULL,
  `airline_cabin` int(11) NOT NULL,
  `is_revenue` tinyint(1) NOT NULL DEFAULT '1',
   `order` int(11) NOT NULL,
  `create_date` int(11) NOT NULL,
  `modify_date` int(11) NOT NULL,
  `create_userID` int(11) NOT NULL,
  `modify_userID` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
    PRIMARY KEY (`map_id`),
  KEY `carrier_index` (`carrier`),
  KEY `is_revenue_index` (`is_revenue`),
KEY `order_index` (`order`),
  KEY `airline_class_index` (`airline_class`),
  KEY `airline_cabin_index` (`airline_cabin`),
  KEY `modify_date_index` (`modify_date`),
  KEY `create_date_index` (`create_date`),
  KEY `create_userID_index` (`create_userID`),
  KEY `modify_userID_index` (`modify_userID`),
  KEY `active_index` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into menu (menuName,link,icon,status,parentID,priority) values ('airline_cabin_class','airline_cabin_class','icon-template','1','0','1000');
insert into permissions (description,name,active) values ('Airline Cabins Class Map','airline_cabin_class','yes');

insert into permissions (description,name,active) values ('Airline Cabins Class Map Add','airline_cabin_class_add','yes');
insert into permissions (description,name,active) values ('Airline Cabins Class Map Delete','airline_cabin_class_delete','yes');
insert into permissions (description,name,active) values ('Airline Cabins Class  Map View','airline_cabin_class_view','yes');
insert into permissions (description,name,active) values ('Airline Cabins Class  Map Edit','airline_cabin_class_edit','yes');
