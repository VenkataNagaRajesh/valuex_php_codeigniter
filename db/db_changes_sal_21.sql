
CREATE TABLE `VX_aln_event_status` (
  `es_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
   `event_id` int(11) NOT NULL,
  `current_status` int(11) NOT NULL,
  `next_status` int(11) NOT NULL,
  `isInternalStatus` tinyint(1) NOT NULL DEFAULT '0',
  `create_date` int(11) NOT NULL,
  `modify_date` int(11) NOT NULL,
  `create_userID` int(11) NOT NULL,
  `modify_userID` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
    PRIMARY KEY (`es_id`),
  KEY `event_id_index` (`event_id`),
  KEY `current_status_index` (`current_status`),
  KEY `next_status_index` (`next_status`),
  KEY `isInternalStatus_index` (`isInternalStatus`),
  KEY `modify_date_index` (`modify_date`),
  KEY `create_date_index` (`create_date`),
  KEY `create_userID_index` (`create_userID`),
  KEY `modify_userID_index` (`modify_userID`),
  KEY `active_index` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ;



insert into menu (menuName,link,icon,status,parentID,priority) values ('event_status','event_status','icon-template','1','0','1000');
insert into permissions (description,name,active) values ('Event Status','event_status','yes');

insert into permissions (description,name,active) values ('Event Status Add','event_status_add','yes');
insert into permissions (description,name,active) values ('Event Status Delete','event_status_delete','yes');
insert into permissions (description,name,active) values ('Event Status Edit','event_status_edit','yes');



insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,alias,create_userID,modify_userID,create_date,modify_date) values ('20','New','New','1','1','1554788423','1554788423');
insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,alias,create_userID,modify_userID,create_date,modify_date) values ('20','Excluded','Excl','1','1','1554788423','1554788423');

update vx_aln_data_defns  set alias='new', code='NULL' where aln_data_typeID = 20 AND aln_data_value = 'New';

update vx_aln_data_defns  set alias='excl', code='NULL' where aln_data_typeID = 20 AND aln_data_value = 'Excluded';

insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,alias,create_userID,modify_userID,create_date,modify_date) values ('20','Create Booking','create_booking','1','1','1554788423','1554788423');
insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,alias,create_userID,modify_userID,create_date,modify_date) values ('20','Staff Cancel Booking','staff_cancel_booking','1','1','1554788423','1554788423');

insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,alias,create_userID,modify_userID,create_date,modify_date) values ('20','Send Offer Mail','send_offer_mail','1','1','1554788423','1554788423');
insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,alias,create_userID,modify_userID,create_date,modify_date) values ('20','Staff Booking Reset','staff_booking_reset','1','1','1554788423','1554788423');

insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,alias,create_userID,modify_userID,create_date,modify_date) values ('20','Re-send  Email','resend_email','1','1','1554788423','1554788423');
insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,alias,create_userID,modify_userID,create_date,modify_date) values ('20','User Bid','user_bid','1','1','1554788423','1554788423');

insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,alias,create_userID,modify_userID,create_date,modify_date) values ('20','Booking Approval','booking_approval','1','1','1554788423','1554788423');
insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,alias,create_userID,modify_userID,create_date,modify_date) values ('20','Payment initiate Process','payment_ini_process','1','1','1554788423','1554788423');

insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,alias,create_userID,modify_userID,create_date,modify_date) values ('20','Booking Confirmation','booking_confirmation','1','1','1554788423','1554788423');
insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,alias,create_userID,modify_userID,create_date,modify_date) values ('20','Send New Booking Email','send_new_bkg_email','1','1','1554788423','1554788423');





insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,alias,create_userID,modify_userID,create_date,modify_date) values ('20','NA','na','1','1','1554788423','1554788423');
insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,alias,create_userID,modify_userID,create_date,modify_date) values ('20','Booking Cancelled','booking_cancelled','1','1','1554788423','1554788423');


insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,alias,create_userID,modify_userID,create_date,modify_date) values ('20','Send Offer Mail Failed','send_offer_mail_fail','1','1','1554788423','1554788423');
insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,alias,create_userID,modify_userID,create_date,modify_date) values ('20','Send Offer Mail','send_offer_mail','1','1','1554788423','1554788423');

insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,alias,create_userID,modify_userID,create_date,modify_date) values ('20','Bid In Progress','bid_in_progress','1','1','1554788423','1554788423');
insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,alias,create_userID,modify_userID,create_date,modify_date) values ('20','Bid Completed','bid_complete','1','1','1554788423','1554788423');


insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,alias,create_userID,modify_userID,create_date,modify_date) values ('20','Bid Accepted','bid_accepted','1','1','1554788423','1554788423');
insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,alias,create_userID,modify_userID,create_date,modify_date) values ('20','Payment Failed','payment_failed','1','1','1554788423','1554788423');

insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,alias,create_userID,modify_userID,create_date,modify_date) values ('20','Payment Success','payment_success','1','1','1554788423','1554788423');
insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,alias,create_userID,modify_userID,create_date,modify_date) values ('20','Booking Confirmed','booking_confirmed','1','1','1554788423','1554788423');





insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,alias,create_userID,modify_userID,create_date,modify_date) values ('20','Sent Offer Mail','sent_offer_mail','1','1','1554788423','1554788423');


insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,alias,create_userID,modify_userID,create_date,modify_date) values ('20','Send Offer Mail Failed','sent_offer_mail_fail','1','1','1554788423','1554788423');
insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,alias,create_userID,modify_userID,create_date,modify_date) values ('20','Bid Cancelled','bid_cancel','1','1','1554788423','1554788423');

insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,alias,create_userID,modify_userID,create_date,modify_date) values ('20','BID Failed','bid_fail','1','1','1554788423','1554788423');
insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,alias,create_userID,modify_userID,create_date,modify_date) values ('20','Booking Hold','booking_hold','1','1','1554788423','1554788423');
insert into vx_aln_data_defns (aln_data_typeID,aln_data_value,alias,create_userID,modify_userID,create_date,modify_date) values ('20','Sent Confirmation Mail','sent_confirm_mail','1','1','1554788423','1554788423');
