ALTER table VX_aln_ra_feed ADD COLUMN season_id int(11) DEFAULT 0 after flight_number;

insert into menu (menuName,link,icon,status,parentID,priority) values ('fclr','fclr','fa-sun-o','1','0','1000');

insert into permissions (description,name,active) values ('FCLR','fclr','yes');
insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,create_userID,modify_userID,create_date,modify_date,code) values ('18','ADULT','1','1','1554788423','1554788423','ADT');
insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,create_userID,modify_userID,create_date,modify_date,code) values ('18','Child','1','1','1554788423','1554788423','CHD');
insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,create_userID,modify_userID,create_date,modify_date,code) values ('18','Infant with out seat','1','1','1554788423','1554788423','INF');
insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,create_userID,modify_userID,create_date,modify_date,code) values ('18','Infant With Seat','1','1','1554788423','1554788423','INS');

insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,create_userID,modify_userID,create_date,modify_date,code) values ('18','Unaccompanied Child','1','1','1554788423','1554788423','UNN');
