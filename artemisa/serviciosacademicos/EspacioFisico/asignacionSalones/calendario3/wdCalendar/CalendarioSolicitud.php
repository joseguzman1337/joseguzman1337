<?php
// echo "<pre>"; print_r($_REQUEST);
// echo $_REQUEST['id'];
/**
* Solicitud y Detalle de los eventos
*/

require_once("../../../templates/template.php");
//include_once('../../../Interfas/InterfazSolicitud_class.php'); $C_InterfazSolicitud = new InterfazSolicitud();
$db = getBD();

class DetalleSolicitudEventos
{
    var $ret = array();
    function consultaDetalleEvento($db)
    {
       $ConsultaEvento ="SELECT ae.AsignacionEspaciosId ,ae.FechaAsignacion as fecha 
                            ,ae.HoraInicio as horainicio 
                            ,ae.HoraFin as horafinal 
                            ,CONCAT(g.idgrupo,' :: ',g.nombregrupo) AS  grupos
                            ,ce.Nombre as Salon
                            ,g.maximogrupo
                            ,ce.ClasificacionEspaciosId
                            ,sae.AccesoDiscapacitados
                            ,ae.SolicitudAsignacionEspacioId
                            ,g.idgrupo,
                            k.codigocarrera,
                            k.nombrecarrera,
                            m.codigomateria,
                            m.nombremateria,
                            CONCAT(m.codigomateria,' :: ',m.nombremateria) AS TextoView,
                            CONCAT(d.nombredocente,' ',d.apellidodocente) AS Responsable

                            FROM AsignacionEspacios ae 
                            INNER JOIN SolicitudAsignacionEspacios sae ON ae.SolicitudAsignacionEspacioId = sae.SolicitudAsignacionEspacioId 
                            INNER JOIN ClasificacionEspacios ce ON ce.ClasificacionEspaciosId=ae.ClasificacionEspaciosId 
                            INNER JOIN SolicitudEspacioGrupos seg ON seg.SolicitudAsignacionEspacioId=sae.SolicitudAsignacionEspacioId
                            INNER JOIN grupo g ON g.idgrupo=seg.idgrupo
                            INNER JOIN materia m ON m.codigomateria=g.codigomateria
                            INNER JOIN carrera k ON k.codigocarrera=m.codigocarrera
                            LEFT JOIN docente d ON d.numerodocumento=g.numerodocumento
                            WHERE ae.AsignacionEspaciosId ='".$_REQUEST['id']."' AND ae.codigoestado=100";
                            
        $queryConsultaEvento = mysql_query($ConsultaEvento);
        
        $Num = mysql_num_rows($queryConsultaEvento);
        
        if($Num!=0 || $Num>=1){ 
        
                while ($row = mysql_fetch_object($queryConsultaEvento)) {
                    
                    $SQL='SELECT
                            	COUNT(codigoestadodetalleprematricula) AS Num
                            FROM
                            	detalleprematricula
                            WHERE
                            	idgrupo= "'.$row->idgrupo.'"
                            AND codigoestadodetalleprematricula IN ("10")';
                            
                            
                      if($Prematriculados=&$db->Execute($SQL)===false){
                            echo 'Error en el SQL data de prematriculados...<br>'.$SQL;
                            die;
                        }
                        
                      $SQL='SELECT
                            	COUNT(codigoestadodetalleprematricula) AS Num
                            FROM
                            	detalleprematricula
                            WHERE
                            	idgrupo= "'.$row->idgrupo.'"
                            AND codigoestadodetalleprematricula IN (30)';
                            
                            
                      if($Matriculados=&$db->Execute($SQL)===false){
                            echo 'Error en el SQL data de prematriculados...<br>'.$SQL;
                            die;
                        }  
                    
                    $this->ret['Fecha'] = $row->fecha;
                    $this->ret['HoraInicio'] = strtotime($row->horainicio);
                    $this->ret['HoraFin'] = strtotime($row->horafinal);
                    $this->ret['grupos'] = $row->grupos;
                    $this->ret['idsalon'] = $row->ClasificacionEspaciosId;
                    $this->ret['salon'] = $row->Salon;
                    $this->ret['MaximoGrupo'] = $row->maximogrupo;
                    $this->ret['Matriculado'] = $Matriculados->fields['Num'];;
                    $this->ret['preMatriculado'] = $Prematriculados->fields['Num'];
                    $this->ret['codigotiposalon'] = $row->codigotiposalon;
                    $this->ret['AccesoDiscapacitados'] = $row->AccesoDiscapacitados;
                    $this->ret['SolicitudAsignacionEspacioId'] = $row->SolicitudAsignacionEspacioId;
                    $this->ret['idgrupo'] = $row->idgrupo;
                    $this->ret['codigocarrera'] = $row->codigocarrera;
                    $this->ret['TextoView'] = $row->TextoView;
                    $this->ret['Tipo'] = 1;
                    $this->ret['Responsable'] = $row->Responsable;
                
                }
        }else{
            
              $ConsultaEvento ="SELECT 
                             ae.AsignacionEspaciosId 
                            ,ae.FechaAsignacion as fecha 
                            ,ae.HoraInicio as horainicio 
                            ,ae.HoraFin as horafinal 
                            ,g.nombregrupo as grupos
                            ,ce.Nombre as Salon
                            ,ce.ClasificacionEspaciosId
                            ,sae.AccesoDiscapacitados
                            ,ae.SolicitudAsignacionEspacioId
                            ,g.idgrupo,
                            k.codigocarrera,
                            k.nombrecarrera,
                            sae.NombreEvento,
                            sae.UnidadNombre, 
                            sae.NumAsistentes AS maximogrupo,
                            CONCAT(sae.NombreEvento,' :: ',sae.UnidadNombre) AS TextoView,
                            sae.Responsable AS Responsable
                            FROM AsignacionEspacios ae 
                            INNER JOIN SolicitudAsignacionEspacios sae ON ae.SolicitudAsignacionEspacioId = sae.SolicitudAsignacionEspacioId 
                            INNER JOIN ClasificacionEspacios ce ON ce.ClasificacionEspaciosId=ae.ClasificacionEspaciosId
                            LEFT JOIN SolicitudEspacioGrupos seg ON seg.SolicitudAsignacionEspacioId=sae.SolicitudAsignacionEspacioId
                            LEFT JOIN grupo g ON g.idgrupo=seg.idgrupo
                            LEFT JOIN materia m ON m.codigomateria=g.codigomateria
                            LEFT JOIN carrera k ON k.codigocarrera=m.codigocarrera
                            WHERE ae.AsignacionEspaciosId ='".$_REQUEST['id']."'  AND ae.codigoestado=100";
                            
                $queryConsultaEvento = mysql_query($ConsultaEvento);
        
                while ($row = mysql_fetch_object($queryConsultaEvento)) {
                    
                    $this->ret['Fecha'] = $row->fecha;
                    $this->ret['HoraInicio'] = strtotime($row->horainicio);
                    $this->ret['HoraFin'] = strtotime($row->horafinal);
                    $this->ret['grupos'] = $row->grupos;
                    $this->ret['idsalon'] = $row->ClasificacionEspaciosId;
                    $this->ret['salon'] = $row->Salon;
                    $this->ret['MaximoGrupo'] = $row->maximogrupo;
                    $this->ret['Matriculado'] = 0;
                    $this->ret['preMatriculado'] =0;
                    $this->ret['codigotiposalon'] = $row->codigotiposalon;
                    $this->ret['AccesoDiscapacitados'] = $row->AccesoDiscapacitados;
                    $this->ret['SolicitudAsignacionEspacioId'] = $row->SolicitudAsignacionEspacioId;
                    $this->ret['idgrupo'] = $row->idgrupo;
                    $this->ret['codigocarrera'] = $row->codigocarrera;
                    $this->ret['TextoView'] = $row->TextoView;
                    $this->ret['Tipo'] = 0;
                    $this->ret['Responsable'] = $row->Responsable;
                
                }
            
        }
    }
    function obtenerdatos(){
        return $this->ret;
        // var_dump($this->ret);
    }
}

$objeto = new DetalleSolicitudEventos;
$objeto->consultaDetalleEvento($db);
$row1 = $objeto->obtenerdatos();

//echo '<pre>';print_r($row1);

?>
<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> 
<html lang="es"> <!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="../../css/jquery.datetimepicker.css"/>
 <link rel="stylesheet" href="../../../css/Styleventana.css" type="text/css" />
    
    <script type="text/javascript" src="../../js/jquery.js"></script>
    <script type="text/javascript" src="../../js/jquery.datetimepicker.js"></script>
    <script type="text/javascript" src="./EventoSolicitud.js"></script>
     <script type="text/javascript" language="javascript" src="../../../js/jquery.bpopup.min.js"></script>
    <script src="../../../wdCalendar/wdCalendar/src/Plugins/Common.js" type="text/javascript"></script> 
    <title>Men&uacute;</title> 
  
</head>
<body>
    <form name="elige" id="ViewEvento" action="capturadatos()">
        <div>
            <fieldset>
                <legend>Detalle del evento</legend>
                <div>
                        <label>Solicitud ID:</label>
                        <label><?php echo $row1['SolicitudAsignacionEspacioId'];?></label>
                </div>
                <div>
                        <label>Fecha:</label>
                        <input type="text" value="<?php echo$row1['Fecha'];?>" readonly="true" name="datetimepickerfecha" id="datetimepickerfecha" size="12"/>
                </div>
                <div>
                        <label>Hora Inicio:</label>
                        <input type="text" id="datetimepicker1"  readonly="true" name="datetimepicker1" value="<?php echo date( 'H:i', $row1['HoraInicio'] ); ?>" size="6"/>
                </div>
                <div>
                        <label>Hora Fin:</label>
                        <input type="text" id="datetimepicker2" readonly="true" name="datetimepicker2" value="<?php echo date( 'H:i', $row1['HoraFin'] ); ?>" size="6"/>
                </div>
                <div>
                        <label>Materia o Evento:</label>
                        <?php echo $row1['TextoView']; ?>
                </div>
                <div>
                        <label>Grupos:</label>
                        <?php echo $row1['grupos']; ?>
                </div>
                <div>
                        <label>Docente o Responsable:</label>
                        <?php echo $row1['Responsable']; ?>
                </div>
                <div>
                <?PHP if($row1['Tipo']==1){?>
                    <table>
                        <tr>
                            <td><label>Maximo Grupo</label></td>
                            <td><label>Matriculados</label></td>
                            <td><label>Prematriculados</label></td>
                            <td><label>Matriculados y Prematriculados</label></td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">
                                <input type="radio" name="Cupo" id="Maxi" value="<?PHP echo $row1['MaximoGrupo'];?>" />
                                <?PHP echo $row1['MaximoGrupo'];?>
                            </td>
                            <td style="text-align: center;">
                                <input type="radio" name="Cupo" id="Matri" value="<?PHP echo $row1['Matriculado'];?>" />
                                <?PHP echo $row1['Matriculado'];?>
                            </td>
                            <td style="text-align: center;">
                                <input type="radio" name="Cupo" id="Pre" value="<?PHP echo $row1['preMatriculado'];?>" />
                                <?PHP echo $row1['preMatriculado'];?>
                            </td>
                            <td style="text-align: center;">
                                <input type="radio" name="Cupo" id="Suma" value="<?PHP echo $row1['Matriculado']+$row1['preMatriculado'];?>" />
                                <?PHP echo $row1['Matriculado']+$row1['preMatriculado'];?>
                            </td>
                        </tr>
                    </table>
                       <?PHP }else{
                            ?>
                            <label>Numero Asistentes</label>
                            <input type="hidden" id="NumAsitentes" name="NumAsitentes" value="<?PHP echo $row1['MaximoGrupo'];?>" />
                            <?PHP echo $row1['MaximoGrupo'];?>
                            <?PHP
                        }?>
                </div>
            </fieldset>
        </div>
        <div>
            <fieldset>
                <legend>Datos del Sal&oacute;n</legend>
                <div>
                    <input type="hidden" id="codSalon" name="codSalon" value="<?php echo $row1['idsalon']?>"/>
                    <input type="hidden" id="SolicitudAsignacionEspacioId" name="SolicitudAsignacionEspacioId" value="<?php echo $row1['SolicitudAsignacionEspacioId']?>"/>
                    <input type="hidden" id="idEvento" name="idEvento" value="<?php echo $_REQUEST['id']; ?>"/>
                    <input type="hidden" id="idGrupo" name="idGrupo" value="<?php echo $row1['idgrupo']; ?>"/>
                    <input type="hidden" id="codigocarrera" name="codigocarrera" value="<?php echo $row1['codigocarrera']; ?>"/>
                </div>
                <div>
                        <label>Tipo Sal&oacute;n:</label>
                       
                        <select id="listaTipoSalon" name="listaTipoSalon">
                        <?php
                        $queryListaTipoSalon = "SELECT codigotiposalon,nombretiposalon FROM tiposalon  t 
                                        INNER JOIN EspaciosFisicos e ON t.EspaciosFisicosId=e.EspaciosFisicosId
                                        WHERE t.codigoestado=100
                                        AND e.PermitirAsignacion=1
                                        AND e.codigoestado=100";
                        $resultadoListaTipoSalon = mysql_query($queryListaTipoSalon);
                        
                        
                        while ($row2=mysql_fetch_object($resultadoListaTipoSalon)) {
                            ?>
                            <option value="<?php echo $row2->codigotiposalon;?>" <?php if($row2->codigotiposalon==$row1['codigotiposalon']){ ?> selected <?php } ?> ><?php echo $row2->nombretiposalon;?></option>
                            <?php
                        }
                        ?>
                        </select>
                </div>
                <div>
                    <label>Acceso a discapacitados:</label>
                    <select id="accesoDiscapacitados" name="accesoDiscapacitados">
                        <option value="1" <?php if ($row1['AccesoDiscapacitados']==1) { ?> selected <?php } ?> >Si </option>
                        <option value="0" <?php if ($row1['AccesoDiscapacitados']==0) { ?> selected <?php } ?> >No </option>
                    </select>   
                </div>
            </fieldset>
        </div>
        <div id="botones" >
            <input type="button" id="buscar" value="Buscar Espacios" onclick="validar(1)">
            <input type="button" id="Actualizar" value="Actualizar" onclick="validar(2)">
            <input type="button" id="Eliminar" value="Eliminar" onclick="validar(3)">
        </div>
        <div>
            <fieldset>
                <legend>Resultado de la Busqueda</legend>
                <div id="mostrarResultados" style="text-align:center"></div>
            </fieldset>
        </div>

    </form>
</body>
</html>

<script type="text/javascript">

$('#datetimepickerfecha').datetimepicker({
    lang:'es',
    timepicker:false,
    format:'Y-m-d',
    formatDate:'Y-m-d',
})
.datetimepicker({value:'',step:10});

$('#datetimepicker1').datetimepicker({
    datepicker:false,
    format:'H:i',
    step:30
});

$('#datetimepicker2').datetimepicker({
    datepicker:false,
    format:'H:i',
    step:30
});
function validar(control){
    var resultado=0;
    var idFecha=document.getElementById("datetimepickerfecha").value;
    var idHoraInicio=document.getElementById("datetimepicker1").value+":00";
    var idHoraFinal=document.getElementById("datetimepicker2").value+":00";
    var tipoSalon=document.getElementById("listaTipoSalon").value;
    var accesoDiscapacitados=document.getElementById("accesoDiscapacitados").value;
    if($('#Maxi').is(':checked')){
         var  tamanioGrupos= $('#Maxi').val();
       }else if($('#Matri').is(':checked')){
         var  tamanioGrupos = $('#Matri').val();
       }else if($('#Pre').is(':checked')){
         var  tamanioGrupos = $('#Pre').val();
       }else if($('#Suma').is(':checked')){
         var  tamanioGrupos = $('#Suma').val();
       }else{
            var  tamanioGrupos = $('#NumAsitentes').val();
       }
   
   if(!$.trim(tamanioGrupos)){
    alert('Por Favor Indique el Cupo Solicitado...');
    return false;
   }
   
    var codSalon=document.getElementsByName("idSalon");
    var SolicitudAsignacionEspacioId=document.getElementById("SolicitudAsignacionEspacioId").value;
    
    for(var i=0;i<codSalon.length;i++)
    {
        if(codSalon[i].checked)
            resultado=codSalon[i].value;
    }
    if (resultado==0) {
        var idTipoSalon=document.getElementById("codSalon").value;
    }else{
        var idTipoSalon=resultado;
    }

    if (idHoraInicio==idHoraFinal) {
        alert('Error: Horas Iguales');
    }else if(idHoraInicio>idHoraFinal){
        alert('Error: Hora inicial no puede ser mayor que la hora final');
    }else{
        if (control==1) {
            capturadatos(idFecha,idHoraInicio,idHoraFinal,tipoSalon,accesoDiscapacitados,tamanioGrupos,idTipoSalon);
        }else if(control==2){
            actualizar('ViewEvento');
        }else if(control==3){
            eliminar('ViewEvento');  
        }
    }

}

function capturadatos(idFecha,idHoraInicio,idHoraFinal,tipoSalon,accesoDiscapacitados,tamanioGrupos,idTipoSalon){
    var Grupo = $('#idGrupo').val();
    var codigocarrera = $('#codigocarrera').val();
    $('#mostrarResultados').html('<img src="../../../../mgi/images/engranaje-09.gif" width="90" />');
    $.ajax({
        url: './funcionesCalendario.php',
        type: 'POST',
        dataType: 'html',
        data: {fecha:idFecha, hi:idHoraInicio, hf:idHoraFinal,tipoSalon: tipoSalon,accesoDiscapacitados:accesoDiscapacitados,tamanioGrupos: tamanioGrupos,idTipoSalon:idTipoSalon,Grupo:Grupo,Carrera:codigocarrera},
    })
    .done(function(data) {
        $('#mostrarResultados').html('');
        $('#mostrarResultados').html(data);
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
}
function actualizar(formulario){
    $input = $('<input type="hidden" name="accion"/>').val('actualizar');
    $('#'+formulario).append($input);
    $.ajax({
        url: './funcionesCalendario1.php',
        type: 'POST',
        dataType: 'json',
        data: $('#'+formulario).serialize(),
        success: function(data){
            
                   if(data.val===false){
                        alert(data.descrip);
                        return false;
                   }else{
                        alert(data.descrip);
                        window.parent.ParentWindowFunction();
                        CloseModelWindow(null,true);  
                   }
                }  
    })
}
function eliminar(formulario){
    $input = $('<input type="hidden" name="accion"/>').val('eliminar');
    $('#'+formulario).append($input);
    $.ajax({
    url: './funcionesCalendario1.php',
    type: 'POST',
    dataType: 'json',
    data:$('#'+formulario).serialize(),
    success: function(data){
            
                   if(data.val===false){
                        alert(data.descrip);
                        return false;
                   }else{
                        alert(data.descrip);
                        window.parent.ParentWindowFunction();
                        CloseModelWindow(null,true);  
                   }
                } 
    })
}
function SolicitarSobreCupo(id){
    /****************************************************/
   $('#VentanaNew').css('z-index','9999');
   $('#VentanaNew').css('display','block');
   $('#VentanaNew').css('left','350px');
   $('#VentanaNew').css('opacity','1');
   $('#VentanaNew').css('position','absolute');
   $('#VentanaNew').css('top','2328.5px');
   $('#VentanaNew').css('height','650px');
   $('#VentanaNew').css('width','650px');
   //$('#OmitirSave').css('display','inline');
   
    $('#VentanaNew').bPopup({
        content:'iframe',// 'ajax', 'iframe' or 'image' xlink
        //contentContainer:'.content',
        iframeAttr:['scrolling="no" style="width:90%;height:90%" frameborder="54"'],
        //escClose:[true],
        loadUrl:'../../../Interfas/InterfazSolicitud_html.php?actionID=HacerSolictuSobrecupo&id='+id,
  }); 
  }//function SolicitarSobreCupo
</script>



<?php
/*
function validar(control){
    var resultado=0;
    var idFecha=document.getElementById("datetimepickerfecha").value;
    var idHoraInicio=document.getElementById("datetimepicker1").value+":00";
    var idHoraFinal=document.getElementById("datetimepicker2").value+":00";
    var tipoSalon=document.getElementById("listaTipoSalon").value;
    var accesoDiscapacitados=document.getElementById("accesoDiscapacitados").value;
    var tamanioGrupos = document.getElementById("tamanioGrupos").value;
    var codSalon=document.getElementsByName("idSalon");
    var SolicitudAsignacionEspacioId=document.getElementById("SolicitudAsignacionEspacioId").value;
    for(var i=0;i<codSalon.length;i++)
    {
        if(codSalon[i].checked)
            resultado=codSalon[i].value;
    }
    if (resultado==0) {
        var idTipoSalon=document.getElementById("codSalon").value;
    }else{
        var idTipoSalon=resultado;
    }

    if (idHoraInicio==idHoraFinal) {
        alert('Error: Horas Iguales');
    }else if(idHoraInicio>idHoraFinal){
        alert('Error: Hora inicial no puede ser mayor que la hora final');
    }else{
        if (control==1) {
            capturadatos(idFecha,idHoraInicio,idHoraFinal,tipoSalon,accesoDiscapacitados,tamanioGrupos,idTipoSalon);
        }else if(control==2){
            if ($("input[type='checkbox']:checked").length==0) {
                alert("Debe elegir un salon antes de continuar");
            }else{
                actualizar('ViewEvento');
            }
        }else if(control==3){
            eliminar('ViewEvento');  
        }
    }

}
*/
?>
<?php
/**
* Calculo fechas
*/
// class calculoFechas
// {
  
//   function calculoSemana($fechainicio, $fechafinal){
//     $d1=new DateTime($fechainicio);
//     $d2=new DateTime($fechafinal);
//     $diff=$d2->diff($d1);
//     for ($i=0; $i <= $diff->days; $i++) { 
//         $numsemana[]= $d1->format('W');
//       date_add($d1, date_interval_create_from_date_string('1 days'));
//     }
//     $numsemana = array_unique($numsemana);
//     for ($periodicidad=$numsemana[0]; $periodicidad <= end($numsemana); $periodicidad+=2) {
//       $this->calculoFechasDias($periodicidad, $fechainicio, $fechafinal);
//     }
//   }
//   function calculoFechasDias($sem, $fechainicio, $fechafinal){
//     $d1=new DateTime($fechainicio);
//     $d2=new DateTime($fechafinal);
//     $diff=$d2->diff($d1);
//     $diaSemana = array(
//       // 1 => "Lunes",
//       2 => "Martes",
//       // 3 => "Miercoles",
//       // 4 => "Jueves",
//       // 5 => "Viernes",
//       // 6 => "Sabado",
//       // 7 => "Domingo",
//       );
//       for ($i=0; $i <= $diff->days; $i++) {
//         foreach ($diaSemana as $key => $value) {
//           if ($d1->format('N')==$key){
//              if ($d1->format('W')==$sem){
//               echo $i."=".$d1->format('Y-m-d-N-D-W') . "</br>";
//             }
//           }
//         }
//         date_add($d1, date_interval_create_from_date_string('1 days'));
//       }
// }
// }
// $fechainicio = '01-07-2014';
// $fechafinal = '30-08-2014';
// $fecha1 = new calculoFechas;
// $fecha1->calculoSemana($fechainicio, $fechafinal);
// die;

?>