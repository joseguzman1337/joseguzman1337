<?php   session_start();
require_once('../Connections/sala2.php');

//require_once('encabezado.php');

?>
<script language="javascript">
var browser = navigator.appName;
function hRefCentral(url){
	if(browser == 'Microsoft Internet Explorer'){
		parent.contenidocentral.location.href(url);
	}
	else{
		parent.contenidocentral.location=url;
	}
	return true;
}

function hRefIzq(url){
	if(browser == 'Microsoft Internet Explorer'){
		parent.leftFrame.location.href(url);
	}
	else{
		parent.leftFrame.location=url;
	}
	return true;
}

function destruirFrames(url){
	parent.document.location.href=url;
}
</script>



<?php

if (isset($_REQUEST['Aceptar']))
 {
   echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=facultades/registro_graduados/carta_egresados/Carta_Estudiante.php'>";
   echo "<script language='javascript'>
   //alert('Usted no tiene permiso para entrar a esta opcion');
   //document.location.href='consultanotas.htm';
   hRefIzq('facultades/facultadeslv2.php');
   hRefCentral('facultades/central.php');
   </script>";		
 }


if (isset($_GET['codigo']))
 {
  $_SESSION['codigo'] = $_GET['codigo'];
 }

if (isset($_GET['codperiodo']))
 {
  //echo "entro";
  $_SESSION['codigoperiodosesion'] = $_GET['codperiodo'];
 }
$codigoestudiante=$_SESSION['codigo'];

mysql_select_db($database_sala, $sala);
$query_carrera = "SELECT codigocarrera from estudiante
where codigoestudiante = '".$codigoestudiante."'";
				 
$carrera = mysql_query($query_carrera, $sala) or die(mysql_error());
$row_carrera = mysql_fetch_assoc($carrera);
$totalRows_carrera = mysql_num_rows($carrera);	
mysql_select_db($database_sala, $sala);
$query_valida = "SELECT * from mensaje m,estadomensaje e 
where (m.codigoestudiante = '".$codigoestudiante."'
OR (m.codigoestudiante = '1' and m.codigodirigidomensaje = '100'))
and m.codigocarrera = '".$row_carrera['codigocarrera']."'
and m.codigoestadomensaje = e.codigoestadomensaje
and fechainiciomensaje <= '".date("Y-m-d H:m:s",time())."'
and fechafinalmensaje >= '".date("Y-m-d H:m:s",time())."'
order by m.fechamensaje desc";
$valida = mysql_query($query_valida, $sala) or die(mysql_error());
$row_valida = mysql_fetch_assoc($valida);
$totalRows_valida = mysql_num_rows($valida);	


if ($row_valida <> "")
  {//validadocente
 ?>
 
 
 
 
 
<style type="text/css">
<!--
.Estilo2 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #990000}
.Estilo5 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
-->
</style>
 <form name="form1" method="post" action="">
   <p>&nbsp;</p>
   <table width="50%"  border="3" bordercolor="#003333">
  <tr>
 
    <td><p align="center" class="Estilo3 Estilo4 Estilo5">ATENCI&Oacute;N</p>
      <p align="center" class="Estilo2">Tiene los siguientes mensajes</p>
      <table width="100%" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#003333">
      <tr class="Estilo2">
        <td width="40%" align="center" bgcolor="#C5D5D6" class="Estilo5">Fecha Mensaje</td>       
        <td width="60%" align="center" bgcolor="#C5D5D6" class="Estilo5">Asunto</td>        
      </tr>
          
	<?php 		
		do{
             if (($row_valida["fechainiciomensaje"]<=date("Y-m-d H:m:s",time()) &&  date("Y-m-d H:m:s",time()) <= $row_valida["fechafinalmensaje"]))
			  { 
					$fecha = $row_valida["fechamensaje"];								
					echo '<tr>';?>					
					
			<?php echo '<td><div align="center" class="Estilo1">'.$row_valida["fechamensaje"].'&nbsp;</div></td>';?> 
						
						<td align='center' class='Estilo5'>
			<?php if ($row_valida["codigoestadomensaje"] == 100)
			        {
					?>
						<table width="100%"  border="0" cellpadding="0">
                            <tr>
                              <td><div align="left"><a onClick="window.open('mensajeestudianteavisoventana.php?idmensaje=<?php echo $row_valida["idmensaje"];?>&tipo=<?php echo $row_valida["codigoestudiante"];?>','mensajes','width=400,height=300,left=150,top=50,scrollbars=yes')" style="cursor: pointer"><img src="../../imagenes/correo1.png" width="15" height="15" alt="Leer Mensaje"></a></div>
                              </td>							   
							  <td><div align="left"><a onClick="window.open('mensajeestudianteavisoventana.php?idmensaje=<?php echo $row_valida["idmensaje"];?>&tipo=<?php echo $row_valida["codigoestudiante"];?>','mensajes','width=400,height=300,left=150,top=50,scrollbars=yes')" style="cursor: pointer; font-size: 10px;"><?php echo $row_valida["asuntomensaje"]; ?></a></div>
							  </td>							 
                            </tr>
                          </table>						
			 <?php }
				 else
				   { ?>
				   <table width="100%"  border="0" cellpadding="0">
                            <tr>
                              <td><div align="left"><a onClick="window.open('mensajeestudianteavisoventana.php?idmensaje=<?php echo $row_valida["idmensaje"];?>&tipo=<?php echo $row_valida["codigoestudiante"];?>','mensajes','width=400,height=300,left=150,top=50,scrollbars=yes')" style="cursor: pointer"><img src="../../imagenes/correo2.png" width="15" height="15" alt="Leer Mensaje"></a></div>
                              </td>							  
                               <td> <div align="left"><a onClick="window.open('mensajeestudianteavisoventana.php?idmensaje=<?php echo $row_valida["idmensaje"];?>&tipo=<?php echo $row_valida["codigoestudiante"];?>','mensajes','width=400,height=300,left=150,top=50,scrollbars=yes')" style="cursor: pointer; font-size: 10px;"><?php echo $row_valida["asuntomensaje"]; ?></a></div>
                               </td>
							</tr>
                          </table>				   
			<?php  }					
					?>			
						</td>					
						</tr>
<?php						
		      }   
		}while ($row_valida = mysql_fetch_assoc($valida));		
		?>
       </table>
       
      </td>
  </tr>
</table>
    
    <div align="center"></div>
   

    <div align="left">
  <input name="Aceptar" type="submit" id="Aceptar" value="Continuar"> 
&nbsp;
      </div>
 </form>
<?php 
 }
else
{  
    
    if($_GET['Consultar']==0 || !isset($_GET['Consultar'])){
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=facultades/registro_graduados/carta_egresados/Carta_Estudiante.php'>";
    }else{
        echo "<script language='javascript'> 
        
		//alert('Usted no tiene permiso para entrar a esta opcion');
		//document.location.href='consultanotas.htm';
		hRefIzq('facultades/facultadeslv2.php');
		hRefCentral('facultades/central.php');
		</script>";
    }
	// echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=consultafacultadesv2.htm'>";
	
	/*echo "<script language='javascript'>
    //alert('Usted no tiene permiso para entrar a esta opcion');
	//document.location.href='consultanotas.htm';
	hRefIzq('facultades/facultadeslv2.php');
	hRefCentral('facultades/central.php');
    </script>";	*/	
}
?>