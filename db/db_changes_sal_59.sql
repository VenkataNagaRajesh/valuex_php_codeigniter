ALTER TABLE VX_aln_daily_tkt_pax_feed_raw ADD CONSTRAINT unique_pnr_carrier_flight_passenger  UNIQUE KEY(pnr_ref,carrier_code,flight_number,pax_nbr);

ALTER TABLE VX_aln_daily_tkt_pax_feed ADD CONSTRAINT unique_pnr_carrier_flight_passenger  UNIQUE KEY(pnr_ref,carrier_code,flight_number,pax_nbr);
