<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php');
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

require('../../../Connections/sala2.php');
//@@session_start();
?>

<style type="text/css">

    <!--

    .Estilo1 {font-family: Tahoma; font-size: 12px}

    .Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }

    .Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}

    .Estilo4 {color: #FF0000}

    -->

</style>

<form name="inscripcion" method="post" action="decisionuniversidad.php">

    <?php
    $codigoinscripcion = $_SESSION['numerodocumentosesion'];
    mysql_select_db($database_sala, $sala);
    $query_decisionuniversidad = "select *
    from decisionuniversidad
    order by 2";
    $decisionuniversidad = mysql_query($query_decisionuniversidad, $sala) or die("$query_decisionuniversidad");
    $totalRows_decisionuniversidad = mysql_num_rows($decisionuniversidad);
    $row_decisionuniversidad = mysql_fetch_assoc($decisionuniversidad);


    $query_formularios = "SELECT linkinscripcionmodulo,posicioninscripcionformulario,nombreinscripcionmodulo,im.idinscripcionmodulo

					 FROM inscripcionformulario ip, inscripcionmodulo im

					 WHERE ip.idinscripcionmodulo = im.idinscripcionmodulo

					 AND ip.codigomodalidadacademica = '" . $_SESSION['modalidadacademicasesion'] . "'

					 AND ip.codigoestado LIKE '1%'

					 order by posicioninscripcionformulario";

    $formularios = mysql_query($query_formularios, $sala) or die("$query_selgenero");

    $totalRows_formularios = mysql_num_rows($formularios);

    $row_formularios = mysql_fetch_assoc($formularios);



    unset($modulos);

    unset($nombremodulo);

    unset($iddescripcion);

    $limitemodulo = $totalRows_formularios;

    $cuentamodulos = 1;



    do {

        $modulos[$cuentamodulos] = $row_formularios['linkinscripcionmodulo'];

        $nombremodulo[$cuentamodulos] = $row_formularios['nombreinscripcionmodulo'];

        $iddescripcion[$cuentamodulos] = $row_formularios['idinscripcionmodulo'];

        //echo $nombremodulo[$cuentamodulos],"/<br>";

        $cuentamodulos++;
    } while ($row_formularios = mysql_fetch_assoc($formularios));



    $query_data = "SELECT eg.*,c.nombrecarrera,m.nombremodalidadacademica,ci.nombreciudad,m.codigomodalidadacademica,i.idinscripcion

               FROM estudiantegeneral eg,inscripcion i,estudiantecarrerainscripcion e,carrera c,modalidadacademica m,ciudad ci

			   WHERE numerodocumento = '$codigoinscripcion'

			   AND eg.idestudiantegeneral = i.idestudiantegeneral

			   AND eg.idciudadnacimiento = ci.idciudad

			   AND i.idinscripcion = e.idinscripcion

			   AND e.codigocarrera = c.codigocarrera

			   AND m.codigomodalidadacademica = i.codigomodalidadacademica 

			   and i.codigoestado like '1%'

			   AND e.idnumeroopcion = '1'

			   and i.idinscripcion = '" . $_SESSION['inscripcionsession'] . "'";

//echo $query_data; 

    $data = mysql_query($query_data, $sala) or die("$query_data");

    $totalRows_data = mysql_num_rows($data);

    $row_data = mysql_fetch_assoc($data);



    if (isset($_POST['inicial']) or isset($_GET['inicial'])) { // vista previa	  
        ?>

        <div align="center" class="style1">

            <p><img src="../../../../imagenes/inscripcion.gif"></p>

        </div>

        <br>

        <?php
        if (isset($_GET['inicial'])) {

            $moduloinicial = $_GET['inicial'];

            echo '<input type="hidden" name="inicial" value="' . $_GET['inicial'] . '">';
        } else {

            $moduloinicial = $_POST['inicial'];

            echo '<input type="hidden" name="inicial" value="' . $_POST['inicial'] . '">';
        }
        ?>

        <table width="70%" border="1" align="center" bordercolor="#003333" cellpadding="0" cellspacing="0">

            <tr>

                <td>	

                    <table width="100%" border="0" align="center" cellpadding="3" bordercolor="#003333">

                        <tr>        

                            <td colspan="2">

                                <table border="0" align="center" cellpadding="1" bordercolor="#003333">

                                    <tr>      

                                        <?php
                                        for ($i = 1; $i < $cuentamodulos; $i++) {
                                            if ($i == $moduloinicial) {

                                                echo "<td  bgcolor='#FEF7ED' border='3' align='center' cellpadding='3' bordercolor='#003333'>";

                                                echo '<strong><div align = "center"><font size="1" face="Tahoma" color="#990033">', $nombremodulo[$i], "</font></div></strong>";

                                                echo "</td>";
                                            } else {

                                                echo "<td bgcolor='#CCDADD'>";

                                                echo '<strong><div align = "center"><font size="1" face="Tahoma">', $nombremodulo[$i], "</font></div></strong>";

                                                echo "</td>";
                                            }
                                        }
                                        ?>			   

                                    </tr>	   

                                </table>

                            </td>

                        </tr>	

                        <tr bgcolor='#FEF7ED'>

                            <td class="Estilo2">&nbsp;Nombre</td>

                            <td class="Estilo1"><?php echo $row_data['nombresestudiantegeneral']; ?>&nbsp;<?php echo $row_data['apellidosestudiantegeneral']; ?></td>

                        </tr>

                        <tr bgcolor='#FEF7ED'>

                            <td class="Estilo2">&nbsp;Modalidad Acad&eacute;mica</td>

                            <td class="Estilo1"><?php echo $row_data['nombremodalidadacademica']; ?>&nbsp;</td>

                        </tr> 

                        <tr bgcolor='#FEF7ED'>

                            <td class="Estilo2">&nbsp;Nombre del Programa</td>

                            <td class="Estilo1"><?php echo $row_data['nombrecarrera']; ?>&nbsp;</td>

                        </tr>

                    </table>



                    <?php
                } // vista previa	      

                $query_datosgrabados = "SELECT * 

								 FROM estudiantedecisionuniversidad e,decisionuniversidad d

								 WHERE e.idestudiantegeneral = '" . $row_data['idestudiantegeneral'] . "'

								 and e.codigodecisionuniversidad = d.codigodecisionuniversidad														 

								 and e.codigoestadoestudiantedecisionuniversidad like '1%'

								 order by nombredecisionuniversidad";

///echo $query_datosgrabados; 

                $datosgrabados = mysql_query($query_datosgrabados, $sala) or die("$query_estudios" . mysql_error());

                $totalRows_datosgrabados = mysql_num_rows($datosgrabados);

                $row_datosgrabados = mysql_fetch_assoc($datosgrabados);



                if ($row_datosgrabados <> "") {
                    ?>

                    <table width="100%" border="0" align="center" cellpadding="3" bordercolor="#003333">

                        <tr bgcolor="#CCDADD">

                            <td class="Estilo2" align="center">Decisión</td>



                        </tr>

                        <?php do { ?>

                            <tr bgcolor='#FEF7ED'>

                                <td><div align="center"><font size="2" face="Tahoma"><?php echo $row_datosgrabados['nombredecisionuniversidad']; ?>&nbsp;</font></div></td>

                            </tr>			   

                            <?php
                        } while ($row_datosgrabados = mysql_fetch_assoc($datosgrabados));
                        ?>

                    </table> 



                    <?php
                }

                if (isset($_POST['inicial']) or isset($_GET['inicial'])) { // vista previa	  	  
                    if (isset($_GET['inicial'])) {

                        $moduloinicial = $_GET['inicial'];

                        echo '<input type="hidden" name="inicial" value="' . $_GET['inicial'] . '">';
                    } else {

                        $moduloinicial = $_POST['inicial'];

                        echo '<input type="hidden" name="inicial" value="' . $_POST['inicial'] . '">';
                    }
                    ?>



                    <table width="100%" border="0" align="center" cellpadding="3" bordercolor="#003333">

                        <tr class="Estilo3">

                            <td colspan="2" bgcolor="#CCDADD" align="center"><?php echo $nombremodulo[$moduloinicial]; ?>&nbsp;&nbsp;<a onClick="window.open('pregunta.php?id=<?php echo $iddescripcion[$moduloinicial]; ?>', 'mensajes', 'width=400,height=200,left=300,top=500,scrollbars=yes')" style="cursor: pointer"><img src="../../../../imagenes/pregunta.gif" width="18" height="18" alt="Ayuda"></a></td>

                        </tr>
                        <?php
                        $cuentamedio = 1;
                        do {
                            ?>
                            <tr bgcolor='#FEF7ED' class="Estilo1">
                                <td width="51%" align="center"><?php echo $row_decisionuniversidad['nombredecisionuniversidad']; ?></td>
                                <td width="49%" align="center"><input type="checkbox" name="mediocomunicacion<?php echo $cuentamedio; ?>" value="<?php echo $row_decisionuniversidad['codigodecisionuniversidad']; ?>"></td>
                            </tr>
                            <?php
                            $cuentamedio++;
                        } while ($row_decisionuniversidad = mysql_fetch_assoc($decisionuniversidad));
                        ?>
                    </table>
                </td> 
            </tr>   
        </table>     

        <script language="javascript">
            function grabar()
            {
                document.inscripcion.submit();
            }
            function vista()
            {
                window.location.reload("vistaformularioinscripcion.php");
            }
        </script>
        <br><br>
        <div align="center">
            <input type="image" src="../../../../imagenes/guardar.gif" name="Guardar" value="Guardar" width="25" height="25" alt="Guardar">
            <a onClick="vista()" style="cursor: pointer"><img src="../../../../imagenes/vistaprevia.gif" width="25" height="25" alt="Vista Previa"></a>  
            <input type="hidden" name="grabado" value="grabado">   
            <br><br>
            <?php
            $banderagrabar = 1;

            if (isset($_GET['inicial'])) {
                $moduloinicial = $_GET['inicial'];
                echo '<input type="hidden" name="inicial" value="' . $_GET['inicial'] . '">';
            } else {
                $moduloinicial = $_POST['inicial'];
                echo '<input type="hidden" name="inicial" value="' . $_POST['inicial'] . '">';
            }

            if ($moduloinicial > 1) {
                $atras = $moduloinicial - 1;
                //echo '<a href="'.$modulos[$atras].'?inicial='.$atras.'"><img src="../../../../imagenes/izquierda.gif" width="20" height="20" alt="Atras"></a>';
                echo '<input type="image" src="../../../../imagenes/izquierda.gif" name="atras" value="atras" width="25" height="25" alt="Atras">';
            }
            echo "&nbsp;&nbsp;";
            if ($moduloinicial < $limitemodulo) {
                $adelante = $moduloinicial + 1;
                //echo '<a href="'.$modulos[$adelante].'?inicial='.$adelante.'"><img src="../../../../imagenes/derecha.gif" width="20" height="20" alt="Adelante"></a>';
                echo '<input type="image" src="../../../../imagenes/derecha.gif" name="adelante" value="adelante" width="25" height="25" alt="Adelante">';
            }

            $banderagrabar_continiar = 0;
            $paginaactual = 1;
            foreach ($_POST as $key => $value) {
                if (ereg("adelante", $key) or ereg("atras", $key)) {
                    for ($i = 1; $i < $cuentamedio; $i++) {
                        if (($_POST['mediocomunicacion' . $i] <> "")) {
                            $banderagrabar_continiar = 1;
                        }
                    }
                } else
                if (ereg("Guardar", $key)) {
                    $banderagrabar_continiar = 1;
                    $paginaactual = 0;
                }
            }

            if ($banderagrabar_continiar == 1) {
                for ($i = 1; $i < $cuentamedio; $i++) {
                    if ($_POST['mediocomunicacion' . $i] == "") {
                        $banderagrabar++;
                    }
                }
                $indicador = 0;
                if ($banderagrabar == $i) {
                    echo '<script language="JavaScript">alert("Debe seleccionar los medios por los cuales decidio estudiar en la Universidad"); history.go(-1);</script>';
                    $indicador = 1;
                } else
                if ($indicador == 0) {
                    $base = "update estudiantedecisionuniversidad
		    set codigoestadoestudiantedecisionuniversidad = '200'
			where idestudiantegeneral = '" . $row_data['idestudiantegeneral'] . "'";
                    $sol = mysql_db_query($database_sala, $base);

                    for ($i = 1; $i < $cuentamedio; $i++) {
                        if ($_POST['mediocomunicacion' . $i] <> "") {
                            $query_decision = "INSERT INTO estudiantedecisionuniversidad(idestudiantedecisionuniversidad,idestudiantegeneral,codigodecisionuniversidad,codigoestadoestudiantedecisionuniversidad,idinscripcion) 
				VALUES(0,'" . $row_data['idestudiantegeneral'] . "','" . $_POST['mediocomunicacion' . $i] . "','100', '" . $row_data['idinscripcion'] . "')";
                            //echo "$query_insestudiantedocumento <br>";
                            $decision = mysql_db_query($database_sala, $query_decision) or die("$query_decision" . mysql_error());
                        }
                    }

                    if ($paginaactual == 0) {
                        echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=decisionuniversidad.php?inicial=$moduloinicial'>";
                    } //aca
                    else
                    if (ereg("adelante", $key) or ereg("atras", $key)) {
                        foreach ($_POST as $key => $value) {
                            if (ereg("adelante", $key)) {
                                echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=" . $modulos[$adelante] . "?inicial=" . $adelante . "'>";
                                exit();
                            } else
                            if (ereg("atras", $key)) {
                                echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=" . $modulos[$atras] . "?inicial=" . $atras . "'>";
                                exit();
                            }
                        }
                    } // aca  
                }
            } else
            if (ereg("adelante", $key) or ereg("atras", $key)) {
                foreach ($_POST as $key => $value) {
                    if (ereg("adelante", $key)) {
                        echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=" . $modulos[$adelante] . "?inicial=" . $adelante . "'>";
                        exit();
                    } else
                    if (ereg("atras", $key)) {
                        echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=" . $modulos[$atras] . "?inicial=" . $atras . "'>";
                        exit();
                    }
                }
            }
        } // vista previa	  	
        ?>
    </div> 
</form>