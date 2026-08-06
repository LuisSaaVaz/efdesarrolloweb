-- 1. Creación de la base de datos y selección
CREATE DATABASE IF NOT EXISTS colegio
  CHARACTER SET utf8mb4;

USE colegio;

DROP TABLE IF EXISTS respuestas_alumno, preguntas_intento, intentos_examen, respuestas, preguntas, examenes, profesor_asignatura_aula, usuarios_asignaturas, asignaturas, usuarios_cursos, aulas, cursos, anos_academicos, usuarios;

-- 2. Tabla de Usuarios (Con fecha_nacimiento)
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    role ENUM('alumno', 'profesor', 'admin') NOT NULL DEFAULT 'alumno',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Tabla de Años Académicos
CREATE TABLE IF NOT EXISTS anos_academicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(20) NOT NULL UNIQUE, -- Ej: '2025/2026'
    activo BOOLEAN NOT NULL DEFAULT FALSE
);

-- 4. Tabla de Cursos
CREATE TABLE IF NOT EXISTS cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL -- Ej: '1º ESO', '2º Primaria'
);

-- 5. Tabla de Aulas
CREATE TABLE IF NOT EXISTS aulas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(10) NOT NULL UNIQUE -- Ej: 'A', 'B', 'C', 'D', 'E', 'F'
);

-- 6. Tabla de Matrículas / Cursos de Usuarios (Rediseñada)
CREATE TABLE IF NOT EXISTS usuarios_cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    curso_id INT NOT NULL,
    aula_id INT NOT NULL,
    ano_academico_id INT NOT NULL,
    estado ENUM('cursando', 'superado', 'repetido', 'baja') NOT NULL DEFAULT 'cursando', 
    
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (curso_id) REFERENCES cursos(id) ON DELETE CASCADE,
    FOREIGN KEY (aula_id) REFERENCES aulas(id) ON DELETE CASCADE,
    FOREIGN KEY (ano_academico_id) REFERENCES anos_academicos(id) ON DELETE CASCADE,
    
    
    UNIQUE KEY uq_usuario_ano (usuario_id, ano_academico_id) -- Restricción: Un usuario solo tiene 1 matrícula (Curso + Aula) por cada año lectivo
);

-- 7. Tabla de Asignaturas
CREATE TABLE IF NOT EXISTS asignaturas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    curso_id INT NOT NULL,
    FOREIGN KEY (curso_id) REFERENCES cursos(id) ON DELETE CASCADE
);

-- 8. Tabla de Asignaturas por Alumno (NUEVA: Expediente Académico de Asignaturas)
CREATE TABLE IF NOT EXISTS usuarios_asignaturas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    alumno_id INT NOT NULL,
    asignatura_id INT NOT NULL,
    ano_academico_id INT NOT NULL,
    estado ENUM('cursando', 'aprobada', 'suspensa', 'convalidada', 'pendiente') NOT NULL DEFAULT 'cursando',
    nota_final DECIMAL(4, 2) NULL DEFAULT NULL,
    
    FOREIGN KEY (alumno_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (asignatura_id) REFERENCES asignaturas(id) ON DELETE CASCADE,
    FOREIGN KEY (ano_academico_id) REFERENCES anos_academicos(id) ON DELETE CASCADE,
    
    UNIQUE KEY uq_alumno_asignatura_ano (alumno_id, asignatura_id, ano_academico_id)
);

-- 9. Tabla de Asignación de Profesores (NUEVA: Qué profesor da qué asignatura en qué aula)
CREATE TABLE IF NOT EXISTS profesor_asignatura_aula (
    id INT AUTO_INCREMENT PRIMARY KEY,
    profesor_id INT NOT NULL,
    asignatura_id INT NOT NULL,
    aula_id INT NOT NULL,
    ano_academico_id INT NOT NULL,
    
    FOREIGN KEY (profesor_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (asignatura_id) REFERENCES asignaturas(id) ON DELETE CASCADE,
    FOREIGN KEY (aula_id) REFERENCES aulas(id) ON DELETE CASCADE,
    FOREIGN KEY (ano_academico_id) REFERENCES anos_academicos(id) ON DELETE CASCADE,
    
    UNIQUE KEY uq_profesor_imparte (profesor_id, asignatura_id, aula_id, ano_academico_id)
);

-- 10. Tabla de Exámenes (Con control de tiempo)
CREATE TABLE IF NOT EXISTS examenes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    con_tiempo_limite BOOLEAN NOT NULL DEFAULT TRUE, -- <-- AÑADIDO: Activa/Desactiva temporizador
    duracion_minutos INT NOT NULL DEFAULT 3,
    asignatura_id INT NOT NULL,
    FOREIGN KEY (asignatura_id) REFERENCES asignaturas(id) ON DELETE CASCADE
);

-- 11. Tabla de Preguntas
CREATE TABLE IF NOT EXISTS preguntas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    enunciado TEXT NOT NULL,
    examen_id INT NOT NULL,
    FOREIGN KEY (examen_id) REFERENCES examenes(id) ON DELETE CASCADE
);

-- 12. Tabla de Respuestas
CREATE TABLE IF NOT EXISTS respuestas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    texto TEXT NOT NULL,
    es_correcta TINYINT(1) NULL DEFAULT NULL,
    pregunta_id INT NOT NULL,
    FOREIGN KEY (pregunta_id) REFERENCES preguntas(id) ON DELETE CASCADE,
    UNIQUE KEY uq_pregunta_respuesta_correcta (pregunta_id, es_correcta)
);

-- 13. Tabla de Intentos de Examen
CREATE TABLE IF NOT EXISTS intentos_examen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    alumno_id INT NOT NULL,
    examen_id INT NOT NULL,
    ano_academico_id INT NOT NULL, -- <-- AÑADIDO: Año lectivo del intento
    estado ENUM('en_proceso', 'finalizado', 'tiempo_agotado') NOT NULL DEFAULT 'en_proceso',
    nota DECIMAL(4, 2) NULL DEFAULT NULL,
    tiempo_empleado_segundos INT NULL DEFAULT NULL,
    fecha_inicio DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_fin DATETIME NULL DEFAULT NULL,
    
    FOREIGN KEY (alumno_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (examen_id) REFERENCES examenes(id) ON DELETE CASCADE,
    FOREIGN KEY (ano_academico_id) REFERENCES anos_academicos(id) ON DELETE CASCADE,
    
    UNIQUE KEY uq_alumno_examen_ano (alumno_id, examen_id, ano_academico_id) -- RESTRICCIÓN: Un alumno solo puede iniciar un examen 1 vez por año académico
);

-- 14. Tabla de Preguntas por Intento
CREATE TABLE IF NOT EXISTS preguntas_intento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    intento_id INT NOT NULL,
    pregunta_id INT NOT NULL,
    
    FOREIGN KEY (intento_id) REFERENCES intentos_examen(id) ON DELETE CASCADE,
    FOREIGN KEY (pregunta_id) REFERENCES preguntas(id) ON DELETE CASCADE,
    
    UNIQUE KEY uq_intento_pregunta (intento_id, pregunta_id) -- Evita que la misma pregunta se le asigne dos veces en el mismo intento
);

-- 15. Tabla de Respuestas por Alumno
CREATE TABLE IF NOT EXISTS respuestas_alumno (
    id INT AUTO_INCREMENT PRIMARY KEY,
    intento_id INT NOT NULL,
    pregunta_id INT NOT NULL,
    respuesta_id INT NULL DEFAULT NULL, -- NULL si no la ha respondido aún
    
    FOREIGN KEY (intento_id) REFERENCES intentos_examen(id) ON DELETE CASCADE,
    FOREIGN KEY (pregunta_id) REFERENCES preguntas(id) ON DELETE CASCADE,
    FOREIGN KEY (respuesta_id) REFERENCES respuestas(id) ON DELETE SET NULL,
    
    UNIQUE KEY uq_intento_pregunta_respuesta (intento_id, pregunta_id) -- Un alumno solo responde 1 vez a cada pregunta dentro de un mismo intento
);


SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE intentos_examen;
SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO usuarios (nombre, email, password, fecha_nacimiento, role) 
VALUES (
    'Admin', 
    'admin@efmail.luis', 
    '$2y$10$TqREGLG4xMeaa6C.ltdbA.IGluX.PrEvnJvmOaHkgJ0dfQo8vBbTe', 
    '1983-11-01', 
    'admin'
);
