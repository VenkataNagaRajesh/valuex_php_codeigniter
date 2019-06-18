alter table VX_aln_offer_ref add column miles int(11) DEFAULT 0;
update VX_aln_offer_ref set miles=500000;


alter table VX_aln_bid drop column create_userID;
alter table VX_aln_bid drop column modify_userID;
alter table VX_aln_bid drop column create_date;
alter table VX_aln_bid drop column modify_date;

CREATE TABLE `vx_aln_card_data` (
  `card_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `offer_id` int(11) NOT NULL,
  `card_number` text NOT NULL,
  `month_expiry` tinyint(2) NOT NULL,
  `year_expiry` tinyint(2) NOT NULL DEFAULT '0',
  `cvv`  char(3) NOT NULL DEFAULT '0',
  `date_added` int(11) NOT NULL,
  PRIMARY KEY (`card_id`)  
)