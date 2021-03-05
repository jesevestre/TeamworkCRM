<?php
include_once('../model/suivi_actions.php');

if ($_SESSION['connecte']==1) {
  if (isset($_POST['insertAction'])) {
    $num_act=ajoutAction($_POST['client'],$_POST['objet'],$_POST['priorite'],$_POST['date_creat'],$_POST['date_prev']);

    echo json_encode($num_act);
    die();
  }

  $listeActions=getActions();
  $optionsNom_Cli= getClients();
  $optionsObjet=getObjets();
  $optionsPriorite=getPriorites();

  //formatage de la date pour l'affichage dans la vue suivi des actions, changer le - en /
  for ($i=0; $i <count($listeActions) ; $i++) {
    /*$listeActions[$i]['DTE_CREAT']=substr($listeActions[$i]['DTE_CREAT'], 0, 10);
    $listeActions[$i]['DTE_CREAT']=str_replace("-", "/", $listeActions[$i]['DTE_CREAT']);

    $listeActions[$i]['DTE_PREV']=substr($listeActions[$i]['DTE_PREV'], 0, 16);
    $listeActions[$i]['DTE_PREV']=str_replace("-", "/", $listeActions[$i]['DTE_PREV']);

    $listeActions[$i]['DTE_REAL']=substr($listeActions[$i]['DTE_REAL'], 0, 16);
    $listeActions[$i]['DTE_REAL']=str_replace("-", "/", $listeActions[$i]['DTE_REAL']);*/
  }

  $_SESSION['title-page']="Suivi des actions";
  include_once('../view/entete.php');
  include_once('../view/suivi_actions.php');
}
else {
  header("location:../controller/index.php");
}
?>