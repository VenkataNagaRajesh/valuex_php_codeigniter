 CREATE TABLE `VX_client_product` (
  `client_productID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `clientID` int(11) NOT NULL, 
  `productID` int(11) NOT NULL,
  `create_date` int(11) NOT NULL,  
  `modify_date` int(11) NOT NULL,
  `create_userID` int(11) NOT NULL,
  `modify_userID` int(11) NOT NULL,
  PRIMARY KEY (`client_productID`)
);

update VX_permissions set description = REPLACE(description,'Role','Usertype') where name like 'usertype%';



DROP table VX_module;

alter table VX_permissions add column productID int(11) NOT NULL DEFAULT 0;
update VX_permissions set productID = 0 where moduleID = 1;
update VX_permissions set productID = 1 where moduleID = 2;
update VX_permissions set productID = 2 where moduleID = 3;
alter table VX_permissions DROP COLUMN moduleID;

alter table VX_contract drop column start_date;
alter table VX_contract drop column end_date;
alter table VX_contract_products add column start_date datetime NOT NULL after productID;
alter table VX_contract_products add column end_date datetime NOT NULL after start_date;
alter table VX_contract_products add column no_users int(11) NOT NULL after end_date;
alter table VX_contract_products add column modify_date int(11) NOT NULL after create_date;
alter table VX_contract_products add column modify_userID int(11) NOT NULL after create_userID;
