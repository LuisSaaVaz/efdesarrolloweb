DELIMITER //

CREATE PROCEDURE GenerarMatriculasAlumnos()
BEGIN
    DECLARE v_done INT DEFAULT FALSE;
    DECLARE v_usuario_id INT;
    DECLARE v_fecha_nac DATE;
    DECLARE v_ano_inicio INT;
    DECLARE v_ano_actual INT;
    DECLARE v_curso INT;
    DECLARE v_aula INT;
    DECLARE v_conteo INT;
    DECLARE v_estado VARCHAR(20);

    -- Cursor para recorrer todos los usuarios con rol 'alumno'
    DECLARE cur_alumnos CURSOR FOR 
        SELECT id, fecha_nacimiento 
        FROM usuarios 
        WHERE role = 'alumno' AND fecha_nacimiento IS NOT NULL;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_done = TRUE;

    OPEN cur_alumnos;

    read_loop: LOOP
        FETCH cur_alumnos INTO v_usuario_id, v_fecha_nac;
        IF v_done THEN
            LEAVE read_loop;
        END IF;

        -- Calculamos el año académico en el que cumple 3 años (ID 1 = 1960)
        SET v_ano_inicio = YEAR(v_fecha_nac) - 1960;
        
        -- Si por edad empezara antes de 1960, ajustamos a 1
        IF v_ano_inicio < 1 THEN
            SET v_ano_inicio = 1;
        END IF;

        SET v_curso = 1; -- Empieza en 1º Infantil (ID 1)

        -- Bucle por cada año académico hasta el 2019-2020 (ID 60)
        SET v_ano_actual = v_ano_inicio;
        
        WHILE v_ano_actual <= 60 AND v_curso <= 10 DO
            
            -- Estado: 'cursando' para 2019-2020 (ID 60), 'superado' para los anteriores
            IF v_ano_actual = 60 THEN
                SET v_estado = 'cursando';
            ELSE
                SET v_estado = 'superado';
            END IF;

            -- Contar alumnos ya matriculados en ese curso y año para asignar aula (máx 15 por aula)
            SELECT COUNT(*) INTO v_conteo 
            FROM usuarios_cursos 
            WHERE ano_academico_id = v_ano_actual AND curso_id = v_curso;

            SET v_aula = FLOOR(v_conteo / 15) + 1;

            -- Insertar registro evitando duplicados
            INSERT IGNORE INTO usuarios_cursos (usuario_id, curso_id, ano_academico_id, aula_id, estado)
            VALUES (v_usuario_id, v_curso, v_ano_actual, v_aula, v_estado);

            SET v_curso = v_curso + 1;
            SET v_ano_actual = v_ano_actual + 1;
        END WHILE;

    END LOOP;

    CLOSE cur_alumnos;
END //

DELIMITER ;

-- Ejecutar el procedimiento
CALL GenerarMatriculasAlumnos();

-- Borrar el procedimiento tras la ejecución
DROP PROCEDURE IF EXISTS GenerarMatriculasAlumnos;