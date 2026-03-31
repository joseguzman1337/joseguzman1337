<?php

 // Pagina Paso_1.php
 define('PASO1_TITULO','Seleccione el idioma');
 define('PASO1_ES','Español');
 define('PASO1_EN','Ingles');
 define('PASO1_PT','Portugues');
 
 // Pagina Paso_2.php
 define('PASO2_TITULO','Bienvenido al instalador de Celsius!!!!');
 define('PASO2_SUBTITULO','Datos iniciales para la instalacion');
 define('PASO2_LABEL_TIPOINSTALACION','Tipo de instalacion');
 define('PASO2_RADIO_TIPOINSTALACION_INSTALACION','Instalacion Nueva');
 define('PASO2_RADIO_TIPOINSTALACION_ACTUALIZACION','Actualizacion');
 define('PASO2_LABEL_HOSTMYSQL','Host de MySQL');
 define('PASO2_LABEL_USUARIOMYSQL','Usuario root de MySQL');
 define('PASO2_LABEL_PASSWORDMYSQL','Password root de MySQL');
 define('PASO2_LABEL_NOMBREBASE','Nombre de la nueva base de datos para CelsiusNT');
 define('PASO2_JS_HOSTMYSQL','Debe ingresar el nombre o ip del host donde esta alocado el mysql');
 define('PASO2_JS_USUARIOMYSQL','Debe ingresar el usuario de root mysql');
 define('PASO2_JS_PASSWORDMYSQL','Debe ingresar el password de root mysql');
 define('PASO2_JS_NOMBREBASE','Debe ingresar el nonbre que debe tener la nueva base de datos de celsius');

// Pagina Paso_3.php

 define('PASO3_SUBTITULO_ACTUALIZACION','Datos de la Base de Datos existente utilizada por Celsius 1.6');
 define('PASO3_LABEL_ACTUALIZACION_BDNAME','DBName 16');
 define('PASO3_SUBTITULO_USUARIOCELSIUS','Usuario de Mysql de CelsiusNT');
 define('PASO3_TEXT_INFORMACION','Ingrese los datos del usuario que debera usar CelsiusNT para conectarse con la BDD. 
			Si el usuario no existe sera creado automaticamente');
 define('PASO3_LABEL_USUARIOCELSIUSMYSQL','Nombre de usuario de Celsius para MySQL');
 define('PASO3_LABEL_PASSWORDCELSIUSMYSQL','Password de Celsius para MySQL');
 define('PASO3_JS_NOMBREBD','Debe ingresar el nombre de la BDD que utiliza actualmente su Celsius 1.6');
 define('PASO3_JS_NOMBREUSUARIOMYSQL','Debe ingresar el nombre de usuario de mysql que uilizara CelsiusNT');
 define('PASO3_JS_PASSWORDUSUARIOMYSQL','Debe ingresar el password de mysql que uilizara CelsiusNT');
 
 
 
 //Pagina Paso_4.php
 define('PASO4_SUBTITULO','Cargando los datos en la BDD de CelsiusNT (Esta operacion puede tardar varios minutos)');
 define('PASO4_MENSAJE_DATOSINICIALES','Cargando los datos iniciales en la BDD de celsiusNT');
 define('PASO4_MENSAJE_ERROR_DATOSINICIALES','Se ha producido un error al tratar de cargar los datos iniciales en la BDD de CelsiusNT');
 define('PASO4_MENSAJE_MIGRACIONBDD','Migrando los datos de la BDD 1.6 a la NT');
 define('PASO4_MENSAJE_ERROR_MIGRACIONBDD','Se ha producido un error al tratar de migrar los datos');
 define('PASO4_MENSAJE_PURGANDO','Purgando los datos provenientes de 1.6');
 define('PASO4_MENSAJE_ERROR_PURGANDO','Se ha producido un error al tratar de purgar los datos provenientes de la BDD de celsius 1.6.');
 define('PASO4_MENSAJE_ACTUALIZACIONPIDU','Actualizando el PIDU proveniente del Celsius 1.6 ya instalado');
 define('PASO4_MENSAJE_ERROR_ACTUALIZACIONPIDU','Se ha producido un error al tratar de actualizar el PIDU proveniente de la BDD de celsius 1.6.');
 define('PASO4_MENSAJE_ACTUALIZACIONDATOS','Actualizando los datos provenientes del Celsius instalado (Parte 2)');
 define('PASO4_MENSAJE_ERROR_ACTUALIZACIONDATOS','Se ha producido un error al tratar de actualizar los datos provenientes de la BDD de celsius 1.6.');
 define('PASO4_MENSAJE_ACTUALIZACIONPEDIDOS','Actualizando los pedidos y eventos provenientes del Celsius 1.6 instalado');
 define('PASO4_MENSAJE_ERROR_ACTUALIZACIONPEDIDOS','Se ha producido un error al tratar de actualizar los pedidos y evetos de la BDD de celsius 1.6.');
 define('PASO4_MENSAJE_TRADUCCIONES','Cargando las traducciones en la BDD de celsiusNT');
 define('PASO4_MENSAJE_ERROR_TRADUCCIONES','Se ha producido un error al tratar de cargar las traducciones en la BDD de CelsiusNT');
 define('PASO4_MENSAJE_CARGANDODATOS2','Cargando los datos iniciales en la BDD de celsiusNT (parte 2)');
 define('PASO4_MENSAJE_TERMINADO','Terminado');
 
 
 //Pagina Paso_5.php
 define('PASO5_SUBTITULO','Parametros de la aplicacion');
 define('PASO5_LABEL_URLCOMPLETA','Url_completa que utilizara celsius');
 define('PASO5_LABEL_MAILCONTACTO','Mail para contactarse con los administradores de esta instancia de Celsius');
 define('PASO5_LABEL_TITULOSITIO','Titulo del sitio, se vera en la parte superior de todas las paginas del sitio');
 define('PASO5_LABEL_DIRECTORIOUPLOAD','Ruta completa al directorio de upload');
 define('PASO5_LABEL_DIRECTORIOUPLOADTEMP','Ruta completa al directorio de archivos temporales');
 define('PASO5_LABEL_DATOSADMIN','Datos para el usuario admin (administrador de CelsiusNT)');
 define('PASO5_LABEL_DATOSADMINPASSWORD','Ingrese la contraseña de admin');
 define('PASO5_LABEL_REDATOSADMINPASSWORD','Reingrese la contraseña de admin');
 define('PASO5_SUBTITULO_DIRECTORIO','Parametros de directorio');
 define('PASO5_LABEL_IDCELSIUSLOCAL','id_celsius_local ASIGNADO POR EL DIRECTORIO');
 define('PASO5_LABEL_NTENABLED','nt_enabled?');
 define('PASO5_LABEL_PASSWORDDIRECTORIO','Password_directorio ASIGNADO POR EL DIRECTORIO');
 define('PASO5_LABEL_URLDIRECTORIO','url_directorio');
 define('PASO5_TEXT_INFORMACION','No Sincronizar CelsiusNT con el directorio en este momento (Si el celsiusNT funciona en modo distribuido, es requerimiento 
			sine qua non que se realice la sincronizacion con el directorio para poder usar CelsiusNT)');
 define('PASO5_JS_URLCOMPLETA','Debe ingresar la direccion web (url) completa para acceder al CelsiusNT');
 define('PASO5_JS_MAIL','Debe ingresar la direccion de correo que se utilizara para establecer contacto on los ususario de CelsiusNT');
 define('PASO5_JS_TITULOSITIO','Debe ingresar el titulo que sera mostrado en todas las paginas de CelsiusNT');
 define('PASO5_JS_DIRECTORIOUPLOAD','Debe ingresar el directorio a utilizar para el upload de archivos');
 define('PASO5_JS_DIRECTORIOTEMP','Debe ingresar el directorio temporal a utilizar');
 define('PASO5_JS_PASSWORDADMIN','Debe ingresar el password del usuario admin de celsiusNT');
 define('PASO5_JS_REPASSOWRD','Debe reingresar el password del usuario admin de celsiusNT');
 define('PASO5_JS_ERRORPASSWORD','Los valores ingresados en los campos de password del usuario admin deben coincidir');
 define('PASO5_JS_IDCELSIUSLOCAL','Debe ingresar el id_celsius_local (otorgado por el Directorio CelsiusNT');
 define('PASO5_JS_PASSWORDDIRECTORIO','Debe ingresar el password para conectarse con el directorio');
 define('PASO5_JS_URLDIRECTORIO','Debe ingresar la url para acceder al directorio');
 
 
 //Pagina Paso_6.php
 
 define('PASO6_TITULO','Actualizacion con el directorio');
 define('PASO6_SUBTITULO','Por favor espere, esta operacion puede tardar varios minutos...');
 define('PASO6_BUTTON_ACTUALIZAR','No actualizar por ahora?');
 define('PASO6_BUTTON_REINTENTAR','Reintentar');
 define('PASO6_MENSAJE_ACTUALIZACIONCORRECTA','La actualizacion del directorio fue realizada satisfactoriamente');
 define('PASO6_MENSAJE_ERROR_ACTUALIZARDIRECTORIO','Se ha producido el siguiente error al tratar de actualizar el directorio.');
 
 
 //Pagina Paso_7.php
 
 define('PASO7_SUBTITULO','Pidu de la instancia');
 define('PASO7_LABEL_PAIS','Pais');
 define('PASO7_LABEL_INSTITUCION','Institucion');
 define('PASO7_LABEL_DEPENDENCIA','Dependencia');
 define('PASO7_LABEL_UNIDAD','Unidad');
 define('PASO7_JS_PAIS','Debe seleccionar el pais');
 define('PASO7_JS_INSTITUCION','Debe seleccionar la institucion');
 
 
 
 //Pagina Paso_8.php
 define('PASO8_TEXT_1','Haga click');
 define('PASO8_TEXT_2','AQUI');
 define('PASO8_TEXT_3','si desea comenzar a usar CelsiusNT en este momento?');
 
 
 //Pagina base_layout_install.php
 
 define('BASE_LAYOUT_TEXT_1','Un producto dise&ntilde;ado integramente por el');
 // Pagina top_layout_install.php
 define('TOP_LAYOUT_TITULO','Instalacion de Celsius');
 
 //COMMON
 define('COMMON_BUTTON_SIGUIENTE','Siguiente');
 define('COMMON_MENSAJE_ERROR_MYSQL',' Mysql devolvio el siguiente error');
 define('COMMON_ERROR_BDD','Se ha producido el siguiente error en la BDD');
 define('COMMON_ERROR_INESPERADO','');
 define('COMMON_ERROR_MYSQL_INCORRECTO','Los datos del mysql son incorrectos o no se puede conectar con el servidor. Revise el Host, usuario y password ingresados');
 define('COMMON_MENSAJE_ERROR','Mensaje de error');
 define('COMMON_ERROR_CREAR_BASE','Se produjo un error al tratar de seleccionar la BD de celsiusNT recien creada con el nombre');
 define('COMMON_CREO_SATISFACTORIO','Se creo la estructura de la BDD de CelsiusNT satisfactoriamente');
 define('COMMON_NUMERO_ERROR','Numero de error');
 define('COMMON_MENSAJE_ERROR_SELECCIONAR_BASE','Se produjo un error al tratar de seleccionar la BD de celsius ingresada con el nombre');
 define('COMMON_MENSAJE_ERRPR_CARGA_SCRIPT','Se produjo un error al tratar de ejecutar el script de carga de la BDD de celsiusNT');
 define('COMMON_MENSAJE_ERROR_USUARIO','Se produjo un error al definir el usuario para celsiusNT. Chequee que el usuario de root que haya ingresado sea exactamente el usuario root de mysql');
 define('COMMON_MENSAJE_ERROR_OLDPASSWORD','Se produjo un error al tratar de setear el password del usuario como OLD_PASSWORD');
 define('COMMON_MENSAJE_ERROR_PERMISOS','Se produjo un error al otorgar los permisos sobre la base de datos de celsius 1.6 a el usuario para celsiusNT. Chequee que el usuario de root que haya ingresado sea exactamente el usuario root de mysql.');
 define('COMMON_MENSAJE_ERROR_ARCHIVO','No se pudo crear el archivo de configuracion de CelsiusNT');
 define('COMMON_MENSAJE_ARCHIVO_SATISFACTORIO','Se creo el archivo de configuracion de CelsiusNT satisfactoriamente');
 define('COMMON_MENSAJE_ERROR_PARAMETROS','Se produjo un error al tratar de guardar los parametros en la tabla parametros de la BDD de CelsiusNT');
 define('COMMON_MENSAJE_ERROR_MODIFICARWSDL','Se produjo un error al tratar de modificar los archivos wsdl');
 define('COMMON_MENSAJE_PARAMETROS_SATISFACTORIO','Se cargaron los datos en la tabla parametros de mysql satisfactoriamente');
  define('COMMON_MENSAJE_ERROR_SCRIPTPIDU','Se produjo un error al tratar de ejecutar el script con los datos iniciales del PIDU');
 define('COMMON_MENSAJE_ERROR_CREARUSUARIO','Se produjo un error al tratar de crear el usuario admin de CelsiusNT');
 define('COMMON_MENSAJE_ERROR_GUARDARPIDU','Se produjo un error al tratar de guardar el PIDU en la tabla parametros de la BDD de CelsiusNT ');
 define('COMMON_MENSAJE_ERROR_CREAR_ARCHIVOPARAMETROS','No se pudo crear el archivo parametros.properties, posiblemente porque el servidor web no tiene privilegios sobre la carpeta common. Dicho archivo deberia ser generado manualmente, y guardado en la carpeta common dentro del directorio CelsiusNT');
 define('COMMON_MENSAJE_ERROR_PROPERTIES','"El error que surgio es el siguiente');
 define('COMMON_MENSAJE_CONTENIDO_ARCHIVO','El contenido del archivo deberia ser');
 define('COMMON_MENSAJE_ERROR_COPIARBASE','Error al tratar de copiar los datos de la BDD');
 define('COMMON_MENSAJE_ERROR_COPIARDATOS','Error al tratar de copiar los datos comunes de la BDD');
 define('COMMON_MENSAJE_ERROR_EJECUTAR_SCRIPT','Error al intentar ejecutar el script del archivo');
 define('COMMON_MENSAJE_ERROR_ACCEDER_ARCHIVO','Error inesperado. Se genero un problema al acceder al archivo');
 define('COMMON_MENSAJE_ERROR_NOLEER','No se puede leer el archivo');
 define('COMMON_MENSAJE_ERROR_PERMISOARCHIVOS',' Revise que el archivo exista y que los permisos sean correctos');
 //define();
 
 define('PASO0_ERROR_ESCRITURA','Error: El Directorio');
 define('PAS00_ERROR_ESCRITURA1','No tiene Permiso de escritura - Es Requerido para la Instalacion');
 define('PASO0_WARNING_VARIABLE',' Para que CELSIUS NT  funcione mejor, la variable de entorno de PHP llamada  ');
 define('PASO0_WARNING_VARIABLE1',' (actualmente con valor ');
 define('PASO0_WARNING_VARIABLE2',') deberia contener el valor  ');
 
 define('PASO0_BUTTON_CONTINUAR','Continuar');
 
?>