<?php 
defined('_EXEC') or die; 
?>

<div class="row">
    <div class="col-lg-8"> 
        <!--Banner para la Autoevalucion de asignaturas por parte de los docentes -->
        <?php         
        if(!empty($banner)){
        ?>
        <div class="panel panel-bordered">
            <div class="panel-heading">
                <h3 class="panel-title">Auto Evaluacion Docente</h3>
            </div>
            <div class="panel-body">                                       
                <div class="row">
                    <a href="<?php echo $banner['UrlEncuesta']; ?>" target="_blank">
                        <img class="img-responsive" src="<?php echo HTTP_ROOT."/".$banner['imagen'];?>"/>
                    </a> 
                </div>               
            </div>
        </div>
        <?php 
        }       
        if(isset($encuestas)){
            if(count($encuestas) > 0){
               $c = 1;
               echo Factory::printImportJsCss("js",HTTP_SITE."/components/dashBoard/assets/js/encuesta.js");
            ?> 
            <div class="panel-group accordion" id="accordion">
                <input type="hidden" id="obligatoria" name="obligatoria" value="<?php if(isset($obligatoria)){echo $obligatoria;}?>">
                <?php
                foreach($encuestas as $puesto){         
                    if(isset($puesto['encuestavalue'])){            
                        if(!empty($puesto['encuestavalue']) || $puesto['encuestavalue'] > 0){
                            $collapseId = "collapse_".$c;
                            $claseColor = "";
                            if($puesto['obligatoria']== 1){
                                $claseColor = "info";
                            }else{
                                $claseColor = "info";
                            }
                            ?>
                            <div class="panel panel-bordered panel-<?php  echo $claseColor; ?>">                                
                                <div class="panel-heading">
                                    <input type="hidden" data-typeId="<?php echo $puesto['encuestavalue'];?>" id="tipoencuesta" name="tipoencuesta" value="<?php echo $puesto['categoria'];?>">                                                                        
                                    <input type="hidden" id="documento" name="documento" value="<?php echo $puesto['documento'];?>">
                                    <h2 class="panel-title">
                                        <a data-parent="#accordion" data-toggle="collapse" href="#<?php echo $collapseId; ?>"><b>
                                            <?php echo $puesto['encuestamsg'];?></b>
                                        </a>
                                    </h2>
                                </div>
                                <div class="panel-collapse collapse <?php if($c== 1){echo 'in';} ?>" id="<?php echo $collapseId; ?>">
                                    <div class="panel-body">
                                        <div class="col-md-12">
                                            <div class="alert alert-success fade in">    
                                                <?php 
                                                if($puesto['categoria'] === 'EDOCENTES' ){
                                                    ?> <h3>Buscamos fortalecer tu proceso de enseñanza y aprendizaje, 
                                                    por eso te pedimos que evalúes todas tus asignaturas cursadas este semestre</h3>
                                                    <?php  
                                                }
                                                if($puesto['categoria'] === 'OTRAS' ){
                                                    ?> <p>La autoevaluación es un proceso de reflexión interna, de autoestudio colectivo, 
                                                        que permite detectar oportunidades de mejora en aquello que la Universidad quiere hacer, lo que hace, 
                                                        la forma en que controla que lo está logrando y su capacidad de cambio e innovación.<br><br>
                                                        Este cuestionario tiene como fin obtener información actualizada sobre 
                                                        algunos aspectos de la Universidad y del programa académico.</p>
                                                    <?php  
                                                }
                                                if($puesto['categoria'] === 'BIENESTAR' ){
                                                    ?> <p>BIENESTAR</p>
                                                    <?php  
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="list-group bord-no">
                                                    <ul class="list-group" id="evaluacion" data-id="<?php echo $puesto['encuestavalue'];?>">
                                                        <?php 
                                                        if($puesto['categoria'] === 'EDOCENTES' ){
                                                            $count = count($puesto['grupo']);
                                                            for($o=0;$o<$count;$o++){                                    
                                                                if($puesto['estadogrupo'][$o] == 'pendiente'){
                                                                    ?>  
                                                                    <li onclick="InicarEncuesta(this)" 
                                                                        data-mat="<?php echo $puesto['grupo'][$o];?>" 
                                                                        data-est="<?php echo $_SESSION['codigo'];?>" 
                                                                        data-doc="<?php echo $puesto['documento'];?>" 
                                                                        data-cat="<?php echo $puesto['categoria'];?>" 
                                                                        data-id="<?php echo $puesto['encuestavalue'];?>" 
                                                                        class="list-group-item list-item-sm" 
                                                                        value="<?php echo $puesto['idgrupo'][$o];?>">
                                                                        <a class="btn btn-danger btn-rounded">
                                                                            <?php echo $puesto['grupo'][$o]; ?>  
                                                                            <i class="fa fa-group fa-2x"></i>
                                                                        </a>
                                                                    </li>
                                                                    <?php
                                                                }else{
                                                                    ?> 
                                                                    <li class="list-group-item list-item-sm" value="0" >
                                                                        <a class="btn btn-success btn-rounded">
                                                                            <?php echo $puesto['grupo'][$o]; ?> 
                                                                            <i class="fa fa-check fa-2x"></i>
                                                                        </a>
                                                                    </li>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        if($puesto['categoria'] === 'OTRAS' || $puesto['categoria'] === 'BIENESTAR'){
                                                           ?>
                                                            <li onclick="InicarEncuesta(this)" 
                                                                data-est="<?php echo $_SESSION['codigo'];?>" 
                                                                data-doc="<?php echo $_SESSION['documento'];?>" 
                                                                data-cat="<?php echo $puesto['categoria']; ?>" 
                                                                data-id="<?php echo $puesto['encuestavalue'];?>" 
                                                                class="list-group-item list-item-sm" value="1">
                                                                <a class="btn btn-danger btn-rounded">                                                                    
                                                                    <i class="fa fa-group fa-2x"></i>
                                                                </a>
                                                            </li>                                                            
                                                            <?php
                                                        }
                                                    ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">&nbsp;</div>
                            </div>
                            <?php 
                            $c++;
                        }
                    }
                }
                ?>
            </div>
            <?php
            }
        }
        ?>
        <?php
        $idPerfil = Factory::getSessionVar('idPerfil');
        //$idVotacion = @$Votacion->getIdvotacion();
        if(!empty($horario)){
            ?>
            <div class="panel">
                <!--<div class="panel-media">
                    <img src="../../../assets/img/av1.png" class="panel-media-img img-circle img-border-light" alt="Profile Picture">
                    <div class="row">
                        <div class="col-lg-7">
                            <h3 class="panel-media-heading">Stephen Tran</h3>
                            <a href="#" class="btn-link">@stephen_doe</a>
                            <p class="text-muted mar-btm">Web and Graphic designer</p>
                        </div>
                        <div class="col-lg-5 text-lg-right">
                            <button class="btn btn-sm btn-primary">Add Friend</button>
                            <button class="btn btn-sm btn-mint btn-icon fa fa-envelope icon-lg"></button>
                        </div>
                    </div>
                </div>-->
            <?php
                echo $horario;
            ?>
            </div> 
            <?php
        }
        ?>
        <?php
        if(!empty($historicoNotas)){
            echo $historicoNotas;
        }
        ?>
        
        <!-- Calendar placeholder-->
        <!-- ============================================ -->
        <?php echo $calendario?>
        <!-- ============================================ --> 
</div>
    <div class="col-lg-4">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Eventos</h3>
            </div>
            <div class="panel-body" id="EventoDinamico">
                <i class="fa fa-spinner fa-pulse fa-3x"></i> Cargando...
            </div>
        </div>
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Conéctate con la UEB</h3>
            </div>
            <div class="panel-body bs-dashDoard-btn">
                <a title="" href="https://www.facebook.com/universidadelbosque" target="_blank" class="btn btn-labeled btn-primary btn-hover-primary fa fa-facebook icon-lg add-tooltip" data-original-title="Facebook" data-container="body">
                    <span class="hidden-xs">Facebook</span>
                </a>
                <a title="" href="https://www.linkedin.com/edu/universidad-el-bosque-11599" target="_blank" class="btn btn-labeled btn-info btn-hover-info fa fa-linkedin icon-lg add-tooltip" data-original-title="Linkedin" data-container="body">
                    <span class="hidden-xs">Linkedin</span>
                </a>
                <a title="" href="https://www.instagram.com/uelbosque" target="_blank" class="btn btn-labeled btn-warning btn-hover-warning fa fa-instagram icon-lg add-tooltip" data-original-title="Instagram" data-container="body">
                    <span class="hidden-xs">Instagram</span>
                </a>
                <a title="" href="https://twitter.com/UElBosque" target="_blank" class="btn btn-labeled btn-info btn-hover-info fa fa-twitter icon-lg add-tooltip" data-original-title="Twitter" data-container="body">
                    <span class="hidden-xs">Twitter</span>
                </a>
            </div>
        </div>
    </div>
</div>
    <!--===================================================-->
    <!--===================================================-->
 

<?php echo Factory::printImportJsCss("js",HTTP_SITE."/components/dashBoard/assets/js/dashBoard.js"); 