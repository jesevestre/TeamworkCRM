<?php
include_once('../model/action.php');

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

session_start();
require '../vendor/autoload.php';
use RtfHtmlPhp\Document;
use PHPUnit\Framework\TestCase;
use RtfHtmlPhp\Html\HtmlFormatter;
use RtfHtmlPhp\Exception;

if ($_SESSION['connecte']==1) {

  if (isset($_POST['ongletBase'])) {
    $_SESSION['ongletAction']='detail';

    $files_list=getFilesList($_POST['action']);
    for ($i=0; $i <count($files_list) ; $i++) {
      // récupération du chemin des fichiers
      $url = $files_list[$i]['IMAGE_LINK'].$files_list[$i]['IMAGE_NAME'];
      // récupération du contenu du fichier
      $results = base64_encode(file_get_contents($url));
      // récupération du contenu du type du fichier
      $type_file=mime_content_type($url);
      // concaténation des deux dans un seul string
      $name_file=basename($url);
      $files_list[$i]['data']=$type_file.','.$name_file.','.$results;
    }
    echo json_encode($files_list);
    die();
  }

  if (isset($_POST['remove_img'])) {
    $file_path='../upload/'.$_POST['action'].'/'.$_POST['name'];
    removeImg($file_path,$_POST['action']);
    unlink($file_path);
  }

  if (isset($_POST['download'])) {
    $file_path_final = '../upload/'.$_POST['action'].'/';
    if(!is_dir($file_path_final)){
      @mkdir($file_path_final);
    }

    save_image($file_path_final, $_POST['action'],$_POST['name']);

    file_put_contents($file_path_final.$_POST['name'], base64_decode($_POST['file']));
    die();
  }
  if (isset($_GET['num_act'])) {
    $numAct=$_GET['num_act'];
    $action=getAction($numAct)[0];

    $AfterTrim=$action['PREPARATION'];
    if(strpos($AfterTrim, 'rtf1') !== false && isset($action['PREPARATION'])){
      $trimmed = trim($AfterTrim);
      $document = new RtfHtmlPhp\Document($trimmed);
      $formatter = new RtfHtmlPhp\Html\HtmlFormatter();
      $action['PREPARATION']=$formatter->Format($document);
    }

    $AfterTrim=$action['COMPTE_RENDU'];
    if(strpos($AfterTrim, 'rtf1') !== false && isset($action['COMPTE_RENDU'])){
      $trimmed = trim($AfterTrim);
      $document = new RtfHtmlPhp\Document($trimmed);
      $formatter = new RtfHtmlPhp\Html\HtmlFormatter();
      $action['COMPTE_RENDU']=$formatter->Format($document);
    }

    $listeSelectPriorite=getPriorites();
    $listeSelectObjet=getObjets();
    $listeSelectProfil=getProfils();
    $listeSelectNature=getNatures();
    $listeSelectOrigine=getOrigines();
    $listeSelectInteret=getInterets();
    $listeSelectStatut=getStatus();
    $listeInterlocuteurs=getInterlocuteurs($numAct);
    $listeTaches=getTaches($numAct);
    $listeIntervenants=getIntervenants();
    $listeFonctions=getFonctions();

    // si on a pas d'onglet déja pré enregistré alors on va dans le detail
    if (!isset($_SESSION['ongletAction']))  {
      $_SESSION['ongletAction']='detail';
    }
  }
  else if (!isset($numAct)) {
    $numAct='invalide';
  }

  if (isset($_POST['recupListeInterlocuteurs'])) {
    $listeInterlocteursPotentiels=recupListeInterlocuteursPotentiel($_POST['numAct'],$_POST['tiers']);
    echo json_encode($listeInterlocteursPotentiels);
    die();
  }

  if (isset($_POST['ajouterInterlocuteurs'])) {
    insertInterlocuteurs($_POST['numAct'],$_POST['listeInterlocteurs']);
    $listeInterlocuteurs=getInterlocuteurs($_POST['numAct']);
    echo json_encode($listeInterlocuteurs);
    die();
  }

  if (isset($_POST['update'])) {
    if (isset($_POST['rencontre'])) {
      updateRencontre($_POST['numAct'],$_POST['rencontre'],$_POST['numCont'],$_POST['typeCont'],$_POST['tiersCont']);
    }
    elseif (isset($_POST['dte_prev'])) {
      updateDtePrev($_POST['numAct'],$_POST['dte_prev']);
    }
    elseif (isset($_POST['dte_real'])) {
      updateDteReal($_POST['numAct'],$_POST['dte_real']);
    }
    elseif (isset($_POST['nature'])) {
      updateNature($_POST['numAct'],$_POST['nature']);
    }
    elseif (isset($_POST['origine'])) {
      updateOrigine($_POST['numAct'],$_POST['origine']);
    }
    elseif (isset($_POST['interet'])) {
      updateInteret($_POST['numAct'],$_POST['interet']);
    }
    elseif (isset($_POST['statut'])) {
      updateStatut($_POST['numAct'],$_POST['statut']);
    }
    elseif (isset($_POST['NUM_AFFAIRE'])) {
      updateCA($_POST['numAct'],$_POST['NUM_AFFAIRE']);
    }
    elseif (isset($_POST['echeance'])) {
      updateEcheance($_POST['numAct'],$_POST['echeance']);
    }
    elseif (isset($_POST['preparation'])) {
      $preparation = urldecode($_POST['preparation']);
      updatePrep($_POST['numAct'],$preparation);
    }
    elseif (isset($_POST['compte_rendu'])) {
      $compte_rendu = urldecode($_POST['compte_rendu']);
      updateCpteRendu($_POST['numAct'],$compte_rendu);
    }
    elseif (isset($_POST['tache'])) {
      updateTache($_POST['numAct'],$_POST['tache'],$_POST['rang']);
    }
    elseif (isset($_POST['interlocuteur'])) {
      updateInterlocuteur($_POST['numAct'],$_POST['interlocuteur'],$_POST['num_contac']);
    }
    elseif (isset($_POST['ressource'])) {
      updateRessource($_POST['numAct'],$_POST['ressource'],$_POST['rang']);
    }
    elseif (isset($_POST['dte_prev_tache'])) {
      updateDtePrev_tache($_POST['numAct'],$_POST['dte_prev_tache'],$_POST['rang']);
    }
    elseif (isset($_POST['dte_real_tache'])) {
      updateDteReal_tache($_POST['numAct'],$_POST['dte_real_tache'],$_POST['rang']);
    }
    elseif (isset($_POST['observation'])) {
      updateObservation($_POST['numAct'],$_POST['observation'],$_POST['rang']);
    }
  }

  elseif  (isset($_POST['insertTache'])) {
    if (isset($_POST['intervenant'])) {
      $tache=insertTache($_POST['numAct'],$_POST['intervenant'],$_POST['tache'],$_POST['date_prev'],$_POST['date_real'],$_POST['observation']);
      if ($tache[0]==0) {
        $listeTaches=getTaches($_POST['numAct']);
        echo json_encode($listeTaches);
        die();
      } else {
        echo 'erreur';
        die();
      }
    }
  }

  elseif  (isset($_POST['insertInterlocuteur'])) {
    $nouvInterlocuteur=insertInterlocuteur($_POST['type'],$_POST['tiersCont'],$_POST['nom'],$_POST['fonction'],
    $_POST['telFixe'],$_POST['telPortable'],$_POST['fax'],$_POST['email'],$_POST['internet'],$_POST['adr0'],$_POST['adr1'],
    $_POST['adr2'],$_POST['adr3'],$_POST['cp'],$_POST['pays'],$_POST['civilite'],$_POST['prenom'], $_POST['date_creat'],
    $_POST['date_MAJ'],$_POST['inactif']);
  }

  elseif  (isset($_POST['deleteTache'])) {
    if (isset($_POST['rang'])) {
      deleteTache($_POST['numAct'],$_POST['rang']);
      $_SESSION['ongletAction']='taches';
    }
  }

  elseif  (isset($_POST['removeInterlocuteur'])) {
    if (isset($_POST['num_contac'])) {
      removeInterlocuteur($_POST['numAct'],$_POST['num_contac']);
      $_SESSION['ongletAction']='detail';
    }
  }
  else{
    $_SESSION['title-page']="Action";
    include_once('../view/entete.php');
    include_once('../view/action.php');
  }
}
else {
  header("location:../controller/index.php");
}
?>