CREATE TABLE `VX_airline_gallery` (
  `galleryID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `airlineID` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `image` text NOT NULL,
  `create_date` int(11) NOT NULL,  
  `create_userID` int(11) NOT NULL, 
   PRIMARY KEY (`galleryID`)
);
insert into permissions set name='airline_gallery',description='Airline Gallery';