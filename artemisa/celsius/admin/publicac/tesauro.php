<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>PrEBi</title>
<?

include_once "../../inc/"."conexion.inc.php";
Conexion();
include_once "../../inc/var.inc.php";
include_once "../../inc/"."identif.php";
Usuario();
  if (!isset($tipobusqueda))	$tipobusqueda=1;
  if (!isset($Busca))			$Busca="";
  if (!isset($Id))				$Id="";
  if (!isset($Tabla))			$Tabla="";
  if (!isset($Alias_Id))		$Alias_Id="";
  if (!isset($Alias_Comunidad))	$Alias_Comunidad="";
  if (!isset($Bandeja))			$Bandeja="";  
  if (!isset($Instit_Alias))	$Instit_Alias="";
  if (!isset($Id_Col))			$Id_Col="";
  if (!isset($CantAutor))		$CantAutor="";
  if (!isset($dedonde))			$dedonde=1;





?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
body {
	background-color: #006599;
	margin-left: 10px;
	margin-right:0px; margin-top:0px; margin-bottom:0px
}
body, td, th {
	color: #000000;
}
a:link {
	color: #006599;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #006599;
}
a:hover {
	text-decoration: underline;
	color: #0099FF;
}
a:active {
	text-decoration: none;
	color: #006599;
}
.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 9px; }
.style28 {color: #FFFFFF; font-size: 11px; }
.style43 {
	font-family: verdana;
	font-size: 10px;
}
.style45 {font-family: Verdana; color: #FFFFFF;}
.style46 {
	color: #006599;
	font-family: verdana;
	font-size: 10px;
	font-style: normal;
	font-weight: bold;
}
.style47 {font-size: 11px}
.style48 {color: #006599}
.style49 {font-family: verdana; font-size: 10px; color: #006599; }
.style51 {font-family: verdana; color: #000000; }
.style52 {color: #000000}
.style54 {font-family: verdana; font-size: 10px; color: #000000; }
.style55 {
	font-size: 10px;
	color: #000000;
	font-family: Verdana;
}
.style56 {font-family: Verdana}
.style57 {font-size: 10px}
-->
</style>
<script language="JavaScript">
function recargo(Valor)
{
	document.forms.form1.Letra.value= Valor;
	document.forms.form1.Busca.value = "";
	document.forms.form1.action = "tesauro.php";
	document.forms.form1.submit();
}

function recargo1()
{
	//document.forms.form1.Letra.value= Valor;
	document.forms.form1.Letra.value = document.forms.form1.Busca.value ;
	document.forms.form1.action = "tesauro.php";
	document.forms.form1.submit();
}

function retornaSin()
{
  document.forms.form1.action = "../indexadm.php";
  document.forms.form1.submit();

}


</script>

<base target="_self">
</head>

<body topmargin="0">
<?
   include_once "../../inc/"."fgenped.php";
   include_once "../../inc/"."fgentrad.php";
   global  $IdiomaSitio;
   $Mensajes = Comienzo ("tes-001",$IdiomaSitio);
   $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);


 ?>

<div align="left">
<a name="arriba">
<form method="POST" name="form1" onSubmit="recargo1();">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">      <div align="center"><center>
        <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#EFEFEF">
        <td bgcolor="#E4E4E4">
            <div align="center">
              <center>
            <table width="576" border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
              <tr>
                <td valign="top" bgcolor="#E4E4E4"><table width="100%"  border="0" cellpadding="0" cellspacing="0" class="style43">
                  <tr>
                    <td height="20" colspan="3" align="left" bgcolor="#006599" class="style45"><img src="../images/square-lb.gif" width="8" height="8"><? echo $Mensajes["tf-1"]; ?> <?
					if ($Busca != ""){echo $Letra;}else{echo $Busca;} ?> </td>
                  </tr>
                  <tr>
                    <td colspan="3" align="left" class="style45">
                      <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="50%" valign="top"><br>                            <table width="95%"  border="0" align="center" cellpadding="1" cellspacing="0">
                              <tr valign="top">
                                <td><div align="right"><span class="style46"><? echo $Mensajes["tf-2"]; ?> </span></div></td>
                                <td align="left">
                                  <input  type="text" class="style49" name="Busca" <? if ($Busca != ""){ echo "value='".$Busca."'";} ?> >
                                  <br>
                            	  <select name="tipobusqueda" class="style43">
             		  	<option value=1 <? if ($tipobusqueda=="" || $tipobusqueda==1) { echo " selected"; }  ?>><? echo $Mensajes["sel-1"]; ?></option>
			            <option value=2 <? if ($tipobusqueda==2) { echo " selected"; }  ?>><? echo $Mensajes["sel-2"]; ?></option>
             			<option value=3 <? if ($tipobusqueda==3) { echo " selected"; }  ?>><? echo $Mensajes["sel-3"]; ?></option>
                        	   </select>
                                  <br>
                                  <input name="Submit2" type="submit" class="style43" value="Buscar texto" OnClick="recargo1();"></td>
                              </tr>
                            </table>                            </td>
                          <td valign="top">
                          <div align="center">
                            <center>
                            <br>
                            <table width="260"  border="0" cellspacing="1" style="border-collapse: collapse" bordercolor="#111111">
                            <tr class="style43">
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('A')">A</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('B')">B</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('C')">C</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('D')">D</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('E')">E</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('F')">F</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('G')">G</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('H')">H</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('I')">I</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('J')">J</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('K')">K</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('L')">L</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('M')">M</a></div></td>
                            </tr>
                            <tr class="style43">
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('N')">N</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('O')">O</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('P')">P</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('Q')">Q</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('R')">R</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('S')">S</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('T')">T</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('U')">U</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('V')">V</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('W')">W</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('X')">X</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('Y')">Y</a></div></td>
                              <td width="20" bgcolor="#ECECEC"><div align="center"><a href="javascript:recargo('Z')">Z</a></div></td>
                            </tr>
                          </table>
                            </center>
                          </div>
                            <div align="center">                                
                              <p>
                                <input name="Submit" type="submit" class="style43" value="Volver sin seleccionar" OnClick="retornaSin();">
                                <input type="hidden" name="CantAutor" value="<? echo $CantAutor; ?>">
                                <input type="hidden" name="dedonde" value="<? echo $dedonde; ?>">
                                <input type="hidden" name="adonde" value="<? echo $adonde; ?>">
                                <input type="hidden" name="Letra" value="<? echo $Letra; ?>">
                                <input type="hidden" name="Id" value="<? echo $Id; ?>">
                                <input type="hidden" name="Alias_Id" value=<? echo $Alias_Id; ?>>
                                <input type="hidden" name="Instit_Alias" value=<? echo $Instit_Alias; ?>>
                                <input type="hidden" name="Alias_Comunidad" value="<? echo $Alias_Comunidad; ?>">
                                <input type="hidden" name="Bandeja" value="<? echo $Bandeja; ?>">
                                <input type="hidden" name="Tabla" value="<? echo $Tabla; ?>">
                                <input type="hidden" name="Id1" value="<? echo $Id1; ?>">
                                <input type="hidden" name="Nombre1" value="<? echo $Nombre1; ?>">
                                <br>
                                  </p>
                              </div></td>
                        </tr>
                      </table>
      </form>
                      <hr>
<?
   $expresion = "SELECT Nombre,Abreviado,ISSN,Id FROM Titulos_Colecciones";
   switch ($tipobusqueda)
   {
   	case 2:
		$expresion.=" WHERE Abreviado LIKE '".AddSlashes($Letra)."%' ORDER BY Abreviado";
		break;
	case 3:
		$expresion.=" WHERE ISSN LIKE '".AddSlashes($Letra)."%' ORDER BY ISSN";
		break;
	default:
		$expresion.=" WHERE Nombre LIKE '".AddSlashes($Letra)."%' ORDER BY Nombre";
   }

  $cantidad=20; // cantidad de resultados por p?ina
		if (! isset($pg))
			{
				$inicial=0;
				$pg =1;
			}
		else
			{
			$inicial = ($pg-1) * $cantidad;
			}

	$resultado_total = mysql_query($expresion);
	$expresion.= " LIMIT ".$inicial .", ". $cantidad;
/*
	ECHO $Id_Col;
	ECHO $adonde;
	ECHO $Busca;
	ECHO $Letra;
*/	
   
   $result = mysql_query($expresion);
   echo mysql_error();
   $total_records = mysql_num_rows($resultado_total);

   $pages = ceil($total_records / $cantidad);
   //Paginado de los resultados
   $decena_actual= intval( $pg / 10);
   if ($decena_actual ==0)
		$decena_actual = 0.1; // Para el caso de que este el la decena 0
   $desde = $decena_actual * 10; // Calculo de la pagina inicial
   $fin_decena= $desde + 9;
   if ($pages > $fin_decena)
				$hasta= $fin_decena;
		    else
			    $hasta = $pages;
   echo '<table    border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#ECECEC"><tr>' ;
   if ($pg > 1)
					{
						$url = $pg - 1;
						echo "<td class='style43'><a href='tesauro.php?Id_Col".$Id_Col."&adonde=".$adonde."&Letra=".$Letra."&pg=".$url."'> &lt;&lt;&nbsp;</a></td>";
					}
   for ($i = $desde; $i<=$hasta ; $i++) {
					if ($i == $pg)  
						{   if ($total_records > $cantidad)
							echo "<td class='style43'><strong>$i</strong></td>";
						

						}
						else 
						{

							echo "<td class='style43' ><a  href='tesauro.php?Id_Col".$Id_Col."&adonde=".$adonde."&Letra=".$Letra."&pg=".$i."'>".$i."</a>&nbsp;</td>";
							
						}
						if (($i+1) <= $hasta ){
							echo "<td class='style43'>&nbsp;|&nbsp;</td>";
							}
					}

				if ($pg < $pages) 
						{
							$url = $pg + 1;
		 					echo "<td class='style43'><a href='tesauro.php?Id_Col".$Id_Col."&adonde=".$adonde."&Letra=".$Letra."&pg=".$url."'>&gt;&gt;</a></td>";
						}
										
						
	echo '</tr></table><br>';
    while($row = mysql_fetch_row($result))
    {
?>			
            <table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#ECECEC">
                        <tr>
     
     <td class="style43" colspan="2" align="left">
      <? echo $row[0] ; ?>
     <td class="style43" valign="middle"><?echo $row[1]; ?><td class="style43" valign="middle">
  </tr>
						<tr>
                          <td class="style43">
                        	  <? if ($adonde==1)
       { ?>
        <a href="union_pub.php?&Id1=<? echo $row[3]; ?>&Nombre1=<? echo $row[0]; ?>">
     <? } else { ?>
        <a href="union_pub.php?&Id1=<? echo $Id1; ?>&Nombre1=<? echo $Nombre1; ?>&Id2=<? echo $row[3]; ?>&Nombre2=<? echo $row[0]; ?>">
     <? }  
        echo $Mensajes["h-4"]; ?></a>
                              </td>
                        </tr>
                      </table>                      
                      <br>
 <?
   }
    mysql_free_result($result);
   Desconectar();
?>
        </td>
         </tr>
         <tr> <td align=center> <a href="#arriba"> ^ Top </a> </td> </tr>
         </table>
          </td>
            </tr>
            </table>
              </center>
            </div>
            </td>
        <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
          <table width="100%" bgcolor="#ececec">
            <tr>
              <td class="style28"><div align="center"></div>                <div align="center" class="style55"><img src="../../images/image001.jpg" width="150" height="118"></div></td>
            </tr>
          </table>
          </div>
          </td>
        </tr>
    </table>    </center>
      </div>    </td>
  </tr>
  <tr>
    <td height="44" bgcolor="#E4E4E4"><div align="center">      
      <hr>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50" class="style49"><div align="center" class="style11">tes-001</div></td>
        </tr>
      </table>
      </div></td>
  </tr>
</table>
</div>
</body>
</html>

