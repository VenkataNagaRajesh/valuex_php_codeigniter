update mailandsmscategory set name="Upgrade Offer",alias='upgrade_offer';
insert into mailandsmscategory set name="Bid Accept",alias='bid_accepted';
insert into mailandsmscategory set name="Bid Reject",alias='bid_reject';
insert into mailandsmscategory set name="Bid Success",alias='bid_success';


alter table mailandsmstemplate drop column type;
alter table mailandsmstemplate drop column usertypeID;
alter table mailandsmstemplate drop column create_date;
alter table mailandsmstemplate modify column name text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE mailandsmstemplate CONVERT TO CHARACTER SET utf8;
alter table mailandsmstemplate add column create_userID int(11) NOT NULL;
alter table mailandsmstemplate add column modify_userID int(11) NOT NULL;
alter table mailandsmstemplate add column create_date int(11) NOT NULL;
alter table mailandsmstemplate add column modify_date int(11) NOT NULL;
