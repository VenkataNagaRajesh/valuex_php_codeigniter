alter table vx_aln_master_data drop column stateID;
update vx_aln_data_types set name='aln_master_city',alias='City' where vx_aln_data_typeID = 3;