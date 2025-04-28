DentalFlow

DentalFlow es un sistema integral de gestión odontológica diseñado para facilitar la administración clínica de pacientes, insumos, recetas médicas, órdenes de compra y asignación de procedimientos, todo desde una interfaz web estructurada según distintos roles del personal de la clínica.


---

Tabla de Contenido

1. Objetivo del Proyecto

2. Tecnologías Usadas

3. Instalación y Ejecución Local

4. Funcionalidades por Rol

5. Base de Datos

6. Metodología de Trabajo

7. Equipo de Desarrollo

8. Enlaces de Interés

---

Objetivo del Proyecto

DentalFlow busca ser un sistema web para clínicas odontológicas que centraliza la gestión de pacientes, citas, procedimientos médicos, recetas, y órdenes de compra en una única plataforma con interfaz intuitiva y accesible según roles definidos. El propósito principal es agilizar el flujo de trabajo interno, facilitar la trazabilidad de los servicios prestados y optimizar el manejo de insumos y proveedores.


---

Tecnologías Usadas

Frontend: HTML5, CSS3, JavaScript puro

Backend: PHP y Laravel

Base de Datos: MySQL

Servidor Local: XAMPP (Apache + MySQL)

Control de Versiones: Git & GitHub

Diseño del Modelo de Datos: Draw.io

Metodología Ágil: Scrumban (en Trello)

---

Instalación y Ejecución Local

1. Clona el repositorio:

git clone https://github.com/KIRZONMAN/Dental_Flow.git

2. Copia el contenido dentro del directorio htdocs de XAMPP.

3. Importa el archivo SQL desde /db/Script Base de Datos DentalFlow.sql en phpMyAdmin.

4. Inicia los servicios de Apache y MySQL desde el panel de control de XAMPP.

5. Accede al sistema desde tu navegador:

http://localhost/Dental_Flow/

---

Funcionalidades por Rol

Administrador

Gestión de usuarios y roles

Visualización de solicitudes de insumos

Control y auditoría general del sistema


Odontólogo

Registro de procedimientos clínicos

Emisión de recetas médicas

Gestión de citas atendidas


Cajero (a desarrollar para futuras versiones)

Facturación de servicios

Registro de medios de pago y estados (Pagado, Pendiente, etc.)

Consulta de facturas


Asistente

Registro de pacientes

Agendamiento de citas

Visualización del historial clínico

Soporte logístico a odontólogos

---

Base de Datos

El sistema utiliza un modelo entidad-relación estructurado en 13 tablas interrelacionadas. Entre ellas se encuentran:
Usuarios, Roles, Citas, Pacientes, Recetas_Medicas, Orden_Compra, Proveedores, Insumos, Detalles_Ordenes, etc.

Todas las relaciones están diseñadas para mantener la integridad referencial. Se emplean claves foráneas y ON DELETE CASCADE donde es necesario.

---

Metodología de Trabajo

El equipo adoptó la metodología Scrumban, una fusión de Scrum y Kanban, ideal para proyectos con carga variable, miembros con horarios inconsistentes y necesidad de visualizar flujo de trabajo.

¿Por qué Scrumban?

* Flexible ante cambios de alcance

* Mejor distribución de tareas por medio de tableros visuales

* Menos reuniones y más enfoque en ejecución

* Seguimiento visual del progreso diario


El equipo utiliza un tablero Kanban digital donde se definen prioridades, se asignan tareas y se hace seguimiento de entregables.

---

Equipo de Desarrollo

Héctor Alejandro Garcés – Líder del proyecto, backend y base de datos

Juan David Oviedo – Interfaz de usuario y conexiones con la base de datos

Janer Esteban Pechene – Documentación, lógica de roles, frontend

---

Enlaces

Repositorio GitHub DentalFlow: https://github.com/KIRZONMAN/Dental_Flow

---