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

