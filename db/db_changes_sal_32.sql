ALTER TABLE VX_aln_fare_control_range MODIFY COLUMN from_cabin int(11) NOT NULL DEFAULT 0;
ALTER TABLE VX_aln_fare_control_range MODIFY COLUMN to_cabin int(11) NOT NULL DEFAULT 0;
ALTER TABLE VX_aln_fare_control_range DROP COLUMN departure_date;
ALTER TABLE VX_aln_fare_control_range MODIFY COLUMN min DECIMAL( 10, 2 )  NOT NULL DEFAULT 0;
ALTER TABLE VX_aln_fare_control_range MODIFY COLUMN max DECIMAL( 10, 2 )  NOT NULL DEFAULT 0;
ALTER TABLE VX_aln_fare_control_range MODIFY COLUMN average DECIMAL( 10, 2 )  NOT NULL DEFAULT 0;
ALTER TABLE VX_aln_fare_control_range MODIFY COLUMN slider_start DECIMAL( 10, 2 )  NOT NULL DEFAULT 0;
ALTER TABLE VX_aln_fare_control_range MODIFY COLUMN  flight_number int(4) NOT NULL DEFAULT 0;
