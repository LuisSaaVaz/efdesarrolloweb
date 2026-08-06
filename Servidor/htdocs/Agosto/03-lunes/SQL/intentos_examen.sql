DELIMITER //

DROP PROCEDURE IF EXISTS GenerarIntentosExamenes //

CREATE PROCEDURE GenerarIntentosExamenes()
BEGIN
    DECLARE v_done INT DEFAULT FALSE;
    DECLARE v_alumno_id INT;
    DECLARE v_curso_id INT;
    DECLARE v_ano_academico_id INT;
    DECLARE v_examen_id INT;
    DECLARE v_duracion_min INT;
    DECLARE v_nota DECIMAL(4, 2);
    DECLARE v_tiempo_segundos INT;

    -- Cursor 1: Recorre las matrículas de cada alumno (alumno, curso y año académico)
    DECLARE cur_matriculas CURSOR FOR 
        SELECT uc.usuario_id, uc.curso_id, uc.ano_academico_id
        FROM usuarios_cursos uc
        INNER JOIN usuarios u ON u.id = uc.usuario_id
        WHERE u.role = 'alumno';

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_done = TRUE;

    OPEN cur_matriculas;

    matricula_loop: LOOP
        FETCH cur_matriculas INTO v_alumno_id, v_curso_id, v_ano_academico_id;
        IF v_done THEN
            LEAVE matricula_loop;
        END IF;

        -- Bloque interno: Buscar los exámenes de las asignaturas pertenecientes al curso_id actual
        BEGIN
            DECLARE v_done_examenes INT DEFAULT FALSE;
            
            DECLARE cur_examenes CURSOR FOR 
                SELECT e.id, e.duracion_minutos
                FROM examenes e
                INNER JOIN asignaturas a ON a.id = e.asignatura_id
                WHERE a.curso_id = v_curso_id;

            DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_done_examenes = TRUE;

            OPEN cur_examenes;

            examen_loop: LOOP
                FETCH cur_examenes INTO v_examen_id, v_duracion_min;
                IF v_done_examenes THEN
                    LEAVE examen_loop;
                END IF;

                -- 1. Generar nota entera aleatoria entre 5 y 10 (sin decimales)
                SET v_nota = FLOOR(5 + (RAND() * 6));

                -- 2. Calcular tiempo empleado aleatorio (entre 30s y el límite en segundos)
                SET v_tiempo_segundos = FLOOR(30 + (RAND() * ((v_duracion_min * 60) - 30)));

                -- 3. Insertar el intento (usando IGNORE por si la restricción UNIQUE se activa)
                INSERT IGNORE INTO intentos_examen (
                    alumno_id,
                    examen_id,
                    ano_academico_id,
                    estado,
                    nota,
                    tiempo_empleado_segundos,
                    fecha_inicio,
                    fecha_fin
                )
                VALUES (
                    v_alumno_id,
                    v_examen_id,
                    v_ano_academico_id,
                    'finalizado',
                    v_nota,
                    v_tiempo_segundos,
                    NOW() - INTERVAL FLOOR(RAND() * 100) DAY,
                    NOW() - INTERVAL FLOOR(RAND() * 100) DAY + INTERVAL v_tiempo_segundos SECOND
                );

            END LOOP examen_loop;

            CLOSE cur_examenes;
        END;

    END LOOP matricula_loop;

    CLOSE cur_matriculas;
END //

DELIMITER ;

-- Ejecutar el procedimiento
CALL GenerarIntentosExamenes();

-- Eliminar el procedimiento tras completar el llenado
DROP PROCEDURE IF EXISTS GenerarIntentosExamenes;