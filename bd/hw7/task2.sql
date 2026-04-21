-- 1
-- a
SELECT `date`, SUM(`hits`), SUM(`loads`) 
FROM `stats` 
GROUP BY `date`;

-- b
SELECT `country`, SUM(`hits`), SUM(`loads`) 
FROM `stats` 
GROUP BY `country`;

-- c
SELECT `date`, `country`, SUM(`hits`), SUM(`loads`) 
FROM `stats` 
GROUP BY `date`, `country`;

-- 2
-- a
SELECT `date`, AVG(`hits`) 
FROM `stats` 
GROUP BY `date`;

-- b
SELECT `country`, AVG(`hits`) 
FROM `stats` 
GROUP BY `country`;

-- 3
-- a
SELECT `date`, AVG(`loads`) 
FROM `stats` 
GROUP BY `date`;

-- b
SELECT `country`, AVG(`loads`) 
FROM `stats` 
GROUP BY `country`;

-- 4
-- a
SELECT `date`, MIN(`loads`), MAX(`loads`) 
FROM `stats` 
GROUP BY `date`;

-- b
SELECT `country`, MIN(`loads`), MAX(`loads`) 
FROM `stats` 
GROUP BY `country`;

-- 5
SELECT `date`, SUM(`loads`) / SUM(`hits`) AS conversion 
FROM `stats` 
GROUP BY `date`;

-- 6
SELECT `date`, SUM(`loads`) / SUM(`hits`) AS conversion 
FROM `stats` 
GROUP BY `date` 
ORDER BY conversion DESC 
LIMIT 1;

-- 7
SELECT `country`, SUM(`loads`) / SUM(`hits`) AS conversion 
FROM `stats` 
GROUP BY `country` 
ORDER BY conversion DESC 
LIMIT 5;

-- 8
SELECT *, (`loads` / `hits`) AS conversion 
FROM `stats` 
ORDER BY conversion DESC;