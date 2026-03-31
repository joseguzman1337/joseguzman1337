<?php
	$respuesta=array();
        $respuesta['mensaje']='success';
        include_once("../variables.php");
        include($rutaTemplate."template.php");
        $db = getBD();
	if($_SERVER["REQUEST_METHOD"]=="POST"){
            $utils = Utils::getInstance();
            $user=$utils->getUser();
            $login=$user["idusuario"];
            $dateHoy=date('Y-m-d H:i:s');
            $intCantidad=addslashes($_POST['inputCantidadAsistencia']);
            $idGrupo=addslashes($_POST['idGrupoAsistencia']);
            $fecha=addslashes($_POST['fechaAsistencia']);
            $hora=addslashes($_POST['horaAsistencia']);
            $listaAsistenciaInsertSql="INSERT into `listaAsistenciaGrupo` (`idGrupo`, `fechaLista`, `horasSesion`, `fecha_creacion`, `usuario_creacion`, `codigoestado`, `fecha_modificacion`, `usuario_modificacion`) VALUES ('$idGrupo', '$fecha', '$hora', '$dateHoy', '$login', '100', '$dateHoy', '$login');";
            $db->Execute($listaAsistenciaInsertSql);
            $sacarListaSql="select idlistaAsistenciaGrupo from listaAsistenciaGrupo where idGrupo='$idGrupo' and fechaLista='$fecha' AND codigoestado='100';";
            $sacarListaSqlRow = $db->GetRow($sacarListaSql);
            $idlista=$sacarListaSqlRow['idlistaAsistenciaGrupo'];
            for($i = 0; $i < $intCantidad; ++$i) { 
                    $idEstudiante=addslashes($_POST['idEstudiante'.$i]);
                    
                    $intAsistio=addslashes($_POST['cambiarEstadoAsistenciaHabilitar'.$i]);
                    
                    if($intAsistio>0){
                        $detalleAsistenciaInsertSql="INSERT into `detalleListaAsistenciaGrupo` (`idListaAsistencia`, `idEstudianteGeneral`, `fecha_creacion`, `usuario_creacion`, `codigoestado`, `fecha_modificacion`, `usuario_modificacion`) VALUES ('$idlista', '$idEstudiante', '$dateHoy', '$login', '100', '$dateHoy', '$login');";
                    
                        $db->Execute($detalleAsistenciaInsertSql);
                    }
            }
	}
	$respuesta['mensaje']='success';
	
	echo json_encode($respuesta);
        exit;
	
?>