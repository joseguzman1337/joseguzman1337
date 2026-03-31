<?php 
session_start();
/*error_reporting(E_ALL);
ini_set('display_errors', '0');*/
function writeHeader($title, $bd=false, $proyecto="",$encabe=null,$modulo=null,$db='',$ruta='../') {  
    if(!isset ($_SESSION['MM_Username'])){
         echo "No session activa";
         exit();
    } 
if($bd){
   
    $db = writeHeaderBD();
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=9" >
        <title><?php echo $title; ?></title>
        <style type="text/css" title="currentStyle">
                @import "<?php echo $ruta; ?>../css/demo_page.css";
                @import "<?php echo $ruta; ?>../css/demo_table_jui.css";
                @import "<?php echo $ruta; ?>../css/demos.css";
                @import "<?php echo $ruta; ?>data/media/css/themes/smoothness/jquery-ui-1.8.4.custom.css";
                @import "<?php echo $ruta; ?>../css/jquery-ui.css";
                @import "<?php echo $ruta; ?>css/styleObservatorio.css";
                @import "<?php echo $ruta; ?>data/media/css/ColVis.css";
                @import "<?php echo $ruta; ?>data/media/css/TableTools.css";
                @import "<?php echo $ruta; ?>data/media/css/jquery.modal.css";
                @import "<?php echo $ruta; ?>data/media/css/ColReorder.css";
                @import "<?php echo $ruta; ?>js/fancybox/jquery.fancybox.css?v=2.1.5";
                
        </style>
        <link href="<?php echo $ruta.'css/jquery.akordeon.css'; ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo $ruta.'css/smart_tab.css'; ?>" rel="stylesheet" type="text/css" />
       <script type="text/javascript" language="javascript" src="<?php echo $ruta.'js/jquery.js'; ?>"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $ruta.'js/jquery.dataTables.js'; ?>"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $ruta.'js/jquery-ui-1.8.21.custom.min.js'; ?>"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $ruta.'js/jquery.fastLiveFilter.js'; ?>"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $ruta.'js/jquery-ui-timepicker-addon.js'; ?>"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $ruta.'js/nicEdit-latest.js'; ?>"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $ruta.'js/functions.js'; ?>"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $ruta.'js/jquery.numeric.js'; ?>"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $ruta.'js/jtip.js'; ?>"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $ruta.'data/media/js/jquery.dataTables.js'; ?>"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo $ruta.'data/media/js/ColVis.js'; ?>"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo $ruta.'data/media/js/ZeroClipboard.js'; ?>"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo $ruta.'data/media/js/TableTools.js'; ?>"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo $ruta.'data/media/js/jquery.modal.js'; ?>"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo $ruta.'data/media/js/ColReorder.js'; ?>"></script>
        <script type="text/javascript" charset="utf-8" src="<?php echo $ruta.'data/media/js/FixedColumns.js'; ?>"></script>
        <script src="<?php echo $ruta.'js/jquery.akordeon.js'; ?>" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo $ruta.'js/jquery.smartTab.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo $ruta.'js/fancybox/jquery.fancybox.js?v=2.1.5'; ?>"></script>
        <link rel="stylesheet" href="<?php echo $ruta.'tablero/css/normalize.css'; ?>"></link>
        <link rel="stylesheet" href="<?php echo $ruta.'tablero/css/main.css'; ?>"></link>
        <link href='http://fonts.googleapis.com/css?family=Fjalla+One' rel='stylesheet' type='text/css'></link>
</head>
    <body id="dt_example" class="mando">
        <?php if($encabe!=null){ 
              $sql="SELECT * 
            FROM obs_usuarios_roles 
            INNER JOIN usuario on (numerodocumento=cedula_usuario)
            where modulo='".$modulo."' and usuario='".$_SESSION['MM_Username']."' and codigoestado=100 ";
            // echo $sql;
            $dataS2 = $db->Execute($sql);
              foreach($dataS2 as $val){
                 $roles['ver']=$val['ver']; 
                 $roles['editar']=$val['editar']; 
                 $roles['eliminar']=$val['eliminar'];
                 $roles['consultar']=$val['consultar'];
              }
            $tRoles=$roles['ver']+$roles['editar']+$roles['eliminar']+$roles['consultar'];
            if($tRoles>1){
                //$tUser='Usuario Administrador';
                $tUser='';
            }else if($tRoles==1){
                $tUser='Usuario Consulta';
            }else{
                $tUser='';
            }
            ?>
        <div id="encabezado" style=" color: #FFFFFF; line-height: 1em; font-family:'Fjalla One',sans-serif">
			<div class="cajon">
				<div style=" margin-left: 100px; color:#E5D912; line-height: 1.2em; font-size: 30px">
					<div><?php echo $title ?></div>
				</div>
				<div style=" margin-left: 20px; line-height: 1em; font-size: 70px;   ">
                                    &Eacute;xito Estudiantil
				</div>
			</div>
                        <div>
                            <a href="<?php echo $ruta; ?>tablero/index.php"><img style=" margin-left: 100px;" src="<?php echo $ruta; ?>tablero/img/inicio2.png"   width="70" height="70"/></a>
                        </div>
		</div>
        <?php if(!empty($tUser)){ ?>
                <div style="width: 430px; "><img src="<?php echo $ruta; ?>interfaz/img/user.png" width="20" height="20" /><b><?php echo $tUser ?></b></div>
        <?php }
        
            } ?>
        
        <div>
<?php if($bd){ return $db; } 
}

function writeFooter() { ?>
       </div>
    </body>
</html>
<?php } 


function writeHeaderBD() { 
    $ruta = "../";
    while (!is_file($ruta.'Connections/sala2.php'))
    {
        $ruta = $ruta."../";
		//echo $ruta.'Connections/sala2.php <br/><br/>';
    }
    require($ruta.'Connections/sala2.php');
    //var_dump (is_file(dirname( realpath( __FILE__ ) ).'/../ManagerEntity.php'));die;
    $rutaado = $ruta."funciones/adodb/";
    require_once($ruta.'Connections/salaado.php');
    require_once(dirname(  __FILE__  ).'/../ManagerEntity.php');
    
    //echo '<pre>';print_r($db);die;
    $ruta = "../";
 
    return $db;
}

function writeHeaderSearchs() {     
    return writeHeaderBD();
}



?>