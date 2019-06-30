alter table VX_aln_daily_tkt_pax_feed add column seat_no varchar(50);
update VX_aln_daily_tkt_pax_feed set seat_no = flight_number+dtpf_id;