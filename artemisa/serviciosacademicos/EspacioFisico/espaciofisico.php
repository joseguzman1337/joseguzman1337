<?PHP 
switch($_REQUEST['data']){
    case '1':{
        $Url = 'subir_Espacios.php';
    }break;
    default:{
        $Url = 'subir_archivo.php';
    }break;
}
?>

<form method="post" action="<?PHP echo $Url?>" enctype="multipart/form-data" id="testform">
 Archivo
 <input name="archivo" type="file" id="archivo">
 <input name="boton" type="submit" id="boton" value="Subir">
</form>