ALTER TABLE VX_aln_daily_inv_feed_raw MODIFY COLUMN sold_seats int(3) NOT NULL DEFAULT 0;

ALTER TABLE VX_aln_daily_inv_feed MODIFY COLUMN sold_seats int(3) NOT NULL DEFAULT 0;
