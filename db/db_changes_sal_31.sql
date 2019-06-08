ALTER TABLE VX_aln_daily_tkt_pax_feed MODIFY COLUMN ptc int(11) NOT NULL DEFAULT 0;
ALTER TABLE VX_aln_daily_tkt_pax_feed DROP COLUMN dep_time;
ALTER TABLE VX_aln_daily_tkt_pax_feed DROP COLUMN arrival_time;
ALTER TABLE VX_aln_daily_tkt_pax_feed_raw DROP COLUMN dep_time;
ALTER TABLE VX_aln_daily_tkt_pax_feed_raw DROP COLUMN arrival_time;
