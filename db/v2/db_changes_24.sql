alter table VX_contract_products add column status tinyint(1)  NOT NULL DEFAULT '1' after no_users;
CREATE TABLE `VX_contract_file` (
  `contract_fileID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `contractID` int(11) NOT NULL,
  `file_name` varchar(60) NOT NULL,
  `create_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL,
  `create_userID` int(11) NOT NULL,
  `active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`contract_fileID`)
);
CREATE TABLE `VX_contract_filelog` (
  `contract_filelogID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `contract_fileID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `activity` varchar(250) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`contract_filelogID`)
);

alter table VX_contract add column poc_user int(11) NOT NULL after mobile_number;
insert into VX_permissions set description='Contract Document View',name='contract_docview',productID=1;