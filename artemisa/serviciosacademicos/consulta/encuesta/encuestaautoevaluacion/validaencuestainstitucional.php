<?php
function validaEncuestaPendiente($idestudiantegeneral,$codigocarrera,$codigoperiodo,$sala) {



    $idencuesta='48';
    $objetobase = new BaseDeDatosGeneral($sala);
    $objvalidaautoevaluacion = new ValidaEncuesta($objetobase, $codigoperiodo, '1');

    $condicion =" and o.numeroordenpago=d.numeroordenpago
					and eg.idestudiantegeneral=e.idestudiantegeneral
						AND e.codigoestudiante=pr.codigoestudiante
						AND pr.codigoperiodo='20111'
						AND e.codigoestudiante=o.codigoestudiante
						AND c.codigocarrera=e.codigocarrera
						AND d.codigoconcepto=co.codigoconcepto
                                                and e.codigocarrera='$codigocarrera'
						AND co.cuentaoperacionprincipal=151
						AND o.codigoperiodo='20111'
						AND o.codigoestadoordenpago LIKE '4%'
						AND c.codigomodalidadacademica like '2%'						
						and c.codigomodalidadacademica='200'
						";
if(!$datosnombresegresado=$objetobase->recuperar_datos_tabla("ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr,estudiantegeneral eg","eg.idestudiantegeneral",$idestudiantegeneral,$condicion,'',0))
{
    return 0;
}
 






    $objvalidaautoevaluacion->setIdEncuesta($idencuesta);
    $condicion = " and pc.idpregunta=p.idpregunta and (pc.codigocarrera ='" . $codigocarrera . "' or pc.codigocarrera=1) ";
    $objvalidaautoevaluacion->setCondicionAdicional($condicion);
    $objvalidaautoevaluacion->setTablaAdicional(",preguntacarrera pc");

    $tabla = "respuestainstitucional";
    $objvalidaautoevaluacion->setTablaRespuesta($tabla);

    /* if(!$objvalidaautoevaluacion->encuentraEstudianteEncuestaBienestar($_GET['idusuario'])){
      echo "<script type='text/javascript'>parent.continuar();</script>";
      } */
//if($objvalidaautoevaluacion->encuestaCarreraActiva()){
    $objvalidaautoevaluacion->setUsuario($idestudiantegeneral);
    $preguntasfacultades = $objvalidaautoevaluacion->validaPreguntasFaltantes();
    /* echo "<pre>";
      print_r($preguntasfacultades);
      echo "</pre>"; */
    if (!is_array($preguntasfacultades) ||
            (count($preguntasfacultades) < 1)) {
        /*  alerta_javascript('Ha finalizado la encuesta,\n Gracias por su colaboracion');
          echo "<script type='text/javascript'>parent.continuar();</script>"; */
        return 0;
        //echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../../educacioncontinuada/certificadoymemorias.php?documento=" . $datosasistente['documentoasistente'] . "&iddiploma=" . $datosasistente['iddiploma'] . "'>";
    } else {
        return 1;
        // alerta_javascript('No ha finalizado la encuesta');
    }
}

?>
