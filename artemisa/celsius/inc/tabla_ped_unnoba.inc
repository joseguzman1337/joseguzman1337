<?

include_once "../inc/identif.php";
Usuario();

include_once "../inc/funcarch.php";

function Dibujar_Tabla_Abrev_Cur($VectorIdioma,$row,$Mensaje)
{

 echo '<table width="90%"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#ECECEC">';
 echo "<tr bgcolor='#ECECEC'>";
 echo '<td colspan="2" align="center" valign="middle" class="style33">';
 echo '<table width="97%"  border="0" align="center" cellpadding="0" cellspacing="1" >
    <tr>
      <td colspan="3" align=left><span class="style33"> ';
 echo Devolver_Tipo_Solicitud($VectorIdioma,$row[0],0)." <b> ";
 echo $row[1]."</b> - ".$row[2].", ".$row[3]." - ".Devolver_Descriptivo_Material_Corto($row[4],$row,0,0)."- Fecha Sol:".$row[40]."</td>";
 echo ' </span>';

 if ($row[44]==1)
    { echo "<td><img border=0 alt='Obs.' src='../images/obs.gif' width='18' height='16'> </td>"; }
  echo " </tr> ";
  echo "<tr><td colspan='3' align='left'><span class='style33'>".$row[41]."-".$row[42]."-".$row[43]."</span></td></tr></table>";

}

  function Dibujar_Tabla_Comp_Cur_Pedidos($VectorIdioma,$row,$Mensajes,$esAdmin = 1)
 //$esAdmin indica si el usuario que esta viendo la tabla es un usuario comun (caso por defecto) o un administrador
 //lo que cambia es que los administradores podrán ver tanto archivos pdf como arb. Los Usuarios no, solo los pdf.
 {
      echo '<table width="95%" align="center" cellpadding="0" cellspacing="1" bgcolor="#ECECEC">
                  <tr>
                    <td width="162"></td>
                  </tr>
                  <tr class="style22">
                    <td width="162" height="18" align="right" valign="middle" class="style33"><div align="right"><strong> '.$Mensajes["et-1"].'&nbsp; </strong></div></td>
                    <td width="367" height="18" colspan="4" align="left" valign="middle"><div align="left"> '.Devolver_Tipo_Solicitud($VectorIdioma,$row[0],0).'-<strong class="style33"> '.Devolver_Tipo_Material ($VectorIdioma,$row[4]).'</strong></div></td>
                  </tr>
                  <tr class="style22">
                    <td width="162" height="18" align="right" valign="middle" class="style33"><div align="right"><strong>'.$Mensajes["et-2"].'&nbsp;&nbsp; </strong></div></td>
                    <td width="367" height="18" colspan="4" align="left" valign="middle"><div align="left"> '.$row[1].'</div></td>
                  </tr>
                  <tr class="style22">
                    <td width="162" height="18" align="right" valign="middle" class="style33"><div align="right"><strong> '.$Mensajes["et-3"].'&nbsp; </strong></div></td>
                    <td width="367" height="18" colspan="4" align="left" valign="middle"><div align="left"> '.$row[2].", ".$row[3].'</div></td>
                  </tr>
                  <tr class="style22">
                    <td width="162" height="18" align="right" valign="top" class="style33"><div align="right"><strong> '.$Mensajes["et-4"].'&nbsp; </strong></div></td>
                    <td width="367" height="18" colspan="4" align="left" valign="top"><div align="left"> '.Devolver_Descriptivo_Material($row[4],$row,0,0).'</div></td>
                  </tr>
                  <tr class="style22">
                    <td width="162" height="18" align="right" valign="middle" class="style33"><div align="right"><strong> '.$Mensajes["et-5"].'&nbsp; </strong></div></td>
                    <td width="367" height="18" align="left" valign="middle"><div align="left"> '.$row[35].'</div></td>
                    <td height="18" colspan="2" align="left" valign="middle"><div align="left" class="style33">
                      <div align="right"><strong>'.$Mensajes["et-6"].'&nbsp;'.'</strong></div>
                    </div></td>
                    <td width="123" height="18" align="left" valign="middle"><div align="left">'; if (strlen($row[37])>0){ echo $row[37].", ".$row[38]; }echo '</div></td>
                  </tr>
                  <tr class="style22">
                    <td width="162" height="18" align="right" valign="middle" class="style33"><div align="right"><strong> '.$Mensajes["et-7"].'&nbsp; </strong></div></td>
                    <td height="18" colspan="4" align="left" valign="middle"><div align="left"> '.Devolver_Estado($VectorIdioma,$row[36],0).'</div>                      <div align="left"></div>    
					<div align="left"><strong></strong></div></td>';
					if ($row[44]==1)
        { echo "<td colspan='1' align=left> <img border=0 alt='Observaciones' src='../images/obs.gif'> </td>"; }
               		echo '</tr>';
         
	 
               

                               $unArchivo = array();
$list = array();
global $Id_usuario;
global $Rol;

$list=devolverArchivosDePedido($row[1],$esAdmin);

if ($list) {
 echo "<tr><td colspan='3' align=center><span align='center' class='style49 style50'>";
  for ($i=0;$i<count($list);$i++) {
    $unArchivo = $list[$i];
    if ($esAdmin) //los administradores siempre pueden bajarse archivos
    //farchivos/download.php?Id_Usuario=".$Id_Usuario."&Id_Archivo=".$row[0].
    if ($Rol==2) //es bibliotecario. No puede bajarse los archivos, solo puede verlos
      echo "  <img alt='No tiene permisos para bajarse el archivo' border=0 src='../images/adobe.gif' width='20'>";
    else
      echo " <a href='farchivos/download.php?adm=1&Id_Pedido=".$row[1]."&Id_Usuario=".$Id_usuario."&Id_Archivo=".$unArchivo['Codigo']."'>  <img alt='Archivo disponible para bajar' border=0 src='../images/adobe.gif' width='20'> </a>";
      else  //si es usuario comun, hay que ver bajo que condiciones puede bajarse el archivo
        {
	   $autorizado = puedeBajarse($unArchivo,$row[1]);

           switch ($autorizado)
			{
				case 1:  //puede bajarse sin problemas
				  echo "<a href='farchivos/download.php?Id_Pedido=".$row[1]."&Id_Usuario=".$Id_usuario."&Id_Archivo=".$unArchivo['Codigo']."'><img alt='Archivo disponible para bajar' border=0 src='../images/adobe.gif' width='20'></a>";
				  break;
				case 0: //el archivo no está disponible
				  echo "<img alt='Archivo ya bajado' border=0 src='../images/notadobe.gif' width='20'>";
				  break;
				case -1: //el archivo está disponible, pero el usuario posee problemas (ej. cta. cte. en rojo)
				  echo "<img alt='Archivo no disponible para bajar' border=0 src='../images/adobe.gif' width='20'>";
				  break;
			}

      } //else

   } //for
    echo "</span> </td> </tr>";
 }
 else
  echo "<b> </b>"; //no hago nada, no había archivos para ese pedido

//Fin buscar archivo(s) para el pedido


 echo "<td width='162' height='17' valign='top'><font face='MS Sans Serif' size='1'>&nbsp;</font></td></tr>";
 echo "</table>";

}

function Dibujar_Tabla_Comp_Cur_pequeña($VectorIdioma,$row,$Mensajes,$esAdmin = 1, $esAnulado=0)
{
 
 
   echo Devolver_Descriptivo_Material_pequeña($row[4],$row,0,1,$esAdmin); 

//$Mensajes[et-2] dice Id Pedido.
//Por lo tanto, $row[1] contiene el id del pedido.
//Con éste id puedo buscar los archivos que necesito
//Buscar archivo(s) para el pedido

/*$unArchivo = array();
$list = array();
global $Id_usuario;
global $Rol;

$list=devolverArchivosDePedido($row[1],$esAdmin);
*/
/*if ($list) {
    echo "<td colspan='3' align=center><span align='center' class='style49 style50'>";

  for ($i=0;$i<count($list);$i++) {
    $unArchivo = $list[$i];

	if ($esAdmin==1) //los administradores siempre pueden bajarse archivos
    //farchivos/download.php?Id_Usuario=".$Id_Usuario."&Id_Archivo=".$row[0].
       if ($Rol==2) //es bibliotecario. No puede bajarse los archivos, solo puede verlos
          echo " <img alt='No tiene permisos para bajarse el archivo' border=0 src='../images/pdf.gif' width='20'> ";
       else
          echo " <a href='../pedidos/farchivos/download.php?adm=1&Id_Pedido=".$row[1]."&Id_Usuario=".$Id_usuario."&Id_Archivo=".$unArchivo['Codigo']."'>
              <img alt='Archivo disponible para bajar' border=0 src='../images/pdf.gif' width='20'> </a> ";
     else  //si es usuario comun, hay que ver bajo que condiciones puede bajarse el archivo
        {
if ($esAdmin==2)
	    {
		  $autorizado = puedeBajarseElArchivo($unArchivo,$row[1]);
           switch ($autorizado)
			{
				case 1:  //puede bajarse sin problemas
				  echo " <a href='../pedidos/farchivos/download.php?Id_Pedido=".$row[1]."&Id_Usuario=".$Id_usuario."&Id_Archivo=".$unArchivo['Codigo']."'>
                       <img src='../images/pdf.gif' alt='Archivo disponible para bajar' border=0 width='20' height='20'> </a> ";
				  break;
				case 0: //el archivo no está disponible
				  echo " <img alt='Archivo ya bajado' border=0 src='../images/pdf-cacelled.gif' width='20'> ";
				  break;
				case -1: //el archivo está disponible, pero el usuario posee problemas (ej. cta. cte. en rojo)
				  echo " <img alt='Archivo no disponible para bajar' border=0 src='../images/pdf.gif' width='20'> ";
				  break;
			}  //switch
}
      }  //else
   }   //for
 
 }  //if
 else
 { echo "</tr> </table>"; //no hago nada, no había archivos para ese pedido
 }
//Fin buscar archivo(s) para el pedido
*/
}


function Dibujar_Tabla_Comp_Cur($VectorIdioma,$row,$Mensajes,$esAdmin = 1, $esAnulado=0)
{
 //$esAdmin indica si el usuario que esta viendo la tabla es un usuario comun (caso por defecto) o un administrador
 //lo que cambia es que los administradores podrán ver tanto archivos pdf como arb. Los Usuarios no, solo los pdf.

 echo '<table width="90%"   align="center" cellpadding="0" cellspacing="1" bgcolor="'.Devolver_Color($row[4]).'" ';
 if ($esAnulado)	{
	 echo ' border="1" ';
	 echo " bordercolor='#33CCFF' ";
	}
	else
		{echo ' border="0"> ';}
 echo ' <tr bgcolor="#ECECEC"><td colspan="2" align="center" valign="middle">
	<table width="97%"  border="0" align="center" cellpadding="0" cellspacing="1" >
	<tr valign="bottom">   <!-- tipo y Id -->
	   <td colspan="1" align=left>
	          <span class="style49">
		  <strong class="style29 style40">'.$Mensajes["ec-5"].":".'</strong> ';
 echo Devolver_Tipo_Solicitud($VectorIdioma,$row[0],0);
 echo ' </span></td> 
        <td align=right colspan="3"><span class="style52">'.$Mensajes["et-2"].'</span>';

   if ($esAdmin==1)
      {
 echo '<span class="style49"> <a href="manpedadmc.php?Codigo='.$row[1].'">'.$row[1].'</a></span>&nbsp;';
 }
 else
     {
	 echo '<span class="style49"> '.$row[1].'</span>&nbsp;';
	 }  
   if ($esAdmin==1)
      {
 
 $valor=devolverFormaDePago($row[50]);

 echo '</td>
 </tr>';
 // aca iria con una funcion que le devulva el valor de de la forma de pago
 switch ($valor)
  {
  case 0:
   {
 echo '<tr  valign="top"> <!-- ahora el usuario -->
   <td colspan="3" align=left><span class="style49">
   <span class="style29"><strong>'.$Mensajes["et-3"].' </strong>
   </span>
   '.$row[2].", ".$row[3].'<br><br></td></tr>';
  break;
 }	  
 case 4: 
        {
 echo '<tr  valign="top"> <!-- ahora el usuario -->
   <td colspan="3" align=left><span class="style49">
   <span class="style29"><strong>'.$Mensajes["et-3"].' </strong>
   </span>
   '.$row[2].", ".$row[3].'<img src="../images/admin.gif">'.$row[53].'<br><br></td>
  </tr>';
  break;
}
  case 1:
      {
 echo '<tr  valign="top"> <!-- ahora el usuario -->
   <td colspan="4" align=left><span class="style49">
   <span class="style29"><strong>'.$Mensajes["et-3"].' </strong>
   </span>
   '.$row[2].", ".$row[3].'&nbsp;&nbsp;<img src="../images/admin02.gif">'.$row[53].'<br><br></td>
  </tr>';
break;
}
 case 2:
 {
 echo '<tr  valign="top"> <!-- ahora el usuario -->
   <td colspan="3" align=left><span class="style49">
   <span class="style29"><strong>'.$Mensajes["et-3"].' </strong>
   </span>
   '.$row[2].", ".$row[3].'<img src="../images/admin03.gif">'.$row[53].'<br><br></td>
  </tr>';
  break;
 }
   }// de switch
}
else
{
 echo '<tr  valign="top"> <!-- ahora el usuario -->
   <td colspan="3" align=left><span class="style49">
   <span class="style29"><strong>'.$Mensajes["et-3"].'</strong>
   </span>
   '.$row[2].", ".$row[3].'&nbsp;&nbsp;&nbsp;'.$row[53].'<br><br></td>
  </tr>';

}
  echo'<tr valign="bottom"> <!-- datos-->
   <td colspan="4" width="612" align=left ><span class="style49">
         <span class="style29"><strong>'.$Mensajes["et-4"].'</strong>	</span>';
   echo Devolver_Descriptivo_Material($row[4],$row,0,0).'</span> 
          </td>'; //Titulo revista, vol, anio,...
   echo '</tr>
<tr valign="bottom"> <!-- Fecha de solicitud-->
  <td align=left colspan="3" width="612"><span class="style49"><span class="style52">'.$Mensajes["et-5"].'</span> '.$row[35].'</span></td>
  
</tr> <tr valign=top>';

echo '<td align=left width="240"><span class="style52">'.$Mensajes["et-7"].'</span> <span class="style49">'.Devolver_Estado($VectorIdioma,$row[36],0).'</span></td>';

if ($row[44]==1)
    { echo "<td  align=left width=39> <img border=0 alt='Observaciones' src='../images/obs.gif'> </td>"; }
    else
    echo "<td  align=left width=39> &nbsp; </td>"; 

echo '  <td colspan="2" width="446"align=right> <span class="style49"> <span class="style52">'.$Mensajes["et-6"].'</span> ';
  if (strlen($row[37])>0)
     { echo $row[37].", ".$row[38]."</span></td>"; } //operador




//$Mensajes[et-2] dice Id Pedido.
//Por lo tanto, $row[1] contiene el id del pedido.
//Con éste id puedo buscar los archivos que necesito
//Buscar archivo(s) para el pedido

$unArchivo = array();
$list = array();
global $Id_usuario;
global $Rol;

$list=devolverArchivosDePedido($row[1],$esAdmin);

if ($list) {
    echo "<td colspan='3' align=center><span align='center' class='style49 style50'>";
  for ($i=0;$i<count($list);$i++) {
    $unArchivo = $list[$i];

    if ($esAdmin==1) //los administradores siempre pueden bajarse archivos
    //farchivos/download.php?Id_Usuario=".$Id_Usuario."&Id_Archivo=".$row[0].

	   if ($Rol==2) //es bibliotecario. No puede bajarse los archivos, solo puede verlos
          
		  echo " <img alt='No tiene permisos para bajarse el archivo' border=0 src='../images/pdf.gif' width='20'> ";
       else
          echo " <a href='farchivos/download.php?adm=1&Id_Pedido=".$row[1]."&Id_Usuario=".$Id_usuario."&Id_Archivo=".$unArchivo['Codigo']."'>
              <img alt='Archivo disponible para bajar' border=0 src='../images/pdf.gif' width='20'> </a> ";
     else  //si es usuario comun, hay que ver bajo que condiciones puede bajarse el archivo
        {
	   
	   if ($esAdmin==2)
	    {
		  $autorizado = puedeBajarseElArchivo($unArchivo,$row[1]);
           switch ($autorizado)
			{
				case 1:  //puede bajarse sin problemas
				  echo " <a href='farchivos/download.php?Id_Pedido=".$row[1]."&Id_Usuario=".$Id_usuario."&Id_Archivo=".$unArchivo['Codigo']."'>
                       <img src='../images/pdf.gif' alt='Archivo disponible para bajar' border=0 width='20' height='20'> </a> ";
				  break;
				case 0: //el archivo no está disponible
				  echo " <img alt='Archivo ya bajado' border=0 src='../images/pdf-cacelled.gif' width='20'> ";
				  break;
				case -1: //el archivo está disponible, pero el usuario posee problemas (ej. cta. cte. en rojo)
				  echo " <img alt='Archivo no disponible para bajar' border=0 src='../images/pdf.gif' width='20'> ";
				  break;
			}  //switch
   }//del id
   else
   {			  echo " <img alt='Archivo no disponible para bajar' border=0 src='../images/pdf.gif' width='20'> ";}
      }  //else
   }   //for
   echo "</span> </td> </tr> </table>";
 }  //if
 else
 { echo "</tr> </table>"; //no hago nada, no había archivos para ese pedido
 }
//Fin buscar archivo(s) para el pedido

}
function Dibujar_Tabla_Comp_Hist_Ped($VectorIdioma,$row,$Mensajes,$Boton,$esAdmin=0)
{
?>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="<? echo Devolver_Color($row[4]);?>" >
	<tr bgcolor="#ECECEC">
		<td colspan="2" align="center" valign="middle">
		<table width="97%"  border="0" align="center" cellpadding="0" cellspacing="1" >
		<tr valign="bottom">   <!-- tipo y Id -->
			<td  colspan=4  align=left>
	          <span class="style49">
				  <strong class="style29 style40"><? echo $Mensajes["et-1"]."</strong>".Devolver_Tipo_Solicitud($VectorIdioma,$row[0],0).'-'.Devolver_Tipo_Material ($VectorIdioma,$row[4]);?>
			  </span></td> 
			<td align=right   ><span class="style52"><? echo $Mensajes["et-2"];?></span><span class="style49"> <a href="manpedadmc.php?Codigo=<? echo $row[1];?>"><? echo $row[1]; ?></a></span>&nbsp;</td>
		</tr>
		<tr  valign="top"> <!-- ahora el usuario -->
		   <td colspan="6" align=left>
		   <span class="style29"><strong><? echo $Mensajes["et-3"]; ?> </strong>
		   </span><? echo $row[2].", ".$row[3]; ?> <br><br></td>
		</tr>

	   <tr valign="bottom"> <!-- datos-->
		   <td colspan="6" width="612" align=left ><span class="style49"><span class="style29"><strong><? echo $Mensajes["et-4"]; ?> </strong>	</span><? echo Devolver_Descriptivo_Material($row[4],$row,1,0); ?> </span> <br><br></td> <!--  //Titulo revista, vol, anio,...-->
		</tr>
		<tr valign="bottom"> <!-- Fecha de solicitud-->
			<td align=left colspan="3" width="612"><span class="style49"><span class="style52"><?  echo $Mensajes["et-5"]; ?> </span> <? echo $row[35] ?> </span></td>  
			<td align=left colspan="3" width="612"><span class="style49"><span class="style52"><?  echo $Mensajes["et-10"]; ?> </span> <? echo $row[37] ?> </span></td>  
		</tr>
		<tr valign=top>
			<td align=left <? if ($row[44] != 1)  echo "colspan='6'"; else echo "colspan='3'"?> width="240"><span class="style52"><? echo $Mensajes["et-7"]?></span> <span class="style49"><? echo Devolver_Estado($VectorIdioma,$row[36],0) ?></span></td><?
		if ($row[44]==1)
		    { echo "<td  align=left width=39> <img border=0 alt='Observaciones' src='../images/obs.gif'> </td>"; }?>

		<? $Suma = $row[38]+$row[39]+$row[40]; ?>
		<tr valign="bottom"> <!-- Recibido por-->
			<td align=left colspan=6 ><br><span class="style49"><span class="style52"><?  echo $Mensajes["et-11"]; ?> </span> <? echo $row[41].'-'.$row[42].'-'.$row[43].' '.$Mensajes["tf-5"].$Suma.' '.$Mensajes["tf-6"]; ?> </span><div align=right>
		<!--	<?  
			 if ($Boton){?>
				<input type='button' value='Ver' name='B3' class='style22'OnClick="rutear_PedHist(<? echo $row[4]?>, '<? echo $row[1];?>')" ><?
				}?>--></div>
			</td>
		</tr>
<?
		 /* Gonzalo */
		$unArchivo = array();
		$list = array();
		global $Id_usuario;

		$list=devolverArchivosDePedido($row[1],$esAdmin);

		if ($list) {
		  echo '<tr valign="bottom"><td align=left colspan=4 > ';
		  for ($i=0;$i<count($list);$i++) {
			$unArchivo = $list[$i];
			if ($esAdmin) //los administradores siempre pueden bajarse archivos
			//farchivos/download.php?Id_Usuario=".$Id_Usuario."&Id_Archivo=".$row[0].
			  echo " <a href='farchivos/download.php?adm=1&Id_Pedido=".$row[1]."&Id_Usuario=".$Id_usuario."&Id_Archivo=".$unArchivo['Codigo']."'>  <img alt='Archivo disponible para bajar' border=0 src='../images/adobe.gif' width='20'> </a>";
			  else  //si es usuario comun, hay que ver bajo que condiciones puede bajarse el archivo
				echo "<img alt='Archivo ya bajado' border=0 src='../images/notadobe.gif' width='20'>";
		   }
		   echo "</td> </tr> ";
		 }

?>
		</td></tr>

</table></table><?
//echo '<table border="0" width="95%" align="center" cellpadding="0" cellspacing="1" bgcolor="#ECECEC">';
/*echo ' <tr>';
echo '<td width="162"></td>';
echo '</tr>';
echo '<tr class="style22">';
echo '<td height="18" align="right" valign="middle" class="style33"><div align="right"><strong>'.$Mensajes["et-1"].'&nbsp; </strong></div></td>';
echo '<td width="367" height="18" colspan="3" align="left" valign="middle"><div align="left">'.Devolver_Tipo_Solicitud($VectorIdioma,$row[0],0).'-';
echo Devolver_Tipo_Material ($VectorIdioma,$row[4]).'</div></td>';
echo '</tr>';
*//*
echo '<tr class="style22">';
echo '<td height="18" align="right" valign="top" class="style33"><div align="right"><strong>'.$Mensajes["et-4"].'&nbsp;</strong></div></td>';
echo '<td width="367" height="18" colspan="3" align="left" valign="top"><div align="left">'.Devolver_Descriptivo_Material ($row[4],$row,0,0).'</div></td>';
echo '</tr>';*/
/*
echo '<tr class="style22">';
echo '<td height="18" align="right" valign="middle" class="style33"><div align="right"><strong>'.$Mensajes["et-5"].'&nbsp; </strong></div></td>';
echo '<td height="18" align="left" valign="middle"><div align="left">'.$row[35].'</div></td>';
echo '<td align="left" valign="middle"><div align="left" class="style33">';
echo '<div align="right"><strong>'.$Mensajes["et-10"].'&nbsp;</strong></div>';
echo '</div></td>';
echo '<td height="14" align="left" valign="middle"><div align="left">'.$row[37].'</div></td>';
echo '</tr>';
*//*
echo '<tr class="style22">';
echo '<td height="18" align="right" valign="middle" class="style33"><div align="right"><strong>'.$Mensajes["et-2"].'&nbsp; </strong></div></td>';
echo '<td height="18" align="left" valign="middle"><div align="left">'.$row[1].'</div></td>';
echo '</tr>';
*/

/*
$Suma = $row[38]+$row[39]+$row[40];
echo '<tr class="style22">';
echo '<td height="18" align="right" valign="middle" class="style33"><div align="right"><strong>'.$Mensajes["et-11"].'</strong></div></td>';
echo '<td height="18" colspan="3" align="left" valign="middle"><div align="left">'.$row[41].'-'.$row[42].'-'.$row[43].' '.$Mensajes["tf-5"].$Suma.' '.$Mensajes["tf-6"].'</div>';
echo '<div align="left"></div>';
echo '<div align="left"><strong></strong></div></td>';
echo '</tr><tr class="style22">';
echo '<td height="18" align="right" valign="middle" class="style33">&nbsp;</td>';
echo '<td height="18" colspan="3" align="left" valign="middle">';*/
/* if ($Boton)
 {
   echo "<input type='button' value='Ver' name='B3' class='style22' OnClick=\"rutear_PedHist(".$row[4].",'".$row[1]."')\">";
 }
 echo "</font></td></tr>";
*/
 /* Gonzalo */
 /*
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
      echo " <a href='farchivos/download.php?adm=1&Id_Pedido=".$row[1]."&Id_Usuario=".$Id_usuario."&Id_Archivo=".$unArchivo['Codigo']."'>  <img alt='Archivo disponible para bajar' border=0 src='../images/adobe.gif' width='20'> </a>";
      else  //si es usuario comun, hay que ver bajo que condiciones puede bajarse el archivo
        echo "<img alt='Archivo ya bajado' border=0 src='../images/notadobe.gif' width='20'>";
   }
   echo "</td> </tr> ";
 }
 else
  echo "<b> </b>"; //no hago nada, no había archivos para ese pedido
*/ 
/*termino Gonzalo */
// echo "</table></div></center>" ;
                      
                      

			  
			  
	                
                      
                      
  /*  --------------------viejo--------------------------
     echo "<center>";
 echo "<div align='left'>";
 echo "<table border='0' width='100%' cellspacing='0' cellpadding='0' height='42' bgcolor='".Devolver_Color($row[4])."'>";
 echo "<tr><td colspan='7' height='9' background='../images/banda.jpg' width='438'>";
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
*/
 /* Gonzalo */
 /*$unArchivo = array();
$list = array();
global $Id_usuario;

$list=devolverArchivosDePedido($row[1],$esAdmin);

if ($list) {
  echo "<tr> <td> ";
  for ($i=0;$i<count($list);$i++) {
    $unArchivo = $list[$i];
    if ($esAdmin) //los administradores siempre pueden bajarse archivos
    //farchivos/download.php?Id_Usuario=".$Id_Usuario."&Id_Archivo=".$row[0].
      echo " <a href='farchivos/download.php?adm=1&Id_Pedido=".$row[1]."&Id_Usuario=".$Id_usuario."&Id_Archivo=".$unArchivo['Codigo']."'>  <img alt='Archivo disponible para bajar' border=0 src='../images/adobe.gif' width='20'> </a>";
      else  //si es usuario comun, hay que ver bajo que condiciones puede bajarse el archivo
        echo "<img alt='Archivo ya bajado' border=0 src='../images/notadobe.gif' width='20'>";
   }
   echo "</td> </tr> ";
 }
 else
  echo "<b> </b>"; //no hago nada, no había archivos para ese pedido

/*termino Gonzalo */
 /*echo "</table></div></center>" ;
   */                   
                      
}

function Dibujar_Tabla_Comp_Hist ($VectorIdioma,$row,$Mensajes,$Boton, $esAdmin = 0)
{ $Suma = $row[38]+$row[39]+$row[40];
echo '
     
	 <tr bgcolor="'.Devolver_Color($row[4]).'">
       <td height="20" colspan="2" bgcolor="'.Devolver_Color($row[4]).'" class="style23 style39">
         <table width="97%"  border="0" align="center" cellpadding="0" cellspacing="1">
            <tr class="style23">
              <td colspan="4" align=left><strong class="style29 style40">Tipo Pedido:     </strong>'.Devolver_Tipo_Solicitud($VectorIdioma,$row[0],0).'-'.Devolver_Tipo_Material ($VectorIdioma,$row[4]).'
              </td>
            </tr>
            <tr class="style23">
              <td colspan="6" align=left><span class="style41">Datos Pedido:</span> '.Devolver_Descriptivo_Material ($row[4],$row,1,0).' </td>
            </tr>
            <tr class="style23">
              <td align=left colspan="2"><span class="style41">Fecha Alta:</span> '.$row[35].' </td>
              <td align=left colspan="1"><span class="style41">Recepci&oacute;n: </span>'.$row[37].'</td>
              <td align=left colspan="3"><span class="style41">Id Pedido: </span>'.$row[1].'</td>
            </tr>
            <tr class="style23">
             <td colspan="6" align=left><span class="style41">Recibido de: </span> '.$row[41].'-'.$row[42].'-'.$row[43].' '.$Mensajes['tf-5'].' '.$Suma.' '.$Mensajes['tf-6'].'
             </td>
            </tr>
            <tr>';

$unArchivo = array();
$list = array();
global $Id_usuario;
global $Rol;

$list=devolverArchivosDePedido($row[1],$esAdmin);

if ($list) {
    echo "<td colspan='3' align=left><div align='center' class='style49 style50'>";
  for ($i=0;$i<count($list);$i++) {
    $unArchivo = $list[$i];
    if ($esAdmin) //los administradores siempre pueden bajarse archivos
    //farchivos/download.php?Id_Usuario=".$Id_Usuario."&Id_Archivo=".$row[0].
       if ($Rol==2) //es bibliotecario. No puede bajarse los archivos, solo puede verlos
          echo " <img alt='No tiene permisos para bajarse el archivo' border=0 src='../images/pdf.gif' width='20'> ";
       else
          echo " <a href='farchivos/download.php?adm=1&Id_Pedido=".$row[1]."&Id_Usuario=".$Id_usuario."&Id_Archivo=".$unArchivo['Codigo']."'>
              <img alt='Archivo disponible para bajar' border=0 src='../images/pdf.gif' width='20'> </a> ";
     else  //si es usuario comun, hay que ver bajo que condiciones puede bajarse el archivo
        {
	   $autorizado = puedeBajarse($unArchivo,$row[1]);

           switch ($autorizado)
			{
				case 1:  //puede bajarse sin problemas
				  echo " <a href='farchivos/download.php?Id_Pedido=".$row[1]."&Id_Usuario=".$Id_usuario."&Id_Archivo=".$unArchivo['Codigo']."'>
                       <img src='../images/pdf.gif' alt='Archivo disponible para bajar' border=0 width='20' height='20'> </a> ";
				  break;
				case 0: //el archivo no está disponible
				  echo " <img alt='Archivo ya bajado' border=0 src='../images/pdf-cacelled.gif' width='20'> ";
				  break;
				case -1: //el archivo está disponible, pero el usuario posee problemas (ej. cta. cte. en rojo)
				  echo " <img alt='Archivo no disponible para bajar' border=0 src='../images/pdf.gif' width='20'> ";
				  break;
			}  //switch

      }  //else
   }   //for
   echo "</div> </td>
               <td align='right'>
                <span align='right'>
                <input type='button' value='Ver' class='style23' onClick=rutear_PedHist('".$row[4]."','".$row[1]."')>
              </span>
              </td> </tr> </table>";
 }  //if
 else
 { echo "<td colspan='3' align=left> &nbsp; </td> <td align='right'>
                <span align='right'>
                <input type='button' value='Ver' class='style23' onClick=rutear_PedHist('".$row[4]."','".$row[1]."')>
              </span>
              </td> </tr> </table>"; //no hago nada, no había archivos para ese pedido
 }
//Fin buscar archivo(s) para el pedido

 echo '
       </td>
     </tr>
      ';
}

?>
