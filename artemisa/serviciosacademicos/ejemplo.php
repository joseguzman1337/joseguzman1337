<html>
	<head>
		<title>:: Ejercicio ::</title>
	</head>
	<body>
		<form name="formulario" action="" method="post">
<?php
			#Conectamos con PostgreSQL
			$host="172.16.1.12";
			$db="ejercicio";
			$usuario="postgres";
			$clave="postgres";
			$conexion = pg_connect("host=$host dbname=$db user=$usuario password=$clave") or die ("Fallo en el establecimiento de la conexión");

			$band=false;
	
			if($_POST['accion']=='Guardar') {
				$query="select id from alumnos where codigo=".$_POST['codigo'];
				$row= pg_query($conexion,$query) or die ("<br>Error en la consulta SQL.<br>");
				if(pg_num_rows($row)==0)
					$query="insert into alumnos (codigo,nombre,semestre) values (".$_POST['codigo'].",'".$_POST['nombre']."',".$_POST['semestre'].")";
				else
					$query="update alumnos set nombre='".$_POST['nombre']."',semestre=".$_POST['semestre']." where codigo=".$_POST['codigo'];
				pg_query ($conexion, $query) or die("<br>Error en la consulta SQL.<br>");
				$codigo=$_POST['codigo'];
				$nombre=$_POST['nombre'];
				$semestre=$_POST['semestre'];
			}
			if($_POST['accion']=='Listar' || $_GET['accion']=='Listar') {
				$query="select min(id) as id_minimo,max(id) as id_maximo from alumnos";
				$row= pg_query($conexion,$query) or die ("<br>Error en la consulta SQL.<br>");
				$reg= pg_fetch_array($row);
				$id_minimo=$reg['id_minimo'];
				$id_maximo=$reg['id_maximo'];
				
				$condicion=($_GET['id_consulta'])?$_GET['id_consulta']:1;
				$query="select * from alumnos where id=".$condicion;
				$row= pg_query($conexion,$query) or die ("<br>Error en la consulta SQL.<br>");
				$reg= pg_fetch_array($row);

				$codigo=$reg['codigo'];
				$nombre=$reg['nombre'];
				$semestre=$reg['semestre'];

				if($reg['id']==$id_minimo)
					$id_anterior=$reg['id'];
				else
					$id_anterior=$reg['id']-1;
				
				if($reg['id']==$id_maximo)
					$id_siguiente=$reg['id'];
				else
					$id_siguiente=$reg['id']+1;
		
				$band=true;
			}
?>
			<center><h3>INFORMACION DE ESTUDIANTES</h3></center>
			<table align="center">
				<tr>
					<th>C&oacute;digo: </th>
					<td><input type="text" name="codigo" size="6" value="<?php echo $codigo?>"></td>
					<th>Nombre: </th>
					<td><input type="text" name="nombre" size="20" value="<?php echo $nombre?>"></td>
					<th>Semestre: </th>
					<td><input type="text" name="semestre" size="2" value="<?php echo $semestre?>"></td>
					<td>
<?php						if($band) { ?>
							<input type="button" name="accion" value="Cancelar" OnClick="location.href='ejemplo.php'">
<?php						} else { ?>
							<input type="submit" name="accion" value="Guardar">
<?php						} ?>
						<input type="submit" name="accion" value="Listar">
					</td>
				</tr>
<?php				if($band) { ?>
					<tr>
						<th colspan="6">
							<input type="button" name="control" value="Primero" OnClick="location.href='ejemplo.php?accion=Listar&id_consulta=<?php echo $id_minimo?>'">
							<input type="button" name="control" value="Anterior" OnClick="location.href='ejemplo.php?accion=Listar&id_consulta=<?php echo $id_anterior?>'">
							<input type="button" name="control" value="Siguiente" OnClick="location.href='ejemplo.php?accion=Listar&id_consulta=<?php echo $id_siguiente?>'">
							<input type="button" name="control" value="Ultimo" OnClick="location.href='ejemplo.php?accion=Listar&id_consulta=<?php echo $id_maximo?>'">
						</th>
						<td>&nbsp;</td>
					</tr>
<?php				} ?>
			</table>
<?php
			#Cerramos la conexión con la base de datos
			pg_close($conexion);
?>
		</form>
	</body>
</html>
