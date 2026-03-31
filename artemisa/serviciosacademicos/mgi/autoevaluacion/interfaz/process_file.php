<?php
/////////////////busca la ruta del managerentity
$ruta = "../";
while (!is_file($ruta.'ManagerEntity.php'))
{
    $ruta = $ruta."../";
}
require_once($ruta.'ManagerEntity.php');
   

/*if(!isset($_SESSION['MM_Username'])){
    $_SESSION['MM_Username'] = 'admintecnologia';
}*/


///////////trae el id del usuario //////////*
$entity = new ManagerEntity("usuario");
$entity->sql_select = "idusuario";
$entity->prefix ="";
$entity->sql_where = " usuario='".$_SESSION['MM_Username']."' ";
//$entity->debug = true;
$data = $entity->getData();
$userid = $data[0]['idusuario'];


$table = $_REQUEST['entity'];
$action = $_REQUEST['action'];
$idsiq_Apublicoobjetivo = $_REQUEST['idsiq_Apublicoobjetivo'];
$currentdate  = date("Y-m-d H:i:s");

$_POST['fechamodificacion'] = $currentdate;
$_POST['usuariomodificacion'] = $userid;
$_POST['fechacreacion'] = $currentdate;
$_POST['usuariocreacion'] = $userid;
$idname= "idsiq_".$table;
$id_nam=$idsiq_Apublicoobjetivo;

$entity = new ManagerEntity($table,"autoevaluacion");

if(sizeof($_FILES)==0){
     echo "No se puede subir el archivo";
     exit();
  }

  //////////trae los datos del archivo
 $tempFile = $_FILES['files']['tmp_name'];
 $nombre = $_FILES['files']['name'];
 $tipo = $_FILES['files']['type'];
 $tamano = $_FILES['files']['size'];
 $handle = fopen($tempFile,"r"); 
 
 $i=0;
 /////////lee las lineas del archivo
   while ($data = fgetcsv ($handle, 1000, ";")){ 
            if ($i>0){
                
                $_POST['cedula']=$data[0];//cedula
                $_POST['nombre']=$data[1];//nombre
                $_POST['apellido']=$data[2];//apellido
                $_POST['correo']=$data[3];//correo
                $_POST['estudiante']=$data[5];//estudiante
                $_POST['docente']=$data[6];//docente
                $_POST['padre']=$data[7];//padre
                $_POST['vecinos']=$data[8];//vecinos
                $_POST['practica']=$data[9];//prectica
                $_POST['docencia_servicio']=$data[10];//docencia servicio
                $_POST['administrativos']=$data[11];//admin
                $_POST['otros']=$data[12];//otros
                $_POST['texto']=$data[13];//Texto
                $entity->SetEntity($_POST);
                //$entity->debug = true;
                $id=$entity->insertRecord();//inserta los datos
            }
            $i++;
    } 
    
    ///Envia el mensaje
    if (!empty($id)){
        $result='Se registro exitosamente';
    }else{
        $result='No se cargo la informacion';
    }
    ?>
    <script>
        alert("<?php echo $result ?>");
        window.close()
        
    </script>
    <?
?>