-- 1 
-- a
SELECT COUNT(*) AS total_clients FROM clients;
-- b
SELECT COUNT(*) AS born_after_1990 FROM clients WHERE YEAR(dbirth) > 1990;
-- c
SELECT name, COUNT(*) AS count_names 
FROM clients 
WHERE name IN ('Thomas', 'Barbara', 'Willie') 
GROUP BY name;

-- 2
-- a
SELECT YEAR(dbirth) AS birth_year, COUNT(*) AS total 
FROM clients 
GROUP BY YEAR(dbirth) 
ORDER BY birth_year;
-- b
SELECT YEAR(dbirth) AS birth_year, gender, COUNT(*) AS total 
FROM clients 
GROUP BY YEAR(dbirth), gender 
ORDER BY birth_year, gender;

-- 3
SELECT MONTH(dbirth) AS birth_month, COUNT(*) AS total 
FROM clients 
GROUP BY MONTH(dbirth) 
ORDER BY birth_month;

-- 4 a,b,c
SELECT 
    AVG(TIMESTAMPDIFF(YEAR, dbirth, CURDATE())) AS avg_age,
    MIN(TIMESTAMPDIFF(YEAR, dbirth, CURDATE())) AS min_age,
    MAX(TIMESTAMPDIFF(YEAR, dbirth, CURDATE())) AS max_age
FROM clients;

-- 5
SELECT 
    FLOOR(YEAR(dbirth) / 10) * 10 AS decade, 
    GROUP_CONCAT(DISTINCT name ORDER BY name SEPARATOR ', ') AS unique_names
FROM clients 
WHERE YEAR(dbirth) BETWEEN 1960 AND 1999
GROUP BY decade
ORDER BY decade;

-- 6
SELECT 
    FLOOR(YEAR(dbirth) / 10) * 10 AS decade, 
    gender, 
    COUNT(*) AS total_clients
FROM clients 
WHERE YEAR(dbirth) BETWEEN 1940 AND 1979
GROUP BY decade, gender
ORDER BY decade, gender;