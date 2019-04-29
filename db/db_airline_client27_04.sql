CREATE TABLE `VX_aln_client` (
  `VX_aln_clientID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` tinytext,
  `address` text,
  `airlineID` int(11) NOT NULL,
  `photo` varchar(200) DEFAULT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(128) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `create_date` int(11) NOT NULL,
  `modify_date` int(11) NOT NULL,
  `create_userID` int(11) NOT NULL,
  `modify_userID` int(11) NOT NULL,  
  PRIMARY KEY (`VX_aln_clientID`)
);

CREATE TABLE `VX_aln_airline` (
  `VX_aln_airlineID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `airlineID` int(11) NOT NULL,
  `flights` text DEFAULT NULL,
  `create_userID` int(11) NOT NULL,
  `modify_userID` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `create_date` int(11) NOT NULL,
  `modify_date` int(11) NOT NULL,
  PRIMARY KEY (`VX_aln_airlineID`),
  KEY `active_indx` (`active`),
  KEY `createdate_indx` (`create_date`),
  KEY `modifydate_indx` (`modify_date`),
  KEY `createuser_indx` (`create_userID`),
  KEY `modifyuser_indx` (`modify_userID`)
);

alter table user modify column dob date DEFAULT NULL;
alter table user modify column sex varchar(10) DEFAULT NULL;
alter table user modify column jod date DEFAULT NULL;

insert into vx_aln_data_types set name='Airline',create_userID=1,modify_userID=1,active=1,create_date=1554788423,modify_date=1554788423;

insert into menu (menuName,link,icon,status,parentID,priority) values ('Airline Client','client','fa-users','1','0','1000');
insert into permissions (description,name,active) values ('Airline Client','client','yes');
insert into permissions (description,name,active) values ('Airline Client Add','client_add','yes');
insert into permissions (description,name,active) values ('Airline Client Edit','client_edit','yes');
insert into permissions (description,name,active) values ('Airline Client Delete','client_delete','yes');
insert into permissions (description,name,active) values ('Airline Client View','client_view','yes');

insert into menu (menuName,link,icon,status,parentID,priority) values ('Airline','airline','fa-plane','1','0','1000');
insert into permissions (description,name,active) values ('Airline ','airline','yes');
insert into permissions (description,name,active) values ('Airline Add','airline_add','yes');
insert into permissions (description,name,active) values ('Airline Edit','airline_edit','yes');
insert into permissions (description,name,active) values ('Airline Delete','airline_delete','yes');
insert into permissions (description,name,active) values ('Airline View','airline_view','yes');
insert into permissions (description,name,active) values ('Airline Upload','airline_upload','yes');