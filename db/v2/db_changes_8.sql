 CREATE TABLE `VX_client_product` (
  `client_productID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `clientID` int(11) NOT NULL,
  `contractID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `create_date` int(11) NOT NULL,
  `create_userID` int(11) NOT NULL,
  PRIMARY KEY (`client_productID`)
);

update VX_permissions set description = REPLACE(description,'Role','Usertype') where name like 'usertype%';

insert into VX_permissions set description='client product Add',name='client_add_product';
insert into VX_permissions set description='client product Delete',name='client_delete_product';