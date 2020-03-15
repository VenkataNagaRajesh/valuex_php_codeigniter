alter table VX_reportdata add column tot_seat_capacity int(11) NOT NULL DEFAULT 0 after reject_revenue;
alter table VX_reportdata add column tot_passengers_boarded int(11) NOT NULL DEFAULT 0 after tot_seat_capacity;
alter table VX_reportdata add column ldf int(11) NOT NULL DEFAULT 0 after tot_passengers_boarded;