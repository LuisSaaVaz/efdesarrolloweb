DELIMITER //

DROP PROCEDURE IF EXISTS GenerarPreguntasPorIntento //

CREATE PROCEDURE GenerarPreguntasPorIntento()
BEGIN
    DECLARE v_done INT DEFAULT FALSE;
    DECLARE v_intento_id INT;
    DECLARE v_examen_id INT;

    -- Cursor 1: Recorrer todos los intentos de examen creados
    DECLARE cur_intentos CURSOR FOR 
        SELECT id, examen_id 
        FROM intentos_examen;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET v_done = TRUE;

    OPEN cur_intentos;

    intento_loop: LOOP
        FETCH cur_intentos INTO v_intento_id, v_examen_id;
        IF v_done THEN
            LEAVE intento_loop;
        END IF;

        -- Insertar 10 preguntas aleatorias pertenecientes al examen del intento actual
        INSERT IGNORE INTO preguntas_intento (intento_id, pregunta_id)
        SELECT v_intento_id, id
        FROM preguntas
        WHERE examen_id = v_examen_id
        ORDER BY RAND()
        LIMIT 10;

    END LOOP intento_loop;

    CLOSE cur_intentos;
END //

DELIMITER ;

-- Ejecutar el procedimiento
CALL GenerarPreguntasPorIntento();

-- Eliminar el procedimiento tras completar
DROP PROCEDURE IF EXISTS GenerarPreguntasPorIntento;