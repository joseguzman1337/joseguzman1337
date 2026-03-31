<?php

    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    /* Modificacion de la conexion de la base de datos*/    
    require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php'); 
    $rutaado = "../../../funciones/adodb/";
    require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado.php');
    require_once('../../../Connections/sala2.php');
    require_once('../../../funciones/funcionip.php' );
    require_once('../../../funciones/clases/autenticacion/redirect.php' );
    $ip = "SIN DEFINIR";
    $ip = tomarip();    
    
    require_once('../actualizarmatriculados.php');

    $codigoperiodo = $_SESSION['codigoperiodosesion'];

    if (!$_SESSION['MM_Username'])
    {
        header( "Location: https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/consultafacultadesv2.htm");
    }
?>
<html>
    <head>
        <title>Modificacion matricula o prematricula</title>
        <script language="javascript">
            function actualizar(dir)
            {
                window.location.href="modificacionprematricula.php"+dir;
            }//actualizar
            
            function ChequearTodos(chkbox, seleccion)
            {
                for (var i=0;i < document.forms[0].elements.length;i++)
                {
                    var elemento = document.forms[0].elements[i];

                    if (elemento.title == seleccion)
                    {
                    elemento.checked = chkbox.checked
                    }
                }
            }//ChequearTodos
            
            function limpiar0(numero)
            {
                if(document.form1.dat[numero-2].checked)
                {
                    document.form1.dat[numero-2].checked = false;
                }
            }//limpiar0
            
            function limpiar1(numero)
            {
                if(document.form1.dat[numero-1].checked)
                {
                    document.form1.dat[numero-1].checked = false;
                }
            }//limpiar1
            
            function limpiar2(numero)
            {
                if(document.form1.data[numero-2].checked)
                {
                    document.form1.data[numero-2].checked = false;
                }
            }//limpiar2
            
            function limpiar3(numero)
            {
                if(document.form1.data[numero-1].checked)
                {
                    document.form1.data[numero-1].checked = false;
                }
            }//limpiar3
        </script>
        <style type="text/css">
        <!--
        .Estilo3 {
            font-family: tahoma;
            font-size: xx-small;
        }
        .Estilo4 {font-size: xx-small}
        .Estilo6 {
            font-size: 14px;
            font-weight: bold;
            font-family: Tahoma;
        }
        .Estilo7 {
            font-family: Tahoma;
            font-size: 12px;
        }
        .Estilo9 {
            font-family: Tahoma;
            font-weight: bold;
            font-size: 12px;
        }
        .Estilo10 {font-size: 12}
        .Estilo12 {
            font-size: 12px;
            font-weight: bold;
        }
        -->
        </style>
    </head>
    <?php
        if(isset($_SESSION['codigo']))
        {
            $_GET['estudiante'] = $_SESSION['codigo'];
        }
        if(isset($_GET['estudiante']))
        {
            $codigoestudiante = $_GET['estudiante'];
            $usonuevofacultad = false;
        }
        else if(isset($_GET['programausadopor']))
        {
            if($_GET['programausadopor'] == "facultad")
            {                
                $codigoestudiante = $_SESSION['codigo'];
                $usonuevofacultad = true;
            }
        }
        if(isset($_GET['usonuevofacultad']))
        {
            $codigoestudiante = $_GET['estudiante'];
            $usonuevofacultad = true;
        }

        if(isset($_POST['Aceptar']))
        {
            $query_selplanestudio="SELECT
                p.idplanestudio,
                e.codigocarrera
            FROM
                planestudioestudiante p,
                estudiante e
            WHERE
                p.codigoestudiante = '$codigoestudiante'
            AND p.codigoestadoplanestudioestudiante LIKE '1%'
            AND e.codigoestudiante = p.codigoestudiante";
	
            $selplanestudio=mysql_db_query($database_sala,$query_selplanestudio) or die("$query_selplanestudio");
            $row_selplanestudio=mysql_fetch_array($selplanestudio);
            $idplanestudio = $row_selplanestudio['idplanestudio'];
            $codigocarrera = $row_selplanestudio['codigocarrera'];
            $usuario = $_SESSION['MM_Username'];

            foreach($_POST as $llave => $valor)
            {
                $asignacion = "\$" . $llave . "='" . $valor . "';";
                // Partir la variable en codigomateria y codigomaterianovasoft
                $pos = strpos ($valor, ":");
                $codigomateria = substr($valor,0,$pos);
                $codigomaterianovasoft = substr ($valor, $pos+1);
                //echo $asignacion."<br>";
                //echo "<br>nova: $codigomaterianovasoft";
                //echo "<br>mate: $codigomateria<br>";
                // En este if se entra cuando se quieren eliminar las materias que pertenecen a la carga generada
            if(ereg("eliminarcarga",$llave))
            {
                // Inserta en la tabla de carga académica las materias eliminadas de la carga automática
                $query_inscarga="INSERT INTO cargaacademica(idcargaacademica, codigoestudiante, codigomateria, codigoperiodo, idplanestudio, usuario, fechacargaacademica, codigoestadocargaacademica,ip)
                VALUES(0, '$codigoestudiante', '$valor', '$codigoperiodo', '$idplanestudio', '$usuario', '".date("Y-m-d H:i:s",time())."', '201','$ip')";
                $inscarga=mysql_db_query($database_sala,$query_inscarga) or die("$query_inscarga");

                // 1 Busca los datos del detlleprematricula a la cual le va a hacer el update
                // 2 mira si tiene nota en la materia y la elimina
                // 3 cambia el estado en detalleprematricula, lo pone en 22 (retirada por alumno)
                $query_logdetalleprematricula = "SELECT dp.idprematricula, dp.codigomateria, dp.codigomateriaelectiva,
                dp.codigotipodetalleprematricula, dp.idgrupo, dp.numeroordenpago
                FROM detalleprematricula dp, estudiante e, prematricula p
                WHERE dp.idprematricula = p.idprematricula
                AND p.codigoestudiante = e.codigoestudiante
                AND e.codigoestudiante = '$codigoestudiante'
                AND p.codigoperiodo = '$codigoperiodo'
                AND (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%')
                AND (dp.codigoestadodetalleprematricula like '3%' or dp.codigoestadodetalleprematricula like '1%' or dp.codigoestadodetalleprematricula like '23%')
                AND (dp.codigomateria = '$valor' or dp.codigomateriaelectiva = '$valor')";
                $logdetalleprematricula = mysql_query($query_logdetalleprematricula,$sala) or die("$query_logdetalleprematricula");
                $totalRows_logdetalleprematricula = mysql_num_rows($logdetalleprematricula);

                if($totalRows_logdetalleprematricula != "" && $totalRows_logdetalleprematricula >0)
                {
                   $query_deldetallenota="DELETE FROM detallenota
                                               WHERE idgrupo = '".$logdetalleprematricula['idgrupo']."'
                                               AND codigoestudiante = '$codigoestudiante'
                                               AND codigomateria = '$valor'";
                    $deldetallenota=mysql_db_query($database_sala,$query_deldetallenota) or die("$query_deldetallenota");
                    while($row_logdetalleprematricula = mysql_fetch_array($logdetalleprematricula))
                    {
                        $query_inslogdetalleprematricula = "INSERT INTO logdetalleprematricula(idprematricula, codigomateria, codigomateriaelectiva, codigoestadodetalleprematricula, codigotipodetalleprematricula, idgrupo, numeroordenpago, fechalogfechadetalleprematricula, usuario)
                        VALUES('".$row_logdetalleprematricula['idprematricula']."','".$row_logdetalleprematricula['codigomateria']."','".$row_logdetalleprematricula['codigomateriaelectiva']."','22','".$row_logdetalleprematricula['codigotipodetalleprematricula']."','".$row_logdetalleprematricula['idgrupo']."','".$row_logdetalleprematricula['numeroordenpago']."','".date("Y-m-d H:i:s")."','".$_SESSION['MM_Username']."')";
                        $inslogdetalleprematricula = mysql_query($query_inslogdetalleprematricula, $sala) or die("$query_inslogdetalleprematricula");
                    }

                }
                // finlog
                $query_upddetalleprematricula="UPDATE detalleprematricula dp, estudiante e, prematricula p
                SET dp.codigoestadodetalleprematricula = '22'
                WHERE dp.idprematricula = p.idprematricula
                AND p.codigoestudiante = e.codigoestudiante
                AND e.codigoestudiante = '$codigoestudiante'
                AND p.codigoperiodo = '$codigoperiodo'
                AND (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%')
                AND (dp.codigoestadodetalleprematricula like '3%' or dp.codigoestadodetalleprematricula like '1%' or dp.codigoestadodetalleprematricula like '23%')
                AND (dp.codigomateria = '$valor' or dp.codigomateriaelectiva = '$valor')";

                $upddetalleprematricula=mysql_db_query($database_sala,$query_upddetalleprematricula) or die(mysql_error()."$query_upddetalleprematricula");

                // Recalcula y actualiza el semestre y los creditos del estudiante
                // Esto lo hace si el estudiante tiene prematricula activa
                $query_selprematricula="SELECT p.idprematricula, dp.codigomateria, dp.idgrupo
                FROM detalleprematricula dp, prematricula p
                WHERE dp.idprematricula = p.idprematricula
                AND p.codigoestudiante = '$codigoestudiante'
                AND p.codigoperiodo = '$codigoperiodo'
                AND (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%')
                AND (dp.codigoestadodetalleprematricula like '3%' or dp.codigoestadodetalleprematricula like '1%')";

                $selprematricula=mysql_db_query($database_sala,$query_selprematricula) or die("$query_selprematricula");
                $totalRows_selprematricula = mysql_num_rows($selprematricula);
                if($totalRows_selprematricula != "" && $totalRows_selprematricula > 0)
                {
                    while($row_selprematricula=mysql_fetch_array($selprematricula))
                    {
                        $idprematricula = $row_selprematricula['idprematricula'];
                        $materiaselegidas[] = $row_selprematricula['codigomateria'];
                    }
                    $usarcondetalleprematricula = true;
                    require('calculocreditossemestre.php');
                    $query_updprematriculaanterior = "UPDATE prematricula
                    SET semestreprematricula='$semestrecalculado'
                    WHERE idprematricula = '$idprematricula'";
                    $updprematriculaanterior = mysql_query($query_updprematriculaanterior,$sala) or die("query_updprematriculaanterior");

                    unset($materiaselegidas);
                }
                actualizarValorPrematricula($codigoestudiante,$codigoperiodo,$codigocarrera);
            }
            // Entra cuando se va adicionar la materia del plan de estudios, la materia queda en materias adicionadas
            if(ereg("adicionadaplan",$llave))
            {
                $query_inscarga="INSERT INTO cargaacademica(idcargaacademica, codigoestudiante, codigomateria, codigoperiodo, idplanestudio, usuario, fechacargaacademica, codigoestadocargaacademica,ip)
                VALUES(0, '$codigoestudiante', '$valor', '$codigoperiodo', '$idplanestudio', '$usuario', '".date("Y-m-d H:i:s")."', '100','$ip')";
                $inscarga=mysql_db_query($database_sala,$query_inscarga) or die("$query_delcarga");
            }
            // Adiciona de materias retiradas, estas materias fueron retiradas de la carga generada por el estudiante
            // Vuelve a colocar la materia en la carga inicial
            if(ereg("retiradacarga",$llave))
            {
                $query_delcarga="DELETE FROM cargaacademica
                WHERE codigoestudiante = '$codigoestudiante'
                and codigoperiodo = '$codigoperiodo'
                and codigomateria = '$valor'";
                //and usuario = '$usuario'
                //idplanestudio = '$idplanestudio' and
                //echo "<br> $query_detalle";
                $delcarga=mysql_db_query($database_sala,$query_delcarga) or die("$query_delcarga");
            }
            // Adiciona de materias retiradas
            if(ereg("retiradaplan",$llave))
            {
                $query_delcarga="UPDATE cargaacademica
                SET codigoestadocargaacademica='100'
                WHERE codigoestudiante = '$codigoestudiante'
                and codigoperiodo = '$codigoperiodo'
                and codigomateria = '$valor'";
                //and usuario = '$usuario'
                //echo "<br> $query_detalle";
                //idplanestudio = '$idplanestudio' and
                $delcarga=mysql_db_query($database_sala,$query_delcarga) or die("$query_delcarga");
            }
            // Quita la materia de las que fueron adicionadas del plan de estudio
            if(ereg("eliminadaplan",$llave))
            {
                $query_delcarga="UPDATE cargaacademica
                SET codigoestadocargaacademica = '200', usuario = '$usuario'
                WHERE codigoestudiante = '$codigoestudiante'
                and codigoperiodo = '$codigoperiodo'
                and codigomateria = '$valor'";
                //idplanestudio = '$idplanestudio' and
                //echo "<br> $query_delcarga";
                $delcarga=mysql_db_query($database_sala,$query_delcarga) or die("$query_delcarga");

                $query_seldetalleprematricula="select dp.idgrupo
                from detalleprematricula dp, estudiante e, prematricula p
                where dp.idprematricula = p.idprematricula
                and p.codigoestudiante = e.codigoestudiante
                and e.codigoestudiante = '$codigoestudiante'
                and p.codigoperiodo = '$codigoperiodo'
                and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%')
                and (dp.codigoestadodetalleprematricula like '3%' or dp.codigoestadodetalleprematricula like '1%')
                and (dp.codigomateria = '$valor' or dp.codigomateriaelectiva = '$valor')";
                $seldetalleprematricula=mysql_db_query($database_sala,$query_seldetalleprematricula) or die("$query_seldetalleprematricula");
                $totalRows_seldetalleprematricula = mysql_num_rows($seldetalleprematricula);
                $row_seldetalleprematricula = mysql_fetch_array($seldetalleprematricula);

                $query_deldetallenota="delete from detallenota
                where idgrupo = '".$row_seldetalleprematricula['idgrupo']."'
                and codigoestudiante = '$codigoestudiante'
                and codigomateria = '$valor'";
                $deldetallenota=mysql_db_query($database_sala,$query_deldetallenota) or die("$query_deldetallenota");

                // log
                $query_logdetalleprematricula = "select dp.idprematricula, dp.codigomateria, dp.codigomateriaelectiva,
                dp.codigotipodetalleprematricula, dp.idgrupo, dp.numeroordenpago
                from detalleprematricula dp, estudiante e, prematricula p
                where dp.idprematricula = p.idprematricula
                and p.codigoestudiante = e.codigoestudiante
                and e.codigoestudiante = '$codigoestudiante'
                and p.codigoperiodo = '$codigoperiodo'
                and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%')
                and (dp.codigoestadodetalleprematricula like '3%' or dp.codigoestadodetalleprematricula like '1%')
                and (dp.codigomateria = '$valor' or dp.codigomateriaelectiva = '$valor')";
                $logdetalleprematricula = mysql_query($query_logdetalleprematricula,$sala) or die("$query_logdetalleprematricula");
                $totalRows_logdetalleprematricula = mysql_num_rows($logdetalleprematricula);
                if($totalRows_logdetalleprematricula != "")
                {
                    while($row_logdetalleprematricula = mysql_fetch_array($logdetalleprematricula))
                    {
                        $query_inslogdetalleprematricula = "INSERT INTO logdetalleprematricula(idprematricula, codigomateria, codigomateriaelectiva, codigoestadodetalleprematricula, codigotipodetalleprematricula, idgrupo, numeroordenpago, fechalogfechadetalleprematricula, usuario)
                        VALUES('".$row_logdetalleprematricula['idprematricula']."','".$row_logdetalleprematricula['codigomateria']."','".$row_logdetalleprematricula['codigomateriaelectiva']."','22','".$row_logdetalleprematricula['codigotipodetalleprematricula']."','".$row_logdetalleprematricula['idgrupo']."','".$row_logdetalleprematricula['numeroordenpago']."','".date("Y-m-d H:i:s")."','".$_SESSION['MM_Username']."')";
                        $inslogdetalleprematricula = mysql_query($query_inslogdetalleprematricula, $sala) or die("$query_inslogdetalleprematricula");
                    }
                }
                // finlog

                $query_upddetalleprematricula="update detalleprematricula dp, estudiante e, prematricula p
                set dp.codigoestadodetalleprematricula = '22'
                where dp.idprematricula = p.idprematricula
                and p.codigoestudiante = e.codigoestudiante
                and e.codigoestudiante = '$codigoestudiante'
                and p.codigoperiodo = '$codigoperiodo'
                and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%')
                and (dp.codigoestadodetalleprematricula like '3%' or dp.codigoestadodetalleprematricula like '1%')
                and (dp.codigomateria = '$valor' or dp.codigomateriaelectiva = '$valor')";
                //echo "<br> $query_detalle";
                $upddetalleprematricula=mysql_db_query($database_sala,$query_upddetalleprematricula) or die(mysql_error()."$query_upddetalleprematricula");

                // Recalcula el semestre y los creditos del estudiante
                // Esto lo hace si el estudiante tiene prematricula activa
                $query_selprematricula="select p.idprematricula, dp.codigomateria, dp.idgrupo
                from detalleprematricula dp, prematricula p
                where dp.idprematricula = p.idprematricula
                and p.codigoestudiante = '$codigoestudiante'
                and p.codigoperiodo = '$codigoperiodo'
                and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%')
                and (dp.codigoestadodetalleprematricula like '3%' or dp.codigoestadodetalleprematricula like '1%')";
                $selprematricula=mysql_db_query($database_sala,$query_selprematricula) or die("$query_selprematricula");
                $totalRows_selprematricula = mysql_num_rows($selprematricula);
                if($totalRows_selprematricula != "")
                {
                    while($row_selprematricula=mysql_fetch_array($selprematricula))
                    {
                        $idprematricula = $row_selprematricula['idprematricula'];
                        $materiaselegidas[] = $row_selprematricula['codigomateria'];
                    }
                    $usarcondetalleprematricula = true;
                    require('calculocreditossemestre.php');
                    $query_updprematriculaanterior = "UPDATE prematricula
                    SET semestreprematricula='$semestrecalculado'
                    WHERE idprematricula = '$idprematricula'";
                    $updprematriculaanterior = mysql_query($query_updprematriculaanterior,$sala) or die("$query_updprematriculaanterior".mysql_error());
                    unset($materiaselegidas);
                }
            }
		// Permite el cambio de grupo a la materia seleccionada
		if(ereg("cambiogrupo",$llave))
		{
        ?>
        <script language="javascript">
            alert("Se le ha permitido el cambio de grupo a la materia");
        </script>
        <?php
            // log
			$query_logdetalleprematricula = "select dp.idprematricula, dp.codigomateria, dp.codigomateriaelectiva,
			dp.codigotipodetalleprematricula, dp.idgrupo, dp.numeroordenpago
			from detalleprematricula dp, estudiante e, prematricula p
			where dp.idprematricula = p.idprematricula
			and p.codigoestudiante = e.codigoestudiante
			and e.codigoestudiante = '$codigoestudiante'
			and p.codigoperiodo = '$codigoperiodo'
			and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%')
			and (dp.codigoestadodetalleprematricula like '3%' or dp.codigoestadodetalleprematricula like '1%')
			and (dp.codigomateria = '$valor' or dp.codigomateriaelectiva = '$valor')";
			$logdetalleprematricula = mysql_query($query_logdetalleprematricula,$sala) or die("$query_logdetalleprematricula");
			$totalRows_logdetalleprematricula = mysql_num_rows($logdetalleprematricula);
			if($totalRows_logdetalleprematricula != "")
			{
				while($row_logdetalleprematricula = mysql_fetch_array($logdetalleprematricula))
				{
					$query_inslogdetalleprematricula = "INSERT INTO logdetalleprematricula(idprematricula, codigomateria, codigomateriaelectiva, codigoestadodetalleprematricula, codigotipodetalleprematricula, idgrupo, numeroordenpago, fechalogfechadetalleprematricula, usuario)
					VALUES('".$row_logdetalleprematricula['idprematricula']."','".$row_logdetalleprematricula['codigomateria']."','".$row_logdetalleprematricula['codigomateriaelectiva']."','23','".$row_logdetalleprematricula['codigotipodetalleprematricula']."','".$row_logdetalleprematricula['idgrupo']."','".$row_logdetalleprematricula['numeroordenpago']."','".date("Y-m-d H:i:s")."','".$_SESSION['MM_Username']."')";
					$inslogdetalleprematricula = mysql_query($query_inslogdetalleprematricula, $sala) or die("$query_inslogdetalleprematricula");
				}
			}
			// finlog

			$query_upddetalleprematricula="update detalleprematricula dp, estudiante e, prematricula p
			set dp.codigoestadodetalleprematricula = '23'
			where dp.idprematricula = p.idprematricula
			and p.codigoestudiante = e.codigoestudiante
			and e.codigoestudiante = '$codigoestudiante'
			and p.codigoperiodo = '$codigoperiodo'
			and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%')
			and (dp.codigoestadodetalleprematricula like '3%' or dp.codigoestadodetalleprematricula like '1%')
			and (dp.codigomateria = '$valor' or dp.codigomateriaelectiva = '$valor')";
			$upddetalleprematricula=mysql_db_query($database_sala,$query_upddetalleprematricula) or die(mysql_error()."$query_upddetalleprematricula");
		}
		if(ereg("eliminarelecoblig",$llave))
		{
			// log
			$query_logdetalleprematricula = "select dp.idprematricula, dp.codigomateria, dp.codigomateriaelectiva,
			dp.codigotipodetalleprematricula, dp.idgrupo, dp.numeroordenpago
			from detalleprematricula dp, estudiante e, prematricula p
			where dp.idprematricula = p.idprematricula
			and p.codigoestudiante = e.codigoestudiante
			and e.codigoestudiante = '$codigoestudiante'
			and p.codigoperiodo = '$codigoperiodo'
			and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%')
			and (dp.codigoestadodetalleprematricula like '3%' or dp.codigoestadodetalleprematricula like '1%')
			and (dp.codigomateria = '$valor' or dp.codigomateriaelectiva = '$valor')";
			$logdetalleprematricula = mysql_query($query_logdetalleprematricula,$sala) or die("$query_logdetalleprematricula");
			$totalRows_logdetalleprematricula = mysql_num_rows($logdetalleprematricula);
			if($totalRows_logdetalleprematricula != "")
			{
				while($row_logdetalleprematricula = mysql_fetch_array($logdetalleprematricula))
				{
					$query_inslogdetalleprematricula = "INSERT INTO logdetalleprematricula(idprematricula, codigomateria, codigomateriaelectiva, codigoestadodetalleprematricula, codigotipodetalleprematricula, idgrupo, numeroordenpago, fechalogfechadetalleprematricula, usuario)
					VALUES('".$row_logdetalleprematricula['idprematricula']."','".$row_logdetalleprematricula['codigomateria']."','".$row_logdetalleprematricula['codigomateriaelectiva']."','22','".$row_logdetalleprematricula['codigotipodetalleprematricula']."','".$row_logdetalleprematricula['idgrupo']."','".$row_logdetalleprematricula['numeroordenpago']."','".date("Y-m-d H:i:s")."','".$_SESSION['MM_Username']."')";
					$inslogdetalleprematricula = mysql_query($query_inslogdetalleprematricula, $sala) or die("$query_inslogdetalleprematricula");
				}
			}
			// finlog
			// Primero cambia el estado en detalleprematricula, lo pone en 22 (retirada por alumno)
			$query_upddetalleprematricula="update detalleprematricula dp, estudiante e, prematricula p
			set dp.codigoestadodetalleprematricula = '22'
			where dp.idprematricula = p.idprematricula
			and p.codigoestudiante = e.codigoestudiante
			and e.codigoestudiante = '$codigoestudiante'
			and p.codigoperiodo = '$codigoperiodo'
			and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%')
			and (dp.codigoestadodetalleprematricula like '3%' or dp.codigoestadodetalleprematricula like '1%')
			and (dp.codigomateria = '$valor' or dp.codigomateriaelectiva = '$valor')";
			//echo "<br> $query_detalle";
			$upddetalleprematricula=mysql_db_query($database_sala,$query_upddetalleprematricula) or die(mysql_error()."$query_upddetalleprematricula");

			// Recalcula el semestre y los creditos del estudiante
			// Esto lo hace si el estudiante tiene prematricula activa
			$query_selprematricula="select p.idprematricula, dp.codigomateria, dp.idgrupo
			from detalleprematricula dp, prematricula p
			where dp.idprematricula = p.idprematricula
			and p.codigoestudiante = '$codigoestudiante'
			and p.codigoperiodo = '$codigoperiodo'
			and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%')
			and (dp.codigoestadodetalleprematricula like '3%' or dp.codigoestadodetalleprematricula like '1%')";
			$selprematricula=mysql_db_query($database_sala,$query_selprematricula) or die("$query_selprematricula");
			$totalRows_selprematricula = mysql_num_rows($selprematricula);
			if($totalRows_selprematricula != "")
			{
				while($row_selprematricula=mysql_fetch_array($selprematricula))
				{
					$idprematricula = $row_selprematricula['idprematricula'];
					$materiaselegidas[] = $row_selprematricula['codigomateria'];
				}
				$usarcondetalleprematricula = true;
				require('calculocreditossemestre.php');
				$query_updprematriculaanterior = "UPDATE prematricula
				SET semestreprematricula='$semestrecalculado'
				WHERE idprematricula = '$idprematricula'";
				$updprematriculaanterior = mysql_query($query_updprematriculaanterior,$sala) or die("query_updprematriculaanterior");
				unset($materiaselegidas);
			}
		}
	}
}
?>
<body>
    <?php
    if(!isset($codigoestudiante))
    {
        ?>
        <style type="text/css">
        <!--
        .Estilo1 {font-weight: bold}
        -->
        </style>
        <script language="javascript">
	       alert("Por seguridad su sesion ha sido cerrada, por favor reinicie.");
        </script>
        <?php
    }
    // Datos del estudiante
    $query_estudiante = "SELECT
        concat(
            eg.nombresestudiantegeneral,
            ' ',
            eg.apellidosestudiantegeneral
        ) AS nombre,
        e.codigoestudiante,
        c.nombrecarrera,
        c.codigocarrera,
        t.nombretipoestudiante,
        pre.semestreprematricula AS semestre,
        s.nombresituacioncarreraestudiante,
        eg.numerodocumento
    FROM
        estudiante e,
        carrera c,
        tipoestudiante t,
        situacioncarreraestudiante s,
        prematricula pre,
        estudiantegeneral eg
    WHERE
        e.codigoestudiante = '$codigoestudiante'
    AND e.codigocarrera = c.codigocarrera
    AND e.codigotipoestudiante = t.codigotipoestudiante
    AND e.codigoperiodo = pre.codigoperiodo
    AND e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante
    AND pre.codigoestudiante = e.codigoestudiante
    AND pre.codigoperiodo = '$codigoperiodo'
    AND (
        pre.codigoestadoprematricula LIKE '1%'
        OR pre.codigoestadoprematricula LIKE '4%'
    )
    AND eg.idestudiantegeneral = e.idestudiantegeneral";
    
    //$estudiante = mysql_query($query_estudiante, $sala) or die("$query_estudiante".mysql_error());
    //$totalRows_estudiante = mysql_num_rows($estudiante);
    
    $estudiante = $db->GetRow($query_estudiante);
    $totalRows_estudiante = count($estudiante);
if($totalRows_estudiante == "")
{
	$query_estudiante = "select concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) as nombre,
	e.codigoestudiante, c.nombrecarrera, c.codigocarrera, t.nombretipoestudiante,
	e.semestre, s.nombresituacioncarreraestudiante, eg.numerodocumento
	from estudiante e, carrera c, tipoestudiante t, situacioncarreraestudiante s, estudiantegeneral eg
	where e.codigoestudiante = '$codigoestudiante'
	and e.codigocarrera = c.codigocarrera
	and e.codigotipoestudiante = t.codigotipoestudiante
	and e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante
	and e.codigoperiodo <= '$codigoperiodo'
	and eg.idestudiantegeneral = e.idestudiantegeneral";
	$estudiante = mysql_query($query_estudiante, $sala) or die("$query_estudiante".mysql_error());
}
$row_estudiante = $estudiante;

// Datos de la primera prematricula hecha
$query_premainicial1 = "SELECT d.codigomateria
FROM detalleprematricula d, prematricula p, materia m, estudiante e
where d.codigomateria = m.codigomateria
and d.idprematricula = p.idprematricula
and p.codigoestudiante = e.codigoestudiante
and e.codigoestudiante = '$codigoestudiante'
and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%')
and (d.codigoestadodetalleprematricula like '3%' or d.codigoestadodetalleprematricula like '1%' or d.codigoestadodetalleprematricula = '23')
and p.codigoperiodo = '$codigoperiodo'";
//echo "$query_premainicial1<br>";
$premainicial1=mysql_query($query_premainicial1, $sala) or die("$query_premainicial1");
$totalRows_premainicial1 = mysql_num_rows($premainicial1);
$tieneprema = false;
while($row_premainicial1 = mysql_fetch_array($premainicial1))
{
	$prematricula_inicial[] = $row_premainicial1['codigomateria'];
	$tieneprema = true;
}
if($row_estudiante != "")
{
?>
<form name="form1" method="post" action="../modificacionprematricula/modificacionprematricula.php?semestrerep=<?php echo $row_estudiante['semestre'];?>&estudiante=<?php echo $codigoestudiante; if($usonuevofacultad) echo "&usonuevofacultad"?>">
<p align="center"><span class="Estilo6">MODIFICACI&Oacute;N DE LA PREMATR&Iacute;CULA</span></p>
<p align="center">    <span class="Estilo9"><font color="#800040">&iexcl;&iexcl;&iexcl;CUIDADO!!! Al modificar la carga académica NO se valida prerrequisitos, correquisitos e histórico de notas.</font></span>
</p>
<table width="650" height="5" border="1" align="center" cellpadding="1" bordercolor="#003333">
    <tr>
      <td bgcolor="#C5D5D6" class="Estilo1 Estilo3"><span class="Estilo12">Estudiante</span></td>
      <td colspan="6"><div align="center"></div>
          <div align="center" class="Estilo7"><?php echo $row_estudiante['nombre'];?></div>
          <div align="center"></div>
          <div align="center"></div></td>
      <td bgcolor="#C5D5D6" class="Estilo1 Estilo3"><div align="center" class="Estilo12">Documento</div></td>
      <td><div align="center" class="Estilo10 Estilo7"><?php echo $row_estudiante['numerodocumento'];?></div></td>
    </tr>
    <tr>
      <td bgcolor="#C5D5D6" class="Estilo1 Estilo3"><div align="center"></div>
          <div align="center" class="Estilo12">Carrera</div></td>
      <td colspan="4"><div align="center" class="Estilo7"><?php echo $row_estudiante['nombrecarrera'];?></div>        <div align="center"></div>        <div align="center"></div></td>
      <td colspan="2" bgcolor="#C5D5D6" class="Estilo1 Estilo3"><div align="center" class="Estilo12">Tipo de Estudiante </div></td>
      <td colspan="2"><div align="center"></div>
          <div align="center" class="Estilo7"><?php echo $row_estudiante['nombretipoestudiante'];?></div></td>
    </tr>
    <tr>
      <td bgcolor="#C5D5D6" class="Estilo1 Estilo3"><div align="center" class="Estilo12">Periodo </div></td>
      <td><div align="center"><font size="2" face="Tahoma"><?php echo $codigoperiodo;?></div></td>
      <td bgcolor="#C5D5D6"><div align="center" class="Estilo9">Semestre</div></td>
      <td><div align="center" class="Estilo7"><?php echo $row_estudiante['semestre'];?></div></td>
      <td colspan="2" bgcolor="#C5D5D6" class="Estilo1 Estilo3"><div align="center" class="Estilo12">Situaci&oacute;n Acad&eacute;mica</div></td>
      <td><div align="center" class="Estilo7"><?php echo $row_estudiante['nombresituacioncarreraestudiante'];?></div></td>
      <td bgcolor="#C5D5D6" class="Estilo1 Estilo3"><div align="center" class="Estilo12">Fecha</div></td>
      <td class="Estilo7"><div align="center"><?php echo date("Y-m-d",time());?></div></td>
    </tr>
  </table>
<?php

	/****************** VALIDACION FECHA PARA PREMATRICULA FACULTAD ***********************************/
	$fecha= "select * from fechaacademica f
	where f.codigocarrera = '".$_SESSION['codigofacultad']."'
	and f.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'";
	$db=mysql_query($fecha, $sala) or die("$fecha");
	$total = mysql_num_rows($db);
	$resultado=mysql_fetch_array($db);
	//echo $fecha;
	//exit();
	$fechavalidaprematricula = true;
	$fechavalidaprematricularetiro = true;
	$mostrarcambiogrupo = "";

	if ($resultado <> "")
	 {
		if ((date("Y-m-d",(time())) < $resultado['fechainicialprematriculacarrera']) or (date("Y-m-d",(time())) > $resultado['fechafinalprematriculacarrera']))
		{
		 $fechavalidaprematricula = false;
		}

		if ((date("Y-m-d",(time())) < $resultado['fechainicialretiroasignaturafechaacademica']) or (date("Y-m-d",(time())) > $resultado['fechafinallretiroasignaturafechaacademica']))
		{
		 $fechavalidaprematricularetiro = false;
		}
	  }

	 if ($fechavalidaprematricula)
	  {
		echo "<br><br><hr>";
		require_once("modificacionprematriculacarga.php");
		echo "<br><br><hr>";
		require_once("modificacionprematriculaadicionada.php");
		echo "<br><br><hr>";
		require_once("modificacionprematricularetirada.php");
		echo "<br><br><hr>";
		require_once("modificacionprematriculaadicionarmaterias.php");
		//$quitarmateriascarga = ereg_replace(" ","_",$quitarmateriascarga);
		//$quitarmateriascarga = ereg_replace("'","",$quitarmateriascarga);
	    //echo $quitarmateriascarga." ".strlen($quitarmateriascarga);
	  }
	 else
	  {
		echo "<br><br><hr>";
		if ($fechavalidaprematricularetiro)
		 {
		  $mostrarcambiogrupo = "disabled";
		  require_once("modificacionprematriculacarga.php");
		 }
		else
		 {
		   echo '<script language="JavaScript">
		   alert("Según el reglamento se podrá inscribir asignaturas adicionales hasta la segunda semana de clases y no podrá cancelarse una asignatura respecto de la cual se haya cursado el cincuenta por ciento (50 %) o más");
		   history.go(-2);
		   </script>';
		  exit();
		 }
	  }
	if(!isset($_SESSION['materiascargasesion']))
	{
		$GLOBALS['materiascargasesion'];
		session_register('materiascargasesion');
	}
	$_SESSION['materiascargasesion'] = $quitarmateriascarga;
?>
	<p class="Estilo1 Estilo3" align="center"><span class="Estilo1 Estilo4">


	  <input type="button" name="materiaexterna" value="Adicionar Materia Externa" onClick="<?php echo "window.open('buscarmateria.php','miventana','width=600,height=500,left=150,top=100,scrollbars=yes')"; ?>">     </span>  </p>


	 <p align="center">
    <input name="Aceptar" type="submit" value="Aceptar">
<?php
	if($_GET['programausadopor'] == "facultad")
	{
?>
    <!-- <input type="button" value="Regresar" onClick="recargar3()"> -->
<?php
	}
	else
	{
?>
    <!-- <input type="button" value="Regresar" onClick="recargar()"> -->
<?php
	}
?>
<input type="button" value="Regresar" onClick="window.location.href='../matriculaautomatica.php?programausadopor=facultad'">
</p>
	 <p align="center">
	<!--  <input name="Adicionarexterna" type="button" value="Adicionar una Materia Externa" onClick="recargar2()">&nbsp; -->
	 </p>
</form>
</body>
<?php
	echo '<script language="javascript">
	function recargar()
	{
		window.location.href="../matriculaautomatica.php?programausadopor=facultad";
		//window.location.href="modificacionprematriculabusqueda.php?busqueda_codigo='.$codigoestudiante.'&buscar=Buscar";
	}
	</script>';

	echo '<script language="javascript">
	function recargar2()
	{
		window.location.href="../matriculaautomatica.php?programausadopor=facultad";
		//window.location.href="modificacionprematriculamateriaexterna.php?estudiante='.$codigoestudiante.'";
	}
	</script>';
}
else
{
	echo "<p>Este estudiante no pertenece al periodo activo</p>";
}
echo '<script language="javascript">
	function recargar3()
	{
		window.location.href="../matriculaautomatica.php?programausadopor=facultad";
	}
	</script>';
?>
</html>
