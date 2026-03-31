delimiter $$

CREATE TABLE `cl_evaluacion` (
  `idcl_evaluacion` int(11) NOT NULL auto_increment,
  `idcl_opcion_evaluacion` int(11) NOT NULL,
  `clicks` int(11) NOT NULL default '0',
  `idcl_servicio` int(11) default NULL,
  `fecha_evaluacion` date default NULL,
  PRIMARY KEY  (`idcl_evaluacion`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci$$


delimiter $$

CREATE TABLE `cl_observacion` (
  `idcl_observacion` int(11) NOT NULL auto_increment,
  `observacion` text,
  `identificacion` varchar(45) default NULL,
  `mail` varchar(200) default NULL,
  `nombre` varchar(128) default NULL,
  `telefono` varchar(45) default NULL,
  `idcl_evaluacion` int(11) default NULL,
  PRIMARY KEY  (`idcl_observacion`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1$$


delimiter $$

CREATE TABLE `cl_opcion_evaluacion` (
  `idcl_opcion_evaluacion` int(11) NOT NULL auto_increment,
  `opcion` varchar(45) default NULL,
  `image` varchar(45) default NULL,
  `peso` int(11) default NULL,
  PRIMARY KEY  (`idcl_opcion_evaluacion`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1$$


delimiter $$

CREATE TABLE `cl_servicio` (
  `idcl_servicio` int(11) NOT NULL auto_increment,
  `nombre` varchar(45) default NULL,
  PRIMARY KEY  (`idcl_servicio`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1$$

delimiter $$
INSERT INTO `sala`.`cl_opcion_evaluacion` (`opcion`, `image`, `peso`) VALUES 
('Exelente', 'images/imagen1.png', 5),
('Bueno', 'images/imagen2.png', 4),
('Regular', 'images/imagen3.png', 3),
('Deficiente', 'images/imagen4.png', 1);

