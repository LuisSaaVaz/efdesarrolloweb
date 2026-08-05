INSERT IGNORE INTO respuestas_alumno (intento_id, pregunta_id, respuesta_id)
WITH 
preguntas_numeradas AS (
    SELECT 
        pi.intento_id,
        pi.pregunta_id,
        ie.nota,
        ROW_NUMBER() OVER (PARTITION BY pi.intento_id ORDER BY pi.id) AS num_pregunta
    FROM preguntas_intento pi
    INNER JOIN intentos_examen ie ON ie.id = pi.intento_id
),
respuestas_correctas AS (
    SELECT 
        pregunta_id,
        MAX(id) AS respuesta_correcta_id
    FROM respuestas
    GROUP BY pregunta_id
),
respuestas_incorrectas AS (
    SELECT 
        pregunta_id,
        MIN(id) AS respuesta_incorrecta_id
    FROM respuestas
    WHERE (pregunta_id, id) NOT IN (
        SELECT pregunta_id, MAX(id) FROM respuestas GROUP BY pregunta_id
    )
    GROUP BY pregunta_id
)
SELECT 
    pn.intento_id,
    pn.pregunta_id,
    CASE 
        -- Si la posición de la pregunta es <= al número de aciertos (nota redondeada), asignamos la correcta
        WHEN pn.num_pregunta <= ROUND(pn.nota) THEN rc.respuesta_correcta_id
        -- Si es mayor, asignamos la incorrecta
        ELSE ri.respuesta_incorrecta_id
    END AS respuesta_id
FROM preguntas_numeradas pn
INNER JOIN respuestas_correctas rc ON rc.pregunta_id = pn.pregunta_id
LEFT JOIN respuestas_incorrectas ri ON ri.pregunta_id = pn.pregunta_id;