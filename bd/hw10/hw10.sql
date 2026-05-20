DELIMITER $$

-- Задание 1:
CREATE OR REPLACE FUNCTION fn_is_jubilee (birth_date DATE)
RETURNS INT
DETERMINISTIC
BEGIN
    DECLARE age INT;
    SET age = YEAR(CURDATE()) - YEAR(birth_date);
    IF age > 0 AND age % 5 = 0 THEN
        RETURN age;
    ELSE
        RETURN NULL;
    END IF;
END $$

-- Задание 2: 
CREATE OR REPLACE FUNCTION fn_format_fio (fio VARCHAR(255))
RETURNS VARCHAR(255)
DETERMINISTIC
BEGIN
    DECLARE last VARCHAR(100);
    DECLARE first VARCHAR(100);
    DECLARE mid VARCHAR(100);
    SET fio = TRIM(fio);
    SET last = SUBSTRING_INDEX(fio, ' ', 1);
    SET first = SUBSTRING_INDEX(SUBSTRING_INDEX(fio, ' ', 2), ' ', -1);
    SET mid = SUBSTRING_INDEX(SUBSTRING_INDEX(fio, ' ', 3), ' ', -1);
    
    IF last = first OR first = mid THEN
        RETURN '######';
    ELSE
        RETURN CONCAT(last, ' ', LEFT(first, 1), '.', LEFT(mid, 1), '.');
    END IF;
END $$

-- Задание 3:
CREATE OR REPLACE FUNCTION fn_salesman_income (rate DECIMAL(4,2), total_sum DECIMAL(10,2))
RETURNS DECIMAL(10,2)
DETERMINISTIC
BEGIN
    RETURN rate * total_sum;
END $$

-- Задание 4: 
CREATE OR REPLACE FUNCTION fn_company_income (price DECIMAL(10,2), qty INT)
RETURNS DECIMAL(10,2)
DETERMINISTIC
BEGIN
    RETURN price * qty;
END $$

-- Задание 5:
CREATE OR REPLACE PROCEDURE sp_get_jubilees ()
BEGIN
    SELECT 
        CONCAT(last_name, ' ', first_name, ' ', middle_name) AS ФИО,
        birth_date AS Дата_рождения,
        fn_is_jubilee(birth_date) AS Возраст
    FROM salesmen
    WHERE fn_is_jubilee(birth_date) IS NOT NULL;
END $$

-- Задание 6: 
CREATE OR REPLACE PROCEDURE sp_products_by_group (IN g_id INT)
BEGIN
    SELECT 
        p.name AS Товар, 
        g.name AS Группа, 
        p.plu AS Артикул, 
        p.cost AS Цена, 
        p.available AS Наличие
    FROM products AS p, groups AS g
    WHERE p.group_id = g.id AND p.group_id = g_id;
END $$

-- Задание 7:
CREATE OR REPLACE PROCEDURE sp_product_sales_period (IN prod_name VARCHAR(255), IN days INT)
BEGIN
    DECLARE interval_d INT;
    SET interval_d = IF(days IN (7, 14, 30), days, 7);

    SELECT 
        p.name AS Товар,
        fn_format_fio(CONCAT(s.last_name, ' ', s.first_name, ' ', s.middle_name)) AS Торгпред,
        o.date AS Дата
    FROM orders AS o, products AS p, salesmen AS s
    WHERE o.product_id = p.id AND o.salesman_id = s.id
      AND p.name = prod_name
      AND o.date >= DATE_SUB(CURDATE(), INTERVAL interval_d DAY);
END $$

-- Задание 8: 
CREATE OR REPLACE PROCEDURE sp_check_price_discrepancies ()
BEGIN
    IF NOT EXISTS (
        SELECT 1 FROM orders AS o, products AS p 
        WHERE o.product_id = p.id AND o.price != p.cost
        AND (p.cost_changed_at IS NULL OR p.cost_changed_at <= o.date)
    ) THEN
        SELECT 'Все цены соответствуют' AS Результат;
    ELSE
        SELECT o.id AS ID_заказа, p.name AS Товар, o.price AS Цена_в_чеке, p.cost AS Базовая_цена
        FROM orders AS o, products AS p
        WHERE o.product_id = p.id AND o.price != p.cost
        AND (p.cost_changed_at IS NULL OR p.cost_changed_at <= o.date);
    END IF;
END $$

DELIMITER ;