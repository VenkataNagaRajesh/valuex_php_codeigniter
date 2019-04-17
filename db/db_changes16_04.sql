alter table vx_aln_master_data add column lat DECIMAL(10, 8) DEFAULT NULL after areaID;
alter table vx_aln_master_data add column lng DECIMAL(11, 8) DEFAULT NULL after lat;