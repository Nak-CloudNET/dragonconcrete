/*------ Nak add location on 27/07/2018 -------*/
ALTER TABLE `erp_deliveries`
ADD COLUMN `location`  longtext NULL AFTER `pos`;