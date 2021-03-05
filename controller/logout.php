<?php
@session_start();
@session_destroy();
header("location:../controller/index.php");
 ?>
