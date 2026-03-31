<?php
/*
 * borrardo de codigo y formateo
 * Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Universidad el Bosque - Direccion de Tecnologia.
 * Modificado 21 de Septiembre de 2017.
 */
class Hoja_Vida {#Class

    public function Principal($id_Estudiante, $Ver) {#public function Principal()
        global $db, $userid, $rol_Usuario;

        if ($Ver == '1' || $Ver == 1) {

            $Entrada = 'display:inline';
        } else {
            $Entrada = 'display:none';
        }
        /*
         * Query y arreglo para estudiantes en situacion graduado
         * Vega Gabriel <vegagabriel@unbosque.edu.do>.
         * Universidad el Bosque - Direccion de Tecnologia.
         * Agregado 21 de Septiembre de 2017.
         */
        $querysituacionestudiantegeneral = 'SELECT codigosituacioncarreraestudiante ';
        $querysituacionestudiantegeneral .= 'FROM estudiante e ';
        $querysituacionestudiantegeneral .= 'INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral ';
        $querysituacionestudiantegeneral .= 'WHERE eg.idestudiantegeneral="' . $id_Estudiante . '" ';
        $selsituacionestudiantegeneral = $db->Execute($querysituacionestudiantegeneral);
        $totalRows_selsituacionestudiantegeneral = $selsituacionestudiantegeneral->RecordCount();
        $acum = '';
        while ($row_selsituacionestudiantegeneral = $selsituacionestudiantegeneral->FetchRow()) {
            $acum .= $row_selsituacionestudiantegeneral['codigosituacioncarreraestudiante'] . ',';
        }
        $tacum = substr($acum, 0, -1);
        $arreglo = array($tacum);
        //end
        ?>
        <script>
            $(function() {
            $("#tabs2").tabs();
            });</script>
        <div id="container" style="width:90%; margin-left:5%" align="center"><!--container-->
            <h1></h1>
            <br /><br />
            <div id="Cargar" style="width:100%;">        
                <fieldset style="border:#88AB0C solid 1px; width:auto">
                    <div align="justify" style="width:90%; margin-left:5%">
                        <br />
                        Para la Universidad El Bosque, en sus procesos de autoevaluación permanente, es de gran importancia conocer  las capacidades, habilidades y necesidades de sus estudiantes. Por lo anterior, le solicitamos diligenciar y/o actualizar el formulario que se presenta a continuación, con el fin de desarrollar estrategias y programas que permitan potencializar al máximo su formación integral (académica, personal, social, cultural).  
                        <br />
                        <br />
                    </div>       
                </fieldset>   
                <fieldset style="border:#88AB0C solid 1px"><!---->
                    <legend style="font-size:24px"></legend>   
                    <div id="Bienvenida" title="Apreciado Estudiante." style="width:auto;<?php echo $Entrada ?>" align="center">
                        <div style="background-color:#3E4729;border-bottom:7px solid #88AB0C;border-top-left-radius:2em;
                             border-bottom-right-radius:2em; width:98%;  margin-bottom:2%; margin-left:2%; margin-right:2%; margin-top:2%" align="right"><img src="http://www.uelbosque.edu.co/sites/default/themes/ueb/images/logotipo_ueb.png"   style="margin-left:3%; margin-right:3%" width="130" /></div><br />

                        <p align="justify" style=" margin-bottom:2%; margin-left:2%; margin-right:2%; margin-top:2%">Tu universidad quiere re-afirmar la información de tus datos personales. Te agradecemos tu colaboración, por favor llena la pestaña "Información Personal" con el fin de brindarte un mejor servicio.<br /><br />

                            Toda la información que consigne en esta Hoja de Vida, está protegida, es confidencial y no será compartida o suministrada a otras entidades o personas naturales o jurídicas sin la autorización previa.<br /><br />

                            Lamentamos los inconvenientes causados.<br /><br />Gracias.</p>
                    </div>   
                    <div id="tabs" >
                        <ul>  
                            <li><a href="#tabs-1" onclick="Prueba(1)">Información General</a></li><!-- onblur="Save_Tab1(<?php # echo $id_Estudiante ?>,'1')"-->
                            <li><a href="#tabs-2" onclick="Prueba(2)">Información Académica</a></li><!-- onblur="Save_Tab1(<?php # echo $id_Estudiante ?>,'2')"-->
                            <li style="display:none"><a href="#tabs-3" onclick="Prueba(3)">Información Adicional</a></li><!-- onblur="Save_Tab1(<?php # echo $id_Estudiante ?>,'3')"-->
                            <li><a href="#tabs-4" onclick="Prueba(4)">Información Personal</a></li><!-- onblur="Save_Tab1(<?php # echo $id_Estudiante ?>,'4')"-->

                        </ul> 
                        <div id="tabs-1"><input type="hidden" id="Tab_1" value="1"  />
                            <?php
                            /*
                             * If de rol de usuario si es 13 es editable (estudiante graduado) de lo contrario no
                             * Vega Gabriel <vegagabriel@unbosque.edu.do>.
                             * Universidad el Bosque - Direccion de Tecnologia.
                             * Agregado 21 de Septiembre de 2017.
                             */
                            if ($rol_Usuario == 13) {
                                $this->InformacionGeneral($id_Estudiante);
                            } else {
                                /*
                                 * Switch de arreglo para estudiantes en situacion graduado
                                 * Vega Gabriel <vegagabriel@unbosque.edu.do>.
                                 * Universidad el Bosque - Direccion de Tecnologia.
                                 * Agregado 21 de Septiembre de 2017.
                                 */
                                switch ($arreglo) {
                                    default:
                                        $this->InformacionGeneral($id_Estudiante);
                                        break;
                                    case in_array(400, $arreglo)://graduado
                                        $this->InformacionGeneral($id_Estudiante, 2);
                                        break;
                                }
                                //end
                            }
                            //else
                            ?>
                        </div>
                        <div id="tabs-2"><input type="hidden" id="Tab_2" value="2"  />
                            <?php $this->InformacionAcademica($id_Estudiante); ?>
                        </div>
                        <div id="tabs-3"><input type="hidden" id="Tab_3" value="3"  />
                            <?php $this->InformacionAdicional($id_Estudiante); ?>
                        </div>
                        <div id="tabs-4"><input type="hidden" id="Tab_4" value="4"  />
                            <?php $this->InformacionPersonal($id_Estudiante); ?>
                        </div>
                    </div>
                    <br>
                    <br> 
                </fieldset>  
                <br /><br />
                <br /><br />
                <div id="Botones" align="right" style="margin-right:5%;" >   
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" id="Siquiente" value="Siquiente." onclick="SaveGeneral()" class="submit" /><!---->
                </div>      
                <br /><br />  
            </div><!--Carga--> 
            <br /><br />  
            <div id="Cargar_Dos" style="width:100%;display:none;">
                <fieldset style="border:#88AB0C solid 1px"><!---->
                    <legend style="font-size:24px"></legend>
                    <fieldset style="border:#88AB0C solid 1px; width:95%">
                        <div align="justify" style="width:90%; margin-left:2%">
                            <br />
                            La Universidad desea brindar a sus estudiantes una formación integral, por esa razón requiere conocer algunos aspectos importantes que permitirán apoyar el ingreso a la Universidad, mejorar las experiencias en la vida universitaria y apoyar la preparación para la vida laboral.
                            <br />
                            <br />
                        </div>       
                    </fieldset>
                    <br />
                    <br />
                    <div id="tabs2" >
                        <ul>
                            <li><a href="#tabs-5">Actividad Laboral</a></li>
                            <li><a href="#tabs-10">Movilidad</a></li>   
                        </ul>
                        <div id="tabs-5" style="width:90%;">
                            <?php $this->ActividadLaboral($id_Estudiante); ?>
                        </div>
                        <div id="tabs-10">
                            <?php $this->Movilidad($id_Estudiante); ?>
                        </div>
                    </div>
                    <br />
                    <br />  
                </fieldset> 
                <br /><br />
                <div id="Botones" align="right" style="margin-right:5%">
                    <input type="button" id="Atras" value="Atras." onclick="Atras()" class="submit"  />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" id="SaveGenral"  value="Guardar." onclick="GuardarFinal();" class="first" />
                </div>      
                <br /><br />     
            </div>   
        </div><!--container--> 

        <?php
    }

#public function Principal()

    public function Add_Box($i, $id_Estudiante, $Name, $Dissable = '') {
        global $db, $userid, $rol_Usuario;

        if ($Dissable == 1) {
            $ClassDisable = 'disabled="disabled"';
        }


        $SQL_NumFamilia = 'SELECT 

										count(es.idestudiantefamilia) as Num
										
										
										FROM 
										
										estudiantefamilia es INNER JOIN 
										tipoestudiantefamilia tipo ON es.idtipoestudiantefamilia=tipo.idtipoestudiantefamilia INNER JOIN
										niveleducacion ni  ON es.idniveleducacion=ni.idniveleducacion
										
										
										WHERE
										
										es.idestudiantegeneral="' . $id_Estudiante . '"
										AND
										es.codigoestado=100';


        if ($Num_Famila = &$db->Execute($SQL_NumFamilia) === false) {
            echo 'Error en el SQl Num de Familiares............<br>' . $SQL_NumFamilia;
            die;
        }


        $r = $Num_Famila->fields['Num'];
        $Q = $r - 1;


        if ($i >= $Q) {

            $SQL_Parentesco = 'SELECT 
										
												idtipoestudiantefamilia as id,
												nombretipoestudiantefamilia as nombre
										
										FROM 
										
												tipoestudiantefamilia';


            if ($Parentesco = &$db->Execute($SQL_Parentesco) === false) {
                echo 'Error en el SQl Parentesco....<br>' . $SQL_Parentesco;
                die;
            }

            $SQL_Nivel = 'SELECT 
								
								idniveleducacion  as id,
								nombreniveleducacion as nombre
								
								FROM 
								
								niveleducacion';

            if ($NivelEduc = &$db->Execute($SQL_Nivel) === false) {
                echo 'Error en el SQL del Nivel Educativo......<br>' . $SQL_Nivel;
                die;
            }
            ?>

            <td align="center">
                <select id="Parentesco_<?php echo $i ?>" name="Parentesco_<?php echo $i ?>" class="CajasHoja" onchange="CambiaGeneral()" >
                    <?php
                    while (!$Parentesco->EOF) {
                        ?>
                        <option value="<?php echo $Parentesco->fields['id'] ?>"><?php echo $Parentesco->fields['nombre'] ?></option>
                        <?php
                        $Parentesco->MoveNext();
                    }
                    ?>
                </select>
            </td>    
            <td align="center"><input type="text" id="Nombre_<?php echo $i ?>" name="Nombre_<?php echo $i ?>" class="CajasHoja"  onclick="CambiaGeneral()"  /></td>
            <td align="center"><input type="text" id="Apellido_<?php echo $i ?>" name="Apellido_<?php echo $i ?>" class="CajasHoja"  onclick="CambiaGeneral()"  /></td>
            <td align="center"><input type="text" id="Ocupacion_<?php echo $i ?>" name="Ocupacion_<?php echo $i ?>" class="CajasHoja"  onclick="CambiaGeneral()"  /></td>
            <td align="center">
                <select id="NivelEdu_<?php echo $i ?>" name="NivelEdu_<?php echo $i ?>" class="CajasHoja" onchange="CambiaGeneral()" >
                    <option value="-1">Elige...</option>
                    <?php
                    while (!$NivelEduc->EOF) {
                        ?>
                        <option value="<?php echo $NivelEduc->fields['id'] ?>"><?php echo $NivelEduc->fields['nombre'] ?></option>
                        <?php
                        $NivelEduc->MoveNext();
                    }
                    ?>
                </select>
            </td>
            <td align="center"><input type="text" id="TelefonoFami_<?php echo $i ?>" name="TelefonoFami_<?php echo $i ?>" class="CajasHoja" onkeypress="return isNumberKey(event)"  onclick="CambiaGeneral()" /></td>
            <td align="center"><input type="text" id="CiudadFamilia_<?php echo $i ?>" name="CiudadFamilia_<?php echo $i ?>" class="CajasHoja" value="" autocomplete="off" onkeypress="AutoCityFamilia(<?php echo $i ?>)" onclick="FormatCityFamily(<?php echo $i ?>); CambiaGeneral()" /><input type="hidden" id="Ciudad_id_Familia_<?php echo $i ?>" /></td>
            <td align="center"><input type="hidden" id="id_RegistroFami_<?php echo $i ?>" name="id_RegistroFami_<?php echo $i ?>" value="" /><!--<img src="../../images/Close_Box_Red.png" width="22" align="middle" />--></td>

            <?php
        } else {

            $SQL_Familia = 'SELECT 

								es.idestudiantefamilia as id,
								es.nombresestudiantefamilia as nombre,
								es.apellidosestudiantefamilia as apellido,
								es.idtipoestudiantefamilia,
								es.celularestudiantefamilia as celular,
								es.direccionestudiantefamilia as dir,
								es.edadestudiantefamilia as edad,
								es.emailestudiantefamilia as email,
								es.idciudadestudiantefamilia as id_city,
								es.ocupacionestudiantefamilia as Ocupacion,
								es.profesionestudiantefamilia as Profecion,
								es.telefonoestudiantefamilia as tel_1,
								es.telefono2estudiantefamilia as tel_2,
								tipo.idtipoestudiantefamilia  as Id_parentesco,
								tipo.nombretipoestudiantefamilia as Parentesco,
								ni.idniveleducacion  as id_Niv,
								ni.nombreniveleducacion as Ni_Edu,
								es.idciudadestudiantefamilia,
								ciudad.idciudad,
								ciudad.nombreciudad
								
								
								
								FROM 
								
								estudiantefamilia es INNER JOIN 
								tipoestudiantefamilia tipo ON es.idtipoestudiantefamilia=tipo.idtipoestudiantefamilia INNER JOIN
								niveleducacion ni  ON es.idniveleducacion=ni.idniveleducacion INNER JOIN ciudad ON es.idciudadestudiantefamilia=ciudad.idciudad
								AND ciudad.codigoestado=100		

								
								
								WHERE
								
								es.idestudiantegeneral="' . $id_Estudiante . '"
								AND
								es.codigoestado=100';

            if ($Familia = &$db->Execute($SQL_Familia) === false) {
                echo 'Error en el SQl de la familia del estudiante..............<br>' . $SQL_Familia;
                die;
            }




            $j = 0;
            while (!$Familia->EOF) {

                ##############################################

                $SQL_Parentesco = 'SELECT 
										
												idtipoestudiantefamilia as id,
												nombretipoestudiantefamilia as nombre
										
										FROM 
										
												tipoestudiantefamilia';


                if ($Parentesco = &$db->Execute($SQL_Parentesco) === false) {
                    echo 'Error en el SQl Parentesco....<br>' . $SQL_Parentesco;
                    die;
                }

                ##############################################
                $SQL_Nivel = 'SELECT 
								
								idniveleducacion  as id,
								nombreniveleducacion as nombre
								
								FROM 
								
								niveleducacion';

                if ($NivelEduc = &$db->Execute($SQL_Nivel) === false) {
                    echo 'Error en el SQL del Nivel Educativo......<br>' . $SQL_Nivel;
                    die;
                }
                ##############################################	
                ?>
                <tr id="<?php echo $Name . $j ?>">
                    <td align="center">
                        <select id="Parentesco_<?php echo $j ?>" name="Parentesco_<?php echo $j ?>" class="CajasHoja" <?php echo $ClassDisable ?> onchange="CambiaGeneral()">
                            <option value="<?php echo $Familia->fields['Id_parentesco'] ?>"><?php echo $Familia->fields['Parentesco'] ?></option>
                            <?php
                            while (!$Parentesco->EOF) {
                                if ($Parentesco->fields['id'] != $Familia->fields['Id_parentesco']) {
                                    ?>
                                    <option value="<?php echo $Parentesco->fields['id'] ?>"><?php echo $Parentesco->fields['nombre'] ?></option>
                                    <?php
                                }
                                $Parentesco->MoveNext();
                            }
                            ?>
                        </select>    
                    </td>    
                    <td align="center"><input type="hidden" id="id_RegistroFami_<?php echo $j ?>" name="id_RegistroFami_<?php echo $j ?>" value="<?php echo $Familia->fields['id'] ?>"  /><input type="text" id="Nombre_<?php echo $j ?>" name="Nombre_<?php echo $j ?>" class="CajasHoja" <?php echo $ClassDisable ?> value="<?php echo $Familia->fields['nombre'] ?>"  onclick="CambiaGeneral()"/></td>
                    <td align="center"><input type="text" id="Apellido_<?php echo $j ?>" name="Apellido_<?php echo $j ?>" class="CajasHoja"  value="<?php echo $Familia->fields['apellido'] ?>" <?php echo $ClassDisable ?> onclick="CambiaGeneral()" /></td>
                    <td align="center"><input type="text" <?php echo $ClassDisable ?> id="Ocupacion_<?php echo $j ?>" name="Ocupacion_<?php echo $j ?>" class="CajasHoja" value="<?php echo $Familia->fields['Ocupacion'] ?>" onclick="CambiaGeneral()" /></td>
                    <td align="center">
                        <select id="NivelEdu_<?php echo $j ?>" name="NivelEdu_<?php echo $j ?>" <?php echo $ClassDisable ?> class="CajasHoja" onchange="CambiaGeneral()" >
                            <option value="<?php echo $Familia->fields['id_Niv'] ?>"><?php echo $Familia->fields['Ni_Edu'] ?></option>
                            <?php
                            while (!$NivelEduc->EOF) {
                                if ($Familia->fields['id_Niv'] != $NivelEduc->fields['id']) {
                                    ?>
                                    <option value="<?php echo $NivelEduc->fields['id'] ?>"><?php echo $NivelEduc->fields['nombre'] ?></option>
                                    <?php
                                }
                                $NivelEduc->MoveNext();
                            }
                            ?>
                        </select>
                    </td>
                    <td align="center"><input type="text" <?php echo $ClassDisable ?> id="TelefonoFami_<?php echo $j ?>" name="TelefonoFami_<?php echo $j ?>" class="CajasHoja" value="<?php echo $Familia->fields['tel_1'] ?>" onkeypress="return isNumberKey(event)" onclick="CambiaGeneral()" /></td>
                    <td align="center"><input type="text" <?php echo $ClassDisable ?> id="CiudadFamilia_<?php echo $j ?>" name="CiudadFamilia_<?php echo $j ?>" class="CajasHoja" value="<?php echo $Familia->fields['nombreciudad'] ?>" autocomplete="off" onkeypress="AutoCityFamilia(<?php echo $j ?>)" onclick="FormatCityFamily(<?php echo $j ?>); CambiaGeneral();" /><input type="hidden" id="Ciudad_id_Familia_<?php echo $j ?>" value="<?php echo $Familia->fields['idciudad'] ?>" /></td>
                    <td align="center"></td>
                </tr>
                <?php
                $j++;
                $Familia->MoveNext();
            }
        }
    }

    public function InformacionGeneral($id_Estudiante, $Dissable = '') {
        global $db, $userid, $rol_Usuario;

        if ($Dissable == 1) {
            $ClassDisable = 'disabled="disabled"';
        }
        /*
         * If de rol de usuario si es 13 habilita los input (estudiante graduado) de lo contrario no
         * Vega Gabriel <vegagabriel@unbosque.edu.do>.
         * Universidad el Bosque - Direccion de Tecnologia.
         * Agregado 21 de Septiembre de 2017.
         */
        if ($Dissable == 2) {
            $ClassDisable2 = 'disabled="disabled"';
        }
        //end
        $SQL_Info = 'SELECT 
		
							Estu.idestudiantegeneral,
							Estu.idtrato,
							Estu.idestadocivil,
							Estu.tipodocumento,
							Estu.numerodocumento,
							Estu.expedidodocumento,
							Estu.numerolibretamilitar,
							Estu.expedidalibretamilitar,
							Estu.numerodistritolibretamilitar,
							Estu.nombresestudiantegeneral  AS Nombres,
							Estu.apellidosestudiantegeneral AS Apellidos,
							date (Estu.fechanacimientoestudiantegeneral) AS Fecha_Naci,
							Estu.idciudadnacimiento,
							Estu.codigogenero,
							Estu.direccionresidenciaestudiantegeneral,
							Estu.direccioncortaresidenciaestudiantegeneral,
							Estu.ciudadresidenciaestudiantegeneral,
							Estu.telefonoresidenciaestudiantegeneral,
							Estu.telefono2estudiantegeneral,
							Estu.celularestudiantegeneral,
							Estu.direccioncorrespondenciaestudiantegeneral,
							Estu.direccioncortacorrespondenciaestudiantegeneral,
							Estu.ciudadcorrespondenciaestudiantegeneral,
							Estu.telefonocorrespondenciaestudiantegeneral,
							Estu.emailestudiantegeneral,
							Estu.email2estudiantegeneral,
							Estu.casoemergenciallamarestudiantegeneral,
							Estu.telefono1casoemergenciallamarestudiantegeneral,
							Estu.telefono2casoemergenciallamarestudiantegeneral,
							Estu.idtipoestudiantefamilia,
							Estu.eps_estudiante,
							Estu.tipoafiliacion,
							Estu.idciudadorigen,
                            Estu.esextranjeroestudiantegeneral,
                            Estu.FechaDocumento,
                            Estu.EstadoActualizaDato,
                            Estu.GrupoEtnicoId
					
					
					FROM 
					
							estudiantegeneral AS Estu 
					
					WHERE
					
							Estu.idestudiantegeneral="' . $id_Estudiante . '"';

        if ($DatosEstudiante = &$db->Execute($SQL_Info) === FALSE) {
            echo 'Error en el SQL de los Datos del estudiante..............<br>' . $SQL_Info;
            die;
        }

        $D_Estudiante = $DatosEstudiante->GetArray();

        $txtActualizaDato = $D_Estudiante[0]['EstadoActualizaDato'];
        if ($txtActualizaDato != 2) {
            $datoActualizado = "readonly='readonly'";
        } else {
            $datoActualizado = "";
        }
        ?>

        <fieldset style="height:100%; width:100%;  border-top-left-radius:2em;border-bottom-right-radius:2em;border:#88AB0C solid 1px" id="fielTab_1">
            <br />
            <input type="hidden" id="EstadoGeneral" name="EstadoGeneral" value="1" />
            <div align="justify" style="width:90%; margin-left:2%">
                La Universidad consciente de la necesidad de mantener permanente comunicación con sus estudiantes requiere contar con información de contacto actualizada. Dicha información nos permitirá darle a conocer los programas, proyectos y estrategias que la Universidad desarrolla para su beneficio académico y financiero.
            </div>
            <br />	
            <table width="98%" border="0" align="center" style="font-size:12px">
                <tr>
                    <td colspan="8">&nbsp;<input type="hidden" id="Estudiante_id"  value="<?php echo $id_Estudiante ?>" />&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="8"><legend>Informaci&oacute;n B&aacute;sica</legend></td>
                </tr>
                <tr>
                    <td colspan="8">&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td align="left"><strong>Nombre&nbsp;&nbsp;<span style="color:#F00; font-size:9px">*</span></strong></td>
                    <td align="center" colspan="2"><input type="text" id="Nombre" name="Nombre" class="CajasHoja" onclick="CambiaGeneral()" value="<?php echo $D_Estudiante[0]['Nombres']; ?>"  style="text-align:center; width:90%" <?php echo $ClassDisable;
        echo $ClassDisable2; ?> <?php echo $datoActualizado; ?> /></td>
                    <td align="center" colspan="2">&nbsp;&nbsp;</td>
                    <td align="left"><strong>Apellidos&nbsp;&nbsp;<span style="color:#F00; font-size:9px">*</span></strong></td>
                    <td colspan="2" align="center"><input type="text" id="Apellidos" name="Apellidos" class="CajasHoja" onclick="CambiaGeneral()"  style="text-align:center;width:90%"  value="<?php echo $D_Estudiante[0]['Apellidos'] ?>" <?php echo $ClassDisable;
        echo $ClassDisable2; ?> <?php echo $datoActualizado; ?> /></td>
                </tr>
                <tr>
                    <td colspan="8">&nbsp;&nbsp;</td>
                </tr>
                <?php
                $SQL_TipoDocumento = 'SELECT 

													tipodocumento AS id,
													nombredocumento AS nombre
										
										FROM 
										
													documento
										
										WHERE
										
													codigoestado=100
													AND
													tipodocumento<>0';

                if ($TipoDocumento = &$db->Execute($SQL_TipoDocumento) === false) {
                    echo 'Error en el SQL De tipo de Documento.....<br>' . $SQL_TipoDocumento;
                    die;
                }

                ################################################################################

                $SQL_TipoDocumento = 'SELECT 

													tipodocumento AS id,
													nombredocumento AS nombre
										
										FROM 
										
													documento
										
										WHERE
										
													codigoestado=100
													AND
													tipodocumento="' . $D_Estudiante[0]['tipodocumento'] . '"';

                if ($TipoDocumentoActual = &$db->Execute($SQL_TipoDocumento) === false) {
                    echo 'Error en el SQL De tipo de Documento.....<br>' . $SQL_TipoDocumento;
                    die;
                }
                ?>
                <tr>
                    <td align="left" ><strong>Tipo Documento&nbsp;&nbsp;<span style="color:#F00; font-size:9px">*</span></strong></td>
                    <td align="center" colspan="2">
                        <?php 
                         /*
                        * Mostrar texto para estudiantes en situacion graduado
                        * Vega Gabriel <vegagabriel@unbosque.edu.do>.
                        * Universidad el Bosque - Direccion de Tecnologia.
                        * Modificado 21 de Septiembre de 2017.
                        */
                       switch ($arreglo) {
                           case in_array(400, $arreglo)://graduado
                               ?>
                                <input type="hidden" id="TipoDocumento" name="TipoDocumento" class="CajasHoja" style="text-align:center;width:90%" value="<?php echo $TipoDocumentoActual->fields['id'] ?>" onkeypress="return isNumberKey(event)" readonly="readonly" <?php echo $ClassDisable2; ?> />
                                <input type="text" id="TipoDocumento1" name="TipoDocumento1" class="CajasHoja" style="text-align:center;width:90%" value="<?php echo $TipoDocumentoActual->fields['nombre'] ?>" onkeypress="return isNumberKey(event)" readonly="readonly" <?php echo $ClassDisable2; ?> />
                               <?php
                               break;
                           default:
                               ?>
                                <select id="TipoDocumento" name="TipoDocumento" class="CajasHoja" style="width:90%" disabled="disabled" <?php echo $ClassDisable2; ?> onchange="CambiaGeneral()" >
                                    <option value="<?php echo $TipoDocumentoActual->fields['id'] ?>"><?php echo $TipoDocumentoActual->fields['nombre'] ?></option>
                                    <?php
                                    while (!$TipoDocumento->EOF) {
                                        if ($TipoDocumento->fields['id'] != $TipoDocumentoActual->fields['id']) {
                                            ?>
                                            <option value="<?php echo $TipoDocumento->fields['id'] ?>"><?php echo $TipoDocumento->fields['nombre'] ?></option>
                                            <?php
                                        }
                                        $TipoDocumento->MoveNext();
                                    }
                                    ?>
                                </select>
                               <?php
                               break;
                           }
                        ?>
                    </td>
                    <td align="center" colspan="2" >&nbsp;&nbsp;</td>
                    <td align="left"><strong>N&deg;. Documento&nbsp;&nbsp;<span style="color:#F00; font-size:9px">*</span></strong></td>
                    <td colspan="2" align="center"><input type="text" id="Num_Documento" name="Num_Documento" class="CajasHoja" style="text-align:center;width:90%" value="<?php echo $D_Estudiante[0]['numerodocumento'] ?>" onkeypress="return isNumberKey(event)" readonly="readonly" <?php echo $ClassDisable2; ?> /></td>
                </tr>
                <tr>
                    <td colspan="8">&nbsp;&nbsp;</td>
                </tr>
                <?php
                $SQL_EstadoCivil = 'SELECT 

													idestadocivil as id,
													nombreestadocivil as nombre 
										
										FROM 
										
													estadocivil';

                if ($EstadoCivil = &$db->Execute($SQL_EstadoCivil) === false) {
                    echo 'Error en el SQL Estado Civil ........<br>' . $SQL_EstadoCivil;
                    die;
                }
                ##############################################################################################
                $SQL_EstadoCivil = 'SELECT 

													idestadocivil as id,
													nombreestadocivil as nombre 
										
										FROM 
										
													estadocivil
													
										WHERE
													
													idestadocivil="' . $D_Estudiante[0]['idestadocivil'] . '"';

                if ($EstadoCivilActual = &$db->Execute($SQL_EstadoCivil) === false) {
                    echo 'Error en el SQL Estado Civil ........<br>' . $SQL_EstadoCivil;
                    die;
                }


                ##############################################################################################				
                $SQL_Estrato = 'SELECT 

												idestrato as id,
												nombreestrato
									
									FROM 
									
												estrato
									
									WHERE
									
												codigoestado=100';

                if ($Estrato = &$db->Execute($SQL_Estrato) === false) {
                    echo 'Error en el SQL del Estrato .......<br>' . $SQL_Estrato;
                    die;
                }

                #############################################################################################	

                $SQL_Estrato = 'SELECT 

									es.idestratohistorico as id,
									es.idestrato,
									estrato.idestrato,
									estrato.nombreestrato
									
									FROM 
									
									estratohistorico AS es INNER JOIN estrato  ON es.idestrato=estrato.idestrato 
									
									WHERE
									
									es.idestudiantegeneral="' . $id_Estudiante . '"
									
									AND
									es.codigoestado=100
									AND 
									estrato.codigoestado=100';

                if ($EstratoActual = &$db->Execute($SQL_Estrato) === false) {
                    echo 'Error en el SQL del Estrato .......<br>' . $SQL_Estrato;
                    die;
                }

                #############################################################################################				

                $SQL_Genero = 'SELECT 

								codigogenero,
								nombregenero
								
								FROM genero';

                if ($Genero = &$db->Execute($SQL_Genero) === false) {
                    echo 'Error en el SQL Genero......<br>' . $SQL_Genero;
                    die;
                }

                #############################################################################################				

                $SQL_Genero = 'SELECT 

								codigogenero,
								nombregenero
								
								FROM genero
								
								WHERE 
								
								codigogenero="' . $D_Estudiante[0]['codigogenero'] . '"';

                if ($GeneroActual = &$db->Execute($SQL_Genero) === false) {
                    echo 'Error en el SQL Genero......<br>' . $SQL_Genero;
                    die;
                }
                ?>
                <tr>
                    <td align="left"><strong>Expedida en<span style="color:#F00; font-size:9px">*</span>&nbsp;&nbsp;</strong></td>
                    <td align="center" colspan="2" ><input type="text" id="Expedida_Doc" name="Expedida_Doc" class="CajasHoja" style="text-align:center;width:90%" value="<?php echo $D_Estudiante[0]['expedidodocumento'] ?>" <?php echo $ClassDisable;
        echo $ClassDisable2; ?> <?php echo $datoActualizado; ?> onclick="CambiaGeneral()"  /></td>
                    <td align="center" colspan="2" >&nbsp;&nbsp;</td>
                    <td align="left"><strong>Fecha de Expedici&oacute;n&nbsp;&nbsp;<span style="color:#F00; font-size:9px">*</span></strong></td>
                    <td colspan="2" align="center">
                        <input type="text" id="FechaDocu" name="FechaDocu" class="CajasHoja" size="12" style="text-align:center;width:90%" value="<?php echo $D_Estudiante[0]['FechaDocumento'] ?>"  maxlength="12" tabindex="7" placeholder="Fecha de Expedición" autocomplete="off" readonly="readonly" onchange="CambiaGeneral();" <?php echo $ClassDisable;
        echo $ClassDisable2; ?> />
                    </td>
                </tr> 
                <tr>
                    <td colspan="8">&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td align="left"><strong>Genero&nbsp;&nbsp;<span style="color:#F00; font-size:9px">*</span></strong></td>
                    <td colspan="2" align="center">
                        <select id="Genero" name="Genero" class="CajasHoja" style="width:90%" <?php echo $ClassDisable ?> onchange="CambiaGeneral()" >
                            <option value="<?php echo $GeneroActual->fields['codigogenero'] ?>" onclick="Genero()"><?php echo $GeneroActual->fields['nombregenero'] ?></option>
                            <?php
                            while (!$Genero->EOF) {
                                if ($Genero->fields['codigogenero'] != $GeneroActual->fields['codigogenero']) {
                                    ?>
                                    <option value="<?php echo $Genero->fields['codigogenero'] ?>" onclick="Genero()"><?php echo $Genero->fields['nombregenero'] ?></option>
                                    <?php
                                }
                                $Genero->MoveNext();
                            }
                            ?>
                        </select>
                    </td>
                    <td align="center" colspan="5" >&nbsp;&nbsp;</td>
                </tr>
                <?php
                if ($GeneroActual->fields['codigogenero'] == 100) {
                    $Style = ' style="visibility:collapse"';
                } else {
                    $Style = ' style="visibility:visiblr"';
                }
                ?>
                <tr id="DatosMilitares_4" <?php echo $Style ?>>
                    <td colspan="8">&nbsp;&nbsp;</td>
                </tr>
                <tr id="DatosMilitares" <?php echo $Style ?>>
                    <td align="left"><strong>Libreta Militar&nbsp;&nbsp;<span style="color:#F00; font-size:9px"></span></strong></td>
                    <td align="center" colspan="2"><input type="text" id="LibretaMilitar" name="LibretaMilitar" class="CajasHoja" style="text-align:center;width:90%" value="<?php echo $D_Estudiante[0]['numerolibretamilitar'] ?>"  onkeypress="return isNumberKey(event)" <?php echo $ClassDisable ?> onclick="CambiaGeneral()" /></td>
                    <td align="center" colspan="2">&nbsp;&nbsp;</td>
                    <td align="left"><strong>Distrito &nbsp;&nbsp;<span style="color:#F00; font-size:9px"></span></strong></td>
                    <td colspan="2" align="center"><input type="text" id="Distrito" name="Distrito" class="CajasHoja" style="text-align:center;width:90%" value="<?php echo $D_Estudiante[0]['numerodistritolibretamilitar'] ?>" <?php echo $ClassDisable ?> onclick="CambiaGeneral()" /></td>
                </tr> 
                <tr  id="DatosMilitares_2" <?php echo $Style ?>>
                    <td colspan="8">&nbsp;&nbsp;</td>
                </tr>
                <tr  id="DatosMilitares_3" <?php echo $Style ?>>
                    <td align="left"><strong>Expedida en</strong></td>
                    <td align="center" colspan="2"><input type="text" id="ExpedidaLibreta" name="ExpedidaLibreta" class="CajasHoja" style="text-align:center;width:90%" value="<?php echo $D_Estudiante[0]['expedidalibretamilitar'] ?>" <?php echo $ClassDisable ?> onclick="CambiaGeneral()" /></td>
                    <td align="center" colspan="2">&nbsp;&nbsp;</td>
                    <td align="left">&nbsp;&nbsp;</td>
                    <td colspan="2" align="center">&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="8">&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td align="left"><strong>Estado Civil&nbsp;&nbsp;<span style="color:#F00; font-size:9px">*</span></strong></td>
                    <td align="center" colspan="2">
                        <select id="EstadiCivil" name="EstadiCivil" class="CajasHoja" style="width:90%" <?php echo $ClassDisable ?> onchange="CambiaGeneral()" >
                            <option value="<?php echo $EstadoCivilActual->fields['id'] ?>"><?php echo $EstadoCivilActual->fields['nombre'] ?></option>
                            <?php
                            while (!$EstadoCivil->EOF) {
                                if ($EstadoCivil->fields['id'] != $EstadoCivilActual->fields['id']) {
                                    ?>
                                    <option value="<?php echo $EstadoCivil->fields['id'] ?>"><?php echo $EstadoCivil->fields['nombre'] ?></option>
                                    <?php
                                }
                                $EstadoCivil->MoveNext();
                            }
                            ?>
                        </select>
                    </td>
                    <td align="center" colspan="2">&nbsp;&nbsp;</td>
                    <td align="left"><strong>Estrato&nbsp;&nbsp;<span style="color:#F00; font-size:9px">*</span></strong></td>
                    <td colspan="2" align="center">
                        <select id="Estrato" name="Estrato" class="CajasHoja" style="width:90%" <?php echo $ClassDisable ?> onchange="CambiaGeneral()"  >
                            <option value="<?php echo $EstratoActual->fields['idestrato'] ?>"><?php echo $EstratoActual->fields['nombreestrato'] ?></option>
                            <?php
                            while (!$Estrato->EOF) {
                                if ($Estrato->fields['id'] != $EstratoActual->fields['idestrato']) {
                                    ?>
                                    <option value="<?php echo $Estrato->fields['id'] ?>"><?php echo $Estrato->fields['nombreestrato'] ?></option>
                                    <?php
                                }
                                $Estrato->MoveNext();
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="8">&nbsp;&nbsp;</td>
                </tr>

                <?php
                $SQL_CiudadNaci = 'SELECT 
									
											idciudad,
											nombreciudad
									
									FROM 
									
											ciudad
									
									WHERE
									
											codigoestado=100
											AND
											idciudad="' . $D_Estudiante[0]['idciudadnacimiento'] . '"';

                if ($CiudadNaci = &$db->Execute($SQL_CiudadNaci) === false) {
                    echo 'Error en SQLÑ De la ciudad de Nacimiento.....<br>' . $SQL_CiudadNaci;
                    die;
                }


                $Fecha = explode('-', $D_Estudiante[0]['Fecha_Naci']);

                $New_Fecha = $Fecha[0] . '/' . $Fecha[1] . '/' . $Fecha[2];

                $Edad = CalculaEdad($D_Estudiante[0]['Fecha_Naci']);
                ?>
                <tr>
                    <td align="left"><strong>Lugar Nacimiento&nbsp;&nbsp;</strong></td>
                    <td align="center" colspan="2"><input type="hidden" id="id_Ciudad" name="id_Ciudad" value="<?php echo $CiudadNaci->fields['idciudad'] ?>" /><input type="text" id="LugarNaci" name="LugarNaci" class="CajasHoja" style="text-align:center;width:90%" value="<?php echo $CiudadNaci->fields['nombreciudad'] ?>" onclick="Format(); CambiaGeneral();" autocomplete="off" onKeyPress="autocompletCiudad_Naci()" <?php echo $ClassDisable ?>  /></td>
                    <td align="center" colspan="2">&nbsp;&nbsp;</td>
                    <td align="left"><strong>Fecha Nacimiento &nbsp;&nbsp;<span style="color:#F00; font-size:9px">*</span></strong></td>
                    <td colspan="2" align="center">&nbsp;<input type="text" id="FechaNaci" name="FechaNaci" class="CajasHoja" size="12" style="text-align:center;width:90%" value="<?php echo $D_Estudiante[0]['Fecha_Naci'] ?>"  maxlength="12" tabindex="7" placeholder="Fecha de Nacimiento" autocomplete="off" readonly="readonly" onchange="EdaNew(); CambiaGeneral();" <?php echo $ClassDisable ?> /></td>
                </tr>
                <tr>
                    <td colspan="8">&nbsp;&nbsp;</td>
                </tr> 
                <?php
                $SQLCiudadResid = 'SELECT 
									
											idciudad,
											nombreciudad
									
									FROM 
									
											ciudad
									
									WHERE
									
											codigoestado=100
											AND
											idciudad="' . $D_Estudiante[0]['ciudadresidenciaestudiantegeneral'] . '"';

                if ($CiudadResident = &$db->Execute($SQLCiudadResid) === false) {
                    echo 'Error en SQLÑ De la ciudad de Nacimiento.....<br>' . $SQL_CiudadNaci;
                    die;
                }
                ?> 
                <tr>
                    <td align="left"><strong>Edad</strong>&nbsp;&nbsp;</td>
                    <td align="center" colspan="2"><input type="text" id="Edad" name="Edad" class="CajasHoja" style="text-align:center;width:90%" value="<?php echo $Edad ?>" readonly="readonly" /></td>
                    <td align="center" colspan="2">&nbsp;&nbsp;</td>
                    <td align="left"><strong>Dirección Residencia&nbsp;&nbsp;<span style="color:#F00; font-size:9px">*</span></strong></td>
                    <td colspan="2" align="center"><input type="text" id="Dir_recidente" name="Dir_recidente" class="CajasHoja"  style="text-align:center;width:90%" value="<?php echo $D_Estudiante[0]['direccionresidenciaestudiantegeneral'] ?>" <?php echo $ClassDisable ?> onclick="CambiaGeneral()" /></td>
                </tr> 
                <tr>
                    <td colspan="8">&nbsp;&nbsp;</td>
                </tr> 
                <tr>
                    <td align="left"><strong>Teléfono Residencia &nbsp;&nbsp;<span style="color:#F00; font-size:9px">*</span></strong></td>
                    <td align="center" colspan="2"><input type="text" id="Tel_Recidente" name="Tel_Recidente" class="CajasHoja"  style="text-align:center;width:90%" value="<?php echo $D_Estudiante[0]['telefonoresidenciaestudiantegeneral'] ?>" onkeypress="return isNumberKey(event)" <?php echo $ClassDisable ?> onclick="CambiaGeneral()" /></td>
                    <td align="center" colspan="2">&nbsp;&nbsp;</td>
                    <td align="left"><strong>Ciudad Residencia &nbsp;&nbsp;<span style="color:#F00; font-size:9px">*</span></strong></td>
                    <td colspan="2" align="center"><input type="hidden" id="id_CiudadResid" name="id_CiudadResid" value="<?php echo $CiudadResident->fields['idciudad'] ?>" /><input type="text" id="CiudadResid" name="CiudadResid" class="CajasHoja" style="text-align:center;width:90%" value="<?php echo $CiudadResident->fields['nombreciudad'] ?>" onclick="FormatResident(); CambiaGeneral();" autocomplete="off"  onkeypress="autocompletCiudadResid()"  <?php echo $ClassDisable ?> /></td>
                </tr>
                <tr>
                    <td colspan="8">&nbsp;&nbsp;</td>
                </tr>
                <?php
                $SQLCiudadOrigen = 'SELECT 
									
											idciudad,
											nombreciudad
									
									FROM 
									
											ciudad
									
									WHERE
									
											codigoestado=100
											AND
											idciudad="' . $D_Estudiante[0]['idciudadorigen'] . '"';

                if ($CiudadOrigen = &$db->Execute($SQLCiudadOrigen) === false) {
                    echo 'Error en SQLÑ De la ciudad de Origen.....<br>' . $SQLCiudadOrigen;
                    die;
                }

                if ($D_Estudiante[0]['esextranjeroestudiantegeneral'] == 0 || $D_Estudiante[0]['esextranjeroestudiantegeneral'] == '0') {

                    $No_Extranjero = 'checked="checked"';
                } else {

                    $ES_Extranjero = 'checked="checked"';
                }
                ?>
                <tr>
                    <td align="left"><strong>Ciudad de Origen &nbsp;&nbsp;<span style="color:#F00; font-size:9px">*</span></strong></td>
                    <td align="center" colspan="2"><input type="hidden" id="id_CiudadOrigen" name="id_CiudadOrigen" value="<?php echo $CiudadOrigen->fields['idciudad'] ?>" /><input type="text" id="CiudadOrigen" name="CiudadOrigen" class="CajasHoja" style="text-align:center;width:90%" value="<?php echo $CiudadOrigen->fields['nombreciudad'] ?>" onclick="FormatOrigen(); CambiaGeneral()"  autocomplete="off" onkeypress="autocompletCiudadOrigen()" <?php echo $ClassDisable ?> /></td>
                    <td align="center" colspan="2">&nbsp;&nbsp;</td>
                    <td align="left"><strong>Es Extranjero..?&nbsp;&nbsp;<span style="color:#F00; font-size:9px">*</span></strong></td>
                    <td colspan="2" align="center">No&nbsp;&nbsp;<input type="radio" id="No_Extranjero" name="Extranjero" <?php echo $No_Extranjero ?> <?php echo $ClassDisable ?> onclick="CambiaGeneral()" />&nbsp;&nbsp;Si&nbsp;&nbsp;<input type="radio" id="Si_Extranjero" name="Extranjero" <?php echo $ES_Extranjero ?>  <?php echo $ClassDisable ?> onclick="CambiaGeneral()" /></td>
                </tr>
                <tr>
                    <td colspan="8">&nbsp;&nbsp;</td>
                </tr> 
                <tr>
                    <td align="left"><strong>E-mail <div style="font-size:8px">U. Bosque.</div>&nbsp;&nbsp;</strong></td>
                    <td align="center" colspan="2"><input type="text" id="EmailBosque" name="EmailBosque" class="CajasHoja"  style="text-align:center;width:90%" value="<?php echo $D_Estudiante[0]['emailestudiantegeneral'] ?>" <?php echo $ClassDisable ?> onclick="CambiaGeneral()" /></td>
                    <td align="center" colspan="2">&nbsp;&nbsp;</td>
                    <td align="left"><strong>E-mail 2&nbsp;&nbsp;</strong></td>
                    <td colspan="2" align="center"><input type="text" id="Email_2" name="Email_2" class="CajasHoja"  style="text-align:center;width:90%" value="<?php echo $D_Estudiante[0]['email2estudiantegeneral'] ?>" <?php echo $ClassDisable ?> onclick="CambiaGeneral()" /></td>
                </tr> 
                <tr>
                    <td colspan="8">&nbsp;&nbsp;</td>
                </tr> 
        <?php
        $SQL_Parentesco = 'SELECT 
										
												idtipoestudiantefamilia,
												nombretipoestudiantefamilia
										
										FROM 
										
												tipoestudiantefamilia';


        if ($Parentesco = &$db->Execute($SQL_Parentesco) === false) {
            echo 'Error en el SQl Parentesco....<br>' . $SQL_Parentesco;
            die;
        }

        $SQL_ParentescoAtual = 'SELECT 
										
													idtipoestudiantefamilia,
													nombretipoestudiantefamilia
											
											FROM 
											
													tipoestudiantefamilia
													
											WHERE
											
													idtipoestudiantefamilia="' . $D_Estudiante[0]['idtipoestudiantefamilia'] . '"';


        if ($ParentescoActual = &$db->Execute($SQL_ParentescoAtual) === false) {
            echo 'Error en el SQl Parentesco....<br>' . $SQL_ParentescoAtual;
            die;
        }
        ?>
                <tr>
                    <td align="left"><strong>En caso de emergencia llamar a <span style="color:#F00; font-size:9px">*</span></strong></td>
                    <td align="center" colspan="2"><input type="text" id="Nom_Emergencia" name="Nom_Emergencia" class="CajasHoja" style="text-align:center;width:90%" value="<?php echo $D_Estudiante[0]['casoemergenciallamarestudiantegeneral'] ?>" <?php echo $ClassDisable ?>  onclick="CambiaGeneral()"/></td>
                    <td align="center" colspan="2">&nbsp;&nbsp;</td>
                    <td align="left"><strong>Parentesco&nbsp;&nbsp;</strong></td>
                    <td colspan="2" align="center">
                        <select id="Parentesco" name="Parentesco" class="CajasHoja" style=" width:90%" <?php echo $ClassDisable ?> onchange="CambiaGeneral()" >
                            <option value="<?php echo $ParentescoActual->fields['idtipoestudiantefamilia'] ?>"><?php echo $ParentescoActual->fields['nombretipoestudiantefamilia'] ?></option>
        <?php
        while (!$Parentesco->EOF) {
            if ($Parentesco->fields['idtipoestudiantefamilia'] != $ParentescoActual->fields['idtipoestudiantefamilia']) {
                ?>
                                    <option value="<?php echo $Parentesco->fields['idtipoestudiantefamilia'] ?>"><?php echo $Parentesco->fields['nombretipoestudiantefamilia'] ?></option>
                                    <?php
                                }
                                $Parentesco->MoveNext();
                            }
                            ?>
                        </select>
                    </td>
                </tr> 
                <tr>
                    <td colspan="8">&nbsp;&nbsp;</td>
                </tr> 
                <tr>
                    <td align="left"><strong>Tel&eacute;fono1 &nbsp;&nbsp;<span style="color:#F00; font-size:9px">*</span></strong></td>
                    <td align="center" colspan="2"><input type="text" id="Telefono1_Parent" name="Telefono1_Parent" class="CajasHoja" style="text-align:center;width:90%" value="<?php echo $D_Estudiante[0]['telefono1casoemergenciallamarestudiantegeneral'] ?>" onkeypress="return isNumberKey(event)" <?php echo $ClassDisable ?>  onclick="CambiaGeneral()" /></td>
                    <td align="center" colspan="2">&nbsp;&nbsp;</td>
                    <td align="left"><strong>Tel&eacute;fono2 &nbsp;&nbsp;<span style="color:#F00; font-size:9px">*</span></strong></td>
                    <td colspan="2" align="center"><input type="text" id="Telefono1_Parent2" name="Telefono1_Parent2" class="CajasHoja" style="text-align:center;width:90%" value="<?php echo $D_Estudiante[0]['telefono2casoemergenciallamarestudiantegeneral'] ?>" onkeypress="return isNumberKey(event)" <?php echo $ClassDisable ?>  onclick="CambiaGeneral()" /></td>
                </tr>  
                <tr>
                    <td colspan="8">&nbsp;&nbsp;</td>
                </tr> 
        <?php
        $Check_Cotizante = '';
        $Check_Beneficiario = '';

        if ($D_Estudiante[0]['tipoafiliacion'] == 0) {
            $Check_Cotizante = 'checked="checked"';
            $Check_Beneficiario = '';
        }
        if ($D_Estudiante[0]['tipoafiliacion'] == 1) {
            $Check_Cotizante = '';
            $Check_Beneficiario = 'checked="checked"';
        }
        ?>
                <tr>
                    <td align="left"><strong>EPS&nbsp;&nbsp;</strong></td>
                    <td align="center" colspan="2"><input type="text" id="Eps" name="Eps" class="CajasHoja" style="text-align:center;width:90%" value="<?php echo $D_Estudiante[0]['eps_estudiante']; ?>" <?php echo $ClassDisable ?>  onclick="CambiaGeneral()" /></td>
                    <td align="center" colspan="2">&nbsp;&nbsp;</td>
                    <td align="left"><strong>Beneficiario &nbsp;&nbsp;</strong><input type="radio" id="Benficiario" name="EpsTipo" style="text-align:center" <?php echo $Check_Beneficiario ?> <?php echo $ClassDisable ?>  onclick="CambiaGeneral()" /></td>
                    <td colspan="2" align="center"><strong>Cotizante&nbsp;&nbsp;</strong><input type="radio" id="Cotizante" name="EpsTipo" style="text-align:center" <?php echo $Check_Cotizante ?> <?php echo $ClassDisable ?>  onclick="CambiaGeneral()"  /></td>
                </tr>
                <tr>
                    <td colspan="8">&nbsp;&nbsp;</td>
                </tr>
        <?php
        $sqlGrupoEtnico = 'SELECT GrupoEtnicoId, NombreGrupoEtnico 
										FROM GrupoEtnico
										WHERE CodigoEstado = 100';

        if ($GrupoEtnico = &$db->Execute($sqlGrupoEtnico) === false) {
            echo 'Error en el SQl Grupo Étnico....<br>' . $sqlGrupoEtnico;
            die;
        }

        $sqlGrupoEtnicoActual = 'SELECT GrupoEtnicoId, NombreGrupoEtnico 
										FROM GrupoEtnico
										WHERE 
										GrupoEtnicoId = "' . $D_Estudiante[0]['GrupoEtnicoId'] . '"
										AND CodigoEstado = 100';

        if ($GrupoEtnicoActual = &$db->Execute($sqlGrupoEtnicoActual) === false) {
            echo 'Error en el SQl Grupo Étnico....<br>' . $sqlGrupoEtnicoActual;
            die;
        }


        $sqlTipoSanguineo = 'SELECT idtipogruposanguineo, nombretipogruposanguineo 
											FROM tipogruposanguineo
											WHERE codigoestado = 100
											AND idtipogruposanguineo != 1';

        if ($TipoSanguineo = &$db->Execute($sqlTipoSanguineo) === false) {
            echo 'Error en el SQl Tipo Sanguíneo....<br>' . $sqlTipoSanguineo;
            die;
        }



        $sqlTipoSanguineoActual = 'SELECT G.idtipogruposanguineo, T.nombretipogruposanguineo
												FROM gruposanguineoestudiante G
												INNER JOIN tipogruposanguineo T ON ( T.idtipogruposanguineo = G.idtipogruposanguineo )
												WHERE idestudiantegeneral = "' . $id_Estudiante . '"';

        if ($TipoSanguineoActual = &$db->Execute($sqlTipoSanguineoActual) === false) {
            echo 'Error en el SQl Grupo Étnico....<br>' . $sqlTipoSanguineoActual;
            die;
        }
        ?>

                <tr>
                    <td align="left" ><strong>Grupo Étnico&nbsp;&nbsp;<span style="color:#F00; font-size:9px">*</span></strong></td>
                    <td align="center" colspan="2">
                        <select id="GrupoEtnico" name="GrupoEtnico" class="CajasHoja" style="width:90%" onchange="CambiaGeneral()" >
                            <option value="<?php echo $GrupoEtnicoActual->fields['GrupoEtnicoId'] ?>"><?php echo $GrupoEtnicoActual->fields['NombreGrupoEtnico'] ?></option>
                <?php
                while (!$GrupoEtnico->EOF) {
                    if ($GrupoEtnico->fields['GrupoEtnicoId'] != $GrupoEtnicoActual->fields['GrupoEtnicoId']) {
                        ?>
                                    <option value="<?php echo $GrupoEtnico->fields['GrupoEtnicoId'] ?>"><?php echo $GrupoEtnico->fields['NombreGrupoEtnico'] ?></option>
                <?php
            }
            $GrupoEtnico->MoveNext();
        }
        ?>
                        </select>
                    </td>
                    <td align="center" colspan="2">&nbsp;&nbsp;</td>
                    <td align="left" ><strong>Tipo Sanguíneo&nbsp;&nbsp;<span style="color:#F00; font-size:9px">*</span></strong></td>
                    <td align="center" colspan="2">
                        <select id="TipoSanguineo" name="TipoSanguineo" class="CajasHoja" style="width:90%" onclick="CambiaGeneral()"  >
                            <option value="<?php echo $TipoSanguineoActual->fields['idtipogruposanguineo'] ?>"><?php echo $TipoSanguineoActual->fields['nombretipogruposanguineo'] ?></option>
                            <?php
                            while (!$TipoSanguineo->EOF) {
                                if ($TipoSanguineo->fields['idtipogruposanguineo'] != $TipoSanguineoActual->fields['idtipogruposanguineo']) {
                                    ?>
                                    <option value="<?php echo $TipoSanguineo->fields['idtipogruposanguineo'] ?>"><?php echo $TipoSanguineo->fields['nombretipogruposanguineo'] ?></option>
                <?php
            }
            $TipoSanguineo->MoveNext();
        }
        ?>
                        </select>
                    </td>
                </tr>    
                <?php
                /*
                 * If de rol de usuario si es != 13 debe mostrar el mensaje
                 * Vega Gabriel <vegagabriel@unbosque.edu.do>.
                 * Universidad el Bosque - Direccion de Tecnologia.
                 * Agregado 21 de Septiembre de 2017.
                 */
                if ($rol_Usuario != 13) {
                    /*
                     * Mostrar texto para estudiantes en situacion graduado
                     * Vega Gabriel <vegagabriel@unbosque.edu.do>.
                     * Universidad el Bosque - Direccion de Tecnologia.
                     * Modificado 21 de Septiembre de 2017.
                     */
                    switch ($arreglo) {
                        case in_array(400, $arreglo)://graduado
                            ?>
                            <tr>
                                <td height="26" align="center" colspan="8"><br>
                                    <font style="color:red; font-weight:bold;">
                                        LOS CAMPOS SOMBREADOS NO PUEDEN SER MODIFICADOS DEBIDO A LA SITUACI&Oacute;N DE
                                        GRADUADO DEL ESTUDIANTE EN ESTE U OTRO PROGRAMA ACADEMICO.
                                    </font>
                                </td>
                            </tr>
                            <?php
                            break;
                    }
                    //end
                }
                //end
                ?>
            </table>
            <br />
        </fieldset>
        <br />
        <fieldset style="height:100%; width:100%;  border-top-left-radius:2em;border-bottom-right-radius:2em;border:#88AB0C solid 1px ">
            <br />
            <div align="justify" style="width:90%; margin-left:2%">Por favor describa a continuación la conformación de su núcleo familiar. Si requiere incluir alguna casilla adicional, por favor haga click en el botón verde "Adicionar una celda nueva".</div>
            <br />
            <table width="98%" border="0" align="center" style="font-size:12px">
                <tr>
                    <td colspan="5">&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="5"><legend>Información Familiar</legend></td>
                </tr>
                <tr>
                    <td colspan="5">&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="5">
                        <table width="100%" align="center" border="0" bordercolor="#88AB0C">
                            <tr>
                                <td align="center" width="9%"><legend>Parentesco</legend></td>
                    <td align="center" width="16%"><legend>Nombre</legend></td>
                <td align="center" width="16%"><legend>Apellido</legend></td>
                <td align="center" width="15%"><legend>Ocupaci&oacute;n</legend></td>
                <td align="center" width="15%"><legend>Nivel educativo</legend></td>
                <td align="center" width="14%"><legend>Teléfono</legend></td>
                <td align="center" width="19%"><legend>Ciudad</legend></td>
                <td width="5%" align="center"><img src="../../images/add.png" title="Adicionar una Celda Nueva." onclick="AgregarFila()" width="30" /></td>
                </tr>
            </table>
        </td>
        </tr>
        <?php
        $SQL_NumFamilia = 'SELECT 

										count(es.idestudiantefamilia) as Num
										
										
										FROM 
										
										estudiantefamilia es INNER JOIN 
										tipoestudiantefamilia tipo ON es.idtipoestudiantefamilia=tipo.idtipoestudiantefamilia INNER JOIN
										niveleducacion ni  ON es.idniveleducacion=ni.idniveleducacion
										
										
										WHERE
										
										es.idestudiantegeneral="' . $id_Estudiante . '"
										AND
										es.codigoestado=100';


        if ($Num_Famila = &$db->Execute($SQL_NumFamilia) === false) {
            echo 'Error en el SQl Num de Familiares............<br>' . $SQL_NumFamilia;
            die;
        }



        if ($Num_Famila->fields['Num'] == 0 || $Num_Famila->fields['Num'] == '') {
            $r = 4;
        } else {
            $r = $Num_Famila->fields['Num'];
        }
        ?>
        <tr>
            <td colspan="5">
                <table id="d_tabla_add" width="100%" align="center" border="0">
                    <tr id="">
        <?php $this->Add_Box('', $id_Estudiante, 'trNewDetalle', $Dissable) ?>
                    </tr>
                </table>
            </td>
        <input type="hidden" id="numIndices" name="numIndices" value="<?php echo $r - 1 ?>" />
        </tr>
        <tr>
            <td colspan="5">&nbsp;<input type="hidden" id="Cadena_Familia" />&nbsp;</td>
        </tr>
        </table>
        </fieldset>
        <br />
        <fieldset style="height:100%; width:100%;  border-top-left-radius:2em;border-bottom-right-radius:2em;border:#88AB0C solid 1px ">
            <br />
            <div align="justify" style="width:90%; margin-left:2%">Por favor seleccione la(s) forma(s) de pago que utiliza para financiar su matrícula.</div>
            <br />
            <table width="98%" border="0" align="center" style="font-size:12px; color:#000">
                <tr>
                    <td colspan="2"><legend>Finanzas Estudiantiles</legend></td>
                <td colspan="3">&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="5">&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="5" align="center">
                        <table border="0" width="80%" align="center">
                            <tr>
                                <td>&nbsp;&nbsp;</td>
                                <td colspan="3">
                                    <table border="0" align="center" width="100%">
                                        <tr>
                                            <td>
                                                <fieldset style="border:#88AB0C solid 1px">
                                                    <legend>Selecione Recursos Finacieros.</legend>
                                                    <table width="100%" border="0" align="center"> 
                                                        <tr>
                                                            <td>&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div id="RecursosFinacieros">
        <?php $this->RecursosFinacieros($id_Estudiante, $Dissable) ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;<input type="hidden" id="CadenaRecursoFianciero" />&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </fieldset>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td>&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="5">&nbsp;&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </fieldset>
        <?php
    }

    public function InformacionAcademica($id_Estudiante, $Dissable = '') {
        global $db, $userid, $rol_Usuario;
        if ($Dissable == 1) {
            $ClassDisable = 'disabled="disabled"';
        }
        if ($rol_Usuario == 1) {
            $icfes_Style = 'style="visibility:collapse"';
        }
        ?>
        <br />
        <div align="justify" style="width:90%; margin-left:2%">
            Conocer información sobre su formación académica y aquellas actividades y trabajos realizados por usted en estas etapas de estudio permitirá motivar su participación en los diferentes escenarios que ofrece la Universidad y su programa académico.
        </div>
        <br />
        <input type="hidden" id="EstadoAcademico" name="EstadoAcademico" value="1" /> 
        <fieldset style="height:100%; width:100%;  border-top-left-radius:2em;border-bottom-right-radius:2em;border:#88AB0C solid 1px ">
            <table width="98%" border="0" align="center" style="font-size:12px">
                <tr>
                    <td colspan="7"><legend>Colegio</legend></td>
                </tr>
                <tr>
                    <td colspan="7">&nbsp;&nbsp;</td>
                </tr>
        <?php
        $SQL_Colegio = 'SELECT 

												estudio.idestudianteestudio as id_Cole,
												estudio.idniveleducacion,
												estudio.anogradoestudianteestudio,
												estudio.idinstitucioneducativa,
												estudio.codigotitulo,
												estudio.observacionestudianteestudio,
												estudio.ciudadinstitucioneducativa,
												estudio.colegiopertenececundinamarca,
												estudio.otrainstitucioneducativaestudianteestudio,
												nivel.codigomodalidadacademica,
												nivel.nombreniveleducacion,
												titulo.nombretitulo,
												inst.nombreinstitucioneducativa
									
									FROM 
									
												estudianteestudio AS estudio
												INNER JOIN niveleducacion AS nivel ON nivel.idniveleducacion=estudio.idniveleducacion
												INNER JOIN titulo ON titulo.codigotitulo=estudio.codigotitulo
												INNER JOIN institucioneducativa AS inst  ON inst.idinstitucioneducativa=estudio.idinstitucioneducativa 
									
									WHERE
									
												estudio.idestudiantegeneral="' . $id_Estudiante . '"
												AND
												estudio.idniveleducacion=2'; #Se dice ke es por nivel 2 ya ke es colegio secundaria.


        if ($Colegio_info = &$db->Execute($SQL_Colegio) === false) {
            echo 'Error en el SQl de lo Colegio....<br>' . $SQL_Colegio;
            die;
        }

        if ($Colegio_info->fields['idinstitucioneducativa'] == 1) {
            $Nombre_Colegio = $Colegio_info->fields['otrainstitucioneducativaestudianteestudio'];
            $CheckBox = 'checked="checked"';
        } else {
            $Nombre_Colegio = $Colegio_info->fields['nombreinstitucioneducativa'];
            $CheckBox = '';
        }

        $SQL_Nivel = 'SELECT  
									idniveleducacion,
									nombreniveleducacion
									FROM 
									niveleducacion 
									WHERE 
									idniveleducacion =2';

        if ($NivelSecundaria = &$db->Execute($SQL_Nivel) === false) {
            echo 'Error en el SQL De Nivel Secucndaria...........<br>' . $SQL_Nivel;
            die;
        }

        if ($Colegio_info->fields['colegiopertenececundinamarca'] == 'SI') {
            $ChecK_Si = 'checked="checked"';
            $ChecK_No = '';
        }
        if ($Colegio_info->fields['colegiopertenececundinamarca'] == 'NO') {
            $ChecK_Si = '';
            $ChecK_No = 'checked="checked"';
        }
        ?>
                <tr>
                    <td align="left"><strong>Nivel</strong></td>
                    <td><input type="text" id="Nivel_Secundaria" name="Nivel_Secundaria" class="CajasHoja" style="text-align:center" value="<?php echo $NivelSecundaria->fields['nombreniveleducacion'] ?>" readonly="readonly" /><input type="hidden" id="Id_nivelSecundaria" value="<?php echo $NivelSecundaria->fields['idniveleducacion'] ?>"  /></td>
                    <td align="left"><strong>Instituci&oacute;n</strong></td>
                    <td><input type="text" id="Institucion" name="Institucion" class="CajasHoja" autocomplete="off" style="text-align:center; width:90%" size="60" onclick="" onKeyPress="autocompletColegios()" value="<?php echo $Nombre_Colegio ?>"  readonly="readonly" /><input type="hidden" id="Id_Colegio" name="Id_Colegio" value="<?php echo $Colegio_info->fields['idinstitucioneducativa'] ?>"  />&nbsp;&nbsp;&nbsp;<input type="checkbox" id="Otro_Colegio" name="Otro_Colegio" title="Activar Si el Colegio No Esta en los Registros" onclick="OmitirEvento()"  <?php echo $CheckBox ?> disabled="disabled" /></td><!--FormatCole()-->
                    <td>&nbsp;&nbsp;</td>
                    <td align="left"><strong>Titulo</strong></td>
                    <td><input type="text" id="Titulo" name="Titulo" class="CajasHoja" style="text-align:center" value="<?php echo $Colegio_info->fields['nombretitulo'] ?>" readonly="readonly" /><input type="hidden" id="id_TituloColegio" name="id_TituloColegio" value="<?php echo $Colegio_info->fields['codigotitulo'] ?>" /></td>
                </tr>
                <tr>
                    <td colspan="7">&nbsp;<input type="hidden" id="id_ColegioSave" value="<?php echo $Colegio_info->fields['id_Cole'] ?>" />&nbsp;</td>
                </tr>
        <?php ?>
                <tr>
                    <td align="left"><strong>Ciudad</strong></td>
                    <td><input type="text" id="Ciudad_Cole" name="Ciudad_Cole" class="CajasHoja" readonly="readonly" autocomplete="off" style="text-align:center" onkeypress="AutocompletarCityCole()" value="<?php echo $Colegio_info->fields['ciudadinstitucioneducativa'] ?>"   /></td>
                    <td align="left" colspan="2"><strong>Colegio pertenece al Departamento de Cundinamarca y es público</strong></td>
                    <td><strong>Si</strong>&nbsp;&nbsp;<input type="radio" id="Si_Colegio" name="Colegio_Dep" class="" <?php echo $ChecK_Si ?> disabled="disabled"  />&nbsp;&nbsp;<strong>NO</strong>&nbsp;&nbsp;<input type="radio" id="No_Colegio" name="Colegio_Dep" class=""  <?php echo $ChecK_No ?> disabled="disabled"/></td>
                    <td align="left"><strong>A&ntilde;o</strong></td>
                    <td><input type="text" id="YearCole" name="YearCole" class="CajasHoja" style="text-align:center" value="<?php echo $Colegio_info->fields['anogradoestudianteestudio'] ?>" readonly="readonly" /></td>
                </tr>
                <tr>
                    <td colspan="7">&nbsp;&nbsp;</td>
                </tr> 
            </table>
        </fieldset>
        <br />
        <fieldset style="height:100%; width:100%;  border-top-left-radius:2em;border-bottom-right-radius:2em;border:#88AB0C solid 1px ">
            <table width="98%" border="0" align="center" style="font-size:12px">
                <tr>
                    <td colspan="7"><legend>Otros estudios</legend></td>
                </tr>
                <tr>
                    <td colspan="7">&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="7">&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="7">
                        <div id="Div_OtrosEstudios"><?php $this->OtrosEstudios($id_Estudiante) ?></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="7">&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2"><strong>¿Usted ha realizado algún otro tipo de estudios?</strong></td>
                    <td><strong>Si</strong>&nbsp;&nbsp;<input type="radio" id="Estudios_si" name="OtrosEstudios" onclick="VerOtrosEstudiosRealizados()" <?php echo $ClassDisable ?> onclick="CambiaAcademico()" />&nbsp;&nbsp;&nbsp;<strong>No</strong>&nbsp;&nbsp;<input type="radio" id="Estudios_no" name="OtrosEstudios" onclick="VerOtrosEstudiosRealizados()" <?php echo $ClassDisable ?> onclick="CambiaAcademico()" /></td>
                    <td colspan="4">&nbsp;&nbsp;</td>
                </tr>
                <tr id="Tr_OtrosEstudiosCajas_1" style="visibility:collapse">
                    <td colspan="7">&nbsp;&nbsp;</td>
                </tr>
        <?php
        $SQL_NivelEdu = 'SELECT 

											idniveleducacion  as id,
											nombreniveleducacion as  nombre
									
									FROM 
									
											niveleducacion 
									
									WHERE 
									
											idniveleducacion IN (3, 4, 6, 5) 
									
									ORDER BY nombreniveleducacion';

        if ($NivelEdu = &$db->Execute($SQL_NivelEdu) === false) {
            echo 'Error en el SQl De Nivel De eEducacion ............<br>' . $SQL_NivelEdu;
            die;
        }
        ?>
                <tr id="Tr_OtrosEstudiosCajas_2" style="visibility:collapse">
                    <td align="left"><strong>Nivel</strong></td>
                    <td>
                        <select id="Nivel_otros" name="Nivel_otros" class="CajasHoja" <?php echo $ClassDisable ?> onchange="CambiaAcademico()"  >
                            <option value="-1">Elige...</option>
                <?php
                while (!$NivelEdu->EOF) {
                    ?>
                                <option value="<?php echo $NivelEdu->fields['id'] ?>"><?php echo $NivelEdu->fields['nombre'] ?></option>
                    <?php
                    $NivelEdu->MoveNext();
                }
                ?>
                        </select>   
                    </td>
                    <td align="left"><strong>Instituci&oacute;n</strong></td>
                    <td><input type="text" id="Institucion_Otros_estu" name="Institucion_Otros_estu" class="CajasHoja" autocomplete="off" style="text-align:center; width:90%" size="60" onclick="Format_Uni()" onkeypress="AutocompletarUniverisidad()" <?php echo $ClassDisable ?> /><input  type="hidden" id="id_Universidad_Otros" name="id_Universidad_Otros" />&nbsp;&nbsp;&nbsp;<input type="checkbox" id="OtraUniv_Text" name="NomNoesta" title="Activar Si El Instituto o Univerisdad No Esta En Los Registros" <?php echo $ClassDisable ?> /></td>
                    <td align="left"><strong>Titulo</strong></td>
                    <td colspan="2"><input type="text" id="Titulo_otros" name="Titulo_otros" class="CajasHoja" style="text-align:center" autocomplete="off" onclick="Format_Titulo()" onkeypress="AutoCompletTitulo()" <?php echo $ClassDisable ?>  /><input type="hidden" id="Titulo_id" name="Titulo_id"  />&nbsp;&nbsp;&nbsp;<input type="checkbox" id="Titulo_No" name="Titulo_No" title="Activar Si El titulo No Esta En Los Registros" <?php echo $ClassDisable ?> /></td>
                </tr>
                <tr id="Tr_OtrosEstudiosCajas_3" style="visibility:collapse">
                    <td colspan="7">&nbsp;&nbsp;</td>
                </tr>
                <tr id="Tr_OtrosEstudiosCajas_4" style="visibility:collapse">
                    <td align="left"><strong>Ciudad</strong></td>
                    <td><input type="text" id="Ciudad_Otros" name="Ciudad_Otros" class="CajasHoja" autocomplete="off" style="text-align:center" readonly="readonly" onkeypress="AutocompletCytyUniv()"  /></td>
                    <td align="left"><strong>A&ntilde;o</strong></td>
                    <td><input type="text" id="Year_otros" name="Year_otros" class="CajasHoja" onkeypress="return isNumberKey(event)" /></td>
                    <td align="left" colspan="2">&nbsp;&nbsp;</td>
                    <td>&nbsp;&nbsp;</td>
                </tr>
                <tr id="Tr_OtrosEstudiosCajas_5" style="visibility:collapse">
                    <td colspan="7">&nbsp;&nbsp;</td>
                </tr>
                <tr id="Tr_OtrosEstudiosCajas_6" style="visibility:collapse">
                    <td colspan="6" align="right">&nbsp;&nbsp;</td>
                    <td align="center">&nbsp;&nbsp;<img src="../../images/Save_reg.png" width="22" align="middle" onclick="Save_OtroEstud(<?php echo $id_Estudiante ?>)" title="Guardar Datos De Otros Estudios Realizados..." />&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="7">&nbsp;&nbsp;</td>
                </tr>
            </table>
        </fieldset>
        <br />
        <fieldset style="height:100%; width:100%;  border-top-left-radius:2em;border-bottom-right-radius:2em;border:#88AB0C solid 1px ">
            <table width="98%" border="0" align="center" style="font-size:12px">
                <tr>
                    <td colspan="4">&nbsp;&nbsp;</td>
                </tr>
                <tr <?php echo $icfes_Style ?>>
                    <td colspan="4"><legend>RESULTADO ICFES</legend></td>
                </tr>
        <?php
        $SQL_ICFES = 'SELECT 
										a.nombreasignaturaestado,
										d.notadetalleresultadopruebaestado
								FROM 
										detalleresultadopruebaestado d,
										resultadopruebaestado r,
										asignaturaestado a
								
								WHERE 
										r.idestudiantegeneral ="' . $id_Estudiante . '"
										AND 
										a.idasignaturaestado = d.idasignaturaestado
										AND 
										r.idresultadopruebaestado = d.idresultadopruebaestado
										and 
										d.codigoestado like "1%"
							  order by 1';

        if ($Resultados_icfes = &$db->Execute($SQL_ICFES) === false) {
            echo 'Error en el SQL del icfes.....<br>' . $SQL_ICFES;
            die;
        }
        ?>
                <tr <?php echo $icfes_Style ?>>
                    <td colspan="4">&nbsp;&nbsp;</td>
                </tr>
                <tr <?php echo $icfes_Style ?>>
                    <td colspan="4">
                        <table border="0" width="100%" align="center">
                            <tr>
                                <td colspan="5">
                                    <table border="0" align="left" width="50%">
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><legend>Asignatura</legend></td>
                                <td>&nbsp;&nbsp;</td>
                                <td><legend>Resultado</legend></td>
                    <td>&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="5">&nbsp;&nbsp;</td>
                </tr>
        <?php
        $R_icfes = $Resultados_icfes->GetArraY();

        $Num = count($R_icfes);

        $l = $Num / 2;
        $l = round($l);

        for ($j = 0; $j < $l; $j++) {
            ########################################
            ?>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td><?php echo $R_icfes[$j]['nombreasignaturaestado'] ?></td>
                        <td>&nbsp;&nbsp;</td>
                        <td><?php echo $R_icfes[$j]['notadetalleresultadopruebaestado'] ?></td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="5">&nbsp;&nbsp;</td>
                    </tr>
                    <?php
                    ########################################	
                }
                ?>
            </table>
            <table border="0" align="right" width="50%">
                <tr>
                    <td>&nbsp;&nbsp;</td>
                    <td><legend>Asignatura</legend></td>
                <td>&nbsp;&nbsp;</td>
                <td><legend>Resultado</legend></td>
                <td>&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="5">&nbsp;&nbsp;</td>
                </tr>
                <?php
                for ($j = $l; $j < $Num; $j++) {
                    ########################################
                    ?>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td><?php echo $R_icfes[$j]['nombreasignaturaestado'] ?></td>
                        <td>&nbsp;&nbsp;</td>
                        <td><?php echo $R_icfes[$j]['notadetalleresultadopruebaestado'] ?></td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="5">&nbsp;&nbsp;</td>
                    </tr>
                    <?php
                    ########################################	
                }
                ?>
            </table> 	
        </td>
        </tr>
        </table>
        </td>
        </tr>
        <tr <?php echo $icfes_Style ?>>
            <td colspan="4">&nbsp;&nbsp;</td>
        </tr>
                <?php
                $SQL_MaxParticipa = 'SELECT 

										MAX(idestudianteparticipacionacademica) AS id
										
										FROM estudianteparticipacionacademica
										
										WHERE
										
										idestudiantegeneral="' . $id_Estudiante . '" AND codigoestado=100';

                if ($Max = &$db->Execute($SQL_MaxParticipa) === false) {
                    echo 'Error en el SQL del Maximo de participacion... <br>' . $SQL_MaxParticipa;
                    die;
                }

                $SQL_DetalleParticipa = 'SELECT 

												semilleroinvestigacion,
												reprecolegioactividades,
												participasemilleros,
												participacioncongresos,
												intercambio,
												ninguna,
												otra,
												cual
												
												FROM estudianteparticipacionacademica
												
												WHERE
												
												idestudiantegeneral="' . $id_Estudiante . '" 
												AND 
												codigoestado=100 
												AND 
												idestudianteparticipacionacademica="' . $Max->fields['id'] . '"';

                if ($DetallePraticipa = &$db->Execute($SQL_DetalleParticipa) === false) {
                    echo 'Error en el SQL del Detalle Praticipa Acdemicamente....<br>' . $SQL_DetalleParticipa;
                    die;
                }
                ?>
        <tr>
            <td  align="left" colspan="2"><strong>1.¿Ha participado en alguna de las actividades académicas que se mencionan a continuación? Por favor marque en cuál o cuáles ha participado &nbsp;&nbsp;<span style="color:#F00; font-size:9px">*</span></strong></td>
            <td >&nbsp;<input type="hidden" id="id_RegistroNewActividad"  />&nbsp;</td>
            <td >&nbsp;&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;&nbsp;</td>
        </tr>
        <tr id="Tr_ParticipacionAcademica">
            <td colspan="4">
                <fieldset style="border:#88AB0C solid 1px; width:100%">
                    <table border="0" align="center" width="100%">
                        <tr>
                            <td>
                                <table align="lefth" border="0" width="100%">
                                    <tr>
                                        <td colspan="5">&nbsp;&nbsp;</td>
                                    </tr>
        <?php
        $Check_Semillerio = '';
        if (!$DetallePraticipa->EOF) {
            if ($DetallePraticipa->fields['semilleroinvestigacion'] == 1) {
                $Check_Semillerio = '';
            }
            if ($DetallePraticipa->fields['semilleroinvestigacion'] == 0) {
                $Check_Semillerio = 'checked="checked"';
            }
        }
        ?>
                                    <tr>
                                        <td width="3%">&nbsp;&nbsp;</td>
                                        <td width="60%"><strong>*Semilleros de Investigación</strong></td>
                                        <td width="5%">&nbsp;&nbsp;</td>
                                        <td width="29%">&nbsp;&nbsp;<input type="checkbox" id="Semillero_inv" name="Op_Participacion" <?php echo $Check_Semillerio ?> <?php echo $ClassDisable ?> onclick="CambiaAcademico()" />&nbsp;&nbsp;</td>
                                        <td width="3%">&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">&nbsp;&nbsp;</td>
                                    </tr>
                                    <?php
                                    $Check_Colegio = '';
                                    if (!$DetallePraticipa->EOF) {
                                        if ($DetallePraticipa->fields['reprecolegioactividades'] == 1) {
                                            $Check_Colegio = '';
                                        }
                                        if ($DetallePraticipa->fields['reprecolegioactividades'] == 0) {
                                            $Check_Colegio = 'checked="checked"';
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td>&nbsp;&nbsp;</td>
                                        <td><strong>*Representación del Colegio en actividades académicas</strong></td>
                                        <td>&nbsp;&nbsp;</td>
                                        <td>&nbsp;&nbsp;<input type="checkbox" id="Repre_Colegio" name="Op_Participacion" <?php echo $Check_Colegio ?> <?php echo $ClassDisable ?> onclick="CambiaAcademico()" />&nbsp;&nbsp;</td>
                                        <td>&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">&nbsp;&nbsp;</td>
                                    </tr>
                                    <?php
                                    $Check_PartiSemillero = '';
                                    if (!$DetallePraticipa->EOF) {
                                        if ($DetallePraticipa->fields['participasemilleros'] == 1) {
                                            $Check_PartiSemillero = '';
                                        }
                                        if ($DetallePraticipa->fields['participasemilleros'] == 0) {
                                            $Check_PartiSemillero = 'checked="checked"';
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td>&nbsp;&nbsp;</td>
                                        <td><strong>*Participación en Seminarios</strong></td>
                                        <td>&nbsp;&nbsp;</td>
                                        <td>&nbsp;&nbsp;<input type="checkbox" id="Parti_Semillero" name="Op_Participacion" <?php echo $Check_PartiSemillero ?> <?php echo $ClassDisable ?> onclick="CambiaAcademico()" />&nbsp;&nbsp;</td>
                                        <td>&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">&nbsp;&nbsp;</td>
                                    </tr>
                                    <?php
                                    $Check_Otra = '';
                                    if (!$DetallePraticipa->EOF) {
                                        if ($DetallePraticipa->fields['otra'] == 1) {
                                            $Check_Otra = '';
                                        }
                                        if ($DetallePraticipa->fields['otra'] == 0) {
                                            $Check_Otra = 'checked="checked"';
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td>&nbsp;&nbsp;</td>
                                        <td><strong>*Otra</strong></td>
                                        <td>&nbsp;&nbsp;</td>
                                        <td>&nbsp;&nbsp;<input type="checkbox" id="Otra_Participacion" name="Op_Participacion" <?php echo $Check_Otra ?> <?php echo $ClassDisable ?> onclick="CambiaAcademico()" />&nbsp;&nbsp;</td>
                                        <td>&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">&nbsp;&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table align="right" border="0" width="100%">
                                    <tr>
                                        <td colspan="5">&nbsp;&nbsp;</td>
                                    </tr>
                                    <?php
                                    $Check_Congresos = '';
                                    if (!$DetallePraticipa->EOF) {
                                        if ($DetallePraticipa->fields['participacioncongresos'] == 1) {
                                            $Check_Congresos = '';
                                        }
                                        if ($DetallePraticipa->fields['participacioncongresos'] == 0) {
                                            $Check_Congresos = 'checked="checked"';
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td>&nbsp;&nbsp;</td>
                                        <td><strong>*Participación en Congresos</strong></td>
                                        <td>&nbsp;&nbsp;</td>
                                        <td>&nbsp;&nbsp;<input type="checkbox" id="Part_Congreso" name="Op_Participacion" <?php echo $Check_Congresos ?> <?php echo $ClassDisable ?> onclick="CambiaAcademico()" />&nbsp;&nbsp;</td>
                                        <td>&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">&nbsp;&nbsp;</td>
                                    </tr>
                                    <?php
                                    $Check_Intercambio = '';
                                    if (!$DetallePraticipa->EOF) {
                                        if ($DetallePraticipa->fields['intercambio'] == 1) {
                                            $Check_Intercambio = '';
                                        }
                                        if ($DetallePraticipa->fields['intercambio'] == 0) {
                                            $Check_Intercambio = 'checked="checked"';
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td>&nbsp;&nbsp;</td>
                                        <td><strong>*Intercambio</strong></td>
                                        <td>&nbsp;&nbsp;</td>
                                        <td>&nbsp;&nbsp;<input type="checkbox" id="Intercambio" name="Op_Participacion" <?php echo $Check_Intercambio ?> <?php echo $ClassDisable ?> onclick="CambiaAcademico()" />&nbsp;&nbsp;</td>
                                        <td>&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">&nbsp;&nbsp;</td>
                                    </tr>
                                    <?php
                                    $Check_Ninguna = '';
                                    if (!$DetallePraticipa->EOF) {
                                        if ($DetallePraticipa->fields['ninguna'] == 1) {
                                            $Check_Ninguna = '';
                                        }
                                        if ($DetallePraticipa->fields['ninguna'] == 0) {
                                            $Check_Ninguna = 'checked="checked"';
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td>&nbsp;&nbsp;</td>
                                        <td><strong>*Ninguna</strong></td>
                                        <td>&nbsp;&nbsp;</td>
                                        <td>&nbsp;&nbsp;<input type="checkbox" id="Ninguna" name="Op_Participacion"  <?php echo $Check_Ninguna ?>  <?php echo $ClassDisable ?> onclick="CambiaAcademico()"/>&nbsp;&nbsp;</td>
                                        <td>&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;</td>
                                        <td><strong>¿Cuál ?</strong></td>
                                        <td>&nbsp;&nbsp;</td>
                                        <td>&nbsp;&nbsp;<input type="text" id="Cual_Participacion" name="Cual_Participacion" class="CajasHoja" value="<?php echo $DetallePraticipa->fields['cual'] ?>" <?php echo $ClassDisable ?> />&nbsp;&nbsp;</td>
                                        <td>&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">&nbsp;&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;&nbsp;</td>
        </tr>
        <?php
        $SQL_MaxLogros = 'SELECT 
										
										MAX(idestudiantelogrosdestinciones) AS id
										
										FROM estudiantelogrosdestinciones
										
										
										WHERE
										
										idestudiantegeneral="' . $id_Estudiante . '" AND codigoestado=100';

        if ($Max_Logros = &$db->Execute($SQL_MaxLogros) === false) {
            echo 'Error en el SQL .....<br>' . $SQL_MaxLogros;
            die;
        }

        $SQL_DetalleLogros = 'SELECT 

												logrosdestinciones,
												gradomeritorio,
												mencionacademica,
												mencionextracurricular,
												becas,
												ninguna, 
												otra,
												cual
												
												
												FROM estudiantelogrosdestinciones
												
												
												WHERE
												
												idestudiantegeneral="' . $id_Estudiante . '" 
												AND 
												codigoestado=100 
												AND 
												idestudiantelogrosdestinciones="' . $Max_Logros->fields['id'] . '"';


        if ($Detalle_Logros = &$db->Execute($SQL_DetalleLogros) === false) {
            echo 'Error en el SQL de los logros...<br>' . $SQL_DetalleLogros;
            die;
        }
        ?>
        <tr>     
            <td align="left"><strong>2. ¿Ha obtenido algún logro o distinción académica? Seleccione el tipo de logro que ha obtenido. &nbsp;&nbsp;<span style="color:#F00; font-size:9px">*</span></strong></td>
            <td>&nbsp;<input type="hidden" id="id_registroLogros" />&nbsp;</td>
            <td>&nbsp;&nbsp;</td>
            <td>&nbsp;&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;&nbsp;</td>
        </tr>
        <tr id="Tr_LogrosDistincion">
            <td colspan="4">
                <fieldset style="border:#88AB0C solid 1px; width:100%">
                    <table border="0" align="center" width="100%">
                        <tr>
                            <td>
                                <table border="0" align="center" width="100%">
                                    <tr>
                                        <td colspan="5">&nbsp;&nbsp;</td>
                                    </tr>
        <?php
        $Check_GradoMeritorio = '';
        if (!$Detalle_Logros->EOF) {
            if ($Detalle_Logros->fields['gradomeritorio'] == 1) {
                $Check_GradoMeritorio = '';
            }
            if ($Detalle_Logros->fields['gradomeritorio'] == 0) {
                $Check_GradoMeritorio = 'checked="checked"';
            }
        }
        ?>
                                    <tr>
                                        <td width="3%">&nbsp;&nbsp;</td>
                                        <td width="58%"><strong>* Grado Meritorio</strong></td>
                                        <td width="5%">&nbsp;&nbsp;</td>
                                        <td width="31%">&nbsp;&nbsp;<input type="checkbox" id="GradoMeritorio" name="Op_Logros" class="CajasHoja"  <?php echo $Check_GradoMeritorio ?> <?php echo $ClassDisable ?> onclick="CambiaAcademico()" />&nbsp;&nbsp;</td>
                                        <td width="3%">&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">&nbsp;&nbsp;</td>
                                    </tr>
        <?php
        $Check_MencionesAcademica = '';
        if (!$Detalle_Logros->EOF) {
            if ($Detalle_Logros->fields['mencionacademica'] == 1) {
                $Check_MencionesAcademica = '';
            }
            if ($Detalle_Logros->fields['mencionacademica'] == 0) {
                $Check_MencionesAcademica = 'checked="checked"';
            }
        }
        ?>
                                    <tr>
                                        <td>&nbsp;&nbsp;</td>
                                        <td><strong>* Menciones Académicas</strong></td>
                                        <td>&nbsp;&nbsp;</td>
                                        <td>&nbsp;&nbsp;<input type="checkbox" id="MencionAcad" name="Op_Logros" class="CajasHoja" <?php echo $Check_MencionesAcademica ?>  <?php echo $ClassDisable ?> onclick="CambiaAcademico()"/>&nbsp;&nbsp;</td>
                                        <td>&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">&nbsp;&nbsp;</td>
                                    </tr>
        <?php
        $Check_MencionesExtracurriculares = '';
        if (!$Detalle_Logros->EOF) {
            if ($Detalle_Logros->fields['mencionextracurricular'] == 1) {
                $Check_MencionesExtracurriculares = '';
            }
            if ($Detalle_Logros->fields['mencionextracurricular'] == 0) {
                $Check_MencionesExtracurriculares = 'checked="checked"';
            }
        }
        ?>
                                    <tr>
                                        <td>&nbsp;&nbsp;</td>
                                        <td><strong>* Menciones de Actividades Extracurriculares</strong></td>
                                        <td>&nbsp;&nbsp;</td>
                                        <td>&nbsp;&nbsp;<input type="checkbox" id="mencionActv" name="Op_Logros" class="CajasHoja" <?php echo $Check_MencionesExtracurriculares ?>  <?php echo $ClassDisable ?> onclick="CambiaAcademico()"/>&nbsp;&nbsp;</td>
                                        <td>&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">&nbsp;&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table border="0" align="center" width="100%">
                                    <tr>
                                        <td colspan="5">&nbsp;&nbsp;</td>
                                    </tr>
                                    <?php
                                    $Check_Becas = '';
                                    if (!$Detalle_Logros->EOF) {
                                        if ($Detalle_Logros->fields['becas'] == 1) {
                                            $Check_Becas = '';
                                        }
                                        if ($Detalle_Logros->fields['becas'] == 0) {
                                            $Check_Becas = 'checked="checked"';
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td width="10%">&nbsp;&nbsp;</td>
                                        <td width="32%"><strong>* Becas</strong></td>
                                        <td width="16%">&nbsp;&nbsp;</td>
                                        <td width="40%">&nbsp;&nbsp;<input type="checkbox" id="Becas" name="Op_Logros" class="CajasHoja" <?php echo $Check_Becas ?> <?php echo $ClassDisable ?> onclick="CambiaAcademico()"/>&nbsp;&nbsp;</td>
                                        <td width="2%">&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">&nbsp;&nbsp;</td>
                                    </tr>
        <?php
        $Check_NingunaLogors = '';
        if (!$Detalle_Logros->EOF) {
            if ($Detalle_Logros->fields['ninguna'] == 1) {
                $Check_NingunaLogors = '';
            }
            if ($Detalle_Logros->fields['ninguna'] == 0) {
                $Check_NingunaLogors = 'checked="checked"';
            }
        }
        ?>
                                    <tr>
                                        <td>&nbsp;&nbsp;</td>
                                        <td><strong>* Ninguna</strong></td>
                                        <td>&nbsp;&nbsp;</td>
                                        <td>&nbsp;&nbsp;<input type="checkbox" id="Ninguna_Logro" name="Op_Logros" class="CajasHoja" <?php echo $Check_NingunaLogors ?> <?php echo $ClassDisable ?> onclick="CambiaAcademico()"/>&nbsp;&nbsp;</td>
                                        <td>&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">&nbsp;&nbsp;</td>
                                    </tr>
        <?php
        $Check_OtraLogors = '';
        if (!$Detalle_Logros->EOF) {
            if ($Detalle_Logros->fields['otra'] == 1) {
                $Check_OtraLogors = '';
            }
            if ($Detalle_Logros->fields['otra'] == 0) {
                $Check_OtraLogors = 'checked="checked"';
            }
        }
        ?>
                                    <tr>
                                        <td colspan="5">
                                            <table border="0" align="center" width="100%">
                                                <tr>
                                                    <td width="10%">&nbsp;&nbsp;</td>
                                                    <td width="46%"><strong>* Otra</strong></td>
                                                    <td width="6%">&nbsp;&nbsp;</td>
                                                    <td width="5%">&nbsp;&nbsp;<input type="checkbox" id="Otro_Logro" name="Op_Logros" class="CajasHoja" <?php echo $Check_OtraLogors ?> <?php echo $ClassDisable ?> onclick="CambiaAcademico()"/>&nbsp;&nbsp;</td>
                                                    <td width="6%"><strong>¿Cuál ?</strong></td>
                                                    <td width="22%">&nbsp;&nbsp;<input type="Text" id="Cual_Logro" name="Cual_Logro" class="CajasHoja" value="<?php echo $Detalle_Logros->fields['cual'] ?>" <?php echo $ClassDisable ?> />&nbsp;&nbsp;</td>
                                                    <td width="5%">&nbsp;&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">&nbsp;&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table> 
                </fieldset>
            </td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;&nbsp;</td>
        </tr>
        </table>
        </fieldset>
        <br />



        <fieldset style="height:100%; width:100%;  border-top-left-radius:2em;border-bottom-right-radius:2em;border:#88AB0C solid 1px ">
            <table width="98%" border="0" align="center" style="font-size:12px; color:#000"><!---->

                <tr>
                    <td colspan="6"><legend>Idiomas</legend></td>
                </tr>
                <tr>
                    <td colspan="6">&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;</td>
                    <td align="left"><strong>&nbsp;</strong></td>
                    <td align="center"><strong>B&aacute;sico</strong></td>
                    <td align="center"><strong>Intermedio</strong></td>
                    <td align="center"><strong>Avanzado</strong></td>
                    <td>&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="6">&nbsp;&nbsp;</td>
                </tr>
        <?php
        $SQL_idioma = 'SELECT
										b.idestudianteidioma as id,
										a.ididioma,
										a.nombreidioma  ,
										b.porcentajeescribeestudianteidioma as porcentaje
								FROM
										idioma a
										left JOIN estudianteidioma b ON  (a.ididioma=b.ididioma AND  b.idestudiantegeneral="' . $id_Estudiante . '" AND b.codigoestado=100) ';

        if ($idiomas = &$db->Execute($SQL_idioma) === false) {
            echo 'Error en el SQL del idioma.....<br>' . $SQL_idioma;
            die;
        }


        $i = 0;
        while (!$idiomas->EOF) {
            ####################################################################################
            if ($idiomas->fields['porcentaje'] == 20) {
                $Check_Basic = 'checked="checked"';
                $Check_Medio = '';
                $Check_Avand = '';
                $Guardado = 1;
            }
            if ($idiomas->fields['porcentaje'] == 60) {
                $Check_Basic = '';
                $Check_Medio = 'checked="checked"';
                $Check_Avand = '';
                $Guardado = 1;
            }
            if ($idiomas->fields['porcentaje'] == 90) {
                $Check_Basic = '';
                $Check_Medio = '';
                $Check_Avand = 'checked="checked"';
                $Guardado = 1;
            }
            if ($idiomas->fields['porcentaje'] == '' || $idiomas->fields['porcentaje'] == 'null') {
                $Check_Basic = '';
                $Check_Medio = '';
                $Check_Avand = '';
                $Guardado = 0;
            }
            ?>
                    <tr>
                        <td>&nbsp;<input type="hidden" id="id_Estudiante" name="id_Estudiante" value="<?php echo $id_Estudiante ?>" />&nbsp;</td>
                        <td align="left"><input type="hidden" id="Guardado_<?php echo $idiomas->fields['ididioma'] ?>" name="Guardado_<?php echo $idiomas->fields['ididioma'] ?>" value="<?php echo $Guardado ?>" <?php echo $ClassDisable ?> /><strong><?php echo $idiomas->fields['nombreidioma'] ?></strong><input type="hidden" id="Nombre_idioma_<?php echo $i ?>" value="<?php echo $idiomas->fields['nombreidioma'] ?>" /></td>
                        <td align="center"><input type="radio" id="B_<?php echo $idiomas->fields['nombreidioma'] ?>" name="idioma_<?php echo $idiomas->fields['ididioma'] ?>" value="20" <?php echo $Check_Basic ?>  onclick="Save_idioma(1, '<?php echo $i ?>', '<?php echo $idiomas->fields['ididioma'] ?>'); CambiaAcademico();"  <?php echo $ClassDisable ?> /><input type="hidden" id="id_Idioma_<?php echo $i ?>" value="<?php echo $idiomas->fields['ididioma'] ?>" /></td>
                        <td align="center"><input type="radio" id="I_<?php echo $idiomas->fields['nombreidioma'] ?>" name="idioma_<?php echo $idiomas->fields['ididioma'] ?>" value="60" <?php echo $Check_Medio ?>  onclick="Save_idioma(2, '<?php echo $i ?>', '<?php echo $idiomas->fields['ididioma'] ?>'); CambiaAcademico();" <?php echo $ClassDisable ?> /></td>
                        <td align="center"><input type="radio" id="A_<?php echo $idiomas->fields['nombreidioma'] ?>" name="idioma_<?php echo $idiomas->fields['ididioma'] ?>" value="90" <?php echo $Check_Avand ?>  onclick="Save_idioma(3, '<?php echo $i ?>', '<?php echo $idiomas->fields['ididioma'] ?>'); CambiaAcademico();" <?php echo $ClassDisable ?> /></td>
                        <td>&nbsp;<input type="hidden" id="id_registro_<?php echo $i ?>" name="id_registro_<?php echo $i ?>" value="<?php echo $idiomas->fields['id'] ?>" />&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="6">&nbsp;&nbsp;</td>
                    </tr>
                    <?php
                    ####################################################################################	
                    $i++;
                    $idiomas->MoveNext();
                }#while1			
                ?>
                <tr>
                    <td colspan="6">&nbsp;<input type="hidden" id="Index_Idioma" name="Index_Idioma" value="<?php echo $i ?>" />&nbsp;</td>
                </tr>
            </table>	
        </fieldset>
                <?php
            }

            public function InformacionAdicional($id_Estudiante, $Dissable = '') {
                global $db, $userid, $rol_Usuario;

                if ($Dissable == 1) {
                    $ClassDisable = 'disabled="disabled"';
                }
                ?>
        <fieldset style="height:100%; width:100%;  border-top-left-radius:2em;border-bottom-right-radius:2em;border:#88AB0C solid 1px ">
            <table width="98%" border="0" align="center" style="font-size:12px">
                <tr>
                    <td colspan="6"><legend>Proceso de Admisi&oacute;n</legend></td>
                </tr>
                <tr>
                    <td colspan="6">&nbsp;&nbsp;</td>
                </tr>
                <?php
                $SQL_OtraUiniversidad = 'SELECT 
											
													idestudianteotrauniversidad as id,
													presentadoestudianteotrauniversidad  as Otra,
													presentadoestudianteuniversidad  as Esta
											
											FROM 
											
													estudianteotrauniversidad
											
											WHERE
											
													codigoestado=100
													AND
													idestudiantegeneral="' . $id_Estudiante . '"';

                if ($Otra_universidad = &$db->Execute($SQL_OtraUiniversidad) === false) {
                    echo 'Error en el SQL Otra Universidad..........<br>' . $SQL_OtraUiniversidad;
                    die;
                }
                ?>
                <tr>
                    <td colspan="6">
                        <table width="100%" border="0" align="center" >
        <?php
        if ($Otra_universidad->fields['Otra'] == 'Si') {
            $checK_OtraU_Si = 'checked="checked"';
            $checK_OtraU_No = '';
            $DisalbleOtraU_Si = 'disabled="disabled"';
        } else {
            $checK_OtraU_Si = '';
            $checK_OtraU_No = 'checked="checked"';
            $DisalbleOtraU_NO = 'disabled="disabled"';
        }

        if ($Otra_universidad->fields['Esta']) {
            $Check_Esta_Si = 'checked="checked"';
            $Check_Esta_No = '';
            $DisablE_Esta_Si = 'disabled="disabled"';
        } else {
            $Check_Esta_Si = '';
            $Check_Esta_No = 'checked="checked"';
            $DisablE_Esta_No = 'disabled="disabled"';
        }
        ?>
                            <tr>
                                <td><strong>¿ Es la primera vez que se presenta a esta universidad ?<span style="color:#F00; font-size:9px">*</span></strong><input type="hidden" id="id_PrimeraVezU" name="id_PrimeraVezU" value="<?php echo $Otra_universidad->fields['id'] ?>" /></td>
                                <td><strong>Si</strong>&nbsp;&nbsp;<input type="radio" id="Si_univerisdad" name="Universida" <?php echo $Check_Esta_Si ?>   <?php echo $DisalbleOtraU_NO ?>  <?php echo $ClassDisable ?>/>&nbsp;&nbsp;&nbsp;<strong>No</strong>&nbsp;&nbsp;<input type="radio" id="No_Universidad" name="Universida" <?php echo $Check_Esta_No ?>  <?php echo $DisalbleOtraU_Si ?>  <?php echo $ClassDisable ?> /></td>
                                <td>&nbsp;&nbsp;</td>
                                <td><strong>¿ Se ha presentado a otras universidades ?<span style="color:#F00; font-size:9px">*</span></strong></td>
                                <td><strong>Si</strong>&nbsp;&nbsp;<input type="radio" id="Si_otras" name="otrasUniversida" <?php echo $checK_OtraU_Si ?> <?php echo $DisablE_Esta_No ?>  <?php echo $ClassDisable ?>/>&nbsp;&nbsp;&nbsp;<strong>No</strong>&nbsp;&nbsp;<input type="radio" id="No_otras" name="otrasUniversida" <?php echo $checK_OtraU_No ?> <?php echo $DisablE_Esta_Si ?> <?php echo $ClassDisable ?>/></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">&nbsp;<input type="hidden" id="id_Dato_OtraU" name="id_Dato_OtraU" value="<?php echo $universidadEstud->fields['id'] ?>" />&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="6">
                        <div id="Div_otrasUniversidades" style="width:100%" align="center" ><?php $this->OtrasUniversidades($id_Estudiante); ?></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">&nbsp;&nbsp;</td>
                </tr>
            </table>
        </fieldset>
        <br />
        <fieldset style="height:100%; width:100%;  border-top-left-radius:2em;border-bottom-right-radius:2em;border:#88AB0C solid 1px ">
            <table width="98%" border="0" align="center" style="font-size:12px; color:#000">
                <tr>
                    <td colspan="2"><legend>Medio de comunicación</legend></td>
                <td colspan="2">&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="4">&nbsp;&nbsp;</td>
                </tr>
        <?php
        $SQL_PadreComunicacion = 'SELECT 

													MedioPadre.codigomediocomunicacion as id, 
													MedioPadre.nombremediocomunicacion as nombre 
											
											FROM 
											
													mediocomunicacion AS MedioPadre
											
											WHERE
											
													MedioPadre.codigoestado=100
													AND
													MedioPadre.codigomediocomunicacionpadre=0
											
											ORDER BY MedioPadre.nombremediocomunicacion ASC';

        if ($PadreComuni = &$db->Execute($SQL_PadreComunicacion) === false) {
            echo 'Error en la Consulta SQL de Medio de Comunicacion Padre.........<br>' . $SQL_PadreComunicacion;
            die;
        }
        ?>
                <tr>
                    <td>&nbsp;&nbsp;</td>
                    <td colspan="2">
                        <table width="100%" border="0" align="center">
        <?php
        $P = 0;
        while (!$PadreComuni->EOF) {
            ?>
                                <tr>
                                    <td>&nbsp;&nbsp;</td>
                                    <td colspan="2"><legend><?php echo $PadreComuni->fields['nombre'] ?></legend></td>
                        <td></td>
                        <td>&nbsp;&nbsp;</td>
                        <td></td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="7">&nbsp;&nbsp;</td>
                    </tr>
                    <?php
                    $SQL_HijoComuncacion = 'SELECT 

																			MedioPadre.codigomediocomunicacion as id, 
																			MedioPadre.nombremediocomunicacion as nombre,
																			es.idestudiantemediocomunicacion as id_MedioEstud ,
																			es.observacionestudiantemediocomunicacion as Descrip
																			
																			FROM 
																			
																			mediocomunicacion AS MedioPadre LEFT JOIN estudiantemediocomunicacion es ON es.codigomediocomunicacion=MedioPadre.codigomediocomunicacion AND es.idestudiantegeneral="' . $id_Estudiante . '" AND es.codigoestadoestudiantemediocomunicacion=100
																			
																			WHERE 
																			
																			MedioPadre.codigoestado=100 
																			
																			AND 
																			MedioPadre.codigomediocomunicacionpadre="' . $PadreComuni->fields['id'] . '"
																			 
																			
																			ORDER BY MedioPadre.nombremediocomunicacion ASC ';

                    if ($HijoComunicacion = &$db->Execute($SQL_HijoComuncacion) === FALSE) {
                        echo 'Error en el SQL de los medios de Comuncacion Hijo.....<br>' . $SQL_HijoComuncacion;
                        die;
                    }
                    ?>
                    <tr>
                        <td colspan="2">&nbsp;&nbsp;</td>
                        <td colspan="4">
                            <table border="0" width="100%" align="center">
            <?php
            $H = 0;
            while (!$HijoComunicacion->EOF) {
                if ($HijoComunicacion->fields['id_MedioEstud']) {
                    $Check_Box_Medio = 'checked="checked"';
                } else {
                    $Check_Box_Medio = '';
                }
                ?>
                                    <tr>
                                        <td>&nbsp;&nbsp;</td>
                                        <td width="60%"><strong><?php echo $HijoComunicacion->fields['nombre'] ?></strong></td>
                                        <td>&nbsp;&nbsp;</td>
                                        <td><input type="checkbox" id="Medio_<?php echo $P ?>_<?php echo $H ?>" name="MediosComunicacion" <?php echo $Check_Box_Medio ?> value="<?php echo $HijoComunicacion->fields['id'] ?>" onclick="DeleteMedio(<?php echo $P ?>, '<?php echo $H ?>', '<?php echo $HijoComunicacion->fields['id'] ?>', '<?php echo $id_Estudiante ?>')" <?php echo $ClassDisable ?> /></td>
                                        <td>&nbsp;&nbsp;</td>
                                        <td><input type="text" id="Descrip_<?php echo $HijoComunicacion->fields['id'] ?>" name="Descrip_<?php echo $HijoComunicacion->fields['id'] ?>" class="CajasHoja" value="<?php echo $HijoComunicacion->fields['Descrip'] ?>" <?php echo $ClassDisable ?>  /></td>
                                        <td>&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">&nbsp;<input type="hidden" id="id_EstudioanteMedio_<?php echo $HijoComunicacion->fields['id'] ?>" value="<?php echo $HijoComunicacion->fields['id_MedioEstud'] ?>" />&nbsp;</td>
                                    </tr>
                        <?php
                        $H++;
                        $HijoComunicacion->MoveNext();
                    }
                    ?>
                            </table><input type="hidden" id="IndexHijo_<?php echo $P ?>" value="<?php echo $H ?>" />
                        </td>
                    </tr>
                    <?php
                    $P++;
                    $PadreComuni->MoveNext();
                }
                ?>
            </table>
        </td>
        <td>&nbsp;<input type="hidden" id="IndexPadre" value="<?php echo $P ?>" />&nbsp;<input type="hidden" id="Cadena_Medios"  /> </td>
        </tr>
        </table>
        </fieldset>
        <br />

                            <?php
                        }

                        public function InformacionPersonal($id_Estudiante, $Dissable = '') {
                            global $db, $userid, $rol_Usuario;

                            if ($Dissable == 1) {
                                $ClassDisable = 'disabled="disabled"';
                            }
                            ?>
        <fieldset style="border:#88AB0C solid 1px; width:auto">
            <legend></legend>
            <div align="justify" style=" width:90%; margin-left:5%; margin-right:5%; margin-bottom:2%; margin-top:2%;">
                Para la Universidad es importante conocer algunos aspectos referentes a su salud, hábitos, actividades, gustos y hobbies. Recuerde que esta información nos permitirá conocer sus caracterísiticas personales con el fin de desarrollar mejores programas de Bienestar Universitario. 
            </div>
            <br />
            <input type="hidden" id="EstadoPersonal" name="EstadoPersonal" value="1" />
                            <?php
                            $SQL_MaxCondicionSalud = 'SELECT 

									MAX(idestudiantecondicionsalud) AS id
									
									FROM estudiantecondicionsalud
									
									WHERE
									
									idestudiantegeneral="' . $id_Estudiante . '"
									AND
									codigoestado=100';

                            if ($Max_CondicionSalud = &$db->Execute($SQL_MaxCondicionSalud) === false) {
                                echo 'Error en el SQL Max Condicion SAlud.....<br>' . $SQL_MaxCondicionSalud;
                                die;
                            }


                            $SQL_DetalleSalud = 'SELECT 

											sufrealgunaenfermeda,
											enfermedadendocrina,
											desordenmental,
											enfermedadsistemacirculatorio,
											enfermedadsistemarespiratorio,
											enfermedadsistemalocomotor,
											malformacionescongenicas,
											otrasenfermedades,
											alergias,
											alergiascual,
											medicamentospermanentes,
											cualmedicamentos,
											trsatornoalimenticio,
											trastornosalimenticiostipos,
											trastornocual,
											discapasidad,
											condiciondiscapacidadfisica,
											condiciondiscapacidadsensorial,
											observaciondiscapacidad
									
									FROM 
									
											estudiantecondicionsalud
									
									WHERE
									
											idestudiantegeneral="' . $id_Estudiante . '"
											AND
											codigoestado=100
											AND
											idestudiantecondicionsalud="' . $Max_CondicionSalud->fields['id'] . '"';


                            if ($DetalleSalud = &$db->Execute($SQL_DetalleSalud) === false) {
                                echo 'Error en el SQL Del Detalle Condicion SAlud....<br>' . $SQL_DetalleSalud;
                                die;
                            }
                            ?>
            <fieldset style=" width:90%;  border-top-left-radius:2em;border-bottom-right-radius:2em;border:#88AB0C solid 1px ">
                <table width="98%" border="0" align="center" style="font-size:12px; color:#000" cellpadding="0" cellspacing="0">
                    <tr>
                        <td colspan="4">&nbsp;<input type="hidden" id="Tab" name="Tab" value="4" />&nbsp;<input type="hidden" id="Estudiante_id" value="<?php echo $id_Estudiante ?>" /></td>
                    </tr>
                    <tr>
                        <td colspan="4"><legend>Información referente a sus condiciones de salud</legend></td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;&nbsp;</td>
                    </tr>
            <?php
            if ($DetalleSalud->EOF) {
                $Ver_Enfermedades = 'visibility:collapse';
            } else {

                if ($DetalleSalud->fields['sufrealgunaenfermeda'] == 1) {
                    $Radio_Sufre_NO = 'checked="checked"';
                    $Ver_Enfermedades = 'visibility:collapse';
                }
                if ($DetalleSalud->fields['sufrealgunaenfermeda'] == 0) {
                    $Radio_Sufre_Si = 'checked="checked"';
                    $Ver_Enfermedades = 'visibility:visible';
                }
            }
            ?>
                    <tr>
                        <td colspan="2" align="left" ><strong>¿Sufre o ha sufrido alguna enfermedad ?&nbsp;&nbsp;<span style="color:#FF0000; font-size:10px" >*</span></strong></td>
                        <td width="55%" align="center"><strong>Si.</strong>&nbsp;&nbsp;<input type="radio" id="Enfermeda_Si" name="Enfermo" onclick="Ver_EnfermedadesUno(); Update_Registro(1); CambiaPersonal();"  <?php echo $Radio_Sufre_Si ?> <?php echo $ClassDisable ?> />&nbsp;&nbsp;<strong>No.</strong>&nbsp;&nbsp;<input type="radio" id="Enfermeda_No" name="Enfermo" onclick="Ver_EnfermedadesUno(); Update_Registro(1); CambiaPersonal();"  <?php echo $Radio_Sufre_NO ?> <?php echo $ClassDisable ?> /></td>
                        <td width="7%">&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;<input type="hidden" id="Open_Uno" name="Open_Uno" value="0" />&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div id="Pregunta_Uno" style="width:100%; <?php echo $Ver_Enfermedades ?>" align="center">
                                <table width="100%" align="center" border="0">
                                    <tr>
                                        <td>&nbsp;&nbsp;</td>
                                        <td align="left"><strong>*Enfermedades Endocrinas <span style=" font-size:10px">(ej: diabetes, hipo o hipertiroidismo)</span></strong></td>
                                        <td align="left"><strong>¿Cuál ?</strong>&nbsp;&nbsp;&nbsp;<input type="text" id="Enf_Endroquina" name="Enf_Endroquina" class="CajasHoja" value="<?php echo $DetalleSalud->fields['enfermedadendocrina'] ?>" <?php echo $ClassDisable ?> /></td>
                                        <td>&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;</td>
                                        <td align="left"><strong>*Desordenes Mentales</strong></td>
                                        <td align="left"><strong>¿Cuál ?</strong>&nbsp;&nbsp;&nbsp;<input type="text" id="DesordenMental" name="DesordenMental" class="CajasHoja" value="<?php echo $DetalleSalud->fields['desordenmental'] ?>" <?php echo $ClassDisable ?> /></td>
                                        <td>&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;</td>
                                        <td align="left"><strong>*Enfermedades del Sistema Circulatorio</strong></td>
                                        <td align="left"><strong>¿Cuál ?</strong>&nbsp;&nbsp;&nbsp;<input type="text" id="Enf_Circulatorio" name="Enf_Circulatorio" class="CajasHoja" value="<?php echo $DetalleSalud->fields['enfermedadsistemacirculatorio'] ?>" <?php echo $ClassDisable ?> /></td>
                                        <td>&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;</td>
                                        <td align="left"><strong>*Enfermedades del Sistema Respiratorio </strong></td>
                                        <td align="left"><strong>¿Cuál ?</strong>&nbsp;&nbsp;&nbsp;<input type="text" id="Enf_Respiratorio" name="Enf_Respiratorio" class="CajasHoja" value="<?php echo $DetalleSalud->fields['enfermedadsistemarespiratorio'] ?>" /></td>
                                        <td>&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;</td>
                                        <td align="left"><strong>*Enfermedades del Sistema Locomotor </strong></td>
                                        <td align="left"><strong>¿Cuál ?</strong>&nbsp;&nbsp;&nbsp;<input type="text" id="Enf_Locomotor" name="Enf_Locomotor" class="CajasHoja" value="<?php echo $DetalleSalud->fields['enfermedadsistemalocomotor'] ?>" <?php echo $ClassDisable ?> /></td>
                                        <td>&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;</td>
                                        <td align="left"><strong>*Enfemedades o Malformaciones Congénicas  </strong></td>
                                        <td align="left"><strong>¿Cuál ?</strong>&nbsp;&nbsp;&nbsp;<input type="text" id="Enf_Malformaciones" name="Enf_Malformaciones" class="CajasHoja" value="<?php echo $DetalleSalud->fields['malformacionescongenicas'] ?>" <?php echo $ClassDisable ?> /></td>
                                        <td>&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;</td>
                                        <td align="left"><strong>*Otras Enfermedades </strong></td>
                                        <td align="left"><strong>¿Cuál ?</strong>&nbsp;&nbsp;&nbsp;<input type="text" id="Enf_Otras" name="Enf_Otras" class="CajasHoja"  value="<?php echo $DetalleSalud->fields['otrasenfermedades'] ?>" <?php echo $ClassDisable ?>  /></td>
                                        <td>&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">&nbsp;&nbsp;</td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <table width="100%" align="center" border="0">
        <?php
        if ($DetalleSalud->EOF) {
            $Ver_Alergias = 'style="visibility:collapse"';
        } else {
            if ($DetalleSalud->fields['alergias'] == 1) {
                $Radio_Alergias_NO = 'checked="checked"';
                $Ver_Alergias = 'style="visibility:collapse"';
            }
            if ($DetalleSalud->fields['alergias'] == 0) {
                $Radio_Alergias_Si = 'checked="checked"';
                $Ver_Alergias = 'style="visibility:visible"';
            }
        }
        ?>
                                <tr>
                                    <td colspan="2" align="left"><strong>¿Sufre de alguna alergía ? &nbsp;&nbsp;<span style="color:#FF0000; font-size:10px" >*</span> </strong></td>
                                    <td align="center" width="31%">&nbsp;<strong>Si</strong>&nbsp;&nbsp;<input type="radio" id="Alegia_Si" name="Alergia" onclick="AlergiasCual(); Update_Registro(1); CambiaPersonal();"  <?php echo $ClassDisable ?> <?php echo $Radio_Alergias_Si ?> />&nbsp;&nbsp;&nbsp;<strong>No</strong>&nbsp;&nbsp;<input type="radio" id="Alergia_No" name="Alergia" onclick="AlergiasCual(); Update_Registro(1); CambiaPersonal();" <?php echo $Radio_Alergias_NO ?> <?php echo $ClassDisable ?>/></td>
                                    <td width="20%" align="center" id="Td_AlergiaCual" <?php echo $Ver_Alergias ?> ><strong>¿Cuál ?</strong>&nbsp;&nbsp;<input type="text" id="Cual_Alergia" name="Cual_Alergia" class="CajasHoja" value="<?php echo $DetalleSalud->fields['alergiascual'] ?>" <?php echo $ClassDisable ?> /></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <table width="100%" align="center" border="0">
        <?php
        if ($DetalleSalud->EOF) {
            $Ver_Medicamento = 'style="visibility:collapse"';
        } else {
            if ($DetalleSalud->fields['medicamentospermanentes'] == 1) {
                $Radio_Medicamento_NO = 'checked="checked"';
                $Ver_Medicamento = 'style="visibility:collapse"';
            }
            if ($DetalleSalud->fields['medicamentospermanentes'] == 0) {
                $Radio_Medicamento_Si = 'checked="checked"';
                $Ver_Medicamento = 'style="visibility:visible"';
            }
        }
        ?>
                                <tr>
                                    <td width="49%"><strong>¿Debe hacer uso de algún medicamento ? &nbsp;&nbsp;<span style="color:#FF0000; font-size:10px" >*</span></strong></td>
                                    <td width="31%" align="center">&nbsp;<strong>Si</strong>&nbsp;&nbsp;<input type="radio" id="UsoMed_Si" name="UsoMed" onclick="Ver_CualUsoMed(); Update_Registro(1); CambiaPersonal();" <?php echo $Radio_Medicamento_Si ?> <?php echo $ClassDisable ?> />&nbsp;&nbsp;&nbsp;<strong>No</strong>&nbsp;&nbsp;<input type="radio" id="UsoMed_No" name="UsoMed" onclick="Ver_CualUsoMed(); Update_Registro(1); CambiaPersonal();"  <?php echo $Radio_Medicamento_NO ?>  <?php echo $ClassDisable ?>/></td>
                                    <td width="20%" align="center" id="Td_UsoMedCual" <?php echo $Ver_Medicamento ?>><strong>¿Cuál ?</strong>&nbsp;&nbsp;<input type="text" id="Cual_UsoMed" name="Cual_UsoMed" class="CajasHoja" value="<?php echo $DetalleSalud->fields['medicamentospermanentes'] ?>" <?php echo $ClassDisable ?> /></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;&nbsp;</td>
                    </tr>
        <?php
        if ($DetalleSalud->EOF) {
            $Ver_Trastorno = 'display:none';
        } else {
            if ($DetalleSalud->fields['trsatornoalimenticio'] == 1) {
                $Radio_Trastorno_NO = 'checked="checked"';
                $Ver_Trastorno = 'display:none';
            }
            if ($DetalleSalud->fields['trsatornoalimenticio'] == 0) {
                $Radio_Trastorno_Si = 'checked="checked"';
                $Ver_Trastorno = 'display:inline"';
            }
        }
        ?>
                    <tr>
                        <td colspan="2" align="left" ><strong>¿Usted ha sufrido de algún tipo de trastorno en su alimentación ?  &nbsp;&nbsp;<span style="color:#FF0000; font-size:10px" >*</span></strong></td>
                        <td colspan="2" align="center">
                            <table align="center" width="100%">
                                <tr>
                                    <td width="19%">&nbsp;</td>
                                    <td width="50%" align="center">&nbsp;<strong>Si</strong>&nbsp;&nbsp;<input type="radio" id="Trastorno_Si" name="Trastorno" onclick="Ver_Trastorno(); CambiaPersonal();"  <?php echo $Radio_Trastorno_Si ?> <?php echo $ClassDisable ?> />&nbsp;&nbsp;<strong>No</strong>&nbsp;&nbsp;<input type="radio" id="Trastorno_No" name="Trastorno" onclick="Ver_Trastorno(); CambiaPersonal();" <?php echo $Radio_Trastorno_NO ?> <?php echo $ClassDisable ?> /></td>
                                    <td width="31%">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;<input type="hidden" id="Pregunta_4" name="Pregunta_4" value="0" />&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div id="Div_Pregunta4" style="width:100%;<?php echo $Ver_Trastorno ?>" align="center">
                                <table width="100%" align="center" border="0">
        <?php
        /*
          1=Anorexia
          2=Bulimia
          3=Obesidad
          4=Otra
         */
        if ($DetalleSalud->EOF) {
            #$Ver_Trastorno = 'display:none';
        } else {
            $Radio_Anorexia = '';
            $Radio_Bulimia = '';
            $Radio_Obesidad = '';
            $Radio_OtroTrastorno = '';

            if ($DetalleSalud->fields['trastornosalimenticiostipos'] == 1) {
                $Radio_Anorexia = 'checked="checked"';
            }
            if ($DetalleSalud->fields['trastornosalimenticiostipos'] == 2) {
                $Radio_Bulimia = 'checked="checked"';
            }
            if ($DetalleSalud->fields['trastornosalimenticiostipos'] == 3) {
                $Radio_Obesidad = 'checked="checked"';
            }
            if ($DetalleSalud->fields['trastornosalimenticiostipos'] == 4) {
                $Radio_OtroTrastorno = 'checked="checked"';
            }
        }
        ?>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td width="30%" align="left"><strong>* Anorexia </strong></td>
                                        <td>&nbsp;&nbsp;<input type="radio" id="Anorexia" name="TransAlimenticio" <?php echo $Radio_Anorexia ?> <?php echo $ClassDisable ?> onclick="CambiaPersonal()" /></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>    
                                        <td>&nbsp;</td>
                                        <td width="30%" align="left"><strong>* Bulimia</strong></td>
                                        <td>&nbsp;&nbsp;<input type="radio" id="Bulimia" name="TransAlimenticio" <?php echo $Radio_Bulimia ?> <?php echo $ClassDisable ?> onclick="CambiaPersonal()" /></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td width="30%" align="left"><strong>* Obesidad</strong></td>
                                        <td>&nbsp;&nbsp;<input type="radio" id="Obesidad" name="TransAlimenticio" <?php echo $Radio_Obesidad ?> <?php echo $ClassDisable ?> onclick="CambiaPersonal()" /></td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td width="30%" align="left"><strong>* Otra</strong></td>
                                        <td>&nbsp;&nbsp;<input type="radio" id="Otra_Trastorno" name="TransAlimenticio"  <?php echo $Radio_OtroTrastorno ?> <?php echo $ClassDisable ?>  onclick="CambiaPersonal()" /></td>
                                        <td align="center" width="50%"><strong>¿Cuál ?</strong>&nbsp;&nbsp;<input type="text" id="TrastornoText" name="TrastornoText" class="CajasHoja" value="<?php echo $DetalleSalud->fields['trastornocual'] ?>" <?php echo $ClassDisable ?> /></td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;&nbsp;</td>
                    </tr>
        <?php
        if ($DetalleSalud->EOF) {
            $Ver_Discapacidad = 'display:none';
        } else {
            if ($DetalleSalud->fields['discapasidad'] == 1) {
                $Radio_Discapacidad_NO = 'checked="checked"';
                $Ver_Discapacidad = 'display:none';
            }
            if ($DetalleSalud->fields['discapasidad'] == 0) {
                $Radio_Discapacidad_Si = 'checked="checked"';
                $Ver_Discapacidad = 'display:inline"';
            }
        }
        ?>
                    <tr>
                        <td colspan="2" ><strong>¿Presenta usted alguna condición de discapacidad ? &nbsp;&nbsp;<span style="color:#FF0000; font-size:10px" >*</span></strong></td>
                        <td colspan="2">
                            <table width="100%" align="center">
                                <tr>
                                    <td width="19%">&nbsp;</td>
                                    <td width="50%" align="center">&nbsp;<strong>Si</strong>&nbsp;&nbsp;<input type="radio" id="Si_discapacidad" name="Discapacidad" onclick="Ver_Discapaciada(); CambiaPersonal();"  <?php echo $Radio_Discapacidad_Si ?>  <?php echo $ClassDisable ?> />&nbsp;&nbsp;&nbsp;<strong>No</strong>&nbsp;&nbsp;<input type="radio" id="No_discapacidad" name="Discapacidad" onclick="Ver_Discapaciada(); CambiaPersonal();" <?php echo $Radio_Discapacidad_NO ?>  <?php echo $ClassDisable ?> /></td>
                                    <td width="31%">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;<input type="hidden" id="Pregunta5" name="Pregunta5" value="0" />&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="4" align="center">
                            <div id="Div_Pregunta5" style="width:100%; <?php echo $Ver_Discapacidad ?>" align="center">
                                <table width="100%" align="center" border="0">
                                    <tr>
                                        <td>&nbsp;&nbsp;</td>
                                        <td colspan="2">
                                            <table width="100%" align="center" border="0">
                                                <tr>
                                                    <td width="3%">&nbsp;</td>
                                                    <td colspan="2"><strong>Fisica:</strong></td>
                                                    <td width="8%">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">&nbsp;</td>
                                                </tr>
                    <?php
                    /*
                      Fisica
                      1= Dificultad para la locomoción
                      2=Anomalía o Ausencia en Estremidades Inferiores
                      3=Anomalía o Ausencia enEestremidades Superiores
                      4=Paralisis
                     */
                    if ($DetalleSalud->EOF) {
                        #$Ver_Discapacidad = 'display:none';
                    } else {
                        $Radio_Locomocion = '';
                        $Radio_Inferionres = '';
                        $Radio_Superiores = '';
                        $Radio_Paralisis = '';

                        if ($DetalleSalud->fields['condiciondiscapacidadfisica'] == 1) {
                            $Radio_Locomocion = 'checked="checked"';
                        }
                        if ($DetalleSalud->fields['condiciondiscapacidadfisica'] == 2) {
                            $Radio_Inferionres = 'checked="checked"';
                        }
                        if ($DetalleSalud->fields['condiciondiscapacidadfisica'] == 3) {
                            $Radio_Superiores = 'checked="checked"';
                        }
                        if ($DetalleSalud->fields['condiciondiscapacidadfisica'] == 4) {
                            $Radio_Paralisis = 'checked="checked"';
                        }
                    }
                    ?>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td colspan="2">
                                                        <table width="100%" align="center" border="0">
                                                            <tr>
                                                                <td width="3%">&nbsp;</td>
                                                                <td align="left" width="59%"><strong>* Dificultad para la locomoción</strong></td>
                                                                <td width="17%" align="center"><input type="radio" id="locomocion" name="CondicionDiscapacidad" <?php echo $Radio_Locomocion ?> <?php echo $ClassDisable ?> onclick="CambiaPersonal();" /></td>
                                                                <td width="21%">&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4">&nbsp;&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td align="left" width="59%"><strong>* Anomalía o Ausencia en Estremidades Inferiores</strong></td>
                                                                <td align="center"><input type="radio" id="inferior" name="CondicionDiscapacidad" <?php echo $Radio_Inferionres ?> <?php echo $ClassDisable ?> onclick="CambiaPersonal();" /></td>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4">&nbsp;&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td align="left" width="59%"><strong>*Anomalía o Ausencia en Estremidades Superiores</strong></td>
                                                                <td align="center"><input type="radio" id="Superior" name="CondicionDiscapacidad" <?php echo $Radio_Superiores ?>  <?php echo $ClassDisable ?> onclick="CambiaPersonal();"/></td>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4">&nbsp;&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td align="left" width="59%"><strong>*Par&aacute;lisis</strong></td>
                                                                <td align="center"><input type="radio" id="Paralisis" name="CondicionDiscapacidad" <?php echo $Radio_Paralisis ?>  <?php echo $ClassDisable ?> onclick="CambiaPersonal();"/></td>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;</td>
                                        <td colspan="2">
                                            <table width="100%" align="center" border="0">
                                                <tr>
                                                    <td width="3%">&nbsp;</td>
                                                    <td colspan="2"><strong>Sensorial:</strong></td>
                                                    <td width="8%">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">&nbsp;</td>
                                                </tr>
        <?php
        /*
          Sensorial
          1=Deficiencia Visual
          2=Deficiencia Auditiva
          3= Deficiencia en el Habla
         */
        if ($DetalleSalud->EOF) {
            #$Ver_Discapacidad = 'display:none';
        } else {
            $Radio_Visual = '';
            $Radio_Auditiva = '';
            $Radio_Habla = '';

            if ($DetalleSalud->fields['condiciondiscapacidadsensorial'] == 1) {
                $Radio_Visual = 'checked="checked"';
            }
            if ($DetalleSalud->fields['condiciondiscapacidadsensorial'] == 2) {
                $Radio_Auditiva = 'checked="checked"';
            }
            if ($DetalleSalud->fields['condiciondiscapacidadsensorial'] == 3) {
                $Radio_Habla = 'checked="checked"';
            }
        }
        ?>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td colspan="2">
                                                        <table width="100%" align="center" border="0">
                                                            <tr>
                                                                <td width="3%">&nbsp;</td>
                                                                <td align="left" width="59%"><strong>* Deficiencia Visual</strong></td>
                                                                <td width="17%" align="center"><input type="radio" id="Visual" name="Sensorial" <?php echo $Radio_Visual ?> <?php echo $ClassDisable ?> onclick="CambiaPersonal();"/></td>
                                                                <td width="21%">&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4">&nbsp;&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td align="left" width="59%"><strong>* Deficiencia Auditiva</strong></td>
                                                                <td align="center"><input type="radio" id="Auditiva" name="Sensorial"  <?php echo $Radio_Auditiva ?>  <?php echo $ClassDisable ?> onclick="CambiaPersonal();"/></td>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4">&nbsp;&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <td align="left" width="59%"><strong>* Deficiencia en el Habla</strong></td>
                                                                <td align="center"><input type="radio" id="Habla" name="Sensorial"  <?php echo $Radio_Habla ?>  <?php echo $ClassDisable ?> onclick="CambiaPersonal();"/></td>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td width="3%">&nbsp;</td>
                                                    <td colspan="2"><strong>Observaciones.</strong></td>
                                                    <td width="8%">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;</td>
                                                    <td colspan="2" align="center">
                                                        <textarea name="ObservacionCondicionDiscapacidad" cols="50" rows="10" class="CajasHoja" id="ObservacionCondicionDiscapacidad" placeholder="Por Ejemplo :requiere cuidador, perro lazarillo, otros" <?php echo $ClassDisable ?>  ><?php echo $DetalleSalud->fields['observaciondiscapacidad'] ?></textarea>
                                                    </td>
                                                    <td>&nbsp;&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>&nbsp;&nbsp;</td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;<input type="hidden" id="id_SaveCondicionSalud" />&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="4" ><strong>Indique por favor cuáles de las siguientes vacunas se ha aplicado: &nbsp;&nbsp;<span style="color:#FF0000; font-size:10px" >*</span></strong></td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;<input type="hidden" id="Pregunta6" name="Pregunta6" value="0" />&nbsp;</td>
                    </tr>
        <?php
        $SQL_MaxVacunas = 'SELECT 
										
										MAX(idestudiantevacunas) AS id

										FROM 
										
										estudiantevacunas
										
										WHERE
										
										idestudiantegeneral="' . $id_Estudiante . '"
										AND
										codigoestado=100';

        if ($MaxVacunas = &$db->Execute($SQL_MaxVacunas) === false) {
            echo 'Error en el SQL Vacunas .....<br>' . $SQL_MaxVacunas;
            die;
        }

        $SQL_MaxHora = 'SELECT 
										
										entrydate AS Fecha

										FROM 
										
										estudiantevacunas
										
										WHERE
										
										idestudiantegeneral="' . $id_Estudiante . '"
										AND
										codigoestado=100
										AND
										idestudiantevacunas="' . $MaxVacunas->fields['id'] . '"';

        if ($HoraVacunas = &$db->Execute($SQL_MaxHora) === false) {
            echo 'Error en el SQL Vacunas .....<br>' . $SQL_MaxHora;
            die;
        }
        ?>
                    <tr>
                        <td colspan="4">
                            <div id="Div_Pregunta6" style="width:100%" align="center">
                                <table width="100%" align="center" border="0">
                    <?php
                    /*
                      vacunas

                      1=Sarampión
                      2=Rubeola
                      3=Tetano
                      4=Hepatitis B -> re4laciona con dosis
                      5=Virus del Papiloma Humano VPH->relaciona con dosis
                     */

                    $Check_Sarampion = '';
                    $Check_Rubeola = '';
                    $Check_Tetano = '';
                    $Check_Hepatitis = '';
                    $Check_VPH = '';
                    $Dosis_Hep_Uno = '';
                    $Dosis_Hep_Dos = '';
                    $Dosis_Hep_Tres = '';
                    $Dosis_Vph_Uno = '';
                    $Dosis_Vph_Dos = '';
                    $Dosis_Vph_Tres = '';
                    $Ver_Hepatitis = 'style="visibility:collapse"';
                    $Ver_VPH = 'style="visibility:collapse"';


                    $SQL_DetalleVAcunas = 'SELECT 

												tipovacunas,
												dosisvacunas
												
												FROM 
												
												estudiantevacunas
												
												WHERE
												
												idestudiantegeneral="' . $id_Estudiante . '"
												AND
												codigoestado=100
												AND
												entrydate="' . $HoraVacunas->fields['Fecha'] . '"
												AND
												tipovacunas=1';

                    if ($Detalle_Sarampion = &$db->Execute($SQL_DetalleVAcunas) === false) {
                        echo 'Error en el SQL de la s Vacuans...<br>' . $SQL_DetalleVAcunas;
                        die;
                    }
                    if (!$Detalle_Sarampion->EOF) {
                        if ($Detalle_Sarampion->fields['tipovacunas'] == 1) {
                            $Check_Sarampion = 'checked="checked"';
                        }
                    }
                    ###################################################

                    $SQL_DetalleVAcunas = 'SELECT 

															tipovacunas,
															dosisvacunas
															
															FROM 
															
															estudiantevacunas
															
															WHERE
															
															idestudiantegeneral="' . $id_Estudiante . '"
															AND
															codigoestado=100
															AND
															entrydate="' . $HoraVacunas->fields['Fecha'] . '"
															AND
															tipovacunas=2';

                    if ($Detalle_Rubeola = &$db->Execute($SQL_DetalleVAcunas) === false) {
                        echo 'Error en el SQL de la s Vacuans...<br>' . $SQL_DetalleVAcunas;
                        die;
                    }

                    if (!$Detalle_Rubeola->EOF) {

                        if ($Detalle_Rubeola->fields['tipovacunas'] == 2) {
                            $Check_Rubeola = 'checked="checked"';
                        }
                    }
                    ######################################

                    $SQL_DetalleVAcunas = 'SELECT 

															tipovacunas,
															dosisvacunas
															
															FROM 
															
															estudiantevacunas
															
															WHERE
															
															idestudiantegeneral="' . $id_Estudiante . '"
															AND
															codigoestado=100
															AND
															entrydate="' . $HoraVacunas->fields['Fecha'] . '"
															AND
															tipovacunas=3';

                    if ($Detalle_Tetano = &$db->Execute($SQL_DetalleVAcunas) === false) {
                        echo 'Error en el SQL de la s Vacuans...<br>' . $SQL_DetalleVAcunas;
                        die;
                    }

                    if (!$Detalle_Tetano->EOF) {

                        if ($Detalle_Tetano->fields['tipovacunas'] == 3) {
                            $Check_Tetano = 'checked="checked"';
                        }
                    }
                    ######################################		

                    $SQL_DetalleVAcunas = 'SELECT 

															tipovacunas,
															dosisvacunas
															
															FROM 
															
															estudiantevacunas
															
															WHERE
															
															idestudiantegeneral="' . $id_Estudiante . '"
															AND
															codigoestado=100
															AND
															entrydate="' . $HoraVacunas->fields['Fecha'] . '"
															AND
															tipovacunas=4';

                    if ($Detalle_Hepatitis = &$db->Execute($SQL_DetalleVAcunas) === false) {
                        echo 'Error en el SQL de la s Vacuans...<br>' . $SQL_DetalleVAcunas;
                        die;
                    }

                    if (!$Detalle_Hepatitis->EOF) {

                        if ($Detalle_Hepatitis->fields['tipovacunas'] == 4) {

                            $Check_Hepatitis = 'checked="checked"';
                            $Ver_Hepatitis = 'style="visibility:visible"';

                            if ($Detalle_Hepatitis->fields['dosisvacunas'] == 1) {
                                $Dosis_Hep_Uno = 'checked="checked"';
                            }
                            if ($Detalle_Hepatitis->fields['dosisvacunas'] == 2) {
                                $Dosis_Hep_Dos = 'checked="checked"';
                            }
                            if ($Detalle_Hepatitis->fields['dosisvacunas'] == 3) {
                                $Dosis_Hep_Tres = 'checked="checked"';
                            }
                        }
                    }
                    ######################################	

                    $SQL_DetalleVAcunas = 'SELECT 

															tipovacunas,
															dosisvacunas
															
															FROM 
															
															estudiantevacunas
															
															WHERE
															
															idestudiantegeneral="' . $id_Estudiante . '"
															AND
															codigoestado=100
															AND
															entrydate="' . $HoraVacunas->fields['Fecha'] . '"
															AND
															tipovacunas=5';

                    if ($Detalle_VPH = &$db->Execute($SQL_DetalleVAcunas) === false) {
                        echo 'Error en el SQL de la s Vacuans...<br>' . $SQL_DetalleVAcunas;
                        die;
                    }

                    if (!$Detalle_VPH->EOF) {

                        if ($Detalle_VPH->fields['tipovacunas'] == 5) {

                            $Check_VPH = 'checked="checked"';
                            $Ver_VPH = 'style="visibility:visible"';

                            if ($Detalle_VPH->fields['dosisvacunas'] == 1) {
                                $Dosis_Vph_Uno = 'checked="checked"';
                            }
                            if ($Detalle_VPH->fields['dosisvacunas'] == 2) {
                                $Dosis_Vph_Dos = 'checked="checked"';
                            }
                            if ($Detalle_VPH->fields['dosisvacunas'] == 3) {
                                $Dosis_Vph_Tres = 'checked="checked"';
                            }
                        }
                    }
                    ######################################						
                    ?>
                                    <tr>
                                        <td width="4%">&nbsp;&nbsp;</td>
                                        <td width="59%"><strong>Sarampi&oacute;n</strong></td>
                                        <td width="4%">&nbsp;&nbsp;</td>
                                        <td width="24%"><input type="checkbox" id="Sarampion" name="Sarampion" onclick="UpdateVacuna(1); CambiaPersonal();"  <?php echo $Check_Sarampion ?> <?php echo $ClassDisable ?> /></td>
                                        <td width="9%">&nbsp;<input type="hidden" id="id_VacunasSarampion" />&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;</td>
                                        <td><strong>Rubeola</strong></td>
                                        <td>&nbsp;&nbsp;</td>
                                        <td><input type="checkbox" id="Rubeola" name="Rubeola" onclick="UpdateVacuna(2); CambiaPersonal();" <?php echo $Check_Rubeola ?> <?php echo $ClassDisable ?> /></td>
                                        <td>&nbsp;<input type="hidden" id="id_VacunasRubeola" />&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;</td>
                                        <td><strong>Tetano</strong></td>
                                        <td>&nbsp;&nbsp;</td>
                                        <td><input type="checkbox" id="Tetano" name="Tetano" onclick="UpdateVacuna(3); CambiaPersonal();" <?php echo $Check_Tetano ?>  <?php echo $ClassDisable ?> /></td>
                                        <td>&nbsp;<input type="hidden" id="id_VacunasTetano" />&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;</td>
                                        <td><strong>Hepatitis B</strong></td>
                                        <td>&nbsp;&nbsp;</td>
                                        <td><input type="checkbox" id="Hepatitis_B" name="Hepatitis_B" onclick="Activar_B(); UpdateVacuna(4); CambiaPersonal();" <?php echo $Check_Hepatitis ?>  <?php echo $ClassDisable ?> /></td>
                                        <td>&nbsp;<input type="hidden" id="id_VacunasHepatitisB" />&nbsp;</td>
                                    </tr>
                                    <tr id="Tr_Dosis_Hep" <?php echo $Ver_Hepatitis ?>>
                                        <td>&nbsp;&nbsp;</td>
                                        <td colspan="3">
                                            <table width="100%" align="center" border="0">
                                                <tr>
                                                    <td colspan="6">&nbsp;&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;</td>
                                                    <td><strong>Dosis:</strong></td>
                                                    <td><strong>1</strong>&nbsp;&nbsp;<input type="radio" id="Hepati_B_Uno" name="Dosis_Hep_B" <?php echo $Dosis_Hep_Uno ?>  <?php echo $ClassDisable ?>/>&nbsp;&nbsp;</td>
                                                    <td><strong>2</strong>&nbsp;&nbsp;<input type="radio" id="Hepati_B_Dos" name="Dosis_Hep_B"  <?php echo $Dosis_Hep_Dos ?>  <?php echo $ClassDisable ?>/>&nbsp;&nbsp;</td>
                                                    <td><strong>3</strong>&nbsp;&nbsp;<input type="radio" id="Hepati_B_Tres" name="Dosis_Hep_B"  <?php echo $Dosis_Hep_Tres ?>  <?php echo $ClassDisable ?>/>&nbsp;&nbsp;</td>
                                                    <td>&nbsp;&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">&nbsp;&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;&nbsp;</td>
                                        <td><strong>Virus del Papiloma Humano VPH</strong></td>
                                        <td>&nbsp;&nbsp;</td>
                                        <td><input type="checkbox" id="VPH" name="VPH" onclick="Activar_VPH(); UpdateVacuna(5); CambiaPersonal();"  <?php echo $Check_VPH ?> <?php echo $ClassDisable ?> /></td>
                                        <td>&nbsp;<input type="hidden" id="id_VacunasVPH" />&nbsp;</td>
                                    </tr>
                                    <tr id="Tr_Dosis_VPH" <?php echo $Ver_VPH ?>>
                                        <td>&nbsp;&nbsp;</td>
                                        <td colspan="3">
                                            <table width="100%" align="center" border="0">
                                                <tr>
                                                    <td colspan="6">&nbsp;&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;</td>
                                                    <td><strong>Dosis:</strong></td>
                                                    <td><strong>1</strong>&nbsp;&nbsp;<input type="radio" id="VPH_Uno" name="Dosis_VPH"  <?php echo $Dosis_Vph_Uno ?>  <?php echo $ClassDisable ?>/>&nbsp;&nbsp;</td>
                                                    <td><strong>2</strong>&nbsp;&nbsp;<input type="radio" id="VPH_Dos" name="Dosis_VPH"  <?php echo $Dosis_Vph_Dos ?>  <?php echo $ClassDisable ?>/>&nbsp;&nbsp;</td>
                                                    <td><strong>3</strong>&nbsp;&nbsp;<input type="radio" id="VPH_Tres" name="Dosis_VPH"  <?php echo $Dosis_Vph_Tres ?> <?php echo $ClassDisable ?> />&nbsp;&nbsp;</td>
                                                    <td>&nbsp;&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">&nbsp;&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">&nbsp;&nbsp;</td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td  colspan="4"><legend>Información referentea a hábitos saludables</legend></td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;&nbsp;</td>
                    </tr>
        <?php
        $SQL_MaxHabito = 'SELECT 

										MAX(idestudiantehabisaludable) AS id
										
										FROM 
										
										estudiantehabitosaludable
										
										WHERE
										
										idestudiantegeneral="' . $id_Estudiante . '"
										AND
										codigoestado=100';

        if ($Max_Habito = &$db->Execute($SQL_MaxHabito) === false) {
            echo 'Error en el SQL Habito Max....<br>' . $SQL_MaxHabito;
            die;
        }

        $SQL_DetalleHabito = 'SELECT 

											vegetariano,
											fuma,
											frecuneciafumar,
											alcohol,
											frecuenciaalcohol
											
											FROM 
											
											estudiantehabitosaludable
											
											WHERE
											
											idestudiantegeneral="' . $id_Estudiante . '"
											AND
											codigoestado=100
											AND
											idestudiantehabisaludable="' . $Max_Habito->fields['id'] . '"';

        if ($Detalle_Habito = &$db->Execute($SQL_DetalleHabito) === false) {
            echo 'Error en el SQL del Detalle del Habito Saludable....<br>' . $SQL_DetalleHabito;
            die;
        }
        ?>
                    <tr>
                        <td colspan="4">
                            <table width="100%" align="center" border="0">
                    <?php
                    if (!$Detalle_Habito->EOF) {

                        if ($Detalle_Habito->fields['vegetariano'] == 0) {
                            $Radio_Vegetariano_Si = 'checked="checked"';
                        }
                        if ($Detalle_Habito->fields['vegetariano'] == 1) {
                            $Radio_Vegetariano_No = 'checked="checked"';
                        }
                    }
                    ?>
                                <tr>
                                    <td width="50%"><strong>¿Usted es vegetariano(a)?&nbsp;&nbsp;<span style="color:#FF0000; font-size:10px" >*</span></strong></td>
                                    <td width="10%">&nbsp;&nbsp;</td>
                                    <td><strong>Si</strong>&nbsp;&nbsp;<input type="radio" id="Si_Vegetales" name="Vegetales" onclick="Update_Registro(2); CambiaPersonal();"  <?php echo $Radio_Vegetariano_Si ?> <?php echo $ClassDisable ?> />&nbsp;&nbsp;&nbsp;<strong>No</strong>&nbsp;&nbsp;<input type="radio" id="No_Vegetales" name="Vegetales" onclick="Update_Registro(2); CambiaPersonal();" <?php echo $Radio_Vegetariano_No ?> <?php echo $ClassDisable ?> /></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;&nbsp;</td>
                    </tr>
                    <?php
                    $Ver_Fuma = 'display:none';
                    if (!$Detalle_Habito->EOF) {
                        if ($Detalle_Habito->fields['fuma'] == 0) {
                            $Radio_Fuma_Si = 'checked="checked"';
                            $Ver_Fuma = 'display:inline';
                        }
                        if ($Detalle_Habito->fields['fuma'] == 1) {
                            $Radio_Fuma_No = 'checked="checked"';
                            $Ver_Fuma = 'display:none';
                        }
                    }
                    ?>
                    <tr>
                        <td colspan="4">
                            <table width="100%" align="center" border="0">
                                <tr>
                                    <td width="50%"><strong>¿Consume usted cigarrillo ? &nbsp;&nbsp;<span style="color:#FF0000; font-size:10px" >*</span></strong></td>
                                    <td width="10%">&nbsp;&nbsp;</td>
                                    <td><strong>Si</strong>&nbsp;&nbsp;<input type="radio" id="Si_Cigarrillo" name="Cigarrillo" onclick="Ver_Cigarillo(); CambiaPersonal(); Update_Registro(2);" <?php echo $Radio_Fuma_Si ?>  <?php echo $ClassDisable ?> />&nbsp;&nbsp;&nbsp;<strong>No</strong>&nbsp;&nbsp;<input type="radio" id="No_Cigarrillo" name="Cigarrillo" onclick="Ver_Cigarillo(); Update_Registro(2); CambiaPersonal();" <?php echo $Radio_Fuma_No ?> <?php echo $ClassDisable ?> /></td>
                                </tr>
                                <tr>
                                    <td colspan="3">&nbsp;&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <div id="Div_Cigarillo" style="width:100%;<?php echo $Ver_Fuma ?>" align="center">
                                            <table width="50%" align="center" border="0">
                                                <tr>
                                                    <td><strong>Con que Frecuencia Consume Cigarrillos:</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;</td>
                                                </tr>
                                <?php
                                /*
                                  1=Menos de 1 al día
                                  2=Entre 1 y 2 al día
                                  3=Entre 3 y 6 al día
                                  4=Entre 7 y 10 día
                                  5=Mas de 11 al día
                                 */

                                if ($Detalle_Habito->fields['frecuneciafumar'] == 1) {
                                    $Radio_Fre_Fumar_Uno = 'checked="checked"';
                                }
                                if ($Detalle_Habito->fields['frecuneciafumar'] == 2) {
                                    $Radio_Fre_Fumar_Dos = 'checked="checked"';
                                }
                                if ($Detalle_Habito->fields['frecuneciafumar'] == 3) {
                                    $Radio_Fre_Fumar_Tres = 'checked="checked"';
                                }
                                if ($Detalle_Habito->fields['frecuneciafumar'] == 4) {
                                    $Radio_Fre_Fumar_Cuatro = 'checked="checked"';
                                }
                                if ($Detalle_Habito->fields['frecuneciafumar'] == 5) {
                                    $Radio_Fre_Fumar_Cinco = 'checked="checked"';
                                }
                                ?>
                                                <tr>
                                                    <td>
                                                        <table width="100%" align="center" border="0">
                                                            <tr>
                                                                <td><strong>*Menos de 1 al d&iacute;a</strong></td>
                                                                <td>&nbsp;&nbsp;</td>
                                                                <td><input type="radio" id="C_uno" name="Fre_Cigarillos" <?php echo $Radio_Fre_Fumar_Uno ?> <?php echo $ClassDisable ?> /></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">&nbsp;&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>*Entre 1 y 2 al d&iacute;a</strong></td>
                                                                <td>&nbsp;&nbsp;</td>
                                                                <td><input type="radio" id="C_dos" name="Fre_Cigarillos" <?php echo $Radio_Fre_Fumar_Dos ?> <?php echo $ClassDisable ?> /></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">&nbsp;&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>*Entre 3 y 6 al d&iacute;a</strong></td>
                                                                <td>&nbsp;&nbsp;</td>
                                                                <td><input type="radio" id="C_tres" name="Fre_Cigarillos" <?php echo $Radio_Fre_Fumar_Tres ?> <?php echo $ClassDisable ?> /></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">&nbsp;&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>*Entre 7 y 10 d&iacute;a</strong></td>
                                                                <td>&nbsp;&nbsp;</td>
                                                                <td><input type="radio" id="C_Cuatro" name="Fre_Cigarillos" <?php echo $Radio_Fre_Fumar_Cuatro ?>  <?php echo $ClassDisable ?>/></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">&nbsp;&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>*Mas de 11 al d&iacute;a</strong></td>
                                                                <td>&nbsp;&nbsp;</td>
                                                                <td><input type="radio" id="C_cinco" name="Fre_Cigarillos" <?php echo $Radio_Fre_Fumar_Cinco ?> <?php echo $ClassDisable ?> /></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;&nbsp;</td>
                    </tr>
        <?php
        $Ver_Alcohol = 'display:none';
        if (!$Detalle_Habito->EOF) {
            if ($Detalle_Habito->fields['alcohol'] == 0) {
                $Radio_Alcohol_Si = 'checked="checked"';
                $Ver_Alcohol = 'display:inline';
            }
            if ($Detalle_Habito->fields['alcohol'] == 1) {
                $Radio_Alcohol_No = 'checked="checked"';
                $Ver_Alcohol = 'display:none';
            }
        }
        ?>
                    <tr>
                        <td colspan="4">
                            <table width="100%" align="center" border="0">
                                <tr>
                                    <td width="50%"><strong>¿Consume usted alcohol ?&nbsp;&nbsp;<span style="color:#FF0000; font-size:10px" >*</span></strong></td>
                                    <td width="10%">&nbsp;&nbsp;</td>
                                    <td><strong>Si</strong>&nbsp;&nbsp;<input type="radio" id="Si_Alcohol" name="Alcohol" onclick="Ver_Alcohol(); Update_Registro(2); CambiaPersonal();" <?php echo $Radio_Alcohol_Si ?> <?php echo $ClassDisable ?> />&nbsp;&nbsp;&nbsp;<strong>No</strong>&nbsp;&nbsp;<input type="radio" id="No_Alcohol" name="Alcohol" onclick="Ver_Alcohol(); Update_Registro(2); CambiaPersonal();" <?php echo $Radio_Alcohol_No ?> <?php echo $ClassDisable ?> /></td>
                                </tr>
                                <tr>
                                    <td colspan="3">&nbsp;&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <div id="Div_Alcohol" style="width:100%;<?php echo $Ver_Alcohol ?>" align="center">
                                            <table width="50%" align="center" border="0">
                                                <tr>
                                                    <td><strong>Con que Frecuencia Consume Alcohol:</strong></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;&nbsp;</td>
                                                </tr>
        <?php
        /*
          1=Menos de 1 vez a la semana
          2=1 vez a la semana
          3=Entre 2 y 3 veces a la semana
          4=Entre 4 y 5 veces a la semana
          5=Más de 6 veces a la semana
         */

        if ($Detalle_Habito->fields['frecuenciaalcohol'] == 1) {
            $Radio_Fre_Alcohol_Uno = 'checked="checked"';
        }
        if ($Detalle_Habito->fields['frecuenciaalcohol'] == 2) {
            $Radio_Fre_Alcohol_Dos = 'checked="checked"';
        }
        if ($Detalle_Habito->fields['frecuenciaalcohol'] == 3) {
            $Radio_Fre_Alcohol_Tres = 'checked="checked"';
        }
        if ($Detalle_Habito->fields['frecuenciaalcohol'] == 4) {
            $Radio_Fre_Alcohol_Cuatro = 'checked="checked"';
        }
        if ($Detalle_Habito->fields['frecuenciaalcohol'] == 5) {
            $Radio_Fre_Alcohol_Cinco = 'checked="checked"';
        }
        ?>
                                                <tr>
                                                    <td>
                                                        <table width="100%" align="center" border="0">
                                                            <tr>
                                                                <td><strong>*Menos de 1 vez a la semana</strong></td>
                                                                <td>&nbsp;&nbsp;</td>
                                                                <td><input type="radio" id="Alcohol_uno" name="Fre_Alcohol" <?php echo $Radio_Fre_Alcohol_Uno ?> <?php echo $ClassDisable ?> /></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">&nbsp;&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>*1 vez a la semana</strong></td>
                                                                <td>&nbsp;&nbsp;</td>
                                                                <td><input type="radio" id="Alcohol_dos" name="Fre_Alcohol" <?php echo $Radio_Fre_Alcohol_Dos ?> <?php echo $ClassDisable ?> /></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">&nbsp;&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>*Entre 2 y 3 veces a la semana
                                                                    </strong></td>
                                                                <td>&nbsp;&nbsp;</td>
                                                                <td><input type="radio" id="Alcohol_tres" name="Fre_Alcohol" <?php echo $Radio_Fre_Alcohol_Tres ?> <?php echo $ClassDisable ?> /></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">&nbsp;&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>*Entre 4 y 5 veces a la semana</strong></td>
                                                                <td>&nbsp;&nbsp;</td>
                                                                <td><input type="radio" id="Alcohol_Cuatro" name="Fre_Alcohol" <?php echo $Radio_Fre_Alcohol_Cuatro ?>  <?php echo $ClassDisable ?> /></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">&nbsp;&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>*M&aacute;s de 6 veces a la semana </strong></td>
                                                                <td>&nbsp;&nbsp;</td>
                                                                <td><input type="radio" id="Alcohol_cinco" name="Fre_Alcohol" <?php echo $Radio_Fre_Alcohol_Cinco ?>  <?php echo $ClassDisable ?>/></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;<input type="hidden" id="id_HabitosSaludables" />&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="4"><legend>Información referente a deportes y actividad física</legend></td>
                    </tr>
                    <tr>
                        <td colspan="4">&nbsp;&nbsp;</td>
                    </tr>
        <?php
        $SQL_MaxActividad = 'SELECT 

										MAX(idestudianteactividafisica) AS id
										
										FROM estudianteactividafisica
										
										WHERE
										
										idestudiantegeneral="' . $id_Estudiante . '"
										AND
										codigoestado=100';

        if ($Max_Actividad = &$db->Execute($SQL_MaxActividad) === false) {
            echo 'Error en el SQL Maximo....<br>' . $SQL_MaxActividad;
            die;
        }

        $SQL_DetalleActividad = 'SELECT 
												
												actividadfisica,
												actividadfisicacual,
												actividadfisicafrecuancia,
												redgruponacionalinternacional,
												cualredogrupo,
												voluntariado,
												cualvoluntariado
												
												FROM estudianteactividafisica
												
												WHERE
												
												idestudiantegeneral="' . $id_Estudiante . '"
												AND
												codigoestado=100
												AND
												idestudianteactividafisica="' . $Max_Actividad->fields['id'] . '"';

        if ($Detalle_Actividad = &$db->Execute($SQL_DetalleActividad) === false) {
            echo 'Error en el SQL Detalle Actividad Fisdica...<br>' . $SQL_DetalleActividad;
            die;
        }
        ?>
                    <tr>
                        <td colspan="4">
                            <table width="100%" align="center" border="0">
        <?php
        $Ver_Actividad = 'style="visibility:collapse"';
        $Div_Actividad = 'display:none';

        if (!$Detalle_Actividad->EOF) {

            if ($Detalle_Actividad->fields['actividadfisica'] == 0) {
                $Radio_Actividad_Si = 'checked="checked"';
                $Ver_Actividad = 'style="visibility:visible"';
                $Div_Actividad = 'display:inline';
            }
            if ($Detalle_Actividad->fields['actividadfisica'] == 1) {
                $Radio_Actividad_No = 'checked="checked"';
                $Ver_Actividad = 'style="visibility:collapse"';
                $Div_Actividad = 'display:none';
            }
        }
        ?>
                                <tr>
                                    <td width="54%"><strong>¿Realiza algún tipo de Actividad Física ? &nbsp;&nbsp;<span style="color:#FF0000; font-size:10px" >*</span></strong></td>
                                    <td width="6%">&nbsp;&nbsp;</td>
                                    <td width="10%"><strong>Si</strong>&nbsp;&nbsp;<input type="radio" id="Si_Act_Fisica" name="Act_Fisica" onclick="ActividaFisica(); CambiaPersonal();" <?php echo $Radio_Actividad_Si ?> <?php echo $ClassDisable ?> />&nbsp;&nbsp;&nbsp;<strong>No</strong>&nbsp;&nbsp;<input type="radio" id="No_Act_Fisica" name="Act_Fisica" onclick="ActividaFisica(); CambiaPersonal();" <?php echo $Radio_Actividad_No ?>  <?php echo $ClassDisable ?> /></td>
                                    <td width="28%">
                                        <table width="100%" align="center" border="0" <?php echo $Ver_Actividad ?> id="Div_ActFisica">
                                            <tr>
                                                <td><strong>¿Cuál ?</strong></td>
                                                <td align="center">
                                                    <input type="text" id="Act_FisicaCual" name="Act_FisicaCual" class="CajasHoja" value="<?php echo $Detalle_Actividad->fields['actividadfisicacual'] ?>" <?php echo $ClassDisable ?> />
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td width="2%">&nbsp;&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="5">&nbsp;<input type="hidden" id="ActividaFisica_id" />&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <div id="Div_ActFisica_2" style="width:100%;<?php echo $Div_Actividad ?>" align="center">
                                            <table width="100%" align="center" border="0">
                                                <tr>
                                                    <td width="13%"><strong>*Frecuencia.</strong></td>
                                                    <td colspan="3">&nbsp;&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">&nbsp;&nbsp;</td>
                                                </tr>
                    <?php
                    /*
                      1= 1 vez a la semana
                      2=3 veces a la semana
                      3=Más de 3 veces a la semana
                     */
                    if ($Detalle_Actividad->fields['actividadfisicafrecuancia'] == 1) {
                        $Fre_Actividad_Uno = 'checked="checked"';
                    }
                    if ($Detalle_Actividad->fields['actividadfisicafrecuancia'] == 2) {
                        $Fre_Actividad_Dos = 'checked="checked"';
                    }
                    if ($Detalle_Actividad->fields['actividadfisicafrecuancia'] == 3) {
                        $Fre_Actividad_Tres = 'checked="checked"';
                    }
                    ?>
                                                <tr>
                                                    <td>&nbsp;&nbsp;</td>
                                                    <td colspan="2">
                                                        <table width="92%" align="center" border="0">
                                                            <tr>
                                                                <td width="35%"><strong>* 1 vez a la semana</strong></td>
                                                                <td width="13%">&nbsp;&nbsp;</td>
                                                                <td width="52%"><input type="radio" id="Frec_uno" name="Fre_ActFisica" <?php echo $Fre_Actividad_Uno ?> <?php echo $ClassDisable ?> /></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">&nbsp;&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>* 3 veces a la semana</strong></td>
                                                                <td>&nbsp;&nbsp;</td>
                                                                <td><input type="radio" id="Frec_dos" name="Fre_ActFisica" <?php echo $Fre_Actividad_Dos ?> <?php echo $ClassDisable ?> /></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">&nbsp;&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>* M&aacute;s de 3 veces a la semana</strong></td>
                                                                <td>&nbsp;&nbsp;</td>
                                                                <td><input type="radio" id="Frec_tres" name="Fre_ActFisica" <?php echo $Fre_Actividad_Tres ?> <?php echo $ClassDisable ?> /></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">&nbsp;&nbsp;</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td width="4%">&nbsp;&nbsp;</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                                                <?php
                                                $SQL_MaxDeporte = 'SELECT 

											MAX(idestudiantedeporte)  AS id 
											
											
											FROM 
											
											estudiantedeporte
											
											WHERE
											
											idestudiantegeneral="' . $id_Estudiante . '"
											AND
											codigoestado=100';

                                                if ($Max_Deporte = &$db->Execute($SQL_MaxDeporte) === false) {
                                                    echo 'Error en el SQL Del MAx deporte....<br>' . $SQL_MaxDeporte;
                                                    die;
                                                }

                                                $SQL_Hora_Deporte = 'SELECT 

												practicadeporte,
												entrydate
												
												
												FROM 
												
												estudiantedeporte
												
												WHERE
												
												idestudiantegeneral="' . $id_Estudiante . '"
												AND
												codigoestado=100
												AND
												idestudiantedeporte="' . $Max_Deporte->fields['id'] . '"';

                                                if ($HoraDeporte = &$db->Execute($SQL_Hora_Deporte) === false) {
                                                    echo 'Error En El SQL Hora del Ingreso ...<br>' . $SQL_Hora_Deporte;
                                                    die;
                                                }


                                                $Ver_Deporte = 'display:none';

                                                if (!$HoraDeporte->EOF) {
                                                    if ($HoraDeporte->fields['practicadeporte'] == 0) {
                                                        $Practica_deporte_Si = 'checked="checked"';
                                                        $Ver_Deporte = 'display:inline';
                                                    }
                                                    if ($HoraDeporte->fields['practicadeporte'] == 1) {
                                                        $Practica_deporte_No = 'checked="checked"';
                                                        $Ver_Deporte = 'display:none';
                                                    }
                                                }
                                                ?>
                    <tr>
                        <td colspan="4">
                            <table width="100%" align="center" border="0">
                                <tr>
                                    <td width="44%"><strong>¿Practica alguna disciplina deportiva ? &nbsp;&nbsp;<span style="color:#FF0000; font-size:10px" >*</span></strong></td>
                                    <td width="12%">&nbsp;&nbsp;</td>
                                    <td width="15%" align="center"><strong>Si</strong>&nbsp;&nbsp;<input type="radio" id="Si_Practica" name="PracticaDepor" onclick="PracticaDeportiva(); CambiaPersonal();" <?php echo $Practica_deporte_Si ?> <?php echo $ClassDisable ?> />&nbsp;&nbsp;&nbsp;<strong>No</strong>&nbsp;&nbsp;<input type="radio" id="No_Practica" name="PracticaDepor" onclick="PracticaDeportiva(); CambiaPersonal();" <?php echo $Practica_deporte_No ?> <?php echo $ClassDisable ?> /></td>
                                    <td width="29%">
                                        <table width="100%" align="center" border="0" style="visibility:collapse"  id="T_DeportePractica">
                                            <tr style="visibility:collapse">
                                                <td><strong>¿Cuál ?</strong></td>
                                                <td align="center">
                                                    <input type="text" id="Practica_Dep" name="Practica_Dep" class="CajasHoja" <?php echo $ClassDisable ?> />
                                                </td>
                                            </tr>
                                        </table>     
                                    </td> 
                                </tr> 
                                <tr>
                                    <td colspan="5">&nbsp;<input type="hidden" id="No_Deporte_id" />&nbsp;</td>
                                </tr>
                    <?php
                    /*
                      1=Fútbol
                      2=Fútbol Sala
                      3=Basketball
                      4=Voleibol
                      5=Rugby
                      6=Tennis de Mesa
                      7=Tennis
                      8=Ciclismo
                      9=Natación
                      10=Atletismo
                      11=Beisbol
                      12=Ajedrez
                      13=Squash
                      14=Taekwondo
                      15=Otro
                     */

                    $SQL_Deporte = 'SELECT 

													practicadeporte,
													deporte,
													frecuenciadeporte
													
													
													FROM 
													
													estudiantedeporte
													
													WHERE
													
													idestudiantegeneral="' . $id_Estudiante . '"
													AND
													codigoestado=100
													AND
													entrydate="' . $HoraDeporte->fields['entrydate'] . '"
													AND
													deporte=1';

                    if ($Futbol = &$db->Execute($SQL_Deporte) === false) {
                        echo 'Error en el SQL Del Deporte Futbol...<br>' . $SQL_Deporte;
                        die;
                    }

                    if (!$Futbol->EOF) {

                        if ($Futbol->fields['deporte'] == 1) {
                            $Futbol_Check = 'checked="checked"';
                        }
                        /*                         * ***************************************** */
                        /*
                          1=1 vez a la semana
                          2=3 veces a la semana
                          3=Más de 3 veces a la semana
                         */
                        /*                         * ***************************************** */
                        if ($Futbol->fields['frecuenciadeporte'] == 1) {
                            $Fre_Futbol_Uno = 'checked="checked"';
                        }
                        if ($Futbol->fields['frecuenciadeporte'] == 2) {
                            $Fre_Futbol_Dos = 'checked="checked"';
                        }
                        if ($Futbol->fields['frecuenciadeporte'] == 3) {
                            $Fre_Futbol_Tres = 'checked="checked"';
                        }
                    }
                    ?>
                                <tr>
                                    <td colspan="5">
                                        <div id="Div_Practica" style="width:100%;<?php echo $Ver_Deporte ?>" align="center">
                                            <table width="50%" align="left" border="0">
                                                <tr>
                                                    <td width="46%"><strong>* F&uacute;tbol</strong></td>
                                                    <td width="8%">&nbsp;<input type="hidden" id="Futbol_id" />&nbsp;</td>
                                                    <td width="46%"><input type="checkbox" id="Futbol" name="Deportes" onclick="Ver_FrecuenciaDeprotiva(); DeleteDeporte('Futbol', 'Futbol_id', '1')" <?php echo $Futbol_Check ?> <?php echo $ClassDisable ?> /></td>
                                                </tr>
                                                <tr id="Tr_F_Futbol"  style="visibility:collapse;">
                                                    <td colspan="3">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Con Que Frecuencia Pactica F&uacute;tbol</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- 1 vez a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_F_Uno" name="Fre_Futbol" onclick="ModificarDeporte('Futbol', 'Futbol_id', '1')" <?php echo $Fre_Futbol_Uno ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- 3 veces a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_F_Dos" name="Fre_Futbol" onclick="ModificarDeporte('Futbol', 'Futbol_id', '2')" <?php echo $Fre_Futbol_Dos ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- M&aacute;s de 3 veces a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_F_Tres" name="Fre_Futbol" onclick="ModificarDeporte('Futbol', 'Futbol_id', '3')"  <?php echo $Fre_Futbol_Tres ?> <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                <?php
                                /*
                                  1=Fútbol
                                  2=Fútbol Sala
                                  3=Basketball
                                  4=Voleibol
                                  5=Rugby
                                  6=Tennis de Mesa
                                  7=Tennis
                                  8=Ciclismo
                                  9=Natación
                                  10=Atletismo
                                  11=Beisbol
                                  12=Ajedrez
                                  13=Squash
                                  14=Taekwondo
                                  15=Otro
                                 */

                                $SQL_Deporte = 'SELECT 
				
																	practicadeporte,
																	deporte,
																	frecuenciadeporte
																	
																	
																	FROM 
																	
																	estudiantedeporte
																	
																	WHERE
																	
																	idestudiantegeneral="' . $id_Estudiante . '"
																	AND
																	codigoestado=100
																	AND
																	entrydate="' . $HoraDeporte->fields['entrydate'] . '"
																	AND
																	deporte=2';

                                if ($FutbolSala = &$db->Execute($SQL_Deporte) === false) {
                                    echo 'Error en el SQL Del Deporte Futbol...<br>' . $SQL_Deporte;
                                    die;
                                }

                                if (!$FutbolSala->EOF) {

                                    if ($FutbolSala->fields['deporte'] == 2) {
                                        $FutbolSala_Check = 'checked="checked"';
                                    }
                                    /*                                     * ***************************************** */
                                    /*
                                      1=1 vez a la semana
                                      2=3 veces a la semana
                                      3=Más de 3 veces a la semana
                                     */
                                    /*                                     * ***************************************** */
                                    if ($FutbolSala->fields['frecuenciadeporte'] == 1) {
                                        $Fre_FutSala_Uno = 'checked="checked"';
                                    }
                                    if ($FutbolSala->fields['frecuenciadeporte'] == 2) {
                                        $Fre_FutSala_Dos = 'checked="checked"';
                                    }
                                    if ($FutbolSala->fields['frecuenciadeporte'] == 3) {
                                        $Fre_FutSala_Tres = 'checked="checked"';
                                    }
                                }
                                ?>
                                                <tr>
                                                    <td><strong>* F&uacute;tbol Sala</strong></td>
                                                    <td>&nbsp;<input type="hidden" id="Sala_id" />&nbsp;</td>
                                                    <td><input type="checkbox" id="F_sala" name="Deportes" onclick="Ver_FrecuenciaDeprotiva(); DeleteDeporte('F_sala', 'Sala_id')" <?php echo $FutbolSala_Check ?> <?php echo $ClassDisable ?> /></td>
                                                </tr>
                                                <tr id="Tr_F_FutbolSala"  style="visibility:collapse;">
                                                    <td colspan="3">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Con Que Frecuencia Pactica F&uacute;tbol Sala</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- 1 vez a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_FS_Uno" name="Fre_FutbolSala" onclick="ModificarDeporte('F_sala', 'Sala_id', '1')" <?php echo $Fre_FutSala_Uno ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- 3 veces a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_FS_Dos" name="Fre_FutbolSala" onclick="ModificarDeporte('F_sala', 'Sala_id', '2')" <?php echo $Fre_FutSala_Dos ?> <?php echo $ClassDisable ?> /> </td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- M&aacute;s de 3 veces a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_FS_Tres" name="Fre_FutbolSala" onclick="ModificarDeporte('F_sala', 'Sala_id', '3')" <?php echo $Fre_FutSala_Tres ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                                <?php
                                                /*
                                                  1=Fútbol
                                                  2=Fútbol Sala
                                                  3=Basketball
                                                  4=Voleibol
                                                  5=Rugby
                                                  6=Tennis de Mesa
                                                  7=Tennis
                                                  8=Ciclismo
                                                  9=Natación
                                                  10=Atletismo
                                                  11=Beisbol
                                                  12=Ajedrez
                                                  13=Squash
                                                  14=Taekwondo
                                                  15=Otro
                                                 */

                                                $SQL_Deporte = 'SELECT 
				
																	practicadeporte,
																	deporte,
																	frecuenciadeporte
																	
																	
																	FROM 
																	
																	estudiantedeporte
																	
																	WHERE
																	
																	idestudiantegeneral="' . $id_Estudiante . '"
																	AND
																	codigoestado=100
																	AND
																	entrydate="' . $HoraDeporte->fields['entrydate'] . '"
																	AND
																	deporte=3';

                                                if ($Basketball = &$db->Execute($SQL_Deporte) === false) {
                                                    echo 'Error en el SQL Del Deporte Futbol...<br>' . $SQL_Deporte;
                                                    die;
                                                }

                                                if (!$Basketball->EOF) {

                                                    if ($Basketball->fields['deporte'] == 3) {
                                                        $Basketball_Check = 'checked="checked"';
                                                    }
                                                    /*                                                     * ***************************************** */
                                                    /*
                                                      1=1 vez a la semana
                                                      2=3 veces a la semana
                                                      3=Más de 3 veces a la semana
                                                     */
                                                    /*                                                     * ***************************************** */
                                                    if ($Basketball->fields['frecuenciadeporte'] == 1) {
                                                        $Fre_Baskll_Uno = 'checked="checked"';
                                                    }
                                                    if ($Basketball->fields['frecuenciadeporte'] == 2) {
                                                        $Fre_Baskll_Dos = 'checked="checked"';
                                                    }
                                                    if ($Basketball->fields['frecuenciadeporte'] == 3) {
                                                        $Fre_Baskll_Tres = 'checked="checked"';
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td><strong>* Basketball</strong></td>
                                                    <td>&nbsp;<input type="hidden" id="Basketball_id" />&nbsp;</td>
                                                    <td><input type="checkbox" id="Basketball" name="Deportes" onclick="Ver_FrecuenciaDeprotiva(); DeleteDeporte('Basketball', 'Basketball_id')" <?php echo $Basketball_Check ?> <?php echo $ClassDisable ?> /></td>
                                                </tr>
                                                <tr id="Tr_Basketball"  style="visibility:collapse;">
                                                    <td colspan="3">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Con Que Frecuencia Pactica Basketball</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- 1 vez a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Bsk_Uno" name="Fre_Basketball" onclick="ModificarDeporte('Basketball', 'Basketball_id', '1')" <?php echo $Fre_Baskll_Uno ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- 3 veces a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Bsk_Dos" name="Fre_Basketball" onclick="ModificarDeporte('Basketball', 'Basketball_id', '2')" <?php echo $Fre_Baskll_Dos ?>  <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- M&aacute;s de 3 veces a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Bsk_Tres" name="Fre_Basketball" onclick="ModificarDeporte('Basketball', 'Basketball_id', '3')" <?php echo $Fre_Baskll_Tres ?>  <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                                <?php
                                                /*
                                                  1=Fútbol
                                                  2=Fútbol Sala
                                                  3=Basketball
                                                  4=Voleibol
                                                  5=Rugby
                                                  6=Tennis de Mesa
                                                  7=Tennis
                                                  8=Ciclismo
                                                  9=Natación
                                                  10=Atletismo
                                                  11=Beisbol
                                                  12=Ajedrez
                                                  13=Squash
                                                  14=Taekwondo
                                                  15=Otro
                                                 */

                                                $SQL_Deporte = 'SELECT 
				
																	practicadeporte,
																	deporte,
																	frecuenciadeporte
																	
																	
																	FROM 
																	
																	estudiantedeporte
																	
																	WHERE
																	
																	idestudiantegeneral="' . $id_Estudiante . '"
																	AND
																	codigoestado=100
																	AND
																	entrydate="' . $HoraDeporte->fields['entrydate'] . '"
																	AND
																	deporte=4';

                                                if ($Voleibol = &$db->Execute($SQL_Deporte) === false) {
                                                    echo 'Error en el SQL Del Deporte Futbol...<br>' . $SQL_Deporte;
                                                    die;
                                                }

                                                if (!$Voleibol->EOF) {

                                                    if ($Voleibol->fields['deporte'] == 4) {
                                                        $Voleibol_Check = 'checked="checked"';
                                                    }
                                                    /*                                                     * ***************************************** */
                                                    /*
                                                      1=1 vez a la semana
                                                      2=3 veces a la semana
                                                      3=Más de 3 veces a la semana
                                                     */
                                                    /*                                                     * ***************************************** */
                                                    if ($Voleibol->fields['frecuenciadeporte'] == 1) {
                                                        $Fre_Vole_Uno = 'checked="checked"';
                                                    }
                                                    if ($Voleibol->fields['frecuenciadeporte'] == 2) {
                                                        $Fre_Vole_Dos = 'checked="checked"';
                                                    }
                                                    if ($Voleibol->fields['frecuenciadeporte'] == 3) {
                                                        $Fre_Vole_Tres = 'checked="checked"';
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td><strong>* Voleibol</strong></td>
                                                    <td>&nbsp;<input type="hidden" id="Voleibol_id" />&nbsp;</td>
                                                    <td><input type="checkbox" id="Voleibol" name="Deportes" onclick="Ver_FrecuenciaDeprotiva(); DeleteDeporte('Voleibol', 'Voleibol_id')" <?php echo $Voleibol_Check ?>  <?php echo $ClassDisable ?> /></td>
                                                </tr>
                                                <tr id="Tr_Voleibol"  style="visibility:collapse;">
                                                    <td colspan="3">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Con Que Frecuencia Pactica Voleibol</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- 1 vez a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Vol_Uno" name="Fre_Voleibol" onclick="ModificarDeporte('Voleibol', 'Voleibol_id', '1')" <?php echo $Fre_Vole_Uno ?>  <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- 3 veces a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Vol_Dos" name="Fre_Voleibol" onclick="ModificarDeporte('Voleibol', 'Voleibol_id', '2')" <?php echo $Fre_Vole_Dos ?>  <?php echo $ClassDisable ?> /> </td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- M&aacute;s de 3 veces a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Vol_Tres" name="Fre_Voleibol" onclick="ModificarDeporte('Voleibol', 'Voleibol_id', '3')" <?php echo $Fre_Vole_Tres ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                                <?php
                                                /*
                                                  1=Fútbol
                                                  2=Fútbol Sala
                                                  3=Basketball
                                                  4=Voleibol
                                                  5=Rugby
                                                  6=Tennis de Mesa
                                                  7=Tennis
                                                  8=Ciclismo
                                                  9=Natación
                                                  10=Atletismo
                                                  11=Beisbol
                                                  12=Ajedrez
                                                  13=Squash
                                                  14=Taekwondo
                                                  15=Otro
                                                 */

                                                $SQL_Deporte = 'SELECT 
				
																	practicadeporte,
																	deporte,
																	frecuenciadeporte
																	
																	
																	FROM 
																	
																	estudiantedeporte
																	
																	WHERE
																	
																	idestudiantegeneral="' . $id_Estudiante . '"
																	AND
																	codigoestado=100
																	AND
																	entrydate="' . $HoraDeporte->fields['entrydate'] . '"
																	AND
																	deporte=5';

                                                if ($Rugby = &$db->Execute($SQL_Deporte) === false) {
                                                    echo 'Error en el SQL Del Deporte Futbol...<br>' . $SQL_Deporte;
                                                    die;
                                                }

                                                if (!$Rugby->EOF) {

                                                    if ($Rugby->fields['deporte'] == 5) {
                                                        $Rugby_Check = 'checked="checked"';
                                                    }
                                                    /*                                                     * ***************************************** */
                                                    /*
                                                      1=1 vez a la semana
                                                      2=3 veces a la semana
                                                      3=Más de 3 veces a la semana
                                                     */
                                                    /*                                                     * ***************************************** */
                                                    if ($Rugby->fields['frecuenciadeporte'] == 1) {
                                                        $Fre_Rugby_Uno = 'checked="checked"';
                                                    }
                                                    if ($Rugby->fields['frecuenciadeporte'] == 2) {
                                                        $Fre_Rugby_Dos = 'checked="checked"';
                                                    }
                                                    if ($Rugby->fields['frecuenciadeporte'] == 3) {
                                                        $Fre_Rugby_Tres = 'checked="checked"';
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td><strong>* Rugby</strong></td>
                                                    <td>&nbsp;<input type="hidden" id="Rugby_id" />&nbsp;</td>
                                                    <td><input type="checkbox" id="Rugby" name="Deportes" onclick="Ver_FrecuenciaDeprotiva(); DeleteDeporte('Rugby', 'Rugby_id')" <?php echo $Rugby_Check ?>  <?php echo $ClassDisable ?> /></td>
                                                </tr>
                                                <tr id="Tr_Rugby"  style="visibility:collapse;">
                                                    <td colspan="3">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Con Que Frecuencia Pactica Rugby</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- 1 vez a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Rby_Uno" name="Fre_Rugby" onclick="ModificarDeporte('Rugby', 'Rugby_id', '1')" <?php echo $Fre_Rugby_Uno ?>  <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- 3 veces a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Rby_Dos" name="Fre_Rugby" onclick="ModificarDeporte('Rugby', 'Rugby_id', '2')" <?php echo $Fre_Rugby_Dos ?>  <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- M&aacute;s de 3 veces a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Rby_Tres" name="Fre_Rugby" onclick="ModificarDeporte('Rugby', 'Rugby_id', '3')" <?php echo $Fre_Rugby_Tres ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                                <?php
                                                /*
                                                  1=Fútbol
                                                  2=Fútbol Sala
                                                  3=Basketball
                                                  4=Voleibol
                                                  5=Rugby
                                                  6=Tennis de Mesa
                                                  7=Tennis
                                                  8=Ciclismo
                                                  9=Natación
                                                  10=Atletismo
                                                  11=Beisbol
                                                  12=Ajedrez
                                                  13=Squash
                                                  14=Taekwondo
                                                  15=Otro
                                                 */

                                                $SQL_Deporte = 'SELECT 
				
																	practicadeporte,
																	deporte,
																	frecuenciadeporte
																	
																	
																	FROM 
																	
																	estudiantedeporte
																	
																	WHERE
																	
																	idestudiantegeneral="' . $id_Estudiante . '"
																	AND
																	codigoestado=100
																	AND
																	entrydate="' . $HoraDeporte->fields['entrydate'] . '"
																	AND
																	deporte=6';

                                                if ($Mesa = &$db->Execute($SQL_Deporte) === false) {
                                                    echo 'Error en el SQL Del Deporte Futbol...<br>' . $SQL_Deporte;
                                                    die;
                                                }

                                                if (!$Mesa->EOF) {

                                                    if ($Mesa->fields['deporte'] == 6) {
                                                        $Mesa_Check = 'checked="checked"';
                                                    }
                                                    /*                                                     * ***************************************** */
                                                    /*
                                                      1=1 vez a la semana
                                                      2=3 veces a la semana
                                                      3=Más de 3 veces a la semana
                                                     */
                                                    /*                                                     * ***************************************** */
                                                    if ($Mesa->fields['frecuenciadeporte'] == 1) {
                                                        $Fre_Mesa_Uno = 'checked="checked"';
                                                    }
                                                    if ($Mesa->fields['frecuenciadeporte'] == 2) {
                                                        $Fre_Mesa_Dos = 'checked="checked"';
                                                    }
                                                    if ($Mesa->fields['frecuenciadeporte'] == 3) {
                                                        $Fre_Mesa_Tres = 'checked="checked"';
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td><strong>* Tennis de Mesa</strong></td>
                                                    <td>&nbsp;<input type="hidden" id="T_mesa_id" />&nbsp;</td>
                                                    <td><input type="checkbox" id="T_mesa" name="Deportes" onclick="Ver_FrecuenciaDeprotiva(); DeleteDeporte('T_mesa', 'T_mesa_id')" <?php echo $Mesa_Check ?>  <?php echo $ClassDisable ?> /></td>
                                                </tr>
                                                <tr id="Tr_T_mesa"  style="visibility:collapse;">
                                                    <td colspan="3">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Con Que Frecuencia Pactica Tennis de Mesa</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- 1 vez a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_TMesa_Uno" name="Fre_T_mesa" onclick="ModificarDeporte('T_mesa', 'T_mesa_id', '1')" <?php echo $Fre_Mesa_Uno ?>  <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- 3 veces a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_TMesa_Dos" name="Fre_T_mesa" onclick="ModificarDeporte('T_mesa', 'T_mesa_id', '2')" <?php echo $Fre_Mesa_Dos ?>  <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- M&aacute;s de 3 veces a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_TMesa_Tres" name="Fre_T_mesa" onclick="ModificarDeporte('T_mesa', 'T_mesa_id', '3')" <?php echo $Fre_Mesa_Tres ?>  <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                                <?php
                                                /*
                                                  1=Fútbol
                                                  2=Fútbol Sala
                                                  3=Basketball
                                                  4=Voleibol
                                                  5=Rugby
                                                  6=Tennis de Mesa
                                                  7=Tennis
                                                  8=Ciclismo
                                                  9=Natación
                                                  10=Atletismo
                                                  11=Beisbol
                                                  12=Ajedrez
                                                  13=Squash
                                                  14=Taekwondo
                                                  15=Otro
                                                 */

                                                $SQL_Deporte = 'SELECT 
				
																	practicadeporte,
																	deporte,
																	frecuenciadeporte
																	
																	
																	FROM 
																	
																	estudiantedeporte
																	
																	WHERE
																	
																	idestudiantegeneral="' . $id_Estudiante . '"
																	AND
																	codigoestado=100
																	AND
																	entrydate="' . $HoraDeporte->fields['entrydate'] . '"
																	AND
																	deporte=7';

                                                if ($Tennis = &$db->Execute($SQL_Deporte) === false) {
                                                    echo 'Error en el SQL Del Deporte Futbol...<br>' . $SQL_Deporte;
                                                    die;
                                                }

                                                if (!$Tennis->EOF) {

                                                    if ($Tennis->fields['deporte'] == 7) {
                                                        $Tennis_Check = 'checked="checked"';
                                                    }
                                                    /*                                                     * ***************************************** */
                                                    /*
                                                      1=1 vez a la semana
                                                      2=3 veces a la semana
                                                      3=Más de 3 veces a la semana
                                                     */
                                                    /*                                                     * ***************************************** */
                                                    if ($Tennis->fields['frecuenciadeporte'] == 1) {
                                                        $Fre_Tennis_Uno = 'checked="checked"';
                                                    }
                                                    if ($Tennis->fields['frecuenciadeporte'] == 2) {
                                                        $Fre_Tennis_Dos = 'checked="checked"';
                                                    }
                                                    if ($Tennis->fields['frecuenciadeporte'] == 3) {
                                                        $Fre_Tennis_Tres = 'checked="checked"';
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td><strong>* Tennis</strong></td>
                                                    <td>&nbsp;<input type="hidden" id="Tennis_id" />&nbsp;</td>
                                                    <td><input type="checkbox" id="Tennis" name="Deportes" onclick="Ver_FrecuenciaDeprotiva(); DeleteDeporte('Tennis', 'Tennis_id')" <?php echo $Tennis_Check ?>  <?php echo $ClassDisable ?> /></td>
                                                </tr>
                                                <tr id="Tr_Tennis"  style="visibility:collapse;">
                                                    <td colspan="3">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Con Que Frecuencia Pactica Tennis</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- 1 vez a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Tennis_Uno" name="Fre_Tennis" onclick="ModificarDeporte('Tennis', 'Tennis_id', '1')" <?php echo $Fre_Tennis_Uno ?>   <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- 3 veces a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Tennis_Dos" name="Fre_Tennis" onclick="ModificarDeporte('Tennis', 'Tennis_id', '2')" <?php echo $Fre_Tennis_Dos ?>   <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- M&aacute;s de 3 veces a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Tennis_Tres" name="Fre_Tennis" onclick="ModificarDeporte('Tennis', 'Tennis_id', '3')" <?php echo $Fre_Tennis_Tres ?>  <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                                <?php
                                                /*
                                                  1=Fútbol
                                                  2=Fútbol Sala
                                                  3=Basketball
                                                  4=Voleibol
                                                  5=Rugby
                                                  6=Tennis de Mesa
                                                  7=Tennis
                                                  8=Ciclismo
                                                  9=Natación
                                                  10=Atletismo
                                                  11=Beisbol
                                                  12=Ajedrez
                                                  13=Squash
                                                  14=Taekwondo
                                                  15=Otro
                                                 */

                                                $SQL_Deporte = 'SELECT 
				
																	practicadeporte,
																	deporte,
																	frecuenciadeporte,
																	deportecual
																	
																	
																	FROM 
																	
																	estudiantedeporte
																	
																	WHERE
																	
																	idestudiantegeneral="' . $id_Estudiante . '"
																	AND
																	codigoestado=100
																	AND
																	entrydate="' . $HoraDeporte->fields['entrydate'] . '"
																	AND
																	deporte=15';

                                                if ($OtroDeport = &$db->Execute($SQL_Deporte) === false) {
                                                    echo 'Error en el SQL Del Deporte Futbol...<br>' . $SQL_Deporte;
                                                    die;
                                                }

                                                if (!$OtroDeport->EOF) {

                                                    if ($OtroDeport->fields['deporte'] == 15) {
                                                        $Ciclismo_Check = 'checked="checked"';
                                                    }
                                                    /*                                                     * ***************************************** */
                                                    /*
                                                      1=1 vez a la semana
                                                      2=3 veces a la semana
                                                      3=Más de 3 veces a la semana
                                                     */
                                                    /*                                                     * ***************************************** */
                                                    if ($OtroDeport->fields['frecuenciadeporte'] == 1) {
                                                        $Fre_OtorDepor_Uno = 'checked="checked"';
                                                    }
                                                    if ($OtroDeport->fields['frecuenciadeporte'] == 2) {
                                                        $Fre_OtorDepor_Dos = 'checked="checked"';
                                                    }
                                                    if ($OtroDeport->fields['frecuenciadeporte'] == 3) {
                                                        $Fre_OtorDepor_Tres = 'checked="checked"';
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td colspan="3">
                                                        <table width="100%" border="0">
                                                            <tr>
                                                                <td width="45%"><strong>* Otro:</strong></td>
                                                                <td width="9%">&nbsp;<input type="hidden" id="OtroDeporte_id" />&nbsp;</td>
                                                                <td width="46%"><input type="checkbox" id="OtroPractica" name="Deportes" onclick="Ver_FrecuenciaDeprotiva(); DeleteDeporte('OtroPractica', 'OtroDeporte_id')" <?php echo $Ciclismo_Check ?> <?php echo $ClassDisable ?> /></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr id="Tr_OtroPractica"  style="visibility:collapse;">
                                                    <td colspan="3">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Con Que Frecuencia Pactica Otro</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- 1 vez a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_OtroDep_Uno" name="Fre_OtroPractica" onclick="ModificarDeporte('OtroPractica', 'OtroDeporte_id', '1')" <?php echo $Fre_OtorDepor_Uno ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- 3 veces a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_OtroDep_Dos" name="Fre_OtroPractica" onclick="ModificarDeporte('OtroPractica', 'OtroDeporte_id', '2')" <?php echo $Fre_OtorDepor_Dos ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- M&aacute;s de 3 veces a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_OtroDep_Tres" name="Fre_OtroPractica" onclick="ModificarDeporte('OtroPractica', 'OtroDeporte_id', '3')" <?php echo $Fre_OtorDepor_Tres ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                            </table>
                                                <?php
                                                /*
                                                  1=Fútbol
                                                  2=Fútbol Sala
                                                  3=Basketball
                                                  4=Voleibol
                                                  5=Rugby
                                                  6=Tennis de Mesa
                                                  7=Tennis
                                                  8=Ciclismo
                                                  9=Natación
                                                  10=Atletismo
                                                  11=Beisbol
                                                  12=Ajedrez
                                                  13=Squash
                                                  14=Taekwondo
                                                  15=Otro
                                                 */

                                                $SQL_Deporte = 'SELECT 
				
																	practicadeporte,
																	deporte,
																	frecuenciadeporte
																	
																	
																	FROM 
																	
																	estudiantedeporte
																	
																	WHERE
																	
																	idestudiantegeneral="' . $id_Estudiante . '"
																	AND
																	codigoestado=100
																	AND
																	entrydate="' . $HoraDeporte->fields['entrydate'] . '"
																	AND
																	deporte=8';

                                                if ($Ciclismo = &$db->Execute($SQL_Deporte) === false) {
                                                    echo 'Error en el SQL Del Deporte Futbol...<br>' . $SQL_Deporte;
                                                    die;
                                                }

                                                if (!$Ciclismo->EOF) {

                                                    if ($Ciclismo->fields['deporte'] == 8) {
                                                        $Ciclismo_Check = 'checked="checked"';
                                                    }
                                                    /*                                                     * ***************************************** */
                                                    /*
                                                      1=1 vez a la semana
                                                      2=3 veces a la semana
                                                      3=Más de 3 veces a la semana
                                                     */
                                                    /*                                                     * ***************************************** */
                                                    if ($Ciclismo->fields['frecuenciadeporte'] == 1) {
                                                        $Fre_Ciclismo_Uno = 'checked="checked"';
                                                    }
                                                    if ($Ciclismo->fields['frecuenciadeporte'] == 2) {
                                                        $Fre_Ciclismo_Dos = 'checked="checked"';
                                                    }
                                                    if ($Ciclismo->fields['frecuenciadeporte'] == 3) {
                                                        $Fre_Ciclismo_Tres = 'checked="checked"';
                                                    }
                                                }
                                                ?>
                                            <table border="0" width="50%" align="right">
                                                <tr>
                                                    <td><strong>* Ciclismo</strong></td>
                                                    <td>&nbsp;<input type="hidden" id="Ciclismo_id" />&nbsp;</td>
                                                    <td><input type="checkbox" id="Ciclismo" name="Deportes" onclick="Ver_FrecuenciaDeprotiva(); DeleteDeporte('Ciclismo', 'Ciclismo_id')" <?php echo $Ciclismo_Check ?> <?php echo $ClassDisable ?> /></td>
                                                </tr>
                                                <tr id="Tr_Ciclismo"  style="visibility:collapse;">
                                                    <td colspan="3">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Con Que Frecuencia Pactica Ciclismo</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- 1 vez a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Cic_Uno" name="Fre_Ciclismo" onclick="ModificarDeporte('Ciclismo', 'Ciclismo_id', '1')" <?php echo $Fre_Ciclismo_Uno ?> <?php echo $ClassDisable ?>  /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- 3 veces a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Cic_Dos" name="Fre_Ciclismo" onclick="ModificarDeporte('Ciclismo', 'Ciclismo_id', '2')" <?php echo $Fre_Ciclismo_Dos ?>  <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- M&aacute;s de 3 veces a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Cic_Tres" name="Fre_Ciclismo" onclick="ModificarDeporte('Ciclismo', 'Ciclismo_id', '3')" <?php echo $Fre_Ciclismo_Tres ?>  <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                            <?php
                                            /*
                                              1=Fútbol
                                              2=Fútbol Sala
                                              3=Basketball
                                              4=Voleibol
                                              5=Rugby
                                              6=Tennis de Mesa
                                              7=Tennis
                                              8=Ciclismo
                                              9=Natación
                                              10=Atletismo
                                              11=Beisbol
                                              12=Ajedrez
                                              13=Squash
                                              14=Taekwondo
                                              15=Otro
                                             */

                                            $SQL_Deporte = 'SELECT 
				
																	practicadeporte,
																	deporte,
																	frecuenciadeporte
																	
																	
																	FROM 
																	
																	estudiantedeporte
																	
																	WHERE
																	
																	idestudiantegeneral="' . $id_Estudiante . '"
																	AND
																	codigoestado=100
																	AND
																	entrydate="' . $HoraDeporte->fields['entrydate'] . '"
																	AND
																	deporte=9';

                                            if ($Natacion = &$db->Execute($SQL_Deporte) === false) {
                                                echo 'Error en el SQL Del Deporte Futbol...<br>' . $SQL_Deporte;
                                                die;
                                            }

                                            if (!$Natacion->EOF) {

                                                if ($Natacion->fields['deporte'] == 9) {
                                                    $Natacion_Check = 'checked="checked"';
                                                }
                                                /*                                                 * ***************************************** */
                                                /*
                                                  1=1 vez a la semana
                                                  2=3 veces a la semana
                                                  3=Más de 3 veces a la semana
                                                 */
                                                /*                                                 * ***************************************** */
                                                if ($Natacion->fields['frecuenciadeporte'] == 1) {
                                                    $Fre_Natacion_Uno = 'checked="checked"';
                                                }
                                                if ($Natacion->fields['frecuenciadeporte'] == 2) {
                                                    $Fre_Natacion_Dos = 'checked="checked"';
                                                }
                                                if ($Natacion->fields['frecuenciadeporte'] == 3) {
                                                    $Fre_Natacion_Tres = 'checked="checked"';
                                                }
                                            }
                                            ?>
                                                <tr>
                                                    <td><strong>* Nataci&oacute;n</strong></td>
                                                    <td>&nbsp;<input type="hidden" id="Natacion_id" />&nbsp;</td>
                                                    <td><input type="checkbox" id="Natacion" name="Deportes" onclick="Ver_FrecuenciaDeprotiva(); DeleteDeporte('Natacion', 'Natacion_id')" <?php echo $Natacion_Check ?>  <?php echo $ClassDisable ?> /></td>
                                                </tr>
                                                <tr id="Tr_Natacion"  style="visibility:collapse;">
                                                    <td colspan="3">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Con Que Frecuencia Pactica Nataci&oacute;n</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- 1 vez a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Nata_Uno" name="Fre_Natacion" onclick="ModificarDeporte('Natacion', 'Natacion_id', '1')" <?php echo $Fre_Natacion_Uno ?>  <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- 3 veces a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Nata_Dos" name="Fre_Natacion" onclick="ModificarDeporte('Natacion', 'Natacion_id', '2')" <?php echo $Fre_Natacion_Dos ?>  <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- M&aacute;s de 3 veces a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Nata_Tres" name="Fre_Natacion" onclick="ModificarDeporte('Natacion', 'Natacion_id', '3')" <?php echo $Fre_Natacion_Tres ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                                <?php
                                                /*
                                                  1=Fútbol
                                                  2=Fútbol Sala
                                                  3=Basketball
                                                  4=Voleibol
                                                  5=Rugby
                                                  6=Tennis de Mesa
                                                  7=Tennis
                                                  8=Ciclismo
                                                  9=Natación
                                                  10=Atletismo
                                                  11=Beisbol
                                                  12=Ajedrez
                                                  13=Squash
                                                  14=Taekwondo
                                                  15=Otro
                                                 */

                                                $SQL_Deporte = 'SELECT 
				
																	practicadeporte,
																	deporte,
																	frecuenciadeporte
																	
																	
																	FROM 
																	
																	estudiantedeporte
																	
																	WHERE
																	
																	idestudiantegeneral="' . $id_Estudiante . '"
																	AND
																	codigoestado=100
																	AND
																	entrydate="' . $HoraDeporte->fields['entrydate'] . '"
																	AND
																	deporte=10';

                                                if ($Atletismo = &$db->Execute($SQL_Deporte) === false) {
                                                    echo 'Error en el SQL Del Deporte Futbol...<br>' . $SQL_Deporte;
                                                    die;
                                                }

                                                if (!$Atletismo->EOF) {

                                                    if ($Atletismo->fields['deporte'] == 10) {
                                                        $Atletismo_Check = 'checked="checked"';
                                                    }
                                                    /*                                                     * ***************************************** */
                                                    /*
                                                      1=1 vez a la semana
                                                      2=3 veces a la semana
                                                      3=Más de 3 veces a la semana
                                                     */
                                                    /*                                                     * ***************************************** */
                                                    if ($Atletismo->fields['frecuenciadeporte'] == 1) {
                                                        $Fre_Atletismo_Uno = 'checked="checked"';
                                                    }
                                                    if ($Atletismo->fields['frecuenciadeporte'] == 2) {
                                                        $Fre_Atletismo_Dos = 'checked="checked"';
                                                    }
                                                    if ($Atletismo->fields['frecuenciadeporte'] == 3) {
                                                        $Fre_Atletismo_Tres = 'checked="checked"';
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td><strong>* Atletismo</strong></td>
                                                    <td>&nbsp;<input type="hidden" id="Atletismo_id" />&nbsp;</td>
                                                    <td><input type="checkbox" id="Atletismo" name="Deportes" onclick="Ver_FrecuenciaDeprotiva(); DeleteDeporte('Atletismo', 'Atletismo_id')" <?php echo $Atletismo_Check ?> <?php echo $ClassDisable ?> /></td>
                                                </tr>
                                                <tr id="Tr_Atletismo"  style="visibility:collapse;">
                                                    <td colspan="3">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Con Que Frecuencia Pactica Atletismo</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- 1 vez a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Atl_Uno" name="Fre_Atletismo" onclick="ModificarDeporte('Atletismo', 'Atletismo_id', '1')" <?php echo $Fre_Atletismo_Uno ?>  <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- 3 veces a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Atl_Dos" name="Fre_Atletismo" onclick="ModificarDeporte('Atletismo', 'Atletismo_id', '2')" <?php echo $Fre_Atletismo_Dos ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- M&aacute;s de 3 veces a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Atl_Tres" name="Fre_Atletismo" onclick="ModificarDeporte('Atletismo', 'Atletismo_id', '3')" <?php echo $Fre_Atletismo_Tres ?>  <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                                <?php
                                                /*
                                                  1=Fútbol
                                                  2=Fútbol Sala
                                                  3=Basketball
                                                  4=Voleibol
                                                  5=Rugby
                                                  6=Tennis de Mesa
                                                  7=Tennis
                                                  8=Ciclismo
                                                  9=Natación
                                                  10=Atletismo
                                                  11=Beisbol
                                                  12=Ajedrez
                                                  13=Squash
                                                  14=Taekwondo
                                                  15=Otro
                                                 */

                                                $SQL_Deporte = 'SELECT 
				
																	practicadeporte,
																	deporte,
																	frecuenciadeporte
																	
																	
																	FROM 
																	
																	estudiantedeporte
																	
																	WHERE
																	
																	idestudiantegeneral="' . $id_Estudiante . '"
																	AND
																	codigoestado=100
																	AND
																	entrydate="' . $HoraDeporte->fields['entrydate'] . '"
																	AND
																	deporte=11';

                                                if ($Beisbol = &$db->Execute($SQL_Deporte) === false) {
                                                    echo 'Error en el SQL Del Deporte Futbol...<br>' . $SQL_Deporte;
                                                    die;
                                                }

                                                if (!$Beisbol->EOF) {

                                                    if ($Beisbol->fields['deporte'] == 11) {
                                                        $Beisbol_Check = 'checked="checked"';
                                                    }
                                                    /*                                                     * ***************************************** */
                                                    /*
                                                      1=1 vez a la semana
                                                      2=3 veces a la semana
                                                      3=Más de 3 veces a la semana
                                                     */
                                                    /*                                                     * ***************************************** */
                                                    if ($Beisbol->fields['frecuenciadeporte'] == 1) {
                                                        $Fre_Beisbol_Uno = 'checked="checked"';
                                                    }
                                                    if ($Beisbol->fields['frecuenciadeporte'] == 2) {
                                                        $Fre_Beisbol_Dos = 'checked="checked"';
                                                    }
                                                    if ($Beisbol->fields['frecuenciadeporte'] == 3) {
                                                        $Fre_Beisbol_Tres = 'checked="checked"';
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td><strong>* Beisbol</strong></td>
                                                    <td>&nbsp;<input type="hidden" id="Beisbol_id" />&nbsp;</td>
                                                    <td><input type="checkbox" id="Beisbol" name="Deportes" onclick="Ver_FrecuenciaDeprotiva(); DeleteDeporte('Beisbol', 'Beisbol_id')" <?php echo $Beisbol_Check ?> <?php echo $ClassDisable ?> /></td>
                                                </tr>
                                                <tr id="Tr_Beisbol"  style="visibility:collapse;">
                                                    <td colspan="3">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Con Que Frecuencia Pactica Beisbol</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- 1 vez a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Bes_Uno" name="Fre_Beisbol" onclick="ModificarDeporte('Beisbol', 'Beisbol_id', '3')" <?php echo $Fre_Beisbol_Uno ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- 3 veces a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Bes_Dos" name="Fre_Beisbol" onclick="ModificarDeporte('Beisbol', 'Beisbol_id', '2')" <?php echo $Fre_Beisbol_Dos ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- M&aacute;s de 3 veces a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Bes_Tres" name="Fre_Beisbol" onclick="ModificarDeporte('Beisbol', 'Beisbol_id', '3')" <?php echo $Fre_Beisbol_Tres ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                                <?php
                                                /*
                                                  1=Fútbol
                                                  2=Fútbol Sala
                                                  3=Basketball
                                                  4=Voleibol
                                                  5=Rugby
                                                  6=Tennis de Mesa
                                                  7=Tennis
                                                  8=Ciclismo
                                                  9=Natación
                                                  10=Atletismo
                                                  11=Beisbol
                                                  12=Ajedrez
                                                  13=Squash
                                                  14=Taekwondo
                                                  15=Otro
                                                 */

                                                $SQL_Deporte = 'SELECT 
				
																	practicadeporte,
																	deporte,
																	frecuenciadeporte
																	
																	
																	FROM 
																	
																	estudiantedeporte
																	
																	WHERE
																	
																	idestudiantegeneral="' . $id_Estudiante . '"
																	AND
																	codigoestado=100
																	AND
																	entrydate="' . $HoraDeporte->fields['entrydate'] . '"
																	AND
																	deporte=12';

                                                if ($Ajedrez = &$db->Execute($SQL_Deporte) === false) {
                                                    echo 'Error en el SQL Del Deporte Futbol...<br>' . $SQL_Deporte;
                                                    die;
                                                }

                                                if (!$Ajedrez->EOF) {

                                                    if ($Ajedrez->fields['deporte'] == 12) {
                                                        $Ajedrez_Check = 'checked="checked"';
                                                    }
                                                    /*                                                     * ***************************************** */
                                                    /*
                                                      1=1 vez a la semana
                                                      2=3 veces a la semana
                                                      3=Más de 3 veces a la semana
                                                     */
                                                    /*                                                     * ***************************************** */
                                                    if ($Ajedrez->fields['frecuenciadeporte'] == 1) {
                                                        $Fre_Ajedrez_Uno = 'checked="checked"';
                                                    }
                                                    if ($Ajedrez->fields['frecuenciadeporte'] == 2) {
                                                        $Fre_Ajedrez_Dos = 'checked="checked"';
                                                    }
                                                    if ($Ajedrez->fields['frecuenciadeporte'] == 3) {
                                                        $Fre_Ajedrez_Tres = 'checked="checked"';
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td><strong>* Ajedrez</strong></td>
                                                    <td>&nbsp;<input type="hidden" id="Ajedrez_id" />&nbsp;</td>
                                                    <td><input type="checkbox" id="Ajedrez" name="Deportes" onclick="Ver_FrecuenciaDeprotiva(); DeleteDeporte('Ajedrez', 'Ajedrez_id')" <?php echo $Ajedrez_Check ?> <?php echo $ClassDisable ?> /></td>
                                                </tr>
                                                <tr id="Tr_Ajedrez"  style="visibility:collapse;">
                                                    <td colspan="3">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Con Que Frecuencia Pactica Ajedrez</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- 1 vez a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Ajd_Uno" name="Fre_Ajedrez" onclick="ModificarDeporte('Ajedrez', 'Ajedrez_id', '1')" <?php echo $Fre_Ajedrez_Uno ?>  <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- 3 veces a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Ajd_Dos" name="Fre_Ajedrez" onclick="ModificarDeporte('Ajedrez', 'Ajedrez_id', '2')" <?php echo $Fre_Ajedrez_Dos ?>  <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- M&aacute;s de 3 veces a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Ajd_Tres" name="Fre_Ajedrez" onclick="ModificarDeporte('Ajedrez', 'Ajedrez_id', '3')" <?php echo $Fre_Ajedrez_Tres ?>  <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                                <?php
                                                /*
                                                  1=Fútbol
                                                  2=Fútbol Sala
                                                  3=Basketball
                                                  4=Voleibol
                                                  5=Rugby
                                                  6=Tennis de Mesa
                                                  7=Tennis
                                                  8=Ciclismo
                                                  9=Natación
                                                  10=Atletismo
                                                  11=Beisbol
                                                  12=Ajedrez
                                                  13=Squash
                                                  14=Taekwondo
                                                  15=Otro
                                                 */

                                                $SQL_Deporte = 'SELECT 
				
																	practicadeporte,
																	deporte,
																	frecuenciadeporte
																	
																	
																	FROM 
																	
																	estudiantedeporte
																	
																	WHERE
																	
																	idestudiantegeneral="' . $id_Estudiante . '"
																	AND
																	codigoestado=100
																	AND
																	entrydate="' . $HoraDeporte->fields['entrydate'] . '"
																	AND
																	deporte=13';

                                                if ($Squash = &$db->Execute($SQL_Deporte) === false) {
                                                    echo 'Error en el SQL Del Deporte Futbol...<br>' . $SQL_Deporte;
                                                    die;
                                                }

                                                if (!$Squash->EOF) {

                                                    if ($Squash->fields['deporte'] == 13) {
                                                        $Squash_Check = 'checked="checked"';
                                                    }
                                                    /*                                                     * ***************************************** */
                                                    /*
                                                      1=1 vez a la semana
                                                      2=3 veces a la semana
                                                      3=Más de 3 veces a la semana
                                                     */
                                                    /*                                                     * ***************************************** */
                                                    if ($Squash->fields['frecuenciadeporte'] == 1) {
                                                        $Fre_Squash_Uno = 'checked="checked"';
                                                    }
                                                    if ($Squash->fields['frecuenciadeporte'] == 2) {
                                                        $Fre_Squash_Dos = 'checked="checked"';
                                                    }
                                                    if ($Squash->fields['frecuenciadeporte'] == 3) {
                                                        $Fre_Squash_Tres = 'checked="checked"';
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td><strong>* Squash</strong></td>
                                                    <td>&nbsp;<input type="hidden" id="Squash_id" />&nbsp;</td>
                                                    <td><input type="checkbox" id="Squash" name="Deportes" onclick="Ver_FrecuenciaDeprotiva(); DeleteDeporte('Squash', 'Squash_id')" <?php echo $Squash_Check ?> <?php echo $ClassDisable ?>/></td>
                                                </tr>
                                                <tr id="Tr_Squash"  class="toggleOptions" style="visibility:collapse;">
                                                    <td colspan="3">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Con Que Frecuencia Pactica Squash</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- 1 vez a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Sqh_Uno" name="Fre_Squash" onclick="ModificarDeporte('Squash', 'Squash_id', '1')" <?php echo $Fre_Squash_Uno ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- 3 veces a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Sqh_Dos" name="Fre_Squash" onclick="ModificarDeporte('Squash', 'Squash_id', '2')" <?php echo $Fre_Squash_Dos ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- M&aacute;s de 3 veces a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Sqh_Tres" name="Fre_Squash" onclick="ModificarDeporte('Squash', 'Squash_id', '3')" <?php echo $Fre_Squash_Tres ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                                <?php
                                                /*
                                                  1=Fútbol
                                                  2=Fútbol Sala
                                                  3=Basketball
                                                  4=Voleibol
                                                  5=Rugby
                                                  6=Tennis de Mesa
                                                  7=Tennis
                                                  8=Ciclismo
                                                  9=Natación
                                                  10=Atletismo
                                                  11=Beisbol
                                                  12=Ajedrez
                                                  13=Squash
                                                  14=Taekwondo
                                                  15=Otro
                                                 */

                                                $SQL_Deporte = 'SELECT 
				
																	practicadeporte,
																	deporte,
																	frecuenciadeporte
																	
																	
																	FROM 
																	
																	estudiantedeporte
																	
																	WHERE
																	
																	idestudiantegeneral="' . $id_Estudiante . '"
																	AND
																	codigoestado=100
																	AND
																	entrydate="' . $HoraDeporte->fields['entrydate'] . '"
																	AND
																	deporte=14';

                                                if ($Taekwondo = &$db->Execute($SQL_Deporte) === false) {
                                                    echo 'Error en el SQL Del Deporte Futbol...<br>' . $SQL_Deporte;
                                                    die;
                                                }

                                                if (!$Taekwondo->EOF) {

                                                    if ($Taekwondo->fields['deporte'] == 14) {
                                                        $Taekwondo_Check = 'checked="checked"';
                                                    }
                                                    /*                                                     * ***************************************** */
                                                    /*
                                                      1=1 vez a la semana
                                                      2=3 veces a la semana
                                                      3=Más de 3 veces a la semana
                                                     */
                                                    /*                                                     * ***************************************** */
                                                    if ($Taekwondo->fields['frecuenciadeporte'] == 1) {
                                                        $Fre_Taekwondo_Uno = 'checked="checked"';
                                                    }
                                                    if ($Taekwondo->fields['frecuenciadeporte'] == 2) {
                                                        $Fre_Taekwondo_Dos = 'checked="checked"';
                                                    }
                                                    if ($Taekwondo->fields['frecuenciadeporte'] == 3) {
                                                        $Fre_Taekwondo_Tres = 'checked="checked"';
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td><strong>* Taekwondo</strong></td>
                                                    <td>&nbsp;<input type="hidden" id="Taekwondo_id" />&nbsp;</td>
                                                    <td><input type="checkbox" id="Taekwondo" name="Deportes" onclick="Ver_FrecuenciaDeprotiva(); DeleteDeporte('Taekwondo', 'Taekwondo_id')" <?php echo $Taekwondo_Check ?>  <?php echo $ClassDisable ?> /></td>
                                                </tr>
                                                <tr id="Tr_Taekwondo" class="toggleOptions"  style="visibility:collapse;">
                                                    <td colspan="3">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Con Que Frecuencia Pactica Taekwondo</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- 1 vez a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Tkw_Uno" name="Fre_Taekwondo" onclick="ModificarDeporte('Taekwondo', 'Taekwondo_id', '1')" <?php echo $Fre_Taekwondo_Uno ?>   <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- 3 veces a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Tkw_Dos" name="Fre_Taekwondo" onclick="ModificarDeporte('Taekwondo', 'Taekwondo_id', '2')" <?php echo $Fre_Taekwondo_Dos ?>  <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- M&aacute;s de 3 veces a la semana</strong></td>
                                                                    <td><input type="radio" id="Fr_Tkw_Tres" name="Fre_Taekwondo" onclick="ModificarDeporte('Taekwondo', 'Taekwondo_id', '3')" <?php echo $Fre_Taekwondo_Tres ?>  <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>¿Cuál ?</strong></td>
                                                    <td align="center"><input type="text" id="Otro_deporte" name="Otro_deporte" class="CajasHoja" value="<?php echo $OtroDeport->fields['deportecual'] ?>" <?php echo $ClassDisable ?> /></td>
                                                    <td>&nbsp;&nbsp;</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width="2%">&nbsp;&nbsp;</td>
                    </tr>  
                </table>

            </fieldset>
            <br />
            <fieldset style=" width:90%;  border-top-left-radius:2em;border-bottom-right-radius:2em;border:#88AB0C solid 1px ">
                <table width="98%" border="0" align="center" style="font-size:12px; color:#000">
                    <tr>
                        <td colspan="6"><legend>Información referente a afilicaión y vinculación con grupos sociales</legend></td>
                    </tr>
                                                <?php
                                                if (!$Detalle_Actividad->EOF) {
                                                    if ($Detalle_Actividad->fields['redgruponacionalinternacional'] == 0) {
                                                        $Radio_Red_Si = 'checked="checked"';
                                                    }
                                                    if ($Detalle_Actividad->fields['redgruponacionalinternacional'] == 1) {
                                                        $Radio_Red_No = 'checked="checked"';
                                                    }
                                                }
                                                ?>
                    <tr>
                        <td><strong>¿Pertenece o ha pertenecido a algún grupo, red o agremiación nacional o internacional ? &nbsp;&nbsp;<span style="color:#FF0000; font-size:10px" >*</span></strong></td>
                        <td>&nbsp;&nbsp;</td>
                        <td colspan="2"><strong>Si</strong>&nbsp;&nbsp;<input type="radio" id="Si_Pertenece" name="Pertenece" onclick="Ver_Pertenece(); CambiaPersonal();" <?php echo $Radio_Red_Si ?> <?php echo $ClassDisable ?>  />&nbsp;&nbsp;&nbsp;<strong>No</strong>&nbsp;&nbsp;<input type="radio" id="No_Pertenece" name="Pertenece" onclick="Ver_Pertenece(); CambiaPersonal();" <?php echo $Radio_Red_No ?>  <?php echo $ClassDisable ?> /></td>
                        <td>
                            <table width="100%" align="center" border="0" style="visibility:collapse" id="Div_PerteneceCual">
                                <tr>
                                    <td>&nbsp;</td>
                                    <td><strong>¿Cuál ?</strong></td>
                                    <td>&nbsp;</td>
                                    <td><input type="text" id="Pertenece_Cual" name="Pertenece_Cual" class="CajasHoja" value="<?php echo $Detalle_Actividad->fields['cualredogrupo'] ?>"  <?php echo $ClassDisable ?> /></td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                        <td>&nbsp;</td>
                    </tr> 
                    <tr>
                        <td colspan="6">&nbsp;&nbsp;</td>
                    </tr>
        <?php
        if (!$Detalle_Actividad->EOF) {
            if ($Detalle_Actividad->fields['voluntariado'] == 0) {
                $Radio_Vol_Si = 'checked="checked"';
            }
            if ($Detalle_Actividad->fields['voluntariado'] == 1) {
                $Radio_Vol_No = 'checked="checked"';
            }
        }
        ?>
                    <tr>
                        <td><strong>¿Realiza o ha o ha realizado algún tipo de voluntariado ? &nbsp;&nbsp;<span style="color:#FF0000; font-size:10px" >*</span> </strong></td>
                        <td>&nbsp;&nbsp;</td>
                        <td><strong>Si</strong>&nbsp;&nbsp;<input type="radio" id="Si_Voluntariado" name="Voluntariado" onclick="Ver_Voluntariado(); CambiaPersonal();" <?php echo $Radio_Vol_Si ?>  <?php echo $ClassDisable ?>  />&nbsp;&nbsp;&nbsp;<strong>No</strong>&nbsp;&nbsp;<input type="radio" id="No_Voluntariado" name="Voluntariado" onclick="Ver_Voluntariado(); CambiaPersonal();" <?php echo $Radio_Vol_No ?>  <?php echo $ClassDisable ?> /></td>
                        <td>&nbsp;&nbsp;</td>
                        <td>
                            <table width="100%" align="center" border="0" style="visibility:collapse" id="T_Voluntariado">
                                <tr>
                                    <td><strong>¿Cuál ?</strong></td>
                                    <td>&nbsp;</td>
                                    <td><input type="text" id="Voluntariado_Cual" name="Voluntariado_Cual" class="CajasHoja" value="<?php echo $Detalle_Actividad->fields['cualvoluntariado'] ?>" <?php echo $ClassDisable ?> /></td>
                                </tr>
                            </table>
                        </td>
                        <td>&nbsp;</td>
                    </tr> 
                    <tr>
                        <td colspan="6">&nbsp;&nbsp;</td>
                    </tr>
                </table>
            </fieldset>
            <br />
            <fieldset style=" width:90%;  border-top-left-radius:2em;border-bottom-right-radius:2em;border:#88AB0C solid 1px ">
                <table width="98%" border="0" align="center" style="font-size:12px; color:#000">
                    <tr>
                        <td><legend>Información referente a prácticas culturales o artísiticas</legend></td>
                    </tr>
        <?php
        $SQL_Max_Musica = 'SELECT 

										MAX(idestudiantemusica) AS id
										
										FROM estudiantemusica
										
										WHERE
										
										idestudiantegeneral="' . $id_Estudiante . '"
										AND
										codigoestado=100';

        if ($Max_Musica = &$db->Execute($SQL_Max_Musica) === false) {
            echo 'Error en el SQL .....<br>' . $SQL_Max_Musica;
            die;
        }

        $SQL_Hora_Musica = 'SELECT 

											instrumentomusical,
											entrydate
											
											FROM estudiantemusica
											
											WHERE
											
											idestudiantegeneral="' . $id_Estudiante . '"
											AND
											codigoestado=100
											AND
											idestudiantemusica="' . $Max_Musica->fields['id'] . '"';

        if ($Hora_Musica = &$db->Execute($SQL_Hora_Musica) === false) {
            echo 'Error en el SQL Hora de la Musica...<br>' . $SQL_Hora_Musica;
            die;
        }

        $Ver_Musica = 'display:none';

        if (!$Hora_Musica->EOF) {
            if ($Hora_Musica->fields['instrumentomusical'] == 0) {
                $Musica_Si = 'checked="checked"';
                $Ver_Musica = 'display:inline';
            }
            if ($Hora_Musica->fields['instrumentomusical'] == 1) {
                $Musica_No = 'checked="checked"';
                $Ver_Musica = 'display:none';
            }
        }
        ?>
                    <tr>
                        <td>
                            <table width="100%" border="0" align="center">
                                <tr>
                                    <td width="55%"><strong>¿Interpreta algún intrumento musical como hobbie o profesionalmente ?&nbsp;&nbsp;<span style="color:#FF0000; font-size:10px" >*</span></strong></td>
                                    <td width="10%">&nbsp;&nbsp;</td>
                                    <td><strong>Si</strong>&nbsp;&nbsp;<input type="radio" id="Si_musica" name="Musica"  onclick="Ver_Musica(); CambiaPersonal();" <?php echo $Musica_Si ?>  <?php echo $ClassDisable ?> />&nbsp;&nbsp;&nbsp;<strong>No</strong>&nbsp;&nbsp;<input type="radio" id="No_musica" name="Musica" onclick="Ver_Musica(); CambiaPersonal();"  <?php echo $Musica_No ?>   <?php echo $ClassDisable ?> /></td>
                                    <td>&nbsp;&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4">&nbsp;<input type="hidden" id="No_Musica_id" />&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <div id="Div_Musica" style="width:100%;<?php echo $Ver_Musica ?>" align="center">
                                            <table width="50%" align="left" border="0">
        <?php
        /*
          1=Guitarra
          2=Bateria
          3=Saxofon
          4=Trompeta
          5=Congas
          6=Acordeón
          7=Otro
         */
        $SQL_Musica = 'SELECT 

																	instrumentomusical,
																	tipoinstrumento,
																	tipoinstrumentocual,
																	frecuenciainstrumento
																	
																	FROM estudiantemusica
																	
																	WHERE
																	
																	idestudiantegeneral="' . $id_Estudiante . '"
																	AND
																	codigoestado=100
																	AND
																	entrydate="' . $Hora_Musica->fields['entrydate'] . '"
																	AND
																	tipoinstrumento=1';

        if ($Guitarra = &$db->Execute($SQL_Musica) === false) {
            echo 'Error en el SQL del LA Guitarra...<br>' . $SQL_Musica;
            die;
        }

        $Ver_Guitarra = 'style="visibility:collapse;"';

        if (!$Guitarra->EOF) {

            if ($Guitarra->fields['tipoinstrumento'] == 1) {
                $Guitarra_Checkc = 'checked="checked"';
                $Ver_Guitarra = 'style="visibility:visible;"';
            }
            /*
              1=Básico
              2=Medio
              3=Avanzado
             */
            if ($Guitarra->fields['frecuenciainstrumento'] == 1) {
                $Guitarra_Fre_Uno = 'checked="checked"';
            }
            if ($Guitarra->fields['frecuenciainstrumento'] == 2) {
                $Guitarra_Fre_Dos = 'checked="checked"';
            }
            if ($Guitarra->fields['frecuenciainstrumento'] == 3) {
                $Guitarra_Fre_Tres = 'checked="checked"';
            }
        }
        ?>
                                                <tr>
                                                    <td><strong>* Guitarra</strong></td>
                                                    <td>&nbsp;<input type="hidden" id="Guitarra_id" />&nbsp;</td>
                                                    <td><input type="checkbox" id="Guitarra" name="Instrumentos" onclick="VerNivelesMusicales(); DeleteMusica('Guitarra', 'Guitarra_id')" <?php echo $Guitarra_Checkc ?>  <?php echo $ClassDisable ?>/></td>
                                                </tr>
                                                <tr id="Tr_Guitarra" <?php echo $Ver_Guitarra ?> >
                                                    <td colspan="3">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Nivel de Conocimiento Guitarra</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- B&aacute;sico</strong></td>
                                                                    <td><input type="radio" id="Nv_Gui_Uno" name="Nivel_Guitarra" onclick="ModificarMusica('Guitarra', 'Guitarra_id', '1')" <?php echo $Guitarra_Fre_Uno ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- Medio</strong></td>
                                                                    <td><input type="radio" id="Nv_Gui_Dos" name="Nivel_Guitarra" onclick="ModificarMusica('Guitarra', 'Guitarra_id', '2')" <?php echo $Guitarra_Fre_Dos ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- Avanzado</strong></td>
                                                                    <td><input type="radio" id="Nv_Gui_Tres" name="Nivel_Guitarra" onclick="ModificarMusica('Guitarra', 'Guitarra_id', '3')" <?php echo $Guitarra_Fre_Tres ?>  <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                                <?php
                                                /*
                                                  1=Guitarra
                                                  2=Bateria
                                                  3=Saxofon
                                                  4=Trompeta
                                                  5=Congas
                                                  6=Acordeón
                                                  7=Otro
                                                 */
                                                $SQL_Musica = 'SELECT 

																	instrumentomusical,
																	tipoinstrumento,
																	tipoinstrumentocual,
																	frecuenciainstrumento
																	
																	FROM estudiantemusica
																	
																	WHERE
																	
																	idestudiantegeneral="' . $id_Estudiante . '"
																	AND
																	codigoestado=100
																	AND
																	entrydate="' . $Hora_Musica->fields['entrydate'] . '"
																	AND
																	tipoinstrumento=2';

                                                if ($Bateria = &$db->Execute($SQL_Musica) === false) {
                                                    echo 'Error en el SQL del LA Bateria...<br>' . $SQL_Musica;
                                                    die;
                                                }

                                                $Ver_Bateria = 'style="visibility:collapse;"';

                                                if (!$Bateria->EOF) {

                                                    if ($Bateria->fields['tipoinstrumento'] == 2) {
                                                        $Bateria_Checkc = 'checked="checked"';
                                                        $Ver_Bateria = 'style="visibility:visible;"';
                                                    }
                                                    /*
                                                      1=Básico
                                                      2=Medio
                                                      3=Avanzado
                                                     */
                                                    if ($Bateria->fields['frecuenciainstrumento'] == 1) {
                                                        $Bateria_Fre_Uno = 'checked="checked"';
                                                    }
                                                    if ($Bateria->fields['frecuenciainstrumento'] == 2) {
                                                        $Bateria_Fre_Dos = 'checked="checked"';
                                                    }
                                                    if ($Bateria->fields['frecuenciainstrumento'] == 3) {
                                                        $Bateria_Fre_Tres = 'checked="checked"';
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td><strong>* Bateria</strong></td>
                                                    <td>&nbsp;<input type="hidden" id="Bateria_id" />&nbsp;</td>
                                                    <td><input type="checkbox" id="Bateria" name="Instrumentos"  onclick="VerNivelesMusicales(); DeleteMusica('Bateria', 'Bateria_id')" <?php echo $Bateria_Checkc ?>  <?php echo $ClassDisable ?>/></td>
                                                </tr>
                                                <tr id="Tr_Bateria" <?php echo $Ver_Bateria ?>>
                                                    <td colspan="3">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Nivel de Conocimiento Bateria</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- B&aacute;sico</strong></td>
                                                                    <td><input type="radio" id="Nv_Bat_Uno" name="Nivel_Bateria" onclick="ModificarMusica('Bateria', 'Bateria_id', '1')" <?php echo $Bateria_Fre_Uno ?>   <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- Medio</strong></td>
                                                                    <td><input type="radio" id="Nv_Bat_Dos" name="Nivel_Bateria" onclick="ModificarMusica('Bateria', 'Bateria_id', '2')" <?php echo $Bateria_Fre_Dos ?>  <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- Avanzado</strong></td>
                                                                    <td><input type="radio" id="Nv_Bat_Tres" name="Nivel_Bateria" onclick="ModificarMusica('Bateria', 'Bateria_id', '3')" <?php echo $Bateria_Fre_Tres ?>  <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                                <?php
                                                /*
                                                  1=Guitarra
                                                  2=Bateria
                                                  3=Saxofon
                                                  4=Trompeta
                                                  5=Congas
                                                  6=Acordeón
                                                  7=Otro
                                                 */
                                                $SQL_Musica = 'SELECT 

																	instrumentomusical,
																	tipoinstrumento,
																	tipoinstrumentocual,
																	frecuenciainstrumento
																	
																	FROM estudiantemusica
																	
																	WHERE
																	
																	idestudiantegeneral="' . $id_Estudiante . '"
																	AND
																	codigoestado=100
																	AND
																	entrydate="' . $Hora_Musica->fields['entrydate'] . '"
																	AND
																	tipoinstrumento=3';

                                                if ($Saxofon = &$db->Execute($SQL_Musica) === false) {
                                                    echo 'Error en el SQL del LA Saxofon...<br>' . $SQL_Musica;
                                                    die;
                                                }

                                                $Ver_Saxofon = 'style="visibility:collapse;"';

                                                if (!$Saxofon->EOF) {

                                                    if ($Saxofon->fields['tipoinstrumento'] == 3) {
                                                        $Saxofon_Checkc = 'checked="checked"';
                                                        $Ver_Saxofon = 'style="visibility:visible;"';
                                                    }
                                                    /*
                                                      1=Básico
                                                      2=Medio
                                                      3=Avanzado
                                                     */
                                                    if ($Saxofon->fields['frecuenciainstrumento'] == 1) {
                                                        $Saxofon_Fre_Uno = 'checked="checked"';
                                                    }
                                                    if ($Saxofon->fields['frecuenciainstrumento'] == 2) {
                                                        $Saxofon_Fre_Dos = 'checked="checked"';
                                                    }
                                                    if ($Saxofon->fields['frecuenciainstrumento'] == 3) {
                                                        $Saxofon_Fre_Tres = 'checked="checked"';
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td><strong>* Saxofon</strong></td>
                                                    <td>&nbsp;<input type="hidden" id="Saxofon_id" />&nbsp;</td>
                                                    <td><input type="checkbox" id="Saxofon" name="Instrumentos" onclick="VerNivelesMusicales(); DeleteMusica('Saxofon', 'Saxofon_id')" <?php echo $Saxofon_Checkc ?>  <?php echo $ClassDisable ?> /></td>
                                                </tr>
                                                <tr id="Tr_Saxofon" <?php echo $Ver_Saxofon ?>>
                                                    <td colspan="3">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Nivel de Conocimiento Saxofon</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- B&aacute;sico</strong></td>
                                                                    <td><input type="radio" id="Nv_Sax_Uno" name="Nivel_Saxofon" onclick="ModificarMusica('Saxofon', 'Saxofon_id', '1')" <?php echo $Saxofon_Fre_Uno ?>  <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- Medio</strong></td>
                                                                    <td><input type="radio" id="Nv_Sax_Dos" name="Nivel_Saxofon" onclick="ModificarMusica('Saxofon', 'Saxofon_id', '2')" <?php echo $Saxofon_Fre_Dos ?>  <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- Avanzado</strong></td>
                                                                    <td><input type="radio" id="Nv_Sax_Tres" name="Nivel_Saxofon" onclick="ModificarMusica('Saxofon', 'Saxofon_id', '3')" <?php echo $Saxofon_Fre_Tres ?>  <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                                <?php
                                                /*
                                                  1=Guitarra
                                                  2=Bateria
                                                  3=Saxofon
                                                  4=Trompeta
                                                  5=Congas
                                                  6=Acordeón
                                                  7=Otro
                                                 */
                                                $SQL_Musica = 'SELECT 

																	instrumentomusical,
																	tipoinstrumento,
																	tipoinstrumentocual,
																	frecuenciainstrumento
																	
																	FROM estudiantemusica
																	
																	WHERE
																	
																	idestudiantegeneral="' . $id_Estudiante . '"
																	AND
																	codigoestado=100
																	AND
																	entrydate="' . $Hora_Musica->fields['entrydate'] . '"
																	AND
																	tipoinstrumento=7';

                                                if ($OtraMusica = &$db->Execute($SQL_Musica) === false) {
                                                    echo 'Error en el SQL del LA OtraMusica...<br>' . $SQL_Musica;
                                                    die;
                                                }

                                                $Ver_OtraMusica = 'style="visibility:collapse;"';

                                                if (!$OtraMusica->EOF) {

                                                    if ($OtraMusica->fields['tipoinstrumento'] == 7) {
                                                        $OtraMusica_Checkc = 'checked="checked"';
                                                        $Ver_OtraMusica = 'style="visibility:visible;"';
                                                    }
                                                    /*
                                                      1=Básico
                                                      2=Medio
                                                      3=Avanzado
                                                     */
                                                    if ($OtraMusica->fields['frecuenciainstrumento'] == 1) {
                                                        $OtraMusica_Fre_Uno = 'checked="checked"';
                                                    }
                                                    if ($OtraMusica->fields['frecuenciainstrumento'] == 2) {
                                                        $OtraMusica_Fre_Dos = 'checked="checked"';
                                                    }
                                                    if ($OtraMusica->fields['frecuenciainstrumento'] == 3) {
                                                        $OtraMusica_Fre_Tres = 'checked="checked"';
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td><strong>* Otro</strong></td>
                                                    <td>&nbsp;<input type="hidden" id="OtraMusica_id" />&nbsp;</td>
                                                    <td><input type="checkbox" id="Otro_Musica" name="Instrumentos" onclick="VerNivelesMusicales(); DeleteMusica('Otro_Musica', 'OtraMusica_id')" <?php echo $OtraMusica_Checkc ?> <?php echo $ClassDisable ?> /></td>
                                                </tr>
                                                <tr id="Tr_Otro_Musica"  <?php echo $Ver_OtraMusica ?>>
                                                    <td colspan="3">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Nivel de Conocimiento Otro</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- B&aacute;sico</strong></td>
                                                                    <td><input type="radio" id="Nv_OtroMusica_Uno" name="Nivel_Otro_Musica" onclick="ModificarMusica('Otro_Musica', 'OtraMusica_id', '1')" <?php echo $OtraMusica_Fre_Uno ?>  <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- Medio</strong></td>
                                                                    <td><input type="radio" id="Nv_OtroMusica_Dos" name="Nivel_Otro_Musica" onclick="ModificarMusica('Otro_Musica', 'OtraMusica_id', '2')" <?php echo $OtraMusica_Fre_Dos ?>  <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- Avanzado</strong></td>
                                                                    <td><input type="radio" id="Nv_OtroMusica_Tres" name="Nivel_Otro_Musica" onclick="ModificarMusica('Otro_Musica', 'OtraMusica_id', '3')" <?php echo $OtraMusica_Fre_Tres ?>  <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                            </table>
                                            <table width="50%" align="right" border="0">
                                                <?php
                                                /*
                                                  1=Guitarra
                                                  2=Bateria
                                                  3=Saxofon
                                                  4=Trompeta
                                                  5=Congas
                                                  6=Acordeón
                                                  7=Otro
                                                 */
                                                $SQL_Musica = 'SELECT 

																	instrumentomusical,
																	tipoinstrumento,
																	tipoinstrumentocual,
																	frecuenciainstrumento
																	
																	FROM estudiantemusica
																	
																	WHERE
																	
																	idestudiantegeneral="' . $id_Estudiante . '"
																	AND
																	codigoestado=100
																	AND
																	entrydate="' . $Hora_Musica->fields['entrydate'] . '"
																	AND
																	tipoinstrumento=4';

                                                if ($Trompeta = &$db->Execute($SQL_Musica) === false) {
                                                    echo 'Error en el SQL del LA Trompeta...<br>' . $SQL_Musica;
                                                    die;
                                                }

                                                $Ver_Trompeta = 'style="visibility:collapse;"';

                                                if (!$Trompeta->EOF) {

                                                    if ($Trompeta->fields['tipoinstrumento'] == 4) {
                                                        $Trompeta_Checkc = 'checked="checked"';
                                                        $Ver_Trompeta = 'style="visibility:visible;"';
                                                    }
                                                    /*
                                                      1=Básico
                                                      2=Medio
                                                      3=Avanzado
                                                     */
                                                    if ($Trompeta->fields['frecuenciainstrumento'] == 1) {
                                                        $Trompeta_Fre_Uno = 'checked="checked"';
                                                    }
                                                    if ($Trompeta->fields['frecuenciainstrumento'] == 2) {
                                                        $Trompeta_Fre_Dos = 'checked="checked"';
                                                    }
                                                    if ($Trompeta->fields['frecuenciainstrumento'] == 3) {
                                                        $Trompeta_Fre_Tres = 'checked="checked"';
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td><strong>* Trompeta</strong></td>
                                                    <td>&nbsp;<input type="hidden" id="Trompeta_id" />&nbsp;</td>
                                                    <td><input type="checkbox" id="Trompeta" name="Instrumentos"  onclick="VerNivelesMusicales(); DeleteMusica('Trompeta', 'Trompeta_id')" <?php echo $Trompeta_Checkc ?>  <?php echo $ClassDisable ?>/></td>
                                                </tr>
                                                <tr id="Tr_Trompeta"  <?php echo $Ver_Trompeta ?>>
                                                    <td colspan="3">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Nivel de Conocimiento Trompeta</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- B&aacute;sico</strong></td>
                                                                    <td><input type="radio" id="Nv_Trop_Uno" name="Nivel_Trompeta" onclick="ModificarMusica('Trompeta', 'Trompeta_id', '1')" <?php echo $Trompeta_Fre_Uno ?>  <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- Medio</strong></td>
                                                                    <td><input type="radio" id="Nv_Trop_Dos" name="Nivel_Trompeta" onclick="ModificarMusica('Trompeta', 'Trompeta_id', '2')" <?php echo $Trompeta_Fre_Dos ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- Avanzado</strong></td>
                                                                    <td><input type="radio" id="Nv_Trop_Tres" name="Nivel_Trompeta" onclick="ModificarMusica('Trompeta', 'Trompeta_id', '3')" <?php echo $Trompeta_Fre_Tres ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                                <?php
                                                /*
                                                  1=Guitarra
                                                  2=Bateria
                                                  3=Saxofon
                                                  4=Trompeta
                                                  5=Congas
                                                  6=Acordeón
                                                  7=Otro
                                                 */
                                                $SQL_Musica = 'SELECT 

																	instrumentomusical,
																	tipoinstrumento,
																	tipoinstrumentocual,
																	frecuenciainstrumento
																	
																	FROM estudiantemusica
																	
																	WHERE
																	
																	idestudiantegeneral="' . $id_Estudiante . '"
																	AND
																	codigoestado=100
																	AND
																	entrydate="' . $Hora_Musica->fields['entrydate'] . '"
																	AND
																	tipoinstrumento=5';

                                                if ($Congas = &$db->Execute($SQL_Musica) === false) {
                                                    echo 'Error en el SQL del LA Congas...<br>' . $SQL_Musica;
                                                    die;
                                                }

                                                $Ver_Congas = 'style="visibility:collapse;"';

                                                if (!$Congas->EOF) {

                                                    if ($Congas->fields['tipoinstrumento'] == 5) {
                                                        $Congas_Checkc = 'checked="checked"';
                                                        $Ver_Congas = 'style="visibility:visible;"';
                                                    }
                                                    /*
                                                      1=Básico
                                                      2=Medio
                                                      3=Avanzado
                                                     */
                                                    if ($Congas->fields['frecuenciainstrumento'] == 1) {
                                                        $Congas_Fre_Uno = 'checked="checked"';
                                                    }
                                                    if ($Congas->fields['frecuenciainstrumento'] == 2) {
                                                        $Congas_Fre_Dos = 'checked="checked"';
                                                    }
                                                    if ($Congas->fields['frecuenciainstrumento'] == 3) {
                                                        $Congas_Fre_Tres = 'checked="checked"';
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td><strong>* Congas</strong></td>
                                                    <td>&nbsp;<input type="hidden" id="Congas_id" />&nbsp;</td>
                                                    <td><input type="checkbox" id="Congas" name="Instrumentos" onclick="VerNivelesMusicales(); DeleteMusica('Congas', 'Congas_id')" <?php echo $Congas_Checkc ?>  <?php echo $ClassDisable ?> /></td>
                                                </tr>
                                                <tr id="Tr_Congas"  <?php echo $Ver_Congas ?>>
                                                    <td colspan="3">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Nivel de Conocimiento Congas</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- B&aacute;sico</strong></td>
                                                                    <td><input type="radio" id="Nv_Cong_Uno" name="Nivel_Congas" onclick="ModificarMusica('Congas', 'Congas_id', '1')" <?php echo $Congas_Fre_Uno ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- Medio</strong></td>
                                                                    <td><input type="radio" id="Nv_Cong_Dos" name="Nivel_Congas" onclick="ModificarMusica('Congas', 'Congas_id', '2')" <?php echo $Congas_Fre_Dos ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- Avanzado</strong></td>
                                                                    <td><input type="radio" id="Nv_Cong_Tres" name="Nivel_Congas" onclick="ModificarMusica('Congas', 'Congas_id', '3')" <?php echo $Congas_Fre_Tres ?>  <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                                <?php
                                                /*
                                                  1=Guitarra
                                                  2=Bateria
                                                  3=Saxofon
                                                  4=Trompeta
                                                  5=Congas
                                                  6=Acordeón
                                                  7=Otro
                                                 */
                                                $SQL_Musica = 'SELECT 

																	instrumentomusical,
																	tipoinstrumento,
																	tipoinstrumentocual,
																	frecuenciainstrumento
																	
																	FROM estudiantemusica
																	
																	WHERE
																	
																	idestudiantegeneral="' . $id_Estudiante . '"
																	AND
																	codigoestado=100
																	AND
																	entrydate="' . $Hora_Musica->fields['entrydate'] . '"
																	AND
																	tipoinstrumento=6';

                                                if ($Acordeon = &$db->Execute($SQL_Musica) === false) {
                                                    echo 'Error en el SQL del LA Acordeon...<br>' . $SQL_Musica;
                                                    die;
                                                }

                                                $Ver_Acordeon = 'style="visibility:collapse;"';

                                                if (!$Acordeon->EOF) {

                                                    if ($Acordeon->fields['tipoinstrumento'] == 6) {
                                                        $Acordeon_Checkc = 'checked="checked"';
                                                        $Ver_Acordeon = 'style="visibility:visible;"';
                                                    }
                                                    /*
                                                      1=Básico
                                                      2=Medio
                                                      3=Avanzado
                                                     */
                                                    if ($Acordeon->fields['frecuenciainstrumento'] == 1) {
                                                        $Acordeon_Fre_Uno = 'checked="checked"';
                                                    }
                                                    if ($Acordeon->fields['frecuenciainstrumento'] == 2) {
                                                        $Acordeon_Fre_Dos = 'checked="checked"';
                                                    }
                                                    if ($Acordeon->fields['frecuenciainstrumento'] == 3) {
                                                        $Acordeon_Fre_Tres = 'checked="checked"';
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td><strong>* Acorde&oacute;n</strong></td>
                                                    <td>&nbsp;<input type="hidden" id="Acordion_id" />&nbsp;</td>
                                                    <td><input type="checkbox" id="Acordion" name="Instrumentos" onclick="VerNivelesMusicales(); DeleteMusica('Acordion', 'Acordion_id')" <?php echo $Acordeon_Checkc ?> <?php echo $ClassDisable ?> /></td>
                                                </tr>
                                                <tr id="Tr_Acordion"  <?php echo $Ver_Acordeon ?>>
                                                    <td colspan="3">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Nivel de Conocimiento Acorde&oacute;n</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- B&aacute;sico</strong></td>
                                                                    <td><input type="radio" id="Nv_Acord_Uno" name="Nivel_Acordion" onclick="ModificarMusica('Acordion', 'Acordion_id', '1')" <?php echo $Acordeon_Fre_Uno ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- Medio</strong></td>
                                                                    <td><input type="radio" id="Nv_Acord_Dos" name="Nivel_Acordion" onclick="ModificarMusica('Acordion', 'Acordion_id', '2')" <?php echo $Acordeon_Fre_Dos ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- Avanzado</strong></td>
                                                                    <td><input type="radio" id="Nv_Acord_Tres" name="Nivel_Acordion" onclick="ModificarMusica('Acordion', 'Acordion_id', '3')" <?php echo $Acordeon_Fre_Tres ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>* ¿Cuál ?</strong></td>
                                                    <td>&nbsp;&nbsp;</td>
                                                    <td><input type="text" id="Cual_Instrumentio" name="Cual_Instrumentio" class="CajasHoja" value="<?php echo $OtraMusica->fields['tipoinstrumentocual'] ?>" <?php echo $ClassDisable ?> /></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">&nbsp;&nbsp;</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                                                <?php
                                                $SQL_Max_Danza = 'SELECT 

										MAX(idestudianteexprecioncorporal) AS id 
										
										FROM estudianteexprecioncorporal
										
										WHERE
										
										idestudiantegeneral="' . $id_Estudiante . '"
										AND
										codigoestado=100';

                                                if ($Max_Danza = &$db->Execute($SQL_Max_Danza) === false) {
                                                    echo 'Error en el SQL Max Danza....<br>' . $SQL_Max_Danza;
                                                    die;
                                                }

                                                $SQL_Hora_Danza = 'SELECT 

											exprecioncorporal,
											entrydate
											
											FROM estudianteexprecioncorporal
											
											WHERE
											
											idestudiantegeneral="' . $id_Estudiante . '"
											AND
											codigoestado=100
											AND
											idestudianteexprecioncorporal="' . $Max_Danza->fields['id'] . '"';

                                                if ($Hora_Danza = &$db->Execute($SQL_Hora_Danza) === false) {
                                                    echo 'Error en el SQl Hora de la Danza...<br>' . $SQL_Hora_Danza;
                                                    die;
                                                }

                                                $Ver_Danza = 'display:none';

                                                if (!$Hora_Danza->EOF) {
                                                    if ($Hora_Danza->fields['exprecioncorporal'] == 0) {
                                                        $Danza_Si = 'checked="checked"';
                                                        $Ver_Danza = 'display:inline';
                                                    }
                                                    if ($Hora_Danza->fields['exprecioncorporal'] == 1) {
                                                        $Danza_No = 'checked="checked"';
                                                        $Ver_Danza = 'display:none';
                                                    }
                                                }
                                                ?>
                    <tr>
                        <td>
                            <table width="100%" border="0" align="center">
                                <tr>
                                    <td width="55%"><strong>¿Practica algún tipo de disciplina de expresión corporal como hobbie o profesionalmente ?&nbsp;&nbsp;<span style="color:#FF0000; font-size:10px" >*</span></strong></td>
                                    <td width="10%">&nbsp;&nbsp;</td>
                                    <td><strong>Si</strong>&nbsp;&nbsp;<input type="radio" id="Si_ExpCorporal" name="ExpCorporal" onclick="Ver_ExpCorporal(); CambiaPersonal();" <?php echo $Danza_Si ?> <?php echo $ClassDisable ?>  />&nbsp;&nbsp;&nbsp;<strong>No</strong>&nbsp;&nbsp;<input type="radio" id="No_ExpCorporal" name="ExpCorporal" onclick="Ver_ExpCorporal(); CambiaPersonal();" <?php echo $Danza_No ?> <?php echo $ClassDisable ?> /></td>
                                    <td>&nbsp;&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4">&nbsp;<input type="hidden" id="NoDanza_id" />&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <div id="Div_ExpCorporal" style="width:100%;<?php echo $Ver_Danza ?>" align="center">
                                            <table width="50%" align="left" border="0">
        <?php
        /*
          1=Danza
          2=Danza Folclorica
          3=Danza Moderna
          4=Danza Contemporanea
          5=Ballet
          6=Otro
         */

        $SQL_Danza = 'SELECT 

															exprecioncorporal,
															tipoexprecioncorporal,
															frecuenciaexprecion,
															cualtipoexprecion
															
															FROM estudianteexprecioncorporal
															
															WHERE
															
															idestudiantegeneral="' . $id_Estudiante . '"
															AND
															codigoestado=100
															AND
															entrydate="' . $Max_Danza->fields['entrydate'] . '"
															AND
															tipoexprecioncorporal=1';

        if ($Danza = &$db->Execute($SQL_Danza) === false) {
            echo 'Error en el SQL Danza...<br>' . $SQL_Danza;
            die;
        }

        $Ver_DanzaG = 'style="visibility:collapse;"';

        if (!$Danza->EOF) {

            if ($Danza->fields['tipoexprecioncorporal'] == 1) {
                $Danza_Check = 'checked="checked"';
                $Ver_DanzaG = 'style="visibility:visible;"';
            }

            /*
              1=Básico
              2=Medio
              3=Avanzado
             */

            if ($Danza->fields['frecuenciaexprecion'] == 1) {
                $Danza_Frec_Uno = 'checked="checked"';
            }
            if ($Danza->fields['frecuenciaexprecion'] == 2) {
                $Danza_Frec_Dos = 'checked="checked"';
            }
            if ($Danza->fields['frecuenciaexprecion'] == 3) {
                $Danza_Frec_Tres = 'checked="checked"';
            }
        }
        ?>
                                                <tr>
                                                    <td><strong>* Danza</strong></td>
                                                    <td>&nbsp;<input type="hidden" id="Danza_id" />&nbsp;</td>
                                                    <td><input type="checkbox" id="Danza" name="Danzas" onclick="Ver_ExprecionCorporal(); DeleteExprecion('Danza', 'Danza_id')" <?php echo $Danza_Check ?> <?php echo $ClassDisable ?>  /></td>
                                                </tr>
                                                <tr id="Tr_Danza"  <?php echo $Ver_DanzaG ?>>
                                                    <td colspan="3">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Nivel de Conocimiento Danza</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- B&aacute;sico</strong></td>
                                                                    <td><input type="radio" id="Nv_Danza_Uno" name="Nivel_Danza" onclick="ModificarExprecion('Danza', 'Danza_id', '1')" <?php echo $Danza_Frec_Uno ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- Medio</strong></td>
                                                                    <td><input type="radio" id="Nv_Danza_Dos" name="Nivel_Danza" onclick="ModificarExprecion('Danza', 'Danza_id', '2')" <?php echo $Danza_Frec_Dos ?>  <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- Avanzado</strong></td>
                                                                    <td><input type="radio" id="Nv_Danza_Tres" name="Nivel_Danza" onclick="ModificarExprecion('Danza', 'Danza_id', '3')" <?php echo $Danza_Frec_Tres ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                                <?php
                                                /*
                                                  1=Danza
                                                  2=Danza Folclorica
                                                  3=Danza Moderna
                                                  4=Danza Contemporanea
                                                  5=Ballet
                                                  6=Otro
                                                 */

                                                $SQL_Danza = 'SELECT 

															exprecioncorporal,
															tipoexprecioncorporal,
															frecuenciaexprecion,
															cualtipoexprecion
															
															FROM estudianteexprecioncorporal
															
															WHERE
															
															idestudiantegeneral="' . $id_Estudiante . '"
															AND
															codigoestado=100
															AND
															entrydate="' . $Max_Danza->fields['entrydate'] . '"
															AND
															tipoexprecioncorporal=2';

                                                if ($Folclorica = &$db->Execute($SQL_Danza) === false) {
                                                    echo 'Error en el SQL Danza Folclorica...<br>' . $SQL_Danza;
                                                    die;
                                                }

                                                $Ver_Folclorica = 'style="visibility:collapse;"';

                                                if (!$Folclorica->EOF) {

                                                    if ($Folclorica->fields['tipoexprecioncorporal'] == 2) {
                                                        $Folclorica_Check = 'checked="checked"';
                                                        $Ver_Folclorica = 'style="visibility:visible;"';
                                                    }

                                                    /*
                                                      1=Básico
                                                      2=Medio
                                                      3=Avanzado
                                                     */

                                                    if ($Folclorica->fields['frecuenciaexprecion'] == 1) {
                                                        $Folclorica_Frec_Uno = 'checked="checked"';
                                                    }
                                                    if ($Folclorica->fields['frecuenciaexprecion'] == 2) {
                                                        $Folclorica_Frec_Dos = 'checked="checked"';
                                                    }
                                                    if ($Folclorica->fields['frecuenciaexprecion'] == 3) {
                                                        $Folclorica_Frec_Tres = 'checked="checked"';
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td><strong>* Danza Folclorica</strong></td>
                                                    <td>&nbsp;<input type="hidden" id="DzFloclorica_id" />&nbsp;</td>
                                                    <td><input type="checkbox" id="Danza_Floclorica" name="Danzas" onclick="Ver_ExprecionCorporal(); DeleteExprecion('Danza_Floclorica', 'DzFloclorica_id')" <?php echo $Folclorica_Check ?> <?php echo $ClassDisable ?> /></td>
                                                </tr>
                                                <tr id="Tr_Danza_Floclorica"  <?php echo $Ver_Folclorica ?>>
                                                    <td colspan="3">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Nivel de Conocimiento Danza Folclorica</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- B&aacute;sico</strong></td>
                                                                    <td><input type="radio" id="Nv_DzFol_Uno" name="Nivel_Danza_Floclorica" onclick="ModificarExprecion('Danza_Floclorica', 'DzFloclorica_id', '1')" <?php echo $Folclorica_Frec_Uno ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- Medio</strong></td>
                                                                    <td><input type="radio" id="Nv_DzFol_Dos" name="Nivel_Danza_Floclorica" onclick="ModificarExprecion('Danza_Floclorica', 'DzFloclorica_id', '2')" <?php echo $Folclorica_Frec_Dos ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- Avanzado</strong></td>
                                                                    <td><input type="radio" id="Nv_DzFol_Tres" name="Nivel_Danza_Floclorica" onclick="ModificarExprecion('Danza_Floclorica', 'DzFloclorica_id', '3')" <?php echo $Folclorica_Frec_Tres ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                                <?php
                                                /*
                                                  1=Danza
                                                  2=Danza Folclorica
                                                  3=Danza Moderna
                                                  4=Danza Contemporanea
                                                  5=Ballet
                                                  6=Otro
                                                 */

                                                $SQL_Danza = 'SELECT 

															exprecioncorporal,
															tipoexprecioncorporal,
															frecuenciaexprecion,
															cualtipoexprecion
															
															FROM estudianteexprecioncorporal
															
															WHERE
															
															idestudiantegeneral="' . $id_Estudiante . '"
															AND
															codigoestado=100
															AND
															entrydate="' . $Max_Danza->fields['entrydate'] . '"
															AND
															tipoexprecioncorporal=3';

                                                if ($Moderna = &$db->Execute($SQL_Danza) === false) {
                                                    echo 'Error en el SQL Danza Folclorica...<br>' . $SQL_Danza;
                                                    die;
                                                }

                                                $Ver_Moderna = 'style="visibility:collapse;"';

                                                if (!$Moderna->EOF) {

                                                    if ($Moderna->fields['tipoexprecioncorporal'] == 3) {
                                                        $Moderna_Check = 'checked="checked"';
                                                        $Ver_Moderna = 'style="visibility:visible;"';
                                                    }

                                                    /*
                                                      1=Básico
                                                      2=Medio
                                                      3=Avanzado
                                                     */

                                                    if ($Moderna->fields['frecuenciaexprecion'] == 1) {
                                                        $Moderna_Frec_Uno = 'checked="checked"';
                                                    }
                                                    if ($Moderna->fields['frecuenciaexprecion'] == 2) {
                                                        $Moderna_Frec_Dos = 'checked="checked"';
                                                    }
                                                    if ($Moderna->fields['frecuenciaexprecion'] == 3) {
                                                        $Moderna_Frec_Tres = 'checked="checked"';
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td><strong>* Danza Moderna</strong></td>
                                                    <td>&nbsp;<input type="hidden" id="DzModerna_id" />&nbsp;</td>
                                                    <td><input type="checkbox" id="Danza_Moderna" name="Danzas" onclick="Ver_ExprecionCorporal(); DeleteExprecion('Danza_Moderna', 'DzModerna_id')" <?php echo $Moderna_Check ?>  <?php echo $ClassDisable ?>/></td>
                                                </tr>
                                                <tr id="Tr_Danza_Moderna"  <?php echo $Ver_Moderna ?>>
                                                    <td colspan="3">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Nivel de Conocimiento Danza Moderna</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- B&aacute;sico</strong></td>
                                                                    <td><input type="radio" id="Nv_DzMod_Uno" name="Nivel_Danza_Moderna" onclick="ModificarExprecion('Danza_Moderna', 'DzModerna_id', '1')" <?php echo $Moderna_Frec_Uno ?>  <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- Medio</strong></td>
                                                                    <td><input type="radio" id="Nv_DzMod_Dos" name="Nivel_Danza_Moderna" onclick="ModificarExprecion('Danza_Moderna', 'DzModerna_id', '2')"  <?php echo $Moderna_Frec_Dos ?>  <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- Avanzado</strong></td>
                                                                    <td><input type="radio" id="Nv_DzMod_Tres" name="Nivel_Danza_Moderna" onclick="ModificarExprecion('Danza_Moderna', 'DzModerna_id', '3')" <?php echo $Moderna_Frec_Tres ?>  <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                                <?php
                                                /*
                                                  1=Danza
                                                  2=Danza Folclorica
                                                  3=Danza Moderna
                                                  4=Danza Contemporanea
                                                  5=Ballet
                                                  6=Otro
                                                 */

                                                $SQL_Danza = 'SELECT 

															exprecioncorporal,
															tipoexprecioncorporal,
															frecuenciaexprecion,
															cualtipoexprecion
															
															FROM estudianteexprecioncorporal
															
															WHERE
															
															idestudiantegeneral="' . $id_Estudiante . '"
															AND
															codigoestado=100
															AND
															entrydate="' . $Max_Danza->fields['entrydate'] . '"
															AND
															tipoexprecioncorporal=6';

                                                if ($Otra_Danza = &$db->Execute($SQL_Danza) === false) {
                                                    echo 'Error en el SQL Danza Otra_Danza...<br>' . $SQL_Danza;
                                                    die;
                                                }

                                                $Ver_Otra_Danza = 'style="visibility:collapse;"';

                                                if (!$Otra_Danza->EOF) {

                                                    if ($Otra_Danza->fields['tipoexprecioncorporal'] == 6) {
                                                        $Otra_Danza_Check = 'checked="checked"';
                                                        $Ver_Otra_Danza = 'style="visibility:visible;"';
                                                    }

                                                    /*
                                                      1=Básico
                                                      2=Medio
                                                      3=Avanzado
                                                     */

                                                    if ($Otra_Danza->fields['frecuenciaexprecion'] == 1) {
                                                        $Otra_Danza_Frec_Uno = 'checked="checked"';
                                                    }
                                                    if ($Otra_Danza->fields['frecuenciaexprecion'] == 2) {
                                                        $Otra_Danza_Frec_Dos = 'checked="checked"';
                                                    }
                                                    if ($Otra_Danza->fields['frecuenciaexprecion'] == 3) {
                                                        $Otra_Danza_Frec_Tres = 'checked="checked"';
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td><strong>* Otro</strong></td>
                                                    <td>&nbsp;<input type="hidden" id="DzOtra_id" />&nbsp;</td>
                                                    <td><input type="checkbox" id="Otra_Danza" name="Danzas" onclick="Ver_ExprecionCorporal(); DeleteExprecion('Otra_Danza', 'DzOtra_id')" <?php echo $Otra_Danza_Check ?> <?php echo $ClassDisable ?> /></td>
                                                </tr>
                                                <tr id="Tr_Otra_Danza" <?php echo $Ver_Otra_Danza ?>>
                                                    <td colspan="3">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Nivel de Conocimiento Otra Danza</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- B&aacute;sico</strong></td>
                                                                    <td><input type="radio" id="Nv_DzOtra_Uno" name="Nivel_Otra_Danza" onclick="ModificarExprecion('Otra_Danza', 'DzOtra_id', '1')" <?php echo $Otra_Danza_Frec_Uno ?>   <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- Medio</strong></td>
                                                                    <td><input type="radio" id="Nv_DzOtra_Dos" name="Nivel_Otra_Danza" onclick="ModificarExprecion('Otra_Danza', 'DzOtra_id', '2')" <?php echo $Otra_Danza_Frec_Dos ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- Avanzado</strong></td>
                                                                    <td><input type="radio" id="Nv_DzOtra_Tres" name="Nivel_Otra_Danza" onclick="ModificarExprecion('Otra_Danza', 'DzOtra_id', '3')" <?php echo $Otra_Danza_Frec_Tres ?>  <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                            </table>
                                            <table width="50%" align="right" border="0">
                                                <?php
                                                /*
                                                  1=Danza
                                                  2=Danza Folclorica
                                                  3=Danza Moderna
                                                  4=Danza Contemporanea
                                                  5=Ballet
                                                  6=Otro
                                                 */

                                                $SQL_Danza = 'SELECT 

															exprecioncorporal,
															tipoexprecioncorporal,
															frecuenciaexprecion,
															cualtipoexprecion
															
															FROM estudianteexprecioncorporal
															
															WHERE
															
															idestudiantegeneral="' . $id_Estudiante . '"
															AND
															codigoestado=100
															AND
															entrydate="' . $Max_Danza->fields['entrydate'] . '"
															AND
															tipoexprecioncorporal=4';

                                                if ($Contemporanea = &$db->Execute($SQL_Danza) === false) {
                                                    echo 'Error en el SQL Danza Contemporanea...<br>' . $SQL_Danza;
                                                    die;
                                                }

                                                $Ver_Contemporanea = 'style="visibility:collapse;"';

                                                if (!$Contemporanea->EOF) {

                                                    if ($Contemporanea->fields['tipoexprecioncorporal'] == 4) {
                                                        $Contemporanea_Check = 'checked="checked"';
                                                        $Ver_Contemporanea = 'style="visibility:visible;"';
                                                    }

                                                    /*
                                                      1=Básico
                                                      2=Medio
                                                      3=Avanzado
                                                     */

                                                    if ($Contemporanea->fields['frecuenciaexprecion'] == 1) {
                                                        $Contemporanea_Frec_Uno = 'checked="checked"';
                                                    }
                                                    if ($Contemporanea->fields['frecuenciaexprecion'] == 2) {
                                                        $Contemporanea_Frec_Dos = 'checked="checked"';
                                                    }
                                                    if ($Contemporanea->fields['frecuenciaexprecion'] == 3) {
                                                        $Contemporanea_Frec_Tres = 'checked="checked"';
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td><strong>* Danza Contemporanea</strong></td>
                                                    <td>&nbsp;<input type="hidden" id="DzContemporanea_id" />&nbsp;</td>
                                                    <td><input type="checkbox" id="Danza_Contemporanea" name="Danzas" onclick="Ver_ExprecionCorporal(); DeleteExprecion('Danza_Contemporanea', 'DzContemporanea_id')"  <?php echo $Contemporanea_Check ?> <?php echo $ClassDisable ?>/></td>
                                                </tr>
                                                <tr id="Tr_Danza_Contemporanea" <?php echo $Ver_Contemporanea ?>>
                                                    <td colspan="3">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Nivel de Conocimiento Danza Contemporanea</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- B&aacute;sico</strong></td>
                                                                    <td><input type="radio" id="Nv_DzCont_Uno" name="Nivel_Danza_Contemporanea" onclick="ModificarExprecion('Danza_Contemporanea', 'DzContemporanea_id', '1')" <?php echo $Contemporanea_Frec_Uno ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- Medio</strong></td>
                                                                    <td><input type="radio" id="Nv_DzCont_Dos" name="Nivel_Danza_Contemporanea" onclick="ModificarExprecion('Danza_Contemporanea', 'DzContemporanea_id', '2')" <?php echo $Contemporanea_Frec_Dos ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- Avanzado</strong></td>
                                                                    <td><input type="radio" id="Nv_DzCont_Tres" name="Nivel_Danza_Contemporanea" onclick="ModificarExprecion('Danza_Contemporanea', 'DzContemporanea_id', '3')" <?php echo $Contemporanea_Frec_Tres ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                                <?php
                                                /*
                                                  1=Danza
                                                  2=Danza Folclorica
                                                  3=Danza Moderna
                                                  4=Danza Contemporanea
                                                  5=Ballet
                                                  6=Otro
                                                 */

                                                $SQL_Danza = 'SELECT 

															exprecioncorporal,
															tipoexprecioncorporal,
															frecuenciaexprecion,
															cualtipoexprecion
															
															FROM estudianteexprecioncorporal
															
															WHERE
															
															idestudiantegeneral="' . $id_Estudiante . '"
															AND
															codigoestado=100
															AND
															entrydate="' . $Max_Danza->fields['entrydate'] . '"
															AND
															tipoexprecioncorporal=5';

                                                if ($Ballet = &$db->Execute($SQL_Danza) === false) {
                                                    echo 'Error en el SQL Danza Ballet...<br>' . $SQL_Danza;
                                                    die;
                                                }

                                                $Ver_Ballet = 'style="visibility:collapse;"';

                                                if (!$Ballet->EOF) {

                                                    if ($Ballet->fields['tipoexprecioncorporal'] == 5) {
                                                        $Ballet_Check = 'checked="checked"';
                                                        $Ver_Ballet = 'style="visibility:visible;"';
                                                    }

                                                    /*
                                                      1=Básico
                                                      2=Medio
                                                      3=Avanzado
                                                     */

                                                    if ($Ballet->fields['frecuenciaexprecion'] == 1) {
                                                        $Ballet_Frec_Uno = 'checked="checked"';
                                                    }
                                                    if ($Ballet->fields['frecuenciaexprecion'] == 2) {
                                                        $Ballet_Frec_Dos = 'checked="checked"';
                                                    }
                                                    if ($Ballet->fields['frecuenciaexprecion'] == 3) {
                                                        $Ballet_Frec_Tres = 'checked="checked"';
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td><strong>* Ballet </strong></td>
                                                    <td>&nbsp;<input type="hidden" id="DzBallet_id" />&nbsp;</td>
                                                    <td><input type="checkbox" id="Ballet" name="Danzas" onclick="Ver_ExprecionCorporal(); DeleteExprecion('Ballet', 'DzBallet_id')" <?php echo $Ballet_Check ?>  <?php echo $ClassDisable ?>/></td>
                                                </tr>
                                                <tr id="Tr_Ballet" <?php echo $Ver_Ballet ?>>
                                                    <td colspan="3">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Nivel de Conocimiento Ballet</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- B&aacute;sico</strong></td>
                                                                    <td><input type="radio" id="Nv_Ballet_Uno" name="Nivel_Ballet" onclick="ModificarExprecion('Ballet', 'DzBallet_id', '1')" <?php echo $Ballet_Frec_Uno ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- Medio</strong></td>
                                                                    <td><input type="radio" id="Nv_Ballet_Dos" name="Nivel_Ballet" onclick="ModificarExprecion('Ballet', 'DzBallet_id', '2')" <?php echo $Ballet_Frec_Dos ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- Avanzado</strong></td>
                                                                    <td><input type="radio" id="Nv_Ballet_Tres" name="Nivel_Ballet" onclick="ModificarExprecion('Ballet', 'DzBallet_id', '3')" <?php echo $Ballet_Frec_Tres ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">&nbsp;&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>* ¿Cuál ?</strong></td>
                                                    <td>&nbsp;&nbsp;</td>
                                                    <td><input type="text" id="Cual_Danzas" name="Cual_Danzas" class="CajasHoja" value="<?php echo $Otra_Danza->fields['cualtipoexprecion'] ?>" <?php echo $ClassDisable ?> /></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">&nbsp;&nbsp;</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                                                <?php
                                                $SQL_Max_Arte = 'SELECT 
										
										MAX(idestudiantesartesescenicas) AS id 
										
										FROM estudianteartesescenicas
										
										WHERE
										
										idestudiantegeneral="' . $id_Estudiante . '"
										AND
										codigoestado=100';

                                                if ($Max_Arte = &$db->Execute($SQL_Max_Arte) === false) {
                                                    echo 'Error en el SQL del Max Arte ....<br>' . $SQL_Max_Arte;
                                                    die;
                                                }

                                                $SQL_Hora_Arte = 'SELECT 

										artesescenicas,
										entrydate
										
										FROM estudianteartesescenicas
										
										WHERE
										
										idestudiantegeneral="' . $id_Estudiante . '"
										AND
										codigoestado=100
										AND
										idestudiantesartesescenicas="' . $Max_Arte->fields['id'] . '"';

                                                if ($Hora_Arte = &$db->Execute($SQL_Hora_Arte) === false) {
                                                    echo 'Error en el SQl del la Hora del Arte......<br>' . $SQL_Hora_Arte;
                                                    die;
                                                }

                                                $Ver_Arte = 'display:none';

                                                if (!$Hora_Arte->EOF) {

                                                    if ($Hora_Arte->fields['artesescenicas'] == 0) {
                                                        $Check_Arte_Si = 'checked="checked"';
                                                        $Ver_Arte = 'display:inline';
                                                    }

                                                    if ($Hora_Arte->fields['artesescenicas'] == 1) {
                                                        $Check_Arte_No = 'checked="checked"';
                                                        $Ver_Arte = 'display:none';
                                                    }
                                                }
                                                ?>
                    <tr>
                        <td>
                            <table width="100%" align="center" border="0">
                                <tr>
                                    <td width="55%"><strong>¿Practica usted algún tipo de artes escénicas como hobbie o profesionalmente ?  &nbsp;&nbsp;<span style="color:#FF0000; font-size:10px" >*</span></strong></td>
                                    <td width="10%">&nbsp;&nbsp;</td>
                                    <td><strong>Si</strong>&nbsp;&nbsp;<input type="radio" id="Si_Arte" name="Arte_Escenico" onclick="Ver_arteEscenico(); CambiaPersonal();" <?php echo $Check_Arte_Si ?> <?php echo $ClassDisable ?> />&nbsp;&nbsp;&nbsp;<strong>No</strong>&nbsp;&nbsp;<input type="radio" id="No_Arte" name="Arte_Escenico" onclick="Ver_arteEscenico(); CambiaPersonal();" <?php echo $Check_Arte_No ?> <?php echo $ClassDisable ?>/></td>
                                    <td>&nbsp;&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4">&nbsp;<input type="hidden" id="NoEscenica_id" />&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <div id="Div_ArteEscenico" style="width:100%;<?php echo $Ver_Arte ?>" align="center">
                                            <table align="center" width="60%" border="0">
        <?php
        /*
          1=Teatro
          2=Actuación
          3=Narración Oral
          4= Stand Up Comedy
          5=otro
         */


        $SQL_Arte = 'SELECT 

																artesescenicas,
																tipoarteescenica,
																frecuanciaescenica,
																escenicacual
																
																FROM estudianteartesescenicas
																
																WHERE
																
																idestudiantegeneral="' . $id_Estudiante . '"
																AND
																codigoestado=100
																AND
																entrydate="' . $Hora_Arte->fields['entrydate'] . '"
																AND
																tipoarteescenica=1';

        if ($Teatro = &$db->Execute($SQL_Arte) === false) {
            echo 'Error en el SQL del Arte Teatro...........<br>' . $SQL_Arte;
            die;
        }

        $Ver_Teatro = 'style="visibility:collapse;"';

        if (!$Teatro->EOF) {

            if ($Teatro->fields['tipoarteescenica'] == 1) {
                $Teatro_Check = 'checked="checked"';
                $Ver_Teatro = 'style="visibility:visible;"';
            }

            /*
              1=Basico
              2=Medio
              3=Avanzado
             */

            if ($Teatro->fields['frecuanciaescenica'] == 1) {
                $Teatro_Fre_Uno = 'checked="checked"';
            }
            if ($Teatro->fields['frecuanciaescenica'] == 2) {
                $Teatro_Fre_Dos = 'checked="checked"';
            }
            if ($Teatro->fields['frecuanciaescenica'] == 3) {
                $Teatro_Fre_Tres = 'checked="checked"';
            }
        }
        ?>
                                                <tr>
                                                    <td><strong>* Teatro</strong></td>
                                                    <td>&nbsp;&nbsp;</td>
                                                    <td><input type="checkbox" id="Teatro" name="Tipos_Arte" onclick="Ver_ArteEscenicas(); DeleteEscenica('Teatro', 'Teatro_id')" <?php echo $Teatro_Check ?> <?php echo $ClassDisable ?> /></td>
                                                    <td colspan="4">&nbsp;<input type="hidden" id="Teatro_id" />&nbsp;</td>
                                                </tr>
                                                <tr id="Tr_Teatro"  <?php echo $Ver_Teatro ?>>
                                                    <td colspan="7">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Nivel de Conocimiento en Teatro</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- B&aacute;sico</strong></td>
                                                                    <td><input type="radio" id="Nv_Teatro_Uno" name="Nivel_Teatro" onclick="ModificarEscenica('Teatro', 'Teatro_id', '1')" <?php echo $Teatro_Fre_Uno ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- Medio</strong></td>
                                                                    <td><input type="radio" id="Nv_Teatro_Dos" name="Nivel_Teatro" onclick="ModificarEscenica('Teatro', 'Teatro_id', '2')" <?php echo $Teatro_Fre_Dos ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- Avanzado</strong></td>
                                                                    <td><input type="radio" id="Nv_Teatro_Tres" name="Nivel_Teatro" onclick="ModificarEscenica('Teatro', 'Teatro_id', '3')" <?php echo $Teatro_Fre_Tres ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                                <?php
                                                /*
                                                  1=Teatro
                                                  2=Actuación
                                                  3=Narración Oral
                                                  4= Stand Up Comedy
                                                  5=otro
                                                 */


                                                $SQL_Arte = 'SELECT 

																artesescenicas,
																tipoarteescenica,
																frecuanciaescenica,
																escenicacual
																
																FROM estudianteartesescenicas
																
																WHERE
																
																idestudiantegeneral="' . $id_Estudiante . '"
																AND
																codigoestado=100
																AND
																entrydate="' . $Hora_Arte->fields['entrydate'] . '"
																AND
																tipoarteescenica=2';

                                                if ($Actuacion = &$db->Execute($SQL_Arte) === false) {
                                                    echo 'Error en el SQL del Arte Actuacion...........<br>' . $SQL_Arte;
                                                    die;
                                                }

                                                $Ver_Actuacion = 'style="visibility:collapse;"';

                                                if (!$Actuacion->EOF) {

                                                    if ($Actuacion->fields['tipoarteescenica'] == 2) {
                                                        $Actuacion_Check = 'checked="checked"';
                                                        $Ver_Actuacion = 'style="visibility:visible;"';
                                                    }

                                                    /*
                                                      1=Basico
                                                      2=Medio
                                                      3=Avanzado
                                                     */

                                                    if ($Actuacion->fields['frecuanciaescenica'] == 1) {
                                                        $Actuacion_Fre_Uno = 'checked="checked"';
                                                    }
                                                    if ($Actuacion->fields['frecuanciaescenica'] == 2) {
                                                        $Actuacion_Fre_Dos = 'checked="checked"';
                                                    }
                                                    if ($Actuacion->fields['frecuanciaescenica'] == 3) {
                                                        $Actuacion_Fre_Tres = 'checked="checked"';
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td><strong>* Actuaci&oacute;n</strong></td>
                                                    <td>&nbsp;&nbsp;</td>
                                                    <td><input type="checkbox" id="actuacion" name="Tipos_Arte" onclick="Ver_ArteEscenicas(); DeleteEscenica('actuacion', 'Actuacion_id')" <?php echo $Actuacion_Check ?> <?php echo $ClassDisable ?> /></td>
                                                    <td colspan="4">&nbsp;<input type="hidden" id="Actuacion_id" />&nbsp;</td>
                                                </tr>
                                                <tr id="Tr_actuacion"  <?php echo $Ver_Actuacion ?>>
                                                    <td colspan="7">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Nivel de Conocimiento en Actuaci&oacute;n</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- B&aacute;sico</strong></td>
                                                                    <td><input type="radio" id="Nv_Actua_Uno" name="Nivel_actuacion" onclick="ModificarEscenica('actuacion', 'Actuacion_id', '1')"  <?php echo $Actuacion_Fre_Uno ?>  <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- Medio</strong></td>
                                                                    <td><input type="radio" id="Nv_Actua_Dos" name="Nivel_actuacion" onclick="ModificarEscenica('actuacion', 'Actuacion_id', '2')" <?php echo $Actuacion_Fre_Dos ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- Avanzado</strong></td>
                                                                    <td><input type="radio" id="Nv_Actua_Tres" name="Nivel_actuacion" onclick="ModificarEscenica('actuacion', 'Actuacion_id', '3')" <?php echo $Actuacion_Fre_Tres ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                                <?php
                                                /*
                                                  1=Teatro
                                                  2=Actuación
                                                  3=Narración Oral
                                                  4= Stand Up Comedy
                                                  5=otro
                                                 */


                                                $SQL_Arte = 'SELECT 

																artesescenicas,
																tipoarteescenica,
																frecuanciaescenica,
																escenicacual
																
																FROM estudianteartesescenicas
																
																WHERE
																
																idestudiantegeneral="' . $id_Estudiante . '"
																AND
																codigoestado=100
																AND
																entrydate="' . $Hora_Arte->fields['entrydate'] . '"
																AND
																tipoarteescenica=3';

                                                if ($Narracion = &$db->Execute($SQL_Arte) === false) {
                                                    echo 'Error en el SQL del Arte Narracion...........<br>' . $SQL_Arte;
                                                    die;
                                                }

                                                $Ver_Narracion = 'style="visibility:collapse;"';

                                                if (!$Narracion->EOF) {

                                                    if ($Narracion->fields['tipoarteescenica'] == 3) {
                                                        $Narracion_Check = 'checked="checked"';
                                                        $Ver_Narracion = 'style="visibility:visible;"';
                                                    }

                                                    /*
                                                      1=Basico
                                                      2=Medio
                                                      3=Avanzado
                                                     */

                                                    if ($Narracion->fields['frecuanciaescenica'] == 1) {
                                                        $Narracion_Fre_Uno = 'checked="checked"';
                                                    }
                                                    if ($Narracion->fields['frecuanciaescenica'] == 2) {
                                                        $Narracion_Fre_Dos = 'checked="checked"';
                                                    }
                                                    if ($Narracion->fields['frecuanciaescenica'] == 3) {
                                                        $Narracion_Fre_Tres = 'checked="checked"';
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td><strong>* Narraci&oacute;n Oral</strong></td>
                                                    <td>&nbsp;&nbsp;</td>
                                                    <td><input type="checkbox" id="narracion" name="Tipos_Arte" onclick="Ver_ArteEscenicas(); DeleteEscenica('narracion', 'Narracion_id')" <?php echo $Narracion_Check ?>  <?php echo $ClassDisable ?>  /></td>
                                                    <td colspan="4">&nbsp;<input type="hidden" id="Narracion_id" />&nbsp;</td>
                                                </tr>
                                                <tr id="Tr_narracion"  <?php echo $Ver_Narracion ?>>
                                                    <td colspan="7">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Nivel de Conocimiento en Narraci&oacute;n Oral</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- B&aacute;sico</strong></td>
                                                                    <td><input type="radio" id="Nv_Narra_Uno" name="Nivel_narracion" onclick="ModificarEscenica('narracion', 'Narracion_id', '1')" <?php echo $Narracion_Fre_Uno ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- Medio</strong></td>
                                                                    <td><input type="radio" id="Nv_Narra_Dos" name="Nivel_narracion" onclick="ModificarEscenica('narracion', 'Narracion_id', '2')" <?php echo $Narracion_Fre_Dos ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- Avanzado</strong></td>
                                                                    <td><input type="radio" id="Nv_Narra_Tres" name="Nivel_narracion" onclick="ModificarEscenica('narracion', 'Narracion_id', '3')" <?php echo $Narracion_Fre_Tres ?>  <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                                <?php
                                                /*
                                                  1=Teatro
                                                  2=Actuación
                                                  3=Narración Oral
                                                  4= Stand Up Comedy
                                                  5=otro
                                                 */


                                                $SQL_Arte = 'SELECT 

																artesescenicas,
																tipoarteescenica,
																frecuanciaescenica,
																escenicacual
																
																FROM estudianteartesescenicas
																
																WHERE
																
																idestudiantegeneral="' . $id_Estudiante . '"
																AND
																codigoestado=100
																AND
																entrydate="' . $Hora_Arte->fields['entrydate'] . '"
																AND
																tipoarteescenica=4';

                                                if ($Stand = &$db->Execute($SQL_Arte) === false) {
                                                    echo 'Error en el SQL del Arte Stand Up Comedy...........<br>' . $SQL_Arte;
                                                    die;
                                                }

                                                $Ver_Stand = 'style="visibility:collapse;"';

                                                if (!$Stand->EOF) {

                                                    if ($Stand->fields['tipoarteescenica'] == 4) {
                                                        $Stand_Check = 'checked="checked"';
                                                        $Ver_Stand = 'style="visibility:visible;"';
                                                    }

                                                    /*
                                                      1=Basico
                                                      2=Medio
                                                      3=Avanzado
                                                     */

                                                    if ($Stand->fields['frecuanciaescenica'] == 1) {
                                                        $Stand_Fre_Uno = 'checked="checked"';
                                                    }
                                                    if ($Stand->fields['frecuanciaescenica'] == 2) {
                                                        $Stand_Fre_Dos = 'checked="checked"';
                                                    }
                                                    if ($Stand->fields['frecuanciaescenica'] == 3) {
                                                        $Stand_Fre_Tres = 'checked="checked"';
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td><strong>* Stand Up Comedy</strong></td>
                                                    <td>&nbsp;&nbsp;</td>
                                                    <td><input type="checkbox" id="standcomedy" name="Tipos_Arte" onclick="Ver_ArteEscenicas(); DeleteEscenica('standcomedy', 'Standcomedy_id')" <?php echo $Stand_Check ?> <?php echo $ClassDisable ?> /></td>
                                                    <td colspan="4">&nbsp;<input type="hidden" id="Standcomedy_id" />&nbsp;</td>
                                                </tr>
                                                <tr id="Tr_standcomedy"  <?php echo $Ver_Stand ?>>
                                                    <td colspan="7">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Nivel de Conocimiento en Stand Up Comedy</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- B&aacute;sico</strong></td>
                                                                    <td><input type="radio" id="Nv_Stand_Uno" name="Nivel_standcomedy" onclick="ModificarEscenica('standcomedy', 'Standcomedy_id', '1')" <?php echo $Stand_Fre_Uno ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- Medio</strong></td>
                                                                    <td><input type="radio" id="Nv_Stand_Dos" name="Nivel_standcomedy" onclick="ModificarEscenica('standcomedy', 'Standcomedy_id', '2')" <?php echo $Stand_Fre_Dos ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- Avanzado</strong></td>
                                                                    <td><input type="radio" id="Nv_Stand_Tres" name="Nivel_standcomedy" onclick="ModificarEscenica('standcomedy', 'Standcomedy_id', '3')" <?php echo $Stand_Fre_Tres ?>  <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                                <?php
                                                /*
                                                  1=Teatro
                                                  2=Actuación
                                                  3=Narración Oral
                                                  4= Stand Up Comedy
                                                  5=otro
                                                 */


                                                $SQL_Arte = 'SELECT 

																artesescenicas,
																tipoarteescenica,
																frecuanciaescenica,
																escenicacual
																
																FROM estudianteartesescenicas
																
																WHERE
																
																idestudiantegeneral="' . $id_Estudiante . '"
																AND
																codigoestado=100
																AND
																entrydate="' . $Hora_Arte->fields['entrydate'] . '"
																AND
																tipoarteescenica=5';

                                                if ($Otro_Arte = &$db->Execute($SQL_Arte) === false) {
                                                    echo 'Error en el SQL del Arte Otro_Arte...........<br>' . $SQL_Arte;
                                                    die;
                                                }

                                                $Ver_Otro_Arte = 'style="visibility:collapse;"';

                                                if (!$Otro_Arte->EOF) {

                                                    if ($Otro_Arte->fields['tipoarteescenica'] == 4) {
                                                        $Otro_Arte_Check = 'checked="checked"';
                                                        $Ver_Otro_Arte = 'style="visibility:visible;"';
                                                    }

                                                    /*
                                                      1=Basico
                                                      2=Medio
                                                      3=Avanzado
                                                     */

                                                    if ($Otro_Arte->fields['frecuanciaescenica'] == 1) {
                                                        $Otro_Arte_Fre_Uno = 'checked="checked"';
                                                    }
                                                    if ($Otro_Arte->fields['frecuanciaescenica'] == 2) {
                                                        $Otro_Arte_Fre_Dos = 'checked="checked"';
                                                    }
                                                    if ($Otro_Arte->fields['frecuanciaescenica'] == 3) {
                                                        $Otro_Arte_Fre_Tres = 'checked="checked"';
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td><strong>* Otro</strong></td>
                                                    <td>&nbsp;<input type="hidden" id="OtroArte_id" />&nbsp;</td>
                                                    <td><input type="checkbox" id="Otro_arte" name="Tipos_Arte" onclick="Ver_ArteEscenicas(); DeleteEscenica('Otro_arte', 'OtroArte_id')" <?php echo $Otro_Arte_Check ?> <?php echo $ClassDisable ?> /></td>
                                                    <td>&nbsp;&nbsp;</td>
                                                    <td><strong>¿Cuál ?</strong></td>
                                                    <td>&nbsp;&nbsp;</td>
                                                    <td><input type="text" id="Cual_arte" name="Cual_arte" class="CajasHoja" value="<?php echo $Otro_Arte->fields['escenicacual'] ?>" <?php echo $ClassDisable ?> /></td>
                                                </tr>
                                                <tr id="Tr_Otro_arte"  <?php echo $Ver_Otro_Arte ?>>
                                                    <td colspan="7">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Nivel de Conocimiento en Otro Arte Escenico</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- B&aacute;sico</strong></td>
                                                                    <td><input type="radio" id="Nv_OtroEscen_Uno" name="Nivel_Otro_arte" onclick="ModificarEscenica('Otro_arte', 'OtroArte_id', '1')" <?php echo $Otro_Arte_Fre_Uno ?>  <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>   
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- Medio</strong></td>
                                                                    <td><input type="radio" id="Nv_OtroEscen_Dos" name="Nivel_Otro_arte" onclick="ModificarEscenica('Otro_arte', 'OtroArte_id', '2')" <?php echo $Otro_Arte_Fre_Dos ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- Avanzado</strong></td>
                                                                    <td><input type="radio" id="Nv_OtroEscen_Tres" name="Nivel_Otro_arte" onclick="ModificarEscenica('Otro_arte', 'OtroArte_id', '3')" <?php echo $Otro_Arte_Fre_Tres ?>  <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                                                <?php
                                                $SQL_Max_Literaria = 'SELECT 

											MAX(idestudiantearteliterario) AS id 
											
											FROM estudiantearteliterario
											
											WHERE
											
											idestudiantegeneral="' . $id_Estudiante . '"
											AND
											codigoestado=100';

                                                if ($Max_Literario = &$db->Execute($SQL_Max_Literaria) === false) {
                                                    echo 'Error en el SQL Arte Literario......<br>' . $SQL_Max_Literaria;
                                                    die;
                                                }

                                                $SQL_Hora_Literario = 'SELECT 
											
											arteliterario,
											entrydate
											
											FROM estudiantearteliterario
											
											WHERE
											
											idestudiantegeneral="' . $id_Estudiante . '"
											AND
											codigoestado=100
											AND
											idestudiantearteliterario="' . $Max_Literario->fields['id'] . '"';

                                                if ($Hora_Literario = &$db->Execute($SQL_Hora_Literario) === false) {
                                                    echo 'Error en el SQL Hora Litrerario...<br>' . $SQL_Hora_Literario;
                                                    die;
                                                }

                                                $Ver_Literario = 'display:none';

                                                if (!$Hora_Literario->EOF) {

                                                    if ($Hora_Literario->fields['arteliterario'] == 0) {
                                                        $Literario_Check_Si = 'checked="checked"';
                                                        $Ver_Literario = 'display:inline';
                                                    }

                                                    if ($Hora_Literario->fields['arteliterario'] == 1) {
                                                        $Literario_Check_No = 'checked="checked"';
                                                        $Ver_Literario = 'display:none';
                                                    }
                                                }
                                                ?>
                    <tr>
                        <td>
                            <table width="100%" align="center" border="0">
                                <tr>
                                    <td width="55%"><strong>¿Desarrolla algún tipo de actividad literaria como hobbie o profesionalmente ?&nbsp;&nbsp;<span style="color:#FF0000; font-size:10px" >*</span></strong></td>
                                    <td width="10%">&nbsp;&nbsp;</td>
                                    <td><strong>Si</strong>&nbsp;&nbsp;<input type="radio" id="Si_Literaria" name="Literaria" onclick="Ver_arteLiteraria(); CambiaPersonal();" <?php echo $Literario_Check_Si ?> <?php echo $ClassDisable ?> />&nbsp;&nbsp;&nbsp;<strong>No</strong>&nbsp;&nbsp;<input type="radio" id="No_Literaria" name="Literaria" onclick="Ver_arteLiteraria(); CambiaPersonal();" <?php echo $Literario_Check_No ?> <?php echo $ClassDisable ?> /></td>
                                    <td>&nbsp;&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4">&nbsp;<input type="hidden" id="NoLirica_id" />&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <div align="center" style="width:100%;<?php echo $Ver_Literario ?>" id="Div_literatura">
                                            <table width="60%" align="center" border="0">
        <?php
        /*
          1=Poesia
          2=Cuento
          3=Novela
          4=Crónica
          5=Otro
         */

        $SQL_Literario = 'SELECT 

																arteliterario,
																tipoarteliterario,
																frecuencialiteraria,
																cualarteliterario
																
																FROM estudiantearteliterario
																
																WHERE
																
																idestudiantegeneral="' . $id_Estudiante . '"
																AND
																codigoestado=100
																AND
																entrydate="' . $Hora_Literario->fields['entrydate'] . '"
																AND
																tipoarteliterario=1';

        if ($Poesia = &$db->Execute($SQL_Literario) === false) {
            echo 'Error en el sql del arte Literario Poesia......<br>' . $SQL_Literario;
            die;
        }

        $Ver_Poesia = 'style="visibility:collapse;"';

        if (!$Poesia->EOF) {

            if ($Poesia->fields['tipoarteliterario'] == 1) {

                $Poesia_Check = 'checked="checked"';
                $Ver_Poesia = 'style="visibility:visible;"';
            }

            /*
              1=Basico
              2=Medio
              3=Avanzado
             */

            if ($Poesia->fields['frecuencialiteraria'] == 1) {
                $Poesia_Fre_Uno = 'checked="checked"';
            }
            if ($Poesia->fields['frecuencialiteraria'] == 2) {
                $Poesia_Fre_Dos = 'checked="checked"';
            }
            if ($Poesia->fields['frecuencialiteraria'] == 3) {
                $Poesia_Fre_Tres = 'checked="checked"';
            }
        }
        ?>
                                                <tr>
                                                    <td><strong>* Poesia</strong></td>
                                                    <td>&nbsp;&nbsp;</td>
                                                    <td><input type="checkbox" id="poesia" name="Tipo_Literatura" onclick="Ver_ArteLiterario(); DeleteLirico('poesia', 'poesia_id')" <?php echo $Poesia_Check ?> <?php echo $ClassDisable ?> /></td>
                                                    <td colspan="3">&nbsp;<input type="hidden" id="poesia_id" />&nbsp;</td>
                                                </tr>
                                                <tr id="Tr_poesia"  <?php echo $Ver_Poesia ?>>
                                                    <td colspan="7">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Nivel de Conocimiento en Poesia</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- B&aacute;sico</strong></td>
                                                                    <td><input type="radio" id="Nv_poesia_Uno" name="Nivel_poesia" onclick="ModificaLirico('poesia', 'poesia_id', '1')" <?php echo $Poesia_Fre_Uno ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- Medio</strong></td>
                                                                    <td><input type="radio" id="Nv_poesia_Dos" name="Nivel_poesia" onclick="ModificaLirico('poesia', 'poesia_id', '2')" <?php echo $Poesia_Fre_Dos ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- Avanzado</strong></td>
                                                                    <td><input type="radio" id="Nv_poesia_Tres" name="Nivel_poesia" onclick="ModificaLirico('poesia', 'poesia_id', '3')" <?php echo $Poesia_Fre_Tres ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
        <?php
        /*
          1=Poesia
          2=Cuento
          3=Novela
          4=Crónica
          5=Otro
         */

        $SQL_Literario = 'SELECT 

																arteliterario,
																tipoarteliterario,
																frecuencialiteraria,
																cualarteliterario
																
																FROM estudiantearteliterario
																
																WHERE
																
																idestudiantegeneral="' . $id_Estudiante . '"
																AND
																codigoestado=100
																AND
																entrydate="' . $Hora_Literario->fields['entrydate'] . '"
																AND
																tipoarteliterario=2';

        if ($Cuento = &$db->Execute($SQL_Literario) === false) {
            echo 'Error en el sql del arte Literario Cuento......<br>' . $SQL_Literario;
            die;
        }

        $Ver_Cuento = 'style="visibility:collapse;"';

        if (!$Cuento->EOF) {

            if ($Cuento->fields['tipoarteliterario'] == 2) {

                $Cuento_Check = 'checked="checked"';
                $Ver_Cuento = 'style="visibility:visible;"';
            }

            /*
              1=Basico
              2=Medio
              3=Avanzado
             */

            if ($Cuento->fields['frecuencialiteraria'] == 1) {
                $Cuento_Fre_Uno = 'checked="checked"';
            }
            if ($Cuento->fields['frecuencialiteraria'] == 2) {
                $Cuento_Fre_Dos = 'checked="checked"';
            }
            if ($Cuento->fields['frecuencialiteraria'] == 3) {
                $Cuento_Fre_Tres = 'checked="checked"';
            }
        }
        ?>
                                                <tr>
                                                    <td><strong>* Cuento</strong></td>
                                                    <td>&nbsp;&nbsp;</td>
                                                    <td><input type="checkbox" id="cuento" name="Tipo_Literatura" onclick="Ver_ArteLiterario(); DeleteLirico('cuento', 'cuento_id')" <?php echo $Cuento_Check ?> <?php echo $ClassDisable ?> /></td>
                                                    <td colspan="3">&nbsp;<input type="hidden" id="cuento_id" />&nbsp;</td>
                                                </tr>
                                                <tr id="Tr_cuento" <?php echo $Ver_Cuento ?>>
                                                    <td colspan="7">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Nivel de Conocimiento en Cuento</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- B&aacute;sico</strong></td>
                                                                    <td><input type="radio" id="Nv_cuento_Uno" name="Nivel_cuento" onclick="ModificaLirico('cuento', 'cuento_id', '1')" <?php echo $Cuento_Fre_Uno ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- Medio</strong></td>
                                                                    <td><input type="radio" id="Nv_cuento_Dos" name="Nivel_cuento" onclick="ModificaLirico('cuento', 'cuento_id', '2')" <?php echo $Cuento_Fre_Dos ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- Avanzado</strong></td>
                                                                    <td><input type="radio" id="Nv_cuento_Tres" name="Nivel_cuento" onclick="ModificaLirico('cuento', 'cuento_id', '3')" <?php echo $Cuento_Fre_Tres ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
        <?php
        /*
          1=Poesia
          2=Cuento
          3=Novela
          4=Crónica
          5=Otro
         */

        $SQL_Literario = 'SELECT 

																arteliterario,
																tipoarteliterario,
																frecuencialiteraria,
																cualarteliterario
																
																FROM estudiantearteliterario
																
																WHERE
																
																idestudiantegeneral="' . $id_Estudiante . '"
																AND
																codigoestado=100
																AND
																entrydate="' . $Hora_Literario->fields['entrydate'] . '"
																AND
																tipoarteliterario=3';

        if ($Novela = &$db->Execute($SQL_Literario) === false) {
            echo 'Error en el sql del arte Literario Novela......<br>' . $SQL_Literario;
            die;
        }

        $Ver_Novela = 'style="visibility:collapse;"';

        if (!$Novela->EOF) {

            if ($Novela->fields['tipoarteliterario'] == 3) {

                $Novela_Check = 'checked="checked"';
                $Ver_Novela = 'style="visibility:visible;"';
            }

            /*
              1=Basico
              2=Medio
              3=Avanzado
             */

            if ($Novela->fields['frecuencialiteraria'] == 1) {
                $Novela_Fre_Uno = 'checked="checked"';
            }
            if ($Novela->fields['frecuencialiteraria'] == 2) {
                $Novela_Fre_Dos = 'checked="checked"';
            }
            if ($Novela->fields['frecuencialiteraria'] == 3) {
                $Novela_Fre_Tres = 'checked="checked"';
            }
        }
        ?>
                                                <tr>
                                                    <td><strong>* Novela</strong></td>
                                                    <td>&nbsp;&nbsp;</td>
                                                    <td><input type="checkbox" id="novela" name="Tipo_Literatura" onclick="Ver_ArteLiterario(); DeleteLirico('novela', 'novela_id')" <?php echo $Novela_Check ?>  <?php echo $ClassDisable ?>/></td>
                                                    <td colspan="3">&nbsp;<input type="hidden" id="novela_id" />&nbsp;</td>
                                                </tr>
                                                <tr id="Tr_novela" <?php echo $Ver_Novela ?>>
                                                    <td colspan="7">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Nivel de Conocimiento en Novela</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- B&aacute;sico</strong></td>
                                                                    <td><input type="radio" id="Nv_novela_Uno" name="Nivel_novela" onclick="ModificaLirico('novela', 'novela_id', '1')" <?php echo $Novela_Fre_Uno ?>  <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- Medio</strong></td>
                                                                    <td><input type="radio" id="Nv_novela_Dos" name="Nivel_novela" onclick="ModificaLirico('novela', 'novela_id', '2')" <?php echo $Novela_Fre_Dos ?>  <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- Avanzado</strong></td>
                                                                    <td><input type="radio" id="Nv_novela_Tres" name="Nivel_novela" onclick="ModificaLirico('novela', 'novela_id', '3')" <?php echo $Novela_Fre_Tres ?>  <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
        <?php
        /*
          1=Poesia
          2=Cuento
          3=Novela
          4=Crónica
          5=Otro
         */

        $SQL_Literario = 'SELECT 

																arteliterario,
																tipoarteliterario,
																frecuencialiteraria,
																cualarteliterario
																
																FROM estudiantearteliterario
																
																WHERE
																
																idestudiantegeneral="' . $id_Estudiante . '"
																AND
																codigoestado=100
																AND
																entrydate="' . $Hora_Literario->fields['entrydate'] . '"
																AND
																tipoarteliterario=4';

        if ($Cronica = &$db->Execute($SQL_Literario) === false) {
            echo 'Error en el sql del arte Literario Cronica......<br>' . $SQL_Literario;
            die;
        }

        $Ver_Cronica = 'style="visibility:collapse;"';

        if (!$Cronica->EOF) {

            if ($Cronica->fields['tipoarteliterario'] == 4) {

                $Cronica_Check = 'checked="checked"';
                $Ver_Cronica = 'style="visibility:visible;"';
            }

            /*
              1=Basico
              2=Medio
              3=Avanzado
             */

            if ($Cronica->fields['frecuencialiteraria'] == 1) {
                $Cronica_Fre_Uno = 'checked="checked"';
            }
            if ($Cronica->fields['frecuencialiteraria'] == 2) {
                $Cronica_Fre_Dos = 'checked="checked"';
            }
            if ($Cronica->fields['frecuencialiteraria'] == 3) {
                $Cronica_Fre_Tres = 'checked="checked"';
            }
        }
        ?>
                                                <tr>
                                                    <td><strong>* Cr&oacute;nica</strong></td>
                                                    <td>&nbsp;&nbsp;</td>
                                                    <td><input type="checkbox" id="cronica" name="Tipo_Literatura" onclick="Ver_ArteLiterario(); DeleteLirico('cronica', 'cronica_id')" <?php echo $Cronica_Check ?> <?php echo $ClassDisable ?>/></td>
                                                    <td colspan="3">&nbsp;<input type="hidden" id="cronica_id" />&nbsp;</td>
                                                </tr>
                                                <tr id="Tr_cronica" <?php echo $Ver_Cronica ?>>
                                                    <td colspan="7">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Nivel de Conocimiento en Cr&oacute;nica</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- B&aacute;sico</strong></td>
                                                                    <td><input type="radio" id="Nv_cronica_Uno" name="Nivel_cronica" onclick="ModificaLirico('cronica', 'cronica_id', '1')" <?php echo $Cronica_Fre_Uno ?> <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- Medio</strong></td>
                                                                    <td><input type="radio" id="Nv_cronica_Dos" name="Nivel_cronica" onclick="ModificaLirico('cronica', 'cronica_id', '2')" <?php echo $Cronica_Fre_Dos ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- Avanzado</strong></td>
                                                                    <td><input type="radio" id="Nv_cronica_Tres" name="Nivel_cronica" onclick="ModificaLirico('cronica', 'cronica_id', '3')" <?php echo $Cronica_Fre_Tres ?>  <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
        <?php
        /*
          1=Poesia
          2=Cuento
          3=Novela
          4=Crónica
          5=Otro
         */

        $SQL_Literario = 'SELECT 

																arteliterario,
																tipoarteliterario,
																frecuencialiteraria,
																cualarteliterario
																
																FROM estudiantearteliterario
																
																WHERE
																
																idestudiantegeneral="' . $id_Estudiante . '"
																AND
																codigoestado=100
																AND
																entrydate="' . $Hora_Literario->fields['entrydate'] . '"
																AND
																tipoarteliterario=5';

        if ($Otro_Lirico = &$db->Execute($SQL_Literario) === false) {
            echo 'Error en el sql del arte Literario Cronica......<br>' . $SQL_Literario;
            die;
        }

        $Ver_Otro_Lirico = 'style="visibility:collapse;"';

        if (!$Otro_Lirico->EOF) {

            if ($Otro_Lirico->fields['tipoarteliterario'] == 5) {

                $Otro_Lirico_Check = 'checked="checked"';
                $Ver_Otro_Lirico = 'style="visibility:visible;"';
            }

            /*
              1=Basico
              2=Medio
              3=Avanzado
             */

            if ($Otro_Lirico->fields['frecuencialiteraria'] == 1) {
                $Otro_Lirico_Fre_Uno = 'checked="checked"';
            }
            if ($Otro_Lirico->fields['frecuencialiteraria'] == 2) {
                $Otro_Lirico_Fre_Dos = 'checked="checked"';
            }
            if ($Otro_Lirico->fields['frecuencialiteraria'] == 3) {
                $Otro_Lirico_Fre_Tres = 'checked="checked"';
            }
        }
        ?>
                                                <tr>
                                                    <td><strong>* Otro</strong></td>
                                                    <td>&nbsp;&nbsp;</td>
                                                    <td><input type="checkbox" id="Otro_Literatura" name="Tipo_Literatura" onclick="Ver_ArteLiterario(); DeleteLirico('Otro_Literatura', 'OtraLirica_id')" <?php echo $Otro_Lirico_Check ?> <?php echo $ClassDisable ?> /></td>
                                                    <td>&nbsp;<input type="hidden" id="OtraLirica_id" />&nbsp;</td>
                                                    <td><strong>¿Cuál ?</strong></td>
                                                    <td><input type="text" id="Cual_Literatura" name="Cual_Literatura" class="CajasHoja" value="<?php echo $Otro_Lirico->fields['cualarteliterario'] ?>" <?php echo $ClassDisable ?> /></td>
                                                </tr>
                                                <tr id="Tr_Otro_Literatura" <?php echo $Ver_Otro_Lirico ?>>
                                                    <td colspan="7">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Nivel de Conocimiento en Otra Literatura</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- B&aacute;sico</strong></td>
                                                                    <td><input type="radio" id="Nv_Otro_Literatura_Uno" name="Nivel_Otro_Literatura" onclick="ModificaLirico('Otro_Literatura', 'OtraLirica_id', '1')" <?php echo $Otro_Lirico_Fre_Uno ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- Medio</strong></td>
                                                                    <td><input type="radio" id="Nv_Otro_Literatura_Dos" name="Nivel_Otro_Literatura" onclick="ModificaLirico('Otro_Literatura', 'OtraLirica_id', '2')" <?php echo $Otro_Lirico_Fre_Dos ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- Avanzado</strong></td>
                                                                    <td><input type="radio" id="Nv_Otro_Literatura_Tres" name="Nivel_Otro_Literatura" onclick="ModificaLirico('Otro_Literatura', 'OtraLirica_id', '3')" <?php echo $Otro_Lirico_Fre_Tres ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>    
                        </td>
                    </tr>
        <?php
        $SQL_Max_Plastica = 'SELECT 
											
											MAX(idestudiantearteplastica) AS id 
											
											FROM 
											
											estudiantearteplastica
											
											WHERE
											
											idestudiantegeneral="' . $id_Estudiante . '"
											AND
											codigoestado=100';

        if ($Max_Plastica = &$db->Execute($SQL_Max_Plastica) === false) {
            echo 'Error en el SQL Max Plastica....<br>' . $SQL_Max_Plastica;
            die;
        }

        $SQL_Hora_Plastica = 'SELECT 

												arteplastica,
												entrydate
												
												FROM 
												
												estudiantearteplastica
												
												WHERE
												
												idestudiantegeneral="' . $id_Estudiante . '"
												AND
												codigoestado=100
												AND
												idestudiantearteplastica="' . $Max_Plastica->fields['id'] . '"';


        if ($Hora_Plastica = &$db->Execute($SQL_Hora_Plastica) === false) {
            echo 'Error en el SLQ  de Hora Plastica....<br>' . $SQL_Hora_Plastica;
            die;
        }

        $Ver_Plastica = 'display:none';

        if (!$Hora_Plastica->EOF) {

            if ($Hora_Plastica->fields['arteplastica'] == 0) {
                $Plastica_Check_Si = 'checked="checked"';
                $Ver_Plastica = 'display:inline';
            }

            if ($Hora_Plastica->fields['arteplastica'] == 1) {
                $Plastica_Check_No = 'checked="checked"';
                $Ver_Plastica = 'display:none';
            }
        }
        ?>
                    <tr>
                        <td>
                            <table align="center" border="0" width="100%">
                                <tr>
                                    <td width="55%"><strong>¿Realiza algún árte plástica y/o visual como hobbie o profesionalmente ? &nbsp;&nbsp;<span style="color:#FF0000; font-size:10px" >*</span></strong></td>
                                    <td width="10%">&nbsp;&nbsp;</td>
                                    <td><strong>Si</strong>&nbsp;&nbsp;<input type="radio" id="Si_Plastica" name="Plastica" onclick="Ver_artePlastica(); CambiaPersonal();" <?php echo $Plastica_Check_Si ?> <?php echo $ClassDisable ?> />&nbsp;&nbsp;&nbsp;<strong>No</strong>&nbsp;&nbsp;<input type="radio" id="No_Plastica" name="Plastica" onclick="Ver_artePlastica(); CambiaPersonal();" <?php echo $Plastica_Check_No ?> <?php echo $ClassDisable ?> /></td>
                                    <td>&nbsp;&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4">&nbsp;<input type="hidden" id="NoPlastica_id" />&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <div id="Div_Plastica" align="center" style="width:100%;<?php echo $Ver_Plastica ?>">
                                            <table align="left" border="0" width="50%">
        <?php
        /*
          1=Fotografía
          2=Video
          3=Diseño Gráfico
          4=Comic
          5=Dibujo
          6=Grafitty
          7=Escultura
          8=Pintura
          9=Otro
         */

        $SQL_Plastico = 'SELECT 

																	arteplastica,
																	tipoarteplastico,
																	frecuenciaplastica,
																	cualarteplastica
																	
																	FROM 
																	
																	estudiantearteplastica
																	
																	WHERE
																	
																	idestudiantegeneral="' . $id_Estudiante . '"
																	AND
																	codigoestado=100
																	AND
																	entrydate="' . $Hora_Plastica->fields['entrydate'] . '"
																	AND
																	tipoarteplastico=1';

        if ($Fotografia = &$db->Execute($SQL_Plastico) === false) {
            echo 'Error en el SQL del Arte Fotografía.........<br>' . $SQL_Plastico;
            die;
        }

        $Ver_Fotografia = 'style="visibility:collapse;"';

        if (!$Fotografia->EOF) {

            if ($Fotografia->fields['tipoarteplastico'] == 1) {
                $Fotografia_Check = 'checked="checked"';
                $Ver_Fotografia = 'style="visibility:visible;"';
            }

            if ($Fotografia->fields['frecuenciaplastica'] == 1) {
                $Fotografia_Fre_Uno = 'checked="checked"';
            }
            if ($Fotografia->fields['frecuenciaplastica'] == 2) {
                $Fotografia_Fre_Dos = 'checked="checked"';
            }
            if ($Fotografia->fields['frecuenciaplastica'] == 3) {
                $Fotografia_Fre_Tres = 'checked="checked"';
            }
        }
        ?>
                                                <tr>
                                                    <td><strong>* Fotograf&iacute;a</strong></td>
                                                    <td>&nbsp;&nbsp;</td>
                                                    <td><input type="checkbox" id="fotografia" name="Arte_Plastica" onclick="VerArtePlasticaVisual(); DeletePlastica('fotografia', 'fotografia_id')" <?php echo $Fotografia_Check ?>  <?php echo $ClassDisable ?>/></td>
                                                    <td colspan="3">&nbsp;<input type="hidden" id="fotografia_id" />&nbsp;</td>
                                                </tr>
                                                <tr id="Tr_fotografia" <?php echo $Ver_Fotografia ?>>
                                                    <td colspan="7">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Nivel de Conocimiento en Fotograf&iacute;a</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- B&aacute;sico</strong></td>
                                                                    <td><input type="radio" id="Nv_fotografia_Uno" name="Nivel_fotografia" onclick="ModificarPlastica('fotografia', 'fotografia_id', '1')" <?php echo $Fotografia_Fre_Uno ?>  <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- Medio</strong></td>
                                                                    <td><input type="radio" id="Nv_fotografia_Dos" name="Nivel_fotografia" onclick="ModificarPlastica('fotografia', 'fotografia_id', '2')" <?php echo $Fotografia_Fre_Dos ?>  <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- Avanzado</strong></td>
                                                                    <td><input type="radio" id="Nv_fotografia_Tres" name="Nivel_fotografia" onclick="ModificarPlastica('fotografia', 'fotografia_id', '3')" <?php echo $Fotografia_Fre_Tres ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                    <?php
                    /*
                      1=Fotografía
                      2=Video
                      3=Diseño Gráfico
                      4=Comic
                      5=Dibujo
                      6=Grafitty
                      7=Escultura
                      8=Pintura
                      9=Otro
                     */

                    $SQL_Plastico = 'SELECT 

																	arteplastica,
																	tipoarteplastico,
																	frecuenciaplastica,
																	cualarteplastica
																	
																	FROM 
																	
																	estudiantearteplastica
																	
																	WHERE
																	
																	idestudiantegeneral="' . $id_Estudiante . '"
																	AND
																	codigoestado=100
																	AND
																	entrydate="' . $Hora_Plastica->fields['entrydate'] . '"
																	AND
																	tipoarteplastico=2';

                    if ($Video = &$db->Execute($SQL_Plastico) === false) {
                        echo 'Error en el SQL del Arte Video.........<br>' . $SQL_Plastico;
                        die;
                    }

                    $Ver_Video = 'style="visibility:collapse;"';

                    if (!$Video->EOF) {

                        if ($Video->fields['tipoarteplastico'] == 2) {
                            $Video_Check = 'checked="checked"';
                            $Ver_Video = 'style="visibility:visible;"';
                        }

                        if ($Video->fields['frecuenciaplastica'] == 1) {
                            $Video_Fre_Uno = 'checked="checked"';
                        }
                        if ($Video->fields['frecuenciaplastica'] == 2) {
                            $Video_Fre_Dos = 'checked="checked"';
                        }
                        if ($Video->fields['frecuenciaplastica'] == 3) {
                            $Video_Fre_Tres = 'checked="checked"';
                        }
                    }
                    ?>
                                                <tr>
                                                    <td><strong>* Video</strong></td>
                                                    <td>&nbsp;&nbsp;</td>
                                                    <td><input type="checkbox" id="video" name="Arte_Plastica" onclick="VerArtePlasticaVisual(); DeletePlastica('video', 'video_id')" <?php echo $Video_Check ?> <?php echo $ClassDisable ?> /></td>
                                                    <td colspan="3">&nbsp;<input type="hidden" id="video_id" />&nbsp;</td>
                                                </tr>
                                                <tr id="Tr_video" <?php echo $Ver_Video ?>>
                                                    <td colspan="7">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Nivel de Conocimiento en Video</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- B&aacute;sico</strong></td>
                                                                    <td><input type="radio" id="Nv_video_Uno" name="Nivel_video" onclick="ModificarPlastica('video', 'video_id', '1')" <?php echo $Video_Fre_Uno ?> <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- Medio</strong></td>
                                                                    <td><input type="radio" id="Nv_video_Dos" name="Nivel_video" onclick="ModificarPlastica('video', 'video_id', '2')" <?php echo $Video_Fre_Dos ?>  <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- Avanzado</strong></td>
                                                                    <td><input type="radio" id="Nv_video_Tres" name="Nivel_video" onclick="ModificarPlastica('video', 'video_id', '3')" <?php echo $Video_Fre_Tres ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
        <?php
        /*
          1=Fotografía
          2=Video
          3=Diseño Gráfico
          4=Comic
          5=Dibujo
          6=Grafitty
          7=Escultura
          8=Pintura
          9=Otro
         */

        $SQL_Plastico = 'SELECT 

																	arteplastica,
																	tipoarteplastico,
																	frecuenciaplastica,
																	cualarteplastica
																	
																	FROM 
																	
																	estudiantearteplastica
																	
																	WHERE
																	
																	idestudiantegeneral="' . $id_Estudiante . '"
																	AND
																	codigoestado=100
																	AND
																	entrydate="' . $Hora_Plastica->fields['entrydate'] . '"
																	AND
																	tipoarteplastico=3';

        if ($Diseno = &$db->Execute($SQL_Plastico) === false) {
            echo 'Error en el SQL del Arte Diseño.........<br>' . $SQL_Plastico;
            die;
        }

        $Ver_Diseno = 'style="visibility:collapse;"';

        if (!$Diseno->EOF) {

            if ($Diseno->fields['tipoarteplastico'] == 3) {
                $Diseno_Check = 'checked="checked"';
                $Ver_Diseno = 'style="visibility:visible;"';
            }

            if ($Diseno->fields['frecuenciaplastica'] == 1) {
                $Diseno_Fre_Uno = 'checked="checked"';
            }
            if ($Diseno->fields['frecuenciaplastica'] == 2) {
                $Diseno_Fre_Dos = 'checked="checked"';
            }
            if ($Diseno->fields['frecuenciaplastica'] == 3) {
                $Diseno_Fre_Tres = 'checked="checked"';
            }
        }
        ?>
                                                <tr>
                                                    <td><strong>* Dise&ntilde;o Gr&aacute;fico</strong></td>
                                                    <td>&nbsp;&nbsp;</td>
                                                    <td><input type="checkbox" id="diseno_Gra" name="Arte_Plastica" onclick="VerArtePlasticaVisual(); DeletePlastica('diseno_Gra', 'disenoGra_id')" <?php echo $Diseno_Check ?> <?php echo $ClassDisable ?> /></td>
                                                    <td colspan="3">&nbsp;<input type="hidden" id="disenoGra_id" />&nbsp;</td>
                                                </tr>
                                                <tr id="Tr_diseno_Gra" <?php echo $Ver_Diseno ?>>
                                                    <td colspan="7">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Nivel de Conocimiento en Dise&ntilde;o Gr&aacute;fico</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- B&aacute;sico</strong></td>
                                                                    <td><input type="radio" id="Nv_diseno_Gra_Uno" name="Nivel_diseno_Gra" onclick="ModificarPlastica('diseno_Gra', 'disenoGra_id', '1')" <?php echo $Diseno_Fre_Uno ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- Medio</strong></td>
                                                                    <td><input type="radio" id="Nv_diseno_Gra_Dos" name="Nivel_diseno_Gra" onclick="ModificarPlastica('diseno_Gra', 'disenoGra_id', '2')" <?php echo $Diseno_Fre_Dos ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- Avanzado</strong></td>
                                                                    <td><input type="radio" id="Nv_diseno_Gra_Tres" name="Nivel_diseno_Gra" onclick="ModificarPlastica('diseno_Gra', 'disenoGra_id', '3')" <?php echo $Diseno_Fre_Tres ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
        <?php
        /*
          1=Fotografía
          2=Video
          3=Diseño Gráfico
          4=Comic
          5=Dibujo
          6=Grafitty
          7=Escultura
          8=Pintura
          9=Otro
         */

        $SQL_Plastico = 'SELECT 

																	arteplastica,
																	tipoarteplastico,
																	frecuenciaplastica,
																	cualarteplastica
																	
																	FROM 
																	
																	estudiantearteplastica
																	
																	WHERE
																	
																	idestudiantegeneral="' . $id_Estudiante . '"
																	AND
																	codigoestado=100
																	AND
																	entrydate="' . $Hora_Plastica->fields['entrydate'] . '"
																	AND
																	tipoarteplastico=4';

        if ($Comic = &$db->Execute($SQL_Plastico) === false) {
            echo 'Error en el SQL del Arte Comic.........<br>' . $SQL_Plastico;
            die;
        }

        $Ver_Comic = 'style="visibility:collapse;"';

        if (!$Comic->EOF) {

            if ($Comic->fields['tipoarteplastico'] == 4) {
                $Comic_Check = 'checked="checked"';
                $Ver_Comic = 'style="visibility:visible;"';
            }

            if ($Comic->fields['frecuenciaplastica'] == 1) {
                $Comic_Fre_Uno = 'checked="checked"';
            }
            if ($Comic->fields['frecuenciaplastica'] == 2) {
                $Comic_Fre_Dos = 'checked="checked"';
            }
            if ($Comic->fields['frecuenciaplastica'] == 3) {
                $Comic_Fre_Tres = 'checked="checked"';
            }
        }
        ?>
                                                <tr>
                                                    <td><strong>* Comic</strong></td>
                                                    <td>&nbsp;&nbsp;</td>
                                                    <td><input type="checkbox" id="comic" name="Arte_Plastica" onclick="VerArtePlasticaVisual(); DeletePlastica('comic', 'Comic_id')" <?php echo $Comic_Check ?> <?php echo $ClassDisable ?> /></td>
                                                    <td colspan="3">&nbsp;<input type="hidden" id="Comic_id" />&nbsp;</td>
                                                </tr>
                                                <tr id="Tr_comic" <?php echo $Ver_Comic ?>>
                                                    <td colspan="7">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Nivel de Conocimiento en Comic</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- B&aacute;sico</strong></td>
                                                                    <td><input type="radio" id="Nv_comic_Uno" name="Nivel_comic" onclick="ModificarPlastica('comic', 'Comic_id', '1')" <?php echo $Comic_Fre_Uno ?> <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- Medio</strong></td>
                                                                    <td><input type="radio" id="Nv_comic_Dos" name="Nivel_comic" onclick="ModificarPlastica('comic', 'Comic_id', '2')" <?php echo $Comic_Fre_Dos ?>  <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- Avanzado</strong></td>
                                                                    <td><input type="radio" id="Nv_comic_Tres" name="Nivel_comic" onclick="ModificarPlastica('comic', 'Comic_id', '3')" <?php echo $Comic_Fre_Tres ?>  <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
        <?php
        /*
          1=Fotografía
          2=Video
          3=Diseño Gráfico
          4=Comic
          5=Dibujo
          6=Grafitty
          7=Escultura
          8=Pintura
          9=Otro
         */

        $SQL_Plastico = 'SELECT 

																	arteplastica,
																	tipoarteplastico,
																	frecuenciaplastica,
																	cualarteplastica
																	
																	FROM 
																	
																	estudiantearteplastica
																	
																	WHERE
																	
																	idestudiantegeneral="' . $id_Estudiante . '"
																	AND
																	codigoestado=100
																	AND
																	entrydate="' . $Hora_Plastica->fields['entrydate'] . '"
																	AND
																	tipoarteplastico=9';

        if ($OtroPlastico = &$db->Execute($SQL_Plastico) === false) {
            echo 'Error en el SQL del Arte OtroPlastico.........<br>' . $SQL_Plastico;
            die;
        }

        $Ver_OtroPlastico = 'style="visibility:collapse;"';

        if (!$OtroPlastico->EOF) {

            if ($OtroPlastico->fields['tipoarteplastico'] == 9) {
                $OtroPlastico_Check = 'checked="checked"';
                $Ver_OtroPlastico = 'style="visibility:visible;"';
            }

            if ($OtroPlastico->fields['frecuenciaplastica'] == 1) {
                $OtroPlastico_Fre_Uno = 'checked="checked"';
            }
            if ($OtroPlastico->fields['frecuenciaplastica'] == 2) {
                $OtroPlastico_Fre_Dos = 'checked="checked"';
            }
            if ($OtroPlastico->fields['frecuenciaplastica'] == 3) {
                $OtroPlastico_Fre_Tres = 'checked="checked"';
            }
        }
        ?>
                                                <tr>
                                                    <td><strong>* Otro</strong></td>
                                                    <td>&nbsp;&nbsp;</td>
                                                    <td><input type="checkbox" id="Otro_Plastico" name="Arte_Plastica" onclick="VerArtePlasticaVisual(); DeletePlastica('Otro_Plastico', 'OtroPlastico_id')" <?php echo $OtroPlastico_Check ?> <?php echo $ClassDisable ?> /></td>
                                                    <td colspan="3">&nbsp;<input type="hidden" id="OtroPlastico_id" />&nbsp;</td>
                                                </tr>
                                                <tr id="Tr_Otro_Plastico" <?php echo $Ver_OtroPlastico ?>>
                                                    <td colspan="7">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Nivel de Conocimiento en OtroAtre Plastico/Visual</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- B&aacute;sico</strong></td>
                                                                    <td><input type="radio" id="Nv_Otro_PV_Uno" name="Nivel_Otro_Plastico" onclick="ModificarPlastica('Otro_Plastico', 'OtroPlastico_id', '1')" <?php echo $OtroPlastico_Fre_Uno ?>  <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- Medio</strong></td>
                                                                    <td><input type="radio" id="Nv_Otro_PV_Dos" name="Nivel_Otro_Plastico" onclick="ModificarPlastica('Otro_Plastico', 'OtroPlastico_id', '2')" <?php echo $OtroPlastico_Fre_Dos ?> <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- Avanzado</strong></td>
                                                                    <td><input type="radio" id="Nv_Otro_PV_Tres" name="Nivel_Otro_Plastico" onclick="ModificarPlastica('Otro_Plastico', 'OtroPlastico_id', '3')" <?php echo $OtroPlastico_Fre_Tres ?>  <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                            </table>
                                            <table align="right" border="0" width="50%">
        <?php
        /*
          1=Fotografía
          2=Video
          3=Diseño Gráfico
          4=Comic
          5=Dibujo
          6=Grafitty
          7=Escultura
          8=Pintura
          9=Otro
         */

        $SQL_Plastico = 'SELECT 

																	arteplastica,
																	tipoarteplastico,
																	frecuenciaplastica,
																	cualarteplastica
																	
																	FROM 
																	
																	estudiantearteplastica
																	
																	WHERE
																	
																	idestudiantegeneral="' . $id_Estudiante . '"
																	AND
																	codigoestado=100
																	AND
																	entrydate="' . $Hora_Plastica->fields['entrydate'] . '"
																	AND
																	tipoarteplastico=5';

        if ($Dibujo = &$db->Execute($SQL_Plastico) === false) {
            echo 'Error en el SQL del Arte Dibujo.........<br>' . $SQL_Plastico;
            die;
        }

        $Ver_Dibujo = 'style="visibility:collapse;"';

        if (!$Dibujo->EOF) {

            if ($Dibujo->fields['tipoarteplastico'] == 5) {
                $Dibujo_Check = 'checked="checked"';
                $Ver_Dibujo = 'style="visibility:visible;"';
            }

            if ($Dibujo->fields['frecuenciaplastica'] == 1) {
                $Dibujo_Fre_Uno = 'checked="checked"';
            }
            if ($Dibujo->fields['frecuenciaplastica'] == 2) {
                $Dibujo_Fre_Dos = 'checked="checked"';
            }
            if ($Dibujo->fields['frecuenciaplastica'] == 3) {
                $Dibujo_Fre_Tres = 'checked="checked"';
            }
        }
        ?>
                                                <tr>
                                                    <td><strong>* Dibujo</strong></td>
                                                    <td>&nbsp;&nbsp;</td>
                                                    <td><input type="checkbox" id="dibujo" name="Arte_Plastica" onclick="VerArtePlasticaVisual(); DeletePlastica('dibujo', 'Dibujo_id')" <?php echo $Dibujo_Check ?> <?php echo $ClassDisable ?> /></td>
                                                    <td colspan="3">&nbsp;<input type="hidden" id="Dibujo_id" />&nbsp;</td>
                                                </tr>
                                                <tr id="Tr_dibujo" <?php echo $Ver_Dibujo ?>>
                                                    <td colspan="7">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Nivel de Conocimiento en Dibujo</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- B&aacute;sico</strong></td>
                                                                    <td><input type="radio" id="Nv_dibujo_Uno" name="Nivel_dibujo" onclick="ModificarPlastica('dibujo', 'Dibujo_id', '1')" <?php echo $Dibujo_Fre_Uno ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- Medio</strong></td>
                                                                    <td><input type="radio" id="Nv_dibujo_Dos" name="Nivel_dibujo" onclick="ModificarPlastica('dibujo', 'Dibujo_id', '2')" <?php echo $Dibujo_Fre_Dos ?>  <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- Avanzado</strong></td>
                                                                    <td><input type="radio" id="Nv_dibujo_Tres" name="Nivel_dibujo" onclick="ModificarPlastica('dibujo', 'Dibujo_id', '3')" <?php echo $Dibujo_Fre_Tres ?>  <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
        <?php
        /*
          1=Fotografía
          2=Video
          3=Diseño Gráfico
          4=Comic
          5=Dibujo
          6=Grafitty
          7=Escultura
          8=Pintura
          9=Otro
         */

        $SQL_Plastico = 'SELECT 

																	arteplastica,
																	tipoarteplastico,
																	frecuenciaplastica,
																	cualarteplastica
																	
																	FROM 
																	
																	estudiantearteplastica
																	
																	WHERE
																	
																	idestudiantegeneral="' . $id_Estudiante . '"
																	AND
																	codigoestado=100
																	AND
																	entrydate="' . $Hora_Plastica->fields['entrydate'] . '"
																	AND
																	tipoarteplastico=6';

        if ($Grafitty = &$db->Execute($SQL_Plastico) === false) {
            echo 'Error en el SQL del Arte Grafitty.........<br>' . $SQL_Plastico;
            die;
        }

        $Ver_Grafitty = 'style="visibility:collapse;"';

        if (!$Grafitty->EOF) {

            if ($Grafitty->fields['tipoarteplastico'] == 6) {
                $Grafitty_Check = 'checked="checked"';
                $Ver_Grafitty = 'style="visibility:visible;"';
            }

            if ($Grafitty->fields['frecuenciaplastica'] == 1) {
                $Grafitty_Fre_Uno = 'checked="checked"';
            }
            if ($Grafitty->fields['frecuenciaplastica'] == 2) {
                $Grafitty_Fre_Dos = 'checked="checked"';
            }
            if ($Grafitty->fields['frecuenciaplastica'] == 3) {
                $Grafitty_Fre_Tres = 'checked="checked"';
            }
        }
        ?>
                                                <tr>
                                                    <td><strong>* Grafitty</strong></td>
                                                    <td>&nbsp;&nbsp;</td>
                                                    <td><input type="checkbox" id="grafitty" name="Arte_Plastica" onclick="VerArtePlasticaVisual(); DeletePlastica('grafitty', 'Grafitty_id')" <?php echo $Grafitty_Check ?> <?php echo $ClassDisable ?> /></td>
                                                    <td colspan="3">&nbsp;<input type="hidden" id="Grafitty_id" />&nbsp;</td>
                                                </tr>
                                                <tr id="Tr_grafitty" <?php echo $Ver_Grafitty ?>>
                                                    <td colspan="7">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Nivel de Conocimiento en Grafitty</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- B&aacute;sico</strong></td>
                                                                    <td><input type="radio" id="Nv_grafitty_Uno" name="Nivel_grafitty" onclick="ModificarPlastica('grafitty', 'Grafitty_id', '1')" <?php echo $Grafitty_Fre_Uno ?>  <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- Medio</strong></td>
                                                                    <td><input type="radio" id="Nv_grafitty_Dos" name="Nivel_grafitty" onclick="ModificarPlastica('grafitty', 'Grafitty_id', '2')" <?php echo $Grafitty_Fre_Dos ?>  <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- Avanzado</strong></td>
                                                                    <td><input type="radio" id="Nv_grafitty_Tres" name="Nivel_grafitty" onclick="ModificarPlastica('grafitty', 'Grafitty_id', '3')" <?php echo $Grafitty_Fre_Tres ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
        <?php
        /*
          1=Fotografía
          2=Video
          3=Diseño Gráfico
          4=Comic
          5=Dibujo
          6=Grafitty
          7=Escultura
          8=Pintura
          9=Otro
         */

        $SQL_Plastico = 'SELECT 

																	arteplastica,
																	tipoarteplastico,
																	frecuenciaplastica,
																	cualarteplastica
																	
																	FROM 
																	
																	estudiantearteplastica
																	
																	WHERE
																	
																	idestudiantegeneral="' . $id_Estudiante . '"
																	AND
																	codigoestado=100
																	AND
																	entrydate="' . $Hora_Plastica->fields['entrydate'] . '"
																	AND
																	tipoarteplastico=7';

        if ($Escultura = &$db->Execute($SQL_Plastico) === false) {
            echo 'Error en el SQL del Arte Escultura.........<br>' . $SQL_Plastico;
            die;
        }

        $Ver_Escultura = 'style="visibility:collapse;"';

        if (!$Escultura->EOF) {

            if ($Escultura->fields['tipoarteplastico'] == 7) {
                $Escultura_Check = 'checked="checked"';
                $Ver_Escultura = 'style="visibility:visible;"';
            }

            if ($Escultura->fields['frecuenciaplastica'] == 1) {
                $Escultura_Fre_Uno = 'checked="checked"';
            }
            if ($Escultura->fields['frecuenciaplastica'] == 2) {
                $Escultura_Fre_Dos = 'checked="checked"';
            }
            if ($Escultura->fields['frecuenciaplastica'] == 3) {
                $Escultura_Fre_Tres = 'checked="checked"';
            }
        }
        ?>
                                                <tr>
                                                    <td><strong>* Escultura</strong></td>
                                                    <td>&nbsp;&nbsp;</td>
                                                    <td><input type="checkbox" id="escultura" name="Arte_Plastica" onclick="VerArtePlasticaVisual(); DeletePlastica('escultura', 'Escultura_id')" <?php echo $Escultura_Check ?>  <?php echo $ClassDisable ?> /></td>
                                                    <td colspan="3">&nbsp;<input type="hidden" id="Escultura_id" />&nbsp;</td>
                                                </tr>
                                                <tr id="Tr_escultura"  <?php echo $Ver_Escultura ?>>
                                                    <td colspan="7">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Nivel de Conocimiento en Escultura</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- B&aacute;sico</strong></td>
                                                                    <td><input type="radio" id="Nv_escultura_Uno" name="Nivel_escultura" onclick="ModificarPlastica('escultura', 'Escultura_id', '1')" <?php echo $Escultura_Fre_Uno ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- Medio</strong></td>
                                                                    <td><input type="radio" id="Nv_escultura_Dos" name="Nivel_escultura" onclick="ModificarPlastica('escultura', 'Escultura_id', '2')" <?php echo $Escultura_Fre_Dos ?>  <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- Avanzado</strong></td>
                                                                    <td><input type="radio" id="Nv_escultura_Tres" name="Nivel_escultura" onclick="ModificarPlastica('escultura', 'Escultura_id', '3')" <?php echo $Escultura_Fre_Tres ?> <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
        <?php
        /*
          1=Fotografía
          2=Video
          3=Diseño Gráfico
          4=Comic
          5=Dibujo
          6=Grafitty
          7=Escultura
          8=Pintura
          9=Otro
         */

        $SQL_Plastico = 'SELECT 

																	arteplastica,
																	tipoarteplastico,
																	frecuenciaplastica,
																	cualarteplastica
																	
																	FROM 
																	
																	estudiantearteplastica
																	
																	WHERE
																	
																	idestudiantegeneral="' . $id_Estudiante . '"
																	AND
																	codigoestado=100
																	AND
																	entrydate="' . $Hora_Plastica->fields['entrydate'] . '"
																	AND
																	tipoarteplastico=8';

        if ($Pintura = &$db->Execute($SQL_Plastico) === false) {
            echo 'Error en el SQL del Arte Pintura.........<br>' . $SQL_Plastico;
            die;
        }

        $Ver_Pintura = 'style="visibility:collapse;"';

        if (!$Pintura->EOF) {

            if ($Pintura->fields['tipoarteplastico'] == 7) {
                $Pintura_Check = 'checked="checked"';
                $Ver_Pintura = 'style="visibility:visible;"';
            }

            if ($Pintura->fields['frecuenciaplastica'] == 1) {
                $Pintura_Fre_Uno = 'checked="checked"';
            }
            if ($Pintura->fields['frecuenciaplastica'] == 2) {
                $Pintura_Fre_Dos = 'checked="checked"';
            }
            if ($Pintura->fields['frecuenciaplastica'] == 3) {
                $Pintura_Fre_Tres = 'checked="checked"';
            }
        }
        ?>
                                                <tr>
                                                    <td><strong>* Pintura</strong></td>
                                                    <td>&nbsp;&nbsp;</td>
                                                    <td><input type="checkbox" id="pintura" name="Arte_Plastica" onclick="VerArtePlasticaVisual(); DeletePlastica('pintura', 'Pintura_id')" <?php echo $Pintura_Check ?> <?php echo $ClassDisable ?> /></td>
                                                    <td colspan="3">&nbsp;<input type="hidden" id="Pintura_id" />&nbsp;</td>
                                                </tr>
                                                <tr id="Tr_pintura" <?php echo $Ver_Pintura ?>>
                                                    <td colspan="7">
                                                        <fieldset style="border:#88AB0C solid 1px; width:70%">
                                                            <legend>Nivel de Conocimiento en Pintura</legend>
                                                            <table width="100%" align="center" border="0">
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- B&aacute;sico</strong></td>
                                                                    <td><input type="radio" id="Nv_pintura_Uno" name="Nivel_pintura" onclick="ModificarPlastica('pintura', 'Pintura_id', '1')" <?php echo $Pintura_Fre_Uno ?>  <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;&nbsp;</td>     
                                                                    <td><strong>- Medio</strong></td>
                                                                    <td><input type="radio" id="Nv_pintura_Dos" name="Nivel_pintura" onclick="ModificarPlastica('pintura', 'Pintura_id', '2')" <?php echo $Pintura_Fre_Dos ?>  <?php echo $ClassDisable ?> /></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>     
                                                                    <td>&nbsp;&nbsp;</td>
                                                                    <td><strong>- Avanzado</strong></td>
                                                                    <td><input type="radio" id="Nv_pintura_Tres" name="Nivel_pintura" onclick="ModificarPlastica('pintura', 'Pintura_id', '3')" <?php echo $Pintura_Fre_Tres ?>   <?php echo $ClassDisable ?>/></td>
                                                                    <td>&nbsp;&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="4">&nbsp;&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </fieldset>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>¿Cuál ?</strong></td>
                                                    <td>&nbsp;&nbsp;</td>
                                                    <td><input type="text" id="Cual_ArtePlastico" name="Cual_ArtePlastico" class="CajasHoja" value="<?php echo $OtroPlastico->fields['cualarteplastica'] ?>"  <?php echo $ClassDisable ?> /></td>
                                                    <td colspan="">&nbsp;&nbsp;</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <td>

                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                    </tr>
                </table>
            </fieldset>
            <br />
        </fieldset> 
                                                <?php
                                            }

                                            public function SegundaPagina($id_Estudiante, $AdminRol) {
                                                global $db, $userid, $rol_Usuario;
                                                $AdminRol = 90;
                                                if ($AdminRol == 90) {
                                                    $SaveAdminAll = "SaveAdmin('" . $id_Estudiante . "','0','1','0','0')";
                                                }
                                                ?>
        <script>
            $(function() {
            $("#tabs2").tabs();
            });</script>
        <fieldset style="border:#88AB0C solid 1px"><!---->
            <div id="Div_Bienestar">
                <legend style="font-size:24px">VIDA UNIVERSITARIA...</legend>
                <fieldset style="border:#88AB0C solid 1px; width:95%">
                    <div id="Bienvenida" title="Apreciado Usuario." style="width:auto;" align="center">
                        <div style="background-color:#3E4729;border-bottom:7px solid #88AB0C;border-top-left-radius:2em;
                             border-bottom-right-radius:2em; width:98%;  margin-bottom:2%; margin-left:2%; margin-right:2%; margin-top:2%" align="right"><img src="http://www.uelbosque.edu.co/sites/default/themes/ueb/images/logotipo_ueb.png"   style="margin-left:3%; margin-right:3%" width="130" /></div>
                        <p align="justify" style=" margin-bottom:2%; margin-left:2%; margin-right:2%; margin-top:2%">La Universidad El Bosque promueve la participación de los estudiantes en actividades académicas, en grupos o centros de estudio, actividades artísticas, deportivas, proyectos de emprendimiento, entre otras, en un ambiente académico propicio para la formación integral.<br /><br />
                            La Universidad desea brindar a sus estudiantes formación integral, por esa razón requiere conocer algunos aspectos importantes que permitirán apoyar el ingreso a la universidad, mejorar las experiencias en la vida universitaria y apoyar la preparación para la vida laboral.
                    </div>   
                    <div align="justify" style="width:90%; margin-left:2%">
                        <br />

                        <br />
                        <br />
                    </div>       
                </fieldset>
                <br />
                <br />
                <div id="tabs" >
                    <ul>
                        <li><a href="#tabs-1">Información General</a>
                        <li><a href="#tabs-2">Información Académica</a></li>
                        <li><a href="#tabs-4">Información Personal</a></li>
                                                <?php if ($AdminRol == 'xxxx') { ?>
                            <li><a href="#tabs-5">&Eacute;xito Estudiantil</a></li>
                                                <?php } ?>
                                                <?php if ($AdminRol == 90) { ?>
                            <li><a href="#tabs-7">Bienestar Universitario</a></li>
                                                <?php } ?>
                                                <?php if ($AdminRol == 'xxxx') { ?>
                            <li><a href="#tabs-8">Participación en Órganos de Gobierno</a></li>
                                                <?php } ?>
                                                <?php if ($AdminRol == 'xxxx') { ?>
                            <li><a href="#tabs-9">Actividades de Investigación</a></li>
                                                <?php } ?>
                    </ul>
                    <div id="tabs-1"><input type="hidden" id="Tab_1" value="1"  />
                                                <?php $this->InformacionGeneral($id_Estudiante, 1); ?>
                    </div>
                    <div id="tabs-2"><input type="hidden" id="Tab_2" value="2"  />
                                                <?php $this->InformacionAcademica($id_Estudiante, 1); ?>
                    </div>
                    <div id="tabs-4"><input type="hidden" id="Tab_4" value="4"  />
        <?php $this->InformacionPersonal($id_Estudiante, 1); ?>   
                    </div>
        <?php if ($AdminRol == 'xxxx') { ?>
                        <div id="tabs-5" style="width:90%;">
            <?php $this->ExitoEstudiantil($id_Estudiante); ?>
                        </div>
        <?php } ?>
        <?php if ($AdminRol == 90) { ?>
                        <div id="tabs-7">
            <?php
            //$userid	= 34923;/****Cultura***/   
            //$userid   = 34922;/****Deporte****/
            //$userid   = 34884;/****Salud****/
            //$userid   = 36533;/****Voluntariado****/
            $this->BienestarUniversitario($id_Estudiante, $_GET["idUsuarioPerfil"]);
            ?>
                        </div>
        <?php } ?>
        <?php if ($AdminRol == 'xxxx') { ?>
                        <div id="tabs-8">
            <?php $this->OrganosGobierno($id_Estudiante); ?>
                        </div>
        <?php } ?>
        <?php if ($AdminRol == 'xxxx') { ?>
                        <div id="tabs-9">
            <?php $this->ActividadInvestigacion($id_Estudiante); ?>
                        </div>
        <?php } ?>
                </div>
                <br />
                <br /> 
                <div id="Botones" align="right" style="margin-right:5%;">   
                    <input style="display:none" type="button" id="Retroceder" value="Atras." onclick="Atras_New()" class="submit" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" id="SaveGenral" value="Guardar." onclick="<?php echo $SaveAdminAll ?>" class="submit" />
                </div>       
        </fieldset> 
        <br /><br />

        <br /><br />
        </div>   
        <!------------------------------------------------------------------------------------------->     
        <div id="Cargar_TabEstudiante" style="display:none"> 

            <fieldset style="border:#88AB0C solid 1px; width:auto">
                <div align="justify" style="width:90%; margin-left:5%">
                    <br />
                    Para la Universidad El Bosque, en sus procesos de autoevaluación permanente, es de gran importancia conocer  las capacidades, habilidades y necesidades de sus estudiantes. Por lo anterior, le solicitamos diligenciar y/o actualizar el formulario que se presenta a continuación, con el fin de desarrollar estrategias y programas que permitan potencializar al máximo su formación integral (académica, personal, social, cultural).  
                    <br />
                    <br />
                </div>       
            </fieldset>   
            <fieldset style="border:#88AB0C solid 1px"><!---->
                <legend style="font-size:24px"></legend>   
                <div id="Bienvenida" title="Apreciado Estudiante." style="width:auto;<?php echo $Entrada ?>" align="center">
                    <div style="background-color:#3E4729;border-bottom:7px solid #88AB0C;border-top-left-radius:2em;
                         border-bottom-right-radius:2em; width:98%;  margin-bottom:2%; margin-left:2%; margin-right:2%; margin-top:2%" align="right"><img src="http://www.uelbosque.edu.co/sites/default/themes/ueb/images/logotipo_ueb.png"   style="margin-left:3%; margin-right:3%" width="130" /></div><br />

                    <p align="justify" style=" margin-bottom:2%; margin-left:2%; margin-right:2%; margin-top:2%">Tu universidad quiere re-afirmar la información de tus datos personales. Te agradecemos tu colaboración, por favor llena la pestaña "Información Personal" con el fin de brindarte un mejor servicio.<br /><br />

                        Toda la información que consigne en esta Hoja de Vida, está protegida, es confidencial y no será compartida o suministrada a otras entidades o personas naturales o jurídicas sin la autorización previa.<br /><br />

                        Lamentamos los inconvenientes causados.<br /><br />Gracias.</p>
                </div>      
                <div id="tabs2" >
                    <ul>  
                        <li><a href="#tabs-1">Información General</a></li>
                        <li><a href="#tabs-2">Información Académica</a></li>
                        <li style="display:none"><a href="#tabs-3">Información Adicional</a></li>
                        <li><a href="#tabs-4">Información Personal</a></li>

                    </ul> 
                    <div id="tabs-1"><input type="hidden" id="Tab_1" value="1"  />
        <?php $this->InformacionGeneral($id_Estudiante, $Dissable = 1); ?>
                    </div>
                    <div id="tabs-2"><input type="hidden" id="Tab_2" value="2"  />   
        <?php $this->InformacionAcademica($id_Estudiante, $Dissable = 1); ?>
                    </div>
                    <div id="tabs-3"><input type="hidden" id="Tab_3" value="3"  />   
        <?php $this->InformacionAdicional($id_Estudiante, $Dissable = 1); ?>
                    </div>
                    <div id="tabs-4"><input type="hidden" id="Tab_4" value="4"  />
        <?php $this->InformacionPersonal($id_Estudiante, $Dissable = 1); ?>
                    </div>
                </div>
                <br>
                <br> 
            </fieldset>
            <br /><br />
            <div id="Botones" align="right" style="margin-right:5%">
                <input type="button" id="Adelante" value="Siguiente." onclick="Adelante_New()" class="submit" />
            </div>      
            <br /><br />
        </div>  

        <?php
    }

    public function ExitoEstudiantil() {
        global $db, $userid, $rol_Usuario;
        ?>
        <div id="Intro_ExitoEstudiantil" style="width:95%; margin-left:3%; margin-right:3%; margin-bottom:2%; margin-top:2%" align="justify">
            <strong>En la medida en que identifiquemos las fortalezas y debilidades académicas de nuestros estudiantes, podremos ofrecer un espacio eficiente de tutorías y acompañamiento, por esta razón recomendamos diligenciar la información que presentamos a continuación. </strong>
        </div>
        <br /><br />
        <fieldset style="height:100%; width:100%;  border-top-left-radius:2em;border-bottom-right-radius:2em;border:#88AB0C solid 1px ">
            <table width="95%" align="center" border="0" style="margin-left:2%; margin-right:2%; margin-bottom:2%;font-size:12px">
                <tr>
                    <td>&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" align="center" border="0">
                            <tr>
                                <td><strong>1. Resultados Prueba de Competencias &nbsp;&nbsp;<span style="color:#FF0000; font-size:10px" >*</span></strong></td>
                                <td colspan="3">&nbsp;&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" align="center" border="0">
                            <tr>
                                <td><strong>2. El estudiante ha hecho uso del PAE &nbsp;&nbsp;<span style="color:#FF0000; font-size:10px" >*</span></strong></td>
                                <td>&nbsp;&nbsp;</td>
                                <td><strong>Si</strong>&nbsp;&nbsp;<input type="radio" id="Si_Pae" name="PAE" onclick="Ver_PAE()" />&nbsp;&nbsp;&nbsp;<strong>NO</strong>&nbsp;&nbsp;<input type="radio" id="No_Pae" name="PAE" onclick="Ver_PAE()" /></td>
                                <td>&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="4">&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <div id="Div_PAE" style="display:none; width:100%" align="center">
                                        <table width="50%" align="center" border="0">
                                            <tr>
                                                <td><strong>Por Que Razones...?</strong></td>
                                                <td colspan="2">&nbsp;&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">&nbsp;&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <table width="100%" align="center" border="0">
                                                        <tr>
                                                            <td width="12%">&nbsp;&nbsp;</td>
                                                            <td width="71%"><strong>* Acad&eacute;micas</strong></td>
                                                            <td width="4%">&nbsp;&nbsp;</td>
                                                            <td width="8%"><input type="checkbox" id="Academicas_PAE" name="Opcione_PAE" /></td>
                                                            <td width="5%">&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5">&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><strong>* Psicosociales</strong></td>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><input type="checkbox" id="psicosociales_PAE" name="Opcione_PAE" /></td>
                                                            <td>&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5">&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><strong>* Económicas</strong></td>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><input type="checkbox" id="economicas_PAE" name="Opcione_PAE" /></td>
                                                            <td>&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5">&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><strong>* Competencias Básicas de Estudio</strong></td>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><input type="checkbox" id="Competencias_PAE" name="Opcione_PAE" /></td>
                                                            <td>&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5">&nbsp;&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td>&nbsp;&nbsp;</td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" align="center" border="0">
                            <tr>
                                <td><strong>3. Clasifique de 1 a 5, siendo 1 mínimo y 5 máximo, los siguientes aspectos en cuanto a  la adaptación del estudiante a la vida universitaria &nbsp;&nbsp;<span style="color:#FF0000; font-size:10px" >*</span></strong></td>
                                <td colspan="2">&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="3">&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <table width="50%" align="left" border="0">
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>* Manejo de la independencia y autonomía</strong></td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td>
                                                <select id="independecia" name="independecia" class="CajasHoja">
                                                    <option value="-1">Elige...</option>
                                                    <option value="1">1 - Minimo</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5 - M&aacute;ximo</option>
                                                </select>
                                            </td>
                                            <td>&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>* Métodos, técnicas y hábitos de estudio</strong></td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td>
                                                <select id="Metodos" name="Metodos" class="CajasHoja">
                                                    <option value="-1">Elige...</option>
                                                    <option value="1">1 - Minimo</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5 - M&aacute;ximo</option>
                                                </select>
                                            </td>
                                            <td>&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>* Manejo y distribución del tiempo</strong></td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td>
                                                <select id="DistribuTiempo" name="DistribuTiempo" class="CajasHoja">
                                                    <option value="-1">Elige...</option>
                                                    <option value="1">1 - Minimo</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5 - M&aacute;ximo</option>
                                                </select>
                                            </td>
                                            <td>&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>* Trabajo en equipo</strong></td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td>
                                                <select id="TrabEquipo" name="TrabEquipo" class="CajasHoja">
                                                    <option value="-1">Elige...</option>
                                                    <option value="1">1 - Minimo</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5 - M&aacute;ximo</option>
                                                </select>
                                            </td>
                                            <td>&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>* Socialización</strong></td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td>
                                                <select id="Socializacion" name="Socializacion" class="CajasHoja">
                                                    <option value="-1">Elige...</option>
                                                    <option value="1">1 - Minimo</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5 - M&aacute;ximo</option>
                                                </select>
                                            </td>
                                            <td>&nbsp;&nbsp;</td>
                                        </tr>
                                    </table>
                                    <table width="50%" align="right" border="0">
                                        <tr>
                                            <td width="2%">&nbsp;&nbsp;</td>
                                            <td width="59%"><strong>* Priorización de actividades</strong></td>
                                            <td width="3%">&nbsp;&nbsp;</td>
                                            <td width="34%">
                                                <select id="PrioriActividades" name="PrioriActividades" class="CajasHoja">
                                                    <option value="-1">Elige...</option>
                                                    <option value="1">1 - Minimo</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5 - M&aacute;ximo</option>
                                                </select>
                                            </td>
                                            <td width="2%">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>* Cambios al interior de la familia </strong></td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td>
                                                <select id="InterFamilia" name="InterFamilia" class="CajasHoja">
                                                    <option value="-1">Elige...</option>
                                                    <option value="1">1 - Minimo</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5 - M&aacute;ximo</option>
                                                </select>
                                            </td>
                                            <td>&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>* Comprensión de lectura </strong></td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td>
                                                <select id="CompLectura" name="CompLectura" class="CajasHoja">
                                                    <option value="-1">Elige...</option>
                                                    <option value="1">1 - Minimo</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5 - M&aacute;ximo</option>
                                                </select>
                                            </td>
                                            <td>&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>* Manejo de conflictos</strong></td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td>
                                                <select id="conflictos" name="conflictos" class="CajasHoja">
                                                    <option value="-1">Elige...</option>
                                                    <option value="1">1 - Minimo</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5 - M&aacute;ximo</option>
                                                </select>
                                            </td>
                                            <td>&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>* Otro</strong></td>
                                            <td colspan="2">
                                                <table>
                                                    <tr>
                                                        <td><input type="text" id="Cual_Adaptacion" name="Cual_Adaptacion" class="CajasHoja" /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td>
                                                            <select id="OtroEscala" name="OtroEscala" class="CajasHoja">
                                                                <option value="-1">Elige...</option>
                                                                <option value="1">1 - Minimo</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5 - M&aacute;ximo</option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td>&nbsp;&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td> 
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" align="center" border="0">
                            <tr>
                                <td><strong>4. Cuál de las siguientes opciones describe mejor la forma en que el estudiante reacciona cuando tiene un problema &nbsp;&nbsp;<span style="color:#FF0000; font-size:10px" >*</span></strong></td>
                                <td colspan="2">&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="3">&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <table width="50%" align="left" border="0">
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td width="55%"><strong>* Lo evade </strong></td>
                                            <td>&nbsp;&nbsp;<input type="radio" id="Lo_evade" name="Problema" onclick="Ver_OtroProblema()" /></td>
                                            <td>&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>    
                                            <td>&nbsp;&nbsp;</td>
                                            <td width="55%"><strong>* Lo afronta  </strong></td>
                                            <td>&nbsp;&nbsp;<input type="radio" id="Lo_afronta" name="Problema" onclick="Ver_OtroProblema()" /></td>
                                            <td>&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>    
                                            <td>&nbsp;&nbsp;</td>
                                            <td width="55%"><strong>* Se agrede a sí mismo</strong></td>
                                            <td>&nbsp;&nbsp;<input type="radio" id="Se_agrede" name="Problema" onclick="Ver_OtroProblema()" /></td>
                                            <td>&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>    
                                            <td>&nbsp;&nbsp;</td>
                                            <td width="55%"><strong>* Comienza a enfermarse </strong></td>
                                            <td>&nbsp;&nbsp;<input type="radio" id="enfermarse" name="Problema" onclick="Ver_OtroProblema()" /></td>
                                            <td>&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">&nbsp;&nbsp;</td>
                                        </tr>
                                    </table>
                                    <table width="50%" align="right" border="0">
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td width="55%"><strong>* Se desquita con otras personas  </strong></td>
                                            <td>&nbsp;&nbsp;<input type="radio" id="Se_desquita" name="Problema" onclick="Ver_OtroProblema()" /></td>
                                            <td>&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>    
                                            <td>&nbsp;&nbsp;</td>
                                            <td width="55%"><strong>* Se deprime</strong></td>
                                            <td>&nbsp;&nbsp;<input type="radio" id="Se_deprime" name="Problema" onclick="Ver_OtroProblema()" /></td>
                                            <td>&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>    
                                            <td>&nbsp;&nbsp;</td>
                                            <td width="55%"><strong>* Se pone ansio</strong></td>
                                            <td>&nbsp;&nbsp;<input type="radio" id="Ansieda" name="Problema" onclick="Ver_OtroProblema()" /></td>
                                            <td>&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>    
                                            <td>&nbsp;&nbsp;</td>
                                            <td width="55%"><strong>* Otro</strong></td>
                                            <td>&nbsp;&nbsp;<input type="radio" id="Otro_Problema" name="Problema" onclick="Ver_OtroProblema()" /></td>
                                            <td>&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr id="Tr_OtroProblema" class="toggleOptions" style="visibility:collapse"> 
                                            <td>&nbsp;&nbsp;</td>   
                                            <td colspan="2">
                                                <table border="0" width="100%" align="center">
                                                    <tr>
                                                        <td><strong>¿Cuál ?</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" id="Cual_Problema" name="Cual_Problema" class="CajasHoja" /></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td>&nbsp;&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td> 
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" align="center" border="0">
                            <tr>
                                <td><strong>5. Indique el grado de apoyo que representa para el estudiante cada una de las siguientes personas.  &nbsp;&nbsp;<span style="color:#FF0000; font-size:10px" >*</span></strong></td>
                                <td colspan="2">&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="3">&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <table width="50%" align="center" border="0">
                                        <tr>
                                            <td width="11%">&nbsp;&nbsp;</td>
                                            <td width="20%"><strong>* Padre</strong></td>
                                            <td width="2%">&nbsp;</td>
                                            <td width="58%">
                                                <table border="0" align="center" width="100%">
                                                    <tr>
                                                        <td width="5%">&nbsp;&nbsp;</td>
                                                        <td width="21%"><input type="text" id="Padre_Por" name="Padre_Por" class="CajasHoja" maxlength="3" size="3" style="text-align:center" />&nbsp;<strong style="font-size:12px">%</strong></td>
                                                        <td width="2%">&nbsp;&nbsp;</td>
                                                        <td width="66%"><input type="text" id="Padre_Descri" name="Padre_Descri" class="CajasHoja"  /></td>
                                                        <td width="6%">&nbsp;&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td width="9%">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>* Madre</strong></td>
                                            <td width="2%">&nbsp;</td>
                                            <td width="58%">
                                                <table border="0" align="center" width="100%">
                                                    <tr>
                                                        <td width="5%">&nbsp;&nbsp;</td>
                                                        <td width="21%"><input type="text" id="Madre_Por" name="Madre_Por" class="CajasHoja" maxlength="3" size="3" style="text-align:center" />&nbsp;<strong style="font-size:12px">%</strong></td>
                                                        <td width="2%">&nbsp;&nbsp;</td>
                                                        <td width="66%"><input type="text" id="Madre_Descri" name="Madre_Descri" class="CajasHoja"  /></td>
                                                        <td width="6%">&nbsp;&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>* Hermano</strong></td>
                                            <td width="2%">&nbsp;</td>
                                            <td width="58%">
                                                <table border="0" align="center" width="100%">
                                                    <tr>
                                                        <td width="5%">&nbsp;&nbsp;</td>
                                                        <td width="21%"><input type="text" id="Hermano_Por" name="Hermano_Por" class="CajasHoja" maxlength="3" size="3" style="text-align:center" />&nbsp;<strong style="font-size:12px">%</strong></td>
                                                        <td width="2%">&nbsp;&nbsp;</td>
                                                        <td width="66%"><input type="text" id="Hermano_Descri" name="Hermano_Descri" class="CajasHoja"  /></td>
                                                        <td width="6%">&nbsp;&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>* Hermana</strong></td>
                                            <td width="2%">&nbsp;</td>
                                            <td width="58%">
                                                <table border="0" align="center" width="100%">
                                                    <tr>
                                                        <td width="5%">&nbsp;&nbsp;</td>
                                                        <td width="21%"><input type="text" id="Hermana_Por" name="Hermana_Por" class="CajasHoja" maxlength="3" size="3" style="text-align:center" />&nbsp;<strong style="font-size:12px">%</strong></td>
                                                        <td width="2%">&nbsp;&nbsp;</td>
                                                        <td width="66%"><input type="text" id="Hermana_Descri" name="Hermana_Descri" class="CajasHoja"  /></td>
                                                        <td width="6%">&nbsp;&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>* Amigos</strong></td>
                                            <td width="2%">&nbsp;</td>
                                            <td width="58%">
                                                <table border="0" align="center" width="100%">
                                                    <tr>
                                                        <td width="5%">&nbsp;&nbsp;</td>
                                                        <td width="21%"><input type="text" id="Amigos_Por" name="Amigos_Por" class="CajasHoja" maxlength="3" size="3" style="text-align:center" />&nbsp;<strong style="font-size:12px">%</strong></td>
                                                        <td width="2%">&nbsp;&nbsp;</td>
                                                        <td width="66%"><input type="text" id="Amigos_Descri" name="Amigos_Descri" class="CajasHoja"  /></td>
                                                        <td width="6%">&nbsp;&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>* Pareja</strong></td>
                                            <td width="2%">&nbsp;</td>
                                            <td width="58%">
                                                <table border="0" align="center" width="100%">
                                                    <tr>
                                                        <td width="5%">&nbsp;&nbsp;</td>
                                                        <td width="21%"><input type="text" id="Pareja_Por" name="Pareja_Por" class="CajasHoja" maxlength="3" size="3" style="text-align:center" />&nbsp;<strong style="font-size:12px">%</strong></td>
                                                        <td width="2%">&nbsp;&nbsp;</td>
                                                        <td width="66%"><input type="text" id="Pareja_Descri" name="Pareja_Descri" class="CajasHoja"  /></td>
                                                        <td width="6%">&nbsp;&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">&nbsp;&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;</td>
                </tr>
            </table>
        </fieldset>
        <?php
    }

    public function ActividadLaboral($id_Estudiante) {

        global $db, $userid, $rol_Usuario;
        ?>
        <fieldset style="height:100%; width:100%;  border-top-left-radius:2em;border-bottom-right-radius:2em;border:#88AB0C solid 1px ">
            <table width="95%" align="center" border="0" style="margin-left:2%; margin-right:2%; margin-bottom:2%;font-size:12px">
                <tr>
                    <td>&nbsp;<input type="hidden" id="Estudiante_id" value="<?php echo $id_Estudiante ?>" /></td>
                </tr>
        <?php
        $SQL_Max_Laboral = 'SELECT 
										
										MAX(idestudianteactividalaboral) AS id 
										
										FROM estudianteactividalaboral
										
										WHERE
										
										idestudiantegeneral="' . $id_Estudiante . '"
										AND
										codigoestado=100';

        if ($Max_Laboral = &$db->Execute($SQL_Max_Laboral) === false) {
            echo 'Error en el SQL MAx LAboral........<br>' . $SQL_Max_Laboral;
            die;
        }

        $SQL_Detalle_Laboral = 'SELECT 

												trabaja,
												tipocontrato,
												trabajorelacionadoestudio,
												tipoempresa
												
												FROM estudianteactividalaboral
												
												WHERE
												
												idestudiantegeneral="' . $id_Estudiante . '"
												AND
												codigoestado=100
												AND
												idestudianteactividalaboral="' . $Max_Laboral->fields['id'] . '"';

        if ($ActividaLAboral_Detalle = &$db->Execute($SQL_Detalle_Laboral) === false) {
            echo 'Error en el SQL Detalle Activida Laboral-..........<br>' . $SQL_Detalle_Laboral;
            die;
        }

        $Ver_Trabajo = 'style="visibility:collapse"';

        if (!$ActividaLAboral_Detalle->EOF) {

            if ($ActividaLAboral_Detalle->fields['trabaja'] == 0) {
                $Trabaj_Si = 'checked="checked"';
                $Ver_Trabajo = 'style="visibility:visible"';

                /*                 * ****************************************************** */
                if ($ActividaLAboral_Detalle->fields['tipocontrato'] == 0) {#empleado
                    $Empleado = 'checked="checked"';
                    $Independiente = '';
                }

                if ($ActividaLAboral_Detalle->fields['tipocontrato'] == 1) {#Independiente
                    $Empleado = '';
                    $Independiente = 'checked="checked"';
                }
                if ($ActividaLAboral_Detalle->fields['trabajorelacionadoestudio'] == 0) {#Si
                    $Relacion_Si = 'checked="checked"';
                }

                if ($ActividaLAboral_Detalle->fields['trabajorelacionadoestudio'] == 1) {#NO
                    $Relacion_No = 'checked="checked"';
                }

                if ($ActividaLAboral_Detalle->fields['tipoempresa'] == 1) {#Propia
                    $Propia = 'checked="checked"';
                }

                if ($ActividaLAboral_Detalle->fields['tipoempresa'] == 2) {#Familiar
                    $Familiar = 'checked="checked"';
                }

                if ($ActividaLAboral_Detalle->fields['tipoempresa'] == 3) {#Externa
                    $Externa = 'checked="checked"';
                }
                /*                 * ****************************************************** */
            }
            if ($ActividaLAboral_Detalle->fields['trabaja'] == 1) {
                $Trabaj_No = 'checked="checked"';
                $Ver_Trabajo = 'style="visibility:collapse"';
            }
        }
        ?>
                <tr>
                    <td>
                        <table border="0" width="100%" align="center">
                            <tr>
                                <td>&nbsp;&nbsp;</td>
                                <td><strong>¿Usted trabaja actualmente ? &nbsp;&nbsp;<span style="color:#FF0000; font-size:10px" >*</span></strong></td>
                                <td>&nbsp;&nbsp;</td>
                                <td><strong>Si</strong>&nbsp;&nbsp;&nbsp;<input type="radio" id="Trab_Si" name="Tb_Actual" onclick="Ver_Empleo();" <?php echo $Trabaj_Si ?> /></td>
                                <td><strong>No</strong>&nbsp;&nbsp;&nbsp;<input type="radio" id="Trab_No" name="Tb_Actual" onclick="Ver_Empleo();"<?php echo $Trabaj_No ?> /></td>
                                <td>&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="6">&nbsp;&nbsp;</td>
                            </tr>
                            <tr class="Empleo_Ver" <?php echo $Ver_Trabajo ?>> 
                                <td>&nbsp;&nbsp;</td>
                                <td colspan="2"><strong>Usted es: &nbsp;&nbsp;<span style="color:#FF0000; font-size:10px" >*</span></strong></td>
                                <td colspan="3">&nbsp;&nbsp;</td>
                            </tr>
                            <tr class="Empleo_Ver" <?php echo $Ver_Trabajo ?>>
                                <td colspan="6">&nbsp;&nbsp;</td>
                            </tr>
                            <tr class="Empleo_Ver" <?php echo $Ver_Trabajo ?>>
                                <td>&nbsp;&nbsp;</td>
                                <td colspan="4">
                                    <table border="0" width="60%" align="center">
                                        <tr>
                                            <td><strong>Empleado &nbsp;&nbsp;<span style="color:#FF0000; font-size:10px" >*</span></strong></td>
                                            <td>&nbsp;&nbsp;&nbsp;<input type="radio" id="Empl_Si" name="Forma_Trabjo" <?php echo $Empleado ?> /></td>
                                            <td><strong> Independiente</strong></td>
                                            <td>&nbsp;&nbsp;&nbsp;<input type="radio" id="Ind_Si" name="Forma_Trabjo" <?php echo $Independiente ?> /></td>
                                        </tr>
                                    </table>
                                </td>
                                <td>&nbsp;&nbsp;</td>
                            </tr>
                            <tr class="Empleo_Ver" <?php echo $Ver_Trabajo ?>>
                                <td colspan="6">&nbsp;&nbsp;</td>
                            </tr>
                            <tr class="Empleo_Ver" <?php echo $Ver_Trabajo ?>>
                                <td>&nbsp;&nbsp;</td>
                                <td><strong>¿Su trabajo está relacionado con su carrera ? &nbsp;&nbsp;<span style="color:#FF0000; font-size:10px" >*</span></strong></td>
                                <td>&nbsp;&nbsp;</td>
                                <td><strong>Si</strong>&nbsp;&nbsp;&nbsp;<input type="radio" id="Relacion_Si" name="Trbajo" <?php echo $Relacion_Si ?> /></td>
                                <td><strong>No</strong>&nbsp;&nbsp;&nbsp;<input type="radio" id="Relacion_No" name="Trbajo" <?php echo $Relacion_No ?>/></td>
                                <td>&nbsp;&nbsp;</td>
                            </tr>
                            <tr class="Empleo_Ver" <?php echo $Ver_Trabajo ?>>
                                <td colspan="6">&nbsp;&nbsp;</td>
                            </tr>
                            <tr class="Empleo_Ver" <?php echo $Ver_Trabajo ?>>
                                <td>&nbsp;&nbsp;</td>
                                <td colspan="2"><strong>4. La empresa en la que trabaja es: &nbsp;&nbsp;<span style="color:#FF0000; font-size:10px" >*</span></strong></td>
                                <td colspan="3">&nbsp;&nbsp;</td>
                            </tr>
                            <tr class="Empleo_Ver" <?php echo $Ver_Trabajo ?>>
                                <td colspan="6">&nbsp;&nbsp;</td>
                            </tr>
                            <tr class="Empleo_Ver" <?php echo $Ver_Trabajo ?>>
                                <td colspan="1">&nbsp;&nbsp;</td>
                                <td colspan="3">
                                    <table width="50%" align="center" border="0">
                                        <tr>
                                            <td>*<strong>Propia</strong></td>
                                            <td>&nbsp;&nbsp;&nbsp;<input type="radio" id="Propia" name="Empresa" <?php echo $Propia ?> /></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>*<strong>Familiar</strong></td>
                                            <td>&nbsp;&nbsp;&nbsp;<input type="radio" id="Familiar" name="Empresa" <?php echo $Familiar ?> /></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>*<strong>Externa</strong></td>
                                            <td>&nbsp;&nbsp;&nbsp;<input type="radio" id="Externa" name="Empresa" <?php echo $Externa ?> /></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">&nbsp;&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                                <td colspan="2">&nbsp;&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </fieldset>
                <?php
            }

            public function BienestarUniversitario($id_Estudiante, $idUsuario = null) {
                global $db, $userid, $rol_Usuario;

                if ($idUsuario != null) {
                    $userid = $idUsuario;
                }
                /*                 * ********************************************************** */

                $SQLPermiso = 'SELECT

							id_permisoHojavidaestudiante AS id,
							usuario_id,
							usuarioname,
							permiso
							
							FROM 
							permisoHojavidaestudiante 
							
							WHERE 
							usuario_id = "' . $userid . '" 
							AND 
							codigoestado=100';

                if ($PermisoFormulario = &$db->Execute($SQLPermiso) === false) {
                    echo 'Error en el SQL Permisos....<br><br>' . $SQLPermiso;
                    die;
                }

                $Permiso = $PermisoFormulario->fields['permiso'];

                /*                 * ********************************************************** */

                if ($Permiso == 1) {
                    /*                     * ********************** */
                    $DisableDeporte = '';
                    $DisableSalud = 'disabled="disabled"';
                    $DisableCultura = 'disabled="disabled"';
                    $DisableGrupos = 'disabled="disabled"';
                    /*                     * ********************** */
                }
                /*                 * ****************************************** */
                if ($Permiso == 2) {
                    /*                     * ********************** */
                    $DisableDeporte = 'disabled="disabled"';
                    $DisableSalud = '';
                    $DisableCultura = 'disabled="disabled"';
                    $DisableGrupos = 'disabled="disabled"';
                    /*                     * ********************** */
                }
                /*                 * ****************************************** */
                if ($Permiso == 3) {
                    /*                     * ********************** */
                    $DisableDeporte = 'disabled="disabled"';
                    $DisableSalud = 'disabled="disabled"';
                    $DisableCultura = '';
                    $DisableGrupos = 'disabled="disabled"';
                    /*                     * ********************** */
                }
                /*                 * ****************************************** */
                if ($Permiso == 4) {
                    /*                     * ********************** */
                    $DisableDeporte = 'disabled="disabled"';
                    $DisableSalud = 'disabled="disabled"';
                    $DisableCultura = 'disabled="disabled"';
                    $DisableGrupos = '';
                    /*                     * ********************** */
                }
                /*                 * ********************************************************** */
                ?>

        <div id="Intro_Bienestar" style="width:95%; margin-left:3%; margin-right:3%; margin-bottom:2%; margin-top:2%" align="justify">
            <strong>Los siguientes campos dan cuenta de la utilización que el estudiante hace de los servicios y actividades ofrecidos por Bienestar Universitario. Señale los campos en los que participa el estudiantes y especifique cuando sea requerido.Agradecemos su oportuna actualización</strong>
        </div>
        <br />
        <input type="hidden" id="PermisoUsuario" value="<?php echo $Permiso ?>" />
        <input type="hidden" id="Estudiante_id" value="<?php echo $id_Estudiante ?>" />
        <br />
        <table width="20%" align="right" border="0" style="">
            <thead>
                <tr>
                    <th><strong>Periodo</strong></th>
                    <td>&nbsp;&nbsp;</td>
                    <td><?php $this->Periodo('P_General', 'Seleccione Periodo', '', 'BuscarDataBienestar') ?></td>
                </tr>
            </thead>
        </table>
        <input type="hidden" id="id_Bienestar" />
        <br />
        <fieldset class="deportesForm" style="border:#88AB0C solid 1px; height:100%; width:100%; ">
            <legend>Participación en Deportes y Actividad Física</legend>
            <table width="95%" align="center" border="0" style="margin-left:2%; margin-right:2%; margin-bottom:2%;font-size:12px">
                <tr>
                    <td>&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>
        <?php $this->Pregunta('1. Participación en selecciones de la Universidad', 'Si_Selec', 'No_Selec', 'Seleciones', 'Ver_Seleciones', $DisableDeporte); ?>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr id="Tr_OpcioneSelecion" class="toggleOptions" style="visibility:collapse">
                    <td>
        <?php
        $name = 'Perido_inicial_Seleccion';
        $nameFinal = 'Perido_Final_Seleccion';

        $this->Respuestas('radio', 'USeleciones', $name, $nameFinal, 'seleccion', $DisableDeporte, 0, '_Selec', 0, 'index_SL', 'Cadena'); //checkbox
        ?>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>
        <?php $this->Pregunta('2. Participación en competencias con apoyo de la Universidad', 'Si_Apoyo', 'No_Apoyo', 'Equipo_Univ', 'Ver_ApoyosUniversida', $DisableDeporte); ?>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr id="Tr_ApoyosUniversidad" class="toggleOptions" style="visibility:collapse">
                    <td>
        <?php
        $name = 'Perido_ini_Apoyo';
        $nameFinal = 'Perido_Fin_Apoyo';

        $this->Respuestas('radio', 'Apoyo_Universidad', $name, $nameFinal, 'competencia', $DisableDeporte, 0, '_Apoyo', 0, 'indexAp', 'CadeanaAp'); //checkbox
        ?>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>
        <?php $this->Pregunta('3. Participación en Talleres Formativos Deportivos ', 'Si_Talleres', 'No_Talleres', 'TalleresDeport', 'Ver_TalleresDeportivos', $DisableDeporte); ?>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr id="Tr_TallerDeportes" class="toggleOptions" style="visibility:collapse">
                    <td>
        <?php
        $name = '';
        $nameFinal = '';

        $this->Respuestas('checkbox', 'Tipo_Taller', $name, $nameFinal, 'taller', $DisableDeporte, 1, '_Taller', 0, 'indexTll', 'CadenaTll', 'P_ini_', 'P_fin_', 'id_tallerB_'); //checkbox
        ?>
                        <input type="hidden" id="CadenaExite" />
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>
        <?php $this->Pregunta('4. Logros Deportivos en representacion de la Universidad', 'Si_LogroDepor', 'No_LogroDepor', 'LogroDeportivo', 'Ver_LogroDeportivo', $DisableDeporte); ?>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr id="Td_TituloCualLogro" class="toggleOptions" style="visibility:collapse">
                    <td>
        <?php $this->CajaRespuesta('Cual_logroDeprot', 'P_ini_LogroDeport', 'P_fin_LogroDeport', $DisableDeporte, 0); ?>
                    </td>   
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>
        <?php $this->Pregunta('5. Ha recibido Becas o Estímulos de Bienestar', 'Si_BecasEstimulos', 'No_BecasEstimulos', 'BecasEstimulos', 'Ver_BecasEstimulos', $DisableDeporte); ?>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr id="Tr_BecasEstimulos" class="toggleOptions" style="visibility:collapse">
                    <td>
        <?php $this->CajaRespuesta('Cua_BecasEstimulos', 'P_ini_BecasDeport', 'P_fin_BecasDeport', $DisableDeporte, 0); ?>
                    </td>   
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>
        <?php $this->Pregunta('6. Actualmente asiste a el Centro de Acondicionamiento Físico ', 'Si_Gym', 'No_Gym', 'Gimnasio', 'Ver_AsitenciaGimnasio', $DisableDeporte); ?>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr id="Tr_CuantasVeces" class="toggleOptions" style="visibility:collapse">
                    <td colspan="1">
                        <table border="0" width="100%" align="center">
                            <tr>
                                <td>&nbsp;&nbsp;</td>
                                <td><strong>* Cuantas veces por semana?</strong></td>
                                <td colspan="2">&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="4">&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;&nbsp;</td>
                                <td colspan="2">
                                    <table border="0" align="center" width="100%">
                                        <tr>
                                            <td width="21%"><strong>- Menos de Una Vez </strong></td>
                                            <td width="7%">&nbsp;&nbsp;</td>
                                            <td width="72%"><input type="radio" id="Gym_Menos" name="AsistenciaGym" <?php echo $DisableDeporte ?> /></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td width="21%"><strong>- Una Vez</strong></td>
                                            <td width="7%">&nbsp;&nbsp;</td>
                                            <td width="72%"><input type="radio" id="Gym_Uno" name="AsistenciaGym" <?php echo $DisableDeporte ?> /></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td><strong>- Dos Veces</strong></td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><input type="radio" id="Gym_dos" name="AsistenciaGym" <?php echo $DisableDeporte ?> /></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td><strong>- Tres Veces</strong></td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><input type="radio" id="Gym_tres" name="AsistenciaGym" <?php echo $DisableDeporte ?> /></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td><strong>- Más de Tres Veces</strong></td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><input type="radio" id="Gym_Mas" name="AsistenciaGym" <?php echo $DisableDeporte ?> /></td>
                                        </tr>   
                                        <tr>
                                            <td colspan="3">&nbsp;&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                                <td>&nbsp;&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>
        <?php $this->Pregunta('7.  Hace parte del Club Running', 'Si_ClubRunning', 'No_ClubRunning', 'ClubRunning', 'Ver_ClubRunning', $DisableDeporte); ?>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;</td>
                </tr>
                <tr id="Td_CajaFechaVinculacion" class="toggleOptions" style="visibility:collapse">
                    <td>&nbsp;&nbsp;</td>
                    <td>
        <?php $this->Periodo('FechaVinculacion', 'Periodo', $DisableDeporte); ?>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <?php $this->Pregunta('8. Club de Caminantes', 'Si_ClubCaminantes', 'No_ClubCaminantes', 'ClubCaminantes', 'Ver_ClubCaminantes', $DisableDeporte); ?>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;</td>
                </tr>
                <tr id="Td_CajaFechaVinculacionCaminantes" class="toggleOptions" style="visibility:collapse">
                    <td>&nbsp;&nbsp;</td>
                    <td>
        <?php $this->Periodo('FechaVinculacionCaminantes', 'Periodo', $DisableDeporte); ?>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;</td>
                </tr>
            </table>
        </fieldset>
        <br /><br />
        <fieldset style="border:#88AB0C solid 1px; height:100%; width:100%; " class="saludbienestar" >
            <legend>Participación en acciones del cuidado de la salud</legend>
            <table width="95%" align="center" border="0" style="margin-left:2%; margin-right:2%; margin-bottom:2%;font-size:12px">
                <tr>
                    <td>&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <table border="0" width="100%" align="center">
                            <tr>
                                <td colspan="2"><legend>Uso de Servicios de Salud</legend></td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;</td>
                    <td>
                        <table border="0" width="100%" align="center">
                            <tr>
                                <td width="3%">&nbsp;&nbsp;</td>
                                <td width="35%"><strong>Asesoria psicológica</strong></td>
                                <td width="1%">&nbsp;&nbsp;</td>
                                <td width="57%"><input type="text" id="Num_Ase_Psico" name="Num_Ase_Psico" class="CajasHoja" <?php echo $DisableSalud; ?> value="0" /></td>
                                <td width="4%">&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="5">&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="3%">&nbsp;&nbsp;</td>
                                <td width="35%"><strong>Medicina General</strong></td>
                                <td width="1%">&nbsp;&nbsp;</td>
                                <td width="57%"><input type="text" id="Num_MedGeneral" name="Num_MedGeneral" class="CajasHoja" <?php echo $DisableSalud; ?> readonly /></td>
                                <td width="4%">&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="5">&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="3%">&nbsp;&nbsp;</td>
                                <td width="35%"><strong>Medicina del Deporte</strong></td>
                                <td width="1%">&nbsp;&nbsp;</td>
                                <td width="57%"><input type="text" id="Num_MedDeporte" name="Num_MedDeporte" class="CajasHoja" <?php echo $DisableSalud; ?> readonly /></td>
                                <td width="4%">&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="5">&nbsp;&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
        </tr>
        <tr>
            <td>
                <table border="0" width="100%" align="center">
                    <tr>
                        <td colspan="2"><legend>Actividades de Promoción y Prevención</legend></td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;</td>
            <td>
                <table border="0" width="100%" align="center" class="requiredInputs">
        <?php include_once("./functionsSalud.php");
        echo pintarActividadesPromocionYPrevencion($db, $DisableSalud);
        ?>
                </table>
            </td>
        </tr>
        </table>
        </td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;</td>
        </tr>
        <tr>
            <td>
                <table border="0" width="100%" align="center">
                    <tr>
                        <td><legend>Incapacidades</legend></td>
            <td>&nbsp;&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;</td>
            <td>

                <table border="0" width="100%" align="center" id="Table_Fechas">
        <?php if ($DisableSalud === "" || $DisableSalud == null) { ?>
                        <tr>
                            <td colspan="5" align="right"><strong>Para Adicionar Un Nuevo Campo</strong>&nbsp;&nbsp;<img src="../../images/add.png" title="Adicionar una Celda Nueva." onclick="AddFechas()" width="25" style="position:relative;top:7px" /></td>
                        </tr>
                        <?php } ?>
                    <tr>
                        <td colspan="5">&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
        <?php $this->FechasIncapacidad(0, $DisableSalud); ?>
                    </tr>
                </table>

            </td>
        </tr>
        </table>
        </td>
        </tr>
        <tr>
            <td>&nbsp;&nbsp;<input type="hidden" id="numIndicesFeha" name="numIndicesFeha" value="0" />&nbsp;&nbsp;
                <input type="hidden" id="CadenaIncapacidad" name="CadenaIncapacidad" />
            </td>
        </tr>
        </table>                  	
        </fieldset>     
        <br /><br />
        <fieldset class="culturalForm" style="border:#88AB0C solid 1px; height:100%; width:100%; ">
            <legend>Participación en actividades culturales y/o artísticas</legend>
            <table width="95%" align="center" border="0" style="margin-left:2%; margin-right:2%; margin-bottom:2%;font-size:12px">
                <tr>
                    <td>&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>
        <?php $this->Pregunta('1. Participación en grupos culturales de la Universidad', 'Si_GrupoCultura', 'No_GrupoCultura', 'Grupo_Cultura', 'VerTiposGrupoCultura', $DisableCultura); ?>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr id="Tr_TiposGruposCulturales" class="toggleOptions" style="visibility:collapse">
                    <td>
        <?php
        $name = 'P_ini_Grupo';
        $nameFinal = 'P_fin_Grupo';

        $this->Respuestas('radio', 'GruposCulturales', $name, $nameFinal, 'grupo', $DisableCultura, 0, '_Grup', 1, 'IndexGrupCul', 'C_GrupCultura'); //checkbox
        ?>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>
        <?php $this->Pregunta('2. Participación en Talleres formativos Culturales', 'Si_TalleresCultura', 'No_TalleresCultura', 'Talleres_Cultura', 'Ver_TalleresCultura', $DisableCultura); ?>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr id="Tr_TalleresCulturales" class="toggleOptions" style="visibility:collapse">
                    <td>
        <?php
        $name = '';
        $nameFinal = '';

        $this->Respuestas('checkbox', 'GruposCulturales', $name, $nameFinal, 'talleres', $DisableCultura, 1, '_TllCult', 1, 'IndexTllCultura', 'C_TallerCultura', 'P_ini', 'P_fin', 'id_BineTll_'); //checkbox
        ?>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>
        <?php $this->Pregunta('3. Logros Culturales', 'LogroCultural_Si', 'LogroCultural_No', 'LogroCultural', 'Ver_LogroCultural', $DisableCultura); ?>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr id="LogrosCulturales_Td" class="toggleOptions" style="visibility:collapse">
                    <td>
        <?php $this->CajaRespuesta('CualLogrosCulturales', 'P_ini_LogorCultura', 'P_fin_LogorCultura', $DisableCultura, 0); ?>
                    </td>   
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td>
        <?php $this->Pregunta('4. Becas o Estímulos de Bienestar', 'BecaCultural_Si', 'BecaCultural_No', 'BecaCultural', 'Ver_BecaCultural', $DisableCultura); ?>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr id="BecasCultural_TD" class="toggleOptions" style="visibility:collapse">
                    <td>
        <?php $this->CajaRespuesta('CualBecasCulturales', 'P_ini_BecaCultura', 'P_fin_BecaCultura', $DisableCultura, 0); ?>
                    </td>   
                </tr>
                <tr>
                    <td>&nbsp;&nbsp;</td>
                </tr>

            </table>                  	
        </fieldset>    
        <br /><br />
        <fieldset class="voluntariadoForm" style="border:#88AB0C solid 1px; height:100%; width:100%; ">
            <legend>Participación en Grupos Universitarios</legend>
            <table width="95%" align="center" border="0" style="margin-left:2%; margin-right:2%; margin-bottom:2%;font-size:12px">
                <tr>
                    <td>&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td style="width:100%">
                        <table border="0" width="100%" align="center">
                            <tr>
                                <td colspan="4">
        <?php $this->Pregunta('1. Pertenece al Voluntariado', 'Si_Volunta', 'No_Volunta', 'PertenceVoluntariado', 'Ver_Voluntariado', $DisableGrupos); ?>
                                </td>                 	
                            </tr>
                            <tr>
                                <td colspan="4">&nbsp;&nbsp;</td>
                            </tr>
                            <tr class="Tr_FechasVoluntario toggleOptions" style="visibility:collapse">
                                <td align="center"><input type="text" name="F_iniVoluntario" size="18" id="F_iniVoluntario" title="Fecha de Inicio" maxlength="12" tabindex="7" placeholder="Fecha de Inicio" autocomplete="off" value="" readonly <?php echo $DisableGrupos; ?>/></td>
                                <td>&nbsp;&nbsp;</td>
                                <td align="center"><input type="text" name="F_finVoluntario" size="18" id="F_finVoluntario" title="Fecha de Terminaci&oacute;n" maxlength="12" tabindex="7" placeholder="Fecha de Terminaci&oacute;n" autocomplete="off" value="" readonly <?php echo $DisableGrupos; ?> /></td>
                                <td>&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="4">&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="4">
        <?php $this->Pregunta('2. Pertenece al Grupo de Apoyo', 'Si_GrupoApoyoBienestar', 'No_GrupoApoyo', 'Grupo_Apoyo', 'Ver_ApoyoVoluntareado', $DisableGrupos); ?>
                                </td>                      	
                            </tr>
                            <tr>
                                <td colspan="4">&nbsp;&nbsp;</td>
                            </tr>
                            <tr id="Tr_FechasGrupoApoyoBienestar" class="toggleOptions" style="visibility:collapse">
                                <td align="right"><?php $this->Periodo("periodoInicialApoyoBienestar", 'Selecione Periodo Inicial', $DisableGrupos, ''); ?> </td>

                                <td>&nbsp;&nbsp;</td><td>  <?php $this->Periodo("periodoFinalApoyoBienestar", 'Selecione Periodo Final', $DisableGrupos, ''); ?> 
                                </td>
                                <td>&nbsp;&nbsp;</td> 
                            </tr>
                            <tr>
                                <td colspan="4">&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="4">
        <?php $this->Pregunta('3. Monitor Bienestar Universitario', 'Si_MonitoBienestar', 'No_MonitoBienestar', 'MonitoBienestar', 'Ver_MonitorVoluntareado', $DisableGrupos); ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">&nbsp;&nbsp;</td>
                            </tr>                                    
                            <tr id="Tr_OpcionesMonitorBienestar" class="toggleOptions" style="visibility:collapse">
                                <td align="right">
        <?php $this->Periodo("periodoInicialMonitor", 'Selecione Periodo Inicial', $DisableGrupos, ''); ?>
                                </td><td>&nbsp;&nbsp;</td><td style="width:200px;">
                        <?php $this->Periodo("periodoFinalMonitor", 'Selecione Periodo Final', $DisableGrupos, ''); ?> 
                                </td> <td> <select class="CajasHoja" style="width: auto; text-align:center" name="tipoMonitorBienestar" id="tipoMonitorBienestar" <?php echo $DisableGrupos; ?> >
                                        <option value="-1"> Elegir tipo de monitor</option></select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">&nbsp;&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>                  	
        </fieldset>    
                        <?php
                    }

                    public function FechasIncapacidad($j, $disable = "") {
                        global $db, $userid, $rol_Usuario;
                        ?>
        <td align="center"><strong><?php echo $j + 1; ?>. Incapacidad estudiante</strong></td>
        <td align="center"><strong>Transcrita</strong>&nbsp;&nbsp;&nbsp;
            <input type="radio" value="1" name="tipoIncapacidad_<?php echo $j ?>" id="transcrita_incapacidad_<?php echo $j ?>" <?php echo $disable; ?> >&nbsp;&nbsp;&nbsp;
            <strong>Emitida</strong>&nbsp;&nbsp;&nbsp;
            <input type="radio" value="2" name="tipoIncapacidad_<?php echo $j ?>" id="emitida_incapacidad_<?php echo $j ?>" <?php echo $disable; ?> >
        </td>
        <td align="center">&nbsp;&nbsp;</td>
        <td align="center"><input type="text" name="Fecha_InicioIncapacida_<?php echo $j ?>" size="14" id="Fecha_InicioIncapacida_<?php echo $j ?>" title="Fecha de inico de la incapacidad" maxlength="12" tabindex="7" placeholder="Fecha de Inicio" autocomplete="off" value="" readonly <?php echo $disable; ?> class="dateInput" /></td>
        <td align="center">&nbsp;&nbsp;</td>
        <td align="center"><input type="text" name="Fecha_FinalizacionIncapacidad_<?php echo $j ?>" size="14" id="Fecha_FinalizacionIncapacidad_<?php echo $j ?>" title="Fecha final de la incapacidad" maxlength="12" tabindex="7" placeholder="Fecha Final" autocomplete="off" value="" readonly <?php echo $disable; ?> class="dateInput" /></td>
        <td align="center">&nbsp;&nbsp;</td>
        <td align="center"><input type="text" id="Motivo_incapacida_<?php echo $j ?>" name="Motivo_incapacida_<?php echo $j ?>" class="CajasHoja" placeholder="Motivo de la Incapacidad" size="50" <?php echo $disable; ?> /><input type="hidden" value="" id="idIncapacidad_<?php echo $j ?>" name="idIncapacidad_<?php echo $j ?>" /></td>

                    <?php
                    }

                    public function OrganosGobierno() {
                        global $db, $userid, $rol_Usuario;
                        ?>
        <div id="Intro_OrganosDeGobierno" style="width:95%; margin-left:3%; margin-right:3%; margin-bottom:2%; margin-top:2%" align="justify">
            <strong>Conocer el grupo de representantes estudiantiles, nos permite mejorar los canales de comunicación con la comunidad.  Agradecemos la oportuna actualización de esta información</strong>
        </div>
        <br />
        <table width="95%" align="center" border="0" style="margin-left:2%; margin-right:2%; margin-bottom:2%;font-size:12px">
            <tr>
                <td>
                    <fieldset style="border:#88AB0C solid 1px; height:100%; width:100%; ">
                        <table border="0" align="center" width="100%">
                            <tr>
                                <td colspan="5">&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;&nbsp;</td>
                                <td><strong>1. Representante de Semestre</strong></td>
                                <td>&nbsp;&nbsp;</td>
                                <td><strong>Si.</strong>&nbsp;&nbsp;<input type="radio" id="Si_Representante" name="RepresentanteSemestre"  />&nbsp;&nbsp;&nbsp;<strong>No.</strong>&nbsp;&nbsp;<input type="radio" id="No_Representante" name="RepresentanteSemestre" /></td>
                                <td>&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="5">&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;&nbsp;</td>
                                <td><strong>2. Representante al Consejo de la Facultad</strong></td>
                                <td>&nbsp;&nbsp;</td>
                                <td><strong>Si.</strong>&nbsp;&nbsp;<input type="radio" id="Si_ConsejoFacul" name="ConsejoFacultad"  />&nbsp;&nbsp;&nbsp;<strong>No.</strong>&nbsp;&nbsp;<input type="radio" id="No_ConsejoFacul" name="ConsejoFacultad" /></td>
                                <td>&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="5">&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;&nbsp;</td>
                                <td><strong>3. Representante al Consejo Académico</strong></td>
                                <td>&nbsp;&nbsp;</td>
                                <td><strong>Si.</strong>&nbsp;&nbsp;<input type="radio" id="Si_ConsejoAcad" name="ConsejoAcademico"  />&nbsp;&nbsp;&nbsp;<strong>No.</strong>&nbsp;&nbsp;<input type="radio" id="No_ConsejoAcad" name="ConsejoAcademico" /></td>
                                <td>&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="5">&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;&nbsp;</td>
                                <td><strong>4. Representante al Consejo Directivo</strong></td>
                                <td>&nbsp;&nbsp;</td>
                                <td><strong>Si.</strong>&nbsp;&nbsp;<input type="radio" id="Si_ConsejoDir" name="ConsejoDirectivo"  />&nbsp;&nbsp;&nbsp;<strong>No.</strong>&nbsp;&nbsp;<input type="radio" id="No_ConsejoDir" name="ConsejoDirectivo" /></td>
                                <td>&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="5">&nbsp;&nbsp;</td>
                            </tr>
                        </table>
                    </fieldset>    
                </td>
            </tr>
        </table>
        <?php
    }

    public function ActividadInvestigacion() {
        global $db, $userid, $rol_Usuario;
        ?>
        <div id="Intro_Investigacion" style="width:95%; margin-left:3%; margin-right:3%; margin-bottom:2%; margin-top:2%" align="justify">
            <strong>La Universidad promueve la participación de los estudiantes en actividades de investigación como:  auxiliar de investigación, miembro de semilleros, autor o coautor de publicaciones, asistencia a congresos, ponencia en congresos, entre otros.<br /><br />
                Por favor registre la participación del estudiante en actividades de investigación en los siguiente campos:</strong>
        </div>
        <br />
        <table width="95%" align="center" border="0" style="margin-left:2%; margin-right:2%; margin-bottom:2%;font-size:12px">
            <tr>
                <td>
                    <fieldset style="border:#88AB0C solid 1px; height:100%; width:100%; ">
                        <table border="0" align="center" width="100%">
                            <tr>
                                <td colspan="5">&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;&nbsp;</td>
                                <td><strong>El estudiante ha participado en alguna de las actividades de Investigaci&oacute;n ?</strong></td>
                                <td>&nbsp;&nbsp;</td>
                                <td><strong>Si.</strong>&nbsp;&nbsp;<input type="radio" id="Si_Investiga" name="ActividadInvestiga" onclick="VerInstigaciones()"  />&nbsp;&nbsp;&nbsp;<strong>No.</strong>&nbsp;&nbsp;<input type="radio" id="No_Investiga" name="ActividadInvestiga" onclick="VerInstigaciones()" /></td>
                                <td>&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="5">&nbsp;&nbsp;</td>
                            </tr>
                            <tr id="Tr_Investigaciones" style="visibility:collapse">
                                <td colspan="5">
                                    <table align="center" width="100%" border="0">
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>1. Semillero de investigación </strong></td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>Si.</strong>&nbsp;&nbsp;<input type="radio" id="Si_Semillero" name="Semillero" onclick="Ver_Semillero()"  />&nbsp;&nbsp;&nbsp;<strong>No.</strong>&nbsp;&nbsp;<input type="radio" id="No_Semillero" name="Semillero" onclick="Ver_Semillero()" /></td>
                                            <td>&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr id="Tr_Semillero" style="visibility:collapse">
                                            <td>&nbsp;&nbsp;</td>
                                            <td colspan="4">
                                                <table border="0" align="center" width="100%">
                                                    <tr>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>Nombre del semillero</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" class="CajasHoja" id="Nom_Semillero" name="Nom_Semillero" /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>Fecha de Vinculación</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" name="FechaVinculacionSemillero" size="12" id="FechaVinculacionSemillero" title="Fecha Vinculacion" class="CajasHoja" maxlength="12" tabindex="7" placeholder="Fecha de Vinculacion" autocomplete="off" value="" readonly /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>Fecha de Fin</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" name="FechaFinSemillero" size="12" id="FechaFinSemillero" title="Fecha Fin Vinculacion" class="CajasHoja" maxlength="12" tabindex="7" placeholder="Fecha Fin" autocomplete="off" value="" readonly /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>Dependencia(s) Organizadora(s)</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" class="CajasHoja" id="Dependencia" name="Dependencia" /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="13">&nbsp;&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>2. Asistente o auxiliar de investigación</strong></td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>Si.</strong>&nbsp;&nbsp;<input type="radio" id="Si_Asistente" name="AsistenteInvestigacion" onclick="Ver_AsisInvestigacion()"  />&nbsp;&nbsp;&nbsp;<strong>No.</strong>&nbsp;&nbsp;<input type="radio" id="No_Asistente" name="AsistenteInvestigacion" onclick="Ver_AsisInvestigacion()"  /></td>
                                            <td>&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr id="Tr_AsistenteInvestigacion" style="visibility:collapse">
                                            <td colspan="5" align="center">
                                                <table border="0" align="center" width="100%">
                                                    <tr>
                                                        <td colspan="6">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td><strong>Nombre del proyecto</strong></td>
                                                        <td><strong>Docente responsable </strong></td>
                                                        <td><strong>Fecha inicial</strong></td>
                                                        <td><strong>Fecha final</strong></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td><input type="text" id="NombreProyecto_invg" name="NombreProyecto_invg" style="text-align:center" class="CajasHoja" /></td>
                                                        <td><input type="text" id="DocenteResp_invg" name="DocenteResp_invg" style="text-align:center" class="CajasHoja" /></td>
                                                        <td><input type="text" name="Fechainicio_invg" size="12" id="Fechainicio_invg" title="Fecha Inicial" maxlength="12" class="CajasHoja" tabindex="7" placeholder="Fecha Inicial" autocomplete="off" value="" readonly /></td>
                                                        <td><input type="text" name="Fechafin_invg" size="12" id="Fechafin_invg" title="Fecha Inicial" maxlength="12" class="CajasHoja" tabindex="7" placeholder="Fecha Final" autocomplete="off" value="" readonly /></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </table>                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>3. Participación en Publicaciones Internas (de la Facultad) </strong></td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>Si.</strong>&nbsp;&nbsp;<input type="radio" id="Si_Publicaciones" name="PublicacionesInternas" onclick="Ver_Publicacion()"  />&nbsp;&nbsp;&nbsp;<strong>No.</strong>&nbsp;&nbsp;<input type="radio" id="No_Publicaciones" name="PublicacionesInternas" onclick="Ver_Publicacion()"  /></td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr id="Table_Publicacion" style="visibility:collapse" >
                                            <td colspan="5" align="center">
                                                <table width="100%" align="center" border="0" >
                                                    <tr>
                                                        <td colspan="9">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>Autor</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" class="CajasHoja" id="Autor_Publicacion" name="Autor_Publicacion" /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>Nombre de la Publicación</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" class="CajasHoja" id="Nom_Publicacion" name="Nom_Publicacion" /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>Coautor</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" class="CajasHoja" id="Coautor_Publicacion" name="Coautor_Publicacion" /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>Entidad ó Editorial</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" class="CajasHoja" id="Editorial_Publicacion" name="Editorial_Publicacion" /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>Otro rol</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>Si</strong>&nbsp;&nbsp;<input type="radio" id="Si_Rol" name="Rol" onclick="Ver_Rol()" />&nbsp;&nbsp;&nbsp;<strong>No</strong>&nbsp;&nbsp;<input type="radio" id="No_Rol" name="Rol" onclick="Ver_Rol()" /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td class="Rol" style="visibility:collapse"><strong>¿Cual?</strong></td>
                                                        <td class="Rol" style="visibility:collapse">&nbsp;&nbsp;</td>
                                                        <td class="Rol" style="visibility:collapse"><input type="text" class="CajasHoja" id="Cual_Rol" name="Cual_Rol" /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td colspan="5"><strong>Tipo de publicación </strong></td>
                                                        <td colspan="3">&nbsp;&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9">&nbsp;</td>
                                                    </tr> 
                                                    <tr>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td colspan="5">
                                                            <table border="0" align="center" width="100%">
                                                                <tr>
                                                                    <td><input type="radio" id="Revista" name="TipoPublicacion" onclick="Ver_TiposPublicacios()" />&nbsp;&nbsp;<strong>Revista</strong></td>
                                                                    <td class="Revista" style="visibility:collapse"><input type="radio" id="Indexada" name="TipoRevista" />&nbsp;&nbsp;<strong>Indexada</strong></td>
                                                                    <td class="Revista" style="visibility:collapse">&nbsp;</td>
                                                                    <td class="Revista" style="visibility:collapse"><input type="radio" id="NoIndexada" name="TipoRevista" />&nbsp;&nbsp;<strong>No Indexada</strong></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="radio" id="Libro" name="TipoPublicacion" onclick="Ver_TiposPublicacios()" />&nbsp;&nbsp;<strong>Libro o Capítulo libro</strong></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="radio" id="Cartilla" name="TipoPublicacion" onclick="Ver_TiposPublicacios()" />&nbsp;&nbsp;<strong>Cartilla</strong></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="radio" id="Protocolo" name="TipoPublicacion" onclick="Ver_TiposPublicacios()" />&nbsp;&nbsp;<strong>Protocolo</strong></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="radio" id="OtraPublic" name="TipoPublicacion" onclick="Ver_TiposPublicacios()" />&nbsp;&nbsp;<strong>Otra</strong></td>
                                                                    <td class="otrasPublicion" style="visibility:collapse"><strong>¿Cual?</strong></td>
                                                                    <td class="otrasPublicion" style="visibility:collapse"><input type="text" id="Otra_publicTipo" name="Otra_publicTipo" class="CajasHoja" /></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td colspan="3">&nbsp;&nbsp;</td>
                                                    </tr>  
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">&nbsp;&nbsp;</td>
                                        </tr>   
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>4. Participación en publicaciones externas </strong></td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>Si.</strong>&nbsp;&nbsp;<input type="radio" id="Si_PublicacionExt" name="PublicacionesExternas" onclick="Ver_PublicacionExterna()"  />&nbsp;&nbsp;&nbsp;<strong>No.</strong>&nbsp;&nbsp;<input type="radio" id="No_PublicacionExt" name="PublicacionesExternas" onclick="Ver_PublicacionExterna()"  /></td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr id="Table_PublicacionExterna" style="visibility:collapse">
                                            <td colspan="5" align="center">
                                                <table width="100%" align="center" border="0" >
                                                    <tr>
                                                        <td colspan="9">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>Autor</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" class="CajasHoja" id="Autor_PublicacionExt" name="Autor_PublicacionExt" /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>Nombre de la Publicación</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" class="CajasHoja" id="Nom_PublicacionExt" name="Nom_PublicacionExt" /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>Coautor</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" class="CajasHoja" id="Coautor_PublicacionExt" name="Coautor_PublicacionExt" /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>Entidad ó Editorial</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" class="CajasHoja" id="Entidad_PublicacionExt" name="Entidad_PublicacionExt" /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>Otro rol</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>Si</strong><input type="radio" id="SiRol_ext" name="OtroRol_PublicacionExt" onclick="Ver_RolExterno()" />&nbsp;&nbsp;&nbsp;<strong>No</strong><input type="radio" id="NoRol_ext" name="OtroRol_PublicacionExt" onclick="Ver_RolExterno()" /></td>
                                                        <td class="Rol_ext" style="visibility:collapse">&nbsp;&nbsp;</td>
                                                        <td class="Rol_ext" style="visibility:collapse"><strong>¿Cual?</strong></td>
                                                        <td class="Rol_ext" style="visibility:collapse">&nbsp;&nbsp;</td>
                                                        <td class="Rol_ext" style="visibility:collapse"><input type="text" class="CajasHoja" id="CualRol_PublicacionExt" name="CualRol_PublicacionExt" /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td colspan="5"><strong>Tipo de publicación </strong></td>
                                                        <td colspan="3">&nbsp;&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9">&nbsp;</td>
                                                    </tr> 
                                                    <tr>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td colspan="5">
                                                            <table border="0" align="center" width="100%">
                                                                <tr>
                                                                    <td><input type="radio" id="RevistaExt" name="TipoPublicacionExt" onclick="Ver_TiposPublicaciosExt()" />&nbsp;&nbsp;<strong>Revista</strong></td>
                                                                    <td class="RevistaExt" style="visibility:collapse"><input type="radio" id="IndexadaExt" name="TipoRevistaExt" />&nbsp;&nbsp;<strong>Indexada</strong></td>
                                                                    <td class="RevistaExt" style="visibility:collapse">&nbsp;</td>
                                                                    <td class="RevistaExt" style="visibility:collapse"><input type="radio" id="NoIndexadaExt" name="TipoRevistaExt" />&nbsp;&nbsp;<strong>No Indexada</strong></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="radio" id="LibroExt" name="TipoPublicacionExt" onclick="Ver_TiposPublicaciosExt()" />&nbsp;&nbsp;<strong>Libro o Capítulo libro</strong></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="radio" id="CartillaExt" name="TipoPublicacionExt" onclick="Ver_TiposPublicaciosExt()" />&nbsp;&nbsp;<strong>Cartilla</strong></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="radio" id="ProtocoloExt" name="TipoPublicacionExt" onclick="Ver_TiposPublicaciosExt()" />&nbsp;&nbsp;<strong>Protocolo</strong></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><input type="radio" id="OtraPublicExt" name="TipoPublicacionExt" onclick="Ver_TiposPublicaciosExt()" />&nbsp;&nbsp;<strong>Otra</strong></td>
                                                                    <td class="otrasPublicionExt" style="visibility:collapse"><strong>¿Cual?</strong></td>
                                                                    <td class="otrasPublicionExt" style="visibility:collapse"><input type="text" id="Otra_publicTipoExt" name="Otra_publicTipoExt" class="CajasHoja" /></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td colspan="3">&nbsp;&nbsp;</td>
                                                    </tr>  
                                                    <tr>
                                                        <td colspan="9">&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>5. Asistencia a eventos de investigación </strong></td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>Si.</strong>&nbsp;&nbsp;<input type="radio" id="Si_AsisEventos" name="AsistenteEventos" onclick="Ver_EventosInvestigacion()" />&nbsp;&nbsp;&nbsp;<strong>No.</strong>&nbsp;&nbsp;<input type="radio" id="No_AsisEventos" name="AsistenteEventos" onclick="Ver_EventosInvestigacion()"  /></td>
                                            <td>&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr id="Tr_EventoInvesti" style="visibility:collapse">
                                            <td>&nbsp;&nbsp;</td>
                                            <td colspan="4">
                                                <table border="0" align="center" width="100%">
                                                    <tr>
                                                        <td colspan="9">&nbsp;&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>Fecha Inicial</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" name="Fechaini_Evento" size="12" id="Fechaini_Evento" title="Fecha Inicial" maxlength="12" class="Fecha CajasHoja" tabindex="7" placeholder="Fecha Inicial" autocomplete="off" value="" readonly /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>Fecha Final</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" name="Fechafin_Evento" size="12" id="Fechafin_Evento" title="Fecha Final" maxlength="12" class="Fecha CajasHoja" tabindex="7" placeholder="Fecha Final" autocomplete="off" value="" readonly /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9">&nbsp;&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>Nombre evento</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" class="CajasHoja" id="Nom_evento" name="Nom_evento" /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>Entidad organizadora</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" class="CajasHoja" id="Nom_EntidadOrg" name="Nom_EntidadOrg" /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9">&nbsp;&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>6. Ponente en Congresos en la Universidad El Bosque </strong></td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>Si.</strong>&nbsp;&nbsp;<input type="radio" id="Si_PonenteCongreso" name="PonenteCongreso" onclick="Ver_PonenteCongreso()"  />&nbsp;&nbsp;&nbsp;<strong>No.</strong>&nbsp;&nbsp;<input type="radio" id="No_PonenteCongreso" name="PonenteCongreso" onclick="Ver_PonenteCongreso()"  /></td>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr id="Table_PonenteCongreso" style="visibility:collapse">
                                            <td colspan="5">
                                                <table width="100%" align="center" border="0" >
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td><strong>Fecha inicial</strong></td>
                                                        <td>&nbsp;</td>
                                                        <td><input type="text" name="Fechaini_CongBosque" size="12" id="Fechaini_CongBosque" title="Fecha Inicial" maxlength="12" class="Fecha CajasHoja" tabindex="7" placeholder="Fecha Inicial" autocomplete="off" value="" readonly /></td>
                                                        <td>&nbsp;</td>
                                                        <td><strong>Fecha final</strong></td>
                                                        <td>&nbsp;</td>
                                                        <td><input type="text" name="Fechafin_CongBosque" size="12" id="Fechafin_CongBosque" title="Fecha Final" maxlength="12" class="Fecha CajasHoja" tabindex="7" placeholder="Fecha Final" autocomplete="off" value="" readonly /></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td><strong>Nombre evento</strong></td>
                                                        <td>&nbsp;</td>
                                                        <td><input type="text" id="NomEvento_CongBosque" name="NomEvento_CongBosque" class="CajasHoja" /></td>
                                                        <td>&nbsp;</td>
                                                        <td><strong>Nombre ponencia</strong></td>
                                                        <td>&nbsp;</td>
                                                        <td><input type="text" id="NomPonencia_CongBosque" name="NomPonencia_CongBosque" class="CajasHoja" /></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9">&nbsp;</td>
                                                    </tr>    
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td><strong>Dependencia o Unidad Organizadora</strong></td>
                                                        <td>&nbsp;</td>
                                                        <td><input type="text" id="Dependencia_CongBosque" name="Dependencia_CongBosque" class="CajasHoja" /></td>
                                                        <td colspan="5">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9">&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>7. Ponente en Congresos locales (Bogotá)</strong></td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>Si.</strong>&nbsp;&nbsp;<input type="radio" id="Si_PonenteLocal" name="PonenteLocal" onclick="Ver_PonenteLocal()" />&nbsp;&nbsp;&nbsp;<strong>No.</strong>&nbsp;&nbsp;<input type="radio" id="No_PonenteLocal" name="PonenteLocal" onclick="Ver_PonenteLocal()"  /></td>
                                            <td>&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr id="Tr_PonenteLocal" style="visibility:collapse">
                                            <td colspan="5">
                                                <table width="100%" align="center" border="0" >
                                                    <tr>
                                                        <td colspan="9">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td><strong>Fecha inicial</strong></td>
                                                        <td>&nbsp;</td>
                                                        <td><input type="text" name="Fechaini_Congreso" size="12" id="Fechaini_Congreso" title="Fecha Inicial" maxlength="12" class="Fecha CajasHoja" tabindex="7" placeholder="Fecha Inicial" autocomplete="off" value="" readonly /></td>
                                                        <td>&nbsp;</td>
                                                        <td><strong>Fecha final</strong></td>
                                                        <td>&nbsp;</td>
                                                        <td><input type="text" name="Fechafin_Congreso" size="12" id="Fechafin_Congreso" title="Fecha Final" maxlength="12" class="Fecha CajasHoja" tabindex="7" placeholder="Fecha Final" autocomplete="off" value="" readonly /></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td><strong>Nombre evento</strong></td>
                                                        <td>&nbsp;</td>
                                                        <td><input type="text" id="NomEvento_Congreso" name="NomEvento_Congreso" class="CajasHoja" /></td>
                                                        <td>&nbsp;</td>
                                                        <td><strong>Nombre ponencia</strong></td>
                                                        <td>&nbsp;</td>
                                                        <td><input type="text" id="NomPonencia_Congreso" name="NomPonencia_Congreso" class="CajasHoja" /></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9">&nbsp;</td>
                                                    </tr>    
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td><strong>Entidad organizadora</strong></td>
                                                        <td>&nbsp;</td>
                                                        <td><input type="text" id="Entidad_Congreso" name="Entidad_Congreso" class="CajasHoja" /></td>
                                                        <td colspan="5">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9">&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>8. Ponente en Congresos Nacionales</strong></td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>Si.</strong>&nbsp;&nbsp;<input type="radio" id="Si_PonenteNacional" name="PonenteNacional" onclick="Ver_PonenteNacional()" />&nbsp;&nbsp;&nbsp;<strong>No.</strong>&nbsp;&nbsp;<input type="radio" id="No_PonenteNacional" name="PonenteNacional" onclick="Ver_PonenteNacional()"  /></td>
                                            <td>&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr id="Tr_PonenteNacional" style="visibility:collapse">
                                            <td colspan="5">
                                                <table width="100%" align="center" border="0" >
                                                    <tr>
                                                        <td colspan="9">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td><strong>Fecha inicial</strong></td>
                                                        <td>&nbsp;</td>
                                                        <td><input type="text" name="Fechaini_CongNal" size="12" id="Fechaini_CongNal" title="Fecha Inicial" maxlength="12" class="Fecha CajasHoja" tabindex="7" placeholder="Fecha Inicial" autocomplete="off" value="" readonly /></td>
                                                        <td>&nbsp;</td>
                                                        <td><strong>Fecha final</strong></td>
                                                        <td>&nbsp;</td>
                                                        <td><input type="text" name="Fechafin_CongNal" size="12" id="Fechafin_CongNal" title="Fecha Final" maxlength="12" class="Fecha CajasHoja" tabindex="7" placeholder="Fecha Final" autocomplete="off" value="" readonly /></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td><strong>Nombre evento</strong></td>
                                                        <td>&nbsp;</td>
                                                        <td><input type="text" id="NomEvento_CongNal" name="NomEvento_CongNal" class="CajasHoja" /></td>
                                                        <td>&nbsp;</td>
                                                        <td><strong>Nombre ponencia</strong></td>
                                                        <td>&nbsp;</td>
                                                        <td><input type="text" id="NomPonencia_CongNal" name="NomPonencia_CongNal" class="CajasHoja" /></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9">&nbsp;</td>
                                                    </tr>    
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td><strong>Ciudad</strong></td>
                                                        <td>&nbsp;</td>
                                                        <td><input type="text" id="Ciudad_Congreso" name="Ciudad_Congreso" class="CajasHoja" onclick="FormatCityCongreso()" autocomplete="off" style="text-align:center" onKeyPress="autocompletCityCongreso()" /><input type="hidden" id="id_CityCongreso" /></td>
                                                        <td>&nbsp;</td>
                                                        <td><strong>Entidad organizadora</strong></td>
                                                        <td>&nbsp;</td>
                                                        <td><input type="text" id="Entidad_Congreso" name="Entidad_Congreso" class="CajasHoja" /></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9">&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>9. Ponente en Congresos Internacionales </strong></td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>Si.</strong>&nbsp;&nbsp;<input type="radio" id="Si_PonenteInternacional" name="PonenteInternacional" onclick="Ver_PonenteInternacional()" />&nbsp;&nbsp;&nbsp;<strong>No.</strong>&nbsp;&nbsp;<input type="radio" id="No_PonenteInternacional" name="PonenteInternacional" onclick="Ver_PonenteInternacional()"  /></td>
                                            <td>&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr id="Tr_PonenteInternacional" style="visibility:collapse">
                                            <td colspan="5">
                                                <table width="100%" align="center" border="0" >
                                                    <tr>
                                                        <td colspan="9">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td><strong>Fecha inicial</strong></td>
                                                        <td>&nbsp;</td>
                                                        <td><input type="text" name="Fechaini_CongInter" size="12" id="Fechaini_CongInter" title="Fecha Inicial" maxlength="12" class="Fecha CajasHoja" tabindex="7" placeholder="Fecha Inicial" autocomplete="off" value="" readonly /></td>
                                                        <td>&nbsp;</td>
                                                        <td><strong>Fecha final</strong></td>
                                                        <td>&nbsp;</td>
                                                        <td><input type="text" name="Fechafin_CongInter" size="12" id="Fechafin_CongInter" title="Fecha Final" maxlength="12" class="Fecha CajasHoja" tabindex="7" placeholder="Fecha Final" autocomplete="off" value="" readonly /></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td><strong>Nombre evento</strong></td>
                                                        <td>&nbsp;</td>
                                                        <td><input type="text" id="NomEvento_CongInter" name="NomEvento_CongInter" class="CajasHoja" /></td>
                                                        <td>&nbsp;</td>
                                                        <td><strong>Nombre ponencia</strong></td>
                                                        <td>&nbsp;</td>
                                                        <td><input type="text" id="NomPonencia_CongInter" name="NomPonencia_CongInter" class="CajasHoja" /></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9">&nbsp;</td>
                                                    </tr>    
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td><strong>Ciudad</strong></td>
                                                        <td>&nbsp;</td>
                                                        <td><input type="text" id="Ciudad_CongresoInter" name="Ciudad_CongresoInter" class="CajasHoja" onclick="FormatCityCongInter()" autocomplete="off" style="text-align:center" onKeyPress="autocompletCityCongInter()" /><input type="hidden" id="id_CityCongInter" /></td>
                                                        <td>&nbsp;</td>
                                                        <td><strong>Pis</strong></td>
                                                        <td>&nbsp;</td>
                                                        <td><input type="text" id="Pais_Congreso" name="Pais_Congreso" class="CajasHoja" onkeypress="autocompletPais()" autocomplete="off" onclick="FormatPais()" style="text-align:center" /><input type="hidden" id="id_Pais" /></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td><strong>Entidad organizadora</strong></td>
                                                        <td>&nbsp;</td>
                                                        <td><input type="text" id="Entidad_CongInter" name="Entidad_CongInter" class="CajasHoja" /></td>
                                                        <td colspan="5">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="9">&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">&nbsp;&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </td>
            </tr>
        </table>            
        <?php
    }

    public function Movilidad($id_Estudiante) {
        global $db, $userid, $rol_Usuario;
        ?>
        <div id="Intro_Movilidad" style="width:95%; margin-left:3%; margin-right:3%; margin-bottom:2%; margin-top:2%" align="justify">
            <strong>En un mundo globalizado se hace necesaria la interacción de los estudiantes universitarios con culturas y referentes del mundo.  Para tal fin la Universidad facilita las experiencias de movilidad académica de sus estudiantes.
                Por favor registre su participación en actividades de movilidad académica.</strong>
        </div>
        <br />
        <table width="95%" align="center" border="0" style="margin-left:2%; margin-right:2%; margin-bottom:2%;font-size:12px">
            <tr>
                <td>
                    <fieldset style="border:#88AB0C solid 1px; height:100%; width:100%; ">
                        <table border="0" width="100%" align="center">
                            <tr>
                                <td colspan="5">&nbsp;&nbsp;</td>
                            </tr>
        <?php
        $SQL_Max_Movilidad = 'SELECT 

														MAX(idestudiantemovilidad) AS id 
														
														FROM estudiantemovilidad
														
														WHERE
														
														idestudiantegeneral="' . $id_Estudiante . '"
														AND
														codigoestado=100';

        if ($Max_Movilidad = &$db->Execute($SQL_Max_Movilidad) === false) {
            echo 'Error en el Max Movilidad...<br>' . $SQL_Max_Movilidad;
            die;
        }

        $SQL_Detalle_Movilidad = 'SELECT 

															redinternacional,
															redvirtual,
															cursosotrasuniversidad,
															cursouniversidadnacional,
															cursouniversidaextranjera,
															frecuenciacursoextranjera,
															usoplataformaujoinus,
															frecuenciaujoinus,
															plataformacollaborate,
															frecuenciacollaborate,
															usoplataformasittio,
															frecuenciasittio
															
															FROM estudiantemovilidad
															
															WHERE
															
															idestudiantegeneral="' . $id_Estudiante . '"
															AND
															codigoestado=100
															AND
															idestudiantemovilidad="' . $Max_Movilidad->fields['id'] . '"';


        if ($Movilidad_detalle = &$db->Execute($SQL_Detalle_Movilidad) === false) {
            echo 'Error en el SQL Detalle de lA Movilidad.......<br>' . $SQL_Detalle_Movilidad;
            die;
        }
        ?>
                            <tr>
                                <td>&nbsp;&nbsp;</td>
                                <td colspan="2"><strong>Por favor registre su en actividades de movilidad  académica en los siguiente campos:</strong></td>
                                <td>&nbsp;&nbsp;</td>
                                <td width="43%">&nbsp;&nbsp;</td>
                                <td width="6%">&nbsp;&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="5">&nbsp;&nbsp;</td>
                            </tr>
        <?php
        $Ver_Red = 'style="visibility:collapse"';
        $Ver_Virtual = 'style="visibility:collapse"';
        $Ver_OtraUniv = 'style="visibility:collapse"';
        $Ver_UnvNacional = 'style="visibility:collapse"';
        $ver_UnvExtr = 'style="visibility:collapse"';
        $Ver_Joinus = 'style="visibility:collapse"';
        $Ver_Black = 'style="visibility:collapse"';
        $Ver_Sittio = 'style="visibility:collapse"';

        if (!$Movilidad_detalle->EOF) {

            if ($Movilidad_detalle->fields['redinternacional'] == 0) {

                $Red_Check_Si = 'checked="checked"';
                $Ver_Red = 'style="visibility:visible"';
                /*                 * ************************************************ */

                $SQL_Detalle_Red = 'SELECT 

																			tipomovilidad,
																			nombrered,
																			piasred,
																			ciudadred,
																			universidad,
																			nombrecurso,
																			fechainicio,
																			fechafin
																			
																			FROM detallemovilidad
																			
																			WHERE
																			
																			codigoestado=100
																			AND
																			idestudiantemovilidad="' . $Max_Movilidad->fields['id'] . '"
																			AND
																			tipomovilidad=1';

                if ($Detalle_Red = &$db->Execute($SQL_Detalle_Red) === false) {
                    echo 'Error en el SQL Detalle de la Red....<br>' . $SQL_Detalle_Red;
                    die;
                }

                $Nombre_Red = $Detalle_Red->fields['nombrered'];
                $Pais_Red = $Detalle_Red->fields['piasred'];
                $Ciudad_Red = $Detalle_Red->fields['ciudadred'];
                $Univ_Red = $Detalle_Red->fields['universidad'];
                $Curso_Red = $Detalle_Red->fields['nombrecurso'];
                $FechaIni_Red = $Detalle_Red->fields['fechainicio'];
                $FechaFin_Red = $Detalle_Red->fields['fechafin'];

                /*                 * ************************************************ */
            }

            if ($Movilidad_detalle->fields['redinternacional'] == 1) {

                $Red_Check_No = 'checked="checked"';
                $Ver_Red = 'style="visibility:collapse"';
            }
            /*             * ******************************************Red Virtual***************************************************** */

            if ($Movilidad_detalle->fields['redvirtual'] == 0) {

                $Virtual_Check_Si = 'checked="checked"';
                $Ver_Virtual = 'style="visibility:visible"';

                /*                 * ************************************************ */

                $SQL_Detalle_Virtual = 'SELECT 

																				tipomovilidad,
																				nombrered,
																				piasred,
																				ciudadred,
																				universidad,
																				nombrecurso,
																				fechainicio,
																				fechafin
																				
																				FROM detallemovilidad
																				
																				WHERE
																				
																				codigoestado=100
																				AND
																				idestudiantemovilidad="' . $Max_Movilidad->fields['id'] . '"
																				AND
																				tipomovilidad=2';

                if ($Detalle_Virtual = &$db->Execute($SQL_Detalle_Virtual) === false) {
                    echo 'Error en el SQL Detalle de la Red Virtual....<br>' . $SQL_Detalle_Virtual;
                    die;
                }

                $Nombre_Virtual = $Detalle_Virtual->fields['nombrered'];
                $Pais_Virtual = $Detalle_Virtual->fields['piasred'];
                $Ciudad_Virtual = $Detalle_Virtual->fields['ciudadred'];
                $Univ_Virtual = $Detalle_Virtual->fields['universidad'];
                $Curso_Virtual = $Detalle_Virtual->fields['nombrecurso'];
                $FechaIni_Virtual = $Detalle_Virtual->fields['fechainicio'];
                $FechaFin_Virtual = $Detalle_Virtual->fields['fechafin'];

                /*                 * ************************************************ */
            }

            if ($Movilidad_detalle->fields['redvirtual'] == 1) {

                $Virtual_Check_No = 'checked="checked"';
                $Ver_Virtual = 'style="visibility:collapse"';
            }

            /*             * ********************************************************************************************************** */
            /*             * ******************************************Curso  locales ***************************************************** */

            if ($Movilidad_detalle->fields['cursosotrasuniversidad'] == 0) {

                $OtraUniv_Check_Si = 'checked="checked"';
                $Ver_OtraUniv = 'style="visibility:visible"';

                /*                 * ************************************************ */

                $SQL_Detalle_Local = 'SELECT 

																				tipomovilidad,
																				nombrered,
																				piasred,
																				ciudadred,
																				universidad,
																				nombrecurso,
																				fechainicio,
																				fechafin
																				
																				FROM detallemovilidad
																				
																				WHERE
																				
																				codigoestado=100
																				AND
																				idestudiantemovilidad="' . $Max_Movilidad->fields['id'] . '"
																				AND
																				tipomovilidad=3';

                if ($Detalle_Local = &$db->Execute($SQL_Detalle_Local) === false) {
                    echo 'Error en el SQL Detalle de la Univerisdad Local....<br>' . $SQL_Detalle_Local;
                    die;
                }

                $Nombre_Local = $Detalle_Local->fields['nombrered'];
                $Pais_Local = $Detalle_Local->fields['piasred'];
                $Ciudad_Local = $Detalle_Local->fields['ciudadred'];
                $Univ_Local = $Detalle_Local->fields['universidad'];
                $Curso_Local = $Detalle_Local->fields['nombrecurso'];
                $FechaIni_Local = $Detalle_Local->fields['fechainicio'];
                $FechaFin_Local = $Detalle_Local->fields['fechafin'];

                /*                 * ************************************************ */
            }

            if ($Movilidad_detalle->fields['cursosotrasuniversidad'] == 1) {

                $OtraUniv_Check_No = 'checked="checked"';
                $Ver_OtraUniv = 'style="visibility:collapse"';
            }

            /*             * *************************************************************************************************************** */
            /*             * ************************************************universidad del país******************************************* */

            if ($Movilidad_detalle->fields['cursouniversidadnacional'] == 0) {

                $UnvNacional_Check_Si = 'checked="checked"';
                $Ver_UnvNacional = 'style="visibility:visible"';

                /*                 * ************************************************ */

                $SQL_Detalle_Nacional = 'SELECT 

																					tipomovilidad,
																					nombrered,
																					piasred,
																					ciudadred,
																					universidad,
																					nombrecurso,
																					fechainicio,
																					fechafin
																					
																					FROM detallemovilidad
																					
																					WHERE
																					
																					codigoestado=100
																					AND
																					idestudiantemovilidad="' . $Max_Movilidad->fields['id'] . '"
																					AND
																					tipomovilidad=4';

                if ($Detalle_Nacioanl = &$db->Execute($SQL_Detalle_Nacional) === false) {
                    echo 'Error en el SQL Detalle de la Univerisdad Nacional o pais....<br>' . $SQL_Detalle_Nacional;
                    die;
                }

                $Nombre_Nacional = $Detalle_Nacioanl->fields['nombrered'];
                $Pais_Nacional = $Detalle_Nacioanl->fields['piasred'];
                $Ciudad_Nacional = $Detalle_Nacioanl->fields['ciudadred'];
                $Univ_Nacional = $Detalle_Nacioanl->fields['universidad'];
                $Curso_Nacional = $Detalle_Nacioanl->fields['nombrecurso'];
                $FechaIni_Nacional = $Detalle_Nacioanl->fields['fechainicio'];
                $FechaFin_Nacional = $Detalle_Nacioanl->fields['fechafin'];

                /*                 * ************************************************ */
            }

            if ($Movilidad_detalle->fields['cursouniversidadnacional'] == 1) {

                $UnvNacional_Check_No = 'checked="checked"';
                $Ver_UnvNacional = 'style="visibility:collapse"';
            }

            /*             * *************************************************************************************************************** */
            /*             * ************************************************ universidades extranjeras************************************** */

            if ($Movilidad_detalle->fields['cursouniversidaextranjera'] == 0) {

                $UnvExtr_Check_Si = 'checked="checked"';
                $ver_UnvExtr = 'style="visibility:visible"';

                /*                 * ************************************************ */

                if ($Movilidad_detalle->fields['frecuenciacursoextranjera'] == 1) {

                    $Extra_Fre_Uno = 'checked="checked"';
                }

                if ($Movilidad_detalle->fields['frecuenciacursoextranjera'] == 2) {

                    $Extra_Fre_Dos = 'checked="checked"';
                }

                if ($Movilidad_detalle->fields['frecuenciacursoextranjera'] == 3) {

                    $Extra_Fre_Tres = 'checked="checked"';
                }

                if ($Movilidad_detalle->fields['frecuenciacursoextranjera'] == 4) {

                    $Extra_Fre_Cuatro = 'checked="checked"';
                }

                /*                 * ************************************************ */
            }

            if ($Movilidad_detalle->fields['cursouniversidaextranjera'] == 1) {

                $UnvExtr_Check_No = 'checked="checked"';
                $ver_UnvExtr = 'style="visibility:collapse"';
            }

            /*             * *************************************************************************************************************** */
            /*             * *******************************************plataforma UJoinUs*************************************************** */

            if ($Movilidad_detalle->fields['usoplataformaujoinus'] == 0) {

                $Joinus_Check_Si = 'checked="checked"';
                $Ver_Joinus = 'style="visibility:visible"';

                /*                 * ************************************************ */

                if ($Movilidad_detalle->fields['frecuenciaujoinus'] == 1) {

                    $Joinus_Fre_Uno = 'checked="checked"';
                }

                if ($Movilidad_detalle->fields['frecuenciaujoinus'] == 2) {

                    $Joinus_Fre_Dos = 'checked="checked"';
                }

                if ($Movilidad_detalle->fields['frecuenciaujoinus'] == 3) {

                    $Joinus_Fre_Tres = 'checked="checked"';
                }

                if ($Movilidad_detalle->fields['frecuenciaujoinus'] == 4) {

                    $Joinus_Fre_Cuatro = 'checked="checked"';
                }

                /*                 * ************************************************ */
            }

            if ($Movilidad_detalle->fields['usoplataformaujoinus'] == 1) {

                $Joinus_Check_No = 'checked="checked"';
                $Ver_Joinus = 'style="visibility:collapse"';
            }

            /*             * *************************************************************************************************************** */
            /*             * *******************************************Blackboard Collaborate********************************************** */

            if ($Movilidad_detalle->fields['plataformacollaborate'] == 0) {

                $Black_Check_SI = 'checked="checked"';
                $Ver_Black = 'style="visibility:visible"';

                /*                 * ************************************************ */

                if ($Movilidad_detalle->fields['frecuenciacollaborate'] == 1) {

                    $Black_Fre_Uno = 'checked="checked"';
                }

                if ($Movilidad_detalle->fields['frecuenciacollaborate'] == 2) {

                    $Black_Fre_Dos = 'checked="checked"';
                }

                if ($Movilidad_detalle->fields['frecuenciacollaborate'] == 3) {

                    $Black_Fre_Tres = 'checked="checked"';
                }

                if ($Movilidad_detalle->fields['frecuenciacollaborate'] == 4) {

                    $Black_Fre_Cuatro = 'checked="checked"';
                }

                /*                 * ************************************************ */
            }

            if ($Movilidad_detalle->fields['plataformacollaborate'] == 1) {

                $Black_Check_No = 'checked="checked"';
                $Ver_Black = 'style="visibility:collapse"';
            }

            /*             * *************************************************************************************************************** */
            /*             * *************************************blackboard SiTTiO********************************************************* */

            if ($Movilidad_detalle->fields['usoplataformasittio'] == 0) {

                $Sittio_Check_Si = 'checked="checked"';
                $Ver_Sittio = 'style="visibility:visible"';

                /*                 * ************************************************ */

                if ($Movilidad_detalle->fields['frecuenciasittio'] == 1) {

                    $Sittio_Fre_Uno = 'checked="checked"';
                }

                if ($Movilidad_detalle->fields['frecuenciasittio'] == 2) {

                    $Sittio_Fre_Dos = 'checked="checked"';
                }

                if ($Movilidad_detalle->fields['frecuenciasittio'] == 3) {

                    $Sittio_Fre_Tres = 'checked="checked"';
                }

                if ($Movilidad_detalle->fields['frecuenciasittio'] == 4) {

                    $Sittio_Fre_Cuatro = 'checked="checked"';
                }

                /*                 * ************************************************ */
            }

            if ($Movilidad_detalle->fields['usoplataformasittio'] == 1) {

                $Sittio_Check_No = 'checked="checked"';
                $Ver_Sittio = 'style="visibility:collapse"';
            }

            /*             * *************************************************************************************************************** */
        }
        ?>
                            <tr id="Tr_Movilidad">
                                <td>&nbsp;</td>
                                <td colspan="4">
                                    <table border="0" align="center" width="100%">
                                        <tr>
                                            <td width="1%">&nbsp;&nbsp;</td>
                                            <td width="50%"><strong>¿Experiencias académicas con redes internacionales - En otros países ? &nbsp;&nbsp;<span style="color:#F00; font-size:9px">*</span></strong></td>
                                            <td width="1%">&nbsp;&nbsp;</td>
                                            <td width="47%"><strong>Si.</strong>&nbsp;&nbsp;<input type="radio" id="Si_RedInternacional" name="RedInternacional" onclick="Ver_RedInternacional()" <?php echo $Red_Check_Si ?> />&nbsp;&nbsp;&nbsp;<strong>No.</strong>&nbsp;&nbsp;<input type="radio" id="No_RedInternacional" name="RedInternacional" onclick="Ver_RedInternacional()" <?php echo $Red_Check_No ?> /></td>
                                            <td width="1%">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr id="Tr_RedInternacional" <?php echo $Ver_Red ?>>
                                            <td>&nbsp;&nbsp;</td>
                                            <td colspan="3">
                                                <table border="0" align="center" width="100%">
                                                    <tr>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>Nombre de la red</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" id="Nom_RedInter" name="Nom_RedInter" class="CajasHoja" value="<?php echo $Nombre_Red ?>" /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>País</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" id="Pais_Inter" name="Pais_Inter" class="CajasHoja" value="<?php echo $Pais_Red ?>" /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>Ciudad</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" id="Ciudad_Inter" name="Ciudad_Inter" class="CajasHoja" value="<?php echo $Ciudad_Red ?>" /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>Fecha inicio</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" name="FechaInicoRed" size="12" id="FechaInicoRed" title="Fecha inicio " maxlength="12" tabindex="7" placeholder="Fecha Inicio" autocomplete="off" value="<?php echo $FechaIni_Red ?>" readonly /></td>
                                                        <td><strong>Fecha Fin</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" name="FechaFinred" size="12" id="FechaFinred" title="Fecha Fin " maxlength="12" tabindex="7" placeholder="Fecha Fin" autocomplete="off" value="<?php echo $FechaFin_Red ?>" readonly /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="16">&nbsp;&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>¿Experiencias académicas con redes internacionales - Virtuales ?&nbsp;&nbsp;<span style="color:#F00; font-size:9px">*</span></strong></td>
                                            <td width="1%">&nbsp;&nbsp;</td>
                                            <td width="47%"><strong>Si.</strong>&nbsp;&nbsp;<input type="radio" id="Si_RedVirtual" name="RedVirtual" onclick="Ver_RedVirtual()" <?php echo $Virtual_Check_Si ?> />&nbsp;&nbsp;&nbsp;<strong>No.</strong>&nbsp;&nbsp;<input type="radio" id="No_RedVirtual" name="RedVirtual" onclick="Ver_RedVirtual()" <?php echo $Virtual_Check_No ?> /></td>
                                            <td width="1%">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr id="Tr_RedVirtual" <?php echo $Ver_Virtual ?>>
                                            <td>&nbsp;&nbsp;</td>
                                            <td colspan="3">
                                                <table border="0" align="center" width="100%">
                                                    <tr>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>Nombre de la red</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" id="Nom_RedVirtual" name="Nom_RedVirtual" class="CajasHoja" value="<?php echo $Nombre_Virtual ?>" /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>País</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" id="Pais_Virtual" name="Pais_Virtual" class="CajasHoja" value="<?php echo $Pais_Virtual ?>" /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>Ciudad</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" id="Ciudad_Virtual" name="Ciudad_Virtual" class="CajasHoja" value="<?php echo $Ciudad_Virtual ?>" /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>Fecha inicio</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" name="FechaInicoVirtual" size="12" id="FechaInicoVirtual" title="Fecha inicio " maxlength="12" tabindex="7" placeholder="Fecha Inicio" autocomplete="off" value="<?php echo $FechaIni_Virtual ?>" readonly /></td>
                                                        <td><strong>Fecha Fin</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" name="FechaFinVirtual" size="12" id="FechaFinVirtual" title="Fecha Fin " maxlength="12" tabindex="7" placeholder="Fecha Fin" autocomplete="off" value="<?php echo $FechaFin_Virtual ?>" readonly /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="16">&nbsp;&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>¿Cursos tomados en otras universidades locales (Bogotá) ?&nbsp;&nbsp;<span style="color:#F00; font-size:9px">*</span></strong></td>
                                            <td width="1%">&nbsp;&nbsp;</td>
                                            <td width="47%"><strong>Si.</strong>&nbsp;&nbsp;<input type="radio" id="Si_CursoLocal" name="CursoLocal" onclick="Ver_CursoLocal()" <?php echo $OtraUniv_Check_Si ?> />&nbsp;&nbsp;&nbsp;<strong>No.</strong>&nbsp;&nbsp;<input type="radio" id="No_CursoLocal" name="CursoLocal" onclick="Ver_CursoLocal()" <?php echo $OtraUniv_Check_No ?> /></td>
                                            <td width="1%">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr id="Tr_CursoLocal" <?php echo $Ver_OtraUniv ?>>
                                            <td>&nbsp;&nbsp;</td>
                                            <td colspan="3">
                                                <table border="0" align="center" width="100%">
                                                    <tr>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>Universidad</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" id="Nom_Universidad" name="Nom_Universidad" class="CajasHoja" value="<?php echo $Univ_Local ?>"/></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>Nombre del Curso</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" id="Nom_Curso" name="Nom_Curso" class="CajasHoja" value="<?php echo $Curso_Local ?>" /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>Fecha inicio</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" name="FechaInicoCurso" size="12" id="FechaInicoCurso" title="Fecha inicio Del Curso" maxlength="12" tabindex="7" placeholder="Fecha Inicio" autocomplete="off" value="<?php echo $FechaIni_Local; ?>" readonly /></td>
                                                        <td><strong>Fecha Fin</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" name="FechaFinCurso" size="12" id="FechaFinCurso" title="Fecha Fin Del Curso" maxlength="12" tabindex="7" placeholder="Fecha Fin" autocomplete="off" value="<?php echo $FechaFin_Local ?>" readonly /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="16">&nbsp;&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>¿Cursos tomados en otra universidad del país ?&nbsp;&nbsp;<span style="color:#F00; font-size:9px">*</span></strong></td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>Si.</strong>&nbsp;&nbsp;<input type="radio" id="Si_CursoNacional" name="CursoNacional" onclick="Ver_CursoNacional()" <?php echo $UnvNacional_Check_Si ?> />&nbsp;&nbsp;&nbsp;<strong>No.</strong>&nbsp;&nbsp;<input type="radio" id="No_CursoNacional" name="CursoNacional" onclick="Ver_CursoNacional()" <?php echo $UnvNacional_Check_No ?> /></td>
                                            <td>&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr id="Tr_CursoNacional" <?php echo $Ver_UnvNacional ?>>
                                            <td>&nbsp;&nbsp;</td>
                                            <td colspan="3">
                                                <table border="0" align="center" width="100%">
                                                    <tr>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>Universidad</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" id="Nom_UniversidadOtra" name="Nom_UniversidadOtra" class="CajasHoja" value="<?php echo $Univ_Nacional ?>" /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>Nombre del Curso</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" id="Nom_OtroCurso" name="Nom_OtroCurso" class="CajasHoja" value="<?php echo $Curso_Nacional ?>" /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><strong>Fecha inicio</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" name="FechaInicoOtroCurso" size="12" id="FechaInicoOtroCurso" title="Fecha inicio Del Curso" maxlength="12" tabindex="7" placeholder="Fecha Inicio" autocomplete="off" value="<?php echo $FechaIni_Nacional ?>" readonly /></td>
                                                        <td><strong>Fecha Fin</strong></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                        <td><input type="text" name="FechaFinOtroCurso" size="12" id="FechaFinOtroCurso" title="Fecha Fin Del Curso" maxlength="12" tabindex="7" placeholder="Fecha Fin" autocomplete="off" value="<?php echo $FechaFin_Nacional ?>" readonly /></td>
                                                        <td>&nbsp;&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="16">&nbsp;&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>¿Cursos tomados en universidades extranjeras ?&nbsp;&nbsp;<span style="color:#F00; font-size:9px">*</span></strong></td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>Si.</strong>&nbsp;&nbsp;<input type="radio" id="Si_CursoInternacional" name="CursoInternacional" onclick="Ver_CursoInternacional()" <?php echo $UnvExtr_Check_Si ?> />&nbsp;&nbsp;&nbsp;<strong>No.</strong>&nbsp;&nbsp;<input type="radio" id="No_CursoInternacional" name="CursoInternacional" onclick="Ver_CursoInternacional()" <?php echo $UnvExtr_Check_No ?> /></td>
                                            <td>&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr id="Tr_CursoInternacional" <?php echo $ver_UnvExtr ?>>
                                            <td>&nbsp;&nbsp;</td>
                                            <td colspan="3" align="center">
                                                <fieldset style="border:#88AB0C solid 1px; height:100%; width:65%; ">
                                                    <legend align="left">Con que frecuencia</legend>
                                                    <table border="0" align="center" width="60%">
                                                        <tr>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><strong>*  1 vez a la semana</strong></td>      
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><input type="radio" id="C_Inter_Uno" name="Fre_Curso" <?php echo $Extra_Fre_Uno ?> /></td>
                                                            <td>&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5">&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><strong>* más de 1 vez a la semana</strong></td>      
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><input type="radio" id="C_Inter_Dos" name="Fre_Curso" <?php echo $Extra_Fre_Dos ?> /></td>
                                                            <td>&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5">&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><strong>* 1 vez al mes</strong></td>      
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><input type="radio" id="C_Inter_Tres" name="Fre_Curso" <?php echo $Extra_Fre_Tres ?> /></td>
                                                            <td>&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5">&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><strong>*  1 vez semestre</strong></td>      
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><input type="radio" id="C_Inter_Cuatro" name="Fre_Curso" <?php echo $Extra_Fre_Cuatro ?> /></td>
                                                            <td>&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5">&nbsp;&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </fieldset>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>¿Ha usado la plataforma UJoinUs ?&nbsp;&nbsp;<span style="color:#F00; font-size:9px">*</span></strong></td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>Si.</strong>&nbsp;&nbsp;<input type="radio" id="Si_UJoinUs" name="UJoinUs" onclick="Ver_UJoinUs()" <?php echo $Joinus_Check_Si ?> />&nbsp;&nbsp;&nbsp;<strong>No.</strong>&nbsp;&nbsp;<input type="radio" id="No_UJoinUs" name="UJoinUs" onclick="Ver_UJoinUs()" <?php echo $Joinus_Check_No ?> /></td>
                                            <td>&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr id="Tr_UJoinUs" <?php echo $Ver_Joinus ?>>
                                            <td>&nbsp;&nbsp;</td>
                                            <td colspan="3" align="center">
                                                <fieldset style="border:#88AB0C solid 1px; height:100%; width:65%; ">
                                                    <legend align="left">Con que frecuencia</legend>
                                                    <table border="0" align="center" width="60%">
                                                        <tr>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><strong>*  1 vez a la semana</strong></td>      
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><input type="radio" id="UJoinUs_Uno" name="uso_UJoinUs" <?php echo $Joinus_Fre_Uno ?> /></td>
                                                            <td>&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5">&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><strong>* más de 1 vez a la semana</strong></td>      
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><input type="radio" id="UJoinUs_Dos" name="uso_UJoinUs" <?php echo $Joinus_Fre_Dos ?> /></td>
                                                            <td>&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5">&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><strong>* 1 vez al mes</strong></td>      
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><input type="radio" id="UJoinUs_Tres" name="uso_UJoinUs" <?php echo $Joinus_Fre_Tres ?> /></td>
                                                            <td>&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5">&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><strong>*  1 vez semestre</strong></td>      
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><input type="radio" id="UJoinUs_Cuatro" name="uso_UJoinUs" <?php echo $Joinus_Fre_Cuatro ?> /></td>
                                                            <td>&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5">&nbsp;&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </fieldset>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>¿Ha usado la Plataforma Blackboard Collaborate ? &nbsp;&nbsp;<span style="color:#F00; font-size:9px">*</span></strong></td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>Si.</strong>&nbsp;&nbsp;<input type="radio" id="Si_Collaborate" name="Collaborate" onclick="Ver_Collaborate()" <?php echo $Black_Check_SI ?> />&nbsp;&nbsp;&nbsp;<strong>No.</strong>&nbsp;&nbsp;<input type="radio" id="No_Collaborate" name="Collaborate" onclick="Ver_Collaborate()" <?php echo $Black_Check_No ?> /></td>
                                            <td>&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr id="Tr_Collaborate" <?php echo $Ver_Black ?>>
                                            <td>&nbsp;&nbsp;</td>
                                            <td colspan="3" align="center">
                                                <fieldset style="border:#88AB0C solid 1px; height:100%; width:65%; ">
                                                    <legend align="left">Con que frecuencia</legend>
                                                    <table border="0" align="center" width="60%">
                                                        <tr>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><strong>*  1 vez a la semana</strong></td>      
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><input type="radio" id="Collaborate_Uno" name="uso_Collaborate" <?php echo $Black_Fre_Uno ?> /></td>
                                                            <td>&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5">&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><strong>* más de 1 vez a la semana</strong></td>      
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><input type="radio" id="Collaborate_Dos" name="uso_Collaborate" <?php echo $Black_Fre_Dos ?> /></td>
                                                            <td>&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5">&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><strong>* 1 vez al mes</strong></td>      
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><input type="radio" id="Collaborate_Tres" name="uso_Collaborate" <?php echo $Black_Fre_Tres ?> /></td>
                                                            <td>&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5">&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><strong>*  1 vez semestre</strong></td>      
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><input type="radio" id="Collaborate_Cuatro" name="uso_Collaborate" <?php echo $Black_Fre_Cuatro ?> /></td>
                                                            <td>&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5">&nbsp;&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </fieldset>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>¿Ha usado la plataforma blackboard SiTTiO ?&nbsp;&nbsp;<span style="color:#F00; font-size:9px">*</span></strong></td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td><strong>Si.</strong>&nbsp;&nbsp;<input type="radio" id="Si_Sittio" name="Sittio" onclick="Ver_Sittio()" <?php echo $Sittio_Check_Si ?> />&nbsp;&nbsp;&nbsp;<strong>No.</strong>&nbsp;&nbsp;<input type="radio" id="No_Sittio" name="Sittio" onclick="Ver_Sittio()" <?php echo $Sittio_Check_No ?> /></td>
                                            <td>&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr id="Tr_Sittio" <?php echo $Ver_Sittio ?>>
                                            <td>&nbsp;&nbsp;</td>
                                            <td colspan="3" align="center">
                                                <fieldset style="border:#88AB0C solid 1px; height:100%; width:65%; ">
                                                    <legend align="left">Con que frecuencia</legend>
                                                    <table border="0" align="center" width="60%">
                                                        <tr>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><strong>*  1 vez a la semana</strong></td>      
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><input type="radio" id="Sittio_Uno" name="uso_Sittio" <?php echo $Sittio_Fre_Uno ?> /></td>
                                                            <td>&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5">&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><strong>* más de 1 vez a la semana</strong></td>      
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><input type="radio" id="Sittio_Dos" name="uso_Sittio"  <?php echo $Sittio_Fre_Dos ?>/></td>
                                                            <td>&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5">&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><strong>* 1 vez al mes</strong></td>      
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><input type="radio" id="Sittio_Tres" name="uso_Sittio" <?php echo $Sittio_Fre_Tres ?> /></td>
                                                            <td>&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5">&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><strong>*  1 vez semestre</strong></td>      
                                                            <td>&nbsp;&nbsp;</td>
                                                            <td><input type="radio" id="Sittio_Cuatro" name="uso_Sittio" <?php echo $Sittio_Fre_Cuatro ?> /></td>
                                                            <td>&nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5">&nbsp;&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </fieldset>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">&nbsp;&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>  
                            </tr>
                        </table>
                    </fieldset>
                </td>
            </tr>
        </table>            
        <?php
    }

    public function RecursosFinacieros($id_Estudiante, $Dissable = '') {
        global $db, $userid, $rol_Usuario;

        if ($Dissable == 1) {
            $ClassDisable = 'disabled="disabled"';
        }

        $SQL_RecursosFinacieros = 'SELECT 
											
								Recurso.idtipoestudianterecursofinanciero AS id,
								Recurso.nombretipoestudianterecursofinanciero AS nombre,
								es_fin.idestudianterecursofinanciero as id_recursoEstud
								 
								
								FROM 
								
								tipoestudianterecursofinanciero Recurso LEFT JOIN 
								estudianterecursofinanciero es_fin ON (es_fin.idtipoestudianterecursofinanciero=Recurso.idtipoestudianterecursofinanciero AND es_fin.idestudiantegeneral="' . $id_Estudiante . '" AND es_fin.codigoestado=100)
								
								WHERE
								
								Recurso.codigoestado=100
								
								
								ORDER BY Recurso.nombretipoestudianterecursofinanciero ASC';


        if ($RecursoFinacieros = &$db->Execute($SQL_RecursosFinacieros) === false) {
            echo 'Error en el SQL Recurso Finaciero.....<br>' . $SQL_RecursosFinacieros;
            die;
        }

        $D_RecursoFinaciero = $RecursoFinacieros->GetArray();

        $Num = count($D_RecursoFinaciero);

        $l = $Num / 2;
        $l = round($l);
        ?>
        <table border="0" align="left" width="50%">
            <tr>
                <td colspan="5">&nbsp;&nbsp;</td>
            </tr>
        <?php
        for ($t = 0; $t < $l; $t++) {
            if ($D_RecursoFinaciero[$t]['id_recursoEstud']) {
                $Check_Recurso = 'checked="checked"';
            } else {
                $Check_Recurso = '';
            }
            ?>
                <tr>
                    <td>&nbsp;&nbsp;</td>
                    <td><strong> <?php echo $D_RecursoFinaciero[$t]['nombre'] ?></strong></td>
                    <td>&nbsp; <input type="hidden" id="id_RecursoEstudiante_<?php echo $D_RecursoFinaciero[$t]['id'] ?>" value="<?php echo $D_RecursoFinaciero[$t]['id_recursoEstud'] ?>" />&nbsp;</td>
                    <td><input type="checkbox" <?php echo $ClassDisable ?> id="Recuso_id_<?php echo $t ?>" name="RecusroFinanciero" <?php echo $Check_Recurso ?> value="<?php echo $D_RecursoFinaciero[$t]['id'] ?>" onclick="DeleteRecursoFinaciero(<?php echo $t ?>, '<?php echo $D_RecursoFinaciero[$t]['id'] ?>', '<?php echo $id_Estudiante ?>'); CambiaGeneral();<?php if ($D_RecursoFinaciero[$t]['id'] == 8) { ?>Ver_CualRecurso(8, 'Recuso_id_<?php echo $t ?>')<?php } ?>"   /></td>
                    <td>&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="5">&nbsp;&nbsp;</td>
                </tr>
            <?php
        }
        ?>
        </table>
        <table border="0" align="right" width="50%">
            <tr>
                <td colspan="5">&nbsp;&nbsp;</td>
            </tr>
        <?php
        for ($t = $l; $t < $Num; $t++) {
            if ($D_RecursoFinaciero[$t]['id_recursoEstud']) {
                $Check_Recurso = 'checked="checked"';
            } else {
                $Check_Recurso = '';
            }
            ?>
                <tr>
                    <td>&nbsp;&nbsp;</td>
                    <td><strong> <?php echo $D_RecursoFinaciero[$t]['nombre'] ?></strong></td>
                    <td>&nbsp; <input type="hidden" id="id_RecursoEstudiante_<?php echo $D_RecursoFinaciero[$t]['id'] ?>" value="<?php echo $D_RecursoFinaciero[$t]['id_recursoEstud'] ?>" />&nbsp;</td>
                    <td><input type="checkbox" <?php echo $ClassDisable ?> id="Recuso_id_<?php echo $t ?>" name="RecusroFinanciero" <?php echo $Check_Recurso ?>  value="<?php echo $D_RecursoFinaciero[$t]['id'] ?>" onclick="DeleteRecursoFinaciero(<?php echo $t ?>, '<?php echo $D_RecursoFinaciero[$t]['id'] ?>', '<?php echo $id_Estudiante ?>'); CambiaGeneral();<?php if ($D_RecursoFinaciero[$t]['id'] == 8) { ?>Ver_CualRecurso(8, 'Recuso_id_<?php echo $t ?>')<?php } ?>" /></td>
                    <td>&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="5">&nbsp;&nbsp;</td>
                </tr>
                <tr id="Tr_Cual_<?php echo $D_RecursoFinaciero[$t]['id'] ?>" style="visibility:collapse">
                    <td>&nbsp;&nbsp;</td>
                    <td><strong>¿Cuál ?</strong></td>
                    <td>&nbsp;<input type="text" <?php echo $ClassDisable ?> id="Cual_RecursoFianciero" name="Cual_RecursoFianciero" class="CajasHoja" style="text-align:center" onclick="CambiaGeneral()" />&nbsp;</td>
                    <td>&nbsp;&nbsp;</td>
                </tr>
                <tr id="Tr_Cual2_<?php echo $D_RecursoFinaciero[$t]['id'] ?>" style="visibility:collapse" >
                    <td colspan="5">&nbsp;&nbsp;</td>
                </tr>
            <?php
        }
        ?><input type="hidden" id="IndexRecursoFinaciero" value="<?php echo $t ?>" />
        </table>
        <?php
    }

    public function OtrasUniversidades($id_Estudiante) {
        global $db, $userid, $rol_Usuario;


        $SQL_Univerisdad = 'SELECT
					  
										es.idestudianteuniversidad  as id,
										es.institucioneducativaestudianteuniversidad as Name_U,
										es.programaacademicoestudianteuniversidad as Name_Prog,
										es.anoestudianteuniversidad as Year_U
										
										FROM 
										
										estudianteuniversidad  es
										
										WHERE
										
										es.idestudiantegeneral="' . $id_Estudiante . '"
										AND
										es.codigoestado=100';

        if ($universidadEstud = &$db->Execute($SQL_Univerisdad) === false) {
            echo 'Error en el SQl del Otra universidad.......<br>' . $SQL_Univerisdad;
            die;
        }
        ?>

        <fieldset style="border:#88AB0C solid 1px; width:98%">
            <table border="0" align="center" width="90%">
                <tr>
                    <td colspan="9">&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td width="5%">&nbsp;</td>
                    <td width="30%" align="left"><legend>Instituci&oacute;n.</legend></td>
                <td width="5%">&nbsp;</td>
                <td width="20%" align="left"><legend>Programa.</legend></td>
                <td width="5%">&nbsp;</td>
                <td width="10%" align="center"><legend>A&ntilde;o.</legend></td>
                <td width="5%">&nbsp;</td>
                <td width="15%" align="center"><legend>Opciones.</legend></td>
                <td width="5%">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="9">&nbsp;&nbsp;</td>
                </tr>
        <?php
        if (!$universidadEstud->EOF) {
            $j = 0;
            while (!$universidadEstud->EOF) {
                ?>
                        <tr>
                            <td colspan="9">
                                <div id="Muestra_info_<?php echo $j ?>">
                                    <table border="0" align="center" width="100%">
                                        <tr>
                                            <td width="5%">&nbsp;</td>
                                            <td width="30%" align="left"><?php echo $universidadEstud->fields['Name_U'] ?></td>
                                            <td width="5%">&nbsp;</td>
                                            <td width="20%" align="left"><?php echo $universidadEstud->fields['Name_Prog'] ?></td>
                                            <td width="5%">&nbsp;</td>
                                            <td width="10%" align="center"><?php echo $universidadEstud->fields['Year_U'] ?></td>
                                            <td width="5%">&nbsp;</td>
                                            <td width="15%" align="center"><img src="../../images/Pencil3_Edit.png" width="25" align="middle" onclick="Edit_U(<?php echo $j ?>)" />&nbsp;&nbsp;<img src="../../images/Close_Box_Red.png" width="25" align="middle" onclick="Delete_U(<?php echo $universidadEstud->fields['id'] ?>, '<?php echo $id_Estudiante ?>')" /></td>
                                            <td width="5%">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="9">&nbsp;&nbsp;</td>
                                        </tr>
                                    </table>
                                </div> 
                                <div id="Edit_info_<?php echo $j ?>" style="display:none">
                                    <table border="0" align="center" width="100%">
                                        <tr>
                                            <td width="5%">&nbsp;</td>
                                            <td width="30%" align="left"><input type="text" id="institucion_Admi_<?php echo $j ?>" name="institucion_Admi_<?php echo $j ?>" class="CajasHoja" style="text-align:center" value="<?php echo $universidadEstud->fields['Name_U'] ?>" size="50" /></td>
                                            <td width="5%">&nbsp;</td>
                                            <td width="20%" align="left"><input type="text" id="Programa_Admi_<?php echo $j ?>" name="Programa_Admi_<?php echo $j ?>" class="CajasHoja" style="text-align:center"  value="<?php echo $universidadEstud->fields['Name_Prog'] ?>" /></td>
                                            <td width="5%">&nbsp;</td>
                                            <td width="10%" align="center"><input type="text" id="Year_Admi_<?php echo $j ?>" name="Year_Admi_<?php echo $j ?>" class="CajasHoja" style="text-align:center" value="<?php echo $universidadEstud->fields['Year_U'] ?>" /></td>
                                            <td width="5%">&nbsp;</td>
                                            <td width="15%" align="center"><img src="../../images/Check.png" width="22" align="middle" onclick="Update_U(<?php echo $universidadEstud->fields['id'] ?>, '<?php echo $j ?>', '<?php echo $id_Estudiante ?>')" /></td>  
                                            <td width="5%">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="9">&nbsp;&nbsp;</td>
                                        </tr>
                                    </table>
                                </div> 
                            </td>
                        </tr>
                <?php
                $j++;
                $universidadEstud->MoveNext();
            }
        } else {
            ?>
                    <tr>
                        <td align="center" colspan="9"><strong style="color:#999">No Hay Informaci&oacute;n...</strong></td>
                    </tr>
            <?php
        }
        ?>
            </table>
        </fieldset>     
        <?php
    }

    public function OtrosEstudios($id_Estudiante) {
        global $db, $userid, $rol_Usuario;


        $SQL_OtrosEstudios = 'SELECT 

											estudio.idestudianteestudio as id,
											estudio.idniveleducacion,
											estudio.anogradoestudianteestudio,
											estudio.idinstitucioneducativa,
											estudio.codigotitulo,
											estudio.observacionestudianteestudio,
											estudio.ciudadinstitucioneducativa,
											estudio.colegiopertenececundinamarca,
											estudio.otrainstitucioneducativaestudianteestudio,
											nivel.idniveleducacion,
											nivel.nombreniveleducacion,
											titulo.nombretitulo,
											inst.nombreinstitucioneducativa,
											estudio.otrotituloestudianteestudio
								
								FROM 
								
											estudianteestudio AS estudio
											INNER JOIN niveleducacion AS nivel ON nivel.idniveleducacion=estudio.idniveleducacion
											INNER JOIN titulo ON titulo.codigotitulo=estudio.codigotitulo
											INNER JOIN institucioneducativa AS inst  ON inst.idinstitucioneducativa=estudio.idinstitucioneducativa 
								
								WHERE
								
											estudio.idestudiantegeneral="' . $id_Estudiante . '"
											AND
											estudio.idniveleducacion IN (3,4,5,6)
											AND
											estudio.codigoestado=100';

        if ($OtrosEstudios = &$db->Execute($SQL_OtrosEstudios) === false) {
            echo 'Error en el SQL Otros Estudios..........<br>' . $SQL_OtrosEstudios;
            die;
        }
        ?>
        <fieldset style="border:#88AB0C solid 1px; width:95%">
            <table border="0" align="center" width="90%">
                <tr>
                    <td colspan="13">&nbsp;</td>
                </tr>
                <tr>
                    <td width="1%">&nbsp;</td>
                    <td width="12%" align="left"><legend>Nivel.</legend></td>
                <td width="1%">&nbsp;</td>
                <td width="22%" align="left"><legend>Instituci&oacute;n.</legend></td>
                <td width="1%">&nbsp;</td>
                <td width="17%" align="left"><legend>Titulo.</legend></td>
                <td width="1%">&nbsp;</td>
                <td width="13%" align="left"><legend>Ciudad.</legend></td>
                <td width="2%">&nbsp;</td>
                <td width="9%" align="center"><legend>A&ntilde;o.</legend></td>
                <td width="1%">&nbsp;</td>
                <td width="18%" align="center"><legend>Opciones.</legend></td>
                <td width="2%">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="13">&nbsp;</td>
                </tr>
        <?php
        if (!$OtrosEstudios->EOF) {
            $k = 0;
            while (!$OtrosEstudios->EOF) {
                if ($OtrosEstudios->fields['idinstitucioneducativa'] == 1 || $OtrosEstudios->fields['idinstitucioneducativa'] == '1') {
                    $Nom_Institucion = $OtrosEstudios->fields['otrainstitucioneducativaestudianteestudio'];
                    $Check_otro = 'checked="checked"';
                    $ReadOnly = '';
                } else {
                    $Nom_Institucion = $OtrosEstudios->fields['nombreinstitucioneducativa'];
                    $Check_otro = '';
                    $ReadOnly = 'readonly="readonly"';
                }
                if ($OtrosEstudios->fields['codigotitulo'] == 1 || $OtrosEstudios->fields['codigotitulo'] == '1') {
                    $Nom_Titulo = $OtrosEstudios->fields['otrotituloestudianteestudio'];
                    $Check_Titulo = 'checked="checked"';
                } else {
                    $Nom_Titulo = $OtrosEstudios->fields['nombretitulo'];
                    $Check_Titulo = '';
                }
                ###############################################

                $SQL_NivelEdu = 'SELECT 

														idniveleducacion  as id,
														nombreniveleducacion as  nombre
												
												FROM 
												
														niveleducacion 
												
												WHERE 
												
														idniveleducacion IN (3, 4, 6, 5) 
												
												ORDER BY nombreniveleducacion';

                if ($NivelEdu = &$db->Execute($SQL_NivelEdu) === false) {
                    echo 'Error en el SQl De Nivel De eEducacion ............<br>' . $SQL_NivelEdu;
                    die;
                }

                ################################################			
                ?>
                        <tr>
                            <td colspan="13">
                                <div id="Div_Mostrar_<?php echo $k ?>">
                                    <table border="0" align="center" width="100%">
                                        <tr>
                                            <td width="1%">&nbsp;</td>
                                            <td width="12%" align="left"><?php echo $OtrosEstudios->fields['nombreniveleducacion'] ?></td>
                                            <td width="1%">&nbsp;</td>
                                            <td width="22%" align="left"><?php echo $Nom_Institucion ?></td>
                                            <td width="1%">&nbsp;</td>
                                            <td width="17%" align="left"><?php echo $Nom_Titulo ?></td>
                                            <td width="1%">&nbsp;</td>
                                            <td width="13%" align="left"><?php echo $OtrosEstudios->fields['ciudadinstitucioneducativa'] ?></td>
                                            <td width="2%">&nbsp;</td>
                                            <td width="9%" align="center"><?php echo $OtrosEstudios->fields['anogradoestudianteestudio'] ?></td>
                                            <td width="1%">&nbsp;</td>
                                            <td width="18%" align="center"><img src="../../images/Pencil3_Edit.png" width="25" align="middle" onclick="Edit_Otro(<?php echo $k ?>)" />&nbsp;&nbsp;<img src="../../images/Close_Box_Red.png" width="25" align="middle" onclick="Delete_Otro(<?php echo $OtrosEstudios->fields['id'] ?>, '<?php echo $id_Estudiante ?>')" /></td>
                                            <td width="2%">&nbsp;</td>
                                        </tr>
                                    </table>
                                </div>
                                <div id="Div_EditOtro_<?php echo $k ?>" style="display:none">
                                    <table border="0" align="center" width="100%">
                                        <tr>
                                            <td width="1%">&nbsp;</td>
                                            <td width="12%" align="left">
                                                <select id="Nivel_<?php echo $k ?>" name="Nivel_<?php echo $k ?>" class="CajasHoja" >
                                                    <option value="<?php echo $OtrosEstudios->fields['idniveleducacion'] ?>"><?php echo $OtrosEstudios->fields['nombreniveleducacion'] ?></option>
                <?php
                while (!$NivelEdu->EOF) {
                    if ($NivelEdu->fields['id'] != $OtrosEstudios->fields['idniveleducacion']) {
                        ?>
                                                            <option value="<?php echo $NivelEdu->fields['id'] ?>"><?php echo $NivelEdu->fields['nombre'] ?></option>
                        <?php
                    }
                    $NivelEdu->MoveNext();
                }
                ?>
                                                </select>
                                            </td>
                                            <td width="1%">&nbsp;</td>
                                            <td width="22%" align="left"><input type="text" id="Institucion_Otros_<?php echo $k ?>" name="Institucion_Otros_<?php echo $k ?>" class="CajasHoja" autocomplete="off" style="text-align:center; width:90%" size="50" onclick="Format_UniOtro(<?php echo $k ?>)" onkeypress="AutocompletarUniverisidadOtro(<?php echo $k ?>)" value="<?php echo $Nom_Institucion ?>" /><input  type="hidden" id="id_Universidad_OtroEdit_<?php echo $k ?>" name="id_Universidad_OtroEdit_<?php echo $k ?>" value="<?php echo $OtrosEstudios->fields['idinstitucioneducativa'] ?>" />&nbsp;&nbsp;&nbsp;<input type="checkbox" id="OtraUniv_Edit_<?php echo $k ?>" name="OtraUniv_Edit_<?php echo $k ?>" <?php echo $Check_otro ?> /></td>
                                            <td width="1%">&nbsp;</td>
                                            <td width="17%" align="left"><input type="text" id="Titulo_otrosEdit_<?php echo $k ?>" name="Titulo_otrosEdit_<?php echo $k ?>" class="CajasHoja" style="text-align:center" autocomplete="off" onclick="Format_TituloEdit(<?php echo $k ?>)" onkeypress="AutoCompletTituloEdit(<?php echo $k ?>)" value="<?php echo $Nom_Titulo ?>"  /><input type="hidden" id="Titulo_id_Edit_<?php echo $k ?>" name="Titulo_id_Edit_<?php echo $k ?>" value="<?php echo $OtrosEstudios->fields['codigotitulo'] ?>"  />&nbsp;&nbsp;&nbsp;<input type="checkbox" id="Titulo_No_Edit_<?php echo $k ?>" name="Titulo_No_Edit_<?php echo $k ?>" <?php echo $Check_Titulo ?> /></td>
                                            <td width="1%">&nbsp;</td>
                                            <td width="13%" align="left"><input type="text" id="Ciudad_OtrosEdit_<?php echo $k ?>" name="Ciudad_OtrosEdit_<?php echo $k ?>" class="CajasHoja" autocomplete="off" style="text-align:center"  onkeypress="AutocompletCytyUnivEdit(<?php echo $k ?>)" value="<?php echo $OtrosEstudios->fields['ciudadinstitucioneducativa'] ?>" <?php echo $ReadOnly ?>  /></td>
                                            <td width="2%">&nbsp;</td>
                                            <td width="9%" align="center"><input type="text" id="Year_Edit_<?php echo $k ?>" name="Year_Edit_<?php echo $k ?>" class="CajasHoja" style="text-align:center" value="<?php echo $OtrosEstudios->fields['anogradoestudianteestudio'] ?>" /></td>
                                            <td width="1%">&nbsp;</td>
                                            <td width="18%" align="center">&nbsp;<img src="../../images/Check.png" width="22" align="middle" onclick="Update_Otro(<?php echo $OtrosEstudios->fields['id'] ?>, '<?php echo $k ?>', '<?php echo $id_Estudiante ?>')" />&nbsp;</td>
                                            <td width="2%">&nbsp;</td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                <?php
                $k++;
                $OtrosEstudios->MoveNext();
            }
        } else {
            ?>
                    <tr>
                        <td colspan="13" align="center"><strong style="color:#999">No Hay Informaci&oacute;n...</strong></td>	
                    </tr>
            <?php
        }
        ?>
                <tr>
                    <td colspan="13">&nbsp;</td>
                </tr>
            </table>
        </fieldset>
        <?php
    }

    public function Periodo($name, $Text, $Disable = '', $Onchange = '') {
        global $db, $userid;
        /*         * **************************************** */
        $SQL_Periodo = 'SELECT codigoperiodo  FROM periodo ORDER BY codigoperiodo DESC';

        if ($Periodo = &$db->Execute($SQL_Periodo) === false) {
            echo 'Error en el SQL del Periodo...<br>' . $SQL_Periodo;
            die;
        }
        ?>
        <select id="<?php echo $name ?>" name="<?php echo $name ?>" style="width: auto; text-align:center" class="CajasHoja" <?php echo $Disable;
        if ($Onchange != '') { ?>onchange="<?php echo $Onchange . "()"; ?>" <?php } ?>>
            <option value="-1"><?php echo $Text ?></option>
        <?php
        while (!$Periodo->EOF) {
            ?>
                <option value="<?php echo $Periodo->fields['codigoperiodo'] ?>"><?php echo $Periodo->fields['codigoperiodo'] ?></option>
            <?php
            $Periodo->MoveNext();
        }
        ?>
        </select>
        <?php
        /*         * ****************************************** */
    }

//Peridod

    public function Pregunta($pregunta, $id_Si, $id_No, $name_seleccion, $OnClick, $Disable = '') {
        global $userid, $db;
        ?>
        <table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
            <tr>
                <td>&nbsp;&nbsp;</td>
                <td width="50%"><strong><?php echo $pregunta ?></strong>&nbsp;&nbsp;<span style="color:#FF0000; font-size:10px" >*</span></td>
                <td width="10%">&nbsp;&nbsp;</td>
                <td align="center" width="20%"><strong>Si.</strong>&nbsp;&nbsp;&nbsp;
                    <input type="radio" id="<?php echo $id_Si ?>" name="<?php echo $name_seleccion ?>" onclick="<?php echo $OnClick . "()"; ?>" <?php echo $Disable ?> value="0" />&nbsp;&nbsp;&nbsp;
                    <strong>No.</strong>&nbsp;&nbsp;&nbsp;
                    <input type="radio" id="<?php echo $id_No ?>" name="<?php echo $name_seleccion ?>" onclick="<?php echo $OnClick . "()"; ?>" <?php echo $Disable ?>  value="1" />
                </td>
                <td>&nbsp;&nbsp;</td>
            </tr>
        </table>
        <?php
    }

//fin		

    public function Respuestas($tipo, $NameTipo, $name = '', $nameFinal = '', $Type, $Disable = '', $Ver, $ext, $op, $index, $Cadena = '', $P_ini_ = '', $P_fin_ = '', $Hidden = '', $periodo = null) {
        global $db, $userid;
        ?>
        <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
                <?php
                if ($Ver == 0) {
                    ?>
                <tr>
                    <td colspan="2">
                        <table border="0" align="right">
                            <tr>
                                <td>&nbsp;&nbsp;<span style="color:#FF0000; font-size:10px" >*</span>  
                    <?php $this->Periodo($name, 'Selecione Periodo Inicial', $Disable, '') ?> 
                                </td>
                                <td>&nbsp;&nbsp;</td>      
                                <td >
                    <?php $this->Periodo($nameFinal, 'Selecione Periodo Final', $Disable, '') ?>   
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <?php } ?>
            <tr>
                <td colspan="2">&nbsp;&nbsp;</td>
            </tr>
                <?php
                if ($op == 0) {
                    $Consulta = $this->ConsultaDeportes($Type);
                }
                if ($op == 1) {
                    $Consulta = $this->ConsultaCultura($Type);
                }
                ?>
            <tr>
                <td colspan="2">
                    <table border="0" width="100%" align="center">
                <?php
                if (!$Consulta->EOF) {
                    $i = 0;
                    while (!$Consulta->EOF) {
                        /*                         * ********************************** */
                        ?>
                                <tr>
                                    <td >&nbsp;&nbsp;</td>
                                    <td ><strong>*<?php echo $Consulta->fields['Nombre'] ?></strong><input type="hidden" id="<?php echo $Hidden . $i ?>" /></td>
                                    <td >&nbsp;&nbsp;</td>
                                    <td><input type="<?php echo $tipo ?>" id="<?php echo $i . $ext ?>" name="<?php echo $NameTipo ?>" <?php echo $Disable ?> value="<?php echo $Consulta->fields['id'] ?>" onclick="Cancelar(<?php echo $i ?>, '<?php echo $Hidden ?>')" /> </td>
                                    <td >&nbsp;</td>
                <?php
                if ($Ver == 1) {

                    $nameDim = $P_ini_ . $i;
                    $nameFinalDim = $P_fin_ . $i;
                    ?>
                                        <td>
                                            <table border="0" align="right">
                                                <tr>
                                                    <td>&nbsp;&nbsp;<span style="color:#FF0000; font-size:10px" >*</span>
                    <?php $this->Periodo($nameDim, 'Selecione Perido Inical', $Disable) ?>   
                                                    </td>
                                                    <td>&nbsp;&nbsp;</td>      
                                                    <td >&nbsp;&nbsp;<span style="color:#FF0000; font-size:10px" >*</span>
                    <?php $this->Periodo($nameFinalDim, 'Selecione Perido Final', $Disable) ?>   
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                <?php } ?>
                                </tr>   
                                <tr>       
                                    <td colspan="5">&nbsp;&nbsp;</td>
                                </tr>
                                                    <?php
                                                    /*                                                     * ********************************** */
                                                    $i++;
                                                    $Consulta->MoveNext();
                                                }//while
                                            }//if
                                            ?>
                    </table>
                    <input type="hidden" id="<?php echo $index ?>" value="<?php echo $i ?>" />
                    <input type="hidden" id="<?php echo $Cadena ?>" />
                </td>	
            </tr>
        </table>
        <?php
    }

//fin

    public function ConsultaDeportes($Type) {
        global $db, $userid;

        if ($Type == 'seleccion') {
            $Mas = '  AND id_deportesbienestar NOT IN(2,5,8)';
        } else {
            $Mas = '';
        }

        $SQL = 'SELECT 
														
					id_deportesbienestar AS id,
					nombredeporte as Nombre,
					nombrecorto
					
					FROM 
					
					deportesbienestar
					
					WHERE
					
					' . $Type . '=1
					AND
					codigoestado=100
					AND
					cancel=0' . $Mas;

        if ($Consulta = &$db->Execute($SQL) === false) {
            echo 'Error en el SQL ...<br><br>' . $SQL;
            die;
        }
        /*         * ******************************* */
        return $Consulta;
        /*         * ******************************* */
    }

//fin

    public function ConsultaCultura($Type) {
        global $db, $userid;

        $SQL = 'SELECT 

					id_culturabienestar as id,
					nombre  as Nombre,
					nombrecorto
					
					FROM 
					
					culturabienestar 
					
					WHERE
					
					' . $Type . '=1
					AND
					codigoestado=100
					AND
					cancel=0';

        if ($Consulta = &$db->Execute($SQL) === false) {
            echo 'Error en el SQL ...<br><br>' . $SQL;
            die;
        }
        /*         * ******************************* */
        return $Consulta;
        /*         * ******************************* */
    }

//fin	

    public function CajaRespuesta($name, $P_Name, $P_nameFin, $Disable = '', $Ver) {
        global $db, $userid;
        ?>
        <table border="0" align="center" width="100%">
            <tr>
                <td>&nbsp;</td>
                <td><strong>¿Cuál ?</strong></td>
                <td><input type="text" id="<?php echo $name ?>" name="<?php echo $name ?>" class="CajasHoja" placeholder="Cual...?" <?php echo $Disable ?> /></td>
                <td>&nbsp;&nbsp;</td>
                <td>
        <?php $this->Periodo($P_Name, 'Periodo Inicial', $Disable); ?>
                </td>
                                <?php
                                if ($Ver == 1) {
                                    ?>
                    <td>&nbsp;&nbsp;</td>
                    <td>
                                    <?php $this->Periodo($P_nameFin, 'Periodo Final', $Disable); ?>
                    </td>
        <?php } ?>
            </tr>
        </table>
        <?php
    }

}

#Fin Class

function CalculaEdad($fecha) {

    list($Y, $m, $d) = explode("-", $fecha);

    return( date("md") < $m . $d ? date("Y") - $Y - 1 : date("Y") - $Y );
}
//end
?>