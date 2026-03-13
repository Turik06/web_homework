SELECT
    *
FROM
    clients
WHERE
    name = 'Gary'
    AND lastname = 'Harrison';

UPDATE clients
SET
    dbirth = '1930-10-21'
WHERE
    name = 'Gary'
    AND lastname = 'Harrison'
LIMIT
    1;

SELECT
    *
FROM
    clients
WHERE
    name = 'Michael'
    AND lastname = 'Atwood';

UPDATE clients
SET
    dbirth = '1934-04-12'
WHERE
    name = 'Michael'
    AND lastname = 'Atwood'
LIMIT
    1;

SELECT
    *
FROM
    clients
WHERE
    name = 'Amy'
    AND lastname = 'Majors';

UPDATE clients
SET
    dbirth = '1975-08-01'
WHERE
    name = 'Amy'
    AND lastname = 'Majors'
LIMIT
    1;

SELECT
    *
FROM
    clients
WHERE
    name = 'Katherine'
    AND lastname = 'Smith';

UPDATE clients
SET
    dbirth = '1959-09-22'
WHERE
    name = 'Katherine'
    AND lastname = 'Smith'
LIMIT
    1;

SELECT
    *
FROM
    clients
WHERE
    dbirth < '1933-01-01';

UPDATE clients
SET
    phone = NULL
WHERE
    dbirth < '1933-01-01'
LIMIT
    13;

SELECT
    *
FROM
    clients
WHERE
    name = 'John'
    AND lastname = 'Ohara';

UPDATE clients
SET
    name = 'Johanna',
    gender = 'F'
WHERE
    name = 'John'
    AND lastname = 'Ohara'
LIMIT
    1;

SELECT
    *
FROM
    clients
WHERE
    name = 'Humberto'
    AND lastname = 'Hoosier';

UPDATE clients
SET
    phone = '79990001122'
WHERE
    name = 'Humberto'
    AND lastname = 'Hoosier'
LIMIT
    1;

SELECT
    *
FROM
    clients
WHERE
    name = 'Irene'
    AND lastname = 'Schreiber';

UPDATE clients
SET
    phone = '79993334455'
WHERE
    name = 'Irene'
    AND lastname = 'Schreiber'
LIMIT
    1;

SELECT
    *
FROM
    clients
WHERE
    name = 'Donna'
    AND lastname = 'Wallace';

UPDATE clients
SET
    phone = '79996667788'
WHERE
    name = 'Donna'
    AND lastname = 'Wallace'
LIMIT
    1;

SELECT
    *
FROM
    clients
WHERE
    id IN (215, 340, 449, 470, 607);

DELETE FROM clients
WHERE
    id IN (215, 340, 449, 470, 607)
LIMIT
    4;

SELECT
    *
FROM
    clients
WHERE
    gender = 'M'
    AND (
        (dbirth BETWEEN '1941-01-01' AND '1941-04-30')
        OR (dbirth BETWEEN '1972-09-10' AND '1972-09-15')
    );

DELETE FROM clients
WHERE
    gender = 'M'
    AND (
        (dbirth BETWEEN '1941-01-01' AND '1941-04-30')
        OR (dbirth BETWEEN '1972-09-10' AND '1972-09-15')
    )
LIMIT
    2;

CREATE TABLE
    IF NOT EXISTS my_table (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255),
        category_id INT,
        price INT DEFAULT 0,
        description TEXT,
        status VARCHAR(50),
        is_deleted TINYINT DEFAULT 0,
        created_at DATE
    );

INSERT IGNORE INTO my_table (
    id,
    name,
    category_id,
    price,
    description,
    status,
    created_at
)
VALUES
    (
        5,
        'Старый товар',
        1,
        100,
        'Текст',
        'active',
        '2023-05-01'
    ),
    (
        10,
        'Предмет 1',
        2,
        1000,
        'Инфо',
        'active',
        '2023-06-01'
    ),
    (
        15,
        'Предмет 2',
        3,
        500,
        NULL,
        'active',
        '2023-07-01'
    ),
    (
        20,
        'Предмет 3',
        4,
        300,
        'Инфо',
        'expired',
        '2023-08-01'
    ),
    (
        25,
        'Предмет 4',
        5,
        100,
        'Инфо',
        'active',
        '2022-12-01'
    );

SELECT
    *
FROM
    my_table
WHERE
    id = 5;

UPDATE my_table
SET
    name = 'Новое имя'
WHERE
    id = 5
LIMIT
    1;

SELECT
    *
FROM
    my_table
WHERE
    category_id = 2;

UPDATE my_table
SET
    price = price + 500
WHERE
    category_id = 2
LIMIT
    5;

SELECT
    *
FROM
    my_table
WHERE
    description IS NULL;

UPDATE my_table
SET
    description = 'Нет данных'
WHERE
    description IS NULL
LIMIT
    3;

SELECT
    *
FROM
    my_table
WHERE
    status = 'expired';

UPDATE my_table
SET
    is_deleted = 1
WHERE
    status = 'expired'
LIMIT
    2;

SELECT
    *
FROM
    my_table
WHERE
    created_at < '2023-01-01';

DELETE FROM my_table
WHERE
    created_at < '2023-01-01'
LIMIT
    4;