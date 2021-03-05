<?php
include_once(dirname(__DIR__).'/settings.php');
include_once(dirname(__DIR__).'/m_bdd.php');

function getAction($numAct)
{
  $req_str = "SELECT *,  t.LIB_50 as LIB_OBJET, t2.LIB_50 as LIB_PRIORITE, t3.LIB_50 as LIB_NATURE, t4.LIB_50 as LIB_ORIGINE,
              t5.LIB_50 as LIB_INTERET, t6.LIB_50 as LIB_STATUT, ac.TEXTE as PREPARATION, ac.COMPTE_RENDU as COMPTE_RENDU, NOM,
              CONCAT(CONVERT(VARCHAR(10),DTE_PREV,105), ' ', CONVERT(VARCHAR(5),DTE_PREV,108)) as DTE_PREV, /*FORMAT DE SORTIE DD/MM/YYYY HH:MM*/
              CONCAT(CONVERT(VARCHAR(10),DTE_REAL,105), ' ', CONVERT(VARCHAR(5),DTE_REAL,108)) as DTE_REAL
              FROM CLIENTS c
              INNER JOIN ACTIONCRM ac ON ac.CDE_CLI = c.CDE_CLI
              INNER JOIN CLIENTSMARCHE Cm ON c.CDE_CLI = cm.CDE_CLI
              INNER JOIN PROFIL p ON p.CDE_PROFIL = cm.CDE_PROFIL
              LEFT OUTER JOIN TABLES t ON T.NUM_TABLE= 1 and t.CDE_TABLE=ac.OBJET
              LEFT OUTER JOIN TABLES t2 ON T2.NUM_TABLE= 2 and t2.CDE_TABLE=ac.PRIORITE
			        LEFT OUTER JOIN TABLES t3 ON T3.NUM_TABLE= 3 and t3.CDE_TABLE=ac.NATURE
              LEFT OUTER JOIN TABLES t4 ON T4.NUM_TABLE= 4 and t4.CDE_TABLE=ac.ORIGINE
              LEFT OUTER JOIN TABLES t5 ON T5.NUM_TABLE= 5 and t5.CDE_TABLE=ac.INTERET
              LEFT OUTER JOIN TABLES t6 ON T6.NUM_TABLE= 6 and t6.CDE_TABLE=ac.STATUT
              WHERE ac.NUM_ACTION=?";
  global $m_bdd;
  $requete = $m_bdd->prepare($req_str);
  $requete->execute(array($numAct,$_SESSION['cde_profil']));
  $result = $requete->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function getCompteRendu()
{
  $req_str = "SELECT COMPTE_RENDU
              FROM ACTIONCRM
              WHERE NUM_ACTION=?";
  global $m_bdd;
  $requete = $m_bdd->prepare($req_str);
  $requete->execute();
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

function getProfils()
{
  $req_str = "SELECT  NOM  FROM ACTIONCRM INNER JOIN PROFIL on ACTIONCRM.CDE_PROFIL=PROFIL.CDE_PROFIL";

  global $m_bdd;
  $requete = $m_bdd->prepare($req_str);
  $requete->execute();
  $result = $requete->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function getNatures()
{
  $req_str = "SELECT *
              FROM TABLES
              WHERE NUM_TABLE='3'";

  global $m_bdd;
  $requete = $m_bdd->prepare($req_str);
  $requete->execute();
  $result = $requete->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function getOrigines()
{
  $req_str = "SELECT *
              FROM TABLES
              WHERE NUM_TABLE='4'";
  global $m_bdd;
  $requete = $m_bdd->prepare($req_str);
  $requete->execute();
  $result = $requete->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function getInterets()
{
  $req_str = "SELECT *
              FROM TABLES
              WHERE NUM_TABLE='5'";
  global $m_bdd;
  $requete = $m_bdd->prepare($req_str);
  $requete->execute();
  $result = $requete->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function getStatus()
{
  $req_str = "SELECT *
              FROM TABLES
              WHERE NUM_TABLE='6'";
  global $m_bdd;
  $requete = $m_bdd->prepare($req_str);
  $requete->execute();
  $result = $requete->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function getInterlocuteurs($numAct)
{
  $req_str = "SELECT CO.*,AC.VU, t.lib_50 as CIVIL FROM ACTIONCRM A
              INNER JOIN ACTIONCONT AC ON A.NUM_ACTION=AC.NUM_ACTION
              INNER JOIN CONTACT CO ON A.CDE_CLI=CO.TIERS AND AC.NUM_CONTAC=CO.NUM_CONTAC AND CO.TYPE_CONTAC=1
              LEFT OUTER JOIN TABLES T ON T.NUM_TABLE = 7  AND T.CDE_TABLE=CO.CIVILITE
              WHERE AC.NUM_ACTION=?
              ORDER BY NOM_CONTAC,PRENOM_CONTAC";
  global $m_bdd;
  $requete = $m_bdd->prepare($req_str);
  $requete->execute(array($numAct));
  $result = $requete->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function getTaches($numAct)
{
  global $m_bdd;
  $req_str = "SELECT *,
              CONVERT(VARCHAR(23), DTE_PREV, 103) as DTE_PREV2,
              CONVERT(VARCHAR(23), DTE_REAL, 103) as DTE_REAL2,
              CASE WHEN DATALENGTH(TACHE)>50 THEN SUBSTRING(TACHE,1,50)+'...' ELSE TACHE END as TACHE2
              FROM ACTIONINST
              WHERE NUM_ACTION=?
              ORDER BY DTE_PREV,RANG";

  $requete = $m_bdd->prepare($req_str);
  $requete->execute(array($numAct));
  $result = $requete->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function getIntervenants()
{
  global $m_bdd;

  $req_str = "SELECT DISTINCT USER_NAME
              FROM UTILISATEUR
              WHERE ISNULL(ETAT,0)=0
              ORDER BY USER_NAME ";

  $requete = $m_bdd->prepare($req_str);
  $requete->execute();
  $result = $requete->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}
////////////////////////////////////////////////////////////
function getFonctions()
{
  global $m_bdd;

  $req_str = "SELECT DISTINCT FONCTION
              FROM CONTACT
              ORDER BY FONCTION ";

  $requete = $m_bdd->prepare($req_str);
  $requete->execute();
  $result = $requete->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}
////////////////////////////////////////////////////////////
function updateRencontre($numAct,$rencontre,$numCont,$typeCont,$tiersCont)
{
  global $m_bdd;
  $requete = $m_bdd->prepare("UPDATE ACTIONCONT
                              SET vu = ?
                              FROM ACTIONCRM AS ac
                              INNER JOIN ACTIONCONT AS a ON ac.NUM_ACTION=a.NUM_ACTION
                              INNER JOIN CONTACT AS c ON c.NUM_CONTAC=a.NUM_CONTAC AND ac.CDE_CLI=c.TIERS
                              WHERE
                              a.NUM_ACTION=?
                              and c.tiers=?
                              and c.TYPE_CONTAC=?
                              and a.NUM_CONTAC=?");
  $requete->execute(array($rencontre,$numAct,$tiersCont,$typeCont,$numCont));
}

function updateDtePrev($numAct,$dte_prev)
{
  global $m_bdd;
  if ($dte_prev=='') {
    $requete = $m_bdd->prepare("UPDATE ACTIONCRM
                                SET DTE_PREV = NULL
                                WHERE
                                NUM_ACTION=?");
    $requete->execute(array($numAct));
  }
  else {
    $requete = $m_bdd->prepare("UPDATE ACTIONCRM
                                SET DTE_PREV = ?
                                WHERE
                                NUM_ACTION=?");
    $requete->execute(array($dte_prev,$numAct));
  }
}

function updateDteReal($numAct,$dte_real)
{
  global $m_bdd;
  if ($dte_real=='') {
  $requete = $m_bdd->prepare("UPDATE ACTIONCRM
                              SET DTE_REAL = NULL
                              WHERE
                              NUM_ACTION=?");
  $requete->execute(array($numAct));
 }
 else {
   $requete = $m_bdd->prepare("UPDATE ACTIONCRM
                               SET DTE_REAL = ?
                               WHERE
                               NUM_ACTION=?");
   $requete->execute(array($dte_real,$numAct));
  }
}

function updateEcheance($numAct,$echeance)
{
  global $m_bdd;
  if ($echeance=='') {
    $requete = $m_bdd->prepare("UPDATE ACTIONCRM
                                SET DTE_SIGN = NULL
                                WHERE
                                NUM_ACTION=?");
    $requete->execute(array($numAct));
  }
  else {
    $requete = $m_bdd->prepare("UPDATE ACTIONCRM
                                SET DTE_SIGN = convert(datetime,convert(date,?))
                                WHERE
                                NUM_ACTION=?");
    $requete->execute(array($echeance,$numAct));
  }
}

function updateNature($numAct,$nature){
  global $m_bdd;
  $requete = $m_bdd->prepare("UPDATE ACTIONCRM
                              SET NATURE = ?
                              WHERE
                              NUM_ACTION=?");

  $requete->execute(array($nature,$numAct));
}

function updateOrigine($numAct,$origine){
  global $m_bdd;
  $requete = $m_bdd->prepare("UPDATE ACTIONCRM
                              SET ORIGINE = ?
                              WHERE
                              NUM_ACTION=?");

  $requete->execute(array($origine,$numAct));
}

function updateInteret($numAct,$interet)
{
  global $m_bdd;
  $requete = $m_bdd->prepare("UPDATE ACTIONCRM
                              SET INTERET = ?
                              WHERE
                              NUM_ACTION=?");

  $requete->execute(array($interet,$numAct));
}

function updateStatut($numAct,$statut)
{
  global $m_bdd;
  $requete = $m_bdd->prepare("UPDATE ACTIONCRM
                              SET STATUT = ?
                              WHERE
                              NUM_ACTION=?");

  $requete->execute(array($statut,$numAct));
}

function updateCA($numAct,$NUM_AFFAIRE)
{
  global $m_bdd;
  $requete = $m_bdd->prepare("UPDATE ACTIONCRM
                              SET NUM_AFFAIRE = ?
                              WHERE
                              NUM_ACTION=?");

  $requete->execute(array($NUM_AFFAIRE,$numAct));
}

function updatePrep($numAct,$prep)
{
  global $m_bdd;
  $requete = $m_bdd->prepare("UPDATE ACTIONCRM
                              SET TEXTE = ?
                              WHERE
                              NUM_ACTION=?");

  $requete->execute(array($prep,$numAct));
}

function updateCpteRendu($numAct,$compte_rendu)
{
  global $m_bdd;
  $requete = $m_bdd->prepare("UPDATE ACTIONCRM
                              SET COMPTE_RENDU = ?
                              WHERE
                              NUM_ACTION=?");

  $requete->execute(array($compte_rendu,$numAct));
}

function updateTache($numAct,$tache,$rang)
{
  global $m_bdd;
  $requete = $m_bdd->prepare("UPDATE ACTIONINST
                              SET TACHE = ?
                              WHERE
                              NUM_ACTION=?
                              and RANG=?");

  $requete->execute(array($tache,$numAct,$rang));
}

function updateRessource($numAct,$ressource,$rang)
{
  global $m_bdd;
  $requete = $m_bdd->prepare("UPDATE ACTIONINST
                              SET RESSOURCE = ?
                              WHERE
                              NUM_ACTION=?
                              and RANG=?");

  $requete->execute(array($ressource,$numAct,$rang));
}

function updateObservation($numAct,$observation,$rang)
{
  global $m_bdd;
  $requete = $m_bdd->prepare("UPDATE ACTIONINST
                              SET TEXTE = ?
                              WHERE
                              NUM_ACTION=?
                              and RANG=?");

  $requete->execute(array($observation,$numAct,$rang));
}

function updateDtePrev_tache($numAct,$dte_prev_tache,$rang)
{
  global $m_bdd;
  $requete = $m_bdd->prepare("UPDATE ACTIONINST
                              SET DTE_PREV = ?
                              WHERE
                              NUM_ACTION=?
                              and RANG=?");

  $requete->execute(array($dte_prev_tache,$numAct,$rang));
}

function updateDteReal_tache($numAct,$dte_real_tache,$rang)
{
  global $m_bdd;
  $requete = $m_bdd->prepare("UPDATE ACTIONINST
                              SET DTE_REAL = ?
                              WHERE
                              NUM_ACTION=?
                              and RANG=?");

  $requete->execute(array($dte_real_tache,$numAct,$rang));
}


function insertTache($numAct,$intervenant,$tache,$date_prev,$date_real,$observation)
{
  global $m_bdd;
  $rangTemp = getMaxACTIONINST($numAct);
  $rang = $rangTemp['RANG']+1;

  if ($date_prev<>'' and $date_real<>'') {
    $requete = $m_bdd->prepare("INSERT INTO ACTIONINST(NUM_ACTION, RANG, RESSOURCE, TACHE, DTE_PREV, DTE_REAL, TEXTE)
                                VALUES(?,?,?,?,?,?,?)
                                IF ((SELECT @@ERROR) = 0)
                                select 1
                                ELSE
                                select 2");
    $resultat = $requete->execute(array($numAct, $rang, $intervenant, $tache, $date_prev, $date_real,$observation,$numAct));
  }
  else if ($date_real=='') {
    $requete = $m_bdd->prepare("INSERT INTO ACTIONINST(NUM_ACTION, RANG, RESSOURCE, TACHE, DTE_PREV, DTE_REAL, TEXTE)
                                VALUES(?,?,?,?,?,NULL,?)
                                IF ((SELECT @@ERROR) = 0)
                                select 1
                                ELSE
                                select 2");
    $resultat = $requete->execute(array($numAct, $rang, $intervenant, $tache, $date_prev, $observation, $numAct));
  }
  return $resultat;
}

function getMaxACTIONINST($numAct)
{
  global $m_bdd;

  $req_str = "SELECT MAX(RANG) as RANG  from ACTIONINST where NUM_ACTION=?";

  $requete = $m_bdd->prepare($req_str);
  $requete->execute(array($numAct));
  $result = $requete->fetchAll(PDO::FETCH_ASSOC);
  return $result[0];
}


function insertInterlocuteur($type,$tiersCont,$nom,$fonction,$telFixe,$telPortable,$fax,$email,$internet,$adr0,$adr1,$adr2,$adr3,$cp,$pays,$civilite,$prenom,$date_creat,$date_MAJ,$inactif)
{
  global $m_bdd;
  $num_contacTemp=getMaxCONTACT($tiersCont);
  $num_contac = $num_contacTemp['NUM_CONTAC']+1;

  $requete = $m_bdd->prepare("INSERT INTO CONTACT(NUM_CONTAC, TYPE_CONTAC, TIERS, NOM_CONTAC, FONCTION, TELEPHONE, MOBILE, FAX, E_MAIL, INTERNET, ADR_0, 
                                          ADR_1, ADR_2, ADR_3, CODE_POSTAL, PAYS, CIVILITE, PRENOM_CONTAC, DTE_CREAT, DTE_MAJ, INACTIF)
                              VALUES(?,'1',?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, DATEDIFF (dd,'30/12/1899',GETDATE()), DATEDIFF (dd,'30/12/1899',GETDATE()),'0')");

echo "$num_contac $tiersCont $nom $fonction $telFixe $telPortable $fax $email $internet $adr0 $adr1 $adr2 $adr3 $cp $pays $civilite $prenom $date_creat $date_MAJ";
  $resultat = $requete->execute(array($num_contac,$tiersCont,$nom,$fonction,$telFixe,$telPortable,$fax,$email,$internet,$adr0,$adr1,$adr2,$adr3,$cp,$pays,$civilite,$prenom,$date_creat,$date_MAJ));
  return $resultat;
}

function getMaxCONTACT($tiersCont)
{
  global $m_bdd;

  $req_str = "SELECT MAX(NUM_CONTAC) as NUM_CONTAC  from CONTACT where TIERS=?";

  $requete = $m_bdd->prepare($req_str);
  $requete->execute(array($tiersCont));
  $result = $requete->fetchAll(PDO::FETCH_ASSOC);
  return $result[0];
}


function deleteTache($numAct,$rang)
{
  global $m_bdd;
  $requete = $m_bdd->prepare("DELETE ACTIONINST where num_action=? and RANG=?");
  $requete->execute(array($numAct,$rang));
}

function removeInterlocuteur($numAct,$num_contac)
{
  global $m_bdd;
  $requete = $m_bdd->prepare("DELETE ACTIONCONT where NUM_ACTION=? and NUM_CONTAC=?");
  $requete->execute(array($numAct,$num_contac));
}

function recupListeInterlocuteursPotentiel($numAct,$tiers)
{
  global $m_bdd;

  $req_str = "SELECT *, t.lib_50 as CIVIL,
              CONCAT(t.lib_50+' ',PRENOM_CONTAC+' ',NOM_CONTAC) as INTERLOCUTEUR
              FROM CONTACT CO
              LEFT OUTER JOIN TABLES T ON T.NUM_TABLE = 7  AND T.CDE_TABLE=CO.CIVILITE
              WHERE  CO.TIERS=? AND CO.TYPE_CONTAC=1
              AND ISNULL(CO.INACTIF,0)=0 AND CO.NUM_CONTAC NOT IN (SELECT AC.NUM_CONTAC FROM ACTIONCRM A
              INNER JOIN ACTIONCONT AC ON A.NUM_ACTION=AC.NUM_ACTION
              INNER JOIN CONTACT CO ON A.CDE_CLI=CO.TIERS AND AC.NUM_CONTAC=CO.NUM_CONTAC AND CO.TYPE_CONTAC=1
              WHERE AC.NUM_ACTION=?) ORDER BY NOM_CONTAC,PRENOM_CONTAC";

  $requete = $m_bdd->prepare($req_str);
  $requete->execute(array($tiers,$numAct));
  $result = $requete->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function insertInterlocuteurs($numAct,$listeInterlocuteurs)
{
  global $m_bdd;

  for ($i=0; $i <sizeof($listeInterlocuteurs) ; $i++) {
    $requete = $m_bdd->prepare("INSERT INTO ACTIONCONT (NUM_ACTION, NUM_CONTAC, VU) VALUES(?,?,0)");
    $resultat = $requete->execute(array($numAct, $listeInterlocuteurs[$i]['NUM_CONTAC']));
  }
}

function save_image($file_path_final, $action,$name)
{
  global $m_bdd;

  $max_ID=getMaxImgID();

  $requete = $m_bdd->prepare("INSERT INTO IMAGES (IMAGE_ID,IMAGE_NAME,IMAGE_LINK) VALUES(?,?,?)");
  $resultat = $requete->execute(array($max_ID,$name,$file_path_final));

  $requete = $m_bdd->prepare("INSERT INTO ACTIONIMAGES (IMAGE_ID,NUM_ACTION) VALUES(?,?)");
  $resultat = $requete->execute(array($max_ID,$action));
}


function getMaxImgID()
{
  global $m_bdd;
  $requete = $m_bdd->prepare("SELECT MAX(IMAGE_ID) as max from IMAGES");
  $requete->execute();
  $resultat = $requete -> fetch(PDO::FETCH_ASSOC);
  return $resultat['max']+1;
}

function getFilesList($action)
{
  global $m_bdd;
  $requete = $m_bdd->prepare("SELECT * from IMAGES I
                              INNER JOIN ACTIONIMAGES ac on ac.IMAGE_ID=I.IMAGE_ID
                              where NUM_ACTION=? ");
  $requete->execute(array($action));
  $result = $requete->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

function removeImg($file_path,$action) {
  global $m_bdd;

  $requete = $m_bdd->prepare("SELECT IMAGE_ID as max from IMAGES where IMAGE_LINK+IMAGE_NAME=?");
  $requete->execute(array($file_path));
  $resultat = $requete -> fetch(PDO::FETCH_ASSOC);
  $img_id= $resultat['max'];

  $requete = $m_bdd->prepare("DELETE IMAGES
                WHERE IMAGE_LINK+IMAGE_NAME=?");
  $requete->execute(array($file_path));

  $requete = $m_bdd->prepare("DELETE FROM ACTIONIMAGES
                WHERE NUM_ACTION = ?
                AND IMAGE_ID=?");
  $requete->execute(array($action,$img_id));
}
?>