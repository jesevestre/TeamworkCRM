<!DOCTYPE html>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../view/css/style.css">
    <script type="text/javascript" src="../js/vue.js"></script>
    <title>Squalp CRM</title>
  </head>
  <body>
    <div class="app " id="app" v-cloak>
      <div class="fab-container">
        <el-button class="addbtn" type="danger" icon="el-icon-plus" @click="dialogFormActionVisible=true" circle></el-button>
      </div>

      <el-dialog title="Ajout d'une action" :visible.sync="dialogFormActionVisible" style="width:100%;" class="dialogAjout">

      <form class="" action="action.php" method="post" id='formAjoutAction'>
        <el-row style="margin-top:15px">
          <el-col :span="4" class="ColonneGauche"> Client : </el-col>
          <el-col :span="9" class="ColDroiteDialogTache ">
            <el-select placeholder="Veuillez saisir un client" v-model='dialogAction.client' id='selectClient' size='mini' name='client' filterable>
              <el-option :key='null' :label='null' :value='null' ></el-option>
               <el-option
                v-for="item in optionsNom_Cli"
                :key="item.CDE_CLI"
                :label="item.LABEL"
                :value="item.CDE_CLI">
              </el-option>
            </el-select>
          </el-col>
        </el-row>
        <br />
        <el-row style="margin-top:15px">
          <el-col :span="4" class="ColonneGauche"> Objet : </el-col>
          <el-col :span="9" class="ColDroiteDialogTache ">
            <el-select placeholder="Veuillez saisir un objet" v-model='dialogAction.objet' id='selectObjet' size='mini' name='objet' filterable>
              <el-option :key='null' :label='null' :value='null' ></el-option>
               <el-option
                v-for="item in optionsObjet"
                :key="item.CDE_TABLE"
                :label="item.LIB_50"
                :value="item.CDE_TABLE">
              </el-option>
            </el-select>
          </el-col>
        </el-row>
        <br />
        <el-row style="margin-top:15px">
          <el-col :span="4" class="ColonneGauche"> Priorité : </el-col>
          <el-col :span= "9" class="ColDroiteDialogTache ">
            <el-select placeholder="Veuillez saisir une priorité" v-model='dialogAction.priorite' id='selectPriorite' size='mini' name='priorite' filterable>
              <el-option :key='null' :label='null' :value='null' ></el-option>
               <el-option
                v-for="item in optionsPriorite"
                :key="item.CDE_TABLE"
                :label="item.LIB_50"
                :value="item.CDE_TABLE">
              </el-option>
            </el-select>
          </el-col>
        </el-row>

        <el-row style="margin-top:15px" hidden>
          <el-col :span="4" class="ColonneGauche">
            <span>
              Créée le : 
            </span>
          </el-col>
          <el-col :span="17" style="text-align:left">
            <el-date-picker
              size='mini'
              class="dateAction selectColDroite"
              type="date"
              placeholder="Date"
              id='dialogDate_creat'
              v-model='dialogAction.date_creat'
              format="dd-MM-yyyy">
            </el-date-picker>
          </el-col>
        </el-row>
        <br />
        <el-row style="margin-top:15px">
          <el-col :span="4" class="ColonneGauche">
            <span>
              Prévue le : 
            </span>          
          </el-col>
          <el-col :span="17" style="text-align:left">
            <el-date-picker
              size='mini'
              class="dateAction selectColDroite"
              type="datetime"
              placeholder="Date et heure"
              id='dialogDate_prev'
              v-model='dialogAction.date_prev'
              name='date_prev'
              format="dd-MM-yyyy HH:mm"
              @change=''>
              </el-date-picker>
          </el-col>
        </el-row>
        <br />
       
        <div  class="dialog-footer">
          <el-button @click="dialogFormActionVisible = false" size='mini'>Retour</el-button>
          <el-button type="primary" @click="handleEnregistrementAction" size='mini'>Enregistrer</el-button>
        </div>
      </form>


      </el-dialog>
      <div class="table-container">
        <el-input
          v-model="search"
          placeholder="Rechercher"
          prefix-icon="custom-icon el-icon-search"
          class="barreDeRecherche">
        </el-input>
              <!-- ORIGINE et PRIORITE SUPPRIME DE LA LISTE RECHERCHE, CAR FAIT TOUT BUGUER -->
        <el-table 
         :data="tableData.filter(data => !search ||
          data.CDE_CLI.toLowerCase().includes(search.toLowerCase()) ||
          data.NOM_CLI.toLowerCase().includes(search.toLowerCase()) ||
          data.NUM_ACTION.toLowerCase().includes(search.toLowerCase()) ||
          data.OBJET.toLowerCase().includes(search.toLowerCase()) ||
          data.DTE_PREV.toLowerCase().includes(search.toLowerCase()) ||
          data.DTE_REAL.toLowerCase().includes(search.toLowerCase())) ||
          data.ETAT.toLowerCase().includes(search.toLowerCase()) ||
          data.STATUT.toLowerCase().includes(search.toLowerCase()) ||
          data.NATURE.toLowerCase().includes(search.toLowerCase()) ||
          data.INTERET.toLowerCase().includes(search.toLowerCase()) ||
          data.NUM_AFFAIRE.toLowerCase().includes(search.toLowerCase())"
          style="width: 100%"
          stripe
          height=95%
          class="tableCenter"
          
          empty-text="Aucun résultat !">
          <el-table-column
            align="left"
            fixed="left"
            width=90px;>
          <template slot-scope="scope">

             <el-popover
             placement="top-start"
             width="70"
             trigger="hover"
             content="Voir l'action"
             popper-class="popperBtn">
              <el-button
                 slot="reference"
                 size="mini "
                 circle
                 @click='handleBtnDetail(scope.row)'
                 class="circleButtons"
                 icon="el-icon-document">
               </el-button>
             </el-popover>

              <el-popover
              placement="top-start"
              width="70"
              trigger="hover"
              content="Localiser"
              popper-class="popperBtn">
                <el-button 
                  slot="reference"
                  icon="el-icon-location-outline"
                  class="circleButtons"
                  @click="handleLocation(scope.$index, scope.row)"
                  size="mini"
                  circle>
                </el-button>
              </el-popover>

            </template>
         </el-table-column>

            <!-- VUE DE SUIVI DES ACTIONS -->
         <el-table-column
           prop="CDE_CLI"
           label="Code client"
           width="110"
           text-align= "center"
           sortable>
         </el-table-column>
         <el-table-column
           prop="NOM_CLI"
           label="Nom client"
           width="230"
           sortable>
         </el-table-column>
         <el-table-column
           prop="NUM_ACTION"
           label="Action"
           width="85"
           sortable>
         </el-table-column>
         <el-table-column
           prop="OBJET"
           label="Objet"
           width="185"
           sortable>
         </el-table-column>
         <el-table-column
           prop="ORIGINE"
           label="Origine"
           width="185"
           sortable>
         </el-table-column>
         <el-table-column
           prop="PRIORITE"
           label="Priorité"
           width="87"
           sortable>
         </el-table-column>
         <!--<el-table-column
           prop="DTE_CREAT"
           label="Créée le"
           width="90"
           sortable>
         </el-table-column>-->
         <el-table-column
           prop="DTE_PREV"
           label="Prévue le"
           width="115"
           sortable>
         </el-table-column>
         <el-table-column
           prop="DTE_REAL"
           label="Réalisée le"
           width="115"
           sortable>
         </el-table-column>
         <el-table-column
           prop="ETAT"
           label="Etat"
           width="70"
           sortable>
         </el-table-column>
         <el-table-column
           prop="STATUT"
           label="Statut"
           width="125"
           sortable>
         </el-table-column>
         <el-table-column
           prop="NATURE"
           label="Nature"
           width="98"
           sortable>
         </el-table-column>
         <el-table-column
           prop="INTERET"
           label="Intérêt"
           width="90"
           sortable>
         </el-table-column>
         <el-table-column
           prop="NUM_AFFAIRE"
           label="CA en €"
           width="90"
           sortable>
         </el-table-column>
       </el-table>
      </div>
    </div>
  </body>

                                                       <!-- PARTIE JAVASCRIPT Vue.js -->
<!-- __________________________________________________________________  __________________________________________________________________ -->
<!-- __________________________________________________________________  __________________________________________________________________ -->
<!-- __________________________________________________________________  __________________________________________________________________ -->
<!-- __________________________________________________________________ __________________________________________________________________ -->
<!-- __________________________________________________________________  __________________________________________________________________ -->
<!-- __________________________________________________________________ __________________________________________________________________ -->


<?php // TODO: Gérer l'inclusion via les fichiers pour l'installation ?>
  <!-- <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css"> -->
  <link rel="stylesheet" type="text/css" href="../view/css/theme/element-ui.css">
  <script src="../js/element-ui.js"></script>
  <script src="../js/element-ui-fr.js"></script>
  <script>
    ELEMENT.locale(ELEMENT.lang.fr)
  </script>
  <script type="text/javascript">

  new Vue({
    data: {
      tableData: <?php echo json_encode($listeActions);?>,
      search:'',
      dialogFormActionVisible:false,
      dialogAction :{
        cde_cli: '',
        client: '',
        objet: '',
        priorite: '',
        date_creat: new Date(),
        date_real: '',
      },
      optionsNom_Cli:<?php echo json_encode($optionsNom_Cli);?>,
      optionsPriorite: <?php echo(json_encode($optionsPriorite)); ?>,
      optionsObjet: <?php echo(json_encode($optionsObjet)); ?>,
    },
    mounted() {


    },
    methods: {
      handleLocation(index, row) {
				window.location.href='https://maps.google.com/?q='+row.ADRESSE_COMPLETE_ACTION.replace(/[ ()]/g,'+');
			},
       handleBtnDetail(row){
        window.location.href = "../controller/action.php?num_act="+row.NUM_ACTION;
      },

      verifChampsTache(){
        var complet=0;
        if ($('#selectClient').val()=='') {
          complet=1;
          this.$alert('Veuillez saisir un client', 'Erreur', {
            confirmButtonText: 'OK'
          });
        }
        else if ($('#selectObjet').val()=='') {
          complet=1;
          this.$alert('Veuillez saisir un objet', 'Erreur', {
            confirmButtonText: 'OK'
          });
        }
        else if ($('#selectPriorite').val()=='') {
          complet=1;
          this.$alert('Veuillez saisir une priorité', 'Erreur', {
            confirmButtonText: 'OK'
          });
        }
        else if ($('#dialogDate_creat').val()=='') {
          complet=1;
          this.$alert('Veuillez saisir une date de création', 'Erreur', {
            confirmButtonText: 'OK'
          });
        }
        else if ($('#dialogDate_prev').val()=='') {
          complet=1;
          this.$alert('Veuillez saisir une date prévue', 'Erreur', {
            confirmButtonText: 'OK'
          });
        }
        return complet;
      },

      handleEnregistrementAction(){
        var complet = this.verifChampsTache();
        if (complet==0) {
          var date_creat = moment(document.getElementById('dialogDate_creat').value, "DD-MM-YYYY").format("YYYY-MM-DD hh:mm:ss.S");
          var date_prev = moment(document.getElementById('dialogDate_prev').value, "DD-MM-YYYY HH:mm").format("YYYY-MM-DD hh:mm:ss.S");
          var request = $.ajax({
  					url: "../controller/suivi_actions.php",
  					async: false,
  					type: "POST",
            data: {
              'insertAction' : 1,
              'client': this.dialogAction.client,
              'objet':this.dialogAction.objet,
              'priorite':this.dialogAction.priorite,
              'date_creat':date_creat.replace(" ", "T"),
              'date_prev':date_prev.replace(" ", "T")
            },
  					dataType: "json",
            success: function(data){
              window.location.href = "../controller/action.php?num_act="+data;
        		}
  				});
        }
      }
      
    }
  }).$mount('#app');
  </script>
</html>