<?php
class Spadies{
    /**************************************************************************/
    public function Display(){
    global $db;

    ?>
    <div id="container">
    <div class="titulo">Reportes Spadies</div>
        <fieldset >
            <legend>Reportes Spadies</legend>
            <div style="text-align: left;">
                <img src="../img/spadies.png" width="30" title="Ir al SPADIES" onclick="Externo()" style="cursor: pointer;" />
            </div>
            <div style="text-align: right;">
            <img src="../img/ChronologicalReview.png" width="30" title="Ver Datos de Control" onclick="Auditoria()" style="cursor: pointer;" />
            </div>
            <br />
            <table border="0" cellpadding="0" cellspacing="0" class="display" align="center" width="100%">
                <thead>
                    <tr>
                        <th>Tipo de Reporte</th>
                        <th>
                            <select id="TypeRepote" name="TypeRepote" style="width: auto;" onchange="BuscarText()">
                                <option value="-1"></option>
                                <option value="0">Primer Nivel</option>
                                <option value="1">Matriculados</option>
                                <option value="2">Graduados</option>
                                <option value="3">Retiros Disciplinarios</option>
                                <option value="4">Apoyos Acad&eacute;micos</option>
                                <option value="5">Apoyos Financieros</option>
                                <option value="6">Otros Apoyos</option>
                            </select>
                        </th>
                        <th>&nbsp;</th>
                        <th>Modalidad Acad&eacute;mica</th>
                        <th>
                            <select id="Modalidad" name="Modalidad" onchange="BuscarCarreras()">
                                <option value="1">Todos</option>
                                <option value="200">Pregrado</option>
                                <option value="300">Posgrado</option>
                            </select>
                        </th>

                        <th>&nbsp;</th>
                        <th>Programa Acad&eacute;mico</th>
                        <th>
                            <table border="0" width="100%">
                                <tr>
                                    <th>
                                        <div id="DivCarreras">
                                            <select id="Carrera_id" name="Carrera_id" style="width:85%;">
                                                <option value="-1"></option>
                                            </select>    
                                        </div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>&nbsp;<input type="checkbox" id="All_Carreras" onclick="Todas()" title="Todas las Carreras" /><strong>Todas</strong></th>
                                </tr>
                            </table>
                       </th>
                    </tr>
                    <tr id="Tr_info" style="visibility: collapse;">
                        <td colspan="5" id="Th_Info"></td>
                    </tr>
                    <tr>
                        <th class="titulo_label">Periodo</th>
                        <?PHP 
                        $C_Periodo=$this->Periodo('Todos','','');
                        ?>
                        <th>
                            <select id="Periodo" name="Periodo">
                                <?PHP 
                                for($i=0;$i<count($C_Periodo);$i++){
                                    /************************************/
                                    if($C_Periodo[$i]['codigoestadoperiodo']==1){
                                        $Selectd  = 'selected="selected"';
                                    }else{
                                        $Selectd  = '';
                                    }
                                    ?>
                                    <option <?PHP echo $Selectd?> value="<?PHP echo $C_Periodo[$i]['codigoperiodo']?>"><?PHP echo $C_Periodo[$i]['codigoperiodo']?></option>
                                    <?PHP
                                    /************************************/
                                }//for
                                ?>
                            </select>
                        </th>
                        <th>&nbsp;</th>
                        <th class="titulo_label">Semestre</th>
                        <th>
                            <select id="TypeSemestre" name="TypeSemestre" style="width: auto;">
                                <option value="-1">Todos</option>
                                <?PHP 
                                for($i=1;$i<=12;$i++){
                                    /***************************/
                                    ?>
                                    <option value="<?PHP echo $i?>"><?PHP echo $i?></option>
                                    <?PHP
                                    /***************************/
                                }//for
                                ?>
                            </select>
                        </th>

                    </tr>
                    <tr>
                        <th colspan="5" align="center">&nbsp;</th>
                    </tr>
                    <tr>
                        <th colspan="5" align="center"><button class="submit" type="button" tabindex="3" onclick="CargarInfo()">Buscar</button></th>
                    </tr>
                    <tr>
                        <th colspan="5">
                            <div style="text-align: center; display: none;" id="Auditoria_Div" >
                            button_cancel.png
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" align="center">
                            <hr style="width:95%;margin-left: 2.5%;" align="center" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" align="left">
                            <div id="Rerporte" style="width: 95%;margin-left: 2.5%;height:auto;" >

                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <input type="hidden" id="Cadena" />
        </fieldset>
    </div>
    <?PHP
    }//public function Display
    public function Periodo($Opcion,$Periodo_ini='',$Periodo_fin=''){
    global  $db;

    if($Opcion=='Actual'){
    $Condicion ='';
    }else if($Opcion=='Cadena'){

    $Condicion ='WHERE  codigoperiodo BETWEEN "'.$Periodo_ini.'" AND "'.$Periodo_fin.'"';
    }else if($Opcion=='Todos'){

    $Condicion ='ORDER BY codigoperiodo DESC';//codigoestadoperiodo, 
    }

    $SQL='SELECT 

        codigoperiodo,
        codigoestadoperiodo

        FROM 

        periodo

        '.$Condicion;

    if($Periodo=&$db->Execute($SQL)===false){
        echo 'Error en Calcular el Periodo...<br><br>'.$SQL;
        die;
    } 

    if($Opcion=='Actual'){
        $C_Periodo  = $Periodo->GetArray();
        return $C_Periodo;
    }else if($Opcion=='Cadena' || $Opcion=='Todos'){

        $C_Periodo  = $Periodo->GetArray();

        return $C_Periodo;
    }    
    }//public function Periodo
    public function Carreras($Modalidad='',$View=''){
    global $db;

    if(!$Modalidad){
    $Modalidad = '200';
    }else if($Modalidad=='1' || $Modalidad==1){
    $Modalidad= '"200","300"';
    }

    $SQL='SELECT 

        codigocarrera,
        nombrecarrera,
        codigomodalidadacademicasic 

        FROM 

        carrera

        WHERE

        codigomodalidadacademicasic IN ('.$Modalidad.')
        AND
        codigocarrera NOT IN (354,6,428,7,120,600,605)


        ORDER BY nombrecarrera ASC';

    if($Carreras=&$db->Execute($SQL)===false){
        echo 'Error en el SQL de las Carreras...<br><br>'.$SQL;
        die;
    }     

    $C_Carrera  = $Carreras->GetArray();    


    if(!$View){

    return $C_Carrera;

    }else{

    ?>
    <select id="Carrera_id" name="Carrera_id" style="width:85%;">
        <option value="-1"></option>
    <?PHP 
    for($i=0;$i<count($C_Carrera);$i++){
            ?>
            <option value="<?PHP echo $C_Carrera[$i]['codigocarrera']?>"><?PHP echo $C_Carrera[$i]['nombrecarrera']?></option>
            <?PHP 
        }//for
    ?>
    </select>
    <?PHP

    }  

    }//public function Carreras
    public function Reportes($TypeRepote,$Carrera_id,$Periodo,$TypeSemestre,$OP='',$Modalidad,$string=false,$Excel=false){
    global $db;


    // $Periodo = '20091';
    /***************************************************************************/
    if($OP!=1){
    ?>
    <input id="Carrera_id" value="<?PHP echo $Carrera_id?>" type="hidden" />
    <input id="Reporte" value="<?PHP echo $TypeRepote?>" type="hidden" />
    <input id="Periodo_id" value="<?PHP echo $Periodo?>" type="hidden" />
    <input id="Semestre" value="<?PHP echo $TypeSemestre?>" type="hidden" />
    <input id="Modalidad" value="<?PHP echo $Modalidad?>" type="hidden" />
    <?PHP 
    }

    /***************************************************************************/    
    if($TypeRepote==0 || $TypeRepote=='0'){
    /***********************************************************************/
    $string = true;
    $this->PrimerNivel($Carrera_id,$Periodo,$TypeSemestre,$OP,$Modalidad,$string,$Excel);
    /***********************************************************************/
    }
    /***************************************************************************/
    if($TypeRepote==1 || $TypeRepote=='1'){
    /***********************************************************************/
    $this->Matriculados($Carrera_id,$Periodo,$TypeSemestre,$OP,$Modalidad,$Excel);
    /***********************************************************************/
    }
    /***************************************************************************/
    if($TypeRepote==2 || $TypeRepote=='2'){
    /***********************************************************************/
    $D_Graduados =$this->Graduados($Carrera_id,$Periodo,$Modalidad,$Excel);
    $this->TableGraduados($D_Graduados,$OP);
    /***********************************************************************/
    }
    /***************************************************************************/
    if($TypeRepote==3 || $TypeRepote=='3'){
    /***********************************************************************/
    $D_Diciplinario = $this->Disiplinarios($Periodo,$Carrera_id,$Modalidad);
    $this->TablaDisplinario($D_Diciplinario,$OP);
    /***********************************************************************/
    }
    /***************************************************************************/
    if($TypeRepote==4 || $TypeRepote=='4'){
    /***********************************************************************/
    $this->ApoyosAcademicos($Carrera_id,$Periodo,$OP,$Modalidad);
    /***********************************************************************/
    }
    /***************************************************************************/    
    if($TypeRepote==5 || $TypeRepote=='5'){
    /***********************************************************************/
    $this->ApoyosFinacieros($Carrera_id,$Periodo,$OP,$Modalidad);
    /***********************************************************************/
    }
    /***************************************************************************/ 
    if($TypeRepote==6 || $TypeRepote=='6'){
    /***********************************************************************/
    $this->OtrosApoyos($Periodo,$OP);
    /***********************************************************************/
    }
    /***************************************************************************/     
    if($OP!=1){
    ?>
    <button id="ExcelButton" name="ExcelButton" onclick="GeneraExcel()">Excel</button>
    <!--<a href="" onclick="GeneraCSV();" style="margin-left:10px;">Exportar a csv</a>-->
    <button id="ExcelButton" name="ExcelButton" onclick="GeneraCSV()" style="margin-left:10px;">Exportar a csv</button>
    <form style="display: hidden" action="" method="POST" id="formcsv">
        <input type="hidden" id="csvdata" name="csvdata" value=""/>
    </form>
    <?PHP
    }
    if($TypeRepote==5 || $TypeRepote=='5'){
    if(!isset ($_SESSION['MM_Username'])){
        $_SESSION['MM_Username']  = 'equipomgi';
    }
    ?>
    <br />
    <br />
    <a onclick="InformeMGI()" title="" style="cursor: pointer;">Informaci&oacute;n MGI</a>
    <?PHP
    }
    }//public function Reportes
    public function PrimerNivel($Carrera_id,$Periodo,$TypeSemestre,$op='',$Modalidad,$string=false,$Excell=false){ 
    global $db,$userid;

    include_once('../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');

    $D_Estadista = new obtener_datos_matriculas($db,$Periodo);

    if($string){
    include_once('../../utilidades/funcionesTexto.php');
    }

    if($TypeSemestre=='-1' || $TypeSemestre==-1){
    $filtro = 0;
    }else{
    $filtro = 1;
    }

    if($Carrera_id==0 || $Carrera_id=='0'){

    $Carrera   = $this->Carreras($Modalidad,'');


    $D_Estudiante = array();

    for($i=0;$i<count($Carrera);$i++){

        $Carrera_id    = $Carrera[$i]['codigocarrera'];

            $C_PrimerNivel  = $D_Estadista->obtener_datos_estudiantes_matriculados_nuevos_homologacion($Carrera_id,'arreglo','',$Modalidad);       
            //obtener_datos_estudiantes_matriculados_nuevos 
            //$C_PrimerNivel   = $D_Estadista->obtener_total_matriculados($Carrera_id,'arreglo');   

        //echo '<br>Carrera_id->'.$Carrera_id;
       // echo '<pre>';print_r($D_Estudiante);die;
     //  echo '<br>num->'.count($C_PrimerNivel);die;

        for($j=0;$j<count($C_PrimerNivel);$j++){
        /*********************************************/

            $E_Data  = $this->DataEstudiante($C_PrimerNivel[$j]['codigoestudiante'],$Periodo,$TypeSemestre,$filtro);

            $D_Estudiante[] = $E_Data;
            /*********************************************/
        }//for

    }//for

    //echo '<pre>';print_r($D_Estudiante);die;

    }else{

    //$C_PrimerNivel  = $D_Estadista->obtener_datos_estudiantes_matriculados_nuevos($Carrera_id,'arreglo',$Modalidad,'');
    $C_PrimerNivel   = $D_Estadista->obtener_datos_estudiantes_matriculados_nuevos_homologacion($Carrera_id,'arreglo','',$Modalidad); 
    //echo '<pre>';print_r($C_PrimerNivel);

    $D_Estudiante = array();

    for($i=0;$i<count($C_PrimerNivel);$i++){
        /*********************************************/

        if($TypeSemestre=='-1' || $TypeSemestre==-1){

           $X = 0; 

        }else{

            $X = 1;

        }//if

        $E_Data  = $this->DataEstudiante($C_PrimerNivel[$i]['codigoestudiante'],$Periodo,$TypeSemestre,$X);

        $D_Estudiante[] = $E_Data;
        /*********************************************/
    }//for

    }



    //echo '<pre>';print_r($D_Estudiante);die;
    //echo '<br>Num2->'.count($D_Estudiante);
    ?>
    <table border="1" align="center">
    <thead>
        <tr>
            <th>apellidos</th>
            <th>nombres</th>
            <th>tipoDocumento</th>
            <th>documento</th>
            <th>nombrePrograma</th>
            <th>codigoEstudiante</th>
            <th>sexo</th>
            <th>fechaNacimiento</th>
            <th>codigoSNIESprograma</th>
        </tr>
    </thead>
    <tbody>
        <?PHP 
        $N = 1;
        //echo '<pre>';print_r($D_Estudiante);die;
        for($j=0;$j<count($D_Estudiante);$j++){
            /***********************************************/
            /*
            [CodigoEstudiante] => 51225
            [Nombre] => SANTIAGO
            [Apellido] => CASTRO DIAZ
            [Tipo_Doc] => CC
            [Codigo_Doc] => 01
            [Documento] => 1020766607
            [Programa] => ADMINISTRACION DE EMPRESAS
            [Genero] => Masculino
            [Codigo_Genero] => 200
            [Fecha_Naci] => 1991-11-06 00:00:00
            */

            if($D_Estudiante[$j]['CodigoEstudiante']){
                if($D_Estudiante[$j]['Codigo_Doc']==01 || $D_Estudiante[$j]['Codigo_Doc']=='01'){
                    $Tipo_Doc = 'C';
                }else if($D_Estudiante[$j]['Codigo_Doc']==02 || $D_Estudiante[$j]['Codigo_Doc']=='02'){
                    $Tipo_Doc = 'T';
                }else if($D_Estudiante[$j]['Codigo_Doc']==03 || $D_Estudiante[$j]['Codigo_Doc']=='03'){
                    $Tipo_Doc = 'E';
                }else if($D_Estudiante[$j]['Codigo_Doc']==04 || $D_Estudiante[$j]['Codigo_Doc']=='04'){
                    $Tipo_Doc = 'R';
                }else{
                    $Tipo_Doc = 'O';
                }

                if($D_Estudiante[$j]['Codigo_Genero']==100 || $D_Estudiante[$j]['Codigo_Genero']=='100'){
                    $Genero  = 'F';
                }else if($D_Estudiante[$j]['Codigo_Genero']==200 || $D_Estudiante[$j]['Codigo_Genero']=='200'){
                    $Genero  = 'M';
                }

                $C_Fecha   = explode('-',$D_Estudiante[$j]['Fecha_Naci']); 

                $Fecha     = $C_Fecha[2].'/'.$C_Fecha[1].'/'.$C_Fecha[0];

                $CodigoSNIES  = $this->CodigoSnies($D_Estudiante[$j]['codigocarrera']);

               $N++; 
               //$apellido = strtoupper(sanear_string($D_Estudiante[$j]['Apellido']));
               $apellido = ($D_Estudiante[$j]['Apellido']);
               $nombre = ($D_Estudiante[$j]['Nombre']);
              /* $nombre = strtoupper(sanear_string($D_Estudiante[$j]['Nombre']));*/
              $name = $this->NameProgramaCambio($D_Estudiante[$j]['codigocarrera']);
              if($name==1){
                $nameData = $D_Estudiante[$j]['Programa'];
              }else{
                $nameData = $name;
              }
              if($string){
               $apellido = sanear_string($apellido,false);
               $nombre   = sanear_string($nombre,false);
               $nameData   = sanear_string($nameData,false);                   
              }
              if($Excell){
                  $Nombre_Print   = utf8_decode(strtoupper($nombre));
                  $Apellido_Print = utf8_decode(strtoupper($apellido));
                  $DataName_Print = utf8_decode(strtoupper($nameData));
              }else{
                  $Apellido_Print   = strtoupper($apellido);
                  $Nombre_Print     = strtoupper($nombre);
                  $DataName_Print   = strtoupper($nameData);
              }    
              ?>
                <tr>
                    <td><?PHP echo $Apellido_Print;?></td>
                    <td><?PHP echo $Nombre_Print;?></td>
                    <td><?PHP echo $Tipo_Doc?></td>
                    <td><?PHP echo $D_Estudiante[$j]['Documento']?></td>
                    <td><?PHP echo $DataName_Print;?></td>
                    <td><?PHP echo $D_Estudiante[$j]['CodigoEstudiante']?></td>
                    <td><?PHP echo $Genero?></td>
                    <td><?PHP echo $Fecha?></td>
                    <td><?PHP echo $CodigoSNIES?></td>     
                </tr>
                <?PHP  
            }

            /***********************************************/
        }//for
        $R = $N-1;
        ?>
    </tbody>
    </table>

    <?PHP  

    if($op==1){
    /*
    TipoReporte este campo puede almacenar los siguientes valores 

    -0-->Primer Nivel
    -1-->Matriculados
    -2-->Graduados
    -3-->Retiros Disciplinarios
    -4-->Apoyos Acad&eacute;micos
    -5-->Apoyos Financieros
    -6-->Otros Apoyos

    */
    $Insert='INSERT INTO AuditoriaSpadies(TipoReporte,NumRegistros,Userid,entrydate)VALUES("0","'.$R.'","'.$userid.'",NOW())';

    /*if($TablaAuditoria=&$db->Execute($Insert)===false){
        echo 'Error en el Insert de la talba de Auditoria del SPADIES...<br><br>'.$Insert;
        die;
    }*/
    }

    }//public function PrimerNivel  
    public function NameProgramaCambio($CodigoCarrera){
    /**
    118	INGENIERIA ELECTRONICA
    119	INGENIERIA ELECTRONICA N
    123	ING. SISTEMAS DIURNA
    124	ING. SISTEMAS NOCTURNA
    133	PSICOLOGIA
    134	PSICOLOGIA-NOCTURNA
    */
    switch($CodigoCarrera){
    case '118':{return $name='INGENIERIA ELECTRONICA';}break;
    case '119':{return $name='INGENIERIA ELECTRONICA';}break;
    case '123':{return $name='INGENIERIA DE SISTEMAS';}break;
    case '124':{return $name='INGENIERIA DE SISTEMAS';}break;
    case '133':{return $name='PSICOLOGIA';}break;
    case '134':{return $name='PSICOLOGIA';}break;
    default:{
       return 1;
    }exit;
    }
    }//public function NameProgramaCambio
    public function DataEstudiante($CodigoEstudiante,$Periodo,$Semestre='',$op){
    global $db;

    if($op==0){
    $Consulta = '';
    $Union = ' UNION 
                (SELECT  

                e.codigoestudiante,
                e.idestudiantegeneral,
                eg.nombresestudiantegeneral,
                eg.apellidosestudiantegeneral,
                eg.tipodocumento,
                d.nombrecortodocumento,
                eg.numerodocumento,
                e.codigocarrera,
                c.nombrecarrera,
                eg.codigogenero,
                g.nombregenero,
                date(eg.fechanacimientoestudiantegeneral) as Fecha,
                "" as semestreprematricula,
                o.idprematricula,
                0 as matriculadas

                FROM estudiante e 
                INNER JOIN estudiantegeneral eg ON e.idestudiantegeneral=eg.idestudiantegeneral
                     INNER JOIN carrera c ON e.codigocarrera=c.codigocarrera
                     INNER JOIN genero g ON eg.codigogenero=g.codigogenero
                     INNER JOIN documento d ON eg.tipodocumento=d.tipodocumento
                INNER JOIN ordenpago o ON o.codigoestudiante=e.codigoestudiante AND o.codigoestadoordenpago IN (40,41)
                INNER JOIN detalleordenpago dop ON dop.numeroordenpago=o.numeroordenpago AND dop.codigoconcepto=151 
                WHERE 
                o.codigoperiodo="'.$Periodo.'" AND e.codigoestudiante="'.$CodigoEstudiante.'" and o.idprematricula=1
                GROUP BY e.idestudiantegeneral)';
    }else{
    $Consulta = '  AND  p.semestreprematricula="'.$Semestre.'"';
    $Union = '';
    }

    $SQL='(SELECT 

        e.codigoestudiante,
        e.idestudiantegeneral,
        eg.nombresestudiantegeneral,
        eg.apellidosestudiantegeneral,
        eg.tipodocumento,
        d.nombrecortodocumento,
        eg.numerodocumento,
        e.codigocarrera,
        c.nombrecarrera,
        eg.codigogenero,
        g.nombregenero,
        date(eg.fechanacimientoestudiantegeneral) as Fecha,
        p.semestreprematricula,
        p.idprematricula,
        COUNT(dp.codigomateria) as matriculadas

        FROM 

        estudiante e INNER JOIN estudiantegeneral eg ON e.idestudiantegeneral=eg.idestudiantegeneral
                     INNER JOIN carrera c ON e.codigocarrera=c.codigocarrera
                     INNER JOIN genero g ON eg.codigogenero=g.codigogenero
                     INNER JOIN documento d ON eg.tipodocumento=d.tipodocumento
                     INNER JOIN prematricula p ON e.codigoestudiante=p.codigoestudiante
                    LEFT JOIN detalleprematricula dp on dp.idprematricula=p.idprematricula and dp.codigoestadodetalleprematricula=30
        WHERE

        e.codigoestudiante="'.$CodigoEstudiante.'"		
        AND
        p.codigoestadoprematricula IN (40,41)
        AND
        p.codigoperiodo="'.$Periodo.'"'.$Consulta." 
        	AND e.codigoestudiante NOT IN (
			SELECT
				codigoestudiante
			FROM
				estudiantesituacionmovilidad
			WHERE
				idsituacionmovilidad IN ('4', '5', '10', '11', '12', '13', '14', '15', '16')
                AND periodoinicial <= '".$Periodo."' and periodofinal >= '".$Periodo."') 
            GROUP BY p.idprematricula)
        ".$Union." 
            ORDER BY matriculadas DESC";     
     if($CodigoEstudiante=='27261' || $CodigoEstudiante==27261){
        echo $SQL;die;
     }  
     if($Data=&$db->Execute($SQL)===false){
        echo 'Error en el SQl De Data Estudiante...<br><br>'.$SQL;
        die;
     }   
       // echo '<pre>'; print_r($SQL); die;
    $C_Data  = array();
    /*if($CodigoEstudiante==51803){
    echo $SQL;
    var_dump($Data->EOF);die;
    }*/

    if(!$Data->EOF){

        $CodigoEstudiante   = $Data->fields['codigoestudiante'];
        $Nombre             = $Data->fields['nombresestudiantegeneral'];
        $Apellido           = $Data->fields['apellidosestudiantegeneral'];
        $Tipo_Doc           = $Data->fields['nombrecortodocumento'];
        $Codigo_Doc         = $Data->fields['tipodocumento'];
        $Documento          = $Data->fields['numerodocumento'];
        $Programa           = $Data->fields['nombrecarrera'];
        $codigocarrera      = $Data->fields['codigocarrera'];
        $Genero             = $Data->fields['nombregenero'];
        $Codigo_Genero      = $Data->fields['codigogenero'];
        $Fecha_Naci         = $Data->fields['Fecha']; 

    $SQL_M='SELECT 

            count(dp.idprematricula) AS Num


            FROM 

            detalleprematricula dp INNER JOIN materia m ON dp.codigomateria=m.codigomateria

            WHERE 

            dp.idprematricula="'.$Data->fields['idprematricula'].'"
            AND 
            dp.codigoestadodetalleprematricula =30
            AND 
            dp.codigotipodetalleprematricula=10';

        if($Materias_R=&$db->Execute($SQL_M)===false){
            echo 'Error en el SQL De las MAterias Reguistradas....<br><br>'.$SQL_M;
            die;
        }  

    $SQL_A='SELECT 
                    COUNT(*) AS Aprobadas 
          FROM 
                    notahistorico 
          WHERE 
                    codigoestudiante ="'.$Data->fields['codigoestudiante'].'"  
                    AND 
                    codigoperiodo = "'.$Periodo.'" 
                    AND 
                    notadefinitiva >= 3 
                    AND 
                    codigoestadonotahistorico=100';    

              if($MateriasAProbadas=&$db->Execute($SQL_A)===false){
                    echo 'Error en el SQL de laas Aprobadas...<br><br>'.$SQL_A;
                    die;
              }          
        $Materias = $Materias_R->fields['Num'];
        $AProbadas = $MateriasAProbadas->fields['Aprobadas'];


       /*if($CodigoEstudiante==51803){
        echo $SQL_M."<br/><br/>".$SQL_A."<br/><br/>";
        echo $Materias." - ".$AProbadas; die;
       }*/
        $C_Data['CodigoEstudiante']   = $CodigoEstudiante;
        $C_Data['Nombre']             = $Nombre;
        $C_Data['Apellido']           = $Apellido;
        $C_Data['Tipo_Doc']           = $Tipo_Doc;
        $C_Data['Codigo_Doc']         = $Codigo_Doc;
        $C_Data['Documento']          = $Documento;
        $C_Data['Programa']           = $Programa;
        $C_Data['codigocarrera']      = $codigocarrera;
        $C_Data['Genero']             = $Genero;
        $C_Data['Codigo_Genero']      = $Codigo_Genero;
        $C_Data['Fecha_Naci']         = $Fecha_Naci;  
        $C_Data['Materias_R']         = $Materias;
        $C_Data['Materias_A']         = $AProbadas;

    }


    return $C_Data;

    }//public function DataEstudiante
    public function Matriculados($Carrera_id,$Periodo,$TypeSemestre,$op='',$Modalidad,$Excel=false){
    global $db,$userid;  

    include_once('../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');
    include_once('../../utilidades/funcionesTexto.php');

    $D_Estadista = new obtener_datos_matriculas($db,$Periodo);

    if($TypeSemestre=='-1' || $TypeSemestre==-1){
    $filtro = 0;
    }else{
    $filtro = 1;
    }
    //echo '<pre>';print_r($D_Estudiante);

    if($Carrera_id==0 || $Carrera_id=='0'){

    $Carrera   = $this->Carreras($Modalidad,'');
    //echo '<pre>';print_r($Carrera);die;
    } else {
    $Carrera[0]['codigocarrera'] = $Carrera_id;
    }
    $C_Matriculados  = array();

    $Total = 0;
    for($i=0;$i<count($Carrera);$i++){

        $Carrera_id    = $Carrera[$i]['codigocarrera'];//nombrecarrera        
        $D_Estudiante = $D_Estadista->obtener_total_matriculados($Carrera_id,'arreglo','1');//1= estudiantes extranjeros 
        $D_Estudiante2 = $D_Estadista->EgresadosNoMatriculados($Carrera_id,$Periodo,'1');//1= estudiantes extranjeros 
        $Num = count($D_CarresaName[$Carrera[$i]['nombrecarrera']]);
        //$Total = $Total+$Num;
        //$Total= $Total+count($D_Estudiante);
        //var_dump($D_Estudiante2); 
        for($j=0;$j<count($D_Estudiante);$j++){
            /*********************************************/
            //$D_Matriculados  = $this->DataEstudianteMatriculados($D_Estudiante[$j]['codigoestudiante'],$Periodo,$TypeSemestre,$filtro);
            $D_Matriculados  = $this->DataEstudiante($D_Estudiante[$j]['codigoestudiante'],$Periodo,$TypeSemestre,$filtro);
            $C_Matriculados[]   = $D_Matriculados;

            /*********************************************/
        }//for
        for($z=0;$z<count($D_Estudiante2);$z++){ 
            $D_Matriculados2  = $D_Estadista->DataEstudianteNoMatriculados($D_Estudiante2[$z]['codigoestudiante']);
            $C_Matriculados[]   = $D_Matriculados2;
        }
    //var_dump(count($C_Matriculados));
        /*for($z=0;$z<count($D_Estudiante2);$z++){ 
            /*********************************************/
            /*$identificador=false;
            for($j=0;$j<count($D_Estudiante);$j++){  /* Compara duplicados*/
                /*if ($D_Estudiante2[$z]['codigoestudiante']  == $D_Estudiante[$j]['codigoestudiante']){
                    $identificador = true;
                }
            }
            if ($identificador == false){
                if($TypeSemestre=='-1' || $TypeSemestre==-1){
                    $X = 0;
                }else{
                    $X  = 1;
                }//if
                $D_Matriculados2  = $D_Estadista->DataEstudianteNoMatriculados($D_Estudiante2[$z]['codigoestudiante']);
                $C_Matriculados[]   = $D_Matriculados2;
            }

            /*********************************************/
        //}//for

    }//for
    // echo '<br>Total->'.$Total;

    ?>
    <table border="1" align="center">
    <thead>
        <tr>

            <th>apellidos</th>
            <th>nombres</th>
            <th>tipoDocumento</th>
            <th>documento</th>
            <th>nombrePrograma</th>
            <th>materiasTomadas</th>
            <th>materiasAprobadas</th>
        </tr>
    </thead>
    <tbody>
        <?PHP $N = 1;
        for($j=0;$j<count($C_Matriculados);$j++){
            if($C_Matriculados[$j]['CodigoEstudiante']){
                if($C_Matriculados[$j]['Codigo_Doc']==01 || $C_Matriculados[$j]['Codigo_Doc']=='01'){
                    $Tipo_Doc = 'C';
                }else if($C_Matriculados[$j]['Codigo_Doc']==02 || $C_Matriculados[$j]['Codigo_Doc']=='02'){
                    $Tipo_Doc = 'T';
                }else if($C_Matriculados[$j]['Codigo_Doc']==03 || $C_Matriculados[$j]['Codigo_Doc']=='03'){
                    $Tipo_Doc = 'E';
                }else if($C_Matriculados[$j]['Codigo_Doc']==04 || $C_Matriculados[$j]['Codigo_Doc']=='04'){
                    $Tipo_Doc = 'R';
                }else{
                    $Tipo_Doc = 'O';
                }
              $N++;


                $X = $j+1;


              $name = $this->NameProgramaCambio($C_Matriculados[$j]['codigocarrera']);
              if($name==1){
                $nameData = $C_Matriculados[$j]['Programa'];
              }else{
                $nameData = $name;
              }  


              $nameData = sanear_string($nameData,false);
              $Apellido = sanear_string($C_Matriculados[$j]['Apellido'],false);
              $Nombre =   sanear_string($C_Matriculados[$j]['Nombre'],false);
                
              if($Excel){
                  $Apellido_Print = utf8_decode(strtoupper($Apellido));
                  $Nombre_Print   = utf8_decode(strtoupper($Nombre));
                  $DataName_Print = utf8_decode(strtoupper($nameData));
              }else{
                  $Apellido_Print = strtoupper($Apellido);
                  $Nombre_Print   = strtoupper($Nombre);
                  $DataName_Print = strtoupper($nameData); 
              }    
             ?>

             <tr>

                <td><?PHP echo $Apellido_Print;?></td>
                <td><?PHP echo $Nombre_Print;?></td>
                <td><?PHP echo $Tipo_Doc?></td>
                <td><?PHP echo $C_Matriculados[$j]['Documento']?></td>
                <td><?PHP echo $DataName_Print;?></td>					
                <td><?PHP echo $C_Matriculados[$j]['Materias_R']?></td>
                <td><?PHP echo $C_Matriculados[$j]['Materias_A']?></td>
             </tr>
             <?PHP   
            }//if
        }//for
        $R = $N-1;
        ?>
    </tbody>
    </table>    
    <?PHP
    if($op==1){
    /*
    TipoReporte este campo puede almacenar los siguientes valores 

    -0-->Primer Nivel
    -1-->Matriculados
    -2-->Graduados
    -3-->Retiros Disciplinarios
    -4-->Apoyos Acad&eacute;micos
    -5-->Apoyos Financieros
    -6-->Otros Apoyos

    */
    $Insert='INSERT INTO AuditoriaSpadies(TipoReporte,NumRegistros,Userid,entrydate)VALUES("1","'.$R.'","'.$userid.'",NOW())';

    if($TablaAuditoria=&$db->Execute($Insert)===false){
        echo 'Error en el Insert de la talba de Auditoria del SPADIES...<br><br>'.$Insert;
        die;
    }
    }

    }//public function Matriculados
    public function Graduados($Carrera_id,$CodigoPeriodo,$Modalidad){
    global $db,$userid;

    $SQL_F='SELECT 

            date(fechainicioperiodo) AS fecha_ini,
            date(fechavencimientoperiodo) AS fecha_fin
            FROM 

            periodo

            WHERE

            codigoperiodo="'.$CodigoPeriodo.'"';

          if($Fecha=&$db->Execute($SQL_F)===false){
            echo 'Error en el SQL Fecha...<br>'.$SQL_F;
            die;
          }  

    if($Carrera_id==0 || $Carrera_id=='0'){
    $Consulta  = '';
    }else{
    $Consulta  = '  AND e.codigocarrera="'.$Carrera_id.'"';
    }

    if($Modalidad==1 || $Modalidad=='1'){

     $Modalidad= '"200","300"';

    }

    $SQL='SELECT 

        r.idregistrograduado,
        r.codigoestudiante,
        r.fechagradoregistrograduado,
        eg.nombresestudiantegeneral,
        eg.apellidosestudiantegeneral,
        d.nombrecortodocumento,
        eg.numerodocumento,
        c.nombrecarrera,
        eg.tipodocumento,
        c.codigocarrera
        FROM 
        registrograduado r INNER JOIN  estudiante e ON e.codigoestudiante=r.codigoestudiante
                           INNER JOIN  estudiantegeneral eg ON e.idestudiantegeneral=eg.idestudiantegeneral
                           INNER JOIN  documento d ON d.tipodocumento=eg.tipodocumento
                           INNER JOIN  carrera c ON c.codigocarrera=e.codigocarrera AND c.codigomodalidadacademica IN('.$Modalidad.')
        WHERE
        r.fechaactaregistrograduado>="'.$Fecha->fields['fecha_ini'].'" AND r.fechaactaregistrograduado<="'.$Fecha->fields['fecha_fin'].'"
        '.$Consulta;
     if($Data2=&$db->Execute($SQL)===false){
        echo 'Error en el SQl dde los Datos de  los graduados..<br><br>'.$SQL;
        die;
     }
    
    $SQL1="SELECT
            R.RegistroGradoId as 'idregistrograduado',
            E.codigoestudiante,
            R.FechaCreacion as 'fechagradoregistrograduado',
            EG.nombresestudiantegeneral,
            EG.apellidosestudiantegeneral,
            D.nombrecortodocumento,
            EG.numerodocumento,
            C.nombrecarrera,
            EG.tipodocumento,
            C.codigocarrera
        FROM
                periodo P,
                RegistroGrado R
            INNER JOIN estudiante E ON  E.codigoestudiante = R.EstudianteId 
            INNER JOIN estudiantegeneral EG ON EG.idestudiantegeneral = E.idestudiantegeneral 
            INNER JOIN AcuerdoActa A ON A.AcuerdoActaId = R.AcuerdoActaId 
            INNER JOIN FechaGrado F ON F.FechaGradoId = A.FechaGradoId 
            INNER JOIN carrera C ON C.codigocarrera = F.CarreraId 
            INNER JOIN documento D on D.tipodocumento = EG.tipodocumento
        WHERE
            P.codigoperiodo = '20162'
            and C.codigomodalidadacademica IN (".$Modalidad.")
            AND ( A.FechaAcuerdo BETWEEN '".$Fecha->fields['fecha_ini']."' AND '".$Fecha->fields['fecha_fin']."' ) ".$Consulta;
    if($Data1=&$db->Execute($SQL1)===false)
    {
        echo 'Error en el SQl dde los Datos de  los graduados..<br><br>'.$SQL1;
        die;
    }
    
    $Data1 = $Data1->GetArray();
    $Data2 = $Data2->GetArray();    
    $D_Graduados  = array();    
    $Graduados = array_merge($Data1,$Data2);    

    return $Graduados;
    }//public function Graduados
    public function TableGraduados($DataGraduado,$op='',$Excel=false){
    global $db,$userid;

    include_once('../../utilidades/funcionesTexto.php');
    //echo '<pre>';print_r($DataGraduado);die;

    ?>
    <table border="1" align="center">
    <thead>
        <tr>
            <th>apellidos</th>
            <th>nombres</th>
            <th>tipoDocumento</th>
            <th>documento</th>
            <th>nombrePrograma</th>
        </tr>
    </thead>
    <tbody>
        <?PHP 
        $N = 1;
        for($i=0;$i<count($DataGraduado);$i++){
            /**********************************************/
                if($DataGraduado[$i]['tipodocumento']==01 || $DataGraduado[$i]['tipodocumento']=='01'){
                    $Tipo_Doc = 'C';
                }else if($DataGraduado[$i]['tipodocumento']==02 || $DataGraduado[$i]['tipodocumento']=='02'){
                    $Tipo_Doc = 'T';
                }else if($DataGraduado[$i]['tipodocumento']==03 || $DataGraduado[$i]['tipodocumento']=='03'){
                    $Tipo_Doc = 'E';
                }else if($DataGraduado[$i]['tipodocumento']==04 || $DataGraduado[$i]['tipodocumento']=='04'){
                    $Tipo_Doc = 'R';
                }else{
                    $Tipo_Doc = 'O';
                }
            $N++;  

             $name = $this->NameProgramaCambio($DataGraduado[$i]['codigocarrera']);
              if($name==1){
                $nameData = $DataGraduado[$i]['nombrecarrera'];
              }else{
                $nameData = $name;
              } 

              $nameData = sanear_string($nameData,false); 
              $apellido = sanear_string($DataGraduado[$i]['apellidosestudiantegeneral'],false);
              $Nombre = sanear_string($DataGraduado[$i]['nombresestudiantegeneral'],false);
            if($Excel){
                $Apellido_Print = utf8_decode(strtoupper($apellido));
                $Nombre_Print   = utf8_decode(strtoupper($Nombre));
                $DataName_Print = utf8_decode(strtoupper($nameData));
            }else{
                $Apellido_Print = strtoupper($apellido);
                $Nombre_Print   = strtoupper($Nombre);
                $DataName_Print = strtoupper($nameData);
            }
            ?>
            <tr>
                <td><?PHP echo $Apellido_Print;?></td>
                <td><?PHP echo $Nombre_Print;?></td>
                <td><?PHP echo $Tipo_Doc?></td>
                <td><?PHP echo $DataGraduado[$i]['numerodocumento']?></td>
                <td><?PHP echo $DataName_Print;?></td>
            </tr>
            <?PHP
            /**********************************************/
        }//for
        $R = $N-1;
        ?>
    </tbody>
    </table>   
    <?PHP
    if($op==1){
    /*
    TipoReporte este campo puede almacenar los siguientes valores 

    -0-->Primer Nivel
    -1-->Matriculados
    -2-->Graduados
    -3-->Retiros Disciplinarios
    -4-->Apoyos Acad&eacute;micos
    -5-->Apoyos Financieros
    -6-->Otros Apoyos

    */
    $Insert='INSERT INTO AuditoriaSpadies(TipoReporte,NumRegistros,Userid,entrydate)VALUES("2","'.$R.'","'.$userid.'",NOW())';

    if($TablaAuditoria=&$db->Execute($Insert)===false){
        echo 'Error en el Insert de la talba de Auditoria del SPADIES...<br><br>'.$Insert;
        die;
    }
    }
    }//public function TableGraduados
    public function Disiplinarios($Periodo,$Carrera_id,$Modalidad){
    global $db,$userid;
    /**************************************************************************/
    include_once('../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');

    //$Periodo  ='20091';

    $D_Estadista = new obtener_datos_matriculas($db,$Periodo);

    if($Carrera_id==0 || $Carrera_id=='0'){

    $Carrera   = $this->Carreras($Modalidad,'');

    $C_Disiplinario  = array();

    for($i=0;$i<count($Carrera);$i++){

        $Carrera_id  = $Carrera[$i]['codigocarrera'];

        $T_Matriculados  = $D_Estadista->obtener_total_matriculados($Carrera_id,'arreglo'); 


        for($j=0;$j<count($T_Matriculados);$j++){
                /********************************************************************/
                $SQL='SELECT  

                            p.idprocesodisciplinario as id,
                            p.idestudiantegeneral,
                            p.codigoestudiante,
                            p.idtiposancionprocesodisciplinario,
                            s.nombretiposancionprocesodisciplinario,
                            e.apellidosestudiantegeneral,
                            e.nombresestudiantegeneral,
                            e.numerodocumento,
                            g.nombregenero,
                            g.codigogenero,
                            d.tipodocumento,
                            d.nombrecortodocumento,
                            c.nombrecarrera

                    FROM 

                            procesodisciplinario p INNER JOIN tiposancionprocesodisciplinario s ON p.idtiposancionprocesodisciplinario=s.idtiposancionprocesodisciplinario
                                                   INNER JOIN estudiantegeneral e ON p.idestudiantegeneral=e.idestudiantegeneral
                                                   INNER JOIN genero g ON e.codigogenero=g.codigogenero
                                                   INNER JOIN documento d ON e.tipodocumento=d.tipodocumento
                                                   INNER JOIN estudiante es ON p.codigoestudiante=es.codigoestudiante
                                                   INNER JOIN carrera c ON es.codigocarrera=c.codigocarrera



                    WHERE 

                            p.codigoestado = 100 
                            AND 
                            p.idtiposancionprocesodisciplinario IN (203, 301, 302)
                            AND
                            p.codigoestudiante="'.$T_Matriculados[$j]['codigoestudiante'].'"';

                   if($D_Displinario=&$db->Execute($SQL)===false){
                        echo 'Error en el SQl De los estudiantes Displinarios...<br><br>'.$SQL;
                        die;
                   }   

                 if(!$D_Displinario->EOF){
                    /****************************************************************/
                    $C_Disiplinario['CodigoEstuante'][]         = $T_Matriculados[$i]['codigoestudiante'];
                    $C_Disiplinario['SituacionDisiplinaria'][]  = $D_Displinario->fields['nombretiposancionprocesodisciplinario'];
                    $C_Disiplinario['codigo'][]                 = $D_Displinario->fields['idtiposancionprocesodisciplinario'];
                    $C_Disiplinario['Nombre'][]                 = $D_Displinario->fields['nombresestudiantegeneral'];
                    $C_Disiplinario['Apellido'][]               = $D_Displinario->fields['apellidosestudiantegeneral'];
                    $C_Disiplinario['tipodocumento'][]          = $D_Displinario->fields['tipodocumento'];
                    $C_Disiplinario['NumeroDocumento'][]        = $D_Displinario->fields['numerodocumento'];
                    $C_Disiplinario['codigoGenero'][]           = $D_Displinario->fields['codigogenero'];
                    $C_Disiplinario['Carrera'][]                = $D_Displinario->fields['nombrecarrera'];
                    /****************************************************************/
                 }//if        
                /********************************************************************/
            }//for 


    }//for


    }else{


    $T_Matriculados  = $D_Estadista->obtener_total_matriculados($Carrera_id,'arreglo');

    //echo '<pre>';print_r($T_Matriculados);

    $C_Disiplinario  = array();

    for($i=0;$i<count($T_Matriculados);$i++){
    /********************************************************************/
    $SQL='SELECT  

                p.idprocesodisciplinario as id,
                p.idestudiantegeneral,
                p.codigoestudiante,
                p.idtiposancionprocesodisciplinario,
                s.nombretiposancionprocesodisciplinario,
                e.apellidosestudiantegeneral,
                e.nombresestudiantegeneral,
                e.numerodocumento,
                g.nombregenero,
                g.codigogenero,
                d.tipodocumento,
                d.nombrecortodocumento,
                c.nombrecarrera

        FROM 

                procesodisciplinario p INNER JOIN tiposancionprocesodisciplinario s ON p.idtiposancionprocesodisciplinario=s.idtiposancionprocesodisciplinario
                                       INNER JOIN estudiantegeneral e ON p.idestudiantegeneral=e.idestudiantegeneral
                                       INNER JOIN genero g ON e.codigogenero=g.codigogenero
                                       INNER JOIN documento d ON e.tipodocumento=d.tipodocumento
                                       INNER JOIN estudiante es ON p.codigoestudiante=es.codigoestudiante
                                       INNER JOIN carrera c ON es.codigocarrera=c.codigocarrera



        WHERE 

                p.codigoestado = 100 
                AND 
                p.idtiposancionprocesodisciplinario IN (203, 301, 302)
                AND
                p.codigoestudiante="'.$T_Matriculados[$i]['codigoestudiante'].'"';

       if($D_Displinario=&$db->Execute($SQL)===false){
            echo 'Error en el SQl De los estudiantes Displinarios...<br><br>'.$SQL;
            die;
       }   

     if(!$D_Displinario->EOF){
        /****************************************************************/
        $C_Disiplinario['CodigoEstuante'][]         = $T_Matriculados[$i]['codigoestudiante'];
        $C_Disiplinario['SituacionDisiplinaria'][]  = $D_Displinario->fields['nombretiposancionprocesodisciplinario'];
        $C_Disiplinario['codigo'][]                 = $D_Displinario->fields['idtiposancionprocesodisciplinario'];
        $C_Disiplinario['Nombre'][]                 = $D_Displinario->fields['nombresestudiantegeneral'];
        $C_Disiplinario['Apellido'][]               = $D_Displinario->fields['apellidosestudiantegeneral'];
        $C_Disiplinario['tipodocumento'][]          = $D_Displinario->fields['tipodocumento'];
        $C_Disiplinario['NumeroDocumento'][]        = $D_Displinario->fields['numerodocumento'];
        $C_Disiplinario['codigoGenero'][]           = $D_Displinario->fields['codigogenero'];
        $C_Disiplinario['Carrera'][]                = $D_Displinario->fields['nombrecarrera'];
        /****************************************************************/
     }//if        
    /********************************************************************/
    }//for 

    }


    //echo '<pre>';print_r($C_Disiplinario);
    return $C_Disiplinario;
    /**************************************************************************/
    }//public function Disiplinarios
    public function TablaDisplinario($D_Displinario,$op=''){
    global $db,$userid;
    /**************************************************************************/
    ?>
    <table border="1" align="center">
    <thead>
        <tr>
            <th>apellidos</th>
            <th>nombres</th>
            <th>tipo documento</th>
            <th>documento</th>
            <th>nombre programa</th>
        </tr>
    </thead>
    <tbody>
    <?PHP 
    $N=1;
    for($i=0;$i<count($D_Displinario['CodigoEstuante']);$i++){
        /************************************************************************/
        if($D_Displinario['tipodocumento'][$i]==01 || $D_Displinario[$i]['tipodocumento'][$i]=='01'){
            $Tipo_Doc = 'C';
        }else if($D_Displinario['tipodocumento'][$i]==02 || $D_Displinario['tipodocumento'][$i]=='02'){
            $Tipo_Doc = 'T';
        }else if($D_Displinario['tipodocumento'][$i]==03 || $D_Displinario['tipodocumento'][$i]=='03'){
            $Tipo_Doc = 'E';
        }else if($D_Displinario['tipodocumento'][$i]==04 || $D_Displinario['tipodocumento'][$i]=='04'){
            $Tipo_Doc = 'R';
        }else{
            $Tipo_Doc = 'O';
        }
        /************************************************************************/
        $N++;
        ?>
        <tr>
            <td><?PHP echo $D_Displinario['Apellido'][$i]?></td>
            <td><?PHP echo $D_Displinario['Nombre'][$i]?></td>
            <td><?PHP echo $Tipo_Doc?></td>
            <td><?PHP echo $D_Displinario['NumeroDocumento'][$i]?></td>
            <td><?PHP echo $D_Displinario['Carrera'][$i]?></td>
        </tr>
        <?PHP
        /************************************************************************/
    }//for
    $R = $N-1;
    ?>
    </tbody>
    </table>    
    <?PHP 

    if($op==1){
    /*
    TipoReporte este campo puede almacenar los siguientes valores 

    -0-->Primer Nivel
    -1-->Matriculados
    -2-->Graduados
    -3-->Retiros Disciplinarios
    -4-->Apoyos Acad&eacute;micos
    -5-->Apoyos Financieros
    -6-->Otros Apoyos

    */
    $Insert='INSERT INTO AuditoriaSpadies(TipoReporte,NumRegistros,Userid,entrydate)VALUES("3","'.$R.'","'.$userid.'",NOW())';

    if($TablaAuditoria=&$db->Execute($Insert)===false){
        echo 'Error en el Insert de la talba de Auditoria del SPADIES...<br><br>'.$Insert;
        die;
    }
    }
    /**************************************************************************/
    }
    public function ApoyosAcademicos($Carrera_id,$Periodo,$op='',$Modalidad){
    global $db,$userid;

    if($Carrera_id==0 || $Carrera_id=='0'){

    $Consulta  = '';
    }else{

    $Consulta = ' AND  a.carrera_id="'.$Carrera_id.'"';
    }

    $SQL='SELECT 

        a.id_ApoyoAcademico,
        a.carrera_id,
        a.codigoestudiante,
        a.tipo_id,
        c.nombrecarrera,
        eg.apellidosestudiantegeneral,
        eg.nombresestudiantegeneral,
        eg.tipodocumento,
        eg.numerodocumento

        FROM 

        ApoyosAcademicos a INNER JOIN carrera c ON c.codigocarrera=a.carrera_id
                           INNER JOIN estudiante e ON e.codigoestudiante=a.codigoestudiante
                           INNER JOIN estudiantegeneral eg ON e.idestudiantegeneral=eg.idestudiantegeneral

        WHERE

        a.codigoperiodo="'.$Periodo.'"
        AND
        a.codigoestado=100
        '.$Consulta;

        if($ApoyosAcademicos=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de Apoyos Academicos....<br>'.$SQL;
            die;
        }
    /**************************************************************************/
    ?>
    <table border="1" align="center">
    <thead>
        <tr>
            <th>apellidos</th>
            <th>nombres</th>
            <th>tipo documento</th>
            <th>documento</th>
            <th>nombre Programa</th>
        </tr>
    </thead>
    <tbody>
    <?PHP 
    $N=1;
    while(!$ApoyosAcademicos->EOF){
        /*****************************************************/
        if($ApoyosAcademicos->fields['tipodocumento']==01 || $ApoyosAcademicos->fields['tipodocumento']=='01'){
            $Tipo_Doc = 'C';
        }else if($ApoyosAcademicos->fields['tipodocumento']==02 || $ApoyosAcademicos->fields['tipodocumento']=='02'){
            $Tipo_Doc = 'T';
        }else if($ApoyosAcademicos->fields['tipodocumento']==03 || $ApoyosAcademicos->fields['tipodocumento']=='03'){
            $Tipo_Doc = 'E';
        }else if($ApoyosAcademicos->fields['tipodocumento']==04 || $ApoyosAcademicos->fields['tipodocumento']=='04'){
            $Tipo_Doc = 'R';
        }else{
            $Tipo_Doc = 'O';
        }
        /*****************************************************/
        $N++;
        ?>
        <tr>
            <td><?PHP echo $ApoyosAcademicos->fields['apellidosestudiantegeneral']?></td>
            <td><?PHP echo $ApoyosAcademicos->fields['nombresestudiantegeneral']?></td>
            <td><?PHP echo $Tipo_Doc?></td>
            <td><?PHP echo $ApoyosAcademicos->fields['numerodocumento']?></td>
            <td><?PHP echo $ApoyosAcademicos->fields['nombrecarrera']?></td>
        </tr>
        <?PHP
        /*****************************************************/
        $ApoyosAcademicos->MoveNext();
    }
    $R = $N-1;
    ?>
    </tbody>
    </table>    
    <?PHP 

    if($op==1){
    /*
    TipoReporte este campo puede almacenar los siguientes valores 

    -0-->Primer Nivel
    -1-->Matriculados
    -2-->Graduados
    -3-->Retiros Disciplinarios
    -4-->Apoyos Acad&eacute;micos
    -5-->Apoyos Financieros
    -6-->Otros Apoyos

    */
    $Insert='INSERT INTO AuditoriaSpadies(TipoReporte,NumRegistros,Userid,entrydate)VALUES("4","'.$R.'","'.$userid.'",NOW())';

    if($TablaAuditoria=&$db->Execute($Insert)===false){
        echo 'Error en el Insert de la talba de Auditoria del SPADIES...<br><br>'.$Insert;
        die;
    }
    }
    /**************************************************************************/
    }//public function ApoyosAcademicos
    public function CodigoSnies($CodigoCarrera){
    global $db;

    $SQL='SELECT idcarreraregistro,numeroregistrocarreraregistro FROM carreraregistro  WHERE  codigocarrera="'.$CodigoCarrera.'"';

    if($C_Codigo=&$db->Execute($SQL)===false){
    echo 'Error en el SQl delCodigo snies<br><br>'.$SQL;
    die;
    }

    return $C_Codigo->fields['numeroregistrocarreraregistro'];
    }/*public function CodigoSnies*/
    public function ApoyosFinacieros($Carrera_id,$Periodo,$op){
    global $db,$userid;

    ?>
    <table border="1" align="center">
    <thead>
        <tr>
            <th>aellidos</th>
            <th>nombres</th>
            <th>tipo documento</th>
            <th>documento</th>
            <th>nombre programa</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
    </table>
    <?PHP


    }//public function ApoyosFinacieros
    public function OtrosApoyos($Periodo,$op,$Modalidad){
    global $db,$userid;

    $SQL_P='SELECT 

        p.codigoestudiante,
        p.codigoperiodo,
        eg.apellidosestudiantegeneral,
        eg.nombresestudiantegeneral,
        eg.tipodocumento,
        d.nombrecortodocumento,
        eg.numerodocumento,
        e.codigocarrera,
        c.nombrecarrera,
        eg.codigogenero,
        g.nombregenero



        FROM obs_remision_psicologica p INNER JOIN estudiante e ON e.codigoestudiante=p.codigoestudiante 
                                        INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral
                                        INNER JOIN carrera c ON e.codigocarrera=c.codigocarrera
                                        INNER JOIN genero g ON eg.codigogenero=g.codigogenero
                                        INNER JOIN documento d ON eg.tipodocumento=d.tipodocumento
        WHERE

        p.codigoestado=100
        AND
        p.codigoperiodo="'.$Periodo.'"';

     if($Psicologico=&$db->Execute($SQL_P)===false){
        echo 'Error en el SQL Tutorias Sicologicas....<br><br>'.$SQL_P;
        die;
     } 

     $C_Data   = array();

     while(!$Psicologico->EOF){

            $C_Data['codigoestudiante'][] = $Psicologico->fields['codigoestudiante'];
            $C_Data['Apellido'][]         = $Psicologico->fields['apellidosestudiantegeneral'];
            $C_Data['Nombre'][]           = $Psicologico->fields['nombresestudiantegeneral'];
            $C_Data['tipoDocumento'][]    = $Psicologico->fields['tipodocumento'];
            $C_Data['numerodocumento'][]  = $Psicologico->fields['numerodocumento'];
            $C_Data['Carrera'][]          = $Psicologico->fields['nombrecarrera'];

        $Psicologico->MoveNext();
     }//while $Psicologico->EOF  


     $SQL_F='SELECT

            f.codigoestudiante,
            f.codigoperiodo,
            eg.apellidosestudiantegeneral,
            eg.nombresestudiantegeneral,
            eg.tipodocumento,
            d.nombrecortodocumento,
            eg.numerodocumento,
            e.codigocarrera,
            c.nombrecarrera,
            eg.codigogenero,
            g.nombregenero



            FROM obs_remision_financiera f  INNER JOIN estudiante e ON e.codigoestudiante=f.codigoestudiante
                                            INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral
                                            INNER JOIN carrera c ON e.codigocarrera=c.codigocarrera
                                            INNER JOIN genero g ON eg.codigogenero=g.codigogenero
                                            INNER JOIN documento d ON eg.tipodocumento=d.tipodocumento


            WHERE

            f.codigoestado=100
            AND
            f.codigoperiodo="'.$Periodo.'"';

         if($Fianciero=&$db->Execute($SQL_F)===false){
            echo 'Error en SQl Tutorias fianciero...<br><br>'.$SQL_F;
            die;
         }  

      while(!$Fianciero->EOF){

            $C_Data['codigoestudiante'][] = $Fianciero->fields['codigoestudiante'];
            $C_Data['Apellido'][]         = $Fianciero->fields['apellidosestudiantegeneral'];
            $C_Data['Nombre'][]           = $Fianciero->fields['nombresestudiantegeneral'];
            $C_Data['tipoDocumento'][]    = $Fianciero->fields['tipodocumento'];
            $C_Data['numerodocumento'][]  = $Fianciero->fields['numerodocumento'];
            $C_Data['Carrera'][]          = $Fianciero->fields['nombrecarrera'];

        $Fianciero->MoveNext();
      }//while $Fianciero->EOF   

    $SQL_T='SELECT 

            t.codigoestudiante,
            t.codigoperiodo,
            eg.apellidosestudiantegeneral,
            eg.nombresestudiantegeneral,
            eg.tipodocumento,
            d.nombrecortodocumento,
            eg.numerodocumento,
            e.codigocarrera,
            c.nombrecarrera,
            eg.codigogenero,
            g.nombregenero

    FROM obs_tutorias t INNER JOIN estudiante e ON e.codigoestudiante=t.codigoestudiante
                INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral
                INNER JOIN carrera c ON e.codigocarrera=c.codigocarrera
                INNER JOIN genero g ON eg.codigogenero=g.codigogenero
                INNER JOIN documento d ON eg.tipodocumento=d.tipodocumento


            WHERE

            t.codigoestado=100
            AND
            t.codigoperiodo="'.$Periodo.'"'; 

      if($Tutorias=&$db->Execute($SQL_T)===false){
        echo 'Error en el SQl de Tutorias...<br><br>'.$SQL_T;
        die;
      } 

     while(!$Tutorias->EOF){

            $C_Data['codigoestudiante'][] = $Tutorias->fields['codigoestudiante'];
            $C_Data['Apellido'][]         = $Tutorias->fields['apellidosestudiantegeneral'];
            $C_Data['Nombre'][]           = $Tutorias->fields['nombresestudiantegeneral'];
            $C_Data['tipoDocumento'][]    = $Tutorias->fields['tipodocumento'];
            $C_Data['numerodocumento'][]  = $Tutorias->fields['numerodocumento'];
            $C_Data['Carrera'][]          = $Tutorias->fields['nombrecarrera'];

        $Tutorias->MoveNext();
      }//while $Tutorias->EOF   


      //echo '<pre>';print_r($C_Data);

    ?>     
    <table border="1" align="center">
    <thead>
        <tr>
            <th>apellidos</th>
            <th>nombres</th>
            <th>tipo documento</th>
            <th>documento</th>
            <th>nombre programa</th>
        </tr>
    </thead>
    <tbody>
    <?PHP 
    $N=1;
        for($i=0;$i<count($C_Data['codigoestudiante']);$i++){

            if($C_Data['tipoDocumento'][$i]==01 || $C_Data['tipoDocumento'][$i]=='01'){
                    $Tipo_Doc = 'C';
                }else if($C_Data['tipoDocumento'][$i]==02 || $C_Data['tipoDocumento'][$i]=='02'){
                    $Tipo_Doc = 'T';
                }else if($C_Data['tipoDocumento'][$i]==03 || $C_Data['tipoDocumento'][$i]=='03'){
                    $Tipo_Doc = 'E';
                }else if($C_Data['tipoDocumento'][$i]==04 || $C_Data['tipoDocumento'][$i]=='04'){
                    $Tipo_Doc = 'R';
                }else{
                    $Tipo_Doc = 'O';
                }
            $N++;
            ?>
             <tr>
                <td><?PHP echo strtoupper($C_Data['Apellido'][$i])?></td>
                <td><?PHP echo strtoupper($C_Data['Nombre'][$i])?></td>
                <td><?PHP echo $Tipo_Doc?></td>
                <td><?PHP echo $C_Data['numerodocumento'][$i]?></td>
                <td><?PHP echo $C_Data['Carrera'][$i]?></td>
            </tr>
            <?PHP
        }//for $C_Data
     $R = $N-1;   
    ?>
    </tbody>
    </table>
    <?PHP     

    if($op==1){
    /*
    TipoReporte este campo puede almacenar los siguientes valores 

    -0-->Primer Nivel
    -1-->Matriculados
    -2-->Graduados
    -3-->Retiros Disciplinarios
    -4-->Apoyos Acad&eacute;micos
    -5-->Apoyos Financieros
    -6-->Otros Apoyos

    */
    $Insert='INSERT INTO AuditoriaSpadies(TipoReporte,NumRegistros,Userid,entrydate)VALUES("6","'.$R.'","'.$userid.'",NOW())';

    if($TablaAuditoria=&$db->Execute($Insert)===false){
        echo 'Error en el Insert de la talba de Auditoria del SPADIES...<br><br>'.$Insert;
        die;
    }
    }      
    }//public function OtrosApoyos
    public function Auditoria(){
    global $db,$userid;

    $SQL='SELECT 

        a.idAuditoriaSpadies,
        a.TipoReporte,
        a.NumRegistros,
        u.nombres,
        u.apellidos,
        DATE(a.entrydate) AS Fecha,
        TIME(a.entrydate) AS Hora


        FROM 

        AuditoriaSpadies a INNER JOIN usuario u ON u.idusuario=a.Userid';

    if($Datos=&$db->Execute($SQL)===false){
    echo 'Error en el SQL de Auditoria...<br><br>'.$SQL;
    die;
    }

    ?>
    <div style="text-align: right;">
    <img src="../img/button_cancel.png" width="20" title="Cerrar Tabla" onclick="CloseTable()" style="cursor: pointer;" />
    </div> 
    <br />
    <table border="1" style="text-align: center;">
    <thead>
        <tr>
            <th>N&deg;</th>
            <th>Tipo de Reporte</th>
            <th>N&uacute;mero de Registros</th>
            <th>Usuario que Genero el Archivo</th>
            <th>Fecha</th>
            <th>Hora</th>
        </tr>
    </thead>
    <tbody>
        <?PHP 
        $i=1;
        while(!$Datos->EOF){

            if($Datos->fields['TipoReporte']==0){
                $Reporte = 'Primer Nivel';
            }else if($Datos->fields['TipoReporte']==1){
                $Reporte = 'Matriculados';
            }else if($Datos->fields['TipoReporte']==2){
                $Reporte = 'Graduados';
            }else if($Datos->fields['TipoReporte']==3){
                $Reporte = 'Retiros Disciplinarios';
            }else if($Datos->fields['TipoReporte']==4){
                $Reporte = 'Apoyos Acad&eacute;micos';
            }else if($Datos->fields['TipoReporte']==5){
                $Reporte = 'Apoyos Financieros';
            }else if($Datos->fields['TipoReporte']==6){
                $Reporte = 'Otros Apoyos';
            }

            ?>
            <tr>
                <td style="text-align: center;"><?PHP echo $i?></td>
                <td style="text-align: left;"><?PHP echo $Reporte?></td>
                <td style="text-align: center;"><?PHP echo $Datos->fields['NumRegistros']?></td>
                <td style="text-align: left;"><?PHP echo $Datos->fields['nombres'].' '.$Datos->fields['apellidos']?></td>
                <td style="text-align: center;"><?PHP echo $Datos->fields['Fecha']?></td>
                <td style="text-align: center;"><?PHP echo $Datos->fields['Hora']?></td>
            </tr>
            <?PHP
            $i++;
            $Datos->MoveNext();
        }/*while*/    
        ?>
    </tbody>
    </table>
    <?PHP

    }/*public function Auditoria*/
    /**************************************************************************/
}//class Spadies

?>