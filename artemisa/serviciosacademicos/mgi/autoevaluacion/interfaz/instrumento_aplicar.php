<?php
/*
 * @author Quintrero Ivan <quintreroivan@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología 
 * @Modified : 28 de Septiembre
 */
    $Ver               = $_REQUEST['Ver'];// ver
    $Grupo_id          = $_REQUEST['Grupo_id'];//id grupo
    $CodigoEstudiante  = $_REQUEST['CodigoEstudiante']; //codigo del estudiante 
    $CodigoJornada     = $_REQUEST['CodigoJornada'];// jornada    
    $id_instrumento    = $_REQUEST['id_instrumento'];//id de la encuesta
    $n                 = $_REQUEST['n']; //numero de documento del usuario    
    
    if(empty($materia) ||$materia== null ){
        $materia  = $_REQUEST['materia']; //numero de documento del usuario    
    }
    
    
    /*if(empty($n)){
        $n= $_REQUEST['documento'];
    }*/    
    
    if(!empty($n)){        
        if($Ver==1){ 
            include_once ('EntradaRedireccion_Class.php');   
            $C_EntradaRedirecion  = new EntradaRedirecion();
        }//ver 1 
    }//if request 

    include("../../templates/templateAutoevaluacion.php");
    $db =writeHeader("Instrumento",true,"Autoevaluacion");
    require("pintarSecciones.php");
    
    if(!$_SESSION['idusuariofinalentradaentrada']){
       $userid = $_REQUEST['Userid'];
       if(empty($userid)){
           $userid = $_SESSION['idusuario'];
       }
    }else{
        $userid = $_SESSION['idusuariofinalentradaentrada']; 
        if(empty($userid)){
            $userid = $_SESSION['idusuario'];
        }
    }//else   
    
    if($_SESSION['MM_Username']=='estudiante'){
        $Estudiante_Gene = $_SESSION['sesion_idestudiantegeneral'];
        $query_periodo = "SELECT u.usuario,u.codigorol FROM usuario u "
        . "INNER JOIN estudiantegeneral e ON e.numerodocumento=u.numerodocumento AND u.idusuario='".$userid."'";
    }else{
        $Estudiante_Gene = '';
        //consulta de datos del usuario
        $query_periodo = "SELECT  u.usuario,u.codigorol  FROM usuario u WHERE u.idusuario='".$userid."'";
    }//else 
   
    $DataUsuer=$db->Execute($query_periodo);
    
    $CodigoPeriodo = $_SESSION['codigoperiodosesion'];// codigo de periodo
    $UserName  = $DataUsuer->fields['usuario']; //nombre del usuario 
    $Tipo_user = $DataUsuer->fields['codigorol'];//codigotipousuario
             
    //consulta del publico objetico del instrumeto a evaluar
    $SQL_B='SELECT obligar FROM siq_Apublicoobjetivo WHERE '
    . 'idsiq_Ainstrumentoconfiguracion="'.$id_instrumento.'" AND codigoestado=100';
            
    $Bienvenida=$db->Execute($SQL_B);
    
    if(!empty($n)){
        if($Ver==1){                        
            $C_Data = 1;
            $Disabled = '';
        }else if($Ver==2){             
            $C_Data   = 1;
            $Disabled = ''; 
        }else{
            $C_Data=1;
            $Disabled = 'disabled="disabled"';
        }//else
    }else{        
        $C_Data=1;
        $Disabled = '';
    }//else     
	    
    //validacion de permisos
    if($C_Data==1){//if Permiso        
        $secc=$_REQUEST['secc'];
        
        if($_SESSION['MM_Username']=='estudiante'){
            if(empty($userid)){            
                $userid = $_SESSION['idusuariofinalentradaentrada'];            
            }
        }else if(isset($_SESSION['MM_Username'])){
            $entity = new ManagerEntity("usuario");
            $entity->sql_select = "idusuario";
            $entity->prefix ="";
            $entity->sql_where = " usuario='".$_SESSION['MM_Username']."' ";		
            $data = $entity->getData();
            $userid = $data[0]['idusuario'];
        }else if(!isset($n)){
            $entity = new ManagerEntity("usuario");
            $entity->sql_select = "idusuario";
            $entity->prefix ="";
            $entity->sql_where = " usuario='".$_POST['Userid']."' ";
            $data = $entity->getData();
            $userid = $data[0]['idusuario'];
        }

        if (!empty($id_instrumento)){
            $entity = new ManagerEntity("Ainstrumentoconfiguracion");
            $entity->sql_where = "idsiq_Ainstrumentoconfiguracion= $id_instrumento";
    
            $data = $entity->getData();
            $data =$data[0];
            $tipo=$data['idsiq_discriminacionIndicador'];
            $tipoProg=$data['codigocarrera'];
            $categoriaInstrumento = $data['cat_ins'];

            $entity1 = new ManagerEntity("Ainstrumento");
            $entity1->sql_where = "idsiq_Ainstrumentoconfiguracion= $id_instrumento";

            $data1 = $entity1->getData();
            $data1 =$data1[0];
        }

        if(empty($_SESSION['MM_Username']) && isset($_REQUEST['n'])){
            $sql_use="SELECT * 
            FROM siq_Apublicoobjetivocsv AS c
            INNER JOIN siq_Apublicoobjetivo as o on (c.idsiq_Apublicoobjetivo=o.idsiq_Apublicoobjetivo)
            LEFT JOIN usuario u on u.numerodocumento=cedula 
            where idsiq_Ainstrumentoconfiguracion='$id_instrumento' and cedula='".$n."'" ;            
            $data_use = $db->Execute($sql_use);  
            $data_user=$data_use->GetArray();
            $data_user=$data_user[0];
            $userid = $data_user['idusuario'];
            //los problemas vienen cuando el usuario es null porque no pertenece a la universidad...
        } 

        ?>
        <style>
            #progressbar .ui-progressbar-value{
                background-color: #006400;
                background: #006400;
            }

            div.centrado{
                text-align: center;
                display: block;
                margin: auto;
            }
        </style>
    	<?php 
        //si la encuesta no es obligatoria y la opcion de ver es diferente a 2
        if($Bienvenida->fields['obligar']==0 && $Ver!=2){
            ?>
            <script>
                $(function(){
                    $( "#Bienvenida" ).dialog({
                        modal: true,
                        width: 700,
                        buttons:{
                            Continuar: function(){
                                var selectedEffect = 'explode';
                                $( "#Bienvenida" ).effect( selectedEffect);  
                                $( this ).dialog( "close" );
                            },
                            <?php 
                            //valida el publico objetivo si es diferente
                            if(!$n){
                            ?>
                                Posponer: function(){ 
                                    /************************************/
                                    $.ajax({//Ajax
                                        type: 'POST',
                                        url: 'instrumento_publico_html.php',
                                        async: false,
                                        dataType: 'json',
                                        data:({actionID: 'CargarSession',Posponer:1,id_instrumento:<?PHP echo $id_instrumento?>,Userid:'<?PHP echo $userid ?>'}),
                                        error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                                        success: function(data){
                                            if(data.val==='FALSE'){
                                                alert(data.descrip);
                                                return false;
                                            }else{
                                                /********************************************/
                                                if(data.Permiso===1 || data.Permiso==='1'){
                                                    location.href='../../../consulta/entrada/index.php';
                                                }else{
                                                    /*************************************************/
                                                    if(data.tipoUser===600 || data.tipoUser==='600'){
                                                        if(data.Rol===1 ||  data.Rol==='1'){
                                                            window.parent.continuar();//Para Estudiantes  
                                                        }//if
                                                    }//if
                                                    /************************************************/ 
                                                    if(data.tipoUser===400 || data.tipoUser==='400'){
                                                        if(data.Rol===3  ||  data.Rol==='3'){
                                                            window.parent.continuar3();//Para Admin  
                                                        }//if
                                                    }//if
                                                    if(data.tipoUser===500 || data.tipoUser==='500'){
                                                        if(data.Rol===2  ||  data.Rol==='2'){
                                                            window.parent.continuar();//Para Docentes  
                                                        }//if
                                                    }//if
                                                }//else
                                                /********************************************/
                                            }//else
                                        }//data 
                                    }); //AJAX
                                    /************************************/		
                                }//function posponer 
                		<?php
                            }//if requees n
                            ?>    
                        }//buttons
                    });//dialog
                });//function Bienvenida
            </script>
            <?php 
        }//if Bienvenida 
        ?>  
        <center>
            <form  method="post" action="instrumento_aplicar.php?id_instrumento=<?php echo $id_instrumento ?>" id="form_test">
                <input type="hidden" name="idsiq_Ainstrumentoconfiguracion" id="idsiq_Ainstrumentoconfiguracion" value="<?php echo $id_instrumento ?>">
                <input type="hidden" name="Materia" id="Materia" value="<?PHP echo $materia?>" />
                <input type="hidden" name="entity" id="entity" value="Arespuestainstrumento">
                <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
                <input type="hidden" name="aprobada" id="aprobada" value="1">
                <input type="hidden" name="idusuario" id="idusuario" value="<?php echo $_SESSION['MM_Username']; ?>">
                <input type="hidden" name="idgrupo" id="idgrupo" value="<?php echo $Grupo_id; ?>">
                <input type="hidden" name="Username" id="Username" value="<?PHP echo $UserName; ?>">
                <input type="hidden" name="cedula_num" id="cedula_num" value="<?PHP echo $n; ?>" />
                <input type="hidden" name="cedula" id="cedula" value="<?PHP echo $data_user['cedula']; ?>" />
                <input type="hidden" name="nombre" id="nombre" value="<?PHP echo $data_user['nombre']; ?>" />
                <input type="hidden" name="apellido" id="apellido" value="<?PHP echo $data_user['apellido']; ?>" />
                <input type="hidden" name="correo" id="correo" value="<?PHP echo $data_user['correo']; ?>" />
                <input type="hidden" name="Userid" id="Userid" value="<?PHP echo $userid; ?>" />
                <div id="container" class="centrado" align="center">
                    <div style="background-color:#3E4729;border-bottom:7px solid #88AB0C;border-top-left-radius:2em;
border-bottom-right-radius:2em; width:130%">
                        <img src="http://www.uelbosque.edu.co/sites/default/themes/ueb/images/logotipo_ueb.png" width="130" />
                    </div>
                    <div>
                        <h2><?php echo $materia." --  ".$Grupo_id;?></h2>
                    </div>
                    <?php    
                    //consulta si el publico objetivo
                    if(empty($n)){
                        //si existe el id de usuario
                        if($userid){                            
                            $Consulta = "r.usuariocreacion='".$userid."'";
                        }else{                         
                            $Consulta = "r.usuariocreacion='".$_SESSION['idusuario']."'";
                        }
                    }else{
                        //si existe el id de usuario
                        if($userid){
                            $Consulta = "r.cedula='".$n."' ";                         
                        }else{
                            $Consulta = "r.cedula='".$n."'";                            
                        }
                    }
                    /*
                     * Caso 107461.
                     * @author Luis Dario Gualteros <castroluisd@unbosque.edu.do>
                     * Se omite el INNER JOIN siq_ADetallesRespuestaInstrumentoEvaluacionDocente para visualizar las secciones sin evaluar.
                     * @copyright Universidad el Bosque - Dirección de Tecnología
                     * @since 20 de Noviembre de 2018. 
                    */
                    
                    //sí el instrumento es para evaluacion docente
                    if($categoriaInstrumento==="EDOCENTES"){
                        $sql = "SELECT i.idsiq_Aseccion FROM siq_Arespuestainstrumento r ".
                        "INNER JOIN siq_Ainstrumento i ON (r.idsiq_Ainstrumentoconfiguracion=i.idsiq_Ainstrumentoconfiguracion AND r.idsiq_Apregunta=i.idsiq_Apregunta) ".
                        "INNER JOIN estudiante e ON (e.codigoestudiante='".$CodigoEstudiante."' ) ".
                        "INNER JOIN estudiantegeneral eg ON ( eg.idestudiantegeneral= e.idestudiantegeneral )".
                        "INNER JOIN usuario u ON (u.numerodocumento=eg.numerodocumento )".
                        "INNER JOIN actualizacionusuario a ON (a.usuarioid=u.idusuario and a.id_instrumento=i.idsiq_Ainstrumentoconfiguracion  and a.estadoactualizacion in(1,2))". 
                       /* "INNER JOIN siq_ADetallesRespuestaInstrumentoEvaluacionDocente der ON (der.idactualizacionusuario =a.idactualizacionusuario and  der.codigoestado = 100 AND der.idgrupo='".$Grupo_id."' )". */
                        "WHERE ".
                        " r.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."' ".
                        "AND r.codigoestado = 100 ".
                        "AND  ".$Consulta." ".
                        "AND r.idgrupo='".$Grupo_id."'   ".    
                        "GROUP BY i.idsiq_Aseccion ";
                    //End Caso 107461.
                    } else  {
                        $sql = "SELECT  i.idsiq_Aseccion FROM siq_Arespuestainstrumento r ".
                        "INNER JOIN siq_Ainstrumento i ON (r.idsiq_Ainstrumentoconfiguracion=i.idsiq_Ainstrumentoconfiguracion AND r.idsiq_Apregunta=i.idsiq_Apregunta) ".
                        "WHERE r.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."' ".
                        "AND r.codigoestado = 100 ".
                        "AND ".$Consulta." ".
                        "GROUP BY i.idsiq_Aseccion";
                    }  
                 
                    $seccionesContestadas = $db->GetAll($sql);
                    $consulta2 = "";
                    //valida si las secciones constestas es difernete a null o mayor a cero
                    if($seccionesContestadas!==null && count($seccionesContestadas)>0){
                        $consulta2 = "AND ins.idsiq_Aseccion NOT IN (";
                        $arreglo = "";
                       
                        foreach($seccionesContestadas as $seccion){
                            if($arreglo===""){
                                $arreglo .= "'".$seccion["idsiq_Aseccion"]."'";
                            }else{
                                $arreglo .= ",'".$seccion["idsiq_Aseccion"]."'";
                            }//else         
                        }//foreach
                        $consulta2 .= $arreglo.")";
                    }//if
                    
                    /*
                    * @author Ivan Dario Quintero Rios <quinteroivan@unbosque.edu.do>
                    * @copyright Universidad el Bosque - Dirección de Tecnología
                    * @modifed since 6 octubre
                    * Se agrega order by idsiq_Ainstrumento para el orden las preguntas 
                    */
                    
                    //consulata para obtener las preguntas
                    $sql_cp="select *
                            from (
                            SELECT ins.idsiq_Aseccion,  sec.nombre as secce, ins.idsiq_Ainstrumento
                            FROM  siq_Ainstrumento as ins
                            INNER JOIN siq_Aseccion as sec ON (sec.idsiq_Aseccion=ins.idsiq_Aseccion)
                            where ins.codigoestado=100 
                            and sec.codigoestado=100 
                            and ins.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."'
                            AND
                            ins.idsiq_Aseccion IN (
                                    SELECT 
                                    insecc.idsiq_Aseccion 
                                    FROM 
                                    siq_ApreguntaRespuestaDependencia dep                            
                                    INNER JOIN siq_Ainstrumentoseccion insecc ON (insecc.idsiq_Ainstrumentoseccion=dep.idDependencia AND insecc.codigoestado=100)
                                    INNER JOIN siq_Arespuestainstrumento r ON ( r.idsiq_Ainstrumentoconfiguracion=dep.idInstrumento ".
                                    "AND dep.idRespuesta=r.idsiq_Apreguntarespuesta AND r.codigoestado=100 AND ".$Consulta." )
                                    WHERE dep.idInstrumento='".$id_instrumento."' AND dep.codigoestado = 100 AND dep.tipo=2 
                                    GROUP BY insecc.idsiq_Aseccion 
                            ) 
                            ".$consulta2." 
                           group by idsiq_Aseccion    
                           UNION
                           SELECT ins.idsiq_Aseccion,  sec.nombre as secce, ins.idsiq_Ainstrumento
                           FROM  siq_Ainstrumento as ins
                           INNER JOIN siq_Aseccion as sec ON (sec.idsiq_Aseccion=ins.idsiq_Aseccion)
                           where ins.codigoestado=100 
                           and sec.codigoestado=100 
                           and ins.idsiq_Ainstrumentoconfiguracion='".$id_instrumento."'
                            ".$consulta2." 
                           AND
                           ins.idsiq_Aseccion NOT IN (
                                   SELECT 
                                   insecc.idsiq_Aseccion 
                                   FROM 
                                   siq_ApreguntaRespuestaDependencia dep                            
                                   INNER JOIN siq_Ainstrumentoseccion insecc ON (insecc.idsiq_Ainstrumentoseccion=dep.idDependencia AND insecc.codigoestado=100)
                                   WHERE dep.idInstrumento='".$id_instrumento."' AND dep.codigoestado = 100 AND dep.tipo=2 
                                   GROUP BY insecc.idsiq_Aseccion 
                           )
                           group by idsiq_Aseccion 
                           ) a ORDER BY idsiq_Ainstrumento ASC";  
                    /* END */    
                    
                    $cant=0;
                    $data_cp = $db->Execute($sql_cp);    

                    foreach($data_cp as $dt_cp){
                        $cant++;
                    }//foreach
                    //valida el porcentaje de sumatoria para cada seccion
                    $vpreg=round((1*100)/$cant);                    
                    $vp=$vpreg;
                    ?>
                    <br>
                    <table border="0" align="center" >
                        <tr>
                            <td colspan="2">
                            <?php
                                $z=0;
                                echo "<div id='bi_".$z."' >";
                                echo $data['mostrar_bienvenida'];
                                echo "<div>";                 
                                $k=0;
                                $secciones = pintarSecciones($data_cp,$id_instrumento,$db);
                                $z=$secciones[0];
                                echo $secciones[1];
                                ?>
                                <div id="seccionDinamica"></div>
                                <br>
                                <br>
                                <br>
                                <br>
                                
                                <div id="botonfinalizar" style="display:none">
                                    <input class="btn btn-warning btn-rounded" type="button" value="Finalizar Proceso" onClick="parent.location.reload();">                                    
                                </div>
                                <div id='dresul' style="display:none" >
                                    <a id="resul" name="resul" href="resultados_prueba_interes.php?id=<?php echo $id_instrumento; ?>&cedula=<?php echo $_REQUEST['n'] ?>" class="submit">Ver Resultados</a>  
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width="98%">
                                <br>
                                <?PHP
                                if($Ver!=0){
                                    ?>
                                    <label id="numeroporcentaje">0%</label>
                                    <div id="progressbar" style="width:100%; height: 15px" ></div>
                                    <?PHP
                                }
                                ?>
                            </td>
                            <td valign="bottom">
                                <input type="hidden" id="pros" name="pros" value="<?php echo $vp; ?>">
                                <input type="hidden" id="countpros" name="countpros" value="0">
                                <input type="hidden" id="cant" name="cant" value="<?php echo $cant; ?>">
                                <input type="hidden" id="cant_pg" name="cant_pg" readonly style="width:40px; border:none;" value="0%" >
                                <input type="hidden" id="cant_sec" name="cont_sec" value="<?php echo $z; ?>" >       
                                <input type="hidden" id="cant_preg" name="cont_preg" value="<?php echo $k; ?>" >
                                <input type="hidden" id="tipoP" name="tipoP" value="<?php echo $tipoP; ?>" >
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
border-bottom-right-radius:2em; width:130%">&nbsp; 
                    </div>
                </div>      		
            </form>
        </center>
        <script type="text/javascript">
            $('body').on( "click", ".preguntasOcultas input[type=radio]", function(){
                ocultarMostrarPreguntas( $( this ),0);
            });
            $('body').on( "click", ".preguntasOcultas input[type=checkbox]", function(){
                ocultarMostrarPreguntas( $( this ),1);
            });
    
            function ocultarMostrarPreguntas(respuesta,tipo){
                //console.log(respuesta.closest(".divPreguntas").attr('class'));
                var idRespuesta = respuesta.val();
                var parent = respuesta.closest(".divPreguntas");
                var listado = false;
                parent.find( "input[type=checkbox]:checked" ).each(function( index ) {
                    //console.log( index + ": " + $( this ).val() );
                    if(listado!==false){
                        listado += ","+$( this ).val(); 
                    } else {
                        listado = $( this ).val();
                    }
                });
                if(listado!==false){
                    idRespuesta = listado;
                } 
                else if(tipo===1){
                    idRespuesta = null;
                }  
                var clases = parent.attr('class');
                clases = clases.split(" ");
                //tiene el id_pregunta?
                if(clases[1].indexOf("divPregunta_")!==-1){
                    var idPregunta = parseInt(clases[1].replace("divPregunta_",""));       
                    var idInstrumento = parseInt(""+<?php echo $id_instrumento;?>);     
                    $.ajax({	
                        dataType: 'json',
                        type: 'POST',
                        url: 'consultarPreguntasAsociadas.php',
                        data: { respuestaElegida: idRespuesta, idPregunta: idPregunta, idInstrumento: idInstrumento },
                        success:function(data){
                            if (data.success === true){
                                //oculto las otras preguntas
                                for (var i=0;i<data.totalOcultar;i++){ 
                                    //console.log(data.ocultar[i]);
                                    var divP = $( ".divPregunta_"+data.ocultar[i].idsiq_Apregunta );
                                    divP.attr('style','display:none;');
                                    //le agrego el disable
                                    divP.find( "input" ).each(function( index ){
                                        $( this ).attr( "disabled", "disabled" );
                                    });
                                    divP.find( "textarea" ).each(function( index ){
                                        $( this ).attr( "disabled", "disabled" );
                                    });
                                }//for    
                                for (var i=0;i<data.totalMostrar;i++){ 
                                    //console.log(data.mostrar[i]);
                                    var divP = $( ".divPregunta_"+data.mostrar[i].idsiq_Apregunta );
                                    divP.attr('style','display:block;');
                                    //le quito el disable
                                    divP.find( "input" ).each(function( index ){
                                        $( this ).removeAttr( "disabled" );
                                    });
                                    divP.find( "textarea" ).each(function( index ){
                                        $( this ).removeAttr( "disabled" );
                                    });
                                }//for
                            }else{
                                alert(data.message);
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });
                }//if
            }//function ocultarMostrarPreguntas
    
            $(document).ready(function(){
                var c=$("#cant_sec").val();        
                for(i=1; i<c; i++){
                    $("#secc_"+i).hide();
                    <?PHP
                        if($Ver==1 || $Ver==2){
                            ?>
                            $('#secc_'+i+' :input').attr('disabled', true);
                            <?PHP
                        }
                    ?>
                }//for
            });
    
            function consultarSeccionesDinamicas(){
                var secciones = false;
                var idInstrumento = parseInt(""+<?php echo $_GET["id_instrumento"]; ?>);     
                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: 'consultarSeccionesAsociadas.php',
                    async: false,
                    data: { idInstrumento: idInstrumento, usuario: '<?php echo $userid; ?>', n: '<?php echo $n; ?>'  },
                    success:function(data){                        
                        if(data[0]>0){
                            secciones = true;
                            $('#seccionDinamica').html(data[1]);
                        } else {
                            $('#seccionDinamica').html("");
                        }
                    },
                    error: function(data,error,errorThrown){alert(error + errorThrown);}
            	});
            	return secciones;
            }//function consultarSeccionesDinamicas

            function mostrar_div(z){
                var esDinamica = consultarSeccionesDinamicas();
            	if(!esDinamica){
                    var x=z-1;
                    <?PHP
                        if($Ver==0){
                            ?>
                            $("#secc_"+z).show();
                            $('#secc_'+z+' :input').attr('disabled', false);
                            $("#secc_"+x).hide();
                            $('#secc_'+x+' :input').attr('disabled', true);
                            $('#datos :input').attr("readonly", "readonly");
                            <?PHP
                        }else{
                            ?>
                            $("#secc_"+z).show();
                            $('#secc_'+z+' :input').attr('disabled', false);
                            $("#secc_"+x).hide();
                            $('#secc_'+x+' :input').attr('disabled', true);
                            $('#datos :input').attr("readonly", "readonly");
                            <?PHP
                        }
                    ?>
                }else {
                    var x=z-1;
                    $("#secc_"+x).hide();
                    $('#secc_'+x+' :input').attr('disabled', true);
                    $('#datos :input').attr("readonly", "readonly");
            	}
            	return esDinamica;
            }//function mostrar_div

            function validar(){
                var name="#form_test";
             	var preguntas = [];
             	$(name + ' input').removeClass('error').removeClass('valid');
             	var fields = $(name + ' input[type=text]');
             	var error = 0;
             
            	fields.each(function(){
                    var value = $(this).val();
                    if( $(this).hasClass('required') && (value.length<1 || value==="") && !$(this).attr('disabled') ) {
                    	$(this).addClass('error');
                    	$(this).effect("pulsate", { times:3 }, 500);
                    	var clases = $(this).attr('class');
                    	//es una pregunta?
                    	if(clases.indexOf("contador_")!==-1){
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
                            $(this).addClass('valid'); 
                        }
                    }//else
            	});//fields

                $(name + ' select').removeClass('error').removeClass('valid');
                var fields = $(name + ' select');

            	fields.each(function(){
                    var value = $(this).val();
                    if( $(this).hasClass('required') && (value.length<1 || value=="") && !$(this).attr('disabled') ) {
                    	$(this).addClass('error');
                    	$(this).effect("pulsate", {times:3}, 500);
                    	var clases = $(this).attr('class');
                    	//es una pregunta?
                    	if(clases.indexOf("contador_")!==-1){
                            preguntas.push(parseInt(clases.replace("contador_","")));
                    	}
                    	error++;
                    } else {
                        $(this).addClass('valid');
                    }
            	});//fields

            	$(name + ' textarea').removeClass('error').removeClass('valid');
            	var fields = $(name + ' textarea');

            	fields.each(function(){
                    var value = $(this).val();               
                    if( $(this).hasClass('required') && (value.length<1 || value==="") && !$(this).attr('disabled') ) {
                    	$(this).addClass('error');
                    	$(this).effect("pulsate", {times:3}, 500);
                    	//console.log('hola');
                    	var clases = $(this).attr('class');
                    	//es una pregunta?
                    	//console.log(clases.indexOf("contador_")!=-1);
                    	if(clases.indexOf("contador_")!==-1){
                            preguntas.push(parseInt(clases.replace("contador_","")));
                    	}
                    	error++;
                    } else {
                        $(this).addClass('valid');
                    }
            	});//fields

            	var fields = $(name + ' input[type=radio]');
            	fields.each(function(){
                    var nameInput = $(this).attr('name');
                    var value = $("input[type=radio][name='"+nameInput+"']:checked").val();
                
                    if( $(this).hasClass('required') && (typeof value === "undefined" || value.length<1 || value==="") && !$(this).attr('disabled') ) {
                        $(this).closest('table').addClass('error');
                        //$(this).closest('table').effect("pulsate", { times:3 }, 500);
                        var clases = $(this).attr('class');
                        //es una pregunta?

                        if(clases.indexOf("contador_")!==-1){
                            preguntas.push(parseInt(clases.replace("contador_","")));
                        }
                        error++;
                    } else {
                        $(this).closest('table').removeClass('error');
                    }
            	});//fields
            
            	//respuestas múltiples con checkbox
            	var fields = $(name + ' input[type=checkbox]');            	
            	fields.each(function(){
                    var nameInput = $(this).attr('name');
                    nameInputGrupo = nameInput.substring(0,nameInput.indexOf("["));
                    //console.log(nameInput);
                    var checked = false;
                    var clases = $(this).attr('class');
                    clases = clases.split(" ");
                    $("input:checkbox:checked."+clases[0]).each(function(){
                        checked = true;
                    });
                   
                    if( $(this).hasClass('required') && !checked && !$(this).attr('disabled') ) {
                    	$(this).closest('table').addClass('error');
                    	//$(this).closest('table').effect("pulsate", { times:3 }, 500);
                    	var clases = $(this).attr('class');
                    	//es una pregunta?
                    	if(clases.indexOf("contador_")!==-1){
                            preguntas.push(parseInt(clases.replace("contador_","")));
                    	}
                    	error++;
                    } else {
                        $(this).closest('table').removeClass('error');
                    }
                });//fields
                //console.log('error->'+error);
                if(error>0){
                    //eliminar duplicados de las preguntas no contestadas (por lo que la clase esta en las respuestas y no en la pregunta)
                    var uniquePreguntas = [];
                    $.each(preguntas, function(i, el){
                        if($.inArray(el, uniquePreguntas) === -1) uniquePreguntas.push(el);
                    });                    
                    alert("Debe contestar las siguientes preguntas obligatorias: " + uniquePreguntas.toString());
                    return false;
                }//if
                else { return true; }
            }//function validar

            $(function() {
                $( "#progressbar" ).progressbar({
                    value:0
                });
                var t=0;
                var t1=0+'%';
                var c=0;
                var i=0;
                var countpros = 0;

                $('body').on( "click", "button", function(event) {                    
                    event.preventDefault();
                });

                $('body').on( "click", "button#numButton", function(event) {
                    event.preventDefault();
                    <?PHP
                    if($Ver==0){
                        ?>
                        $("#pros").val(t);
                        $("#cant_pg").val(t1);
                        i=i+1;
                        mostrar_div(i);
                        <?PHP
                    }else{		 
                        ?>
                        if(validar()){                              
                            sendForm();
                            var esDinamica = mostrar_div(i+1);                            
                            
                            if(esDinamica){
                                /*if(typeof $('#cant_Temp').val() === 'undefined'){
                                    $("#cant_pg").val(0);
                                } else {
                                    $("#cant_pg").val($('#cant_Temp').val());
                                }
                                $('#cant_Temp').val($("#cant_pg").val()-t);
                                progressbar.progressbar( "option", {
                                    value: $("#cant_pg").val()
                                });*/
                            }else {                                
                                var target = $( event.target ),
                                progressbar = $( "#progressbar" ),
                                progressbarValue = progressbar.find( ".ui-progressbar-value" );
                        
                                var numeroporcentaje = $('#numeroporcentaje');                                
                                numeroporcentaje.val(progressbarValue);
                                
                                if ( target.is( "#numButton" ) ){
                                    var c = parseInt($("#pros").val());
                                    var cant = parseInt($("#cant").val());
                                    var countpros = parseInt($("#countpros").val());
                                    t=t+c;      
                                    countpros=countpros+1;
                                    $("#countpros").val(countpros);
                                    if (t>100){
                                        t1='100%';
                                    }
                                    else{
                                        //si la cantidad de secciones es igual al contador de secciones se modifica el porcenatje a 100
                                        if(cant ===  countpros){
                                            t1='100%';
                                        }else{
                                            t1=t+'%';
                                        }
                                    }
                                    
                                    progressbar.progressbar( "option", {
                                        value: Math.floor(t)
                                    });
                                }//if                                
                                $("#numeroporcentaje").html(t1);
                                $('#cant_Temp').val($("#cant_pg").val());
                                $("#cant_pg").val(t1);
                                i=i+1;
                                actualizarEstados();
                            }//else
                        }//if Validar
                        <?PHP
                    }//else
                    ?>
                });//body
            });//function

            function actualizarEstados(){
                var Porcentaje  = $("#cant_pg").val();	                  
                if(!$.trim($('#cedula_num').val())){                    
                    /*********************************************/                
                    if(Porcentaje==='100%'){                        
                        var cedula_num  = $('#cedula_num').val();						
                        /**********************************************/
                        $.ajax({//Ajax
                            type: 'POST',
                            url: 'instrumento_publico_html.php',
                            async: false,
                            dataType: 'json',
                            data:({actionID: '<?php if($userid==null && isset($n) && $n!=""){ echo "FinalizoExtreno"; }else { echo "Finalizo";} ?>',Instrumento_id:<?PHP echo $id_instrumento?>,
                            Grupo_id:'<?PHP echo $Grupo_id?>',CodigoEstudiante:'<?PHP echo $CodigoEstudiante?>',
                            CodigoJornada:'<?PHP echo $CodigoJornada?>',
                            Userid: '<?php echo $userid; ?>', cedula: cedula_num}),
                            error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                            success: function(data){
                                if(data.val==='FALSE'){
                                    alert(data.descrip);
                                    return false;
                                }else{
                                    /*************************************/
                                    var UserName  = $('#Username').val();
                                    alert('Se Ha Finalizado Con Exito');
                                    $.ajax({//Ajax
                                        type: 'POST',
                                        url: 'instrumento_publico_html.php',
                                        async: false,
                                        dataType: 'json',
                                        data:({actionID: 'CargarSession', id_instrumento: <?php echo $id_instrumento; ?>}),
                                        error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                                        success: function(data){
                                            if(data.val==='FALSE'){
                                                alert(data.descrip);
                                                return false;
                                            }else{                                                
                                                $('#botonfinalizar').show();
                                                /********************************************/
                                                if(data.Permiso===1 || data.Permiso==='1'){   
                                                    if(data.tipoUser===600 || data.tipoUser==='600'){
                                                        if(data.Rol===1 ||  data.Rol==='1'){
                                                            window.parent.continuar();//Para Estudiantes
                                                        }//if
                                                        else{
                                                            location.href='../../../consulta/entrada/index.php';
                                                        }
                                                    }//if
                                                    else{
                                                        location.href='../../../consulta/entrada/index.php';
                                                    }
                                                }else{
                                                    /*************************************************/
                                                    if(data.tipoUser===600 || data.tipoUser==='600'){
                                                        if(data.Rol===1 ||  data.Rol==='1'){
                                                            window.parent.continuar();//Para Estudiantes
                                                        }//if
                                                    }//if
                                                    /************************************************/
                                                    if(data.tipoUser===400 || data.tipoUser==='400'){
                                                        if(data.Rol===3  ||  data.Rol==='3'){
                                                            window.parent.continuar3();//Para Admin
                                                        }//if
                                                    }//if
                                                    if(data.tipoUser===500 || data.tipoUser==='500'){
                                                        if(data.Rol===2  ||  data.Rol==='2'){
                                                            window.parent.continuar();//Para Docentes  
                                                        }//if
                                                    }//if
                                                }//else
                                                /********************************************/
                                            }//else
                                        }//success data
                                    }); //AJAX
                                    /*************************************/
                                }//else
                            }//data
                        }); //AJAX
                        /**********************************************/
                    }//if porcentaje 100
                    else{                    
                        /**********************************************/                        
                        $.ajax({//Ajax
                            type: 'POST',
                            url: 'instrumento_publico_html.php',
                            async: false,
                            dataType: 'json',
                            data:({actionID: 'SinFinalizar',Instrumento_id:'<?PHP echo $id_instrumento?>', id:'<?PHP echo $userid ?>'}),
                            error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                            success: function(data){
                                if(data.val==='FALSE'){
                                    alert(data.descrip);
                                    return false;
                                }
                            }//data
                        }); //AJAX
                        /**********************************************/
                    }//else                                    
                    /************************************************/
                }else{	
                    //Cedula                 
                    var Porcentaje  = $("#cant_pg").val();             
                    /**********************************************/
                    if(Porcentaje==='100%'){                
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
                            error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                            success: function(data){
                                if(data.val==='FALSE'){
                                    alert(data.descrip);
                                    return false;
                                }else{
                                    /*************************************/
                                    var UserName  = $('#Username').val();              
                                    var cedula_num  = $('#cedula_num').val();
                                    alert('Se Ha Finalizado Con Exito');
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
                            error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                            success: function(data){
                                if(data.val==='FALSE'){
                                    alert(data.descrip);
                                    return false;
                                }
                            }//data
                        }); //AJAX
                        /**********************************************/            
                    }//if                
                }//if Cedula
            }//function actualizarEstados

            function sendForm(){
                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: 'process_ins.php',
                    async: false,
                    data: $('#form_test').serialize(),
                    success:function(data){
                        if (data.success === true){
                            alert(data.message);
                            //actualizarEstados();
                        }else{
                            $('#msg-error').html('<p>' + data.message + '</p>');
                            $('#msg-error').addClass('msg-error');
                        }
                    },
                    error: function(data,error,errorThrown){alert(error + errorThrown);}
                });
            }//function sendForm
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