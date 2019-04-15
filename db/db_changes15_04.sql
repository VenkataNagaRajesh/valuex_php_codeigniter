alter table vx_aln_data_defns modify column aln_data_value varchar(250) NOT NULL;

insert into permissions set description='Airports Master',name='airports_master';
insert into permissions set description='Airports Master Add',name='airports_master_add';
insert into permissions set description='Airports Master Edit',name='airports_master_edit';
insert into permissions set description='Airports Master Delete',name='airports_master_delete';
insert into permissions set description='Airports Master View',name='airports_master_view';
insert into permissions set description='Airports Master Upload',name='airports_master_upload';