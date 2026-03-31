1 -> instalacion NT
2 -> instalacion NO NT
3 -> actualizacion NT
4 -> actualizacion NO NT


(*) celsiusNT_Schema.sql = Script que contiene el schema de todas las tablas de celsiusNT
(*) celsiusNT_datos_iniciales.sql = Script sql que contiene datos para las tablas agregadas en CelsiusNT. las tablas son:
                                campos_pedidos, campos_pedidos_traducidos,existencia. Tambien se reinsertan todas las 
                                traducciones porque cambiaron: idiomas,elementos, pantallas, traducciones.
(1|2) celsiusNT_datos_iniciales_instalacion.sql = Script sql que contiene un conjunto de datos basicos para operar celsiusNT. 
											Solo se usa en el caso de la instalacion, no en la actualizacion. Las tablas son:
											catalogos, forma_entrega, noticias (ejemplo),plantmail,tab_categ_usuarios,
											sugerencias, parametros
(2) celsiusNT_datos_inicialesPIDU.sql = Script sql que contiene datos para las tablas del PIDUI de CelsiusNT (PIDU ISTEC). Solo debe usarse en 
                                    caso de no utilizar la parte NT de celsius y si es una instalacion de cero.

(3|4) limpieza_bd_1.6.sql = Script sql que realiza una limpieza sobre los datos importados de la BDD de celsius1.6. 
						(solo se usa en la actualizacion).
(3|4) update_Ids_1.6.sql = Script de actualizacion del Ids. Lo que hace principalemente es incrementar en 10000 los ids
					 de paises, instituciones, dependencias  y unidades junto con sus referencias (Esto se hace para 
					 que no se produzcan conflictos con los ids traidos desde el directorio en las actualziaciones), e 
					 incrementar los eventos en 200000 y los evanula en 150000 (para que los ids de los eventos sean 
					 unicos en las tres tablñas, y poder administrar un evento por su id, sin que dicho id exista en mas
					  de una tabla de eventos).
	
readme.txt = ver archivo readme.txt
