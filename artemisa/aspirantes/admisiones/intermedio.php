<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" rel="stylesheet" href="../../assets/css/sweetalert.css" />
        <script type="text/javascript" src="../../assets/js/sweetalert.min.js"></script>
        <script type="text/javascript" src="../../sala/assets/js/jquery-3.1.1.js"></script>
        <title></title>
        <script type="text/javascript">
           
            function redireccion() {
                swal('La sesion se ha cerrado');
                location.href = 'inscripcion_aspirante.php';
            }
            
            window.onload = redireccion();
        </script>
    </head>

    <body>
        <h1>Has cerrado la sesion</h1>
    </body>
</html>
