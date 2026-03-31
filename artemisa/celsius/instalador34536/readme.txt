Pasos de la Instalacion:

1. Seleccionar el idioma
2. 
   - conseguir user (root), host y password(root) de mysql y el nombre de la nueva BDD de celsiusNT. 
   - Ver si es una instalacion o actualizacion
   - crear la BDD de celsiusNT y cargar el schema (celsiusNT_Schema.sql) en la misma
3.
   - si es una actualizacion conseguir el nombre de la BDD del celsius1.6
   - preguntar si se desea crear un nuevo usuario de mysql para celsiusNT o si se debe usar un usuario de mysql preexistente. 
     En ambos casos solicitar el user y pass del mismo.
   - si es una actualizacion chequear que la BDD del celsius1.6 exista
   - crear el usuario o sino otorgarle los grants correspobdientes sobre la bdd de celsiusNT
   - crear el archivo de configuracion parametros.properties
4.
   - Se cargan los datos de las tablas nuevas de celsiusNT en la bdd creada (celsiusNT_datos_iniciales.sql)
   - Si es una instalacion desde cero se deben cargar los datos iniciales en la BDD de celsiusNT 
     (celsiusNT_datos_iniciales_instalacion.sql)
   - Si es una actualizacion se deben migrar los datos de la bdd de celsius16 a la de celsiusNT, ejecutar el script de limpieza 
     de la BDD (limpieza_bd_1.6.sql), actializar los datos importados (actualizacion_16_a_NT) y finalmente actualizar los 
     pedidos y los estados (actualizacion_bd_1.6.php).
5.
   - se solictan lso parametros: url_completa,mail_contacto,titulo_sitio,directorio_upload,directorio_temporal,admin_password (solo si es actualizacion)
     ,id_celsius_local.
   - preguntar si se desea habilitar la parte NT (nt_enabled) y si es asi solicitar:url_directorio y 
     password_directorio. Ademas en este caso se debera preguntar si se desea sincronizar con el directorio en el siguiente 
     paso o si lo prefiere hacer mas adelante.
   - guardar los parametros ingresados.
   - crear el usuario admin (si es una instalacion)
6. 
   - Si nt_enabled se ejecuta la actualizacion con el directorio si se puede. Si la actualizacion se realizo correctamente 
     se guarda en la tabla parametros el id_pais, id_institucion , id_dependencia y id_unidad que corresponden a la instancia.
   - nt_enabled= false y es uan instalacion cargo un pidu inicial
7. Si nt_enabled == false entonces se le permite al usuario que seleccione el pidu de su intancia
   de una lista
8. finaliza la instalacion.
9. Se obliga al usuario a borrar la carpeta del instalador para poder comenzar a utilizar celsiusNT (El codigo esta en index.php)