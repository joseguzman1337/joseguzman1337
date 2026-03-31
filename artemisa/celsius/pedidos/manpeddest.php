<? 
 include_once "../inc/var.inc.php";
 include_once "../inc/"."conexion.inc.php";  
 include_once "../inc/"."parametros.inc.php";  
 Conexion();

 include_once "../inc/"."identif.php";
 Administracion();
 	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><? echo Titulo_Sitio(); ?></title>
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
	color: #000000;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #000000;
}
a:hover {
	text-decoration: underline;
	color: #0099FF;
}
a:active {
	text-decoration: none;
	color: #000000;
}
.style22 {
	color: #333333;
	font-family: verdana;
	font-size: 9px;
}
.style33 {
	font-family: verdana;
	font-size: 9px;
	color: #006699;
}
.style34 {
	color: #FFFFFF;
	font-weight: normal;
	font-family: Verdana;
	font-size: 9px;
}
.style35 {color: #FFFFFF}
.style29 {color: #006599}
.style40 {color: #006699}
.style49 {font-size: 11px; font-family: verdana; }
.style50 {font-size: 11px}
.style52 {
	color: #006599;
	font-weight: bold;
	font-family: Verdana;
	font-size: 11px;
}
-->
</style>
<base target="_self">
</head>

<body topmargin="0">
<?
  include_once "../inc/fgenped.php";
  include_once "../inc/fgentrad.php";
  include_once "../inc/tabla_ped_unnoba.inc";
  global $IdiomaSitio;
  $Mensajes = Comienzo ("adm-002",$IdiomaSitio);
  $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
  $Modo = 15;

?>


<script language="JavaScript">
tabla_Instituciones = new Array;
tabla_val_Instit = new Array;
tabla_Long_Instit = new Array;
tabla_Paises = new Array;
tabla_val_Paises = new Array;
tabla_Dependencias = new Array;
tabla_val_Dep = new Array;
tabla_Long_Dep = new Array;

// Estas representan las opciones que usan Institucion y Dependencia
// lo devuelve como un vector la funcion PHP y se comparan desde
// JavaScript

vector_usa = [<? echo Devuelve_Inst(); ?>];

  <?
   include_once "../inc/"."pidu.inc.php";
   armarScriptPaises("tabla_Paises","tabla_val_Paises");
   armarScriptInstituciones("tabla_Instituciones" , "tabla_val_Instit" , "tabla_Long_Instit");
   armarScriptDependencia("tabla_Dependencias","tabla_val_Dep","tabla_Long_Dep");

    ?>

function Generar_Dependencias (DepSel){

        		Codigo_Instit=document.forms.form2.Instituciones.options[document.forms.form2.Instituciones.selectedIndex].value;
				seleccion = 0;

        		if (Codigo_Instit!=0 && tabla_Long_Dep[Codigo_Instit]!=null)
        		{
        		 document.forms.form2.Dependencias.length =tabla_Long_Dep[Codigo_Instit]+1;
      			 for (i=0;i<tabla_Long_Dep[Codigo_Instit];i++)
                 {
                   document.forms.form2.Dependencias.options[i].text=tabla_Dependencias [Codigo_Instit][i];
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

				if (DepSel==0)
			    {
			  	  seleccion = i;
			    }
			    document.forms.form2.Dependencias.length=i+1;
                document.forms.form2.Dependencias.options[i].text="<? echo $Mensajes["opc-2"];?>";
                document.forms.form2.Dependencias.options[i].value=0;
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
    		    document.forms.form2.Instituciones.length = tabla_Long_Instit[Codigo_Pais]+1;
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

			  if (InstSel==0)
			  {
			  	seleccion = i;
			  }
              document.forms.form2.Instituciones.length=i+1;
			  document.forms.form2.Instituciones.options[i].text="<? echo $Mensajes["opc-2"]; ?>";
			  document.forms.form2.Instituciones.options[i].value=0;
              document.forms.form2.Instituciones.selectedIndex=seleccion;
    		  Generar_Dependencias(DepSel);

			}
  			return null;
}

function genera_evento(Id,Estado,Mail,Nombre,Rol,IdCreador)
{
   ventana=window.open("gen_evento.php?Id="+Id+"&usuario=<? echo $Id_usuario; ?>&Modo=<? echo $Modo;?>&Estado="+Estado+"&Mail="+Mail+"&Nombre="+Nombre+"&RolCreador="+Rol+"&IdCreador="+IdCreador, "Eventos", "dependent=yes,toolbar=no,width=530,height=500,top=5,left=20");

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

 function rutear_pedidos (TipoPed,Id)
 {

     switch (TipoPed)
	  {
	    case 1:
	      ventana=open("verped_col.php?Id="+Id+"&dedonde=2&Tabla=1","Colecciones","scrollbars=yes,width=700,height=450,alwaysLowered");
	      break;
	    case 2:
	      ventana=open("verped_cap.php?Id="+Id+"&dedonde=2&Tabla=1","Capitulos","scrollbars=yes,width=700,height=450,alwaysLowered");
	      break;
	    case 3:
          ventana=open("verped_pat.php?Id="+Id+"&dedonde=2&Tabla=1","Patentes","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;
        case 4:
          ventana=open("verped_tes.php?Id="+Id+"&dedonde=2&Tabla=1","Tesis","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;
		 case 5:
          ventana=open("verped_con.php?Id="+Id+"&dedonde=2&Tabla=1","Congresos","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;

	  }

	 return null

 }
 function busquedas(Id,Estado,Mail,Nombre,Rol,IdCreador)
{
   ventana=window.open("pres_busq.php?Id_Pedido="+Id+"&usuario=<? echo $Id_usuario; ?>&Modo=<? echo $Modo;?>&Estado="+Estado+"&Mail="+Mail+"&Nombre="+Nombre+"&RolCreador="+Rol+"&IdCreador="+IdCreador, "Eventos", "scrollbars=yes,dependent=yes,toolbar=no,width=600 height=450");

 }

</script>

<div align="left">
     <form name="form2" method="POST" action="manpeddest.php">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <div align="center">
        <center>
      <table width="600" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr>
        <td valign="top">            <div align="center">
              <center>
                <table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#ECECEC">
                  <tr bgcolor="#006699">
                    <td height="20" class="style33"><span class="style34"><img src="../images/square-w.gif" width="8" height="8"> <? echo $Mensajes["tf-7"]; ?></span></td>
                    </tr>
                  <tr align="left" valign="middle">
                    <td class="style22"><div align="center" class="style33">
                      <table width="90%"  border="0" align="center" cellpadding="1" cellspacing="1" class="style22">
                        <tr>
                          <td class="style22"><div align="right"><? echo $Mensajes["ec-1"]; ?></div></td>
                          <td class="style33"><div align="left"><select size="1" name="Paises" OnChange="Generar_Instituciones(0,0)" class="style22">
                          </select></div></td>
                        </tr>
                        <tr>
                          <td class="style22"><p align="right"><? echo $Mensajes["ec-2"]; ?></p></td>
                          <td class="style33"><div align="left"><select size="1" name="Instituciones" OnChange="Generar_Dependencias(0)" class="style22">
             </select></div></td>
                        </tr>
                        <tr>
                          <td class="style22"><p align="right"><? echo $Mensajes["ec-3"]; ?></p></td>
                          <td class="style33"><div align="left"><select size="1" name="Dependencias" class="style22">
              </select></div></td>
                        </tr>
                        <tr>
                          <td width="120" class="style22"><div align="right"><? echo $Mensajes["ec-4"]; ?></div></td>
                          <td class="style33"><div align="left">
                            <select size="1" name="Estado" class="style22">
							<? if (!isset($Estado)) {$Estado = 0;}?>
			   <option <? if ($Estado==Devolver_Estado_Pedido()) {echo " selected "; } ?> value=<?  echo Devolver_Estado_Pedido(); ?>><? echo $Mensajes["otp-1"]; ?></option>
			   <option <? if ($Estado==Devolver_Estado_Recibido()) {echo " selected "; } ?> value=<?  echo Devolver_Estado_Recibido(); ?>><? echo $Mensajes["otp-2"]?></option>
			   <option <? if ($Estado==0 || $Estado=="") {echo " selected "; } ?> value=0><? echo $Mensajes["otp-3"]; ?></option>
   	          </select>
                          </div></td>
                        </tr>
                        <tr>
                          <td width="120" class="style22"><div align="right"></div></td>
                          <td>
                              <div align="left">
                                  <input type="radio" value="1" name="Lista" <? If (!isset($Lista)) {$Lista="";} If ($Lista==1) { echo " checked"; }?>><? echo $Mensajes["tf-3"]; ?>
              <input type="radio" name="Lista" value="2" <? If (!isset($Lista)) {$Lista="";} If ($Lista==2 || $Lista=="") { echo " checked";}?>><? echo $Mensajes["tf-4"]; ?><br>
                                  <input type="submit" value="<? echo $Mensajes["bot-1"]; ?>" class="style22" name="B1">
                              </div></td>
       <input type="hidden" name="Modo" value=<? echo $Modo; ?>>
                          </tr>
                      </table>
                      </div>
                      </form>                     </td>
                    </tr>
                </table>
                <?
   if (isset($Paises))
   {

  	  $expresion = armar_expresion_busqueda();
	  if ($Instituciones!=0)
	  {
  	    if ($Dependencias!="0")
  	    {
          $expresion = $expresion."WHERE Pedidos.Ultima_Dependencia_Solicitado=".$Dependencias;
        }
        else
        {
          $expresion = $expresion."WHERE Pedidos.Ultima_Institucion_Solicitado=".$Instituciones;
        }
	  }
	  else
	  {
	     $expresion = $expresion."WHERE Pedidos.Ultimo_Pais_Solicitado=".$Paises;
	  }

	  if ($Estado==Devolver_Estado_Pedido() || $Estado==Devolver_Estado_Recibido())
	  {
	    $expresion.= " AND Pedidos.Estado=".$Estado; //aca cambie
	  }
	  $expresion = $expresion." ORDER BY Fecha_Solicitado";

     $result = mysql_query($expresion);
     echo mysql_error();

 If (!isset($Lista)) {$Lista="";}
 If ($Lista==2 || $Lista=="")
   {
 ?>
                
                
                <hr>
                <div align="left">
                  <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#0099CC">
                    <tr>
                      <td height="20" class="style22"><img src="../images/square-w.gif" width="8" height="8"> <?
        echo $Mensajes["tf-7"];
      ?><span class="style35"><? echo mysql_num_rows($result); ?></span></td>
                    </tr>
                  </table>
                  </div>
                  <? } else { ?>
                        <div align="left">
                  <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#0099CC">
                    <tr>
                      <td height="20" class="style22"><img src="../images/square-w.gif" width="8" height="8"> <?
        echo $Mensajes["tf-7"];
      ?><span class="style35"><? echo mysql_num_rows($result); ?></span></td>
                    </tr>
                  </table>
                  </div>
                  <?
    }

    while($row = mysql_fetch_row($result))
     {
   ?>


 <? If (!isset($Lista)) {$Lista="";} If ($Lista==2 || $Lista =="")
 {
         Dibujar_Tabla_Comp_Cur($VectorIdioma,$row,$Mensajes);

 ?>

<form name="form3" method="POST">
  <p align="center">
  <input type="button" value="<? echo $Mensajes["bot-2"]; ?>" name="B3" class="style22" OnClick="rutear_pedidos(<? echo $row[4]; ?>,'<? echo $row[1]; ?>')">
  <input type="button" value="<? echo $Mensajes["bot-3"]; ?>" name="B1" class="style22" OnClick="genera_evento('<? echo $row[1]; ?>',<? echo $row[36]; ?>,'<? echo $row[46]; ?>','<? echo $row[2].",".$row[3]; ?>',<? echo $row[48];?>,<? echo $row[49];?>)">
  <? if (estado_busqueda($row[36]))
  {?>
  <input type="button" value="<? echo $Mensajes["bot-7"]; ?>" name="B1" class="style22" OnClick="busquedas('<? echo $row[1]; ?>',<? echo $row[36]; ?>,'<? echo $row[46]; ?>','<? echo $row[2].",".$row[3]; ?>',<? echo $row[48];?>,<? echo $row[49];?>)">
  <?}?>
  </p>
  <input type="hidden" name="Modo">
  <input type="hidden" name="Lista">
 </form>
 </td></tr></table>
<br>
<? }
   else
   {
           Dibujar_Tabla_Abrev_Cur ($VectorIdioma,$row,$Mensajes);

 ?>
   <form name="form4" method="POST">
   <td width="5%" height="17" align="left">
   <input type="button" value="P" name="B3" class="style22" OnClick="rutear_pedidos(<? echo $row[4]; ?>,'<? echo $row[1]; ?>')">
   </td>
   <td width="5%" height="17" align="left">
   <input type="button" value="E" name="B1" class="style22" OnClick="genera_evento('<? echo $row[1]; ?>',<? echo $row[36]; ?>,'<? echo $row[46]; ?>','<? echo $row[2].",".$row[3]; ?>',<? echo $row[48];?>,<? echo $row[49];?>)">
   </td>
   <td width="5%" height="17" align="left">
   <? if (estado_busqueda($row[36]))
   {?>
   <input type="button" value="B" name="B1" class="style22" OnClick="busquedas('<? echo $row[1]; ?>',<? echo $row[36]; ?>,'<? echo $row[46]; ?>','<? echo $row[2].",".$row[3]; ?>',<? echo $row[48];?>,<? echo $row[49];?>)">
   <?} else { echo "&nbsp;"; } ?>
   </td>
   </form>
  </tr>
  </table>

<? }
  }

 } // Viene del if de Paises y de Instituciones

    ?>
                  
                  
 <script language="JavaScript">
 Generar_Paises(<? if (!isset($Paises)) { echo "0"; } else { echo $Paises; }?>);
 Generar_Instituciones(<? if (!isset($Instituciones)) { echo "0"; } else { echo $Instituciones; } ?>,<? if (!isset($Dependencias)) { echo "0"; } else { echo $Dependencias; } ?>);
</script>

<?
      Desconectar();
?>
           
				  </td> </tr> </table>
                  
     
            </div>            </td>
        <td width="150" valign="top"><div align="center" class="style22">
          <div align="left">
            <table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td><div align="center">
                  <table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td bgcolor="#ECECEC"><div align="center">
                          <p><img src="../images/image001.jpg" width="150" height="118"><br>
                              <span class="style33"><a href="../admin/indexadm.php"><? echo $Mensajes["h-1"]; ?></a></span></p>
                      </div></td>
                    </tr>
                </table>
                  </div></td>-
              </tr>
            </table>
            </div>
        </div></td>
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
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" height="43" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50"><div align="right" class="style33">
            <div align="center">adm-002</div>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
</body>
</html>
