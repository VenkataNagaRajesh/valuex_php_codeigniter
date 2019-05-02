alter table vx_aln_data_types add column alias varchar(100) NOT NULL after name;

update vx_aln_data_types set alias = 'Airport' where vx_aln_data_typeID = 1;
update vx_aln_data_types set alias = 'Country' where vx_aln_data_typeID = 2;
update vx_aln_data_types set alias = 'State' where vx_aln_data_typeID = 3;
update vx_aln_data_types set alias = 'Region' where vx_aln_data_typeID = 4;
update vx_aln_data_types set alias = 'Area' where vx_aln_data_typeID = 5;
update vx_aln_data_types set alias = 'Preference Category' where vx_aln_data_typeID = 6;
update vx_aln_data_types set alias = 'Preference System' where vx_aln_data_typeID = 7;
update vx_aln_data_types set alias = 'Preference User' where vx_aln_data_typeID = 8;
update vx_aln_data_types set alias = 'Preference Boolean' where vx_aln_data_typeID = 9;
update vx_aln_data_types set alias = 'Preference Text' where vx_aln_data_typeID = 10;
update vx_aln_data_types set alias = 'Preference List' where vx_aln_data_typeID = 11;
update vx_aln_data_types set alias = 'Airline' where vx_aln_data_typeID = 12;
update vx_aln_data_types set alias = 'Airline Cabin Class' where vx_aln_data_typeID = 13;
update vx_aln_data_types set alias = 'Days Of Week' where vx_aln_data_typeID = 14;
update vx_aln_data_types set alias = 'Time 24 Hours Format' where vx_aln_data_typeID = 15;

