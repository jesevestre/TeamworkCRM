<?php
  include_once('../model/Suivi_Clients.php');
  @session_start();
  if ($_SESSION['connecte']==1) {
    $listeClients=getClients();

    $_SESSION['title-page']="Suivi des clients";
  	include_once('../view/entete.php');

  	include_once('../view/Suivi_Clients.php');
  }
  else {
    header("location:../controller/index.php");
  }
 ?>
