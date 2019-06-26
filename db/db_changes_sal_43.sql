 update menu set menuName = 'Offer Issuance Management' where link = 'offer_issue';
update permissions set description='Offer Issueance Management View' where name = 'offer_issue_view';

update permissions set description='Offer Issueance Management' where name = 'offer_issue';
insert into menu (menuName,link,icon,status,parentID,priority) values ('Offer Management','offer_table','icon-template','1','0','1000');
insert into permissions (description,name,active) values ('Offer Management','offer_table','yes');

insert into permissions (description,name,active) values ('Offer Management View','offer_table_view','yes');


