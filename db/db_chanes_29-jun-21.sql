ALTER TABLE `VX_contract_products` CHANGE start_date start_date DATETIME DEFAULT NULL

ALTER TABLE `VX_contract_products` CHANGE end_date end_date DATETIME DEFAULT NULL

ALTER TABLE `VX_contract_products` CHANGE create_date create_date DATETIME DEFAULT NULL

ALTER TABLE VX_contract_products ALTER modify_date SET datetime NUll;

ALTER TABLE VX_contract_products MODIFY no_users VARCHAR(11);

delete from VX_preference where vx_aln_preferenceID=199;

delete from VX_preference where vx_aln_preferenceID=200;

delete from VX_preference where vx_aln_preferenceID=201;

delete from VX_preference where vx_aln_preferenceID=202;

delete from VX_preference where vx_aln_preferenceID=203;

delete from VX_preference where vx_aln_preferenceID=204;

delete from VX_preference where vx_aln_preferenceID=205;

delete from VX_preference where vx_aln_preferenceID=206;

delete from VX_preference where vx_aln_preferenceID=207;

delete from VX_preference where vx_aln_preferenceID=208;

delete from VX_preference where vx_aln_preferenceID=209;

delete from VX_preference where vx_aln_preferenceID=210;

delete from VX_preference where vx_aln_preferenceID=178;

delete from VX_preference where vx_aln_preferenceID=211;

delete from VX_preference where vx_aln_preferenceID=212;

delete from VX_preference where vx_aln_preferenceID=213;

delete from VX_preference where vx_aln_preferenceID=214;

delete from VX_preference where vx_aln_preferenceID=216;

delete from VX_preference where vx_aln_preferenceID=196;

delete from VX_preference where vx_aln_preferenceID=219;

