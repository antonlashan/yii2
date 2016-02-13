
ALTER TABLE `reg_user_detail`
	ADD COLUMN `boc_account_no` VARCHAR(20) NULL DEFAULT NULL AFTER `address`,
	ADD COLUMN `boc_branch` VARCHAR(50) NULL DEFAULT NULL AFTER `boc_account_no`;