<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?

  include_once "../inc/var.inc.php";
  include_once "../inc/"."parametros.inc.php";
  include_once "../inc/"."conexion.inc.php";
  Conexion();
  include_once "../inc/"."identif.php";
  Usuario();
  include_once "../inc/"."fgenped.php";
  include_once "../inc/"."fgentrad.php";
  
  echo Titulo_Sitio(); ?></title>


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
.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 9px; }
.style23 {
	color: #000000;
	font-size: 9px;
	font-family: verdana;
}
.style28 {color: #FFFFFF}
.style29 {
	color: #006599;
	font-family: Verdana;
	font-size: 9px;
}
.style42 {color: #FFFFFF; font-size: 9px; font-family: verdana; }
-->
</style>
<base target="_self">
</head>
 <?

   global $IdiomaSitio;
   $Mensajes = Comienzo ("rpe-001",$IdiomaSitio);
   $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
   global $Rol;
   if (!isset($Indice))
      $Indice = "";
    if (strtoupper($Indice)=="ON")
   {
   		$Indice=1;
   }
   else
   {
   		$Indice=0;
   }

    $Dia = date ("d");
    $Mes = date ("m");
    $Anio = date ("Y");
    $FechaHoy =$Anio."-".$Mes."-".$Dia;

    $Instruccion = "LOCK TABLES Instituciones WRITE, Paises READ";
       $result = mysql_query($Instruccion);
        $enviar="Id Session:".$CkSesionId."\n"."Rol del Usuario".SesionToma("Rol")."\n"."Id de la session:".SesionToma("Id_usuario")."\n"."Id Instituccion:".SesionToma("Instit_usuario")."\n";
       $Instruccion = "SELECT Instituciones.Abreviatura,Paises.Abreviatura,Instituciones.Codigo_Pedidos ";
       $Instruccion = $Instruccion."FROM Instituciones LEFT JOIN Paises ON Paises.Id=Instituciones.Codigo_Pais ";
	   $enviar.=$Alias_Id."\n"; 
	   // echo $Alias_Id;
	   if(!isset($Alias_Id)) {$Alias_Id = ''; }
       if ($Alias_Id == '')
       {
		 $Instruccion = $Instruccion."WHERE Codigo=".$Instit_usuario;
		 $enviar.="Entro por inst usuario".$Instit_usuario."\n";
       }
       else
       { 
         $Instruccion = $Instruccion."WHERE Codigo=".$Instit_Alias;
 		 $enviar.="Entro por alias".$Instit_Alias."\n";
		}

       $result = mysql_query($Instruccion);
	   echo mysql_error();
     //   echo $Instruccion; 
	   $enviar.=$Instruccion."\n";
       $row = mysql_fetch_row($result);
	   
	   
       $NumeroX = $row[2]+1;
       $Codigo_Pedido = $row[1]."-".$row[0]."-".sprintf("%07d",$NumeroX);
	   $enviar.=$Codigo_Pedido."\n";
//	   mail ( "asobrado@sedici.unlp.edu.ar","Pedido nuevo",$enviar);

       mysql_free_result($result);

       if (!isset($Alias_Id) || ($Alias_Id == ''))
       {
	      $Instruccion = "UPDATE Instituciones SET Codigo_Pedidos =".$NumeroX." WHERE Codigo=".$Instit_usuario;
	    }
	    else
	    {
   	      $Instruccion = "UPDATE Instituciones SET Codigo_Pedidos =".$NumeroX." WHERE Codigo=".$Instit_Alias;
	    }
		
       $result = mysql_query($Instruccion);

	    $Instruccion = "UNLOCK TABLES";
       $result = mysql_query($Instruccion);
       echo mysql_error();

       $Instruccion = "INSERT INTO Pedidos (Id,Codigo_Usuario,Tipo_Pedido,Tipo_Material,Titulo_Libro,Autor_Libro,Editor_Libro";
       $Instruccion = $Instruccion.",Anio_Libro,Desea_Indice,Capitulo_Libro,Numero_Patente,Codigo_Pais_Patente,Pais_Patente,Anio_Patente";
    	$Instruccion = $Instruccion.",Autor_Detalle1,Autor_Detalle2,Autor_Detalle3,Codigo_Titulo_Revista";
    	$Instruccion = $Instruccion.",Titulo_Revista,Titulo_Articulo,Volumen_Revista,Numero_Revista,Anio_Revista";
    	$Instruccion = $Instruccion.",Pagina_Desde,Pagina_Hasta,TituloCongreso,Organizador,NumeroLugar";
    	$Instruccion = $Instruccion.",Anio_Congreso,PaginaCapitulo,PonenciaActa,Codigo_Pais_Congreso";
		$Instruccion = $Instruccion.",Otro_Pais_Congreso,TituloTesis,AutorTesis,DirectorTesis,GradoAccede";
		$Instruccion = $Instruccion.",Codigo_Pais_Tesis,Otro_Pais_Tesis,Codigo_Institucion_Tesis,Otra_Institucion_Tesis";
		$Instruccion = $Instruccion.",Codigo_Dependencia_Tesis,Otra_Dependencia_Tesis,Anio_Tesis,PagCapitulo";
    	$Instruccion = $Instruccion.",Fecha_Alta_Pedido,Estado,Biblioteca_Sugerida,Observaciones,Ultimo_Pais_Solicitado,Ultima_Institucion_Solicitado,Ultima_Dependencia_Solicitado,Operador_Corriente";
    	$Instruccion = $Instruccion.",Tardanza_Atencion,Tardanza_Busqueda,Tardanza_Recepcion,Observado,Tipo_Usuario_Crea,Usuario_Creador";

    	If (strtoupper($Bandeja)=="ON")
    	{
    		// Si entra en la bandeja debe setear la fecha de inicio de la busqueda
    		$Instruccion=$Instruccion.",Fecha_Inicio_Busqueda";
    	}

    	$Instruccion = $Instruccion.") VALUES (";

    	// Si el alias está definido implica que es un pedido realizado por un operador en nombre
    	// de un usuario
		if (!isset($Titulo)){  $Titulo = ''; }
		if (!isset($AutorTitulo)){  $AutorTitulo = ''; }
		if (!isset($Editorial)){  $Editorial = ''; }
        if (!isset($Alias_Id)) {$Alias_Id = '';}
    	if ($Alias_Id == '')
    	{
    	  $Instruccion = $Instruccion."'".$Codigo_Pedido."',".$Id_usuario.",".$Tipo_Pedido.",".$Tipo_Material.",'".AddSlashes($Titulo)."','".AddSlashes($AutorTitulo)."','".AddSlashes($Editorial)."',";
    	}
    	else
    	{
    	  $Instruccion = $Instruccion."'".$Codigo_Pedido."',".$Alias_Id.",".$Tipo_Pedido.",".$Tipo_Material.",'".AddSlashes($Titulo)."','".AddSlashes($AutorTitulo)."','".AddSlashes($Editorial)."',";
    	}

    	// Si bandeja está en ON implica que el operador aparte desea incluirlo en su bandeja particular
        if (!isset($Bandeja)){  $Bandeja = ''; }
    	If (strtoupper($Bandeja)=="ON")
    	{
    		$Operador = $Id_usuario;
    		$EstInicial = Devolver_Estado_Tomado();
    	}
    	else
    	{
    		$Operador = 0;
    		$EstInicial = Devolver_Estado_Inicial();
    	}

		// Modificación introducida 24-4-2002
		// solo si es administrador normaliza el título de la coleccion
		// en cualquiera de los otros casos completa el título pero no
		// el valor de la colección

		if ($Rol!=1)
		{
			$Id_Col=0;
		}
		if (!isset($Id_Col)){  $Id_Col = 0; }
        if (!isset($AnioLibro)){  $AnioLibro = ''; }
		if (!isset($Capitulo_Libro)){  $Capitulo_Libro = ''; }
		if (!isset($NumeroPatente)){  $NumeroPatente = ''; }
		if (!isset($Pais)){  $Pais = ''; }
		if (!isset($OtroPais)){  $OtroPais = ''; }
		if (!isset($AnioPatente)){  $AnioPatente = ''; }
		if (!isset($Autor1)){  $Autor1= ''; }
		if (!isset($Autor2)){  $Autor2= ''; }
		if (!isset($Autor3)){  $Autor3= ''; }
		if (!isset($Titulo_Revista)){  $Titulo_Revista= ''; }
		if (!isset($NombreArticulo)){  $NombreArticulo= ''; }
		if (!isset($Volumen)){  $Volumen= ''; }
		if (!isset($Numero)){  $Numero= ''; }
		if (!isset($AnioRevista)){  $AnioRevista= ''; }
		if (!isset($PagDesde)){  $PagDesde= ''; }
		if (!isset($PagHasta)){  $PagHasta= ''; }
		if (!isset($TituloCongreso)){  $TituloCongreso= ''; }
		if (!isset($Organizador)){  $Organizador =''; }
		if (!isset($NumeroLugar)){  $NumeroLugar= ''; }
		if (!isset($AnioCongreso)){  $AnioCongreso= ''; }
		if (!isset($PaginaCapitulo)){  $PaginaCapitulo= ''; }
		if (!isset($PonenciaActa)){  $PonenciaActa= ''; }
		if (!isset($PaisCongreso)){  $PaisCongreso= ''; }
		if (!isset($OtroPaisCongreso)){  $OtroPaisCongreso= ''; }
		if (!isset($TituloTesis)){  $TituloTesis= ''; }
		if (!isset($AutorTesis)){  $AutorTesis= ''; }
		if (!isset($DirectorTesis)){  $DirectorTesis= ''; }
		if (!isset($GradoAccede)){  $GradoAccede= ''; }
		if (!isset($PaisTesis)){  $PaisTesis= ''; }
		if (!isset($OtroPaisTesis)){  $OtroPaisTesis= ''; }
		if (!isset($InstitucionTesis)){  $InstitucionTesis= ''; }
		if (!isset($OtraInstitucionTesis)){  $OtraInstitucionTesis= ''; }
		if (!isset($DependenciaTesis)){  $DependenciaTesis= ''; }
		if (!isset($OtraDependenciaTesis)){  $OtraDependenciaTesis= ''; }
		if (!isset($AnioTesis)){  $AnioTesis= ''; }
		if (!isset($PagCapitulo)){  $PagCapitulo= ''; }
		if (!isset($FechaHoy)){  $FechaHoy= ''; }
		if (!isset($EstInicial)){  $EstInicial= ''; }
		if (!isset($Biblioteca)){  $Biblioteca= ''; }
		if (!isset($Observaciones)){  $Observaciones= ''; }




    	$Instruccion = $Instruccion."'".$AnioLibro."',".$Indice.",'".AddSlashes($Capitulo_Libro)."','".AddSlashes($NumeroPatente)."',".$Pais.",'".AddSlashes($OtroPais)."','".AddSlashes($AnioPatente)."',";
    	$Instruccion = $Instruccion."'".AddSlashes($Autor1)."','".AddSlashes($Autor2)."','".AddSlashes($Autor3)."','".$Id_Col."',";
    	$Instruccion = $Instruccion."'".AddSlashes($Titulo_Revista)."','".AddSlashes($NombreArticulo)."','".AddSlashes($Volumen)."','".AddSlashes($Numero)."','".AddSlashes($AnioRevista)."',";
    	$Instruccion = $Instruccion."'".$PagDesde."','".$PagHasta."','".AddSlashes($TituloCongreso)."','".AddSlashes($Organizador)."','".AddSlashes($NumeroLugar)."'";
    	$Instruccion = $Instruccion.",'".$AnioCongreso."','".AddSlashes($PaginaCapitulo)."','".AddSlashes($PonenciaActa)."',".$PaisCongreso.",'".AddSlashes($OtroPaisCongreso)."'";
        $Instruccion = $Instruccion.",'".AddSlashes($TituloTesis)."','".AddSlashes($AutorTesis)."','".AddSlashes($DirectorTesis)."','".AddSlashes($GradoAccede)."','".AddSlashes($PaisTesis)."'";
		$Instruccion = $Instruccion.",'".AddSlashes($OtroPaisTesis)."','".$InstitucionTesis."','".AddSlashes($OtraInstitucionTesis)."','".AddSlashes($DependenciaTesis)."','".AddSlashes($OtraDependenciaTesis)."'";
		$Instruccion = $Instruccion.",'".$AnioTesis."','".AddSlashes($PagCapitulo)."',";
    	$Instruccion = $Instruccion."'".$FechaHoy."',".$EstInicial.",'".AddSlashes($Biblioteca)."','".AddSlashes($Observaciones)."'";


		$Instruccion=$Instruccion.",0,0,0,".$Operador.",0,0,0,0,".$Rol.",".$Id_usuario;
        If (strtoupper($Bandeja)=="ON")
    	{
    		$Instruccion=$Instruccion.",'".$FechaHoy."'";
    	}
    	$Instruccion=$Instruccion.")";
     	$result = mysql_query($Instruccion);
        //echo $Autor1;
    	echo mysql_error();
	    if (mysql_affected_rows()>0)
    		{

    		   if (strtoupper($Bandeja)=="ON")
    		   {
   				   $Instruccion = "INSERT INTO Eventos (Id_Pedido,Codigo_Evento,Codigo_Pais,Codigo_Institucion,Codigo_Dependencia,Fecha,Observaciones";
		     		$Instruccion = $Instruccion.",Operador,Es_Privado,Numero_Paginas) VALUES ('".$Codigo_Pedido."',".Devuelve_Evento_Tomado().",0,0,0,'".$FechaHoy."','',".$Id_usuario.",0,0)";
     				$result = mysql_query($Instruccion);
     				echo mysql_error();

    		   }

        //$Id_usuario;
        //$Codigo_Pedido;
        /*$Direccion = Devolver_email_origen_unnoba();
        $Asunto = 'Hay un nuevo pedido en PrEBi | UNNOBA';
        $Texto = 'El usaurio '.$Usuario.' ha ingresado un nuevo pedido con codigo '.$Codigo_Pedido.'\n';
        $Texto .= '<a href="http://unnoba.prebi.unlp.edu.ar">Ir al sitio web de PrEBi | UNNOBA</a>';
        $Destino = Devolver_email_destino_unnoba();

       mail ($Direccion,$Asunto,$Texto,"From:".$Destino); //Destino_Mail()
*/

?>
<body topmargin="0">
<div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <div align="center">
        <center>
      <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#EFEFEF">
        <td align="center" valign="middle" bgcolor="#E4E4E4">            <div align="center">
              <center>
                <table width="97%" height="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr align="center">
                    <td colspan="3" align="center" valign="middle" class="style42"> <div align="center" class="style23">
                      <p>&nbsp;</p>
                      <p><? echo $Mensajes["tc-001"]; ?>.<br>
                         <? echo $Mensajes["tc-002"]; ?> <span class="style29"><? echo $Codigo_Pedido; ?></span></p>

       <form method="POST" action="agrega_ped_alias.php">
	   
<?
  /*    switch ($Tipo_Material)
	  {
	    case 1:
	      echo "agrega_col.php";
	      break;
	    case 2:
         echo "agrega_cap.php";
         break;
	    case 3:
	      echo "agrega_pat.php";
	      break;
	    case 4:
	      echo "agrega_tes.php";
	      break;
  		 case 5:
         echo "agrega_cong.php";

	  }

*/

    ?>

    	<input type="hidden" name="Instit_Usuario" value="<? echo $Instit_Usuario; ?>">
    	<input type="hidden" name="Instit_Alias" value="<? echo $Instit_Alias; ?>">
    	<input type="hidden" name="Alias_Id" value="<? echo $Alias_Id; ?>">
    	<input type="hidden" name="Id_usuario" value="<? echo $Id_usuario; ?>">
    	<input type="hidden" name="Bandeja" value="<? echo $Bandeja; ?>">

    	<input type="hidden" name="Comunidad" value="<? echo $Usuario; ?>">
		<input type="hidden" name="CantAutor" value="<? echo $CantAutor; ?>">
       <input type="hidden" name="Alias_Comunidad" value="<? echo $Alias_Comunidad; ?>">


    	<!--<input type="hidden" name="Titulo" value="<? echo $Titulo; ?>">
     	<input type="hidden" name="AutorTitulo" value="<? echo $AutorTitulo; ?>">
    	<input type="hidden" name="Editorial" value="<? echo $Editorial; ?>">

    	<input type="hidden" name="AnioLibro" value="<? echo $AnioLibro; ?>">
    	<input type="hidden" name="Indice" value="<? echo $Indice; ?>">
       <input type="hidden" name="Capitulo_Libro" value="<? echo $Capitulo_Libro; ?>">
		<input type="hidden" name="NumeroPatente" value="<? echo $NumeroPatente; ?>">
		<input type="hidden" name="Pais" value="<? echo $Pais; ?>">
		<input type="hidden" name="OtroPais" value="<? echo $OtroPais; ?>">
		<input type="hidden" name="AnioPatente" value="<? echo $AnioPatente; ?>">
		<input type="hidden" name="Autor1" value="<? echo $Autor1; ?>">
		<input type="hidden" name="Autor2" value="<? echo $Autor2; ?>">
		<input type="hidden" name="Autor3" value="<? echo $Autor3; ?>">
		<input type="hidden" name="Id_Col" value="<? echo $Id_Col; ?>">
		<input type="hidden" name="Titulo_Revista" value="<? echo $Titulo_Revista; ?>">
		<input type="hidden" name="NombreArticulo" value="<? echo $NombreArticulo; ?>">
		<input type="hidden" name="Numero" value="<? echo $Numero; ?>">
		<input type="hidden" name="Volumen" value="<? echo $Volumen; ?>">
		<input type="hidden" name="AnioRevista" value="<? echo $AnioRevista; ?>">
		<input type="hidden" name="PagDesde" value="<? echo $PagDesde; ?>">
		<input type="hidden" name="PagHasta" value="<? echo $PagHasta; ?>">
		<input type="hidden" name="TituloCongreso" value="<? echo $TituloCongreso; ?>">
		<input type="hidden" name="NumeroLugar" value="<? echo $NumeroLugar; ?>">
		<input type="hidden" name="Organizador" value="<? echo $Organizador; ?>">
		<input type="hidden" name="AnioCongreso" value="<? echo $AnioCongreso; ?>">
		<input type="hidden" name="PaginaCapitulo" value="<? echo $PaginaCapitulo; ?>">
		<input type="hidden" name="PonenciaActa" value="<? echo $PonenciaActa; ?>">
		<input type="hidden" name="PaisCongreso" value="<? echo $PaisCongreso; ?>">
		<input type="hidden" name="OtroPaisCongreso" value="<? echo $OtroPaisCongreso; ?>">
		<input type="hidden" name="TituloTesis" value="<? echo $TituloTesis; ?>">
		<input type="hidden" name="AutorTesis" value="<? echo $AutorTesis; ?>">
		<input type="hidden" name="GradoAccede" value="<? echo $GradoAccede; ?>">
		<input type="hidden" name="PaisTesis" value="<? echo $PaisTesis; ?>">
		<input type="hidden" name="OtroPaisTesis" value="<? echo $OtroPaisTesis; ?>">
		<input type="hidden" name="OtraInstitucionTesis" value="<? echo $OtraInstitucionTesis; ?>">
		<input type="hidden" name="InstitucionTesis" value="<? echo $InstitucionTesis; ?>">
		<input type="hidden" name="DependenciaTesis" value="<? echo $DependenciaTesis; ?>">
		<input type="hidden" name="OtraDependenciaTesis" value="<? echo $OtraDependenciaTesis; ?>">
		<input type="hidden" name="AnioTesis" value="<? echo $AnioTesis; ?>">
		<input type="hidden" name="PagCapitulo" value="<? echo $PagCapitulo; ?>">
		<input type="hidden" name="Biblioteca" value="<? echo $Biblioteca; ?>">
  		<input type="hidden" name="Observaciones" value="<? echo $Observaciones; ?>">
		<input type="hidden" name="Operador" value="<? echo $Operador; ?>">
		-->
        <input name="Submit" type="submit" class="style23" value="Agregar Otro Pedido">
		<? // if ($Tipo_Material != 4)
             // echo '<input name="Submit" type="submit" class="style23" value="Repetir datos">';
           ?>
              

        </form>
                      <p>&nbsp;</p>
                    </div>                      </td>
                    </tr>
                </table>
              </center>
            </div>            </td>
          <?  if ($Rol!=1)
		   {
		   		?>
		<td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
        <? dibujar_menu_usuarios($Usuario,1); ?>
          </div></td>
		  <?
		   }
		  else
		  {
		  ?>
            <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
                <p><img src="../images/image001.jpg" width="150" height="118"><br>
                    <a href="../admin/indexadm.php"><? echo $Mensajes["tc-003"]; ?></a></span></p>
                  </div>                  </td>
          </div></td>
		  <?
		  }	  
		  ?>
       
        
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
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../PrEBi%20:%20UNLP"></a></div></td>
          <td width="50"><div align="center" class="style11">rpe-001</div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
</body>
 <?
   } else //no se puede cargar el pedido, ha ocurrido algun error
   {

 ?>
   <body topmargin="0">
<div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <div align="center">
        <center>
      <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#EFEFEF">
        <td align="center" valign="middle" bgcolor="#E4E4E4">            <div align="center">
              <center>
                <table width="97%" height="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr align="center">
                    <td colspan="3" align="center" valign="middle" class="style42"> <div align="center" class="style23">
                      <p>&nbsp;</p>
                      <p><? echo $Mensajes["tc-004"]; ?>.<br>
                          <? echo $Mensajes["tc-005"]; ?></span>
                          <br><a href="javascript:window.history.back()";><? echo $Mensajes["tc-006"]; ?> </a> </p>

                      <p>&nbsp;</p>
                    </div>                      </td>
                    </tr>
                </table>
              </center>
            </div>            </td>
             <?  if ($Rol!=1)
		   {
		   		?>
		<td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
        <? dibujar_menu_usuarios($Usuario,1); ?>
          </div></td>
		  <?
		   }
		  else
		  {
		  ?>
            <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
                <p><img src="../images/image001.jpg" width="150" height="118"><br>
                    <a href="../admin/indexadm.php"><? echo $Mensajes["tc-003"]; ?></a></span></p>
                  </div>                  </td>
          </div></td>
		  <?
		  }	  
		  ?>
       
        
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
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../PrEBi%20:%20UNLP"></a></div></td>
          <td width="50"><div align="center" class="style11">spc</div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
</body>
 <?

    }

    ?>
 
</html>
