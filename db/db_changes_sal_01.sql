CREATE TABLE `VX_aln_market_zone` (
  `market_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `market_name` varchar(60) NOT NULL,
  `amz_level_id` int(11) NOT NULL,
  `amz_level_name` varchar(100) NOT NULL,
  `amz_incl_id` int(11) NOT NULL,
  `amz_incl_name` varchar(100) NOT NULL,
  `amz_excl_id` int(11) NOT NULL,
  `amz_excl_name` varchar(60) NOT NULL,
  `create_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL,
  `create_userID` int(11) NOT NULL,
  `modify_userID` int(11) NOT NULL,
   `active` int(11) NOT NULL,
  PRIMARY KEY (`market_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE INDEX market_name_index ON VX_aln_market_zone(market_name);
CREATE INDEX amz_level_id_index ON VX_aln_market_zone(amz_level_id);
CREATE INDEX amz_level_name_index ON VX_aln_market_zone(amz_level_name);
CREATE INDEX amz_incl_id_index ON VX_aln_market_zone(amz_incl_id);
CREATE INDEX amz_incl_name_index ON VX_aln_market_zone(amz_incl_name);
CREATE INDEX amz_excl_id_index ON VX_aln_market_zone(amz_excl_id);
CREATE INDEX amz_excl_name_index ON VX_aln_market_zone(amz_excl_name);
CREATE INDEX create_date_index ON VX_aln_market_zone(create_date);
CREATE INDEX modify_date_index ON VX_aln_market_zone(modify_date);
CREATE INDEX create_userID_index ON VX_aln_market_zone(create_userID);
CREATE INDEX  mdify_userID_index ON VX_aln_market_zone(modify_userID);
CREATE INDEX active_index ON VX_aln_market_zone(active);
