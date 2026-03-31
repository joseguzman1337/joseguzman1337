<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    
    
    require_once('../Connections/sala2.php');
    $rutaado = "../funciones/adodb/";
    require_once('../Connections/salaado.php');   
?>
<html>
    <head>
        <title>Convenios</title>
        <style type="text/css" title="currentStyle">
                @import "../css/demo_page.css";
                @import "../css/demo_table_jui.css";
                @import "../css/themes/smoothness/jquery-ui-1.8.4.custom.css";
                
                
        </style>
        <!--<link type="text/css" href="../mgi/css/cssreset-min.css" rel="stylesheet">
        <link type="text/css" href="../mgi/css/styleMonitoreo.css" rel="stylesheet">        
	<link type="text/css" href="../mgi/css/styleDatos.css" rel="stylesheet">-->
	<style type="text/css">
	  div#container table.formData tr td {
	    border: 1px solid #000000;
	  }
	  div#container table.formData tr th,div#container table.formData tr td{
	    border:1px solid #000;	  
	  }
	  table.formData th {
	    font-weight: bold;
	    text-align: center;
	  }
	  table.formData th,table.formData td {    
	    padding: 0.5em;
	  }
	  table.formData th,table.formData td {
	      margin: 0;	      
	  }
	  table.formData {
	      font-size: 0.8em;
	      border-collapse:collapse;
	  }
	  table.formData tr.category th {
	    background-color: #D8D8C0;
	  }
	</style>
        <script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="../js/jquery-ui-1.8.21.custom.min.js"></script>        
        <script type="text/javascript">
        var oTable;   
        var aSelected = [];

       function traercontenido(){           
           $.ajax({
                dataType: 'json',
                type: 'POST',
                url: 'lookupInstitucion.php',
                dataType: "html",
                data: "id=sdsds",                
                success:function(data){                    
                    $('#searh').html(data);},
                error: function(data,error){}
            });           
       }
       
        function sendForm(){
	    var resultado=true;
	    $.ajax({
                dataType: 'json',
                type: 'POST',
                url: 'consultacodigoconvenio.php',
                async:false,
                data: $('#form_test').serialize(),                
                success:function(data){
                       if(data.success==false){
			  $.ajax({
			      dataType: 'json',
			      type: 'POST',
			      url: 'process.php',
			      async:false,
			      data: $('#form_test').serialize(),                
			      success:function(data){ 
			      //console.log('holaaaaa');
			      //$('.result').html(data); 
			      return true;
			      },
			      error: function(data,error){}
			  });  
                       
                       }
                       else if(data.success==true){
			alert('Ya Existe un Codigo de Convenio');
			resultado=false;
			return false;
                       }
		
		},
                error: function(data,error){}
            });            
	    
        return resultado;            
        }
        
        function deleteForm(){
            if(confirm('Esta seguro de eliminar este registro?')){                
                if(aSelected.length==1){
                var id = aSelected[0];
                id=id.substring(4,id.length);                
                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: 'process.php?delete=true',
                    data: 'idsiq_convenio='+id+'&entity=convenio',
                    success:function(data){$('.result').html(data);},
                    error: function(data,error){}
                }); 
                }else{
                    return false;
                }
                alert('Registro eliminado satisfactoriamente!');
                location.reload();
            }
        }
        
        function updateForm(){            
            if(aSelected.length==1){
                var id = aSelected[0];
                showPanel('dialog',id);
            }else{
                return false;
            }
        }
        function gotodetalle(){            
            if(aSelected.length==1){
                var id = aSelected[0];
                id=id.substring(4,id.length);
                window.location.href= "detalleconlistar.php?id="+id;
            }else{
                return false;
            }
        }
        
        function gotoanexo(){            
            if(aSelected.length==1){
                var id = aSelected[0];
                id=id.substring(4,id.length);
                window.location.href= "anexolistar.php?id="+id;
            }else{
                return false;
            }
        }

        
   
        /* Formating function for row details */
        function validar(){
        
	    var patcodconvenio=/^\d{4}$/;
        
            if($("#nombreconvenio").val()=='') {
                alert("El nombre del convenio no debe estar vacio");
                $("#nombreconvenio").focus();
               return false;
            }else if($("#codigoconvenio").val()=='' || !($("#codigoconvenio").val().match(patcodconvenio))){
                alert("Debe Digitar el Código del Convenio y debe ser númerico de 4 digitos");
                $("#codigoconvenio").focus();
               return false;
            }else if($("#idsiq_institucionconvenio").val()==''){
                alert("La institución no debe estar vacio");
                $("#nombreinstitucion").focus();
               return false;
            }else if($("#fechainicio").val()==''){
                alert("La fecha inicio del convenio no debe estar vacio");
                $("#fechainicio").focus();
               return false;
            }else if($("#fechafin").val()==''){
                alert("La fecha fin del convenio no debe estar vacio");
                $("#fechafin").focus();
               return false;
            }else if($("#fechainicio").val()>$("#fechafin").val()){
                alert("La fecha fin del convenio no debe ser menor a la fecha de inicio");
                $("#fechafin").focus();
               return false;
            }
            else{
                return true;
           } 
        }
        
       function showPanel(panelID,id){
            $panel = $('#'+panelID);
            $.ajax({
                url: "createconvenio.php",
                type: "GET",
                dataType: "html",
                async: false,
                data: { "id": id},
                success: function (obj) {
                    // obj will contain the complete contents of the page requested
                    // use jquery to extract just the html inside the body tag                   
                    // then update the dialog contents with this and show it
                    $panel.html(obj);
                    $.fx.speeds._default = 1000;
                    $panel.dialog({
                        height: 500,
			width: 880,
			modal: true,
                        show: "blind",
			hide: "explode",
                        buttons:{        
                            Cancelar: function() {
                                $(this).dialog( "close" );
                            },
                             Guardar: function() {
                                  if(validar()){  
                                    if(confirm('Esta Seguro de Realizar esta accion')){
                                        var validado=sendForm();
                                        //console.log(validado);
                                        if(validado==true){
                                        alert('Proceso realizado satisfactoriamente');
                                        $( this ).dialog( "close" );
                                        location.reload();
                                        }
                                    }else{
                                        $( this ).dialog( "close" );
                                    }
                                }
                            } 
                        }
                    }                    
                );
                }
            });
        }
            
  
        
            
        $(document).ready(function() { 
        
	     var sql;
        
	     sql="SELECT s.idsiq_convenio, s.nombreconvenio,s.codigoconvenio,s.fechainicio,s.fechafin, CASE WHEN DATEDIFF(s.fechafin, NOW()) BETWEEN 0 and 90 THEN 'POR VENCER' WHEN NOW() BETWEEN s.fechainicio and s.fechafin THEN 'ACTIVO' WHEN NOW() > s.fechafin THEN 'VENCIDO' end as situacionconvenio FROM siq_convenio s";
        
            oTable = $('#example').dataTable({         
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "bServerSide": true,                                
                "sAjaxSource": "../mgi/server_processing.php?active=true&table=siq_convenio&sql="+sql+"&tableNickname=s&wh=s.codigoestado&join=true",
                "aoColumns": [
                { "sTitle": "Nombre del Convenio" },                 
                { "sTitle": "Código del Convenio" },
                { "sTitle": "Fecha Inicio" },
                { "sTitle": "Fecha Fin" },
                { "sTitle": "Estado" }
                ]
            });
            /* Click event handler */
             $('#example tbody tr').live('click', function () {
                var id = this.id;
                var index = jQuery.inArray(id, aSelected);
                 if ( $(this).children().hasClass('dataTables_empty') && index === -1  ) {
                     aSelected1.splice(index, 1);
                    $("#ToolTables_example_1").addClass('DTTT_disabled');
                    $("#ToolTables_example_2").addClass('DTTT_disabled');
                    $("#ToolTables_example_3").addClass('DTTT_disabled');
                    $("#ToolTables_example_4").addClass('DTTT_disabled');
                }else{
                    aSelected.push(id); 
                   // alert(aSelected+' '+aSelected.length);
                    if (aSelected.length>1) aSelected.shift();
                   // alert(aSelected+' '+aSelected.length);
                    oTable.$('tr.row_selected').removeClass('row_selected');
                    $(this).addClass('row_selected');
                    $("#ToolTables_example_1").removeClass('DTTT_disabled');                    
                    $("#ToolTables_example_2").removeClass('DTTT_disabled');
                    $("#ToolTables_example_3").removeClass('DTTT_disabled');
                    $("#ToolTables_example_4").removeClass('DTTT_disabled');
                }
             } );
            
            $('#ToolTables_example_0').click( function () {  
                showPanel('dialog','');  
                //Popup2();
            } );
            
            $('#ToolTables_example_1').click( function () {  
                updateForm();                
            } );
            $('#ToolTables_example_2').click( function () {  
                deleteForm();                
            } );
            $('#ToolTables_example_3').click( function () {  
                gotodetalle();                
            } );
            $('#ToolTables_example_4').click( function () {  
                gotoanexo();                
            } );
            
            //$("#example_length").append("<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='institucionconvenio.php'><img src='../css/themes/smoothness/images/plus.gif'>&nbsp;Nuevo</a></label>");
            
        } );
        </script>
    </head>
    <body id="dt_example">
        <div id="container">
            <div class="full_width big">Convenios</div>
            
            <div >
            <br>
            <?php 
            $query_existecod = "select idsiq_convenio, nombreconvenio,codigoconvenio,fechainicio,fechafin,
	      CASE 
	      WHEN DATEDIFF(fechafin, NOW()) BETWEEN 0 and 90 THEN 'POR VENCER'
	      WHEN NOW() > fechafin THEN 'VENCIDO'
	      end as situacionconvenio
	      from siq_convenio
	      where codigoestado like '1%'
	      and (NOW() > fechafin or DATEDIFF(fechafin, NOW()) BETWEEN 0 and 90)
	      order by 5 desc";
	    $existecod= $db->Execute($query_existecod);
	    $totalRows_existecod = $existecod->RecordCount();
	    
	    
	    if($totalRows_existecod > 0){
	    ?>
	    
	      <table class="viewData formData" width="100%" border="1">
                    <thead>
		      <tr class="dataColumns category">
			<th colspan="5">Información de Convenios Vencidos</th>		                          
		      </tr>
		      <tr class="dataColumns category">                            
			      <th>Nombre Convenio</th>
			      <th>Codigo Convenio</th>
			      <th>Fecha Inicio</th>
			      <th>Fecha Finalización</th>
			      <th>Situacion Convenio</th>
			      
		      </tr>
                    </thead>
                    <tbody>
		      <?php 
			while($row_existecod = $existecod->FetchRow()){
		      ?>
		      <tr>
			<td><?php echo $row_existecod['nombreconvenio']; ?></td>
			<td><?php echo $row_existecod['codigoconvenio']; ?></td>
			<td><?php echo $row_existecod['fechainicio']; ?></td>
			<td><?php echo $row_existecod['fechafin']; ?></td>
			<td><?php echo $row_existecod['situacionconvenio']; ?></td>
		      </tr>
		      <?php
		      }
		      ?>
                    </tbody>
                </table>
	      <?php
	      }
	      ?>
      
	    </div>
            
            <h1>Administraci&oacute;n de Convenios</h1>
            <div class="demo_jui">
                <div class="DTTT_container">
                <button id="ToolTables_example_0" class="DTTT_button DTTT_button_text">
                <span>Nuevo</span>
                </button>
                <button id="ToolTables_example_1" class="DTTT_button DTTT_button_text DTTT_disabled">
                <span>Editar</span>
                </button>
                <button id="ToolTables_example_2" class="DTTT_button DTTT_button_text DTTT_disabled">
                <span>Eliminar</span>
                </button>
                <button id="ToolTables_example_3" class="DTTT_button DTTT_button_text DTTT_disabled">
                <span>Detalle Carrera</span>                
                </button>
                <button id="ToolTables_example_4" class="DTTT_button DTTT_button_text DTTT_disabled">
                <span>Anexos</span>                
                </button>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>                            
                            <th>Nombre del Convenio</th>
                            <th>pais</th>
                             <th>Duracion del convenio</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>  
                        </tr>
                    </thead>
                    <tbody>
                        <!tr class="gradeX" esta clase es rosado-->
                        <!tr class="gradeC" esta clase es Asul-->
                        <!tr class="gradeU"-->
                    </tbody>
                </table>
            </div>
        </div>
        <div id="dialog">
        </div>
    </body>
</html>