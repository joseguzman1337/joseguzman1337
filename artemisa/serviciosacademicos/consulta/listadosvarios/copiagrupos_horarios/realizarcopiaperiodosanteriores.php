<?php 
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');   
session_start();

$codigocarrera = $_SESSION['codigofacultad'];
	/* $query_car = "SELECT c.nombrecarrera, c.codigocarrera
	FROM carrera c
	where c.codigomodalidadacademica = '".$_POST['modalidad']."'
	AND c.fechavencimientocarrera > now()";
	//echo $query_car;
	$car = $db->Execute($query_car);
	$totalRows_car = $car->RecordCount(); 	
	$query_modalidad = "SELECT * FROM modalidadacademica where codigoestado like '1%' order by 1";
	$modalidad = $db->Execute($query_modalidad);
	$totalRows_modalidad = $modalidad->RecordCount();
	$row_modalidad = $modalidad->FetchRow();  */
	function valida_fecha($fecha)
	 {
	  $ano = substr($fecha,0,4); 
      $mes = substr($fecha,5,2);
      $dia = substr($fecha,8,2);	
	  
	   if (!(@checkdate($mes, $dia,$ano))) 
	   {
	     return false;
	   }
	   
	   return true;
	 }	
	
	$query_periodo1 = "SELECT * 
	FROM periodo 
	ORDER BY 1";
	$periodo1 = $db->Execute($query_periodo1);
	$totalRows_periodo1 = $periodo1->RecordCount();
	$row_periodo1 = $periodo1->FetchRow();
	//WHERE (codigoestadoperiodo LIKE '1%' OR codigoestadoperiodo LIKE '3%')
	
	$query_periodo2 = "SELECT * 
	FROM periodo 
	ORDER BY 1";
	$periodo2 = $db->Execute($query_periodo2);
	$totalRows_periodo2 = $periodo2->RecordCount();
	$row_periodo2 = $periodo2->FetchRow();
        //WHERE (codigoestadoperiodo LIKE '1%' OR codigoestadoperiodo LIKE '4%')
	
?>
 
<html>
<head>
<title>Copiar Grupos</title>
<link rel="stylesheet" href="../../estilos/sala.css" type="text/css">

<style type="text/css">
<!--
.Estilo1 {
	font-size: x-small;
	font-weight: bold;
}
.Estilo6 {font-family: tahoma; font-size: xx-small; font-weight: bold; }
-->
</style>
<script type="text/javascript" language="javascript" src="../../../mgi/js/jquery.js"></script>
<script>
    function GenerarMasivoSolicitud(){
        if(confirm('Desea Generar de Forma Maxiva las Solicitudes')){
            $('#SolicituMasiva').attr('disabled',true);
            $('#CrearGrupo').attr('disabled',true);
            $('#Distra').html('<img src="../../../EspacioFisico/imagenes/engranaje-13.gif" />Este Proceso Puede Tardar Unos Minutos...');
            
            $('#actionID').val('SolicitudMasiva');
            
            $.ajax({//Ajax
                  type: 'POST',
                  url: '../../../EspacioFisico/Interfas/SolicitudMasiva_html.php',
                  async: false,
                  dataType: 'html',
                  data:$('#f1').serialize(),
                  error:function(objeto, quepaso, otroobj){alert('Error de Conexi�n , Favor Vuelva a Intentar');},
                  success: function(data){
                      $('#Distra').html(data);
                      $('#SolicituMasiva').attr('disabled',false);
                      $('#CrearGrupo').attr('disabled',false);
                  }  
            });//Ajax
       }else{
        $('#SolicituMasiva').attr('disabled',false);
        $('#CrearGrupo').attr('disabled',false);
       } 
    }
</script>

<form name="f1" id="f1" method="post" action="">
  <input id="actionID" name="actionID" value="" type="hidden" />  
  <div align="center"><span class="Estilo1">COPIAR GRUPOS PERIODOS ANTERIORES </span>
  </div>
  <br>
<table align="center"  bordercolor="#FF9900" border="1" width="50%">
<tr  id="tdtitulogris">
<td><span class="Estilo6">Este programa Realiza una copia de los grupos y horarios de un periodo anterior, Cualquier modificación a un horario o grupo debe realizarse directamente por la opción de grupos y horarios académicos</span></td>
</tr>
<tr  id="tdtitulogris">
<td>
<table align="center"  width="60%">
<tr >
 <td bgcolor="#E9E9E9"><span class="Estilo6">Periodo Origen </span></td>
 <td><select name="fecha1" id="fecha1" >    
<?php
do 
{
?>
    <option value="<?php echo $row_periodo1['codigoperiodo']?>" <?php if (!(strcmp($row_periodo1['codigoperiodo'], $_POST['fecha1']))) {echo "SELECTED";} ?>><?php echo $row_periodo1['codigoperiodo']?></option>
<?php
}
while($row_periodo1 = $periodo1->FetchRow());
?>
  </select></td>
</tr>
<tr>
 <td bgcolor="#E9E9E9"><span class="Estilo6">Periodo Destino</span></td>
 <td><select name="fecha2" id="fecha2" >
<?php
do 
{
?>
    <option value="<?php echo $row_periodo2['codigoperiodo']?>" <?php if (!(strcmp($row_periodo2['codigoperiodo'], $_POST['fecha2']))) {echo "SELECTED";} ?>><?php echo $row_periodo2['codigoperiodo']?></option>
<?php
}
while($row_periodo2 = $periodo2->FetchRow());
?>
  </select></td>
</tr>
<tr>
 <td bgcolor="#E9E9E9"><span class="Estilo6">Fecha Inicial Grupo</span></td>
 <td><input type="text" name="fecha3" size="10" value="<?php echo $_POST['fecha3'] ?>"> aaaa-mm-dd</td>
</tr>
<tr>
 <td bgcolor="#E9E9E9"><span class="Estilo6">Fecha Final Grupo</span></td>
 <td><input type="text" name="fecha4" size="10" value="<?php echo $_POST['fecha4'] ?>"> aaaa-mm-dd</td>
</tr>
<tr>
 <td>&nbsp;</td>
 <td>&nbsp;</td>
</tr>
<tr>
 <td colspan="2"><div align="center">
   <input type="submit" name="Submit" id="CrearGrupo" value="Crear Grupos y Horarios">
   <input type="button" name="SolicituMasiva" id="SolicituMasiva"  onclick="GenerarMasivoSolicitud()" value="Generar Solicitudes">
 </div></td>

</tr>
<tr>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
    <td colspan="2">
        <div align="center" id="Distra"></div>
    </td>
</tr>
</table>
</td>
</tr>
</table>
</form>
<?php 
if ($_POST['Submit'] ==  true)
{		   
	$query_car = "SELECT *
	FROM grupo g,materia m
	where g.codigoperiodo = '".$_POST['fecha2']."'
	AND m.codigomateria = g.codigomateria
	and m.codigocarrera = '$codigocarrera'
	and codigoestadogrupo like '1%'";
	//echo $query_car;
	$car = $db->Execute($query_car);
	$totalRows_car = $car->RecordCount(); 
	$row_car = $car->FetchRow(); 	
	
	if ($row_car <> "")
	{
		echo '<script language="javascript">alert("Ya presenta horarios para el periodo destino, solamente se insertaran los horarios en materias que no posean grupos");</script>';
			//exit();
	}
	   
	if ($_POST['fecha1'] >= $_POST['fecha2'])
	{
		echo '<script language="javascript">alert("El periodo origen no puede ser igual o Mayor al periodo destino"); history.go(-1);</script>';
		exit();
	}
		
	$fechita1 = valida_fecha($_POST['fecha3']);
	$fechita2 = valida_fecha($_POST['fecha4']);
		
	if (!$fechita1 or !$fechita2 or ($_POST['fecha3'] >= $_POST['fecha4']))
	{
		echo '<script language="javascript">alert("Alguna de Las fechas es incorrecta"); history.go(-1);</script>';
		exit();
	}
	  
	$query_periodoinicial = "SELECT * 
	FROM grupo g,materia m
	WHERE g.codigoperiodo = '".$_POST['fecha1']."'
	AND m.codigocarrera   = '$codigocarrera'
	AND g.codigomateria   = m.codigomateria
	AND g.codigoestadogrupo LIKE '1%'";	   
	$periodoinicial = $db->Execute($query_periodoinicial);
	$totalRows_periodoinicial = $periodoinicial->RecordCount();
	$row_periodoinicial = $periodoinicial->FetchRow();	   
	   
	//echo $query_periodoinicial,"<br><br><br>";
	do
	{
		$query_materiaexiste = "SELECT *
		FROM grupo g,materia m
		where g.codigoperiodo = '".$_POST['fecha2']."'
		AND m.codigomateria = g.codigomateria
		and m.codigocarrera = '$codigocarrera'
		and m.codigomateria = '".$row_periodoinicial['codigomateria']."'
		and g.nombregrupo = '".$row_periodoinicial['nombregrupo']."'
		and codigoestadogrupo like '1%'";
		//echo $query_car;
		$materiaexiste = $db->Execute($query_materiaexiste);
		$totalRows_materiaexiste = $materiaexiste->RecordCount(); 
		if($totalRows_materiaexiste == 0)
		{
			// Si existe el grupo continua, si no lo inserta
			$query_grupoexiste = "SELECT *
			FROM grupo g,materia m
			where g.codigoperiodo = '".$_POST['fecha2']."'
			AND m.codigomateria = g.codigomateria
			and m.codigocarrera = '$codigocarrera'
			and m.codigomateria = '".$row_periodoinicial['codigomateria']."'
			and g.nombregrupo = '".$row_periodoinicial['nombregrupo']."'
			and codigoestadogrupo like '1%'";
			//echo $query_car;
			$grupoexiste = $db->Execute($query_grupoexiste);
			$totalRows_grupoexiste = $grupoexiste->RecordCount(); 
			
			if($totalRows_grupoexiste == 0)
			{ 			
		 	// ****  Realizo Insercion de Grupos de periodo nuevo ****//		
		  	$query_insetgrupo = "INSERT INTO grupo(idgrupo,codigogrupo,nombregrupo,codigomateria,codigoperiodo,numerodocumento,maximogrupo,matriculadosgrupo,maximogrupoelectiva,matriculadosgrupoelectiva,codigoestadogrupo,codigoindicadorhorario,fechainiciogrupo,fechafinalgrupo,numerodiasconservagrupo)
		  	VALUES('0','".$row_periodoinicial['codigogrupo']."','".$row_periodoinicial['nombregrupo']."','".$row_periodoinicial['codigomateria']."','".$_POST['fecha2']."','".$row_periodoinicial['numerodocumento']."','".$row_periodoinicial['maximogrupo']."','0','0','0','10','100','".$_POST['fecha3']."','".$_POST['fecha4']."','999')";
		  	$insetgrupo  = $db->Execute($query_insetgrupo);
		 
		  	$idnumerogrupo = $db->Insert_ID();
		  
		   	$query_horario = "SELECT * 
		   	FROM horario
		   	where idgrupo = '".$row_periodoinicial['idgrupo']."'
		   	and codigoestado like '1%'";	   
		   	$horario = $db->Execute($query_horario);
		   	$totalRows_horario = $horario->RecordCount();
		   	$row_horario = $horario->FetchRow(); 
		   	//echo $query_horario;
		  	// exit();
		   	do
		    {
				$query_insethorario = "INSERT INTO horario(idhorario, idgrupo, codigodia, horainicial,horafinal,codigotiposalon,codigosalon,codigoestado)
		      	VALUES('0', '$idnumerogrupo', '".$row_horario['codigodia']."', '".$row_horario['horainicial']."', '".$row_horario['horafinal']."', '".$row_horario['codigotiposalon']."', '".$row_horario['codigosalon']."', '100')";
		      	$insethorario  = $db->Execute($query_insethorario);			
			  	$idnumerohorario = $db->Insert_ID();
			  
				$query_insetdetallehorario = "INSERT INTO horariodetallefecha(idhorariodetallefecha,idhorario,fechadesdehorariodetallefecha,fechahastahorariodetallefecha,codigoestado)
			    VALUES('0', '$idnumerohorario', '".$_POST['fecha3']."','".$_POST['fecha4']."', '100')";
		   		$insetdetallehorario  = $db->Execute($query_insetdetallehorario);			
			}
			while ($row_horario = $horario->FetchRow());
			}		 
		}
	}
	while($row_periodoinicial = $periodoinicial->FetchRow()); 
    echo '<script language="javascript">alert("Proceso Generado con Exito"); history.go(-2);</script>';
}
?>