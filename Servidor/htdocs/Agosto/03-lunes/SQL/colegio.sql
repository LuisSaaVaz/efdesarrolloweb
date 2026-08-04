-- 1. Creación de la base de datos y selección
CREATE DATABASE IF NOT EXISTS colegio
  CHARACTER SET utf8mb4;

USE colegio;

-- 2. Tabla de Usuarios (Con fecha_nacimiento)
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    role ENUM('alumno', 'profesor', 'admin') NOT NULL DEFAULT 'alumno',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Tabla de Años Académicos
CREATE TABLE anos_academicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(20) NOT NULL UNIQUE, -- Ej: '2025/2026'
    activo BOOLEAN NOT NULL DEFAULT FALSE
);

-- 4. Tabla de Cursos
CREATE TABLE cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL -- Ej: '1º ESO', '2º Primaria'
);

-- 5. Tabla de Aulas (NUEVA)
CREATE TABLE aulas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(10) NOT NULL UNIQUE -- Ej: 'A', 'B', 'C', 'D', 'E', 'F'
);

-- 6. Tabla de Matrículas / Cursos de Usuarios (Rediseñada)
CREATE TABLE usuarios_cursos (
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
    
    -- Restricción: Un usuario solo tiene 1 matrícula (Curso + Aula) por cada año lectivo
    UNIQUE KEY uq_usuario_ano (usuario_id, ano_academico_id)
);

-- 7. Tabla de Asignaturas
CREATE TABLE asignaturas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    curso_id INT NOT NULL,
    FOREIGN KEY (curso_id) REFERENCES cursos(id) ON DELETE CASCADE
);

-- 8. Tabla de Asignaturas por Alumno (NUEVA: Expediente Académico de Asignaturas)
CREATE TABLE usuarios_asignaturas (
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
CREATE TABLE profesor_asignatura_aula (
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
CREATE TABLE examenes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    con_tiempo_limite BOOLEAN NOT NULL DEFAULT TRUE, -- <-- AÑADIDO: Activa/Desactiva temporizador
    duracion_minutos INT NOT NULL DEFAULT 3,
    asignatura_id INT NOT NULL,
    FOREIGN KEY (asignatura_id) REFERENCES asignaturas(id) ON DELETE CASCADE
);

-- 11. Tabla de Preguntas
CREATE TABLE preguntas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    enunciado TEXT NOT NULL,
    examen_id INT NOT NULL,
    FOREIGN KEY (examen_id) REFERENCES examenes(id) ON DELETE CASCADE
);

-- 12. Tabla de Respuestas
CREATE TABLE respuestas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    texto TEXT NOT NULL,
    es_correcta TINYINT(1) NULL DEFAULT NULL,
    pregunta_id INT NOT NULL,
    FOREIGN KEY (pregunta_id) REFERENCES preguntas(id) ON DELETE CASCADE,
    UNIQUE KEY uq_pregunta_respuesta_correcta (pregunta_id, es_correcta)
);

-- 13. Tabla de Intentos de Examen
CREATE TABLE intentos_examen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    alumno_id INT NOT NULL,
    examen_id INT NOT NULL,
    nota DECIMAL(4, 2) NOT NULL,
    tiempo_empleado_segundos INT NULL, -- <-- AÑADIDO: Medir cuánto tardó
    estado ENUM('finalizado', 'tiempo_agotado') DEFAULT 'finalizado', -- <-- AÑADIDO
    fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (alumno_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (examen_id) REFERENCES examenes(id) ON DELETE CASCADE
);

-- 14. Tabla de Respuestas por Alumno (JSON)
CREATE TABLE respuestas_alumno (
    id INT AUTO_INCREMENT PRIMARY KEY,
    intento_id INT NOT NULL UNIQUE,
    respuestas_json TEXT NOT NULL,
    FOREIGN KEY (intento_id) REFERENCES intentos_examen(id) ON DELETE CASCADE
);

INSERT INTO usuarios (nombre, email, password, fecha_nacimiento, role) 
VALUES (
    'Admin', 
    'admin@efmail.luis', 
    '$2y$10$TqREGLG4xMeaa6C.ltdbA.IGluX.PrEvnJvmOaHkgJ0dfQo8vBbTe', 
    '1983-11-01', 
    'admin'
);

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE usuarios;
SET FOREIGN_KEY_CHECKS = 1;