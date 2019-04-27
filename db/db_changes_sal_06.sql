
CREATE TABLE `VX_aln_airline_cabin_map` (
`cabin_map_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(60) NOT NULL,
  `airline_code` int(11) NOT NULL,
`airline_class`  int(11) NOT NULL DEFAULT '0',
`airline_cabin` varchar(100) DEFAULT NULL,
`video_links` text default null,
 `create_date` int(11) NOT NULL,
  `modify_date` int(11) NOT NULL,
  `create_userID` int(11) NOT NULL,
  `modify_userID` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
 PRIMARY KEY (`cabin_map_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE INDEX airline_code_index ON VX_aln_airline_cabin_map(airline_code);
CREATE INDEX name_index ON VX_aln_airline_cabin_map(name);
CREATE INDEX airline_class_index ON VX_aln_airline_cabin_map(airline_class);
CREATE INDEX airline_cabin_index ON VX_aln_airline_cabin_map(airline_cabin);
CREATE INDEX modify_date_index ON VX_aln_airline_cabin_map(modify_date);
CREATE INDEX create_date_index ON VX_aln_airline_cabin_map(create_date);
CREATE INDEX create_userID_index ON VX_aln_airline_cabin_map(create_userID);
CREATE INDEX modify_userID_index ON VX_aln_airline_cabin_map(modify_userID);
CREATE INDEX active_index ON VX_aln_airline_cabin_map(active);




CREATE TABLE `VX_aln_airline_cabin_images` (
  `cabin_images_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `airline_cabin_map_id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `image` text NOT NULL,
  `status` int(11) DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `create_userID` int(11) DEFAULT NULL,
    `modify_userID` int(11) DEFAULT NULL,
    `create_date` int(11) DEFAULT NULL,
  `modify_date` int(11) DEFAULT NULL,
  PRIMARY KEY (`cabin_images_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE INDEX airline_cabin_map_id_index ON VX_aln_airline_cabin_images(airline_cabin_map_id);
CREATE INDEX name_index ON VX_aln_airline_cabin_images(name);

CREATE INDEX modify_date_index ON VX_aln_airline_cabin_images(modify_date);
CREATE INDEX create_date_index ON VX_aln_airline_cabin_images(create_date);
CREATE INDEX create_userID_index ON VX_aln_airline_cabin_images(create_userID);
CREATE INDEX modify_userID_index ON VX_aln_airline_cabin_images(modify_userID);
CREATE INDEX type_index ON VX_aln_airline_cabin_images(type);
CREATE INDEX status_index ON VX_aln_airline_cabin_images(status);

insert into menu (menuName,link,icon,status,parentID,priority) values ('airline_cabin','airline_cabin','icon-template','1','0','1000');
insert into permissions (description,name,active) values ('Airline Cabins','airline_cabin','yes');

insert into permissions (description,name,active) values ('Airline Cabins Add','airline_cabin_add','yes');
insert into permissions (description,name,active) values ('Airline Cabins Delete','airline_cabin_delete','yes');
insert into permissions (description,name,active) values ('Airline Cabins View','airline_cabin_view','yes');

insert into permissions (description,name,active) values ('Airline Cabins Gallery','airline_cabin_gallery','yes');

insert into permissions set description='Marketzone Reconfigure',name='marketzone_reconfigure';
