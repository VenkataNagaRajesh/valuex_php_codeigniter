
CREATE TABLE `vx_airline_product` (
  `airline_productID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `productID` int(11) NOT NULL,
  `airlineID` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `create_date` int(11) NOT NULL,
  `modify_date` int(11) NOT NULL,
  `create_userID` int(11) NOT NULL,
  `modify_userID` int(11) NOT NULL,
  PRIMARY KEY (`airline_productID`)
);
insert into VX_permissions set description='Airline Product',name='airline_product';
insert into VX_permissions set description='Airline Product Add',name='airline_product_add';
insert into VX_permissions set description='Airline Product Edit',name='airline_product_edit';
insert into VX_permissions set description='Airline Product Delete',name='airline_product_delete';
insert into VX_permissions set description='Airline Product View',name='airline_product_view';