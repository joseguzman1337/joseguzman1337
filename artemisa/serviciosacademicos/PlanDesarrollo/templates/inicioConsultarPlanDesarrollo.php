
    <script src="../js/MainConsultar.js"></script>
    <div align="right">
        <a href="#" id="btnRegresarConsultar"><img src="../css/images/arrow_leftAzul.png" class="imgCursor" height="20" width="20" /><strong >Regresar al menu</strong></a>
    </div>
        <br />
    <style>
        .active {
                 font-weight:bold;
                }

     </style>

<?php 
    require_once('../control/ControlMenusPlandesarrollo.php');

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
     $controlPrograma = new ControlPrograma( $persistencia );
     $controlProyecto = new ControlProyecto( $persistencia );
     $controlCarrera = new ControlCarrera( $persistencia );
     $controlMenus = new ControlMenusPlandesarrollo( $persistencia );	
?>

<!-- Script para mostrar menu activo y rotar icono -->
 <script type="text/javascript">
  $(document).ready(function(){
	$(".ln").click(function() { 
	$(this).find('.fa').toggleClass('fa-rotate-90'); 
	$(this).toggleClass('active'); 
  	});
  	
  	$(".iniciopagina").click(function(){
  		   $("html, body").animate({ scrollTop: 0 }, 600);
            return false;
  	});
  });
	
 </script>

<?php
    /*
     * @modified Diego Rivera <riveradiego@unbosque.edu.co>
     * Se cambian las listas deplegalbles por menu acordion 
     * @since  Febraury 17, 2017
     */
?>		  

<div class="container"style="min-height: 700px">
	
    <fieldset class="well">
    <legend class="the-legend">Plan de desarrollo</legend>
    <div class="row">
        <div class="col-md-3" >
        <?php 
             echo $menu=$controlMenus->consultarMenu( );
        ?>
        </div>

        <div class="col-md-9">
            <fieldset class="well">
            <legend class="the-legend">Detalle plan de desarrollo</legend>
            <div id="dvTablaConsultarPlan" class="row" style="overflow: auto; top: 0px; height: 100%; display: none" >
                <div id="DivConsultarPlan" class="col-sm-12 col-md-12" style="padding:0 !important;"></div>
            </div>
            <div id="detallePlan"></div>
            <div id="actualizaPlan"></div>   
            <div id="verAvance"></div>
            <div id="verEvidencias"></div>

            </fieldset>     
        </div>
    </div>
    </fieldset> 
	
</div>
<!-- fin modificacion-->
