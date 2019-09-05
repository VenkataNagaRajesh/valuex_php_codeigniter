ALTER TABLE  VX_aln_daily_tkt_pax_feed ADD COLUMN is_fclr_processed  tinyint(1) NOT NULL default 0 after is_processed ;

ALTER TABLE  VX_aln_daily_tkt_pax_feed ADD COLUMN fclr_data  varchar(100) NOT NULL default 0 after is_fclr_processed ;
