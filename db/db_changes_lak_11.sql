alter table VX_aln_bid add column fclr_id int(11) NOT NULL;
insert into vx_aln_data_defns set alias='bid_unselect_cabin',aln_data_typeID = 20,aln_data_value = 'Unselected cabin in Bidding Process',parentID=0,create_userID=1,modify_userID=1,active=1,create_date=1554788423,modify_date=1554788423;
