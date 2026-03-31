<script language="javascript">
    function validar(){

        var largoannio=document.getElementById('annio').value.length+0;

        if(largoannio < 1){
            alert('Porfavor Digite Año');
        }
        //alert("Entro2="+largoannio;

        else if(document.getElementById('periodo').value.length < 1){
            alert('Porfavor Seleccione Periodo');
        }
        else if(document.getElementById('accion').value.length < 1){
            alert('Porfavor Seleccione Accion');
        }
        else{
            document.getElementById('form1').submit();
        }
    }
</script>
<form name="form1" id="form1" action="" method="POST">
    <table>
        <tr>
            <td>Año</td>
            <td><input name="annio" id="annio" value="<?php echo $_POST['annio']?>"></td>
        </tr>
        <tr>
            <td>Periodo</td>
            <td>
                <select name="periodo" id="periodo">
                    <option value="">Seleccionar</option>>
                    <option value="1" <?php if($_POST['periodo']=='1')echo "selected"?>>01</option>
                    <option value="2" <?php if($_POST['periodo']=='2')echo "selected"?>>02</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Accion</td>
            <td>
                <select name="accion" id="accion">
                    <option value="">Seleccionar</option>>
                    <option value="1" <?php if($_POST['accion']=='1')echo "selected"?>>Reportar</option>
                    <option value="2" <?php if($_POST['accion']=='2')echo "selected"?>>Insertar</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Tipo</td>
            <td>
                <select name="tipo" id="tipo">
                    <option value="1" <?php if($_POST['tipo']=='1')echo "selected"?>>Cursos</option>
                    <option value="2" <?php if($_POST['tipo']=='2')echo "selected"?>>Plan estudio</option>
                    <option value="3" <?php if($_POST['tipo']=='3')echo "selected"?>>Plan estudio cursos</option>
                    <option value="4" <?php if($_POST['tipo']=='4')echo "selected"?>>Resumen</option>

                </select>
            </td>
        </tr>

    </table>
    <input name="Enviar" type="button" value="Enviar" onclick="validar()">
</form>
<?php
print_r($_POST);
error_reporting(0);
ini_set('memory_limit','32M');
ini_set('pgsql.ignore_notice','1');
ini_set('pgsql.log_notice','0');
$rutaado=("../serviciosacademicos/funciones/adodb_mod/");
require_once('../serviciosacademicos/Connections/salaado-pear.php');
require_once('../serviciosacademicos/Connections/snies_conexion_postgresql.php');
require_once('../serviciosacademicos/funciones/clases/motor/motor.php');
require_once('../serviciosacademicos/funciones/clases/motor/motor.php');
require_once("../serviciosacademicos/funciones/sala_genericas/FuncionesCadena.php");
require_once('funciones/obtener_datos.php');
function limpiarPalabra($val) {

        $nuevapalabra=iconv("UTF-8","UTF-8",quitartilde(quitarsaltolinea(str_replace("&","&amp;",str_replace("<","",$val)))));
        return $nuevapalabra;

}
if(!empty($_POST['annio']) and !empty($_POST['periodo'])) {
    $codigoperiodo=$_POST['annio'].$_POST['periodo'];
    $snies = new snies($sala,$codigoperiodo);
    $snies_conexion->debug=true;
    $array_cursos=$snies->planestudiocursos($codigoperiodo);



    foreach($array_cursos as $llave=>$valor) {
        $fila["ies_code"]=$valor["ies_code"];
        $fila["curso_code"]=$valor["curso_code"];
        $fila["curso_nombre"]=limpiarPalabra($valor["curso_nombre"]);
        $fila["nbc_code"]=$valor["nbc_code"];
        $fila["es_extension"]=$valor["es_extension"];
        if($_POST['accion']=="2"&&$_POST['tipo']=="1")
            insertar_fila_bd($snies_conexion,'curso',$fila);
        $arraycurso[$valor["curso_code"]]=$fila;
        unset($fila);
        $arrayplan[$valor["idplanestudio"]]["ies_code"]=$valor["ies_code"];
        $arrayplan[$valor["idplanestudio"]]["url_plan"]=limpiarPalabra($valor["url_plan"]);
        $arrayplan[$valor["idplanestudio"]]["fecha_vigencia"]=$valor["fecha_vigencia"];

        if(isset($valor["min_num_cred"])&&($valor["min_num_cred"]!='0')&&(trim($valor["min_num_cred"])!='')) {
            $arrayplan[$valor["idplanestudio"]]["min_num_cred"]+=$valor["min_num_cred"];
        }

        if($valor["codigotipomateria"]==4)
            if(isset($valor["min_num_cred"])&&($valor["min_num_cred"]!='0')&&(trim($valor["min_num_cred"])!='')) {
                $arrayplan[$valor["idplanestudio"]]["min_num_cred_el"]+=$valor["min_num_cred"];
            }

        echo $query="SELECT * FROM programa where prog_code='".$valor["numeroregistrocarreraregistro"]."'";
        echo "<br>";
        $operacion=$snies_conexion->query($query);
        $row_operacion=$operacion->fetchRow();
        $arrayplan[$valor["idplanestudio"]]["pro_consecutivo"]=$row_operacion["pro_consecutivo"];

        $arrayplancurso[$valor["curso_code"]]["ies_code"]=$valor["ies_code"];
        $arrayplancurso[$valor["curso_code"]]["fecha_vigencia"]=$valor["fecha_vigencia"];
        $arrayplancurso[$valor["curso_code"]]["cod_curso"]=$valor["curso_code"];
        $arrayplancurso[$valor["curso_code"]]["modalidad_code"]=$valor["modalidad_code"];
        $arrayplancurso[$valor["curso_code"]]["tipo_curso_code"]=$valor["tipo_curso_code"];
        $arrayplancurso[$valor["curso_code"]]["utiliza_cur_virtuales"]=$valor["utiliza_cur_virtuales"];
        $arrayplancurso[$valor["curso_code"]]["pro_consecutivo"]=$arrayplan[$valor["idplanestudio"]]["pro_consecutivo"];
        //$arrayplancomple=$arrayplan;
        $arrayplancomple[$valor["idplanestudio"]]["pro_consecutivo"]=$row_operacion["pro_consecutivo"];
        $arrayplancomple[$valor["idplanestudio"]]["ies_code"]=$valor["ies_code"];
        $arrayplancomple[$valor["idplanestudio"]]["url_plan"]=$valor["url_plan"];
        $arrayplancomple[$valor["idplanestudio"]]["fecha_vigencia"]=$valor["fecha_vigencia"];
        $arrayplancomple[$valor["idplanestudio"]]["min_num_cred"]=$arrayplan[$valor["idplanestudio"]]["min_num_cred"];
        if(isset($arrayplan[$valor["idplanestudio"]]["min_num_cred_el"]))
            $arrayplancomple[$valor["idplanestudio"]]["min_num_cred_el"]=$arrayplan[$valor["idplanestudio"]]["min_num_cred_el"];
        else
            $arrayplancomple[$valor["idplanestudio"]]["min_num_cred_el"]="&nbsp;";

        $arrayplancursoscompl[$valor["idplanestudio"]][]=$valor["curso_code"];
        $arrayplancomple[$valor["idplanestudio"]]["idplanestudio"]=$valor["idplanestudio"];

    }
    if($_POST['accion']=="2"&&$_POST['tipo']=='2') {
        foreach($arrayplan as $llaveplan=>$valoresplan)
            insertar_fila_bd($snies_conexion,'plan_estudios',$valoresplan);
    }
    if($_POST['accion']=="2"&&$_POST['tipo']=='3') {
        foreach($arrayplancurso as $llaveplancurso=>$valoresplancurso)
            insertar_fila_bd($snies_conexion,'plan_estudios_curso',$valoresplancurso);
    }


    if($_POST['accion']=="1") {
        switch($_POST['tipo']) {
            case '1':
                foreach($arraycurso as $llave=>$valores)
                    $array_muestra[]=$valores;
                break;
            case '2':
                foreach($arrayplancomple as $llave=>$valores)
                    $array_muestra[]=$valores;
                break;
            case '3':
                foreach($arrayplancurso as $llave=>$valores)
                    $array_muestra[]=$valores;
                break;
            case '4':
                foreach($arrayplancomple as $llave1=>$valores1) {
                    //$i=0;
                    foreach($arrayplancursoscompl[$llave1] as $llave2=>$valores2) {
                        //foreach($arraycurso[$valores2] as $llave3=>$valores3){
                        $valores=$arraycurso[$valores2];
                        $valores["url_plan"]=$valores1["url_plan"];
                        $valores["pro_consecutivo"]=$valores1["pro_consecutivo"];
                        $valores["idplanestudio"]=$valores1["idplanestudio"];
                        //$i++;
                        $array_muestra[]=$valores;
                        //}
                    }
                }


                break;

        }
        $motor = new matriz($array_muestra);
        $motor->mostrar();

    }
}
function insertar_fila_bd($conexion,$tabla,$fila) {

    $claves="(";
    $valores="(";
    $i=0;
    while (list ($clave, $val) = each ($fila)) {

        if($i>0) {
            $claves .= ",".$clave."";
            $valores .= ",'".$val."'";
        }
        else {
            $claves .= "".$clave."";
            $valores .= "'".$val."'";
        }
        $i++;
    }
    $claves .= ")";
    $valores .= ")";

    echo $sql="insert into $tabla $claves values $valores";
    $operacion=$conexion->query($sql);

}

?>