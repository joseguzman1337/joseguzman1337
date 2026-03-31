


<script src="../js/MainSeguimiento.js"></script>
<!--<link href="../../../assets/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
<script src="../../../assets/js/fileinput.min.js" type="text/javascript"></script>
-->
<?php 
	
include '../tools/includes.php';
include '../control/controlAvancesIndicadorPlanDesarrollo.php';

 
error_reporting(E_ALL);
ini_set('display_errors', 1);
 session_start( );
 
 if($_POST){
    $keys_post = array_keys($_POST);
    foreach ($keys_post as $key_post) {
            if( is_array($_POST[$key_post]) ){
                    $$key_post = $_POST[$key_post];
            }else{
                    $$key_post = strip_tags(trim($_POST[$key_post]));
            }
    }
}
	
if($_GET){
    $keys_get = array_keys($_GET); 
    foreach ($keys_get as $key_get){
        if( is_array($_GET[$key_get]) ){ 
             $$key_get = $_GET[$key_get];
        }else{
            $$key_post = strip_tags(trim($_GET[$key_get]));
         }
     } 
}

 if( isset ( $_SESSION["datoSesion"] ) ){
	$user = $_SESSION["datoSesion"];
	$idPersona = $user[ 0 ];
	$luser = $user[ 1 ];
	$lrol = $user[3];
	$txtCodigoFacultad = $user[4];
	$persistencia = new Singleton( );
	$persistencia = $persistencia->unserializar( $user[ 5 ] );
	$persistencia->conectar( );
	}else{
		header("Location:error.php");
	}
	
	$controlAvance = new controlAvancesIndicadorPlanDesarrollo( $persistencia );
		
	switch( $tipoOperacion ){

	case "verAvances": {
		
		$archivo = $controlAvance->VerArchivosEvidencia( $idMetaSecundaria , $fecha , $actividad , $avance , $aprabado );
		$contadorRegistros = 0;
			
		?>
		
		<div class="row">
                    <div class="col-md-1"><strong>N°</strong></div>
                    <div class="col-md-8"><strong>Nombre</strong></div>
                    <div class="col-md-1"><strong>Ver</strong></div>
                    <div class="col-md-2"><strong>Eliminar</strong></div>
                    <br><br>
		</div>
		
		<?php	
		$unicoRegistro = sizeof( $archivo );
		
		foreach ($archivo as $evidencia) {
			
			 $contadorRegistros++;
			 $ArchivoNombre =  $evidencia->getEvidencia();
			 $ext = pathinfo( $ArchivoNombre ,PATHINFO_EXTENSION );//captura extencion del archivo
			 $ArchivoNombre = explode("_",$ArchivoNombre);//muestra unicamente el nombre del archivo 
			 $idAvance = $evidencia->getidAvancesIndicadorPlanDesarrollo( );
			 $aprobado = $evidencia->getaprobacion();
			 
			?>
			
			<div class ="row">
				
				<div class="col-md-1"><?php //echo $contadorRegistros; ?></div>
				<div class="col-md-8"><?php echo $ArchivoNombre[1];?></div>
				<div class="col-md-1">
				<a href="../evidencia/<?php echo $evidencia->getEvidencia();?>" download>
                                <?php 
                                        if ( $ext == 'doc' or $ext == 'docx'  ){
                                                ?>
                                                <img id="imgAnexo" src="../css/images/Word.png" width="25px" height="25px">
                                                <?php
                                        }

                                        if ( $ext == 'xls' or $ext == 'xlsx'  ){
                                                ?>
                                                <img id="imgAnexo" src="../css/images/Excel.png" width="25px" height="25px">
                                                <?php
                                        }

                                        if ( $ext == 'pdf' ){
                                                ?>
                                                        <img id="imgAnexo" src="../css/images/pdf.png" width="20px" height="20px">
                                                <?php
                                        }
                                        if ( $ext == 'txt' ){
                                                ?>	
                                                <img id="imgAnexo" src="../css/images/Note.png" width="20px" height="20px">
                                                <?php
                                        }

                                ?>
						
				</a>
				</div>
				
				<div class="col-md-2">
                                <?php 
                                    if ( $unicoRegistro == 1 ) {

                                    } else if ( $aprobado =='' ) {
                                ?>
                                        <button class="btn btn-warning" class="btnDelelete" title="Eliminar" onclick="eliminarEvidencia('<?php echo  $idAvance; ?>' , 'eliminarAvance' , '<?php echo $evidencia->getEvidencia(); ?>')"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                <?php 
                                    }
                                ?>
				</div>
						
			</div><br>
		<?php 
		}
		?>
		<form id="actualizaEvindecia" name="actualizaEvindecia">
			<?php 
			if($aprabado ==''){
			?>
		
			<div>
				<div class="col-md-4">
						<strong>Adicionar Evidencias maximo(<?php echo $permitidos= 10 - $contadorRegistros; ?>):</strong>
				</div>	
				<div class="col-md-8">
					<input type="file" name="txtFileEvidencia"  id="txtFileEvidencia" multiple="multiple"  class="form-control-file filestyle txtFileEvidencia" data-buttonName="btn-warning"  accept=".pdf,text/plain,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
				</div>	
			</div>	
			
			<br><br><br>
			
			<div class="col-md-12" style="text-align: right"> 
				
				<input type="hidden" name="fechas" id="fechas" value="<?php echo $fecha;?>">
				<input type="hidden" name="actividades" id="actividades" value="<?php echo $actividad;?>">
				<input type="hidden" name="vAvance" id="vAvance" value="<?php echo $avance?>">
				<input type="hidden" name="idMetaSecundaria" id="idMetaSecundaria" value="<?php echo $idMetaSecundaria?>">
				<input type="hidden" name="permitidos" id="permitidos" value="<?php echo $permitidos?>">
				<?php
				if($aprabado ==''){
                                    /* 93  Decanos de Facultades
                                     * 98  Director de Facultad
                                     * 99  Coordinador de Facultad
                                     * 3   Admon Facultades - Secretari@s Academic@s
                                     * 102 apoyo decano
                                     * 101 planeacion
                                     */

                                    if( $lrol == 99 or $lrol == 98  or $lrol == 93 or $lrol == 3 or $lrol == 102  ){ 
				?>
                                        <button class="btn btn-warning" id="btnGuardarCambioAvances">Actualizar</button>&nbsp&nbsp	
		    	<?php 
				    }
                                    
                                    if( $lrol == 101 and $facultadPlan == 10000 ){
                                    ?>
                                        <button class="btn btn-warning" id="btnGuardarCambioAvances">Actualizar</button>&nbsp&nbsp	
                                    <?php    
                                        
                                    }
		    		}
		    	}
		    	?>
		    	<button class="btn btn-warning" id="btnCerrarCambioAvances">Cerrar</button>
		    </div>
                </form>
	    
        <?php
  	}   
        break;
   
	case "eliminarAvance": {   
            $ruta = '../evidencia/'.$archivo;
            unlink( $ruta );
            $controlAvance->EliminarEvidenciaAvance( $idAvance );
	}
	break;
	case "verAvanceMeta":{

                $archivo=$controlAvance->VerArchivosEvidenciaMeta( $idMetaSecundaria ,  $fecha , $actividad , $avance , $aprabado );
                //echo sizeof($archivo);
		?>
		
		<div class="row">
                    <div class="col-md-1"><strong>N°</strong></div>
                    <div class="col-md-8"><strong>Nombre</strong></div>
                    <div class="col-md-1"><strong>Ver</strong></div>

                    <br><br>
		</div>
		<?php
		$contadorRegistros=0;
		foreach ($archivo as $evidencia ){
			 $contadorRegistros++;
			 $ArchivoNombre =  $evidencia->getEvidencia();
			 $ext = pathinfo( $ArchivoNombre ,PATHINFO_EXTENSION );//captura extencion del archivo
			 $ArchivoNombre = explode("_",$ArchivoNombre);//muestra unicamente el nombre del archivo 
			 $idAvance = $evidencia->getidAvancesIndicadorPlanDesarrollo( );
			 $aprobado = $evidencia->getaprobacion();
	
		?>
		<div class ="row">

                    <div class="col-md-1"><?php echo $contadorRegistros; ?></div>
                    <div class="col-md-8"><?php echo $ArchivoNombre[1];?></div>
                    <div class="col-md-1">
                    <a href="../evidencia/<?php echo $evidencia->getEvidencia();?>" download>
                    <?php 
                        if ( $ext == 'doc' or $ext == 'docx'  ){
                                ?>
                                <img id="imgAnexo" src="../css/images/Word.png" width="25px" height="25px">
                                <?php
                        }

                        if ( $ext == 'xls' or $ext == 'xlsx'  ){
                                ?>
                                <img id="imgAnexo" src="../css/images/Excel.png" width="25px" height="25px">
                                <?php
                        }

                        if ( $ext == 'pdf' ){
                                ?>
                                        <img id="imgAnexo" src="../css/images/pdf.png" width="20px" height="20px">
                                <?php
                        }
                        if ( $ext == 'txt' ){
                                ?>	
                                <img id="imgAnexo" src="../css/images/Note.png" width="20px" height="20px">
                                <?php
                        }
                    ?>
                    </a>
                    </div>
                </div>	
				
		<?php
		}
		?>
                <br><br>
                <div class="col-md-12" style="text-align: right"> 
                <input type="hidden" name="fechas" id="fechas" value="<?php echo $fecha;?>">
                <button class="btn btn-warning" id="btnCerrarCambioAvances">Cerrar</button>
                </div>
<?php
	break;
	}
    }   	
?>