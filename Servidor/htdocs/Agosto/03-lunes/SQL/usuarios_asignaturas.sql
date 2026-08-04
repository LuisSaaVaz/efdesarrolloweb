DELIMITER //

CREATE PROCEDURE GenerarAsignaturasAlumnos()
BEGIN
    DECLARE v_done INT DEFAULT FALSE;
    DECLARE v_alumno_id INT;
    DECLARE v_curso_id INT;
    DECLARE v_ano_academico_id INT;
    DECLARE v_estado VARCHAR(20);
    DECLARE v_nota DECIMAL(4, 2);

    -- Recorremos cada matriculación existente en la tabla usuarios_cursos
    DECLARE cur_matriculas CURSOR FOR 
        SELECT usuario_id, curso_id, ano_academico_id 
        FROM usuarios_cursos;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_done = TRUE;

    OPEN cur_matriculas;

    read_loop: LOOP
        FETCH cur_matriculas INTO v_alumno_id, v_curso_id, v_ano_academico_id;
        IF v_done THEN
            LEAVE read_loop;
        END IF;

        -- Definimos estado y nota según el año académico
        IF v_ano_academico_id = 60 THEN
            SET v_estado = 'cursando';
            SET v_nota = NULL;
        ELSE
            SET v_estado = 'aprobada';
            -- Genera una nota aleatoria entre 5.00 y 10.00 con 2 decimales
            SET v_nota = ROUND(5.00 + (RAND() * 5.00), 2);
        END IF;

        -- Insertamos todas las asignaturas pertenecientes a ese curso académico
        INSERT IGNORE INTO usuarios_asignaturas (alumno_id, asignatura_id, ano_academico_id, estado, nota_final)
        SELECT 
            v_alumno_id, 
            a.id, 
            v_ano_academico_id, 
            v_estado, 
            v_nota
        FROM asignaturas a
        WHERE a.curso_id = v_curso_id;

    END LOOP;

    CLOSE cur_matriculas;
END //

DELIMITER ;

-- Ejecutar el procedimiento
CALL GenerarAsignaturasAlumnos();

-- Eliminar el procedimiento tras ejecutarlo
DROP PROCEDURE IF EXISTS GenerarAsignaturasAlumnos;