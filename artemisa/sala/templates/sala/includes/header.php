<?php 
    /**
	 * @author Andres Ariza <arizaandres@unbosque.edu.do>
	 * @copyright Universidad el Bosque - Dirección de Tecnología
	 * @package control
	 * @since November 24, 2016
	*/
	function printheaders($base){
		echo '
			<!--JQuery [ REQUIRED ]-->
				<script type="text/javascript" src="'.$base.'assets/js/jquery-3.1.1.js"></script>
				<script type="text/javascript" src="'.$base.'assets/js/jquery-migrate-1.2.1.js"></script>';
		echo '
			<!--Bootstrap [ REQUIRED ]-->
				<script type="text/javascript" src="'.$base.'assets/js/bootstrap.js"></script>';
		echo '
			<!--Ajax Dinamic List Search Menu [ REQUIRED ]-->
				<script type="text/javascript" src="'.$base.'templates/sala/js/ajax.js"></script>
				<script type="text/javascript" src="'.$base.'templates/sala/js/ajax-dynamic-list-search-menu.js"></script>';
		echo '
			<!--Bootstrap Stylesheet [ REQUIRED ]-->
				<link href="'.$base.'assets/css/bootstrap.min.css" rel="stylesheet">';
		echo '
			<!--Btheme Stylesheet [ REQUIRED ]-->
				<link href="'.$base.'assets/css/btheme.css" rel="stylesheet">';
		echo '
			<!--Font Awesome [ OPTIONAL ]-->
    			<link href="'.$base.'assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet">';
		echo '
			<!--Theme styles-->
    			<link href="'.$base.'templates/sala/css/template.css" rel="stylesheet">';
		/*echo '
			<!--Demo script [ DEMONSTRATION ]-->
			<link href="'.$base.'assets/css/demo/btheme-demo.css" rel="stylesheet">';/**/
				
	}
	function printScriptFooter($base){
		echo '
			<!--JAVASCRIPT--> 
    			<script type="text/javascript" src="'.$base.'assets/js/btheme.js"></script>';/**/
		echo '
    			<script type="text/javascript" src="'.$base.'templates/sala/js/menuTrigger.js"></script>';/**/
	}
	/*
?>



<?php
/* <!--STYLESHEET-->
    <!--=================================================-->

    <!--Open Sans Font [ OPTIONAL ] -->
     <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&amp;subset=latin" rel="stylesheet">


    <!--Animate.css [ OPTIONAL ]-->
    <link href="plugins/animate-css/animate.min.css" rel="stylesheet">


    <!--Morris.js [ OPTIONAL ]-->
    <link href="plugins/morris-js/morris.min.css" rel="stylesheet">


    <!--Switchery [ OPTIONAL ]-->
    <link href="plugins/switchery/switchery.min.css" rel="stylesheet">


    <!--Bootstrap Select [ OPTIONAL ]-->
    <link href="plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">


    <!--Demo script [ DEMONSTRATION ]-->
    <link href="css/demo/btheme-demo.min.css" rel="stylesheet">




    <!--SCRIPT-->
    <!--=================================================-->

    <!--Page Load Progress Bar [ OPTIONAL ]-->
    <link href="plugins/pace/pace.min.css" rel="stylesheet">
    <script src="plugins/pace/pace.min.js"></script>


    
	<!--

	REQUIRED
	You must include this in your project.

	RECOMMENDED
	This category must be included but you may modify which plugins or components which should be included in your project.

	OPTIONAL
	Optional plugins. You may choose whether to include it in your project or not.

	DEMONSTRATION
	This is to be removed, used for demonstration purposes only. This category must not be included in your project.

	SAMPLE
	Some script samples which explain how to initialize plugins or components. This category should not be included in your project.


	Detailed information and more samples can be found in the document.

	-->
 */
?>