ALTER TABLE VX_aln_daily_tkt_pax_feed ADD COLUMN arrival_date int(11) after dep_date;
ALTER TABLE VX_aln_daily_tkt_pax_feed ADD COLUMN dept_time int(11) after arrival_date;
ALTER TABLE VX_aln_daily_tkt_pax_feed ADD COLUMN arrival_time int(11) after dept_time;

CREATE INDEX arrival_date_index ON VX_aln_daily_tkt_pax_feed(arrival_date);
CREATE INDEX dept_time_index ON VX_aln_daily_tkt_pax_feed(dept_time);
CREATE INDEX arrival_time_index ON VX_aln_daily_tkt_pax_feed(arrival_time);

ALTER TABLE VX_aln_daily_tkt_pax_feed_raw ADD COLUMN arrival_date varchar(50) after dep_date;
ALTER TABLE VX_aln_daily_tkt_pax_feed_raw ADD COLUMN dept_time varchar(11) after arrival_date;
ALTER TABLE VX_aln_daily_tkt_pax_feed_raw ADD COLUMN arrival_time varchar(11) after dept_time;

CREATE INDEX arrival_date_index ON VX_aln_daily_tkt_pax_feed_raw(arrival_date);
CREATE INDEX dept_time_index ON VX_aln_daily_tkt_pax_feed_raw(dept_time);
CREATE INDEX arrival_time_index ON VX_aln_daily_tkt_pax_feed_raw(arrival_time);
