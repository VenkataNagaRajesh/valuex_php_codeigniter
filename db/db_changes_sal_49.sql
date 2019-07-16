ALTER TABLE VX_aln_ra_feed MODIFY COLUMN airline_code char(3) NOT NULL;
 ALTER TABLE  VX_aln_daily_tkt_pax_feed  MODIFY COLUMN airline_code char(3) NOT NULL;
 ALTER TABLE  VX_aln_daily_tkt_pax_feed_raw  MODIFY COLUMN airline_code char(3) NOT NULL;
