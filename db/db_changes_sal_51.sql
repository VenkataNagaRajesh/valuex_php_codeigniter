ALTER TABLE VX_aln_daily_tkt_pax_feed ADD COLUMN frequency int(11) AFTER dep_date;
ALTER TABLE VX_aln_daily_tkt_pax_feed ADD COLUMN tier int(11) NOT NULL default 0 AFTER dep_date;

