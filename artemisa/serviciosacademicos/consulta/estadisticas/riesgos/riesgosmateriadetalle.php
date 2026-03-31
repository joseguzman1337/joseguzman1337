<?php
//session_start();
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

include('../../../men/templates/MenuReportes.php');

?>

    <style type="text/css" title="currentStyle">
                @import "data/media/css/demo_page.css";
                @import "data/media/css/demo_table_jui.css";
                @import "data/media/css/ColVis.css";
                @import "data/media/css/TableTools.css";
                @import "data/media/css/jquery.modal.css";
                
    </style>
    <script type="text/javascript" language="javascript" src="data/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" charset="utf-8" src="data/media/js/ColVis.js"></script>
    <script type="text/javascript" charset="utf-8" src="data/media/js/ZeroClipboard.js"></script>
    <script type="text/javascript" charset="utf-8" src="data/media/js/TableTools.js"></script>
    <script type="text/javascript" charset="utf-8" src="data/media/js/jquery.modal.js"></script>
    <script type="text/javascript" language="javascript">
	/****************************************************************/
	$(document).ready( function () {
			
			oTable = $('#example').dataTable({
                            "sDom": '<"H"Cfrltip>',
                            "bJQueryUI": true,
                            "bPaginate": true,
                            "sPaginationType": "full_numbers",
                            "oColVis": {
                                  "buttonText": "Ver/Ocultar Columns",
                                   "aiExclude": [ 0 ]
                            }
                        });
                        var oTableTools = new TableTools( oTable, {
					"buttons": [
						"copy",
						"csv",
						"xls",
						"pdf",
						{ "type": "print", "buttonText": "Print me!" }
					]
		         });
                         $('#demo').before( oTableTools.dom.container );
		} );
	/**************************************************************/
</script>	
<?PHP
    require_once('../../../Connections/sala2.php');
    $rutaado = "../../../funciones/adodb/";
    require_once('../../../funciones/sala/estudiante/estudiante.php');
    require_once('../../../Connections/salaado.php');
    require_once('../../../funciones/sala/nota/nota.php');
    require ('../../../funciones/notas/redondeo.php');
    require('../../../funciones/notas/funcionequivalenciapromedio.php');
?>
<html>
    <body>
        <?php
        $codigoperiodo 	= $_POST['Periodo'];
        $codigomateria	= $_POST['codigomateria'];
        $modalidad 		= $_POST['modalidad'];
        $codigocarrera 	= $_POST['codigocarrera'];
        $tmaterias		= $_POST['tmaterias'];
		$Semestre		= $_POST['Semestre'];
        ?>
        <div id="container">
           <h2>Listado De Estudiantes En Riesgo Por Materia</h2>
        </div>
        <div id="demo">
        <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
        <thead>
            <tr>
                <th>N&deg;</th>
                <th>Codigo Carrera</th>
                <th>Nombre Carrera</th>
                <th>Codigo Materia</th>
                <th>Nombre Materia</th>
                <th>Codigo Grupo</th>
                <th>Codigo Periodo</th>
                <th>Riesgo Alto</th>
                <th>Riesgo Medio</th>
                <th>Riesgo Bajo</th>
                <th>Sin Riesgo</th>
                <th>Estudiante Matriculados</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $smat="";
        if ($tmaterias==1){
            $smat="";
        }else{
            $smat="  AND m.codigomateria='".$codigomateria."'  ";
        }
         $sql1="select c.codigocarrera, c.nombrecarrera, m.codigomateria, m.nombremateria, g.idgrupo, g.codigoperiodo 
               from grupo g
               inner join materia m on g.codigomateria = m.codigomateria 
               inner join carrera c on  m.codigocarrera = c.codigocarrera 
               where g.codigoperiodo ='".$codigoperiodo."' 
               AND c.codigocarrera='".$codigocarrera."' 
              ".$smat."
               and c.codigomodalidadacademica = '".$modalidad."'
               group by g.idgrupo";
       // echo $sql1;
        $data_cp1 = &$db->Execute($sql1);
        $C_data1 = $data_cp1->GetArray();
        $C_total1=count($C_data1);
        if ($C_total1>0){
            $i=1;
            foreach($data_cp1 as $data1){
                $arrayRiesgos = tomarCantidadesRiesgosXMateria(trim($data1['idgrupo']), trim($data1['codigomateria']));
                $ccar=trim($data1['codigocarrera']);
                $cma=trim($data1['codigomateria']);
                $cpe=trim($data1['codigoperiodo']);
                $idg=trim($data1['idgrupo']);
                $ah="idgrupo=".$idg."&codigocarrera=".$ccar."&periodo=".$cpe."&codigomateria=".$cma."&modalidad=".$modalidad."  "
               // print_r($arrayRiesgos);
              ?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo trim($data1['codigocarrera']) ?></td>
                    <td><?php echo trim($data1['nombrecarrera']) ?></td>
                    <td><?php echo trim($data1['codigomateria']) ?></td>
                    <td><?php echo trim($data1['nombremateria']) ?></td>
                    <td><?php echo trim($data1['idgrupo']) ?></td>
                    <td><?php echo trim($data1['codigoperiodo']) ?></td>
                    <td><a href="riesgosmateriadetalle_est.php?riesgo=Alto&<?php echo $ah ?>"  target="_blank" style="color: #00F"><?php echo trim($arrayRiesgos['Riesgo_Alto']) ?></a></td>
                    <td><a href="riesgosmateriadetalle_est.php?riesgo=Medio&<?php echo $ah ?>" target="_blank" style="color: #00F"><?php echo trim($arrayRiesgos['Riesgo_Medio']) ?></a></td>
                    <td><a href="riesgosmateriadetalle_est.php?riesgo=Bajo&<?php echo $ah ?>"  target="_blank" style="color: #00F"><?php echo trim($arrayRiesgos['Riesgo_Bajo']) ?></a></td>
                    <td><a href="riesgosmateriadetalle_est.php?riesgo=Sin&<?php echo $ah ?>"   target="_blank"  style="color: #00F"><?php echo trim($arrayRiesgos['Sin_Riesgo']) ?></a></td>
                    <td><a href="riesgosmateriadetalle_est.php?riesgo=Nes&<?php echo $ah ?>"   target="_blank" style="color: #00F"><?php echo trim($arrayRiesgos['Estudiantes_Matriculados']) ?></a></td>
                </tr>
              <?php
              $i++;
            }
        }
        ?>           
        </tbody>
        </table>
        </div>
    <!--     <div id="ex1" style="display:none;">
              <p>Thanks for clicking.  That felt good.  <a href="#" rel="modal:close">Close</a> or press ESC</p>
       </div>

  Link to open the modal 
  <p><a href="menuriesgosmateria.php" rel="modal:open">Open Modal</a></p>-->
    </body>
</html>
    