USE `population_db`;

-- 1 Представления видов (VIEWS)
CREATE OR REPLACE VIEW `v_citizen_details` AS
SELECT 
    `c`.`id`,
    `c`.`first_name`,
    `c`.`last_name`,
    `c`.`birth_date`,
    `g`.`name` AS `gender`,
    `m`.`name` AS `marital_status`,
    `ct`.`name` AS `city`,
    `r`.`name` AS `region`,
    `co`.`name` AS `country`
FROM `citizens` AS `c`
JOIN `genders` AS `g` ON `c`.`gender_id` = `g`.`id`
JOIN `marital_statuses` AS `m` ON `c`.`marital_status_id` = `m`.`id`
JOIN `cities` AS `ct` ON `c`.`city_id` = `ct`.`id`
JOIN `regions` AS `r` ON `ct`.`region_id` = `r`.`id`
JOIN `countries` AS `co` ON `r`.`country_id` = `co`.`id`;

-- 2 Процедуры   
-- Процедура для оформления переезда гражданина
DELIMITER //

CREATE PROCEDURE `register_migration`(
    IN `p_citizen_id` INT UNSIGNED,
    IN `p_new_city_id` INT UNSIGNED,
    IN `p_migration_date` DATE
)
BEGIN
    DECLARE `v_old_city_id` INT UNSIGNED;

    -- Получаем текущий город гражданина
    SELECT `city_id` INTO `v_old_city_id`
    FROM `citizens`
    WHERE `id` = `p_citizen_id`;

    -- Обновляем город в таблице граждан
    UPDATE `citizens`
    SET `city_id` = `p_new_city_id`
    WHERE `id` = `p_citizen_id`;

    -- Записываем историю миграции
    INSERT INTO `migration_records` (`citizen_id`, `from_city_id`, `to_city_id`, `migration_date`)
    VALUES (`p_citizen_id`, `v_old_city_id`, `p_new_city_id`, `p_migration_date`);
END//

DELIMITER ;

-- 3 Триггеры
-- Триггер на добавление гражданина: увеличивает счетчик населения страны (population_cache)
DELIMITER //

CREATE TRIGGER `trg_after_citizen_insert`
AFTER INSERT ON `citizens`
FOR EACH ROW
BEGIN
    DECLARE `v_country_id` INT UNSIGNED;

    -- Находим страну, к которой относится город нового гражданина
    SELECT `r`.`country_id` INTO `v_country_id`
    FROM `cities` AS `ct`
    JOIN `regions` AS `r` ON `ct`.`region_id` = `r`.`id`
    WHERE `ct`.`id` = NEW.`city_id`;

    -- Обновляем кэш населения в таблице стран
    UPDATE `countries`
    SET `population_cache` = `population_cache` + 1
    WHERE `id` = `v_country_id`;
END//

DELIMITER ;