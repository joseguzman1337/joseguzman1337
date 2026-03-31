<?php
/*
* @Rivera Diego<arizaandres@unbosque.edu.co>
* Modificado Julio 26 del 2018
* Se unifican las claves con el archivo de configuracion
*se añade libreria  jquery.fixedtableheader.js
*/
require_once(realpath ( dirname(__FILE__)."/../../../sala/config/Configuration.php" ));
$Configuration = Configuration::getInstance();
require_once (PATH_SITE."/lib/Factory.php");
?>
<?php echo Factory::printImportJsCss("js",HTTP_ROOT."/sala/assets/plugins/fixedtableheader/jquery.fixedtableheader.js");?>
<script>
    /*@Modified Diego Rivera <riveradiego@unbosque.edu.co>
     *Se configura dialog (verAvance)y se crea funcion(verEvidenciaPlan)  con el fin de cargar las evidencias acutales
     *@Since May 02,2018
     */
    $(document).ready(function(){
        $( "#verAvance" ).dialog({
            autoOpen: false,
            modal: true,
            draggable: true,
            resizable: false,
            title: "Detalle Avances Indicador",
            width: 750,
            height: 'auto',
            show: {
                effect: "blind",
                duration: 500
            },
            hide: {
                effect: "blind",
                duration: 500
            },
            open: function() {
                $buttonPane = $(this).next();
                $buttonPane.find('button').addClass('btn').addClass('btn-warning');
            }
        });
        $('[data-toggle="tooltip"]').tooltip();   
        $(".verEvidenciaPlan").click(function(){
            var idProyecto = $(this).attr("data-idProyecto");
            var indicador = $(this).attr("data-indicador");
            var accion = $(this).attr("data-accion");
            var idMeta = $(this).attr("data-idMeta");
            var periodo = $(this).attr("data-periodo");
            verEvidenciaPlan(idProyecto, indicador, accion, idMeta , periodo);
        });
        var cantidadPlan = $("#cantidadPlan").val();
        for(i=1;i<=9;i++){
            var nPlan = 0
            var acumuladorlineas = 0;
            var avanceInstitucional = 0;
            
            $( ".linea_"+i ).each( function( ) {
                    if( i == 2 || i == 3 || i== 6 ){
                        nPlan = cantidadPlan;
                        acumuladorlineas +=Number($(this).text());
                    }else{
                        nPlan=cantidadPlan-1;
                        acumuladorlineas +=Number($(this).text());
                    }
            });
       
             if( acumuladorlineas == 0 ){
                avanceInstitucional = 0;
             } else {
                 avanceInstitucional = acumuladorlineas / nPlan;
             }
             $("#linea_"+i).text(avanceInstitucional.toFixed(2));
        }
        var acumuladorTotal = 0;
        $(".lineaTotal").each(function() {
            acumuladorTotal+=Number($(this).text());
        });
        total = acumuladorTotal / 9;
        
        if( total >100 ){
            $("#promedio").css("background","Sobrepasa");
            $("#promedio").css("color","#84c3be");
            $("#promedio").attr("data-original-title","");
            $("#promedio").text(total.toFixed(2)+"%");
        }else if ( total > 75 && total < 101 ){
            $("#promedio").css("background","blue");
            $("#promedio").css("color","white");
            $("#promedio").attr("data-original-title","Muy Alto");
            $("#promedio").text(total.toFixed(2)+"%");
        }else if ( total > 50 && total <= 75 ){
            $("#promedio").css("background","green");
            $("#promedio").css("color","white");
            $("#promedio").attr("data-original-title","Alto");
            $("#promedio").text(total.toFixed(2)+"%");
        }else if ( total > 25 && total <= 50 ){
            $("#promedio").css("background","yellow");
            $("#promedio").css("color","black");
            $("#promedio").attr("data-original-title","Medio");
            $("#promedio").text(total.toFixed(2)+"%");
        }else if ( total < 26 ){
            $("#promedio").css("background","red");
            $("#promedio").css("color","white");
            $("#promedio").attr("data-original-title","bajo");
            $("#promedio").text(total.toFixed(2)+"%");
        } 
        /*@modified Diego Rivera<riveradiego@unbosque.edu.co>
        * Se agrega funcion fixedtableheader para dejar encabezado fijo en las tablas de los diferentes reportes
        *@Since  July 26,2018
        */ 
        $('.tbl1').fixedtableheader();
    });
    /*@Modified Diego RIvera <riveradiego@unbosque.edu.co>
    *Se añade parametreo $periodo a funcion con el fin de mostrar unicamente las evidencias correspondientes al año seleccionado
    *@Since May 10 ,2018
    */
    function verEvidenciaPlan( txtProyectoPlanDesarrolloId ,txtIndicadorPlanDesarrolloId , tipoOperacion , idMetaPrincipal ,periodo ){
        
         $.ajax({
            type: "POST",
            url: "../interfaz/detallePlan.php",
            dataType: "html",
            data: { txtProyectoPlanDesarrolloId : txtProyectoPlanDesarrolloId , txtIndicadorPlanDesarrolloId : txtIndicadorPlanDesarrolloId , tipoOperacion : tipoOperacion , idMetaPrincipal : idMetaPrincipal , periodo : periodo},
            success: function( data ){
                $( "#verAvance" ).html( data );
                $( "#verAvance" ).dialog( "open" );
              }
        }); 
    }
	
</script>

<style type="text/css">
    #tablatotal  tr td:last-child, #tablatotal tr th:last-child{
        border:1px dashed darkblue;
        display:none;
    }
</style>
<?php 
/*
 * Funcion para cargar tooltips con porcentajes de las metas , proyectos, programa y linea
 */

function porcentaje( $valor ){
    $ver="";
    if ( $valor  > 100) {
                    $ver ='<div data-toggle="tooltip" title="Sobrepasa el indicador"  style="background:#84c3be;color:white;text-align:center;width:55px">'.round($valor,2).'%</div>';
            } else if ( $valor  > 75 && $valor < 101) {
                    $ver ='<div data-toggle="tooltip" title="Muy alto" style="background:blue;color:white;text-align:center;width:55px">'.round($valor,2).'%</div>';
            } else if ( $valor  > 50 && $valor <= 75) {
                    $ver ='<div data-toggle="tooltip" title="Alto" style="background:green;color:white;text-align:center;width:55px">'.round($valor,2).'%</div>';
            } else if ($valor  > 25 && $valor <= 50) {
                    $ver = '<div data-toggle="tooltip" title="Medio" style="background:yellow;color:black;text-align:center;width:55px">'.round($valor,2).'%</div>';
            } else if ($valor < 26) {
                    $ver ='<div data-toggle="tooltip" title="Bajo" style="background:red;color:white;text-align:center;width:55px">'.round($valor,2).'%</div>';
            }
            return $ver;
}		
//Fin function porcentaje
?>

<style>
    a{ color:#000000 !important; }
    table {     font-family: "Tahoma", "Geneva", sans-serif;   font-size: 12px;   border-collapse: collapse; background: #F4F4F4;}
    .th {     font-size: 18px;     font-weight: normal;     padding: 8px;     background: #57A639; border-top: 4px solid #fff;    border-bottom: 1px solid #fff; color: #000; }
    .hr_programa{ color: #57A639; background-color: #57A639; height: 5px;}
    .hr_proyecto{ color: #57A639; background-color: #57A639; height: 4px;}
    .hr_indicador{ color: #57A639; background-color: #57A639; height: 3px;}
    .hr_meta{ color: #57A639; background-color: #57A639; height: 2px;}
    .hr_metaSecundaria{ color: #57A639; background-color: #57A639; height: 1px;}
</style>

<?php 
if( isset ( $_SESSION["datoSesion"] ) ){
    $user = $_SESSION["datoSesion"];
    $idPersona = $user[ 0 ];
    $luser = $user[ 1 ];
    $lrol = $user[3]; 
    $txtCodigoFacultad = $user[4];
    $persistencia = new Singleton( );
    $persistencia = $persistencia->unserializar( $user[ 5 ] );
    $persistencia->conectar( );
}

require_once '../control/ControlMeta.php';
require_once '../control/ControlIndicador.php';
require_once '../control/ControlViewPlanReporteLinea.php';
require_once '../control/ControlViewPlanDiferencia.php';
$controlPlanProgramaLinea = new ControlPlanProgramaLinea( $persistencia );
$controlLineaEstrategica = new ControlLineaEstrategica( $persistencia );
$controlIndicador = new ControlIndicador( $persistencia );
$controlMeta = new ControlMeta( $persistencia );
$controlViewPlanReporteLineas = new ControlViewPlanReporteLinea( $persistencia );
$controlViewPlanDiferencia = new ControlViewPlanDiferencia( $persistencia );
    switch($tiporeporte)
    {
      case '1':
      {
        if($periodo<>0){
    ?>
            <div class="table">
                  <table  width="1100PX" class="tbl1">
                  <thead  class="bg-success">
                      <tr>
                        <th style="width: 100px !important" class="th">Línea Estratégica</th>
                        <th style="width: 100px !important" class="th">Programa</th>
                        <th style="width: 100px !important" class="th">Proyecto</th>
                        <th style="width: 100px !important" class="th">Indicador</th>
                        <th style="width: 100px !important" class="th">Meta</th>
                        <th style="width: 100px !important" class="th">Alcance</th>
                        <th style="width: 100px !important" class="th">Avance</th>
                        <th style="width: 100px !important" class="th">Alcance<br>Avance</th>
                        <th style="width: 100px !important" class="th">Valoración</th>
                        <th style="width: 100px !important" class="th">Evidencias</th>
                      </tr>
                  </thead>
                   <tbody id="datosFacultades">  
                    <?php 
                       
                       $codigoCarrera = $carrera;
                       $numeroLineas = sizeof( $linea );
                       $nl = 1;
                       $totalLineas = $numeroLineas+1;	

                       //Tabla calcula avances por linea estrategica

                        $tr = "<table align='center' class='table table-bordered' id='tablatotal'>
                                <thead  class='bg-success'>
                                  <tr>
                                     <th class='th' colspan='2' style='!important' id='plan'>Plan de Desarrollo</th>
                                     <th></th>
                                  </tr>
                                  <tr>
                                    <th class='th' style='!important'>Linea estrategica </th>
                                    <th class='th' style='!important'>Porcentaje</th>
                                    <th></th>
                                 </tr>
                                </thead>";
                        $acumuladoTotalLinea=0;

                        foreach( $linea as $ln ){//foreach lineas
                                $acumuladorPorcentajeLinea= 0;	
                                $acumuladorPorcentajePrograma = 0;
                                $idLinea = $ln->getLineaEstrategica( )->getIdLineaEstrategica( );
                                $nombreLinea = $ln->getLineaEstrategica( )->getNombreLineaEstrategica( );
                                $porcentajeLinea = $ln->getPorcentaje();

                                $tr .='<tr><td>'.$nombreLinea.'</td>';

                                if($porcentajeLinea == '') {
                                        $porcentajeLinea = 0;
                                }

                                $programas = $controlPlanProgramaLinea->verPrograma( $facultad , $idLinea , $codigoCarrera , $periodo );

                        ?>
                        <tr>
                            <td  style="vertical-align:middle;width: 100px !important;border-bottom: 1px;">
                            <?php 
                                $Palabras_linea = explode(" ", $nombreLinea);
                                 $contadorPalabras = 0;
                                 $tool='';
                                 $programaPorcentaje="";
                                 while ($contadorPalabras <5 ){

                                        if( isset($Palabras_linea[$contadorPalabras])){
                                                $tool.=$Palabras_linea[$contadorPalabras]." ";
                                                $contadorPalabras++;
                                        }else {
                                                $contadorPalabras++;
                                        }
                                 }                                       

                                echo '<div data-toggle="tooltip" title="'.$nombreLinea.'" >'.$tool.'</div>';
                            ?>
                            </td>
                            <td colspan="11">
                                <table >
                                   <?php

                                        $npro = 1;
                                        $numeroProgramas = sizeof( $programas );
                                        $conteoProyectosPrograma = 0;
                                        foreach( $programas as $prg ){
                                                $acumuladoPorcentajeProyecto = 0;
                                                $avanceProyecto = 0;

                                                 $idPrograma = $prg->getPrograma( )->getIdProgramaPlanDesarrollo( );
                                                 $proyectos = $controlPlanProgramaLinea->verProyecto( $facultad , $idLinea , $idPrograma ,  $codigoCarrera , $periodo );
                                                 $porcentajePrograma = $prg->getPorcentaje();

                                        if($porcentajePrograma == '') {
                                                $porcentajePrograma = 0;
                                        }

                                    ?>
                                        <tr>
                                            <td style="width: 110px !important;border-bottom: 1px ;">
                                               <?php
                                                  $tool='';
                                                  $Palabras_Programa = explode(" ", $prg->getPrograma()->getNombrePrograma());
                                                  $contadorPalabras = 0;

                                                  while ($contadorPalabras < 5 ){

                                                        if( isset($Palabras_Programa[$contadorPalabras])){
                                                                $tool.=$Palabras_Programa[$contadorPalabras]." ";
                                                                $contadorPalabras++;
                                                        }else {
                                                                $contadorPalabras++;
                                                        }
                                                 }                      
                                                 echo '<div data-toggle="tooltip" title="'.$prg->getPrograma()->getNombrePrograma().'" >'.$tool.'</div>';
                                                 $programaPorcentaje=100;
                                                ?>
                                             </td>
                                             <td >
                                                <table >
                                                    <?php
                                                    $np = 1;
                                                    $numeroProyectos = sizeof( $proyectos );
                                                    $proyectoPorcentaje="";
                                                   // $acumuladoPorcentajeMeta  = 0;
                                                    foreach( $proyectos as $pry )	{//foreach proyectos
                                                            $acumuladoPorcentajeMeta  = 0;
                                                            $numeroMetasecundarias = 0;

                                                            $idProyecto = $pry->getProyecto()->getProyectoPlanDesarrolloId() ;
                                                            $nombreProyecto= $pry ->getProyecto()->getNombreProyectoPlanDesarrollo();
                                                            $porcentajeProyecto = $pry ->getPorcentaje();
                                                            $porcenjateMetaNumero = $pry->getPorcentaje();
                                                            $valorMeta = 0;
                                                                    if($porcentajeProyecto == '') {
                                                                            $porcentajeProyecto = 0;
                                                                    }

                                                    ?>
                                                    <tr>	
                                                        <td style="vertical-align:middle;width: 104px !important;border-bottom: 1px;"> 
                                                          <?php
                                                              $Palabras_Proyecto = explode(" ", $nombreProyecto);
                                                              $tool='';
                                                              $contadorPalabras = 0;
                                                                while ($contadorPalabras < 5 ){

                                                                        if( isset($Palabras_Proyecto[$contadorPalabras])){
                                                                                $tool.=$Palabras_Proyecto[$contadorPalabras]." ";
                                                                                $contadorPalabras++;
                                                                        }else {
                                                                                $contadorPalabras++;
                                                                        }
                                                                 }   
                                                              echo '<div data-toggle="tooltip" title="'.$nombreProyecto.'" >'.$tool.'</div>';
                                                              $proyectoPorcentaje = round((100/$numeroProyectos),2);
                                                          ?>
                                                         </td>	
                                                         <td>
                                                            <table>
                                                            <?php
                                                                $indicadores = $controlIndicador ->verIndicadorMeta( $idProyecto , $periodo );
                                                                $ni = 1;
                                                                $numeroIndicadores = sizeof( $indicadores );

                                                                foreach ( $indicadores as $indic ){//foreach indicadores
                                                                            $idIndicador = $indic->getIndicadorPlanDesarrolloId( );
                                                                            $nombreIndicador  =$indic->getNombreIndicador( );
                                                                            $tipoIndicador = $indic->getTipoIndicador( );
                                                                            $NombreIndicador = $indic->getNombreIndicador( );
                                                                            if($tipoIndicador == 1){

                                                                                    $tipoIndicador='Cuantitativo';
                                                                            }else{
                                                                                    $tipoIndicador='Cualitativo';
                                                                            }
                                                            ?>
                                                                <tr>
                                                                    <td style="width: 104px !important;border-bottom: 1px ;" >
                                                                    <?php 
                                                                         $Palabras_Indicador = explode(" ", $nombreIndicador);
                                                                         $tool='';
                                                                         $contadorPalabras = 0;
                                                                            while ($contadorPalabras < 5 ){

                                                                                   if( isset($Palabras_Indicador[$contadorPalabras])){
                                                                                           $tool.=$Palabras_Indicador[$contadorPalabras]." ";
                                                                                           $contadorPalabras++;
                                                                                   }else {
                                                                                           $contadorPalabras++;
                                                                                   }
                                                                            }   
                                                                        echo '<div data-toggle="tooltip" title="'.$nombreIndicador.'" >'.$tool.' <br><strong>('.$tipoIndicador.')</strong> </div>';
                                                                    ?>
                                                                     </td>
                                                                        <td style="vertical-align:middle; padding: 0 !important;border-bottom: 1px ;">
                                                                            <table >
                                                                            <?php
                                                                                $meta = $controlMeta->metaProyectoAvance( $facultad , $codigoCarrera , $idProyecto , $idIndicador , $idLinea , $idPrograma ,$periodo );
                                                                                $nm = 1;
                                                                                $numeroMetas = sizeof( $meta );


                                                                                foreach ($meta as $mt ) {

                                                                                        $idMeta = $mt->getMetaIndicadorPlanDesarrolloId( );
                                                                                        $nombreMeta = $mt->getNombreMetaPlanDesarrollo( );
                                                                                        $alcanceMeta = $mt->getAlcanceMeta( );
                                                                                        $vigenciaMeta = $mt->getVigenciaMeta( );
                                                                                        $porcentajeMeta = $mt->getPorcentaje( );
                                                                                        $indicador = $mt->getIndicador( );
                                                                                        if( $porcentajeMeta == '') {
                                                                                                $porcentajeMeta = 0;
                                                                                        }
                                                                            ?>
                                                                             <tr>
                                                                                 <td style="width: 106px !important;border-bottom: 1px ;" >
                                                                                  <?php 
                                                                                     $Palabras_Meta = explode(" ", $nombreMeta);
                                                                                     $tool='';
                                                                                     $contadorPalabras = 0;
                                                                                     while ($contadorPalabras < 5 ){

                                                                                            if( isset($Palabras_Meta[$contadorPalabras])){
                                                                                                    $tool.=$Palabras_Meta[$contadorPalabras]." ";
                                                                                                    $contadorPalabras++;
                                                                                            }else {
                                                                                                    $contadorPalabras++;
                                                                                            }
                                                                                     }   

                                                                                          echo '';echo '<div data-toggle="tooltip" title="'.$nombreMeta.'" >'.$tool.'<br>'.$vigenciaMeta.'</div>';
                                                                                           if($porcenjateMetaNumero==0){
                                                                                            $valorMeta=0;
                                                                                           }else{
                                                                                             $valorMeta = round((100/$porcenjateMetaNumero),2);
                                                                                           }
                                                                                    ?>
                                                                                     </td>
                                                                                     <td style="width: 107px !important;text-align: center;border-bottom: 1px;">
                                                                                                    <?php  
                                                                                                            if( $tipoIndicador == 'Cuantitativo' ) {
                                                                                                                    echo $alcanceMeta; 
                                                                                                            } else{
                                                                                                                    echo $alcanceMeta.'%'; 		
                                                                                                            }
                                                                                                     ?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <table>
                                                                                         <?php 
                                                                                        
                                                                                         $metaSecundarias = $controlMeta->buscarMetaSecundariaFecha( $idMeta , $periodo );
                                                                                         $nms = 1;
                                                                                         $numeroMetasecundaria = sizeof( $metaSecundarias );
                                                                                         $avance =  round((($valorMeta/100) * $porcentajeMeta),2);
                                                                                        
                                                                                         foreach ($metaSecundarias as $secundarias) {
                                                                                            
                                                                                             $nombreMetaSecundaria = $secundarias->getNombreMetaSecundaria();
                                                                                             $alcance = $secundarias->getValorMetaSecundaria();
                                                                                             $porcentajeMeta = $secundarias->getAvanceResponsableMetaSecundaria();
                                                                                             $numeroMetasecundarias = $numeroMetasecundarias + 1;
                                                                                             $valorMeta = round((100/$porcenjateMetaNumero),2);
                                                                                             if($alcance == 0){
                                                                                                 $avanceReal=0;
                                                                                             }else{
                                                                                                $avanceReal = ( $porcentajeMeta / $alcance )*100;
                                                                                             }      
                                                                                             if($avanceReal>100){
                                                                                                  $avanceReal=100;
                                                                                             }
                                                                                             if($alcance == 0){
                                                                                                 $avance=0;
                                                                                             }else{
                                                                                                $avance= ( $porcentajeMeta * 100 )/$alcance;
                                                                                             }
                                                                                            $porcentajeAvance=round((($valorMeta/100) * $avanceReal),2);
                                                                                            $acumuladoPorcentajeMeta =  $acumuladoPorcentajeMeta + $porcentajeAvance;
                                                                                            
                                                                                         ?>
                                                                                         <tr>
                                                                                             <td style="width: 105px !important;border-bottom: 1px;">
                                                                                              <?php

                                                                                                 $Palabras_MetaSecundaria = explode(" ", $nombreMetaSecundaria);
                                                                                                 $tool='';
                                                                                                 $contadorPalabras = 0;
                                                                                                 while ($contadorPalabras < 5 ){

                                                                                                    if( isset($Palabras_MetaSecundaria[$contadorPalabras])){
                                                                                                            $tool.=$Palabras_MetaSecundaria[$contadorPalabras]." ";
                                                                                                            $contadorPalabras++;
                                                                                                    } else {
                                                                                                            $contadorPalabras++;
                                                                                                    }
                                                                                                 }   
                                                                                                echo '';echo '<div data-toggle="tooltip" title="'.$nombreMetaSecundaria.'" >'.$tool.'</div>';                 
                                                                                             ?>
                                                                                             </td>
                                                                                             <td style="width: 108px !important;border-bottom: 1px;" align="center">
                                                                                                 <?php 
                                                                                                     if( $tipoIndicador == 'Cuantitativo' ) {
                                                                                                         echo $alcance;
                                                                                                     } else {
                                                                                                         echo $alcance.'%'; 		
                                                                                                     }
                                                                                                 ?>
                                                                                            </td>
                                                                                            <td style="width: 118px !important;border-bottom: 1px;"><?php echo  porcentaje($avance);?></td>
                                                                                            <td style="width: 115px !important;text-align: center;border-bottom: 1px;">
                                                                                              <a class="btn btn-warning verEvidenciaPlan" data-idProyecto="<?php echo $idProyecto; ?>" data-indicador="<?php echo $indicador; ?>" data-accion="VerEvidenciaTotal" data-idMeta="<?php echo $idMeta; ?>" data-periodo="<?php echo $periodo; ?>" ><label style="color:white">Ver</label></a>
                                                                                            </td>
                                                                                         </tr>
                                                                                         <tr>
                                                                                          <?php 
                                                                                            if( $numeroMetasecundaria == 1 or $nms == $numeroMetasecundaria ) {}else{
                                                                                          ?>
                                                                                             <td colspan="3" >
                                                                                              <hr class="hr_metaSecundaria">
                                                                                             </td>
                                                                                         </tr>
                                                                                         <?php 
                                                                                            }
                                                                                         }
                                                                                         ?>

                                                                                        </table>
                                                                                    </td>
                                                                              </tr>
                                                                              <?php 
                                                                                if( $numeroMetas == 1 or $nm==$numeroMetas) {}else{
                                                                              ?>
                                                                              <tr>
                                                                                <td colspan="8" >
                                                                                    <hr class="hr_meta">
                                                                                </td>
                                                                              </tr>
                                                                              <?php
                                                                                     $nm++;
                                                                                    }
                                                                                } // fin foreach meta
                                                                              ?>
                                                                    </table>	
                                                                    </td>	
                                                                <tr>																	
                                                                <?php 
                                                                 if( $numeroIndicadores == 1 or $ni==$numeroIndicadores) {}else{
                                                                ?>
                                                                <tr>
                                                                    <td colspan="8" >
                                                                            <hr class="hr_indicador">
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                   $ni++;
                                                                  }
                                                                }// fin foreach indicador
                                                                ?>
                                                             </table>
                                                        </td>
                                                     </tr>
                                                     <?php 
                                                      if( $numeroProyectos == 1 or $np==$numeroProyectos) {
                                                    ?>
                                                       <tr>
                                                          <td colspan="8" >
                                                            <?php 	

                                                                echo 'Avance Proyecto:</br>';
                                                                echo porcentaje( $acumuladoPorcentajeMeta );
                                                                $acumuladoPorcentajeProyecto = $acumuladoPorcentajeProyecto + $acumuladoPorcentajeMeta;
                                                                $conteoProyectosPrograma = $conteoProyectosPrograma +1;
                                                              ?>
                                                          </td>
                                                       </tr>
                                                        <?php		
                                                             }else{
                                                        ?>
                                                        <tr>
                                                            <td colspan="8" >
                                                            <?php 
                                                                $conteoProyectosPrograma = $conteoProyectosPrograma +1;	
                                                                echo 'Avance Proyecto:</br>';
                                                                echo porcentaje( $acumuladoPorcentajeMeta );
                                                                $acumuladoPorcentajeProyecto = $acumuladoPorcentajeProyecto + $acumuladoPorcentajeMeta;
                                                                 
                                                            ?>
                                                            <hr class="hr_proyecto">
                                                            </td>
                                                        </tr>
                                                        <?php 	
                                                             $np++;
                                                            }
                                                         }// fin foreach proyectos
                                                        ?>
                                                </table>
                                            </td>
                                        </tr>
                                        <?php 
                                        if( $numeroProgramas == 1 or $npro == $numeroProgramas) {
                                        ?>
                                        <tr>
                                            <td colspan="10">
                                            <?php 
                                            $valorProgramas = round((($acumuladoPorcentajeProyecto / 100) * 100) , 2 );
                                            $valorPrograma = round((($acumuladoPorcentajeProyecto / 100) * $programaPorcentaje ) , 2 );
                                            $valorP = $valorProgramas/$numeroProyectos;

                                            echo 'Avance Programa:</br>';
                                            echo porcentaje( $valorP );

                                            $acumuladorPorcentajeLinea= $acumuladorPorcentajeLinea  + $valorP;
                                            $acumuladorPorcentajePrograma = $acumuladorPorcentajePrograma + $valorProgramas;
                                            ?>
                                            </td>
                                        </tr>

                                        <?php


                                        }else{
                                        ?>
                                        <tr>
                                            <td colspan="8" ><?php 

                                                $valorProgramas = round((($acumuladoPorcentajeProyecto / 100) * 100) , 2 );
                                                $valorPrograma = round((($acumuladoPorcentajeProyecto / 100) * $programaPorcentaje ) , 2 );

                                                echo 'Avance Programa:</br>';
                                                echo porcentaje( $valorProgramas/$numeroProyectos );

                                                $valorP = $valorProgramas/$numeroProyectos;
                                                $acumuladorPorcentajeLinea= $acumuladorPorcentajeLinea  + $valorP;
                                                $acumuladorPorcentajePrograma = $acumuladorPorcentajePrograma + $valorProgramas;

                                                ?>
                                                <hr class="hr_programa">
                                            </td>
                                        </tr>
                                        <?php
                                            $npro++;
                                             }
                                         } // foreach programas
                                        ?>
                                   </table>
                                </td>							
                        </tr>

                        <?php 	
                        if( $numeroLineas == 1 or $nl==$numeroLineas) {
                        ?>
                        <tr>
                            <td colspan="11" >
                            <?php 
                                echo 'Avance Linea:</br>';
                                echo porcentaje( $acumuladorPorcentajeLinea  / $numeroProgramas);

                                $avanceTotalLinea = round(($acumuladorPorcentajeLinea  / $numeroProgramas),2);
                                $tr.='<td align="center">'.$avanceTotalLinea.'%<td></tr>';
                                $acumuladoTotalLinea=$acumuladoTotalLinea+$avanceTotalLinea;
                            ?>
                            </td>
                        </tr>
                        <?php

                        }else{
                       ?>
                        <tr>
                            <td colspan="11" >
                            <?php 
                                echo 'Avance Linea:</br>';
                                echo porcentaje( $acumuladorPorcentajeLinea / $numeroProgramas );
                                $avanceTotalLinea = round(($acumuladorPorcentajeLinea  / $numeroProgramas),2);
                                $tr.='<td align="center">'.$avanceTotalLinea.'%<td></tr>';
                                $acumuladoTotalLinea=$acumuladoTotalLinea+$avanceTotalLinea;
                            ?>
                            <hr class="hr_programa">
                            </td>
                        </tr>
                    <?php
                       $nl++;
                        }								
                     }// fin foreach linea
                    ?>

                  </tbody>
                </table>
            </div>
                <br>
            <?php
                if($numeroLineas == 0){
                        echo $tr.="<tr><td colspan='2'><p align='center'><strong>Total avance del año : 0%</strong></p></td><td></td></tr></table>";

                }else{
                $valorPlan=round(( $acumuladoTotalLinea / $numeroLineas ),2);
                         echo $tr.="<tr><td colspan='2'><p align='center'><strong>Total avance del año: ".$valorPlan."%</strong></p></td><td></td><tr></table>";
                }

        } else {
           
        ?>
	 <div class="table">
                <table  width="1020px" class="tbl1">
                    <thead  class="bg-success">
                        <tr>
                            <th style="width: 120px !important" class="th">Línea Estratégica</th>
                            <th style="width: 120px !important" class="th">Programa</th>
                            <th style="width: 120px !important" class="th">Proyecto</th>
                            <th style="width: 120px !important" class="th">Indicador</th>
                            <th style="width: 120px !important" class="th">Meta</th>
                            <th style="width: 120px !important" class="th">Alcance de la Meta</th>
                            <th style="width: 120px !important" class="th">Valoración</th>
                            <th style="width: 170px !important" class="th">Evidencias</th>
                        </tr>
                    </thead>
                    <tbody id="datosFacultades">  
                    <?php 
                    $codigoCarrera = $carrera;
                    $numeroLineas = sizeof( $linea );
                    $nl = 1;
                    $totalLineas = $numeroLineas+1;	

                    $tr = "<table align='center' class='table table-bordered' id='tablatotal'>
                           <thead  class='bg-success'>
                            <tr>
                                <th class='th' colspan='2' style='!important' id='plan'>Plan de Desarrollo</th>
                                <th></th>
                            </tr>
                            <tr>
                                <th class='th' style='!important'>Linea estrategica</th>
                                <th class='th' style='!important'>Porcentaje</th>
                                <th></th>
                            </tr>
                            </thead>";
                    $acumuladoTotalLinea=0;

                    foreach( $linea as $ln ){
                            $acumuladorPorcentajeLinea= 0;	
                            $acumuladorPorcentajePrograma = 0;
                            $idLinea = $ln->getLineaEstrategica( )->getIdLineaEstrategica( );
                            $nombreLinea = $ln->getLineaEstrategica( )->getNombreLineaEstrategica( );
                            $porcentajeLinea = $ln->getPorcentaje();
                            $tr .='<tr><td>'.$nombreLinea.'</td>';

                            if($porcentajeLinea == '') {
                                    $porcentajeLinea = 0;
                            }
                            /*Modified Diego Rivera<riveradiego@unbosque.edu.co>
                            *se añande parametro $periodo $programas = $controlPlanProgramaLinea->verPrograma( $facultad , $idLinea , $codigoCarrera ;
                            *SInce September 21,2017
                             */
                            $programas = $controlPlanProgramaLinea->verPrograma( $facultad , $idLinea , $codigoCarrera , $periodo );
                    ?>
                        <tr>
                            <td  style="vertical-align:middle;width: 120px !important;border-bottom: 1px;">
                            <?php 
                                //separa el texto de la linea por espacion en un array
                                $Palabras_linea = explode(" ", $nombreLinea);
                                //Muestra en un tooltip el texto completo y solo las primeras 5 palabras en el texto normal.
                                $contadorPalabras = 0;
                                $tool='';
                                $programaPorcentaje="";
                                while ($contadorPalabras <5 ){
                                
                                    if( isset($Palabras_linea[$contadorPalabras])){
                                           $tool.=$Palabras_linea[$contadorPalabras]." ";
                                           $contadorPalabras++;
                                    }else {
                                           $contadorPalabras++;
                                    }
                                }                                       
                               echo '<div data-toggle="tooltip" title="'.$nombreLinea.'" >'.$tool.'</div>';
                            ?>
                            </td>
                            <td colspan="8" >
                                <table >
                                    <?php
                                        $npro = 1;
                                        $numeroProgramas = sizeof( $programas );
                                        $conteoProyectosPrograma = 0;
                                        foreach( $programas as $prg ){
                                                $acumuladoPorcentajeProyecto = 0;
                                                $avanceProyecto = 0;

                                                 $idPrograma = $prg->getPrograma( )->getIdProgramaPlanDesarrollo( );
                                                 /*Modified Diego Rivera<riveradiego@unbosque.edu.co>
                                                 *se añande parametro $periodo $proyectos = $controlPlanProgramaLinea->verProyecto( $facultad , $idLinea , $idPrograma ,  $codigoCarrera);
                                                 */
                                                 $proyectos = $controlPlanProgramaLinea->verProyecto( $facultad , $idLinea , $idPrograma ,  $codigoCarrera , $periodo );
                                                 $porcentajePrograma = $prg->getPorcentaje();

                                        if($porcentajePrograma == '') {
                                                $porcentajePrograma = 0;
                                        }
                                    ?>
                                    <tr>
                                      <td style="width: 120px !important;border-bottom: 1px ;" >
                                      <?php
                                        $tool='';
                                        //separa el texto del programa por espacion en un array
                                         $Palabras_Programa = explode(" ", $prg->getPrograma()->getNombrePrograma());
                                        //Muestra en un tooltip el texto completo y solo las primeras 5 palabras en el texto normal.
                                         $tool='';
                                         $contadorPalabras = 0;
                                         while ($contadorPalabras < 5 ) {

                                                if( isset($Palabras_Programa[$contadorPalabras])){
                                                        $tool.=$Palabras_Programa[$contadorPalabras]." ";
                                                        $contadorPalabras++;
                                                }else {
                                                        $contadorPalabras++;
                                                }
                                          }                      
                                          echo '<div data-toggle="tooltip" title="'.$prg->getPrograma()->getNombrePrograma().'" >'.$tool.'</div>';
                                          $programaPorcentaje=100;
                                      ?>
                                      </td>
                                      <td >
                                        <table >
                                        <?php
                                            $np = 1;
                                            $numeroProyectos = sizeof( $proyectos );
                                            $proyectoPorcentaje="";
                                            $acumuladoPorcentajeMeta  = 0;
                                            foreach( $proyectos as $pry )	{
                                                    $acumuladoPorcentajeMeta  = 0;
                                                    $idProyecto = $pry->getProyecto()->getProyectoPlanDesarrolloId() ;
                                                    $nombreProyecto= $pry ->getProyecto()->getNombreProyectoPlanDesarrollo();
                                                    $porcentajeProyecto = $pry ->getPorcentaje();
                                                    $porcenjateMetaNumero = $pry->getPorcentaje();
                                                    $valorMeta = 0;
                                                    
                                                    if($porcentajeProyecto == '') {
                                                        $porcentajeProyecto = 0;
                                                    }

                                        ?>
                                            <tr>	
                                                <td style="vertical-align:middle;width: 120px !important;border-bottom: 1px;"> 
                                                <?php
                                                    //separa el texto del proyecto por espacion en un array
                                                    $Palabras_Proyecto = explode(" ", $nombreProyecto);
                                                    $tool='';
                                                    $contadorPalabras = 0;
                                                    while ($contadorPalabras < 5 ){
                                                           if( isset($Palabras_Proyecto[$contadorPalabras])){
                                                                   $tool.=$Palabras_Proyecto[$contadorPalabras]." ";
                                                                   $contadorPalabras++;
                                                           }else {
                                                                   $contadorPalabras++;
                                                           }
                                                    }   
                                                    echo '<div data-toggle="tooltip" title="'.$nombreProyecto.'" >'.$tool.'</div>';
                                                    $proyectoPorcentaje = round((100/$numeroProyectos),2);
                                                ?>
                                                </td>	
                                                
                                                <td>
                                                    <table>
                                                    <?php
                                                        $indicadores = $controlIndicador ->verIndicadorMeta( $idProyecto );
                                                        $ni = 1;
                                                        $numeroIndicadores = sizeof( $indicadores );
                                                        foreach ( $indicadores as $indic ){
                                                            $idIndicador = $indic->getIndicadorPlanDesarrolloId( );
                                                            $nombreIndicador  =$indic->getNombreIndicador( );
                                                            $tipoIndicador = $indic->getTipoIndicador( );
                                                            $NombreIndicador = $indic->getNombreIndicador( );
                                                            if($tipoIndicador == 1){

                                                                    $tipoIndicador='Cuantitativo';
                                                            }else{
                                                                    $tipoIndicador='Cualitativo';
                                                            }
                                                    ?>
                                                        <tr>
                                                            <td style="width: 120px !important;border-bottom: 1px ;" >
                                                            <?php 
                                                                $Palabras_Indicador = explode(" ", $nombreIndicador);
                                                                $tool='';
                                                                $contadorPalabras = 0;
                                                                while ($contadorPalabras < 5 ){

                                                                       if( isset($Palabras_Indicador[$contadorPalabras])){
                                                                               $tool.=$Palabras_Indicador[$contadorPalabras]." ";
                                                                               $contadorPalabras++;
                                                                       }else {
                                                                               $contadorPalabras++;
                                                                       }
                                                                }   
                                                             echo '<div data-toggle="tooltip" title="'.$nombreIndicador.'" >'.$tool.' <br><strong>('.$tipoIndicador.')</strong> </div>';
                                                            ?>
                                                            </td>
                                                            <td style="vertical-align:middle; padding: 0 !important;border-bottom: 1px ;">
                                                                <table >
                                                                <?php
                                                                    $meta = $controlMeta->metaProyecto( $facultad , $codigoCarrera , $idProyecto , $idIndicador , $idLinea , $idPrograma );
                                                                    $nm = 1;
                                                                    $numeroMetas = sizeof( $meta );

                                                                    foreach ($meta as $mt ) {

                                                                            $idMeta = $mt->getMetaIndicadorPlanDesarrolloId( );
                                                                            $nombreMeta = $mt->getNombreMetaPlanDesarrollo( );
                                                                            $alcanceMeta = $mt->getAlcanceMeta( );
                                                                            $vigenciaMeta = $mt->getVigenciaMeta( );
                                                                            $porcentajeMeta = $mt->getPorcentaje( );
                                                                            $indicador = $mt->getIndicador( );
                                                                            if( $porcentajeMeta == '') {
                                                                                    $porcentajeMeta = 0;
                                                                            }
                                                                ?>
                                                                    <tr>
                                                                        <td style="width: 120px !important;border-bottom: 1px ;" >
                                                                        <?php 
                                                                            $Palabras_Meta = explode(" ", $nombreMeta);
                                                                            $tool='';
                                                                            $contadorPalabras = 0;
                                                                            while ($contadorPalabras < 5 ){

                                                                                   if( isset($Palabras_Meta[$contadorPalabras])){
                                                                                           $tool.=$Palabras_Meta[$contadorPalabras]." ";
                                                                                           $contadorPalabras++;
                                                                                   }else {
                                                                                           $contadorPalabras++;
                                                                                   }
                                                                            }   
                                                                            echo '';echo '<div data-toggle="tooltip" title="'.$nombreMeta.'" >'.$tool.'<br>'.$vigenciaMeta.'</div>';
                                                                            /*
                                                                             *variable $valorMeta almace el valor equivalete de la meta con respecto al proyecto es decir si el proyecto tiene cuatro metas este se divide en 100 y genera el equivalente 
                                                                             */
                                                                            $valorMeta = round((100/$porcenjateMetaNumero),2);
                                                                        ?>  
                                                                        </td>
                                                                        <td style="width: 135px !important;text-align: center;border-bottom: 1px;">
                                                                        <?php  
                                                                            if( $tipoIndicador == 'Cuantitativo' ) {
                                                                                    echo $alcanceMeta; 
                                                                            } else {
                                                                                    echo $alcanceMeta.'%'; 		
                                                                            }
                                                                         ?>
                                                                        </td>
                                                                        <td style="width: 120px !important;border-bottom: 1px;">
                                                                        <?php 
                                                                            /*
                                                                             *Llamado de funcion que carga los div con tooltips
                                                                             */
                                                                            echo porcentaje( $porcentajeMeta );
                                                                            /*
                                                                             *fin llamado funcion 
                                                                             */								

                                                                            if($porcentajeMeta>100){
                                                                                    $porcentajeMeta=100;
                                                                            }
                                                                            $avance =  round((($valorMeta/100) * $porcentajeMeta),2);
                                                                            $acumuladoPorcentajeMeta =  $acumuladoPorcentajeMeta + $avance;
                                                                        ?>
                                                                        </td>
                                                                        <td style="width: 170px !important;text-align: center;border-bottom: 1px;"><button class="btn btn-warning btn-labeled fa fa-eye" onclick="verEvidenciaPlan('<?php echo $idProyecto ?>' , '<?php echo $indicador ?>' , 'VerEvidenciaTotal' , '<?php echo $idMeta ?>','<?php echo $periodo?>')">
                                                                          Evidencias
                                                                        </button>
                                                                        </td>
                                                                    </tr>
                                                                    <?php 
                                                                      if( $numeroMetas == 1 or $nm==$numeroMetas) {}else{
                                                                    ?>
                                                                    <tr>
                                                                        <td colspan="8" >
                                                                                <hr class="hr_meta">
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                        $nm++;
                                                                        }

                                                                    } // fin foreach meta
                                                                    ?>
                                                                </table>	
                                                            </td>	
                                                            <tr>																	
                                                            <?php 
                                                                if( $numeroIndicadores == 1 or $ni==$numeroIndicadores) {}else{
                                                            ?>
                                                            <tr>
                                                                    <td colspan="8" >
                                                                            <hr class="hr_indicador">
                                                                    </td>
                                                            </tr>
                                                            <?php
                                                                $ni++;
                                                                } 
                                                             }// fin foreach indicador
                                                            ?>

                                                    </table>
                                                </td>
                                            </tr>
                                            <?php 
                                                if( $numeroProyectos == 1 or $np==$numeroProyectos) {
                                            ?>
                                            <tr>
                                                <td colspan="8" >
                                                <?php 	
                                                    echo 'Avance Proyecto:</br>';
                                                    echo porcentaje( $acumuladoPorcentajeMeta );
                                                    $acumuladoPorcentajeProyecto = $acumuladoPorcentajeProyecto + $acumuladoPorcentajeMeta;
                                                    $conteoProyectosPrograma = $conteoProyectosPrograma +1;
                                                ?>
                                               </td>
                                            </tr>
                                            <?php		
                                               } else {
                                            ?>
                                            <tr>
                                                <td colspan="8" >
                                                <?php 
                                                    $conteoProyectosPrograma = $conteoProyectosPrograma +1;	
                                                    echo 'Avance Proyecto:</br>';
                                                    echo porcentaje( $acumuladoPorcentajeMeta );
                                                    $acumuladoPorcentajeProyecto = $acumuladoPorcentajeProyecto + $acumuladoPorcentajeMeta;
                                                ?>
                                                <hr class="hr_proyecto">
                                                </td>
                                            </tr>
                                            <?php 	
                                                 $np++;
                                                }
                                            }// fin foreach proyectos
                                            ?>
                                        </table>
                                      </td>
                                    </tr>
                                    <?php 
                                      if( $numeroProgramas == 1 or $npro == $numeroProgramas) {
                                    ?>
                                    <tr>
                                        <td colspan="8" >
                                        <?php 
                                            $valorProgramas = round((($acumuladoPorcentajeProyecto / 100) * 100) , 2 );
                                            $valorPrograma = round((($acumuladoPorcentajeProyecto / 100) * $programaPorcentaje ) , 2 );
                                            $valorP = $valorProgramas/$numeroProyectos;
                                            echo 'Avance Programa:</br>';
                                            echo porcentaje( $valorP );
                                            $acumuladorPorcentajeLinea= $acumuladorPorcentajeLinea  + $valorP;
                                            $acumuladorPorcentajePrograma = $acumuladorPorcentajePrograma + $valorProgramas;
                                        ?>
                                        </td>
                                    </tr>
                                    <?php
                                      } else {
                                    ?>
                                    <tr>
                                        <td colspan="8" >
                                        <?php 

                                            $valorProgramas = round((($acumuladoPorcentajeProyecto / 100) * 100) , 2 );
                                            $valorPrograma = round((($acumuladoPorcentajeProyecto / 100) * $programaPorcentaje ) , 2 );
                                            echo 'Avance Programa:</br>';
                                            echo porcentaje( $valorProgramas/$numeroProyectos );
                                            $valorP = $valorProgramas/$numeroProyectos;
                                            $acumuladorPorcentajeLinea= $acumuladorPorcentajeLinea  + $valorP;
                                            $acumuladorPorcentajePrograma = $acumuladorPorcentajePrograma + $valorProgramas;
                                        ?>
                                        <hr class="hr_programa">
                                        </td>
                                    </tr>
                                    <?php
                                       $npro++;
                                                            }
                                          } // foreach programas
                                    ?>
                                    </table>
                            </td>							
                    </tr>

            <?php 	
                    if( $numeroLineas == 1 or $nl==$numeroLineas) {
                            ?>
                            <tr>
                                    <td colspan="8" >
                                    <?php 
                                        echo 'Avance Linea:</br>';
                                        echo porcentaje( $acumuladorPorcentajeLinea  / $numeroProgramas);
                                        $avanceTotalLinea = round(($acumuladorPorcentajeLinea  / $numeroProgramas),2);
                                        $tr.='<td align="center">'.$avanceTotalLinea.'%<td></tr>';
                                        $acumuladoTotalLinea=$acumuladoTotalLinea+$avanceTotalLinea;
                                    ?>
                                    </td>
                            </tr>
                            <?php

                    }else{
                            ?>
                            <tr>
                                    <td colspan="8" >
                                    <?php 
                                        echo 'Avance Linea:</br>';
                                        echo porcentaje( $acumuladorPorcentajeLinea / $numeroProgramas );
                                        $avanceTotalLinea = round(($acumuladorPorcentajeLinea  / $numeroProgramas),2);
                                        $tr.='<td align="center">'.$avanceTotalLinea.'%<td></tr>';
                                        $acumuladoTotalLinea=$acumuladoTotalLinea+$avanceTotalLinea;
                                    ?>
                                    <hr class="hr_programa">
                                    </td>
                            </tr>
                            <?php
                            $nl++;
                        }								
                    }// fin foreach linea
            ?>
		    </tbody>
		</table>
	 </div>
	 <br>

        <?php
            if( $numeroLineas == 0 ){
               echo $tr.="<tr><td colspan='2'><p align='center'><strong>Total avance del plan de desarrollo :0%</strong></p></td><td></td></tr></table>";

            } else {
                $valorPlan=round(( $acumuladoTotalLinea / $numeroLineas ),2);
             echo $tr.="<tr><td colspan='2'><p align='center'><strong>Total avance del plan de desarrollo :".$valorPlan."%</strong></p></td><td></td><tr></table>";
            }
  
        }
        if(isset($idLineaReporte)){
            
        }else{
            $idLineaReporte=0;
        }
        ?> 
	  <p align="center">
             <a href="../servicio/excel.php?tiporeporte=<?php echo $tiporeporte;?>&periodo=<?php echo $periodo;?>&carrera=<?php echo $carrera;?>&facultad=<?php echo $facultad;?>&linea=<?php echo $idLineaReporte;?>" target_blank><strong>Exportar a excel:</strong><img src="../css/images/Excel.png" width="40" heigth="40"></a>
         </p>;		
    <?php
      }break;
      case '2': 
        {
	?>
        <div class="col-md-8">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Plan Desarrollo</th>
                        <th>Cumplimiento Linea Estrategica</th>
                        <th>ValoracionLinea estrategica</th>
                        <th>Cumplimiento Programa</th>
                        <th>Valoracion Programa</th>
                        <th>Cumplimiento proyecto</th>
                        <th>Valoracion proyecto</th>
                    </tr>
                </thead>
                <tbody>				
                    <tr></tr>
                </tbody>
            </table>
        </div>
	<?php
	}break;
      case '3':
	{
         if( $cmbRectoria== '1' ) {
             
            ?>
        
          <div class="table">
                <table class="tbl1">
                    <thead>
                    <!-- 
                    * @modified Diego Rivera <riveradiego@unbosque.edu.co>
                    * se agregan columnas con los nombres de los indicadores y tooltip en los titulos
                    * @since March  15, 2017 	
                    -->
                    <tr class="th">
                        <th class="th"><div data-toggle="tooltip" >Plan Desarrollo</div></th>
                        <th class="th"><div data-toggle="tooltip" title="Misión, Proyecto Educativo Institucional, Orientación Estratégica Institucional, Visión" >Misión</div></th>
                        <th class="th"><div data-toggle="tooltip" title="Planeación, Innovación, Calidad">Planeación</div></th>							
                        <th class="th"><div data-toggle="tooltip" title="Talento Humano">Talento Humano</div></th>
                        <th class="th"><div data-toggle="tooltip" title="Educación">Educación</div></th>
                        <th class="th"><div data-toggle="tooltip" title="Investigación">Investigación</div></th>
                        <th class="th"><div data-toggle="tooltip" title="Responsabilidad Social Universitaria">Responsabilidad</div></th>
                        <th class="th"><div data-toggle="tooltip" title="Éxito Estudiantil">Éxito Estudiantil</div></th>
                        <th class="th"><div data-toggle="tooltip" title="Bienestar Universitario">Bienestar Universitario</div></th>
                        <th class="th"><div data-toggle="tooltip" title="Internacionalización">Internacionalización</div></th>
                        <th class="th"><div data-toggle="tooltip" >Cumplimiento del plan</div></th>
                    </tr>
                        <!--fin modificacion -->
                    </thead>
                    <tbody id="datosplanes">
                        <?php		
                        
                        $lineasEstrategicas = $controlLineaEstrategica ->consultarLineaEstrategica();
                        $cantidadLineas = count( $lineasEstrategicas  );
                        $numeroPlanes = sizeof($PlanDesarrollo);
                        $acumuladorPorcentaje = 0;
                        $identificadorPlan = 0;
                        foreach($PlanDesarrollo as $planes)
                        { 
                        $identificadorPlan++;
                        ?>
                        <tr <?php if($identificadorPlan==1){ ?>style="display:none"<?php }?>>							
                                <td><input type="hidden" id="cantidadPlan" value="<?php echo $numeroPlanes;?>">
                               <?php echo $planes->NombrePlanDesarrollo; ?>
                               </td>
                               <?php
                               $porcentajeLinea = 0;
                               $identificador = 0;
                                foreach( $lineasEstrategicas as $lineas ){
                                    $identificador++;
                                    $ln = $lineas->getIdLineaEstrategica();
                                    $pd = $planes->PlanDesarrolloId;
                                    $idPrograma=0;
                                      if ( $periodo == 0){
                                          $valorAlcanceMeta = $controlViewPlanReporteLineas->alcanceMetasReporte( $pd , $ln );
                                      }else{
                                          $valorAlcanceMeta = $controlViewPlanReporteLineas->alcanceAvancesAnuales( $pd , $ln , $periodo );   
                                      }
                                ?>
                                <td align="center"><span class="linea_<?php echo $identificador?>">
                                   <?php 
                                  /* Modified Diego Rivera<riveradiego@unbosque.edu.co>
                                   *Se elimina foreach cambio en clase
                                   *Since august 6 ,2018 
                                   * foreach ( $valorAlcanceMeta as $va ){
                                     echo round($conteoMetas = $va->conteo,2);
                                     $porcentajeLinea=$porcentajeLinea+$conteoMetas;
                                    }*/
                                   echo  round($conteoMetas = $valorAlcanceMeta->conteo,2);
                                   $porcentajeLinea=$porcentajeLinea+$conteoMetas;
                                   ?></span>%
                                </td>
                                <?php 
                                } 
                                ?>
                                <td align="center"> 
                                   <?php
                                  $porcentaje = $porcentajeLinea/$cantidadLineas;
                                   //$avancePlan = $controlPlanProgramaLinea->verProgramasLineas( $planes->PlanDesarrolloId , null );	
                                   //foreach ( $avancePlan as $ap ) {
                                   $acumuladorPorcentaje=$acumuladorPorcentaje+$porcentaje;
                                   $porcentajePlan=round($porcentaje,2);

                                       if ( $porcentajePlan  > 100) {

                                              echo '<div data-toggle="tooltip" title="Sobrepasa el indicador"  style="background:#84c3be;color:white;text-align:center">'.round($porcentajePlan, 2, PHP_ROUND_HALF_ODD).'%</div>';

                                       } else if ($porcentajePlan  > 75 && $porcentajePlan < 101) {

                                              echo '<div data-toggle="tooltip" title="Muy alto" style="background:blue;color:white;text-align:center">'.round($porcentajePlan, 2, PHP_ROUND_HALF_ODD).'%</div>';

                                       } else if ($porcentajePlan  > 50 && $porcentajePlan <= 75) {

                                              echo '<div data-toggle="tooltip" title="Alto" style="background:green;color:white;text-align:center">'.round($porcentajePlan, 2, PHP_ROUND_HALF_ODD).'%</div>';

                                       } else if ($porcentajePlan  > 25 && $porcentajePlan <= 50) {

                                               echo '<div data-toggle="tooltip" title="Medio" style="background:yellow;color:black;text-align:center">'.round($porcentajePlan, 2, PHP_ROUND_HALF_ODD).'%</div>';

                                       } else if ($porcentajePlan  < 26) {

                                               echo '<div data-toggle="tooltip" title="Bajo" style="background:red;color:white;text-align:center;">'.round($porcentajePlan, 2, PHP_ROUND_HALF_ODD).'%</div>';
                                       }										
                                  // }
                                   ?>
                                </td>
                            </tr>
                           <tr <?php if($identificadorPlan==1){ ?>style="display:none"<?php }?>>
                               <td colspan="11">
                                       <hr class="hr_meta">
                               </td>
                           </tr>
                        <?php
                          }
                        ?>
                            <tr>
                                <td >Plan Desarrollo Institucional </td>
                                 <?php
                                 for( $i = 1; $i <= 9; $i++){
                                 ?>
                                <td align="center"><span id="linea_<?php echo $i;?>" class="lineaTotal"></span>%</td>
                                 <?php
                                 }
                                 ?>
                                    <td align="center"><span id="lineaTotal"></span>
                                    <div  id="promedio" data-toggle="tooltip"></div>
                                    <?php 
                                      $porcentajeReal = $acumuladorPorcentaje/$numeroPlanes;
                                      $porcentajePlanTotal=round($porcentajeReal,2);
                                    ?>
                                    
                                    </td>
                            </tr>
                            <tr>
                               <td colspan="11">
                                    <hr class="hr_meta">
                               </td>
                           </tr>
                    </tbody>
                </table>
          </div>	
         <p align="center">
             <a href="../servicio/excel.php?tiporeporte=<?php echo $tiporeporte;?>&periodo=<?php echo $periodo;?>" target_blank><strong>Exportar a excel:</strong><img src="../css/images/Excel.png" width="40" heigth="40"></a>
         </p>;
     
        <?php
        }
        if( $cmbRectoria== '2' ) {
        ?>
            <div class="col-md-8">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                        <th>Linea</th>
                        <th>PDI</th>
                        <th>Facultad</th>
                        <th>...</th>
                        <th>Departamentos</th>
                        <th>Cumplimiento de la linea</th>
                        <th>Valoracion de la linea</th>
                    </tr>
                  </thead>
                  <tbody id="datoslineas">
                    <tr></tr>
                  </tbody>
                </table>
            </div>
<?php
        }
       }break;
      case '4':{
          $linea = $controlViewPlanDiferencia->lineaSinAvances( $carrera );
?>
        <div class="table">
            <table  width="1020px" class="tbl1">
                <thead  class="bg-success">
                    <tr>
                        <th style="width: 120px !important" class="th">Línea Estratégica</th>
                        <th style="width: 120px !important" class="th">Programa</th>
                        <th style="width: 120px !important" class="th">Proyecto</th>
                        <th style="width: 120px !important" class="th">Indicador</th>
                        <th style="width: 120px !important" class="th">Meta</th>
                        <th style="width: 120px !important" class="th">Alcance de la Meta</th>
                    </tr>
                </thead>
                <tbody id="datosFacultades">  
                <?php 
                $numeroLineas = sizeof( $linea );//Cuenta las lineas para pintar el hr o no
                $nl = 1;//para identificar si solo existe una linea
                foreach ($linea as $ln){
                    $idLinea = $ln->getLineaEstrategicaId();
                    $nombreLinea = $ln->getNombreLineaEstrategica();
                    $programas = $controlViewPlanDiferencia->programaSinAvances( $carrera , $idLinea );
                ?>
                <tr>    
                    <td  style="vertical-align:middle;width: 120px !important;border-bottom: 1px;">
                    <?php 
                    //separa el texto de la linea por espacion en un array
                    $Palabras_linea = explode(" ", $nombreLinea);
                    //Muestra en un tooltip el texto completo y solo las primeras 5 palabras en el texto normal.
                    $contadorPalabras = 0;
                    $tool='';
                    $programaPorcentaje="";
                    while ($contadorPalabras <5 ){

                        if( isset($Palabras_linea[$contadorPalabras])){
                               $tool.=$Palabras_linea[$contadorPalabras]." ";
                               $contadorPalabras++;
                        }else {
                               $contadorPalabras++;
                        }
                    }                                       
                   echo '<div data-toggle="tooltip" title="'.$nombreLinea.'" >'.$tool.'</div>';
                    ?>
                    </td>
                    <td colspan="6" >
                        <table>
                        <?php 
                        $nPro = 1;//para identificar si existe solo un programa
                        $numeroProgramas = sizeof( $programas );//numero de programas sin avances
                        foreach( $programas as $prg ){
                          $idPrograma = $prg->getProgramaPlanDesarrolloId();
                          $nombrePrograma = $prg->getNombrePrograma();
                          $proyecto = $controlViewPlanDiferencia->proyectoSinAvances( $carrera , $idLinea , $idPrograma );
                        
                        ?>
                            <tr>
                                <td style="vertical-align:middle;width: 180px !important;border-bottom: 1px ;" >
                                <?php 
                                   $tool='';
                                   $Palabras_Programa = explode(" ", $nombrePrograma ); 
                                   $contadorPalabras = 0;
                                    while ($contadorPalabras < 5 ) {
                                        if( isset($Palabras_Programa[$contadorPalabras])){
                                            $tool.=$Palabras_Programa[$contadorPalabras]." ";
                                            $contadorPalabras++;
                                        }else {
                                            $contadorPalabras++;
                                        } 
                                    }
                                     echo '<div data-toggle="tooltip" title="'.$nombrePrograma.'" >'.$tool.'</div>';
                                     echo '<br><br><br>'
                                ?>    
                                </td>
                                <td>
                                    <table>
                                    <?php
                                    $np = 1;
                                    $numeroProyectos = sizeof( $proyecto );
                                    foreach ($proyecto as $pry ){
                                       $idProyecto = $pry->getProyectoPlanDesarrolloId();
                                       $nombreProyecto= $pry ->getNombreProyectoPlanDesarrollo();
                                    ?>
                                        <tr>
                                            <td style="vertical-align:middle;width: 160px !important;border-bottom: 1px;"> 
                                                <?php
                                                    $Palabras_Proyecto = explode(" ", $nombreProyecto);
                                                    $tool='';
                                                    $contadorPalabras = 0;
                                                    while ($contadorPalabras < 5 ){
                                                           if( isset($Palabras_Proyecto[$contadorPalabras])){
                                                                   $tool.=$Palabras_Proyecto[$contadorPalabras]." ";
                                                                   $contadorPalabras++;
                                                           }else {
                                                                   $contadorPalabras++;
                                                           }
                                                    }   
                                                    echo '<div data-toggle="tooltip" title="'.$nombreProyecto.'" >'.$tool.'</div>';
                                                ?> 
                                            </td>
                                            <td>
                                                <table>
                                                <?php 
                                                $indicadores = $controlViewPlanDiferencia->indicadorSinAvances($carrera , $idLinea , $idPrograma , $idProyecto);
                                                $ni = 1;
                                                $numeroIndicadores = sizeof( $indicadores );
                                                foreach ( $indicadores as $indic ){
                                                 $indicadorId = $indic->getIndicadorPlanDesarrolloId();
                                                 $nombreIndicadores = $indic->getIndicador();
                                                 $indicador = explode("_",$nombreIndicadores);
                                                 $tipoIndicador = $indicador[0];
                                                 $nombreIndicador =  $indicador[1];
                                                ?>
                                                    <tr>
                                                        <td style="width: 170px !important;border-bottom: 1px ;" >
                                                           <?php 
                                                                $Palabras_Indicador = explode(" ", $nombreIndicador);
                                                                $tool='';
                                                                $contadorPalabras = 0;
                                                                while ($contadorPalabras < 5 ){

                                                                       if( isset($Palabras_Indicador[$contadorPalabras])){
                                                                               $tool.=$Palabras_Indicador[$contadorPalabras]." ";
                                                                               $contadorPalabras++;
                                                                       }else {
                                                                               $contadorPalabras++;
                                                                       }
                                                                }   
                                                             echo '<div data-toggle="tooltip" title="'.$nombreIndicador.'" >'.$tool.' <br><strong>('.$tipoIndicador.')</strong> </div>'; 
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <table>
                                                            <?php
                                                                $meta = $controlViewPlanDiferencia->metaSinAvances($carrera , $idLinea , $idPrograma , $idProyecto , $indicadorId);
                                                                $nm = 1;
                                                                $numeroMetas = sizeof( $meta );
                                                                foreach ($meta as $mt){
                                                                    $nombreMeta = $mt->getMeta( );
                                                                    $alcanceMeta = $mt->getAlcanceMeta( );
                                                                    $Palabras_Meta = explode(" ", $nombreMeta);
                                                                    $tool='';
                                                                    $contadorPalabras = 0;
                                                                    while ($contadorPalabras < 5 ){

                                                                        if( isset($Palabras_Meta[$contadorPalabras])){
                                                                                $tool.=$Palabras_Meta[$contadorPalabras]." ";
                                                                                $contadorPalabras++;
                                                                        }else {
                                                                                $contadorPalabras++;
                                                                        }
                                                                    }   
                                                                ?>
                                                                <tr>
                                                                    <td style="width: 175px !important;border-bottom: 1px ;" >
                                                                        <?php
                                                                             echo '<div data-toggle="tooltip" title="'.$nombreMeta.'" >'.$tool.'</div>';
                                                                        ?>
                                                                    </td>
                                                                    <td style="width: 170px;" align="center" >
                                                                        <?php 
                                                                            echo $mt->getAlcanceMeta();
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                                  <?php 
                                                                      if( $numeroMetas == 1 or $nm==$numeroMetas) {}else{
                                                                    ?>
                                                                <tr>
                                                                    <td colspan="6" >
                                                                            <hr class="hr_meta">
                                                                    </td>
                                                                 </tr>
                                                                <?php
                                                                      }
                                                                $nm++;
                                                                }// fin foreach meta
                                                                
                                                            ?>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <?php 
                                                        if( $numeroIndicadores == 1 or $ni==$numeroIndicadores) {}else{
                                                    ?>
                                                    <tr>
                                                        <td colspan="8" >
                                                                <hr class="hr_indicador">
                                                        </td>
                                                    </tr>  
                                                    <?php 
                                                        }
                                                    ?>
                                                <?php    
                                                    $ni++;
                                                }//fin foreach indicadro
                                                ?>
                                                </table> 
                                            </td>
                                        </tr>
                                        <?php 
                                        if( $numeroProyectos == 1 or $np==$numeroProyectos) {

                                        } else {
                                        ?>
                                        <tr>
                                            <td colspan="6" >
                                                  <hr class="hr_proyecto">
                                            </td> 
                                        </tr>
                                        <?php
                                          }
                                        ?>
                                    <?php  
                                    $np++;
                                    }// fin foreach proyectos
                                    ?>
                                    </table>
                                <td>
                                
                            </tr>
                            <?php 
                            if( $numeroProgramas == 1 or $nPro == $numeroProgramas) {

                                }else{
                            ?>
                            <tr>
                                <td colspan="6" >
                                      <hr class="hr_programa">
                                </td> 
                            </tr>
                        <?php 
                            $nPro++;
                                }
                        }//fin foreach programas
                        ?>
                        </table>
                    </td>
                </tr>
                <?php 
                     if( $numeroLineas == 1 or $nl==$numeroLineas) {
                         
                     }else{
                ?>
                <tr>
                    <td colspan="6">
                        <hr class="hr_programa">
                    </td>
                </tr>
                <?php 
                     }
                ?>
                <?php 
                    $nl++;
                }// fin foreah linea
                ?>
                </tbody>
            </table>
             <p align="center">
             <a href="../servicio/excel.php?tiporeporte=<?php echo $tiporeporte;?>&carrera=<?php echo $carrera;?>" target_blank><strong>Exportar a excel:</strong><img src="../css/images/Excel.png" width="40" heigth="40"></a>
         </p>;
        </div>   
         
<?php
        }
        break;
      case '5':{
          $linea = $controlViewPlanDiferencia->lineaDiferencia( $carrera );
?>
        <div class="table">
            <table  width="1020px" class="tbl1">
                <thead  class="bg-success">
                    <tr>
                        <th style="width: 120px !important" class="th">Línea Estratégica</th>
                        <th style="width: 120px !important" class="th">Programa</th>
                        <th style="width: 120px !important" class="th">Proyecto</th>
                        <th style="width: 120px !important" class="th">Indicador</th>
                        <th style="width: 120px !important" class="th">Meta</th>
                        <th style="width: 120px !important" class="th">Alcance de la Meta</th>
                        <th style="width: 120px !important" class="th">Alcance de los Avances</th>
                    </tr>
                </thead>
                <tbody id="datosFacultades">  
                <?php 
                $numeroLineas = sizeof( $linea );//Cuenta las lineas para pintar el hr o no
                $nl = 1;//para identificar si solo existe una linea
                foreach ($linea as $ln){
                    $idLinea = $ln->getLineaEstrategicaId();
                    $nombreLinea = $ln->getNombreLineaEstrategica();
                    $programas = $controlViewPlanDiferencia->programaDiferencia( $carrera , $idLinea );
                ?>
                <tr>    
                    <td  style="vertical-align:middle;width: 145px !important;border-bottom: 1px;">
                    <?php 
                    //separa el texto de la linea por espacion en un array
                    $Palabras_linea = explode(" ", $nombreLinea);
                    //Muestra en un tooltip el texto completo y solo las primeras 5 palabras en el texto normal.
                    $contadorPalabras = 0;
                    $tool='';
                    $programaPorcentaje="";
                    while ($contadorPalabras <5 ){

                        if( isset($Palabras_linea[$contadorPalabras])){
                               $tool.=$Palabras_linea[$contadorPalabras]." ";
                               $contadorPalabras++;
                        }else {
                               $contadorPalabras++;
                        }
                    }                                       
                   echo '<div data-toggle="tooltip" title="'.$nombreLinea.'" >'.$tool.'</div>';
                    ?>
                    </td>
                    <td colspan="6" >
                        <table>
                        <?php 
                        $nPro = 1;//para identificar si existe solo un programa
                        $numeroProgramas = sizeof( $programas );//numero de programas sin avances
                        foreach( $programas as $prg ){
                          $idPrograma = $prg->getProgramaPlanDesarrolloId();
                          $nombrePrograma = $prg->getNombrePrograma();
                          $proyecto = $controlViewPlanDiferencia->proyectoDiferencia( $carrera , $idLinea , $idPrograma );
                        
                        ?>
                            <tr>
                                <td style="vertical-align:middle;width: 145px !important;border-bottom: 1px ;" >
                                <?php 
                                   $tool='';
                                   $Palabras_Programa = explode(" ", $nombrePrograma ); 
                                   $contadorPalabras = 0;
                                    while ($contadorPalabras < 5 ) {
                                        if( isset($Palabras_Programa[$contadorPalabras])){
                                            $tool.=$Palabras_Programa[$contadorPalabras]." ";
                                            $contadorPalabras++;
                                        }else {
                                            $contadorPalabras++;
                                        } 
                                    }
                                     echo '<div data-toggle="tooltip" title="'.$nombrePrograma.'" >'.$tool.'</div>';
                                     echo '<br><br><br>'
                                ?>    
                                </td>
                                <td>
                                    <table>
                                    <?php
                                    $np = 1;
                                    $numeroProyectos = sizeof( $proyecto );
                                    foreach ($proyecto as $pry ){
                                       $idProyecto = $pry->getProyectoPlanDesarrolloId();
                                       $nombreProyecto= $pry ->getNombreProyectoPlanDesarrollo();
                                    ?>
                                        <tr>
                                            <td style="vertical-align:middle;width: 145px !important;border-bottom: 1px;"> 
                                                <?php
                                                    $Palabras_Proyecto = explode(" ", $nombreProyecto);
                                                    $tool='';
                                                    $contadorPalabras = 0;
                                                    while ($contadorPalabras < 5 ){
                                                           if( isset($Palabras_Proyecto[$contadorPalabras])){
                                                                   $tool.=$Palabras_Proyecto[$contadorPalabras]." ";
                                                                   $contadorPalabras++;
                                                           }else {
                                                                   $contadorPalabras++;
                                                           }
                                                    }   
                                                    echo '<div data-toggle="tooltip" title="'.$nombreProyecto.'" >'.$tool.'</div>';
                                                ?> 
                                            </td>
                                            <td>
                                                <table>
                                                <?php 
                                                $indicadores = $controlViewPlanDiferencia->indicadorDiferencia($carrera , $idLinea , $idPrograma , $idProyecto);
                                                $ni = 1;
                                                $numeroIndicadores = sizeof( $indicadores );
                                                foreach ( $indicadores as $indic ){
                                                 $indicadorId = $indic->getIndicadorPlanDesarrolloId();
                                                 $nombreIndicadores = $indic->getIndicador();
                                                 $indicador = explode("_",$nombreIndicadores);
                                                 $tipoIndicador = $indicador[0];
                                                 $nombreIndicador =  $indicador[1];
                                                ?>
                                                    <tr>
                                                        <td style="width: 145px !important;border-bottom: 1px ;" >
                                                           <?php 
                                                                $Palabras_Indicador = explode(" ", $nombreIndicador);
                                                                $tool='';
                                                                $contadorPalabras = 0;
                                                                while ($contadorPalabras < 5 ){

                                                                       if( isset($Palabras_Indicador[$contadorPalabras])){
                                                                               $tool.=$Palabras_Indicador[$contadorPalabras]." ";
                                                                               $contadorPalabras++;
                                                                       }else {
                                                                               $contadorPalabras++;
                                                                       }
                                                                }   
                                                             echo '<div data-toggle="tooltip" title="'.$nombreIndicador.'" >'.$tool.' <br><strong>('.$tipoIndicador.')</strong> </div>'; 
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <table>
                                                            <?php
                                                                $meta = $controlViewPlanDiferencia->metaDiferencia($carrera , $idLinea , $idPrograma , $idProyecto , $indicadorId);
                                                                $nm = 1;
                                                                $numeroMetas = sizeof( $meta );
                                                                foreach ($meta as $mt){
                                                                    $nombreMeta = $mt->getMeta( );
                                                                    $alcanceMeta = $mt->getAlcanceMeta( );
                                                                    $Palabras_Meta = explode(" ", $nombreMeta);
                                                                    $tool='';
                                                                    $contadorPalabras = 0;
                                                                    while ($contadorPalabras < 5 ){

                                                                        if( isset($Palabras_Meta[$contadorPalabras])){
                                                                                $tool.=$Palabras_Meta[$contadorPalabras]." ";
                                                                                $contadorPalabras++;
                                                                        }else {
                                                                                $contadorPalabras++;
                                                                        }
                                                                    }   
                                                                ?>
                                                                <tr>
                                                                    <td style="width: 145px !important;border-bottom: 1px ;" >
                                                                        <?php
                                                                             echo '<div data-toggle="tooltip" title="'.$nombreMeta.'" >'.$tool.'</div>';
                                                                        ?>
                                                                    </td>
                                                                    <td style="width: 145px;" align="center" >
                                                                        <?php 
                                                                            echo $mt->getAlcanceMeta();
                                                                        ?>
                                                                    </td>
                                                                    <td style="width: 145px ;" align="center" >
                                                                        <?php 
                                                                            echo $mt->getDiferencia();
                                                                        ?>    
                                                                    </td>
                                                                </tr>
                                                                  <?php 
                                                                      if( $numeroMetas == 1 or $nm==$numeroMetas) {}else{
                                                                    ?>
                                                                <tr>
                                                                    <td colspan="7" >
                                                                            <hr class="hr_meta">
                                                                    </td>
                                                                 </tr>
                                                                <?php
                                                                      }
                                                                $nm++;
                                                                }// fin foreach meta
                                                                
                                                            ?>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <?php 
                                                        if( $numeroIndicadores == 1 or $ni==$numeroIndicadores) {}else{
                                                    ?>
                                                    <tr>
                                                        <td colspan="7" >
                                                                <hr class="hr_indicador">
                                                        </td>
                                                    </tr>  
                                                    <?php 
                                                        }
                                                    ?>
                                                <?php    
                                                    $ni++;
                                                }//fin foreach indicadro
                                                ?>
                                                </table> 
                                            </td>
                                        </tr>
                                        <?php 
                                        if( $numeroProyectos == 1 or $np==$numeroProyectos) {

                                        } else {
                                        ?>
                                        <tr>
                                            <td colspan="7" >
                                                  <hr class="hr_proyecto">
                                            </td> 
                                        </tr>
                                        <?php
                                          }
                                        ?>
                                    <?php  
                                    $np++;
                                    }// fin foreach proyectos
                                    ?>
                                    </table>
                                <td>
                                
                            </tr>
                            <?php 
                            if( $numeroProgramas == 1 or $nPro == $numeroProgramas) {

                                }else{
                            ?>
                            <tr>
                                <td colspan="7" >
                                      <hr class="hr_programa">
                                </td> 
                            </tr>
                        <?php 
                            $nPro++;
                                }
                        }//fin foreach programas
                        ?>
                        </table>
                    </td>
                </tr>
                <?php 
                     if( $numeroLineas == 1 or $nl==$numeroLineas) {
                         
                     }else{
                ?>
                <tr>
                    <td colspan="7">
                        <hr class="hr_programa">
                    </td>
                </tr>
                <?php 
                     }
                ?>
                <?php 
                    $nl++;
                }// fin foreah linea
                ?>
                </tbody>
            </table>
             <p align="center">
             <a href="../servicio/excel.php?tiporeporte=<?php echo $tiporeporte;?>&carrera=<?php echo $carrera;?>" target_blank><strong>Exportar a excel:</strong><img src="../css/images/Excel.png" width="40" heigth="40"></a>
            </p>;
        </div>   
         
<?php
        }
    }
?>
<div id="verAvance"></div>
<div id="verEvidencias"></div>		