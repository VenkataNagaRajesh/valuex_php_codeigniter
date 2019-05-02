 ALTER table VX_aln_market_zone ADD COLUMN airline_id int(11) NOT NULL;
ALTER table VX_aln_market_zone ADD COLUMN description varchar(200) DEFAULT NULL after market_name;
