CREATE TABLE `VX_role` (
  `roleID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `create_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL,
  `create_userID` int(11) NOT NULL,  
  PRIMARY KEY (`roleID`)
);

insert into VX_role set name='valuex';
insert into VX_role set name='client';

CREATE TABLE `VX_products` (
  `productID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `create_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL,
  `create_userID` int(11) NOT NULL,
  PRIMARY KEY (`productID`)
);

insert into VX_products set name='Upgrade';
insert into VX_products set name='Baggage';

alter table VX_user add column domain varchar(150) DEFAULT NULL;

insert into VX_role (name,create_date,modify_date,create_userID) select usertype,create_date,modify_date,create_userID from VX_usertype;

ALTER TABLE `VX_role` CHANGE `name` `role` VARCHAR(60);

ALTER TABLE  `VX_mailandsms` CHANGE `usertypeID` `roleID` int(11) NOT NULL;

ALTER TABLE  `vx_mailandsmstemplatetag` CHANGE `usertypeID` `roleID` int(11) NOT NULL;

ALTER TABLE  `VX_user` CHANGE `usertypeID` `roleID` int(11) NOT NULL;

ALTER TABLE  `VX_loginlog` CHANGE `usertypeID` `roleID` int(11) NOT NULL;

ALTER TABLE  `VX_permission_relationships` CHANGE `usertype_id` 'roleID' int(11) NOT NULL;
