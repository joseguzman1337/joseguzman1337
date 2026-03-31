<?
$pageName = "estadisticas1";
require_once "../common/includes.php";
require_once "metodos_estadisticas.php";
?>
<html>
<head>
<?


if (!isset ($Paises))
	$Paises = "";
if (!isset ($Instituciones))
	$Instituciones = "";
if (!isset ($Dependencias))
	$Dependencias = "";
if (!isset ($Modalidad))
	$Modalidad = 2;
if (!isset ($Caja))
	$Caja = 0;
if (!isset ($TipoGrafico))
	$TipoGrafico = 2;
?>  
<script language="JavaScript">
tabla_Paises = new Array;
tabla_val_Paises = new Array;

tabla_Instituciones = new Array;
tabla_val_Instit = new Array;
tabla_Long_Instit = new Array; 

tabla_dependencias = new Array;
tabla_val_Dep = new Array;
tabla_Long_Dep = new Array; 

// Estas representan las opciones que usan Institucion y Dependencia
// lo devuelve como un vector la funcion PHP y se comparan desde
// JavaScript

vector_usa = [<? echo "3,6" ?>];

  <?

armarScriptPaises("tabla_Paises", "tabla_val_Paises");
armarScriptInstituciones("tabla_Instituciones", "tabla_val_Instit", "tabla_Long_Instit");
armarScriptDependencia("tabla_dependencias", "tabla_val_Dep", "tabla_Long_Dep");
/*  		  $Instruccion = "SELECT Id,Nombre FROM paises ORDER BY Nombre";	
         $result = mysql_query($Instruccion);   
         if (mysql_num_rows($result)>0)
         {
           $contpaises=0;
           while ($row =mysql_fetch_row($result))
           {
             echo "tabla_Paises[".$contpaises."]='".$row[1]."';\n";
             echo "tabla_val_Paises[".$contpaises."]=".$row[0].";\n";
             $contpaises ++;
             
           }
           echo "contpaises=".$contpaises;
         }  
  		  
         echo "// Armo el vector de Instituciones\n";
         echo "\n";
                   
         $Instruccion = "SELECT Codigo_Pais,Nombre,Codigo FROM instituciones ORDER BY Codigo_Pais,Nombre";	
         $result = mysql_query($Instruccion);   
         if (mysql_num_rows($result)>0)
         {
           while ($row =mysql_fetch_row($result))
           {
           	 If (!($Indice[$row[0]]>0))
           	 {
                $Indice[$row[0]]=0;
                echo "\n";
            	  echo "tabla_Instituciones[".$row[0]."]=new Array;\n";
            	  echo "tabla_val_Instit[".$row[0]."]=new Array;\n";            
        	     }
           	 echo "tabla_Instituciones[".$row[0]."][".$Indice[$row[0]]."]='".$row[1]."';\n";
               echo "tabla_val_Instit[".$row[0]."][".$Indice[$row[0]]."]=".$row[2].";\n";
           
               $Indice[$row[0]]+=1;
            }
          
            echo "//Reflejo las longitudes de los vectores\n";
            while (list($key,$valor)=each($Indice))
            {	
          		echo "tabla_Long_Instit[".$key."]=".$valor.";\n";
            }		                              
         }
         
		  echo "\n";
         echo "//Armo el vector de Dependencias \n";
	
         $Instruccion = "SELECT Codigo_Institucion,Nombre,Id FROM dependencias ORDER BY Codigo_Institucion,Nombre";	
         $result = mysql_query($Instruccion);   
         if (mysql_num_rows($result)>0)
		  {
           while ($row =mysql_fetch_row($result))
           {            
           		
          If (!($Ind[$row[0]]>0))
           	 {
                $Ind[$row[0]]=0;
            	  echo "tabla_dependencias[".$row[0]."]=new Array;\n";
            	  echo "tabla_val_Dep[".$row[0]."]=new Array;\n";
				  echo "\n";	
        	     }
           	 echo "tabla_dependencias[".$row[0]."][".$Ind[$row[0]]."]='".$row[1]."';\n";
               echo "tabla_val_Dep[".$row[0]."][".$Ind[$row[0]]."]=".$row[2].";\n";
           
               $Ind[$row[0]]+=1;
            }
          
            echo "//Reflejo las longitudes de los vectores\n";
            echo "\n";
            
            while (list($key1,$valor1)=each($Ind))
            {
          		   echo "tabla_Long_Dep[".$key1."]=".$valor1.";\n";
            }		                              
         }
*/
?>
    
function Generar_Dependencias (DepSel){     

        		Codigo_Instit=document.forms.form2.Instituciones.options[document.forms.form2.Instituciones.selectedIndex].value;    			
				seleccion = 0;
				
        		if (Codigo_Instit!=0 && tabla_Long_Dep[Codigo_Instit]!=null)
        		{
        		 document.forms.form2.Dependencias.length =tabla_Long_Dep[Codigo_Instit];    			
      			 for (i=0;i<tabla_Long_Dep[Codigo_Instit];i++)
                 {             	
                   document.forms.form2.Dependencias.options[i].text=tabla_dependencias [Codigo_Instit][i];
                   if (tabla_val_Dep [Codigo_Instit][i]==DepSel)
                   {
                     seleccion = i;
                   }
                   document.forms.form2.Dependencias.options[i].value=tabla_val_Dep [Codigo_Instit][i];
                 }       
                }
				else
				{
				  i=0;
				} 
				
			    document.forms.form2.Dependencias.selectedIndex=seleccion;
			    return null;
}	    		

function Generar_Instituciones(InstSel,DepSel)
{     

          if (document.forms.form2.Paises.length>0)
          {
		      seleccion = 0;
    		  Codigo_Pais=document.forms.form2.Paises.options[document.forms.form2.Paises.selectedIndex].value;    			
			
			  if (tabla_Long_Instit [Codigo_Pais]!=null)
			  {  
    		    document.forms.form2.Instituciones.length = tabla_Long_Instit[Codigo_Pais];    			
				for (i=0;i<tabla_Long_Instit[Codigo_Pais];i++)
                {             	
                 document.forms.form2.Instituciones.options[i].text=tabla_Instituciones [Codigo_Pais][i];
                 if (tabla_val_Instit [Codigo_Pais][i]==InstSel)
                 { seleccion = i; }
                 
                 document.forms.form2.Instituciones.options[i].value=tabla_val_Instit [Codigo_Pais][i];
                }
			  }
			  else
			  {
			   i=0;
			  }
			
	         document.forms.form2.Instituciones.selectedIndex=seleccion;
    		  Generar_Dependencias(DepSel);
			  
			}    
  			return null;
}	    
	
function Generar_Paises (PaisSel){     
    
          document.forms.form2.Paises.length = contpaises;
          seleccion = 0;
     		for (i=0;i<contpaises;i++)
                {             	
                 document.forms.form2.Paises.options[i].text=tabla_Paises [i];
                 document.forms.form2.Paises.options[i].value=tabla_val_Paises [i];
                 if (tabla_val_Paises [i]==PaisSel)
                 {
                   seleccion = i;
                 }

                }       
            document.forms.form2.Paises.length=i;	      			
            document.forms.form2.Paises.selectedIndex=seleccion;
			  return null;
		}	    
		

</script>

<?

// Estas funciones son específicas de cálculo
// mas abajo están las específicas de graficación

function Calcular() {
	global $result;
	global $Suma_Total;
	global $Total_General;
	global $Anio;
	global $row;
	global $SumaAnios;
	global $SumaPaises;
	global $hash;

	while ($rowg = mysql_fetch_row($result)) {
		// Si $rowg[3]==0 implica que son  pedidos
		// que no llegaron a pedirse a ningun país

		if ($rowg[3] > 0) {

			$filacorrecta = $hash[$rowg[3]];

			$row[$filacorrecta][$rowg[0] - $Anio +1] += $rowg[2];
			$SumaAnios[$rowg[0] - $Anio +1] += $rowg[2];
			$SumaPaises[$filacorrecta] += $rowg[2];
			$Total_General += $rowg[2];
		}

	}

}

function Armar_Instruccion($dedonde) {
	global $TPed;
	global $Anio;
	global $AnioFinal;
	global $Caja;
	global $Dependencias;

	$Instruccion = "SELECT YEAR(Fecha_Alta_Pedido) AS p,unidades.Nombre,COUNT(*),unidades.Id ";
	if ($dedonde == 1) {
		$Instruccion .= "FROM pedhist ";
		$Instruccion .= "LEFT JOIN usuarios ON usuarios.Id=pedhist.Codigo_Usuario ";
	} else {
		$Instruccion .= "FROM pedidos ";
		$Instruccion .= "LEFT JOIN usuarios ON usuarios.Id=pedidos.Codigo_Usuario ";
	}
	$Instruccion .= "LEFT JOIN unidades ON unidades.Id=usuarios.Codigo_Unidad ";
	$Instruccion .= "WHERE YEAR(Fecha_Alta_Pedido)>=" . $Anio . " AND YEAR(Fecha_Alta_Pedido)<=" . $AnioFinal . " AND usuarios.Codigo_Dependencia=" . $Dependencias;
	$Instruccion .= " AND Tipo_Pedido=" . $TPed;

	if ($Caja == ESTADO__ENTREGADO_IMPRESO || $Caja == ESTADO__CANCELADO) {
		if ($dedonde == 1) {
			$Instruccion .= " AND Estado=" . $Caja;
		} else {
			$Instruccion .= " AND Estado=" . ESTADO__RECIBIDO;
		}
	}

	$Instruccion .= " GROUP BY p,unidades.Id";
	$Instruccion .= " ORDER BY p,unidades.Nombre";

	return $Instruccion;
}
global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);
?>
<title>PrEBi </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
body {
	margin:0px;
	background-color: #006599;
	margin-left: 10px;
	
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
.style28 {color: #FFFFFF; font-size: 11px; }
.style43 {
	font-family: verdana;
	font-size: 10px;
	color: #000000;
}
.style49 {font-family: verdana; font-size: 10px; color: #006599; }
.style54 {font-family: verdana; font-size: 10px; color: #000000; }
.style55 {
	font-size: 10px;
	color: #000000;
	font-family: Verdana;
}
.style63 {
	font-size: 9px;
	font-family: Arial, Helvetica, sans-serif;
}
.style66 {color: #FFFFFF}
-->
</style>
<base target="_self">
<link rel="stylesheet" type="text/css" href="../css/celsiusStyles.css">
</head>

<body topmargin="0">
<div align="left">
<form name="form2" method="POST" action="est-origenunidped.php">
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
                <td valign="top" bgcolor="#E4E4E4">
                <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="style43">
                <tr>
                    <td height="20" colspan="2" align="left" bgcolor="#006599" class="style45">
                    	<img src="../images/square-lb.gif" width="8" height="8" border="0"><span class="style28"><? echo $Mensajes["tf-30"];?></span>
                    </td>
                </tr>
                  <tr>
                    <td height="15" colspan="2" align="left" class="style45"><br>                      
                    <table width="97%"  border="0" align="center" cellpadding="1" cellspacing="0" class="table-form">
                    <tr>
                        <th>
                        	<div align="right"><? echo $Mensajes["tf-1"];?></div>
                        </th>
                        <td align="left">
                        	<input name="Anio" value="<? echo $Anio; ?>" type="text" class="style43">
                        	<input type="hidden" name="TPed" value="<? echo $TPed; ?>">
                        </td>
                    </tr>
                    <tr>
                       	<th>
                       		<div align="right"><? echo $Mensajes["tf-2"];?></div>
                       	</th>
                       	<td align="left">
                       		<input name="AnioFinal" value="<? echo $AnioFinal; ?>" type="text" class="style54">
                       	</td>
                    </tr>
                    <tr>
                        <th>
                        	<div align="right"><? echo $Mensajes["tf-17"];?>:</div>
                        </th>
                        <td align="left">
                        	<select size="1" name="Paises" class="style54" onChange="Generar_Instituciones(0,0)" size="1" style="width:200px">
                        	</select>
                        </td>
                    </tr>
                    <tr>
                    	<th>
                    		<div align="right"><? echo $Mensajes["ec-10"];?>:</div>
                    	</th>
                       	<td align="left">
                       		<select size="1" name="Instituciones" OnChange="Generar_Dependencias(0)" class="style54" size="1" style="width:200px">
                       		</select>
                       	</td>
                    </tr>
                    <tr>
                       <th>
                       		<div align="right"><? echo $Mensajes["ec-11"];?>:</div>
                       </th>
                       <td align="left">
                       		<select size="1" name="Dependencias" class="style54" size="1" style="width:200px">
                       		</select>
                       </td>
                    </tr>
                    <tr>
                       <th>
                       		<div align="right"><? echo $Mensajes["tf-3"];?></div>
                       </th>
                       <td align="left">
                       		<select name="Modalidad" class="style54" size="1" style="width:200px">
                        		<option <? if ($Modalidad==1) { echo "selected"; } ?> value="1"><? echo $Mensajes["opc-3"];?></option>
                        		<option <? if ($Modalidad!=1) { echo "selected"; } ?> value="2"><? echo $Mensajes["opc-4"];?></option>
                        	</select>
                       </td>
                    </tr>
                    <tr>
                        <th>
                        	<div align="right"><? echo $Mensajes["tf-5"]; ?></div>
                        </th>
                        <td align="left">
                        	<select name="Caja" class="style54" size="1" style="width:200px">
                        		<option <? if ($Caja==0) { echo "selected"; } ?> value="0"><? echo $Mensajes["ec-30"]; ?></option>
                        		<option <? if ($Caja==ESTADO__ENTREGADO_IMPRESO) { echo "selected"; } ?> value="<? echo ESTADO__ENTREGADO_IMPRESO; ?>"><? echo $Mensajes["ec-28"]; ?></option>
                        		<option <? if ($Caja==ESTADO__CANCELADO) { echo "selected"; } ?> value="<? echo ESTADO__CANCELADO; ?>"><? echo $Mensajes["ec-29"]; ?></option>
                        	</select>
                        </td>
                    </tr>
                    <tr>
                        <th>
                        	<div align="right"><? echo $Mensajes["tf-6"];?></div>
                        </th>
                        <td align="left">
                        	<select name="TipoGrafico" class="style54" size="1" style="width:200px">
                          		<option <? if ($TipoGrafico==1) { echo "selected"; } ?> value="1"><? echo $Mensajes["otg-1"];?></option>
                          		<option <? if ($TipoGrafico!=1) { echo "selected"; } ?> value="2"><? echo $Mensajes["otg-2"];?></option>
                        	</select>
                        </td>
                    </tr>
                    <tr valign="middle">
                        <td colspan="2" class="style43">
                       		<div align="center">
                            	<input name="B1" type="submit" class="style43" value="<? echo $Mensajes["bot-1"];?>">
                          	</div>
                        </td>
                    </tr>
                    </table>
                    </form>
                      <hr></td>
                  </tr>

                          <?


if ($Dependencias != "") {
?>

<tr valign="top">
                    <td colspan="2" align="left" class="style45">
                      <div align="left">
                        <p><span class="style54"><img src="../images/sa6.gif" width="8" height="10">

<?


	// Obtengo la tabla con todos las instituciones del país seleccionado
	$Instruccion = "SELECT Id,Nombre FROM unidades WHERE Codigo_Dependencia=$Dependencias ORDER BY Nombre";
	$result = mysql_query($Instruccion);
	$tope = mysql_num_rows($result);

	// Genero el encabezado de la matriz con el nombre del país
	// y un vector que el código de país dice donde esta en la matriz
	// este pais. Necesario para mantener el orden alfabetico

	for ($i = 1; $i <= $tope; $i++) {
		$resultado = mysql_fetch_row($result);
		$row[$i][0] = $resultado[1];
		$hash[$resultado[0]] = $i;
	}

	$columnastope = $AnioFinal - $Anio +1;
	for ($filas = 1; $filas <= $tope; $filas++) {
		for ($columnas = 1; $columnas <= $columnastope; $columnas++) {
			$row[$filas][$columnas] = 0;
		}
	}

	// Inicializo otros totales la Suma por Paises
	// los porcentajes por Países y las Sumas por Columnas, es decir años
	for ($filas = 1; $filas <= $tope; $filas++) {
		$SumaPaises[$filas] = 0;
		$PorcentajePaises[$filas] = 0;
	}

	for ($columnas = 1; $columnas <= $columnastope; $columnas++) {
		$SumaAnios[$columnas] = 0;
		$PorcentajeAnios[$columnas] = 0;
	}

	// Encabezo las columnas con los valores que corresponden a los años
	$Total_General = 0;
	for ($i = $Anio; $i <= $AnioFinal; $i++) {
		$row[0][$i - $Anio +1] = $i;
	}

	$Instruccion = Armar_Instruccion(1);
	$result = mysql_query($Instruccion);
	echo mysql_error();
	Calcular();
	mysql_free_result($result);

	if ($Caja != ESTADO__CANCELADO) {
		$Instruccion = Armar_Instruccion(2);
		$result = mysql_query($Instruccion);
		echo mysql_error();
		Calcular();
		mysql_free_result($result);
	}

	// Calculo los porcentajes
	for ($i = 1; $i <= $tope; $i++) {
		if ($SumaPaises[$i] > 0) {
			$PorcentajePaises[$i] = (100 * $SumaPaises[$i]) / $Total_General;
		}
	}

	for ($i = 1; $i <= $columnastope; $i++) {
		if ($SumaAnios[$i] > 0) {
			$PorcentajeAnios[$i] = (100 * $SumaAnios[$i]) / $Total_General;
		}
	}

	switch ($Caja) {
		case ESTADO__ENTREGADO_IMPRESO :
			$Titulo = $Mensajes["ec-28"];
			break;
		case ESTADO__CANCELADO :
			$Titulo = $Mensajes["ec-29"];
			break;
		default :
			$Titulo = $Mensajes["ec-30"];
			break;
	}

	$buffer = '';
	$Titulo .= " " . $Mensajes["tf-31"];
	echo $Titulo . " - " . $Mensajes["tf-4"];
?>
    </span></p>
  </div>
<table  border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="#CCCCCC" class="style43">
 <tr bordercolor="#CCCCCC" bgcolor="#006699" class="style28">
    <td align="right"><span class="style66"><? echo $Mensajes["ec-14"]; $buffer .= $Mensajes["ec-14"]; ?></span></td>
   <?

	if ($Modalidad == 1) {
		for ($i = 1; $i <= $columnastope; $i++) {
?>  
    <td align="center"><span class="style66"><? echo $row[0][$i]; $buffer .= ','.$row[0][$i]; ?></span></td>
       <?

		} //del primer for
	} //del primer if
?>
    <td align="center" class="style28"><? echo $Mensajes["ec-8"]; $buffer .= ','.$Mensajes["ec-8"];?></td>
    <td align="center" class="style28"><? echo $Mensajes["ec-15"]; $buffer .= ', '.$Mensajes["ec-15"];?></td>
  </tr>
  <?

	$descuento = 0;
	for ($i = 1; $i <= $tope; $i++) {
		if ($SumaPaises[$i] > 0) {
			$buffer .= "\n";
?>
  <tr bordercolor="#CCCCCC">
      <td align="right" bgcolor="#CCCCCC"><? echo $row[$i][0]; $buffer .= $row[$i][0]; ?>&nbsp;</a></td>
  <?

			// descuento sirve para descontar las filas de países que 
			// no voy a contar. A fines de graficar
			if ($Modalidad == 1) {
				for ($j = 1; $j <= $columnastope; $j++) {
?>
        <td align="center" bgcolor="#ECECEC"><? echo $row[$i][$j]; $buffer .= ','.$row[$i][$j]; ?></td>
  <?

				} // 4 for
			} //3 if
?>
        <td align="center" bgcolor="#ECECEC"><? echo $SumaPaises[$i]; $buffer .= ','.$SumaPaises[$i]; ?></td>
        <td align="center" bgcolor="#ECECEC"><? echo number_format($PorcentajePaises[$i],2);  $buffer .= ','.number_format($PorcentajePaises[$i],2)."%"; ?></td>
    </tr>
  <?

		} else {
			$descuento += 1;
		}
	}
?>
	      <tr bordercolor="#CCCCCC">
        <td align="right" bgcolor="#CCCCCC"><? echo $Mensajes["ec-3"]; $buffer .= "\n ".$Mensajes["ec-3"]; ?></td>
  <?

	if ($Modalidad == 1) {
		for ($i = 1; $i <= $columnastope; $i++) {
?>       <td align="center" bgcolor="#ECECEC"><? echo $SumaAnios[$i]; $buffer .= ','.$SumaAnios[$i]; ?></td>
  <?

		} //del for
	} //del if
?>
      <td align="center" bgcolor="#ECECEC"><? echo $Total_General; $buffer .= ','.$Total_General; ?></td>
      <td align="center" bgcolor="#ECECEC"><? echo "100.00%"; $buffer .= ','."100.00%";?></td>
   </tr>
   <tr bordercolor="#CCCCCC">
       <td align="right" bgcolor="#CCCCCC"><? echo $Mensajes["ec-4"]; $buffer .= " \n ".$Mensajes["ec-4"]; ?></td>
  <?

	if ($Modalidad == 1) {
		for ($i = 1; $i <= $columnastope; $i++) {
?>      <td align="center" bgcolor="#ECECEC"><? echo number_format($PorcentajeAnios[$i],2); $buffer .= ','.number_format($PorcentajeAnios[$i],2)."%"; ?></td>
  <?

		} //del for
	} //del if
?>
       <td align="center" bgcolor="#ECECEC"><? echo "100.00%"; $buffer .= ','."100.00%"; ?></td>
       <td align="center" bgcolor="#ECECEC">&nbsp;</td>
    </tr>
  </table>
 <br>
<hr></td>
<?


	// Estas funciones son específicas de 
	// graficación

	function retornar_labels($Modalidad) {
		global $row;
		global $columnastope;
		global $VectorIdioma;
		global $Mensajes;

		if ($Modalidad == 1) {
			$cadena = "";
			for ($j = 1; $j <= $columnastope; $j++) {
				$cadena .= $row[0][$j] . ",";
			}
			$cadena = substr($cadena, 0, strlen($cadena) - 1);
			return "<param name=sampleLabels value=" . $cadena . ">";
		} else {
			return "<param name=sampleLabels value=" . $Mensajes["opc-4"] . ">";
		}

	}

	function retornar_series() {
		global $row;
		global $tope;
		global $SumaPaises;

		$cadena = "";
		for ($j = 1; $j <= $tope; $j++) {
			if ($SumaPaises[$j] > 0) {
				$cadena .= $row[$j][0] . ",";
			}
		}
		$cadena = substr($cadena, 0, strlen($cadena) - 1);
		return "<param name=seriesLabels value=\"" . $cadena . "\">";

	}

	function retornar_valores($Modalidad) {
		global $row;
		global $tope;
		global $columnastope;
		global $SumaPaises;

		$valores = "";
		$indice = 0;
		for ($j = 1; $j <= $tope; $j++) {
			if ($SumaPaises[$j] > 0) {
				$cadena = "";
				if ($Modalidad == 1) {
					for ($i = 1; $i <= $columnastope; $i++) {
						$cadena .= $row[$j][$i] . ",";
					}
				} else {
					$cadena = $SumaPaises[$j] . ",";
				}

				$cadena = substr($cadena, 0, strlen($cadena) - 1);
				$valores .= "<param name=sampleValues_" . $indice++ . " value=" . $cadena . ">\n";
			}
		}
		return $valores;
	}
?>

  </tr>
  <tr valign="top">
      <td colspan="2" align="left" class="style45"><p class="style54"><img src="../images/sa6.gif" width="8" height="10"> <? echo $Mensajes["mensaje.pedidosPorUnidadOrigen"]?> </p>
      <table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>
		<?

	// Calculo el tamaño del gráfico de acuerdo a la cantidad
	// de series a presentar
	$alto = 580;
	$ancho = 270;

	if ($TipoGrafico == 1) {
?>
		
		<applet code="com.objectplanet.gui.BarChartApplet" archive=com.objectplanet.gui.BarChartApplet.jar
		width=<? echo $alto; ?> height=<? echo $ancho; ?> name="BarChart" VIEWASTEXT>
		<param name=seriesCount value="<? echo ($tope - $descuento) ?>">
		
		<param name=sampleCount value="<?  echo $columnastope;  ?>">
		<?

		echo retornar_valores($Modalidad);
?>
		<param name=barLabelsOn value=true>
		<param name=legendOn value=true>
		<param name=valueLinesOn value=true>
		<param name=multiColorOn value=true>
		<param name=barOutlineOff value=true>
		<param name=3DModeOn value=true>
		<param name=chartTitle value="<? echo $Titulo; ?>">
		
		<?

		echo retornar_series();
		echo retornar_labels($Modalidad);
?>
		
		<param name=barWidth value="0.6">
		<param name=titleFont value="Ms Sans Serif, bold, 14">
		<param name=sampleColors value="<? echo Opciones_Color()?>">
		
		<param name=multiSeriesOn value=true>
		</applet> 
		<?

	} else {
?>
		<applet code=com.objectplanet.gui.PieChartApplet archive=com.objectplanet.gui.PieChartApplet.jar 
		   width=<? echo $alto; ?> height=<? echo $ancho; ?>>
		<param name=seriesCount value="<? echo ($tope - $descuento); ?>">
		<?

		echo retornar_valores($Modalidad);
?>
		<param name=chartTitle value="<? echo $Titulo; ?>">
		<?

		echo retornar_series();
		echo retornar_labels($Modalidad);
?>
		<param name=graphInsets value="-1,-1,-1,-1">
		<param name=sampleColors value=<? echo Opciones_Color(); ?>>
		<param name=titleFont value="Ms Sans Serif, bold, 14">
		<param name=valueLabelsOn value=true>
		<param name=sampleLabelsOn value=true>
		<param name=percentLabelsOn value=true>
		<param name=pieLabelsOn value=true>
		<param name=legendOn value=true>
		<param name=3DModeOn value=true>
		<param name=sliceSeperatorOn value=true>
		<PARAM NAME="selectionstyle" VALUE="detached">
		<PARAM NAME="detacheddistance" VALUE="0.2">		
		</applet>
		
		<? } ?>
  </td>
                        </tr>
                      </table>
                      <div align="right"><br>
                      </div>
                      <div align="center"><a href='javascript:direct_export()'><img src="../images/files/xls.jpg" width="17" height="17" border="0"></a></div></td>
                  </tr>
                </table>                  </td>
              </tr>
            </table>

              </center>
</div>
            </td>

        <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">

          <table width="100%" bgcolor="#ececec">
            <tr>

              <td valign="top" class="style28"><div align="center"><img src="../images/image001.jpg" width="150" height="118" border="0"><br>


                <span class="style54"><a href="main-estadisticas.php"><? echo $Mensajes["h-1"]?></a></span></div>                <div align="center" class="style55"></div></td>
            </tr>
          </table>
          </div>
</td>
        </tr>
    </table>    </center>
      </div>    </td>
  </tr>

<form name="formExport" action="exp_est.php">
  <input type='hidden' name='datos' value='<? echo $buffer; ?>'>
  <input type='hidden' name='mifilename' value='origenunidped.csv'>

</form>

<script>
function direct_export()
{
  document.forms.formExport.submit();
}
</script>




<?

	}
else {
?>
	</td>
	</tr>
	</table>
	</td>
	</tr>
	</table>
	<td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">

          <table width="100%" bgcolor="#ececec">
            <tr>

              <td valign="top" class="style28"><div align="center"><img src="../images/image001.jpg" width="150" height="118" border="0"><br>


                <span class="style54"><a href="main-estadisticas.php"><? echo $Mensajes["h-1"] ; ?> </a></span></div>                <div align="center" class="style55"></div></td>
            </tr>
          </table>
          </div>
</td>
 <?

}

DibujarBarraInferior();
?>
  <tr>
    <td height="44" bgcolor="#E4E4E4"><div align="center">
      <hr>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logos/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50" class="style49"><div align="center" class="style11 style63">npm-001</div></td>
        </tr>
      </table>
      </div></td>
  </tr>
</table>
</div>
<script language="JavaScript">
 Generar_Paises(<? if ($Paises=="") { echo "0"; } else { echo $Paises; }?>);
 Generar_Instituciones(<? if ($Instituciones=="") { echo "0"; } else { echo $Instituciones; } ?>,<? if ($Dependencias=="") { echo "0"; } else { echo $Dependencias; } ?>);
</script>

</body>
</html>
