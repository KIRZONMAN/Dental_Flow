-- 1) Evita solapes de fecha/hora
DROP TRIGGER IF EXISTS tg_bi_citas_slotvalid;
CREATE TRIGGER tg_bi_citas_slotvalid
  BEFORE INSERT ON citas
  FOR EACH ROW
BEGIN
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
END;

-- 2) Crea orden de laboratorio
DROP TRIGGER IF EXISTS tg_ai_citas_create_ordenlab;
CREATE TRIGGER tg_ai_citas_create_ordenlab
  AFTER INSERT ON citas
  FOR EACH ROW
BEGIN
  INSERT INTO ordenes_laboratorio (cita_id, usuario_id, fecha_solicitud, estado)
    VALUES (NEW.id_cita, NEW.usuario_id, CURDATE(), 'NUEVO');
END;


-- 3) Recalcula total antes de UPDATE
DROP TRIGGER IF EXISTS tg_bu_citas_totalcalc;
CREATE TRIGGER tg_bu_citas_totalcalc
  BEFORE UPDATE ON citas
  FOR EACH ROW
BEGIN
  SET NEW.total_cita = (
    SELECT IFNULL(SUM(proc.costo),0)
      FROM procedimientos_citas pc
      JOIN procedimientos proc
        ON pc.procedimiento_id = proc.id_procedimiento
     WHERE pc.cita_id = NEW.id_cita
  );
END;

-- 4) Borrado seguro de citas
DROP TRIGGER IF EXISTS tg_bd_citas_softdel;
CREATE TRIGGER tg_bd_citas_softdel
  BEFORE DELETE ON citas
  FOR EACH ROW
BEGIN
  IF OLD.estado_cita != 'pendiente'
     OR OLD.fecha_cita <= CURDATE() THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Solo se pueden borrar citas pendientes y futuras';
  END IF;
END;

-- 5) Limpia orden de laboratorio al borrar cita
DROP TRIGGER IF EXISTS tg_ad_citas_cleanup;
CREATE TRIGGER tg_ad_citas_cleanup
  AFTER DELETE ON citas
  FOR EACH ROW
BEGIN
  DELETE FROM ordenes_laboratorio
   WHERE cita_id = OLD.id_cita;
END;

-- 6) Recalcula tras INSERT en procedimientos_citas
DROP TRIGGER IF EXISTS tg_ai_proc_cita_total;
CREATE TRIGGER tg_ai_proc_cita_total
  AFTER INSERT ON procedimientos_citas
  FOR EACH ROW
BEGIN
  CALL pa_RecalcularTotalCita(NEW.cita_id);
END;

-- 7) Recalcula tras DELETE en procedimientos_citas
DROP TRIGGER IF EXISTS tg_ad_proc_cita_remove;
CREATE TRIGGER tg_ad_proc_cita_remove
  AFTER DELETE ON procedimientos_citas
  FOR EACH ROW
BEGIN
  CALL pa_RecalcularTotalCita(OLD.cita_id);
END;

-- 8) Recalcula tras UPDATE en procedimientos_citas
DROP TRIGGER IF EXISTS tg_au_proc_cita_update;
CREATE TRIGGER tg_au_proc_cita_update
  AFTER UPDATE ON procedimientos_citas
  FOR EACH ROW
BEGIN
  CALL pa_RecalcularTotalCita(NEW.cita_id);
END;




/*nuevos tryherds*/
-- ===================================================================
-- 1) roles: impide borrar rol con usuarios asignados
-- ===================================================================
DROP TRIGGER IF EXISTS tg_bd_roles_protect;
CREATE TRIGGER tg_bd_roles_protect
  BEFORE DELETE ON roles
  FOR EACH ROW
BEGIN
  IF EXISTS(SELECT 1 FROM usuarios WHERE rol_id = OLD.id) THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'No puedes borrar un rol que aún tiene usuarios';
  END IF;
END;

-- ===================================================================
-- 2–6) usuarios
-- ===================================================================
DROP TRIGGER IF EXISTS tg_bi_users_emailuniq;
CREATE TRIGGER tg_bi_users_emailuniq
  BEFORE INSERT ON usuarios
  FOR EACH ROW
BEGIN
  IF EXISTS(SELECT 1 FROM usuarios WHERE correo_usuario = NEW.correo_usuario) THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'El correo ya está en uso';
  END IF;
END;

DROP TRIGGER IF EXISTS tg_bu_users_hashpwd;
CREATE TRIGGER tg_bu_users_hashpwd
  BEFORE UPDATE ON usuarios
  FOR EACH ROW
BEGIN
  IF NEW.contrasena_usuario <> OLD.contrasena_usuario THEN
    SET NEW.contrasena_usuario = CONCAT('$2y$12$', SUBSTRING(SHA2(NEW.contrasena_usuario,256),1,53));
  END IF;
END;

DROP TRIGGER IF EXISTS tg_bu_users_softdel;
CREATE TRIGGER tg_bu_users_softdel
  BEFORE DELETE ON usuarios
  FOR EACH ROW
BEGIN
  IF OLD.rol_id = 1
     AND (SELECT COUNT(*) FROM usuarios WHERE rol_id = 1) <= 1 THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Debe quedar al menos un administrador';
  END IF;
  SET NEW.estado_usuario = 'inactivo';
END;

DROP TRIGGER IF EXISTS tg_ad_users_cascade;
CREATE TRIGGER tg_ad_users_cascade
  AFTER DELETE ON usuarios
  FOR EACH ROW
BEGIN
  UPDATE citas
     SET estado_cita = 'cancelada'
   WHERE usuario_id = OLD.id_usuario
     AND fecha_cita > CURDATE();
  DELETE FROM sessions WHERE user_id = OLD.id_usuario;
END;

DROP TRIGGER IF EXISTS tg_au_users_lock;
CREATE TRIGGER tg_au_users_lock
  AFTER UPDATE ON usuarios
  FOR EACH ROW
BEGIN
  IF NEW.estado_usuario = 'BLOQUEADO' THEN
    DELETE FROM sessions WHERE user_id = NEW.id_usuario;
  END IF;
END;

-- ===================================================================
-- 7–9) pacientes
-- ===================================================================
DROP TRIGGER IF EXISTS tg_bi_pacientes_validate;
CREATE TRIGGER tg_bi_pacientes_validate
  BEFORE INSERT ON pacientes
  FOR EACH ROW
BEGIN
  IF NEW.edad < 0 OR NEW.edad > 120 THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Edad inválida';
  END IF;
  SET NEW.nombres_paciente  = UPPER(NEW.nombres_paciente);
  SET NEW.apellidos_paciente = UPPER(NEW.apellidos_paciente);
  IF NOT NEW.cedula REGEXP '^[0-9]{10}$' THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cédula debe tener 10 dígitos';
  END IF;
END;

DROP TRIGGER IF EXISTS tg_ai_pacientes_hist;
CREATE TRIGGER tg_ai_pacientes_hist
  AFTER INSERT ON pacientes
  FOR EACH ROW
BEGIN
  INSERT INTO historias_clinicas (paciente_id, antecedentes_medicos, tratamientos_realizados)
    VALUES (NEW.cedula, 'SIN ANTECEDENTES', 'SIN TRATAMIENTOS');
END;

DROP TRIGGER IF EXISTS tg_bd_pacientes_protect;
CREATE TRIGGER tg_bd_pacientes_protect
  BEFORE DELETE ON pacientes
  FOR EACH ROW
BEGIN
  IF EXISTS(SELECT 1 FROM citas WHERE paciente_id = OLD.cedula AND fecha_cita >= CURDATE())
     OR EXISTS(SELECT 1 FROM facturas WHERE paciente_id = OLD.cedula) THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Paciente con actividad pendiente, no se puede borrar';
  END IF;
END;

-- ===================================================================
-- 10) historias_clinicas
-- ===================================================================
DROP TRIGGER IF EXISTS tg_bd_historia_protect;
CREATE TRIGGER tg_bd_historia_protect
  BEFORE DELETE ON historias_clinicas
  FOR EACH ROW
BEGIN
  IF EXISTS(SELECT 1 FROM recetas_medicas WHERE historia_id = OLD.id_historia) THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'No puedes borrar historia con recetas asociadas';
  END IF;
END;

-- ===================================================================
-- 11–12) procedimientos
-- ===================================================================
DROP TRIGGER IF EXISTS tg_ai_proc_costvalidate;
CREATE TRIGGER tg_ai_proc_costvalidate
  BEFORE INSERT ON procedimientos
  FOR EACH ROW
BEGIN
  IF NEW.costo <= 0 THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Costo debe ser mayor a cero';
  END IF;
END;

DROP TRIGGER IF EXISTS tg_bd_proc_protect;
CREATE TRIGGER tg_bd_proc_protect
  BEFORE DELETE ON procedimientos
  FOR EACH ROW
BEGIN
  IF EXISTS(SELECT 1 FROM procedimientos_citas WHERE procedimiento_id = OLD.id_procedimiento) THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'No puedes borrar un procedimiento usado';
  END IF;
END;

-- ===================================================================
-- 13–14) recetas_medicas
-- ===================================================================
DROP TRIGGER IF EXISTS tg_bi_receta_datechk;
CREATE TRIGGER tg_bi_receta_datechk
  BEFORE INSERT ON recetas_medicas
  FOR EACH ROW
BEGIN
  IF NEW.fecha > CURDATE() THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Fecha de receta no puede ser futura';
  END IF;
END;

DROP TRIGGER IF EXISTS tg_bd_receta_protect;
CREATE TRIGGER tg_bd_receta_protect
  BEFORE DELETE ON recetas_medicas
  FOR EACH ROW
BEGIN
  SIGNAL SQLSTATE '45000'
    SET MESSAGE_TEXT = 'Las recetas no se pueden borrar en esta fase';
END;

-- ===================================================================
-- 15–20) citas
-- ===================================================================
DROP TRIGGER IF EXISTS tg_bi_citas_slotvalid;
CREATE TRIGGER tg_bi_citas_slotvalid
  BEFORE INSERT ON citas
  FOR EACH ROW
BEGIN
  IF EXISTS(
    SELECT 1 FROM citas
     WHERE fecha_cita = NEW.fecha_cita
       AND hora_cita  = NEW.hora_cita
       AND (paciente_id = NEW.paciente_id OR usuario_id = NEW.usuario_id)
  ) THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Ya hay cita a esa hora para paciente u odontólogo';
  END IF;
END;

DROP TRIGGER IF EXISTS tg_ai_citas_create_ordenlab;
CREATE TRIGGER tg_ai_citas_create_ordenlab
  AFTER INSERT ON citas
  FOR EACH ROW
BEGIN
  INSERT INTO ordenes_laboratorio (cita_id, usuario_id, fecha_solicitud, estado)
    VALUES (NEW.id_cita, NEW.usuario_id, CURDATE(), 'NUEVO');
END;

DROP TRIGGER IF EXISTS tg_ai_citas_notification;
CREATE TRIGGER tg_ai_citas_notification
  AFTER INSERT ON citas
  FOR EACH ROW
BEGIN
  INSERT INTO notificaciones(usuario_id, mensaje, created_at)
  VALUES
    (NEW.paciente_id, CONCAT('Tu cita: ', NEW.fecha_cita, ' ha sido agendada'), NOW()),
    (NEW.usuario_id,       CONCAT('Tienes nueva cita para ', NEW.fecha_cita), NOW());
END;

DROP TRIGGER IF EXISTS tg_bu_citas_totalcalc;
CREATE TRIGGER tg_bu_citas_totalcalc
  BEFORE UPDATE ON citas
  FOR EACH ROW
BEGIN
  SET NEW.total_cita = (
    SELECT IFNULL(SUM(proc.costo),0)
      FROM procedimientos_citas pc
      JOIN procedimientos proc
        ON pc.procedimiento_id = proc.id_procedimiento
     WHERE pc.cita_id = NEW.id_cita
  );
END;

DROP TRIGGER IF EXISTS tg_bd_citas_softdel;
CREATE TRIGGER tg_bd_citas_softdel
  BEFORE DELETE ON citas
  FOR EACH ROW
BEGIN
  IF OLD.estado_cita != 'pendiente'
     OR OLD.fecha_cita <= CURDATE() THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Solo se pueden borrar citas pendientes y futuras';
  END IF;
END;

DROP TRIGGER IF EXISTS tg_ad_citas_cleanup;
CREATE TRIGGER tg_ad_citas_cleanup
  AFTER DELETE ON citas
  FOR EACH ROW
BEGIN
  DELETE FROM ordenes_laboratorio
   WHERE cita_id = OLD.id_cita;
END;

-- ===================================================================
-- 21–23) procedimientos_citas
-- ===================================================================
DROP TRIGGER IF EXISTS tg_ai_proc_cita_total;
CREATE TRIGGER tg_ai_proc_cita_total
  AFTER INSERT ON procedimientos_citas
  FOR EACH ROW
BEGIN
  CALL pa_RecalcularTotalCita(NEW.cita_id);
END;

DROP TRIGGER IF EXISTS tg_ad_proc_cita_remove;
CREATE TRIGGER tg_ad_proc_cita_remove
  AFTER DELETE ON procedimientos_citas
  FOR EACH ROW
BEGIN
  CALL pa_RecalcularTotalCita(OLD.cita_id);
END;

DROP TRIGGER IF EXISTS tg_au_proc_cita_update;
CREATE TRIGGER tg_au_proc_cita_update
  AFTER UPDATE ON procedimientos_citas
  FOR EACH ROW
BEGIN
  CALL pa_RecalcularTotalCita(NEW.cita_id);
END;
