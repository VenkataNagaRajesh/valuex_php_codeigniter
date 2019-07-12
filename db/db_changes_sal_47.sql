ALTER TABLE VX_aln_eligibility_excl_rules DROP COLUMN future_use;
ALTER TABLE VX_aln_eligibility_excl_rules MODIFY COLUMN  excl_grp int(11) unsigned NOT NULL DEFAULT 0;

ALTER TABLE VX_aln_eligibility_excl_rules MODIFY COLUMN  flight_efec_date  int(11) unsigned  NOT NULL DEFAULT 0;
ALTER TABLE VX_aln_eligibility_excl_rules MODIFY COLUMN  flight_disc_date  int(11) unsigned  NOT NULL DEFAULT 0;
ALTER TABLE VX_aln_eligibility_excl_rules MODIFY COLUMN  flight_dep_start  int(11) unsigned  NOT NULL DEFAULT 0;
ALTER TABLE VX_aln_eligibility_excl_rules MODIFY COLUMN  flight_dep_end  int(11) unsigned  NOT NULL DEFAULT 0;
ALTER TABLE VX_aln_eligibility_excl_rules MODIFY COLUMN  flight_nbr_start  SMALLINT(5) unsigned  NOT NULL DEFAULT 0;
ALTER TABLE VX_aln_eligibility_excl_rules MODIFY COLUMN  flight_nbr_end SMALLINT(5) unsigned  NOT NULL DEFAULT 0;
ALTER TABLE VX_aln_eligibility_excl_rules MODIFY COLUMN  carrier int(11) unsigned  NOT NULL DEFAULT 0;

ALTER TABLE VX_aln_eligibility_excl_rules MODIFY COLUMN  frequency varchar(100)   NOT NULL DEFAULT 0;
ALTER TABLE VX_aln_eligibility_excl_rules MODIFY COLUMN  upgrade_from_cabin_type int(11) unsigned NOT NULL DEFAULT 0;
 ALTER TABLE VX_aln_eligibility_excl_rules MODIFY COLUMN  upgrade_to_cabin_type int(11) unsigned NOT NULL DEFAULT 0;

 ALTER TABLE VX_aln_eligibility_excl_rules DROP COLUMN  orig_market_id ;
 ALTER TABLE VX_aln_eligibility_excl_rules DROP COLUMN  dest_market_id ;



ALTER TABLE VX_aln_eligibility_excl_rules ADD COLUMN dest_level_value varchar(100)  DEFAULT NULL AFTER excl_grp;
ALTER TABLE VX_aln_eligibility_excl_rules ADD COLUMN dest_level_id int(11) unsigned NOT NULL DEFAULT 0 AFTER excl_grp;
ALTER TABLE VX_aln_eligibility_excl_rules ADD COLUMN orig_level_value varchar(100)  DEFAULT NULL AFTER excl_grp;
ALTER TABLE VX_aln_eligibility_excl_rules ADD COLUMN orig_level_id int(11) unsigned NOT NULL  DEFAULT 0 AFTER excl_grp;
