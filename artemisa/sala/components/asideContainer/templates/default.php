<?php defined('_EXEC') or die;
if($variables->option=="dashBoard"){
?>
<div id="aside">
    <div class="nano">
        <div class="nano-content">

            <!-- Simple profile -->
            <div class="text-center pad-all">
                <div class="pad-ver">
                        <img src="<?php echo $imgUsuario;?>" class="img-lg img-border img-circle img-rectangulo" alt="Profile Picture">
                </div>
                <h4 class="text-lg text-overflow mar-no"><?php echo ucwords(mb_strtolower($Usuario->getNombres(),"UTF-8"))." ".ucwords(mb_strtolower($Usuario->getApellidos(),"UTF-8"));?></h4>
                <?php
                if(!empty($personalInfo["cargo"]->text)){
                    ?>
                    <p class="text-sm"><?php echo $personalInfo["cargo"]->text;?></p>
                    <?php
                }
                ?>
                <p class="text-sm"><?php echo $selectPerfil;?></p>

                <div class="pad-ver btn-group">
                    <a title="" href="https://mail.google.com/a/unbosque.edu.co" target="_blank" class="btn btn-icon btn-hover-mint fa fa-envelope icon-lg add-tooltip" data-original-title="Email" data-container="body"></a>
                    <a title="" href="https://ubosquemoodle.unbosque.edu.co/" target="_blank" class="btn btn-icon btn-hover-success fa fa-graduation-cap icon-lg add-tooltip" data-original-title="Campus virtual" data-container="body"></a>
                    <a title="" href="http://biblioteca.unbosque.edu.co/" target="_blank" class="btn btn-icon btn-hover-success fa fa-book icon-lg add-tooltip" data-original-title="Biblioteca" data-container="body"></a>
                    <?php /*/ ?><a title="" href="http://revistas.unbosque.edu.co/" target="_blank" class="btn btn-icon btn-hover-success fa fa-leanpub icon-lg add-tooltip" data-original-title="Revistas" data-container="body"></a>
                    <a title="" href="http://www.facebook.com" target="_blank" class="btn btn-icon btn-hover-primary fa fa-facebook icon-lg add-tooltip" data-original-title="Facebook" data-container="body"></a>
                    <a title="" href="http://www.twitter.com" target="_blank" class="btn btn-icon btn-hover-info fa fa-twitter icon-lg add-tooltip" data-original-title="Twitter" data-container="body"></a><?php /**/ ?>
                </div>
                
            </div>
            <hr>
            <ul class="list-group bg-trans">

                <!-- Profile Details -->
                <?php
                $nombreCarrera = $Carrera->getNombrecarrera();
                if(!empty($nombreCarrera)){
                ?>
                <li class="list-group-item list-item-sm" id="asideNombreCarrera">
                    <i class="fa fa-university fa-fw"></i> <span><?php echo $nombreCarrera; ?></span>
                </li>
                <?php  }?>
                <?php 
                foreach($personalInfo as $pi){
                    if(!empty($pi->ico)){
                        ?>
                        <li class="list-group-item list-item-sm" id="<?php if(!empty($pi->id)){echo $pi->id;} ?>" >
                            <i class="fa <?php echo $pi->ico;?> fa-fw"></i> <span><?php echo $pi->text;?></span>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
            <hr>
            <?php /*/ ?><div class="pad-hor">
                <h5>About Me</h5>
                <small class="text-thin">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</small>
            </div>
            <hr>
            <div class="text-center clearfix">
                <div class="col-xs-6">
                    <p class="h3">523</p>
                    <small class="text-muted">Likes</small>
                </div>
                <div class="col-xs-6">
                    <p class="h3">7,345</p>
                    <small class="text-muted">Friends</small>
                </div>
            </div><?php /**/ ?>
        </div>
    </div>
</div>
<?php } ?>