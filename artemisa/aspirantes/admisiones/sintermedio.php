<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title></title>
        <script type="text/javascript">
            function redireccion() {                        
                alert('La sesion se ha cerrado');
                document.forms["redireccion"].submit();
            }
            var repeticion = window.setInterval("redireccion()", 100);
            window.onload = repeticion;
        </script>
    </head>
    <body>
        <form id="redireccion"  name="redireccion" action="inscripcion_aspirante.php" method="post">
            <input type="hidden" name="flag" id="flag" value="1">
        </form>
    </body>
</html>