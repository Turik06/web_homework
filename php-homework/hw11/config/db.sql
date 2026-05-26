CREATE DATABASE IF NOT EXISTS `calendar_db`;
USE `calendar_db`;

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `theme` VARCHAR(255) NOT NULL,
  `type` ENUM('Встреча', 'Звонок', 'Совещание', 'Дело') NOT NULL DEFAULT 'Дело',
  `place` VARCHAR(255) DEFAULT NULL,
  `task_datetime` DATETIME NOT NULL,
  `duration` VARCHAR(50) DEFAULT NULL,
  `comment` TEXT,
  `status` ENUM('Текущая', 'Выполнена') NOT NULL DEFAULT 'Текущая',
  PRIMARY KEY (`id`)
);