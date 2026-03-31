<?php 
/*
 * @create Luis Dario Gualteros 
 * <castroluisd@unbosque.edu.co>
 * Este corn crea Usuarios pendientes por crear en las tablas UsuarioTipo y usuariorol.
 * @since Diciembre 20, 2017.
*/ 
require_once('../../../../serviciosacademicos/Connections/sala2.php');
require('../../../../serviciosacademicos/funciones/funcionpassword.php');
$rutaado = '../../../../serviciosacademicos/funciones/adodb/';
require_once('../../../../serviciosacademicos/Connections/salaado.php');

session_start();
include_once('../../../../serviciosacademicos/utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

$user = $_SESSION['usuario'];

$SQL_usuario = "SELECT u.idusuario, u.usuario, ur.idrol
    FROM usuariorol ur
    INNER JOIN UsuarioTipo ut ON ur.idusuariotipo = ut.UsuarioTipoId
    INNER JOIN usuario u ON ut.UsuarioId = u.idusuario
    WHERE ur.idrol = '13'
    AND ut.CodigoEstado = '100'
    AND u.codigoestadousuario = '100'
    AND u.usuario = '$user'";
 
$identificadorUsuario = $db->GetRow($SQL_usuario);

if(count($identificadorUsuario)>0){ 
    $SQL_InsertTipoUser = 'INSERT INTO UsuarioTipo (
	CodigoTipoUsuario,
	UsuarioId,
	CodigoEstado
	)SELECT 
u.codigotipousuario,
u.idusuario,
u.codigoestadousuario
FROM
usuario u
LEFT JOIN UsuarioTipo ut ON u.idusuario = ut.UsuarioId
WHERE u.codigotipousuario = 600
AND u.codigoestadousuario= 100
AND u.idusuario NOT IN(SELECT 
u.idusuario
FROM
usuario u
RIGHT JOIN UsuarioTipo ut ON u.idusuario = ut.UsuarioId
WHERE u.codigotipousuario = 600
AND u.codigoestadousuario= 100)'; 

$tipoUsuarios = $db->Execute($SQL_InsertTipoUser);	
        
    if($tipoUsuarios){
       echo "Creando Usuarios...<br>";
       }else{
        echo "Error al insertar en la tabla UsuarioTipo...";
       }

    $SQL_UsuariosCreados ="SELECT 
        u.idusuario,
        u.usuario,
        u.numerodocumento,
        u.apellidos,
        u.nombres,
        u.codigoestadousuario AS 'EstadoUsuario'
    FROM
    usuario u
    INNER JOIN UsuarioTipo ut ON u.idusuario = ut.UsuarioId
    LEFT JOIN usuariorol ur ON ut.UsuarioTipoId = ur.idusuariotipo
    WHERE u.codigotipousuario = 600
    AND u.codigoestadousuario= 100
    AND u.idusuario NOT IN (SELECT 
        u.idusuario
        FROM
        usuario u
        INNER JOIN UsuarioTipo ut ON u.idusuario = ut.UsuarioId
        RIGHT JOIN usuariorol ur ON ut.UsuarioTipoId = ur.idusuariotipo
        WHERE u.codigotipousuario = 600
        AND u.codigoestadousuario= 100)
        ORDER BY u.apellidos";

    $usuariosCreados= $db->GetAll($SQL_UsuariosCreados);
    $tabla= "";
    if(count($usuariosCreados)>0){  
     $tabla = '<h1 align="left">Lista de Usuarios Creados</h1> 
                <table border=1 cellpacing=1 Cellpadding=1 id="tabla" width="80%" class="table">
                  <thead>
                     <tr>
                        <th style="text-align: center">N</th>
                        <th style="text-align: center">idUsuario</th>
                        <th style="text-align: center">Usuario</th>
                        <th style="text-align: center">Documento</th>
                        <th style="text-align: center">Apellidos</th>
                        <th style="text-align: center">Nombres</th>
                        <th style="text-align: center">Estado Usuario</th>
                    </tr>
                 </thead>';

         $i=1;    
         foreach ($usuariosCreados as $listaUsuarios) {
            $tabla.= "<tr>";
            $tabla.= "<td>".$i."</td>";
            $tabla.= "<td>".$listaUsuarios['idusuario']."</td>";
            $tabla.= "<td>".$listaUsuarios['usuario']."</td>";
            $tabla.= "<td>".$listaUsuarios['numerodocumento']."</td>";
            $tabla.= "<td>".$listaUsuarios['apellidos']."</td>";
            $tabla.= "<td>".$listaUsuarios['nombres']."</td>"; 
            $tabla.= "<td>".$listaUsuarios['EstadoUsuario']."</td>"; 
            $tabla.= "</tr>";
            $i++;
         }
        $tabla.='</table>';
        echo $tabla;
    }else{
        echo "No hay Usuarios pendientes por crear...<br>";    
    }

    $SQL_Existentes ='SELECT 
    u.idusuario
    FROM
    usuario u
    INNER JOIN UsuarioTipo ut ON u.idusuario = ut.UsuarioId
    RIGHT JOIN usuariorol ur ON ut.UsuarioTipoId = ur.idusuariotipo
    WHERE u.codigotipousuario = 600
    AND u.codigoestadousuario= 100';

    $UsuariosE = $db->Execute($SQL_Existentes);
    $concatenado ="";
    foreach($UsuariosE as $resultUsusriosE){

        $concatenado.=$resultUsusriosE['idusuario'].",";
    }

    $resultadoConcatenado=substr($concatenado, 0, -1);
    $SQL_InsertRolUser = "INSERT INTO usuariorol (
        idrol,
        codigoestado,
        idusuariotipo
        )SELECT 
    u.codigorol,
    u.codigoestadousuario,
    ut.UsuarioTipoId
    FROM
    usuario u
    INNER JOIN UsuarioTipo ut ON u.idusuario = ut.UsuarioId
    WHERE u.codigotipousuario = 600
    AND u.codigoestadousuario= 100
    AND u.idusuario NOT IN (".$resultadoConcatenado.")"; 

    $rolUsuarios = $db->Execute($SQL_InsertRolUser);

        if($rolUsuarios){
           echo "Se han Creado ".mysql_affected_rows()." Usuarios.";
        }else{
            echo "Error al insertar en la tabla usuariorol...";
        }
}else{
    ?>
    <meta charset="utf-8">
    <script language="JavaScript" type="text/javascript"> 
        alert("USTED NO ESTA AUTORIZADO PARA EJECUTAR ESTA ACCIÓN...");
    </script>
<?php
}
  
?>