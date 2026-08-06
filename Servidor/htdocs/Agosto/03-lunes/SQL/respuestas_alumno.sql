CREATE TEMPORARY TABLE IF NOT EXISTS temp_mapa_respuestas AS
SELECT 
    p.id AS pregunta_id,
    MAX(r.id) AS respuesta_correcta_id,
    MIN(CASE WHEN r.id != rc.max_id THEN r.id END) AS respuesta_incorrecta_id
FROM preguntas p
JOIN respuestas r ON r.pregunta_id = p.id
JOIN (
    SELECT pregunta_id, MAX(id) AS max_id 
    FROM respuestas 
    GROUP BY pregunta_id
) rc ON rc.pregunta_id = p.id
GROUP BY p.id;

ALTER TABLE temp_mapa_respuestas ADD PRIMARY KEY (pregunta_id);


INSERT IGNORE INTO respuestas_alumno (intento_id, pregunta_id, respuesta_id)
WITH preguntas_numeradas AS (
    SELECT 
        pi.intento_id,
        pi.pregunta_id,
        ie.nota,
        ROW_NUMBER() OVER (PARTITION BY pi.intento_id ORDER BY pi.id) AS num_pregunta
    FROM preguntas_intento pi
    INNER JOIN intentos_examen ie ON ie.id = pi.intento_id
    WHERE pi.intento_id <= (SELECT (MIN(id) + MAX(id)) / 2 FROM intentos_examen)
)
SELECT 
    pn.intento_id,
    pn.pregunta_id,
    CASE 
        WHEN pn.num_pregunta <= ROUND(pn.nota) THEN tm.respuesta_correcta_id
        ELSE tm.respuesta_incorrecta_id
    END AS respuesta_id
FROM preguntas_numeradas pn
INNER JOIN temp_mapa_respuestas tm ON tm.pregunta_id = pn.pregunta_id;


INSERT IGNORE INTO respuestas_alumno (intento_id, pregunta_id, respuesta_id)
WITH preguntas_numeradas AS (
    SELECT 
        pi.intento_id,
        pi.pregunta_id,
        ie.nota,
        ROW_NUMBER() OVER (PARTITION BY pi.intento_id ORDER BY pi.id) AS num_pregunta
    FROM preguntas_intento pi
    INNER JOIN intentos_examen ie ON ie.id = pi.intento_id
    WHERE pi.intento_id > (SELECT (MIN(id) + MAX(id)) / 2 FROM intentos_examen)
)
SELECT 
    pn.intento_id,
    pn.pregunta_id,
    CASE 
        WHEN pn.num_pregunta <= ROUND(pn.nota) THEN tm.respuesta_correcta_id
        ELSE tm.respuesta_incorrecta_id
    END AS respuesta_id
FROM preguntas_numeradas pn
INNER JOIN temp_mapa_respuestas tm ON tm.pregunta_id = pn.pregunta_id;

-- Limpieza final tras completar ambas ejecuciones
DROP TEMPORARY TABLE IF EXISTS temp_mapa_respuestas;