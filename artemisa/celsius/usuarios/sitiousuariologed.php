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

           setcookie("ariel");
    	  
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

<html>

<head>
<style type="text/css">
<!--
body {
	background-color: #0099CC;
	margin-left: 10px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
}
a:active {
	text-decoration: none;
}
.style13 {
	color: #006699; 
	font-family: Arial, Helvetica, sans-serif; 
	font-size: 9px; 
}
.style1 {
	font-family: Verdana;
	font-size: 9px;
	font-weight: normal;
	color: #333333;
}
.style2 {
	font-family: Verdana;
	font-size: 9px;
	font-weight: normal;
	color: #666666;
}
.style3 {
	font-family: Verdana;
	font-size: 9px;
	font-weight: normal;
	color: #0599B4;
}
.style4 {
	font-family: Verdana;
	font-size: 11px;
	font-weight: normal;
	color: #0599B4;
}
.style5 {
	font-family: Verdana;
	font-size: 9px;
	font-weight: normal;
	color: #FFFFFF;
}
.style6 {
	font-family: Arial;
	font-size: 9px;
	font-weight: normal;
	color: #666666;
}
.style7 {

	font-family: Arial;
	font-size: 9px;
	font-weight: normal;
	color: #0599B4;
}
.style8 {

	font-family: Verdana;
	font-size: 11px;
	font-weight: normal;
	color: #333333;
}
.style13 {

	font-family: Arial;
	font-size: 9px;
	font-weight: normal;
	color: #37849D;
}
.style12 {

	font-family: Verdana;
	font-size: 9px;
	font-weight: normal;
	color: #006699;
}
.style14 {

	font-family: Arial;
	font-size: 9px;
	font-weight: normal;
	color: #F2F0E9;
}
.style15 {
	font-family: verdana;
	font-size: 9px;
	color: #006699;
}
.style16 {

	font-family: Verdana;
	font-size: 11px;
	font-weight: bold;
	color: #FF9900;
}
.style17 {


	font-family: Verdana;
	font-size: 11px;
	font-weight: bold;
	color: #0594AD;
}
.style18 {


	font-family: Verdana;
	font-size: 11px;
	font-weight: normal;
	color: #FFFFFF;
}



-->
</style>
<link href="../celsius.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style19 {font-size: 11px; color: #FFFFFF; font-family: Verdana;}
-->
</style>


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
function ayuda ()
{
 ventana=window.open("ayuda.htm","Ayuda","scrollbars =yes,dependent=yes,toolbar=no,width=512,height=200,top=150,left=150");
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
</head>
<body>
<table width="780" border="0" align="left" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#E4E4E4" style="border-collapse: collapse">
  <tr>
    <td valign="top" bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <span align="center">
      <center>
        <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="2" cellspacing="3">
          <tr bgcolor="#E4E4E4">
            <td valign="top"> <span align="center">
              <center>
                <span align="center">                </span>
                <span align="center">                </span>
                <span align="center"><span align="center">
                </span></span>
                <span align="center"><span align="center">
</span></span>

<form name='form3'>
                <table width="600" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#F5F5F5">
                  <tr>
                    
					<td height="20" bgcolor="#007CA6" colspan="2"><span class="style18"><span class="style2"><span class="style8"><span class="style5"><img src="../images/b1owhite.gif" width="8" height="8"></span> </span></span></span><span class="style19"><? echo $Mensajes["usr-1"]; ?></span></td>
				<? if ($Bibliotecario==0)
                 	  {
                  ?>
					
					<td bgcolor="#007CA6" align="right"> <a href="javascript:ayuda()"><img src="../images/help.gif" border=0 width="22" height="22"></a></td>
                  <?
					 }
					else		
				    {
					?>
					<td bgcolor="#007CA6" align="right"> <a href="javascript:ayuda(0,402)"><img src="../images/help.gif" border=0 width="22" height="22"></a></td>
					<?
					}
				  
				  ?>
				  
				  </tr>
                  <? if ($Bibliotecario==0)
                 	  {
                  ?>
				  <tr>
                    <td height="40" valign="middle"><table height="20" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td height="18" class="style2">
                       <? echo $Mensajes["usr-1"]; ?>
                           <select size="1" name="Material" class="style2">
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
                             
							  <!-- <INPUT TYPE="hidden" value=<? echo $Id_usuario; ?>  name="Alias_Id">-->
                              <INPUT TYPE="hidden" value=<? echo SesionToma("Id_usuario"); ?>  name="Alias_Id">
							   
							   <INPUT TYPE="hidden" value=<? echo     SesionToma("Instit_usuario"); ?> name="Instit_Alias">
						     </form>
							</td></tr>
																
                      
                    </table>

					
					</td>
                  </tr>
				   <? }
                      		else
                      		{
                         	?>
					<tr>
                             <td>&nbsp;</td> <td height="18" class="style2"><div align="left"><a class="style8" href="elige_usu.php?Letra=A&dedonde=1"><? echo $Mensajes["usr-20"]; ?></a></div></td>
                            </tr>
                    		<? }
							?>
               </table>
               <span align="center"><span align="center">
<hr align="center" width="590" size="1" noshade class="style15">
                </span></span>
                <!-- Ver a partir de aca-->
            <?
                 $expresion = armar_expresion_busqueda();
                 if ($Bibliotecario>=1)
                  {
             		// Si es bibliotecario solo va a ver lo creado por el mismo
               	 	//$Id_us = $Id_Entrega;
                	$Id_us = $Id_usuario;
					$expresion = $expresion."LEFT JOIN Usuarios AS Bibliotecario ON ".$Id_usuario."=Bibliotecario.Id ";
					$completa=" AND Pedidos.Tipo_Usuario_Crea=2 ";
					  $completa=''; 
					  
					  }
                  else
                  {
                	$Id_us = $Id_usuario;
               		$completa="";
                  }
                 $expresion = $expresion."WHERE (Pedidos.Estado = ".Devolver_Estado_SolicitarPDF().") AND ";
				 if ($Bibliotecario>=1)
				 {
					   $expresion=$expresion." Pedidos.Codigo_Usuario=".$Id_us;
				  //$expresion=$expresion." Pedidos.Usuario_Creador =".$Id_us;
				 }
				 else
				 {
					   $expresion=$expresion." Pedidos.Codigo_Usuario=".$Id_us;
				 }
				 

                 
				  if ($Bibliotecario>=1)
                      {
                       $expresion1=$expresion;
					   
					   $expresion1.=$completa." and  Bibliotecario.bibliotecario_permite_download =1 ORDER BY Pedidos.Fecha_Alta_Pedido";
                       $expresion.=$completa." ORDER BY Pedidos.Fecha_Alta_Pedido";
					   $result = mysql_query($expresion);
                       $result1 = mysql_query($expresion1);
					  // echo $expresion;
					//   mail ( "asobrado@sedici.unlp.edu.ar","Problema de usuario",$expresion);
					   if (mysql_num_rows($result1)>0)
						  {
					       $adm=2;
					      }
						  else {$adm=3;}
					  }
                      else
					  {
                       $expresion.=$completa." ORDER BY Pedidos.Fecha_Alta_Pedido";
                       //echo $expresion;
                       $result = mysql_query($expresion);
                       $adm=2;
					  }
                   echo mysql_error();
//				 echo $expresion; 
				 
				 		 			 
                
					
					
					
					
					
				/*	$expresion = armar_expresion_busqueda();
                    $Id_us = $Id_usuario;
                    $completa="";
                    $expresion = $expresion."WHERE (Pedidos.Estado = ".Devolver_Estado_SolicitarPDF().") AND Pedidos.Codigo_Usuario=".$Id_us;
                    $expresion.=$completa." ORDER BY Pedidos.Fecha_Alta_Pedido";
                    //echo $expresion;
                    $result = mysql_query($expresion);
                    echo mysql_error();
             */
// ver bien esto es el tema de los bibliotecarios
                
              if (mysql_num_rows($result)>0)
			  {
			  
			  ?>

				<table width="600"  border="0" align="center" cellpadding="3" cellspacing="2" bgcolor="#F5F5F5">
                  <tr>
                    <td width="576" height="20" bgcolor="#0599B4" class="style30"><div align="left" class="style5"><img src="../images/b1owhite.gif" width="8" height="8"> <span class="style18"> <? echo $Mensajes["st-001"]; ?> </span></div></td>
					<td bgcolor="#007CA6" align="right"> <a href="javascript:ayuda(0,401)"><img src="../images/help.gif" border=0 width="22" height="22"></a></td>
                  </tr>
                  <tr>
                    <td class="style23">
                      <div align="left">                        
                      <?
					    //echo "Adm:".$adm;   
				        while($row = mysql_fetch_row($result))
                              {
                           	       if (!isset($adm))
								    {$adm=1;}
                                   Dibujar_Tabla_Comp_Cur_pequeña ($VectorIdioma,$row,$MensajesTabla,$adm);
                               }
                      ?>
			
						
						
						
                     
                    </div>                      </td>
                  </tr>
                </table>
               <span align="center">
                <hr align="center" width="600" size="1" noshade class="style15">
                </span>
			  <?
		   	    }
			  // Cierre de llave 
			   ?>
               <!-- Hasta aca-->
               
                <table width="600"  border="0" align="center" cellpadding="2" cellspacing="0" bgcolor="#F5F5F5">
                  <tr>
                    <td width="576" height="20" colspan="2" bgcolor="#0099CC" class="style30"><div align="left" class="style18"><img src="../images/b1owhite.gif" width="8" height="8"> <? echo $Mensajes["st-002"]; ?> </div></td><td bgcolor="#0099CC" align="right"> <a href="javascript:ayuda(0,402)"><img src="../images/help.gif" border=0 width="22" height="22"></a></td>
                  </tr>
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
              
			?>	  
				  <tr bgcolor="#ECECEC">
               <?
			    if ($rowc[0]>1){
                  ?>
    
					<td height="18" class="style23"><div align="left" class="style8">
                      <div align="left"><a href='../pedidos/manpedcur.php?dedonde=0&adm=0' class="style8"><?echo $rowc[0] ?> <? echo $Mensajes["usr-2"]; ?> </a> </div>
                    </div></td><td class="style23">&nbsp;</td>
                       <?
              } elseif ($rowc[0]==1){
                  ?>
                  <td height="18" class="style23"><div align="left" class="style8"><a href='../pedidos/manpedcur.php?dedonde=0&adm=0' class="style8"><? echo $rowc[0];?> <? echo $Mensajes["usr-3"]; ?> </a> </div></td><td class="style23">&nbsp;</td>
                  <?
                }
               else
               { ?>
                 <td height="18" class="style23"><div align="left" class="style8"><? echo $Mensajes["usr-4"]; ?> </div></td>
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


                    <td width="50%" height="18" class="style23"><div align="left"><span class="style16">   <?
                if ($rowc[0]>1){
                    echo "<a href='../pedidos/manpedcur.php?dedonde=1&adm=0' class='style8' style='font:#FFFFCC'>
                          ".$rowc[0]." ".$Mensajes['usr-5']." </a>";
               }
             elseif ($rowc[0]==1){
                 echo "<a href='../pedidos/manpedcur.php?dedonde=1&adm=0' class='style8'>".$rowc[0]." ".$Mensajes['usr-6']." </a>";
               }
              else
              {
                 echo "<div align='left' class='style8'>".$Mensajes["usr-7"]."</div>";
              }

           ?> </span></div></td>
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
                    <td height="18" colspan="2" class="style23"><div align="left" class="style17">
                      <div align="left"><?
               if ($rowc[0]>1){
                    echo "<a href='../pedidos/manpedcon.php' class='style8'>".$rowc[0]." ".$Mensajes['usr-8']."</a>";
               }
             elseif ($rowc[0]==1){
                 echo "<a href='../pedidos/manpedcon.php' class='style8'>".$rowc[0]." ".$Mensajes['usr-9']." </a>";
               }
              else
              {
               echo '<div align="left" class="style8">'.$Mensajes["usr-10"].'</div>';
              }

              ?></div>
                    </div></td>
                  </tr>
                  <tr bgcolor="#ECECEC">
                    <td height="18" colspan="2" class="style23"><div align="left"><a href="../pedidos/manpedushist.php?fila=0&Modo=1&adm=0" class="style8"><? echo $Mensajes["usr-18"]; ?></a></div></td>
                    <td class="style23"><div align="left"><span class="style8"><a  class="style8" href="../pedidos/manpedcoltl.php?dedonde=1&Id_Usuario=<?echo $Id_usuario;?>"><? echo $Mensajes["usr-12"]; ?></a> </span></div></td>
                  </tr>
                </table>
                <hr align="center" width="600" size="1" noshade class="style15">
                <table width="600"  border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#F5F5F5">
                  <tr>
                    <td height="20" colspan="2" bgcolor="#0099CC" class="style30"><div align="left" class="style18"><img src="../images/b1owhite.gif" width="8" height="8"><? echo $Mensajes["usr-13"]; ?> </div></td><td bgcolor="#0099CC" align="right"> <a href="javascript:ayuda(0,403)"><img src="../images/help.gif" border=0 width="22" height="22"></a></td>
                  </tr>
           <? if ($Bibliotecario!=0)
            {
           ?>
               <tr>
                    <td width="20"><div align="center"><span class="style8"><img src="../images/user.gif" width="18" height="18"> </span></div></td>
                    <td bgcolor="#ECECEC"><span class="style8"><A class="style8" HREF="form_usu_bib.php?operacion=0"><? echo $Mensajes["st-003"]; ?></a></span></td><td bgcolor="#ECECEC">&nbsp;</td>
                  </tr>
			   
			   <tr>
                    <td width="20"><div align="center"><span class="style8"><img src="../images/edit_user.gif" width="18" height="18"> </span></div></td>
                    <td bgcolor="#ECECEC"><span class="style8"><A class="style8" HREF="elige_usu.php?Letra=<? echo $Letra; ?>&dedonde=3"><? echo $Mensajes["st-004"]; ?></a></span></td><td bgcolor="#ECECEC">&nbsp;</td>
                  </tr>
           <?
	    	}
		  ?>

                  <tr>
                    <td width="20"><div align="center"><span class="style8"><img src="../images/m_2_s.gif" width="16" height="11"> </span></div></td>
                    <td bgcolor="#ECECEC"><span class="style8"><A class="style8" HREF="../mail/cons_mail.php?Id_Usuario=<? echo $Id_usuario; ?>&Nom_Usu=<? echo $Usuario; ?>&dedonde=1"><? echo $Mensajes["usr-14"]; ?></a></span></td><td bgcolor="#ECECEC">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="20"><div align="center"><img src="../images/estadisticas.gif" width="18" height="18"></div></td>
                    <td bgcolor="#ECECEC"><span class="style8"><a class="style8" href="../estadisticas/us_pedinic.php?Id_Usuario=<? echo $Id_usuario; ?>&Nom_Usu=<? echo $Usuario; ?>&Anio=<? echo $DiadeHoy["year"]; ?>&AnioFinal=<? echo $DiadeHoy["year"]; ?>" ><? echo $Mensajes["usr-15"]; ?></a></span></td><td bgcolor="#ECECEC">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="20"><div align="center"><img src="../images/estadisticas.gif" width="18" height="18"></div></td>
                    <td bgcolor="#ECECEC"><span class="style8"><a class="style8" href="../estadisticas/10pedidas_us.php?Id_Usuario=<? echo $Id_usuario; ?>&Nom_Usu=<? echo $Usuario; ?>&Anio=<? echo $DiadeHoy["year"]; ?>&AnioFinal=<? echo $DiadeHoy["year"]; ?>"><? echo $Mensajes["usr-16"]; ?></a></span></td><td bgcolor="#ECECEC">&nbsp;</td>
                  </tr>
                </table>
                <hr align="center" width="600" size="1" noshade class="style15">
              </center>
            </span> </td>
            <td valign="top" bgcolor="#E4E4E4"><div align="center">
                <?
                 dibujar_menu_usuarios($Usuario,0);

             ?>
            </div></td>
          </tr>
        </table>
      </center>
    </span></td>
  </tr>

  <tr>
    <td height="44" bgcolor="#E4E4E4"> <font face="Arial">
      <center>
        <hr>
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50">&nbsp;</td>
            <td><div align="center"><font face="Arial"><a href='http://www.unlp.istec.org/prebi' target=_BLANK border=0><img border="0" src="../images/logo-prebi.jpg"></a></font></div></td>
            <td width="50"><div align="center" class="style17">
                <div align="right" class="style18">
                  <div align="center" class="style7">adm_001</div>
                </div>
            </div></td>
          </tr>
        </table>
        <a href='http://www.unlp.istec.org/prebi' target=_BLANK border=0> </a>
      </center>
    </font> </td>
  </tr>
</table>
<style>
  	    #mensajes {
		    position=absolute;
		    visibility='visible';
		    top=50;
		    left=50;
	    }
	    
</style>
<script>
  

</script>


 <?   /* Verificacion de mensajes a los usuarios */
  /* Primero veo si tengo que actualizar algun mensaje */
  if ($idMensaje > 0)
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
             position=absolute;
	     width=225;
	     background-color=blue;
		 left=10;
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
     style='position:absolute;width:225;background-color:#FFFF99;left:10top:".$pos.";visibility:visible;'>";
  
     echo "
       <table>
         <tr>
		 <td width='100%' bgcolor='#006699'>
		  <table colspan=2 width='100%'>
		   <tr>
	          <td width='*' align='center' bgcolor='#006699' onclick='cambiarValor(".$cant.")'>
   	           <font size=1 color='#33FFFF'> Creado <b> ".$mensaje[1]." </b> </font>
		  </td>
  		  <td align='right' width='*' bgcolor='#006699'>
   	            <input type='button' style='color:006699;background:#33FFFF;weight:10;height:18' value='-' onclick=minimizar('texto".$cant."','mensaje".$cant."');>
	            <input type='button' style='color:006699;background:#33FFFF;weight:10;height:18' value='+' onclick=maximizar('texto".$cant."','mensaje".$cant."');>
   	            <input type='button' style='color:006699;background:#33FFFF;weight:10;height:18' value='x' onclick=cerrar('mensaje".$cant."','texto".$cant."');>
		</td>
	        </tr>
  	        </table>

	    </tr>
	   <tr id='texto".$cant."' style='visibility:visible'> <td>
	     <span onclick='cambiarValor(".$cant.")'>
           <font size=2 color='#006699'> ".$mensaje[2]."  </font> </span>
	   </td> </tr>
	   <tr onclick='cambiarValor(".$cant.")'> <td align='right'>
	        <form action='indexcom2.php' action='indexcom2.php' name='form".$cant."'>
			<input type='hidden' name='idMensaje' value='".$mensaje[0]."'>
            <input type='submit' style='color:#006699;font-size:8pt;background:#33FFFF'
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


<?
  Desconectar();

?>
<script>
if (existe1==1)
  document.getElementById('mensaje1').style.top=10;
if (existe2==1)
  document.getElementById('mensaje2').style.top=30;
if (existe3==1)
  document.getElementById('mensaje3').style.top=50;
</script>
</body>
</html>
</body>

</html>
