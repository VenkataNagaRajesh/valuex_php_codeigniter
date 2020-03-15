alter table VX_daily_inv_feed_raw add column aircraft_typeID int(11) NOT NULL AFTER sold_seats;
alter table VX_daily_inv_feed_raw add column seat_capacity int(11) NOT NULL AFTER aircraft_typeID;
alter table VX_daily_inv_feed_raw add column sold_weight int(11) NOT NULL AFTER seat_capacity;

alter table VX_daily_inv_feed add column aircraft_typeID int(11) NOT NULL AFTER sold_seats;
alter table VX_daily_inv_feed add column seat_capacity int(11) NOT NULL AFTER aircraft_typeID;
alter table VX_daily_inv_feed add column sold_weight int(11) NOT NULL AFTER seat_capacity;