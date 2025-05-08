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
    correo_usuario VARCHAR(50) NOT NULL,
    contrasena_usuario VARCHAR(255) NOT NULL,
    telefono_usuario VARCHAR(50) NOT NULL,
    direccion_usuario VARCHAR(100) NOT NULL,
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
    cedula VARCHAR(20) NOT NULL PRIMARY KEY,
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
    estado ENUM('ordenado', 'en produccion', 'listo para entregar', 'entregado') NOT NULL,
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

/*TABLAS PARA LABORATORISTA*/
CREATE TABLE ordenes_laboratorio (
    id_orden_lab INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    cita_id INT NOT NULL,
    usuario_id INT NOT NULL,               -- el laboratorista asignado
    fecha_solicitud DATE NOT NULL,
    fecha_limite DATE NOT NULL,
    horario ENUM('Mañana','Tarde') NOT NULL,
    tipo_material VARCHAR(50) NOT NULL,
    otros_detalles TEXT,
    estado ENUM('pendiente','en producción','listo para enviar','entregada','rechazada')
        NOT NULL DEFAULT 'pendiente',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (cita_id)   REFERENCES citas(id_cita),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id_usuario)
);

CREATE TABLE productos_laboratorio (
    id_producto_lab INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    orden_id INT NOT NULL,    -- referencia a ordenes_laboratorio.id_orden_lab
    insumo_id INT NOT NULL,
    cantidad INT NOT NULL,
    detalles TEXT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (orden_id)  REFERENCES ordenes_laboratorio(id_orden_lab),
    FOREIGN KEY (insumo_id) REFERENCES insumos(id_insumo)
);

/* Insertar roles*/
INSERT INTO roles (id_rol, nombre_rol, descripcion_rol) VALUES
(1, 'Administrador', 'Gestiona el sistema'),
(2, 'Odontologo',     'Atiende a los pacientes'),
(3, 'Asistente',      'Agenda citas y maneja pacientes'),
(4, 'Laboratorista',  'Gestiona órdenes de laboratorio'),
(5, 'Dueño',          'Supervisor general del sistema');

/* Insertar usuarios*/
INSERT INTO usuarios (nombres_usuario, apellidos_usuario, correo_usuario, contrasena_usuario, telefono_usuario, direccion_usuario, estado_usuario, especialidad_usuario, rol_id) VALUES
("Marco Alejandro","Torres Gomez","marcotorres@gmail.com","contra123456789","3112345678","Calle 123 # 45-67","activo",NULL,1),
('Juan', 'Pérez', 'juan.perez@gmail.com', 'hashedpassword1', '123456789', 'Calle 12C #3-10 Centro', 'activo', 'Odontopediatría', 2),
('Maria', 'Gonzalez', 'maria.gonzalez@gmail.com', 'hashedpassword2', '987654321', 'Avenida Azulejo 456', 'activo', 'Cirugía Oral y Maxilofacial', 2),
('Carlos', 'Ramirez', 'carlos.ramirez@gmail.com', 'hashedpassword3', '456123789', 'Boulevard Rose 789', 'activo', NULL, 3),
('Gref', 'Smithforge', 'grefsmithforge@gmail.com', 'contraseñageneric3', '456123089', 'Retiro Bajo 789', 'inactivo', NULL, 3),
('Manuel José', 'Moreno Campo', 'jose.moreno@gmail.com','$2y$12$PVFYuJjgM7hBsrjrv17UHOaFiz2qTWvsvrL6Sq1wolmEZaVODqA3a', '67234917', 'El Imperio de la Alta Sociedad Torre 12 Piso 3', 'activo', NULL, 2),
('Janer Esteban', 'Pechene Cifuentes', 'janner.pechene@gmail.com','$2y$12$PVFYuJjgM7hBsrjrv17UHOaFiz2qTWvsvrL6Sq1wolmEZaVODqA3a', '67234917', 'El Imperio de la Alta Sociedad Torre 12 Piso 3', 'activo', NULL, 3),
('Juan Armando','Gomez Galindez','juan.laboratorista@example.com', '$2y$12$PVFYuJjgM7hBsrjrv17UHOaFiz2qTWvsvrL6Sq1wolmEZaVODqA3a', '3001234567','Calle Falsa 123','activo',NULL,4);
/* Insertar procedimientos*/
INSERT INTO procedimientos (tipo_procedimiento, costo) VALUES
('Consulta General', 50000.00),
('Radiografía', 120000.00),
('Extracción Dental', 300000.00);

/* Insertar pacientes*/
INSERT INTO pacientes (cedula,nombres_paciente, apellidos_paciente, edad, genero, telefono_paciente, direccion_paciente, correo_paciente, tipo_sangre) VALUES
("1020304050",'Pedro', 'Lopez', 30, 'masculino', '123123123', 'Calle ABC', 'pedro.lopez@gmail.com', 'O+'),
("5040302010",'Ana', 'Martinez', 45, 'femenino', '321321321', 'Avenida XYZ', 'ana.martinez@gmail.com', 'A-');

/* Insertar citas*/
INSERT INTO citas (fecha_cita, hora_cita, estado_cita, motivo_cita, total_cita, paciente_id, usuario_id) VALUES
('2024-04-01', '09:00:00', 'confirmada', 'Dolor de muelas', 50000.00, "1020304050", 2),
('2024-04-02', '10:30:00', 'pendiente', 'Chequeo general', 120000.00, "5040302010", 3),
('2025-04-22', '11:30:00', 'pendiente', 'Chequeo dental', 100000.00, "1020304050", 2),
('2025-05-08', '11:26:00', 'confirmada', 'Tratamiento de Caries', 230.00, "1020304050", 9);

/* Insertar procedimientos_citas*/
INSERT INTO procedimientos_citas (procedimiento_id, cita_id) VALUES
(1, 1),
(2, 2);

/* Insertar historia clínica*/
INSERT INTO historias_clinicas (antecedentes_medicos, tratamiento_realizados, paciente_id) VALUES
('Hipertensión', 'Control de presión', "1020304050"),
('Alergia a penicilina', 'Evitar antibióticos con penicilina', "1020304050");

/* Insertar recetas médicas*/
INSERT INTO recetas_medicas (historia_clinica_id, tipo_orden, descripcion_receta, medicamento_recetado, fecha_receta) VALUES
(1, 'Medicamento', 'Tomar una pastilla diaria', 'Losartan 50mg', '2024-03-05'),
(2, 'Antibiótico', 'Tomar cada 8 horas', 'ketorolaco 500KG', '2024-03-06');

/* Insertar órdenes de compras*/
INSERT INTO ordenes_compras (fecha_expedicion, fecha_vencimiento, usuario_id,estado) VALUES
('2024-02-20', '2024-03-20', 1,'ordenado'),
('2024-02-25', '2024-03-25', 2,'en produccion'),
('2024-03-01', '2024-04-01', 3,'listo para entregar'),
('2024-03-05', '2024-04-05', 1,'entregado');

/* Insertar proveedores*/
INSERT INTO proveedores (nit,nombre_proveedor, telefono_proveedor, correo_proveedor) VALUES
('123','Medicorp', '111222333', 'ventas@medicorp.com'),
('432','DentalCare', '444555666', 'contacto@dentalcare.com'),
('665','KetoCorp', '896555666', 'contacto@ketocorp.com');

/* Insertar insumos*/
INSERT INTO insumos (nombre_insumo, cantidad_insumo, costo_insumo, fecha_vencimiento, umbral_alerta) VALUES
('Guantes quirúrgicos', 100, 2500.00, '2125-01-01', 20),
('Anestesia local', 50, 20.00, '2028-12-01', 10);

/* Insertar proveedores_insumos*/
INSERT INTO proveedores_insumos (proveedor_id, insumo_id) VALUES
('123', 1),
('432', 2),
('665', 2);

/* Insertar detalles de órdenes*/
INSERT INTO detalles_ordenes (cantidad_insumo, total, orden_id, insumo_id) VALUES
(50, 2500000.00, 1, 1),
(20, 4000000.00, 2, 2),
(40000, 5000000.00, 2, 2);

/*Insertar en ordenes_laboratorio*/

INSERT INTO ordenes_laboratorio
(cita_id, usuario_id, fecha_solicitud, fecha_limite, horario, tipo_material, otros_detalles, estado)
VALUES
(1, 4, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 7 DAY), 'Mañana', 'Zirconio', 'Solicitar coronas superiores', 'pendiente');

/*Insertar en productos_laboratorio*/

INSERT INTO productos_laboratorio
(orden_id, insumo_id, cantidad, detalles)
VALUES
(LAST_INSERT_ID(), 1, 5, 'Guantes quirúrgicos usados para prueba');

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
SELECT estado_cita, COUNT(*) AS cantidad
FROM citas
GROUP BY estado_cita;

/*ESTADO CITA DEL PACIENTES */
CREATE VIEW v_estado_citas_pacientes As
SELECT u.id_usuario,c.hora_cita,p.cedula,
CONCAT(p.nombres_paciente,' ',p.apellidos_paciente) AS nombre_completo_paciente,
 c.estado_cita,CONCAT(u.nombres_usuario,' ',u.apellidos_usuario) AS nombre_completo_odontologo
FROM pacientes p
JOIN citas c ON c.paciente_id = p.cedula
JOIN usuarios u ON u.id_usuario = c.usuario_id
WHERE u.rol_id = 2;

/*Consultas sobre Historia Clínica y Recetas Médicas*/
CREATE VIEW v_paciente_historia_receta AS
SELECT p.nombres_paciente, h.antecedentes_medicos, h.tratamiento_realizados
FROM pacientes p
JOIN historias_clinicas h ON p.cedula= h.paciente_id;

/*GESTION INSUMOS ODONTOLOGO**/
CREATE VIEW v_gestion_insumos AS
SELECT
    i.nombre_insumo,
    oc.estado
FROM detalles_ordenes AS deto
JOIN proveedores_insumos pi ON deto.insumo_id = pi.id_proveedor_insumo
JOIN insumos i ON pi.insumo_id = i.id_insumo
JOIN ordenes_compras oc ON deto.orden_id = oc.id_orden_compra;

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
CALL pa_ActualizarCita(1, '2026-04-20', '20:30:00', 'confirmada', 'Consulta de seguimiento', 1200000.00,1);
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
