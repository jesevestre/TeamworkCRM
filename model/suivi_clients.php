<?php

include_once(dirname(__DIR__).'/settings.php');
include_once(dirname(__DIR__).'/m_bdd.php');
@session_start();

function getClients()
{
  $req_str = "SELECT DISTINCT *, C.CDE_CLI, LIB_TYPE=CASE TYPE WHEN 0 THEN 'Client' WHEN 1 THEN 'Prospect' END,
              CONCAT(C.ADRESSE_1 +' ',C.ADRESSE_2 +' ',C.NUM_VOIE +' ',C.NUM_VOIE2 +' ',C.TYPE_VOIE +' ',C.NOM_VOIE +' ',C.CP +' ',C.VILLE +' ',C.PAYS) AS ADRESSE_COMPLETE_CLIENT
              FROM  CLIENTS c";
              if ($_SESSION['superviseur']==0) {
                $req_str=$req_str." INNER JOIN CLIENTSMARCHE Cm ON c.CDE_CLI = cm.CDE_CLI
                    			inner JOIN PROFIL p ON p.CDE_PROFIL = cm.CDE_PROFIL
                          WHERE cm.CDE_PROFIL=?";
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




 ?>
