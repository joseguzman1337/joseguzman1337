<?php

require_once(realpath ( dirname(__FILE__)."/../../../sala/config/Configuration.php" ));
$Configuration = Configuration::getInstance();
require_once (PATH_SITE."/lib/Factory.php");
  ?>

<html >
<head >
    <!--  scripts  -->
    <script src="<?php echo HTTP_SITE?>/assets/js/jquery-3.6.0.min.js"></script>
    <script src="<?php echo HTTP_SITE?>/assets/js/bootstrap.js"></script>
    <link rel="stylesheet" href="<?php echo HTTP_SITE?>/assets/css/bootstrap4.css">
    <!--  Space loading indicator  -->
    <script src="<?php echo HTTP_SITE; ?>/assets/js/spiceLoading/pace.min.js"></script>

    <!--  loading cornerIndicator  -->
    <link href="<?php echo HTTP_SITE; ?>/assets/css/cornerIndicator/cornerIndicator.css" rel="stylesheet">
</head>
<body>
    <?php
    include('header.php');
    ?>

    <div class="row" id="divDataSonda" style="display: none">

    </div>
</body>
</html>

