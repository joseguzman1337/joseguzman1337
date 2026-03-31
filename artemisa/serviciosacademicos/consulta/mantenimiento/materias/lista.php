<?php
session_start();
include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION); 
	
unset ($_SESSION['sesion_materias']);
$fechahoy=date("Y-m-d H:i:s");
require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado.php');

switch($_REQUEST['codigocarrera']){
    case 'TextBuscar':{TextBuscar($db,$_REQUEST['term']);}break;
    case 'Programa':{Programas($db,$_POST['dato']);}break;
    case '1':{Others($db);}break;
    case '156':{Others($db);}break;
    default:{
        Principal($db,$_REQUEST['codigocarrera'],$_SESSION);
    }break;
}

function Principal($db,$CodigoCarrera,$_SESSION){
    
//$SQL='SELECT * FROM usuariorol WHERE usuario = "'.$_SESSION['usuario'].'" AND idrol=13';
$SQL='SELECT rol.* FROM usuariorol rol 
inner join UsuarioTipo ut on ut.UsuarioTipoId = rol.idusuariotipo
inner join usuario u on ut.UsuarioId=u.idusuario 
WHERE u.usuario = "'.$_SESSION['usuario'].'" AND rol.idrol=13';
if($Acceso=&$db->Execute($SQL)===false){
    echo 'Error en el Sistema....';
    die;
}

$Condicion="";

if($Acceso->EOF){
    $Condicion = " and m.codigoestadomateria = '01'";
}

    $query ="select m.codigomateria, m.nombrecortomateria, m.nombremateria, m.numerocreditos, m.codigoperiodo, m.notaminimaaprobatoria, m.notaminimahabilitacion, m.numerosemana, m.numerohorassemanales, m.porcentajeteoricamateria, m.porcentajepracticamateria, m.porcentajefallasteoriamodalidadmateria, m.porcentajefallaspracticamodalidadmateria, m.codigomodalidadmateria, m.codigolineaacademica, m.codigocarrera, m.codigoindicadorgrupomateria, m.codigotipomateria, m.codigoestadomateria, m.ulasa, m.ulasb, m.ulasc, m.codigoindicadorcredito, m.codigoindicadoretiquetamateria, m.codigotipocalificacionmateria, ca.nombrecarrera ,e.nombreestadomateria
    FROM
	carrera ca,
	materia m INNER JOIN estadomateria  e ON e.codigoestadomateria=m.codigoestadomateria
    
    where ca.codigocarrera = m.codigocarrera
    and ca.codigocarrera = '".$CodigoCarrera."'
    ".$Condicion."
        order by m.nombremateria";
        $rta= $db->Execute($query);
                $totalRows_rta = $rta->RecordCount();
$row_rta = $rta->FetchRow();
?>

<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
</head>
    <body>
<form name="form1" id="form1"  method="GET" action="listabusquedamaterias.php?codigocarrera=<?php echo $CodigoCarrera; ?>">
  <table width="750px"  border="0" align="center" cellpadding="3" cellspacing="3">

         <TR >
           <TD align="center"><label id="labelresaltadogrande" >LISTA DE MATERIAS PARA <?php echo $row_rta['nombrecarrera']; ?></label></TD>
          </TR>
   </table>

       <TABLE width="50%"  border="1" align="center">
        <TR id="trgris" align="center">
                <TD id="tdtitulogris" colspan="4"  align="center">

                <INPUT type="button" value="Adicionar" onClick="window.location.href='insertar_modificar.php?codigocarrera=<?php echo $CodigoCarrera; ?>'">
                <INPUT type="button" value="Regresar" onClick="window.location.href='menumodalidad.php'">
                </TD>
        </TR>
        <TR id="trgris">
            <TD align="center"><label id="labelresaltado">Código </label></TD>
            <TD align="center"><label id="labelresaltado">Nombre </label></TD>
            <?PHP 
            if(!$Acceso->EOF){
            ?>
            <TD align="center"><label id="labelresaltado">Estado </label></TD>
            <?PHP 
            }
            ?>
        </TR>
        <TR id="trgris">
            <TD align="center"><INPUT type="submit" value="Filtrar"></TD>
            <TD align="center" colspan="2">
                <INPUT type="text" name="buscar" id="buscar">
                <INPUT type="hidden" name="codigocarrera" value="<?php echo $CodigoCarrera; ?>">
            </TD>

        </TR>
            <?php do {?>
        <TR>
            <TD width="5%" align="center"><?php echo $row_rta['codigomateria']; ?></TD>
            <TD align="center"><A id="aparencialink" href="insertar_modificar.php?codigomateria=<?php echo $row_rta['codigomateria']."&codigocarrera=".$CodigoCarrera; ?>"><?php echo $row_rta['nombremateria']; ?></A></TD>
            <?PHP 
            if(!$Acceso->EOF){
                if($row_rta['codigoestadomateria']=='01'){
                    $Color ='green';
                }else{
                    $Color ='#cc0000';
                }
            ?>
            <TD width="5%" align="center" style="color:<?PHP echo $Color?>"><?php echo $row_rta['nombreestadomateria']; ?></TD>
            <?PHP 
            }
            ?>
        </TR>
        <?php }while($row_rta = $rta->FetchRow());
         ?>
        
       </TABLE>

</form>
</body>
</html>
<?PHP 
}
function Others($db){
    ?>
    <html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
        <link rel="stylesheet" href="../../../mgi/../css/demo_table_jui.css" type="text/css" /> 
        <link rel="stylesheet" href="../../../mgi/../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>   
        <script type="text/javascript" language="javascript">
            function BuscarPrograma(value){
                formatText();
                $.ajax({//Ajax
                      type: 'POST',
                      url: 'lista.php',
                      async: false,
                      dataType: 'html',
                      data:{ dato : value ,codigocarrera:'Programa'},
                      error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
                      success: function(data){
                            $('#Td_Programa').html(data);
                      }//DATA
                  });//AJAX
            }
            function BuscarMaterias(){
                
                if($.trim($('#BuscarText_id').val())){
                    var Materia = $('#BuscarText_id').val();
                    var Carrera = $('#BuscarText_id2').val();
                    $.ajax({//Ajax
                          type: 'POST',
                          url: 'insertar_modificar.php',
                          async: false,
                          dataType: 'html',
                          data:{codigomateria:Materia,codigocarrera:Carrera},
                          error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
                          success: function(data){
                                $('#DataCarga').html(data);
                          }//DATA
                    });//AJAX
                }else{
                
                var codigocarrera = $('#Programa').val();
                 
                $.ajax({//Ajax
                      type: 'POST',
                      url: 'lista.php',
                      async: false,
                      dataType: 'html',
                      data:{codigocarrera:codigocarrera},
                      error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
                      success: function(data){
                            $('#DataCarga').html(data);
                      }//DATA
                });//AJAX
              }  
            }
            function BuscarMateriaText(){
                $('#BuscarText').autocomplete({    					
                    source: "lista.php?codigocarrera=TextBuscar",
                    minLength: 2,
                    select: function( event, ui ) {
                            $('#BuscarText_id').val(ui.item.id);   //id2
                            $('#BuscarText_id2').val(ui.item.id2);   //id2                         
                            
                    }                
                });
            }
            function formatText(){
                $('#BuscarText').val('');
                $('#BuscarText_id').val('');
                $('#BuscarText_id2').val('');
            }
        </script>
    </head>
    
    <body>
        <TABLE  width="750px"  border="0" align="center" cellpadding="3" cellspacing="3">
            <TR id="trgris">
                <TD><label id="labelresaltado">Modalidad Acad&eacute;mica</label></TD>
                <TD><?PHP Modalidad($db);?></TD>
            </TR>
            <TR id="trgris">
                <TD><label id="labelresaltado">Programa Acad&eacute;mico</label></TD>
                <TD id="Td_Programa">
                    <select id="Programa" name="Programa">
                        <option value="-1"></option>
                    </select>
                </TD>
            </TR>
            <tr id="trgris">
                <td colspan="2">
                    <label id="labelresaltado">Busqueda por Codigo o Nombre Materia</label>
                </td>
            </tr>
            <tr id="trgris">
                <td colspan="2" style="text-align: center;">
                    <input type="text" style="text-align: center;" autocomplete="off" name="BuscarText" id="BuscarText" size="70" onkeypress="BuscarMateriaText()" onclick="formatText()" />
                    <input type="hidden"  name="BuscarText_id" id="BuscarText_id"/>
                    <input type="hidden"  name="BuscarText_id2" id="BuscarText_id2"/>
                </td>
            </tr>
            <tr id="trgris">
                <td colspan="2">
                    <input type="button" value="Buscar" onclick="BuscarMaterias()" />
                </td>
            </tr>
        </TABLE>
        <div id="DataCarga"></div>
    </body>
    </html>
    <?PHP
}
function Modalidad($db){
      $SQL='SELECT
            	codigomodalidadacademica,
            	nombremodalidadacademica
            FROM
            	modalidadacademica
            WHERE
            	codigoestado = 100';
                
         if($Modalidad=&$db->GetAll($SQL)===false){
            echo 'Error en el Sistema...';
            die;
         }       
    
    ?>
    <select id="Modalidad" name="Modalidad" onchange="BuscarPrograma(this.value)">
    <?PHP
    for($i=0;$i<count($Modalidad);$i++){
    ?>
     <option value="<?PHP echo $Modalidad[$i]['codigomodalidadacademica']?>"><?PHP echo $Modalidad[$i]['nombremodalidadacademica']?></option>
    <?PHP    
    }
    ?>
    </select>
    <?PHP    
}
function Programas($db,$modalida){
      $SQL='SELECT
            	codigocarrera AS id,
            	nombrecarrera AS Nombre
            FROM
            	carrera
            WHERE
            	codigomodalidadacademica = "'.$modalida.'"
            AND (	fechavencimientocarrera >= curdate() 	OR EsAdministrativa = 1)
            AND codigocarrera NOT IN (1)';
            
      if($Programa=&$db->GetAll($SQL)===false){
        echo 'Error en el Sistema...';
        die;
      }   
   ?>
    <select id="Programa" name="Programa" >
    <?PHP
    for($i=0;$i<count($Programa);$i++){
    ?>
     <option value="<?PHP echo $Programa[$i]['id']?>"><?PHP echo $Programa[$i]['Nombre']?></option>
    <?PHP    
    }
    ?>
    </select>
    <?PHP         
            
}
function TextBuscar($db,$letra){
     $SQL='SELECT
            
            	m.codigomateria,
            	m.nombremateria,
            	e.nombreestadomateria,
                m.codigocarrera
            FROM
            	materia m
            INNER JOIN estadomateria e ON e.codigoestadomateria = m.codigoestadomateria
            WHERE
            m.codigomateria LIKE "'.$letra.'%" OR  m.nombremateria LIKE"'.$letra.'%"';
            
      if($Materia=&$db->Execute($SQL)===false){
        echo 'Error en el Sistema...';
        die;
      }  
      
      $DataMateria = array();
         
      if(!$Materia->EOF){
            while(!$Materia->EOF){
               
                    $Ini_Vectt['label']=$Materia->fields['codigomateria'].' :: '.$Materia->fields['nombremateria'].' :: '.$Materia->fields['nombreestadomateria'];
                    $Ini_Vectt['value']=$Materia->fields['codigomateria'].' :: '.$Materia->fields['nombremateria'].' :: '.$Materia->fields['nombreestadomateria'];
                    $Ini_Vectt['id']   =$Materia->fields['codigomateria'];
                    $Ini_Vectt['id2']   =$Materia->fields['codigocarrera'];
                    
                    array_push($DataMateria, $Ini_Vectt);
                
                $Materia->MoveNext();
            }//while
        }else{
            $Ini_Vectt['label']='No Hay Informacion';
            $Ini_Vectt['value']='No Hay Informacion';
            $Ini_Vectt['id']   ='-1';
            
           array_push($DataMateria, $Ini_Vectt);
        } 
        
       echo json_encode($DataMateria);    
}
?>