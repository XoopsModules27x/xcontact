CREATE TABLE `xcontact_forms` (
    `form_id`     INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`        VARCHAR(255) NOT NULL DEFAULT '',
    `slug`        VARCHAR(100) NOT NULL DEFAULT '',
    `description` TEXT NOT NULL,
    `fields`      LONGTEXT NOT NULL,
    `settings`    TEXT NOT NULL,
    `is_active`   TINYINT(1) NOT NULL DEFAULT 1,
    `created_at`  INT(10) UNSIGNED NOT NULL DEFAULT 0,
    `submitter`   INT(10) UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (`form_id`),
    UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB;

CREATE TABLE `xcontact_submissions` (
    `sub_id`     INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `form_id`    INT(10) UNSIGNED NOT NULL,
    `data`       LONGTEXT NOT NULL,
    `ip`         VARCHAR(45) NOT NULL DEFAULT '',
    `status`     TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` INT(10) UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (`sub_id`),
    KEY `form_id` (`form_id`),
    KEY `status` (`status`)
) ENGINE=InnoDB;
