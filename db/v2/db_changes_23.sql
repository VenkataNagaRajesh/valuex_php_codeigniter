alter table VX_daily_tkt_pax_feed CHANGE is_processed   is_up_offer_processed bool default 0;
alter table VX_daily_tkt_pax_feed add  is_bg_offer_processed bool default 0;
alter table UP_dtpf_ext modify fclr_id int(11)  default NULL;
alter table UP_dtpf_ext add ond int(5) default NULL;
alter table UP_dtpf_ext add bclr_id int(11) default NULL;
