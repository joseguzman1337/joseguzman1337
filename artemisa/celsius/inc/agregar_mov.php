<?
include_once "../inc/"."conexion.inc.php"; 

function devolverIdCuenta($Id_Usuario)
{

  //Conexion1();
  $inst="select u.id_cuenta as id_cuenta,tdc.id as idtdc from Emiliano.Usuarios as u ,Contable.cuentas as c,Contable.tipo_de_cuentas as tdc where u.id_cuenta=c.id and c.id_tipo_cuenta=tdc.id  and u.Id=".$Id_Usuario;
 // echo $inst;
  $result=mysql_query($inst);
  $row=mysql_fetch_array($result);
  
  return $row;
}

function insertarMovimiento($ultimo_id_recibo=0,$user,$total_a_pagar_credito=0,$total_a_pagar_debito=0,$id_cuenta,$id_tipo_cuenta=0)
{

$link=Conexion1();
mysql_select_db("Contable",$link);
$Dia = date ("d");
$Mes = date ("m");
$Anio = date ("Y");
$FechaHoy =$Anio."-".$Mes."-".$Dia;
$hora=Date("H").':'.Date("i").':00';




$instruccion="INSERT INTO movimientos_cuentas (nro_recibo,fecha,hora,id_usuario,monto_credito,monto_debito,id_cuenta) VALUES(".$ultimo_id_recibo.",'".$FechaHoy."','".$hora."',".$user.",".$total_a_pagar_credito.",".$total_a_pagar_debito.",".$id_cuenta.")";
//echo $instruccion;
$result=mysql_query($instruccion);



$monto="select * from cuentas where id=".$id_cuenta;
$result=mysql_query($monto);
$row=mysql_fetch_row($result);
$valor=$row[2];
//echo "Id Tipo decuenta:".$id_tipo_cuenta;
switch($id_tipo_cuenta)
	{
	case 1:{
	        $valorTotal=$valor+$total_a_pagar_credito;
           }
    case 2:{
	        $valorTotal=$valor-$total_a_pagar_debito;
		   }
    case 3:{
	       $valorTotal=$valor+$total_a_pagar_credito;
		   }
	}
$act="update cuentas set saldo=".$valorTotal." where id=".$id_cuenta;
//echo $act; 
$result=mysql_query($act);

Desconectar1();
return "Se agrago el movimiento";

}


?>