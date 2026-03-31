<?php 
ini_set("memory_limit","11000M");
ini_set("max_execution_time","360");

if(file_exists('conf_guias.php'))
		include('conf_guias.php');
	else
 		die('<strong>No existe archivo de configuracion.</strong> [<em>'.$GLOBALS['_IV_ruta_sitio'].'guias/config.php'.'</em>]');
/********************************************************************************************************/
    $vrte = new X0005(
array(
"Modulo_Id" => 11,
"Categoria_Id" => 139,
"html_name" => "rfac",
"html_class" => "lista",
"html_id" => "rfac",
"tipo" => "select"
));

    $pago1 = new X0005(
    array(
        "Modulo_Id" => 9,
        "Categoria_Id" => 33,
        "html_name" => "rfac",
        "html_class" => "lista",
        "html_id" => "rfac",
        "tipo" => "select"
    ));


        $guia3 = $varX0001->generarConsulta(
        $GLOBALS['_IV_modulo']['xml'],      // Archivo de configuracion en xml del modulo en uso.
        '338',
        array($_GET['varId'])
        );
        $y= $guia3->fetchRow(MDB2_FETCHMODE_ASSOC);

        $guia5 = $varX0001->generarConsulta(
        $GLOBALS['_IV_modulo']['xml'],      // Archivo de configuracion en xml del modulo en uso.
        '339',
        array($y[idpedido])
        );
        $x= $guia5->fetchRow(MDB2_FETCHMODE_ASSOC);

       $_GET['id'] = $x['codigoguia'];

    if($_POST['id'] != "")
    {
        $idGuia=$_POST['id'];
    }
    else
    {
        $idGuia=$_GET['id'];
    }       


    if($_GET['clief'] != "")
    {
        $idClief =$_GET['clief'];
    }

    /* Traemos los datos de cabecera de la guia */
    $guia2 = $varX0001->generarConsulta(
        $GLOBALS['_IV_modulo']['xml'],      // Archivo de configuracion en xml del modulo en uso.
        '47',
        array($x[codigoguia])
    );
    
    if (PEAR::isError($guia2)){
        die($guia2->getMessage()); 
    }
    
    /*if($guia2->numRows() == 0)
    {
        if(!isset($_GET["retorno"]))
        {
                header("Location: ".$GLOBALS['_IV_sitio']."index.php?errorguia=1");
        }
        else
        {
                header("Location: ".$GLOBALS['_IV_sitio'].$_GET["retorno"]."?errorguia=1");
        }
        exit();
    }*/
    
    if($sql3=$guia2->fetchRow(MDB2_FETCHMODE_ASSOC))
    {
        $idtguia=$sql3['id'];
        $pedido=$sql3['id_pedido'];
        $numguia=$sql3['numguia'];
        $prefijo=$sql3['prefijo'];
        $ref1=$sql3['ref1'];
        $fprog=$sql3['fprog'];
        $fechaini=$sql3['fechahoraenvio'];
        $fechaini = date("Y-m-d h:i a", strtotime($fechaini));
        //              $idorigen=$sql3['idorigen'];
        //              $iddestino=$sql3['iddestino'];
        $remitenom=$sql3['remitenom'];
        $remitedir=$sql3['remitedir'];
        $remitetel=$sql3['remitetel'];
        $remitecc=$sql3['remitecc'];
        $destinonom=$sql3['destinonom'];
        $destinodir=$sql3['destinodir'];
        $destinotel=$sql3['destinotel'];
        $destinoempresa=$sql3['destinoempresa'];
        $destinodep=$sql3['destinodep'];
        $destinocc=$sql3['destinocc'];
        $ciudadorig=$sql3['ciudadorig'];
        $ciudaddest=$sql3['ciudaddest'];
        $formapago=$sql3['formapago'];
        $mensajero=$sql3['mensajero'];
        
        
        $tiponov=$sql3['novedad_tipo'];
        $personalrel=$sql3['novedad_personarel'];
     /*$contenido=$sql3['contenido'];
         $valordeclarado=$sql3['valordeclarado'];
         $fletes=$sql3['fletes'];
         $otros=$sql3['otros'];
         $total=$sql3['total'];*/
        $idzona=$sql3['idzona'];
        $idldn=$sql3['idldn'];
        $remiteid=$sql3['remiteid'];
        $estado=$sql3['estado'];
        $lastldn=$sql3['idldn'];
        $idcompania=$sql3['compania'];
        $observaciones2=$sql3['observaciones2'];
        $dependencia_cliente=$sql3['dependencia_cliente'];
        $iddependencia=$sql3['iddependencia'];
        $tservicios=$sql3['idtipo'];
        $tservicioshijo=$sql3['idtipohijo'];
        $descripcion_adicional=$sql3['descripcion_adicional'];
        $valor_adicional=$sql3['valor_adicional'];
        $hora_adicional=$sql3['hora_adicional'];
        $total=$sql3['total_tipo'];
        $idcto=$sql3['destinoid'];
        $ct01=$sql3['ct01'];
        $nomcliente=$sql3['nomcliente'];
        $fechacreacion=date("d-m-Y h:i a", strtotime($sql3['fechaoriginal']));
        $suma_servicios= $sql3['item1precio']+$sql3['item2precio'];
        $lastuser = $sql3['au_usuario'];
        $sucursal=$sql3['sucursal'];
        $traslado=$sql3['traslado'];
        $traslado_idsucursal=$sql3['traslado_idsucursal'];
        $traslado_observaciones=$sql3['traslado_observaciones'];
        $tipopago=$sql3['tipopago'];
        $denominacion=$sql3['denominacion'];
        $datafono=$sql3['datafono'];
        $idprogramacion=$sql3['idprogramacion'];
        $adicionalcosto=$sql3['adicionalcosto'];
        $adicionalprecio=$sql3['adicionalprecio'];
        $formauxiliar=$sql3['auxiliar'];
        $auxiliarcosto=$sql3['auxiliarcosto'];
        $auxiliarprecio=$sql3['auxiliarprecio'];
        $idprogramacion=$sql3['idprogramacion'];
        // PRECIOS Y COSTOS FIJOS ADICIONALES.
        $adicional2costo=$sql3['adicional2costo'];
        $adicional2precio=$sql3['adicional2precio'];
        $adicional3costo=$sql3['adicional3costo'];
        $adicional3precio=$sql3['adicional3precio'];
        //Valores basicos
        $item1Costo=$sql3['item1costo'];
        $item1Precio=$sql3['item1precio'];
        $item2Costo=$sql3['item2costo'];
        $item2Precio=$sql3['item2precio'];
        $cambio_efectivo=$sql3['cambio_efectivo'];
        $pago_mensajero = $sql3['item1costo']+$sql3['item2costo'];
        $precioinicial = $sql3['item1precio']+$sql3['item2precio'];
        $preciohadicional = $sql3['hora_adicional']*$sql3['adicionalprecio'];
        $precioauxiliares = $sql3['auxiliar']*$sql3['auxiliarprecio'];
        $lastdate = date("d-m-Y h:i a", strtotime($sql3['au_fecha']));
        $col_flagnotraslados=$sql3['col_flagnotraslados'];
        $col_notraslados=$sql3['col_notraslados'];
    }

    
    $varres = array($remiteid);
             /**
             *  consulta detalle de dependencia seleccionada. 
             **/
            $seldep = $varX0001->generarConsulta(
                $GLOBALS['_IV_modulo']['xml'],      // Archivo de configuracion en xml del modulo en uso.
                '305',                              // identificador de la consulta en archivo xml.
                $varres                             // Numero de enlaces para mostrar
            );
            if (PEAR::isError($seldep)) {
                die($seldep->getMessage());
            }


    //Consulta de compaï¿½ias
    $compania = $varX0001->generarConsulta(
        $GLOBALS['_IV_modulo']['xml'],      // Archivo de configuracion en xml del modulo en uso.
        '80'
    );

    if (PEAR::isError($compania)){
        die($compania->getMessage());
    }

    $tservicio = $varX0001->generarConsulta(
        $GLOBALS['_IV_modulo']['xml'],      // Archivo de configuracion en xml del modulo en uso.
        '128',
        array($idldn)
    );
    
    if (PEAR::isError($tservicio)){
        die($tservicio->getMessage());
    }


    /* Traemos las ubicacions*/
    $servicios= $varX0001->generarConsulta(
        $GLOBALS['_IV_modulo']['xml'],      // Archivo de configuracion en xml del modulo en uso.
        '124',
        array($tservicios)
    );
    
    
    if (PEAR::isError($servicios)){
        die($servicios->getMessage());
    }


            
            

    /*
    *   Verificamos tipos de servicio que sean hijos y esten activos
    */
    if($tservicioshijo != "")
    {
        //Cargamos los tipos de servicio hijos asociados al tipo de servicio global.
        $tservicioh = $varX0001->generarConsulta(
            $GLOBALS['_IV_modulo']['xml'],      // Archivo de configuracion en xml del modulo en uso.
            '325',
            array($tservicioshijo)
        );
    
        if (PEAR::isError($tservicioh)){
            die($tservicioh->getMessage());
        }

    }
    if (PEAR::isError($sucursal))
    {
        die($sucursal->getMessage());
    }
        /* $sucursal = $varX0001->generarConsulta(
            $GLOBALS['_IV_modulo']['xml'],      // Archivo de configuracion en xml del modulo en uso.
            '203',
            array($sucursal)
            );
            
    /* Traemos las zonas*/


    $zona = $varX0001->generarConsulta(
        $GLOBALS['_IV_modulo']['xml'],      // Archivo de configuracion en xml del modulo en uso.
        '82',
        array($idcompania)
    );
    if (PEAR::isError($zona)){
        die($zona->getMessage());
    }


    /* Traemos las lineas de negocio*/
    $ldn = $varX0001->generarConsulta(
        $GLOBALS['_IV_modulo']['xml'],      // Archivo de configuracion en xml del modulo en uso.
        '81',
        array($idcompania)
    );
    
    if (PEAR::isError($ldn)){
        die($ldn->getMessage()); 
    }


    /* Traemos las NOVEDADES */
    $resnov = $varX0001->generarConsulta(
        $GLOBALS['_IV_modulo']['xml'],      // Archivo de configuracion en xml del modulo en uso.
        '46',
        array($idtguia)
    );
    
    if (PEAR::isError($resnov)){
        die($resnov->getMessage());
    }

    /* Traemos los ESTADOS */
    $resest = $varX0001->generarConsulta(
        $GLOBALS['_IV_modulo']['xml'],      // Archivo de configuracion en xml del modulo en uso.
        '48',
        array($lastldn)
    );
    
    if (PEAR::isError($resest)){
        die($resest->getMessage());
    }


    /* Traemos el USUARIO que la modifico */
    $resuser = $varX0001->generarConsulta(
        $GLOBALS['_IV_modulo']['xml'],      // Archivo de configuracion en xml del modulo en uso.
        '43',
        array($lastuser)
    );
    
    if (PEAR::isError($resuser)){
        die($resuser->getMessage());
    }
    

    if($resuser->numRows() > 0)
    {
        $rowUsuario = $resuser->fetchRow(MDB2_FETCHMODE_ASSOC);
        $lastusername = $rowUsuario["nombres"]." ".$rowUsuario["apellidos"];    
        
    }
    //esta consulta debe ejecutarse cuando la guia se avanza por movil. 
    else
    {
        /* Traemos el USUARIO (mensajero) que la modifico */
        /*$resusermens = $varX0001->generarConsulta(
        $GLOBALS['_IV_modulo']['xml'],      // Archivo de configuracion en xml del modulo en uso.
        '43a',
        array($lastuser)
        );
    
        if (PEAR::isError($resusermens)){
        die($resusermens->getMessage());
        }   
            if($resusermens->numRows() > 0)
            {
                $rowUsuario = $resusermens->fetchRow(MDB2_FETCHMODE_ASSOC);
                $lastusername = $rowUsuario["nombres"]." ".$rowUsuario["apellidos"];    
                
            }*/
    
    }
    
    /**
     * Agregado Por Carlos Carlos Pinto
     * Fecha: 29-09-2010
     * Obtener Listado Historico de Estados de la Guia
     */
    $reshistEdo = $varX0001->generarConsulta(
        $GLOBALS['_IV_modulo']['xml'],      // Archivo de configuracion en xml del modulo en uso.
        '225',
        array($idtguia,$idldn)
    );

    if (PEAR::isError($reshistEdo)){
        die($reshistEdo->getMessage());
    }
    
    for($i=0; $i<$reshistEdo->numRows();$i++)
    {
        $dbarray = $reshistEdo->fetchRow(MDB2_FETCHMODE_ASSOC);
        $arrayHistEdo[]=$dbarray;
    }
    
    
    
        if($numguia!="")
        {
            
            
                /* SE REALIZA LA CONSULTA DEL PROGRAMACION DE GUIAS AVANZADAS */
                    
                    
                    $respro = $varX0001->generarConsulta(
                        $GLOBALS['_IV_modulo']['xml'],                                  // identificador de la consulta en archivo xml.
                        '319',
                        array($numguia)
                    );
                    if (PEAR::isError($respro)){
                        die($respro->getMessage());
                    }
        $rowpror=$respro->fetchRow(MDB2_FETCHMODE_ASSOC);
        $fechainip = date("Y-m-d h:i a", strtotime($rowpror['fechacreacion']));
        $fechafinp = date("Y-m-d", strtotime($rowpror['fechafinal']));
         
        
        $rowprordia = explode(",",$rowpror['dia']);
        $con = count($rowprordia);
        for($x = 0;$x < $con;$x++)
        { 
        if($rowprordia[$x] == 'Monday'){$filapro['lunes']= $rowprordia[$x]; }
        if($rowprordia[$x] == 'Tuesday'){$filapro['martes']= $rowprordia[$x]; }
        if($rowprordia[$x] == 'Wednesday'){$filapro['miercoles']= $rowprordia[$x]; }
        if($rowprordia[$x] == 'Thursday'){$filapro['jueves']= $rowprordia[$x]; }
        if($rowprordia[$x] == 'Friday'){$filapro['viernes']= $rowprordia[$x]; }
        if($rowprordia[$x] == 'Saturday'){$filapro['sabado']= $rowprordia[$x]; }
        if($rowprordia[$x] == 'Sunday'){$filapro['domingo']= $rowprordia[$x]; }
        }

        }
    
    
    
    /**
     * Obtener diferencia en fechas en minutos
     */
    function getDiffFH($param1,$param2)
    {
        global $varX0001;
        
        $resDiffFH = $varX0001->generarConsulta(
            $GLOBALS['_IV_modulo']['xml'],      // Archivo de configuracion en xml del modulo en uso.
            '226',
            array($param1,$param2)
        );

        
        if (PEAR::isError($resDiffFH)){
            die($resDiffFH->getMessage());
        }
        
        $varHF = $resDiffFH->fetchRow(MDB2_FETCHMODE_ASSOC);
        
        return $varHF['diffseg'];
    }
    
     /**
     * Obtener diferencia en fechas en minutos
     */
    function getDiffFHNOW($fini)
    {
        global $varX0001;
        
        $resDiffFH = $varX0001->generarConsulta(
            $GLOBALS['_IV_modulo']['xml'],      // Archivo de configuracion en xml del modulo en uso.
            '254',
            array($fini)
        );
        
        if (PEAR::isError($resDiffFH)){
            die($resDiffFH->getMessage());
        }
        
        $varHF = $resDiffFH->fetchRow(MDB2_FETCHMODE_ASSOC);
        
        return $varHF['diffseg'];
    }   
    
    
    //Consulta de las novedades
    $novedades = $varX0001->generarConsulta(
    $GLOBALS['_IV_modulo']['xml'],      // Archivo de configuracion en xml del modulo en uso.
    '316'
    );

    if (PEAR::isError($compania)){
            die($novedades->getMessage());
    }
    
    for($i=0; $i<$novedades->numRows();$i++)
    {
        $dbarraynov = $novedades->fetchRow(MDB2_FETCHMODE_ASSOC);
        $arrayNOv[]=$dbarraynov;
    }
    
    if($ct01 == "1")
    {
        /*
        *   Traemos el USUARIO que la modifico.
        */
    }
    


if(!empty($_GET['id']))
{
	$datos_m = $varX0001->generarConsulta(
		$GLOBALS['_IV_modulo']['xml'],		// Archivo de configuracion en xml del modulo en uso.
			'9',
		array($idGuia)			                    // Numero de enlaces para mostrar
	);

 $d= $datos_m->fetchRow(MDB2_FETCHMODE_ASSOC);


    $ciudades = $varX0001->generarConsulta(
    $GLOBALS['_IV_modulo']['xml'],      // Archivo de configuracion en xml del modulo en uso.
    '328',
    array($d['ciudadorig'])
    );
    $f= $ciudades->fetchRow(MDB2_FETCHMODE_ASSOC);


    $pie = $varX0001->generarConsulta(
    $GLOBALS['_IV_modulo']['xml'],      // Archivo de configuracion en xml del modulo en uso.
    '331',
    array('')
    );
    $g= $pie->fetchRow(MDB2_FETCHMODE_ASSOC);

    $clien = $varX0001->generarConsulta(
    $GLOBALS['_IV_modulo']['xml'],      // Archivo de configuracion en xml del modulo en uso.
    '332',
    array($destinocc)
    );
    $h= $clien->fetchRow(MDB2_FETCHMODE_ASSOC);



     $ciudaddesti = $varX0001->generarConsulta(
    $GLOBALS['_IV_modulo']['xml'],      // Archivo de configuracion en xml del modulo en uso.
    '333',
    array($d['ciudaddest'])
    );
    $i= $ciudaddesti->fetchRow(MDB2_FETCHMODE_ASSOC);



    $pedido1 = $varX0001->generarConsulta(
    $GLOBALS['_IV_modulo']['xml'],      // Archivo de configuracion en xml del modulo en uso.
    '334',
    array($idtguia)
    );
    $j= $pedido1->fetchRow(MDB2_FETCHMODE_ASSOC);
    
    $vendedor = $varX0001->generarConsulta(
    $GLOBALS['_IV_modulo']['xml'],      // Archivo de configuracion en xml del modulo en uso.
    '335',
    array($destinocc)
    );
    $l= $vendedor->fetchRow(MDB2_FETCHMODE_ASSOC);

    $desc = $varX0001->generarConsulta(
    $GLOBALS['_IV_modulo']['xml'],      // Archivo de configuracion en xml del modulo en uso.
    '336',
    array($h[id])
    );
    $m= $desc->fetchRow(MDB2_FETCHMODE_ASSOC);
    $monto=0;


    if ($m[idcto]!=0) {
        # code...
    
    $monto = $varX0001->generarConsulta(
    $GLOBALS['_IV_modulo']['xml'],      // Archivo de configuracion en xml del modulo en uso.
    '337',
    array($m[idcto])
    );
    $n=$monto->fetchRow(MDB2_FETCHMODE_ASSOC);
        $monto=$n[monto];
    }



    $forpago1=$h[tcli];
    $dir=$g[direccion];
    $telcompa=$g[telefono];
    $nomcompa=$g[nombre];
    $emailcompa=$g[email];
    $nit3=$h[identificacion];
    $nomvendedor=$l[destinonom];
    $nit1=$g[nit];
    $nproceso1=$j[nproceso];
    $desnomb=$j[destinonom];
    $nombre1=$h[nombre];
    $nit2=$h[remitecc];
    $direccion1=$h[direccion];
    $ciudad1=$i[nombre];
    $telefono1=$h[telefono];
    $fecha1=$j[fechapedido];
    $fpago=$j[formaPago];
    $prefac=$g[prefijo_factura];
    $numfac=$g[numero_factura];
    $piefac=$g[pie];
    $dianfac=$g[dian];
    $rangofac=$g[rango];
    $regimenfac=$g[regimen];
    $fechafac=$g[fecha_resolucion];
    $forpago=$pago1->retornarDescripcion($h[tcli]);
    $fechavencimiento=$y[condiciones_pago];
    $fechaAg=$fecha1;
    $fecha2=date('Y-m-d',strtotime($fecha1));
   $fechaAg = date("Y-m-d",strtotime("+$fechavencimiento day",strtotime($fechaAg)));
    //$imagen=<img src="./images/laimagen.jpg"/>;

// print_r($d);
 // exit();
 $datos_m = $varX0001->generarConsulta( $GLOBALS['_IV_modulo']['xml'], '10', array("and idcontacto='$d[destinoid2]'", " group by iddoc ") );
// while($dt = $datos_m->fetchRow(MDB2_FETCHMODE_ASSOC)) {
//	$docs .="<div style='float:left'>$dt[ndoc] <div style='border-style: solid!important; border-width: thin!important; width:11px; height:11px; float:right;'>&nbsp;</div></div><br />"; } 
//}

$html = "<html>
         <head><title>Pdf</title><style type='txt/css'>
         * { margin-right:8px; margin-left:4px; margin-bottom:0px; margin-top:10px;  padding:0;  font-family:arial;}
         table tr td { padding-top: 3px; padding-bottom: 0px; font-size: 8px; border-style: solid; border-color: #9F9F9F; font-family:arial; }
         table { border-spacing: 0px!important; border-collapse: collapse; }
	 .b { font-weight: bold; }
	 .blue { font-weight: bold; color:blue; }
         </style>
         </head>
         <body>
         ";
}	


               $datos_m = $varX0001->generarConsulta( $GLOBALS['_IV_modulo']['xml'], '183', array(" and t50001ptmp.pedido = '$pedido' and t50001ptmp.idkit = '0'",'') );
                                        $num1 =  $datos_m->numRows();    

       
     $datos_m = $varX0001->generarConsulta( $GLOBALS['_IV_modulo']['xml'], '182', array("and t50001ktmp.pedido = '$pedido'",'') );
                                        $num =  $datos_m->numRows();
if($num >0){
                       

$html .= "<table width='100%' style='border 0px; margin-bottom:0px; margin-top:0px; font-size: 11px; border-style: none;'>
            <tr>
                <td style='border 0px; margin-bottom:0px; margin-top:0px; width:180px; border-style: none;'align='center' ><img src='logoIntegraVirtual.jpg' style='width:140px; height: 50px; border-style: none; '/></td>
                <td style='border 0px; margin-bottom:0px; margin-top:0px; border-style: none;'align='left'></td>
                <td style='border-style: none;'></td>
                <td style='border-style: none;'></td>
                <td style='border-style: none;'>Pag: 1 - 2</td>
            </tr>
        </table>
        <div style='border-style: solid!important; border-width: thin!important; margin-bottom:0px; margin-top:15px; width:420px; height:3px; background-color:blue;'></div> 
        </br>
     ";
//    width='100%' style='border-style: solid!important; border-width: thin!important; margin-bottom:0px; margin-top:0px;';                    
                                               
     if($num>0){                                  

            $num1 = 1;
            $num2= 1;
            $wCount=1;
        $varC = new X0005( array( "Modulo_Id" => 25, "Categoria_Id" => 131 ) );

                $html .=" <div id='dkits' style='margin-bottom:0px;  position:relative; margin-top:60px;'>";
                
                 // \$pdf->page_text(20, 130, \"Cliente: $nombre1\", \$font, 10, array(0,0,0)); 
                while ($d2= $datos_m->fetchRow(MDB2_FETCHMODE_ASSOC))
                {
                   $cont2++; // abs()

                    $datos_m2 = $varX0001->generarConsulta( $GLOBALS['_IV_modulo']['xml'], '193', array(" and t50001ptmp.pedido = '$pedido'"," and t50001ptmp.idkit = '$d2[id]'") );
            $d3=$datos_m2->fetchRow(MDB2_FETCHMODE_ASSOC);
                
             //if($wCount%2!=0) {$color = 'odd';}else{$color='';}   
            $datos_m2 = $varX0001->generarConsulta( $GLOBALS['_IV_modulo']['xml'], '326a', array($d2["id"],$pedido));
            if ($cont2<2) {
            
            if ($datos_m2->numRows() > 0) {
                $html .="<table width='100%' style='border-style: none;  position:relative; margin-top:0px; font-size:8px;'>
                <tr>
                <td  style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px; '><font color='#164FD4'>COD. PROD</font></td>
                <td  style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px; '><font color='#164FD4'>DESCRIPCION<font></td>
                <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px; '><font color='#164FD4'>U.M</font></td>
                <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px; '><font color='#164FD4'>CANT</font></td>
                <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px; '><font color='#164FD4'>PRE UNI</font></td>
                <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px; '><font color='#164FD4'>DEST</font></td>
                <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px; '><font color='#164FD4'>PRE TOTAL</font></td>
                <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px; '><font color='#164FD4'>IVA</font</td>
                </tr>
                ";
            }}
               
            while ($d4= $datos_m2->fetchRow(MDB2_FETCHMODE_ASSOC))
                {
                    $cont1++;

                 $number = $d4[precio];  
                  $suma = $d4[cant] * $number;
					if($cont1%30==0){
                $html .="
                </table>
            <div style='margin-top:60px;'>
                <a style='font-size:7px;'>$regimenfac </a></br>
                <a style='font-size:7px;'>$piefac </a></br>
                <a style='font-size:7px;'> DESPUES DE VENCIDA ESTA FACTURA COBRAMOS INTERES DE MORA DEL 2.68% MENSUAL</a></br>
                <a style='font-size:7px;'> IVA REGIMEN COMUN Tarifa ICA 6,9 * Mil Res.DIAN No. $dianfac $fechafac Desde $rangofac</a></br>
                <a style='font-size:8px; margin-left:240px;'> BIOART S.A </a></br>
                <a style='font-size:6px; margin-left:220px;'> impreso por: software InterWap </a>
                
                </div>


                <div style='page-break-after:always'>&nbsp;</div>

                <table width='100%' style='border 0px; margin-bottom:0px; margin-top:0px; font-size: 11px; border-style: none;' >
            <tr>
                <td style='border 0px; margin-bottom:0px; margin-top:0px; width:180px; border-style: none;'align='center' ><img src='logoIntegraVirtual.jpg' style='width:140px; height: 50px; border-style: none;'/></td>
                <td style='border 0px; margin-bottom:0px; margin-top:0px; border-style: none;'align='left'></td>
                <td style='border-style: none;'></td>
                <td style='border-style: none;'></td>
                <td style='border-style: none;'>Pag: 2 - 2</td>

            </tr>
        </table>
        <span style=' position:relative; margin-left:450px;'></span>
        <span style=' position:relative; margin-left:460px;'></span>
        <div style='border-style: solid!important; border-width: thin!important; margin-bottom:0px; margin-top:15px; width:420px; height:3px; background-color:blue;'></div> 
        </br>
<table width='100%' style='position:relative; margin-top:60px; font-size:8px; border-style: none;'>
                    <tr>
                <td  style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:px; '><font color='#164FD4'>COD. PROD</font></td>
                <td  style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px;'><font color='#164FD4'>DESCRIPCION<font></td>
                <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px; '><font color='#164FD4'>U.M</font></td>
                <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px; '><font color='#164FD4'>CANT</font></td>
                <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px; '><font color='#164FD4'>PRE UNI</font></td>
                <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px; '><font color='#164FD4'>DEST</font></td>
                <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px; '><font color='#164FD4'>PRE TOTAL</font></td>
                <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px; '><font color='#164FD4'>IVA</font</td>
                </tr>

                ";
                       
               $html  .= "
               <tr>
                <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px; '>$d4[id] </td>
                <td style='border-style: solid!important; border-width: thin!important; font-size:7px; '>$d4[descripcion1] </td>
                <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px; '> $d4[um] </td>
                <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px; '> $d4[cant] </td>
                <td style='border-style: solid!important; border-width: thin!important; text-align:right; font-size:7px; '>$". number_format($number,0)."</td>
                <td style='border-style: solid!important; border-width: thin!important; text-align:right; font-size:7px; '>$ $monto </td>
                <td style='border-style: solid!important; border-width: thin!important; text-align:right; font-size:7px; '>$".number_format($suma,0)."</td>";
                if ($d4[iva]!='') {
                $d4[iva] = 0;
                $html  .= "<td style='border-style: solid!important; border-width: thin!important; text-align:right; font-size:7px; '>$ $d4[iva] </td>";
                }else{
              $html  .= "<td style='border-style: solid!important; border-width: thin!important; text-align:right; font-size:7px; '>$ $d4[iva] </td>";  
                }
            $html  .= "</tr>

            "; 
             
                 
                 $wCount++;
                $num2 = $num2+1;
                $suma1=$suma1+$suma;
                $iva1 = $iva1 + $d4[iva];
                $sumatotal = $suma1 - $iva1;
                $num1++;

            

           $iva2 = $iva1 + $iva2; 
         $num5 = $num5+$num1;
         $sumatotal1 = $sumatotal1 + $sumatotal;
         $sumatotal4 = $sumatotal1 - $iva2;


         
       if ($cont1>30) {
             $cont1=0;
           }
        while($cont1<30) {
            $html  .="
			<tr>
             <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:6px; height:8px;'></td>
             <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:6px; height:8px;'></td>
             <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:6px; height:8px;'></td>
             <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:6px; height:8px;'></td>
             <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:6px; height:8px;'></td>
             <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:6px; height:8px;'></td>
             <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:6px; height:8px;'></td>
             <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:6px; height:8px;'></td>
             </tr>";
             $cont1++;
			 }
        }
			}
           }


           $sumatotal3 = $sumatotal + $sumatotal3;
        $num3= 1;
  

            
            }

        $num4 = 1;
		
         $datos_m = $varX0001->generarConsulta( $GLOBALS['_IV_modulo']['xml'], '183', array(" and t50001ptmp.pedido = '$pedido' and t50001ptmp.idkit = '0'",'') );
                
                                        $num =  $datos_m->numRows();
        
       if ($datos_m->numRows() < 1) {
                $html .="
                <tr>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px;'> Subtotal </td>
            <td style='border-style: solid!important; border-width: thin!important; text-align:right; font-size:7px;'>".number_format($suma1,0)."</td>
        </tr>
        <tr>
             <td style='border-style: none;'></td>
             <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none; collapse:4'></td>
        <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px;'> IVA </td>
        <td style='border-style: solid!important; border-width: thin!important; text-align:right; font-size:7px;'>".number_format($iva1,0)."</td>
        </tr>
        <tr>
             <td style='border-style: none;'></td>
             <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
        <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px;'> Total </td>
        <td style='border-style: solid!important; border-width: thin!important; text-align:right; font-size:7px;'>".number_format($sumatotal,0)."</td>
        </tr>
    </table>
<div style='border-style: solid!important; border-width: thin!important; width:350px; height:45px; position:relative; margin-left:10px; margin-bottom:0px; margin-top:0px;'>  
            <a> ______________________________________________________</a></br><a> ______________________________________________________</a></br><a> ______________________________________________________</a>
    </div>
    <div style='border-style: solid!important; border-width: thin!important; width:100px; height:20px; position:relative; margin-left:450px; margin-bottom:0px; margin-top:0px;'></div>
    <p style='margin-left:465px;'>(Firma y Sello)</p>
 </div>
  <div style='margin-top:0px;'>
                <a style='font-size:7px;'>$regimenfac </a></br>
                <a style='font-size:7px;'>$piefac </a></br>
                <a style='font-size:7px;'> DESPUES DE VENCIDA ESTA FACTURA COBRAMOS INTERES DE MORA DEL 2.68% MENSUAL</a></br>
                <a style='font-size:7px;'> IVA REGIMEN COMUN Tarifa ICA 6,9 * Mil Res.DIAN No. $dianfac $fechafac Desde $rangofac</a></br>
                <a style='font-size:8px; margin-left:240px;'> BIOART S.A </a></br>
                <a style='font-size:6px; margin-left:220px;'> impreso por: software InterWap </a>
                </div>
";

            }

    if ($cont2!=0) {  

		
	     $datos_m = $varX0001->generarConsulta( $GLOBALS['_IV_modulo']['xml'], '183', array(" and t50001ptmp.pedido = '$pedido' and t50001ptmp.idkit = '0'",'') );
                
         $num =  $datos_m->numRows();	
		if($num!=0){         


			while ($d2= $datos_m->fetchRow(MDB2_FETCHMODE_ASSOC))
			{
				 $cont1++; 
			$p2 = ($d2['cant'] * $d2['precio']);
						$ct = round($d2['cant'],0);
						$pt = ($d2['precio']);
						$number = $d2[precio];
						$suma = $d2[cant] * $number;

				if($cont1%30==0){


					$html .="
					
					<div style='page-break-after:always'>&nbsp;</div>

					   <table width='100%' style='border 0px; margin-bottom:0px; margin-top:0px; font-size: 11px; border-style: none;' >
				<tr>
					<td style='border 0px; margin-bottom:0px; margin-top:0px; width:180px; border-style: none;'align='center' ><img src='logoIntegraVirtual.jpg' style='width:140px; height: 50px; border-style: none;'/></td>
					<td style='border 0px; margin-bottom:0px; margin-top:0px; border-style: none;'align='left'><td>
					<td style='border-style: none;'></td>
					<td style='border-style: none;'></td>
					<td style='border-style: none;'>Pag: 1 - 2</td>
					 </td>

				</tr>
			</table>
			<span style=' position:relative; margin-left:450px;'></span>
			<span style=' position:relative; margin-left:460px;'></span>
			<div style='border-style: solid!important; border-width: thin!important; margin-bottom:0px; margin-top:15px; width:420px; height:3px; background-color:blue;'></div> 
					<table width='100%' style='position:relative; margin-top:60px;'>
						<tr>
							<td  style='border-style: solid!important; border-width: thin!important; font-weight:bold; text-align:center; font-size:7px;'><font color='#164FD4'>Cod .prod</font></td>
							<td style='border-style: solid!important; border-width: thin!important; font-weight:bold; text-align:center; font-size:7px;'><font color='#164FD4'> Descripcion</font></td>
							<td style='border-style: solid!important; border-width: thin!important; font-weight:bold; text-align:center; font-size:7px;'><font color='#164FD4'>U.M.</font></td>
							<td style='border-style: solid!important; border-width: thin!important; font-weight:bold; text-align:center; font-size:7px;'><font color='#164FD4'>CANT</font></td>
							<td style='border-style: solid!important; border-width: thin!important; font-weight:bold; text-align:center; font-size:7px;'><font color='#164FD4'>PRE UNI</font></td>
							<td style='border-style: solid!important; border-width: thin!important; font-weight:bold; text-align:center; font-size:7px;'><font color='#164FD4'>DES</font></td>
						   <td style='border-style: solid!important; border-width: thin!important; font-weight:bold; text-align:center; font-size:7px;'><font color='#164FD4'>PRE TOTAL</font></td>
						   <td style='border-style: solid!important; border-width: thin!important; font-weight:bold; text-align:center; font-size:7px;'><font color='#164FD4'>IVA</font></td> 
						 </tr>";
				 }
				if ($d2[idprod] != '') {

				   

				$html  .= " <tr>
				<td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px;'>$d2[idprod]</td>
				<td style='border-style: solid!important; border-width: thin!important; font-size:7px;'>$d2[descripcion1]</td>
				<td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px;'>$d2[um]</td>
				<td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px;'>$d2[cant]</td>
				<td style='border-style: solid!important; border-width: thin!important; text-align:right; font-size:7px;'>".number_format($number,0)."</td>
				<td style='border-style: solid!important; border-width: thin!important; text-align:right; font-size:7px;'>$monto</td>
				<td style='border-style: solid!important; border-width: thin!important; text-align:right; font-size:7px;'>".number_format($suma,0)."</td>
				";
					if ($d4[iva]!='') {
					$d4[iva] = 0;
					$html  .= "<td style='border-style: solid!important; border-width: thin!important; text-align:right; font-size:7px; '>$ $d4[iva] </td>";
					}else{
				  $html  .= "<td style='border-style: solid!important; border-width: thin!important; text-align:right; font-size:7px; '>$ $d4[iva] </td>";  
					}
				$html  .= "
			</tr>";
			}
			 $wCount++;
			 $suma1 = $suma1 + $suma;
			  
				$num4 = $num4+1;
				$num1 = $num1+1;
				$iva1 = $iva1 + $d4[iva];
           
        }

        if ($cont1>30) {
             $cont1=0;
           }

        while($cont1<30) {

            $html  .="<tr>
             <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:6px; height:8px;'></td>
             <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:6px; height:8px;'></td>
             <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:6px; height:8px;'></td>
             <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:6px; height:8px;'></td>
             <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:6px; height:8px;'></td>
             <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:6px; height:8px;'></td>
             <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:6px; height:8px;'></td>
             <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:6px; height:8px;'></td>
             </tr>";
             $cont1++;
        }




        $sumatotal = $suma1 - $iva1; 

        $html  .= " 

        <tr>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px;'> Subtotal </td>
            <td style='border-style: solid!important; border-width: thin!important; text-align:right; font-size:7px;'>".number_format($suma1,0)."</td>
        </tr>
        <tr>
             <td style='border-style: none;'></td>
             <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
        <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px;'> IVA </td>
        <td style='border-style: solid!important; border-width: thin!important; text-align:right; font-size:7px;'>".number_format($iva1,0)."</td>
        </tr>
        <tr>
             <td style='border-style: none;'></td>
             <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
        <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px;'> Total </td>
        <td style='border-style: solid!important; border-width: thin!important; text-align:right; font-size:7px;'>".number_format($sumatotal,0)."</td>
        </tr>
    </table>

 </div>
 <div style='border-style: solid!important; border-width: thin!important; width:350px; height:45px; position:relative; margin-left:10px; margin-bottom:0px; margin-top:0px;'>  
            <a> ______________________________________________________</a></br><a> ______________________________________________________</a></br><a> ______________________________________________________</a>
    </div>
    <div style='border-style: solid!important; border-width: thin!important; width:100px; height:20px; position:relative; margin-left:450px; margin-bottom:0px; margin-top:0px;'></div>
    <p style='margin-left:465px;'>(Firma y Sello)</p>
 </div>
  <div style='margin-top:0px;'>
                <a style='font-size:7px;'>$regimenfac </a></br>
                <a style='font-size:7px;'>$piefac </a></br>
                <a style='font-size:7px;'> DESPUES DE VENCIDA ESTA FACTURA COBRAMOS INTERES DE MORA DEL 2.68% MENSUAL</a></br>
                <a style='font-size:7px;'> IVA REGIMEN COMUN Tarifa ICA 6,9 * Mil Res.DIAN No. $dianfac $fechafac Desde $rangofac</a></br>
                <a style='font-size:8px; margin-left:240px;'> BIOART S.A </a></br>
                <a style='font-size:6px; margin-left:220px;'> impreso por: software InterWap </a>
                
                </div>

    ";

        }
		
			} else{ 


         if($num>0){         
        $html  .= "<div id='dprods'>
               <table width='100%' style='border 0px; margin-bottom:0px; margin-top:0px; font-size: 11px; border-style: none;' >
                             <tr>
                <td style='border 0px; margin-bottom:0px; margin-top:0px; width:180px; border-style: none;'align='center' ><img src='logoIntegraVirtual.jpg' style='width:140px; height: 50px; border-style: none; '/></td>
                <td style='border 0px; margin-bottom:0px; margin-top:0px; border-style: none;'align='left'></td>
                <td style='border-style: none;'></td>
                <td style='border-style: none;'></td>
                <td style='border-style: none;'>Pag: 1 - 2</td>
            </tr>
        </table>
        <div style='border-style: solid!important; border-width: thin!important; margin-bottom:0px; margin-top:15px; width:420px; height:3px; background-color:blue;'></div> 
                <table width='100%' style='position:relative; margin-top:60px;'>
                    <tr>
                        <td  style='border-style: solid!important; border-width: thin!important; font-weight:bold; text-align:center; font-size:7px;'><font color='#164FD4'>Cod .prod</font></td>
                        <td style='border-style: solid!important; border-width: thin!important; font-weight:bold; text-align:center; font-size:7px;'><font color='#164FD4'> Descripcion</font></td>
                        <td style='border-style: solid!important; border-width: thin!important; font-weight:bold; text-align:center; font-size:7px;'><font color='#164FD4'>U.M.</font></td>
                        <td style='border-style: solid!important; border-width: thin!important; font-weight:bold; text-align:center; font-size:7px;'><font color='#164FD4'>CANT</font></td>
                        <td style='border-style: solid!important; border-width: thin!important; font-weight:bold; text-align:center; font-size:7px;'><font color='#164FD4'>PRE UNI</font></td>
                        <td style='border-style: solid!important; border-width: thin!important; font-weight:bold; text-align:center; font-size:7px;'><font color='#164FD4'>DES</font></td>
                       <td style='border-style: solid!important; border-width: thin!important; font-weight:bold; text-align:center; font-size:7px;'><font color='#164FD4'>PRE TOTAL</font></td>
                       <td style='border-style: solid!important; border-width: thin!important; font-weight:bold; text-align:center; font-size:7px;'><font color='#164FD4'>IVA</font></td> 
                     </tr>";

            $wCount=1;
        $varUM = new X0005( 
        array(
            "Modulo_Id" => 4, // AGENDA (id del modulo al que pertenece)
            "Categoria_Id"  => 42 // Tipo de Reunion (id de la categoria)
        )
    );

        $varTP = new X0005( 
        array(
            "Modulo_Id" => 4, // AGENDA (id del modulo al que pertenece)
            "Categoria_Id"  => 43 // Tipo de Reunion (id de la categoria)
        )
    );
        while ($d2= $datos_m->fetchRow(MDB2_FETCHMODE_ASSOC))
        {
        $p2 = ($d2['cant'] * $d2['precio']);
                    $ct = round($d2['cant'],0);
                    $pt = ($d2['precio']);
                    $number = $d2[precio];
                    $suma = $d2[cant] * $number;

            if($num4%32==0){
                $html .="
                </table>
                <div style='page-break-after:always'>&nbsp;</div>

    <table width='100%' style='position:relative; margin-top:60px;'>

";
             }
            if ($d2[idprod] != '') {
                # code...
            

            $html  .= " <tr>
            <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-weight: normal;  font-size:7px;'>$d2[idprod]</td>
            <td style='border-style: solid!important; border-width: thin!important; font-weight: 100; font-size:7px;'>$d2[descripcion1]</td>
            <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px;'>$d2[um]</td>
            <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px;'>$d2[cant]</td>
            <td style='border-style: solid!important; border-width: thin!important; text-align:right; font-size:7px;'>".number_format($number,0)."</td>
            <td style='border-style: solid!important; border-width: thin!important; text-align:right; font-size:7px;'>$monto</td>
            <td style='border-style: solid!important; border-width: thin!important; text-align:right; font-size:7px;'>".number_format($suma,0)."</td>
            ";
                if ($d4[iva]!='') {
                $d4[iva] = 0;
                $html  .= "<td style='border-style: solid!important; border-width: thin!important; text-align:right; font-size:7px; '>$ $d4[iva] </td>";
                }else{
              $html  .= "<td style='border-style: solid!important; border-width: thin!important; text-align:right; font-size:7px; '>$ $d4[iva] </td>";  
                }
            $html  .= "
        </tr>";
        }
         $wCount++;
         $suma1 = $suma1 + $suma;
            $num4 = $num4+1;
            $num1 = $num1+1;
            $iva1 = $iva1 + $d4[iva];

        }


        if ($num4>32) {
             $num4=0;
           }
        while($num4<32) {
            $html  .="<tr>
             <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:6px; height:8px;'></td>
             <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:6px; height:8px;'></td>
             <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:6px; height:8px;'></td>
             <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:6px; height:8px;'></td>
             <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:6px; height:8px;'></td>
             <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:6px; height:8px;'></td>
             <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:6px; height:8px;'></td>
             <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:6px; height:8px;'></td>
             </tr>";
             $num4++;
        }


        $sumatotal = $suma1 - $iva1; 

        $html  .= " 

        <tr>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px;'> Subtotal </td>
            <td style='border-style: solid!important; border-width: thin!important; text-align:right; font-size:7px;'>".number_format($suma1,0)."</td>
        </tr>
        <tr>
             <td style='border-style: none;'></td>
             <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
        <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px;'> IVA </td>
        <td style='border-style: solid!important; border-width: thin!important; text-align:right; font-size:7px;'>".number_format($iva1,0)."</td>
        </tr>
        <tr>
             <td style='border-style: none;'></td>
             <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
        <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px;'> Total </td>
        <td style='border-style: solid!important; border-width: thin!important; text-align:right; font-size:7px;'>".number_format($sumatotal,0)."</td>
        </tr>
    </table>

 </div>
<div style='border-style: solid!important; border-width: thin!important; width:350px; height:45px; position:relative; margin-left:10px; margin-bottom:0px; margin-top:0px;'>  
            <a> ______________________________________________________</a></br><a> ______________________________________________________</a></br><a> ______________________________________________________</a>
    </div>
    <div style='border-style: solid!important; border-width: thin!important; width:100px; height:20px; position:relative; margin-left:450px; margin-bottom:0px; margin-top:0px;'></div>
    <p style='margin-left:465px;'>(Firma y Sello)</p>
 </div>
  <div style='margin-top:0px;'>
                <a style='font-size:7px;'>$regimenfac </a></br>
                <a style='font-size:7px;'>$piefac </a></br>
                <a style='font-size:7px;'> DESPUES DE VENCIDA ESTA FACTURA COBRAMOS INTERES DE MORA DEL 2.68% MENSUAL</a></br>
                <a style='font-size:7px;'> IVA REGIMEN COMUN Tarifa ICA 6,9 * Mil Res.DIAN No. $dianfac $fechafac Desde $rangofac</a></br>
                <a style='font-size:8px; margin-left:240px;'> BIOART S.A </a></br>
                <a style='font-size:6px; margin-left:220px;'> impreso por: software InterWap </a>
                
                </div>

		";}

		}

    }else{
        $num4 = 1;
         $datos_m = $varX0001->generarConsulta( $GLOBALS['_IV_modulo']['xml'], '183', array(" and t50001ptmp.pedido = '$pedido' and t50001ptmp.idkit = '0'",'') );
                                        $num =  $datos_m->numRows();

         
        $html  .= "<div id='dprods'>
        <table width='100%' style='border 0px; margin-bottom:0px; margin-top:0px; font-size: 11px; border-style: none;' >
            <tr>
                <td style='border 0px; margin-bottom:0px; margin-top:0px; width:180px; border-style: none;'align='center' ><img src='logoIntegraVirtual.jpg' style='width:140px; height: 50px; border-style: none; '/></td>
                <td style='border 0px; margin-bottom:0px; margin-top:0px; border-style: none;'align='left'></td>
                <td style='border-style: none;'></td>
                <td style='border-style: none;'></td>
                <td style='border-style: none;'>Pag: 1 - 2</td>
            </tr>
        </table>
        <div style='border-style: solid!important; border-width: thin!important; margin-bottom:0px; margin-top:15px; width:420px; height:3px; background-color:blue;'></div> 
                <table width='100%' style='position:relative; margin-top:60px;'>
                    <tr>
                        <td  style='border-style: solid!important; border-width: thin!important; font-weight:bold; text-align:center; font-size:7px;'><font color='#164FD4'>Cod .prod</font></td>
                        <td style='border-style: solid!important; border-width: thin!important; font-weight:bold; text-align:center; font-size:7px;'><font color='#164FD4'> Descripcion</font></td>
                        <td style='border-style: solid!important; border-width: thin!important; font-weight:bold; text-align:center; font-size:7px;'><font color='#164FD4'>U.M.</font></td>
                        <td style='border-style: solid!important; border-width: thin!important; font-weight:bold; text-align:center; font-size:7px;'><font color='#164FD4'>CANT</font></td>
                        <td style='border-style: solid!important; border-width: thin!important; font-weight:bold; text-align:center; font-size:7px;'><font color='#164FD4'>PRE UNI</font></td>
                        <td style='border-style: solid!important; border-width: thin!important; font-weight:bold; text-align:center; font-size:7px;'><font color='#164FD4'>DES</font></td>
                       <td style='border-style: solid!important; border-width: thin!important; font-weight:bold; text-align:center; font-size:7px;'><font color='#164FD4'>PRE TOTAL</font></td>
                       <td style='border-style: solid!important; border-width: thin!important; font-weight:bold; text-align:center; font-size:7px;'><font color='#164FD4'>IVA</font></td> 
                     </tr>";

            $wCount=1;
        $varUM = new X0005( 
        array(
            "Modulo_Id" => 4, // AGENDA (id del modulo al que pertenece)
            "Categoria_Id"  => 42 // Tipo de Reunion (id de la categoria)
        )
    );

        $varTP = new X0005( 
        array(
            "Modulo_Id" => 4, // AGENDA (id del modulo al que pertenece)
            "Categoria_Id"  => 43 // Tipo de Reunion (id de la categoria)
        )
    );
        while ($d2= $datos_m->fetchRow(MDB2_FETCHMODE_ASSOC))
        {
        $p2 = ($d2['cant'] * $d2['precio']);
                    $ct = round($d2['cant'],0);
                    $pt = ($d2['precio']);
                    $number = $d2[precio];
                    $suma = $d2[cant] * $number;

            if($num4%32==0){
                $html .="
                </table>
                <div style='page-break-after:always'>&nbsp;</div>

                                
        </br>
    <table width='100%' style='position:relative; margin-top:60px;'>

";
             }
            if ($d2[idprod] != '') {
                # code...
            

            $html  .= " <tr>
            <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px;'>$d2[idprod]</td>
            <td style='border-style: solid!important; border-width: thin!important; font-size:7px;'>$d2[descripcion1]</td>
            <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px;'>$d2[um]</td>
            <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px;'>$d2[cant]</td>
            <td style='border-style: solid!important; border-width: thin!important; text-align:right; font-size:7px;'>".number_format($number,0)."</td>
            <td style='border-style: solid!important; border-width: thin!important; text-align:right; font-size:7px;'>$monto</td>
            <td style='border-style: solid!important; border-width: thin!important; text-align:right; font-size:7px;'>".number_format($suma,0)."</td>
            ";
                if ($d4[iva]!='') {
                $d4[iva] = 0;
                $html  .= "<td style='border-style: solid!important; border-width: thin!important; text-align:right; font-size:7px; '>$ $d4[iva] </td>";
                }else{
              $html  .= "<td style='border-style: solid!important; border-width: thin!important; text-align:right; font-size:7px; '>$ $d4[iva] </td>";  
                }
            $html  .= "
				</tr>";
			}
         $wCount++;
         $suma1 = $suma1 + $number;
            $num4 = $num4+1;
            $num1 = $num1+1;
            $iva1 = $iva1 + $d4[iva];

        }


        if ($num4>32) {
             $num4=0;
           }
        while($num4<32) {
            $html  .="<tr>
             <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:6px; height:8px;'></td>
             <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:6px; height:8px;'></td>
             <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:6px; height:8px;'></td>
             <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:6px; height:8px;'></td>
             <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:6px; height:8px;'></td>
             <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:6px; height:8px;'></td>
             <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:6px; height:8px;'></td>
             <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:6px; height:8px;'></td>
             </tr>";
             $num4++;
        }


        $sumatotal = $suma1 - $iva1; 

        $html  .= " 

        <tr>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px;'> Subtotal </td>
            <td style='border-style: solid!important; border-width: thin!important; text-align:right; font-size:7px;'>".number_format($suma1,0)."</td>
        </tr>
        <tr>
             <td style='border-style: none;'></td>
             <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
        <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px;'> IVA </td>
        <td style='border-style: solid!important; border-width: thin!important; text-align:right; font-size:7px;'>".number_format($iva1,0)."</td>
        </tr>
        <tr>
             <td style='border-style: none;'></td>
             <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
            <td style='border-style: none;'></td>
        <td style='border-style: solid!important; border-width: thin!important; text-align:center; font-size:7px;'> Total </td>
        <td style='border-style: solid!important; border-width: thin!important; text-align:right; font-size:7px;'>".number_format($sumatotal,0)."</td>
        </tr>
		
    </table>
			
 </div>

<div style='border-style: solid!important; border-width: thin!important; width:350px; height:45px; position:relative; margin-left:10px; margin-bottom:0px; margin-top:0px;'>  
            <a> ______________________________________________________</a></br><a> ______________________________________________________</a></br><a> ______________________________________________________</a>
    </div>
    <div style='border-style: solid!important; border-width: thin!important; width:100px; height:20px; position:relative; margin-left:450px; margin-bottom:0px; margin-top:0px;'></div>
    <p style='margin-left:465px;'>(Firma y Sello)</p>
 </div>
  <div style='margin-top:0px;'>
                <a style='font-size:7px;'>$regimenfac </a></br>
                <a style='font-size:7px;'>$piefac </a></br>
                <a style='font-size:7px;'> DESPUES DE VENCIDA ESTA FACTURA COBRAMOS INTERES DE MORA DEL 2.68% MENSUAL</a></br>
                <a style='font-size:7px;'> IVA REGIMEN COMUN Tarifa ICA 6,9 * Mil Res.DIAN No. $dianfac $fechafac Desde $rangofac</a></br>
                <a style='font-size:8px; margin-left:240px;'> BIOART S.A </a></br>
                <a style='font-size:6px; margin-left:220px;'> impreso por: software InterWap </a>
                
                </div>
				

    ";}
    


			$html  .= "<div> 
			<div>
        </table>

 </div>
    <script type=\"text/php\"> 
           if ( isset(\$pdf) ) { 
          \$pdf->page_text(200, 36, \"BIOART S.A.\", \$font, 15, array(0,0,20));    
          \$pdf->page_text(200, 50, \"NIT. $nit1\", \$font, 10, array(0,0,20));     
          \$pdf->page_text(200, 60, \"$dir\", \$font, 10, array(0,0,20)); 
          \$pdf->page_text(200, 70, \"$nomcompa PBX : $telcompa\", \$font, 10, array(0,0,20));    
          \$pdf->page_text(200, 80, \"$emailcompa\", \$font, 10, array(0,0,20)); 
          \$pdf->page_text(475, 40, \"Factura N :\", \$font, 10, array(0,0,10));
          \$pdf->page_text(525, 40, \"$prefac - $numfac\", \$font, 10, array(20,0,0));    
          \$pdf->page_text(470, 100, \"FACTURA DE VENTA\", \$font, 10, array(0,0,0));    
          \$pdf->page_text(490, 110, \"Ley 1231 de 2008\", \$font, 8, array(0,0,0));

          \$pdf->page_text(40, 125, \"Cliente:\", \$font, 10, array(0,0,0));
           \$pdf->page_text(100, 125, \"$nombre1\", \$font, 10, array(0,0,0));
          \$pdf->page_text(100, 124, \"__________________________________\", \$font, 10, array(0,0,0)); 
          \$pdf->page_text(40, 135, \"NIT:\", \$font, 10, array(0,0,0));
          \$pdf->page_text(100, 135, \"$nit3\", \$font, 10, array(0,0,0));
          \$pdf->page_text(100, 134, \"__________________________________\", \$font, 10, array(0,0,0));     
          \$pdf->page_text(40, 145, \"Direccion:\", \$font, 10, array(0,0,0));
          \$pdf->page_text(100, 145, \"$direccion1\", \$font, 10, array(0,0,0));
          \$pdf->page_text(100, 144, \"__________________________________\", \$font, 10, array(0,0,0)); 
          \$pdf->page_text(40, 155, \"Ciudad:\", \$font, 10, array(0,0,0));
          \$pdf->page_text(100, 155, \"$ciudad1\", \$font, 10, array(0,0,0));
          \$pdf->page_text(100, 154, \"__________________________________\", \$font, 10, array(0,0,0));     
          \$pdf->page_text(40, 165, \"Telefono:\", \$font, 10, array(0,0,0));
          \$pdf->page_text(100, 165, \"$telefono1\", \$font, 10, array(0,0,0));
          \$pdf->page_text(100, 164, \"__________________________________\", \$font, 10, array(0,0,0)); 

          \$pdf->page_text(320, 125, \"Fecha Factura:\", \$font, 10, array(0,0,0));
          \$pdf->page_text(410, 125, \"$fecha2\", \$font, 10, array(0,0,0));
          \$pdf->page_text(410, 124, \"________________________\", \$font, 10, array(0,0,0)); 
          \$pdf->page_text(320, 135, \"Fecha Vencimiento:\", \$font, 10, array(0,0,0));
          \$pdf->page_text(410, 135, \"$fechaAg\", \$font, 10, array(0,0,0));
          \$pdf->page_text(410, 134, \"________________________\", \$font, 10, array(0,0,0));    
          \$pdf->page_text(320, 145, \"Forma de Pago:\", \$font, 10, array(0,0,0));
          \$pdf->page_text(410, 145, \"$forpago\", \$font, 10, array(0,0,0));
          \$pdf->page_text(410, 144, \"________________________\", \$font, 10, array(0,0,0));
          \$pdf->page_text(320, 155, \"N. Pedido /OS:\", \$font, 10, array(0,0,0));
          \$pdf->page_text(410, 155, \"$idtguia / $numguia\", \$font, 10, array(0,0,0)); 
          \$pdf->page_text(410, 154, \"________________________\", \$font, 10, array(0,0,0));   
          \$pdf->page_text(320, 165, \"Comercial:\", \$font, 10, array(0,0,0));
          \$pdf->page_text(410, 165, \"$nomvendedor\", \$font, 10, array(0,0,0));
          \$pdf->page_text(410, 164, \"________________________\", \$font, 10, array(0,0,0));


        } 
        </script>"; 





    $html  .= "<div> 
    <div>
    </div> 




    ";  
         $html .= '</body></html>';
















	//echo $html;
    /*require_once("html2pdf_v4.03/html2pdf.class.php");
	//require_once(dirname(__FILE__).'/html2pdf_v4.03/html2pdf.class.php');
    $html2pdf = new HTML2PDF('P','A4','fr');
    $html2pdf->WriteHTML($hmtl);
    $html2pdf->Output('pdf.pdf');*/

    /*include("../js/dompdf06/dompdf_config.inc.php");
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->render();
    $dompdf->stream("sample.pdf");*/
    include("../js/dompdf06/dompdf_config.inc.php");	
	$dompdf = new DOMPDF();
	$dompdf->load_html($html);
	$dompdf->set_paper("letter","portrait"); // a4 , lanscape
	$dompdf->render();
	$dompdf->stream("factura.pdf");
	
?>