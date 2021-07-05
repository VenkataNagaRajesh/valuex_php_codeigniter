ALTER TABLE `VX_contract_products` CHANGE modify_date modify_date DATETIME DEFAULT NULL;

ALTER TABLE `VX_contract_products` CHANGE start_date start_date DATETIME DEFAULT NULL;

ALTER TABLE `VX_contract_products` CHANGE end_date end_date DATETIME DEFAULT NULL;

ALTER TABLE `VX_contract_products` CHANGE create_date create_date DATETIME DEFAULT NULL;

ALTER TABLE VX_contract_products MODIFY no_users VARCHAR(11);