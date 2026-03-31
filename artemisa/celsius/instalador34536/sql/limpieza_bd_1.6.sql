--
-- ESTE SCRIPT REALIZA UNA LIMPIEZA DE LA BDD, ELIMINANDO TODOS LOS REGISTROS CON INFORMACION INUTIL.
--

DROP TABLE IF EXISTS `ayuda`;
DROP TABLE IF EXISTS `campos`;
DROP TABLE IF EXISTS `cuentas_corrientes`;
DROP TABLE IF EXISTS `autorizaciones`;
DROP TABLE IF EXISTS `archivos_instalador`; 
DROP TABLE IF EXISTS `bindings`;
DROP TABLE IF EXISTS `downloads_instalador`; 
DROP TABLE IF EXISTS `elemcontenidos`;
DROP TABLE IF EXISTS `secciones`;
DROP TABLE IF EXISTS `contenidos`;
DROP TABLE IF EXISTS `idiomas_instalador`; 
DROP TABLE IF EXISTS `log_instalador`;
DROP TABLE IF EXISTS `movimientos`;
DROP TABLE IF EXISTS `traducciones_instalador`;
DROP TABLE IF EXISTS `usuarios_instalador`;
DROP TABLE IF EXISTS `mail_bibliotecas`;
DROP TABLE IF EXISTS `recibos`;
DROP TABLE IF EXISTS `detalle_recibo`; 

DELETE FROM `archivos_pedidos` WHERE nombre_archivo="" OR isNull(nombre_archivo)OR codigo_pedido="" OR isNull(codigo_pedido);
DELETE FROM `busquedas` WHERE Id_Catalogo=0 OR Id_Usuario=0 OR isNull(Id_Pedido) OR Id_Pedido="" ;
DELETE FROM `catalogos` WHERE isNull(Nombre) OR Nombre="" ;
DELETE FROM `downloads` WHERE codigo_archivo=0 OR codigo_usuario=0;
DELETE FROM `elementos` WHERE isNull(Codigo_Pantalla) OR Codigo_Pantalla="" OR isNull(Codigo_Elemento) OR Codigo_Elemento="" ;
DELETE FROM `localidades` WHERE Codigo_Pais=0 OR isNull(Nombre) OR Nombre="" ;
DELETE FROM `mail` WHERE isNull(Direccion) OR Direccion="" ;
DELETE FROM `mensajes_usuarios` WHERE idUsuario=0;
DELETE FROM `noticias` WHERE Codigo_Idioma=0;
DELETE FROM `pantalla` WHERE isNull(Id) OR Id="";
DELETE FROM `plantmail` WHERE isNull(Denominacion) OR Denominacion="";
DELETE FROM `tab_categ_usuarios` WHERE isNull(Nombre) OR Nombre="";
DELETE FROM `titulos_colecciones` WHERE isNull(Nombre) OR Nombre="";

--PIDU
DELETE FROM `paises` WHERE isNull(Nombre) OR Nombre = "" ;
DELETE i FROM `instituciones` AS i LEFT JOIN paises AS p ON p.Id = i.Codigo_Pais WHERE isNull(p.Id) OR isNull(i.Nombre) OR i.Nombre = "" ;
DELETE d FROM `dependencias` AS d LEFT JOIN `instituciones` AS i ON i.Codigo = d.Codigo_Institucion WHERE isNull(i.Codigo) OR isNull(d.Nombre) OR d.Nombre = "" ;
DELETE u FROM `unidades` AS u LEFT JOIN `instituciones` AS i ON i.Codigo = u.Codigo_Institucion LEFT JOIN `dependencias` AS d ON d.Id = u.Codigo_Dependencia WHERE isNull(i.Codigo) OR isNull(d.Id) OR isNull(u.Nombre) OR u.Nombre = "";

--Deshabilita las instituciones sin abreviatura para evitar conflictos en el Id pedido
UPDATE `instituciones` SET habilitado_crear_pedidos = 0,habilitado_crear_usuarios = 0 WHERE isNull( Abreviatura ) OR TRIM( Abreviatura ) = "";
UPDATE `instituciones` SET tipo_pedido_nuevo = 2 WHERE tipo_pedido_nuevo = 0;

--Deshabilita las instituciones que son del mismo pais y que tienen la misma abreviatura
CREATE TABLE instituciones_aux SELECT Codigo_Pais, Abreviatura, count( * ) AS c FROM instituciones GROUP BY Codigo_Pais, Abreviatura HAVING c >1;
UPDATE instituciones AS i SET i.habilitado_crear_pedidos =0 WHERE (i.Codigo_Pais,i.Abreviatura) IN (SELECT p.Codigo_Pais, p.Abreviatura FROM instituciones_aux AS p);
DROP TABLE instituciones_aux;

--PEDIDOS
DELETE FROM `eventos` WHERE isNull(Id_Pedido) OR Id_Pedido="" OR Codigo_Evento=0;
DELETE FROM `evhist` WHERE isNull(Id_Pedido) OR Id_Pedido="" OR Codigo_Evento=0;
DELETE FROM `evanula` WHERE isNull(Id_Pedido) OR Id_Pedido="" OR Codigo_Evento=0;

DELETE FROM `pedidos` WHERE isNull(Id) OR Id="" OR Tipo_Pedido=0 OR Tipo_Material=0 OR Estado=0 OR Codigo_Usuario=0;
DELETE FROM `pedanula` WHERE isNull(Id) OR Id="" OR Tipo_Pedido=0 OR Tipo_Material=0 OR Estado=0 OR Codigo_Usuario=0;
DELETE FROM `pedhist` WHERE isNull(Id) OR Id="" OR Tipo_Pedido=0 OR Tipo_Material=0 OR Estado=0 OR Codigo_Usuario=0;

--Usuarios (Borra los usuarios sin institucion y resetea en 0 los campos de dependencias de los usuarios
DELETE u FROM `usuarios` AS u LEFT JOIN instituciones AS i ON u.Codigo_Institucion = i.Codigo WHERE isNull(i.Codigo);
UPDATE `usuarios` AS u LEFT JOIN dependencias AS d ON u.Codigo_Dependencia = d.Id SET u.Codigo_Dependencia = 0 WHERE isNull(d.Id);

--paso los eventos a las tablas q correponden. No saco los evento de evanula, eso lo hace despues el instalador
INSERT INTO evhist (Id_Pedido, Codigo_Evento, Operador, vigente, Es_Privado, Fecha, id_evento_origen, Id_Correo, Codigo_Pais, Codigo_Institucion, Codigo_Dependencia, Codigo_Unidad, Id_Instancia_Celsius, destino_remoto, Id_Pedido_Remoto, Numero_Paginas, Observaciones, motivo_anulacion, fecha_anulacion, operador_anulacion) SELECT E.Id_Pedido, E.Codigo_Evento, E.Operador, E.vigente, E.Es_Privado, E.Fecha, E.id_evento_origen, E.Id_Correo, E.Codigo_Pais, E.Codigo_Institucion, E.Codigo_Dependencia, E.Codigo_Unidad, E.Id_Instancia_Celsius, E.destino_remoto, E.Id_Pedido_Remoto, E.Numero_Paginas, E.Observaciones, E.motivo_anulacion, E.fecha_anulacion, E.operador_anulacion FROM eventos as E INNER JOIN pedhist as PH ON E.Id_Pedido = PH.Id;
INSERT INTO evanula (Id_Pedido, Codigo_Evento, Operador, vigente, Es_Privado, Fecha, id_evento_origen, Id_Correo, Codigo_Pais, Codigo_Institucion, Codigo_Dependencia, Codigo_Unidad, Id_Instancia_Celsius, destino_remoto, Id_Pedido_Remoto, Numero_Paginas, Observaciones, motivo_anulacion, fecha_anulacion, operador_anulacion) SELECT E.Id_Pedido, E.Codigo_Evento, E.Operador, E.vigente, E.Es_Privado, E.Fecha, E.id_evento_origen, E.Id_Correo, E.Codigo_Pais, E.Codigo_Institucion, E.Codigo_Dependencia, E.Codigo_Unidad, E.Id_Instancia_Celsius, E.destino_remoto, E.Id_Pedido_Remoto, E.Numero_Paginas, E.Observaciones, E.motivo_anulacion, E.fecha_anulacion, E.operador_anulacion FROM eventos as E INNER JOIN pedanula as PA ON E.Id_Pedido = PA.Id;
INSERT INTO eventos (Id_Pedido, Codigo_Evento, Operador, vigente, Es_Privado, Fecha, id_evento_origen, Id_Correo, Codigo_Pais, Codigo_Institucion, Codigo_Dependencia, Codigo_Unidad, Id_Instancia_Celsius, destino_remoto, Id_Pedido_Remoto, Numero_Paginas, Observaciones, motivo_anulacion, fecha_anulacion, operador_anulacion) SELECT E.Id_Pedido, E.Codigo_Evento, E.Operador, E.vigente, E.Es_Privado, E.Fecha, E.id_evento_origen, E.Id_Correo, E.Codigo_Pais, E.Codigo_Institucion, E.Codigo_Dependencia, E.Codigo_Unidad, E.Id_Instancia_Celsius, E.destino_remoto, E.Id_Pedido_Remoto, E.Numero_Paginas, E.Observaciones, E.motivo_anulacion, E.fecha_anulacion, E.operador_anulacion FROM evhist as E INNER JOIN pedidos as P ON E.Id_Pedido = P.Id;
INSERT INTO evanula (Id_Pedido, Codigo_Evento, Operador, vigente, Es_Privado, Fecha, id_evento_origen, Id_Correo, Codigo_Pais, Codigo_Institucion, Codigo_Dependencia, Codigo_Unidad, Id_Instancia_Celsius, destino_remoto, Id_Pedido_Remoto, Numero_Paginas, Observaciones, motivo_anulacion, fecha_anulacion, operador_anulacion) SELECT E.Id_Pedido, E.Codigo_Evento, E.Operador, E.vigente, E.Es_Privado, E.Fecha, E.id_evento_origen, E.Id_Correo, E.Codigo_Pais, E.Codigo_Institucion, E.Codigo_Dependencia, E.Codigo_Unidad, E.Id_Instancia_Celsius, E.destino_remoto, E.Id_Pedido_Remoto, E.Numero_Paginas, E.Observaciones, E.motivo_anulacion, E.fecha_anulacion, E.operador_anulacion FROM evhist as E INNER JOIN pedanula as P ON E.Id_Pedido = P.Id;

-- borro los eventos desubicados
DELETE E FROM eventos as E LEFT JOIN pedidos as P ON E.Id_Pedido = P.Id WHERE isNull(P.Id);
DELETE E FROM evhist as E LEFT JOIN pedhist as P ON E.Id_Pedido = P.Id WHERE isNull(P.Id);


--Interseccion de las tablas Pedidos, PedHist y PedAnula, para obtener los pedidos duplicados.

--Elimino las tuplas duplicadas de la tabla de busquedas.
CREATE TEMPORARY TABLE busq_aux SELECT * FROM busquedas GROUP BY Id_Catalogo, Id_Pedido HAVING count(*) > 1;
DELETE B FROM busquedas as B, busq_aux as a WHERE B.Id_Catalogo = a.Id_Catalogo AND B.Id_Pedido = a.Id_Pedido ;
INSERT INTO busquedas SELECT * FROM busq_aux;
ALTER TABLE busquedas ADD UNIQUE KEY (`Id_Catalogo`,`Id_Pedido`);
