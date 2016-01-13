CREATE TABLE `reg_batch_exam_centers` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`batch_id` INT(11) NOT NULL,
	`name` VARCHAR(50) NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `FK__reg_batch` (`batch_id`)
)
ENGINE=InnoDB
;

ALTER TABLE `reg_user_detail`
	ALTER `college_and_address` DROP DEFAULT;
ALTER TABLE `reg_user_detail`
	CHANGE COLUMN `college_and_address` `exam_center_id` INT NOT NULL AFTER `dob`,
	ADD INDEX `exam_center_id` (`exam_center_id`);
ALTER TABLE `reg_batch`
	DROP COLUMN `examination_center`;
ALTER TABLE `reg_batch`
	ADD COLUMN `restricted_age` TINYINT(4) NOT NULL DEFAULT '16' AFTER `status`;
ALTER TABLE `reg_user_detail`
	ADD COLUMN `payment_mathod` TINYINT NOT NULL AFTER `academic_year`,
	ADD COLUMN `payment_date` DATE NULL AFTER `payment_mathod`,
	ADD COLUMN `bank_branch` VARCHAR(50) NULL AFTER `payment_date`;

ALTER TABLE `reg_user_detail`
	ADD COLUMN `address` TEXT NOT NULL AFTER `bank_branch`;