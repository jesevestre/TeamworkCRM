<?php
// include_once(dirname(__DIR__).'/m_bdd.php');
include_once('head.php');

?>
<link rel="stylesheet" type="text/css" href="../view/css/style.css">
<link href="../view/css/style_menu.css?<?php echo date("YmdHis");?>" rel="stylesheet" type="text/css"/>

<script type="text/javascript" src="../js/script_menu.js?<?php echo date("YmdHis");?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<div  id='cssmenu'>

  <div id="header-title"><h1 class="titleEntete"><?php echo $_SESSION['title-page']; ?></h1></div>
  <div id="mySidenav" class="sidenav">
    <div  class="profile">

      <a href="javascript:void(0)" class="closebtn">&times;</a>
      <p class="texteprofile">
      <?php echo $_SESSION['nom']; if($_SESSION['prenom'] != '') echo " ".$_SESSION['prenom']; ?>
      </p>
    </div>
    <div class="links">
      <a href="../controller/suivi_actions.php">Suivi des actions</a>
      <a href="../controller/Suivi_Clients.php">Suivi des clients</a>
      <a href="../controller/logout.php" >Quitter</a>
    </div>
  </div>
</div>