CREATE DATABASE movies;

USE movies;

CREATE TABLE
    movies (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(150) NOT NULL,
        director VARCHAR(100),
        genre ENUM ('Comedy', 'Thriller', 'Action', 'Drama', 'Sci-Fi'),
        manufacture_year YEAR,
        rating DECIMAL(3, 1),
        oscar_win BOOLEAN,
        added_at TIMESTAMP
    );

INSERT INTO
    movies (
        title,
        director,
        genre,
        manufacture_year,
        rating,
        oscar_win,
        added_at
    )
VALUES
    (
        'Звёздные войны. Эпизод IV',
        'Джордж Лукас',
        'Sci-Fi',
        1977,
        8.6,
        TRUE,
        '2026-03-08 15:30:00'
    ),
    (
        'Крёстный отец',
        'Фрэнсис Форд Коппола',
        'Drama',
        1972,
        9.2,
        TRUE,
        '2026-03-08 15:35:00'
    ),
    (
        'Терминатор',
        'Джеймс Кэмерон',
        'Action',
        1984,
        8.0,
        FALSE,
        '2026-03-08 15:40:00'
    ),
    (
        'Лицо со шрамом',
        'Брайан Де Пальма',
        'Drama',
        1983,
        8.3,
        FALSE,
        '2026-03-08 15:45:00'
    ),
    (
        'Титаник',
        'Джеймс Кэмерон',
        'Drama',
        1997,
        8.4,
        TRUE,
        '2026-03-08 15:50:00'
    ),
    (
        'Мстители',
        'Джосс Уидон',
        'Action',
        2012,
        7.9,
        FALSE,
        '2026-03-08 15:55:00'
    );

SELECT
    *
FROM
    movies;