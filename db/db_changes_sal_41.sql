ALTER TABLE VX_aln_daily_tkt_pax_feed_raw MODIFY dept_time varchar(11) NOT NULL;
ALTER TABLE VX_aln_daily_tkt_pax_feed_raw MODIFY arrival_time varchar(11) NOT NULL;
ALTER TABLE VX_aln_daily_tkt_pax_feed_raw DROP COLUMN tier_markup;
ALTER TABLE VX_aln_daily_tkt_pax_feed_raw ADD COLUMN tier_markup varchar(4) NOT NULL;


ALTER TABLE VX_aln_daily_tkt_pax_feed MODIFY COLUMN arrival_date int(11) NOT NULL;
ALTER TABLE VX_aln_daily_tkt_pax_feed MODIFY COLUMN dept_time int(11) NOT NULL;
ALTER TABLE VX_aln_daily_tkt_pax_feed MODIFY COLUMN arrival_time int(11) NOT NULL;

ALTER TABLE VX_aln_daily_tkt_pax_feed MODIFY COLUMN cabin int(11) NOT NULL;




ALTER TABLE VX_aln_daily_tkt_pax_feed ADD COLUMN is_processed  tinyint(1) NOT NULL DEFAULT '0';


insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,alias,create_userID,modify_userID,create_date,modify_date) values ('20','Offer Expired','offer_expire','1','1','1554788423','1554788423');
