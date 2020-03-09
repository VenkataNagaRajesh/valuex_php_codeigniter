insert into VX_permissions set description='Partner',name='partner';
insert into VX_permissions set description='Partner Add',name='partner_add';
insert into VX_permissions set description='Partner Edit',name='partner_edit';
insert into VX_permissions set description='Partner Delete',name='partner_delete';
insert into VX_permissions set description='Partner View',name='partner_view';

CREATE TABLE `VX_partner` (
  `partnerID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `carrierID` int(11) NOT NULL,
  `partner_carrierID` int(11) NOT NULL,  
  `origin_level` int(11) NOT NULL,  
  `origin_content`  varchar(250) NOT NULL,  
  `dest_level` int(11) NOT NULL,  
  `dest_content`  varchar(250) NOT NULL,  
  `start_date` int(11) NOT NULL,
  `end_date` int(11) NOT NULL,
  `create_date` int(11) NOT NULL,
  `modify_date` int(11) NOT NULL,
  `create_userID` int(11) NOT NULL,
  `modify_userID` int(11) NOT NULL,
   PRIMARY KEY (`partnerID`)
);
