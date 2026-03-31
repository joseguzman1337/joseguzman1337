<?php
/* error_reporting(E_ALL);
  ini_set('display_errors', '1'); */
require_once('../Connections/sala2.php');
$rutaado = "../funciones/adodb/";
require_once('../Connections/salaado.php');
include_once("includes/objetosHTML.php");
$obj = New objetosHTML;

/**
 * Se hace reorganizacion de codigo de modo tal que se cambian las sentencias if
 * por un switch cases, y se agrega una consulta adicional para consultar los datos
 * de candidatos adminstrativos (case 4)
 * @modified Andres Ariza <andresariza@unbosque.edu.do>.
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @since 18 de septiembre de 2018.
 */
$idtip = $_REQUEST["idtip"];
switch ($idtip){
    case 1:
        $query = "SELECT DISTINCT apellidosegresado AS apellidos,nombresegresado AS nombres,
            telefonoresidenciaegresado AS telefono,telefonorecelularegresado AS celular, 
            direccionresidenciaegresado AS direccion
        FROM egresado e 
        JOIN estudiante ee USING(idestudiantegeneral)
        JOIN carrera c USING(codigocarrera) 
        WHERE e.numerodocumento='" . trim($_REQUEST["id"]) . "' 
            AND ee.codigosituacioncarreraestudiante=400
        UNION
        SELECT DISTINCT apellidosestudiantegeneral AS apellidos,nombresestudiantegeneral AS nombres,
            telefonoresidenciaestudiantegeneral telefono, celularestudiantegeneral AS celular, 
            direccionresidenciaestudiantegeneral AS direccion 
        FROM registrograduado rg
        INNER JOIN estudiante e ON ( e.codigoestudiante=rg.codigoestudiante AND e.codigosituacioncarreraestudiante=400 )
        INNER JOIN estudiantegeneral eg ON ( eg.idestudiantegeneral=e.idestudiantegeneral )
        WHERE eg.numerodocumento='" . trim($_REQUEST["id"]) . "' 
        UNION 
	SELECT DISTINCT apellidosestudiantegeneral AS apellidos,nombresestudiantegeneral AS nombres,
            telefonoresidenciaestudiantegeneral AS telefono, celularestudiantegeneral AS celular, 
            direccionresidenciaestudiantegeneral AS direccion
        FROM registrograduadoantiguo rg 
        INNER JOIN estudiante e ON ( e.codigoestudiante=rg.codigoestudiante AND e.codigosituacioncarreraestudiante=400 )
        INNER JOIN estudiantegeneral eg ON ( eg.idestudiantegeneral=e.idestudiantegeneral )
        WHERE eg.numerodocumento='" . trim($_REQUEST["id"]) . "'";
        break;
    case 2:
        $query = "SELECT DISTINCT apellidosestudiantegeneral AS apellidos,nombresestudiantegeneral AS nombres,
            telefonoresidenciaestudiantegeneral AS telefono, celularestudiantegeneral AS celular,
            direccionresidenciaestudiantegeneral as direccion 
        FROM estudiante e 
        JOIN carrera c ON ( e.codigocarrera=c.codigocarrera )
        JOIN estudianteestadistica ee ON ( ee.codigoestudiante=e.codigoestudiante )
        JOIN prematricula p ON ( e.codigoestudiante=p.codigoestudiante )
        JOIN estudiantegeneral eg USING(idestudiantegeneral) 
        JOIN periodo per ON ( p.codigoperiodo=per.codigoperiodo AND per.codigoestadoperiodo=1 )
        WHERE ee.codigoperiodo=p.codigoperiodo 
            AND c.codigomodalidadacademica IN (200,300)  
            AND ee.codigoprocesovidaestudiante IN (400,401) 
            AND ee.codigoestado LIKE '1%' 
            AND numerodocumento='" . trim($_REQUEST["id"]) . "'";
        break;
    case 3:
        $query = "SELECT DISTINCT apellidodocente AS  apellidos,nombredocente AS nombres,
            telefonoresidenciadocente AS telefono,numerocelulardocente AS  celular,direcciondocente AS direccion 
            FROM docente 
            WHERE numerodocumento='" . trim($_REQUEST["id"]) . "'";
        break;
    case 4:
        $query = "SELECT  DISTINCT apellidosadministrativosdocentes AS apellidos,nombresadministrativosdocentes AS nombres,
            telefonoadministrativosdocentes AS telefono,celularadministrativosdocentes AS celular, 
            direccionadministrativosdocentes AS direccion
        FROM administrativosdocentes 
        WHERE codigoestado = 100
        AND numerodocumento = '" . trim($_REQUEST["id"]) . "'";
        break;
}
    

//echo $query;die;
//echo "<br/>".$query."<br/>";
$row = $db->GetRow($query);
//var_dump($res);
if (count($row) == 0 || $row == null || $row === false) {
    ?>
    <span class="error">El candidato no se encuentra registrado.</span>
    <?php
} else {
    //$row=$res->FetchRow();
    //$foto=(file_exists("../../imagenes/estudiantes/".$_REQUEST["id"].".jpg"))?"../../imagenes/estudiantes/".$_REQUEST["id"].".jpg":"images/no_foto.jpg";

    require_once("../utilidades/datosEstudiante.php");
    $foto = "";
    $foto = obtenerFotoDocumentoEstudiante($db, trim($_REQUEST["id"]), "../../imagenes/estudiantes/");
    if (strpos($foto, 'no_foto') !== false) {
        if (file_exists("../../imagenes/estudiantes/" . trim($_REQUEST["id"]) . ".jpg")) {
            $foto = "../../imagenes/estudiantes/" . trim($_REQUEST["id"]) . ".jpg";
        }
    }
    ?>
    <table width="100%">
        <tr>
            <td width="10%" align="center">
                <img src="<?php echo $foto ?>" width="90" height="125">
            </td>
            <td width="90%">
                <p> <?php echo $obj->textBox("Apellidos", "apellidos" . $_REQUEST["tc"], $row["apellidos"], 1, "25") ?> </p>
                <p> <?php echo $obj->textBox("Nombres", "nombres" . $_REQUEST["tc"], $row["nombres"], 1, "25") ?> </p>
                <p> <?php echo $obj->textBox("Teléfono", "telefono" . $_REQUEST["tc"], $row["telefono"], 0, "10", "right") ?> </p>
                <p> <?php echo $obj->textBox("Celular", "celular" . $_REQUEST["tc"], $row["celular"], 0, "15", "right") ?> </p>
                <p> <?php echo $obj->textBox("Dirección", "direccion" . $_REQUEST["tc"], $row["direccion"], 0, "90") ?> </p>
            </td>
        </tr>
    </table>
    <?php
}
?>
