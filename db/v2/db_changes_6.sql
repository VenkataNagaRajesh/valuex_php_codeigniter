CREATE TABLE `VX_module` (
  `moduleID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module_name` varchar(60) DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL,
  `create_userID` int(11) NOT NULL,
  PRIMARY KEY (`moduleID`)
);

insert into VX_module set module_name='General',create_userID=1,create_date='2020-02-05 11:39:05',modify_date='2020-02-05 11:39:05';
insert into VX_module set module_name='Valuex',create_userID=1,create_date='2020-02-05 11:39:05',modify_date='2020-02-05 11:39:05';
insert into VX_module set module_name='Upgrade',create_userID=1,create_date='2020-02-05 11:39:05',modify_date='2020-02-05 11:39:05';
insert into VX_module set module_name='Baggage',create_userID=1,create_date='2020-02-05 11:39:05',modify_date='2020-02-05 11:39:05';

alter table VX_permissions add column moduleID int(11) NOT NULL DEFAULT 1 after permissionID;

update VX_permissions set moduleID = 1 where permissionID <=800;
update VX_permissions set moduleID = 2 where permissionID > 800;
update VX_permissions set moduleID = 3 where permissionID = 890;
update VX_permissions set moduleID = 3 where permissionID = 891;
update VX_permissions set moduleID = 3 where permissionID = 892;
update VX_permissions set moduleID = 3 where permissionID = 893;
update VX_permissions set moduleID = 3 where permissionID = 855;
update VX_permissions set moduleID = 3 where permissionID = 856;
update VX_permissions set moduleID = 3 where permissionID = 857;
update VX_permissions set moduleID = 3 where permissionID = 858;
update VX_permissions set moduleID = 3 where permissionID = 870;
update VX_permissions set moduleID = 3 where permissionID = 907;
update VX_permissions set moduleID = 3 where permissionID = 899;
update VX_permissions set moduleID = 3 where permissionID = 900;
update VX_permissions set moduleID = 3 where permissionID = 901;
update VX_permissions set moduleID = 3 where permissionID = 902;                                                           
update VX_permissions set moduleID = 3 where permissionID = 859;
update VX_permissions set moduleID = 3 where permissionID = 860;
update VX_permissions set moduleID = 3 where permissionID = 861;
update VX_permissions set moduleID = 3 where permissionID = 862;

alter table VX_permission_relationships add column usertypeID int(11) NOT NULL DEFAULT 1 after permission_id;

insert into VX_permissions set description='Role Add',name='role_add';
insert into VX_permissions set description='Role Edit',name='role_edit';
insert into VX_permissions set description='Role Delete',name='role_delete';
insert into VX_permissions set description='Role View',name='role_view';