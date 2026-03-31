<?php 
defined('_EXEC') or die; 
$Configuration = Configuration::getInstance();
$entorno = $Configuration->getEntorno();
?>
<!--jQuery [ REQUIRED ]-->
<?php echo Factory::printImportJsCss("js",HTTP_SITE."/components/login/assets/js/login.js"); ?>
<!--Bootstrap Validator [ OPTIONAL ]-->
<?php echo Factory::printImportJsCss("js",HTTP_SITE."/assets/plugins/bootstrap-validator/bootstrapValidator.min.js"); ?>
<script type="text/javascript">
var lanzarAlerta = <?php echo (!empty($clavereq2) && ($clavereq2=="SEGCLAVE"))?"true":"false"; ?>
</script>
<!-- BACKGROUND IMAGE -->
<!--===================================================-->
<div id="bg-overlay" class="bg-img img-acceso"></div>

<div id="page-alert"></div>
<!-- HEADER -->
<!--===================================================-->
<div class="cls-header cls-header-lg">
    <div class="cls-brand">
        <a class="box-inline" href="<?php echo HTTP_SITE; ?>/">
            <?php 
            if($entorno!=="produccion"){
                ?>
                <span class="text-center text-4x text-warning glow">Entorno <span class="text-thin"><?php echo $entorno; ?></span></span>
                <?php
            }else{
                ?>
                <img src="<?php echo HTTP_SITE;?>/assets/images/Logotipo_Login.png" class="img-responsive" />
                <?php
            }
            ?>
        </a>
    </div>
</div>
<!--===================================================-->

<!-- LOGIN FORM -->
<!--===================================================-->
<div class="cls-content">
    <div class="cls-content-sm panel">
        <div class="panel-body">
            <?php /*/ ?><p class="pad-btm">Sign In to your account</p><?php /**/ ?>
            <form action="index.php" id="login-form" method="post" novalidate="novalidate">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-user"></i></div>
                        <input type="text" name="login" id="login" class="form-control" placeholder="Nombre de usuario" <?php if(@$clavereq2=='SEGCLAVE'){ echo "disabled";}?> value="<?php echo @$MM_Username; ?>" autocomplete="off" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                        <input type="password" name="clave" id="clave" class="form-control" placeholder="<?php echo (@$clavereq2=='SEGCLAVE')?"Segunda contraseña":"Contraseña";?>" autocomplete="off" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-8 text-left">
                        <a class="btn btn-danger btn-labeled fa  fa-user-times btn-login" id="cambiarDeUsuario" style="display: <?php echo (!empty($clavereq2) && ($clavereq2=="SEGCLAVE"))?"":"none"; ?> ;" >Cambiar de usuario</a>
                    </div>
                    <div class="col-xs-4">
                        <div class="form-group text-right">
                            <button class="btn btn-warning btn-labeled fa fa-sign-in btn-login" type="submit" id="login_btn" disabled="disabled">Entrar</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="">
                <a href="http://openldap.unbosque.edu.co/gapps/google/gaas/recuperacion.php" class="btn-link forgot">He olvidado mi contraseña</a>
                <a href="https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/creacionusuariopadre/recuperacionclaveusuariopadre.php" class="btn-link mar-lft forgot">PADRES - Modificar contraseña</a>
            </div>
        </div>
    </div>
</div>
<!--===================================================-->