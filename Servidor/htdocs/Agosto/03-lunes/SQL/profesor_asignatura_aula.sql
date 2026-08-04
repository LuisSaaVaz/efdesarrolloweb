DELIMITER //

CREATE PROCEDURE GenerarProfesorAsignaturaAula()
BEGIN
    DECLARE v_done INT DEFAULT FALSE;
    DECLARE v_curso_id INT;
    DECLARE v_ano_academico_id INT;
    DECLARE v_aula_id INT;
    DECLARE v_asignatura_id INT;
    DECLARE v_profesor_id INT;
    DECLARE v_num_profesores INT DEFAULT 0;

    -- Cursor 1: Agrupa todas las combinaciones únicas de curso, año y aula donde hay alumnos matriculados
    DECLARE cur_clases CURSOR FOR 
        SELECT DISTINCT curso_id, ano_academico_id, aula_id 
        FROM usuarios_cursos;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_done = TRUE;

    -- Contamos cuántos profesores existen para verificar que hay personal registrado
    SELECT COUNT(*) INTO v_num_profesores 
    FROM usuarios 
    WHERE role = 'profesor';

    IF v_num_profesores > 0 THEN

        OPEN cur_clases;

        clases_loop: LOOP
            FETCH cur_clases INTO v_curso_id, v_ano_academico_id, v_aula_id;
            IF v_done THEN
                LEAVE clases_loop;
            END IF;

            -- Bloque interno: recorre todas las asignaturas de dicho curso
            BEGIN
                DECLARE v_done_asig INT DEFAULT FALSE;
                
                DECLARE cur_asignaturas CURSOR FOR 
                    SELECT id 
                    FROM asignaturas 
                    WHERE curso_id = v_curso_id;

                DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_done_asig = TRUE;

                OPEN cur_asignaturas;

                asig_loop: LOOP
                    FETCH cur_asignaturas INTO v_asignatura_id;
                    IF v_done_asig THEN
                        LEAVE asig_loop;
                    END IF;

                    -- Seleccionar un profesor aleatorio con rol 'profesor'
                    SELECT id INTO v_profesor_id 
                    FROM usuarios 
                    WHERE role = 'profesor' 
                    ORDER BY RAND() 
                    LIMIT 1;

                    -- Insertar la asignación del docente
                    INSERT IGNORE INTO profesor_asignatura_aula 
                        (profesor_id, asignatura_id, aula_id, ano_academico_id)
                    VALUES 
                        (v_profesor_id, v_asignatura_id, v_aula_id, v_ano_academico_id);

                END LOOP;

                CLOSE cur_asignaturas;
            END;

        END LOOP;

        CLOSE cur_clases;

    END IF;
END //

DELIMITER ;

-- Ejecutar el procedimiento
CALL GenerarProfesorAsignaturaAula();

-- Borrar el procedimiento tras la ejecución
DROP PROCEDURE IF EXISTS GenerarProfesorAsignaturaAula;