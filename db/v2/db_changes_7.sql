 DROP TABLE VX_airline_product;
 
 CREATE TABLE `VX_contract` (
  `contractID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,  
  `airlineID` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `create_date` int(11) NOT NULL,
  `modify_date` int(11) NOT NULL,
  `create_userID` int(11) NOT NULL,
  `modify_userID` int(11) NOT NULL,
  PRIMARY KEY (`contractID`)
);


 CREATE TABLE `VX_contract_products` (
  `contract_productID` int(11) unsigned NOT NULL AUTO_INCREMENT, 
  `contractID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `create_date` int(11) NOT NULL,  
  `create_userID` int(11) NOT NULL, 
  PRIMARY KEY (`contract_productID`)
);