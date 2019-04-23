 ALTER table VX_aln_market_zone MODIFY COLUMN  create_date int(11) NOT NULL;
 ALTER table VX_aln_market_zone MODIFY COLUMN  modify_date int(11) NOT NULL;


CREATE TABLE `VX_trigger_table` (
  `table_name` varchar(60) NOT NULL,
  `table_last_changed` int(11) NOT NULL,
  `create_userID` int(11) NOT NULL,
  `isReconfigured` int(11) NOT NULL,
   `trigger_last_run_time` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE INDEX table_name_index ON VX_trigger_table(table_name);
CREATE INDEX table_last_changed_index ON VX_trigger_table(table_last_changed);
CREATE INDEX create_userID_index ON VX_trigger_table(create_userID);
CREATE INDEX  isReconfigured_index ON VX_trigger_table(isReconfigured);
CREATE INDEX trigger_last_run_time_index ON VX_trigger_table(trigger_last_run_time);


CREATE TABLE `VX_market_airport_map` (
`ma_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `market_id` int(11) NOT NULL,
`airport_id`  int(11) NOT NULL,
 PRIMARY KEY (`ma_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE INDEX ma_id_index ON VX_market_airport_map(ma_id);
CREATE INDEX  market_id_index ON VX_market_airport_map(market_id);
CREATE INDEX airport_id_index ON VX_market_airport_map(airport_id);
