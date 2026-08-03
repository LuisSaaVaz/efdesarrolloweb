-- 1. Creación de la base de datos y selección
CREATE DATABASE IF NOT EXISTS colegio
  CHARACTER SET utf8mb4;

USE colegio;

-- 2. Tabla de Usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
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

-- 5. Tabla de Matrículas (Relación Alumno - Curso - Año Académico)
CREATE TABLE usuarios_cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    curso_id INT NOT NULL,
    ano_academico_id INT NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (curso_id) REFERENCES cursos(id) ON DELETE CASCADE,
    FOREIGN KEY (ano_academico_id) REFERENCES anos_academicos(id) ON DELETE CASCADE,
    -- Restricción: Un usuario (alumno o profe) solo tiene 1 curso asignado por año lectivo
    UNIQUE KEY uq_usuario_ano (usuario_id, ano_academico_id)
);

-- 6. Tabla de Asignaturas
CREATE TABLE asignaturas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    curso_id INT NOT NULL,
    FOREIGN KEY (curso_id) REFERENCES cursos(id) ON DELETE CASCADE
);

-- 7. Tabla de Exámenes
CREATE TABLE examenes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    duracion_minutos INT NOT NULL DEFAULT 3,
    asignatura_id INT NOT NULL,
    FOREIGN KEY (asignatura_id) REFERENCES asignaturas(id) ON DELETE CASCADE
);

-- 8. Tabla de Preguntas
CREATE TABLE preguntas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    enunciado TEXT NOT NULL,
    examen_id INT NOT NULL,
    FOREIGN KEY (examen_id) REFERENCES examenes(id) ON DELETE CASCADE
);

-- 9. Tabla de Respuestas
CREATE TABLE respuestas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    texto TEXT NOT NULL,
    -- NULL para incorrecta, 1 para correcta (TINYINT(1) maneja 0 y 1 en MySQL)
    es_correcta TINYINT(1) NULL DEFAULT NULL,
    pregunta_id INT NOT NULL,
    FOREIGN KEY (pregunta_id) REFERENCES preguntas(id) ON DELETE CASCADE,
    -- Al ser UNIQUE, solo puede haber un '1' por pregunta_id (los NULLs se ignoran)
    UNIQUE KEY uq_pregunta_respuesta_correcta (pregunta_id, es_correcta)
);

-- 10. Tabla de Intentos de Examen (Registro histórico de notas)
CREATE TABLE intentos_examen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    alumno_id INT NOT NULL,
    examen_id INT NOT NULL,
    nota DECIMAL(4, 2) NOT NULL, -- Permite notas de 0.00 a 10.00
    fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (alumno_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (examen_id) REFERENCES examenes(id) ON DELETE CASCADE
);

-- 11. Tabla de Respuestas por Alumno (Almacena el detalle del examen en JSON)
CREATE TABLE respuestas_alumno (
    id INT AUTO_INCREMENT PRIMARY KEY,
    intento_id INT NOT NULL UNIQUE, -- 1 a 1 con el intento de examen
    respuestas_json TEXT NOT NULL,   -- Detalle de preguntas y respuestas seleccionadas
    FOREIGN KEY (intento_id) REFERENCES intentos_examen(id) ON DELETE CASCADE
);

INSERT INTO usuarios (nombre, email, password, role) 
VALUES (
    'Admin', 
    'admin@efmail.luis', 
    '$2y$10$TqREGLG4xMeaa6C.ltdbA.IGluX.PrEvnJvmOaHkgJ0dfQo8vBbTe', 
    'admin'
);

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE usuarios;
SET FOREIGN_KEY_CHECKS = 1;