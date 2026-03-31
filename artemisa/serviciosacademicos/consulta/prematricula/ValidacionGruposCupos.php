<?PHP 
 session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
if($_POST['actionID']=='ValidarGrupoCupoAjax'){
        
    $json['val'] = validacuposgrupo($_POST['idgrupo'],$_POST['codigoperiodo'],$_POST['codigocarrera']);
    echo json_encode($json);
    exit();
}
function validacuposgrupo($idgrupo, $codigoperiodo, $codigocarrera){
    
    require(realpath(dirname(__FILE__)).'/../../Connections/sala2.php'); 
    $rutaado = "../../funciones/adodb/";
    require(realpath(dirname(__FILE__)).'/../../Connections/salaado.php');
    
    include_once(realpath(dirname(__FILE__)).'/actualizarmatriculados.php');
   
    $sala = $db->_connectionID;
   
    actualizarmatriculadosOther($idgrupo, $codigoperiodo, $codigocarrera,$sala);
    
    $SQL='SELECT COUNT(d.idgrupo) AS matriculados
		FROM detalleprematricula d, estudiante e, prematricula p
		WHERE (d.codigoestadodetalleprematricula LIKE "1%" OR d.codigoestadodetalleprematricula LIKE "3%")
		and (p.codigoestadoprematricula like "1%" or p.codigoestadoprematricula like "4%")
		and p.idprematricula = d.idprematricula
		and p.codigoestudiante = e.codigoestudiante
		and e.codigosituacioncarreraestudiante not like "1%"
		and e.codigosituacioncarreraestudiante not like "5%"
		and p.codigoperiodo = "'.$codigoperiodo.'"
		AND d.idgrupo = "'.$idgrupo.'"';
    
    $DatoPrematricula = $db->GetRow($SQL);
    
    $SQL='SELECT
            maximogrupo,
            matriculadosgrupo,
            maximogrupoelectiva,
            matriculadosgrupoelectiva
          FROM
            grupo      
          WHERE
            idgrupo="'.$idgrupo.'"';    
    
    
    $row_ValidarGrupoCupo = $db->GetAll($SQL);
   
    if($row_ValidarGrupoCupo[0]['maximogrupo']>0){
        if($DatoPrematricula['matriculados']<$row_ValidarGrupoCupo[0]['maximogrupo']){
            return true;
        }else{
            ?>
            <script type="application/javascript">
                alert('No hay cupos Disponibles vuelva a Intentar');
                location.href='matriculaautomatica.php?programausadopor=';
            </script>
            <?PHP
            return false;
        }
    }else if($row_ValidarGrupoCupo[0]['maximogrupo']>0 && $row_ValidarGrupoCupo[0]['maximogrupoelectiva']>0){
        if(($DatoPrematricula['matriculados']<$row_ValidarGrupoCupo[0]['maximogrupo']) && ($DatoPrematricula['matriculados']<$row_ValidarGrupoCupo[0]['maximogrupoelectiva'])){   
            return true;
        }else{
            ?>
            <script type="application/javascript">
                alert('No hay cupos Disponibles vuelva a Intentar');
                location.href='matriculaautomatica.php?programausadopor=';
            </script>
            <?PHP
            return false;
        }
    }
}//function validacuposgrupo
function ValidarAjax($idgrupo,$codigoperiodo,$codigocarrera){
    ?>
    <script type="text/javascript" language="javascript" src="../../mgi/js/jquery.js"></script>
    <script type="text/javascript" language="javascript" src="../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
    <script type="application/javascript">
                $(document).ready(function () {
                    $.ajax({ //Ajax
                        type: 'POST',
                        url: 'ValidacionGruposCupos.php',
                        async: false,
                        dataType: 'json',
                        data:({actionID: 'ValidarGrupoCupoAjax',idgrupo:<?PHP echo $idgrupo;?>,codigoperiodo:<?PHP echo $codigoperiodo?>,codigocarrera:<?PHP echo $codigocarrera?>}),
                        error: function (objeto, quepaso, otroobj) {
                            alert('Error de Conexi?n , Favor Vuelva a Intentar');
                        },
                        success: function (data) {
                                if (data.val === false) {
                                    alert('No hay cupos Disponibles vuelva a Intentar');
                                    location.href='matriculaautomatica.php?programausadopor=';
                                    return false;
                                }else{
                                    return 1;
                                }
                            } //DATA
                    }); //AJAX  
                });
            </script>
    <?PHP
   
}//function name

?>