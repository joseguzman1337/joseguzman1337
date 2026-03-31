<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');

   include("../templates/templateObservatorio.php");
     if($tipo=='PS'){
       $tit='Seguimiento<br>Psicol&oacute;gico';
   }else if($tipo=='PF'){
       $tit='Seguimiento<br>Financiero';
   }else if($tipo=='TU'){
       $tit='Seguimiento<br>Tutor&iacute;as';
   }
   $db =writeHeader($tit,true,"seguimiento",1);
   
 $tipo=$_REQUEST['tipo'];
 
 $red1=''; $red2='';
 if ($tipo=='PS'){
     $red1='listar_riesgo_psicologico.php?tipo=R';
     $red2='listar_riesgo_psicologico.php?tipo=P';
 }
 
 if ($tipo=='PF'){
     $red1='listar_riesgo_financiero.php?tipo=R';
     $red2='listar_riesgo_financiero.php?tipo=P';
 }
 
  if ($tipo=='TU'){
     $red1='listar_riesgo_academico.php?tipo=R';
     $red2='listar_riesgo_academico.php?tipo=P';
 }
  
//echo $red1.'<br>'.$red2;
  
?>
<script>
    function redirec(url){
        window.location.href=url;
    }
  </script>
    <style>
        
    .roundedOne {
            width: 28px;
            height: 28px;
            background: #fcfff4;

            background: -webkit-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
            background: -moz-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
            background: -o-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
            background: -ms-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
            background: linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fcfff4', endColorstr='#b3bead',GradientType=0 );
            margin: 20px auto;

            -webkit-border-radius: 50px;
            -moz-border-radius: 50px;
            border-radius: 50px;

            -webkit-box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0,0,0,0.5);
            -moz-box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0,0,0,0.5);
            box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0,0,0,0.5);
            position: relative;
    }

    .roundedOne label {
            cursor: pointer;
            position: absolute;
            width: 20px;
            height: 20px;

            -webkit-border-radius: 50px;
            -moz-border-radius: 50px;
            border-radius: 50px;
            left: 4px;
            top: 4px;

            -webkit-box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,1);
            -moz-box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,1);
            box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,1);

            background: -webkit-linear-gradient(top, #222 0%, #45484d 100%);
            background: -moz-linear-gradient(top, #222 0%, #45484d 100%);
            background: -o-linear-gradient(top, #222 0%, #45484d 100%);
            background: -ms-linear-gradient(top, #222 0%, #45484d 100%);
            background: linear-gradient(top, #222 0%, #45484d 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#222', endColorstr='#45484d',GradientType=0 );
    }

    .roundedOne label:after {
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
            filter: alpha(opacity=0);
            opacity: 0;
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            background: #00bf00;

            background: -webkit-linear-gradient(top, #00bf00 0%, #009400 100%);
            background: -moz-linear-gradient(top, #00bf00 0%, #009400 100%);
            background: -o-linear-gradient(top, #00bf00 0%, #009400 100%);
            background: -ms-linear-gradient(top, #00bf00 0%, #009400 100%);
            background: linear-gradient(top, #00bf00 0%, #009400 100%);

            -webkit-border-radius: 50px;
            -moz-border-radius: 50px;
            border-radius: 50px;
            top: 2px;
            left: 2px;

            -webkit-box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0,0,0,0.5);
            -moz-box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0,0,0,0.5);
            box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0,0,0,0.5);
    }

    .roundedOne label:hover::after {
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=30)";
            filter: alpha(opacity=30);
            opacity: 0.3;
    }

    .roundedOne input[type=checkbox]:checked + label:after {
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
            filter: alpha(opacity=100);
            opacity: 1;
    }

    input[type=checkbox] {
            visibility: hidden;
    }
</style>
    <form action="save.php" method="post" id="form_test">
        <br>
        <br>
        <br>
        <br>
        <table border="0" class="CSSTableGenerator" width="50%" align="center" >
            <tr>
                <td height="21"><center><b>Ver Estudiantes Remitidos</b></center></td>
              <td><center><b>Ver Estudiantes Atendidos</b></center></td>
          </tr>
            <tr>
                <td height="116"><center><b>
                        <div class="roundedOne">
                               <input type="checkbox" value="1" class="roundedOne" id="remision_psicologica1" onclick="redirec('<?php echo $red1 ?>')" name="remision_psicologica1"  />
                               <label for="remision_psicologica1"></label>
                </div>
                </b>
                </center></td>
                <td><center><b>
                        <div class="roundedOne">
                               <input type="checkbox" value="1" class="roundedOne" id="remision_psicologica2" onclick="redirec('<?php echo $red2 ?>')" name="remision_psicologica2"  />
                               <label for="remision_psicologica2"></label>
                </div></b></center></td>
            </tr>
        </table>
        <br>
        <a href="../tablero/index.php" class="submit" tabindex="4">Tablero de Mando</a>
    </form>
        
    
<?php    writeFooter();
        ?>  

