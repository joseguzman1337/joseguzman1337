<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>{PAGE_TITLE}</title>
        <style type="text/css" title="currentStyle">
                @import "../css/cssreset-min.css";
                @import "../../css/themes/smoothness/jquery-ui-1.8.4.custom.css";
                @import "../css/tableroAvance.css";
        </style>        
        <script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../js/jquery-ui-1.8.21.custom.min.js"></script>  
        <script type="text/javascript" language="javascript" src="../js/funcionesTableroAvance.js"></script>
    </head>
    <body>
        
        <div id="barraLateral">
            <h1>MGI-UEB</h1>
            <ul>
                <li class="first"><a href="index.php?page=index">INICIO</a></li>
                <li><a href="index.php?page=factores">Factores</a></li>
                <li><a href="index.php?page=encuestas">Encuestas</a></li>
                <li><a href="index.php?page=tablas_maestras">Tablas maestras</a></li>
            </ul>
        </div>
        <div id="container">
            <div id="header">
                <a class="sala" href="volverSala.php">Volver a Sala</a>
            </div>
            <div id="pageWrapper">
                <div id="loadingDiv"><img src="../images/ajax-loader2.gif" alt="Cargando..." /></div>
                <div id="pageContainer">
                    <div id="contenido">{PAGE_CONTENT}</div>                
                </div>
            </div>
        </div>
        <div class="vacio"></div>
    </body>
</html>
