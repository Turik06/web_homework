-- 1
CREATE TABLE IF NOT EXISTS `student_presents` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_id` INT(10) UNSIGNED NOT NULL,
  `subject_id` INT(10) UNSIGNED NOT NULL,
  `date` DATE NOT NULL,
  `is_present` TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`),
  KEY `subject_id` (`subject_id`)
);

-- 2
INSERT INTO `student_presents` (`student_id`, `subject_id`, `date`, `is_present`)
SELECT 
    st.id,
    ss.subject_id,
    ss.date,
    ROUND(RAND())
FROM students st
CROSS JOIN subject_schedules ss
WHERE ss.date BETWEEN '2016-11-28' - INTERVAL 14 DAY AND '2016-11-28';

-- 3
SELECT 
    su.name AS 'Дисциплина',
    st.lastname AS 'Фамилия',
    st.firstname AS 'Имя',
    COUNT(sp.id) AS 'Всего занятий',
    SUM(sp.is_present) AS 'Посещено',
    ROUND((SUM(sp.is_present) / COUNT(sp.id)) * 100, 2) AS 'Посещаемость %'
FROM student_presents sp
JOIN students st ON sp.student_id = st.id
JOIN subjects su ON sp.subject_id = su.id
GROUP BY su.id, st.id
ORDER BY su.name, st.lastname;