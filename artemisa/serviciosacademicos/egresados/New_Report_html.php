<?php
/*
* Caso 90158
* @modified Luis Dario Gualteros 
* <castroluisd@unbosque.edu.co>
 * Se modifica la variable session_start por la session_start( ) ya que es la funcion la que contiene el valor de la variable $_SESSION.
 * @since Mayo 18 de 2017
*/
session_start( );
//End Caso 90158  
include_once(realpath(dirname(__FILE__)).'/../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

switch($_REQUEST['actionID']){
    case 'Reporte':{
        global $userid,$db,$C_New_Report;
       
        MainGeneral(); 
        
       // echo '<pre>';print_r($_POST);die;
        
        $id        = $_POST['id'];
        $Modalidad = $_POST['Modalidad'];
        $Carrera   = $_POST['Carrera'];
        $ExcelReporte = $_POST['reportexcel'];        
        
        $C_New_Report->ViewReport($id,$Modalidad,$Carrera);
        
    }break;
    
    
    
    case 'ReporteExcel':{
        global $userid,$db,$C_New_Report;
       
        MainGeneral(); 
        
       // echo '<pre>';print_r($_POST);die;
        
        $id        = $_POST['id'];
        $Modalidad = $_POST['Modalidad'];
        $Carrera   = $_POST['Carrera'];
             
        $C_New_Report->ViewReportExcel($id,$Modalidad,$Carrera);
    }break;                
        
    case 'Carrera':{
       global $userid,$db,$C_New_Report;
       
       MainGeneral(); 
       
              
       $Modalidad   = $_POST['Modalidad'];
       
       
       $C_New_Report->Carrera($Modalidad);
       
    }break;
    default:{
       global $userid,$db,$C_New_Report;
       
       include_once('New_Report_class.php');   $C_New_Report = new New_Report();
       MainGeneral(); 
       JSGenral();
       
       $id  = $_REQUEST['id'];
       
       $C_New_Report->Consola($id);
    }break;
}
function MainGeneral(){
    
        global $userid,$db,$C_New_Report;
        
		//$proyectoMonitoreo = "Monitoreo";
        //var_dump (is_file('../mgi/templates/template.php'));die;
        include_once("../ReportesAuditoria/templates/mainjson.php");
        include_once('New_Report_class.php');   $C_New_Report = new New_Report();

		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>';
				die;
			}
		
		 $userid=$Usario_id->fields['id'];
}
function JSGenral(){
    ?>
    <script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
    <script type="text/javascript" language="javascript" src="../js/jquery.dataTables.js"></script>
    <script type="text/javascript" language="javascript" src="../js/jquery-ui-1.8.21.custom.min.js"></script> 
    <script type="text/javascript">
    
        function BuscarData(){
           
           var Modalidad = $('#Modalidad').val();
            
            if(Modalidad=='-1' || Modalidad==-1){
                alert('Selecione Una Modalidad Academica.');
                $('#Modalidad').effect("pulsate", {times:3}, 500);
                $('#Modalidad').css('border-color','#F00');
                return false;
            }
           
           $('#actionID').val('Carrera');
           
           $.ajax({//Ajax
			  type: 'POST',
			  url: 'New_Report_html.php',
			  async: false,
			  dataType: 'html',
			  data:$('#NewReport').serialize(),
			  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			  success: function(data){
					$('#Td_Carrera').html(data);
				}//data 
		  }); //AJAX 
          
        }//function Carrera
        function GenerarNewReporte(){
            $('#actionID').val('Reporte');
            $('#Div_Carga').html('Generando Reporte...');
                        
            $('#ExportaExcel').css('visibility','visible');            
            $.ajax({//Ajax
    			  type: 'POST',
    			  url: 'New_Report_html.php',
    			  async: false,
    			  dataType: 'html',
    			  data:$('#NewReport').serialize(),
    			  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    			  success: function(data){
    			        $('#Div_Carga').html(''); 
    					$('#Div_Carga').html(data);
    				}//data 
    		  }); //AJAX 
            
        }//function GenerarNewReporte
        
        function ExportarReporteExcel(){
            /*
            
            var Carrera=$('#Carrera').val();
            var Modalidad=$('#Modalidad').val();
            var Id=$('#id').val();
               
            $(location).attr('href','New_Report_html.php?actionID=ReporteExcel&Modalidad='+Modalidad+'&Carrera='+Carrera+'&id='+Id);*/
              
            
            ////////testing                   
            $('#actionID').val('ReporteExcel');
            $("#NewReport").attr("action", "New_Report_html.php");
            $("#NewReport").attr("method", "POST");
            $("#NewReport").submit();
            
            
            ////final test
            
            ////original            
            /*$('#actionID').val('ReporteExcel');
            $.ajax({//Ajax
    			  type: 'POST',
    			  url: 'New_Report_html.php',
    			  async: false,
                  dataType: 'html',
    			  data:$('#NewReport').serialize(),
    			  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
    			  success: function(data, textStatus) {
                        var win = window.open();
                        win.document.write(data);
                  }//data 
		    });            
                    */
        }
        /////function Ge                
    </script>
    <?PHP
}
?>