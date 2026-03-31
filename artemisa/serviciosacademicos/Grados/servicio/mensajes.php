<?php
/**
 * @author Gonzalo Mejia Zapata <c.gmejia@sic.gov.co>
 * @copyright 2012 Oficnina de tecnologoia
 * @package servicio
 */
header('Content-type: text/html; charset=utf-8');
ini_set('display_errors', 'On');

session_start();

if ($_POST) {
    $keys_post = array_keys($_POST);
    foreach ($keys_post as $key_post) {
        $$key_post = $_POST[$key_post];
    }
}

if ($_GET) {
    $keys_get = array_keys($_GET);
    foreach ($keys_get as $key_get) {
        $$key_get = $_GET[$key_get];
    }
}

switch ($mensaje) {

    case 'actualizado':
        echo "Actualizado con exito";
        break;

    case 'ValidarCampos':
        ?>
        <p align="center">
            <?php echo "</br>&nbsp;Existen campos sin diligenciar.</br>"; ?>
        </p>	
        <?php
        /* if($_POST){ 
          $keys_post = array_keys($_POST);
          foreach ($keys_post as $key_post){
          if( $_POST[$key_post] != "ValidarCampos" )
          echo $key_post . " , ";
          }
          }
          if($_GET){
          $keys_get = array_keys($_GET);
          foreach ($keys_get as $key_get){
          if( $_GET[$key_post] != "ValidarCampos" )
          echo $key_get . " , ";
          }
          } */
        break;
    case 'errorLogin':
        echo "Error usuario o contrasenia incorrectos";
        break;


    case 'errorClaves':
        echo "Las claves no coinciden";
        break;

    case 'clavesActulizadas':
        echo "Las claves se han actualizado.";

    case 'selecionarTipoDocumento':
        echo "Seleccion el tipo de documento";
        break;

    case 'controlCampos':
        echo "<div style=\"color:#FF0000;\">";
        echo "Los siguientes campos se encuentran vacios o no seleccionados.</br></br>";
        echo $errores;
        echo "</div>";
        break;

    /* Modified Diego Rivera <riveradiego@unbosque.edu.co>
     * Se crea caso  tipoGrado con el fin de generar mensaje cuando no se pueda consultar de forma multiple programas de posgrado o pregrado 
     * Since august 15,2017
     *  */
    case 'tipoGrado':
        ?>
        <script src="../js/MainTableroMando.js"></script>

        <?php
        echo "<div style=\"color:#FF0000;\">";
        echo "<strong>Menú no permite consultar por  la opción todos los programas de pregrado o posgrado.</strong></br></br>";
        echo $errores;
        echo "</div>";
        break;

    case 'sinDatos':
        ?>
        <script src="../js/MainTableroMando.js"></script>

        <?php
        echo "<div style=\"color:#FF0000;\">";
        echo "<strong>No existen registros para consultar.</strong></br></br>";
        echo "</div>";
        break;

    case 'estadoActualizado':
        echo "Estado actualizado";
        break;
    /** Modified Diego Rivera <riveradiego@unbosque.edu.co>
     * Se agrega case promocionActualizado para generar mensaje al actualizar promocion de un programa academico
     * Since july 15,2019
     */
    case 'promocionActualizado':
        ?>
        <script src="../js/MainTableroMando.js"></script>
        <?php
        echo "<div style=\"color:#FF0000;\">";
        echo "<strong>Promocion actualizada</strong></br></br>";
        echo "</div>";

        break;
    case 'error':
        echo $error;
        break;
}
?>