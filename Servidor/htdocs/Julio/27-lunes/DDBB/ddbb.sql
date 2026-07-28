USE bar;

-- 1. Tabla de Mesas
CREATE TABLE mesas (
    id_mesa INT AUTO_INCREMENT PRIMARY KEY,
    numero_mesa INT UNIQUE NOT NULL, -- Número de la mesa (1, 2, 3...)
    estado ENUM('libre', 'ocupada') DEFAULT 'libre'
);

-- 2. Tabla de Bebidas
CREATE TABLE bebidas (
    id_bebida INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    precio DECIMAL(6,2) NOT NULL,
    foto VARCHAR(255) NULL
);

-- 3. Tabla de Tickets
CREATE TABLE tickets (
    id_ticket INT AUTO_INCREMENT PRIMARY KEY,
    id_mesa INT NOT NULL,
    estado ENUM('pendiente', 'pagado') DEFAULT 'pendiente',
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_mesa) REFERENCES mesas(id_mesa)
);

-- 4. Tabla para asociar Bebidas a un Ticket
CREATE TABLE ticket_bebidas (
    id_linea INT AUTO_INCREMENT PRIMARY KEY,
    id_ticket INT NOT NULL,
    id_bebida INT NOT NULL,
    cantidad INT NOT NULL DEFAULT 1,
    precio_unitario DECIMAL(6,2) NOT NULL, -- Se guarda el precio del momento de la venta
    FOREIGN KEY (id_ticket) REFERENCES tickets(id_ticket) ON DELETE CASCADE,
    FOREIGN KEY (id_bebida) REFERENCES bebidas(id_bebida),
    UNIQUE (id_ticket, id_bebida)
);


INSERT INTO mesas (numero_mesa, estado) VALUES 
(1, 'libre'),
(2, 'libre'),
(3, 'libre'),
(4, 'libre'),
(5, 'libre'),
(6, 'libre'),
(7, 'libre'),
(8, 'libre'),
(9, 'libre'),
(10, 'libre'),
(11, 'libre'),
(12, 'libre'),
(13, 'libre'),
(14, 'libre'),
(15, 'libre'),
(16, 'libre'),
(17, 'libre'),
(18, 'libre'),
(19, 'libre'),
(20, 'libre');

INSERT INTO bebidas (nombre, precio, foto) VALUES 
-- Café e Infusiones
('Café Solo', 1.20, 'https://images.unsplash.com/photo-1510591509098-f4fdc6d0ff04?w=300'),
('Café con Leche', 1.40, 'https://images.unsplash.com/photo-1534778101976-62847782c213?w=300'),
('Café Cortado', 1.30, 'https://images.unsplash.com/photo-1517256064527-09c73fc73e38?w=300'),
('Café Bombón', 1.60, 'https://images.unsplash.com/photo-1572442388796-11668a67e53d?w=300'),
('Cappuccino', 2.00, 'https://images.unsplash.com/photo-1572442388796-11668a67e53d?w=300'),
('Te Negro', 1.50, 'https://images.unsplash.com/photo-1576092768241-dec231879fc3?w=300'),
('Té Verde', 1.50, 'https://images.unsplash.com/photo-1627435601361-ec25f5b1d0e5?w=300'),
('Manzanilla', 1.30, 'https://images.unsplash.com/photo-1597481499750-3e6b22637e12?w=300'),
('Menta Poleo', 1.30, 'https://images.unsplash.com/photo-1597481499750-3e6b22637e12?w=300'),
('Chocolate a la Taza', 2.20, 'https://images.unsplash.com/photo-1542990253-0d0f5be5f0ed?w=300'),
-- Aguas y Refresh
('Agua Mineral 50cl', 1.20, 'https://images.unsplash.com/photo-1548839140-29a749e1cf4e?w=300'),
('Agua con Gas 50cl', 1.50, 'https://images.unsplash.com/photo-1523362628745-0c100150b504?w=300'),
('Zumo de Naranja Natural', 2.50, 'https://images.unsplash.com/photo-1613478223719-2ab802602423?w=300'),
('Zumo de Melocotón', 1.80, 'https://images.unsplash.com/photo-1553530666-ba11a7da3888?w=300'),
('Zumo de Piña', 1.80, 'https://images.unsplash.com/photo-1525385133512-2f3bdd039054?w=300'),
('Limonada Casera', 2.20, 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?w=300'),
-- Refrescos
('Coca-Cola Original', 2.20, 'https://images.unsplash.com/photo-1622483767028-3f66f32aef97?w=300'),
('Coca-Cola Zero', 2.20, 'https://images.unsplash.com/photo-1554866585-cd94860890b7?w=300'),
('Fanta Naranja', 2.20, 'https://images.unsplash.com/photo-1624517452488-04869289c4ca?w=300'),
('Fanta Limón', 2.20, 'https://images.unsplash.com/photo-1581006852262-e4307cf6283a?w=300'),
('Sprite', 2.20, 'https://images.unsplash.com/photo-1625772299848-391b6a87d7b3?w=300'),
('Nestea de Té al Limón', 2.30, 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=300'),
('Aquarius Naranja', 2.30, 'https://images.unsplash.com/photo-1581006852262-e4307cf6283a?w=300'),
('Tónica Nordic', 2.20, 'https://images.unsplash.com/photo-1527661591475-527312dd65f5?w=300'),
('Red Bull', 2.80, 'https://images.unsplash.com/photo-1622543925917-763c34d1a86e?w=300'),
-- Cervezas
('Caña de Cerveza', 2.00, 'https://images.unsplash.com/photo-1608270586620-248524c67de9?w=300'),
('Doble de Cerveza', 3.00, 'https://images.unsplash.com/photo-1535958636474-b021ee887b13?w=300'),
('Cerveza Tercio Mahou', 2.50, 'https://images.unsplash.com/photo-1567696911980-2eed69a46042?w=300'),
('Cerveza Tercio Alhambra 1925', 3.00, 'https://images.unsplash.com/photo-1608270586620-248524c67de9?w=300'),
('Cerveza Sin Alcohol (0,0)', 2.30, 'https://images.unsplash.com/photo-1567696911980-2eed69a46042?w=300'),
('Clara con Limón', 2.20, 'https://images.unsplash.com/photo-1535958636474-b021ee887b13?w=300'),
('Cerveza Artesana IPA', 3.80, 'https://images.unsplash.com/photo-1571613316887-6f8d5cbf7ef7?w=300'),
-- Vinos y Vermut
('Copa Vino Tinto Rioja', 2.50, 'https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?w=300'),
('Copa Vino Tinto Ribera del Duero', 2.80, 'https://images.unsplash.com/photo-1506377247377-2a5b3b417ebb?w=300'),
('Copa Vino Blanco Rueda', 2.50, 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?w=300'),
('Copa Vino Blanco Albariño', 2.90, 'https://images.unsplash.com/photo-1569919659476-f0852f6834b7?w=300'),
('Copa Vino Rosado', 2.30, 'https://images.unsplash.com/photo-1558001373-7b9fcc98a1b9?w=300'),
('Vermut Rojo con Hielo', 2.80, 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?w=300'),
('Tinto de Verano', 2.50, 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=300'),
('Copa de Cava', 3.00, 'https://images.unsplash.com/photo-1592858308914-61014e590fa1?w=300'),
-- Cócteles y Combinados
('Mojito Tradicional', 6.50, 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?w=300'),
('Caipirinha', 6.50, 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?w=300'),
('Piña Colada', 7.00, 'https://images.unsplash.com/photo-1546171753-97d7676e4602?w=300'),
('Margarita', 7.00, 'https://images.unsplash.com/photo-1556881286-fc6915169721?w=300'),
('Gin Tonic Premium', 7.50, 'https://images.unsplash.com/photo-1527661591475-527312dd65f5?w=300'),
('Cuba Libre (Ron con Cola)', 6.00, 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?w=300'),
('Whisky On The Rocks', 6.50, 'https://images.unsplash.com/photo-1527281400683-1aae777175f8?w=300'),
('Aperol Spritz', 6.00, 'https://images.unsplash.com/photo-1560512823-829485b8bf24?w=300'),
('Sangría (Jarra 1L)', 9.50, 'https://images.unsplash.com/photo-1541544741938-0af808871cc0?w=300'),
('San Francisco (Sin Alcohol)', 4.50, 'https://images.unsplash.com/photo-1536935338788-846bb9981813?w=300');