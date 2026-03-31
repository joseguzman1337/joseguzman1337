<?
  include_once "../inc/var.inc.php";
  include_once "../inc/"."cache.inc";
 // include_once "../inc/"."tabla_ped_unnoba.inc";
  
  $DiadeHoy = getdate();
  if (!isset($Login))
  { $Login = '';}
  if (!isset($Password))
  {$Password = '';}

  if (isset($CkSesionId))
  {
  //	   Si tiene sesion definida que conecte con Mysql

	  include_once "../inc/"."conexion.inc.php";
	   include_once "../inc/"."tabla_ped_unnoba.inc";
      Conexion();

  }
  else
  {	  //if (!isset($Login)) {$Login = '';}
      //if (!isset($Password)) {$Password = '';}
  	 // Ahora se fija si tengo datos en Login & Password
	 
      
	 if ($Login!="" && $Password!="")
	 {
	  include_once "../inc/"."conexion.inc.php";
      Conexion();
            $expresion = "SELECT Apellido,Nombres,Id,Codigo_Institucion,Bibliotecario,Codigo_Dependencia,Codigo_Unidad,Password FROM Usuarios";
      $expresion = $expresion." WHERE Login='".$Login."'";
      $result = mysql_query($expresion);
      echo mysql_error();
      $row = mysql_fetch_array($result);

      if (mysql_num_rows($result)>0)
       {
         $enc = md5($row[7]);
	     $nuevoString = substr($enc,0,strlen($enc)-8);
		  if ($nuevoString != $Password)
		  { //la password es incorrecta
     	   Desconectar();
		   header("Location: sitiousuario.php");
		   return;
                 }


	   	 // Si es personal de administracion graba los datos en la sesion

         $Usuario = $row[0].",".$row[1];
         $Id_usuario = $row[2];
         $Instit_usuario = $row[3];
		 $Bibliotecario = $row[4];
		 $Dependencia = $row[5];
		 $Unidad = $row[6];


    	  
    	  include_once "../inc/"."sesion.inc";

	   	 if (SesionCrea())
		 {

     	   SesionPone("Usuario", $Usuario);
	       SesionPone("Id_usuario", $Id_usuario);
		   if ($Bibliotecario>0)
		   {
		    SesionPone("Rol", "2");
		   }
		   else
		   {
		    SesionPone("Rol", "3");
		   }
	       SesionPone("Instit_usuario", $Instit_usuario);
		   SesionPone("Bibliotecario", $Bibliotecario);
		   SesionPone("Dependencia",$Dependencia);
		   SesionPone("Unidad",$Unidad);

		  }
		  else
		  {

		    Desconectar();
		 	header("Location: sitiousuario.php");
		 	return;
		  }



        }
       else
       {
		// el login y password es incorrecto
		 Desconectar();
		 header("Location: sitiousuario.php");
		 return;

       }
	 }
	 else
	 {
	 	// No tengo datos de login & password
		// con lo cual redirijo hacia login
	 	header ("Location: sitiousuario.php");
		return;
	 }

  }
  // Por aca entra cuando tiene sesion
  // con lo cual pasa a verificar si la sesion identifica
  // que es alguien de administracion


  include_once "../inc/"."identif.php";


  Usuario();

  include_once "../inc/"."fgentrad.php";
  include_once "../inc/"."fgenped.php";
   include_once "../inc/"."tabla_ped_unnoba.inc";
  global  $IdiomaSitio ; 
  $Mensajes = Comienzo ("adm-001",$IdiomaSitio);
  $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);

?>
<title><? echo Titulo_Sitio();?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<script>

  var elem1=0;
  var elem2=0;
  var elem3=0;
  var existe1=0;
  var existe2=0;
  var existe3=0;


  function cerrar(superelem,elem)
  {document.getElementById(superelem).style.visibility='hidden';
   document.getElementById(elem).style.visibility='hidden';
  }

 function minimizar(elem,superelem)
  {   //document.getElementById(superelem).style.height = 10;
   document.getElementById(elem).style.position = 'absolute';
   document.getElementById(elem).style.visibility='hidden';
  }

  function maximizar(elem,superelem)
  {
   document.getElementById(elem).style.visibility='visible';
   //document.getElementById(superelem).style.height='*'
   document.getElementById(elem).style.position = 'relative';
  }
   function marcarLeido(idMensaje,formName)
   {
    var formulario = document.getElementById(formName);
	formulario.submit();
   }

   function mover(event)
   {

   	if ((existe1==1) && (elem1))
	   {   if (window.event) {
             e =window.event;
        	 document.getElementById('mensaje1').style.top = e.clientY - 10;
		     document.getElementById('mensaje1').style.left = e.clientX - 10;

	       }
	       else {
              document.getElementById('mensaje1').style.top = event.pageY - 10;
		      document.getElementById('mensaje1').style.left = event.pageX - 10;
	       }
	   }
    if ((existe2==1) && (elem2))
	   {
       if (window.event) {
             e =window.event;
        	 document.getElementById('mensaje2').style.top = e.clientY - 10;
		     document.getElementById('mensaje2').style.left = e.clientX - 10;

	       }
	       else {
	          document.getElementById('mensaje2').style.top = event.pageY - 10;
		      document.getElementById('mensaje2').style.left = event.pageX - 10;
	       }

	   }
    if ((existe3==1) && (elem3))
	   {
         if (window.event) {
             e =window.event;
        	 document.getElementById('mensaje3').style.top = e.clientY - 10;
		     document.getElementById('mensaje3').style.left = e.clientX - 10;

	       }
	       else {
	          document.getElementById('mensaje3').style.top = event.pageY - 10;
		      document.getElementById('mensaje3').style.left = event.pageX - 10;
	       }
		 }
   }
   //document.body.onmousemove=mover;
   //alert(doc);
  // document.getElementById('cuerpo').onmousemove = mover;

 // document.getElementsByTagName('body').onmousemove = mover;

   function cambiarValor(elem)
   {var e = window.event;
	if (elem==1)
      if (elem1==0)
	    elem1 = 1;
		else
			elem1 = 0;
    else
    	if (elem==2)
         if (elem2==0)
	        elem2 = 1;
		  else
			elem2 = 0;
        else
			if (elem==3)
             if (elem3==0)
	           elem3 = 1;
      		else
	    		elem3 = 0;
   }


</script>


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

.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 11px; }
.style23 {
	color: #000000;
	font-size: 11px;
	font-family: verdana;
}
.style28 {color: #FFFFFF}
.style29 {color: #006599}
.style30 {color: #FFFFFF; font-size: 11px; font-family: verdana; }
.style31 {color: #000000}
.style32 {
	font-family: Verdana;
	font-size: 11;
	color: #000000;
}
.style34 {color: #006699; font-family: Verdana; font-size: 10px; }
.style36 {
	font-size: 11;
	color: #000000;
}
-->
</style>
<script>
  window.parent.frames[0].document.getElementById('login').firstChild.nodeValue = "<? echo $Mensajes["ec-12"]; ?>";

function ruteaPedido()
{

	Selector = document.forms.form3.Material.value;
	switch (Selector)
	{
		case "1":
			document.forms.form3.action = "../pedidos/agrega_col.php";
			break;
		case "2":
     		document.forms.form3.action = "../pedidos/agrega_cap.php";
     		break;
		case "3":
 			document.forms.form3.action = "../pedidos/agrega_pat.php";
 			break;
		case "4":
			document.forms.form3.action = "../pedidos/agrega_tes.php";
			break;
		case "5":
			document.forms.form3.action = "../pedidos/agrega_cong.php";
			break;
	}
	document.forms.form3.submit();

}


</script>
<base target="_self">
</head>

<body topmargin="0" id='cuerpo' onmousemove=mover(event);>
<div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <div align="center">
        <center>
      <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#EFEFEF">
        <td bgcolor="#E4E4E4">
            <div align="center">
              <center>
              <form name='form3'>
            <table width="97%" border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
              <tr>
                <td bgcolor="#E4E4E4"><table width="100%"  border="0">
                  <tr>
                    <td width="576" height="20" bgcolor="#cecece" class="style30"><div align="left" class="style31"><? echo $Mensajes["usr-17"]; ?></div></td>
                  </tr>
                  	<? if ($Bibliotecario==0)
                 	   {
                	 ?>

                  <tr>
                    <td height="20" class="style23">
                        <div align="left">

                          <table height="20" border="0" cellspacing="0">
                                  <tr>
                                    <td height="18" class="style23" ><? echo $Mensajes["usr-1"]; ?>
                                      <select size="1" name="Material" class="style23">
                                    <?
                             		for ($i=1;$i<=5;$i++)
                                		{
                                 	?>
                           	     	<option value=<? echo $i; ?>><? echo Devolver_Tipo_Material($VectorIdioma,$i); ?></option>
                                  <?
                            		}
                                      ?>
                                 </select>
                                 <input type="button" value="<? echo $Mensajes["usr-19"]; ?>" name="B3" class="style23" OnClick="ruteaPedido()">
                                 <INPUT TYPE="hidden" value=<? echo $Id_usuario; ?>  name="Alias_Id">
								 <INPUT TYPE="hidden" value=<? echo SesionToma("Instit_usuario"); ?> name="Instit_Alias">
								  </tr>
                                    </table>
              </form>
                      </div></td></tr>
                      <? }
                      		else
                      		{
                         	?>
                       		<tr>
                              <td height="18" class="style23"><div align="left"><a href="elige_usu.php?Letra=A&dedonde=1"><? echo $Mensajes["usr-20"]; ?></a></div></td>
                            </tr>
                     <? } ?>
<tr><td>Pedidos Listo para bajar</td></tr>
  <?
                       $expresion = armar_expresion_busqueda();
                       $Id_us = $Id_usuario;
                       $completa="";
                       $expresion = $expresion."WHERE (Pedidos.Estado = ".Devolver_Estado_SolicitarPDF().") AND Pedidos.Codigo_Usuario=".$Id_us;
                          $expresion.=$completa." ORDER BY Pedidos.Fecha_Alta_Pedido";
                          //echo $expresion;
                          $result = mysql_query($expresion);
                           echo mysql_error();
                          while($row = mysql_fetch_row($result))
                                  {
                           		  echo "<tr class='style34'><td class='style34'>";
                                   Dibujar_Tabla_Comp_Cur_pequeña ($VectorIdioma,$row,$MensajesTabla,0);

                                    ?>
                                          </td></tr> <?
                                 

                      }
                                ?>

            <?  //Ahora busco los pedidos del usuario
              $expresion = "SELECT COUNT(*) FROM Pedidos";
  			  if ($Bibliotecario==0)
			  {
			  	$expresion.=" WHERE (Estado<=3 OR Estado=5) AND Codigo_Usuario=".$Id_usuario;
			  }
			  else
			  {
			  	$expresion.=" LEFT JOIN Usuarios ON Usuarios.Id=Pedidos.Codigo_usuario";
			    switch ($Bibliotecario)
				{
					case 1:
						$expresion.=" WHERE (Estado<=3 OR Estado=5) AND Usuarios.Codigo_Institucion=".$Instit_usuario;
						break;
					case 2:
						$expresion.=" WHERE (Estado<=3 OR Estado=5) AND Usuarios.Codigo_Dependencia=".$Dependencia;
						break;
					case 3:
						$expresion.=" WHERE (Estado<=3 OR Estado=5) AND Usuarios.Codigo_Unidad=".$Unidad;
						break;
				}
				$expresion.=" AND Tipo_Usuario_Crea=2";
			  }
              $result = mysql_query($expresion);
			  echo mysql_error();
              $rowc = mysql_fetch_array($result);
              if ($rowc[0]>1){
                  ?>
                  <tr>
                    <td height="18" class="style23"><div align="left"><a href='../pedidos/manpedcur.php?dedonde=0&adm=0'><?echo $rowc[0] ?> <? echo $Mensajes["usr-2"]; ?> </a> </div></td>
                  </tr>
                  <?
              } elseif ($rowc[0]==1){
                  ?>
                  <tr>
                    <td height="18" class="style23"><div align="left"><a href='../pedidos/manpedcur.php?dedonde=0&adm=0'><? echo $rowc[0];?> <? echo $Mensajes["usr-3"]; ?> </a> </div></td>
                  </tr>
                  <?
                }
               else
               { ?>
                  <tr>
                    <td height="18" class="style23"><div align="left"><? echo $Mensajes["usr-4"]; ?> </div></td>
                  </tr>
               <?}
              
             $expresion = "SELECT COUNT(*) FROM Pedidos";
			  if ($Bibliotecario==0)
			  {
			  	$expresion.="  WHERE (Estado=6 OR Estado=".Devolver_Estado_SolicitarPDF().") AND Codigo_Usuario=".$Id_usuario;
			  }
			  else
			  {
			   	$expresion.=" LEFT JOIN Usuarios ON Usuarios.Id=Pedidos.Codigo_usuario";
			    switch ($Bibliotecario)
				{
					case 1:
						$expresion.=" WHERE (Estado=6 OR Estado=".Devolver_Estado_SolicitarPDF().")AND Usuarios.Codigo_Institucion=".$Instit_usuario;
						break;
					case 2:
						$expresion.=" WHERE (Estado=6 OR Estado=".Devolver_Estado_SolicitarPDF().") AND Usuarios.Codigo_Dependencia=".$Dependencia;
						break;
					case 3:
						$expresion.=" WHERE (Estado=6 OR Estado=".Devolver_Estado_SolicitarPDF().") AND Usuarios.Codigo_Unidad=".$Unidad;
						break;
				}
    			$expresion.=" AND Tipo_Usuario_Crea=2";
			  }
              $result = mysql_query($expresion);
              $rowc = mysql_fetch_array($result);

              ?>
                <tr>
                    <td height="18" class="style23"><div align="left">

                  <?
                if ($rowc[0]>1){
                    echo "<a href='../pedidos/manpedcur.php?dedonde=1&adm=0' style='font:#FFFFCC'>
                          ".$rowc[0]." ".$Mensajes['usr-5']." </a>";
               }
             elseif ($rowc[0]==1){
                 echo "<a href='../pedidos/manpedcur.php?dedonde=1&adm=0'>".$rowc[0]." ".$Mensajes['usr-6']." </a>";
               }
              else
              {
                 echo $Mensajes["usr-7"];
              }

           ?>

                </div></td>
              </tr>
                        <?
              $expresion = "SELECT COUNT(*) FROM Pedidos";
 			  if ($Bibliotecario==0)
			  {
			  	$expresion.="  WHERE Estado=4 AND Codigo_Usuario=".$Id_usuario;
			  }
			  else
			  {
			  	$expresion.=" LEFT JOIN Usuarios ON Usuarios.Id=Pedidos.Codigo_usuario";
			    switch ($Bibliotecario)
				{
					case 1:
						$expresion.=" WHERE Estado=4 AND Usuarios.Codigo_Institucion=".$Instit_usuario;
						break;
					case 2:
						$expresion.=" WHERE Estado=4 AND Usuandencia=".$Dependencia;
						break;
					case 3:
						$expresion.=" WHERE Estado=4 AND Usuarios.Codigo_Unidad=".$Unidad;
						break;
				}
				$expresion.=" AND Tipo_Usuario_Crea=2";
			  }
              $result = mysql_query($expresion);
              $rowc = mysql_fetch_array($result);
              ?>
                  <tr>
                    <td height="18" class="style23"><div align="left"><span class="style29"><strong>
               <?
               if ($rowc[0]>1){
                    echo "<a href='../pedidos/manpedcon.php'>".$rowc[0]." ".$Mensajes['usr-8']."</a>";
               }
             elseif ($rowc[0]==1){
                 echo "<a href='../pedidos/manpedcon.php'>".$rowc[0]." ".$Mensajes['usr-9']." </a>";
               }
              else
              {
               echo $Mensajes["usr-10"];
              }

              ?>
                    </strong></span></div></td>
                  </tr>
                  <tr>
                    <td height="18" class="style23"><div align="left"><a href="../pedidos/manpedushist.php?fila=0&Modo=1&adm=0"><? echo $Mensajes["usr-18"]; ?></a></div></td>
                  </tr>
				  <tr>
                    <td height="18" class="style23"><div align="left"><a href="../pedidos/manpedcoltlh.php?dedonde=1&Id_Usuario=<?echo $Id_usuario;?>&es_historico=1"><? echo $Mensajes["usr-11"]; ?></a></div></td>
                  </tr>
                  <tr>
                    <td height="18" class="style23"><div align="left"><a href="../pedidos/manpedcoltl.php?dedonde=1&Id_Usuario=<?echo $Id_usuario;?>"><? echo $Mensajes["usr-12"]; ?></a></div></td>
                  </tr>
                </table>                  
                  <hr>
                  <span align=left>
                  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="20" bgcolor="#cecece" class="style30"><div align="left" class="style31"><? echo $Mensajes["usr-13"]; ?></div></td>
                    </tr>
                    <tr>
                      <td height="18" align="left"><span class="style23" align=left><A HREF="../mail/cons_mail.php?Id_Usuario=<? echo $Id_usuario; ?>&Nom_Usu=<? echo $Usuario; ?>&dedonde=1"><? echo $Mensajes["usr-14"]; ?></a></span></td>
                    </tr>
                    <tr>
                      <td height="18" align="left"><span class="style23" align=left><a href="../estadisticas/us_pedinic.php?Id_Usuario=<? echo $Id_usuario; ?>&Nom_Usu=<? echo $Usuario; ?>&Anio=<? echo $DiadeHoy["year"]; ?>&AnioFinal=<? echo $DiadeHoy["year"]; ?>" ><? echo $Mensajes["usr-15"]; ?></a></span></td>
                    </tr>
                    <tr>
                      <td height="18" align="left"><span class="style23" align=left><a href="../estadisticas/10pedidas_us.php?Id_Usuario=<? echo $Id_usuario; ?>&Nom_Usu=<? echo $Usuario; ?>&Anio=<? echo $DiadeHoy["year"]; ?>&AnioFinal=<? echo $DiadeHoy["year"]; ?>"><? echo $Mensajes["usr-16"]; ?></a></span></td>
                    </tr>
                  </table>                  
                  </span>
                  </td>
              </tr>
            </table>
              </center>
            </div>
            </td>
        <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
          <?
                 dibujar_menu_usuarios($Usuario,0);

             ?>
          <p>&nbsp; </p>
          </div>
          </td>
        </tr>
    </table>    </center>
      </div>    </td>
  </tr>
  <?

  include_once "../inc/"."barrainferior.php";
  DibujarBarraInferior($IdiomaSitio);

  ?>
  <tr>
    <td height="44" bgcolor="#E4E4E4"><div align="center">
      <hr>
      <a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
  </tr>
</table>
</div>
<style>
  	    #mensajes {
		    position='absolute';
		    visibility='visible';
		    top=50;
		    left=50;
	    }

</style>


 <?   /* Verificacion de mensajes a los usuarios */
  /* Primero veo si tengo que actualizar algun mensaje */
  if (isset($idMensaje) && ($idMensaje > 0))
    { $query = 'update Mensajes_Usuarios set leido=1,fecha_leido=NOW() where id='.$idMensaje;
	  $resu = mysql_query($query);
	  echo mysql_error();
    }

   $mensquery = "select id,fecha_creado,texto from Mensajes_Usuarios where idUsuario=".$Id_usuario." and leido=0";
   $mensajes=mysql_query($mensquery);

   echo mysql_error();
   $cant=0;
   echo "<script>
         var cant =".mysql_num_rows($mensajes);

   for($i=1;$i<=mysql_num_rows($mensajes);$i++)
   { echo "
         var moviendo".$i;}
     echo  "</script>";
   while (($mensaje=mysql_fetch_row($mensajes)) and ($cant<3)) //muestro como mucho 3 mensajes, para que no quede toda la pantalla llena de mensajes
   {//se muestra un solo cuadro de texto
   $cant++;
   $pos = $cant*100;
   echo "
     <style>
     #mensaje".$cant." {
         position='absolute';
	     width=225;
	     background-color=yellow;
		 left=150;
	     top=".$pos.";
	     visibility='visible';
     }
          #texto".$cant." {
	     visibility='visible';
	  }
     </style>
	 <script>
	   existe".$cant." = 1;
	 </script>
     <div id='mensaje".$cant."'
     style='position:absolute;width:225;background-color:#FFFF99;left:150;top:".$pos.";visibility:visible;'>";

     echo "
       <table>
         <tr>
		 <td width='100%' bgcolor='#006699'>
		  <table colspan=2 width='100%'>
		   <tr>
	          <td width='*' align='center' bgcolor='#006699' onclick='cambiarValor(".$cant.")'>
   	           <font size=1 color='#FFFF99'> Creado <b> ".$mensaje[1]." </b> </font>
		  </td>
  		  <td align='right' width='*' bgcolor='#006699'>
   	            <input type='button' style='color:006699;background:#FFFF99;weight:10;height:18' value='-' onclick=minimizar('texto".$cant."','mensaje".$cant."');>
	            <input type='button' style='color:006699;background:#FFFF99;weight:10;height:18' value='+' onclick=maximizar('texto".$cant."','mensaje".$cant."');>
   	            <input type='button' style='color:006699;background:#FFFF99;weight:10;height:18' value='x' onclick=cerrar('mensaje".$cant."','texto".$cant."');>
		</td>
	        </tr>
  	        </table>

	    </tr>
	   <tr id='texto".$cant."' style='visibility:visible'> <td>
	     <span onclick='cambiarValor(".$cant.")'>
           <font size=2 color='#006699'> ".$mensaje[2]."  </font> </span>
	   </td> </tr>
	   <tr onclick='cambiarValor(".$cant.")'> <td align='right'>
	        <form action='sitiousuariologed.php' name='form".$cant."'>
			<input type='hidden' name='idMensaje' value='".$mensaje[0]."'>
            <input type='submit' style='color:#006699;font-size:8pt;background:#FFFF99'
			value='Marcar como leido'
			onclick=marcarLeido(".$mensaje[0].",'form".$cant."')>
			</form>
	   </td>
	   </tr>
      </table>
      </div>
   ";

   }
  ?>
<script>
if (existe1==1) {1
  document.getElementById('mensaje1').style.top=100;
  document.getElementById('mensaje1').style.left=500;
}
if (existe2==1) {
  document.getElementById('mensaje2').style.top=120;
  document.getElementById('mensaje2').style.left=500;
}
if (existe3==1) {
  document.getElementById('mensaje3').style.top=140;
  document.getElementById('mensaje3').style.left=500;
}
</script>


</body>
</html>
