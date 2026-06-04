USE `population_db`;

-- Тест 1: Проверка Представления
-- Получаем детальную информацию о первых 5 гражданах
SELECT '--- TEST 1: VIEW v_citizen_details ---' AS 'Info';
SELECT * FROM `v_citizen_details` LIMIT 5;

-- Тест 2: Проверка Хранимой процедуры (Переезд гражданина)
-- Переезжает Дмитрий Попов (id 3) из Ангарска (id 3) в Братск (id 2)
SELECT '--- TEST 2: PROCEDURE register_migration ---' AS 'Info';
CALL `register_migration`(3, 2, '2026-06-04');
-- Проверяем результат в истории (должна появиться новая запись о миграции для id 3)
SELECT * FROM `migration_records` WHERE `citizen_id` = 3 ORDER BY `id` DESC LIMIT 1;

-- Тест 3: Проверка Триггера (Подсчет населения)
-- Смотрим население России до и после добавления нового гражданина
SELECT '--- TEST 3: TRIGGER trg_after_citizen_insert ---' AS 'Info';
SELECT `name`, `population_cache` FROM `countries` WHERE `id` = 1;
INSERT INTO `citizens` (`first_name`, `last_name`, `birth_date`, `gender_id`, `marital_status_id`, `city_id`) 
VALUES ('Тест', 'Тестович', '2026-06-04', 1, 1, 1);
SELECT `name`, `population_cache` FROM `countries` WHERE `id` = 1;