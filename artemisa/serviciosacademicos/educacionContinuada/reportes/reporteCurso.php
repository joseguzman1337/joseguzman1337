<?php
/**
 * Caso 522.
 * Ajuste validación de Sesión
 * Se incluye el archivo adaptador para tener acceso a las funciones basicas de
 * del nuevo sala si la aplicacion se corre en un entorno local o de pruebas.
 * @modified Dario Gualteros Castro <castroluisd@unbosque.edu.co>.
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @since 18 de Marzo 2019.
 */
require(realpath(dirname(__FILE__) . "/../../../sala/includes/adaptador.php"));
/**
 * El metodo Factory::validateSession($variables) hace una validacion de session activa en el sistema
 * dependiendo de los parametros que se le envíen, si determina que la session acabo redirige el sistema al login
 */
Factory::validateSession($variables);

include_once(realpath(dirname(__FILE__))."/../variables.php"); 
include($rutaTemplate."template.php");
$db = writeHeader("Reporte Curso de Educacion Continuada",TRUE);
    
	$utils = Utils::getInstance();
    $data = array();
    $row=$utils->reporte1($db,$_REQUEST["idgrupo"]);
    
    $sql = "SELECT c.codigocarrera, c.nombrecarrera, f.codigofacultad, f.nombrefacultad, m.codigomateria, g.idgrupo, g.fechainiciogrupo, g.fechafinalgrupo FROM grupo g 
			inner join materia m ON m.codigomateria=g.codigomateria AND g.idgrupo='".$_REQUEST["idgrupo"]."' 
                        inner join carrera c ON c.codigocarrera=m.codigocarrera AND c.codigomodalidadacademicasic=400 
			inner join facultad f ON f.codigofacultad=c.codigofacultad ";
	$dataGrupo= $db->GetRow($sql);
    
	// echo "<pre>"; print_r($consulta);
?>
<script type="text/javascript" language="javascript" src="../js/functionsReportes.js"></script>    
<style>
table,td
{
border:1px solid black;
}
table
{
border-collapse:collapse;
}
</style>
<form  action="imprimirInformeGestion.php" method="post" id="formInformeCamapania" style="z-index: -1;  width:100%">

		<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
                
                <input type="button" id="volver" value="Volver" style="margin-right:10px;" />
<input id="inputInformeGestion" style="margin-bottom:20px;" type="submit" name="Submit"  value="Exportar a excel"/>
</form>

<table id="floatTable" class="viewReport viewList">
    
</table>

		<table name="tableInformeGestion" id="tableInformeGestion" style="border: 2px;  margin-right: 10px;" class="viewReport viewList persist-area tableWithFloatingHeader">
                    <thead class="persist-header">
                        <tr class="dataColumns"><th colspan="8"><?php echo $dataGrupo["nombrefacultad"]; ?></th></tr>
                        <tr class="dataColumns"><th colspan="8"><?php echo $dataGrupo["nombrecarrera"]; ?></th></tr>
                        <tr class="dataColumns category"><th colspan="8">Cursos ofrecidos en el periodo <?php echo $dataGrupo["fechainiciogrupo"]." a ".$dataGrupo["fechafinalgrupo"]; ?></th></tr>
						<tr align="center" class="dataColumns category">
							<th>Participante</th>
							<th>Estado del pago</th>
							<th>Patrocinado por</th>
							<th>Tipo de documento</th>
							<th>Número de documento</th>
							<th>Celular</th>
							<th>Correo</th>
							<th>Pais de origen</th>
						</tr>
					</thead>
                    <tbody>
		<?php
			//variable para hacer la tabla de colores intercalados
			$color=false;
                        $nombre="";
			$nombreAnterior="";
			for($i=0; $i<count($row);$i++){
                        $nombre=$row[$i][0];
			if(strcmp($nombre,$nombreAnterior)!=0){
		?>
                            <tr align="center" <?php if($color){ $color=false;?> class="odd" <?php } else{ $color=true;}?>>
                                    <td><?php echo $row[$i][0];?></td>
                                    <td><?php echo $row[$i][1];?></td>
                                    <td><?php echo $row[$i][2];?></td>
                                    <td><?php echo $row[$i][3];?></td>
                                    <td><?php echo $row[$i][4];?></td>
                                    <td><?php echo $row[$i][5];?></td>
									<td><?php echo $row[$i][6];?></td>
                                    <td><?php echo $row[$i][7];?></td>
                            </tr>
		<?php
                $nombreAnterior=$nombre;
                        }
                }
		?>
                            </tbody>
		</table>


<script type="text/javascript">
/*
*	Funciona para imprimir el reporte a excel
*/
$(":submit").click(function(event) {
   
    event.preventDefault();
     $("#datos_a_enviar").val( $("<div>").append( $("#tableInformeGestion").eq(0).clone()).html());
     $("#formInformeCamapania").submit();
});

$("#volver").click(function(event) {
    <?php if(isset($_REQUEST["fecha_inicio"])){ ?>
        window.location.href="reporteMacro.php?fecha_inicio=<?php echo $_REQUEST["fecha_inicio"];?>&fecha_fin=<?php echo $_REQUEST["fecha_fin"]; ?>&tipo=<?php echo $_REQUEST["tipo"]; ?>&actividad=<?php echo $actividad; ?>";        
    <?php } else { ?>
        if (document.referrer) { //alternatively, window.history.length == 0
                history.back();
        } else {
                history.go(-1);
        }
   <?php } ?>
});
</script>

<table class="viewReport">
	<thead>
	
	</thead>
	<tbody>
            
	</tbody>
</table>
<?php  writeFooter(); ?>