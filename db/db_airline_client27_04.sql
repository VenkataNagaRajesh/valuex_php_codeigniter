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

alter table user modify column dob date DEFAULT NULL;
alter table user modify column sex varchar(10) DEFAULT NULL;
alter table user modify column jod date DEFAULT NULL;

insert into menu (menuName,link,icon,status,parentID,priority) values ('Airline Client','client','fa-users','1','0','1000');
insert into permissions (description,name,active) values ('Airline Client','client','yes');
insert into permissions (description,name,active) values ('Airline Client Add','client_add','yes');
insert into permissions (description,name,active) values ('Airline Client Edit','client_edit','yes');
insert into permissions (description,name,active) values ('Airline Client Delete','client_delete','yes');
insert into permissions (description,name,active) values ('Airline Client View','client_view','yes');