USE test_db;

-- ТЕСТ 1
UPDATE `products` SET `cost` = 9999.99 WHERE `id` = 1;

SELECT * FROM `price_logs`; 


-- ТЕСТ 2
INSERT INTO `groups` (`id`, `name`) VALUES (999, 'Тестовая группа для удаления');

UPDATE `products` SET `group_id` = 999 WHERE `id` = 2;

DELETE FROM `groups` WHERE `id` = 999;

SELECT `id`, `name`, `group_id`, `available` FROM `products` WHERE `id` = 2;