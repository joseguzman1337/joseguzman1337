<?php
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=reporte_".date('Y-m-d').".xls");
header("Pragma: no-cache");
header("Expires: 0");
 session_start(); 

require_once("../templates/template.php");
$db = getBD();
$sql = 'select eg.numerodocumento as username,eg.numerodocumento as password1, eg.nombresestudiantegeneral as firstname,eg.apellidosestudiantegeneral as lastname,
			CONCAT(eg.numerodocumento,"@unbosque.edu.co") as email,"Competencias 2015I" as course1,1 as type1,c.nombrecarrera as group1,e.codigoestudiante 
			from prematricula pr 
			inner join estudiante e on e.codigoestudiante=pr.codigoestudiante 
			INNER JOIN carrera c on c.codigocarrera=e.codigocarrera and c.codigomodalidadacademica=200
			inner join estudiantegeneral eg on eg.idestudiantegeneral=e.idestudiantegeneral  
			INNER JOIN estudianteestadistica ee on ee.codigoestudiante=e.codigoestudiante and ee.codigoprocesovidaestudiante= 400
			and ee.codigoperiodo=pr.codigoperiodo and ee.codigoestado like "1%" 
			WHERE pr.codigoperiodo="20151" and pr.codigoestadoprematricula IN (40,41)
			ORDER BY c.nombrecarrera,eg.apellidosestudiantegeneral,eg.nombresestudiantegeneral';
$matriculados = $db->Execute($sql);

 $i=0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
<title>Reporte</title>


<style type="text/css">
table
{
 border-collapse: collapse;
    border-spacing: 0;
}
th, td {
border: 1px solid #000000;
    padding: 0.5em;
}
</style>
</head>
<body>
    <table CELLPADDING="10" id="tableResult">
            <thead>
                <tr>
                    <th>username</th>
                    <th>password</th>
                    <th>firstname</th>
                    <th>lastname</th>
                    <th>email</th>
                    <th>course1</th>
                    <th>type1</th>
                    <th>group1</th>
                </tr>
            </thead>
        <tbody>
    <?php $html="";
	while(!$matriculados->EOF){ ?>
		<tr class="dataColumns" >
			<td class="column borderR"><?php echo $matriculados->fields['username']; ?></td>
			<td class="column borderR"><?php echo $matriculados->fields['password1']; ?></td>
			<td class="column borderR"><?php echo $matriculados->fields['firstname']; ?></td>
			<td class="column borderR"><?php echo $matriculados->fields['lastname']; ?></td>
			<td class="column borderR"><?php echo $matriculados->fields['email']; ?></td>
			<td class="column borderR"><?php echo $matriculados->fields['course1']; ?></td>
			<td class="column borderR"><?php echo $matriculados->fields['type1']; ?></td>
			<td class="column borderR"><?php echo $matriculados->fields['group1']; ?></td>
		</tr>
	<?php $matriculados->MoveNext(); }
?>
    </tbody>
    </table>        
</body>
</html>
