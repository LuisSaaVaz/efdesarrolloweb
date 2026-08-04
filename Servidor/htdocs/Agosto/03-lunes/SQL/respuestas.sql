DELIMITER //

DROP PROCEDURE IF EXISTS GenerarRespuestasParaPreguntas //

CREATE PROCEDURE GenerarRespuestasParaPreguntas()
BEGIN
    DECLARE v_done INT DEFAULT FALSE;
    DECLARE v_pregunta_id INT;

    -- Cursor para recorrer todas las preguntas
    DECLARE cur_preguntas CURSOR FOR 
        SELECT id FROM preguntas;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_done = TRUE;

    OPEN cur_preguntas;

    preg_loop: LOOP
        FETCH cur_preguntas INTO v_pregunta_id;
        IF v_done THEN
            LEAVE preg_loop;
        END IF;

        -- Opción 1 (Incorrecta)
        INSERT INTO respuestas (texto, es_correcta, pregunta_id)
        VALUES ('Opción A: Respuesta incorrecta de prueba', NULL, v_pregunta_id);

        -- Opción 2 (Incorrecta)
        INSERT INTO respuestas (texto, es_correcta, pregunta_id)
        VALUES ('Opción B: Respuesta incorrecta de prueba', NULL, v_pregunta_id);

        -- Opción 3 (Incorrecta)
        INSERT INTO respuestas (texto, es_correcta, pregunta_id)
        VALUES ('Opción C: Respuesta incorrecta de prueba', NULL, v_pregunta_id);

        -- Opción 4 (Correcta)
        INSERT INTO respuestas (texto, es_correcta, pregunta_id)
        VALUES ('Opción D: Respuesta correcta', 1, v_pregunta_id);

    END LOOP;

    CLOSE cur_preguntas;
END //

DELIMITER ;

-- Ejecutar el procedimiento
CALL GenerarRespuestasParaPreguntas();

-- Eliminar el procedimiento tras completar
DROP PROCEDURE IF EXISTS GenerarRespuestasParaPreguntas;