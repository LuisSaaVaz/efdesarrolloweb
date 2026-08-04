INSERT INTO examenes (titulo, con_tiempo_limite, duracion_minutos, asignatura_id)
SELECT CONCAT('1ª Avaliación - ', nombre), TRUE, 45, id FROM asignaturas
UNION ALL
SELECT CONCAT('2ª Avaliación - ', nombre), TRUE, 45, id FROM asignaturas
UNION ALL
SELECT CONCAT('Exame Final - ', nombre), TRUE, 60, id FROM asignaturas;