-- phpMyAdmin SQL Dump
-- version 2.10.0.2
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tiempo de generación: 02-07-2007 a las 13:57:31
-- Versión del servidor: 4.1.22
-- Versión de PHP: 4.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

SET AUTOCOMMIT=0;
START TRANSACTION;

-- 
-- Base de datos: 'celsiusoriginal'
-- 

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'archivos_pedidos'
-- 

CREATE TABLE archivos_pedidos (
  codigo mediumint(8) unsigned NOT NULL auto_increment,
  nombre_archivo varchar(255) character set latin1 NOT NULL default '',
  codigo_pedido varchar(20) character set latin1 default NULL,
  Permitir_Download tinyint(1) unsigned NOT NULL default '0',
  Fecha_Upload datetime NOT NULL default '0000-00-00 00:00:00',
  borrado tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (codigo),
  KEY codigo_pedido (codigo_pedido),
  KEY nombre_archivo (nombre_archivo)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'busquedas'
-- 

CREATE TABLE busquedas (
  Id int(11) unsigned NOT NULL auto_increment,
  Id_Catalogo smallint(5) unsigned NOT NULL default '0',
  Fecha date NOT NULL default '0000-00-00',
  Id_Pedido varchar(20) character set latin1 NOT NULL default '',
  Id_Usuario smallint(5) unsigned NOT NULL default '0',
  Resultado tinyint(3) unsigned NOT NULL default '0',
  Comentarios text character set latin1 NOT NULL,
  PRIMARY KEY  (Id),
  KEY Id_Pedido (Id_Pedido),
  KEY Id_Catalogo_2 (Id_Catalogo,Id_Pedido)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'campos_pedidos'
-- 

CREATE TABLE campos_pedidos (
  id smallint(5) unsigned NOT NULL auto_increment,
  tipo_material tinyint(3) unsigned NOT NULL default '0',
  codigo varchar(50) collate latin1_spanish_ci default NULL,
  obligatorio tinyint(1) unsigned NOT NULL default '0',
  tipo_regexp varchar(50) collate latin1_spanish_ci NOT NULL default 'string',
  PRIMARY KEY  (id),
  UNIQUE KEY tipo_material (tipo_material,codigo)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'campos_pedidos_traducidos'
-- 

CREATE TABLE campos_pedidos_traducidos (
  id_campo smallint(5) unsigned NOT NULL default '0',
  id_idioma smallint(5) unsigned NOT NULL default '0',
  texto varchar(50) collate latin1_spanish_ci NOT NULL default '',
  abreviatura varchar(50) collate latin1_spanish_ci NOT NULL default '',
  mensaje_ayuda varchar(255) collate latin1_spanish_ci NOT NULL default '',
  mensaje_error varchar(255) collate latin1_spanish_ci NOT NULL default '',
  PRIMARY KEY  (id_campo,id_idioma)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'candidatos'
-- 

CREATE TABLE candidatos (
  Id smallint(5) unsigned NOT NULL auto_increment,
  Apellido varchar(60) character set latin1 NOT NULL default '',
  Nombres varchar(100) character set latin1 NOT NULL default '',
  EMail varchar(100) character set latin1 default NULL,
  Codigo_Institucion smallint(5) unsigned NOT NULL default '0',
  Otra_Institucion varchar(100) character set latin1 default NULL,
  Codigo_Dependencia smallint(5) unsigned NOT NULL default '0',
  Otra_Dependencia varchar(100) character set latin1 default NULL,
  Codigo_Unidad smallint(5) unsigned NOT NULL default '0',
  Otra_Unidad varchar(100) character set latin1 default NULL,
  Direccion varchar(100) character set latin1 default NULL,
  Codigo_Pais smallint(5) unsigned NOT NULL default '0',
  Otro_Pais varchar(100) character set latin1 default NULL,
  Codigo_Localidad smallint(5) unsigned NOT NULL default '0',
  Otra_Localidad varchar(100) character set latin1 default NULL,
  Codigo_Categoria smallint(5) unsigned NOT NULL default '0',
  Otra_Categoria varchar(100) character set latin1 default NULL,
  Telefonos varchar(100) character set latin1 default NULL,
  Fecha_Registro datetime default NULL,
  Comentarios text character set latin1,
  rechazados tinyint(2) unsigned NOT NULL default '0',
  PRIMARY KEY  (Id),
  KEY rechazados (rechazados)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'catalogos'
-- 

CREATE TABLE catalogos (
  Id smallint(5) unsigned NOT NULL auto_increment,
  Nombre varchar(60) character set latin1 NOT NULL default '',
  Link varchar(200) character set latin1 NOT NULL default '',
  observaciones text character set latin1 NOT NULL,
  numero smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (Id),
  UNIQUE KEY Nombre (Nombre)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'cola_envios_nt'
-- 

CREATE TABLE cola_envios_nt (
  id int(11) unsigned NOT NULL auto_increment,
  id_envio int(11) unsigned NOT NULL default '0',
  duracion smallint(8) unsigned NOT NULL default '0',
  error_msg varchar(255) character set latin1 NOT NULL default '',
  fecha datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'cola_eventos_nt'
-- 

CREATE TABLE cola_eventos_nt (
  id int(11) unsigned NOT NULL auto_increment,
  id_pedido varchar(20) character set latin1 NOT NULL default '',
  id_instancia_remota varchar(50) character set latin1 NOT NULL default '',
  enviado tinyint(1) unsigned NOT NULL default '0',
  nombre_archivo varchar(100) character set latin1 default NULL,
  fecha_ingreso datetime NOT NULL default '0000-00-00 00:00:00',
  codigo_evento_local tinyint(3) unsigned NOT NULL default '0',
  observaciones varchar(255) character set latin1 NOT NULL default '',
  rol_local varchar(15) character set latin1 NOT NULL default '',
  PRIMARY KEY  (id),
  KEY enviado (enviado)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'dependencias'
-- 

CREATE TABLE dependencias (
  Id smallint(5) unsigned NOT NULL auto_increment,
  Codigo_Institucion smallint(5) unsigned NOT NULL default '0',
  Nombre varchar(100) character set latin1 NOT NULL default '',
  Abreviatura varchar(100) character set latin1 default NULL,
  Direccion varchar(100) character set latin1 default NULL,
  Telefonos varchar(100) character set latin1 default NULL,
  Figura_Portada tinyint(1) unsigned NOT NULL default '0',
  Es_LibLink tinyint(1) unsigned NOT NULL default '0',
  Hipervinculo1 varchar(100) character set latin1 default NULL,
  Hipervinculo2 varchar(100) character set latin1 default NULL,
  Hipervinculo3 varchar(100) character set latin1 default NULL,
  Comentarios text character set latin1,
  esCentralizado tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (Id),
  KEY Codigo_Institucion (Codigo_Institucion)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'downloads'
-- 

CREATE TABLE downloads (
  codigo_download int(11) unsigned NOT NULL auto_increment,
  codigo_archivo mediumint(8) unsigned NOT NULL default '0',
  codigo_usuario smallint(5) unsigned NOT NULL default '0',
  Fecha datetime NOT NULL default '0000-00-00 00:00:00',
  IP_usuario varchar(100) character set latin1 NOT NULL default '',
  download_forzado tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (codigo_download)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'elementos'
-- 

CREATE TABLE elementos (
  Codigo_Pantalla varchar(50) character set latin1 NOT NULL default '',
  Codigo_Elemento varchar(50) character set latin1 NOT NULL default '',
  PRIMARY KEY  (Codigo_Pantalla,Codigo_Elemento)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'evanula'
-- 

CREATE TABLE evanula (
  Id int(11) unsigned NOT NULL auto_increment,
  Id_Pedido varchar(20) character set latin1 NOT NULL default '',
  Codigo_Evento tinyint(3) unsigned NOT NULL default '0',
  Operador smallint(5) unsigned NOT NULL default '0',
  vigente tinyint(1) unsigned NOT NULL default '0',
  Es_Privado tinyint(1) unsigned NOT NULL default '0',
  Fecha datetime NOT NULL default '0000-00-00 00:00:00',
  id_evento_origen int(11) unsigned NOT NULL default '0',
  Id_Correo mediumint(8) unsigned NOT NULL default '0',
  Codigo_Pais smallint(5) unsigned NOT NULL default '0',
  Codigo_Institucion smallint(5) unsigned NOT NULL default '0',
  Codigo_Dependencia smallint(5) unsigned NOT NULL default '0',
  Codigo_Unidad smallint(5) unsigned NOT NULL default '0',
  Id_Instancia_Celsius varchar(30) character set latin1 default NULL,
  destino_remoto tinyint(1) unsigned NOT NULL default '0',
  Id_Pedido_Remoto varchar(100) character set latin1 default NULL,
  Numero_Paginas smallint(5) unsigned NOT NULL default '0',
  Observaciones text character set latin1,
  motivo_anulacion varchar(255) character set latin1 default NULL,
  fecha_anulacion datetime default NULL,
  operador_anulacion smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (Id),
  KEY Codigo_Evento (Codigo_Evento),
  KEY Id_Pedido (Id_Pedido),
  KEY Id_Pedido_2 (Id_Pedido,Codigo_Evento),
  KEY Id_Pedido_3 (Id_Pedido,Codigo_Evento,vigente)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'eventos'
-- 

CREATE TABLE eventos (
  Id int(11) unsigned NOT NULL auto_increment,
  Id_Pedido varchar(20) character set latin1 NOT NULL default '',
  Codigo_Evento tinyint(3) unsigned NOT NULL default '0',
  Operador smallint(5) unsigned NOT NULL default '0',
  vigente tinyint(1) unsigned NOT NULL default '0',
  Es_Privado tinyint(1) unsigned NOT NULL default '0',
  Fecha datetime NOT NULL default '0000-00-00 00:00:00',
  id_evento_origen int(11) unsigned NOT NULL default '0',
  Id_Correo mediumint(8) unsigned NOT NULL default '0',
  Codigo_Pais smallint(5) unsigned NOT NULL default '0',
  Codigo_Institucion smallint(5) unsigned NOT NULL default '0',
  Codigo_Dependencia smallint(5) unsigned NOT NULL default '0',
  Codigo_Unidad smallint(5) unsigned NOT NULL default '0',
  Id_Instancia_Celsius varchar(30) character set latin1 default NULL,
  destino_remoto tinyint(1) unsigned NOT NULL default '0',
  Id_Pedido_Remoto varchar(100) character set latin1 default NULL,
  Numero_Paginas smallint(5) unsigned NOT NULL default '0',
  Observaciones text character set latin1,
  motivo_anulacion varchar(255) character set latin1 default NULL,
  fecha_anulacion datetime default NULL,
  operador_anulacion smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (Id),
  KEY Codigo_Evento (Codigo_Evento),
  KEY Id_Pedido (Id_Pedido),
  KEY Id_Pedido_2 (Id_Pedido,Codigo_Evento),
  KEY Id_Pedido_3 (Id_Pedido,Codigo_Evento,vigente)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'evhist'
-- 

CREATE TABLE evhist (
  Id int(11) unsigned NOT NULL auto_increment,
  Id_Pedido varchar(20) character set latin1 NOT NULL default '',
  Codigo_Evento tinyint(3) unsigned NOT NULL default '0',
  Operador smallint(5) unsigned NOT NULL default '0',
  vigente tinyint(1) unsigned NOT NULL default '0',
  Es_Privado tinyint(1) unsigned NOT NULL default '0',
  Fecha datetime NOT NULL default '0000-00-00 00:00:00',
  id_evento_origen int(11) unsigned NOT NULL default '0',
  Id_Correo mediumint(8) unsigned NOT NULL default '0',
  Codigo_Pais smallint(5) unsigned NOT NULL default '0',
  Codigo_Institucion smallint(5) unsigned NOT NULL default '0',
  Codigo_Dependencia smallint(5) unsigned NOT NULL default '0',
  Codigo_Unidad smallint(5) unsigned NOT NULL default '0',
  Id_Instancia_Celsius varchar(30) character set latin1 default NULL,
  destino_remoto tinyint(1) unsigned NOT NULL default '0',
  Id_Pedido_Remoto varchar(100) character set latin1 default NULL,
  Numero_Paginas smallint(5) unsigned NOT NULL default '0',
  Observaciones text character set latin1,
  motivo_anulacion varchar(255) character set latin1 default NULL,
  fecha_anulacion datetime default NULL,
  operador_anulacion smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (Id),
  KEY Codigo_Evento (Codigo_Evento),
  KEY Id_Pedido (Id_Pedido),
  KEY Id_Pedido_2 (Id_Pedido,Codigo_Evento),
  KEY Id_Pedido_3 (Id_Pedido,Codigo_Evento,vigente)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'existencia'
-- 

CREATE TABLE existencia (
  Id_Titulo_Colecciones mediumint(8) unsigned NOT NULL default '0',
  Id_Catalogo smallint(5) unsigned NOT NULL default '0',
  Descripcion text collate latin1_spanish_ci NOT NULL,
  Operador smallint(5) unsigned default '0',
  Fecha date NOT NULL default '0000-00-00',
  PRIMARY KEY  (Id_Titulo_Colecciones,Id_Catalogo)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'forma_entrega'
-- 

CREATE TABLE forma_entrega (
  id smallint(5) unsigned NOT NULL auto_increment,
  nombre varchar(100) character set latin1 NOT NULL default '',
  recibo tinyint(1) unsigned NOT NULL default '0',
  descripcion text character set latin1 NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'idiomas'
-- 

CREATE TABLE idiomas (
  Id smallint(5) unsigned NOT NULL auto_increment,
  Nombre varchar(30) character set latin1 NOT NULL default '',
  Predeterminado tinyint(1) unsigned NOT NULL default '0',
  0_Dia varchar(20) character set latin1 NOT NULL default '',
  1_Dia varchar(20) character set latin1 NOT NULL default '',
  2_Dia varchar(20) character set latin1 NOT NULL default '',
  3_Dia varchar(20) character set latin1 NOT NULL default '',
  4_Dia varchar(20) character set latin1 NOT NULL default '',
  5_Dia varchar(20) character set latin1 NOT NULL default '',
  6_Dia varchar(20) character set latin1 NOT NULL default '',
  1_Mes varchar(20) character set latin1 NOT NULL default '',
  2_Mes varchar(20) character set latin1 NOT NULL default '',
  3_Mes varchar(20) character set latin1 NOT NULL default '',
  4_Mes varchar(20) character set latin1 NOT NULL default '',
  5_Mes varchar(20) character set latin1 NOT NULL default '',
  6_Mes varchar(20) character set latin1 NOT NULL default '',
  7_Mes varchar(20) character set latin1 NOT NULL default '',
  8_Mes varchar(20) character set latin1 NOT NULL default '',
  9_Mes varchar(20) character set latin1 NOT NULL default '',
  10_Mes varchar(20) character set latin1 NOT NULL default '',
  11_Mes varchar(20) character set latin1 NOT NULL default '',
  12_Mes varchar(20) character set latin1 NOT NULL default '',
  Evento1 varchar(50) character set latin1 NOT NULL default '',
  Evento2 varchar(50) character set latin1 NOT NULL default '',
  Evento3 varchar(50) character set latin1 NOT NULL default '',
  Evento4 varchar(50) character set latin1 NOT NULL default '',
  Evento5 varchar(50) character set latin1 NOT NULL default '',
  Evento6 varchar(50) character set latin1 NOT NULL default '',
  Evento7 varchar(50) character set latin1 NOT NULL default '',
  Evento8 varchar(50) character set latin1 NOT NULL default '',
  Evento9 varchar(50) character set latin1 NOT NULL default '',
  Evento10 varchar(50) character set latin1 NOT NULL default '',
  Evento11 varchar(50) character set latin1 NOT NULL default '',
  Evento12 varchar(50) character set latin1 NOT NULL default '',
  Evento13 varchar(50) character set latin1 NOT NULL default '',
  Evento14 varchar(50) character set latin1 NOT NULL default '',
  Evento15 varchar(50) character set latin1 NOT NULL default '',
  Evento16 varchar(255) character set latin1 NOT NULL default '',
  Evento17 varchar(255) character set latin1 NOT NULL default '',
  Evento18 varchar(50) character set latin1 NOT NULL default '',
  Evento19 varchar(50) character set latin1 NOT NULL default '',
  Estado_1 varchar(50) character set latin1 NOT NULL default '',
  Estado_2 varchar(50) character set latin1 NOT NULL default '',
  Estado_3 varchar(50) character set latin1 NOT NULL default '',
  Estado_4 varchar(50) character set latin1 NOT NULL default '',
  Estado_5 varchar(50) character set latin1 NOT NULL default '',
  Estado_6 varchar(50) character set latin1 NOT NULL default '',
  Estado_7 varchar(50) character set latin1 NOT NULL default '',
  Estado_8 varchar(50) character set latin1 NOT NULL default '',
  Estado_9 varchar(50) character set latin1 NOT NULL default '',
  Estado_10 varchar(50) character set latin1 NOT NULL default '',
  Estado_11 varchar(50) character set latin1 NOT NULL default '',
  Estado_12 varchar(30) character set latin1 NOT NULL default '',
  Estado_13 varchar(100) character set latin1 NOT NULL default '',
  Estado_14 varchar(40) character set latin1 NOT NULL default '',
  Estado_15 varchar(40) collate latin1_spanish_ci NOT NULL default '',
  Estado_16 varchar(40) collate latin1_spanish_ci NOT NULL default '',
  Estado_17 varchar(40) collate latin1_spanish_ci NOT NULL default '',
  Tipo_Material_1 varchar(30) character set latin1 NOT NULL default '',
  Tipo_Material_2 varchar(30) character set latin1 NOT NULL default '',
  Tipo_Material_3 varchar(30) character set latin1 NOT NULL default '',
  Tipo_Material_4 varchar(30) character set latin1 NOT NULL default '',
  Tipo_Material_5 varchar(30) character set latin1 NOT NULL default '',
  Perfil_Biblio_1 varchar(40) character set latin1 NOT NULL default '',
  Perfil_Biblio_2 varchar(40) character set latin1 NOT NULL default '',
  Perfil_Biblio_3 varchar(40) character set latin1 NOT NULL default '',
  Tipo_Pedido_1 varchar(40) character set latin1 NOT NULL default '',
  Tipo_Pedido_2 varchar(40) character set latin1 NOT NULL default '',
  Eventos_Mail_1 varchar(30) character set latin1 default NULL,
  Eventos_Mail_2 varchar(30) character set latin1 default NULL,
  Eventos_Mail_3 varchar(30) character set latin1 default NULL,
  PRIMARY KEY  (Id),
  UNIQUE KEY Nombre (Nombre)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'instancias_celsius'
-- 

CREATE TABLE instancias_celsius (
  id varchar(30) character set latin1 collate latin1_general_ci NOT NULL default '',
  email varchar(50) character set latin1 NOT NULL default '',
  version varchar(10) character set latin1 collate latin1_general_ci NOT NULL default '',
  sitio_web varchar(255) character set latin1 collate latin1_general_ci NOT NULL default '',
  nt_habilitado tinyint(1) unsigned NOT NULL default '0',
  id_institucion smallint(5) unsigned NOT NULL default '0',
  id_dependencia smallint(5) unsigned default NULL,
  id_unidad smallint(5) unsigned default NULL,
  `password` varchar(50) character set latin1 collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (id),
  KEY id_institucion (id_institucion),
  KEY id_dependencia (id_dependencia),
  KEY id_unidad (id_unidad)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'instituciones'
-- 

CREATE TABLE instituciones (
  Codigo smallint(5) unsigned NOT NULL auto_increment,
  Nombre varchar(100) character set latin1 NOT NULL default '',
  Abreviatura varchar(8) character set latin1 NOT NULL default '',
  Direccion varchar(100) character set latin1 default NULL,
  Codigo_Pais smallint(5) unsigned NOT NULL default '0',
  Codigo_Localidad smallint(5) unsigned NOT NULL default '0',
  Participa_Proyecto tinyint(1) unsigned NOT NULL default '0',
  Telefono varchar(100) character set latin1 default NULL,
  Sitio_Web varchar(100) character set latin1 default NULL,
  Comentarios text character set latin1,
  Codigo_Pedidos smallint(5) unsigned NOT NULL default '0',
  tipo_pedido_nuevo tinyint(2) unsigned NOT NULL default '0',
  esCentralizado tinyint(2) unsigned NOT NULL default '0',
  habilitado_crear_pedidos tinyint(1) unsigned NOT NULL default '1',
  habilitado_crear_usuarios int(11) NOT NULL default '1',
  PRIMARY KEY  (Codigo),
  KEY Pais (Codigo_Pais)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'localidades'
-- 

CREATE TABLE localidades (
  Id smallint(5) unsigned NOT NULL auto_increment,
  Codigo_Pais smallint(5) unsigned NOT NULL default '0',
  Nombre varchar(100) character set latin1 NOT NULL default '',
  PRIMARY KEY  (Id),
  KEY Pais (Codigo_Pais)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'log'
-- 

CREATE TABLE log (
  id smallint(5) unsigned NOT NULL auto_increment,
  idOperador smallint(5) unsigned NOT NULL default '0',
  fecha datetime NOT NULL default '0000-00-00 00:00:00',
  tipoEvento varchar(30) character set latin1 NOT NULL default '',
  idViejo smallint(5) unsigned NOT NULL default '0',
  idNuevo smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'mail'
-- 

CREATE TABLE mail (
  Id mediumint(8) unsigned NOT NULL auto_increment,
  Codigo_Usuario smallint(5) unsigned NOT NULL default '0',
  Id_Candidato smallint(5) unsigned NOT NULL default '0',
  Codigo_Usuario_From smallint(5) unsigned NOT NULL default '0',
  Codigo_Pedido varchar(20) character set latin1 NOT NULL default '',
  Fecha date NOT NULL default '0000-00-00',
  Hora time NOT NULL default '00:00:00',
  Direccion varchar(100) character set latin1 NOT NULL default '',
  Asunto varchar(100) character set latin1 NOT NULL default '',
  Texto text character set latin1 NOT NULL,
  PRIMARY KEY  (Id),
  KEY Usuario (Codigo_Usuario)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'mensajes_usuarios'
-- 

CREATE TABLE mensajes_usuarios (
  id mediumint(8) unsigned NOT NULL auto_increment,
  idUsuario smallint(5) unsigned NOT NULL default '0',
  idUsuarioFrom smallint(5) unsigned NOT NULL default '0',
  fecha_creado datetime NOT NULL default '0000-00-00 00:00:00',
  fecha_leido datetime NOT NULL default '0000-00-00 00:00:00',
  texto text character set latin1 NOT NULL,
  leido tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (id),
  KEY idUsuario (idUsuario)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'noticias'
-- 

CREATE TABLE noticias (
  Id smallint(5) unsigned NOT NULL auto_increment,
  Codigo_Idioma smallint(5) unsigned NOT NULL default '0',
  Fecha datetime NOT NULL default '0000-00-00 00:00:00',
  Titulo varchar(255) character set latin1 NOT NULL default '',
  Texto_Noticia text character set latin1 NOT NULL,
  mostrar_noticia tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (Id),
  KEY Codigo_Idioma (Codigo_Idioma)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'paises'
-- 

CREATE TABLE paises (
  Id smallint(5) unsigned NOT NULL auto_increment,
  Nombre varchar(100) character set latin1 NOT NULL default '',
  Abreviatura varchar(4) character set latin1 NOT NULL default '',
  permite_revista tinyint(1) unsigned NOT NULL default '0',
  permite_libro tinyint(1) unsigned NOT NULL default '0',
  permite_tesis tinyint(1) unsigned NOT NULL default '0',
  permite_patente tinyint(1) unsigned NOT NULL default '0',
  permite_congreso tinyint(1) unsigned NOT NULL default '0',
  esCentralizado tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (Id),
  UNIQUE KEY Nombre (Nombre,esCentralizado)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'pantalla'
-- 

CREATE TABLE pantalla (
  Id varchar(50) character set latin1 NOT NULL default '',
  PRIMARY KEY  (Id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'parametros'
-- 

CREATE TABLE parametros (
  id enum('1') character set latin1 NOT NULL default '1',
  directorio_upload varchar(255) character set latin1 NOT NULL default '',
  directorio_temporal varchar(255) character set latin1 NOT NULL default '',
  ult_actualizacion_directorio datetime NOT NULL default '0000-00-00 00:00:00',
  password_directorio varchar(30) character set latin1 collate latin1_general_ci NOT NULL default '',
  url_directorio varchar(100) character set latin1 collate latin1_general_ci NOT NULL default '',
  id_celsius_local varchar(30) character set latin1 collate latin1_general_ci NOT NULL default '',
  id_pais smallint(5) unsigned NOT NULL default '0',
  id_institucion smallint(5) unsigned NOT NULL default '0',
  id_dependencia smallint(5) unsigned NOT NULL default '0',
  id_unidad smallint(5) unsigned NOT NULL default '0',
  mail_contacto varchar(255) character set latin1 NOT NULL default '',
  titulo_sitio varchar(255) character set latin1 NOT NULL default '',
  nt_enabled tinyint(1) unsigned NOT NULL default '0',
  url_completa varchar(255) character set latin1 NOT NULL default '',
  texto text collate latin1_spanish_ci NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'pedanula'
-- 

CREATE TABLE pedanula (
  Id varchar(20) character set latin1 NOT NULL default '',
  Tipo_Pedido tinyint(1) unsigned NOT NULL default '0',
  Tipo_Material tinyint(3) unsigned NOT NULL default '0',
  Estado tinyint(3) unsigned NOT NULL default '0',
  Codigo_Usuario smallint(5) unsigned NOT NULL default '0',
  Tipo_Usuario_Crea tinyint(3) unsigned NOT NULL default '0',
  Usuario_Creador smallint(5) unsigned NOT NULL default '0',
  isbn_issn varchar(50) character set latin1 default NULL,
  Titulo_Libro varchar(100) character set latin1 default NULL,
  Autor_Libro varchar(100) character set latin1 default NULL,
  Editor_Libro varchar(100) character set latin1 default NULL,
  Desea_Indice tinyint(1) unsigned NOT NULL default '0',
  Capitulo_Libro varchar(100) character set latin1 default NULL,
  Anio_Libro varchar(30) character set latin1 default NULL,
  Numero_Patente varchar(30) character set latin1 default NULL,
  Codigo_Pais_Patente smallint(5) unsigned NOT NULL default '0',
  Pais_Patente varchar(100) character set latin1 default NULL,
  Anio_Patente varchar(30) character set latin1 default NULL,
  Autor_Detalle1 varchar(100) character set latin1 default NULL,
  Autor_Detalle2 varchar(100) character set latin1 default NULL,
  Autor_Detalle3 varchar(100) character set latin1 default NULL,
  Codigo_Titulo_Revista mediumint(8) unsigned NOT NULL default '0',
  Titulo_Revista varchar(100) character set latin1 default NULL,
  Titulo_Articulo varchar(100) character set latin1 default NULL,
  Volumen_Revista varchar(8) character set latin1 default NULL,
  Numero_Revista varchar(8) character set latin1 default NULL,
  Anio_Revista varchar(4) character set latin1 default NULL,
  Pagina_Desde varchar(10) character set latin1 default NULL,
  Pagina_Hasta varchar(10) character set latin1 default NULL,
  TituloCongreso varchar(100) character set latin1 default NULL,
  Organizador varchar(100) character set latin1 default NULL,
  NumeroLugar varchar(100) character set latin1 default NULL,
  Anio_Congreso varchar(4) character set latin1 default NULL,
  PaginaCapitulo varchar(50) character set latin1 default NULL,
  PonenciaActa varchar(100) character set latin1 default NULL,
  Codigo_Pais_Congreso smallint(5) unsigned NOT NULL default '0',
  Otro_Pais_Congreso varchar(100) character set latin1 default NULL,
  TituloTesis varchar(100) character set latin1 default NULL,
  AutorTesis varchar(100) character set latin1 default NULL,
  DirectorTesis varchar(100) character set latin1 default NULL,
  GradoAccede varchar(50) character set latin1 default NULL,
  Codigo_Pais_Tesis smallint(5) unsigned NOT NULL default '0',
  Otro_Pais_Tesis varchar(100) character set latin1 default NULL,
  Codigo_Institucion_Tesis smallint(5) unsigned NOT NULL default '0',
  Otra_Institucion_Tesis varchar(100) character set latin1 default NULL,
  Codigo_Dependencia_Tesis smallint(5) unsigned NOT NULL default '0',
  Otra_Dependencia_Tesis varchar(100) character set latin1 default NULL,
  Anio_Tesis varchar(30) character set latin1 default NULL,
  PagCapitulo varchar(60) character set latin1 default NULL,
  Fecha_Alta_Pedido date default NULL,
  Fecha_Inicio_Busqueda date default NULL,
  Fecha_Solicitado date default NULL,
  Fecha_Recepcion date default NULL,
  Fecha_Entrega date default NULL,
  Tardanza_Atencion smallint(5) unsigned NOT NULL default '0',
  Tardanza_Busqueda smallint(5) unsigned NOT NULL default '0',
  Tardanza_Recepcion smallint(5) unsigned NOT NULL default '0',
  Biblioteca_Sugerida varchar(100) character set latin1 default NULL,
  Observaciones text character set latin1,
  Operador_Corriente smallint(5) unsigned NOT NULL default '0',
  Ultimo_Pais_Solicitado smallint(5) unsigned NOT NULL default '0',
  Ultima_Institucion_Solicitado smallint(5) unsigned NOT NULL default '0',
  Ultima_Dependencia_Solicitado smallint(5) unsigned NOT NULL default '0',
  Ultima_Unidad_Solicitado smallint(5) unsigned NOT NULL default '0',
  Numero_Paginas smallint(5) unsigned NOT NULL default '0',
  Observado tinyint(1) unsigned NOT NULL default '0',
  origen_remoto tinyint(1) unsigned NOT NULL default '0',
  id_instancia_origen varchar(40) character set latin1 default NULL,
  Archivos_Totales tinyint(3) unsigned NOT NULL default '0',
  Archivos_Bajados tinyint(3) unsigned NOT NULL default '0',
  En_Busqueda tinyint(1) unsigned NOT NULL default '0',
  Fecha_Anulacion date default NULL,
  Causa_Anulacion text character set latin1,
  Operador_Anula smallint(5) unsigned default NULL,
  PRIMARY KEY  (Id),
  KEY EstadoPedido (Estado),
  KEY Usuario (Codigo_Usuario)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'pedhist'
-- 

CREATE TABLE pedhist (
  Id varchar(20) character set latin1 NOT NULL default '',
  Tipo_Pedido tinyint(1) unsigned NOT NULL default '0',
  Tipo_Material tinyint(3) unsigned NOT NULL default '0',
  Estado tinyint(3) unsigned NOT NULL default '0',
  Codigo_Usuario smallint(5) unsigned NOT NULL default '0',
  Tipo_Usuario_Crea tinyint(3) unsigned NOT NULL default '0',
  Usuario_Creador smallint(5) unsigned NOT NULL default '0',
  isbn_issn varchar(50) character set latin1 default NULL,
  Titulo_Libro varchar(100) character set latin1 default NULL,
  Autor_Libro varchar(100) character set latin1 default NULL,
  Editor_Libro varchar(100) character set latin1 default NULL,
  Desea_Indice tinyint(1) unsigned NOT NULL default '0',
  Capitulo_Libro varchar(100) character set latin1 default NULL,
  Anio_Libro varchar(4) character set latin1 default NULL,
  Numero_Patente varchar(30) character set latin1 default NULL,
  Codigo_Pais_Patente smallint(5) unsigned NOT NULL default '0',
  Pais_Patente varchar(100) character set latin1 default NULL,
  Anio_Patente varchar(4) character set latin1 default NULL,
  Autor_Detalle1 varchar(100) character set latin1 default NULL,
  Autor_Detalle2 varchar(100) character set latin1 default NULL,
  Autor_Detalle3 varchar(100) character set latin1 default NULL,
  Codigo_Titulo_Revista mediumint(8) unsigned NOT NULL default '0',
  Titulo_Revista varchar(100) character set latin1 default NULL,
  Titulo_Articulo varchar(100) character set latin1 default NULL,
  Volumen_Revista varchar(8) character set latin1 default NULL,
  Numero_Revista varchar(8) character set latin1 default NULL,
  Anio_Revista varchar(4) character set latin1 default NULL,
  Pagina_Desde varchar(10) character set latin1 default NULL,
  Pagina_Hasta varchar(10) character set latin1 default NULL,
  TituloCongreso varchar(100) character set latin1 default NULL,
  Organizador varchar(100) character set latin1 default NULL,
  NumeroLugar varchar(100) character set latin1 default NULL,
  Anio_Congreso varchar(4) character set latin1 default NULL,
  PaginaCapitulo varchar(50) character set latin1 default NULL,
  PonenciaActa varchar(100) character set latin1 default NULL,
  Codigo_Pais_Congreso smallint(5) unsigned NOT NULL default '0',
  Otro_Pais_Congreso varchar(100) character set latin1 default NULL,
  TituloTesis varchar(100) character set latin1 default NULL,
  AutorTesis varchar(100) character set latin1 default NULL,
  DirectorTesis varchar(100) character set latin1 default NULL,
  GradoAccede varchar(50) character set latin1 default NULL,
  Codigo_Pais_Tesis smallint(5) unsigned NOT NULL default '0',
  Otro_Pais_Tesis varchar(100) character set latin1 default NULL,
  Codigo_Institucion_Tesis smallint(5) unsigned NOT NULL default '0',
  Otra_Institucion_Tesis varchar(100) character set latin1 default NULL,
  Codigo_Dependencia_Tesis smallint(5) unsigned NOT NULL default '0',
  Otra_Dependencia_Tesis varchar(100) character set latin1 default NULL,
  Anio_Tesis varchar(4) character set latin1 default NULL,
  PagCapitulo varchar(60) character set latin1 default NULL,
  Fecha_Alta_Pedido date default NULL,
  Fecha_Inicio_Busqueda date default NULL,
  Fecha_Solicitado date default NULL,
  Fecha_Recepcion date default NULL,
  Fecha_Entrega date default NULL,
  Tardanza_Atencion smallint(5) unsigned NOT NULL default '0',
  Tardanza_Busqueda smallint(5) unsigned NOT NULL default '0',
  Tardanza_Recepcion smallint(5) unsigned NOT NULL default '0',
  Biblioteca_Sugerida varchar(100) character set latin1 default NULL,
  Observaciones text character set latin1,
  Operador_Corriente smallint(5) unsigned NOT NULL default '0',
  Ultimo_Pais_Solicitado smallint(5) unsigned NOT NULL default '0',
  Ultima_Institucion_Solicitado smallint(5) unsigned NOT NULL default '0',
  Ultima_Dependencia_Solicitado smallint(5) unsigned NOT NULL default '0',
  Ultima_Unidad_Solicitado smallint(5) unsigned NOT NULL default '0',
  Numero_Paginas smallint(5) unsigned NOT NULL default '0',
  Observado tinyint(1) unsigned NOT NULL default '0',
  origen_remoto tinyint(1) unsigned NOT NULL default '0',
  id_instancia_origen varchar(40) character set latin1 default NULL,
  Archivos_Totales tinyint(3) unsigned NOT NULL default '0',
  Archivos_Bajados tinyint(3) unsigned NOT NULL default '0',
  En_Busqueda tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (Id),
  KEY EstadoPedido (Estado),
  KEY Usuario (Codigo_Usuario)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'pedidos'
-- 

CREATE TABLE pedidos (
  Id varchar(20) character set latin1 NOT NULL default '',
  Tipo_Pedido tinyint(1) unsigned NOT NULL default '0',
  Tipo_Material tinyint(3) unsigned NOT NULL default '0',
  Estado tinyint(3) unsigned NOT NULL default '0',
  Codigo_Usuario smallint(5) unsigned NOT NULL default '0',
  Tipo_Usuario_Crea tinyint(3) unsigned NOT NULL default '0',
  Usuario_Creador smallint(5) unsigned NOT NULL default '0',
  isbn_issn varchar(50) character set latin1 default NULL,
  Titulo_Libro varchar(100) character set latin1 default NULL,
  Autor_Libro varchar(100) character set latin1 default NULL,
  Editor_Libro varchar(100) character set latin1 default NULL,
  Desea_Indice tinyint(1) unsigned NOT NULL default '0',
  Capitulo_Libro varchar(100) character set latin1 default NULL,
  Anio_Libro varchar(30) character set latin1 default NULL,
  Numero_Patente varchar(30) character set latin1 default NULL,
  Codigo_Pais_Patente smallint(5) unsigned NOT NULL default '0',
  Pais_Patente varchar(100) character set latin1 default NULL,
  Anio_Patente varchar(30) character set latin1 default NULL,
  Autor_Detalle1 varchar(100) character set latin1 default NULL,
  Autor_Detalle2 varchar(100) character set latin1 default NULL,
  Autor_Detalle3 varchar(100) character set latin1 default NULL,
  Codigo_Titulo_Revista mediumint(8) unsigned NOT NULL default '0',
  Titulo_Revista varchar(100) character set latin1 default NULL,
  Titulo_Articulo varchar(100) character set latin1 default NULL,
  Volumen_Revista varchar(8) character set latin1 default NULL,
  Numero_Revista varchar(8) character set latin1 default NULL,
  Anio_Revista varchar(30) character set latin1 default NULL,
  Pagina_Desde varchar(10) character set latin1 default NULL,
  Pagina_Hasta varchar(10) character set latin1 default NULL,
  TituloCongreso varchar(100) character set latin1 default NULL,
  Organizador varchar(100) character set latin1 default NULL,
  NumeroLugar varchar(100) character set latin1 default NULL,
  Anio_Congreso varchar(30) character set latin1 default NULL,
  PaginaCapitulo varchar(50) character set latin1 default NULL,
  PonenciaActa varchar(100) character set latin1 default NULL,
  Codigo_Pais_Congreso smallint(5) unsigned NOT NULL default '0',
  Otro_Pais_Congreso varchar(100) character set latin1 default NULL,
  TituloTesis varchar(100) character set latin1 default NULL,
  AutorTesis varchar(100) character set latin1 default NULL,
  DirectorTesis varchar(100) character set latin1 default NULL,
  GradoAccede varchar(50) character set latin1 default NULL,
  Codigo_Pais_Tesis smallint(5) unsigned NOT NULL default '0',
  Otro_Pais_Tesis varchar(100) character set latin1 default NULL,
  Codigo_Institucion_Tesis smallint(5) unsigned NOT NULL default '0',
  Otra_Institucion_Tesis varchar(100) character set latin1 default NULL,
  Codigo_Dependencia_Tesis smallint(5) unsigned NOT NULL default '0',
  Otra_Dependencia_Tesis varchar(100) character set latin1 default NULL,
  Anio_Tesis varchar(30) character set latin1 default NULL,
  PagCapitulo varchar(60) character set latin1 default NULL,
  Fecha_Alta_Pedido date default NULL,
  Fecha_Inicio_Busqueda date default NULL,
  Fecha_Solicitado date default NULL,
  Fecha_Recepcion date default NULL,
  Fecha_Entrega date default NULL,
  Tardanza_Atencion smallint(5) unsigned NOT NULL default '0',
  Tardanza_Busqueda smallint(5) unsigned NOT NULL default '0',
  Tardanza_Recepcion smallint(5) unsigned NOT NULL default '0',
  Biblioteca_Sugerida varchar(100) character set latin1 default NULL,
  Observaciones text character set latin1,
  Operador_Corriente smallint(5) unsigned NOT NULL default '0',
  Ultimo_Pais_Solicitado smallint(5) unsigned NOT NULL default '0',
  Ultima_Institucion_Solicitado smallint(5) unsigned NOT NULL default '0',
  Ultima_Dependencia_Solicitado smallint(5) unsigned NOT NULL default '0',
  Ultima_Unidad_Solicitado smallint(5) unsigned NOT NULL default '0',
  Numero_Paginas smallint(5) unsigned NOT NULL default '0',
  Observado tinyint(1) unsigned NOT NULL default '0',
  origen_remoto tinyint(1) unsigned NOT NULL default '0',
  id_instancia_origen varchar(40) character set latin1 default NULL,
  Archivos_Totales tinyint(3) unsigned NOT NULL default '0',
  Archivos_Bajados tinyint(3) unsigned NOT NULL default '0',
  En_Busqueda tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (Id),
  KEY EstadoPedido (Estado),
  KEY Usuario (Codigo_Usuario),
  KEY Operador_Corriente (Operador_Corriente),
  KEY origen_remoto (origen_remoto),
  KEY En_Busqueda (En_Busqueda)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'plantmail'
-- 

CREATE TABLE plantmail (
  Id smallint(5) unsigned NOT NULL auto_increment,
  Denominacion varchar(100) character set latin1 default NULL,
  Cuando_Usa smallint(5) unsigned default NULL,
  Texto text character set latin1,
  PRIMARY KEY  (Id),
  KEY Cuando_Usa (Cuando_Usa)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'sugerencias'
-- 

CREATE TABLE sugerencias (
  Id smallint(5) unsigned NOT NULL auto_increment,
  Titulo varchar(100) character set latin1 NOT NULL default '',
  Comentario text character set latin1,
  PRIMARY KEY  (Id)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'tab_categ_usuarios'
-- 

CREATE TABLE tab_categ_usuarios (
  Id smallint(5) unsigned NOT NULL auto_increment,
  Nombre char(100) character set latin1 NOT NULL default '',
  PRIMARY KEY  (Id),
  UNIQUE KEY Nombre (Nombre)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'titulos_colecciones'
-- 

CREATE TABLE titulos_colecciones (
  Id mediumint(8) unsigned NOT NULL auto_increment,
  Nombre varchar(220) character set latin1 collate latin1_general_ci NOT NULL default '',
  Abreviado varchar(60) character set latin1 NOT NULL default '',
  ISSN varchar(15) character set latin1 NOT NULL default '0',
  Responsable varchar(100) character set latin1 NOT NULL default '',
  Volumenes text character set latin1,
  Frecuencia varchar(100) character set latin1 NOT NULL default '',
  PRIMARY KEY  (Id),
  UNIQUE KEY Nombre (Nombre)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'traducciones'
-- 

CREATE TABLE traducciones (
  Codigo_Pantalla varchar(50) character set latin1 NOT NULL default '',
  Codigo_Elemento varchar(50) character set latin1 NOT NULL default '',
  Codigo_Idioma int(11) NOT NULL default '0',
  Texto text character set latin1,
  traduccion_completa tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (Codigo_Pantalla,Codigo_Elemento,Codigo_Idioma)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'unidades'
-- 

CREATE TABLE unidades (
  Id smallint(5) unsigned NOT NULL auto_increment,
  Codigo_Institucion smallint(5) unsigned NOT NULL default '0',
  Codigo_Dependencia smallint(5) unsigned NOT NULL default '0',
  Nombre varchar(100) character set latin1 NOT NULL default '',
  Direccion varchar(100) character set latin1 default NULL,
  Telefonos varchar(100) character set latin1 default NULL,
  Figura_Portada tinyint(1) unsigned NOT NULL default '0',
  Hipervinculo1 varchar(100) character set latin1 default NULL,
  Hipervinculo2 varchar(100) character set latin1 default NULL,
  Hipervinculo3 varchar(100) character set latin1 default NULL,
  Comentarios text character set latin1,
  esCentralizado tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (Id),
  KEY Institucion (Codigo_Institucion),
  KEY Dependencia (Codigo_Dependencia)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla 'usuarios'
-- 

CREATE TABLE usuarios (
  Id smallint(5) unsigned NOT NULL auto_increment,
  Apellido varchar(60) character set latin1 NOT NULL default '',
  Nombres varchar(100) character set latin1 NOT NULL default '',
  EMail varchar(100) character set latin1 default NULL,
  Codigo_Institucion smallint(5) unsigned NOT NULL default '0',
  Codigo_Dependencia smallint(5) unsigned NOT NULL default '0',
  Codigo_Unidad smallint(5) unsigned NOT NULL default '0',
  Direccion varchar(100) character set latin1 default NULL,
  Codigo_Pais smallint(5) unsigned NOT NULL default '0',
  Codigo_Localidad smallint(5) unsigned NOT NULL default '0',
  Codigo_Categoria smallint(5) unsigned NOT NULL default '0',
  Telefonos varchar(100) character set latin1 default NULL,
  Fecha_Solicitud date default NULL,
  Fecha_Alta date default NULL,
  Codigo_UsuarioAprueba smallint(5) unsigned NOT NULL default '0',
  Comentarios text character set latin1,
  Login varchar(100) character set latin1 NOT NULL default '',
  `Password` varchar(8) character set latin1 NOT NULL default '',
  Codigo_FormaEntrega smallint(5) unsigned NOT NULL default '0',
  Personal tinyint(1) unsigned NOT NULL default '0',
  Bibliotecario tinyint(2) unsigned NOT NULL default '0',
  Staff tinyint(1) unsigned NOT NULL default '0',
  Orden_Staff tinyint(3) unsigned NOT NULL default '0',
  Cargo varchar(100) character set latin1 default NULL,
  Delay_Atencion smallint(5) unsigned default NULL,
  bibliotecario_permite_download tinyint(5) NOT NULL default '0',
  habilitar_entrega_pedido tinyint(4) default 0 NOT NULL , 
  PRIMARY KEY  (Id),
  UNIQUE KEY Login (Login),
  KEY ApellidoNombre (Apellido,Nombres),
  KEY Codigo_Unidad (Codigo_Unidad)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

COMMIT;