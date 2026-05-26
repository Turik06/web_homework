CREATE DATABASE IF NOT EXISTS `calendar_db`;
USE `calendar_db`;

-- Таблица пользователей
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
);

-- Таблица задач
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(10) UNSIGNED NOT NULL, -- Ссылка на владельца задачи
  `theme` VARCHAR(255) NOT NULL,
  `type` ENUM('Встреча', 'Звонок', 'Совещание', 'Дело') NOT NULL DEFAULT 'Дело',
  `place` VARCHAR(255) DEFAULT NULL,
  `task_datetime` DATETIME NOT NULL,
  `duration` VARCHAR(50) DEFAULT NULL,
  `comment` TEXT,
  `status` ENUM('Текущая', 'Выполнена') NOT NULL DEFAULT 'Текущая',
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);