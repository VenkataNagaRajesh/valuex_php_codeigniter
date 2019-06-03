alter table vx_aln_data_defns modify column parentID int(11) unsigned DEFAULT NULL;
alter table vx_aln_data_defns modify column code char(5) DEFAULT NULL;
insert into vx_aln_data_types (name,alias,create_userID,modify_userID,create_date,modify_date) values ('city','City', '1','1','1554788423','1554788423');
alter table vx_aln_master_data add column cityID int(11) unsigned NOT NULL after airportID;
 