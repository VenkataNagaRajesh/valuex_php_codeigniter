ALTER TABLE VX_aln_ra_feed  DROP COLUMN dep_time;
ALTER TABLE VX_aln_ra_feed  DROP COLUMN arrival_time;
ALTER TABLE VX_aln_ra_feed ADD COLUMN fare_basis varchar(15) NOT NULL DEFAULT  0 AFTER prorated_price;
ALTER TABLE VX_aln_ra_feed DROP COLUMN days_to_departure;

alter table VX_aln_ra_feed modify column coupon_number int(1) unsigned NOT NULL;
alter table VX_aln_ra_feed modify column class char(1)  NOT NULL;

alter table VX_aln_ra_feed modify column office_id varchar(8) NOT NULL DEFAULT 0;
alter table VX_aln_ra_feed modify column channel varchar(20)  NOT NULL DEFAULT 0;
 ALTER TABLE VX_aln_ra_feed DROP COLUMN booking_date;
ALTER TABLE VX_aln_ra_feed ADD COLUMN carrier int(11) NOT NULL DEFAULT  0 AFTER prorated_price;
ALTER TABLE VX_aln_ra_feed ADD COLUMN airline_code int(11) NOT NULL DEFAULT  0 AFTER prorated_price;
