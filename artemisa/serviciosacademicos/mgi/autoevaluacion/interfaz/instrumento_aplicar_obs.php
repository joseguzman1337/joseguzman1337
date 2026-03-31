<?php
/*
 *  Ivan Dario quintero Rios
 *  junio 15 del 2018
 *  ajuste para google analitys
 */
    error_reporting(E_ALL);
    ini_set('display_errors', '0');

    session_start();

    //echo '<pre>';print_r($_SESSION);

    /*if(!isset ($_SESSION['MM_Username'])){
      echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesi贸n en el sistema</strong></blink>';
      exit();
    }*/

    $Ver    = $_REQUEST['Ver'];

    if(!$_REQUEST['n']){
        if($Ver==1){
            include_once ('EntradaRedireccion_Class.php');   $C_EntradaRedirecion  = new EntradaRedirecion();
        }
    }

   //var_dump (is_file('EntradaRedireccion_Class.php'));die;
   include("../../templates/templateAutoevaluacion.php");
   $db =writeHeader("Instrumento",true,"Autoevaluacion");
   $id_instrumento= $_REQUEST['id_instrumento'];

   //echo '<pre>';print_r($_SESSION);
   //idusuariofinalentradaentrada
   //sesion_idestudiantegeneral
   //codigoperiodosesion

   if(!$_SESSION['idusuariofinalentradaentrada']){

        $userid = $_REQUEST['Userid'];
   }else{

    $userid            = $_SESSION['idusuariofinalentradaentrada'];

   }



   if($_SESSION['MM_Username']=='estudiante'){

   $Estudiante_Gene   = $_SESSION['sesion_idestudiantegeneral'];

   $query_periodo = "SELECT * FROM usuario u INNER JOIN estudiantegeneral e ON e.numerodocumento=u.numerodocumento AND u.idusuario='".$userid."'";

   }else{

    $Estudiante_Gene = '';

     $query_periodo = "SELECT * FROM usuario u WHERE u.idusuario='".$userid."'";

   }

   //echo '<br>'.$query_periodo;

   if($DataUsuer=&$db->Execute($query_periodo)===false){
        echo 'error en el sql de datos de Usuario....<br><br>'.$query_periodo;
        die;
      }

   $CodigoPeriodo     = $_SESSION['codigoperiodosesion'];
   //echo 'User_id->'.$userid;





 // echo '<pre>';print_r($D_User);

  $UserName  = $DataUsuer->fields['usuario'];

   $Tipo_user = $DataUsuer->fields['codigorol'];

   /**********************************/
    $SQL_B='SELECT

            obligar

            FROM

            siq_Apublicoobjetivo

            WHERE

            idsiq_Apublicoobjetivo="'.$id_instrumento.'"
            AND
            codigoestado=100';

        if($Bienvenida=&$db->Execute($SQL_B)===false){
            echo 'Error en el SQl ....<br><br>'.$SQL_B;
            die;
        }
		
			
   /***********************************/

  if(!$_REQUEST['n']){

       if($Ver==1){

          $C_Data  = $C_EntradaRedirecion->ValidadInfo($id_instrumento,$userid,$Tipo_user,$Estudiante_Gene);

          $Disabled = '';

        }else{

          $C_Data=1;

          $Disabled = 'disabled="disabled"';
        }
   }else{

        $C_Data=1;
        $Disabled = '';

   }
   //echo '<pre>';print_r($C_Data);
   //$C_Data=1;

   // echo '<pre>';print_r($_SESSION);

   if($C_Data==1){//if Permiso

   $secc=$_REQUEST['secc'];
  // $preg=funciones();

  if($_SESSION['MM_Username']=='estudiante'){

    $userid = $_SESSION['idusuariofinalentradaentrada'];
  }else{
    $entity = new ManagerEntity("usuario");
    $entity->sql_select = "idusuario";
    $entity->prefix ="";
    $entity->sql_where = " usuario='".$_SESSION['MM_Username']."' ";
    //$entity->debug = true;
    $data = $entity->getData();
    $userid = $data[0]['idusuario'];
    }


  if (!empty($id_instrumento)){
    $entity = new ManagerEntity("Ainstrumentoconfiguracion");
    $entity->sql_where = "idsiq_Ainstrumentoconfiguracion= $id_instrumento";
    //$entity->debug = true;
    $data = $entity->getData();
    $data =$data[0];
    $tipo=$data['idsiq_discriminacionIndicador'];
    $tipoProg=$data['codigocarrera'];

    $entity1 = new ManagerEntity("Ainstrumento");
    $entity1->sql_where = "idsiq_Ainstrumentoconfiguracion= $id_instrumento";
   // $entity->debug = true;
    $data1 = $entity1->getData();
    $data1 =$data1[0];
  }
  
  if(empty($_SESSION['MM_Username'])){
    $sql_use="SELECT * 
                FROM siq_Apublicoobjetivocsv AS c
                INNER JOIN siq_Apublicoobjetivo as o on (c.idsiq_Apublicoobjetivo=o.idsiq_Apublicoobjetivo)
                where idsiq_Ainstrumentoconfiguracion='$id_instrumento' and cedula='".$_REQUEST['n']."'" ;
    // echo $sql_use;
    $data_use = $db->Execute($sql_use);  
    $data_user=$data_use->GetArray();
    $data_user=$data_user[0];
  } 
  
  $tipoP=$_REQUEST['tipoP'];
?>
<style>
 
 body{ background: url("http://www.uelbosque.edu.co/sites/default/files/exito_estudiantil/bg_exito.jpg") repeat scroll 0 0 rgba(0, 0, 0, 0);
font-family: 'PT Sans', sans-serif;
margin:0;
padding:0;
color: #3E4729;
}
#encabezado {
	    background-color: #3E4729;
	    border-bottom: 7px solid #88AB0C;
	    height: 80px;
	    width: 100%;
	    z-index: 100;
		overflow:hidden;
	}

	.cajon {
	    clear: both;
    margin: 0 auto;
    position: relative;
    text-align: left;
    width: 960px;
	}
	
	#encabezado > div > a {
	    display: block;
	    width: 172px;
	
		
	}
	
	
	fieldset{
	background: none repeat scroll 0 0 #FFFFFF;
    border: 0 none;
    box-shadow: 0 0 5px 0 #CCCCCC;
    margin: 2em 0;
    padding: 1em 2em;
    position: relative;
    width: 800px;}
fieldset > table{
	margin:1em 2em;
	}	
fieldset > legend
{
	padding: 40px 0 0 0;
	}	
  #progressbar .ui-progressbar-value {
    background-color: #006400;
    background: #006400;
  }

  div.centrado{
    text-align: center;
    display: block;
    margin: auto;
}
input[type="submit"] {
    background: url("http://www.uelbosque.edu.co/sites/default/themes/ueb/images/boton-de-busqueda.gif") repeat-x scroll 0 0 rgba(0, 0, 0, 0);
    border-color: #DDE2BC;
    border-style: solid;
    border-width: 1px;
    height: 25px;
    line-height: 25px;
    margin: 5px 0 0;
    padding: 3px;
    text-align: center;
}

  </style>



  </style>

    <?PHP


  if($Bienvenida->fields['obligar']==0 && $tipoP!='PIN'){
  ?>
  <script>
	$(function() {

		$( "#Bienvenida" ).dialog({
			modal: true,
			width: 700,
			buttons: {
			Continuar: function() {
					var selectedEffect = 'explode';
					$( "#Bienvenida" ).effect( selectedEffect);
					$( this ).dialog( "close" );
				},
            <?PHP
            if(!$_REQUEST['n']){
                ?>
                 Posponer: function() {
					/************************************/
                    $.ajax({//Ajax
                        type: 'POST',
                        url: 'instrumento_publico_html.php',
                        async: false,
                        dataType: 'json',
                        data:({actionID: 'CargarSession',Posponer:1,id_instrumento:<?PHP echo $id_instrumento?>}),
                        error:function(objeto, quepaso, otroobj){alert('Error de Conexi贸n , Favor Vuelva a Intentar');},
                        success: function(data){
                          if(data.val=='FALSE'){
                              alert(data.descrip);
                              return false;
                            }else{
                              /********************************************/
                                if(data.Permiso==1 || data.Permiso=='1'){
                                  location.href='../../../consulta/entrada/index.php';
                                }else{
                                    /*************************************************/
                                        if(data.tipoUser==600 || data.tipoUser=='600'){
                                            if(data.Rol==1 ||  data.Rol=='1'){
                                                window.parent.continuar();//Para Estudiantes
                                            }//if
                                        }//if
                                     /************************************************/
                                        if(data.tipoUser==400 || data.tipoUser=='400'){
                                            if(data.Rol==3  ||  data.Rol=='3'){
                                                window.parent.continuar3();//Para Admin
                                            }//if
                                        }//if
                                      if(data.tipoUser==500 || data.tipoUser=='500'){
                                            if(data.Rol==2  ||  data.Rol=='2'){
                                                window.parent.continuar();//Para Docentes
                                            }//if
                                        }//if
                                }//if
                              /********************************************/
                            }//else
                        }//data
                      }); //AJAX
                    /************************************/
				}
                <?PHP
            }
            ?>

			}
		});
	});
	</script>
  <div id="Bienvenida" title="Apreciado Usuario." style="width:auto;<?PHP echo $Entrada?>" >
 	
<div id="encabezado">
		<div class="cajon">
			<a title="Ir a la p醙ina principal" href="http://www.uelbosque.edu.co"><img id="logoU" alt="Universidad El Bosque" src="http://www.uelbosque.edu.co/sites/default/themes/ueb/images/logotipo_ueb.png"></a>			<!-- herramientas -->									
		</div>
	</div>
    <p align="justify" style=" margin-bottom:2%; margin-left:2%; margin-right:2%; margin-top:2%" font-family: 'PT Sans', sans-serif;>La autoevaluaci髇 institucional es un proceso de reflexi髇 que permite detectar oportunidades de consolidaci髇 y mejoramiento. Su participaci髇 es muy importante, por ello lo invitamos a diligenciar este instrumento de evaluaci髇.<br /><br />Gracias.</p>
 </div>
    
<?PHP
}
?>

  <center>
    <form  method="post" action="instrumento_aplicar.php?id_instrumento=<?php echo $id_instrumento ?>" id="form_test">
        <input type="hidden" name="idsiq_Ainstrumentoconfiguracion" id="idsiq_Ainstrumentoconfiguracion" value="<?php echo $id_instrumento ?>">
        <input type="hidden" name="entity" id="entity" value="Arespuestainstrumento">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <input type="hidden" name="aprobada" id="aprobada" value="1">
        <input type="hidden" name="idusuario" id="idusuario" value="<?php echo $_SESSION['MM_Username'] ?>">
        <input type="hidden" name="Username" id="Username" value="<?PHP echo $UserName ?>">
        <input type="hidden" name="cedula_num" id="cedula_num" value="<?PHP echo $_REQUEST['n']?>" />
        <input type="hidden" name="cedula" id="cedula" value="<?PHP echo $data_user['cedula']?>" />
        <input type="hidden" name="nombre" id="nombre" value="<?PHP echo $data_user['nombre']?>" />
        <input type="hidden" name="apellido" id="apellido" value="<?PHP echo $data_user['apellido']?>" />
        <input type="hidden" name="correo" id="correo" value="<?PHP echo $data_user['correo']?>" />
        <input type="hidden" name="Userid" id="Userid" value="<?PHP echo $userid?>" />
          
                       
         <div id="encabezado">
		<div class="cajon">
			<a title="Ir a la p醙ina principal" href="http://www.uelbosque.edu.co"><img id="logoU" alt="Universidad El Bosque" src="http://www.uelbosque.edu.co/sites/default/themes/ueb/images/logotipo_ueb.png"></a>			<!-- herramientas -->									
		</div>
	</div>
        <div id="container" class="centrado" align="center">
        <?php
             /*$sql_cp="SELECT ins.idsiq_Aseccion,  sec.nombre as secce
                        FROM  siq_Ainstrumento as ins
                        inner join siq_Aseccion as sec on (sec.idsiq_Aseccion=ins.idsiq_Aseccion)
                        where ins.codigoestado=100
                        and sec.codigoestado=100
                        and ins.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."'
                        group by idsiq_Aseccion    ";*/



                $sql_cp="SELECT ins.idsiq_Aseccion,  sec.nombre as secce
                        FROM  siq_Ainstrumento as ins
                        inner join siq_Aseccion as sec on (sec.idsiq_Aseccion=ins.idsiq_Aseccion)
                        where ins.codigoestado=100
                        and sec.codigoestado=100
                        and ins.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."'
                        AND
                        ins.idsiq_Aseccion NOT IN (

                           SELECT

                            i.idsiq_Aseccion

                            FROM

                            siq_Arespuestainstrumento r INNER JOIN siq_Ainstrumento i ON r.idsiq_Ainstrumentoconfiguracion=i.idsiq_Ainstrumentoconfiguracion
                            AND r.idsiq_Apregunta=i.idsiq_Apregunta

                            WHERE
                            r.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."'
                            AND
                            r.codigoestado = 100
                            AND
                            (r.cedula='".$_REQUEST['n']."')

                            GROUP BY i.idsiq_Aseccion

                        )

                        group by idsiq_Aseccion    ";
					


                 //echo $sql_cp;
                 $cant=0;
                 $data_cp = $db->Execute($sql_cp);


                foreach($data_cp as $dt_cp){
                    $cant++;
                }
                //si no existen registros en el contador  
                if($cant == 0){
                    echo "<script>alert('Ya completo la prueba de intereses'); location='resultados_prueba_interes.php?cedula=".$_REQUEST['n']."&id=".$id_instrumento."';</script>";
                } 

                 $vpreg=round((1*100)/$cant);
                 $vp=$vpreg;
                 //echo $vpreg;
        ?>
              <br>
        <table border="0" align="center" >
            <tr>
                <td colspan="2">
             <?php
             $z=0;
             echo "<div id='bi_".$z."' style='width:1050' >";
				if ($id_instrumento !== '53'){
					echo $data['mostrar_bienvenida'];	
				}
                 
             echo "<div>";
                 //echo "<br>";
                  $k=0;
                 foreach($data_cp as $dt_cp){//lee las secciones

                    echo "<div id='secc_".$z."'  >";
                     echo "<fieldset>";//abre un fieldset por seccion

                     $id_secc=$dt_cp['idsiq_Aseccion'];
                     echo "<legend>".trim($dt_cp['secce'])."</legend>";//coloca el nombre de la seccion
                     ///*******Busca la pregunta por seccion*/////////
                     $sql_preg="SELECT ins.idsiq_Ainstrumentoconfiguracion,
                                            ins.idsiq_Apregunta, pr.titulo, pr.obligatoria,
                                            pr.idsiq_Atipopregunta, tp.nombre as tipo, ins.idsiq_Aseccion,
                                            ins.codigoestado, sec.nombre as secce
                                            FROM siq_Ainstrumento as ins
                                            inner join siq_Aseccion as sec on (sec.idsiq_Aseccion=ins.idsiq_Aseccion)
                                            inner join siq_Apregunta as pr on (pr.idsiq_Apregunta=ins.idsiq_Apregunta)
                                            inner join siq_Atipopregunta tp on (pr.idsiq_Atipopregunta=tp.idsiq_Atipopregunta)
                                            where ins.codigoestado=100
                                            and sec.codigoestado=100
                                            and pr.codigoestado=100 and ins.idsiq_Aseccion='".$id_secc."' and ins.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."' ";
                               // echo $sql_preg;
                       $data_preg = $db->Execute($sql_preg);
                       $j=1;
                        foreach($data_preg as $dt_preg){//lee las preguntas por seccion
                             $id_preg=$dt_preg['idsiq_Apregunta'];
                             $titulo=$dt_preg['titulo'];
                             $obl=$dt_preg['obligatoria'];
                             $t_preg=$dt_preg['idsiq_Atipopregunta'];
                             if ($j>1) echo "<br>";
                             echo '<input type="hidden" name="preg['.$k.']" id="preg_'.$k.'" value="'.$id_preg.'">';
                             echo '<input type="hidden" name="tpreg['.$k.']" id="tpreg_'.$k.'" value="'.$t_preg.'">';
                             echo '<input type="hidden" name="obl['.$k.']" id="obl_'.$k.'" value="'.$obl.'_'.$k.'">';
                             $class="";
                             $obligatoria = false;
                             if (!empty($obl)){
                                 echo '<b><label style="color:red; font-size:9px;margin-right:3px">(*)</label>'.$j.'.'.$titulo.'</b>';
                                 $class="required";
                             }else{
                                 echo '<b>'.$j.'.'.$titulo.'</b>';//pinta el titulo de la pregunta
                             }
                             echo "<br>";
                            if($t_preg==5){
                              $style="style='width:100%'";
                            }else{
                              $style="";
                            }
                            echo "<table border='0' ".$style." >";//crea tabla por pregunta
                                    ///****Busca las respuestas por preguntas**//////
                                   $sql_rep="SELECT pre.idsiq_Apreguntarespuesta, pre.respuesta, pre.valor, pre.texto_inicio, pre.texto_final,
                                                 pre.unica_respuesta, pre.multiple_respuesta, pr.idsiq_Atipopregunta,
                                                 pre.maximo_caracteres, pre.analisis, pre.idsiq_Apregunta
                                              FROM siq_Apreguntarespuesta as pre
                                              inner join siq_Apregunta as pr on (pr.idsiq_Apregunta=pre.idsiq_Apregunta)
                                              where pr.idsiq_Apregunta='".$id_preg."'
                                              and pre.codigoestado=100
                                              and pr.codigoestado=100";
                                      $data_rep = $db->Execute($sql_rep);
                                      /////***Pregunat tipo Likert******///////
                                      if ($t_preg==1){
                                          echo "<tr>";
                                          foreach($data_rep as $dt_rep){
                                              $res=$dt_rep['respuesta'];
                                              echo '<td  valign="top"><center>&nbsp;'.$res.'&nbsp;</center>';
                                          }
                                          echo "</tr>";
                                          echo "<tr>";
                                          $i=0;
                                          foreach($data_rep as $dt_rep){
                                              $id_pregResp=$dt_rep['idsiq_Apreguntarespuesta'];
                                              $ur=$dt_rep['unica_respuesta']; $mr=$dt_rep['multiple_respuesta']; $val=$dt_rep['valor'];
                                              echo '<td valign="top"><center><input type="radio" '.$Disabled.'  class="contador_'.$j.' '.$class.'" name="valor_'.$id_preg.'" id="valor_'.$id_preg.'_'.$i.'" value="'.$id_pregResp.'" /></center></td>';
                                              $i++;
                                          }
                                          echo "</tr>";
                                      }
                                  ///////////cierra pregunta tipo liket****///////
                                   ///////////abre tipo gutman******//////
                                      if ($t_preg==2){
                                          $x=0;
                                          echo "<tr>";
                                          $i=0;
                                          foreach($data_rep as $dt_rep){
                                               $id_pregResp=$dt_rep['idsiq_Apreguntarespuesta']; $res=$dt_rep['respuesta'];
                                               $ti=$dt_rep['texto_inicio']; $tf=$dt_rep['texto_final'];
                                               $ur=$dt_rep['unica_respuesta']; $mr=$dt_rep['multiple_respuesta']; $val=$dt_rep['valor'];
                                               if ($x==0) echo '<td  valign="top">'.$ti.'</td>';
                                               echo '<td  valign="top">';
                                               echo '<center><input type="radio"  '.$Disabled.' name="valor_'.$id_preg.'" class="contador_'.$j.' '.$class.'"  id="valor_'.$id_preg.'_'.$i.'" value="'.$id_pregResp.'" /></center></td>';
                                               $x++; $i++;
                                          }
                                          echo '<td  valign="top">'.$tf.'</td>';
                                          echo "</tr>";
                                      }
                                 ///////////cierra tipo gutman******//////
                                 /////abre tipo dicotomicas///////
                                      if ($t_preg==3){
                                         $i=0;
                                         foreach($data_rep as $dt_rep){
                                             echo "<tr>";
                                              $id_pregResp=$dt_rep['idsiq_Apreguntarespuesta']; $res=$dt_rep['respuesta'];
                                              $ur=$dt_rep['unica_respuesta']; $mr=$dt_rep['multiple_respuesta']; $val=$dt_rep['valor'];
                                              echo '<td  valign="top"><center><input type="radio" '.$Disabled.' class="contador_'.$j.' '.$class.'"  name="valor_'.$id_preg.'" id="valor_'.$id_preg.'_'.$i.'" value="'.$id_pregResp.'" /></center></td>';
                                              echo '<td  valign="top">&nbsp;'.$res.'&nbsp;';
                                              $i++;
                                          }
                                          echo "</tr>";
                                      }
                                 /////cierra tipo dicotomicas///////
                                  //////////abre tipo opcion de respuesta multiple ////////////
                                      if ($t_preg==4){
                                         $i=0;
                                         foreach($data_rep as $dt_rep){
                                             echo "<tr>";
                                             $id_pregResp=$dt_rep['idsiq_Apreguntarespuesta']; $res=$dt_rep['respuesta'];
                                              $ur=$dt_rep['unica_respuesta']; $mr=$dt_rep['multiple_respuesta']; $val=$dt_rep['valor'];
                                              echo '<td  valign="top"><center><input type="checkbox"  '.$Disabled.'  class="contador_'.$j.' '.$class.'"  name="valor_'.$id_preg.'['.$i.']" id="valor_'.$id_preg.'_'.$i.'" value="'.$id_pregResp.'" /></center></td>';
                                              echo '<td  valign="top">&nbsp;'.trim($res).'&nbsp;';
                                              $i++;
                                          }
                                          echo "</tr>";
                                      }

                                //////////cierra tipo opcion de respuesta multiple ////////////



                                 //////////abre tipo pregunta abierta////////////
                                      if ($t_preg==5){
                                         $i=0;
                                         foreach($data_rep as $dt_rep){
                                             echo "<tr>";
                                              $mc=$dt_rep['maximo_caracteres'];
                                              echo '<td><textarea  '.$Disabled.' name="valor_'.$id_preg.'" class="contador_'.$j.' '.$class.'"  id="valor_'.$id_preg.'_'.$i.'" value="" maxlength="'.$mc.'" rows="10" style="width:100%" ></textarea></td>';
                                              $i++;
                                          }
                                          echo "</tr>";
                                      }
                               //////////cierra tipo de pregunta abierta////////////
                                /////////abre tipo pregunta opcion multiple////////////
                                      if ($t_preg==6){
                                         $i=0;
                                         foreach($data_rep as $dt_rep){
                                             echo "<tr>";
                                              $ur=$dt_rep['unica_respuesta']; $mr=$dt_rep['multiple_respuesta']; $val=$dt_rep['valor'];
                                              $id_pregResp=$dt_rep['idsiq_Apreguntarespuesta']; $res=$dt_rep['respuesta'];
                                              echo '<td  valign="top"><center><input type="radio"  '.$Disabled.'  class="contador_'.$j.' '.$class.'"  name="valor_'.$id_preg.'" id="valor_'.$id_preg.'_'.$i.'" value="'.$id_pregResp.'" /></center></td>';
                                              echo '<td  valign="top">&nbsp;'.trim($res).'&nbsp;';
                                              $i++;
                                          }
                                          echo "</tr>";
                                      }
                              /////////cierra tipo pregunta opcion multiple////////////


                             /////////abre tipo pregunta analisis//////////
                                       if ($t_preg==8){
                                         $i=0;
                                         foreach($data_rep as $dt_rep){
                                             echo "<tr>";
                                              $ur=$dt_rep['unica_respuesta']; $mr=$dt_rep['multiple_respuesta']; $val=$dt_rep['valor'];
                                              $id_pregResp=$dt_rep['idsiq_Apreguntarespuesta']; $res=$dt_rep['respuesta']; $ana=$dt_rep['analisis'];
                                               if ($i==0){
                                                        echo "<td colspan='2' ".$ana."<br></td></tr><tr>";
                                                    }
                                              echo '<td  valign="top" width="5%"><input type="radio"  '.$Disabled.'  class="contador_'.$j.' '.$class.'"  name="valor_'.$id_preg.'" id="valor_'.$id_preg.'_'.$i.'" value="'.$id_pregResp.'" /></td>';
                                              echo '<td  valign="top">&nbsp;'.trim($res).'&nbsp;';
                                              $i++;
                                         }
                                       }

                              /////////cierra tipo pregunta analisis//////////


                            echo "</table>";    //cierra tabla por pregunta
                            $j++; $k++;
                        }//cierra las preguntas por seccion

                     echo "</fieldset>";//cierra el fieldset por seccion
                     ?>
            <br>
                        <button id="numButton" class="submit">Siguiente</button>
                        <?php
                     echo "</div>";
                $z++;
                 }//cierra leer las secciones
             ?>
                         <br>
                        <br>
                        <br>
                        <br>
                        <div  id='dresul' style="display:none" >
                            <a id="resul" name="resul" href="resultados_prueba_interes.php?id=<?php echo $_REQUEST['id_instrumento'] ?>&cedula=<?php echo $_REQUEST['n'] ?>" class="submit">Ver Resultados</a>  
                         </div>
                        </td>
                     </tr>
                     <tr>
                         <td width="98%">
                            <br>
                            <?PHP
                            if($Ver!=0){
                            ?>
                            <div id="progressbar" style="width:100%; height: 5px" ></div>
                            <?PHP
                            }
                            ?>
                         </td>
                         <td valign="bottom">
                            <input type="hidden" id="pros" name="pros" value="<?php echo $vp ?>">
                            <input type="text" id="cant_pg" name="cant_pg" readonly style="width:40px; border:none;"   value="0%" >
                            <input type="hidden" id="cant_sec" name="cont_sec" value="<?php echo $z ?>" >
                            <input type="hidden" id="cant_preg" name="cont_preg" value="<?php echo $k ?>" >
                             <input type="hidden" id="tipoP" name="tipoP" value="<?php echo $tipoP ?>" >

                         </td>
                     </tr>
                  <tr>
                      <td colspan="2">
            <?php

                 echo "<br>";
                 echo $data['mostrar_despedida'];
             ?>
                      </td>
                  </tr>
                  </table>
              <div style="background-color:#3E4729;border-bottom:7px solid #88AB0C;border-top-left-radius:2em;
border-bottom-right-radius:2em; width:130%">&nbsp; </div>
            </div>
                   <!--<div class="derecha">
                        <button class="submit" id="guardar" type="submit">Aprobar</button>
                        &nbsp;&nbsp;
                        <a href="configuracioninstrumentolistar.php" class="submit" >Regreso al men煤</a>
                    </div><!-- End demo -->
    </div>
  </form>
  </center>
<script type="text/javascript">
    $(document).ready(function(){
        var c=$("#cant_sec").val();
        //alert(c);
         for(i=1; i<c; i++){
           $("#secc_"+i).hide();
           <?PHP
          if($Ver==1){
            ?>
           $('#secc_'+i+' :input').attr('disabled', true);
           <?PHP
         }
           ?>
        }
    });

        function mostrar_div(z){
            var x=z-1;
            <?PHP
          if($Ver==0){
            ?>
            $("#secc_"+z).show();
            //$('#secc_'+z+' :input').attr('disabled', false);
            $("#secc_"+x).hide();
            //$('#secc_'+x+' :input').attr('disabled', true);
            $('#datos :input').attr("readonly", "readonly")
            <?PHP
              }else{
                ?>
                $("#secc_"+z).show();
                $('#secc_'+z+' :input').attr('disabled', false);
                $("#secc_"+x).hide();
                $('#secc_'+x+' :input').attr('disabled', true);
                $('#datos :input').attr("readonly", "readonly")
                <?PHP
              }
            ?>
        }

   function validar(){
             var name="#form_test";
             var preguntas = [];
             $(name + ' input').removeClass('error').removeClass('valid');
             var fields = $(name + ' input[type=text]');
             var error = 0;
             //console.log(fields);
            fields.each(function(){
                var value = $(this).val();
                if( $(this).hasClass('required') && (value.length<1 || value=="") && !$(this).attr('disabled') ) {
                    $(this).addClass('error');
                    $(this).effect("pulsate", { times:3 }, 500);
                    var clases = $(this).attr('class');
                    //es una pregunta?
                    if(clases.indexOf("contador_")!=-1){
                        preguntas.push(parseInt(clases.replace("contador_","")));
                    }
                    error++;
                } else {
                    if($(this).hasClass('correo') && !$(this).attr('disabled')){
                        if(!validateEmail(value)){
                            $(this).addClass('error');
                            $(this).effect("pulsate", { times:3 }, 500);
                            error++;
                        }
                    } else {
                        $(this).addClass('valid'); }
                }
            });

         $(name + ' select').removeClass('error').removeClass('valid');
            var fields = $(name + ' select');

            fields.each(function(){
                var value = $(this).val();
                if( $(this).hasClass('required') && (value.length<1 || value=="") && !$(this).attr('disabled') ) {
                    $(this).addClass('error');
                    $(this).effect("pulsate", {times:3}, 500);
                    var clases = $(this).attr('class');
                    //es una pregunta?
                    if(clases.indexOf("contador_")!=-1){
                        preguntas.push(parseInt(clases.replace("contador_","")));
                    }
                    error++;
                } else {
                    $(this).addClass('valid');
                }
            });

            $(name + ' textarea').removeClass('error').removeClass('valid');
            var fields = $(name + ' textarea');

            fields.each(function(){
                var value = $(this).val();
                /*console.log(value);
                console.log($(this).hasClass('required'));
                console.log(value.length);
                console.log($(this).attr('disabled'));*/
                if( $(this).hasClass('required') && (value.length<1 || value=="") && !$(this).attr('disabled') ) {
                    $(this).addClass('error');
                    $(this).effect("pulsate", {times:3}, 500);
                    //console.log('hola');
                    var clases = $(this).attr('class');
                    //es una pregunta?
                    //console.log(clases.indexOf("contador_")!=-1);
                    if(clases.indexOf("contador_")!=-1){
                        preguntas.push(parseInt(clases.replace("contador_","")));
                    }
                    error++;
                } else {
                    $(this).addClass('valid');
                }
            });

            var fields = $(name + ' input[type=radio]');
            //var error = 0;
             //console.log(fields);
            fields.each(function(){
                var nameInput = $(this).attr('name');
                var value = $("input[type=radio][name='"+nameInput+"']:checked").val();

                if( $(this).hasClass('required') && (typeof value === "undefined" || value.length<1 || value=="") && !$(this).attr('disabled') ) {
                    $(this).closest('table').addClass('error');
                    //$(this).closest('table').effect("pulsate", { times:3 }, 500);
                    var clases = $(this).attr('class');
                    //es una pregunta?

                    if(clases.indexOf("contador_")!=-1){
                        preguntas.push(parseInt(clases.replace("contador_","")));
                    }
                    error++;
                } else {
                    $(this).closest('table').removeClass('error');
                }
            });
         //console.log('error->'+error);
    if(error>0)
    {
        //eliminar duplicados de las preguntas no contestadas (por lo que la clase esta en las respuestas y no en la pregunta)
        var uniquePreguntas = [];
        //console.log(preguntas);
        //alert(uniquePreguntas);
        $.each(preguntas, function(i, el){
            if($.inArray(el, uniquePreguntas) === -1) uniquePreguntas.push(el);
        });
        //console.log(uniquePreguntas.toString());
        alert("Debe contestar las siguientes preguntas obligatorias: " + uniquePreguntas.toString());

        return false;

    }
    else { return true; }
            // alert('hola');

        }



 $(function() {
    $( "#progressbar" ).progressbar({
      value:0
    });
    var t=0;
    var t1=0+'%';
    var c=0;
    var i=0;
    var tT1=0;
    $( "button" ).on( "click", function( event ) {
            event.preventDefault();
        <?PHP
          if($Ver==0){
            ?>


            $("#pros").val(t);
            $("#cant_pg").val(t1);
            i=i+1
                //validar()
               //sendForm()
                mostrar_div(i)

           <?PHP
          }else{
            ?>
            if(validar()){
            var target = $( event.target ),
                progressbar = $( "#progressbar" ),
                progressbarValue = progressbar.find( ".ui-progressbar-value" );
            var cont_preg=$("#cant_preg").val();
            var tipoP=$("#tipoP").val();
            var can_seg=$("#cant_sec").val();
                
            if ( target.is( "#numButton" ) ) {
                var c=parseInt($("#pros").val())

                //alert('C->'+c+'\n t->'+t);

                t=t+c;
                tT1=tT1+1;

               // alert(t+'-->'+tT1);
                if (t>100){
                    t1='100%'
                }else{
                    t1=t+'%';
                }

                  if (tipoP=='PIN' && tT1>=22){
                    $("#dresul").css('display','')
                  }
                progressbar.progressbar( "option", {
                value: Math.floor(t)
                });
            }
            // alert(t1)
            //$("#pros").val(t);
            $('#cant_Temp').val($("#cant_pg").val());
            $("#cant_pg").val(t1);
            i=i+1
                //validar()
                sendForm();
                mostrar_div(i);
           }//if Validar
            <?PHP
          }
        ?>

    });
  });



                function sendForm(){
                     $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process_ins.php',
                        data: $('#form_test').serialize(),
                        success:function(data){
                            if (data.success == true){
                               if ($("#tipoP").val()=='PIN'){
                                    alert('Continue con la siguiente sección');
                               }else{
                                alert(data.message);
                               }
                                var Porcentaje  = $("#cant_pg").val();

                                if(!$.trim($('#cedula_num').val())){
                                    if(Porcentaje=='100%'){
                                    $.ajax({//Ajax
                                        type: 'POST',
                                        url: 'instrumento_publico_html.php',
                                        async: false,
                                        dataType: 'json',
                                        data:({actionID: 'Finalizo',Instrumento_id:<?PHP echo $id_instrumento ?> }),
                                        error:function(objeto, quepaso, otroobj){alert('Error de Conexi贸n , Favor Vuelva a Intentar');},
                                        success: function(data){
                                          if(data.val=='FALSE'){
                                              alert(data.descrip);
                                              return false;
                                            }else{
                                              /*************************************/
                                                  var UserName  = $('#Username').val();

                                                  //alert('Se Ha Finalizado Con Exito');

                                                   $.ajax({//Ajax
                                                        type: 'POST',
                                                        url: 'instrumento_publico_html.php',
                                                        async: false,
                                                        dataType: 'json',
                                                        data:({actionID: 'CargarSession'}),
                                                        error:function(objeto, quepaso, otroobj){alert('Error de Conexi贸n , Favor Vuelva a Intentar');},
                                                        success: function(data){
                                                          if(data.val=='FALSE'){
                                                              alert(data.descrip);
                                                              return false;
                                                            }else{
                                                              /********************************************/
                                                                if(data.Permiso==1 || data.Permiso=='1'){
                                                                  location.href='../../../consulta/entrada/index.php';
                                                                }else{
                                                                    /*************************************************/
                                                                        if(data.tipoUser==600 || data.tipoUser=='600'){
                                                                            if(data.Rol==1 ||  data.Rol=='1'){
                                                                                window.parent.continuar();//Para Estudiantes
                                                                            }//if
                                                                        }//if
                                                                     /************************************************/
                                                                        if(data.tipoUser==400 || data.tipoUser=='400'){
                                                                            if(data.Rol==3  ||  data.Rol=='3'){
                                                                                window.parent.continuar3();//Para Admin
                                                                            }//if
                                                                        }//if
                                                                        if(data.tipoUser==500 || data.tipoUser=='500'){
                                                                            if(data.Rol==2  ||  data.Rol=='2'){
                                                                                window.parent.continuar();//Para Docentes
                                                                            }//if
                                                                        }//if
                                                                }//if
                                                              /********************************************/
                                                            }
                                                        }//data
                                                      }); //AJAX
                                              /*************************************/
                                              }//if
                                        }//data
                                      }); //AJAX
                                    /**********************************************/
                                }else{
                                    /**********************************************/
                                    $.ajax({//Ajax
                                        type: 'POST',
                                        url: 'instrumento_publico_html.php',
                                        async: false,
                                        dataType: 'json',
                                        data:({actionID: 'SinFinalizar',Instrumento_id:<?PHP echo $id_instrumento?>}),
                                        error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                                        success: function(data){
                                          if(data.val=='FALSE'){
                                              alert(data.descrip);
                                              return false;
                                            }
                                        }//data
                                      }); //AJAX
                                    /**********************************************/
                                }//if

                                    /************************************************/
                                }else{//Cedula

                                 var Porcentaje  = $("#cant_pg").val();

                                    /**********************************************/
                                   if(Porcentaje=='100%'){

                                    var cedula_num  = $('#cedula_num').val();
                                    var Userid      = $('#Userid').val();
                                    /**********************************************/
                                    $.ajax({//Ajax
                                        type: 'POST',
                                        url: 'instrumento_publico_html.php',
                                        async: false,
                                        dataType: 'json',
                                        data:({actionID: 'FinalizoExtreno',
                                               Instrumento_id:<?PHP echo $id_instrumento?>,
                                               NumeroDocumento:cedula_num,
                                               Userid:Userid}),
                                        error:function(objeto, quepaso, otroobj){alert('Error de Conexi贸n , Favor Vuelva a Intentar');},
                                        success: function(data){
                                          if(data.val=='FALSE'){
                                              alert(data.descrip);
                                              return false;
                                            }else{
                                              /*************************************/
                                                  var UserName  = $('#Username').val();
                                                  var cedula_num  = $('#cedula_num').val();

                                                 // alert('Se Ha Finalizado Con Exito');


                                              /*************************************/
                                              }//if
                                        }//data
                                      }); //AJAX
                                    /**********************************************/
                                }else{
                                    /**********************************************/
                                    var cedula_num  = $('#cedula_num').val();
                                    var Userid      = $('#Userid').val();

                                    $.ajax({//Ajax
                                        type: 'POST',
                                        url: 'instrumento_publico_html.php',
                                        async: false,
                                        dataType: 'json',
                                        data:({actionID: 'SinFinalizarNumeroDocumento',
                                               Instrumento_id:<?PHP echo $id_instrumento?>,
                                               NumeroDocumento:cedula_num,
                                               Userid:Userid}),
                                        error:function(objeto, quepaso, otroobj){alert('Error de Conexi贸n , Favor Vuelva a Intentar');},
                                        success: function(data){
                                          if(data.val=='FALSE'){
                                              alert(data.descrip);
                                              return false;
                                            }
                                        }//data
                                      }); //AJAX
                                    /**********************************************/

                                   }//if

                                }//if Cedula


                            }
                            else{
                                $('#msg-error').html('<p>' + data.message + '</p>');
                                $('#msg-error').addClass('msg-error');
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });
             }


</script>

<?php
writeFooter();

}else{
  ?>
  <script type='text/javascript'>
      window.parent.continuar3();
  </script>
<?PHP
}//if
?>

