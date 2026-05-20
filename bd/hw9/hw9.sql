-- Задание 1:
CREATE TABLE IF NOT EXISTS `subject_schedules_time` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `subject_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
  `date` DATE NOT NULL,
  `start_time` TIME NOT NULL,
  `end_time` TIME NOT NULL,
  PRIMARY KEY (`id`),
  KEY `subject_id` (`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Задание 2: 
INSERT INTO `subject_schedules_time` (`subject_id`, `date`, `start_time`, `end_time`)
SELECT 
    `s1`.`subject_id`,
    `s1`.`date`,
    CASE (SELECT COUNT(*) FROM `subject_schedules` AS `s2` WHERE `s2`.`date` = `s1`.`date` AND `s2`.`id` <= `s1`.`id`)
        WHEN 1 THEN '08:30:00'
        WHEN 2 THEN '10:10:00'
        WHEN 3 THEN '11:50:00' 
        WHEN 4 THEN '13:50:00'
        WHEN 5 THEN '15:30:00'
        WHEN 6 THEN '17:10:00' 
        ELSE '18:50:00'      
    END AS `start_time`,
    CASE (SELECT COUNT(*) FROM `subject_schedules` AS `s2` WHERE `s2`.`date` = `s1`.`date` AND `s2`.`id` <= `s1`.`id`)
        WHEN 1 THEN '10:00:00'
        WHEN 2 THEN '11:40:00'
        WHEN 3 THEN '13:20:00' 
        WHEN 4 THEN '15:20:00'
        WHEN 5 THEN '17:00:00'
        WHEN 6 THEN '18:40:00' 
        ELSE '20:20:00'        
    END AS `end_time`
FROM `subject_schedules` AS `s1`;


-- Задание 3:
SELECT 
    `sst`.`date` AS `Дата`,
    `sst`.`start_time` AS `Начало`,
    `sst`.`end_time` AS `Конец`,
    `s`.`name` AS `Предмет`
FROM `subject_schedules_time` AS `sst`, `subjects` AS `s`
WHERE `sst`.`subject_id` = `s`.`id`
ORDER BY `sst`.`date` ASC, `sst`.`start_time` ASC;


-- Задание 4: 
SELECT DISTINCT
    `st`.`id` AS `student_id`,
    `st`.`firstname` AS `Имя`,
    `st`.`lastname` AS `Фамилия`,
    `sst`.`date` AS `Дата`,
    `sst`.`start_time` AS `Начало`,
    `sst`.`end_time` AS `Конец`,
    `s`.`name` AS `Предмет`
FROM `students` AS `st`, `student_marks` AS `sm`, `subject_schedules_time` AS `sst`, `subjects` AS `s`
WHERE `st`.`id` = `sm`.`student_id` 
  AND `sm`.`subject_id` = `sst`.`subject_id` 
  AND `sst`.`subject_id` = `s`.`id`
ORDER BY `sst`.`date` ASC, `sst`.`start_time` ASC;


-- Задание 5: 
-- 5.1 Представление для общего расписания
CREATE OR REPLACE VIEW `view_general_schedule` AS
SELECT 
    `sst`.`date` AS `Дата`,
    `sst`.`start_time` AS `Начало`,
    `sst`.`end_time` AS `Конец`,
    `s`.`name` AS `Предмет`
FROM `subject_schedules_time` AS `sst`, `subjects` AS `s`
WHERE `sst`.`subject_id` = `s`.`id`;

-- 5.2 Представление для индивидуального расписания
CREATE OR REPLACE VIEW `view_individual_schedule` AS
SELECT DISTINCT
    `st`.`id` AS `student_id`,
    `st`.`firstname` AS `Имя`,
    `st`.`lastname` AS `Фамилия`,
    `sst`.`date` AS `Дата`,
    `sst`.`start_time` AS `Начало`,
    `sst`.`end_time` AS `Конец`,
    `s`.`name` AS `Предмет`
FROM `students` AS `st`, `student_marks` AS `sm`, `subject_schedules_time` AS `sst`, `subjects` AS `s`
WHERE `st`.`id` = `sm`.`student_id` 
  AND `sm`.`subject_id` = `sst`.`subject_id` 
  AND `sst`.`subject_id` = `s`.`id`;


-- Задание 6: 
CREATE OR REPLACE VIEW `view_student_avg_marks` AS
SELECT 
    `st`.`id`,
    `st`.`firstname`,
    `st`.`lastname`,
    ROUND(AVG(`sm`.`mark`), 2) AS `avg_mark`,
    COUNT(`sm`.`mark`) AS `total_marks`
FROM `students` AS `st`, `student_marks` AS `sm`
WHERE `st`.`id` = `sm`.`student_id`
GROUP BY `st`.`id`;

-- Представление: Статистика по предметам
CREATE OR REPLACE VIEW `view_subject_stats` AS
SELECT 
    `s`.`id`,
    `s`.`name` AS `subject_name`,
    ROUND(AVG(`sm`.`mark`), 2) AS `subject_avg_mark`
FROM `subjects` AS `s`, `student_marks` AS `sm`
WHERE `s`.`id` = `sm`.`subject_id`
GROUP BY `s`.`id`;


-- Задание 7: 

-- 7.1. Общее расписание на первую неделю сентября
SELECT `Дата`, `Начало`, `Конец`, `Предмет`
FROM `view_general_schedule`
WHERE `Дата` BETWEEN '2016-09-01' AND '2016-09-07'
ORDER BY `Дата` ASC, `Начало` ASC;

-- 7.2. Подсчет количества пар по предметам 
SELECT `Предмет`, COUNT(*) AS `Количество_пар`
FROM `view_general_schedule`
GROUP BY `Предмет`
HAVING COUNT(*) > 10
ORDER BY `Количество_пар` DESC;

-- 7.3. Расписание Ивана Петрова на конкретный день
SELECT `Начало`, `Конец`, `Предмет`
FROM `view_individual_schedule`
WHERE `Имя` = 'Иван' AND `Фамилия` = 'Петров' AND `Дата` = '2016-09-05'
ORDER BY `Начало` ASC;

-- 7.4. Студенты со средним баллом от 4.0 и  
SELECT `firstname`, `lastname`, `avg_mark`
FROM `view_student_avg_marks`
WHERE `avg_mark` >= 4.0
ORDER BY `avg_mark` DESC;