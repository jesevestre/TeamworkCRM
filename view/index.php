<!DOCTYPE html>

<?php
// include_once(dirname(__DIR__).'/m_bdd.php');
include_once('head.php');

?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../view/css/index.css">
    <script type="text/javascript" src="../js/vue.js"></script>
    <title>Squalp CRM</title>
  </head>
  <body>

    <div id="app">
      <form class="login-form" id="login-form" action="../controller/index.php" method="post">
        <h1>Connexion CRM</h1>

        <?php if (isset($message_erreur) and $message_erreur != "") {
  				echo '<div id="message" class="alert-danger">'.$message_erreur.'</div>';
  			} ?>
        
        <div class="txtb" id='user'>
          <input v-model="login" name='identifiant' autocomplete="new-password">
          <span data-placeholder="Utilisateur"></span>
        </div>

        <div class="txtb">
          <input v-model="password" type='password' name='mdp' autocomplete="new-password">
          <span data-placeholder="Mot de passe"></span>
        </div>

        <input type="submit" class="logbtn" name="" value="Se connecter"></input>

      </form>

    </div>
  </body>

                                                          <!-- PARTIE VUE.JS -->
<!-- __________________________________________________________________  __________________________________________________________________ -->
<!-- __________________________________________________________________  __________________________________________________________________ -->
<!-- __________________________________________________________________  __________________________________________________________________ -->
<!-- __________________________________________________________________ __________________________________________________________________ -->
<!-- __________________________________________________________________  __________________________________________________________________ -->
<!-- __________________________________________________________________ __________________________________________________________________ -->


<?php // TODO: Gérer l'inclusion via les fichiers pour l'installation ?>
  <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
  <script src="https://unpkg.com/element-ui/lib/index.js"></script>
  <script type="text/javascript">
    function checkWindowSize() {
        if ( $(window).height() < 450 ) {
            $('#login-form').addClass('small');
        }
        else {
            $('#login-form').removeClass('small');
        }
    }

    $(window).resize(checkWindowSize);
  </script>
  <script type="text/javascript">

  new Vue({
    data: {
      login:'',
      password:'',
    },
    mounted(){
      checkWindowSize();
    }
  }).$mount('#app');
  </script>

  <script type="text/javascript">


  $(".txtb input").on("focus",function(event) {
    $(this).addClass('focus');
  });

  $('.txtb input').on("blur",function() {
    if(this.value==''){
      $(this).removeClass('focus');
    }
  });
</script>
</html>
