-- DDBB examen
-- Tabla clientes
-- id_cli. No autoincremental automatico sino hecho a mano
-- 4 campos mas

CREATE DATABASE examen
    DEFAULT CHARACTER SET = 'utf8mb4';

USE examen;

CREATE TABLE clientes (
    id_cli INT(3) PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    telefono CHAR(9),
    fecha_alta TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE ids (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tabla VARCHAR(50) NOT NULL UNIQUE,
    lastId INT NOT NULL DEFAULT 1
);