<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php');
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
//require_once("../../datos/templates/template.php");
//$idOportunidad = $_REQUEST["id"];
$db = getBD();
error_reporting(E_ALL);
ini_set('display_errors', '1');
function ver($id,$db){

    $sqlOportunidad = "SELECT
                                so.*,
                                top.nombre AS tipo 
                        FROM
                                siq_oportunidades so
                                INNER JOIN siq_tipooportunidades top ON ( so.idsiq_tipooportunidad = top.idsiq_tipooportunidad ) 
                        WHERE
                                so.idsiq_oportunidad =".$id." 
                                AND so.codigoestado = 100";
        return $resultSqlOportunidad=$db->GetRow( $sqlOportunidad );
}

function verEvidencia( $id , $db ){
    $sqlEvidencia="SELECT
                            idsiq_evidenciaoportunidad,
                            nombre,
                            descripcion,
                            valoracion,
                            fechacreacion,
                            fechamodificacion,
                            Ubicacion_url
                    FROM
                            siq_evidenciaoportunidades 
                    WHERE
                            idsiq_oportunidad = ".$id." 
                            AND codigoestado = 100";
    return $resultSqlEvidencia=$db->GetAll( $sqlEvidencia );
}

function verEvidenciaActualizar( $id , $db ){
    $sqlEvidencia="SELECT
                            idsiq_evidenciaoportunidad,
                            nombre,
                            descripcion,
                            valoracion,
                            fechacreacion,
                            fechamodificacion,
                            Ubicacion_url
                    FROM
                            siq_evidenciaoportunidades 
                    WHERE
                            idsiq_evidenciaoportunidad = ".$id." 
                            AND codigoestado = 100";
    return $resultSqlEvidencia=$db->GetRow( $sqlEvidencia );

}

function agregar($db, $idOportunidad , $nombre ,$descripcion, $usuario,$ubicacion ){
    $sql="
            INSERT INTO siq_evidenciaoportunidades 
            ( idsiq_oportunidad,
            nombre,
            descripcion, 
            usuariocreacion,
            fechacreacion,
            codigoestado,
            Ubicacion_url )
            VALUES(
            ".$idOportunidad.",
            '".$nombre."',
            '".$descripcion."',
            '".$usuario."',
             now(),
             100,
             '".$ubicacion."'
            )";
    $db->Execute($sql);
}

function actualizarEvidencia( $db, $id ,$nombre,$descripcion,$usuario ){
    $sql ="UPDATE siq_evidenciaoportunidades 
           SET nombre = '".$nombre."',
            descripcion = '".$descripcion."',
            usuariomodificacion = ".$usuario.",
            fechamodificacion = NOW( ) 
           WHERE
            idsiq_evidenciaoportunidad = ".$id." ";
    $db->Execute($sql);
}

function actualizarEstadoEvidencia( $db, $id , $usuario){
    $sql ="UPDATE siq_evidenciaoportunidades  SET codigoestado=200, fechamodificacion = NOW( ) ,usuariomodificacion = ".$usuario."  WHERE idsiq_evidenciaoportunidad = ".$id."";
    $db->Execute($sql);
}

function modificarAvance( $db, $id, $valoracion, $avanceevidencia, $usuario){
	$sql = "UPDATE siq_oportunidades SET `Valoracion`='".$valoracion."', `descripcionavance`='".$avanceevidencia."', usuariomodificacion = ".$usuario.",
            fechamodificacion = NOW( ) WHERE (`idsiq_oportunidad`=".$id.")";
	$db->Execute($sql);
}

function conteoEvidencia ($db,$id){
    $sql="SELECT COUNT(*) as evidencias FROM siq_evidenciaoportunidades WHERE idsiq_oportunidad =".$id." AND codigoestado=100 ";
    return $db->GetRow( $sql );
}

function precargarAvances($db,$id = 0){
	$sql = "SELECT
				Valoracion,
				descripcionavance
			FROM
				siq_oportunidades
			WHERE
				idsiq_oportunidad = ".$id;
	return $db->GetRow( $sql );
}

?>
