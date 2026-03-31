<?php
include_once("./templates/template.php"); 	$db = getBD();

$CodigoEstudiante = '29474';
$Periodo          = '20142';

$SQL='INSERT INTO prematricula(fechaprematricula,codigoestudiante,codigoperiodo,codigoestadoprematricula,observacionprematricula,semestreprematricula)VALUES(NOW(),"'.$CodigoEstudiante.'","'.$Periodo.'",10,"prueba de creacion para reenvio",4)';

if($CrerarPrematricula=&$db->Execute($SQL)===false){
    echo 'Error en el SQL de Crear Prematricula...<br><br>'.$SQL;
    die;
}

echo 'Prematricula-->'.$Prematricula_id = $db->Insert_ID();

$Select='SELECT MAX(numeroordenpago)+1 AS num
         FROM   ordenpago';
         
         if($idOrden=&$db->Execute($Select)===false){
            echo 'Error en el SQL Selecionar Numero de Orden...<br><br>'.$Select;
            die;
         }

echo '<br><br>Orden-->'.$OrdePago  = $idOrden->fields['num'];

$SQL='INSERT INTO ordenpago(numeroordenpago,codigoestudiante,fechaordenpago,idprematricula,fechaentregaordenpago,codigoperiodo,codigoestadoordenpago,codigoimprimeordenpago,codigocopiaordenpago,idsubperiodo,idsubperiododestino)VALUES("'.$OrdePago.'","'.$CodigoEstudiante.'",NOW(),"'.$Prematricula_id.'","0000-00-00","'.$Periodo.'",10,"01",100,7358,7358)';

if($CreaOrdenPago=&$db->Execute($SQL)===false){
    echo 'Error en el SQL Crear Orden de Pargo ....<br><br>'.$SQL;
    die;
}

$SQL='INSERT INTO detalleordenpago(numeroordenpago,codigoconcepto,cantidaddetalleordenpago,valorconcepto,codigotipodetalleordenpago)VALUES("'.$OrdePago.'",151,1,6280000,1)';

if($DetalleOrdenPago=&$db->Execute($SQL)===false){
    echo 'Error en el SQL Crear Detalle Orden de Pargo ....<br><br>'.$SQL;
    die;
}

$SQL='INSERT INTO fechaordenpago(numeroordenpago,fechaordenpago,porcentajefechaordenpago,valorfechaordenpago)VALUES("'.$OrdePago.'","2014-10-13","0","6280000")';

if($FechaOrdenPago=&$db->Execute($SQL)===false){
    echo 'Error en el SQL Crear Fecha Orden de Pargo ....<br><br>'.$SQL;
    die;
}

$SQL='INSERT INTO fechaordenpago(numeroordenpago,fechaordenpago,porcentajefechaordenpago,valorfechaordenpago)VALUES("'.$OrdePago.'","2014-10-20","5","6594000")';

if($FechaOrdenPago=&$db->Execute($SQL)===false){
    echo 'Error en el SQL Crear Fecha Orden de Pargo ....<br><br>'.$SQL;
    die;
}

$SQL='INSERT INTO fechaordenpago(numeroordenpago,fechaordenpago,porcentajefechaordenpago,valorfechaordenpago)VALUES("'.$OrdePago.'","2014-10-27","15","7222000")';

if($FechaOrdenPago=&$db->Execute($SQL)===false){
    echo 'Error en el SQL Crear Fecha Orden de Pargo ....<br><br>'.$SQL;
    die;
}
/*****************************************************************************/
$SQL='INSERT INTO detalleprematricula(idprematricula,codigomateria,codigomateriaelectiva,codigoestadodetalleprematricula,codigotipodetalleprematricula,idgrupo,numeroordenpago)VALUES("'.$Prematricula_id.'","13652","0","10","10","79986","'.$OrdePago.'")';

if($DetallePrematricula=&$db->Execute($SQL)===false){
    echo 'Error en el SQL Detalle Prematricula ....<br><br>'.$SQL;
    die;
}

$SQL='INSERT INTO detalleprematricula(idprematricula,codigomateria,codigomateriaelectiva,codigoestadodetalleprematricula,codigotipodetalleprematricula,idgrupo,numeroordenpago)VALUES("'.$Prematricula_id.'","13659","0","10","10","79997","'.$OrdePago.'")';

if($DetallePrematricula=&$db->Execute($SQL)===false){
    echo 'Error en el SQL Detalle Prematricula ....<br><br>'.$SQL;
    die;
}

$SQL='INSERT INTO detalleprematricula(idprematricula,codigomateria,codigomateriaelectiva,codigoestadodetalleprematricula,codigotipodetalleprematricula,idgrupo,numeroordenpago)VALUES("'.$Prematricula_id.'","13658","0","10","10","79998","'.$OrdePago.'")';

if($DetallePrematricula=&$db->Execute($SQL)===false){
    echo 'Error en el SQL Detalle Prematricula ....<br><br>'.$SQL;
    die;
}

$SQL='INSERT INTO detalleprematricula(idprematricula,codigomateria,codigomateriaelectiva,codigoestadodetalleprematricula,codigotipodetalleprematricula,idgrupo,numeroordenpago)VALUES("'.$Prematricula_id.'","13654","0","10","10","79993","'.$OrdePago.'")';

if($DetallePrematricula=&$db->Execute($SQL)===false){
    echo 'Error en el SQL Detalle Prematricula ....<br><br>'.$SQL;
    die;
}

$SQL='INSERT INTO detalleprematricula(idprematricula,codigomateria,codigomateriaelectiva,codigoestadodetalleprematricula,codigotipodetalleprematricula,idgrupo,numeroordenpago)VALUES("'.$Prematricula_id.'","13651","0","10","10","79992","'.$OrdePago.'")';

if($DetallePrematricula=&$db->Execute($SQL)===false){
    echo 'Error en el SQL Detalle Prematricula ....<br><br>'.$SQL;
    die;
}
?>