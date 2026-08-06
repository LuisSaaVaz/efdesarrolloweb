DELIMITER //

CREATE PROCEDURE GenerarMatriculasAlumnos()
BEGIN
    -- 1. DECLARACIÓN DE VARIABLES LOCALES
    DECLARE v_done INT DEFAULT FALSE;
    DECLARE v_usuario_id INT;
    DECLARE v_fecha_nac DATE;
    DECLARE v_ano_inicio INT;
    DECLARE v_ano_actual INT;
    DECLARE v_curso INT;
    DECLARE v_aula INT;
    DECLARE v_conteo INT;
    DECLARE v_max_ano_id INT;

    -- 2. DECLARACIÓN DE CURSORES
    DECLARE cur_alumnos CURSOR FOR 
        SELECT id, fecha_nacimiento 
        FROM usuarios 
        WHERE role = 'alumno' AND fecha_nacimiento IS NOT NULL;

    -- 3. DECLARACIÓN DE HANDLERS
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_done = TRUE;

    -- LÓGICA DEL PROCEDIMIENTO
    SELECT MAX(id) INTO v_max_ano_id FROM anos_academicos;

    OPEN cur_alumnos;

    read_loop: LOOP
        FETCH cur_alumnos INTO v_usuario_id, v_fecha_nac;
        IF v_done THEN
            LEAVE read_loop;
        END IF;

        SET v_ano_inicio = YEAR(v_fecha_nac) - 1960;
        IF v_ano_inicio < 1 THEN
            SET v_ano_inicio = 1;
        END IF;

        SET v_curso = 1;
        SET v_ano_actual = v_ano_inicio;

        -- CAMBIO AQUÍ: v_curso <= 18 para cubrir de Infantil a Bachillerato
        WHILE v_ano_actual <= v_max_ano_id AND v_curso <= 18 DO
            SELECT COUNT(*) INTO v_conteo 
            FROM usuarios_cursos 
            WHERE ano_academico_id = v_ano_actual AND curso_id = v_curso;

            SET v_aula = FLOOR(v_conteo / 15) + 1;

            INSERT IGNORE INTO usuarios_cursos (usuario_id, curso_id, ano_academico_id, aula_id, estado)
            VALUES (v_usuario_id, v_curso, v_ano_actual, v_aula, 'superado');

            SET v_curso = v_curso + 1;
            SET v_ano_actual = v_ano_actual + 1;
        END WHILE;

    END LOOP;

    CLOSE cur_alumnos;
END //

DELIMITER ;

CALL GenerarMatriculasAlumnos();
DROP PROCEDURE IF EXISTS GenerarMatriculasAlumnos;