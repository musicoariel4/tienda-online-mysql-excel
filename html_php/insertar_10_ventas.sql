INSERT INTO clientes (nombre, direccion, telefono, email)
VALUES ('Luis Mendoza', 'Calle 45 #22-18', '3105671234', 'luis.mendoza@example.com');

INSERT INTO proveedores (nombre, contacto, telefono, email)
VALUES ('Distribuciones Globales S.A.', 'Carrera 15 #35-80', '6017654321', 'contacto@globales.com');

-- 10 Nuevas Ventas

INSERT INTO ventas (cliente_id, producto_id, cantidad, total, fecha)
VALUES (1, 6, 1, 1800.00, '2025-07-20');

INSERT INTO ventas (cliente_id, producto_id, cantidad, total, fecha)
VALUES (2, 7, 2, 40.00, '2025-07-20');

INSERT INTO ventas (cliente_id, producto_id, cantidad, total, fecha)
VALUES (3, 8, 1, 75.00, '2025-07-20');

INSERT INTO ventas (cliente_id, producto_id, cantidad, total, fecha)
VALUES (1, 8, 2, 75.00, '2025-07-21');

INSERT INTO ventas (cliente_id, producto_id, cantidad, total, fecha)
VALUES (2, 6, 1, 1800.00, '2025-07-21');

INSERT INTO ventas (cliente_id, producto_id, cantidad, total, fecha)
VALUES (3, 7, 4, 40.00, '2025-07-22');

INSERT INTO ventas (cliente_id, producto_id, cantidad, total, fecha)
VALUES (3, 6, 1, 1800.00, '2025-07-22');

INSERT INTO ventas (cliente_id, producto_id, cantidad, total, fecha)
VALUES (1, 7, 2, 40.00, '2025-07-23');

INSERT INTO ventas (cliente_id, producto_id, cantidad, total, fecha)
VALUES (2, 8, 1, 75.00, '2025-07-23');

INSERT INTO ventas (cliente_id, producto_id, cantidad, total, fecha)
VALUES (2, 6, 1, 1800.00, '2025-07-24');
