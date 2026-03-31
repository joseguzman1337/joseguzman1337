<?php
//require_once('../Connections/sala2.php');

mysql_select_db($database_sala, $sala);

$query_estadoconexionexterna = "select e.codigoestadoconexionexterna, e.nombreestadoconexionexterna, e.codigoestado,
e.hostestadoconexionexterna, e.numerosistemaestadoconexionexterna, e.mandanteestadoconexionexterna,
e.usuarioestadoconexionexterna, e.passwordestadoconexionexterna
from estadoconexionexterna e
where e.codigoestado like '1%'";
//and dop.codigoconcepto = '151'
//echo "sdas $query_ordenes<br>";
$estadoconexionexterna = mysql_query($query_estadoconexionexterna,$sala) or die("$query_estadoconexionexterna<br>".mysql_error());
$totalRows_estadoconexionexterna = mysql_num_rows($estadoconexionexterna);
$row_estadoconexionexterna = mysql_fetch_array($estadoconexionexterna);
//echo "<h1>".$row_estadoconexionexterna['mandanteestadoconexionexterna']." -- ".$row_estadoconexionexterna['hostestadoconexionexterna']."</h1>";
if(ereg("^1.+$",$row_estadoconexionexterna['codigoestadoconexionexterna']))
{
    $login = array (                              // Set login data to R/3
    "ASHOST"=>$row_estadoconexionexterna['hostestadoconexionexterna'],              // application server host name
    "SYSNR"=>$row_estadoconexionexterna['numerosistemaestadoconexionexterna'],      // system number
    "CLIENT"=>$row_estadoconexionexterna['mandanteestadoconexionexterna'],          // client
    "USER"=>$row_estadoconexionexterna['usuarioestadoconexionexterna'],             // user
    "PASSWD"=>$row_estadoconexionexterna['passwordestadoconexionexterna'],          // password
    "CODEPAGE"=>"1100");                                                            // codepage

    $rfc = saprfc_open($login);
    if(!$rfc)
    {
        // We have failed to connect to the SAP server
        echo "<br><br>Failed to connect to the SAP server".saprfc_error();
        //exit();
    }
}

if($rfc)
{
    //echo $row_estadoconexionexterna['mandanteestadoconexionexterna'];
    $rfcfunction = "ZBAPI_BUPA_CENTRAL_CHANGE2";
    $resultstable = "RETURN";
    $rfchandle = saprfc_function_discover($rfc, $rfcfunction);
    if(!$rfchandle )
    {
        // We have failed to discover the function
        echo "We have failed to discover the function" . saprfc_error($rfc);
        //exit();
    }
    else
    {
        //$interlocutor = 9344;
        $cuentaCeros = 10 - strlen($interlocutor);
        $ceros = "";
        for($i = 1; $i <= $cuentaCeros; $i++)
            $ceros = $ceros."0";
        $interlocutor = $ceros.$interlocutor;
        //echo $interlocutor."---".saprfc_error($rfc);
        //exit();
        saprfc_import($rfchandle,"BUSINESSPARTNER",$interlocutor);

        /*$centralData = array(
        'SEARCHTERM1' => '',
        'SEARCHTERM2' => '',
        'PARTNERTYPE' => '',
        'AUTHORIZATIONGROUP' => '',
        'PARTNERLANGUAGE' => '',
        'PARTNERLANGUAGEISO' => '',
        'DATAORIGINTYPE' => '',
        'CENTRALARCHIVINGFLAG' => '',
        'CENTRALBLOCK' => '',
        'TITLE_KEY' => '',
        'CONTACTALLOWANCE' => '',
        'PARTNEREXTERNAL' => '',
        'TITLELETTER' => '',
        'NOTRELEASED' => '',
        'COMM_TYPE' => ''
        );*/
        if(!saprfc_import($rfchandle,"CENTRALDATA",$centralData))
        {
            echo "Error al insertar la estructura CENTRALDATA";
            exit();
        }

        /*$centralDataX = array(
        'SEARCHTERM1' => '',
        'SEARCHTERM2' => '',
        'PARTNERTYPE' => '',
        'AUTHORIZATIONGROUP' => '',
        'PARTNERLANGUAGE' => '',
        'PARTNERLANGUAGEISO' => '',
        'DATAORIGINTYPE' => '',
        'CENTRALARCHIVINGFLAG' => '',
        'CENTRALBLOCK' => '',
        'TITLE_KEY' => '',
        'CONTACTALLOWANCE' => '',
        'PARTNEREXTERNAL' => '',
        'TITLELETTER' => '',
        'NOTRELEASED' => '',
        'COMM_TYPE' => ''
        );*/
        if(!saprfc_import($rfchandle,"CENTRALDATA_X",$centralDataX))
        {
            echo "Error al insertar la estructura CENTRALDATA";
            //exit();
        }

        //saprfc_import ($rfchandle,"CUENTA",$numerocuenta);
        if(!saprfc_table_init($rfchandle,"TELEFONDATANONADDRESS"))
        {
            echo "Error al iniciar la tabla TELEFONDATANONADDRESS ";
            exit();
        }

        /*$telefonoData = array(
        'COUNTRY' => '',
        'COUNTRYISO' => '',
        'STD_NO' => '',
        'TELEPHONE' => '1234567',
        'EXTENSION' => '',
        'TEL_NO' => '',
        'CALLER_NO' => '',
        'STD_RECIP' => '',
        'R_3_USER'=> '',
        'HOME_FLAG' => '',
        'CONSNUMBER' => '002',
        'ERRORFLAG' => '',
        'FLG_NOUSE' => ''
        );*/
        if(is_array($telefonoData))
        {
            if(!saprfc_table_append($rfchandle, "TELEFONDATANONADDRESS", $telefonoData))
            {
                echo "Error al insertar la tabla TELEFONDATANONADDRESS";
                exit();
            }
        }
        else
        {
            echo "MIERRRDA";
        }

        /*$telefonoDataX = array(
        'COUNTRY' => '',
        'COUNTRYISO' => '',
        'STD_NO' => '',
        'TELEPHONE' => 'X',
        'EXTENSION' => '',
        'TEL_NO' => '',
        'CALLER_NO' => '',
        'STD_RECIP' => '',
        'R_3_USER'=> '',
        'HOME_FLAG' => '',
        'CONSNUMBER' => 'X',
        'UPDATEFLAG' => '',
        'FLG_NOUSE' => ''
        );*/
        if(is_array($telefonoDataX))
        {
            if(!saprfc_table_append($rfchandle, "TELEFONDATANONADDRESSX", $telefonoDataX))
            {
                echo "Error al insertar la tabla TELEFONDATANONADDRESSX";
                exit();
            }
        }
        else
        {
            echo "MIERRRDA";
        }
        /*$dataPersona = array(
        'FIRSTNAME' => '',
        'LASTNAME' => '',
        'BIRTHNAME' => '',
        'MIDDLENAME' => '',
        'SECONDNAME' => '',
        'TITLE_ACA1' => '',
        'TITLE_ACA2' => '',
        'TITLE_SPPL' => '',
        'PREFIX1' => '',
        'PREFIX2' => '',
        'NICKNAME' => '',
        'INITIALS' => '',
        'NAMEFORMAT' => '',
        'NAMCOUNTRY' => '',
        'NAMCOUNTRYISO' => '',
        'SEX' => '',
        'BIRTHPLACE' => '',
        'BIRTHDATE' => '',
        'DEATHDATE' => '',
        'MARITALSTATUS' => '',
        'CORRESPONDLANGUAGE' => '',
        'CORRESPONDLANGUAGEISO' => '',
        'FULLNAME' => '',
        'EMPLOYER' => '',
        'OCCUPATION' => '',
        'NATIONALITY' => '',
        'NATIONALITYISO' => '',
        'COUNTRYORIGIN' => ''
        );*/
        if(!saprfc_import($rfchandle,"CENTRALDATAPERSON",$dataPersona))
        {
            echo "Error al insertar la estructura CENTRALDATAPERSON";
            //exit();
        }
        /*$dataPersonaX = array(
        'FIRSTNAME' => '',
        'LASTNAME' => '',
        'BIRTHNAME' => '',
        'MIDDLENAME' => '',
        'SECONDNAME' => '',
        'TITLE_ACA1' => '',
        'TITLE_ACA2' => '',
        'TITLE_SPPL' => '',
        'PREFIX1' => '',
        'PREFIX2' => '',
        'NICKNAME' => '',
        'INITIALS' => '',
        'NAMEFORMAT' => '',
        'NAMCOUNTRY' => '',
        'NAMCOUNTRYISO' => '',
        'SEX' => '',
        'BIRTHPLACE' => '',
        'BIRTHDATE' => '',
        'DEATHDATE' => '',
        'MARITALSTATUS' => '',
        'CORRESPONDLANGUAGE' => '',
        'CORRESPONDLANGUAGEISO' => '',
        'FULLNAME' => '',
        'EMPLOYER' => '',
        'OCCUPATION' => '',
        'NATIONALITY' => '',
        'NATIONALITYISO' => '',
        'COUNTRYORIGIN' => ''
        );*/
        if(!saprfc_import($rfchandle,"CENTRALDATAPERSON_X",$dataPersonaX))
        {
            echo "Error al insertar la estructura CENTRALDATAPERSON_X";
            //exit();
        }
        //saprfc_function_debug_info($rfchandle);

        $rfcresult = saprfc_call_and_receive($rfchandle);
        //echo "<h1>DOS</h1>";

        //saprfc_function_debug_info($rfchandle);

        //$rfchandle2 = saprfc_function_discover($rfc, "BAPI_TRANSACTION_COMMIT");
        /*if(!$rfchandle2)
        {
            // We have failed to discover the function
            echo "We have failed to discover the function" . saprfc_error($rfc);
            //exit();
        }
        saprfc_import($rfchandle2,"WAIT","X");
        $rfcresult2 = saprfc_call_and_receive($rfchandle2);*/

        //realease the function and close the connection
        //saprfc_function_debug_info($rfchandle2);

        $numrows = saprfc_table_rows($rfchandle,$resultstable);
        // echo $numrows,"numero";
        for ($i=1; $i <= $numrows; $i++)
        {
            $tabla[$i] = saprfc_table_read($rfchandle,$resultstable,$i);
        }
        //print_r($tabla);
        /*echo "<h1>DOS</h1>";
        $numrows2 = saprfc_table_rows($rfchandle2,$resultstable);
        // echo $numrows,"numero";
        for ($i=1; $i <= $numrows2; $i++)
        {
            $tabla2[$i] = saprfc_table_read($rfchandle2,$resultstable,$i);
        }
        print_r($tabla2);*/

        saprfc_function_free($rfchandle);
        //saprfc_function_free($rfchandle2);
        saprfc_close($rfc);
        //exit();
    }
}
?>
