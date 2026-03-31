
<?php
include ('Reporte_ComparativoSaber11.class.php');
$C_Reporte_ComparativoSaber11 = new Reporte_ComparativoSaber11();
class ViewReporte_ComparativoSaber11{
    public function Principal(){
        global $db,$userid;
           
           
        ?>
        <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=8" >
        <title>Reporte Comparativo Saber 11</title>
        <style type="text/css" title="currentStyle">
                @import "../../css/demo_page.css";
                @import "../../css/demo_table_jui.css";
                @import "../../css/demos.css";
                @import "../data/media/css/themes/smoothness/jquery-ui-1.8.4.custom.css";
                @import "../../css/jquery-ui.css";
                @import "../css/styleObservatorio.css";
                @import "../data/media/css/ColVis.css";
                @import "../data/media/css/TableTools.css";
                @import "../data/media/css/jquery.modal.css";
                @import "../data/media/css/ColReorder.css";
                @import "../js/fancybox/jquery.fancybox.css?v=2.1.5";
                
        </style>
        <link href="../css/jquery.akordeon.css" rel="stylesheet" type="text/css" />
        <link href="../css/smart_tab.css" rel="stylesheet" type="text/css" />
       <script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="../js/jquery-ui-1.8.21.custom.min.js"></script>
        <script type="text/javascript" language="javascript" src="../js/jquery.fastLiveFilter.js"></script>
        <script type="text/javascript" language="javascript" src="../js/jquery-ui-timepicker-addon.js"></script>
        <script type="text/javascript" language="javascript" src="../js/nicEdit-latest.js"></script>
        <script type="text/javascript" language="javascript" src="../js/functions.js"></script>
        <script type="text/javascript" language="javascript" src="../js/jquery.numeric.js"></script>
        <script type="text/javascript" language="javascript" src="../js/jtip.js"></script>
        <script type="text/javascript" language="javascript" src="../data/media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8" src="../data/media/js/ColVis.js"></script>
        <script type="text/javascript" charset="utf-8" src="../data/media/js/ZeroClipboard.js"></script>
        <script type="text/javascript" charset="utf-8" src="../data/media/js/TableTools.js"></script>
        <script type="text/javascript" charset="utf-8" src="../data/media/js/jquery.modal.js"></script>
        <script type="text/javascript" charset="utf-8" src="../data/media/js/ColReorder.js"></script>
        <script type="text/javascript" charset="utf-8" src="../data/media/js/FixedColumns.js"></script>
        <script src="../js/jquery.akordeon.js" type="text/javascript"></script>
        <script type="text/javascript" src="../js/jquery.smartTab.js"></script>
        <script type="text/javascript" src="../js/fancybox/jquery.fancybox.js?v=2.1.5"></script>
        <link rel="stylesheet" href="../tablero/css/normalize.css"></link>
        <link rel="stylesheet" href="../tablero/css/main.css"></link>
        <link href='http://fonts.googleapis.com/css?family=Fjalla+One' rel='stylesheet' type='text/css'></link>
</head>
    <body id="dt_example" class="mando">
                <div id="encabezado" style=" color: #FFFFFF; line-height: 1em; font-family:'Fjalla One',sans-serif">
			<div class="cajon">
				<div style=" margin-left: 100px; color:#E5D912; line-height: 1.2em; font-size: 30px">
					<div>Reporte Comparativo Saber 11</div>
				</div>
			
			</div>
                        
		</div>
                
        <div>

   
        <script type="text/javascript" language="javascript">
            
            $(document).ready( function () {//"sDom": '<Cfrltip>',
    				
    			} ); 
            
        </script>
         <div id="container">
            <fieldset >
                <legend>Reporte Saber 11</legend>
                <div id="listadorangos">
                    <?php $this->ViewTablaRangos(); ?>
                </div>
                <div id="listaestudiantes">
                
                </div>
            </fieldset>
        </div>
        <div id="resultablas">
        
        
        </div>
        </body>
    </html>
        <?php
    }//public function Principal
    public function ViewTablaRangos(){
        global $db,$userid,$C_Reporte_ComparativoSaber11;
        $arrayrango=array();
        $arrayrango["400_410"]=$C_Reporte_ComparativoSaber11->CantidadRangosPuntajeEstudiantes("400","410");
        $arrayrango["411_425"]=$C_Reporte_ComparativoSaber11->CantidadRangosPuntajeEstudiantes("411","425");
        $arrayrango["426_450"]=$C_Reporte_ComparativoSaber11->CantidadRangosPuntajeEstudiantes("426","450");
        $arrayrango["451_max"]=$C_Reporte_ComparativoSaber11->CantidadRangosPuntajeEstudiantes("451","1000");
    ?>
    <table border="1" cellpadding="0" cellspacing="0" class="display" id="tabla">
        <thead>
            <tr>
                <th>Rango</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
           <tr>
                <td  aling="center">
                    400 a 410
                </td>
                <td aling="center"><a onclick="tablalumnos('400_410');" style="cursor: pointer;"><?php echo $arrayrango["400_410"]; ?></a></td>
            </tr>
            <tr>
                <td  aling="center">
                     411 a 425
                </td>
                <td aling="center"><a onclick="tablalumnos('411_425');" style="cursor: pointer;"><?php echo $arrayrango["411_425"]; ?></a></td>
            </tr>
            <tr>
                <td aling="center">
                     426 a 450
                </td>
                <td aling="center"><a onclick="tablalumnos('426_450');" style="cursor: pointer;"><?php echo $arrayrango["426_450"]; ?></a></td>
            </tr>
            <tr>
                <td aling="center">
                     mayores a 451
                </td>
                <td aling="center"><a onclick="tablalumnos('451_1000');" style="cursor: pointer;"><?php echo $arrayrango["451_max"]; ?></a></td>
                
                
            </tr>
            
        </tbody>
    </table>
    <?php 
    }///////////function ViewTablaRangos   
    public function ViewListadoEstudiantesRango($Pinicial,$Pfinal){
        global $db,$userid,$C_Reporte_ComparativoSaber11;
        $arrayrango=array();
        $arrayrango=$C_Reporte_ComparativoSaber11->RangosEstudiantes($Pinicial,$Pfinal);
        //print_r($arrayrango);
        
            
            
        
        ?>
        <table border="1" cellpadding="0" cellspacing="0" class="display" id="tabla">
        <thead>
            
            <tr>
                <th colspan="3">Listado de Estudiantes</th>
            </tr>
            <tr>
                <th>Documento</th>
                <th>Nombres</th>
                <th>Puntaje Global</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($arrayrango as $itemestudiante){ ?>
           <tr>
                <td  aling="center"><?php echo $itemestudiante["numerodocumento"]; ?></td>
                <td aling="center"><?php echo $itemestudiante["nombresestudiantegeneral"]." ".$itemestudiante["apellidosestudiantegeneral"]; ?></td>
                <td aling="center"><?php echo $itemestudiante["PuntajeGlobal"]; ?></td>
           
            </tr>
            
         <?php  }
        ?>   
        </tbody>
    </table>
   <?php
   }///functionViewRangos

}//class ViewReporte_ComparativoSaber11



?>