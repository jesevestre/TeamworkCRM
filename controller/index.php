<?php

include_once('../model/index.php');

// include_once('../view/entete.php');
@session_start();

if(isset($_POST['identifiant']) and isset($_POST['mdp']) and !empty($_POST['identifiant']) and !empty($_POST['mdp']) )
{
  $_SESSION['prenom'] = '';
  $_SESSION['nom'] = '';
  $result = check_user(strtoupper($_POST['identifiant']));
  if($result != null) {
    $result = check_motdepasse(strtoupper($_POST['identifiant']), md5(strtoupper($_POST['mdp'])));
    if($result != null) {
      if($result[0]['user_name'] != null)
      {
        $_SESSION['connecte'] = 1;
        $_SESSION['cde_profil'] = $result[0]['user_name'];
        $_SESSION['nom'] = $result[0]['nom'];
        $_SESSION['prenom'] = $result[0]['prenom'];
        $_SESSION['email'] = $result[0]['email'];
        $_SESSION['superviseur']= $result[0]['superviseur'];
        header('location:../controller/Suivi_Clients.php');
      }
    }
    else {
      $message_erreur=' Mot de passe incorrect';
      include_once('../view/index.php');
    }
  }
  else {
    $message_erreur='Identifiant incorrect';
    include_once('../view/index.php');
  }
}
else {
  include_once('../view/index.php');
}

 ?>
