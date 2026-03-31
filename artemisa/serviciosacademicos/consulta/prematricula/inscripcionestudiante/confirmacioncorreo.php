<style type="text/css">
<!--
.Estilo1 {color: #FFFFFF}
.Estilo2 {font-family: tahoma}
.Estilo3 {font-size: x-small}
.Estilo4 {font-size: xx-small}
.Estilo5 {
	color: #000000;
	font-size: x-small;
	font-weight: bold;
}
.Estilo6 {
	font-size: small;
	font-weight: bold;
}
.Estilo8 {font-size: x-small; color: #000000; }
-->
</style>
<title> Confirmaciòn de Correo</title>
<form action="confirmacioncorreo.php" method="post">
 <table width="400" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
      <td  bgcolor="#607766"  class="Estilo1 Estilo4 Estilo1"><div align="center" class="Estilo1 Estilo18 Estilo2"><span class="Estilo6">UNIVERSIDAD EL BOSQUE</span></div></td>
  </tr> 
   <tr>
       <td  bgcolor="#C5D5D6" class="Estilo1 Estilo4 Estilo1"><div align="center" class="Estilo2"> <span class="Estilo8 Estilo3">Para el proceso de Inscripción se ha generado un usuario y clave.</span>
          <br><br>
		  <span class="Estilo5">Usuario:  <?php echo $_GET['user'];?><br> 
          Clave: <?php echo $_GET['contrasena'] ;?></span><br>
       <p><span class="Estilo3"><font color="#000000"><strong>ESTA SEGURO DE EL E-MAIL DIGITADO? </strong></font></span></p>
       <p class="Estilo3"><font color="#000000"><?php echo $_GET['correodigitado']; ?></font></p>  </div>
	   <div align="center"><p> 
			<input type="submit" name="Confirmar" value="Confirmar">&nbsp;&nbsp;&nbsp; 
            <input name="Cancelar" type="submit"  value="Cancelar"> &nbsp;&nbsp;&nbsp; 
            <input name="Imprimir" type="button"  value="Imprimir" onClick="print()">     
            </p>
        </div></td>
   </tr>
 </table>  

<?php      
		   if ($_POST['Confirmar'] == true)
		    {
		    // $direccioncompleta = "formulariopreinscripcion.php";
			 $correooculto1 = "confirmar";
			 echo "<script language='javascript'>
		     window.opener.correos('".$correooculto1."');
		     window.opener.focus();
		     window.close();
		     </script>";
			}
		   else
		    if ($_POST['Cancelar'] == true)
		    {
			  echo "<script language='javascript'>		     
		      window.close();
		      </script>";
			}
?>

</form>