insert into VX_permissions set description='Baggage RA feed',name='rafeed/baggage',productID=2;
insert into VX_menu (menuName,link,icon,status,parentID,priority) values ('RA feed - Baggage','rafeed/baggage','fa-list','1','130','500');

insert into VX_permissions set description='BCLR',name='bclr',productID=2;
insert into VX_permissions set description='BCLR Add',name='bclr_add',productID=2;
insert into VX_permissions set description='BCLR Edit',name='bclr_edit',productID=2;
insert into VX_permissions set description='BCLR View',name='bclr_view',productID=2;
insert into VX_permissions set description='BCLR Delete',name='bclr_delete',productID=2;

insert into VX_menu (menuName,link,icon,status,parentID,priority) values ('Baggage Control Rule','bclr','fa-sun-o','1','124','700');

