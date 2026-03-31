<?php
require('../../../funciones/clases/fpdf/fpdf.php');
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');


$varguardar = 0;
global $db;

$query_certificado = "SELECT * FROM certificado where idcertificado not in (1,2,3,4,11,12,13)";
$certificado = $db->Execute($query_certificado);
$totalRows_certificado = $certificado->RecordCount();
$row_certificado = $certificado->FetchRow();

//$documento=$_REQUEST['numerodocumento'];

if (isset($_POST['enviar'])) {
    if ($_POST['documento'] == "" && $_POST['naidcertificado'] == "") {
        echo "<script language='JavaScript'>alert('Por favor digite un Número de documento');
            window.location.href='certificadosprueba.php';
            </script>";
        $varguardar = 1;
    } elseif ($varguardar == 0) {

        if ($_POST["naidcertificado"] == 5) {

        } elseif ($_POST["naidcertificado"] == 6) {

        } elseif ($_POST["naidcertificado"] == 7) {

        } elseif ($_POST["naidcertificado"] == 8) {

        } elseif ($_POST["naidcertificado"] == 9) {

        } elseif ($_POST["naidcertificado"] == 10) {

        }
        elseif ($_POST["naidcertificado"] == 14) {

        }
        elseif ($_POST["naidcertificado"] == 15) {

        }
        elseif ($_POST["naidcertificado"] == 16) {

        }
        elseif ($_POST["naidcertificado"] == 17) {

        }
        elseif ($_POST["naidcertificado"] == 18) {

        }

        switch ($_POST["naidcertificado"]) {

            case "5":
               echo "<script language='JavaScript'>
            window.location.href='../seleccioncarreraestudiante.php?documento=" . $_POST['documento'] . "&certificado=" . $_POST['naidcertificado'] . "';
            </script>";
                break;

            case "6":
                echo "<script language='JavaScript'>
            window.location.href='../seleccioncarreraestudiante.php?documento=" . $_POST['documento'] . "&certificado=" . $_POST['naidcertificado'] . "';
            </script>";
                break;
            case "7":
                echo "<script language='JavaScript'>
            window.location.href='../seleccioncarreraestudiante.php?documento=" . $_POST['documento'] . "&certificado=" . $_POST['naidcertificado'] . "';
            </script>";
                break;

            case "8":
                echo "<script language='JavaScript'>
            window.location.href='../seleccioncarreraestudiante.php?documento=" . $_POST['documento'] . "&certificado=" . $_POST['naidcertificado'] . "';
            </script>";
                break;

            case "9":
                echo "<script language='JavaScript'>
            window.location.href='../seleccioncarreraestudiante.php?documento=" . $_POST['documento'] . "&certificado=" . $_POST['naidcertificado'] . "';
            </script>";
                break;

            case "10":
                echo "<script language='JavaScript'>
            window.location.href='../seleccioncarreraestudiante.php?documento=" . $_POST['documento'] . "&certificado=" . $_POST['naidcertificado'] . "';
            </script>";
                break;
            case "14":
                echo "<script language='JavaScript'>
            window.location.href='../seleccioncarreraestudiante.php?documento=" . $_POST['documento'] . "&certificado=" . $_POST['naidcertificado'] . "';
            </script>";
                break;
            case "15":
                echo "<script language='JavaScript'>
            window.location.href='../seleccioncarreraestudiante.php?documento=" . $_POST['documento'] . "&certificado=" . $_POST['naidcertificado'] . "';
            </script>";
                break;
              case "16":
                echo "<script language='JavaScript'>
            window.location.href='../../../funciones/clases/html2fpdf/Certificado de Representación Legal.pdf';
            </script>";
                break;
             case "17":
                echo "<script language='JavaScript'>
            window.location.href='../seleccioncarreraestudiante.php?documento=" . $_POST['documento'] . "&certificado=" . $_POST['naidcertificado'] . "';
            </script>";
                break;
            case "18":
                echo "<script language='JavaScript'>
            window.location.href='../seleccioncarreraestudiante.php?documento=" . $_POST['documento'] . "&certificado=" . $_POST['naidcertificado'] . "';
            </script>";
                break;
        }
    }
}
?>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
    </head>
    <body>

        <form name="form1"  method="POST" action="" >
            <table border="1" cellpadding="2" cellspacing="1" bordercolor="#003333" align="center">
                <tr bgcolor="#C5D5D6" class="Estilo2">
                    <td colspan="3" id="tdtitulogris"> <label id="labelgrande"><div align="center"><h3>CERTIFICADOS</h3></div></label>
                 <div align="center"> <select name="naidcertificado" id="naidcertificado" onChange="document.fsel.submit()">
                    <option value="" selnaidcertificadected>Seleccionar</option></div>
                    
                    <?php
do {
    $selected = " ";
    if ($row_certificado['idcertificado'] == $_REQUEST['naidcertificado'])
        $selected = "selected";
?>
                    <option value="<?php echo $row_certificado['idcertificado']; ?>" <?php echo $selected; ?>> <?php echo $row_certificado['nombrecertificado']; ?> </option>
                    <?php
                                }
                                while ($row_certificado = $certificado->FetchRow());
                                    ?>
                  </select></td>
                </tr>
           
                         <tr bgcolor="#C5D5D6" class="Estilo2">
                    
                                         <td colspan="3" bgcolor="#C5D5D6">
                             <label id="labelgrande"> <h3>Por  favor digite el número de documento para realizar la búsqueda.
                                  </h3></label>

                            </td>
                        </tr>

                    <tr bgcolor="#C5D5D6" class="Estilo2">
                           <td colspan="3" id="tdtitulogris">
                                <label id="labelgrande"><h3> Número de Documento</h3></label><div align="justify">
                                    <INPUT type="text" name="documento" id="documento"> </div>
                                                         </td>
                      </tr>
                        <tr align="center" id="trgris">
                            <td id="tdtitulogris">
                                <div align="center">
                                    <INPUT type="submit" value="Enviar" name="enviar" id="enviar" >
                                </div>
                            </td>
                        </tr>

                    </TABLE>

                </form>



</body>
                </html>
