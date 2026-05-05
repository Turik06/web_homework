-- 1
SELECT 
    st.lastname AS 'Фамилия',
    st.firstname AS 'Имя',
    su.name AS 'Предмет',
    AVG(sm.mark) AS 'Средний балл'
FROM students st
JOIN student_marks sm ON st.id = sm.student_id
JOIN subjects su ON sm.subject_id = su.id
GROUP BY st.id, su.id
ORDER BY st.lastname, su.name;

-- 2 
SELECT 
    st.lastname AS 'Фамилия',
    sm.mark AS 'Оценка',
    COUNT(sm.mark) AS 'Количество'
FROM students st
JOIN student_marks sm ON st.id = sm.student_id
GROUP BY st.id, sm.mark
ORDER BY st.lastname, sm.mark DESC;

-- 3
SELECT 
    st.lastname, 
    st.firstname, 
    AVG(sm.mark) AS avg_mark
FROM students st
JOIN student_marks sm ON st.id = sm.student_id
GROUP BY st.id
ORDER BY avg_mark DESC
LIMIT 1;

-- 4
SELECT 
    st.lastname, 
    st.firstname, 
    AVG(sm.mark) AS avg_mark
FROM students st
JOIN student_marks sm ON st.id = sm.student_id
GROUP BY st.id
ORDER BY avg_mark ASC
LIMIT 1;

-- 5
SELECT 
    su.name AS 'Дисциплина',
    AVG(sm.mark) AS avg_mark
FROM subjects su
JOIN student_marks sm ON su.id = sm.subject_id
GROUP BY su.id
ORDER BY avg_mark DESC
LIMIT 1;

-- 6
SELECT 
    ss.date AS 'Дата',
    GROUP_CONCAT(su.name ORDER BY su.name SEPARATOR ', ') AS 'Расписание предметов'
FROM subject_schedules ss
JOIN subjects su ON ss.subject_id = su.id
GROUP BY ss.date
ORDER BY ss.date ASC;