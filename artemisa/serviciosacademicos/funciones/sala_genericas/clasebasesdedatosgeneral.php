<?php

class BaseDeDatosGeneral extends ADODB_Active_Record{

    var $conexion;

    function BaseDeDatosGeneral($conexion){
        $this->conexion=$conexion;
    }
    //Hace una consulta de una sola tabla $tabla dependiendo del id de la tabla $nombreidtabla
    //donde se puede añadir una condicion $condicion y una operacion (max(),min(),sum()...) basica
    function recuperar_datos_tabla($tabla,$nombreidtabla,$idtabla,$condicion="",$operacion="",$imprimir=0)
    {
        $query="select * $operacion from $tabla where $nombreidtabla= '$idtabla' $condicion";
        $operacion=$this->conexion->query($query);
        $row_operacion=$operacion->fetchRow();
        if($imprimir)
            echo $query;
        return $row_operacion;
    }
    //Hace una consulta de una sola tabla $tabla dependiendo del id de la tabla $nombreidtabla
    //donde se puede añadir una condicion $condicion y una operacion (max(),min(),sum()...) basica
    function recuperar_resultado_tabla($tabla,$nombreidtabla,$idtabla,$condicion="",$operacion="",$imprimir=0)
    {
        $query="select * $operacion from $tabla where $nombreidtabla= '$idtabla' $condicion";
        $operacion=$this->conexion->query($query);
        if($imprimir)
            echo $query;
        return $operacion;
    }

    //Hace una consulta de una sola tabla $tabla dependiendo del id de la tabla $nombreidtabla
    //donde se puede añadir una condicion $condicion y una operacion (max(),min(),sum()...) basica
    function recuperar_datos_tabla_fila($tabla,$clave,$valor,$condicion="",$operacion="",$imprimir=0,$tipo=1)
    {
        $condicion==""?$where="":$where="where";
        $query="select $clave, $valor $operacion from $tabla $where  $condicion";
        $Mode=$this->conexion->fetchMode;
        if(!$tipo)
            $this->conexion->SetFetchMode(ADODB_FETCH_NUM);

        $operacion=$this->conexion->query($query);

        $explodeclave=explode(".",$clave); $explodevalor=explode(".",$valor);
        if($explodeclave[1]!="")  $clave=$explodeclave[1];
        if($explodevalor[1]!="")  $valor=$explodevalor[1];
        if($tipo)
            while($row_operacion=$operacion->fetchRow()){
                $fila[$row_operacion[$clave]]=$row_operacion[$valor];
            }
        else{
            while($row_operacion=$operacion->fetchRow()){
                $fila[$row_operacion[0]]=$row_operacion[1];
            }
            $this->conexion->SetFetchMode($Mode);
        }

        if($imprimir)
            echo $query;

        return $fila;
    }

    //Inserta una fila de datos del tipo $fila['clave']=valor en la tabla $tabla donde
    //las claves son los nombres de los campos y los valores son los valores de campo a insertar
    function insertar_fila_bd($tabla,$fila,$imprimir=0,$load="")
    {

        $obj = new ADODB_Active_Record($tabla);

        if($load<>"")
        {
            $obj->load($load);
            while (list ($clave, $val) = each ($fila)) {
                $obj->$clave=$val;
            }

            if($imprimir)
                print_r($obj);

            $obj->save();

        }
        else{

            $claves="(";
            $valores="(";
            $i=0;
            while (list ($clave, $val) = each ($fila)) {

                if($i>0){
                    $claves .= ",".$clave."";
                    $valores .= ",'".$val."'";
                }
                else{
                    $claves .= "".$clave."";
                    $valores .= "'".$val."'";
                }
                $i++;
            }
            $claves .= ")";
            $valores .= ")";

            $sql="insert into $tabla $claves values $valores";
            if($imprimir)
                echo $sql;
            $operacion=$this->conexion->query($sql);

        }


    }

    //Actualiza de una fila de datos del tipo $fila['clave']=valor en la tabla $tabla donde
    //las claves son los nombres de los campos y los valores son los valores de campo a actualizar
    //dependiendo del id de la tabla ingresado $idtabla
    function actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla,$condicion="",$imprimir=0){
        $i=0;

        while (list ($clave, $val) = each ($fila)) {

            if($i>0){
                $claves .= ",".$clave."";
                $valores .= ",'".$val."'";
                $condiciones .= ",".$clave."='".$val."'";
            }
            else{
                $claves .= "".$clave."";
                $valores .= "'".$val."'";
                $condiciones .= $clave."='".$val."'";
            }
            $i++;
        }

      echo  $sql="update $tabla set $condiciones where $nombreidtabla=$idtabla $condicion";

        if($imprimir)
            echo $sql;

        $operacion=$this->conexion->query($sql);
    }

    //Ingresa o actualiza un registro dependiendo de si se encuentran registros con el mismo id
    //o la misma condicion.
    function ingresar_actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla,$condicion="")
    {
        $sql="select * from $tabla where $nombreidtabla=$idtabla $condicion";
        $operacion=$this->conexion->query($sql);
        $numrows=$operacion->numRows();
        if($numrows>0)
            $this->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla,$condicion);
        else
            $this->insertar_fila_bd($tabla,$fila);
    }
    //Ingresa o anula un registro dependiendo de si se encuentran registros con el mismo id
    //o la misma condicion.
    function ingresar_vencer_fila_bd($tabla,$fila,$nombreidtabla,$idtabla,$condicion="")
    {
        $sql="select * from $tabla where $nombreidtabla=$idtabla $condicion";
        $operacion=$this->conexion->query($sql);
        $numrows=$operacion->numRows();
        if($numrows>0)
            insertar_fila_bd($tabla,$fila);
        else
            actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla,$condicion);
    }
    //
    function close(){
        $this->conexion->close();
    }

}
