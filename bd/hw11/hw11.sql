USE test_db;

-- Создание дополнительной таблицы 
CREATE TABLE IF NOT EXISTS `price_logs` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` INT UNSIGNED NOT NULL,
  `old_cost` DECIMAL(10,2) DEFAULT NULL,
  `new_cost` DECIMAL(10,2) DEFAULT NULL,
  `changed_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`)
);

-- Триггер на изменение цены в таблице товаров
DELIMITER //

CREATE TRIGGER `after_product_cost_update` 
AFTER UPDATE ON `products` 
FOR EACH ROW 
BEGIN
    IF OLD.cost <> NEW.cost THEN
        INSERT INTO `price_logs` (`product_id`, `old_cost`, `new_cost`, `changed_at`) 
        VALUES (NEW.id, OLD.cost, NEW.cost, NOW());
    END IF;
END//

DELIMITER ;

-- Триггер на удаление группы товаров
DELIMITER //

CREATE TRIGGER `before_group_delete` 
BEFORE DELETE ON `groups` 
FOR EACH ROW 
BEGIN
    UPDATE `products` 
    SET `group_id` = NULL, 
        `available` = 0
    WHERE `group_id` = OLD.id;
END//

DELIMITER ;