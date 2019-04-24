ALTER TABLE  VX_trigger_table CHANGE table_last_changed create_date int(11) NOT NULL;
ALTER TABLE  VX_trigger_table CHANGE trigger_last_run_time modify_date int(11) DEFAULT 0;

ALTER TABLE  VX_trigger_table ADD COLUMN modify_userID int(11) NOT NULL;


ALTER TABLE  VX_trigger_table DROP INDEX table_last_changed_index;
ALTER TABLE  VX_trigger_table DROP INDEX trigger_last_run_time_index;
CREATE INDEX create_date_index ON VX_trigger_table(create_date);
CREATE INDEX modify_date_index ON VX_trigger_table(modify_date);
CREATE INDEX modify_userID_index ON VX_trigger_table(modify_userID);





