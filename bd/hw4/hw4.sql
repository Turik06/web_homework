-- Задание 1
SELECT
    id,
    name,
    lastname,
    YEAR (dbirth) AS birth_year
FROM
    clients;

-- Задание 2
SELECT
    id,
    name,
    lastname,
    TIMESTAMPDIFF(YEAR, dbirth, CURDATE()) AS age_full,
    YEAR(CURDATE()) - YEAR(dbirth) AS age_by_end_of_year
FROM
    clients;

-- Задание 3
SELECT 
    id, 
    name, 
    lastname,
    TIMESTAMPDIFF(YEAR, dbirth, '1992-12-08') AS age_in_1992,
    TIMESTAMPDIFF(YEAR, dbirth, '2024-07-15') AS age_in_2024
FROM clients;

-- Задание 4а
SELECT
    id,
    dbirth
FROM
    clients
WHERE
    DATE_FORMAT(dbirth, CONCAT(YEAR(CURDATE()), '-%m-%d')) BETWEEN CURDATE() AND (CURDATE() + INTERVAL 1 WEEK);

-- Задание 4б
SELECT
    id,
    dbirth
FROM
    clients
WHERE
    DATE_FORMAT(dbirth, CONCAT(YEAR(CURDATE()), '-%m-%d')) BETWEEN CURDATE() AND (CURDATE() + INTERVAL 2 WEEK);

-- Задание 4в
SELECT
    id,
    dbirth
FROM
    clients
WHERE
    DATE_FORMAT(dbirth, CONCAT(YEAR(CURDATE()), '-%m-%d')) BETWEEN CURDATE() AND LAST_DAY(CURDATE());