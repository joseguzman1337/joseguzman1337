<?php
class Encuestas{
    
    public function ListaEncuestas(){
        global $db;

		include_once('../../ReportesAuditoria/templates/mainjson.php');
        //var_dump (is_file('../../ReportesAuditoria/templates/mainjson.php'));die;
        
        //echo '<pre>';print_r($db);
        
         $SQL='SELECT 

                        e.id_instrumento,
                        DATE(e.fechafinalentradaredireccion) AS fecha,
                        i.nombre
                
                FROM  
                
                        entradaredireccion e INNER JOIN siq_Ainstrumentoconfiguracion i ON i.idsiq_Ainstrumentoconfiguracion=e.id_instrumento
                		 						 
                WHERE  
                		 						 			
                		 						 			
                        now() between e.fechainicioentradaredireccion and e.fechafinalentradaredireccion  
                        AND 
                        e.codigoestado=100
                        AND
                        e.id_instrumento<>0'; 
                        
                if($Lista=&$db->Execute($SQL)===false){
                    echo 'Error en el SQl de la Lista de encuetas Activas...<br><br>'.$SQL;
                    die;
                }
                
               //echo '<pre>';print_r($Lista);
                
            
                
           $C_Lista  = $Lista->GetArray();
           
           //echo '<pre>';print_r($C_Lista);die;
           
          return $C_Lista;         
    }/*public function ListaEncuestas*/
    public function PublicoObjetivo($id_instrumento){
        global $db;
        
        //include_once('../../ReportesAuditoria/templates/mainjson.php');
        /*
***Estudiante en la tabla detalledel publico objetivo exiten dos campos E_new E_old si alguno de estos esta en 1 aplica a estudiante

***Docente  en la tabla detalle publico objetivo existe un (1) docente y esta en 1 aplica  a docente la encueta o instrumento.

***Graduado en la talba detalle publico objetivo exite un campo llamado E_Gra  1 aplica a estudiantes graduados 

***Si el campo en la tabla publico objetivo cvs esta en 0 toca revisar la tabla cvspublico objetivo 

*/

  $SQL_PublicoObjetivo='SELECT 

                        idsiq_Apublicoobjetivo, 
                        cvs 
                        
                        FROM 
                        
                        siq_Apublicoobjetivo  
                        
                        WHERE  
                        
                        idsiq_Ainstrumentoconfiguracion="'.$id_instrumento.'" 
                        AND 
                        codigoestado=100';
                        
                  if($PublicoObjetivo=&$db->Execute($SQL_PublicoObjetivo)===false){
                    echo 'Error en el SQL del Publico Obejtivo del Instrumento o Encuesta...<br><br>'.$SQL_PublicoObjetivo;
                    die;
                  }     
                  
       
       
       if(!$PublicoObjetivo->EOF){
        
            
               /*******************************************/
               $CVS  = $PublicoObjetivo->fields['cvs'];
               $id_PublicoObjetivo = $PublicoObjetivo->fields['idsiq_Apublicoobjetivo'];
               /*******************************************/
               
               
            if($CVS==0){
                
                $E_CSV  = array();
                
                 $SQL_cvs=' SELECT

                            COUNT(estudiante) as Num,
                            "Estudiante" as tipo
                            
                            FROM siq_Apublicoobjetivocsv
                            
                            WHERE
                            
                            idsiq_Apublicoobjetivo ="'.$id_PublicoObjetivo.'"
                            AND
                            codigoestado=100
                            AND
                            estudiante=1
                            
                            UNION
                            
                            SELECT
                            
                            COUNT(docente) as Num,
                            "Docente" as tipo
                            
                            
                            FROM siq_Apublicoobjetivocsv
                            
                            WHERE
                            
                            idsiq_Apublicoobjetivo = "'.$id_PublicoObjetivo.'"
                            AND
                            codigoestado=100
                            AND
                            docente=1
                            
                            UNION
                            
                            SELECT
                            
                            COUNT(padre) as Num,
                            "Padres" as tipo
                            
                            
                            FROM siq_Apublicoobjetivocsv
                            
                            WHERE
                            
                            idsiq_Apublicoobjetivo = "'.$id_PublicoObjetivo.'"
                            AND
                            codigoestado=100
                            AND
                            padre=1
                            
                            UNION
                            
                            SELECT
                            
                            COUNT(vecinos) as Num,
                            "Vecinos" as tipo
                            
                            
                            FROM siq_Apublicoobjetivocsv
                            
                            WHERE
                            
                            idsiq_Apublicoobjetivo = "'.$id_PublicoObjetivo.'"
                            AND
                            codigoestado=100
                            AND
                            vecinos=1
                            
                            UNION
                            
                            SELECT
                            
                            COUNT(administrativos) as Num,
                            "Administrativos" as tipo
                            
                            
                            FROM siq_Apublicoobjetivocsv
                            
                            WHERE
                            
                            idsiq_Apublicoobjetivo = "'.$id_PublicoObjetivo.'"
                            AND
                            codigoestado=100
                            AND
                            administrativos=1
                            
                            UNION
                            
                            SELECT
                            
                            COUNT(otros) as Num,
                            "Otros" as tipo
                            
                            
                            FROM siq_Apublicoobjetivocsv
                            
                            WHERE
                            
                            idsiq_Apublicoobjetivo ="'.$id_PublicoObjetivo.'"
                            AND
                            codigoestado=100
                            AND
                            otros=1';
                            
                      if($C_cvs=&$db->Execute($SQL_cvs)===false){
                        echo 'Error en el SQl NumMatriculados....<br>'.$SQL_cvs;
                        die;
                      }   
                      
                      $D_CSV = $C_cvs->GetArray();
                      
                      //echo '<pre>';print_r($D_CSV);
                      
                      for($i=0;$i<count($D_CSV);$i++){
                        
                        if($D_CSV[$i]['Num']>0){
                            
                            if($D_CSV[$i]['tipo']=='Estudiante'){$Condicion = 'c.estudiante=1';}//if...1
                            if($D_CSV[$i]['tipo']=='Docente'){$Condicion = 'c.docente=1';}//if...2
                            if($D_CSV[$i]['tipo']=='Padres'){$Condicion = 'c.padre=1';}//if...3
                            if($D_CSV[$i]['tipo']=='Vecinos'){$Condicion = 'c.vecinos=1';}//if...4
                            if($D_CSV[$i]['tipo']=='Administrativos'){$Condicion = 'c.administrativos=1';}//if...4
                            if($D_CSV[$i]['tipo']=='Otros'){$Condicion = 'c.otros=1';}//if...6
                            
                            
                            $SQL_DCVS='SELECT 

                                        COUNT(c.cedula) AS num 
                                        
                                        FROM 
                                        
                                        actualizacionusuario a INNER JOIN siq_Apublicoobjetivo p ON p.idsiq_Ainstrumentoconfiguracion=a.id_instrumento
                                        											 INNER JOIN siq_Apublicoobjetivocsv c ON c.idsiq_Apublicoobjetivo=p.idsiq_Apublicoobjetivo AND c.cedula=a.numerodocumento
                                        
                                        WHERE 
                                        
                                        a.id_instrumento = "'.$id_instrumento.'"
                                        AND 
                                        a.estadoactualizacion = 2 
                                        AND
                                        a.codigoestado=100
                                        AND
                                        c.codigoestado=100
                                        AND
                                        '.$Condicion; 
                                        
                                  if($DataExterna=&$db->Execute($SQL_DCVS)===false){
                                    echo 'Error en el SQl detalle...<br><br>'.$SQL_DCVS;
                                    die;
                                  } 
                                  
                               //$D_Externa = $DataExterna->GetArray();
                               $E_CSV['CVS']=1;
                               $E_CSV['total'][]     = $D_CSV[$i]['Num']; 
                               $E_CSV['Label'][]     = $D_CSV[$i]['tipo'];   
                               $E_CSV['Contestado'][]= $DataExterna->fields['num'];       
                            
                        }//if
                        
                      }//for
                      
                    // echo '<pre>';print_r($E_CSV); 
                                
                 return $E_CSV;                 
                
            }else{
                
                $SQL_DetallePublcoObjetivo='SELECT 

                                            tipoestudiante,
                                            E_New,
                                            E_Old,
                                            E_Gra,
                                            docente,
                                            modalidadsic,
                                            cadena,
                                            recienegresado,
                                            consolidacionprofesional,
                                            senior
                                            
                                            FROM 
                                            
                                            siq_Adetallepublicoobjetivo 
                                            
                                            WHERE
                                            
                                            idsiq_Apublicoobjetivo="'.$id_PublicoObjetivo.'"
                                            AND
                                            codigoestado=100';
                                            
                                    if($DetallePublicoObjetivo=&$db->Execute($SQL_DetallePublcoObjetivo)===false){
                                        echo 'Error en el SQL del detalle del publico obejtivo de la encuesta o instrumento...<br><br>'.$SQL_DetallePublcoObjetivo;
                                        die;
                                    }  
                                    
                  $D_PublicoObjetivo = $DetallePublicoObjetivo->GetArray();
                  
                  //echo '<pre>';print_r($D_PublicoObjetivo); 
                  
                  $R_Data = array();  
                  
                  if($D_PublicoObjetivo[0]['E_New']==1 || $D_PublicoObjetivo[1]['E_Old']==1){
                    
                    $R_Data['Estudiante']['data']=1;
                    
                    if($D_PublicoObjetivo[0]['modalidadsic']!=0){
                        $modalida  = $D_PublicoObjetivo[0]['modalidadsic'];
                    }else{
                        $modalida  = $D_PublicoObjetivo[1]['modalidadsic'];
                    }
                    
                    if($D_PublicoObjetivo[0]['cadena']!=0){
                        $Carrera  = $D_PublicoObjetivo[0]['cadena'];
                    }else{
                       $Carrera  = $D_PublicoObjetivo[1]['cadena']; 
                    }
                    
                    $R_Data['Estudiante']['modalidad']=$modalida;
                    $R_Data['Estudiante']['Carrera']=$Carrera;
                    
                  }else{
                    
                    $R_Data['Estudiante']=0;
                    
                  }                     
                  if($D_PublicoObjetivo[3]['E_Gra']==1){
                    
                    $R_Data['Graduado']['data']=1;
                    $R_Data['Graduado']['recienegresado']=$D_PublicoObjetivo[3]['recienegresado'];
                    $R_Data['Graduado']['consolidacionprofesional']=$D_PublicoObjetivo[3]['consolidacionprofesional'];
                    $R_Data['Graduado']['senior']=$D_PublicoObjetivo[3]['senior'];
                    
                  }else{
                    
                    $R_Data['Graduado']['data']=0;
                    
                  }
                  if($D_PublicoObjetivo[4]['docente']==1){
                    
                    $R_Data['Docente']=1;
                    
                  }else{
                    
                    $R_Data['Docente']=0;
                    
                  }     
                  
               return $R_Data;                   
            }//if       
        
       }//if  
       
       //echo '<pre>';print_r($R_Data);
       
       
    }/*public function PublicoObjetivo*/
    public function DataEstudiantes($id_instrumento,$Modalidad,$Periodo){
        global $db;
        
        //include_once('../../ReportesAuditoria/templates/mainjson.php');
        
         $SQL='SELECT  

                x.nombrecarrera as Nombre,
                COUNT(x.nombrecarrera) as num,
                x.codigocarrera
                
                FROM
                (
                
                        SELECT
                        
                        a.idactualizacionusuario,
                        a.usuarioid,
                        c.codigocarrera,
                        c.nombrecarrera,
                        e.codigoestudiante,
                        e.idestudiantegeneral
                        
                        FROM
                        
                        actualizacionusuario a INNER JOIN usuario u ON u.idusuario=a.usuarioid
											   INNER JOIN estudiantegeneral eg ON eg.numerodocumento=u.numerodocumento
											   INNER JOIN estudiante  e ON e.idestudiantegeneral=eg.idestudiantegeneral 
											   INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera
											   INNER JOIN prematricula p ON e.codigoestudiante=p.codigoestudiante
                        
                        
                        WHERE
                        
                        a.codigoestado=100
                        AND
                        a.id_instrumento="'.$id_instrumento.'"
                        AND
                        a.estadoactualizacion=2
                        AND
                        c.codigomodalidadacademica="'.$Modalidad.'"
                        
                        GROUP BY a.idactualizacionusuario
                
                )  x
                
                GROUP BY x.nombrecarrera';
                /*
                AND
                a.codigoperiodo="'.$Periodo.'"
                */
                
           if($DataEstudiante=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de la Data de la Encueta de estudiantes...<br><br>'.$SQL;
            die;
           }  
           
         $D_Estudiante = $DataEstudiante->GetArray();
         
         //echo '<pre>';print_r($D_Estudiante);     
        
        return $D_Estudiante;
        
    }/*public function DataEstudiantes*/
    public function Periodo($Opcion,$Periodo_ini='',$Periodo_fin=''){
        global  $db;
        
        if($Opcion=='Actual'){
            $Condicion ='WHERE  codigoestadoperiodo=1';
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
                return $Periodo->fields['codigoperiodo'];
           }else if($Opcion=='Cadena' || $Opcion=='Todos'){
            
                $C_Periodo  = $Periodo->GetArray();
                
                return $C_Periodo;
           }    
     }//public function Periodo
     public function LLamaMatriuclados($Periodo,$Carrera_id){
        global $db;
        
        //var_dump (is_file('../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php'));die;
        include_once('../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php');
        
        $datos_estadistica=new obtener_datos_matriculas($db,$Periodo);
        
        $TotalMatriculados = $datos_estadistica->obtener_total_matriculados($Carrera_id,'conteo');
        
        return $TotalMatriculados;
     }
   public function GraficaBarras($C_Info,$name){
        global $db;
    
    // echo '<pre>';print_r($C_Info);
    //var_dump (is_file('../pChart/class/pData.class.php'));die; 
    include_once("../pChart/class/pData.class.php");
   
    include_once("../pChart/class/pDraw.class.php");
    
    include_once("../pChart/class/pImage.class.php");
   
    $fontPath = "../pChart/fonts/";
    
     /* Create and populate the pData object */
     $MyData = new pData();  
     $MyData->addPoints($C_Info['Porcentaje'],"");
     $MyData->setAxisName(0,"Porcentaje %");
     $MyData->addPoints($C_Info['Labes'],"Programas Academicos");
     $MyData->setSerieDescription("Programas Academicos","Programas Academicos");
     $MyData->setAbscissa("Programas Academicos");
     $MyData->setAbscissaName("Programas Academicos");
     $MyData->loadPalette("../palettes/blind.color",TRUE);
     /* Create the pChart object */
     
     if(count($C_Info['Porcentaje'])<10){
        
        $alto = 500;
        $ancho = 500;
        $x     = ($alto/2)+20;
        
     }else{
        
        $alto = 1000;
        $ancho = 1000;
        $x     = ($alto/2)+20;
     }
     
     $myPicture = new pImage($alto,$ancho,$MyData);
     
     $myPicture->drawGradientArea(0,0,$alto,$ancho,DIRECTION_VERTICAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>100));
     $myPicture->drawGradientArea(0,0,$alto,$ancho,DIRECTION_HORIZONTAL,array("StartR"=>240,"StartG"=>240,"StartB"=>240,"EndR"=>180,"EndG"=>180,"EndB"=>180,"Alpha"=>20));
     $myPicture->setFontProperties(array("FontName"=>$fontPath."verdana.ttf","FontSize"=>8));
    
     /* Draw the chart scale */ 
     $myPicture->setGraphArea($x,50,$alto-20,$ancho-20);
     $myPicture->drawScale(array("CycleBackground"=>TRUE,"DrawSubTicks"=>TRUE,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridAlpha"=>10,"Pos"=>SCALE_POS_TOPBOTTOM));
    
     /* Turn on shadow computing */ 
     $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
    
     /* Create the per bar palette */
     $Palette = array("0"=>array("R"=>188,"G"=>224,"B"=>46,"Alpha"=>100),
                      "1"=>array("R"=>224,"G"=>100,"B"=>46,"Alpha"=>100),
                      "2"=>array("R"=>224,"G"=>214,"B"=>46,"Alpha"=>100),
                      "3"=>array("R"=>46,"G"=>151,"B"=>224,"Alpha"=>100),
                      "4"=>array("R"=>176,"G"=>46,"B"=>224,"Alpha"=>100),
                      "5"=>array("R"=>224,"G"=>46,"B"=>117,"Alpha"=>100),
                      "6"=>array("R"=>92,"G"=>224,"B"=>46,"Alpha"=>100),
                      "7"=>array("R"=>224,"G"=>176,"B"=>46,"Alpha"=>100));
    
     /* Draw the chart */ 
     $myPicture->drawBarChart(array("DisplayPos"=>LABEL_POS_INSIDE,"DisplayValues"=>TRUE,"Rounded"=>TRUE,"Surrounding"=>30,"OverrideColors"=>$Palette));
    
     /* Write the legend */ 
     //$myPicture->drawLegend(570,215,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
    
     /* Render the picture (choose the best way) */
    // $myPicture->autoOutput("pictures/example.drawBarChart.palette.png");
      $myPicture->Render("pictures/.".$name.".png"); 
     ?>
     <div aling="center">
        <img alt="Resultados " src="<?php echo "pictures/.".$name.".png?random=".time(); ?>" style="border: 1px solid gray;margin-right: 20px;"/>
     </div>
     <br />
     <?PHP
   }/*public function GraficaBarras*/
   public function DetalleCarreraEncuesta($id_instrumento,$Carrera_id){
    global $db;
    
       $SQL='SELECT 
            
                c.nombrecarrera,
                COUNT(a.usuarioid) as num ,
                c.codigocarrera
            
            FROM 
                 
                 actualizacionusuario a INNER JOIN usuario u ON u.idusuario=a.usuarioid
                                        INNER JOIN estudiantegeneral eg ON eg.numerodocumento=u.numerodocumento
                                        INNER JOIN estudiante e ON e.idestudiantegeneral=eg.idestudiantegeneral
                                        INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera

            WHERE 
            
            a.id_instrumento ="'.$id_instrumento.'"  
            AND 
            a.estadoactualizacion=2
            AND
            a.codigoestado=100
            AND
            c.codigocarrera="'.$Carrera_id.'"
            
            
            GROUP BY c.nombrecarrera';
            
         if($Data=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de data por carrera ...<br><br>'.$SQL;
            die;
         }
         
         $C_Data  = $Data->GetArraY();
         
         return $C_Data;   
    
   }/*public function DetalleCarreraEncuesta*/
   public function DataDocente($id_instrumento,$Periodo){
    global $db;
    
      $SQL='SELECT

            x.nombrecarrera as Nombre,
            COUNT(x.nombrecarrera) as Num
            
            FROM
            (
            SELECT
            
            a.idactualizacionusuario,
            a.usuarioid,
            a.numerodocumento,
            g.idgrupo,
            g.codigomateria,
            m.nombremateria,
            c.codigocarrera,
            c.nombrecarrera
            
            FROM
            
            actualizacionusuario  a INNER JOIN usuario u ON u.idusuario=a.usuarioid AND u.codigorol=2
									LEFT JOIN grupo g ON g.numerodocumento=u.numerodocumento 
									LEFT JOIN materia m ON m.codigomateria=g.codigomateria
									LEFT JOIN carrera c ON c.codigocarrera=m.codigocarrera
            												
            
            WHERE
            
            
            a.id_instrumento="'.$id_instrumento.'"
            AND
            a.codigoestado=100
            AND
            a.estadoactualizacion=2
            AND
            c.codigocarrera is Not NULL
            
            GROUP BY a.idactualizacionusuario
            ) x
            GROUP BY x.nombrecarrera
            
            UNION
            
            SELECT

            x.nombrecarrera as Nombre,
            COUNT(x.usuarioid) as Num
            
            
            FROM
            (
            SELECT
            
            a.idactualizacionusuario,
            a.usuarioid,
            a.numerodocumento,
            g.idgrupo,
            g.codigomateria,
            m.nombremateria,
            c.codigocarrera,
            c.nombrecarrera
            
            FROM
            
            actualizacionusuario  a INNER JOIN usuario u ON u.idusuario=a.usuarioid AND u.codigorol=2
            												LEFT JOIN grupo g ON g.numerodocumento=u.numerodocumento 
            												LEFT JOIN materia m ON m.codigomateria=g.codigomateria
            												LEFT JOIN carrera c ON c.codigocarrera=m.codigocarrera
            												
            
            WHERE
            
            
            a.id_instrumento="'.$id_instrumento.'"
            AND
            a.codigoestado=100
            AND
            a.estadoactualizacion=2
            AND
            c.codigocarrera is  NULL
            
            
            GROUP BY a.idactualizacionusuario
            
            
            ) x
            GROUP BY x.nombrecarrera';
            /*
            AND
            a.codigoperiodo="'.$Periodo.'"
            */
            if($DataDocente=&$db->Execute($SQL)===false){
                echo 'Error en el SQl de Data De Docentes...<br><br>'.$SQL;
                die;
            }
            
        $D_Docente  = $DataDocente->GetArray();
        
        return $D_Docente;    
   }/*public function DataDocente*/
   public function DataRecienEgresado(){
     global $db;
     
     $Year = date('Y');
     $month = date('m');
     
     $Fecha  = $Year-5;
     
     $Fecha = $Fecha.'-'.$month.'-00';
     
    
     
           $SQL_Recien='SELECT

                        x.nombrecarrera as Nombre,
                        COUNT(x.nombrecarrera) as Num,
                        x.codigocarrera
                        
                        FROM
                        (
                            SELECT 
                            eg.numerodocumento,
                            e.codigoestudiante,
                            e.codigocarrera,
                            c.nombrecarrera
                            
                            FROM registrograduado rg INNER JOIN estudiante e ON e.codigoestudiante=rg.codigoestudiante 
                            												 INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral 
                            												 INNER JOIN carrera c ON e.codigocarrera=c.codigocarrera
                            
                            
                            WHERE rg.fechagradoregistrograduado>="'.$Fecha.'" 
                            
                            ORDER BY rg.fecharegistrograduado ASC
                            
                            )x
                            GROUP BY x.nombrecarrera
                            
                            ORDER BY x.nombrecarrera';
                    
                    if($RecienEgresado=&$db->Execute($SQL_Recien)===false){
                        echo 'Error en el SQl de Recien egresado...<br><br>'.$SQL_Recien;
                        die;                        
                    }
                
                $R_Data = array();
                
                while(!$RecienEgresado->EOF){
                    
                        $R_Data['Nombre'][]             = $RecienEgresado->fields['Nombre'];
                        $R_Data['num'][]                = $RecienEgresado->fields['Num'];
                        $R_Data['CodigoCarrera'][]       = $RecienEgresado->fields['codigocarrera'];
                    
                    $RecienEgresado->MoveNext();
                }/*while*/
                    
         return $R_Data;             
    
   }/*public function DataEgresado*/
   public function ConsolidacionEgresado(){
     global $db;
     
     
     $Year = date('Y');
     $month = date('m');
     
     $Fecha  = $Year-6;
     
     $Fecha_1 = $Fecha.'-'.$month.'-00';
     
     
     $Fecha_2  = $Year-34;
     
     $Fecha_2 = $Fecha_2.'-'.$month.'-00';
     
         $SQL_Conso='SELECT


                        x.nombrecarrera as Nombre,
                        COUNT(x.nombrecarrera) as Num,
                        x.codigocarrera
                        
                        
                        
                        FROM( 
                        
                        SELECT 
                        
                                eg.numerodocumento,
                                e.codigoestudiante,
                                e.codigocarrera,
                                c.nombrecarrera
                                
                                FROM registrograduado rg INNER JOIN estudiante e ON e.codigoestudiante=rg.codigoestudiante 
                                                         INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral
                                                         INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera
                                
                                
                                WHERE rg.fechagradoregistrograduado>="'.$Fecha_2.'" AND rg.fechagradoregistrograduado<="'.$Fecha_1.'"
                                
                                UNION 
                                
                                
                                SELECT 
                                
                                rga.documentoegresadoregistrograduadoantiguo,
                                e.codigoestudiante,
                                e.codigocarrera,
                                c.nombrecarrera
                                
                                
                                FROM registrograduadoantiguo rga INNER JOIN estudiante e ON e.codigoestudiante=rga.codigoestudiante 
                                                                 INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral 
                                                                 INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera
                                
                                WHERE rga.fechagradoregistrograduadoantiguo>="'.$Fecha_1.'" AND rga.fechagradoregistrograduadoantiguo<="'.$Fecha_1.'")
                                
                        x
                        
                        GROUP BY x.nombrecarrera
                        
                        ORDER BY x.nombrecarrera';
                    
                    
                 if($ConsolidacionEgresado=&$db->Execute($SQL_Conso)===false){
                    echo 'Error en el SQl de Consolidacion <br><br>'.$SQL_Conso;
                    die;
                 }
                 
                 
                 $R_Data = array();
                
                while(!$ConsolidacionEgresado->EOF){
                    
                        $R_Data['Nombre'][]              = $ConsolidacionEgresado->fields['Nombre'];
                        $R_Data['num'][]                 = $ConsolidacionEgresado->fields['Num'];
                        $R_Data['CodigoCarrera'][]       = $ConsolidacionEgresado->fields['codigocarrera'];
                    
                    $ConsolidacionEgresado->MoveNext();
                }/*while*/
                    
         return $R_Data; 
                      
   }/*public function ConsolidacionEgresado*/
   public function DataEgresado($id_instrumento,$op){
     global $db;
     
     
    if($op==0){
        
        $SQL='SELECT

                x.nombrecarrera as Nombre,
                COUNT(x.nombrecarrera) as Num,
                x.codigocarrera
                
                FROM
                   (SELECT 
                    
                    a.usuarioid,
                    a.numerodocumento,
                    eg.idestudiantegeneral,
                    e.codigoestudiante,
                    e.codigocarrera,
                    c.nombrecarrera
                    
                    
                    FROM actualizacionusuario a INNER JOIN usuario u ON u.numerodocumento=a.numerodocumento
                                                INNER JOIN estudiantegeneral eg ON eg.numerodocumento=u.numerodocumento
                    							INNER JOIN estudiante e ON e.idestudiantegeneral=eg.idestudiantegeneral
                    							INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera
                                                INNER JOIN registrograduado r ON r.codigoestudiante=e.codigoestudiante
                    
                    WHERE 
                    
                    a.id_instrumento ="'.$id_instrumento.'" 
                    AND 
                    a.estadoactualizacion IN (1,2) 
                    AND 
                    a.codigoestado = 100 
                    
                    
                    GROUP BY a.numerodocumento
                    
                    ORDER BY a.usuarioid
                    )x
                    GROUP BY x.nombrecarrera
                    ORDER BY x.nombrecarrera';
        
    }else{
        
          $SQL='SELECT

                x.nombrecarrera as Nombre,
                COUNT(x.nombrecarrera) as Num,
                x.codigocarrera
                
                FROM
                (
                
                
                SELECT 
                
                    a.usuarioid,
                    a.numerodocumento,
                    eg.idestudiantegeneral,
                    e.codigoestudiante,
                    e.codigocarrera,
                    c.nombrecarrera
                    
                    
                    FROM actualizacionusuario a 
                                                INNER JOIN estudiantegeneral eg ON eg.numerodocumento=a.numerodocumento
                                                INNER JOIN estudiante e ON e.idestudiantegeneral=eg.idestudiantegeneral
                                                INNER JOIN carrera c ON c.codigocarrera=e.codigocarrera
                                                LEFT JOIN registrograduado r ON r.codigoestudiante=e.codigoestudiante
                                                LEFT JOIN registrograduadoantiguo rg ON rg.codigoestudiante=e.codigoestudiante
                    
                    WHERE 
                    
                    a.id_instrumento ="'.$id_instrumento.'"
                    AND 
                    a.estadoactualizacion IN (1,2) 
                    AND 
                    a.codigoestado = 100 
                    
                    
                    GROUP BY a.numerodocumento
                    
                    ORDER BY e.codigocarrera
                    )x
                    GROUP BY x.nombrecarrera
                    
                    ORDER BY x.nombrecarrera';      
        
    }/*if*/ 
      
                
  

          if($Dato=&$db->Execute($SQL)===false){
            echo 'Error en el SQL del Dato ....<br><br>'.$SQL;
            die;
          }  
    
        $D_Data = array();
        
        while(!$Dato->EOF){
            
              $D_Data['Nombre'][]               = $Dato->fields['Nombre'];  
              $D_Data['Num'][]                  = $Dato->fields['Num'];
              $D_Data['CodigoCarrera'][]        = $Dato->fields['codigocarrera'];
            
            $Dato->MoveNext();
        }/*while*/
    
    
    return $D_Data;
    
   }/**/
}//Clas Encuestas

?>