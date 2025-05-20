-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-05-2025 a las 00:23:38
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `prototype1`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_ActualizarCita` (IN `p_id` INT, IN `p_fecha` DATE, IN `p_hora` TIME, IN `p_estado` ENUM('pendiente','confirmada','cancelada','completada'), IN `p_motivo` VARCHAR(255), IN `p_total` DECIMAL(10,2), IN `p_odontologo` INT)   BEGIN
  UPDATE citas
  SET fecha_cita = p_fecha,
      hora_cita   = p_hora,
      estado_cita = p_estado,
      motivo_cita = p_motivo,
      total_cita  = p_total,
      usuario_id  = p_odontologo
  WHERE id_cita = p_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_ActualizarEstadoCita` (IN `id_cita_t` INT, IN `nuevo_estado` ENUM('pendiente','confirmada','cancelada','completada'))   BEGIN
    UPDATE citas
    SET estado_cita = nuevo_estado
    WHERE id_cita = id_cita_t;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_ActualizarEstadoPedidos` (IN `id_orden_t` INT, IN `nuevo_estado` ENUM('ordenado','en produccion','listo para entregar','entregado'))   BEGIN
    UPDATE ordenes_compras
    SET estado = nuevo_estado
    WHERE id_orden_compra = id_orden_t;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_ActualizarEstadoUsuarios` (IN `id_usuario_t` INT, IN `nuevo_estado` ENUM('activo','inactivo'))   BEGIN
    UPDATE usuarios
    SET estado_usuario = nuevo_estado
    WHERE id_usuario = id_usuario_t;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_ActualizarHistoriaClinica` (IN `id_historia_t` INT, IN `nuevos_antecedentes` VARCHAR(255), IN `nuevos_tratamientos` VARCHAR(255))   BEGIN
    UPDATE historias_clinicas
    SET
        antecedentes_medicos = nuevos_antecedentes,
        tratamiento_realizados = nuevos_tratamientos
    WHERE id_historia_clinica = id_historia_t;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_ActualizarInsumo` (IN `p_id` INT, IN `p_nombre` VARCHAR(50), IN `p_cantidad` INT, IN `p_costo` DECIMAL(10,2), IN `p_fecha` DATE, IN `p_umbral` INT)   BEGIN
    UPDATE insumos
    SET nombre_insumo = p_nombre,
        cantidad_insumo = p_cantidad,
        costo_insumo = p_costo,
        fecha_vencimiento = p_fecha,
        umbral_alerta = p_umbral
    WHERE id_insumo = p_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_ActualizarOrdenCompra` (IN `p_id` INT, IN `p_fecha_expedicion` DATE, IN `p_fecha_vencimiento` DATE, IN `p_usuario_id` INT, IN `p_estado` ENUM('ordenado','en produccion','listo para entregar','entregado'))   BEGIN
    UPDATE ordenes_compras
    SET fecha_expedicion = p_fecha_expedicion,
        fecha_vencimiento = p_fecha_vencimiento,
        usuario_id = p_usuario_id,
        estado = p_estado
    WHERE id_orden_compra = p_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_ActualizarPaciente` (IN `id_paciente` INT, IN `nombre` VARCHAR(50), IN `apellido` VARCHAR(50), IN `edad_t` INT, IN `genero_t` ENUM('masculino','femenino'), IN `telefono` VARCHAR(50), IN `direccion` VARCHAR(50), IN `correo` VARCHAR(50), IN `tipo_sangre_t` ENUM('A+','A-','B+','B-','AB+','AB-','O+','O-'))   BEGIN
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
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_ActualizarProcedimiento` (IN `id_procedimiento_t` INT, IN `tipo_procedimiento_t` VARCHAR(30), IN `costo_t` DECIMAL(10,2))   BEGIN
    UPDATE procedimientos
    SET tipo_procedimiento = tipo_procedimiento_t,
        costo = costo_t
    WHERE id_procedimiento = id_procedimiento_t;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_ActualizarProveedor` (IN `id_proveedor_t` VARCHAR(20), IN `nombre` VARCHAR(50), IN `telefono` VARCHAR(50), IN `correo` VARCHAR(50))   BEGIN
    UPDATE proveedores
    SET
        nombre_proveedor = nombre,
        telefono_proveedor = telefono,
        correo_proveedor = correo
    WHERE nit = id_proveedor_t;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_ActualizarRecetaMedica` (IN `id_receta_t` INT, IN `historia_clinica_id_t` INT, IN `tipo_orden_t` VARCHAR(50), IN `descripcion_receta_t` VARCHAR(255), IN `medicamento_recetado_t` VARCHAR(255), IN `fecha_receta_t` DATE)   BEGIN
    UPDATE recetas_medicas
    SET
        historia_clinica_id = historia_clinica_id_t,
        tipo_orden = tipo_orden_t,
        descripcion_receta = descripcion_receta_t,
        medicamento_recetado = medicamento_recetado_t,
        fecha_receta = fecha_receta_t
    WHERE id_receta = id_receta_t;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_ActualizarUsuario` (IN `id_usuario_t` INT, IN `nombres` VARCHAR(50), IN `apellidos` VARCHAR(50), IN `correo` VARCHAR(50), IN `telefono` VARCHAR(50), IN `direccion` VARCHAR(100), IN `estado` ENUM('activo','inactivo'), IN `especialidad` VARCHAR(50), IN `rol` INT)   BEGIN
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
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_EliminarCita` (IN `p_id` INT)   BEGIN
  DELETE FROM citas WHERE id_cita = p_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_EliminarHistoriaClinica` (IN `id_historia_t` INT)   BEGIN
    DELETE FROM historias_clinicas
    WHERE id_historia_clinica = id_historia_t;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_EliminarInsumo` (IN `p_id` INT)   BEGIN
    DELETE FROM insumos WHERE id_insumo = p_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_EliminarOrdenCompra` (IN `p_id` INT)   BEGIN
    DELETE FROM ordenes_compras WHERE id_orden_compra = p_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_EliminarPaciente` (IN `cedula_t` VARCHAR(20))   BEGIN
    DELETE FROM pacientes
    WHERE cedula = cedula_t;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_EliminarProcedimiento` (IN `id_procedimiento_t` INT)   BEGIN
    DELETE FROM procedimientos
    WHERE id_procedimiento = id_procedimiento_t;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_EliminarProveedor` (IN `_nit` VARCHAR(20))   BEGIN
    DELETE FROM proveedores WHERE nit = _nit;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_EliminarRecetaMedica` (IN `id_receta_t` INT)   BEGIN
    DELETE FROM recetas_medicas
    WHERE id_receta = id_receta_t;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_EliminarUsuario` (IN `id_usuario_t` INT)   BEGIN
    DELETE FROM usuarios
    WHERE id_usuario = id_usuario_t;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_InsertarCita` (IN `p_fecha` DATE, IN `p_hora` TIME, IN `p_estado` ENUM('pendiente','confirmada','cancelada','completada'), IN `p_motivo` VARCHAR(255), IN `p_total` DECIMAL(10,2), IN `p_paciente` VARCHAR(20), IN `p_odontologo` INT)   BEGIN
  INSERT INTO citas
    (fecha_cita,hora_cita,estado_cita,motivo_cita,total_cita,paciente_id,usuario_id)
  VALUES
    (p_fecha,p_hora,p_estado,p_motivo,p_total,p_paciente,p_odontologo);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_InsertarInsumo` (IN `p_nombre` VARCHAR(50), IN `p_cantidad` INT, IN `p_costo` DECIMAL(10,2), IN `p_fecha` DATE, IN `p_umbral` INT)   BEGIN
    INSERT INTO insumos(nombre_insumo, cantidad_insumo, costo_insumo, fecha_vencimiento, umbral_alerta)
    VALUES (p_nombre, p_cantidad, p_costo, p_fecha, p_umbral);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_InsertarOrdenCompra` (IN `p_fecha_expedicion` DATE, IN `p_fecha_vencimiento` DATE, IN `p_usuario_id` INT, IN `p_estado` ENUM('ordenado','en produccion','listo para entregar','entregado'))   BEGIN
    INSERT INTO ordenes_compras(fecha_expedicion, fecha_vencimiento, usuario_id, estado)
    VALUES (p_fecha_expedicion, p_fecha_vencimiento, p_usuario_id, p_estado);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_InsertarPaciente` (IN `cedula` VARCHAR(20), IN `nombres` VARCHAR(50), IN `apellidos` VARCHAR(50), IN `edad` INT, IN `genero` ENUM('masculino','femenino'), IN `telefono` VARCHAR(50), IN `direccion` VARCHAR(50), IN `correo` VARCHAR(50), IN `tipo_sangre` ENUM('A+','A-','B+','B-','AB+','AB-','O+','O-'))   BEGIN
    INSERT INTO pacientes (cedula, nombres_paciente, apellidos_paciente, edad, genero, telefono_paciente, direccion_paciente, correo_paciente, tipo_sangre)
    VALUES (cedula,nombres ,apellidos, edad, genero, telefono, direccion, correo, tipo_sangre);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_InsertarProcedimiento` (IN `tipo_procedimiento_t` VARCHAR(30), IN `costo_t` DECIMAL(10,2))   BEGIN
    INSERT INTO procedimientos (tipo_procedimiento, costo)
    VALUES (tipo_procedimiento_t, costo_t);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_InsertarProveedor` (IN `nit_t` VARCHAR(20), IN `nombre` VARCHAR(50), IN `telefono` VARCHAR(50), IN `correo` VARCHAR(50))   BEGIN
    INSERT INTO proveedores (nit,nombre_proveedor, telefono_proveedor, correo_proveedor)
    VALUES (nit_t,nombre, telefono, correo);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_InsertarRecetaMedica` (IN `historia_clinica_id_t` INT, IN `tipo_orden_t` VARCHAR(50), IN `descripcion_receta_t` VARCHAR(255), IN `medicamento_recetado_t` VARCHAR(255), IN `fecha_receta_t` DATE)   BEGIN
    INSERT INTO recetas_medicas (historia_clinica_id, tipo_orden, descripcion_receta, medicamento_recetado, fecha_receta)
    VALUES (historia_clinica_id_t, tipo_orden_t, descripcion_receta_t, medicamento_recetado_t, fecha_receta_t);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_InsertarUsuario` (IN `nombres_usuario` VARCHAR(50), IN `apellidos_usuario` VARCHAR(50), IN `correo` VARCHAR(50), IN `contrasena` VARCHAR(50), IN `telefono` VARCHAR(50), IN `direccion` VARCHAR(100), IN `estado` ENUM('activo','inactivo'), IN `especialidad` VARCHAR(50), IN `rol` INT)   BEGIN
    INSERT INTO usuarios (nombres_usuario, apellidos_usuario, correo_usuario, contrasena_usuario, telefono_usuario, direccion_usuario, estado_usuario, especialidad_usuario, rol_id)
    VALUES (nombres_usuario, apellidos_usuario, correo, contrasena, telefono, direccion, estado, especialidad, rol);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_ObtenerCita` (IN `p_id` INT)   BEGIN
  SELECT
    c.id_cita, c.fecha_cita, c.hora_cita, c.estado_cita,
    c.motivo_cita, c.total_cita, c.paciente_id,
    CONCAT(p.nombres_paciente,' ',p.apellidos_paciente) AS nombre_paciente,
    c.usuario_id AS id_odontologo,
    CONCAT(u.nombres_usuario,' ',u.apellidos_usuario) AS nombre_odontologo
  FROM citas c
  JOIN pacientes p ON c.paciente_id = p.cedula
  JOIN usuarios u ON c.usuario_id = u.id_usuario
  WHERE c.id_cita = p_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_ObtenerCitas` ()   BEGIN
  SELECT
    c.id_cita,
    c.fecha_cita,
    c.hora_cita,
    c.estado_cita,
    c.motivo_cita,
    c.total_cita,
    c.paciente_id,
    CONCAT(p.nombres_paciente,' ',p.apellidos_paciente) AS nombre_paciente,
    u.id_usuario,
    CONCAT(u.nombres_usuario,' ',u.apellidos_usuario) AS nombre_odontologo
  FROM citas c
  JOIN pacientes p ON c.paciente_id = p.cedula
  JOIN usuarios u  ON c.usuario_id  = u.id_usuario
  ORDER BY c.fecha_cita DESC, c.hora_cita DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_ObtenerCitasHoy` (IN `p_fecha` DATE)   BEGIN
  SELECT
    c.id_cita, c.fecha_cita, c.hora_cita, c.estado_cita,
    c.motivo_cita, c.total_cita, c.paciente_id,
    CONCAT(p.nombres_paciente,' ',p.apellidos_paciente) AS nombre_paciente,
    c.usuario_id AS id_odontologo,
    CONCAT(u.nombres_usuario,' ',u.apellidos_usuario) AS nombre_odontologo
  FROM citas c
  JOIN pacientes p ON c.paciente_id = p.cedula
  JOIN usuarios u ON c.usuario_id = u.id_usuario
  WHERE c.fecha_cita = p_fecha;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_ObtenerHistoriaClinica` ()   BEGIN
    SELECT hc.*, p.nombre, p.apellido
    FROM historias_clinicas hc
    INNER JOIN pacientes p ON hc.paciente_id = p.cedula;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_ObtenerInsumos` ()   BEGIN
    SELECT * FROM insumos;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_ObtenerOrdenesCompras` ()   BEGIN
    SELECT * FROM ordenes_compras;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_ObtenerPacientes` ()   BEGIN
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
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_ObtenerProcedimientos` ()   BEGIN
    SELECT * FROM procedimientos;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_ObtenerProveedores` ()   BEGIN
    SELECT nit, nombre_proveedor, telefono_proveedor, correo_proveedor
    FROM proveedores;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_ObtenerRecetasMedicas` ()   BEGIN
    SELECT * FROM recetas_medicas;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_ObtenerRoles` ()   BEGIN
    SELECT * FROM roles;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_ObtenerUsuarios` ()   BEGIN
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
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_PeticionInsumos` (IN `id_insumo_t` INT, IN `cantidad` INT, IN `id_orden` INT)   BEGIN
    /* Declarar la variable correctamente*/
    DECLARE total_t DECIMAL(10, 2);

    /* Calcular el total*/
    SET total_t = (SELECT costo_insumo FROM insumos WHERE id_insumo = id_insumo_t) * cantidad;

    /* Insertar en la tabla detalles_ordenes*/
    INSERT INTO detalles_ordenes (cantidad_insumo, total, orden_id,insumo_id)
    VALUES (cantidad, total_t, id_orden, (SELECT id_proveedor_insumo FROM proveedores_insumos WHERE insumo_id = id_insumo_t LIMIT 1));

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_RecalcularTotalCita` (IN `p_cita_id` INT)   BEGIN
  UPDATE citas
    SET total_cita = COALESCE((
      SELECT SUM(proc.costo)
        FROM procedimientos_citas pc
        JOIN procedimientos proc
          ON pc.procedimiento_id = proc.id_procedimiento
       WHERE pc.cita_id = p_cita_id
    ), 0)
  WHERE id_cita = p_cita_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_RechazarPedido` (IN `id_orden_t` INT)   BEGIN

    DELETE FROM detalles_ordenes WHERE orden_id = id_orden_t;

    DELETE FROM ordenes_compras WHERE id_orden_compra = id_orden_t;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pa_RegistrarHistoriaClinica` (IN `paciente_id_t` VARCHAR(20), IN `antecedentes` VARCHAR(255), IN `tratamientos` VARCHAR(255))   BEGIN
    INSERT INTO historias_clinicas (paciente_id, antecedentes_medicos, tratamiento_realizados)
    VALUES (paciente_id_t, antecedentes, tratamientos);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id_cita` int(11) NOT NULL,
  `fecha_cita` date NOT NULL,
  `hora_cita` time NOT NULL,
  `estado_cita` enum('pendiente','confirmada','cancelada','completada') NOT NULL,
  `motivo_cita` varchar(255) NOT NULL,
  `total_cita` decimal(10,2) NOT NULL,
  `paciente_id` varchar(20) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id_cita`, `fecha_cita`, `hora_cita`, `estado_cita`, `motivo_cita`, `total_cita`, `paciente_id`, `usuario_id`) VALUES
(1, '2025-05-13', '10:00:00', 'confirmada', 'Chequeo detallado y profundo', 0.00, '1020304050', 2),
(2, '2024-04-02', '10:30:00', 'pendiente', 'Chequeo general', 120000.00, '5040302010', 3),
(3, '2025-04-22', '11:30:00', 'pendiente', 'Chequeo dental', 100000.00, '1020304050', 2),
(4, '2025-05-12', '11:26:00', 'confirmada', 'Tratamiento de Caries', 0.00, '1020304050', 9),
(9, '2025-06-01', '10:00:00', 'pendiente', 'Test', 0.00, '1020304050', 2),
(10, '2025-05-20', '09:30:00', 'pendiente', 'Revisión inicial', 0.00, '1020304050', 2),
(11, '2025-05-14', '14:00:00', 'pendiente', 'Limpieza', 0.00, '1020304050', 2),
(12, '2025-05-18', '17:10:00', 'confirmada', 'Revision de cordales', 0.00, '1020304050', 6),
(13, '2025-05-18', '22:50:00', 'completada', 'Revision de calidad de protesis', 0.00, '1020304050', 6),
(14, '2025-05-19', '13:11:00', 'pendiente', 'Extraccion de Cordal', 400000.00, '1020304050', 5),
(15, '2025-05-19', '10:30:00', 'completada', 'Chequeo Odontologico Urgente', 0.00, '1020304050', 2),
(16, '2025-05-19', '18:50:00', 'completada', 'Chequeo de molares urgente', 0.00, '1020304050', 2),
(17, '2025-05-19', '16:54:00', 'cancelada', 'Chequeo de incisivos', 0.00, '1020304050', 5),
(18, '2025-05-19', '18:39:00', 'completada', 'Problemas de mordedura', 300000.00, '1020304050', 3);

--
-- Disparadores `citas`
--
DELIMITER $$
CREATE TRIGGER `tg_ad_citas_cleanup` AFTER DELETE ON `citas` FOR EACH ROW BEGIN
  DELETE FROM ordenes_laboratorio
   WHERE cita_id = OLD.id_cita;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tg_ai_citas_create_ordenlab` AFTER INSERT ON `citas` FOR EACH ROW BEGIN
  INSERT INTO ordenes_laboratorio (cita_id, usuario_id, fecha_solicitud, fecha_limite, estado)
    VALUES (
      NEW.id_cita,
      NEW.usuario_id,
      CURDATE(),
      DATE_ADD(CURDATE(), INTERVAL 7 DAY),
      'NUEVO'
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tg_bd_citas_softdel` BEFORE DELETE ON `citas` FOR EACH ROW BEGIN
  IF OLD.estado_cita <> 'pendiente'
     OR OLD.fecha_cita <= CURDATE() THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Solo se pueden borrar citas pendientes y futuras';
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tg_bi_citas_slotvalid` BEFORE INSERT ON `citas` FOR EACH ROW BEGIN
  IF EXISTS(
    SELECT 1
      FROM citas
     WHERE fecha_cita = NEW.fecha_cita
       AND hora_cita  = NEW.hora_cita
       AND (paciente_id = NEW.paciente_id OR usuario_id = NEW.usuario_id)
  ) THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Ya hay cita a esa hora para paciente u odontólogo';
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tg_bu_citas_totalcalc` BEFORE UPDATE ON `citas` FOR EACH ROW BEGIN
  SET NEW.total_cita = (
    SELECT COALESCE(SUM(proc.costo),0)
      FROM procedimientos_citas pc
      JOIN procedimientos proc
        ON pc.procedimiento_id = proc.id_procedimiento
     WHERE pc.cita_id = OLD.id_cita
  );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_ordenes`
--

CREATE TABLE `detalles_ordenes` (
  `id_detalle_orden` int(11) NOT NULL,
  `cantidad_insumo` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `orden_id` int(11) NOT NULL,
  `insumo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_ordenes`
--

INSERT INTO `detalles_ordenes` (`id_detalle_orden`, `cantidad_insumo`, `total`, `orden_id`, `insumo_id`) VALUES
(2, 20, 4000000.00, 2, 2),
(3, 40000, 5000000.00, 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historias_clinicas`
--

CREATE TABLE `historias_clinicas` (
  `id_historia_clinica` int(11) NOT NULL,
  `antecedentes_medicos` varchar(50) NOT NULL,
  `tratamiento_realizados` varchar(50) NOT NULL,
  `paciente_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historias_clinicas`
--

INSERT INTO `historias_clinicas` (`id_historia_clinica`, `antecedentes_medicos`, `tratamiento_realizados`, `paciente_id`) VALUES
(1, 'Hipertensión', 'Control de presión', '1020304050'),
(2, 'Alergia a penicilina', 'Evitar antibióticos con penicilina', '1020304050'),
(3, 'Hipertensión y diabetes', 'Tratamiento con insulina y dieta controlada', '1020304050'),
(4, 'SIN ANTECEDENTES', 'SIN TRATAMIENTOS', '9999999999'),
(5, 'SIN ANTECEDENTES', 'SIN TRATAMIENTOS', '2232425262'),
(6, 'SIN ANTECEDENTES', 'SIN TRATAMIENTOS', '2233425262'),
(7, 'SIN ANTECEDENTES', 'SIN TRATAMIENTOS', '9878796566'),
(8, 'SIN ANTECEDENTES', 'SIN TRATAMIENTOS', '1070176285'),
(9, 'SIN ANTECEDENTES', 'SIN TRATAMIENTOS', '1160676285'),
(11, 'CONSERVADA', 'Tratamiento especial', '1020304050');

--
-- Disparadores `historias_clinicas`
--
DELIMITER $$
CREATE TRIGGER `tg_bd_historia_protect` BEFORE DELETE ON `historias_clinicas` FOR EACH ROW BEGIN
  IF EXISTS(SELECT 1 FROM recetas_medicas WHERE historia_clinica_id = OLD.id_historia_clinica) THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'No puedes borrar historia con recetas asociadas';
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumos`
--

CREATE TABLE `insumos` (
  `id_insumo` int(11) NOT NULL,
  `nombre_insumo` varchar(50) NOT NULL,
  `cantidad_insumo` int(11) NOT NULL,
  `costo_insumo` decimal(10,2) NOT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `umbral_alerta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `insumos`
--

INSERT INTO `insumos` (`id_insumo`, `nombre_insumo`, `cantidad_insumo`, `costo_insumo`, `fecha_vencimiento`, `umbral_alerta`) VALUES
(1, 'Guantes quirúrgicos', 100, 2500.00, '2125-01-01', 20),
(2, 'Anestesia local', 50, 20.00, '2028-12-01', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2025_05_11_231736_add_citas_triggers', 2),
(8, '2025_05_18_103517_update_ordenes_laboratorio_table_add_color_and_firma_drop_timestamps', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes_compras`
--

CREATE TABLE `ordenes_compras` (
  `id_orden_compra` int(11) NOT NULL,
  `fecha_expedicion` date NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `estado` enum('ordenado','en produccion','listo para entregar','entregado') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ordenes_compras`
--

INSERT INTO `ordenes_compras` (`id_orden_compra`, `fecha_expedicion`, `fecha_vencimiento`, `usuario_id`, `estado`) VALUES
(2, '2024-02-25', '2024-03-25', 2, 'en produccion'),
(3, '2024-03-01', '2024-04-01', 3, 'listo para entregar'),
(4, '2024-03-05', '2024-04-05', 1, 'entregado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes_laboratorio`
--

CREATE TABLE `ordenes_laboratorio` (
  `id_orden_lab` int(11) NOT NULL,
  `cita_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha_solicitud` date NOT NULL,
  `fecha_limite` date NOT NULL,
  `horario` enum('Mañana','Tarde') NOT NULL,
  `tipo_material` varchar(50) NOT NULL,
  `otros_detalles` text DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `firma` varchar(150) DEFAULT NULL,
  `estado` enum('pendiente','en producción','listo para enviar','entregada','rechazada') NOT NULL DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ordenes_laboratorio`
--

INSERT INTO `ordenes_laboratorio` (`id_orden_lab`, `cita_id`, `usuario_id`, `fecha_solicitud`, `fecha_limite`, `horario`, `tipo_material`, `otros_detalles`, `color`, `firma`, `estado`) VALUES
(1, 1, 8, '2025-05-08', '2025-05-15', 'Mañana', 'Zirconio', 'Coronas superiores', NULL, NULL, 'pendiente'),
(2, 2, 8, '2025-05-08', '2025-05-10', 'Tarde', 'Resina', 'Incrustación', NULL, NULL, 'en producción'),
(3, 3, 8, '2025-04-30', '2025-05-10', 'Mañana', 'Metal', 'Puente', NULL, NULL, 'listo para enviar'),
(4, 4, 8, '2025-05-03', '2025-05-14', 'Tarde', 'Cerámica', 'Corona', NULL, NULL, 'entregada'),
(6, 9, 2, '2025-05-12', '2025-05-19', 'Mañana', '', NULL, NULL, NULL, ''),
(7, 10, 2, '2025-05-12', '2025-05-19', 'Mañana', '', NULL, NULL, NULL, ''),
(8, 11, 2, '2025-05-13', '2025-05-20', 'Mañana', '', NULL, NULL, NULL, ''),
(10, 12, 6, '2025-05-17', '2025-05-24', 'Mañana', '', NULL, NULL, NULL, ''),
(11, 13, 6, '2025-05-17', '2025-05-24', 'Mañana', '', NULL, NULL, NULL, ''),
(12, 14, 5, '2025-05-19', '2025-05-26', 'Mañana', '', NULL, NULL, NULL, ''),
(13, 15, 2, '2025-05-19', '2025-05-26', 'Mañana', '', NULL, NULL, NULL, ''),
(14, 16, 2, '2025-05-19', '2025-05-26', 'Mañana', '', NULL, NULL, NULL, ''),
(15, 17, 5, '2025-05-19', '2025-05-26', 'Mañana', '', NULL, NULL, NULL, ''),
(16, 13, 8, '2025-05-19', '2025-05-19', 'Tarde', 'Metal Porcelana, Zirconio', 'El paciente requiere de retenedores nuevos en la molar 4 de la capa inferior derecha de la encia, debido a presencia de daños severos en la protesis. Se necesita de materiales más resistentes para que pueda aguantar varias fuerzas aplicadas dentro de esta protesis y que no se pueda romper', 'Purpura', 'firmas/9SqAK2siDjKz1voPmkqpUWpPDNChhFtlRo6ClNu4.jpg', 'pendiente'),
(17, 13, 8, '2025-05-19', '2025-05-19', 'Mañana', 'Flexible', 'El paciente necesita de alambre nuevo para sus retenedores', 'Negro', 'firmas/OpAxY94Y6oTpTYiic9xnH80Ra679n69xAkDfnedo.jpg', 'rechazada'),
(18, 18, 3, '2025-05-19', '2025-05-26', 'Mañana', '', NULL, NULL, NULL, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `cedula` varchar(20) NOT NULL,
  `nombres_paciente` varchar(50) NOT NULL,
  `apellidos_paciente` varchar(50) NOT NULL,
  `edad` int(11) NOT NULL,
  `genero` enum('masculino','femenino') NOT NULL,
  `telefono_paciente` varchar(50) NOT NULL,
  `direccion_paciente` varchar(50) NOT NULL,
  `correo_paciente` varchar(50) DEFAULT NULL,
  `tipo_sangre` enum('A+','A-','B+','B-','AB+','AB-','O+','O-') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`cedula`, `nombres_paciente`, `apellidos_paciente`, `edad`, `genero`, `telefono_paciente`, `direccion_paciente`, `correo_paciente`, `tipo_sangre`) VALUES
('101010011', 'Luis Esteban ', 'Gomez Gonzales', 34, 'masculino', '123456789', 'Calle 123', 'luis.gomez@example.com', 'O+'),
('1020304050', 'Carlos', 'Martínez', 40, 'masculino', '321654987', 'Av. Siempre Viva 742', 'carlos.martinez@gmail.com', 'A+'),
('1070176285', 'ROSA FERNANDA', 'GUERRERO MACIAS', 40, 'femenino', '3134561507', 'Calle 55 N, #10-46 casa 18', 'rosa@example.com', 'A+'),
('1160676285', 'AGUSTO ALBERTO', 'QUINCHOA PINILLA', 20, 'masculino', '3143561589', 'Calle 7 N, #10-46 casa 18', 'AA@example.com', 'A+'),
('2232425262', 'ALAN FERNANDO', 'MARTINEZ SALAZAR', 23, 'masculino', '3143561503', 'Calle 57 N, #10-46 casa 16', '334@gmail.com', 'O+'),
('2233425262', 'VICTOR', 'SMITH', 47, 'masculino', '3143561512', 'Calle 57 N, #10-46 casa 15', 'victor@example.com', 'AB+'),
('5040302010', 'Ana', 'Martinez', 45, 'femenino', '321321321', 'Avenida XYZ', 'ana.martinez@gmail.com', 'A-'),
('9878796566', 'CARLA FERNANDA', 'GARCIA SALAZAR', 31, 'femenino', '3143561706', 'Calle 57 N, #10-44 casa 14', 'Carla@example.com', 'O+'),
('9999999999', 'ANAMIN', 'APELL', 30, 'femenino', '111', 'dir', 'x@y.com', 'A+');

--
-- Disparadores `pacientes`
--
DELIMITER $$
CREATE TRIGGER `tg_ai_pacientes_hist` AFTER INSERT ON `pacientes` FOR EACH ROW BEGIN
  INSERT INTO historias_clinicas (paciente_id, antecedentes_medicos, tratamiento_realizados)
    VALUES (NEW.cedula, 'SIN ANTECEDENTES', 'SIN TRATAMIENTOS');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tg_bi_pacientes_validate` BEFORE INSERT ON `pacientes` FOR EACH ROW BEGIN
  IF NEW.edad < 0 OR NEW.edad > 120 THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Edad inválida';
  END IF;
  SET NEW.nombres_paciente  = UPPER(NEW.nombres_paciente);
  SET NEW.apellidos_paciente = UPPER(NEW.apellidos_paciente);
  IF NOT NEW.cedula REGEXP '^[0-9]{10}$' THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cédula debe tener 10 dígitos';
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procedimientos`
--

CREATE TABLE `procedimientos` (
  `id_procedimiento` int(11) NOT NULL,
  `tipo_procedimiento` varchar(30) NOT NULL,
  `costo` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `procedimientos`
--

INSERT INTO `procedimientos` (`id_procedimiento`, `tipo_procedimiento`, `costo`) VALUES
(2, 'Radiografía', 120000.00),
(3, 'Extracción Dental', 300000.00),
(5, 'Toma de impresiones', 1000.00);

--
-- Disparadores `procedimientos`
--
DELIMITER $$
CREATE TRIGGER `tg_ai_proc_costvalidate` BEFORE INSERT ON `procedimientos` FOR EACH ROW BEGIN
  IF NEW.costo <= 0 THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Costo debe ser mayor a cero';
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tg_bd_proc_protect` BEFORE DELETE ON `procedimientos` FOR EACH ROW BEGIN
  IF EXISTS(SELECT 1 FROM procedimientos_citas WHERE procedimiento_id = OLD.id_procedimiento) THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'No puedes borrar un procedimiento usado';
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `procedimientos_citas`
--

CREATE TABLE `procedimientos_citas` (
  `id_procedimiento_cita` int(11) NOT NULL,
  `procedimiento_id` int(11) NOT NULL,
  `cita_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `procedimientos_citas`
--

INSERT INTO `procedimientos_citas` (`id_procedimiento_cita`, `procedimiento_id`, `cita_id`) VALUES
(2, 2, 2);

--
-- Disparadores `procedimientos_citas`
--
DELIMITER $$
CREATE TRIGGER `tg_ad_proc_cita_remove` AFTER DELETE ON `procedimientos_citas` FOR EACH ROW BEGIN
  CALL pa_RecalcularTotalCita(OLD.cita_id);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tg_ai_proc_cita_total` AFTER INSERT ON `procedimientos_citas` FOR EACH ROW BEGIN
  CALL pa_RecalcularTotalCita(NEW.cita_id);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tg_au_proc_cita_update` AFTER UPDATE ON `procedimientos_citas` FOR EACH ROW BEGIN
  CALL pa_RecalcularTotalCita(NEW.cita_id);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_laboratorio`
--

CREATE TABLE `productos_laboratorio` (
  `id_producto_lab` int(11) NOT NULL,
  `orden_id` int(11) NOT NULL,
  `insumo_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `detalles` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos_laboratorio`
--

INSERT INTO `productos_laboratorio` (`id_producto_lab`, `orden_id`, `insumo_id`, `cantidad`, `detalles`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 5, 'Guantes quirúrgicos usados para prueba', '2025-05-08 09:04:27', '2025-05-08 09:04:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `nit` varchar(20) NOT NULL,
  `nombre_proveedor` varchar(50) NOT NULL,
  `telefono_proveedor` varchar(50) NOT NULL,
  `correo_proveedor` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`nit`, `nombre_proveedor`, `telefono_proveedor`, `correo_proveedor`) VALUES
('123', 'Suministros Médicos S.A.', '987654321', 'contacto@sumedicos.com'),
('432', 'DentalCare', '444555666', 'contacto@dentalcare.com'),
('665', 'KetoCorp', '896555666', 'contacto@ketocorp.com'),
('69543', 'CocaCorp S.A', '6537843', 'general@cocacorp.com'),
('777', 'KZCORP', '3143561509', 'basstrex96@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores_insumos`
--

CREATE TABLE `proveedores_insumos` (
  `id_proveedor_insumo` int(11) NOT NULL,
  `proveedor_id` varchar(20) NOT NULL,
  `insumo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores_insumos`
--

INSERT INTO `proveedores_insumos` (`id_proveedor_insumo`, `proveedor_id`, `insumo_id`) VALUES
(1, '123', 1),
(2, '432', 2),
(3, '665', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recetas_medicas`
--

CREATE TABLE `recetas_medicas` (
  `id_receta` int(11) NOT NULL,
  `historia_clinica_id` int(11) NOT NULL,
  `tipo_orden` varchar(50) NOT NULL,
  `descripcion_receta` varchar(255) NOT NULL,
  `medicamento_recetado` varchar(255) NOT NULL,
  `fecha_receta` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recetas_medicas`
--

INSERT INTO `recetas_medicas` (`id_receta`, `historia_clinica_id`, `tipo_orden`, `descripcion_receta`, `medicamento_recetado`, `fecha_receta`) VALUES
(1, 1, 'Medicamento', 'Tomar una pastilla diaria', 'Losartan 50mg', '2024-03-05'),
(2, 2, 'Antibiótico', 'Tomar cada 8 horas', 'ketorolaco 500KG', '2024-03-06'),
(3, 1, 'Medicamento', 'Tomar dos pastillas diarias', 'Ketorolaco  400mg', '2025-03-08');

--
-- Disparadores `recetas_medicas`
--
DELIMITER $$
CREATE TRIGGER `tg_bd_receta_protect` BEFORE DELETE ON `recetas_medicas` FOR EACH ROW BEGIN
  SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'No puedes borrar una receta médica';
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tg_bi_receta_datechk` BEFORE INSERT ON `recetas_medicas` FOR EACH ROW BEGIN
  IF NEW.fecha_receta > CURDATE() THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Fecha de receta no puede ser futura';
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(50) NOT NULL,
  `descripcion_rol` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre_rol`, `descripcion_rol`) VALUES
(1, 'Administrador', 'Gestiona el sistema'),
(2, 'Odontologo', 'Atiende a los pacientes'),
(3, 'Asistente', 'Agenda citas y maneja pacientes'),
(4, 'Laboratorista', 'Gestiona órdenes de laboratorio'),
(5, 'Dueño', 'Supervisor general del sistema');

--
-- Disparadores `roles`
--
DELIMITER $$
CREATE TRIGGER `tg_bd_roles_protect` BEFORE DELETE ON `roles` FOR EACH ROW BEGIN
  IF EXISTS(
    SELECT 1
      FROM usuarios
     WHERE rol_id = OLD.id_rol
  ) THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'No puedes borrar un rol que aún tiene usuarios';
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombres_usuario` varchar(50) NOT NULL,
  `apellidos_usuario` varchar(50) NOT NULL,
  `correo_usuario` varchar(50) NOT NULL,
  `contrasena_usuario` varchar(255) NOT NULL,
  `telefono_usuario` varchar(50) NOT NULL,
  `direccion_usuario` varchar(100) NOT NULL,
  `estado_usuario` enum('activo','inactivo') NOT NULL,
  `especialidad_usuario` varchar(50) DEFAULT NULL,
  `rol_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombres_usuario`, `apellidos_usuario`, `correo_usuario`, `contrasena_usuario`, `telefono_usuario`, `direccion_usuario`, `estado_usuario`, `especialidad_usuario`, `rol_id`) VALUES
(1, 'Marco Alejandro', 'Torres Gomez', 'marcotorres@gmail.com', 'contra123456789', '3112345678', 'Calle 123 # 45-67', 'activo', NULL, 1),
(2, 'Juan', 'Pérez', 'juan.perez@gmail.com', 'hashedpassword1', '123456789', 'Calle 12C #3-10 Centro', 'activo', 'Odontopediatría', 2),
(3, 'Maria', 'Gonzalez', 'maria.gonzalez@gmail.com', 'hashedpassword2', '987654321', 'Avenida Azulejo 456', 'activo', 'Cirugía Oral y Maxilofacial', 2),
(4, 'Carlos', 'Ramirez', 'carlos.ramirez@gmail.com', 'hashedpassword3', '456123789', 'Boulevard Rose 789', 'activo', NULL, 3),
(5, 'Felipe Manuel', 'Caicedo Ximenex', 'felipe.ximenex@gmail.com', 'contraseñageneric3', '123456789', 'Bolivar Calle 123 # 45-67', 'inactivo', 'Odontología General', 2),
(6, 'Manuel José', 'Moreno Campo', 'jose.moreno@gmail.com', '$2y$12$PVFYuJjgM7hBsrjrv17UHOaFiz2qTWvsvrL6Sq1wolmEZaVODqA3a', '67234917', 'El Imperio de la Alta Sociedad Torre 12 Piso 3', 'activo', NULL, 2),
(7, 'Janer Esteban', 'Pechene Cifuentes', 'janner.pechene@gmail.com', '$2y$12$PVFYuJjgM7hBsrjrv17UHOaFiz2qTWvsvrL6Sq1wolmEZaVODqA3a', '67234917', 'El Imperio de la Alta Sociedad Torre 12 Piso 3', 'activo', NULL, 3),
(8, 'Juan Armando', 'Gomez Galindez', 'juan.laboratorista@example.com', '$2y$12$PVFYuJjgM7hBsrjrv17UHOaFiz2qTWvsvrL6Sq1wolmEZaVODqA3a', '3001234567', 'Calle Falsa 123', 'activo', NULL, 4),
(9, 'Ana', 'Lopez', 'ana.lopez@gmail.com', '12345', '987654321', 'Av. Central 456', 'activo', 'Odontología Forense', 2),
(10, 'Xerneas Zygarde', 'Yveltal', 'test1@example.com', '12345678', '123456783', 'calle falsa 4', 'activo', NULL, 4),
(11, 'Tmp', 'Usr', 'tmp@ejemplo.com', 'pw', '111', 'dir', 'activo', NULL, 3),
(13, 'Hector Alejandro', 'Garces', 'hector.garces@gmail.com', '$2y$12$PVFYuJjgM7hBsrjrv17UHOaFiz2qTWvsvrL6Sq1wolmEZaVODqA3a', '3133737701', 'El Imperio de la Alta Sociedad Torre 12 Piso 3', 'activo', NULL, 1);

--
-- Disparadores `usuarios`
--
DELIMITER $$
CREATE TRIGGER `tg_bi_users_emailuniq` BEFORE INSERT ON `usuarios` FOR EACH ROW BEGIN
  IF EXISTS(SELECT 1 FROM usuarios WHERE correo_usuario = NEW.correo_usuario) THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El correo ya está en uso';
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tg_bu_users_softdel` BEFORE DELETE ON `usuarios` FOR EACH ROW BEGIN
  IF OLD.rol_id = 1
     AND (SELECT COUNT(*) FROM usuarios WHERE rol_id = 1) <= 1 THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Debe quedar al menos un administrador';
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_cantidad_estado_citas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_cantidad_estado_citas` (
`estado_cita` enum('pendiente','confirmada','cancelada','completada')
,`cantidad` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_cantidad_usuarios_por_rol`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_cantidad_usuarios_por_rol` (
`nombre_rol` varchar(50)
,`cantidad_usuarios` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_citas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_citas` (
`id_cita` int(11)
,`fecha_cita` date
,`hora_cita` time
,`estado_cita` enum('pendiente','confirmada','cancelada','completada')
,`motivo_cita` varchar(255)
,`nombres_paciente` varchar(50)
,`apellidos_paciente` varchar(50)
,`odontologo_nombre` varchar(50)
,`odontologo_apellido` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_citas_avanzadas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_citas_avanzadas` (
`id_cita` int(11)
,`fecha_cita` date
,`hora_cita` time
,`estado_cita` enum('pendiente','confirmada','cancelada','completada')
,`motivo_cita` varchar(255)
,`cedula` varchar(20)
,`nombres_paciente` varchar(50)
,`apellidos_paciente` varchar(50)
,`odontologo_nombre` varchar(50)
,`odontologo_apellido` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_estado_citas_pacientes`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_estado_citas_pacientes` (
`id_usuario` int(11)
,`hora_cita` time
,`cedula` varchar(20)
,`nombre_completo_paciente` varchar(101)
,`estado_cita` enum('pendiente','confirmada','cancelada','completada')
,`nombre_completo_odontologo` varchar(101)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_gestion_insumos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_gestion_insumos` (
`nombre_insumo` varchar(50)
,`estado` enum('ordenado','en produccion','listo para entregar','entregado')
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_gestion_usuarios`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_gestion_usuarios` (
`id` int(11)
,`nombre_completo` varchar(101)
,`correo` varchar(50)
,`estado` enum('activo','inactivo')
,`rol` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_insumos_bajo_stock`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_insumos_bajo_stock` (
`id_insumo` int(11)
,`nombre_insumo` varchar(50)
,`cantidad_insumo` int(11)
,`costo_insumo` decimal(10,2)
,`fecha_vencimiento` date
,`umbral_alerta` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_insumos_vencimiento`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_insumos_vencimiento` (
`id_insumo` int(11)
,`nombre_insumo` varchar(50)
,`cantidad_insumo` int(11)
,`costo_insumo` decimal(10,2)
,`fecha_vencimiento` date
,`umbral_alerta` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_paciente_historia_receta`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_paciente_historia_receta` (
`nombres_paciente` varchar(50)
,`antecedentes_medicos` varchar(50)
,`tratamiento_realizados` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_proveedores_insumos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_proveedores_insumos` (
`Insumo` varchar(50)
,`Provedoor` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_usuarios_activos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_usuarios_activos` (
`id_usuario` int(11)
,`nombres_usuario` varchar(50)
,`apellidos_usuario` varchar(50)
,`estado_usuario` enum('activo','inactivo')
,`especialidad` varchar(50)
,`rol_id` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `v_usuarios_roles`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `v_usuarios_roles` (
`id_usuario` int(11)
,`nombres_usuario` varchar(50)
,`apellidos_usuario` varchar(50)
,`nombre_rol` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `v_cantidad_estado_citas`
--
DROP TABLE IF EXISTS `v_cantidad_estado_citas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_cantidad_estado_citas`  AS SELECT `citas`.`estado_cita` AS `estado_cita`, count(0) AS `cantidad` FROM `citas` GROUP BY `citas`.`estado_cita` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_cantidad_usuarios_por_rol`
--
DROP TABLE IF EXISTS `v_cantidad_usuarios_por_rol`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_cantidad_usuarios_por_rol`  AS SELECT `r`.`nombre_rol` AS `nombre_rol`, count(0) AS `cantidad_usuarios` FROM (`usuarios` `u` join `roles` `r` on(`u`.`rol_id` = `r`.`id_rol`)) GROUP BY `r`.`nombre_rol` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_citas`
--
DROP TABLE IF EXISTS `v_citas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_citas`  AS SELECT `c`.`id_cita` AS `id_cita`, `c`.`fecha_cita` AS `fecha_cita`, `c`.`hora_cita` AS `hora_cita`, `c`.`estado_cita` AS `estado_cita`, `c`.`motivo_cita` AS `motivo_cita`, `p`.`nombres_paciente` AS `nombres_paciente`, `p`.`apellidos_paciente` AS `apellidos_paciente`, `u`.`nombres_usuario` AS `odontologo_nombre`, `u`.`apellidos_usuario` AS `odontologo_apellido` FROM ((`citas` `c` join `pacientes` `p` on(`c`.`paciente_id` = `p`.`cedula`)) join `usuarios` `u` on(`c`.`usuario_id` = `u`.`id_usuario`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_citas_avanzadas`
--
DROP TABLE IF EXISTS `v_citas_avanzadas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_citas_avanzadas`  AS SELECT `c`.`id_cita` AS `id_cita`, `c`.`fecha_cita` AS `fecha_cita`, `c`.`hora_cita` AS `hora_cita`, `c`.`estado_cita` AS `estado_cita`, `c`.`motivo_cita` AS `motivo_cita`, `p`.`cedula` AS `cedula`, `p`.`nombres_paciente` AS `nombres_paciente`, `p`.`apellidos_paciente` AS `apellidos_paciente`, `u`.`nombres_usuario` AS `odontologo_nombre`, `u`.`apellidos_usuario` AS `odontologo_apellido` FROM ((`citas` `c` join `pacientes` `p` on(`c`.`paciente_id` = `p`.`cedula`)) join `usuarios` `u` on(`c`.`usuario_id` = `u`.`id_usuario`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_estado_citas_pacientes`
--
DROP TABLE IF EXISTS `v_estado_citas_pacientes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_estado_citas_pacientes`  AS SELECT `u`.`id_usuario` AS `id_usuario`, `c`.`hora_cita` AS `hora_cita`, `p`.`cedula` AS `cedula`, concat(`p`.`nombres_paciente`,' ',`p`.`apellidos_paciente`) AS `nombre_completo_paciente`, `c`.`estado_cita` AS `estado_cita`, concat(`u`.`nombres_usuario`,' ',`u`.`apellidos_usuario`) AS `nombre_completo_odontologo` FROM ((`pacientes` `p` join `citas` `c` on(`c`.`paciente_id` = `p`.`cedula`)) join `usuarios` `u` on(`u`.`id_usuario` = `c`.`usuario_id`)) WHERE `u`.`rol_id` = 2 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_gestion_insumos`
--
DROP TABLE IF EXISTS `v_gestion_insumos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_gestion_insumos`  AS SELECT `i`.`nombre_insumo` AS `nombre_insumo`, `oc`.`estado` AS `estado` FROM (((`detalles_ordenes` `deto` join `proveedores_insumos` `pi` on(`deto`.`insumo_id` = `pi`.`id_proveedor_insumo`)) join `insumos` `i` on(`pi`.`insumo_id` = `i`.`id_insumo`)) join `ordenes_compras` `oc` on(`deto`.`orden_id` = `oc`.`id_orden_compra`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_gestion_usuarios`
--
DROP TABLE IF EXISTS `v_gestion_usuarios`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_gestion_usuarios`  AS SELECT `u`.`id_usuario` AS `id`, concat(`u`.`nombres_usuario`,' ',`u`.`apellidos_usuario`) AS `nombre_completo`, `u`.`correo_usuario` AS `correo`, `u`.`estado_usuario` AS `estado`, `r`.`nombre_rol` AS `rol` FROM (`usuarios` `u` join `roles` `r` on(`u`.`rol_id` = `r`.`id_rol`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_insumos_bajo_stock`
--
DROP TABLE IF EXISTS `v_insumos_bajo_stock`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_insumos_bajo_stock`  AS SELECT `insumos`.`id_insumo` AS `id_insumo`, `insumos`.`nombre_insumo` AS `nombre_insumo`, `insumos`.`cantidad_insumo` AS `cantidad_insumo`, `insumos`.`costo_insumo` AS `costo_insumo`, `insumos`.`fecha_vencimiento` AS `fecha_vencimiento`, `insumos`.`umbral_alerta` AS `umbral_alerta` FROM `insumos` WHERE `insumos`.`cantidad_insumo` <= `insumos`.`umbral_alerta` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_insumos_vencimiento`
--
DROP TABLE IF EXISTS `v_insumos_vencimiento`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_insumos_vencimiento`  AS SELECT `insumos`.`id_insumo` AS `id_insumo`, `insumos`.`nombre_insumo` AS `nombre_insumo`, `insumos`.`cantidad_insumo` AS `cantidad_insumo`, `insumos`.`costo_insumo` AS `costo_insumo`, `insumos`.`fecha_vencimiento` AS `fecha_vencimiento`, `insumos`.`umbral_alerta` AS `umbral_alerta` FROM `insumos` WHERE `insumos`.`fecha_vencimiento` between curdate() and curdate() + interval 30 day ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_paciente_historia_receta`
--
DROP TABLE IF EXISTS `v_paciente_historia_receta`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_paciente_historia_receta`  AS SELECT `p`.`nombres_paciente` AS `nombres_paciente`, `h`.`antecedentes_medicos` AS `antecedentes_medicos`, `h`.`tratamiento_realizados` AS `tratamiento_realizados` FROM (`pacientes` `p` join `historias_clinicas` `h` on(`p`.`cedula` = `h`.`paciente_id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_proveedores_insumos`
--
DROP TABLE IF EXISTS `v_proveedores_insumos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_proveedores_insumos`  AS SELECT `i`.`nombre_insumo` AS `Insumo`, `p`.`nombre_proveedor` AS `Provedoor` FROM ((`insumos` `i` join `proveedores_insumos` `pi` on(`pi`.`insumo_id` = `i`.`id_insumo`)) join `proveedores` `p` on(`p`.`nit` = `pi`.`proveedor_id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_usuarios_activos`
--
DROP TABLE IF EXISTS `v_usuarios_activos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_usuarios_activos`  AS SELECT `usuarios`.`id_usuario` AS `id_usuario`, `usuarios`.`nombres_usuario` AS `nombres_usuario`, `usuarios`.`apellidos_usuario` AS `apellidos_usuario`, `usuarios`.`estado_usuario` AS `estado_usuario`, coalesce(`usuarios`.`especialidad_usuario`,'No aplica') AS `especialidad`, `usuarios`.`rol_id` AS `rol_id` FROM `usuarios` WHERE `usuarios`.`estado_usuario` = 'activo' ;

-- --------------------------------------------------------

--
-- Estructura para la vista `v_usuarios_roles`
--
DROP TABLE IF EXISTS `v_usuarios_roles`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_usuarios_roles`  AS SELECT `u`.`id_usuario` AS `id_usuario`, `u`.`nombres_usuario` AS `nombres_usuario`, `u`.`apellidos_usuario` AS `apellidos_usuario`, `r`.`nombre_rol` AS `nombre_rol` FROM (`usuarios` `u` join `roles` `r` on(`u`.`rol_id` = `r`.`id_rol`)) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id_cita`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `paciente_id` (`paciente_id`);

--
-- Indices de la tabla `detalles_ordenes`
--
ALTER TABLE `detalles_ordenes`
  ADD PRIMARY KEY (`id_detalle_orden`),
  ADD KEY `orden_id` (`orden_id`),
  ADD KEY `insumo_id` (`insumo_id`);

--
-- Indices de la tabla `historias_clinicas`
--
ALTER TABLE `historias_clinicas`
  ADD PRIMARY KEY (`id_historia_clinica`),
  ADD KEY `paciente_id` (`paciente_id`);

--
-- Indices de la tabla `insumos`
--
ALTER TABLE `insumos`
  ADD PRIMARY KEY (`id_insumo`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ordenes_compras`
--
ALTER TABLE `ordenes_compras`
  ADD PRIMARY KEY (`id_orden_compra`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `ordenes_laboratorio`
--
ALTER TABLE `ordenes_laboratorio`
  ADD PRIMARY KEY (`id_orden_lab`),
  ADD KEY `cita_id` (`cita_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`cedula`),
  ADD UNIQUE KEY `cedula` (`cedula`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `procedimientos`
--
ALTER TABLE `procedimientos`
  ADD PRIMARY KEY (`id_procedimiento`);

--
-- Indices de la tabla `procedimientos_citas`
--
ALTER TABLE `procedimientos_citas`
  ADD PRIMARY KEY (`id_procedimiento_cita`),
  ADD KEY `procedimiento_id` (`procedimiento_id`),
  ADD KEY `cita_id` (`cita_id`);

--
-- Indices de la tabla `productos_laboratorio`
--
ALTER TABLE `productos_laboratorio`
  ADD PRIMARY KEY (`id_producto_lab`),
  ADD KEY `orden_id` (`orden_id`),
  ADD KEY `insumo_id` (`insumo_id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`nit`),
  ADD UNIQUE KEY `nit` (`nit`);

--
-- Indices de la tabla `proveedores_insumos`
--
ALTER TABLE `proveedores_insumos`
  ADD PRIMARY KEY (`id_proveedor_insumo`),
  ADD KEY `proveedor_id` (`proveedor_id`),
  ADD KEY `insumo_id` (`insumo_id`);

--
-- Indices de la tabla `recetas_medicas`
--
ALTER TABLE `recetas_medicas`
  ADD PRIMARY KEY (`id_receta`),
  ADD KEY `historia_clinica_id` (`historia_clinica_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `rol_id` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `detalles_ordenes`
--
ALTER TABLE `detalles_ordenes`
  MODIFY `id_detalle_orden` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `historias_clinicas`
--
ALTER TABLE `historias_clinicas`
  MODIFY `id_historia_clinica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `insumos`
--
ALTER TABLE `insumos`
  MODIFY `id_insumo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `ordenes_compras`
--
ALTER TABLE `ordenes_compras`
  MODIFY `id_orden_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ordenes_laboratorio`
--
ALTER TABLE `ordenes_laboratorio`
  MODIFY `id_orden_lab` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `procedimientos`
--
ALTER TABLE `procedimientos`
  MODIFY `id_procedimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `procedimientos_citas`
--
ALTER TABLE `procedimientos_citas`
  MODIFY `id_procedimiento_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `productos_laboratorio`
--
ALTER TABLE `productos_laboratorio`
  MODIFY `id_producto_lab` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `proveedores_insumos`
--
ALTER TABLE `proveedores_insumos`
  MODIFY `id_proveedor_insumo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `recetas_medicas`
--
ALTER TABLE `recetas_medicas`
  MODIFY `id_receta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `citas_ibfk_2` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`cedula`);

--
-- Filtros para la tabla `detalles_ordenes`
--
ALTER TABLE `detalles_ordenes`
  ADD CONSTRAINT `detalles_ordenes_ibfk_1` FOREIGN KEY (`orden_id`) REFERENCES `ordenes_compras` (`id_orden_compra`),
  ADD CONSTRAINT `detalles_ordenes_ibfk_2` FOREIGN KEY (`insumo_id`) REFERENCES `insumos` (`id_insumo`);

--
-- Filtros para la tabla `historias_clinicas`
--
ALTER TABLE `historias_clinicas`
  ADD CONSTRAINT `historias_clinicas_ibfk_1` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`cedula`);

--
-- Filtros para la tabla `ordenes_compras`
--
ALTER TABLE `ordenes_compras`
  ADD CONSTRAINT `ordenes_compras_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `ordenes_laboratorio`
--
ALTER TABLE `ordenes_laboratorio`
  ADD CONSTRAINT `ordenes_laboratorio_ibfk_1` FOREIGN KEY (`cita_id`) REFERENCES `citas` (`id_cita`),
  ADD CONSTRAINT `ordenes_laboratorio_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `procedimientos_citas`
--
ALTER TABLE `procedimientos_citas`
  ADD CONSTRAINT `procedimientos_citas_ibfk_1` FOREIGN KEY (`procedimiento_id`) REFERENCES `procedimientos` (`id_procedimiento`),
  ADD CONSTRAINT `procedimientos_citas_ibfk_2` FOREIGN KEY (`cita_id`) REFERENCES `citas` (`id_cita`);

--
-- Filtros para la tabla `productos_laboratorio`
--
ALTER TABLE `productos_laboratorio`
  ADD CONSTRAINT `productos_laboratorio_ibfk_1` FOREIGN KEY (`orden_id`) REFERENCES `ordenes_laboratorio` (`id_orden_lab`),
  ADD CONSTRAINT `productos_laboratorio_ibfk_2` FOREIGN KEY (`insumo_id`) REFERENCES `insumos` (`id_insumo`);

--
-- Filtros para la tabla `proveedores_insumos`
--
ALTER TABLE `proveedores_insumos`
  ADD CONSTRAINT `proveedores_insumos_ibfk_1` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`nit`),
  ADD CONSTRAINT `proveedores_insumos_ibfk_2` FOREIGN KEY (`insumo_id`) REFERENCES `insumos` (`id_insumo`);

--
-- Filtros para la tabla `recetas_medicas`
--
ALTER TABLE `recetas_medicas`
  ADD CONSTRAINT `recetas_medicas_ibfk_1` FOREIGN KEY (`historia_clinica_id`) REFERENCES `historias_clinicas` (`id_historia_clinica`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
