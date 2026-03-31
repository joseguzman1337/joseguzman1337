<?php 
include("./templates/template.php");
		
		$db = getBD();
        
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		 $userid=$Usario_id->fields['id'];
         
         //echo '<pre>';print_r($db);die;

//COMO EL INPUT FILE FUE LLAMADO archivo ENTONCES ACCESAMOS A TRAVÉS DE $_FILES["archivo"]
?>
<table align="center">
 <tr>
  <td>
   <b>Nombre:</b>: <?php echo $_FILES["archivo"]["name"]?>
       
   <b>Tipo:</b>: <?php echo $_FILES["archivo"]["type"]?>
       
   <b>Subida:</b>: <?php echo ($_FILES["archivo"]["error"]) ? "Incorrecta" : "Correcta"?>
       
   <b>Tamaño:</b>: <?php echo $_FILES["archivo"]["size"]?> bytes
  </td>
 </tr>
</table>


<?php
//SI EL ARCHIVO SE ENVIÓ Y ADEMÁS SE SUBIO CORRECTAMENTE
if (isset($_FILES["archivo"]) && is_uploaded_file($_FILES['archivo']['tmp_name'])) {
 
 //SE ABRE EL ARCHIVO EN MODO LECTURA
 $fp = fopen($_FILES['archivo']['tmp_name'], "r");
 //SE RECORRE
 while (!feof($fp)){ //LEE EL ARCHIVO A DATA, LO VECTORIZA A DATA
  
  //SI SE QUIERE LEER SEPARADO POR TABULADORES
  //$data  = explode(" ", fgets($fp));
  //SI SE LEE SEPARADO POR COMAS
  $data  = explode(";", fgets($fp));
  
  //AHORA DATA ES UN VECTOR Y EN CADA POSICIÓN CONTIENE UN VALOR QUE ESTA SEPARADO POR COMA.
  //EJEMPLO    A, B, C, D
  //$data[0] CONTIENE EL VALOR "A", $data[1] -> B, $data[2] -> C.


  //SI QUEREMOS VER TODO EL CONTENIDO EN BRUTO:
  echo '<pre>';print_r($data);


  //SI QUEREMOS IMPRIMIR UN SOLO DATO 
  /*
    Array
    (
        [0] => bloque E
        [1] => Edificio Facultades
        [2] => usaquen
        [3] => 0
        [4] => 0
        [5] => 0
        [6] => 0
        [7] => 1
    
    )
    
    Array
    (
        [0] => Bloque M
        [1] => edificio Fundadores
        [2] => usquen
        [3] => 30
        [4] => M306
        [5] => 1
        [6] => mesas y sillas o sillas univeristarias….etc
        [7] => 2
    
    )
  */
  
   if($data[7]==1){
        $Descripcion        = '';
        $Nombre             = $data[0];
        $Padre_id           = $data[2];
        $Max                = 0;
        $acceso             = 0;
        $CodigoTipoSalon    = 32; 
        $Espacio            = 4;
        
        
   }else{
        $Descripcion       = '';
        $Padre             = $data[0];
        $Sede              = $data[2];
        $Max               = $data[3];
        $Nombre            = $data[4];
        $acceso            = $data[5];
        $CodigoTipoSalon   = $data[6];
        $Espacio           = 5;
        
        $SQL='SELECT ClasificacionEspaciosId FROM ClasificacionEspacios  WHERE  Nombre like"%'.$Padre.'%" AND codigoestado=100';
        
        if($ClasePadreId=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de la Clasificacion Padre ID ...<br><br>'.$SQL;
            die;
        }
        
        $Padre_id = $ClasePadreId->fields['ClasificacionEspaciosId'];
        
   } 
   
   $Fcha_fin = '9999-12-31';
   
   echo 'Insert_1...<br><br>'.$SQL_insert='INSERT INTO ClasificacionEspacios(Nombre,descripcion,CapacidadEstudiantes,AccesoDiscapacitados,EspaciosFisicosId,codigotiposalon,UsuarioCreacion,FechaCreacion,UsuarioUltimaModificacion,FechaUltimaModificacion,ClasificacionEspacionPadreId)VALUES("'.$Nombre.'","'.$Descripcion.'","'.$Max.'","'.$acceso.'","'.$Espacio.'","'.$CodigoTipoSalon.'","'.$userid.'",NOW(),"'.$userid.'",NOW(),"'.$Padre_id.'")';
   
   if($Insert_1=&$db->Execute($SQL_insert)===false){
        echo 'Error en el SQL del Insert...<br><br>'.$SQL_insert;
        die;
   }
   
   $last_id=$db->Insert_ID();
   
    echo 'Insert_2...<br><br>'.$Detalle_Insert='INSERT INTO DetalleClasificacionEspacios(FechaInicioVigencia,FechaFinVigencia,EstadoAprobacion,ClasificacionEspaciosId)VALUES(NOW(),"'.$Fcha_fin.'",0,"'.$last_id.'")';
   
   if($Insert_2=&$db->Execute($Detalle_Insert)===false){
        echo 'Error en el SQL del Detalle Insert...<br><br>'.$Detalle_Insert;
        die;
   }
   
    }//while 
 echo "<br><br>Archivo recorrido";

} else 
 echo "Error de subida";
?> 
