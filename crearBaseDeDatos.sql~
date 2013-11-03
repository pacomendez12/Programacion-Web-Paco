create database cc409_user106;


use cc409_user106;

create table alumno(codigo bigint, 
	nombre varchar(40), apellidos varchar(40), contrasena varchar(40),email varchar(50),
	carrera varchar(30), status boolean, celular varchar(12),
	github varchar(50), pagina varchar(50),
	primary key(codigo)
);
	
create table curso(nrc int auto_increment,
	
	id_materia int,
	nombre_ciclo_escolar varchar(6),
	codigo_profesor bigint,
	primary key(nrc)
	);

create table administrador(codigo bigint auto_increment,
	nombre varchar(40), apellidos varchar(40), contrasena varchar(40),
	email varchar(50),
	primary key(codigo)
);

create table ciclo_escolar(nombre varchar(6),
	fecha_inicio date, fecha_fin date,
	primary key(nombre)
);


create table dias_de_suspension(id_dia int auto_increment,
	fecha date, motivo varchar(50),
	nombre_ciclo_escolar varchar(6),
	primary key(id_dia)
);

create table academia(id_academia int,
	nombre varchar(25),
	primary key(id_academia)
);

create table materia(id_materia int auto_increment,
	clave varchar(6),
	nombre varchar(50),
	id_academia int,
	primary key(id_materia)
);

create table dias_clases(id_dia int auto_increment,
	dia varchar(15), hora_inicio timestamp, hora_fin timestamp,
	
	nrc int,
	primary key(id_dia)
);

create table asistencia(nrc int, codigo_alumno bigint,
	fecha date, asistio boolean,
	primary key(nrc,codigo_alumno)
);

create table profesor(codigo bigint auto_increment,
	nombre varchar(40), apellidos varchar(40), contrasena varchar(40),
	email varchar(50),
	primary key(codigo)
);

create table evaluacion(id_evaluacion int auto_increment,
	rubro varchar(15), calificacion double,
	
	codigo_alumno bigint,
	id_rubro int,
	primary key(id_evaluacion)
);

create table rubro(id_rubro int auto_increment,
	actividad varchar(15), porcentaje int,
	hoja_extra boolean, 
	
	nrc int,
	primary key(id_rubro)
);


create table columnas_hojas(id_columna int auto_increment,
	columna varchar(25), 
	
	id_rubro int,
	primary key(id_columna)
);


--llaves foraneas
--curso
alter table curso add constraint  fk_curso_materia foreign key (id_materia) references  materia(id_materia);
alter table curso add constraint  fk_curso_ciclo foreign key (nombre_ciclo_escolar) references  ciclo_escolar(nombre);
alter table curso add constraint  fk_curso_profesor foreign key (codigo_profesor) references  profesor(codigo);

--dias de suspension
alter table dias_de_suspension add constraint  fk_dds_ciclo foreign key (nombre_ciclo_escolar) references  ciclo_escolar(nombre);

--materia
alter table materia add constraint  fk_materia_academia foreign key (id_academia) references academia(id_academia);

--asistencia
alter table asistencia add constraint  fk_asistencia_curso foreign key (nrc) references  curso(nrc);
alter table asistencia add constraint  fk_asistencia_alumno foreign key (codigo_alumno) references  alumno(codigo);

--evaluacion
alter table evaluacion add constraint  fk_evaluacion_alumno foreign key (codigo_alumno) references  alumno(codigo);
alter table evaluacion add constraint  fk_evaluacion_rubro foreign key (id_rubro) references  rubro(id_rubro);

--rubro
alter table rubro add constraint  fk_rubro_curso foreign key (nrc) references  curso(nrc);

--columnas_hojas
alter table columnas_hojas add constraint  fk_ch_rubro foreign key (id_rubro) references  rubro(id_rubro);


--datos por default-----------------------------------------------------------------------------------------
--administrador
insert into administrador values(0,'admin','admin','admin','admin@admin.admin');

--academias
insert into academia values(1,'Computación básica');
insert into academia values(2,'Programación básica');
insert into academia values(3,'Técnicas Modernas de Programación');
insert into academia values(4,'Estructuras y algoritmos');
insert into academia values(5,'Sistemas de Información');
insert into academia values(6,'Sistemas Digitales');
insert into academia values(7,'Software de Sistemas');
insert into academia values(8,'Técnicas Modernas de Programación');

--materias
insert into materia values(default,'CC100','Introducción a la Computación','1');
insert into materia values(default,'CC101','Taller de Introducción a la Computación','1');
insert into materia values(default,'CC102','Introducción a la Programación','2');
insert into materia values(default,'CC103','Taller de Programación Estructurada','2');
insert into materia values(default,'CC108','Programación Estructurada','2');
insert into materia values(default,'CC109','Programación para Interfaces','8');
insert into materia values(default,'CC200','Programación Orientada a Objetos','8');
insert into materia values(default,'CC201','Taller de Programación Orientada a Objetos','8');
insert into materia values(default,'CC202','Estructura de Datos','3');
insert into materia values(default,'CC203','Taller de Estructura de Datos','3');
insert into materia values(default,'CC204','Estructura de Archivos','3');
insert into materia values(default,'CC205','Taller de Estructura de Archivos','3');
insert into materia values(default,'CC206','Programación de Sistemas','7');
insert into materia values(default,'CC207','Taller de Programación de Sistemas','7');
insert into materia values(default,'CC208','Lenguajes de Programación Comparados','8');
insert into materia values(default,'CC209','Teoría de la Computación','3');
insert into materia values(default,'CC210','Arquitectura de Computadoras','6');
insert into materia values(default,'CC211','Teleinformática','6');
insert into materia values(default,'CC212','Redes de Computadoras','6');
insert into materia values(default,'CC213','Taller de Redes de Computadoras','6');
insert into materia values(default,'CC300','Sistemas Operativos','7');
insert into materia values(default,'CC301','Taller de Sistemas Operativos','7');
insert into materia values(default,'CC302','Bases de Datos','5');
insert into materia values(default,'CC303','Taller de Bases de Datos','5');
insert into materia values(default,'CC304','Ingeniería de Software I','4');
insert into materia values(default,'CC305','Ingenieria de Software II','4');
insert into materia values(default,'CC306','Taller de Ingenieria de Software II','4');
insert into materia values(default,'CC307','Programación Lógica y Funcional','8');
insert into materia values(default,'CC308','Taller de Programación Lógica y Funcional','8');
insert into materia values(default,'CC309','Bases de Datos Avanzadas','5');
insert into materia values(default,'CC310','Taller de Bases de Datos Avanzadas','5');
insert into materia values(default,'CC311','Gráficas por Computadora','7');
insert into materia values(default,'CC312','Taller de Gráficas por Computadora',null);
insert into materia values(default,'CC313','Administración de Bases de Datos','5');
insert into materia values(default,'CC314','Taller de Administración de Bases de Datos','5');
insert into materia values(default,'CC315','Sistemas de Información Administrativos','5');
insert into materia values(default,'CC316','Análisis y Diseño de Algoritmos','3');
insert into materia values(default,'CC317','Compiladores',null);
insert into materia values(default,'CC318','Taller de Compiladores','7');
insert into materia values(default,'CC319','Sistemas Operativos Avanzados','7');
insert into materia values(default,'CC320','Taller de Sistemas Operativos Avanzados','7');
insert into materia values(default,'CC321','Fundamentos de Ingeniería de Software','4');
insert into materia values(default,'CC322','Organización de Computadoras I','6');
insert into materia values(default,'CC323','Organización de Computadoras II','6');
insert into materia values(default,'CC324','Redes de Computadoras Avanzadas','6');
insert into materia values(default,'CC325','Taller de Redes Avanzadas','6');
insert into materia values(default,'CC400','Sistemas Expertos','8');
insert into materia values(default,'CC401','Programación de Sistemas Multimedia','5');
insert into materia values(default,'CC402','Taller de Sistemas Multimedia','5');
insert into materia values(default,'CC403','Auditoría de Sistemas','4');
insert into materia values(default,'CC404','Sistemas de Información Financieros','5');
insert into materia values(default,'CC405','Sistemas de Información para la Manufactura','5');
insert into materia values(default,'CC406','Sistemas de Información para la Toma de Decisiones','5');
insert into materia values(default,'CC407','Proyecto Terminal','4');
insert into materia values(default,'CC408','Simulación de Sistemas Digitales','6');
insert into materia values(default,'CC409','Arquitectura de Computadoras Avanzada','6');
insert into materia values(default,'CC410','Redes Neuronales Artificiales','8');
insert into materia values(default,'CC411','Computación Tolerante a Fallas','7');
insert into materia values(default,'CC413','Programación Concurrente y Distribuida','7');
insert into materia values(default,'CC414','Taller de Programacion Concurrente y Distribuida','7');
insert into materia values(default,'CC415','Inteligencia Artificial','8');
insert into materia values(default,'CC417','Tópicos Selectos de Computación I (Robótica Móvil)','7');
insert into materia values(default,'CC417','Tópicos Selectos de Computación I (Administración de Servidores Microsoft)','7');
insert into materia values(default,'CC417','Tópicos Selectos de Computación I (Control de Proyectos)','4');
insert into materia values(default,'CC418','Tópicos Selectos de Computación II (Unix y Linux)','7');
insert into materia values(default,'CC419','Topicos Selectos de Computación III (Java Avanzado)','8');
insert into materia values(default,'CC419','Topicos Selectos de Computación III (Programación Web)','8');
insert into materia values(default,'CC420','Tópicos Selectos de Informática I (Programación de iPod y iPhone)','7');
insert into materia values(default,'CC420','Tópicos Selectos de Informática I (Interconexión de redes)','6');
insert into materia values(default,'CC420','Tópicos Selectos de Informática I (Comercio Electrónico)','4');
insert into materia values(default,'CC421','Tópicos Selectos de Informática II (Programación de iPod y iPhone)','7');
insert into materia values(default,'CC421','Tópicos Selectos de Informática II','8');
insert into materia values(default,'CC421','Tópicos Selectos de Informática II','4');
insert into materia values(default,'CC422','Tópicos Selectos de Informática III (C#)','8');
insert into materia values(default,'CC422','Tópicos Selectos de Informática III (Software libre)','7');
insert into materia values(default,'I5882','Programación',null);
insert into materia values(default,'I5883','Seminario de Solución de Problemas de Programación',null);
insert into materia values(default,'I5884','Algoritmia',null);
insert into materia values(default,'I5885','Seminario de Solución de Problemas de Algoritmia',null);
insert into materia values(default,'I5886','Estructuras de Datos I',null);
insert into materia values(default,'I5887','Seminario de Solución de Problemas de Estructuras de Datos I',null);
insert into materia values(default,'I5888','Estructuras de Datos II',null);
insert into materia values(default,'I5889','Seminario de Solución de Problemas de Estructuras de Datos II',null);
insert into materia values(default,'I5890','Bases de Datos',null);
insert into materia values(default,'I5891','Seminario de Solución de Problemas de Bases de Datos',null);
insert into materia values(default,'I5898','Ingeniería de Software I',null);
insert into materia values(default,'I5899','Seminario de Solución de Problemas de Ingeniería de Software I',null);
insert into materia values(default,'I5900','Ingeniería de Software II',null);
insert into materia values(default,'I5902','Administración de Bases de Datos',null);
insert into materia values(default,'I5903','Uso, Adaptación y Explotación de Sistemas Operativos',null);
insert into materia values(default,'I5904','Seminario de Solución de Problemas de Uso, Adaptación y Explotación de Sistemas Operativos',null);
insert into materia values(default,'I5905','Seguridad de la Información',null);
insert into materia values(default,'I5906','Almacenes de Datos (Data Warehouse)',null);
insert into materia values(default,'I5907','Administración de Redes',null);
insert into materia values(default,'I5908','Administración de Servidores',null);
insert into materia values(default,'I5909','Programación para Internet',null);
insert into materia values(default,'I5910','Hypermedia',null);
insert into materia values(default,'I5911','Minería de Datos',null);
insert into materia values(default,'I5912','Clasificación Inteligente de Datos',null);
insert into materia values(default,'I5913','Sistemas Basados en Conocimiento',null);
insert into materia values(default,'I5914','Seminario de Solución de Problemas de Sistemas Basados en Conocimiento',null);
insert into materia values(default,'I5915','Teoría de la Computación',null);
insert into materia values(default,'I7022','Fundamentos Filosóficos de la Computación',null);
insert into materia values(default,'I7023','Arquitectura de Computadoras',null);
insert into materia values(default,'I7024','Seminario de Solución de Problemas de Arquitectura de Computadoras',null);
insert into materia values(default,'I7025','Traductores de Lenguajes I',null);
insert into materia values(default,'I7026','Seminario de Solución de Problemas de Traductores de Lenguajes I',null);
insert into materia values(default,'I7027','Traductores de Lenguajes II',null);
insert into materia values(default,'I7028','Seminario de Solución de Problemas de Traductores de Lenguaje II',null);
insert into materia values(default,'I7029','Sistemas Operativos',null);
insert into materia values(default,'I7030','Seminario de Solución de Problemas de Sistemas Operativos',null);
insert into materia values(default,'I7031','Redes de computadoras y Protocolos de Comunicación',null);
insert into materia values(default,'I7032','Seminario de Solución de Problemas de Redes de Computadoras y Protocolos de Comunicación',null);
insert into materia values(default,'I7033','Sistemas Operativos de Red',null);
insert into materia values(default,'I7034','Seminario de Solución de Problemas de Sistemas Operativos en Red',null);
insert into materia values(default,'I7035','Sistemas Concurrentes y Distribuidos',null);
insert into materia values(default,'I7036','Computación tolerante a fallas',null);
insert into materia values(default,'I7037','Seguridad',null);
insert into materia values(default,'I7038','Inteligencia Artificial I',null);
insert into materia values(default,'I7039','Seminario de Solución de Problemas de Inteligencia Artificial I',null);
insert into materia values(default,'I7040','Inteligencia Artificial II',null);
insert into materia values(default,'I7041','Seminario de Solución de Problemas de Inteligencia Artificial II',null);
insert into materia values(default,'I7042','Simulación por Computadora',null);
insert into materia values(default,'I7609','Procesamiento de Bioimágenes',null);

