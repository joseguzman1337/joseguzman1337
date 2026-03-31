<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * usado para subir archivos anexos del convenio
 */

//header( 'Content-type: text/html; charset=ISO-8859-1' );

require_once '../class/ManagerEntity.php';

if(!isset($_SESSION['MM_Username'])){
    $_SESSION['MM_Username'] = 'admintecnologia';
}

$entity = new ManagerEntity("usuario");
$entity->sql_select = "idusuario";
$entity->prefix ="";
$entity->sql_where = " usuario='".$_SESSION['MM_Username']."' ";
//$entity->debug = true;
$data = $entity->getData();
$userid = $data[0]['idusuario'];
$table = $_REQUEST['entity'];
$entity = new ManagerEntity($table);
$currentdate  = date("Y-m-d H:i:s");
$idname= "idsiq_".$table;
$_POST['fechamodificacion'] = $currentdate;
$_POST['usuariomodificacion'] = $userid;

$nombre_archivo = $_FILES['cargadato']['name'];
$extension = explode(".",$nombre_archivo);

if($extension[1]!=''){
  if(("pdf"!=$extension[1]) && ("PDF"!=$extension[1])) {
  echo "<script language='javascript'>
	      alert('El archivo debe ser un documento en formato PDF y la extensión pdf');
	      window.location.href='anexolistar.php?id=".$_REQUEST['idsiq_convenio']."'
	      </script>";
	      exit;
  }
}   

//echo '<pre>';print_r($_FILES['_FILES']);die;
//echo '<pre>';print_r($_REQUEST);die;
if($_REQUEST[$idname]){    
    if(is_array($_FILES) and is_array($_FILES['cargadato'])){       
        $_POST['rutadelarchivo'] = targetfile($_FILES,$_REQUEST[$idname]);
    }
    $entity->SetEntity($_POST);
    $entity->fieldlist[$idname]['pkey']=$_REQUEST[$idname];
    if($_REQUEST['delete']==true){
        //$entity->debug = true;
        $entity->deleteRecord();
    }else{
        //$entity->debug = true;
        $entity->updateRecord();
        
    }
}else{
    $_POST['fechacreacion'] = $currentdate;
    $_POST['usuariocreacion'] = $userid;
    $entity->SetEntity($_POST);
    //$entity->debug = true;
    //en anexo se utiliza el response process id
    $id = $entity->insertRecord();
    if(is_array($_FILES)){
        $_POST['rutadelarchivo'] = targetfile($_FILES,$id);        
        $_POST[$idname] = $id;
        $entity->SetEntity($_POST);
        $entity->fieldlist[$idname]['pkey']=$id;
        $entity->updateRecord();
       
    }    
    
}
echo "<script type=\"text/javascript\">alert('Proceso realizado satisfactoriamente'); window.location.href='anexolistar.php?id=".$_REQUEST['idsiq_convenio']."'</script>";
exit;
function targetfile($file,$id){
    //$targetFolder = '/tmp'; // Relative to the root
    //$targetFolder = substr(__FILE__,0,strrpos(__FILE__,'/'));
  //  print_r($file);
  //  echo $id;
    if (!empty($file)){
        $tempFile = $file['cargadato']['tmp_name'];
        //$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
        $targetPath = substr(__FILE__,0,strrpos(__FILE__,'/'));;
        $targetFile = rtrim($targetPath,'/') . '/Uploader/files/' . $id;
        // Validate the file type
        //$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
        $fileParts = pathinfo($file['cargadato']['name']);
        //print_r($fileParts); 
        
	$fileParts['extension']=strtolower($fileParts['extension']) ;
	
        
        move_uploaded_file($tempFile,$targetFile.".".$fileParts['extension']);
        //if (in_array($fileParts['extension'],$fileTypes)) {
        //	echo '1';
        //} else {
        //	echo 'Invalid file type.';
        //}
    }   
    if(isset($fileParts['extension']) && $fileParts['extension']!=''){
    return "Uploader/files/".$id.".".$fileParts['extension'];
    }
    else{
    return "Uploader/files/".$id.".pdf";
    }
}
?>