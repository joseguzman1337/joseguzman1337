<?php
class Bicicletero{
    public function TipoBicicleta($db){
        
          $SQL='SELECT
                	TipoBicicletaId,
                	nombre
                FROM
                	TipoBicicleta
                WHERE
                	CodigoEstado = 100';
                    
          if($Data=&$db->GetAll($SQL)===false){
            echo 'Error en el Sistema...';
            die;
          }          
        
        return $Data;
    }//public function TipoBicicleta
    public function ValidaDocenteAdmin($db,$Datos){
        $Documento = $this->limpiarCadena(filter_var($Datos['NumDocenteAdmin'],FILTER_SANITIZE_NUMBER_INT));
        $Nombre    = $this->limpiarCadena(filter_var($Datos['Nom_DocenteAdmin'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
        $Apellido  = $this->limpiarCadena(filter_var($Datos['Apll_DocenteAdmin'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
        
        
        if(strlen($Nombre)<3){
            $info['val'] = false;
            $info['msj'] = "Debe escribir Su primer Nombre";
            echo json_encode($info);
            exit;
        }
        
        if(strlen($Apellido)<3){
            $info['val'] = false;
            $info['msj'] = "Debe escribir Su primer Apellido";
            echo json_encode($info);
            exit;
        }
        
          $SQL='SELECT
                	idadministrativosdocentes,
                    nombresadministrativosdocentes,
                    apellidosadministrativosdocentes
                FROM
                	administrativosdocentes
                WHERE
                	numerodocumento = "'.$Documento.'"
                AND
                  nombresadministrativosdocentes LIKE "'.$Nombre.'%"
                AND
                apellidosadministrativosdocentes LIKE "'.$Apellido.'%"';
                
          if($Validacion=&$db->Execute($SQL)===false){
            $info['val'] = false;
            $info['msj'] = "Error Del Sistema...";
            echo json_encode($info);
            exit;
          }
          
        if(!$Validacion->EOF){  
            $info['val'] = true;
            $info['datoadmindocente'] = $Validacion->fields['idadministrativosdocentes'];
            $info['msj'] = "Bienvenido Sr(a).";
            $info['msj2'] = $Validacion->fields['nombresadministrativosdocentes'].' '.$Validacion->fields['apellidosadministrativosdocentes'];
            echo json_encode($info);
            exit; 
        }else{
            $info['val']  = false;
            $info['msj']  = "No Se Encuentra en Sistema...";
            $info['msj2'] = "Por favor verificar los Datos Gracias";
            echo json_encode($info);
            exit;
        }     
    }//public function ValidaDocenteAdmin
    public function limpiarCadena($cadena){
     $cadena = (ereg_replace('[^ A-Za-z0-9_ñÑáéíóúÁÉÍÓÚ\s]', '', $cadena));
     return $cadena;
    }//public function limpiarCadena
    public function InfoAdminDocente($db,$id){
         $SQL='SELECT
                	idadministrativosdocentes,
                    nombresadministrativosdocentes,
                    apellidosadministrativosdocentes,
                    emailadministrativosdocentes,
                    cargoadministrativosdocentes
                FROM
                	administrativosdocentes
                WHERE
                	idadministrativosdocentes = "'.$id.'"';
                    
          if($Info=&$db->GetAll($SQL)===false){
             echo 'Error en el Sistema....';
             die;
          } 
          
          return $Info;         
    }//public function InfoAdminDocente
    public function CalcularTamano($bytes){
    $bytes = $bytes;
    $labels = array('B', 'KB', 'MB', 'GB', 'TB');
	foreach($labels AS $label)
    {
        if ($bytes > 1024)
        {
	       $bytes = $bytes / 1024;
        }
        else {
	      break;
	    }
    }  
    $datos[] =round($bytes, 2);
    $datos[] = $label; 
    return $datos;
    }//public function CalcularTamano
   public function EstudianteId($db,$codigoestudiante,$carrera){
          $SQL='SELECT
                idestudiantegeneral
                FROM
                estudiante
                WHERE
                codigocarrera="'.$carrera.'"
                AND
                codigoestudiante="'.$codigoestudiante.'"';
                
         if($Estudiante=&$db->Execute($SQL)===false){
            echo 'Error en el Sistema...';
            die;
         } 
         
         return $Estudiante->fields['idestudiantegeneral'];      
   }//public function EstudianteId 
   public function ViewBicicletas($db,$idUser,$op){
         if($op!=1){
            $Campo='	b.idadministrativosdocentes = "'.$idUser.'"';
         }else{
            $Campo='	b.idestudiantegeneral = "'.$idUser.'"';           
         }   
         
       return $Dato = $this->SQLViewBici($db,$Campo);   
       
   }//public function ViewBicicletas 
   public function SQLViewBici($db,$Campo){
        $SQL='SELECT
                	b.BicicleteroId,
                	d.DetalleBicicleteroId AS id,
                	d.imagen,
                	d.marca,
                	d.color,
                	d.TipoBicicleta,
                	d.otra,
                	d.observaciones
                FROM
                	Bicicletero b
                INNER JOIN DetalleBicicletero d ON d.BicicleteroId = b.BicicleteroId
                WHERE
                '.$Campo.'
                AND b.CodigoEstado = 100
                AND d.CodigoEstado = 100';
                
         if($Consulta=&$db->GetAll($SQL)===false){
            echo 'Error en el Sistema...';
            die;
         }    
         
         return $Consulta;    
   }//public function SQLViewBici()
   public function ViewBicicletaEdit($Dato){
    //echo '<pre>';print_r($Dato);
        ?>
        <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	    <link rel="stylesheet" href="../../css/demo_page.css" type="text/css" /> 
        <link rel="stylesheet" href="../../css/demo_table_jui.css" type="text/css" />
        <link rel="stylesheet" href="../../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" />
        <link rel="stylesheet" href="../../mgi/css/styleDatos.css" type="text/css" />
        <link rel="stylesheet" href="../../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="../../mgi/css/styleMonitoreo.css" type="text/css" /> 
       
		<script type="text/javascript" language="javascript" src="../../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../../mgi/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>   
        <script type="text/javascript" language="javascript" src="../../mgi/js/jquery.fastLiveFilter.js"></script>  
        <script type="text/javascript" language="javascript" src="../../mgi/js/functions.js"></script>  
        <script type="text/javascript" language="javascript" src="../../mgi/js/functionsMonitoreo.js"></script>
        <script type="text/javascript" language="javascript" src="../js/Bicicletero.js"></script>
    	
    	<script type="text/javascript">
            $(document).ready(function(){
 
                $(".messages").hide();
                //queremos que esta variable sea global
                var fileExtension = "";
                //función que observa los cambios del campo file y obtiene información
                $(':file').change(function()
                {
                    //obtenemos un array con los datos del archivo
                    var file = $("#Bicicleta")[0].files[0];
                    //obtenemos el nombre del archivo
                    var fileName = file.name;
                    //obtenemos la extensión del archivo
                    fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
                    //obtenemos el tamaño del archivo
                    var fileSize = file.size;
                    //obtenemos el tipo de archivo image/png ejemplo
                    var fileType = file.type;
                    //mensaje con la información del archivo
                    showMessage("<span class='info'>Archivo para subir: "+fileName+", peso total: "+fileSize+" bytes.</span>");
                });
             });   
           function validarNumeros(e) { // 1//**onkeydown="return validarNumeros(event)"*//
           
            		tecla = (document.all) ? e.keyCode : e.which; // 2
            		if (tecla==8) return true; // backspace
                    if (tecla==9) return true; // tab
            		if (tecla==109) return true; // menos
                    if (tecla==110) return true; // punto
            		if (tecla==189) return true; // guion
            		//if (e.ctrlKey && tecla==86) { return true}; //Ctrl v
            		if (e.ctrlKey && tecla==67) { return true}; //Ctrl c
            		if (e.ctrlKey && tecla==88) { return true}; //Ctrl x
            		if (tecla>=96 && tecla<=105) { return true;} //numpad
             
            		patron = /[0-9]/; // patron
             
            		te = String.fromCharCode(tecla); 
            		return patron.test(te); // prueba
            }//function validarNumeros
            function val_texto(e) { //*onkeypress="return val_texto(event)"**//
                tecla = (document.all) ? e.keyCode : e.which;
               
                if (tecla==8 || tecla==0){ 
                    return true;
                }else{
                
                patron = /[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/;
                te = String.fromCharCode(tecla);
              
                return patron.test(te);
                }
            }//function val_texto
            function val_textoNumero(e){
               if (tecla==8) return true; // backspace
                if (tecla==9) return true; // tab
                if (tecla==109) return true; // menos
                if (tecla==110) return true; // punto
                if (tecla==189) return true; // guion
                if (tecla==47 || tecla==40 || tecla==41 || tecla==61 || tecla==63 || tecla==191 || tecla==161 || tecla==124 || tecla==58 || tecla==59 || tecla==44 || tecla==46 || tecla==45 || tecla==95) return true;
                if(tecla>=33 && tecla<=39)return true;//!
                if (tecla>=96 && tecla<=105){ return true;} //numpad
                if (tecla==8 || tecla==0){ 
                    return true;
                }else{
                
                patron = /[a-zA-ZñÑáéíóúÁÉÍÓÚ\s0-9]+$/;
                te = String.fromCharCode(tecla);
              
                return patron.test(te);
                }
            }//function val_textoNumero(){}
            
        </script>           
        <style>
        .button{
            background-color: #fff;
            background-image: -moz-linear-gradient(0% 100% 90deg, #bbbbbb, #ffffff);
            border: 1px solid #f1f1f1;
            border-radius: 10px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
            color: #444;
            font-family: Helvetica,Arial,sans-serif;
            font-weight: bold;
            line-height: 1;
            padding: 9px 17px;
            text-shadow: 0 1px 1px rgba(255, 255, 255, 0.85);
            cursor: pointer;
        }
        
        fieldset{
            border: grey 1px solid; margin: 1%;padding: 1%;
        }
        
        
        .tbNuevaInscripcion{
        	border: 0px;
        }
        
        td{
            border: 0px;
           
        }
        h4 {
			font-size: 24px;
			line-height: 26px;
			margin: 20px auto 10px;
			text-align:center;
		}
		
		legend {
			font-size: 1.15em;
		}
		
		.formData input{
			border-color: #ccc;
			border-style: solid;
			border-width: 1px;
			box-sizing: border-box;
			clear: right;
			display: block;
			float: left;
			font-size: 0.9em;
			line-height: 1.1em;
			margin-bottom: 10px;
			margin-left: 15px;
			padding: 3px;
			vertical-align: middle;    
			position: relative;
			top: 5px;
		}
		table.formData{
			    font-size: 14px;
		}
		#OrdenesVer #trtitulogris td{
			font-weight:bold;
		}
		#OrdenesVer table table tr td{
			border: 1px solid #999;
		}
		
		#OrdenesVer a {
			color: #0000EE;
			text-decoration:underline;
			cursor: pointer;
		}
        .Buton{
            background: transparent -moz-linear-gradient(center top , #7db72f, #4e7d0e) repeat scroll 0 0;
            border: 1px solid #538312;
            border-radius: 10px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            color: #e8f0de;
            cursor: pointer;
            display: inline-block;
            font-size: 14px;
            padding: 8px 19px 9px;
            text-align: center;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.3);            
        }
        .ViewBici{
            /*width: 180px;*/
            height: 500px;
            overflow: scroll;
        }
        .TypeBici{
            /*width: 180px;*/
            height: 150px;
            overflow: scroll;
        }
       .messages{
        float: left;
        font-family: sans-serif;
        display: none;
    }
    .info{
        padding: 10px;
        border-radius: 10px;
        background: orange;
        color: #fff;
        font-size: 18px;
        text-align: center;
    }
    .before{
        padding: 10px;
        border-radius: 10px;
        background: blue;
        color: #fff;
        font-size: 18px;
        text-align: center;
    }
    .success{
        padding: 10px;
        border-radius: 10px;
        background: green;
        color: #fff;
        font-size: 18px;
        text-align: center;
    }
    .error{
        padding: 10px;
        border-radius: 10px;
        background: red;
        color: #fff;
        font-size: 18px;
        text-align: center;
    }

       </style>
	<body class="body">
        <h4><?PHP echo $Dato['Label'];?></h4>
         <fieldset style="width: 90%;margin-left:2%; font-family: Lucida Grande, sans-serif; ">
            <legend><strong><?PHP echo $Dato['Label'];?></strong></legend>
            <div class="ViewBici">
            <?PHP 
            for($i=0;$i<count($Dato['Datos']);$i++){
            ?>
            <form id="FormView<?PHP echo $Dato['Datos'][$i]['id'];?>">  
            <input type="hidden" id="action_ID" name="action_ID" class="Clear" />
            <input type="hidden" id="idUser" name="idUser" value="<?PHP echo $Dato['idUser'];?>" />
            <input type="hidden" id="BicicleteroId" name="BicicleteroId" value="<?PHP echo $Dato['Datos'][$i]['BicicleteroId'];?>" />
            <input type="hidden" id="BiciDetalle" name="BiciDetalle" value="<?PHP echo $Dato['Datos'][$i]['id'];?>" />
            <input type="hidden" id="opc" name="opc" value="<?PHP echo $Dato['op'];?>" />
                  <table style="width: 100%;"  border="0" class="formData">
                      <tr>
                        <td rowspan="6" style="text-align: center;" >
                           <img src="../<?PHP echo $Dato['Datos'][$i]['imagen'];?>" width="300" />
                        </td>
                        <td ></td>
                        <td ></td>
                        <td >
                        </td>
                        <td style="text-align: right;">
                            <img src="../../mgi/images/trash_delete.ico" style="cursor: pointer;" width="32" title="Eliminar Registro" onclick="DelectBicicleta('<?PHP echo $Dato['Datos'][$i]['id'];?>')"  />&nbsp;&nbsp;<img src="../../mgi/images/Pencil3_Edit.png" style="cursor: pointer;" width="32" title="Editar o Actualizar Registro" onclick="EditUpdateBicicleta('<?PHP echo $Dato['Datos'][$i]['id'];?>')"  />
                        </td>
                      </tr>
                      <tr>
                          <td >Marca</td>
                            <td >
                                <input type="text" id="Marca" name="Marca" value="<?PHP echo $Dato['Datos'][$i]['marca'];?>" style="text-align: center;" onkeypress="return val_texto(event)" />
                            </td>
                            <td >color</td>
                            <td >
                                <input type="text" id="Color" name="Color" value="<?PHP echo $Dato['Datos'][$i]['color'];?>" style="text-align: center;" onkeypress="return val_texto(event)" />
                            </td>
                          </tr>
                      <tr>
                      <tr>
                         <td colspan="2" >
                                <fieldset>
                                    <legend><strong>Tipos Bicicleta<span style="color:red;">(*)</span></strong></legend>
                                    <div class="TypeBici">
                                    <table>
                                    <?PHP 
                                    for($j=0;$j<count($Dato['TipoBicicleta']);$j++){
                                        $Check = '';
                                        if($Dato['TipoBicicleta'][$j]['TipoBicicletaId']==$Dato['Datos'][$i]['TipoBicicleta']){
                                            $Check = 'checked="checked"';
                                        }else{
                                            $Check = '';
                                        }
                                    ?>
                                    
                                        <tr>
                                            <td>
                                                <input type="radio" <?PHP echo $Check?> id="Bici_<?PHP echo $Dato['TipoBicicleta'][$j]['TipoBicicletaId']?>" name="BiciType" value="<?PHP echo $Dato['TipoBicicleta'][$j]['TipoBicicletaId']?>" onclick="ActivarDesactivar(this.value)" class="ClearRadio" />
                                            </td>
                                            <td>
                                               <?PHP echo $Dato['TipoBicicleta'][$j]['nombre']?>
                                            </td>
                                        </tr>
                                    <?PHP 
                                    }
                                    ?>
                                    </table>    
                                    </div>                     
                                </fieldset>
                            </td>
                            <td colspan="2" >
                                <fieldset>
                                    <legend>Observaciones</legend>
                                    <textarea id="Observacion" name="Observacion" onkeypress="return val_textoNumero(event)"><?PHP echo $Dato['Datos'][$i]['observaciones'];?></textarea>
                                </fieldset>
                            </td>
                          </tr>
                      <tr>
                      <tr>
                            <td id="TD_OtherLabel" style="visibility: collapse;" >Otor Cual </td>
                            <td id="TD_OtherBox" style="visibility: collapse;" >
                             <input type="text" id="Cual" name="Cual" value="<?PHP echo $Dato['Datos'][$i]['otra'];?>" style="text-align: center;" onkeypress="return val_texto(event)" />
                            </td>
                            <td ></td>
                            <td ></td>
                          </tr>
                      <tr>
                      <tr>
                        <td colspan="5" style="text-align: center; width: 100%; font-size: 9px;">
                            <div class="messages"></div>
                        </td>
                      </tr>
                        <td colspan="5">
                            <hr style="width: 90%;" />
                        </td>
                      </tr>
                  </table>
              </form>  
              <?PHP 
              }
              ?>
              <input type="button" class="Buton" id="Retorno" name="Retorno" onclick="VolverRetorno('<?PHP echo $Dato['idUser']?>','<?PHP echo $Dato['op']?>')" value="Volver" />
            </div>
       </fieldset>
	</body>
</html>

        <?PHP
   }
}//class
?>