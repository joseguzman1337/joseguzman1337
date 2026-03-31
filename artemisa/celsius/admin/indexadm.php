<?
  include_once "../inc/var.inc.php";
  include_once "../inc/"."cache.inc";
  include_once "../inc/"."conexion.inc.php"; 
  include_once "../inc/"."sesion.inc";
  global $IdiomaSitio;
  Conexion();
  $prueba=getdate();
  if (!isset($Login))
    $Login = '';
  if (!isset($Password))
    $Password = '';
  
  if ((isset($CkSesionId)) &&($CkSesionId))
  {
  	  // Si tiene sesion definida que conecte con Mysql
  	  include_once "../inc/"."conexion.inc.php";  
      Conexion();
     
	 
  }  
  else
  {
  	 // Ahora se fija si tengo datos en Login & Password

	 if ($Login!="" && $Password!="")
	 {
	//  include_once "../inc/"."conexion.inc.php";  
    //  Conexion();
      $expresion = "SELECT Apellido,Nombres,Id,Codigo_Institucion,Password FROM Usuarios WHERE Login='".$Login."' AND Personal=1";
      $result = mysql_query($expresion);
      $row = mysql_fetch_array($result);
     if (mysql_num_rows($result)>0) 	
       {     $enc = md5($row[4]);

	     $nuevoString = substr($enc,0,strlen($enc)-8);
		  if ($nuevoString != $Password)
		  { //la password es incorrecta
		   Desconectar();
		   header("Location: login.php"); 
		   return; 
                 }

	   // Si es personal de administracion graba los datos en la sesion
//         $row = mysql_fetch_array($result);
         $Usuario = $row[0].", ".$row[1];
         $Id_usuario = $row[2];
         $Instit_usuario = $row[3];
//		 include_once "../inc/"."sesion.inc";
       
	   	  
		 if (SesionCrea())
		 {	
     	  SesionPone("Usuario", $Usuario);
	      SesionPone("Id_usuario", $Id_usuario);
		  SesionPone("Rol", "1");
	      SesionPone("Instit_usuario", $Instit_usuario);
		 }
		 else
		 {
		  Desconectar();
		  header("Location: login.php");
		  return; 
		 } 

        }
       else
       { 
		// el login y password es incorrecto
		
		 Desconectar();
		 header("Location: login.php");
		 return;
       }
	 }
	 else
	 {
	 	// No tengo datos de login & password
		// con lo cual redirijo hacia login
	 	header ("Location: login.php");
		return;
	 }  
	   
  }
  
  // Por aca entra cuando tiene sesion
  // con lo cual pasa a verificar si la sesion identifica
  // que es alguien de administracion
  
  include_once "../inc/"."identif.php";
  Administracion();	
  include_once "../inc/"."fgentrad.php";	
  include_once "../inc/"."fgenped.php";
  if (! isset($IdiomaSitio))
		{ $IdiomaSitio = 1; }
  $Mensajes = Comienzo ("adm-001",$IdiomaSitio);  
  $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
  if (!isset($_COOKIE['layout'])) {
    setcookie('layout','false-true-false-false-false-true-true-true');
    $layout = 'false-true-false-false-false-true-true-true';
  }
  else
    $layout = $HTTP_COOKIE_VARS['layout'];
  setcookie('layout','true-true-false-false-true-true-true');
  $vec = explode('-',$layout);
  
  /*
  $us_query = 'SELECT Administra_usuarios FROM Usuarios Where Id = '.$Id_usuario;
  $user_admin = mysql_query($us_query);
  echo mysql_error();
  $row_us = mysql_fetch_row($user_admin);
  $Administra_usuarios = $row_us[0];
    */            
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>PrEBi</title>
<script>

 window.parent.frames[0].document.getElementById('login_admin').firstChild.nodeValue = "<? echo $Mensajes["txt-1"]; ?>";
 window.parent.frames[0].document.getElementById('login_admin').style.visibility = "visible";


  var elem1=0;
  var elem2=0;
  var elem3=0;
  var existe1=0;
  var existe2=0;
  var existe3=0;
  //el vector frames guarda la visibilidad de las tablas
 
 
  var valor = "<? $valor= Devolver_Abreviatura_Pais_Predeterminada()."-".Devolver_Abreviatura_Institucion_Predeterminada()."-"; echo $valor;?>";


  function cambiar()
  {
	  if (document.getElementById('campo').value == 2)
	  {
		  document.getElementById('labelTitulos').style.visibility = 'visible';
		  document.getElementById('labelTitulos').style.position = 'relative';
	  }
	  else
	  {
		  document.getElementById('labelTitulos').style.visibility = 'hidden';
		  document.getElementById('labelTitulos').style.position = 'absolute';
	  }

	  if (document.getElementById('campo').value == 1)  {
				document.getElementById('expresion').value=valor;
				}
				else
				{
					document.getElementById('expresion').value='';
				}
  }
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
	e =window.event;
   	if ((existe1==1) && (elem1))
	   { 
		  if (window.event) {
            
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
             
        	 document.getElementById('mensaje3').style.top = e.clientY - 10;
		     document.getElementById('mensaje3').style.left = e.clientX - 10;

	       }
	       else {
	          document.getElementById('mensaje3').style.top = event.pageY - 10;
		      document.getElementById('mensaje3').style.left = event.pageX - 10;
			
	       }
		 }
   }
  
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


	function mostrar(mostrar, ocultar , mispan , operacion)
	{  
		
	
		
		document.getElementById(mostrar).style.position = 'relative';
		document.getElementById(mostrar).style.visibility = 'visible';

		document.getElementById(ocultar).style.position = 'absolute';
		document.getElementById(ocultar).style.visibility = 'hidden';
		
		if (operacion == 0)
			{	

				document.getElementById(mispan).style.position = 'relative';
				document.getElementById(mispan).style.visibility = 'visible';
			
			}
			else
			{
				document.getElementById(mispan).style.position = 'absolute';
				document.getElementById(mispan).style.visibility = 'hidden';
			}
        var aux;
	    if (document.getElementById('tabla1').style.visibility == 'visible')
			  aux = 'true';
		else aux = 'false';
		if (document.getElementById('tabla2').style.visibility == 'visible')
			  aux = aux + '-true';
		else aux = aux + '-false';
		if (document.getElementById('tabla3').style.visibility == 'visible')
			  aux = aux +'-true';
		else aux = aux +'-false';
		if (document.getElementById('tabla4').style.visibility == 'visible')
			  aux =aux + '-true';
		else aux = aux +'-false';
		if (document.getElementById('tabla5').style.visibility == 'visible')
			  aux = aux +'-true';
		else aux = aux +'-false';
		if (document.getElementById('tabla6').style.visibility == 'visible')
			  aux = aux +'-true';
		else aux = aux +'-false';
	    if (document.getElementById('tabla7').style.visibility == 'visible')
			  aux =aux + '-true';
		else aux = aux +'-false';
		if (document.getElementById('tabla8').style.visibility == 'visible')
			  aux =aux + '-true';
	    else aux = aux +'-false';
        document.cookie = "layout="+aux;

	}
   
   function titulosNormalizados()
   { 
	var Letra = "A";
//    alert("Letra");
    if (document.forms.busqueda.expresion.value != '')
		  Letra = document.forms.busqueda.expresion.value;
	  var win = window.open("./elige_col.php?dedonde=popup&Letra="+Letra,"titulos","toolbar=no, directories=no, location=no,status=yes, menubar=no, resizable=yes, scrollbars=yes, width=700, height=700, top=20, left=30");
   }


</script>



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
.style11 {color: #1380C3; font-family: Arial, Helvetica, sans-serif; font-size: 11px; }
.style22 {
	color: #333333;
	font-family: verdana;
	font-size: 11px;
}
.style23 {
	color: #000000;
	font-size: 11px;
}
.style28 {color: #FFFFFF; font-size: 11px; }
.style30 {
	font-size: 11px;
	color: #000000;
	font-family: Verdana;
}
.style32 {font-size: 11px}
.style33 {
	font-family: verdana;
	font-size: 11px;
	color: #1380C3;
}
.style35 {font-size: 11px; color: #FFFFFF; font-family: Verdana; }
.style46 {color: #666666}
.style47 {font-family: Verdana; font-size: 11px; color: #666666; }
-->
</style>
<base target="_self">
</head>


<body topmargin="0" id='cuerpo' onmousemove=mover(event);  >
<div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <div align="center">
        <center>

      <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#EFEFEF">
        <td align="left" valign="top" bgcolor="#E4E4E4">                <div align="left" class="style30">        </div>         
          <table width="100%"  border="0" cellspacing="0" cellpadding="0">
		     
                    <tr bgcolor="#1380C3">
                      <td height="20" colspan="3" class="style28"><span class="style30"><span class="style35"><? echo $Mensajes["ec-2"]; ?></span></span></td>
                    </tr>
		</table>
		<hr>   
				<table width="100%"  border="0" cellspacing="0" cellpadding="0">
                    <tr bgcolor="#1380C3">
					
                      <td height="20" width="20" valign='MIDDLE' bgcolor="#999999">&nbsp;<IMG SRC="../images/boton-mas.jpg"  BORDER="0" id='buttonMas2' onclick="mostrar('buttonMenos2' , 'buttonMas2' , 'tabla2' , 0);" style='visibility:hidden;position:absolute;'><IMG SRC="../images/boton-menos.jpg"  BORDER="0" id='buttonMenos2' onclick="mostrar('buttonMas2' ,'buttonMenos2', 'tabla2' , 1);"></td>
                      <td height="20" colspan="2" bgcolor="#999999"><div align="left"><span class="style35"><? echo $Mensajes["ec-5"]; ?></span></div></td>
                    </tr>

				</table>
		

		<!-- Menu de los Datos de Usuarios - Comunicaciones y Consultas de Pedidos -->
			<table width="100%"  border="0" cellspacing="0" cellpadding="0"  id='tabla2' >
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"><? echo $Mensajes["tf-3"]; ?></div></td>
                      <td height="18" colspan="2" align="left" class="style47"><div align="left"><a href="elige_usuario.php?Letra=A&dedonde=1"><? echo $Mensajes["hr-4"]; ?></a></div></td>
                    </tr>
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"><? echo $Mensajes["tf-13"]; ?></div></td>
                      <td width="200" height="18" align="left" class="style47"><div align="left"><a href="../usuarios/form_usu.php?operacion=0"><? echo $Mensajes["hr-1"]; ?></a></div></td>
                      <td height="18" align="left" class="style47"><div align="left"><a href="../usuarios/elige_usu.php?Letra=A"><? echo $Mensajes["hr-3"]; ?></a></div></td>
                    </tr>
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"><? echo $Mensajes["tf-25"]; ?></div></td>
                      <td width="200" height="18" align="left" class="style47"><div align="left"><a HREF="elige_usuario.php?Letra=A&dedonde=4"><? echo $Mensajes["hr-1"]; ?></a></div></td>
                      <td height="18" align="left" class="style47"><div align="left"><A HREF="elige_usuario.php?Letra=A&dedonde=5"><? echo $Mensajes["hco-1"]; ?></A></div></td>
                    </tr>
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"><? echo $Mensajes["tf-14"]; ?></div></td>
                      <td width="200" height="18" align="left" class="style47"><div align="left"><A HREF='elige_usuario.php?Letra=A&dedonde=3&usuario=<? echo SesionToma("Id_usuario");?>'><? echo $Mensajes["hco-1"]; ?></A></div></td>
                      <td height="18" align="left" class="style47"><div align="left"><A HREF="elige_col.php?dedonde=1&Letra=A"><? echo $Mensajes["hco-2"]; ?></A></div></td>
                    </tr>
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"><? echo $Mensajes["nn-1"]; ?></div></td>
                      <td width="200" height="18" align="left" class="style47"><div align="left"><A HREF="../pedidos/pedidos_anulado.php"><? echo $Mensajes["nn-2"]; ?></A></div></td>
                      <td height="18" align="left" class="style47"><div align="left"></div></td>
                    </tr>

					<!-- Todo lo comentado se debe a que la busqueda engloba todas las búsquedas-->
					 <!--
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"></div></td>
                      <td height="18" colspan="2" align="left" class="style47"><div align="left"><A HREF="../pedidos/manpedcoltl.php?dedonde=1"><? echo $Mensajes["hco-3"]; ?></A></div></td> 
                    </tr>
 					<tr>
                      <td width="180" height="18" class="style30"><div align="left"></div></td>
                      <td width="200" height="18" align="left" class="style47"><div align="left"><A HREF="../pedidos/manpedcoltitar.php?dedonde=1"><? echo $Mensajes["hco-5"]; ?></A></div></td>
                      <td height="18" align="left" class="style47"><div align="left"><A HREF="../pedidos/manpedcolaut.php"><? echo $Mensajes["hco-7"]; ?></A> </div></td>
                    </tr>
					-->
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"><? echo $Mensajes["tf-15"]; ?></div></td>
                      <td width="200" height="18" align="left" class="style47"><div align="left"><a href="elige_usuario.php?Letra=A&dedonde=2"><? echo $Mensajes["hco-1"]; ?></a></div></td>
                      <td height="18" align="left" class="style47"><div align="left"><a href="elige_col.php?dedonde=2&Letra=A"><? echo $Mensajes["hco-2"]; ?></a></div></td>
                    </tr>
					<!--
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"></div></td>
                       <td height="18" colspan="2" align="left" class="style47"><div align="left"><a href="../pedidos/manpedcoltlh.php?dedonde=1"><? echo $Mensajes["hco-3"]; ?></a></div></td>
					</tr>
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"></div></td>
                      <td width="200" height="18" align="left" class="style47"><div align="left"><A HREF="../pedidos/manpedcoltitarh.php?dedonde=1"><? echo $Mensajes["hco-6"]; ?></A></div></td>
                      <td height="18" align="left" class="style47"><div align="left"><A HREF="../pedidos/manpedcolauth.php?dedonde=1"><? echo $Mensajes["hco-8"]; ?></A> </div></td>
                    </tr>
					-->
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"><? echo $Mensajes["hc-27"]; ?></div></td>
                      <td width="200" height="18" align="left" class="style47"><div align="left"><A HREF="../usuarios/mensajes.php?operacion=1"><? echo $Mensajes["hc-28"]; ?></A></div></td>
                      <td height="18" align="left" class="style47"><div align="left"><A HREF="../usuarios/mensajes.php?operacion=2"><? echo $Mensajes["hc-29"]; ?></A></div></td>
                    </tr>
<tr>
                      <td width="180" height="18" class="style30"><div align="left"><? echo $Mensajes["nn-3"]; ?></div></td>
                      <td width="200" height="18" align="left" class="style47"><div align="left"><A HREF="../usuarios/aut_bib.php"><? echo $Mensajes["nn-4"]; ?></A></div></td>
                      <td height="18" align="left" class="style47"><div align="left">&nbsp;</div></td>
                    </tr>

                                </table>                
           <?
		  //if ($Administra_usuarios != 1)
            //      { //el usuario tiene facultades para administrar otros usuarios
            //?>
		
		  <hr>
		  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
			<tr bgcolor="#1380C3">
					   <td height="20" width="20" valign='MIDDLE' bgcolor="#999999">&nbsp;<IMG SRC="../images/boton-menos.jpg"  BORDER="0" id='buttonMenos8' onclick="mostrar('buttonMas8' ,'buttonMenos8', 'tabla8' , 1);" style='visibility:hidden;position:absolute;'><IMG SRC="../images/boton-mas.jpg"  BORDER="0" id='buttonMas8' onclick="mostrar('buttonMenos8' , 'buttonMas8' , 'tabla8' , 0);" ></td>
                      <td height="20" colspan="2" bgcolor="#999999"><span align="left"><span class="style35"><? echo $Mensajes["nn-5"]; ?></span></span></td>
                    </tr>

			</table>

			<!-- Menu de Internacionalización del Sitio -->
				
				<table width="100%"  border="0" cellspacing="0" cellpadding="0" style='visibility:hidden;position:absolute;' id='tabla8' >
				
                    <tr>
                       <td width="180" height="18" class="style30" ><div align="right"><span class="style30"><? echo $Mensajes["nn-6"]; ?></span></div></td>
					   <form name="busqueda" action='../pedidos/busqueda.php'>
                      <td width="200" height="18" class="style47"><span align="left" class="style47" colspan=2><INPUT TYPE="text" NAME="expresion" id="expresion" value="<? echo $valor;?>" class="style47" width="50"></span>				  
					  <INPUT class="style47" TYPE="submit" value='<? echo $Mensajes["nn-16"]; ?>'></span></td>
					  <!-- <td align="center" class="style47"><span align="left">&nbsp;</span></td> -->
                    <tr>
                      <td width="150" height="18" class="style30"><div align="left">&nbsp;</div></td>
                      <td width="300" height="18" class="style47" ><span align="left" class="style47">
					  <SELECT NAME="campo" onChange="cambiar();" id=campo class="style47">
					  <option value ="1" ><? echo $Mensajes["nn-7"]; ?></option>
					  <option value ="2"><? echo $Mensajes["nn-9"]; ?></option> 
					  <option value ="3"><? echo $Mensajes["nn-8"]; ?></option>
					  </SELECT> <!--</td> <td width="250" height="18" class="style47"> -->
					  <span align="left" class="style47" id="labelTitulos" style="position:relative"> <a href="Javascript:titulosNormalizados();"><? echo $Mensajes["nn-10"]; ?></a></span>
					  </span>
					   </td>
					  
					  			<input type="hidden" name="dedonde" value="0">
                                <input type="hidden" name="Modo" value="4">

			</form>
                    </tr>
            </table> 

		<hr>
		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
                    <tr bgcolor="#999999">
					

					
                      <td height="20" width="20" valign='MIDDLE' bgcolor="#999999">&nbsp;<IMG SRC="../images/boton-menos.jpg"  BORDER="0" id='buttonMenos1' onclick="mostrar('buttonMas1' ,'buttonMenos1', 'tabla1' , 1);" style='visibility:hidden;position:absolute;'><IMG SRC="../images/boton-mas.jpg"  BORDER="0" id='buttonMas1' onclick="mostrar('buttonMenos1' , 'buttonMas1' , 'tabla1' , 0);" ></td>

                      <td height="20"  class="style35" valign='MIDDLE' align='left'><div align="left" ><? echo $Mensajes["ec-3"]; ?></div></td>
                    </tr>
		</table>

		<!-- Menu de  Portada del Sitio -->
			<table width="100%"  border="0" cellspacing="0" cellpadding="0" style='visibility:hidden;position:absolute;' id='tabla1' >
						
                    <tr class="style30"  >
                      <td width="180" height="18" class="style30" ><div align="left"><span class="style30"><? echo $Mensajes["tf-1"]; ?></span></div></td>
                      <td width="200" align="center" class="style47"><div align="left"><a href="../noticias/form_noticia.php?operacion=0"><? echo $Mensajes["hr-1"]; ?></a></div></td>
                      <td align="center" class="style47"><div align="left"><a href="../noticias/elige_not.php"><? echo $Mensajes["hr-2"]; ?></a></div></td>
                    </tr>
                    <tr class="style30"  >
                      <td width="180" height="18" class="style30"><div align="left"><span class="style30"><? echo $Mensajes["tf-2"]; ?></span></div></td>
                      <td width="200" align="center" class="style47"><div align="left"><a href="../sugerencias/form_suger.php?operacion=0"><? echo $Mensajes["hr-1"]; ?></a></div></td>
                      <td align="center" class="style47"><div align="left"><a href="../sugerencias/elige_sug.php"><? echo $Mensajes["hr-2"]; ?></a></div></td>
                    </tr>
                    <tr class="style30"  >
                      <td width="180" height="18" class="style30"><div align="left"><span class="style30"><? echo $Mensajes["nn-11"]; ?> </span></div></td>
                      <td width="200" align="center" class="style47"><div align="left"><a href="../secciones/form_secc.php?operacion=0"><? echo $Mensajes["hr-1"]; ?></a></div></td>
                      <td align="center" class="style47"><div align="left"><a href="../secciones/elige_secc.php"><? echo $Mensajes["hr-2"]; ?></a></div></td>
                    </tr>
                    <tr class="style30"  >
                      <td width="180" height="18" class="style30"><div align="left"><span class="style30"><? echo $Mensajes["nn-12"]; ?></span></div></td>
                      <td width="200" align="center" class="style47"><div align="left"><a href="../contenidos/form_cont.php?operacion=0"><? echo $Mensajes["hr-1"]; ?></a></div></td>
                      <td align="center" class="style47"><div align="left"><a href="../contenidos/elige_cont.php"><? echo $Mensajes["hr-2"]; ?></a></div></td>
                    </tr>
                    <tr class="style30"  >
                      <td width="180" height="18" class="style30"><div align="left"><span class="style30"><? echo $Mensajes["nn-13"]; ?></span></div></td>
                      <td width="200" align="center" class="style47"><div align="left"><a href="../elemcontenidos/form_econt.php?operacion=0"><? echo $Mensajes["hr-1"]; ?></a></div></td>
                      <td align="center" class="style47"><div align="left"><a href="../elemcontenidos/elige_econt.php"><? echo $Mensajes["hr-2"]; ?></a></div></td>
                    </tr>
                      </table>                
          
  
		   <hr>   
			<table width="100%"  border="0" cellspacing="0" cellpadding="0">
                    <tr bgcolor="#1380C3">

                      <td height="20" width="20" valign='MIDDLE' bgcolor="#999999">&nbsp;<IMG SRC="../images/boton-menos.jpg"  BORDER="0" id='buttonMenos3' onclick="mostrar('buttonMas3' ,'buttonMenos3', 'tabla3' , 1);" style='visibility:hidden;position:absolute;'><IMG SRC="../images/boton-mas.jpg"  BORDER="0" id='buttonMas3' onclick="mostrar('buttonMenos3' , 'buttonMas3' , 'tabla3' , 0);" ></td>
					  
                      <td height="20" colspan="2" bgcolor="#999999"><div align="left">
					  <span class="style35"><? echo $Mensajes["ec-11"]; ?></span></div></td>
                    </tr>

			</table>
		

		<!-- Menu de los Datos de Usuarios - Comunicaciones y Consultas de Pedidos -->
			<table width="100%"  border="0" cellspacing="0" cellpadding="0" style='visibility:hidden;position:absolute;' id='tabla3' >
			
			
                 
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"><? echo $Mensajes["tf-20"]; ?></div></td>
                      <td width="200" height="18" class="style47"><a href="../anula/anulaped.php"><? echo $Mensajes["ha-1"]; ?></a></td>
                      <td height="18" class="style47"><a href="../anula/conanuped.php"><?  echo $Mensajes["ha-2"]; ?></a></td>
                    </tr>
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"><? echo $Mensajes["tf-21"]; ?></div></td>
                      <td width="200" height="18" class="style47"><a href="../anula/anulaeve.php"><? echo $Mensajes["ha-1"]; ?></a></td>
                      <td height="18" class="style47"><a href="../anula/conanueve.php"><? echo $Mensajes["ha-2"]; ?></a></td>
                    </tr>
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"><? echo $Mensajes["tf-22"]; ?></div></td>
                      <td height="18" colspan="2" class="style47"><a href="../anula/anupedhist.php"><? echo $Mensajes["ha-1"]; ?></a></td>
                    </tr>
                                </table>
								
				<hr> 
				 <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                    <tr bgcolor="#1380C3">

					  <td height="20" width="20" valign='MIDDLE' bgcolor="#999999">&nbsp;<IMG SRC="../images/boton-menos.jpg"  BORDER="0" id='buttonMenos4' onclick="mostrar('buttonMas4' ,'buttonMenos4', 'tabla4' , 1);" style='visibility:hidden;position:absolute;'><IMG SRC="../images/boton-mas.jpg"  BORDER="0" id='buttonMas4' onclick="mostrar('buttonMenos4' , 'buttonMas4' , 'tabla4' , 0);" ></td>

					  
                      <td height="20" colspan="2" bgcolor="#999999"><div align="left"><span class="style35"><? echo $Mensajes["ec-4"]; ?></span></div></td>
                    </tr>

			</table>
		

			<!-- Menu de Datos Generales para la Administración -->
				<table width="100%"  border="0" cellspacing="0" cellpadding="0" style='visibility:hidden;position:absolute;' id='tabla4' >
				
                  
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"><? echo $Mensajes["tf-4"]; ?></div></td>
                      <td width="200" height="18" class="style47"><div align="left"><a href="../paises/form_pais.php?dedonde=0"><? echo $Mensajes["hr-1"]; ?></a></div></td>
                      <td height="18" class="style47"><div align="left"><a href="../paises/elige_pais.php"><? echo $Mensajes["hr-3"]; ?></a></div></td>
                    </tr>
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"><? echo $Mensajes["tf-5"]; ?></div></td>
                      <td width="200" height="18" class="style47"><div align="left"><a href="../localidades/form_loc.php?dedonde=0"><? echo $Mensajes["hr-1"]; ?></a></div></td>
                      <td height="18" class="style47"><div align="left"><a href="../localidades/elige_localidad.php"><? echo $Mensajes["hr-3"]; ?></a></div></td>
                    </tr>
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"><? echo $Mensajes["tf-6"]; ?></div></td>
                      <td width="200" height="18" class="style47"><div align="left"><a href="../instituciones/form_instit.php?dedonde=0"><? echo $Mensajes["hr-1"]; ?></a></div></td>
                      <td height="18" class="style47"><div align="left"><a href="../instituciones/elige_instit.php"><? echo $Mensajes["hr-3"]; ?></a></div></td>
                    </tr>
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"><? echo $Mensajes["tf-7"]; ?></div></td>
                      <td width="200" height="18" class="style47"><div align="left"><a href="../dependencias/form_depe.php?dedonde=0"><? echo $Mensajes["hr-1"]; ?></a></div></td>
                      <td height="18" class="style47"><div align="left"><a href="../dependencias/elige_depe.php"><? echo $Mensajes["hr-3"]; ?></a></div></td>
                    </tr>
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"><? echo $Mensajes["tf-8"]; ?></div></td>
                      <td width="200" height="18" class="style47"><div align="left"><a href="../unidades/form_unid.php?operacion=0"><? echo $Mensajes["hr-1"]; ?></a</div></td>
                      <td height="18" class="style47"><div align="left"><a href="../unidades/elige_unid.php"><? echo $Mensajes["hr-3"]; ?></a></div></td>
                    </tr>
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"><? echo $Mensajes["tf-9"] ?></div></td>
                      <td width="200" height="18" class="style47"><div align="left"><a href="../categorias/form_cat.php?operacion=0"><? echo $Mensajes["hr-1"]; ?></a></div></td>
                      <td height="18" class="style47"><div align="left"><a href="../categorias/elige_cat.php"><? echo $Mensajes["hr-3"]; ?></a></div></td>
                    </tr>
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"><? echo $Mensajes["tf-10"]; ?></div></td>
                      <td width="200" height="18" class="style47"><div align="left"><a href="../solicitudes/add_cand1.php?dedonde=0"><? echo $Mensajes["hr-1"]; ?></a></div></td>
                      <td height="18" class="style47"><div align="left"><a href="../solicitudes/administrar_usuarios.php"><? echo $Mensajes["hr-3"]; ?></a></div></td>
                    </tr>
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"><? echo $Mensajes["tf-11"]; ?></div></td>
                      <td width="200" height="18" class="style47"><div align="left"><a href="../colecciones/form_colec.php?dedonde=0"><? echo $Mensajes["hr-1"]; ?></a></div></td>
                      <td height="18" class="style47"><div align="left"><a href="../colecciones/tesauro.php?Letra=A"><? echo $Mensajes["hr-3"]; ?></a></div></td>
                    </tr>
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"><? echo $Mensajes["tf-32"]; ?></div></td>
                      <td width="200" height="18" class="style47"><div align="left"><a href="../catalogos/form_catal.php?dedonde=0"><? echo $Mensajes["hr-1"]; ?></a></div></td>
                      <td height="18" class="style47"><div align="left"><a href="../catalogos/elige_catal.php"><? echo $Mensajes["hr-3"]; ?></a></div></td>
                    </tr>

					<tr>
                      <td width="180" height="18" class="style30"><div align="left"><? echo $Mensajes["nn-14"]; ?></div></td>
                      <td width="200" height="18" class="style47"><div align="left"><a href="../formapago/form_pago.php?dedonde=0"><? echo $Mensajes["hr-1"]; ?></a></div></td>
                      <td height="18" class="style47"><div align="left"><a href="../formapago/elige_forma_pago.php"><? echo $Mensajes["hr-3"]; ?></a></div></td>
                    </tr>

<tr>
                      <td width="180" height="18" class="style30"><div align="left"><? echo $Mensajes["nn-17"]; ?></div></td>
                      <td width="200" height="18" class="style47"><div align="left"><a href="../solicitudes/rechazados.php?dedonde=0"><? echo $Mensajes["nn-18"]; ?></a></div></td>
                      <td height="18" class="style47"><div align="left">&nbsp;</div></td>
                    </tr>



                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"></div></td>
                      <td height="18" colspan="2" class="style47"><div align="left"></div>                        
                        <div align="left"><a href="union.php"><? echo $Mensajes["tf-28"]; ?></div></td>
                      </tr>
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"><? echo $Mensajes["tf-12"]; ?></div></td>
                      <td width="200" height="18" class="style47"><div align="left"><a href="../campos/elige_campos.php?Tipo_Material=1"><? echo $Mensajes["he-1"]; ?></a></div></td>
                      <td height="18" class="style47"><div align="left"><a href="../campos/elige_campos.php?Tipo_Material=2"><? echo $Mensajes["he-2"]; ?></a></div></td>
                    </tr>
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"><? echo $Mensajes["tf-12"]; ?></div></td>
                      <td width="200" height="18" class="style47"><div align="left"><a href="../campos/elige_campos.php?Tipo_Material=3"><? echo $Mensajes["he-3"]; ?></a></div></td>
                      <td height="18" class="style47"><div align="left"><A HREF="../campos/elige_campos.php?Tipo_Material=4"><? echo $Mensajes["he-4"]; ?></A></div></td>
                    </tr>
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"><? echo $Mensajes["tf-12"]; ?></div></td>
                      <td width="200" height="18" class="style47"><div align="left"><A HREF="../campos/elige_campos.php?Tipo_Material=5"><? echo $Mensajes["he-5"]; ?></A></div></td>
                      <td height="18" class="style47"><div align="left"><a href="../campos/elige_campos.php?Tipo_Material=0"><? echo $Mensajes["he-6"]; ?></a></div></td>
                    </tr>
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"></div></td>
                      <td height="18" colspan="2" class="style47"><div align="left"></div>                                                <div align="left"><a href="ejecutaSql.php"><? echo $Mensajes["he-8"]; ?></a></div></td>
                      </tr>
					  <tr>
                      <td width="180" height="18" class="style30"><div align="left"></div></td>
                      <td height="18" colspan="2" class="style47"><div align="left"></div>                                                <div align="left"><a href="backup_base.php"><? echo $Mensajes["nn-15"]; ?></a></div></td>
                      </tr>
             </table>
			 
			 <hr>   
			 
			 <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                    <tr bgcolor="#1380C3">

					 <td height="20" width="20" valign='MIDDLE' bgcolor="#999999">&nbsp;<IMG SRC="../images/boton-menos.jpg"  BORDER="0" id='buttonMenos5' onclick="mostrar('buttonMas5' ,'buttonMenos5', 'tabla5' , 1);" style='visibility:hidden;position:absolute;'><IMG SRC="../images/boton-mas.jpg"  BORDER="0" id='buttonMas5' onclick="mostrar('buttonMenos5' , 'buttonMas5' , 'tabla5' , 0);" ></td>

					  
                      <td height="20" colspan="2" bgcolor="#999999"><div align="left"><span class="style35"><? echo $Mensajes["ec-6"]; ?></span></div></td>
                    </tr>

			</table>
		

		<!-- Menu de las Utilidades -->
			<table width="100%"  border="0" cellspacing="0" cellpadding="0" style='visibility:hidden;position:absolute;' id='tabla5' >
			
                    
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"><? echo $Mensajes["tf-26"]; ?></div></td>
                      <td width="200" height="18" class="style47"><div align="left"><a href="../plantmail/form_pmail.php?operacion=0"><? echo $Mensajes["hr-1"]; ?></a></div></td>
                      <td height="18" class="style47"><div align="left"><a href="../plantmail/elige_pmail.php"><? echo $Mensajes["hr-2"]; ?></a></div></td>
                    </tr>
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"><? echo $Mensajes["tf-27"]; ?> </div></td>
                      <td height="18" colspan="2" class="style47"><div align="left"></div>                        
                        <div align="left"><a href="../lcorreo/asistente1.php?operacion=0"><? echo $Mensajes["he-7"]; ?></a></div></td>
                      </tr>
              </table>
			<hr> 
				
			 <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                    <tr bgcolor="#1380C3">
					   <td height="20" width="20" valign='MIDDLE' bgcolor="#999999">&nbsp;<IMG SRC="../images/boton-menos.jpg"  BORDER="0" id='buttonMenos6' onclick="mostrar('buttonMas6' ,'buttonMenos6', 'tabla6' , 1);" style='visibility:hidden;position:absolute;'><IMG SRC="../images/boton-mas.jpg"  BORDER="0" id='buttonMas6' onclick="mostrar('buttonMenos6' , 'buttonMas6' , 'tabla6' , 0);" ></td>

                      <td height="20" colspan="2" bgcolor="#999999"><div align="left"><span class="style35"><? echo $Mensajes["ec-8"]; ?></span></div></td>
                    </tr>

			</table>
		

			<!-- Menu de Internacionalización del Sitio -->
				<table width="100%"  border="0" cellspacing="0" cellpadding="0" style='visibility:hidden;position:absolute;' id='tabla6' >
				
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"><? echo $Mensajes["tf-16"]; ?></div></td>
                      <td width="200" height="18" class="style47"><div align="left"><a href="../idiomas/form_idioma.php?operacion=0"><? echo $Mensajes["hr-1"]; ?></a></div></td>
                      <td height="18" class="style47"><div align="left"><a href="../idiomas/elige_idioma.php"><? echo $Mensajes["hr-2"]; ?></a> </div></td>
                    </tr>
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"><? echo $Mensajes["tf-17"]; ?></div></td>
                      <td width="200" height="18" class="style47"><div align="left"><a href="../paginas/form_pagina.php?dedonde=0"><? echo $Mensajes["hr-1"]; ?></a></div></td>
                      <td height="18" class="style47"><div align="left"><a href="../paginas/elige_pagina.php"><? echo $Mensajes["hr-2"]; ?></a></div></td>
                    </tr>
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"><? echo $Mensajes["tf-18"]; ?></div></td>
                      <td width="200" height="18" class="style47"><div align="left"><a href="../elementos/form_elem.php?dedonde=0"><? echo $Mensajes["hr-1"]; ?></a></div></td>
                      <td height="18" class="style47"><div align="left"><a href="../elementos/elige_elem.php"><? echo $Mensajes["hr-2"]; ?></a></div></td>
                    </tr>
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"><? echo $Mensajes["tf-19"]; ?></div></td>
                      <td height="18" colspan="2" class="style47"><div align="left"></div>                        <div align="left"><a href="../traducciones/elige_trad.php"><? echo $Mensajes["hr-2"]; ?></a></div></td>
                      </tr>
                    <tr>
                      <td width="180" height="18" class="style30"><div align="left"><? echo $Mensajes["tf-19"]; ?></div></td>
                      <td width="200" height="18" class="style47"><div align="left"><a href="../traducciones/save_idioma.php?operacion=0"><? echo $Mensajes["hr-5"]; ?></a></div></td>
                      <td height="18" class="style47"><div align="left"><a href="../traducciones/load_idioma.php"><? echo $Mensajes["hr-6"]; ?></a></div></td>
                    </tr>
                                </table> 

		
								<? //}?></td>
		
        <td width="200" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
        
		  
		  <table width="100%" border="0" bgcolor="#EFEFEF">
            <tr>
              <td height="20" align="center" class="style30" colspan="3"><img src="../images/image001.jpg" width="150" height="118"></td>
            </tr>
         <?
		  //if ($Administra_usuarios != 1)
            //      { //el usuario tiene facultades para administrar otros usuarios
            ?>
  
			<tr>
			<td height="20" width="20" valign='MIDDLE' bgcolor="#1380C3">&nbsp;<IMG SRC="../images/boton-menos.jpg"  BORDER="0" id='buttonMenos7' onclick="mostrar('buttonMas7' ,'buttonMenos7', 'tabla7' , 1);"><IMG SRC="../images/boton-mas.jpg" style='visibility:hidden;position:absolute;' BORDER="0" id='buttonMas7' onclick="mostrar('buttonMenos7' , 'buttonMas7' , 'tabla7' , 0);" ></td>
              <td height="20" bgcolor="#1380C3" class="style30"><div align="center">
                <p style="margin-top: 0; margin-bottom: 0; color: #FFFFFF;"><? echo $Mensajes["ec-1"]; ?>
              </div></td>
            </tr>
      </table>
	  <table width="100%" border="0" bgcolor="#EFEFEF" style='visibility:visible;position:relative;' id='tabla7'>
            <tr>
              <td bgcolor="#ECECEC" class="style30" colspan="2"><div align="left" class="style32">
                <div align="left"><?
          $expresion = "SELECT COUNT(*) FROM Pedidos WHERE Estado=1";
          $result = mysql_query($expresion);
          $rowc = mysql_fetch_array($result);  
          if ($rowc[0]>1){
               echo "<a href='../pedidos/manpedadm.php?Modo=1'>".$rowc[0]." ".$Mensajes["hc-1"]."</a>";
               }
             elseif ($rowc[0]==1){  
                 echo "<a href='../pedidos/manpedadm.php?Modo=1'>".$rowc[0]." ".$Mensajes["hc-2"]."</a>";  
             }
             else
             {
               echo $Mensajes["hc-3"];
              }
          ?></div>
              </div></td>
            </tr>
            <tr>
              <td bgcolor="#ECECEC" class="style30" colspan="2"><div align="left" class="style32">
                <div align="left"><?
          $expresion = "SELECT COUNT(*) FROM Pedidos WHERE Estado=2";
          $result = mysql_query($expresion);
          $rowc = mysql_fetch_array($result);  
          if ($rowc[0]>1){
               echo "<a href='../pedidos/manpedadm.php?Modo=2'>".$rowc[0]." ".$Mensajes["hc-4"]."</a>";
               }
             elseif ($rowc[0]==1){  
                 echo "<a href='../pedidos/manpedadm.php?Modo=2'>".$rowc[0]." ".$Mensajes["hc-5"]."</a>";  
             }
             else
             {
               echo $Mensajes["hc-6"];
              }

           ?></div>
              </div></td>
            </tr>
            <tr>
              <td bgcolor="#ECECEC" class="style30" colspan="2"><div align="left" class="style32">
                <div align="left"><?
          $expresion = "SELECT COUNT(*) FROM Pedidos WHERE Estado=3";
          $result = mysql_query($expresion);
          $rowc = mysql_fetch_array($result);  
          if ($rowc[0]>1){
               echo "<a href='../pedidos/manpedadm.php?Modo=3'>".$rowc[0]." ".$Mensajes["hc-7"]."</a>";
               }
             elseif ($rowc[0]==1){  
                 echo "<a href='../pedidos/manpedadm.php?Modo=3'>".$rowc[0]." ".$Mensajes["hc-8"]."</a>";  
             }
             else
             {
               echo $Mensajes["hc-9"];
              }

           ?></div>
              </div></td>
            </tr>
            <tr>
              <td bgcolor="#ECECEC" class="style30" colspan="2"><div align="left" class="style32">
                <div align="left"><?
          $expresion = "SELECT COUNT(*) FROM Pedidos WHERE Estado=4";
          $result = mysql_query($expresion);
          $rowc = mysql_fetch_array($result);  
          if ($rowc[0]>1){
               echo "<a href='../pedidos/manpedadm.php?Modo=4'>".$rowc[0]." ".$Mensajes["hc-10"]."</a>";
               }
             elseif ($rowc[0]==1){  
                 echo "<a href='../pedidos/manpedadm.php?Modo=4'>".$rowc[0]." ".$Mensajes["hc-11"]."</a>";  
             }
             else
             {
               echo $Mensajes["hc-12"];
              }

           ?></div>
              </div></td>
            </tr>
            <tr>
              <td bgcolor="#ECECEC" class="style30" colspan="2"><div align="left" class="style32">
                <div align="left"><?
          $expresion = "SELECT COUNT(*) FROM Pedidos WHERE Estado=5";
          $result = mysql_query($expresion);
          $rowc = mysql_fetch_array($result);  
          if ($rowc[0]>1){
               echo "<a href='../pedidos/manpedadm.php?Modo=5'>".$rowc[0]." ".$Mensajes["hc-13"]."</a>";
               }
             elseif ($rowc[0]==1){  
                 echo "<a href='../pedidos/manpedadm.php?Modo=5'>".$rowc[0]." ".$Mensajes["hc-14"]."</a>";  
             }
             else
             {
               echo $Mensajes["hc-15"];
              }

           ?></div>
              </div></td>
            </tr>
<!--            <tr>
              <td bgcolor="#CECECE" class="style30" colspan="2"><div align="left" class="style32 style36">
                <div align="left"><a href="../pedidos/busqueda.php"><? echo $Mensajes["hc-16"]; ?></a><br>
                </div>
              </div></td>
            </tr> -->
            <tr>
              <td bgcolor="#CECECE" class="style30" colspan="2"><div align="left"><span class="style23"><a href="../pedidos/manpeddest.php"><? echo $Mensajes["hc-23"]; ?></a></span></div></td>
            </tr>
        </table>
		<table>
			<tr>
              <?
            $expresion = "SELECT COUNT(*) FROM Candidatos where rechazados=0";
            $result = mysql_query($expresion);
            $rowc = mysql_fetch_array($result);  
           ?>
		  <td height="20" bgcolor="#1380C3" class="style30" colspan="2"><div align="center" class="style35"><? echo $Mensajes["tf-10"]; ?></div></td>
            </tr>
            <tr>
              <td bgcolor="#ECECEC" class="style30" colspan="2"><div align="left"> <?

             if ($rowc[0]>1){
               echo "<a href='../solicitudes/administrar_usuarios.php'>".$rowc[0]." ".$Mensajes["hc-17"]."</a>";
               }
             elseif ($rowc[0]==1){  
                 echo "<a href='../solicitudes/administrar_usuarios.php'>".$rowc[0]." ".$Mensajes["hc-18"]."</a>";  
             }
             else
             {
               echo $Mensajes["hc-19"];
              }
           ?>      </div></td>
            </tr>
        
		 
			
			<tr>
              <td height="20" bgcolor="#1380C3" class="style35"><div align="center"><? echo $Mensajes["ec-9"]; ?></div></td>
            </tr>
            <tr>
              <td bgcolor="#ECECEC" class="style30" colspan="2"><div align="left"><?
          $expresion = "SELECT COUNT(*) FROM Pedidos WHERE Estado=6";
          $result = mysql_query($expresion);
          $rowc = mysql_fetch_array($result);  
          if ($rowc[0]>1){
               echo "<a href='../pedidos/manpedent3.php'>".$rowc[0]." ".$Mensajes["hc-20"]."</a>";
               }
             elseif ($rowc[0]==1){  
                 echo "<a href='../pedidos/manpedent3.php'>".$rowc[0]." ".$Mensajes["hc-21"]."</a>";  
             }
             else
             {
               echo $Mensajes["hc-22"];
              }
           ?> 
</div></td>
            </tr>
            <tr>
              <td bgcolor="#ECECEC" class="style30" colspan="2"><div align="left">         <?
          $expresion = "SELECT COUNT(*) FROM Pedidos WHERE Estado=11";
		  
          $result = mysql_query($expresion);
          $rowc = mysql_fetch_array($result);  
          if ($rowc[0]>1){
               echo "<a href='../pedidos/manpedent4.php'>".$rowc[0]." ".$Mensajes["hc-31"]."</a>";
               }
             elseif ($rowc[0]==1){  
                 echo "<a href='../pedidos/manpedent4.php'>".$rowc[0]." ".$Mensajes["hc-30"]."</a>";  
             }
             else
             {
               echo $Mensajes["hc-32"];
              }
           ?> 

</div></td>
            </tr>

			<tr>
              <td height="20" bgcolor="#1380C3" class="style35" colspan="2"><div align="center"><? echo $Mensajes["ec-10"]; ?></div></td>
            </tr>
            <tr>
              <td bgcolor="#ECECEC" class="style30" colspan="2"><div align="center"><? echo
            SesionToma("Usuario"); ?></div></td>
            </tr>
            <tr>
              <td height="18" bgcolor="#CECECE" class="style28" colspan="2"><div align="center"><span class="style30"><a href="login.php"><? echo $Mensajes["ss-1"]; ?></a></span></div></td>
            </tr>
          </table>
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
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50"><div align="right" class="style33">
            <div align="center">adm-001</div>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>

</div>
<style>
  	    #mensajes {
		    position=absolute;
		    visibility='visible';
		    top=50;
		    left=50;
	    }

</style>



 <?   /* Verificacion de mensajes a los usuarios */
  /* Primero veo si tengo que actualizar algun mensaje */
  if (isset($idMensaje) &&($idMensaje > 0))
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
	     width=100;
	     background-color=yellow;
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
     style='position:absolute;width:100;background-color:#FFFF99;left:10;top:".$pos.";visibility:visible'>";

     echo "
       <table>
         <tr>
		 <td width='250' bgcolor='#1380C3'>
		  <table colspan=2 width='100%'>
		   <tr>
	          <td width='*' align='center' bgcolor='#1380C3' onclick='cambiarValor(".$cant.")'>
   	           <font size=1 color='#FFFF99'> Creado <b> ".$mensaje[1]." </b> </font>
		  </td>
  		  <td align='right' width='*' bgcolor='#1380C3'>
   	            <input type='button' style='color:1380C3;background:#FFFF99;weight:10;height:18' value='-' onclick=minimizar('texto".$cant."','mensaje".$cant."');>
	            <input type='button' style='color:1380C3;background:#FFFF99;weight:10;height:18' value='+' onclick=maximizar('texto".$cant."','mensaje".$cant."');>
   	            <input type='button' style='color:1380C3;background:#FFFF99;weight:10;height:18' value='x' onclick=cerrar('mensaje".$cant."','texto".$cant."');>
		</td>
	        </tr>
  	        </table>

	    </tr>
	   <tr id='texto".$cant."' style='visibility:visible'> 
	   <td width='250'>
	     <span onclick='cambiarValor(".$cant.")'>
           <font size=2 color='#1380C3'> ".$mensaje[2]."  </font> </span>
	   </td> </tr>
	   <tr onclick='cambiarValor(".$cant.")'> <td align='right'>
	        <form action='indexadm.php' name='form".$cant."'>
			<input type='hidden' name='idMensaje' value='".$mensaje[0]."'>
            <input type='submit' style='color:#1380C3;font-size:8pt;background:#FFFF99'
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
if (existe1==1)
  document.getElementById('mensaje1').style.top=10;
if (existe2==1)
  document.getElementById('mensaje2').style.top=30;
if (existe3==1)
  document.getElementById('mensaje3').style.top=50;

 <? if ($vec[0]=='true')  echo "mostrar('buttonMenos1' ,'buttonMas1', 'tabla1' , 0);";
    else  echo "mostrar('buttonMas1' ,'buttonMenos1', 'tabla1' , 1);";
   
	if ($vec[1]=='true')  echo "mostrar('buttonMenos2' ,'buttonMas2', 'tabla2' , 0);";
    else  echo "mostrar('buttonMas2' ,'buttonMenos2', 'tabla2' , 1);";
	
	 if ($vec[2]=='true')  echo "mostrar('buttonMenos3' ,'buttonMas3', 'tabla3' , 0);";
    else  echo "mostrar('buttonMas3' ,'buttonMenos3', 'tabla3' , 1);";
	 
	 if ($vec[3]=='true')  echo "mostrar('buttonMenos4' ,'buttonMas4', 'tabla4' , 0);";
    else  echo "mostrar('buttonMas4' ,'buttonMenos4', 'tabla4' , 1);";
	 
	 if ($vec[4]=='true')  echo "mostrar('buttonMenos5' ,'buttonMas5', 'tabla5' , 0);";
    else  echo "mostrar('buttonMas5' ,'buttonMenos5', 'tabla5' , 1);";
	 
	 if ($vec[5]=='true')  echo "mostrar('buttonMenos6' ,'buttonMas6', 'tabla6' , 0);";
    else  echo "mostrar('buttonMas6' ,'buttonMenos6', 'tabla6' , 1);";
	 
	 if ($vec[6]=='true')  echo "mostrar('buttonMenos7' ,'buttonMas7', 'tabla7' , 0);";
    else  echo "mostrar('buttonMas7' ,'buttonMenos7', 'tabla7' , 1);";
	 if ($vec[7]=='true')  echo "mostrar('buttonMenos8' ,'buttonMas8', 'tabla8' , 0);";
    else  echo "mostrar('buttonMas8' ,'buttonMenos8', 'tabla8' , 1);";
	?>

	if (document.getElementById('tabla8').style.visibility == 'visible') {
	   document.forms.busqueda.expresion.focus();
         } 

    cambiar();
  
</script>
</div>
</body>
</html>
