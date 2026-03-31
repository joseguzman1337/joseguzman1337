<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 

require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');
require_once('../../../class/table.php');
require_once('../../../class/Class_andor.php');

//session_start();

if (isset($_GET['documento'])){$documento = $_GET['documento'];}
$obtable_admindco = new table("administrativosdocentes");
$obtable_admindco->sql_where = " numerodocumento= '$documento' and codigoestado='100' ";
$admdocente = $obtable_admindco->getData();
$admdocente = $admdocente[0];

if (!is_array($admdocente)) {
?>
    <script type="text/javascript">
        alert('No se encuentra laborando en la Universidad, favor remitirse a Talento Humano.');
           </script>
<?php
 echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=../carnetizacion_docentadmin/busquedadocenteadministrativo.php'>";
  exit();
} else {
$obj_tarjet = new table("tarjetainteligenteadmindocen");
$obj_tarjet->sql_where = " idadministrativosdocentes= '".$admdocente['idadministrativosdocentes']."' and codigoestado='100' ";
$objtarjeta = $obj_tarjet->getData();
$objtarjeta = $objtarjeta[0];
}




?>
<html>
<head>
<title>Editar Docente-Administrativo</title>
<script src="../../js/jquery.js" language="JavaScript" type="text/javascript"></script>
</head>
<style type="text/css">
<!--
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; background-color: #C5D5D6; text-align: center;}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
<body>
<form name="form1" method="post" action="editaresdocenadmin.php?documento=<?=$documento;?>" id="form1">
    <input type="hidden" name="Guardar" value="SI"/>
    <input type="hidden" name="idadministrativosdocentes" value="<?=$admdocente['idadministrativosdocentes'];?>"/>
    <p align="center" class="Estilo3">EDITAR DOCENTES-ADMINISTRATIVOS</p>
    <div>
    <table width="876" border="1" align="center" cellpadding="1" bordercolor="#003333">          
        <tr>
            <td class="Estilo2">Apellidos<span class="Estilo4">*</span></td>
            <td colspan="3">
            <input name="apellidos" type="text" id="apellidos" value="<?=$admdocente['apellidosadministrativosdocentes'];?>" size="30">
            </td>
            <td class="Estilo2">Nombres<span class="Estilo4">*</span></td>
            <td>
            <input name="nombres" type="text" id="nombres2" value="<?=$admdocente['nombresadministrativosdocentes'];?>" size="25">
            </td>
        </tr>
        <tr>
            <td class="Estilo2">Tipo Documento<span class="Estilo4">*</span></td>
            <td>          
                <?
                    $query_tipodocenteadministrativo = "SELECT nombrecortodocumento,tipodocumento FROM documento order by 1";
                    $registrostipousuario = $db->Execute ($query_tipodocenteadministrativo);
                    echo $registrostipousuario->GetMenu2('tipodocumento',$admdocente['tipodocumento'],false,false,1,' ');
                ?>    
            </td>
            <td class="Estilo2">N&uacute;mero<span class="Estilo4" >*</span></td>
            <td>
                <input name="documento" type="text" id="documento2" value="<?=$admdocente['numerodocumento'];?>" size="20">
            </td>
            <td class="Estilo2">Expedido en</td>
            <td>
                <input name="expedido" type="text" value="<?=$admdocente['expedidodocumento'];?>" size="25">
            </td>
        </tr>  
        <tr>
            <td class="Estilo2">Número Tarjeta Inteligente</td>
            <td>
                <input name="numerotarjeta" id="numerotarjeta" type="text" value="<?=$objtarjeta['codigotarjetainteligenteadmindocen'];?>" size="20">
            </td>
            <td class="Estilo2">Grupo Sanguineo<span class="Estilo4">*</span></td>
            <td>
                <?
                $query_tipodocenteadministrativo = "SELECT nombretipogruposanguineo,idtipogruposanguineo 
                FROM tipogruposanguineo order by 1";
                $registrostipousuario = $db->Execute ($query_tipodocenteadministrativo);
                echo $registrostipousuario->GetMenu2('idtipogruposanguineo',$admdocente['idtipogruposanguineo'],false,false,1,' ');
                ?>
            </td>
            <td class="Estilo2">Genero<span class="Estilo4">*</span></td>
            <td>
                <?
                $query_tipodocenteadministrativo = "SELECT nombregenero,codigogenero FROM genero";
                $registrostipousuario = $db->Execute ($query_tipodocenteadministrativo);
                echo $registrostipousuario->GetMenu2('genero',$admdocente['codigogenero'],false,false,1,' ');
                ?>
            </td>
        </tr>
        <tr>
            <td class="Estilo2">Tipo Usuario<span class="Estilo4">*</span></td>
            <td colspan="2">
            <?
            $query_tipodocenteadministrativo = "SELECT nombretipousuarioadmdocen,idtipousuarioadmdocen FROM tipousuarioadmdocen";
            $registrostipousuario = $db->Execute ($query_tipodocenteadministrativo);
            echo $registrostipousuario->GetMenu2('tipousuariodocenadmin',$admdocente['idtipousuarioadmdocen'],false,false,1,' disabled="disabled"');                
            ?>         
            </td>        
            <td class="Estilo2">Celular</td>
            <td colspan="2">
            <input name="celular" type="text" value="<?=$admdocente['celularadministrativosdocentes'];?>" size="30">
            </td>
        </tr>
        <tr>
            <td class="Estilo2">Télefono</td>
            <td colspan="2">
            <input name="telefono" type="text" value="<?=$admdocente['telefonoadministrativosdocentes'];?>" size="30">
            </td>
            <td class="Estilo2">E-mail</td>
            <td colspan="2">
            <input name="email" type="text" id="email3" value="<?=$admdocente['emailadministrativosdocentes'] ;?>" size="30">
            </td>
        </tr>
        <tr>
            <td class="Estilo2">Dirección<span class="Estilo4">*</span></td>
            <td colspan="5">&nbsp;
            <INPUT name="direccion1" size="90" readonly onclick="window.open('direccion.php?inscripcion=1','direccion','width=1000,height=300,left=150,top=150,scrollbars=yes')"  value="<?=$admdocente['direccionadministrativosdocentes']; ?>">
            <input name="direccion1oculta" type="hidden" value="<?=$admdocente['direccionadministrativosdocentes']; ?>">
            </td>
        </tr>
    </table>
    </div>
    <div id=restable>
        <?
        
        $objAndor = new class_andor($documento);        
        $NivelAcceso = 1;
        $objAndor->setNivelAcceso($NivelAcceso); 
        $objAndor->setApellido('');
        $objAndor->setNombres('');
        $rsutl = $objAndor->get_ws_result();
        echo  $objAndor->table_cardholder($rsutl);
        ?>
    </div>        
<script language="javascript">

function estado(ojbtable){    
    $(ojbtable.parentNode).each(function (index) {
        var apellido = $(this.cells[0]).html();
        var nombre = $(this.cells[1]).html();
        var tarjeta = $(this.cells[2]).html();
        var documento='<?php echo $documento;?>';
        var v_estado = $(this.cells[3]).html();
        var v_inactivar = '';
        if (v_estado == 'Activar'){
            v_inactivar = 'false';            
        }else{
            v_inactivar = 'true';
        }
        $.get("ajax.php", {Inactivar : v_inactivar, v_apellido: apellido, v_nombre: nombre, v_tarjeta : tarjeta ,v_documento : documento}, function(data){
        alert('Tarjeta Actualizada Correctamente');
        $("#restable").html(data);
        });
    });   
}
function guardar_data(){        
        $.post("ajax.php",$("#form1").serialize(),function (data){
            alert('Tarjeta Actualizada Correctamente');
            $("#restable").html(data);
        }
        );
       // $("#restable").html(data);

}
</script>
<br>
<div align="center">
<input type="button" name="guardar" value="Guardar" onclick="javascript:guardar_data();">
 <input type="button" value="Regresar" onclick="history.back()">
</div>
</form>