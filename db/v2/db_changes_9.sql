 CREATE TABLE `VX_user_product` (
  `user_productID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `create_date` int(11) NOT NULL,
  `modify_date` int(11) NOT NULL,
  `create_userID` int(11) NOT NULL,
  `modify_userID` int(11) NOT NULL,
  PRIMARY KEY (`user_productID`)
);

alter table VX_role add column usertypeID tinyint(1) NOT NULL DEFAULT 1;

alter table vx_contract add column create_client int(11) NOT NULL;