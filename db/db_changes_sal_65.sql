insert into vx_aln_data_types (name,alias,create_userID,modify_userID,active,create_date,modify_date) values('pref_airline','Preference Airline',1,1,1,1554788423,1554788423);

 ALTER TABLE VX_aln_preference ADD COLUMN pref_type_value int(11) NOT NULL DEFAULT 0 after pref_type;


insert into menu (menuName,link,icon,status,parentID,priority) values ('Airline Preferences','pref_setting/airline_settings','fa-cogs','1','0','500');

insert into permissions (description,name,active) values ('Airline Preferences','pref_setting/airline_settings','yes');



insert into menu (menuName,link,icon,status,parentID,priority) values ('User Preferences','pref_setting/user_preferences','fa-cogs','1','0','500');

insert into permissions (description,name,active) values ('User Preference','pref_setting/user_preferences','yes');




insert into menu (menuName,link,icon,status,parentID,priority) values ('Application Preferences','pref_setting','fa-cogs','1','0','500');

insert into permissions (description,name,active) values ('Application Preference','pref_setting','yes');
