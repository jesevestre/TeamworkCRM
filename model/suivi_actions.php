<?php
include_once(dirname(__DIR__).'/settings.php');
include_once(dirname(__DIR__).'/m_bdd.php');

@session_start();

function getActions()
{
  $req_str = "SELECT C.CDE_CLI, C.NOM_CLI, NUM_ACTION, t.LIB_50 as OBJET, t4.LIB_50 as ORIGINE, t2.LIB_50 as PRIORITE,
              /*CONVERT(VARCHAR(10), DTE_CREAT, 103) as DTE_CREAT,*/
              CONCAT(CONVERT(VARCHAR(10),DTE_PREV,103), ' ', CONVERT(VARCHAR(5),DTE_PREV,108)) as DTE_PREV,
              CONCAT(CONVERT(VARCHAR(10),DTE_REAL,103), ' ', CONVERT(VARCHAR(5),DTE_REAL,108)) as DTE_REAL,
              IIF(ETAT='CL', 'Cloturé', 'En cours') AS ETAT, t6.LIB_50 as STATUT, t3.LIB_50 as NATURE, t5.LIB_50 as INTERET,
              NUM_AFFAIRE, CONCAT(C.ADRESSE_1 +' ',C.ADRESSE_2 +' ',C.NUM_VOIE +' ',C.NUM_VOIE2 +' ',C.TYPE_VOIE +' ',C.NOM_VOIE +' ',C.CP +' ',C.VILLE +' ',C.PAYS) AS ADRESSE_COMPLETE_ACTION

              FROM CLIENTS C";
              if ($_SESSION['superviseur']==0) {
                $req_str =$req_str."INNER JOIN CLIENTSMARCHE Cm ON c.CDE_CLI = cm.CDE_CLI
                INNER JOIN PROFIL p ON p.CDE_PROFIL = cm.CDE_PROFIL";
              }
              $req_str =$req_str." INNER JOIN ACTIONCRM ac ON ac.CDE_CLI = c.CDE_CLI
              LEFT OUTER JOIN TABLES t ON T.NUM_TABLE= 1 and t.CDE_TABLE=ac.OBJET
              LEFT OUTER JOIN TABLES t2 ON T2.NUM_TABLE= 2 and t2.CDE_TABLE=ac.PRIORITE
              LEFT OUTER JOIN TABLES t3 ON T3.NUM_TABLE= 3 and t3.CDE_TABLE=ac.NATURE
              LEFT OUTER JOIN TABLES t4 ON T4.NUM_TABLE= 4 and t4.CDE_TABLE=ac.ORIGINE
              LEFT OUTER JOIN TABLES t5 ON T5.NUM_TABLE= 5 and t5.CDE_TABLE=ac.INTERET
              LEFT OUTER JOIN TABLES t6 ON T6.NUM_TABLE= 6 and t6.CDE_TABLE=ac.STATUT";
              if ($_SESSION['superviseur']==0) {
                $req_str =$req_str." WHERE cm.CDE_PROFIL=?";
              }
  global $m_bdd;
  $requete = $m_bdd->prepare($req_str);
  if ($_SESSION['superviseur']==0) {
    $requete->execute(array($_SESSION['cde_profil']));
  }
  else {
    $requete->execute();
  }
  return $requete->fetchAll(PDO::FETCH_ASSOC);
}


function getClients()
{
  $req_str = "SELECT DISTINCT C.CDE_CLI, NOM_CLI, NOM_CLI+' - '+C.CDE_CLI AS LABEL from CLIENTSMARCHE CM
              INNER JOIN CLIENTS c on cm.CDE_CLI=c.CDE_CLI";
  if ($_SESSION['superviseur']==0) {
    $req_str =$req_str." WHERE CDE_PROFIL=?";
  }
  $req_str=  $req_str." ORDER BY NOM_CLI";
  global $m_bdd;
  $requete = $m_bdd->prepare($req_str);
  if ($_SESSION['superviseur']==0) {
    $requete->execute(array($_SESSION['cde_profil']));
  }
  else {
    $requete->execute();
  }
  $result = $requete->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}


function getObjets()
{
  $req_str = "SELECT * FROM TABLES
              WHERE NUM_TABLE=1
              ORDER BY CDE_TABLE";
  global $m_bdd;
  $requete = $m_bdd->prepare($req_str);
  $requete->execute();
  $result = $requete->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}


function getPriorites()
{
  $req_str = "SELECT *
              FROM TABLES
              WHERE NUM_TABLE='2'";
  global $m_bdd;
  $requete = $m_bdd->prepare($req_str);
  $requete->execute();
  $result = $requete->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function ajoutAction($client,$objet,$priorite,$date_creat,$date_prev)
{
  $NumAction=nouvelleAction();

  $req_str = "INSERT INTO ACTIONCRM (NUM_ACTION,OBJET,PRIORITE,ETAT,AUTEUR,CDE_PROFIL,CDE_CLI,DTE_CREAT,DTE_PREV)
            VALUES(?,?,?,'EC',?,?,?,?,convert(datetime,convert(datetime,?)))";

  global $m_bdd;
  $requete = $m_bdd->prepare($req_str);
  $result=$requete->execute(array($NumAction, $objet, $priorite,$_SESSION['cde_profil'],$_SESSION['cde_profil'],$client, $date_creat, $date_prev));
  return $NumAction;
}

function nouvelleAction()
{
  global $m_bdd;
  $format='A';
  $requete = $m_bdd->prepare('SELECT MAX(NUM_ACTION) as max FROM ACTIONCRM');
  $result = $requete->execute();
  $res = "";

  while ($row = $requete->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
    $res = $row[0];
  }

  if ($res == ""){
    $res = $format."000000";
  }

  $res = explode("$format",$res)[1];
  $i = "000000".($res+1);
  $resultat = "$format".substr($i,-6);
  return $resultat;
}
?>