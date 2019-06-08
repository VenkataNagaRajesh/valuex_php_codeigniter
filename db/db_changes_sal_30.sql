ALTER TABLE VX_aln_daily_tkt_pax_feed MODIFY COLUMN pnr_ref varchar(6) NOT NULL;
ALTER TABLE VX_aln_daily_tkt_pax_feed MODIFY COLUMN pax_nbr int(2) NOT NULL;
ALTER TABLE VX_aln_daily_tkt_pax_feed MODIFY COLUMN first_name char(99) NOT NULL;
ALTER TABLE VX_aln_daily_tkt_pax_feed MODIFY COLUMN last_name char(99) NOT NULL;
ALTER TABLE VX_aln_daily_tkt_pax_feed MODIFY COLUMN ptc char(3) NOT NULL;
 ALTER TABLE VX_aln_daily_tkt_pax_feed MODIFY COLUMN fqtv int(12) NOT NULL;
ALTER TABLE VX_aln_daily_tkt_pax_feed MODIFY COLUMN flight_number int(4) NOT NULL;
 ALTER TABLE VX_aln_daily_tkt_pax_feed MODIFY COLUMN seg_nbr int(2) NOT NULL;

ALTER TABLE VX_aln_daily_tkt_pax_feed MODIFY COLUMN class char(1) NOT NULL;


ALTER TABLE VX_aln_daily_tkt_pax_feed MODIFY COLUMN office_id  varchar(8)  NOT NULL;
ALTER TABLE VX_aln_daily_tkt_pax_feed MODIFY COLUMN channel  char(99)  NOT NULL;




ALTER TABLE VX_aln_daily_tkt_pax_feed_raw MODIFY COLUMN pnr_ref varchar(6) NOT NULL;
ALTER TABLE VX_aln_daily_tkt_pax_feed_raw MODIFY COLUMN pax_nbr int(2) NOT NULL;
ALTER TABLE VX_aln_daily_tkt_pax_feed_raw MODIFY COLUMN first_name char(99) NOT NULL;
ALTER TABLE VX_aln_daily_tkt_pax_feed_raw MODIFY COLUMN last_name char(99) NOT NULL;
ALTER TABLE VX_aln_daily_tkt_pax_feed_raw MODIFY COLUMN ptc char(3) NOT NULL;
 ALTER TABLE VX_aln_daily_tkt_pax_feed_raw MODIFY COLUMN fqtv int(12) NOT NULL;
ALTER TABLE VX_aln_daily_tkt_pax_feed_raw MODIFY COLUMN flight_number varchar(6) NOT NULL;
 ALTER TABLE VX_aln_daily_tkt_pax_feed_raw MODIFY COLUMN seg_nbr int(2) NOT NULL;

ALTER TABLE VX_aln_daily_tkt_pax_feed_raw MODIFY COLUMN class char(1) NOT NULL;


ALTER TABLE VX_aln_daily_tkt_pax_feed_raw MODIFY COLUMN office_id  varchar(8)  NOT NULL;
ALTER TABLE VX_aln_daily_tkt_pax_feed_raw MODIFY COLUMN channel  char(99)  NOT NULL;
ALTER TABLE VX_aln_daily_tkt_pax_feed_raw MODIFY COLUMN airline_code  char(2)  NOT NULL;
ALTER TABLE VX_aln_daily_tkt_pax_feed_raw MODIFY COLUMN carrier_code  char(2)  NOT NULL;
ALTER TABLE VX_aln_daily_tkt_pax_feed_raw MODIFY COLUMN booking_country  char(2)  NOT NULL;
ALTER TABLE VX_aln_daily_tkt_pax_feed_raw MODIFY COLUMN booking_city  char(3)  NOT NULL;


ALTER TABLE VX_aln_daily_inv_feed_raw MODIFY COLUMN flight_nbr varchar(6) NOT NULL;
ALTER TABLE VX_aln_daily_inv_feed MODIFY COLUMN flight_nbr int(4) NOT NULL;

ALTER TABLE VX_aln_ra_feed MODIFY COLUMN flight_number int(4) NOT NULL;



ALTER TABLE VX_aln_daily_inv_feed_raw MODIFY COLUMN airline char(2) NOT NULL;
ALTER TABLE VX_aln_daily_inv_feed_raw MODIFY COLUMN cabin  char(3) NOT NULL;
ALTER TABLE VX_aln_daily_inv_feed_raw MODIFY COLUMN empty_seats  int(3) NOT NULL;
ALTER TABLE VX_aln_daily_inv_feed_raw MODIFY COLUMN sold_seats  int(3) NOT NULL;

ALTER TABLE VX_aln_daily_inv_feed_raw MODIFY COLUMN origin_airport  char(3) NOT NULL;
ALTER TABLE VX_aln_daily_inv_feed_raw MODIFY COLUMN dest_airport  char(3) NOT NULL;




ALTER TABLE VX_aln_daily_inv_feed MODIFY COLUMN empty_seats  int(3) NOT NULL;
ALTER TABLE VX_aln_daily_inv_feed MODIFY COLUMN sold_seats  int(3) NOT NULL;


