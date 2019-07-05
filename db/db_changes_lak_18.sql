alter table VX_aln_bid drop column cash;
alter table VX_aln_bid drop column miles;
alter table VX_aln_offer_ref add column cash int(11) DEFAULT 0;
alter table VX_aln_offer_ref add column miles int(11) DEFAULT 0;
alter table VX_aln_offer_ref add column cash_percentage decimal(10,2) DEFAULT 0;