CREATE DATABASE Prototype1;
USE Prototype1;

CREATE TABLE roles (
    id_rol INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR(50) NOT NULL,
    descripcion_rol VARCHAR(255) NOT NULL
);

CREATE TABLE usuarios (
    id_usuario INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombres_usuario VARCHAR(50) NOT NULL,
    apellidos_usuario VARCHAR(50) NOT NULL,
    correo_usuario VARCHAR(100) NOT NULL,
    contrasena_usuario VARCHAR(255) NOT NULL,
    telefono_usuario VARCHAR(50) NOT NULL,
    direccion_usuario VARCHAR(255) NOT NULL,
    estado_usuario ENUM('activo', 'inactivo') NOT NULL,
    especialidad_usuario VARCHAR(50),
    rol_id INT NOT NULL,
    FOREIGN KEY (rol_id) REFERENCES roles(id_rol)
);


CREATE TABLE procedimientos (
    id_procedimiento INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    tipo_procedimiento VARCHAR(30) NOT NULL,
    costo DECIMAL(10, 2) NOT NULL
);

CREATE TABLE pacientes (
    cedula VARCHAR(20) NOT NULL PRIMARY KEY ,
    nombres_paciente VARCHAR(50) NOT NULL,
    apellidos_paciente VARCHAR(50) NOT NULL,
    edad INT NOT NULL,
    genero ENUM('masculino', 'femenino') NOT NULL,
    telefono_paciente VARCHAR(50) NOT NULL,
    direccion_paciente VARCHAR(50) NOT NULL,
    correo_paciente VARCHAR(50),
    tipo_sangre ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-') NOT NULL,
    UNIQUE (cedula)
);

CREATE TABLE citas (
    id_cita INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    fecha_cita DATE NOT NULL,
    hora_cita TIME NOT NULL,
    estado_cita ENUM('pendiente', 'confirmada', 'cancelada', 'completada') NOT NULL,
    motivo_cita VARCHAR(255) NOT NULL,
    total_cita DECIMAL(10, 2) NOT NULL,
    paciente_id VARCHAR(20) NOT NULL,
    usuario_id INT NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (paciente_id) REFERENCES pacientes(cedula)
);

CREATE TABLE procedimientos_citas (
    id_procedimiento_cita INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    procedimiento_id INT NOT NULL,
    cita_id INT NOT NULL,
    FOREIGN KEY (procedimiento_id) REFERENCES procedimientos(id_procedimiento),
    FOREIGN KEY (cita_id) REFERENCES citas(id_cita)
);

CREATE TABLE historias_clinicas (
    id_historia_clinica INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    antecedentes_medicos VARCHAR(50) NOT NULL,
    tratamiento_realizados VARCHAR(50) NOT NULL,
    paciente_id VARCHAR(20) NOT NULL,
    FOREIGN KEY (paciente_id) REFERENCES pacientes(cedula)
);

CREATE TABLE recetas_medicas (
    id_receta INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    historia_clinica_id INT NOT NULL,
    tipo_orden VARCHAR(50) NOT NULL,
    descripcion_receta VARCHAR(255) NOT NULL,
    medicamento_recetado VARCHAR(255) NOT NULL,
    fecha_receta DATE NOT NULL,
    FOREIGN KEY (historia_clinica_id) REFERENCES historias_clinicas(id_historia_clinica)
);

CREATE TABLE ordenes_compras (
    id_orden_compra INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    fecha_expedicion DATE NOT NULL,
    fecha_vencimiento DATE NOT NULL,
    usuario_id INT,
    estado ENUM('ordenado', 'aprobado','rechazado','en produccion', 'listo para entregar', 'entregado') NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id_usuario)
);


CREATE TABLE proveedores (
    nit VARCHAR(20) NOT NULL PRIMARY KEY,
    nombre_proveedor VARCHAR(50) NOT NULL,
    telefono_proveedor VARCHAR(50) NOT NULL,
    correo_proveedor VARCHAR(50) NOT NULL,
    UNIQUE (nit)
);

CREATE TABLE insumos (
    id_insumo INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre_insumo VARCHAR(50) NOT NULL,
    cantidad_insumo INT NOT NULL,
    costo_insumo DECIMAL(10, 2) NOT NULL,
    fecha_vencimiento DATE,
    umbral_alerta INT NOT NULL
);

CREATE TABLE proveedores_insumos (
    id_proveedor_insumo INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    proveedor_id VARCHAR(20) NOT NULL,
    insumo_id INT NOT NULL,
    FOREIGN KEY (proveedor_id) REFERENCES proveedores(nit),
    FOREIGN KEY (insumo_id) REFERENCES insumos(id_insumo)
);

CREATE TABLE detalles_ordenes (
        id_detalle_orden INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        cantidad_insumo INT NOT NULL,
        total DECIMAL(10, 2) NOT NULL,
        orden_id INT NOT NULL,
        insumo_id INT NOT NULL,
        FOREIGN KEY (orden_id) REFERENCES ordenes_compras(id_orden_compra),
        FOREIGN KEY (insumo_id) REFERENCES insumos(id_insumo)
);

/* Insertar roles*/
INSERT INTO roles (nombre_rol, descripcion_rol) VALUES
('Administrador', 'Gestiona el sistema'),
('Odontologo', 'Atiende a los pacientes'),
('Asistente', 'Agenda citas y maneja pacientes'),
('Laboratorista', 'Encargado de realizar protesis'),
('Dueño', 'Gestiona la clínica');

/* Insertar usuarios*/
INSERT INTO usuarios (nombres_usuario, apellidos_usuario, correo_usuario, contrasena_usuario, telefono_usuario, direccion_usuario, estado_usuario, especialidad_usuario, rol_id) VALUES
("Juan David","Oviedo Jiménez","juan.oviedo@gmail.com","$2y$12$s5AuwDptSLWnv0HvHM4.ievgGmm7zK/gNLLF6j/s7PqotQBqZ7rUG","3126730341","Retiro bajo calle 12C #5A-2","activo",NULL,1),
('Janer Esteban', 'Pechene Cifuentes', 'janner.pechene@gmail.com','$2y$12$PVFYuJjgM7hBsrjrv17UHOaFiz2qTWvsvrL6Sq1wolmEZaVODqA3a', '67234917', 'El Imperio de la Alta Sociedad Torre 12 Piso 3', 'activo', NULL, 1),
('Juan Carlos', 'Pérez Castrillón', 'juan.perez@gmail.com', '$2y$12$TfvqCwC1sU7X8xGpoHoezehOHxEQmwr5Cbv83tc0s2JjwSuiVPYuu', '123456789', 'Calle 12C #3-10 Centro', 'activo', 'Odontopediatría', 2),
('Maria Alejandra', 'Gonzalez López', 'maria.gonzalez@gmail.com', '$2y$12$TfvqCwC1sU7X8xGpoHoezehOHxEQmwr5Cbv83tc0s2JjwSuiVPYuu', '987654321', 'Avenida Azulejo 456', 'activo', 'Cirugía Oral y Maxilofacial', 2),
('Manuel José', 'Moreno Campo', 'jose.moreno@gmail.com','$2y$12$PVFYuJjgM7hBsrjrv17UHOaFiz2qTWvsvrL6Sq1wolmEZaVODqA3a', '67234917', 'El Imperio de la Alta Sociedad Torre 12 Piso 3', 'activo', NULL, 2),
('Carlos', 'Ramirez', 'carlos.ramirez@gmail.com', '$2y$12$TfvqCwC1sU7X8xGpoHoezehOHxEQmwr5Cbv83tc0s2JjwSuiVPYuu', '456123789', 'Boulevard Rose 789', 'activo', NULL, 3),
('Pedro', 'Manquillo Solarte', 'pedro.manquillo@gmail.com', '$2y$12$TfvqCwC1sU7X8xGpoHoezehOHxEQmwr5Cbv83tc0s2JjwSuiVPYuu', '456123089', 'Retiro Bajo 789', 'inactivo', NULL, 3),
('David','Rey Castillo','david.rey@gmail.com','$2y$12$PVFYuJjgM7hBsrjrv17UHOaFiz2qTWvsvrL6Sq1wolmEZaVODqA3a','3207490231','El pajonal Calle 3 # 9C-2','activo',NULL,4),
('Jesús David ','Velasco Quilindo','jesus.velasco@gmail.com','$2y$12$PVFYuJjgM7hBsrjrv17UHOaFiz2qTWvsvrL6Sq1wolmEZaVODqA3a','3175609347','La esmeralda calle 5 #4A-2','activo',NULL,4),
('Dueño','Clinica Dental','gerencia@dentalflow.com','$2y$12$PVFYuJjgM7hBsrjrv17UHOaFiz2qTWvsvrL6Sq1wolmEZaVODqA3a','3146590264','Retiro Alto Calle 5 #7B-3','activo',NULL,5);

/* Insertar procedimientos*/
INSERT INTO procedimientos (tipo_procedimiento, costo) VALUES
('Consulta General', 50000.00),
('Radiografía', 120000.00),
('Extracción Dental', 300000.00),
('Limpieza Dental', 80000.00),
('Ortodoncia Inicial', 450000.00),
('Blanqueamiento Dental', 250000.00),
('Endodoncia', 320000.00),
('Implante Dental', 1500000.00),
('Control Post-Operativo', 40000.00);

/* Insertar pacientes*/
INSERT INTO pacientes (cedula,nombres_paciente, apellidos_paciente, edad, genero, telefono_paciente, direccion_paciente, correo_paciente, tipo_sangre) VALUES
("1020304050",'Pedro', 'Lopez Rivera', 30, 'masculino', '123123123', 'Calle ABC', 'pedro.lopez@gmail.com', 'O+'),
("5040302010",'Ana', 'Martinez gomez', 45, 'femenino', '321321321', 'Avenida XYZ', 'ana.martinez@gmail.com', 'A-'),
("1122334455", 'Carlos Andrés', 'Ramírez Soto', 28, 'masculino', '987654321', 'Calle Los Pinos 123', 'carlos.ramirez@gmail.com', 'B+'),
("5566778899", 'María José', 'González Martinez', 35, 'femenino', '876543210', 'Avenida Libertad 456', 'maria.gonzalez@gmail.com', 'AB-'),
("6677889900", 'Luis Alberto', 'Fernández Ocampo', 52, 'masculino', '765432109', 'Pasaje El Sol 789', 'luis.fernandez@gmail.com', 'B-'),
("9988776655", 'Laura Patricia', 'Torres Ríos', 41, 'femenino', '654321098', 'Callejón San Juan 321', 'laura.torres@gmail.com', 'A+'),
("3344556677", 'Xavier Manuel', 'Pérez Montoya', 37, 'masculino', '543210987', 'Ruta 5 Km 18', 'javier.perez@gmail.com', 'B-'),
("2233445566", 'Lucía Fernanda', 'Morales Delgado', 22, 'femenino', '432109876', 'Camino Real 654', 'lucia.morales@gmail.com', 'AB+');

/* Insertar citas*/
INSERT INTO citas (fecha_cita, hora_cita, estado_cita, motivo_cita, total_cita, paciente_id, usuario_id) VALUES
('2025-05-05', '08:30:00', 'completada', 'Limpieza dental', 85000.00, '3344556677', 4),
('2025-05-05', '09:45:00', 'completada', 'Revisión de ortodoncia', 120000.00, '5566778899', 3),
('2025-05-06', '10:15:00', 'completada', 'Consulta general', 50000.00, '6677889900', 5),
('2025-05-06', '11:30:00', 'completada', 'Blanqueamiento dental', 250000.00, '9988776655', 4),
('2025-05-08', '13:00:00', 'completada', 'Extracción dental', 300000.00, '2233445566', 3),
('2025-05-10', '14:20:00', 'completada', 'Consulta por dolor de muelas', 60000.00, '1122334455', 5),
('2025-05-11', '07:45:00', 'completada', 'Control post-operatorio', 40000.00, '3344556677', 4),
('2025-05-11', '08:30:00', 'completada', 'Limpieza dental', 90000.00, '2233445566', 3),
('2025-05-12', '07:30:00', 'confirmada', 'Consulta general', 50000.00, "1020304050", 5),
('2025-05-13', '09:45:00', 'pendiente', 'Limpieza dental', 90000.00, "1122334455", 4),
('2025-05-13', '10:00:00', 'completada', 'Revisión de ortodoncia', 120000.00, "5566778899", 3),
('2025-05-13', '11:15:00', 'cancelada', 'Consulta de ortodoncia', 110000.00, "1122334455", 4),
('2025-05-13', '14:00:00', 'confirmada', 'Revisión anual', 100000.00, "2233445566", 4),
('2025-05-14', '08:15:00', 'pendiente', 'Control post-operatorio', 40000.00, "6677889900", 4),
('2025-05-15', '09:00:00', 'cancelada', 'Consulta por dolor de muelas', 60000.00, "9988776655", 5),
('2025-05-16', '11:45:00', 'confirmada', 'Limpieza dental', 85000.00, "2233445566", 3),
('2025-05-17', '14:15:00', 'pendiente', 'Consulta general', 50000.00, "3344556677", 4),
('2025-05-20', '15:30:00', 'completada', 'Extracción dental', 300000.00, "1122334455", 5),
('2025-05-21', '10:30:00', 'confirmada', 'Blanqueamiento dental', 250000.00, "5566778899", 3),
('2025-05-22', '16:00:00', 'pendiente', 'Dolor mandibular', 95000.00, "5040302010", 4),
('2025-05-23', '07:00:00', 'cancelada', 'Consulta de encías', 55000.00, "1020304050", 3);

/* Insertar procedimientos_citas*/
INSERT INTO procedimientos_citas (procedimiento_id, cita_id) VALUES
(1, 1),   
(3, 2),   
(4, 3),   
(4, 4),   
(1, 5),   
(9, 6),   
(1, 7),   
(3, 8),   
(1, 9),  
(2, 10),  
(6, 10),  
(5, 11), 
(1, 12),  
(2, 12),  
(1, 13);  

/* Insertar historia clínica*/
INSERT INTO historias_clinicas (antecedentes_medicos, tratamiento_realizados, paciente_id) VALUES
('Hipertensión', 'Control de presión', "1020304050"),
('Alergia a penicilina', 'Evitar antibióticos con penicilina', "1020304050"),
('Diabetes tipo 2', 'Control con metformina y dieta baja en azúcares', "5040302010"),
('Sin antecedentes relevantes', 'Limpieza dental y chequeos anuales', "1122334455"),
('Bruxismo', 'Uso de férula nocturna', "5566778899"),
('Extracción de muela del juicio', 'Cicatrización sin complicaciones', "6677889900"),
('Periodontitis crónica', 'Tratamiento periodontal y control trimestral', "9988776655"),
('Alergia al látex', 'Evitar uso de guantes o materiales con látex', "3344556677"),
('Asma leve', 'Inhalador de rescate antes de procedimientos', "2233445566");

/* Insertar recetas médicas*/
INSERT INTO recetas_medicas (historia_clinica_id, tipo_orden, descripcion_receta, medicamento_recetado, fecha_receta) VALUES 
(1, 'Medicamento', 'Tomar una pastilla diaria por la mañana', 'Losartan 50mg', '2025-05-12'),
(2, 'Antibiótico', 'Tomar una cápsula cada 8 horas por 7 días', 'Amoxicilina 500mg', '2025-05-13'),
(3, 'Medicamento', 'Administrar con el desayuno y cena', 'Metformina 850mg', '2025-05-14'),
(4, 'Indicación general', 'Continuar higiene bucal y uso de hilo dental', 'Sin medicación', '2025-05-15'),
(5, 'Dispositivo', 'Usar férula dental todas las noches', 'Férula rígida personalizada', '2025-05-16'),
(6, 'Analgésico', 'Tomar en caso de dolor postquirúrgico', 'Ibuprofeno 400mg', '2025-05-17'),
(7, 'Tratamiento', 'Aplicar gel antibacteriano cada 12 horas', 'Clorhexidina al 0.12%', '2025-05-18'),
(8, 'Advertencia', 'Evitar el uso de guantes de látex durante consulta', 'N/A', '2025-05-20'),
(9, 'Medicamento', 'Administrar 2 inhalaciones antes de la cita', 'Salbutamol aerosol', '2025-05-21'),
(3, 'Examen complementario', 'Control de glucosa capilar semanal', 'Kit glucómetro y tiras', '2025-05-22');

/* Insertar órdenes de compras*/
INSERT INTO ordenes_compras (fecha_expedicion, fecha_vencimiento, usuario_id, estado) VALUES
('2025-05-12', '2025-05-19', 2, 'ordenado'),
('2025-05-13', '2025-05-24', 3, 'aprobado'),
('2025-05-14', '2025-05-21', 4, 'en produccion'),
('2025-05-16', '2025-05-29', 2, 'listo para entregar'),
('2025-05-18', '2025-05-25', 3, 'entregado'),
('2025-05-18', '2025-05-21', 3, 'aprobado'),
('2025-05-19', '2025-05-22', 2, 'aprobado'),
('2025-05-20', '2025-05-27', 4, 'ordenado'),
('2025-05-21', '2025-06-05', 2, 'aprobado'),
('2025-05-22', '2025-06-01', 3, 'en produccion'),
('2025-05-23', '2025-06-05', 4, 'listo para entregar');

/* Insertar proveedores*/
INSERT INTO proveedores (nit,nombre_proveedor, telefono_proveedor, correo_proveedor) VALUES
('123','Medicorp', '111222333', 'ventas@medicorp.com'),
('432','DentalCare', '444555666', 'contacto@dentalcare.com'),
('665','KetoCorp', '896555666', 'contacto@ketocorp.com');

/* Insertar insumos*/
INSERT INTO insumos (nombre_insumo, cantidad_insumo, costo_insumo, fecha_vencimiento, umbral_alerta) VALUES
('Guantes quirúrgicos', 15, 2500.00, '2125-01-01', 20), 
('Anestesia local', 50, 20000.00, '2028-12-01', 10),
('Algodón dental', 80, 300.00, '2035-05-23', 100),       
('Mascarillas quirúrgicas', 45, 1800.00, '2125-05-23', 50),
('Jeringas desechables', 150, 500.00, '2125-05-23', 30),
('Vasos plásticos para enjuague', 300, 100.00, '2125-05-23', 80),
('Batas desechables', 60, 3500.00, '2125-05-23', 15),
('Carillas provisionales', 25, 45000.00, '2030-05-23', 5),
('Pasta profiláctica', 40, 12000.00, '2027-05-23', 10),
('Selladores dentales', 30, 30000.00, '2029-05-23', 5),
('Fórceps de extracción', 10, 120000.00, '2125-05-23', 2),
('Posicionadores radiográficos', 80, 2500.00, '2125-05-23', 10),
('Limas endodónticas', 60, 6000.00, '2125-05-23', 10),
('Material de impresión (alginato)', 20, 18000.00, '2026-05-23', 5),
('Resina compuesta', 40, 25000.00, '2028-05-23', 8);

/* Insertar proveedores_insumos*/
INSERT INTO proveedores_insumos (proveedor_id, insumo_id) VALUES
('123', 1), 
('123', 2), 
('123', 4),
('123', 5), 
('123', 7), 
('123', 10), 
('432', 2), 
('432', 3), 
('432', 6), 
('432', 8), 
('432', 9), 
('432', 14), 
('432', 15), 
('665', 2), 
('665', 5), 
('665', 6), 
('665', 11), 
('665', 12), 
('665', 13); 

/* Insertar detalles de órdenes*/
INSERT INTO detalles_ordenes (cantidad_insumo, total, orden_id, insumo_id) VALUES
(50, 125000.00, 1, 1), 
(60, 30000.00, 1, 3), 
(10, 200000.00, 2, 2), 
(80, 144000.00, 2, 4), 
(20, 50000.00, 2, 3), 
(40, 20000.00, 3, 3),
(5, 225000.00, 3, 9), 
(10, 35000.00, 4, 7), 
(100, 10000.00, 4, 6),
(3, 135000.00, 5, 8), 
(10, 250000.00, 5, 10),
(40, 20000.00, 6, 3), 
(50, 25000.00, 6, 6),  
(15, 180000.00, 7, 9), 
(10, 180000.00, 7, 15),
(8, 160000.00, 7, 2),  
(20, 500000.00, 7, 15), 
(5, 90000.00, 8, 14),  
(6, 15000.00, 9, 5),
(60, 108000.00, 10, 4), 
(10, 60000.00, 10, 13), 
(4, 72000.00, 11, 14), 
(12, 6000.00, 11, 5);  

/*VISTAS*/
/*OBTENER DATOS DE UNA CITA*/
CREATE VIEW v_citas AS
SELECT c.id_cita, c.fecha_cita, c.hora_cita, c.estado_cita, c.motivo_cita, p.nombres_paciente, p.apellidos_paciente, u.nombres_usuario
AS odontologo_nombre, u.apellidos_usuario
AS odontologo_apellido
FROM citas c JOIN pacientes p ON c.paciente_id = p.cedula JOIN usuarios u ON c.usuario_id = u.id_usuario;

/*OBTENER DATOS AVANZADOS DE CITAS*/
CREATE VIEW v_citas_avanzadas AS
SELECT c.id_cita, c.fecha_cita, c.hora_cita, c.estado_cita, c.motivo_cita, p.cedula
AS cedula, p.nombres_paciente, p.apellidos_paciente, u.nombres_usuario
AS odontologo_nombre, u.apellidos_usuario
AS odontologo_apellido
FROM citas c JOIN pacientes p ON c.paciente_id = p.cedula JOIN usuarios u ON c.usuario_id = u.id_usuario;

/*Listar todos los usuarios con su rol correspondiente*/
CREATE VIEW v_usuarios_roles AS
SELECT u.id_usuario, u.nombres_usuario, u.apellidos_usuario, r.nombre_rol
FROM usuarios u
JOIN roles r ON u.rol_id = r.id_rol;

/*Obtener la cantidad de usuarios por cada rol*/
CREATE VIEW v_cantidad_usuarios_por_rol AS
SELECT r.nombre_rol, COUNT(*) AS cantidad_usuarios
FROM usuarios u
JOIN roles r ON u.rol_id = r.id_rol
GROUP BY r.nombre_rol;

/*Usuarios activos y su especialidad (si tienen)*/
CREATE VIEW v_usuarios_activos AS
SELECT id_usuario, nombres_usuario, apellidos_usuario,
       estado_usuario,
       COALESCE(especialidad_usuario, 'No aplica') AS especialidad,
       rol_id
FROM usuarios
WHERE estado_usuario = 'activo';

/*Insumos con bajo stock*/
CREATE VIEW v_insumos_bajo_stock AS
SELECT * FROM insumos
WHERE cantidad_insumo <= umbral_alerta;

/*VER PROVEDORES Y SUS INSUMOS*/
CREATE VIEW v_proveedores_insumos AS
SELECT i.nombre_insumo AS Insumo,p.nombre_proveedor AS Provedoor FROM insumos i
JOIN proveedores_insumos pi ON pi.insumo_id = i.id_insumo
JOIN proveedores p ON p.nit = pi.proveedor_id;

/*VISTA DE VENCIMIENTO 30 DIAS*/
CREATE VIEW v_insumos_vencimiento AS
SELECT * FROM insumos
WHERE fecha_vencimiento BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY);

/*VER CANTIDAD DE ESTADO CITAS (pendiente 1, confirmada 2, cancelada 4, completada 3)*/
CREATE VIEW v_cantidad_estado_citas AS
SELECT estado_cita,
       SUM(total_cita) AS total_cita,
       COUNT(*) AS cantidad,
       fecha_cita
FROM citas
WHERE estado_cita IN ('cancelada', 'completada')
GROUP BY estado_cita, fecha_cita;

/*RENDIMIENTO ODONTOLOGOS*/
CREATE OR REPLACE VIEW v_rendimiento_odontologos AS
SELECT 
    u.id_usuario, 
    CONCAT(u.nombres_usuario, ' ', u.apellidos_usuario) AS nombre_completo_odontologo,
    COUNT(c.id_cita) AS cantidad_citas,
    c.fecha_cita
FROM usuarios u
JOIN citas c ON u.id_usuario = c.usuario_id
WHERE c.estado_cita IN ('cancelada', 'completada')
GROUP BY u.id_usuario, u.nombres_usuario, u.apellidos_usuario, c.fecha_cita;


/*VER TOTAL DE PROCEDIMIENTOS REALIZADOS POR ODONTOLOGO*/
CREATE VIEW v_procedimientos_por_odontologo AS
SELECT 
    u.id_usuario,
    CONCAT(u.nombres_usuario, ' ', u.apellidos_usuario) AS nombre_completo_odontologo,
    COUNT(*) AS cantidad
FROM procedimientos p
JOIN procedimientos_citas pc ON p.id_procedimiento = pc.procedimiento_id
JOIN citas c ON pc.cita_id = c.id_cita
JOIN usuarios u ON c.usuario_id = u.id_usuario
WHERE c.estado_cita = 'completada'
GROUP BY u.id_usuario, u.nombres_usuario, u.apellidos_usuario;


/*VER CANTIDAD DE ESTADO DE CITAS PARA UN ODONTOLOGO ESPECIFICO*/
CREATE VIEW v_cantidad_estado_citas_odontologo AS
SELECT u.id_usuario, c.estado_cita, COUNT(*) AS cantidad
FROM citas c
JOIN usuarios u ON c.usuario_id = u.id_usuario
GROUP BY u.id_usuario, c.estado_cita;


/*ESTADO CITA DEL PACIENTES */
CREATE VIEW v_estado_citas_pacientes As
SELECT c.id_cita,u.id_usuario,c.hora_cita,p.cedula,
CONCAT(p.nombres_paciente,' ',p.apellidos_paciente) AS nombre_completo_paciente,
 c.estado_cita,CONCAT(u.nombres_usuario,' ',u.apellidos_usuario) AS nombre_completo_odontologo
FROM pacientes p
JOIN citas c ON c.paciente_id = p.cedula
JOIN usuarios u ON u.id_usuario = c.usuario_id
WHERE u.rol_id = 2;

CREATE OR REPLACE VIEW v_citas_detalladas 
AS SELECT c.fecha_cita, 
CONCAT(u.nombres_usuario, ' ', u.apellidos_usuario) AS nombre_completo_odontologo, 
c.estado_cita, COUNT(c.id_cita) AS cantidad, 
SUM(c.total_cita) AS total_cita FROM prototype1.citas c 
JOIN prototype1.usuarios u ON u.id_usuario = c.usuario_id 
WHERE c.estado_cita IN ('cancelada', 'completada') GROUP BY c.fecha_cita, CONCAT(u.nombres_usuario, ' ', u.apellidos_usuario),c.estado_cita;

/*Vista de gestion de usuarios*/
CREATE OR REPLACE VIEW v_gestion_usuarios AS
SELECT
    u.id_usuario AS id,
    CONCAT(u.nombres_usuario, ' ', u.apellidos_usuario) AS nombre_completo,
    u.correo_usuario AS correo,
    u.estado_usuario AS estado,
    r.nombre_rol AS rol
FROM
    usuarios u
JOIN
    roles r ON u.rol_id = r.id_rol;


/*Consultas sobre Historia Clínica y Recetas Médicas*/
CREATE VIEW v_paciente_historia_receta AS
SELECT p.nombres_paciente, h.antecedentes_medicos, h.tratamiento_realizados
FROM pacientes p
JOIN historias_clinicas h ON p.cedula= h.paciente_id;

/*GESTION INSUMOS ODONTOLOGO**/
CREATE VIEW v_gestion_insumos AS
SELECT
    i.nombre_insumo,
    i.cantidad_insumo as cantidad_actual,
    deto.cantidad_insumo as cantidad_ordenada,
    oc.estado,
    i.fecha_vencimiento,
    deto.total,
    i.umbral_alerta
FROM detalles_ordenes AS deto
JOIN insumos i ON deto.insumo_id = i.id_insumo
JOIN ordenes_compras oc ON deto.orden_id = oc.id_orden_compra
 ORDER BY oc.estado ASC;

/*PROCEDIMIENTOS*/
/*INSERTAR o REGISTRAR PACIENTE*/
DELIMITER //

CREATE PROCEDURE pa_InsertarPaciente(
    in cedula VARCHAR(20),
    IN nombres VARCHAR(50),
    IN apellidos VARCHAR(50),
    IN edad INT,
    IN genero ENUM('masculino', 'femenino'),
    IN telefono VARCHAR(50),
    IN direccion VARCHAR(50),
    IN correo VARCHAR(50),
    IN tipo_sangre ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-')
)
BEGIN
    INSERT INTO pacientes (cedula, nombres_paciente, apellidos_paciente, edad, genero, telefono_paciente, direccion_paciente, correo_paciente, tipo_sangre)
    VALUES (cedula,nombres ,apellidos, edad, genero, telefono, direccion, correo, tipo_sangre);
END //

DELIMITER ;

CALL pa_InsertarPaciente("101010011",'Luis Esteban ', 'Gomez Gonzales', 34, 'masculino', '123456789', 'Calle 123', 'luis.gomez@example.com', 'O+');
/*LISTO*/

/*ACTUALIZAR DATOS PACIENTE*/
DELIMITER //

CREATE PROCEDURE pa_ActualizarPaciente(
    IN id_paciente INT,
    IN nombre VARCHAR(50),
    IN apellido VARCHAR(50),
    IN edad_t INT,
    IN genero_t ENUM('masculino', 'femenino'),
    IN telefono VARCHAR(50),
    IN direccion VARCHAR(50),
    IN correo VARCHAR(50),
    IN tipo_sangre_t ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-')
)
BEGIN
    UPDATE pacientes
    SET
        nombres_paciente = nombre,
        apellidos_paciente = apellido,
        edad = edad_t,
        genero = genero_t,
        telefono_paciente = telefono,
        direccion_paciente = direccion,
        correo_paciente = correo,
        tipo_sangre = tipo_sangre_t
    WHERE cedula = id_paciente;
END //

DELIMITER ;

CALL pa_ActualizarPaciente('1020304050', 'Carlos', 'Martínez', 40, 'masculino', '321654987', 'Av. Siempre Viva 742', 'carlos.martinez@gmail.com', 'A+');
/*LISTO*/

/*ELIMINAR PACIENTE*/

DELIMITER //

CREATE PROCEDURE pa_EliminarPaciente(
    IN cedula_t VARCHAR(20)
)
BEGIN
    DELETE FROM pacientes
    WHERE cedula = cedula_t;
END //

DELIMITER ;

/*MOSTRAR PACIENTE*/

DELIMITER //

CREATE PROCEDURE pa_ObtenerPacientes()
BEGIN
    SELECT
        cedula,
        nombres_paciente,
        apellidos_paciente,
        edad,
        genero,
        telefono_paciente,
        direccion_paciente,
        correo_paciente,
        tipo_sangre
    FROM pacientes;
END //

DELIMITER ;

/*REGISTRAR CITAS*/
DELIMITER //
CREATE PROCEDURE pa_InsertarCita(
    IN fecha_cita_t DATE,
    IN hora_cita_t TIME,
    IN estado_cita_t ENUM('pendiente', 'confirmada', 'cancelada', 'completada'),
    IN motivo_cita_t VARCHAR(255),
    IN total_cita_t DECIMAL(10, 2),
    IN paciente_id_t VARCHAR(20),
    IN usuario_id_t INT
)
BEGIN
    INSERT INTO citas (fecha_cita, hora_cita, estado_cita, motivo_cita, total_cita, paciente_id, usuario_id)
    VALUES (fecha_cita_t, hora_cita_t, estado_cita_t, motivo_cita_t, total_cita_t, paciente_id_t, usuario_id_t);
END //
DELIMITER ;
CALL pa_InsertarCita('2025-04-22', '11:30:00', 'pendiente', 'Chequeo dental', 100000.00, '1020304050', 2);
/*LISTO*/

/*ACTUALIZAR ESTADO CITAS*/
DELIMITER //

CREATE PROCEDURE pa_ActualizarEstadoCita(
    IN id_cita_t INT,
    IN nuevo_estado ENUM('pendiente', 'confirmada', 'cancelada', 'completada')
)
BEGIN
    UPDATE citas
    SET estado_cita = nuevo_estado
    WHERE id_cita = id_cita_t;
END //

DELIMITER ;
CALL pa_ActualizarEstadoCita(5, 'completada');
/*LISTO*/

/*ACTUALIZAR CITA*/
DELIMITER //
CREATE PROCEDURE pa_ActualizarCita(
    IN id_cita_t INT,
    IN nueva_fecha DATE,
    IN nueva_hora TIME,
    IN nuevo_estado ENUM('pendiente', 'confirmada', 'cancelada', 'completada'),
    IN nuevo_motivo VARCHAR(255),
    IN nuevo_total DECIMAL(10, 2),
    IN nuevo_odontologo INT
)
BEGIN
    UPDATE citas
    SET
        fecha_cita = nueva_fecha,
        hora_cita = nueva_hora,
        estado_cita = nuevo_estado,
        motivo_cita = nuevo_motivo,
        total_cita = nuevo_total,
        usuario_id = nuevo_odontologo
    WHERE id_cita = id_cita_t;
END //

DELIMITER ;
CALL pa_ActualizarCita(1, '2025-04-20', '20:30:00', 'confirmada', 'Consulta de seguimiento', 1200000.00,2);
/*LISTO*/

/*ELIMINAR CITA*/

DELIMITER //

CREATE PROCEDURE pa_EliminarCita(
    IN id_cita_t INT
)
BEGIN
    DELETE FROM citas
    WHERE id_cita = id_cita_t;
END //

DELIMITER ;

/*MOSTRAR CITA*/

DELIMITER //

CREATE PROCEDURE pa_ObtenerCitas()
BEGIN
    SELECT
        c.id_cita,
        c.fecha_cita,
        c.hora_cita,
        c.estado_cita,
        c.motivo_cita,
        c.total_cita,
        c.paciente_id,
        CONCAT(p.nombres_paciente, ' ', p.apellidos_paciente) AS nombre_paciente,
        u.id_usuario,
        CONCAT(u.nombres_usuario, ' ', u.apellidos_usuario) AS nombre_odontologo
    FROM citas c
    INNER JOIN pacientes p ON c.paciente_id = p.cedula
    INNER JOIN usuarios u ON c.usuario_id = u.id_usuario;
END //

DELIMITER ;
/*OBTENER CITA DE HOY*/

DELIMITER //
CREATE PROCEDURE pa_ObtenerCitasHoy(IN p_fecha DATE)
BEGIN
  SELECT * FROM v_citas WHERE fecha_cita = p_fecha;
END //

DELIMITER ;

/*ACTUALIZAR ESTADO PEDIDOS*/
DELIMITER //

CREATE PROCEDURE pa_ActualizarEstadoPedidos(
    IN id_orden_t INT,
    IN nuevo_estado ENUM('ordenado', 'en produccion', 'listo para entregar', 'entregado')
)
BEGIN
    UPDATE ordenes_compras
    SET estado = nuevo_estado
    WHERE id_orden_compra = id_orden_t;
END //

DELIMITER ;
CALL pa_ActualizarEstadoPedidos(1, 'ordenado');
/*LISTO*/


/*ACTUALIZAR ESTADO USUARIOS*/
DELIMITER //

CREATE PROCEDURE pa_ActualizarEstadoUsuarios(
    IN id_usuario_t INT,
    IN nuevo_estado ENUM('activo', 'inactivo')
)
BEGIN
    UPDATE usuarios
    SET estado_usuario = nuevo_estado
    WHERE id_usuario = id_usuario_t;
END //

DELIMITER ;
CALL pa_ActualizarEstadoUsuarios(1, 'activo');
/*LISTO*/

/*INSERTAR USUARIOS*/
DELIMITER //

CREATE PROCEDURE pa_InsertarUsuario(
    IN nombres_usuario VARCHAR(50),
    IN apellidos_usuario VARCHAR(50),
    IN correo VARCHAR(50),
    IN contrasena VARCHAR(50),
    IN telefono VARCHAR(50),
    IN direccion VARCHAR(100),
    IN estado ENUM('activo', 'inactivo'),
    IN especialidad VARCHAR(50),
    IN rol INT
)
BEGIN
    INSERT INTO usuarios (nombres_usuario, apellidos_usuario, correo_usuario, contrasena_usuario, telefono_usuario, direccion_usuario, estado_usuario, especialidad_usuario, rol_id)
    VALUES (nombres_usuario, apellidos_usuario, correo, contrasena, telefono, direccion, estado, especialidad, rol);
END //

DELIMITER ;
CALL pa_InsertarUsuario('Ana', 'Lopez', 'ana.lopez@gmail.com', '12345', '987654321', 'Av. Central 456', 'activo', 'Odontología Forense', 2);
/*LISTO*/

/*ACTUALIZAR USUARIOS*/
DELIMITER //
CREATE PROCEDURE pa_ActualizarUsuario(
IN id_usuario_t INT,
IN nombres VARCHAR(50),
IN apellidos VARCHAR(50),
IN correo VARCHAR(50),
IN telefono VARCHAR(50),
IN direccion VARCHAR(100),
IN estado ENUM('activo', 'inactivo'),
IN especialidad VARCHAR(50),
IN rol INT
)
BEGIN
    UPDATE usuarios
    SET
        nombres_usuario = nombres,
        apellidos_usuario = apellidos,
        correo_usuario = correo,
        telefono_usuario = telefono,
        direccion_usuario = direccion,
        estado_usuario = estado,
        especialidad_usuario = especialidad,
        rol_id = rol
    WHERE id_usuario = id_usuario_t;
END //

DELIMITER ;

CALL pa_ActualizarUsuario(5,'Felipe Manuel','Caicedo Ximenex','felipe.ximenex@gmail.com','123456789','Bolivar Calle 123 # 45-67','inactivo','Odontología General',2);
/*LISTO*/

/*ELIMINAR USUARIO*/

DELIMITER //

CREATE PROCEDURE pa_EliminarUsuario(
    IN id_usuario_t INT
)
BEGIN
    DELETE FROM usuarios
    WHERE id_usuario = id_usuario_t;
END //

DELIMITER ;

/*MOSTRAR USUARIO*/

DELIMITER //

CREATE PROCEDURE pa_ObtenerUsuarios()
BEGIN
    SELECT
        u.id_usuario,
        u.nombres_usuario,
        u.apellidos_usuario,
        u.correo_usuario,
        u.telefono_usuario,
        u.direccion_usuario,
        u.estado_usuario,
        u.especialidad_usuario,
        r.nombre_rol
    FROM usuarios u
    INNER JOIN roles r ON u.rol_id = r.id_rol;
END //

DELIMITER ;

/*ACTUALIZAR PROVEEDOR*/
DELIMITER //

CREATE PROCEDURE pa_ActualizarProveedor(
    IN id_proveedor_t VARCHAR(20),
    IN nombre VARCHAR(50),
    IN telefono VARCHAR(50),
    IN correo VARCHAR(50)
)
BEGIN
    UPDATE proveedores
    SET
        nombre_proveedor = nombre,
        telefono_proveedor = telefono,
        correo_proveedor = correo
    WHERE nit = id_proveedor_t;
END //

DELIMITER ;
CALL pa_ActualizarProveedor('123', 'Suministros Médicos S.A.', '987654321', 'contacto@sumedicos.com');
/*LISTO*/

/*REGISTRAR PROVEEDOR*/
DELIMITER //
CREATE PROCEDURE pa_InsertarProveedor(
    IN nit_t VARCHAR(20),
    IN nombre VARCHAR(50),
    IN telefono VARCHAR(50),
    IN correo VARCHAR(50)
)
BEGIN
    INSERT INTO proveedores (nit,nombre_proveedor, telefono_proveedor, correo_proveedor)
    VALUES (nit_t,nombre, telefono, correo);
END //

DELIMITER ;

CALL pa_InsertarProveedor('69543','CocaCorp S.A','6537843','general@cocacorp.com');
/*LISTO*/

/*PROCEDIMIENTOS ALMACENADOS PARA INSUMOS*/

DELIMITER //

/*Insertar insumo*/
CREATE PROCEDURE pa_InsertarInsumo(
    IN p_nombre VARCHAR(50),
    IN p_cantidad INT,
    IN p_costo DECIMAL(10,2),
    IN p_fecha DATE,
    IN p_umbral INT
)
BEGIN
    INSERT INTO insumos(nombre_insumo, cantidad_insumo, costo_insumo, fecha_vencimiento, umbral_alerta)
    VALUES (p_nombre, p_cantidad, p_costo, p_fecha, p_umbral);
END //

/*Actualizar insumo*/
CREATE PROCEDURE pa_ActualizarInsumo(
    IN p_id INT,
    IN p_nombre VARCHAR(50),
    IN p_cantidad INT,
    IN p_costo DECIMAL(10,2),
    IN p_fecha DATE,
    IN p_umbral INT
)
BEGIN
    UPDATE insumos
    SET nombre_insumo = p_nombre,
        cantidad_insumo = p_cantidad,
        costo_insumo = p_costo,
        fecha_vencimiento = p_fecha,
        umbral_alerta = p_umbral
    WHERE id_insumo = p_id;
END //

/*Eliminar insumo*/
CREATE PROCEDURE pa_EliminarInsumo(IN p_id INT)
BEGIN
    DELETE FROM insumos WHERE id_insumo = p_id;
END //

/*Obtener todos los insumos*/
CREATE PROCEDURE pa_ObtenerInsumos()
BEGIN
    SELECT * FROM insumos;
END //

DELIMITER ;

/*PETICION INSUMOS*/
DELIMITER //

CREATE PROCEDURE pa_PeticionInsumos(
    IN id_insumo_t INT,
    IN cantidad INT,
    IN id_orden INT
)
BEGIN
    /* Declarar la variable correctamente*/
    DECLARE total_t DECIMAL(10, 2);

    /* Calcular el total*/
    SET total_t = (SELECT costo_insumo FROM insumos WHERE id_insumo = id_insumo_t) * cantidad;

    /* Insertar en la tabla detalles_ordenes*/
    INSERT INTO detalles_ordenes (cantidad_insumo, total, orden_id,insumo_id)
    VALUES (cantidad, total_t, id_orden, (SELECT id_proveedor_insumo FROM proveedores_insumos WHERE insumo_id = id_insumo_t LIMIT 1));

END //

DELIMITER ;

CALL pa_PeticionInsumos(1, 10, 1);
/*ELIMINAR PROVEEDOR*/
DELIMITER //

CREATE PROCEDURE pa_EliminarProveedor (
    IN _nit VARCHAR(20)
)
BEGIN
    DELETE FROM proveedores WHERE nit = _nit;
END //

DELIMITER ;

/*LISTAR PROVEEDORES*/
DELIMITER //

CREATE PROCEDURE pa_ObtenerProveedores()
BEGIN
    SELECT nit, nombre_proveedor, telefono_proveedor, correo_proveedor
    FROM proveedores;
END //

DELIMITER ;


/*RECHAZAR PEDIDO(ROL DUEÑO)*/
DELIMITER //

CREATE PROCEDURE pa_RechazarPedido(
    IN id_orden_t INT
)
BEGIN

    DELETE FROM detalles_ordenes WHERE orden_id = id_orden_t;

    DELETE FROM ordenes_compras WHERE id_orden_compra = id_orden_t;
END //

DELIMITER ;

CALL pa_RechazarPedido(1);
/*LISTO*/

/*REGISTRAR HISTORIA CLINICA*/
DELIMITER //

CREATE PROCEDURE pa_RegistrarHistoriaClinica(
    IN paciente_id_t VARCHAR(20),
    IN antecedentes VARCHAR(255),
    IN tratamientos VARCHAR(255)
)
BEGIN
    INSERT INTO historias_clinicas (paciente_id, antecedentes_medicos, tratamiento_realizados)
    VALUES (paciente_id_t, antecedentes, tratamientos);
END //

DELIMITER ;

CALL pa_RegistrarHistoriaClinica("1020304050", 'Hipertensión y diabetes', 'Tratamiento con insulina y dieta controlada');
/*LISTO*/

/*ACTUALIZAR HISTORIA CLINICA*/
DELIMITER //

CREATE PROCEDURE pa_ActualizarHistoriaClinica(
    IN id_historia_t INT,
    IN nuevos_antecedentes VARCHAR(255),
    IN nuevos_tratamientos VARCHAR(255)
)
BEGIN
    UPDATE historias_clinicas
    SET
        antecedentes_medicos = nuevos_antecedentes,
        tratamiento_realizados = nuevos_tratamientos
    WHERE id_historia_clinica = id_historia_t;
END //

DELIMITER ;

CALL pa_ActualizarHistoriaClinica(5, 'Hipertensión controlada, sin cambios', 'Nuevo tratamiento con Amlodipino');
/*LISTO*/

/*ELIMINAR HISTORIA CLINICA*/
DELIMITER //
CREATE PROCEDURE pa_EliminarHistoriaClinica(
    IN id_historia_t INT
)
BEGIN
    DELETE FROM historias_clinicas
    WHERE id_historia_clinica = id_historia_t;
END //
DELIMITER ;

/*OBTENER HISTORIA CLINICA*/
DELIMITER //
CREATE PROCEDURE pa_ObtenerHistoriaClinica()
BEGIN
    SELECT hc.*, p.nombre, p.apellido
    FROM historias_clinicas hc
    INNER JOIN pacientes p ON hc.paciente_id = p.cedula;
END //
DELIMITER ;

/*REGISTRAR RECETAS MEDICAS*/
DELIMITER //
CREATE PROCEDURE pa_InsertarRecetaMedica(
    IN historia_clinica_id_t INT,
    IN tipo_orden_t VARCHAR(50),
    IN descripcion_receta_t VARCHAR(255),
    IN medicamento_recetado_t VARCHAR(255),
    IN fecha_receta_t DATE
)
BEGIN
    INSERT INTO recetas_medicas (historia_clinica_id, tipo_orden, descripcion_receta, medicamento_recetado, fecha_receta)
    VALUES (historia_clinica_id_t, tipo_orden_t, descripcion_receta_t, medicamento_recetado_t, fecha_receta_t);
END //
DELIMITER ;

CALL pa_InsertarRecetaMedica(1, 'Medicamento', 'Tomar una pastilla diaria', 'Ibuprofeno 400mg', '2024-03-07');
/*LISTO*/

/*ACTUALIZAR RECETAS MEDICAS*/
DELIMITER //
CREATE PROCEDURE pa_ActualizarRecetaMedica(
    IN id_receta_t INT,
    IN historia_clinica_id_t INT,
    IN tipo_orden_t VARCHAR(50),
    IN descripcion_receta_t VARCHAR(255),
    IN medicamento_recetado_t VARCHAR(255),
    IN fecha_receta_t DATE
)
BEGIN
    UPDATE recetas_medicas
    SET
        historia_clinica_id = historia_clinica_id_t,
        tipo_orden = tipo_orden_t,
        descripcion_receta = descripcion_receta_t,
        medicamento_recetado = medicamento_recetado_t,
        fecha_receta = fecha_receta_t
    WHERE id_receta = id_receta_t;
END //
DELIMITER ;

CALL pa_ActualizarRecetaMedica(3, 1, 'Medicamento', 'Tomar dos pastillas diarias', 'Ketorolaco  400mg', '2025-03-08');
/*LISTO*/
/*ELIMINAR RECETA MEDICA*/
DELIMITER //
CREATE PROCEDURE pa_EliminarRecetaMedica(
    IN id_receta_t INT
)
BEGIN
    DELETE FROM recetas_medicas
    WHERE id_receta = id_receta_t;
END //
DELIMITER ;

/*OBTENER RECETA MEDICA*/
DELIMITER //
CREATE PROCEDURE pa_ObtenerRecetasMedicas()
BEGIN
    SELECT * FROM recetas_medicas;
END //
DELIMITER ;

/*PROCEDIMIENTOS ALMACENADOS PARA ORDENCOMPRA*/

DELIMITER //
/*INSERTAR ORDENCOMPRA*/
CREATE PROCEDURE pa_InsertarOrdenCompra(
    IN p_fecha_expedicion DATE,
    IN p_fecha_vencimiento DATE,
    IN p_usuario_id INT,
    IN p_estado ENUM('ordenado', 'en produccion', 'listo para entregar', 'entregado')
)
BEGIN
    INSERT INTO ordenes_compras(fecha_expedicion, fecha_vencimiento, usuario_id, estado)
    VALUES (p_fecha_expedicion, p_fecha_vencimiento, p_usuario_id, p_estado);
END //


/*ACTUALIZAR ORDENCOMPRA*/

CREATE PROCEDURE pa_ActualizarOrdenCompra(
    IN p_id INT,
    IN p_fecha_expedicion DATE,
    IN p_fecha_vencimiento DATE,
    IN p_usuario_id INT,
    IN p_estado ENUM('ordenado', 'en produccion', 'listo para entregar', 'entregado')
)
BEGIN
    UPDATE ordenes_compras
    SET fecha_expedicion = p_fecha_expedicion,
        fecha_vencimiento = p_fecha_vencimiento,
        usuario_id = p_usuario_id,
        estado = p_estado
    WHERE id_orden_compra = p_id;
END //


/*ELIMINAR ORDENCOMPRA*/

CREATE PROCEDURE pa_EliminarOrdenCompra(IN p_id INT)
BEGIN
    DELETE FROM ordenes_compras WHERE id_orden_compra = p_id;
END //


/*OBTENER ORDENCOMPRAS*/

CREATE PROCEDURE pa_ObtenerOrdenesCompras()
BEGIN
    SELECT * FROM ordenes_compras;
END //

DELIMITER ;

/*ROLES*/
/*OBTENER ROLES*/
DELIMITER //
CREATE PROCEDURE pa_ObtenerRoles()
BEGIN
    SELECT * FROM roles;
END //
DELIMITER ;

/*PROCEDIMIENTOS*/
/*INSERTAR PROCEDIMIENTO*/
DELIMITER //
CREATE PROCEDURE pa_InsertarProcedimiento(
    IN tipo_procedimiento_t VARCHAR(30),
    IN costo_t DECIMAL(10, 2)
)
BEGIN
    INSERT INTO procedimientos (tipo_procedimiento, costo)
    VALUES (tipo_procedimiento_t, costo_t);
END //
DELIMITER ;

/*ACTUALIZAR PROCEDIMIENTO*/
DELIMITER //
CREATE PROCEDURE pa_ActualizarProcedimiento(
    IN id_procedimiento_t INT,
    IN tipo_procedimiento_t VARCHAR(30),
    IN costo_t DECIMAL(10, 2)
)
BEGIN
    UPDATE procedimientos
    SET tipo_procedimiento = tipo_procedimiento_t,
        costo = costo_t
    WHERE id_procedimiento = id_procedimiento_t;
END //
DELIMITER ;

/*ELIMINAR PROCEDIMIENTO*/
DELIMITER //
CREATE PROCEDURE pa_EliminarProcedimiento(
    IN id_procedimiento_t INT
)
BEGIN
    DELETE FROM procedimientos
    WHERE id_procedimiento = id_procedimiento_t;
END //
DELIMITER ;

/*OBTENER PROCEDIMIENTO*/
DELIMITER //
CREATE PROCEDURE pa_ObtenerProcedimientos()
BEGIN
    SELECT * FROM procedimientos;
END //
DELIMITER ;
