<?


	include_once "tabla_ped.inc";

include_once "identif.php";
Usuario();

include_once "funcarch.php";

  function Dibujar_Tabla_Comp_Cur($VectorIdioma,$row,$Mensajes,$esAdmin = 1)
 //$esAdmin indica si el usuario que esta viendo la tabla es un usuario comun (caso por defecto) o un administrador
 //lo que cambia es que los administradores podrán ver tanto archivos pdf como arb. Los Usuarios no, solo los pdf.
 { 
      echo '<table width="95%" cellpadding="0" cellspacing="1" bgcolor="#ECECEC">
                  <tr>
                    <td width="162"></td>
                  </tr>
                  <tr class="style22">
                    <td width="162" height="18" align="right" valign="middle" class="style33"><div align="right"><strong>'.$Mensajes["et-1"].':&nbsp; </strong></div></td>
                    <td width="367" height="18" colspan="4" align="left" valign="middle"><div align="left">'.Devolver_Tipo_Solicitud($VectorIdioma,$row[0],0).'-<strong class="style33">'.Devolver_Tipo_Material ($VectorIdioma,$row[4]).'</strong></div></td>
                  </tr>
                  <tr class="style22">
                    <td width="162" height="18" align="right" valign="middle" class="style33"><div align="right"><strong>Id Pedido:&nbsp;&nbsp; </strong></div></td>
                    <td width="367" height="18" colspan="4" align="left" valign="middle"><div align="left">ARG-UNLP-0014193 </div></td>
                  </tr>
                  <tr class="style22">
                    <td width="162" height="18" align="right" valign="middle" class="style33"><div align="right"><strong>Usuario:&nbsp; </strong></div></td>
                    <td width="367" height="18" colspan="4" align="left" valign="middle"><div align="left">Altavista,Manrique Lucio </div></td>
                  </tr>
                  <tr class="style22">
                    <td width="162" height="18" align="right" valign="top" class="style33"><div align="right"><strong>Datos del Pedido:&nbsp; </strong></div></td>
                    <td width="367" height="18" colspan="4" align="left" valign="top"><div align="left">Titulo Revista: <a href="http://unnoba.prebi.unlp.edu.ar/pedidos/conshallados.php?Id_Col=4120&Vol=11&Numero=11&Anio=2001&Id=ARG-UNLP-0014193">A HORA VETERINARIA </a> / Vol-A&ntilde;o-Numero: 11-2001-11 / Paginas: 11- </div></td>
                  </tr>
                  <tr class="style22">
                    <td width="162" height="18" align="right" valign="middle" class="style33"><div align="right"><strong>Fecha Solicitud:&nbsp; </strong></div></td>
                    <td width="367" height="18" align="left" valign="middle"><div align="left">2004-08-23 </div></td>
                    <td height="18" colspan="2" align="left" valign="middle"><div align="left" class="style33">
                      <div align="right"><strong>Ult.Operador: </strong></div>
                    </div></td>
                    <td width="123" height="18" align="left" valign="middle"><div align="left">Fulanito de tal </div></td>
                  </tr>
                  <tr class="style22">
                    <td width="162" height="18" align="right" valign="middle" class="style33"><div align="right"><strong>Estado:&nbsp; </strong></div></td>
                    <td height="18" colspan="4" align="left" valign="middle"><div align="left">Pendiente de Atencion </div>                      <div align="left"></div>                      <div align="left"><strong></strong></div></td>
                    </tr>
                  <tr class="style22">
                    <td height="18" align="right" valign="middle" class="style33">&nbsp;</td>
                    <td height="18" colspan="4" align="left" valign="middle"><input name="Submit32" type="submit" class="style22" value="Revisar Pedido">
                      <input name="Submit33" type="submit" class="style22" value="Generar Evento"></td>
                  </tr>
                  <tr>
                    <td valign="top" width="162"></td>
                  </tr>
                </table>';



 echo "<center>";
 echo "<div align='left'>";
 echo "<table border='0' width='533' cellspacing='0' cellpadding='0' height='42' bgcolor='".Devolver_Color($row[4])."'";
 echo "<td width='162'><tr>";  
 echo "<td width='162' height='17' valign='middle' align='right'><b><font face='MS Sans Serif' size='1'>";
 echo $Mensajes["et-1"]."&nbsp;</font></b><font face='MS Sans Serif' size='1'>&nbsp;</font></td>";
 echo "<td width='367' height='17' valign='middle' align='left' colspan='4'>";
 echo "<font face='MS Sans Serif' size='1' color='#000080'>";
 
 echo Devolver_Tipo_Solicitud($VectorIdioma,$row[0],0)."-"; //busqueda o prov.
 
 echo "<b>".Devolver_Tipo_Material ($VectorIdioma,$row[4])."</b></font></td></tr><tr>"; //revistas,tesis, ...
 echo "<td width='162' height='17' valign='middle' align='right'><b><font face='MS Sans Serif' size='1'>".$Mensajes["et-2"]."&nbsp;&nbsp;</font></b></td>";
 echo "<td width='367' height='17' valign='middle' align='left' colspan='4'>";
 echo "<font face='MS Sans Serif' size='1' color='#000080'>".$row[1]."</font></td></tr><tr>"; 


 echo "<td width='162' height='17' valign='middle' align='right'><b><font face='MS Sans Serif' size='1'>".$Mensajes["et-3"]."&nbsp;</font></b></td>";
 echo "<td width='367' height='17' valign='middle' align='left' colspan='4'><font face='MS Sans Serif' size='1' color='#000080'>".$row[2].",".$row[3]."</font></td></tr><tr>";
 echo "<td width='162' height='17' valign='top' align='right'><b><font face='MS Sans Serif' size='1'>".$Mensajes["et-4"]."&nbsp;</font></b></td>";
 echo "<td width='367' height='17' valign='top' align='left' colspan='4'><font face='MS Sans Serif' size='1' color='#000080'>";
 
 echo Devolver_Descriptivo_Material($row[4],$row,0,0)." </font></td></tr><tr>";
  
 echo "<td width='162' height='17' valign='middle' align='right'><b><font face='MS Sans Serif' size='1' color='#000000'>".$Mensajes["et-5"]."&nbsp;</font></b></td>";
 echo "<td width='119' height='17' valign='middle' align='left'><font face='MS Sans Serif' size='1' color='#000080'>".$row[35]."</font></td>";
 echo "<td width='123' height='17' valign='middle' align='left' colspan='2'>&nbsp;<font face='MS Sans Serif' size='1'><b>".$Mensajes["et-6"]."</b></font></td>";
 echo "<td width='123' height='17' valign='middle' align='left'><font face='MS Sans Serif' size='1' color='#000080'>";
 
 if (strlen($row[37])>0) 
     { echo $row[37].",".$row[38]; }
	 
 echo "</font></td></tr><tr>";
 echo "<td width='162' height='17' valign='middle' align='right'><font face='MS Sans Serif' size='1'><b>".$Mensajes["et-7"]."&nbsp;</b></font></td>";
 echo "<td width='184' height='17' valign='middle' align='left' colspan='2'><font face='MS Sans Serif' size='1' color='#FF0000'>";

 echo Devolver_Estado($VectorIdioma,$row[36],0);
 
 echo "</font></td>";
 echo "<td width='92' height='17' valign='middle' align='left'>&nbsp;</td>";
 echo "<td width='91' height='17' valign='middle' align='left'><font face='MS Sans Serif' size='1' color='#FF0000'></font>";
 if ($row[44]==1) 
    { echo "<img border=0 src='../imagenes/obs.gif' width='18' height='16'>"; }
    
//$Mensajes[et-2] dice Id Pedido. 
//Por lo tanto, $row[1] contiene el id del pedido. 
//Con éste id puedo buscar los archivos que necesito
//Buscar archivo(s) para el pedido

/* global $Rol;
 if ($Rol == 3) //está logueado como usuario comun
	$esAdmin = 0;
      else
	if ($Rol == 1)  // es Administrador
	    $esAdmin = 1;
        else
            $esAdmin = 0;  
*/
$unArchivo = array();
$list = array();
global $Id_usuario;
global $Rol;
 
$list=devolverArchivosDePedido($row[1],$esAdmin);

if ($list) {
  for ($i=0;$i<count($list);$i++) {
    $unArchivo = $list[$i];
    if ($esAdmin) //los administradores siempre pueden bajarse archivos
    //farchivos/download.php?Id_Usuario=".$Id_Usuario."&Id_Archivo=".$row[0].
    if ($Rol==2) //es bibliotecario. No puede bajarse los archivos, solo puede verlos
      echo "  <img alt='No tiene permisos para bajarse el archivo' border=0 src='../imagenes/adobe.gif' width='20'>";
    else
      echo " <a href='farchivos/download.php?adm=1&Id_Pedido=".$row[1]."&Id_Usuario=".$Id_usuario."&Id_Archivo=".$unArchivo['Codigo']."'>  <img alt='Archivo disponible para bajar' border=0 src='../imagenes/adobe.gif' width='20'> </a>";
      else  //si es usuario comun, hay que ver bajo que condiciones puede bajarse el archivo 
        {  
	   $autorizado = puedeBajarse($unArchivo,$row[1]);
	  
           switch ($autorizado)
			{
				case 1:  //puede bajarse sin problemas
				  echo "<a href='farchivos/download.php?Id_Pedido=".$row[1]."&Id_Usuario=".$Id_usuario."&Id_Archivo=".$unArchivo['Codigo']."'><img alt='Archivo disponible para bajar' border=0 src='../imagenes/adobe.gif' width='20'></a>";
				  break;
				case 0: //el archivo no está disponible
				  echo "<img alt='Archivo ya bajado' border=0 src='../imagenes/notadobe.gif' width='20'>";
				  break;
				case -1: //el archivo está disponible, pero el usuario posee problemas (ej. cta. cte. en rojo)
				  echo "<img alt='Archivo no disponible para bajar' border=0 src='../imagenes/adobe.gif' width='20'>";
				  break;
			}
			
      }
   }
 }
 else
  echo "<b> </b>"; //no hago nada, no había archivos para ese pedido

//Fin buscar archivo(s) para el pedido
  
 echo "</font></td></tr><tr>";
 echo "<td width='162' height='17' valign='top'><font face='MS Sans Serif' size='1'>&nbsp;</font></td></tr>";
 echo "</table>";
 
}

function Dibujar_Tabla_Comp_Hist ($VectorIdioma,$row,$Mensajes,$Boton,$esAdmin=1)
{


 echo "<center>";
 echo "<div align='left'>";
 echo "<table border='0' width='100%' cellspacing='0' cellpadding='0' height='42' bgcolor='".Devolver_Color($row[4])."'>";
 echo "<tr><td colspan='7' height='9' background='../imagenes/banda.jpg' width='438'>";
 echo "<tr><td width='20%' height='17' valign='middle' align='right'><b><font face='MS Sans Serif' size='1'>".$Mensajes["et-1"]."&nbsp;</font></b></td>";
 echo "<td width='80%' height='17' valign='middle' align='left' colspan='6'>";
 echo "<font face='MS Sans Serif' size='1' color='#000080'>";
 echo Devolver_Tipo_Solicitud($VectorIdioma,$row[0],0)."-<b>";
 echo Devolver_Tipo_Material ($VectorIdioma,$row[4])."</b></font></td></tr><tr>";
 echo "<td width='20%' height='17' valign='top' align='right'><b><font face='MS Sans Serif' size='1'>".$Mensajes["et-4"]."&nbsp;</font></b></td>";
 echo "<td width='80%' height='17' valign='top' align='left' colspan='6'><font face='MS Sans Serif' size='1' color='#000080'>";
 echo Devolver_Descriptivo_Material ($row[4],$row,0,0); 
 echo "</font></td></tr><tr>";
 echo "<td width='15%' valign='top' align='right'><b><font face='MS Sans Serif' size='1' color='#000000'>".$Mensajes["et-5"]."&nbsp;</font></b></td>";
 echo "<td width='15%' valign='top' align='left'><font face='MS Sans Serif' size='1' color='#000080'>".$row[35]."</font></td>";
 echo "<td width='15%' valign='top' align='left'>";
 echo "<p align='right'><b><font face='MS Sans Serif' size='1' color='#000000'>&nbsp;".$Mensajes["et-10"]."&nbsp;&nbsp;</font></b></p>";
 echo "</td><td width='15%' valign='top' align='left'><font face='MS Sans Serif' size='1' color='#000080'>".$row[36]."</font></td>";
 echo "<td width='15%' valign='top' align='left'><p align='right'>";
 echo "<b><font face='MS Sans Serif' size='1'>".$Mensajes["et-2"]."&nbsp;</font></b>";
 echo "</p></td><td width='25%' valign='top' align='left' colspan='2'><font face='MS Sans Serif' size='1' color='#800000'>";
 echo $row[1]."</font></td></tr><tr>";
 echo "<td width='15%' valign='top' align='right'><b><font face='MS Sans Serif' size='1' color='#000000'>".$Mensajes["et-11"]."&nbsp;</font></b></td>";
 $Suma = $row[37]+$row[38]+$row[39];
 echo "<td width='83%' valign='top' align='left' colspan='4'><font face='MS Sans Serif' size='1' color='#000080'>".$row[40]."-".$row[41]."-".$row[42]." ".$Mensajes["tf-5"].$Suma." ".$Mensajes["tf-6"]."</font></td></center></center>";
 echo "<td width='2%' valign='top' align='left'>";
 echo "<p align='right'>&nbsp;";
 if ($Boton)
 {
   echo "<font face='MS Sans Serif' size='1'><input type='button' value='Ver' name='B3' style='font-family: MS Sans Serif; font-size: 10 px; font-weight: bold' OnClick=\"rutear_PedHist(".$row[4].",'".$row[1]."')\">";
 }  
 echo "</font></td></tr>";

 /* Gonzalo */
 $unArchivo = array();
$list = array();
global $Id_usuario;

$list=devolverArchivosDePedido($row[1],$esAdmin);

if ($list) {
  echo "<tr> <td> ";
  for ($i=0;$i<count($list);$i++) {
    $unArchivo = $list[$i];
    if ($esAdmin) //los administradores siempre pueden bajarse archivos
    //farchivos/download.php?Id_Usuario=".$Id_Usuario."&Id_Archivo=".$row[0].
      echo " <a href='farchivos/download.php?adm=1&Id_Pedido=".$row[1]."&Id_Usuario=".$Id_usuario."&Id_Archivo=".$unArchivo['Codigo']."'>  <img alt='Archivo disponible para bajar' border=0 src='../imagenes/adobe.gif' width='20'> </a>";
      else  //si es usuario comun, hay que ver bajo que condiciones puede bajarse el archivo 
        echo "<img alt='Archivo ya bajado' border=0 src='../imagenes/notadobe.gif' width='20'>";
   }
   echo "</td> </tr> ";
 }
 else
  echo "<b> </b>"; //no hago nada, no había archivos para ese pedido

/*termino Gonzalo */
 echo "</table></div></center>" ;
 
}

function Dibujar_Tabla_Abrev_Cur($VectorIdioma,$row,$Mensaje)
{
 echo "<table border='0' width='100%' height='17' bgcolor='".Devolver_Color($row[4])."'>";
 echo "<tr height='15'><td width='85%' height='17' valign='middle' align='left'><font face='MS Sans Serif' size='1' color='#000080'>";
 echo Devolver_Tipo_Solicitud($VectorIdioma,$row[0],1)."-<b>";
 echo $row[1]."</b>- ".$row[2].",".$row[3]." - <font color=black>:".$row[41]."-".$row[42]."-".$row[43]."</font> - ". Devolver_Descriptivo_Material($row[4],$row,0,0)."- Fecha Sol:".$row[40]."</td>";
 echo "<td width='5%' height='17' align='left'>";
 
 if ($row[44]==1) 
 { echo "<img border=0 src='../imagenes/obs.gif' width='18' height='16'>"; }
 echo "</td><td width='10%' height='17' align='left'>";
 
}
?>
