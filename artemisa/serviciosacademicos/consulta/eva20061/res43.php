<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<?php  $hola=$_GET['si'];
$nomb=$_GET['nom'];
$apel=$_GET['ape'];
$od=$_GET['cod'];
$yyy=$_GET['siti'];
$mna=$_GET['nnm'];
$add=$_GET['idd'];
$ama=$_GET['gama'];


//echo "aqui esta $ab";
if(($hola==""))
{
?><title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<frameset rows="36,25,36,20%" cols="*" framespacing="0" frameborder="NO" border="0">
  <frame src="resultado22.php?om=<?php echo "$nomb"?>&pe=<?php echo "$apel"?>&di=<?php echo "$od"?>&ggg=<?php echo "$yyy"?>&ii=<?php echo "$mna"?>" name="Frame" frameborder="no" scrolling="no" >
  <frame src="resultado11.php?no=<?php echo "$hola"?>&ii=<?php echo "$mna"?>&ggg=<?php echo "$yyy"?>&om=<?php echo "$nomb"?>&pe=<?php echo "$apel"?>&di=<?php echo "$od"?>&mano=<?php echo "$ama"?>" name="Frame" frameborder="no" scrolling="no">
  <frame src="resultados13.php?no=<?php echo "$hola"?>&ii=<?php echo "$mna"?>&ggg=<?php echo "$yyy"?>&om=<?php echo "$nomb"?>&pe=<?php echo "$apel"?>&di=<?php echo "$od"?>&rdi=<?php echo "$add"?>&mano=<?php echo "$ama"?>" name="Frame" frameborder="no" scrolling="no" bordercolor="#00FFFF">
  <frame src="resultado14.php" name="kkiki" frameborder="no" id="kkiki">
</frameset>
<noframes><body>

</body></noframes>

</html>
<?php }

else
{ ?>


<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<frameset rows="36,25,36,20%" cols="*" framespacing="0" frameborder="NO" border="0">
  <frame src="resultado22.php?om=<?php echo "$nomb"?>&pe=<?php echo "$apel"?>&di=<?php echo "$od"?>&ggg=<?php echo "$yyy"?>&ii=<?php echo "$mna"?>" name="Frame" scrolling="NO" noresize >
  <frame src="resultado11.php?no=<?php echo "$hola"?>&ii=<?php echo "$mna"?>&ggg=<?php echo "$yyy"?>&om=<?php echo "$nomb"?>&pe=<?php echo "$apel"?>&di=<?php echo "$od"?>&mano=<?php echo "$ama"?>" name="Frame" frameborder="no" scrolling="no">
  <frame src="resultados13.php?no=<?php echo "$hola"?>&ii=<?php echo "$mna"?>&ggg=<?php echo "$yyy"?>&om=<?php echo "$nomb"?>&pe=<?php echo "$apel"?>&di=<?php echo "$od"?>&rdi=<?php echo "$add"?>&mano=<?php echo "$ama"?>" name="Frame" frameborder="no" scrolling="no">
 <frame src="resultado14.php?no=<?php echo "$hola"?>&ii=<?php echo "$mna"?>&ggg=<?php echo "$yyy"?>&om=<?php echo "$nomb"?>&pe=<?php echo "$apel"?>&di=<?php echo "$od"?>&rdi=<?php echo "$add"?>&mano=<?php echo "$ama"?>" name="kkiki" frameborder="no" id="kkiki">
</frameset>
<noframes><body>

</body></noframes>

</html>
<?php }?>
