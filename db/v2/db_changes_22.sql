insert into VX_menu (menuName,link,icon,status,parentID,priority) values ('Baggage Report','bgreport','icon-template','1','0','700');
update VX_permissions set productID=1 where name like 'report%';

insert into VX_permissions set description='Baggage Report',name='bgreport',productID=2;
insert into VX_permissions set description='Baggage Report Add',name='bgreport_add',productID=2;
insert into VX_permissions set description='Baggage Report Edit',name='bgreport_edit',productID=2;
insert into VX_permissions set description='Baggage Report Delete',name='bgreport_delete',productID=2;
insert into VX_permissions set description='Baggage Report View',name='bgreport_view',productID=2;

insert into VX_data_types set name="mail_template_types",alias='Mail Template Types',create_userID=1,modify_userID=1,active=1,create_date=1554788423,modify_date=1554788423;
insert into vx_data_defns set aln_data_typeID=25,aln_data_value='Upgrade Template',parentID=0,alias='upgrade_template',create_userID=1,modify_userID=1,active=1,create_date=1554788423,modify_date=1554788423;
insert into vx_data_defns set aln_data_typeID=25,aln_data_value='Baggage Template',parentID=0,alias='baggage_template',create_userID=1,modify_userID=1,active=1,create_date=1554788423,modify_date=1554788423;
insert into vx_data_defns set aln_data_typeID=25,aln_data_value='Upgrade & Baggage Template',parentID=0,alias='upgrade_baggage_template',create_userID=1,modify_userID=1,active=1,create_date=1554788423,modify_date=1554788423;

alter table VX_mailandsmstemplate add column template_typeID int(11) NOT NULL;