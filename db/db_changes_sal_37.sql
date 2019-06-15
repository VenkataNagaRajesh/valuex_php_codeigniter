ALTER TABLE  VX_aln_daily_tkt_pax_feed ADD COLUMN tier_markup int(11) NOT NULL DEFAULT 0;
ALTER TABLE  VX_aln_daily_tkt_pax_feed ADD COLUMN rbd_markup int(11) NOT NULL DEFAULT 0;

ALTER TABLE  VX_aln_daily_tkt_pax_feed_raw ADD COLUMN tier_markup varchar(11) NOT NULL DEFAULT 0;
ALTER TABLE  VX_aln_daily_tkt_pax_feed_raw ADD COLUMN rbd_markup varchar(11) NOT NULL DEFAULT 0;
