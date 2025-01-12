create database gestion_proyectos;
use gestion_proyectos;
drop database gestion_proyectos;

CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) unique,
    email VARCHAR(255) unique,
    contrasena VARCHAR(255)
);

CREATE TABLE proyectos (
    id_proyecto INT AUTO_INCREMENT PRIMARY KEY,
    titulo_proyecto VARCHAR(255)
);
CREATE TABLE usuarios_proyectos (
    id_usuario INT,
    id_proyecto INT,
    id_rol INT,
    PRIMARY KEY (id_usuario, id_proyecto),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_proyecto) REFERENCES proyectos(id_proyecto),
    FOREIGN KEY (id_rol) REFERENCES roles(id_rol)
);
CREATE TABLE roles (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR(100)
);

CREATE TABLE estado_tareas (
	id_estado_tarea INT auto_increment PRIMARY KEY,
	estado_tarea VARCHAR(50)
);

CREATE TABLE tipo_tareas (
	id_tipo_tarea INT AUTO_INCREMENT PRIMARY KEY,
	tipo_tarea VARCHAR(50)
);

CREATE TABLE tareas (
    id_tarea INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(200),
    descripcion VARCHAR(255),
    fecha_inicio DATE,
    fecha_final DATE,
    id_usuario INT,
    id_proyecto INT,
    id_estado_tarea INT,  
    id_tipo_tarea INT,  
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_proyecto) REFERENCES proyectos(id_proyecto),
    FOREIGN KEY (id_estado_tarea) REFERENCES estado_tareas(id_estado_tarea),
    FOREIGN KEY (id_tipo_tarea) REFERENCES tipo_tareas(id_tipo_tarea)
);
