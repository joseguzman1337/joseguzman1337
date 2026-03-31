<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
     
require_once('../../Connections/sala2.php');
session_start(); 

mysql_select_db($database_sala, $sala);
$query_estados = "SELECT * FROM estadopazysalvoestudiante";
$estados = mysql_query($query_estados, $sala) or die(mysql_error());
$row_estados = mysql_fetch_assoc($estados);
$totalRows_estados = mysql_num_rows($estados);
?>

<style type="text/css">
<!--
.Estilo1 {font-family: tahoma}
.Estilo2 {font-size: x-small}
-->
</style>

<form method="post" action="pazysalvooperacion.php">
		
      <p>
  <input name="accion" type="hidden" id="accion" value="<?php echo $_GET['accion']; ?>">	
  <input name="estudiante" type="hidden" id="estudiante" value="<?php echo $_GET['estudiante']; ?>">
  <input name="periodo" type="hidden" id="periodo" value="<?php echo $_GET['periodo']; ?>">
  <input name="editar" type="hidden" id="editar" value="<?php echo $_GET['editar']; ?>">
<?php

       if(isset($_GET['accion']))
	   {
		$accion = $_GET['accion'];
		$codigo = $_GET['estudiante'];
		$periodo = $_GET['periodo'];
		$codigoarea = $_SESSION['codigofacultad'];
		$fecha = date("Y-m-d G:i:s",time());
        $id = $_GET['editar'];
	   }
	   		
     if ($_POST['regresar'])
        {
		  $codigo = $_POST['estudiante'];
		  echo '<script language="javascript"> window.location.href="pazysalvoformulario.php?estudiante='.$codigo.'"; </script>';	        	     
		  exit();
		}	 
	 if ($_POST['aceptar'])
	   {
	      
		  if ($_POST['accion'] == "adicionar")
	      {// if adicionar
			$accion = $_POST['accion'];
			$codigo = $_POST['estudiante'];
			$periodo = $_POST['periodo'];
			$codigoarea = $_SESSION['codigofacultad'];
			$fecha = date("Y-m-d G:i:s",time()); 
		 
		 
	                $query_pazysalvoestudiante = "SELECT * 
												FROM pazysalvoestudiante
												WHERE idestudiantegeneral='$codigo'
												and codigocarrera = '$codigoarea'";
					$res_pazysalvoestudiante = mysql_query($query_pazysalvoestudiante, $sala) or die(mysql_error());
					$pazysalvoestudiante = mysql_fetch_assoc($res_pazysalvoestudiante);
							
					 
			 if ($_POST['codigoconcepto']== 0)
		      {
		          echo '<script language="JavaScript">alert("El Tipo de deuda es requerido")</script>';
                  echo '<script language="javascript"> window.location.href="pazysalvooperacion.php?estudiante='.$codigo.'&accion='.$accion.'&periodo='.$periodo.'"; </script>';	        	     
			  }
			 else
			  if ($_POST['valor']== "")
		      {
		          echo '<script language="JavaScript">alert("La descripción es requerida")</script>';
                  echo '<script language="javascript"> window.location.href="pazysalvooperacion.php?estudiante='.$codigo.'&accion='.$accion.'&periodo='.$periodo.'"; </script>';	        	     
			  }
			 else			 
			  if ($pazysalvoestudiante == "")
			   {
					     $adicion="INSERT INTO pazysalvoestudiante(idpazysalvoestudiante,idestudiantegeneral,codigocarrera,codigoperiodo) 
    									 VALUES(0, '$codigo', '$codigoarea','$periodo')
										";
				         //echo $adicion;
						 $ins=mysql_db_query($database_sala,$adicion) or die("$adicion");
					     
						 $numeroid=mysql_insert_id();
						 
					     $adiciona="INSERT INTO detallepazysalvoestudiante(idpazysalvoestudiante,descripciondetallepazysalvoestudiante,fechainiciodetallepazysalvoestudiante,fechavencimientodetallepazysalvoestudiante,codigotipopazysalvoestudiante,codigoestadopazysalvoestudiante) 
													 VALUES('".$numeroid."','".$_POST['valor']."','".$fecha."','".$fecha."','".$_POST['codigoconcepto']."','100')";
						 ///echo $adiciona;
						 $ins_des=mysql_db_query($database_sala,$adiciona) or die("No se dejo adicionar2");
					      echo '<script language="javascript"> window.location.href="pazysalvoformulario.php?estudiante='.$codigo.'"; </script>';
					  }					
				     else
					   {
				
							$adiciona="INSERT INTO detallepazysalvoestudiante(idpazysalvoestudiante,descripciondetallepazysalvoestudiante,fechainiciodetallepazysalvoestudiante,fechavencimientodetallepazysalvoestudiante,codigotipopazysalvoestudiante,codigoestadopazysalvoestudiante) 
													 VALUES('".$pazysalvoestudiante['idpazysalvoestudiante']."','".$_POST['valor']."','".$fecha."','".$fecha."','".$_POST['codigoconcepto']."','100')";
							//8echo  $adiciona;
							$ins_des=mysql_db_query($database_sala,$adiciona) or die("No se dejo adicionar3");
							
							echo '<script language="javascript"> window.location.href="pazysalvoformulario.php?estudiante='.$codigo.'"; </script>';
			          }
	   
	   
	       }// fin adicianar
		   
	   if ($_POST['accion'] == "editar")
	     {// if editar 
		    $accion = $_POST['accion'];
			$codigo = $_POST['estudiante'];
			$periodo = $_POST['periodo'];
			$codigoarea = $_SESSION['codigofacultad'];
			$id = $_POST['editar'];
			$fecha = date("Y-m-d G:i:s",time()); 
		 
	        if ($_POST['codigoconcepto']== 0)
		      {
		          echo '<script language="JavaScript">alert("El Tipo de deuda es requerido")</script>';
                  echo '<script language="javascript"> window.location.href="pazysalvooperacion.php?estudiante='.$codigo.'&accion='.$accion.'&periodo='.$periodo.'&editar='.$id.'"; </script>';	        	     
			  }
			 else
			  if ($_POST['valor']== "")
		      {
		          echo '<script language="JavaScript">alert("La descripción es requerida")</script>';
                  echo '<script language="javascript"> window.location.href="pazysalvooperacion.php?estudiante='.$codigo.'&accion='.$accion.'&periodo='.$periodo.'&editar='.$id.'"; </script>';	        	     
			  }
			 else	
			       {
				      $base = "update detallepazysalvoestudiante set				 
                       codigotipopazysalvoestudiante = '".$_POST['codigoconcepto']."',
                       descripciondetallepazysalvoestudiante ='".$_POST['valor']."',
					   codigoestadopazysalvoestudiante = '".$_POST['estados']."'				   
					   where iddetallepazysalvoestudiante ='".$id."'";		            
					  //echo $base;
                      //exit();
					   $sol=mysql_db_query($database_sala,$base);						
                       echo '<script language="javascript"> window.location.href="pazysalvoformulario.php?estudiante='.$codigo.'"; </script>';
					  }	
	  
	  
	    }  // fin editar
	  }// FIN BOTON
	 
	 
        $query_descripcion = "SELECT * 
							    FROM tipopazysalvoestudiante";
		$res_descripcion = mysql_query($query_descripcion, $sala) or die(mysql_error());
		$descripcion = mysql_fetch_assoc($res_descripcion); 

       if($accion == "adicionar")
	     {//IF ACCION?>
</p>
      <p align="center"><span class="Estilo4 Estilo1"><b> ADICIONAR DEUDA</b></span> </p>
      <table width="707" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr>
      <td colspan="2" bgcolor="#C5D5D6">
      <div align="center" class="Estilo2 Estilo1 Estilo4"><strong>Conceptos deuda </strong></div>      </td>
    </tr>
    <tr>
      <td>
      <div align="right" class="Estilo4 Estilo1 Estilo2"><strong>Tipo de deuda: </strong></div>      </td>
      <td><span class="Estilo4 Estilo1 Estilo2"><b>
        <select name="codigoconcepto">
          <option value="0" <?php if (!(strcmp(0, $_POST['codigoconcepto']))) {echo "SELECTED";} ?>>Seleccionar</option>
<?php
	do {  
?>
          <option value="<?php echo $descripcion['codigotipopazysalvoestudiante']?>"<?php if (!(strcmp($descripcion['codigotipopazysalvoestudiante'], $_POST['codigoconcepto']))) {echo "SELECTED";} ?>><?php echo $descripcion['nombretipopazysalvoestudiante']?></option>
          <?php
				  
	} while ($descripcion = mysql_fetch_assoc($res_descripcion));
	  $rows = mysql_num_rows($res_descripcion);
	  if($rows > 0) {
		  mysql_data_seek($res_descripcion, 0);
		  $descripcion = mysql_fetch_assoc($res_descripcion);
	  }
?>
        </select>       
      </b>
	  </span></td>
    </tr>
    <tr>
      <td>
      <div align="right" class="Estilo4 Estilo1 Estilo2"><strong>Descripci&oacute;n: </strong></div></td>
      <td><span class="Estilo4 Estilo1 Estilo2"><b>
        <input name="valor" type="text" id="valor" value="<?php echo $_POST['valor']; ?>" size="50">
      </b>
         </span></td>
    </tr>
    <tr>
      <td colspan="2">
        <div align="center" class="Estilo4 Estilo1 Estilo2">
          <input name="aceptar" type="submit" id="aceptar" value="Aceptar">
          &nbsp;&nbsp;		  
          <input name="regresar" type="submit" id="regresar" value="Cancelar">
      </div>      </td>
    </tr>
  </table>

<?php		 
		 }//FIN IF ACCION
  
////////////////////////////////////////////////////////////////////////////////////////////////////////

if ($accion == "editar")
	{//  

     $query_pazysalvoestudiante = "SELECT * 
												FROM detallepazysalvoestudiante
												WHERE iddetallepazysalvoestudiante= '".$id."'";
					//echo $query_pazysalvoestudiante;
					$res_pazysalvoestudiante = mysql_query($query_pazysalvoestudiante, $sala) or die(mysql_error());
					$pazysalvoestudiante = mysql_fetch_assoc($res_pazysalvoestudiante);
 ?>  
   
   <p align="center"><span class="Estilo4 Estilo1"><b>EDITAR DEUDA</b></span> </p>
      <table width="707" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr>
      <td colspan="2" bgcolor="#C5D5D6">
      <div align="center" class="Estilo2 Estilo1 Estilo4"><strong>Conceptos deuda </strong></div>      </td>
    </tr>
    <tr>
      <td>
      <div align="right" class="Estilo4 Estilo1 Estilo2"><strong>Tipo de deuda: </strong></div>      </td>
      <td><span class="Estilo4 Estilo1 Estilo2"><b><b><b>
        <select name="codigoconcepto">
          <option value="0" <?php if (!(strcmp(0, $pazysalvoestudiante['codigotipopazysalvoestudiante']))) {echo "SELECTED";} ?>>Seleccionar</option>
          <?php
	do {  
	?>
          <option value="<?php echo $descripcion['codigotipopazysalvoestudiante']?>"<?php if (!(strcmp($descripcion['codigotipopazysalvoestudiante'], $pazysalvoestudiante['codigotipopazysalvoestudiante']))) {echo "SELECTED";} ?>><?php echo $descripcion['nombretipopazysalvoestudiante']?></option>
          <?php
				  
	} while ($descripcion = mysql_fetch_assoc($res_descripcion));
	  $rows = mysql_num_rows($res_descripcion);
	  if($rows > 0) {
		  mysql_data_seek($res_descripcion, 0);
		  $descripcion = mysql_fetch_assoc($res_descripcion);
	  }
	?>
        </select>
      </b>
      </b>
      </b>
	  </span></td>
    </tr>
    <tr>
      <td>
      <div align="right" class="Estilo4 Estilo1 Estilo2"><strong>Descripci&oacute;n: </strong></div></td>
      <td><span class="Estilo4 Estilo1 Estilo2"><b>
        <input name="valor" type="text" id="valor" value="<?php echo $pazysalvoestudiante['descripciondetallepazysalvoestudiante']; ?>" size="50">
      </b>
         </span></td>
    </tr>
    <tr>
      <td><div align="right"><span class="Estilo4 Estilo1 Estilo2"><strong>Descripci&oacute;n: </strong></span></div></td>
      <td><select name="estados" id="estados">
        <option value="0" <?php if (!(strcmp(0, $pazysalvoestudiante['codigoestadopazysalvoestudiante']))) {echo "SELECTED";} ?>>seleccionar</option>
        <?php
do {  
?>
        <option value="<?php echo $row_estados['codigoestadopazysalvoestudiante']?>"<?php if (!(strcmp($row_estados['codigoestadopazysalvoestudiante'], $pazysalvoestudiante['codigoestadopazysalvoestudiante']))) {echo "SELECTED";} ?>><?php echo $row_estados['nombreestadopazysalvoestudiante']?></option>
        <?php
} while ($row_estados = mysql_fetch_assoc($estados));
  $rows = mysql_num_rows($estados);
  if($rows > 0) {
      mysql_data_seek($estados, 0);
	  $row_estados = mysql_fetch_assoc($estados);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td colspan="2">
        <div align="center" class="Estilo4 Estilo1 Estilo2">
          <input name="aceptar" type="submit" id="aceptar" value="Aceptar">
          &nbsp;&nbsp;		  
          <input name="regresar" type="submit" id="regresar" value="Cancelar">
      </div>      </td>
    </tr>
  </table>  
 <?php   
   }// fin editar

if ($accion == "eliminar")
	{//  
	 $fecha = date("Y-m-d G:i:s",time()); 
	 $id = $_GET['eliminar'];
	 $base = "update detallepazysalvoestudiante set				 
                       codigoestadopazysalvoestudiante = '200',
					   fechavencimientodetallepazysalvoestudiante = '".$fecha."'		   
					   where iddetallepazysalvoestudiante ='".$id."'";		            
					  //echo $base;
                      //exit();
					   $sol=mysql_db_query($database_sala,$base);						
                       echo '<script language="javascript"> window.location.href="pazysalvoformulario.php?estudiante='.$codigo.'"; </script>';
	}
?>

</form>	 
<?php
mysql_free_result($estados);
?>
