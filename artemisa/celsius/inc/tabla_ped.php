<?
/*if (__Tabla_inc == 1)
	return;
	
    define ('__Tabla_inc', 1); */
 
	include_once "tabla_ped.inc";


 function Dibujar_Tabla_Comp_Cur ($VectorIdioma,$row,$Mensajes)
 {
 

 
 echo "<center>";
 echo "<div align='left'>";
 echo "<table border='0' width='533' cellspacing='0' cellpadding='0' height='42' bgcolor='".Devolver_Color($row[4])."'";
 echo "<td width='162'><tr>";  
 echo "<td width='162' height='17' valign='middle' align='right'><b><font face='MS Sans Serif' size='1'>";
 echo $Mensajes["et-1"]."&nbsp;</font></b><font face='MS Sans Serif' size='1'>&nbsp;</font></td>";
 echo "<td width='367' height='17' valign='middle' align='left' colspan='4'>";
 echo "<font face='MS Sans Serif' size='1' color='#000080'>";
 
 echo Devolver_Tipo_Solicitud($VectorIdioma,$row[0],0)."-";
 
 echo "<b>".Devolver_Tipo_Material ($VectorIdioma,$row[4])."</b></font></td></tr><tr></tr>";
 echo "<td width='162' height='17' valign='middle' align='right'><b><font face='MS Sans Serif' size='1'>".$Mensajes["et-2"]."&nbsp;&nbsp;</font></b></td>";
 echo "<td width='367' height='17' valign='middle' align='left' colspan='4'>"; 
 echo "<font face='MS Sans Serif' size='1' color='#000080'>".$row[1]."</font></td></tr><tr>"; 
 echo "<td width='162' height='17' valign='middle' align='right'><b><font face='MS Sans Serif' size='1'>".$Mensajes["et-3"]."&nbsp;</font></b></td>";
 echo "<td width='367' height='17' valign='middle' align='left' colspan='4'><font face='MS Sans Serif' size='1' color='#000080'>".$row[2].",".$row[3]."</font></td></tr><tr>";
 echo "<td width='162' height='17' valign='top' align='right'><b><font face='MS Sans Serif' size='1'>".$Mensajes["et-4"]."&nbsp;</font></b></td>";
 echo "<td width='367' height='17' valign='top' align='left' colspan='4'><font face='MS Sans Serif' size='1' color='#000080'>";
 
 echo Devolver_Descriptivo_Material($row[4],$row,0,0)."</font></td></tr><tr>";
  
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
 echo "</font></td></tr><tr>";
 echo "<td width='162' height='17' valign='top'><font face='MS Sans Serif' size='1'>&nbsp;</font></td></tr>";
 echo "</table>";
 
}

function Dibujar_Tabla_Comp_Hist ($VectorIdioma,$row,$Mensajes,$Boton)
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
