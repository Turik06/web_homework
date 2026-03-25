-- Задание 1
-- Задание 1
SELECT
    id,
    UPPER(name) AS name_upper,
    LOWER(name) AS name_lower
FROM
    clients;

-- Задание 2
SELECT
    CONCAT_WS (' ', lastname, name) AS full_name,
    CONCAT (
        LEFT (phone, 3),
        REPEAT ('*', CHAR_LENGTH(phone) - 4),
        RIGHT (phone, 1)
    ) AS phone_number
FROM
    clients;

-- Задание 3
SELECT
    CONCAT (LEFT (name, 1), '. ', lastname) AS short_name
FROM
    clients
WHERE
    INSTR (lastname, 'tt') > 0
    OR INSTR (lastname, 'ss') > 0
    OR INSTR (lastname, 'll') > 0;

-- Задание 4
-- а) Начинаются на 586
SELECT
    *
FROM
    clients
WHERE
    LEFT (phone, 3) = '586';

SELECT
    *
FROM
    clients
WHERE
    SUBSTRING(phone, 1, 3) = '586';

SELECT
    *
FROM
    clients
WHERE
    POSITION('586' IN phone) = 1;

SELECT
    *
FROM
    clients
WHERE
    LOCATE ('586', phone) = 1;

SELECT
    *
FROM
    clients
WHERE
    INSTR (phone, '586') = 1;

-- б) Содержат 657
SELECT
    *
FROM
    clients
WHERE
    LOCATE ('657', phone) > 0;

SELECT
    *
FROM
    clients
WHERE
    POSITION('657' IN phone) > 0;

SELECT
    *
FROM
    clients
WHERE
    INSTR (phone, '657') > 0;

-- в) Заканчиваются на 707
SELECT
    *
FROM
    clients
WHERE
    RIGHT (phone, 3) = '707';

SELECT
    *
FROM
    clients
WHERE
    SUBSTRING(phone, CHAR_LENGTH(phone) - 2) = '707';

SELECT
    *
FROM
    clients
WHERE
    LEFT (REVERSE (phone), 3) = REVERSE ('707');

SELECT
    *
FROM
    clients
WHERE
    LOCATE ('707', phone) = CHAR_LENGTH(phone) - 2;