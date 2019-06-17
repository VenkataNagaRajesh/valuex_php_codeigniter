alter table VX_aln_offer_ref add column miles int(11) DEFAULT 0;
update VX_aln_offer_ref set miles=500000;