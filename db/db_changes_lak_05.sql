alter table VX_aln_airline_cabin_images modify column airline_cabin_map_id int(11) unsigned NOT NULL;
alter table VX_aln_airline_cabin_images modify column create_userID int(11) unsigned NOT NULL;
alter table VX_aln_airline_cabin_images modify column modify_userID int(11) unsigned NOT NULL;
alter table VX_aln_airline_cabin_images modify column create_date int(11) unsigned NOT NULL;
alter table VX_aln_airline_cabin_images modify column modify_date int(11) unsigned NOT NULL;

alter table VX_aln_airline_cabin_map modify column aircraft_id int(11) unsigned NOT NULL;
alter table VX_aln_airline_cabin_map modify column create_userID int(11) unsigned NOT NULL;
alter table VX_aln_airline_cabin_map modify column modify_userID int(11) unsigned NOT NULL;
alter table VX_aln_airline_cabin_map modify column create_date int(11) unsigned NOT NULL;
alter table VX_aln_airline_cabin_map modify column modify_date int(11) unsigned NOT NULL;

alter table VX_aln_client modify column create_userID int(11) unsigned NOT NULL;
alter table VX_aln_client modify column modify_userID int(11) unsigned NOT NULL;
alter table VX_aln_client modify column create_date int(11) unsigned NOT NULL;
alter table VX_aln_client modify column modify_date int(11) unsigned NOT NULL;
alter table VX_aln_client modify column userID int(11) unsigned NOT NULL;
alter table VX_aln_client modify column airlineID int(11) unsigned NOT NULL;

alter table vx_aln_data_defns modify column create_userID int(11) unsigned NOT NULL;
alter table vx_aln_data_defns modify column modify_userID int(11) unsigned NOT NULL;
alter table vx_aln_data_defns modify column create_date int(11) unsigned NOT NULL;
alter table vx_aln_data_defns modify column modify_date int(11) unsigned NOT NULL;
alter table vx_aln_data_defns modify column aln_data_typeID int(11) unsigned NOT NULL;
alter table vx_aln_data_defns modify column parentID int(11) unsigned NOT NULL;
alter table vx_aln_data_defns modify column code char(3) NOT NULL;

alter table VX_aln_eligibility_excl_rules modify column create_userID int(11) unsigned NOT NULL;
alter table VX_aln_eligibility_excl_rules modify column modify_userID int(11) unsigned NOT NULL;
alter table VX_aln_eligibility_excl_rules modify column create_date int(11) unsigned NOT NULL;
alter table VX_aln_eligibility_excl_rules modify column modify_date int(11) unsigned NOT NULL;
alter table VX_aln_eligibility_excl_rules modify column orig_market_id int(11) unsigned NOT NULL;
alter table VX_aln_eligibility_excl_rules modify column dest_market_id int(11) unsigned NOT NULL;
alter table VX_aln_eligibility_excl_rules modify column flight_efec_date int(11) unsigned NOT NULL;
alter table VX_aln_eligibility_excl_rules modify column flight_disc_date int(11) unsigned NOT NULL;

alter table vx_aln_data_types modify column create_userID int(11) unsigned NOT NULL;
alter table vx_aln_data_types modify column modify_userID int(11) unsigned NOT NULL;
alter table vx_aln_data_types modify column create_date int(11) unsigned NOT NULL;
alter table vx_aln_data_types modify column modify_date int(11) unsigned NOT NULL;

alter table VX_aln_market_zone modify column create_userID int(11) unsigned NOT NULL;
alter table VX_aln_market_zone modify column modify_userID int(11) unsigned NOT NULL;
alter table VX_aln_market_zone modify column create_date int(11) unsigned NOT NULL;
alter table VX_aln_market_zone modify column modify_date int(11) unsigned NOT NULL;
alter table VX_aln_market_zone modify column amz_level_id int(11) unsigned NOT NULL;
alter table VX_aln_market_zone modify column amz_incl_id int(11) unsigned NOT NULL;
alter table VX_aln_market_zone modify column amz_excl_id int(11) unsigned NOT NULL;
alter table VX_aln_market_zone modify column airline_id int(11) unsigned NOT NULL;

alter table vx_aln_master_data modify column create_userID int(11) unsigned NOT NULL;
alter table vx_aln_master_data modify column modify_userID int(11) unsigned NOT NULL;
alter table vx_aln_master_data modify column create_date int(11) unsigned NOT NULL;
alter table vx_aln_master_data modify column modify_date int(11) unsigned NOT NULL;
alter table vx_aln_master_data modify column airportID int(11) unsigned NOT NULL;
alter table vx_aln_master_data modify column stateID int(11) unsigned NOT NULL;
alter table vx_aln_master_data modify column countryID int(11) unsigned NOT NULL;
alter table vx_aln_master_data modify column regionID int(11) unsigned NOT NULL;
alter table vx_aln_master_data modify column areaID int(11) unsigned NOT NULL;

alter table VX_aln_preference modify column create_userID int(11) unsigned NOT NULL;
alter table VX_aln_preference modify column modify_userID int(11) unsigned NOT NULL;
alter table VX_aln_preference modify column create_date int(11) unsigned NOT NULL;
alter table VX_aln_preference modify column modify_date int(11) unsigned NOT NULL;
alter table VX_aln_preference modify column categoryID int(11) unsigned NOT NULL;

alter table VX_aln_ra_feed modify column create_userID int(11) unsigned NOT NULL;
alter table VX_aln_ra_feed modify column modify_userID int(11) unsigned NOT NULL;
alter table VX_aln_ra_feed modify column create_date int(11) unsigned NOT NULL;
alter table VX_aln_ra_feed modify column modify_date int(11) unsigned NOT NULL;


alter table VX_aln_season modify column create_userID int(11) unsigned NOT NULL;
alter table VX_aln_season modify column modify_userID int(11) unsigned NOT NULL;
alter table VX_aln_season modify column create_date int(11) unsigned NOT NULL;
alter table VX_aln_season modify column modify_date int(11) unsigned NOT NULL;
alter table VX_aln_season modify column airlineID int(11) unsigned NOT NULL;
alter table VX_aln_season modify column ams_orig_levelID int(11) unsigned NOT NULL;
alter table VX_aln_season modify column ams_dest_levelID int(11) unsigned NOT NULL;
alter table VX_aln_season modify column ams_season_start_date int(11) unsigned NOT NULL;
alter table VX_aln_season modify column ams_season_end_date int(11) unsigned NOT NULL;

alter table VX_market_airport_map modify column market_id int(11) unsigned NOT NULL;
alter table VX_market_airport_map modify column airport_id int(11) unsigned NOT NULL;

alter table VX_season_airport_dest_map modify column seasonID int(11) unsigned NOT NULL;
alter table VX_season_airport_dest_map modify column dest_airportID int(11) unsigned NOT NULL;

alter table VX_season_airport_origin_map modify column seasonID int(11) unsigned NOT NULL;
alter table VX_season_airport_origin_map modify column orig_airportID int(11) unsigned NOT NULL;

alter table VX_trigger_table modify column create_userID int(11) unsigned NOT NULL;
alter table VX_trigger_table modify column modify_userID int(11) unsigned NOT NULL;
alter table VX_trigger_table modify column create_date int(11) unsigned NOT NULL;
alter table VX_trigger_table modify column modify_date int(11) unsigned NOT NULL;

alter table VX_aln_airline_cabin_class modify column create_userID int(11) unsigned NOT NULL;
alter table VX_aln_airline_cabin_class modify column modify_userID int(11) unsigned NOT NULL;
alter table VX_aln_airline_cabin_class modify column create_date int(11) unsigned NOT NULL;
alter table VX_aln_airline_cabin_class modify column modify_date int(11) unsigned NOT NULL;

alter table VX_aln_daily_tkt_pax_feed modify column create_userID int(11) unsigned NOT NULL;
alter table VX_aln_daily_tkt_pax_feed modify column modify_userID int(11) unsigned NOT NULL;
alter table VX_aln_daily_tkt_pax_feed modify column create_date int(11) unsigned NOT NULL;
alter table VX_aln_daily_tkt_pax_feed modify column modify_date int(11) unsigned NOT NULL;