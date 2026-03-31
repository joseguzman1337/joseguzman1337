<?php
error_reporting(2047);
require_once("../../../Connections/sala2.php");
include('Tree.php');
include('TreeMenu.php');
require_once('../../../funciones/clases/autenticacion/redirect.php');
$query_arbol="SELECT
mu.idmenuopcion as id, mu.idpadremenuopcion as parent_id, mu.nombremenuopcion as text, mu.linkmenuopcion as link, mu.framedestinomenuopcion as linkTarget
FROM menuopcion mu
WHERE 
mu.codigoestadomenuopcion='01'
";

$tree = &Tree::createFromMySQL(array('host'=>$hostname_sala,'user'=> $username_sala,'pass'=> $password_sala,'database' => $database_sala,'query'=>$query_arbol));
$nodeOptions = array('icon'=> 'folder.gif','expandedIcon'=>'openfoldericon.png','class'=>'','expanded'=>true,'linkTarget'=> '_self','isDynamic'=>'true');
$options = array('structure' => $tree,'type' => 'heyes','nodeOptions' => $nodeOptions);
$menu = &HTML_TreeMenu::createFromStructure($options);

// Create the presentation class
//$treeMenu = &new HTML_TreeMenu_DHTML($menu, array('images' => '../images', 'defaultClass' => 'treeMenuDefault'));
$listBox  = &new menuOrdenamiento($menu, array('linkTarget' => '_self'));
//$treeMenuStatic = &new HTML_TreeMenu_staticHTML($menu, array('images' => '../images', 'defaultClass' => 'treeMenuDefault', 'noTopLevelImages' => true));
?>
<html>
<head>
    <style type="text/css">
        body {
            font-family: Georgia;
            font-size: 11pt;
        }
        
        .treeMenuDefault {
            font-style: italic;
        }
        
        .treeMenuBold {
            font-style: italic;
            font-weight: bold;
        }
    </style>
    <script src="../TreeMenu.js" language="JavaScript" type="text/javascript"></script>
</head>
<body>

<script language="JavaScript" type="text/javascript">
<!--
a = new Date();
a = a.getTime();
//-->
</script>

<?//$treeMenu->printMenu()?><br /><br />
<?$listBox->printMenu()?>

<script language="JavaScript" type="text/javascript">
<!--
b = new Date();
b = b.getTime();

document.write("Time to render tree: " + ((b - a) / 1000) + "s");
//-->
</script>


</body>
</html>