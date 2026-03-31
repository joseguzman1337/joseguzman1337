<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-es" lang="es-es" >
<head>
  <title>Ejemplo de formulario para subir archivos</title>
</head>
<body>
  <div id="formulario">
    <form action="subir.php" method="post" enctype="multipart/form-data" name="form"> 
      <label for="archivo">Archivo</label>
      <input name="archivo" type="file" id="archivo" /> 
      <input name="boton" type="submit" id="boton" value="Enviar" />
     </form>
  </div>
</body>
</html>