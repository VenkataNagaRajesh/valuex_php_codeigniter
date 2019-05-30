ALTER TABLE VX_aln_daily_tkt_pax_feed ADD COLUMN cabin int(11)  NOT NULL AFTER class;
ALTER TABLE VX_aln_daily_tkt_pax_feed ADD COLUMN dep_time int(11) NOT NULL AFTER dep_date;
ALTER TABLE VX_aln_daily_tkt_pax_feed ADD COLUMN arrival_time int(11)NOT NULL AFTER dep_time;
CREATE INDEX cabin_index ON VX_aln_daily_tkt_pax_feed(cabin);
CREATE INDEX dep_time_index ON VX_aln_daily_tkt_pax_feed(dep_time);
CREATE INDEX arrival_time_index ON VX_aln_daily_tkt_pax_feed(arrival_time);

ALTER TABLE VX_aln_daily_tkt_pax_feed_raw ADD COLUMN dep_time varchar(50) NOT NULL AFTER dep_date;
ALTER TABLE VX_aln_daily_tkt_pax_feed_raw ADD COLUMN arrival_time varchar(50)NOT NULL AFTER dep_time;
CREATE INDEX dep_time_index ON VX_aln_daily_tkt_pax_feed_raw(dep_time);
CREATE INDEX arrival_time_index ON VX_aln_daily_tkt_pax_feed_raw(arrival_time);
