CREATE TABLE `VX_season_airport_origin_map` (
  `saoID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `seasonID` int(11) NOT NULL,
  `orig_airportID` int(11) NOT NULL,  
   PRIMARY KEY (`saoID`)
);

CREATE TABLE `VX_season_airport_dest_map` (
  `sadID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `seasonID` int(11) NOT NULL,
  `dest_airportID` int(11) NOT NULL,   
  PRIMARY KEY (`sadID`)
);


CREATE INDEX saoid_index ON VX_season_airport_origin_map(saoID);
CREATE INDEX season_index ON VX_season_airport_origin_map(seasonID);
CREATE INDEX airport_index ON VX_season_airport_origin_map(orig_airportID);


CREATE INDEX sadid_index ON VX_season_airport_dest_map(sadID);
CREATE INDEX season_index ON VX_season_airport_dest_map(seasonID);
CREATE INDEX airport_index ON VX_season_airport_dest_map(dest_airportID);


insert into permissions set description='Season Reconfigure',name='season_reconfigure';