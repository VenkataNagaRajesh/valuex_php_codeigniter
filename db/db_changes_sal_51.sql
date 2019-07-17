ALTER TABLE VX_aln_daily_tkt_pax_feed ADD COLUMN frequency int(11) AFTER dep_date;
ALTER TABLE VX_aln_daily_tkt_pax_feed ADD COLUMN tier int(11) AFTER dep_date NOT NULL default 0;

