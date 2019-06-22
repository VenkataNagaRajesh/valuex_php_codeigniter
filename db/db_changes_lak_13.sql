alter table mailandsmstemplatetag modify column create_date int(11) DEFAULT 0;
alter table mailandsmstemplate add column catID int(11) NOT NULL;
alter table mailandsmstemplate add column `default` tinyint(1) DEFAULT 0 ;
insert into mailandsmstemplatetag set usertypeID = 12,create_date=1560342432,tagname='[first_name]';
insert into mailandsmstemplatetag set usertypeID = 12,create_date=1560342432,tagname='[last_name]';
insert into mailandsmstemplatetag set usertypeID = 12,create_date=1560342432,tagname='[pnr_ref]';

CREATE TABLE `mailandsmscategory` (
  `catID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `alias` varchar(128) NOT NULL,  
  PRIMARY KEY (`catID`)
);

insert into mailandsmscategory set name='Offer Mail',alias='offer_mail';


insert into mailandsmstemplatetag set usertypeID = 12,create_date=1560342432,tagname='[mail_logo]';
insert into mailandsmstemplatetag set usertypeID = 12,create_date=1560342432,tagname='[temp1_img]';
insert into mailandsmstemplatetag set usertypeID = 12,create_date=1560342432,tagname='[temp2_img]';
insert into mailandsmstemplatetag set usertypeID = 12,create_date=1560342432,tagname='[temp3_img]';
