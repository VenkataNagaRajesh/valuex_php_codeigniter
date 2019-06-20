
ALTER TABLE VX_aln_eligibility_excl_rules ADD COLUMN  carrier int(11) NOT NULL after flight_nbr_end;
ALTER TABLE VX_aln_daily_tkt_pax_feed MODIFY COLUMN fqtv bigint(20) NOT NULL;
ALTER TABLE VX_aln_daily_tkt_pax_feed_raw MODIFY COLUMN fqtv bigint(20) NOT NULL;


 ALTER  TABLE VX_aln_auto_confirm_setup_rules ADD COLUMN carrier_code int(11) NOT NULL after dest_market_id;



