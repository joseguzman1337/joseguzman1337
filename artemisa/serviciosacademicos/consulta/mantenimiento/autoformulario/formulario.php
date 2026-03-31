

Ir al contenido
Uso de Correo de Universidad El Bosque con lectores de pantalla

4 de 1.002
copia de archivos produccion
Recibidos
x

JESUS ENRIQUE JIMENEZ POSADA
jue., 27 feb. 15:24 (hace 19 horas)
Buen día Tatiana Solicito de tu amable colaboración con una copia de los siguientes archivos de producción -serviciosacademicos/consulta/mantenimiento/autoformu

Tatiana Camacho
Archivos adjuntos
jue., 27 feb. 16:05 (hace 18 horas)
para mí, Nestor

Buenos Tardes,

Adjunto archivos solicitados.

Quedo atenta a comentarios.
Cordialmente,

Tatiana Camacho
Infraestructura

2 archivos adjuntos
GRACIAS!MUCHAS GRACIAS.RECIBIDO.






<?php
session_start();

$rutaado=("../../../funciones/adodb/");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/clases/debug/SADebug.php");
require_once("../../../../sala/includes/adaptador.php");

$permission = getPermissionByUser($db);

if(count($permission) == 0)
{
    ?>
    <link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap.css">
    <script type="text/javascript" src="../../../../assets/js/bootstrap.js"></script>
    <?php

    echo "
        <div class='alert alert-danger' role='alert'>
          Usted no tiene permiso para ver esta página
        </div>";
    exit();
}

?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script><script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
<form name="form1" method="POST" action="">
    <p align="left" class="Estilo3"><h3><?php echo $_GET['tabla']?></h3></p>
    <table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
        <?php
        $ruta="/var/tmp/";
        if($_GET['tabla']<>'')
        {
            if($_GET['depurar']=='si')
            {

                $tabla->debug=true;
                $debug=true;
            }
            $tabla=new formulario($sala,$_GET['tabla'],'post',"","true","","",$debug);
            $tabla->ObtenerNombresTablasBD("sala");
            $tabla->DibujarTablaComoFormulario($_GET['tabla'],$ruta);

            if(isset($_REQUEST['Enviar']))
            {
                $tabla->valida_formulario();
                $tabla->InsertarDatosFormularioenBD("<script language='javascript'>reCarga('".$_GET['link_origen']."?tabla=".$_GET['tabla']."&inferior=".$_GET['inferior']."&superior=".$_GET['superior']."')</script>","<script language='javascript'>reCarga('".$_GET['link_origen']."?tabla=".$_GET['tabla']."&inferior=".$_GET['inferior']."&superior=".$_GET['superior']."')</script>");
            }
            if(isset($_REQUEST['Regresar']))
            {
                echo "<script language='javascript'>reCarga('".$_GET['link_origen']."?tabla=".$_GET['tabla']."&inferior=".$_GET['inferior']."&superior=".$_GET['superior']."')</script>";
            }
        }
        else
        {
            echo "<h1>No ha seleccionado tabla ni llave(opcional)</h1>";
        }


        function getPermissionByUser($db)
        {
            $query = "
        SELECT p.id, p.idTipoPermiso, idRelacionUsuario,
                       p.idUsuario, p.editar, p.ver, p.insertar, p.eliminar,p.idComponenteModulo,mo.nombremenuopcion
                  FROM Permiso p
                      inner join usuario u on p.idUsuario = u.idusuario
                      inner join menuopcion mo on mo.idmenuopcion = p.idComponenteModulo
            INNER JOIN TipoPermiso tp ON (tp.id = p.idTipoPermiso)
            where u.usuario = '".$_SESSION['usuario']."'
            and p.idComponenteModulo = 117;
    ";

            $data = $db->GetRow($query);
            return $data;
        }
        ?>
    </table>
    <input type="submit" name="Enviar" value="Enviar">
    <input type="submit" name="Regresar" value="Regresar">
</form>
