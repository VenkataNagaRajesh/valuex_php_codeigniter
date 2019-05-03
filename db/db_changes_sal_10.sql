insert into vx_aln_data_types (name,alias,create_userID,modify_userID,create_date,modify_date) values ('aln_flight_numbers','Aircrafts', '1','1','1554788423','1554788423');

ALTER TABLE VX_aln_airline_cabin_map ADD COLUMN aircraft_id int(11) NOT NULL;
 ALTER TABLE VX_aln_airline_cabin_map MODIFY COLUMN airline_cabin int(11) NOT NULL;
ALTER TABLE VX_aln_airline_cabin_map MODIFY COLUMN airline_class varchar(100) NOT NULL;

insert into permissions (description, name, active) values ('Airline Cabins Gallery' ,'airline_cabin_gallery', 'yes');
