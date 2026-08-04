DELIMITER //

DROP PROCEDURE IF EXISTS GenerarPreguntasParaExamenes //

CREATE PROCEDURE GenerarPreguntasParaExamenes()
BEGIN
    DECLARE v_done INT DEFAULT FALSE;
    DECLARE v_examen_id INT;
    DECLARE v_titulo VARCHAR(150);
    DECLARE i INT;

    -- Cursor para recorrer todos los exámenes registrados
    DECLARE cur_examenes CURSOR FOR 
        SELECT id, titulo FROM examenes;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_done = TRUE;

    OPEN cur_examenes;

    exam_loop: LOOP
        FETCH cur_examenes INTO v_examen_id, v_titulo;
        IF v_done THEN
            LEAVE exam_loop;
        END IF;

        SET i = 1;

        -- Generar 50 preguntas genéricas para el examen actual
        WHILE i <= 50 DO
            INSERT INTO preguntas (enunciado, examen_id)
            VALUES (
                CONCAT('Pregunta ', i, ' correspondiente al examen "', v_titulo, '". Seleccione la respuesta correcta para completar la evaluación.'),
                v_examen_id
            );
            SET i = i + 1;
        END WHILE;

    END LOOP;

    CLOSE cur_examenes;
END //

DELIMITER ;

-- Ejecutar el procedimiento almacenado
CALL GenerarPreguntasParaExamenes();

-- Eliminar el procedimiento tras completar el llenado
DROP PROCEDURE IF EXISTS GenerarPreguntasParaExamenes;