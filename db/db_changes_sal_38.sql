insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,alias,create_userID,modify_userID,create_date,modify_date) values ('20','No seats Avaiable','no_seats','1','1','1554788423','1554788423');


ALTER TABLE VX_aln_daily_tkt_pax_feed_raw ADD COLUMN tier_markup varchar(4) after class;

ALTER TABLE VX_aln_daily_tkt_pax_feed MODIFY COLUMN tier_markup int(11) NOT NULL DEFAULT 0;

ALTER TABLE VX_aln_daily_tkt_pax_feed MODIFY COLUMN rbd_markup int(11) NOT NULL DEFAULT 0;
