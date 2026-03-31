<?php
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
//error_reporting(0);
require_once('../Connections/salasiq.php');
$rutaado = "../funciones/adodb/";
require_once('../Connections/salaado.php');

//echo 'ok'.$_REQUEST['id'];

if($_REQUEST['id']){    
    require_once '../class/ManagerEntity.php';
        $entity2 = new ManagerEntity("docente");
        $entity2->prefix = "";
        $entity2->sql_where = "iddocente = ".str_replace('row_','',$_REQUEST['id'])."";
        //$entity2->debug = true;
        $data2 = $entity2->getData();
        $data2 = $data2[0];
       // print_r($data2);
}

?>
<xml version="1.0" encoding='iso-8859-1'>
<docentes>
      <iddocente><?php echo $data2['iddocente']; ?> </iddocente>
      <codigodocente><?php echo $data2['codigodocente']; ?> </codigodocente>
      <apellidodocente><?php echo $data2['apellidodocente'];?> </apellidodocente>
      <nombredocente><?php echo $data2['nombredocente'];?> </nombredocente>
      <tipodocumento><?php echo $data2['tipodocumento'];?> </tipodocumento>
      <numerodocumento><?php echo $data2['numerodocumento'];?> </numerodocumento>
      <emaildocente><?php echo $data2['emaildocente'];?> </emaildocente>
      <codigogenero><?php echo $data2['codigogenero'];?> </codigogenero>
      <fechanacimientodocente><?php echo $data2['fechanacimientodocente'];?> </fechanacimientodocente>
      <idpaisnacimiento><?php echo $data2['idpaisnacimiento'];?> </idpaisnacimiento>
      <iddepartamentonacimiento><?php echo $data2['iddepartamentonacimiento'];?> </iddepartamentonacimiento>
      <idciudadnacimiento><?php echo $data2['idciudadnacimiento'];?> </idciudadnacimiento>
      <idestadocivil><?php echo $data2['idestadocivil'];?> </idestadocivil>
      <direcciondocente><?php echo $data2['direcciondocente'];?> </direcciondocente>
      <idciudadresidencia><?php echo $data2['idciudadresidencia'];?> </idciudadresidencia>
      <telefonoresidenciadocente><?php echo $data2['telefonoresidenciadocente'];?> </telefonoresidenciadocente>
      <profesion><?php echo $data2['profesion'];?> </profesion>
</docentes>
</xml>
