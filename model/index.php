<?php

include_once(dirname(__DIR__).'/settings.php');
include_once(dirname(__DIR__).'/m_bdd.php');

function check_user($user_name)
{
  global $m_bdd;

  $requete = $m_bdd->prepare('SELECT upper(u.cde_profil) as user_name, u.nom, u.prenom, u.superviseur, u.civilite, u.email
                FROM PROFIL u
                WHERE upper(u.cde_profil) = ?');
  $requete->execute(array($user_name));
  $result = $requete->fetchAll(PDO::FETCH_ASSOC);

  if(count($result) == 1)
  {
    return $result;
  }
  else
  {
    return null;
  }
}


function check_motdepasse($user_name, $mdp)
{
  global $m_bdd;
  $requete = $m_bdd->prepare('SELECT upper(u.cde_profil) as user_name, u.nom, u.prenom, u.superviseur, u.civilite, u.email
                FROM PROFIL u
                WHERE upper(u.cde_profil) = ? AND password = ?');
  $requete->execute(array($user_name, $mdp));
  $result = $requete->fetchAll(PDO::FETCH_ASSOC);

  if(count($result) == 1)
  {
    return $result;
  }
  else
  {
    return null;
  }
}


?>
