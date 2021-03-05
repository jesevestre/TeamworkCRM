<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../view/css/style.css">
    <script type="text/javascript" src="../js/vue.js"></script>
    <!--<script src="//unpkg.com/vue/dist/vue.js"></script>
    <script src="//unpkg.com/element-ui@2.15.0/lib/index.js"></script>-->
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    
    <!-- <script src="https://cdn.tiny.cloud/1/jbeyjdcnqogw3d6xr65emop664fk1msl2fthsed88zhrbikc/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    Ne fonctionne pas car ne reconnait pas LOCALHOST:8080. Uns fois le site mis sur un ébergeur privé, changer sur https://www.tiny.cloud/my-account/domains/ 
    et vérifier le fichier hosts dans C:\Windows\System32\drivers\etc -->
    <script>

    tinymce.init({
      selector: '#inputCommentPrep',
      setup: function (ed) {
        ed.on("blur", function (event) {
          //console.log(location.search.split('num_act=')[1])
          var textprep = encodeURI(ed.getContent())
          var request = $.ajax({
            url: "../controller/action.php",
            async: false,
            type: "POST",
            data: {'update' : 1,'numAct':location.search.split('num_act=')[1],'preparation':textprep},
            dataType: "html",
          });
        })
      }
    });

    tinymce.init({
      selector: '#inputCommentCompteRend',
      setup: function (ed) {
        ed.on("blur", function (event) {
          //console.log(location.search.split('num_act=')[1])
          var textprep = encodeURI(ed.getContent())
          var request = $.ajax({
            url: "../controller/action.php",
            async: false,
            type: "POST",
            data: {'update' : 1,'numAct':location.search.split('num_act=')[1],'compte_rendu':textprep},
            dataType: "html",
          });
        })
      }
    });
    </script>

    <title>Squalp CRM</title>
  </head>
  <body>
    <div class="app apact" id="app" v-cloak>
      <el-tabs v-model="activeName" :tab-position="tabPosition">

          <!--                                      Onglet 1                                         -->
          <!-- ///////////////////////////////////////////////////////////////////////////////////// -->
          <!-- ///////////////////////////////////////////////////////////////////////////////////// -->
          <!-- ///////////////////////////////////////////////////////////////////////////////////// -->
          <el-tab-pane label="Détail" name="detail">
            <el-card class="box-card BoxDetail" >
              <!-- Header -->
              <div slot="header" class="clearfix headerAction">
                <span class="numAct">Action {{numAct}}</span>
                <span v-if="action['ETAT']=='EC'" class="boldy etat" ><el-tag size="mini">{{etat}}</el-tag></span>
                <span v-if="action['ETAT']=='CL'" class="boldy etat" ><el-tag size="mini">{{etat}}</el-tag></span>
              </div>
              <div class="bodyCard">
                <el-row class="ligneAct">
    							<el-col class="ColonneGauche" :span="4">
    							<span >
    								Client
    							</span>
    							</el-col>
    							<el-col  :span="3">
                    <el-select 
                    v-model="nom_cli" 
                    size='mini' 
                    placeholder="" 
                    class="selectColDroite2"
                    <?php if (isset($action)) {
                      echo "disabled";
                    } ?>>
                      <el-option :key='null' :label='null' :value='null' ></el-option>
                      <el-option
                        v-for="item in optionsNom_Cli"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value">
                      </el-option>
                    </el-select>
    							</el-col>
    						</el-row>
                <br />
                <el-row class="ligneAct">
    							<el-col class="ColonneGauche" :span="4">
    							<span >
    								Commercial
    							</span>
    							</el-col>
    							<el-col  :span="3">
                    <el-select 
                    v-model="nom_com" 
                    size='mini' 
                    placeholder="" 
                    class="selectColDroite2"
                    <?php if (isset($action)) {
                      echo "disabled";
                    } ?>>
                    </el-select>
    							</el-col>
    						</el-row>
                <br />
                <el-row class="ligneAct">
    							<el-col class="ColonneGauche" :span="4">
    							<span >
    								Objet
    							</span>
    							</el-col>
    							<el-col  :span="3">
                    <el-select 
                    v-model="objet" 
                    size='mini' 
                    placeholder="" 
                    class="selectColDroite2"
                    <?php if (isset($action)) {
                      echo "disabled";
                    } ?>>
                      <el-option :key='null' :label='null' :value='null' ></el-option>
                      <el-option
                        v-for="item in optionsObjet"
                        :key="item.LIB_50"
                        :label="item.LIB_50"
                        :value="item.CDE_TABLE">
                      </el-option>
                    </el-select>
    							</el-col>
    						</el-row>
                <br />
                <el-row class="ligneAct">
    							<el-col class="ColonneGauche" :span="4">
    							<span>
    								Priorité
    							</span>
    							</el-col>
    							<el-col  :span="3">
                    <el-select 
                    v-model="priorite" 
                    size='mini' 
                    placeholder="" 
                    class="selectColDroite2"
                    <?php if (isset($action)) {
                      echo "disabled";
                    } ?>>
                    <el-option :key='null' :label='null' :value='null' ></el-option>
                      <el-option
                        v-for="item in optionsPriorite"
                        :key="item.LIB_50"
                        :label="item.LIB_50"
                        :value="item.CDE_TABLE">
                      </el-option>
                    </el-select>
    							</el-col>
    						</el-row>
                <br />
                <el-row class="ligneAct">
    							<el-col class="ColonneGauche" :span="4">
    							<span>
    								Créée le
    							</span>
    							</el-col>
    							<el-col  :span="3">
                    <el-date-picker
                      size='mini'
                      class="selectColDroite"
                      v-model="dte_creat"
                      type="date"
                      placeholder="Date"
                      value-format="yyyy-MM-dd"
                      format="dd-MM-yyyy"
                      <?php if (isset($action)) {
                        echo "disabled";
                      } ?>>
                    </el-date-picker>
    							</el-col>
                </el-row>
                
                <br />
                <el-row class="ligneAct">
                  <el-col class="ColonneGauche" :span="4">
                  <span>
                    Prévue le
                  </span>
                  </el-col>
                  <el-col  :span="3">
                    <el-date-picker
                      size='mini'
                      v-model="dte_prev"
                      id='detail_dte_prev'
                      class="selectColDroite"
                      type="datetime"
                      placeholder="Date et heure"
                      value-format="dd-MM-yyyy HH:mm"
                      format="dd-MM-yyyy HH:mm"
                      @change='handleDtePrev'
                      @blur='handleblurDtePrev'>
                    </el-date-picker>
                  </el-col>
                </el-row>
                <br />
                <el-row class="ligneAct">
                  <el-col class="ColonneGauche" :span="4">
                    <span>
                      Réalisée le
                    </span>
                  </el-col>
                  <el-col  :span="3">
                    <el-date-picker
                      size='mini'
                      v-model="dte_real"
                      id='detail_dte_real'
                      class="selectColDroite"
                      type="datetime"
                      placeholder="Date et heure"
                      value-format="dd-MM-yyyy HH:mm"
                      format="dd-MM-yyyy HH:mm"
                      @change='handleDteReal'
                      @blur='handleblurDteReal'>
                    </el-date-picker>
                  </el-col>
                </el-row>
                <br />

                <!-- BOUTON AJOUT INTERLOCUTEURS DANS ACTION -->
                <!--   ///////////////////////////////////   -->
                <!--   ///////////////////////////////////   -->
                <!--   ///////////////////////////////////   -->

                <el-row class="ligneAct">
                  <el-col class="ColonneGauche" :span="5">
                    <span>
                      Interlocuteurs
                    </span>
                  </el-col>
                </el-row>

                <el-card class="box-card BoxDetail" >
                <div class="bodyCard">

                <el-dialog title="Ajout d'interlocuteurs" :visible.sync="dialogFormInterlocuteurVisible" style="width:100%;" @close='handleClose' class="dialogAjout">
                    <el-table
                      ref='tableInterlocuteur'
                     :data=listeInterlocteursPotentiels
                     height=400
                     stripe
                     @selection-change="handleSelectionChange"
                     class="tableCenter"
                     empty-text="Aucun résultat !">

                     <el-table-column
                        type="selection"
                        header-align='center'
                        align='right'
                        width="45">
                      </el-table-column>

                      <el-table-column
                        prop="INTERLOCUTEUR"
                        label="Interlocuteur"
                        class-name='colDialogInterlocuteur'
                        align='center'
                        min-width="100"
                        >
                      </el-table-column>

                      <el-table-column
                         prop="FONCTION"
                         label="Fonction"
                         min-width="150"
                         >
                      </el-table-column>
                   </el-table>

                  <form class="" action="action.php" method="post" id='formAjoutTache'>
                    <div class="dialog-footer" v-if='listeInterlocteursPotentiels.length>0'>
                      <el-button type="primary" @click="handleEnregistrementInterlocuteurs" size='mini'>Ajouter à l'action</el-button>
                      <el-button @click="dialogFormInterlocuteurVisible = false" size='mini'>Retour</el-button>
                      <el-button style="background-color: #32CD32; color: white" @click="handleAjouterInterlocuteurCollapse" size='mini'>Ajouter à la liste</el-button>
                      <!--<el-button type="danger" @click="SuppressionInterlocuteurs" size='mini'>Supprimer de la liste</el-button>-->
                    </div>
                  </form>
                </el-dialog>


              <!-- AJOUT D'UN INTERLOCUTEUR DANS CONTACT -->
              <!--   /////////////////////////////////   -->
              <!--   /////////////////////////////////   -->
              <!--   /////////////////////////////////   -->

            <div v-if="this.closeable && hasBodySlot">
            </div>
            <el-dialog title="Ajout d'un interlocuteur" :visible.sync="handleAjouterInterlocuteurVisible" style="width:100%;" @close='handleClose1' class="dialogAjout">

              <form class="" action="action.php" method="post" id='formAjoutTache'>
                
                <br />
                <el-row>
                  <el-col :span="4" class="ColonneGauche">
                    Civilité* :
                  </el-col>
                    <el-col :span="17" class="ColDroiteDialogTache">
                      <el-radio-group
                        name='civilite'
                        id='dialogCivilite' 
                        v-model='dialogInterlocuteur.civilite' 
                        size="small">
                        <el-radio label="1" border>Madame</el-radio>
                        <el-radio label="2" border>Monsieur</el-radio>
                      </el-radio-group>
                    </el-select>
                  </el-col>
                </el-row>

                <br />
                <el-row style="margin-top:15px;">
                  <el-col :span="4" class="ColonneGauche">
                    Prénom* : 
                  </el-col>
                  <el-col :span="6" class="ColDroiteDialogTache ">
                    <el-input
                      type="text"
                      name='prenom'
                      id='dialogPrenom'
                      placeholder="Veuillez saisir"
                      rows=4
                      v-model='dialogInterlocuteur.prenom'
                      class="TextareaFont"
                      resize='none'
                      size='mini'
                      show-word-limit>
                    </el-input>
                  </el-col>
                </el-row>

                <br />
                <el-row style="margin-top:15px;">
                  <el-col :span="4" class="ColonneGauche">
                    Nom* : 
                  </el-col>
                  <el-col :span="6" class="ColDroiteDialogTache ">
                    <el-input
                      type="text"
                      name='nom'
                      id='dialogNom'
                      placeholder="Veuillez saisir"
                      rows=4
                      v-model='dialogInterlocuteur.nom'
                      class="TextareaFont"
                      resize='none'
                      size='mini'
                      show-word-limit>
                    </el-input>
                  </el-col>
                </el-row>
                
                <br />
                <el-row style="margin-top:15px;">
                    <el-col :span="4" class="ColonneGauche">
                    Fonction* :
                    </el-col>
                    <el-col :span="6" class="ColDroiteDialogTache ">
                      <el-select 
                        placeholder="Veuillez choisir" 
                        v-model='dialogInterlocuteur.fonction' 
                        id='dialogFonction' 
                        size='mini' 
                        name='fonction'>
                        <el-option :key='null' :label='null' :value='null' ></el-option>
                        <el-option
                          v-for="item in optionsFonction"
                          :key="item.FONCTION"
                          :label="item.FONCTION"
                          :value="item.FONCTION">
                        </el-option>
                      </el-select>
                    </el-col>
                  </el-row>

                <br />
                <el-row style="margin-top:15px;">
                  <el-col :span="4" class="ColonneGauche">
                    Téléphone fixe : 
                  </el-col>
                  <el-col :span="6" class="ColDroiteDialogTache ">
                    <el-input
                      type="text"
                      name='telFixe'
                      id='dialogTelFixe'
                      placeholder="Option de saisie"
                      rows=4
                      v-model='dialogInterlocuteur.telFixe'
                      class="TextareaFont"
                      resize='none'
                      size='mini'
                      show-word-limit>
                    </el-input>
                  </el-col>
                </el-row>

                <br />
                <el-row style="margin-top:15px;">
                  <el-col :span="4" class="ColonneGauche">
                    Téléphone portable : 
                  </el-col>
                  <el-col :span="6" class="ColDroiteDialogTache ">
                    <el-input
                      type="text"
                      name='telPortable'
                      id='dialogTelPortable'
                      placeholder="Option de saisie"
                      rows=4
                      v-model='dialogInterlocuteur.telPortable'
                      class="TextareaFont"
                      resize='none'
                      size='mini'
                      show-word-limit>
                    </el-input>
                  </el-col>
                </el-row>

                <br />
                <el-row style="margin-top:15px;">
                  <el-col :span="4" class="ColonneGauche">
                    Email : 
                  </el-col>
                  <el-col :span="6" class="ColDroiteDialogTache ">
                    <el-input
                      type="email"
                      name='email'
                      id='dialogEmail'
                      placeholder="Option de saisie"
                      rows=4
                      v-model='dialogInterlocuteur.email'
                      class="TextareaFont"
                      resize='none'
                      size='mini'
                      show-word-limit>
                    </el-input>
                  </el-col>
                </el-row>

                <br />
                <el-row style="margin-top:15px;">
                  <el-col :span="4" class="ColonneGauche">
                    Nom de la société rattaché : 
                  </el-col>
                  <el-col :span="10" class="ColDroiteDialogTache ">
                    <el-input
                      type="text"
                      name='adr0'
                      id='dialogAdr0'
                      placeholder="Option de saisie"
                      rows=4
                      v-model='dialogInterlocuteur.adr0'
                      class="TextareaFont"
                      resize='none'
                      size='mini'
                      show-word-limit>
                    </el-input>
                  </el-col>
                </el-row>

                <br />
                <el-row style="margin-top:15px;">
                  <el-col :span="4" class="ColonneGauche">
                    Adresse : 
                  </el-col>
                  <el-col :span="10" class="ColDroiteDialogTache ">
                    <el-input
                      type="text"
                      name='adr1'
                      id='dialogAdr1'
                      placeholder="Option de saisie"
                      rows=4
                      v-model='dialogInterlocuteur.adr1'
                      class="TextareaFont"
                      resize='none'
                      size='mini'
                      show-word-limit>
                    </el-input>
                  </el-col>
                </el-row>

                <br />
                <el-row style="margin-top:15px;">
                  <el-col :span="4" class="ColonneGauche">
                    Complément d'adresse : 
                  </el-col>
                  <el-col :span="10" class="ColDroiteDialogTache ">
                    <el-input
                      type="text"
                      name='adr2'
                      id='dialogAdr2'
                      placeholder="Option de saisie"
                      rows=4
                      v-model='dialogInterlocuteur.adr2'
                      class="TextareaFont"
                      resize='none'
                      size='mini'
                      show-word-limit>
                    </el-input>
                  </el-col>
                </el-row>

                <br />
                <el-row style="margin-top:15px;">
                  <el-col :span="4" class="ColonneGauche">
                    Ville : 
                  </el-col>
                  <el-col :span="10" class="ColDroiteDialogTache ">
                    <el-input
                      type="text"
                      name='adr3'
                      id='dialogAdr3'
                      placeholder="Option de saisie"
                      rows=4
                      v-model='dialogInterlocuteur.adr3'
                      class="TextareaFont"
                      resize='none'
                      size='mini'
                      show-word-limit>
                    </el-input>
                  </el-col>
                </el-row>

                <br />
                <el-row style="margin-top:15px;">
                  <el-col :span="4" class="ColonneGauche">
                    Code postal : 
                  </el-col>
                  <el-col :span="6" class="ColDroiteDialogTache ">
                    <el-input
                      type="text"
                      name='cp'
                      id='dialogCP'
                      placeholder="Option de saisie"
                      rows=4
                      v-model='dialogInterlocuteur.cp'
                      class="TextareaFont"
                      resize='none'
                      size='mini'
                      show-word-limit>
                    </el-input>
                  </el-col>
                </el-row>

                <br />
                <el-row style="margin-top:15px;">
                  <el-col :span="4" class="ColonneGauche">
                    Pays : 
                  </el-col>
                  <el-col :span="6" class="ColDroiteDialogTache ">
                    <el-input
                      type="text"
                      name='pays'
                      id='dialogPays'
                      placeholder="Option de saisie"
                      rows=4
                      v-model='dialogInterlocuteur.pays'
                      class="TextareaFont"
                      resize='none'
                      size='mini'
                      show-word-limit>
                    </el-input>
                  </el-col>
                </el-row>

                <br />
                <el-row style="margin-top:15px;">
                  <el-col :span="4" class="ColonneGauche">
                    Lien internet : 
                  </el-col>
                  <el-col :span="6" class="ColDroiteDialogTache ">
                    <el-input
                      type="text"
                      name='internet'
                      id='dialogInternet'
                      placeholder="Option de saisie"
                      rows=4
                      v-model='dialogInterlocuteur.internet'
                      class="TextareaFont"
                      resize='none'
                      size='mini'
                      show-word-limit>
                    </el-input>
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
                    type="date"
                      name="date_creat"
                      id='dialogDate_creat'
                      placeholder="Date"
                      rows=4
                      v-model='dialogInterlocuteur.date_creat'
                      class="TextareaFont"
                      format="yyyy-MM-dd"
                      size='mini'>
                    </el-date-picker>
                  </el-col>
                </el-row>

                <el-row style="margin-top:15px" hidden>
                  <el-col :span="4" class="ColonneGauche">
                    <span>
                      MAJ le : 
                    </span>
                  </el-col>
                  <el-col :span="17" style="text-align:left">
                    <el-date-picker
                      type="date"
                      name="date_MAJ"
                      id='dialogDate_MAJ'
                      placeholder="Date"
                      rows=4
                      v-model='dialogInterlocuteur.date_MAJ'
                      class="TextareaFont"
                      format="yyyy-MM-dd"
                      size='mini'>
                    </el-date-picker>
                  </el-col>
                </el-row>

                <el-row style="margin-top:15px;" hidden>
                  <el-col :span="4" class="ColonneGauche">
                    Inactif : 
                  </el-col>
                  <el-col :span="6" class="ColDroiteDialogTache ">
                    <el-input
                      type="text"
                      name='inactif'
                      id='dialogInactif'
                      placeholder="Option de saisie"
                      rows=4
                      v-model='dialogInterlocuteur.inactif'
                      class="TextareaFont"
                      resize='none'
                      size='mini'
                      show-word-limit>
                    </el-input>
                  </el-col>
                </el-row>

                <el-row style="margin-top:15px;" hidden>
                  <el-col :span="4" class="ColonneGauche">
                    Fax : 
                  </el-col>
                  <el-col :span="6" class="ColDroiteDialogTache ">
                    <el-input
                      type="text"
                      name='fax'
                      id='dialogFax'
                      placeholder="Option de saisie"
                      rows=4
                      v-model='dialogInterlocuteur.fax'
                      class="TextareaFont"
                      resize='none'
                      size='mini'
                      show-word-limit>
                    </el-input>
                  </el-col>
                </el-row>

                <el-row style="margin-top:15px;" hidden>
                  <el-col :span="4" class="ColonneGauche">
                    Type : 
                  </el-col>
                  <el-col :span="6" class="ColDroiteDialogTache ">
                    <el-input
                      type="text"
                      name='type'
                      id='dialogType'
                      placeholder="Option de saisie"
                      rows=4
                      v-model='dialogInterlocuteur.type'
                      class="TextareaFont"
                      resize='none'
                      size='mini'
                      show-word-limit>
                    </el-input>
                  </el-col>
                </el-row>

                <div  class="dialog-footer">
                  <el-button @click="handleAjouterInterlocuteurVisible = false" size='mini'>Retour</el-button>
                  <el-button type="primary" @click="handleAjouterInterlocuteur" size='mini'>Enregistrer</el-button>
                </div>
              </form>
            </el-dialog>


                <!--   PARTIE AFFICHAGE INTERLOCUTEURS  -->
                <!-- ////////////////////////////////// -->
                <!-- ////////////////////////////////// -->
                <!-- ////////////////////////////////// -->

                <el-collapse>
                  <div v-model='reactiviteDetail'>
                    <div  v-for='(interlocuteur, index) in listeInterlocteurs' >
                      <el-collapse-item style="display:inline;font-size:11px">
                        <el-divider class="dividerInterlocuteur"><i class="el-icon-document"></i></el-divider>
                        <template slot="title" style="display:inline-block">
                          <el-col :span="20" v-if="((interlocuteur.PRENOM_CONTAC.length)+(interlocuteur.NOM_CONTAC.length))<30" class="ColGaucheInterlocuteur"><i class="header-icon el-icon-user">
                            
                          </i><span class="infoInterlocuteur">{{interlocuteur.CIVIL}} {{interlocuteur.PRENOM_CONTAC}} {{interlocuteur.NOM_CONTAC}}</span> 
                          <span v-if="interlocuteur.FONCTION!='' " class="fonctionInterlocuteur">{{interlocuteur.FONCTION}}</span> </el-col>
                          <el-col :span="20" v-else class="ColGaucheInterlocuteurSmall"><i class="header-icon el-icon-user"></i>
                          <span class="infoInterlocuteurSmall">{{interlocuteur.CIVIL}} {{interlocuteur.PRENOM_CONTAC}} {{interlocuteur.NOM_CONTAC}}</span> <span class="fonctionInterlocuteurSmall">{{interlocuteur.FONCTION}}</span> </el-col>
                          <div class="colDroiteRencontré">Rencontré :      
                            <el-checkbox class="rencontre" v-model="interlocuteurs.interlocuteurs_ID[index]" @change='handleRencontre(index,interlocuteur.NUM_CONTAC,interlocuteur.TYPE_CONTAC,interlocuteur.TIERS,numAct)'></el-checkbox>
                          </div>
                          </template>
                          <div>
                          <el-row>
                            <el-col :span="7" class="ColGaucheInterlocuteur"> <i class="header-icon el-icon-location"></i> Adresse : </el-col>
                            <el-col :span="17" class="ColDroiteInterlocuteur"> <el-row> {{interlocuteur.ADR_0}} {{interlocuteur.ADR_1}} {{interlocuteur.ADR_2}} </el-row>
                                                                              <el-row>  {{interlocuteur.ADR_3}} {{interlocuteur.CODE_POSTAL}} {{interlocuteur.PAYS}} </el-row>
                            </el-col>
                          </el-row>

                          <el-row>
                            <el-col :span="7" class="ColGaucheInterlocuteur"> <i class="header-icon el-icon-phone"></i> Téléphone fixe : </el-col>
                            <el-col :span="17" class="ColDroiteInterlocuteur">  {{interlocuteur.TELEPHONE}} </el-col>
                          </el-row>

                          <el-row>
                            <el-col :span="7" class="ColGaucheInterlocuteur"> <i class="header-icon el-icon-mobile"></i> Téléphone mobile : </el-col>
                            <el-col :span="17" class="ColDroiteInterlocuteur"> {{interlocuteur.MOBILE}} </el-col>
                          </el-row>

                          <el-row>
                            <el-col :span="7" class="ColGaucheInterlocuteur"> <i class="header-icon el-icon-message"></i> Mail : </el-col>
                            <el-col :span="17" class="ColDroiteInterlocuteur"> {{interlocuteur.E_MAIL}} </el-col>
                          </el-row>

                          <el-row>
                            <el-button type="danger" @click="handleRetirerInterlocuteur(interlocuteur.NUM_CONTAC)" size='mini' style="margin-top:10px">Supprimer</el-button>
                          </el-row>
                        </div>
                      </el-collapse-item>
                    </div>
                    </div>
                </el-collapse>
              <el-row>
                <el-button type="primary" @click="recupInterlocuteursPotentiels" size='mini' style="margin-top:20px">Ajouter interlocuteur</el-button>
              </el-row>
              </div>
            </div>
            <br />
            <br />
            
            <div class="bodyCard">
                <el-row class="">
                  <el-tabs type="card">
                    <el-tab-pane label="Préparation">
                      <el-input
                        size='mini'
                        type="textarea"
                        :rows="4"
                        placeholder=""
                        v-model="commentPrep"
                        height='327px'
                        class="selectColDroite TextareaFont"
                        @blur='handleTextarea(0)'
                        id='inputCommentPrep'
                        width='100%'>
                      </el-input>
                    </el-tab-pane>
                    <el-tab-pane label="Compte rendu">
                      <el-input
                        size='mini'
                        type="textarea"
                        :rows="4"
                        placeholder=""
                        v-model="commentCompteRend"
                        height='327px'
                        class="selectColDroite TextareaFont"
                        @blur='handleTextarea(1)'
                        id='inputCommentCompteRend'
                        width='100%'>
                      </el-input>
                    </el-tab-pane>
                  </el-tabs>
                </el-row>
              </div>
            </el-card>
          </el-tab-pane>
        </el-dialog>


          <!--                                      Onglet 2                                         -->
          <!-- ///////////////////////////////////////////////////////////////////////////////////// -->
          <!-- ///////////////////////////////////////////////////////////////////////////////////// -->
          <!-- ///////////////////////////////////////////////////////////////////////////////////// -->
          <el-tab-pane label="Projet client" name="projets">
            <el-card class="box-card BoxDetail" >
              <!-- Header -->
              <div slot="header" class="clearfix headerAction">
                <span class="numAct">Action {{numAct}}</span>
                <span v-if="action['ETAT']=='CL'" class="boldy etat" ><el-tag size="mini">{{etat}}</el-tag></span>
              </div>

              <div class="bodyCard">
                <el-row class="ligneAct">
    							<el-col class="ColonneGauche" :span="4">
    							<span >
    								Nature du projet
    							</span>
    							</el-col>
    							<el-col  :span="3">
                    <el-select 
                    v-model="nature" 
                    size='mini' 
                    placeholder=""
                    class="selectColDroite2"
                    @blur='handleblurDteReal' 
                    @change="handleSelectChange('NATURE')" 
                    class="selectColDroite2 " >
                      <el-option :key='null' :label='null' :value='null' ></el-option>
                      <el-option
                        v-for="item in optionsNature"
                        :key="item.LIB_50"
                        :label="item.LIB_50"
                        :value="item.CDE_TABLE">
                      </el-option>
                    </el-select>
    							</el-col>
    						</el-row>
                
                <br />
                <el-row class="ligneAct">
    							<el-col class="ColonneGauche" :span="4">
    							<span >
    								Origine
    							</span>
    							</el-col>
    							<el-col  :span="3">
                    <el-select 
                    v-model="origine" 
                    size='mini' 
                    placeholder=""
                    class="selectColDroite2"
                    @change="handleSelectChange('ORIGINE')" 
                    class="selectColDroite2 ">
                      <el-option :key='null' :label='null' :value='null' ></el-option>
                      <el-option
                        v-for="item in optionsOrigine"
                        :key="item.LIB_50"
                        :label="item.LIB_50"
                        :value="item.CDE_TABLE">
                      </el-option>
                    </el-select>
    							</el-col>
    						</el-row>
                
                <br />
                <el-row class="ligneAct">
    							<el-col class="ColonneGauche" :span="4">
    							<span>
    								Intérêt
    							</span>
    							</el-col>
    							<el-col  :span="3">
                    <el-select 
                    v-model="interet" 
                    size='mini' 
                    placeholder=""
                    class="selectColDroite2"
                    @change="handleSelectChange('INTERET')" >
                      <el-option :key='null' :label='null' :value='null' ></el-option>
                      <el-option
                        v-for="item in optionsInteret"
                        :key="item.LIB_50"
                        :label="item.LIB_50"
                        :value="item.CDE_TABLE">
                      </el-option>
                    </el-select>
    							</el-col>
    						</el-row>
                
                <br />
                <el-row class="ligneAct">
    							<el-col class="ColonneGauche" :span="4">
    							<span>
    								Statut
    							</span>
    							</el-col>
    							<el-col  :span="3">
                    <el-select 
                    v-model="statut" 
                    size='mini' 
                    placeholder="" 
                    class="selectColDroite2" 
                    @change="handleSelectChange('STATUT')">
                      <el-option :key='null' :label='null' :value='null' ></el-option>
                      <el-option
                        v-for="item in optionsStatut"
                        :key="item.LIB_50"
                        :label="item.LIB_50"
                        :value="item.CDE_TABLE">
                      </el-option>
                    </el-select>
    							</el-col>
                </el-row>
                
                <br />
                <el-row class="ligneAct">
    							<el-col class="ColonneGauche" :span="4">
                    <span>
                      Chiffre d'affaire
                    </span>
    							</el-col>
    							<el-col  :span="3">
                    <el-input
                    size='mini'
                    row=1
                    class="selectColDroite"
                    v-model="NUM_AFFAIRE" 
                    type="text"
                    placeholder="Chiffre d'affaire en €"
                    @change="handleNUM_AFFAIRE">
                    </el-input>
    							</el-col>
    						</el-row>
                
                <br />
                <el-row class="ligneAct">
                  <el-col class="ColonneGauche" :span="4">
                    <span>
                      Estimé le
                    </span>
                  </el-col>
                  <el-col  :span="3">
                    <el-date-picker
                      size='mini'
                      class="selectColDroite"
                      v-model="echeance"
                      type="date"
                      placeholder="Date"
                      value-format="yyyy-MM-dd"
                      format="dd-MM-yyyy"
                      @change='handleEstime'>
                    </el-date-picker>
                  </el-col>
                </el-row>

              </div>
            </el-card>
          </el-tab-pane>


          <!--                            ONGLET 3                              -->
          <!-- //////////////////////////////////////////////////////////////// -->
          <!-- //////////////////////////////////////////////////////////////// -->
          <el-tab-pane label="Tâches" name="taches">
            <div class="fab-container">
              <el-button class="addbtn" type="danger" icon="el-icon-plus" @click="dialogFormTacheVisible = true" circle></el-button>
            </div>
            <el-card class="box-card BoxDetail" >
              <!-- Header -->
              <div slot="header" class="clearfix headerAction">
                <span class="numAct">Action {{numAct}}</span>
                <span v-if="action['ETAT']=='CL'" class="boldy etat" ><el-tag size="mini">{{etat}}</el-tag></span>
              </div>

              <div class="bodyCard">


              <!-- Ajout d'une tache -->
              <!-- ///////////////////////////////// -->
              <!-- ///////////////////////////////// -->
              <!-- ///////////////////////////////// -->
              <el-dialog title="Ajout d'une tâche" :visible.sync="dialogFormTacheVisible" style="width:100%;" @close='handleClose' class="dialogAjout">

                <form class="" action="action.php" method="post" id='formAjoutTache'>
                  <el-row>
                    <el-col :span="4" class="ColonneGauche">
                      Intervenant :
                    </el-col>
                    <el-col :span="9" class="ColDroiteDialogTache ">
                      <el-select 
                        placeholder="Veuillez saisir" 
                        v-model='dialogTache.intervenant' 
                        id='dialogIntervenant' 
                        size='mini' 
                        name='intervenant'>
                        <el-option :key='null' :label='null' :value='null' ></el-option>
                        <el-option
                          v-for="item in optionsRessource"
                          :key="item.USER_NAME"
                          :label="item.USER_NAME"
                          :value="item.USER_NAME">
                        </el-option>
                      </el-select>
                    </el-col>
                  </el-row>

                  <el-row style="margin-top:15px;">
                    <el-col :span="4" class="ColonneGauche">
                      Tâche : 
                    </el-col>
                    <el-col :span="17" class="ColDroiteDialogTache ">
                      <el-input
                        type="textarea"
                        name='tache'
                        id='dialogTache'
                        placeholder="Veuillez saisir"
                        rows=4
                        v-model='dialogTache.tache'
                        class="TextareaFont"
                        maxlength="100"
                        resize='none'
                        show-word-limit>
                      </el-input>
                    </el-col>
                  </el-row>

                  <el-row style="margin-top:15px">
                    <el-col class="ColonneGauche" :span="4">
                      <span>
                        Prévue le :
                      </span>
                    </el-col>
                    <el-col  :span="17" style="text-align:left">
                      <el-date-picker
                        size='mini'
                        class="dateAction selectColDroite"
                        type="datetime"
                        id='dialogDate_prev'
                        v-model='dialogTache.date_prev'
                        placeholder="Date et heure"
                        name='date_prev'
                        value-format="yyyy-MM-dd HH:mm"
                        format="dd-MM-yyyy HH:mm">
                      </el-date-picker>
                  </el-row>

                  <el-row style="margin-top:15px">
                    <el-col class="ColonneGauche" :span="4">
                      <span>
                        Réalisée le :
                      </span>
                    </el-col>
                    <el-col  :span="17" style="text-align:left">
                      <el-date-picker
                        size='mini'
                        class="dateAction selectColDroite"
                        type="datetime"
                        id='dialogDate_real'
                        v-model='dialogTache.date_real'
                        placeholder="Date et heure"
                        name='date_real'
                        value-format="yyyy-MM-dd HH:mm"
                        format="dd-MM-yyyy HH:mm"
                        @change=''>
                      </el-date-picker>
                    </el-col>
                  </el-row>

                  <el-row style="margin-top:15px;">
                    <el-col :span="4" class="ColonneGauche">
                      Observations :
                    </el-col>
                    <el-col :span="17" class="ColDroiteDialogTache">
                      <el-input
                        type="textarea"
                        placeholder="Veuillez saisir"
                        rows=4
                        v-model='dialogTache.observation'
                        id='dialogObservation'
                        class="TextareaFont"
                        name='observation'
                        resize='none'>
                      </el-input>
                    </el-col>
                  </el-row>

                  <div  class="dialog-footer">
                    <el-button @click="dialogFormTacheVisible = false" size='mini'>Retour</el-button>
                    <el-button type="primary" @click="handleEnregistrementTache" size='mini'>Enregistrer</el-button>
                  </div>
                </form>

              </el-dialog>

                <!-- AFFICHAGE TACHES -->
                <!-- ///////////////////////////////// -->
                <!-- ///////////////////////////////// -->
                <!-- ///////////////////////////////// -->
                <el-collapse>
                  <div  v-for='(tache,index) in listeTaches' >
                    <el-collapse-item style="display:inline">
                      <template slot="title">
                        <div class="colGaucheTacheHeader">
                          <el-row><i class="header-icon el-icon-suitcase"></i> {{taches_INT.taches_INT_ID[index]}} </el-row>
                          <el-row> {{tache.TACHE2}} </el-row>
                        </div>
                        <div class="colDroiteTacheHeader">
                          <el-row v-if='tache.DTE_REAL2==null' style="margin-bottom:16px">{{tache.DTE_PREV2}} </el-row>
                          <el-row v-else >{{tache.DTE_PREV2}} </el-row>
                          <el-row> {{tache.DTE_REAL2}} </el-row>
                        </div>
                        <!-- /////////////////////////////// -->
                      </template>
                      <div>
                        <el-divider class="dividerInterlocuteur"><i class="el-icon-document"></i></el-divider>
                        <el-row style="margin-top:15px;">
                          <el-col :span="5" class="ColGaucheInterlocuteur">
                            Intervenant
                          </el-col>
                          <el-col :span="3" class="ColDroiteInterlocuteur TextareaFont">
                            <el-select 
                            placeholder="Veuillez saisir" 
                            v-model="taches_INT.taches_INT_ID[index]"
                            class="selectColDroite2"
                            size='mini'
                            @change="handleSelectChangeTache('RESSOURCE',tache.RANG)" 
                            <?php if (isset($action)) {
                                    echo "disabled";
                                  } ?>>
                              <el-option :key='null' :label='null' :value='null' ></el-option>
                              <el-option
                                v-for="item in optionsRessource"
                                :key="item.USER_NAME"
                                :label="item.USER_NAME"
                                :value="item.USER_NAME"
                                >
                              </el-option>
                            </el-select>
                          </el-col>
                        </el-row>

                        <el-row style="margin-top:15px;">
                          <el-col :span="5" class="ColGaucheInterlocuteur">
                            Tâche
                          </el-col>
                          <el-col :span="17" class="ColDroiteInterlocuteur ">
                            <el-input
                            type="textarea"
                            placeholder="Veuillez saisir"
                            v-model="taches_LIB.taches_LIB_ID[index]"
                            rows=4
                            class="TextareaFont"
                            @blur='handleTextareaTache(0,tache.RANG)'
                            maxlength="100"
                            resize='none'
                            show-word-limit
                            >
                            </el-input>
                          </el-col>
                        </el-row>


                        <el-row style="margin-top:15px">
                          <el-col class="ColonneGauche" :span="5">
                            <span>
                              Prévue le
                            </span>
                          </el-col>
                          <el-col  :span="3" style="text-align:left">
                            <el-date-picker
                              size='mini'
                              type="datetime"
                              class="selectColDroite3"
                              v-model="taches_PRE.taches_PRE_ID[index]"
                              placeholder="Date et heure"
                              value-format="dd-MM-yyyy HH:mm"
                              format="dd-MM-yyyy HH:mm"
                              @change='handleDtePrev_tache(tache.RANG,index)'
                              <?php if (isset($action)) {
                                echo "disabled";
                              } ?>>
                            </el-date-picker>
                          </el-col>
                        </el-row>

                        <el-row style="margin-top:15px">
                          <el-col class="ColonneGauche" :span="5">
                            <span>
                              Réalisée le
                            </span>
                          </el-col>
                          <el-col  :span="3" style="text-align:left">
                            <el-date-picker
                              size='mini'
                              type="datetime"
                              class="selectColDroite3"
                              v-model="taches_REA.taches_REA_ID[index]"
                              placeholder="Date et heure"
                              value-format="dd-MM-yyyy HH:mm"
                              format="dd-MM-yyyy HH:mm"
                              @change='handleDteReal_tache(tache.RANG,index)'>
                            </el-date-picker>
                          </el-col>
                        </el-row>

                        <el-row style="margin-top:15px;">
                          <el-col :span="5" class="ColGaucheInterlocuteur">
                            Observations
                          </el-col>
                          <el-col :span="17" class="ColDroiteInterlocuteur">
                            <el-input
                            type="textarea"
                            placeholder="Veuillez saisir"
                            v-model="taches_OBS.taches_OBS_ID[index]"
                            rows=4
                            class="TextareaFont"
                            @blur='handleTextareaTache(1,tache.RANG)'
                            resize='none'
                            show-word-limit
                            >
                            </el-input>
                          </el-col>
                        </el-row>

                        <el-row>
                          <el-button type="danger" @click="handleSupprimerTache(tache.RANG)" size='mini' style="margin-top:10px">Supprimer</el-button>
                        </el-row>
                      </div>
                    </el-collapse-item>
                  </div>
              </div>
            </el-card>
          </el-tab-pane>
          <el-tab-pane label="Documents" name="doc">


          <!--                            ONGLET 4                              -->
          <!-- //////////////////////////////////////////////////////////////// -->
          <!-- //////////////////////////////////////////////////////////////// -->
            <el-card class="box-card BoxDetail" >
              <!-- Header -->
              <div slot="header" class="clearfix headerAction">
                <span class="numAct">Action {{numAct}}</span>
                <span v-if="action['ETAT']=='CL'" class="boldy etat" ><el-tag size="mini">{{etat}}</el-tag></span>
              </div>

              <div class="bodyCard">
              <el-upload
                id='uploadDocs'
                class="upload-demo"
                action=""
                ref="upload"
                :on-preview="handlePreview"
                :on-success="handleSuccess"
                :on-remove="handleRemove"
                :before-upload="handleDoublon"
                :file-list="fileList"
                :before-upload="beforeAvatarUpload"
                list-type="picture">

                <el-button size="small" type="primary">Ajouter un document</el-button>

                <div slot="file" slot-scope="{file}">
                  <img
                    class="el-upload-list__item-thumbnail"
                    :src="file.url" alt=""
                    @click="handlePreview(file)"
                    v-if='isImage(file.name)'
                  >

                  <img
                    class="el-upload-list__item-thumbnail"
                    src="../images/file.png" alt=""
                    @click="handlePreview(file)"
                    v-else
                  >

                  <div style="display: inline-block;width: 100%;">
                    <span
                      class="el-upload-list__item-name"
                      @click="handlePreview(file)"
                      style="float: left;width: 60%;margin-right: 2;"
                    >
                      {{file.name}}
                     </span>
                    <div class="el-upload-list__item-name" style="float: right;margin-right: 2px;">
                      <!-- <el-link :href="file.url" class="" :download="file.name" icon="el-icon-download">download</el-link> -->
                      <a :href="file.url" class="" :download="file.name"><i class="el-icon-download iconDownload" style="display:inline-block"></i></a>
                      <i class="el-icon-delete iconDownload" style="display:inline-block" @click="removeImg(file)"></i>

                    </div>
                  </div>
                </div>
              </div>
                <!-- <div slot="tip" class="el-upload__tip">jpg/png files with a size less than 500kb</div> -->
              </el-upload>
            </el-card>
            <a href="#" class="download-link"></a>
          <el-dialog class="dialog_IMG" :visible.sync="dialogVisible">
            <img width="100%" :src="dialogImageUrl" alt="">
          </el-dialog>
        </el-tab-pane>
      </el-tabs>
    </div>
  </body>

                                                       <!-- PARTIE JAVASCRIPT Vue.js -->
<!-- __________________________________________________________________  __________________________________________________________________ -->
<!-- __________________________________________________________________  __________________________________________________________________ -->
<!-- __________________________________________________________________  __________________________________________________________________ -->
<!-- __________________________________________________________________  __________________________________________________________________ -->
<!-- __________________________________________________________________  __________________________________________________________________ -->
<!-- __________________________________________________________________  __________________________________________________________________ -->

  <script src="../js/element-ui.js"></script>
  <script src="../js/element-ui-fr.js"></script>
  <link rel="stylesheet" type="text/css" href="../view/css/theme/element-ui.css">
  <script>
    ELEMENT.locale(ELEMENT.lang.fr)
  </script>
  <script type="text/javascript">

  new Vue({
    data: {
      tableData: <?php echo json_encode($listeActions);?>,
      activeName:'<?php echo $_SESSION['ongletAction'];  ?>',
      numAct: '<?php echo ($numAct);?>',
      action: <?php if (isset($action)) {
        echo (json_encode($action));
      } else {
        echo "'error'";
      }
       ?>,
      tabPosition: 'top',
      interlocuteurs: {
        interlocuteurs_ID: []
      },
      nom_cli:'<?php echo ($action['NOM_CLI']); ?>',
      nom_com:'<?php echo ($action['NOM']); ?>',
      objet: '<?php echo($action['LIB_OBJET']) ?>',
      etat: '<?php echo($action['ETAT']) ?>',
      priorite:'<?php echo ($action['LIB_PRIORITE']); ?>',
      dte_creat: '<?php echo($action['DTE_CREAT']) ?>',
      dte_prev: '<?php echo($action['DTE_PREV']) ?>',
      dte_real: '<?php echo($action['DTE_REAL']) ?>',
      commentCompteRend: <?php echo(json_encode($action['COMPTE_RENDU']))?>,
      commentPrep: <?php echo(json_encode($action['PREPARATION']))?>,
      nature: '<?php echo($action['LIB_NATURE']) ?>',
      origine: '<?php echo($action['LIB_ORIGINE']) ?>',
      interet: '<?php echo($action['LIB_INTERET']) ?>',
      statut: '<?php echo($action['LIB_STATUT']) ?>',
      echeance : '<?php echo($action['DTE_SIGN']) ?>',
      NUM_AFFAIRE : '<?php echo($action['NUM_AFFAIRE']) ?>',
      reactiviteDetail: false,
      rencontre : 0,
      
      optionsNom_Cli:[{value: 'nom_cli',label:'<?php echo ($action['CDE_PROFIL']); ?>'}],
      optionsPriorite: <?php echo(json_encode($listeSelectPriorite)); ?>,
      optionsObjet: <?php echo(json_encode($listeSelectObjet)); ?>,
      optionsNature: <?php echo(json_encode($listeSelectNature)); ?>,
      optionsOrigine: <?php echo(json_encode($listeSelectOrigine)); ?>,
      optionsInteret: <?php echo(json_encode($listeSelectInteret)); ?>,
      optionsStatut: <?php echo(json_encode($listeSelectStatut)); ?>,

      nom : '<?php echo($action['NOM']) ?>',
      Fonction : '<?php echo($action['FONCTION']) ?>',
      listeInterlocteurs: <?php echo(json_encode($listeInterlocuteurs)); ?>,
      dialogFormInterlocuteurVisible : false,
      handleAjouterInterlocuteurVisible : false,
      listeInterlocteursPotentiels: [],
      multipleSelection: [],

      optionsFonction: <?php echo(json_encode($listeFonctions)); ?>,
      dialogInterlocuteur :{
        civilite: '1',
        prenom: '',
        nom: '',
        fonction: '',
        telFixe: '',
        telPortable: '',
        email: '',
        adr0: '',
        adr1: '',
        adr2: '',
        adr3: '',
        cp: '',
        pays: '',
        internet: '',
        fax: '',
        type: '1',
        inactif: '0',
        date_creat: '',
        date_MAJ: ''

      },
      // ------------------------ Onglet 3 -----------------------------
      listeTaches:<?php echo(json_encode($listeTaches)); ?>,
      taches_LIB: {
        taches_LIB_ID: []
      },
      taches_OBS: {
        taches_OBS_ID: []
      },
      taches_INT: {
        taches_INT_ID: []
      },
      taches_PRE: {
        taches_PRE_ID: []
      },
      taches_REA: {
        taches_REA_ID: []
      },
      optionsRessource: <?php echo(json_encode($listeIntervenants)); ?>,
      dialogFormTacheVisible : false,
      formTache: {
          Intervenant: '',
          tache: '',
          date_prev: '',
          date_real: '',
          observation: ''
      },   
      dialogTache :{
        intervenant: '',
        tache: '',
        date_prev: new Date(),
        date_real: '',
        observation: ''
      },
      dialogImageUrl: '',
      dialogVisible: false,
      disabled: false,

      // ajout de documents
      fileList:[],
      theBlob:''

    },
    methods: {
      test(){
        console.log(tinymce)
      },
      beforeAvatarUpload(file){
        //console.log(file);
        //console.log(this.fileList);
        this.theBlob=file;
      },
      handlePreview(file) {
        if (file.name.toLowerCase().includes('jpg') || file.name.toLowerCase().includes('png') || file.name.toLowerCase().includes('jpeg')) {
          this.dialogImageUrl = file.url;
          this.dialogVisible = true;
        }
      },isImage(file){
        return (file.toLowerCase().includes('jpg') || file.toLowerCase().includes('png') || file.toLowerCase().includes('jpeg'))
      },
      handleRemove(file) {
        console.log(file);
      },
      handlePictureCardPreview(file) {
        this.dialogImageUrl = file.url;
        this.dialogVisible = true;
      },
      handleDownload(file) {
        console.log(file);
      },
      handleDoublon(file){
        console.log('test');
        var found = false;
        for(var i = 0; i < this.fileList.length; i++) {
            if (this.fileList[i].name == file.name) {
                found = true;
                console.log('Un document du même nom existe déjà');
                this.$notify.error({
                  title: 'Erreur',
                  customClass:'notification_doublon',
                  offset: 60,
                  message: 'Un document du même nom existe déjà'
                });
                return false;
            }
        }
      },

      handleSuccess(response, file, fileList) {
        var vm = this;
        vm.fileList = fileList;
        var cpt = vm.fileList.length - 1;

        var xhr = new XMLHttpRequest();
        xhr.open('GET', fileList[cpt].url, true);
        xhr.responseType = 'arraybuffer';
        xhr.onload = function(e) {
          if (this.status == 200) {
            var myBlob = this.response;

            var uInt8Array = new Uint8Array(this.response);
            var i = uInt8Array.length;
            var binaryString = new Array(i);
            while (i--)
            {
              binaryString[i] = String.fromCharCode(uInt8Array[i]);
            }
            var data = binaryString.join('');

            var base64 = window.btoa(data);


            var request = $.ajax({
              url: "../controller/action.php",
              async: false,
              type: "POST",
              data: {'download' : 1,'name':fileList[cpt].name,'file': base64,'action': vm.numAct},
              dataType: "html",
              success: function(data){
                console.log('update fini');
              }
            });
          }
        };
        xhr.send();

        $(".download-link").click(function(event) {

            var link = $(".download-link");
            link.attr("href", fileList[cpt].url);
            link.attr("download", fileList[cpt].name);
        });
      }
      ,removeImg(file){
        this.$confirm('Confirmez vous la suppression?', 'Suppression', {
          confirmButtonText: 'Oui',
          cancelButtonText: 'Non',
          type: 'warning'
        }).then(() => {
          var index=this.fileList.findIndex(x => x.uid === file.uid);
          if (index > -1) {
            this.fileList.splice(index, 1);
            var request = $.ajax({
    					url: "../controller/action.php",
    					async: false,
    					type: "POST",
    					data: {'remove_img' : 1,'name':file.name,'action': this.numAct },
    					dataType: "html",
              success: function(data){
                console.log('update fini');
          		}
    				});
          }
        });


      },
      handleRadioValider(){

				if (this.rencontre==1) {
					this.rencontre=0;
				}
				else {
					this.rencontre=1;
				}
					if (this.rencontre==1) {
						$(event.currentTarget).addClass('BtnValiderDevisPlain');
						$(event.currentTarget).removeClass('BtnValiderDevisNPlain');

						$(event.currentTarget).siblings().first().removeClass('BtnRefuserDevisPlain');
						$(event.currentTarget).siblings().first().addClass('BtnRefuserDevisNPlain');
					}
					else if (this.rencontre==0) {
						$(event.currentTarget).removeClass('BtnValiderDevisPlain');
						$(event.currentTarget).addClass('BtnValiderDevisNPlain');

						$(event.currentTarget).siblings().first().removeClass('BtnRefuserDevisPlain');
						$(event.currentTarget).siblings().first().addClass('BtnRefuserDevisNPlain');
					}
			},handleRadioRefuser(){
				if (this.rencontre==2) {
					this.rencontre=0;
				}
				else {
					this.rencontre=2;
				}
				if (this.rencontre==2) {
					$(event.currentTarget).addClass('BtnRefuserDevisPlain');
					$(event.currentTarget).removeClass('BtnRefuserDevisNPlain');

					$(event.currentTarget).siblings().first().removeClass('btnValiderDevisTab');
					$(event.currentTarget).siblings().first().addClass('BtnValiderDevisNPlain');
				}
				else if (this.rencontre==0) {
					$(event.currentTarget).removeClass('BtnRefuserDevisPlain');
					$(event.currentTarget).addClass('BtnRefuserDevisNPlain');

					$(event.currentTarget).siblings().first().removeClass('btnValiderDevisTab');
					$(event.currentTarget).siblings().first().addClass('BtnValiderDevisNPlain');
				}
			},
      handleRencontre(index,numCont,typeCont,tiersCont,numAct){
        var rencontre = 0;
        if (event.currentTarget.checked) {
          rencontre=1;
        }
        var request = $.ajax({
					url: "../controller/action.php",
					async: false,
					type: "POST",
					data: {'update' : 1,'rencontre':rencontre,'numCont':numCont,'typeCont': typeCont,'tiersCont':tiersCont,'numAct': numAct },
					dataType: "html",
          success: function(data){
            console.log('update fini');
      		}
				});
      },

      handleblurDtePrev(){
        $('.date_picker_mobile').css('display','none');
      },
      handleDtePrev(){
        if (this.dte_prev===null) {
          this.dte_prev='';
        }
        var date_prev = moment(document.getElementById('detail_dte_prev').value, "DD-MM-yyyy HH:mm").format("YYYY-MM-DD hh:mm:ss");
        var request = $.ajax({
				url: "../controller/action.php",
        async: false,
        type: "POST",
        data: {'update' : 1,'numAct': this.numAct,'dte_prev':date_prev.replace(" ", "T")},
        dataType: "html",
				});
        //La suite permet de passer les heures en francais (sans les AM PM)
        var request = $.ajax({
					url: "../controller/action.php",
					async: false,
					type: "POST",
					data: {'update' : 1,'numAct': this.numAct,'dte_prev':this.dte_prev},
					dataType: "html",
				});
      },

      handleblurDteReal(){
        $('.date_picker_mobile').css('display','none');
      },
      handleDteReal(){
        if (this.dte_real===null) {
          this.dte_real='';
        }
        var date_real = moment(document.getElementById('detail_dte_real').value, "DD-MM-yyyy HH:mm").format("YYYY-MM-DD hh:mm:ss");
        var request = $.ajax({
				url: "../controller/action.php",
        async: false,
        type: "POST",
        data: {'update' : 1,'numAct': this.numAct,'dte_real':date_real.replace(" ", "T")},
        dataType: "html",
				});
        //La suite permet de passer les heures en francais (sans les AM PM)
        var request = $.ajax({
					url: "../controller/action.php",
					async: false,
					type: "POST",
					data: {'update' : 1,'numAct': this.numAct,'dte_real':this.dte_real},
					dataType: "html",
				});
      },

      handleNUM_AFFAIRE(){
        if (this.NUM_AFFAIRE===null) {
          this.NUM_AFFAIRE='';
        }
        var request = $.ajax({
					url: "../controller/action.php",
					async: false,
					type: "POST",
					data: {'update' : 1,'numAct': this.numAct,'NUM_AFFAIRE':this.NUM_AFFAIRE},
					dataType: "html",
          success: function(data){
            console.log('update fini');
      		}
				});
      },

      handleEstime(){
        if (this.echeance===null) {
          this.echeance='';
        }
        var request = $.ajax({
					url: "../controller/action.php",
					async: false,
					type: "POST",
					data: {'update' : 1,'numAct': this.numAct,'echeance':this.echeance},
					dataType: "html",
          success: function(data){
            console.log('update fini');
      		}
				});
      },

      getCDE_TABLEFromLIB(liste,lib_50){
        //debugger;
        for (var i = 0; i < liste.length; i++) {
          if (liste[i].LIB_50==lib_50) {
            return liste[i].CDE_TABLE;
          }
        }
        return '';
      },
      handleSelectChange(champ){
        var lib_50=event.currentTarget.textContent;

        // UPDATE DU CHAMP NATURE DANS LA TABLE ACTIONCRM
        if (champ=='NATURE') {
          var cde_table=this.getCDE_TABLEFromLIB(this.optionsNature,lib_50);

          var request = $.ajax({
  					url: "../controller/action.php",
  					async: false,
  					type: "POST",
  					data: {'update' : 1,'numAct': this.numAct,'nature':cde_table},
  					dataType: "html",
            success: function(data){
              console.log('update fini');
        		}

  				});
        }
        // Gestion de l'origine
        else if (champ=='ORIGINE') {
          var cde_table=this.getCDE_TABLEFromLIB(this.optionsOrigine,lib_50);

          var request = $.ajax({
  					url: "../controller/action.php",
  					async: false,
  					type: "POST",
  					data: {'update' : 1,'numAct': this.numAct,'origine':cde_table},
  					dataType: "html",
            success: function(data){
              console.log('update fini');
        		}

  				});
        }
        // Gestion de l'interet
        else if (champ=='INTERET') {
          var cde_table=this.getCDE_TABLEFromLIB(this.optionsInteret,lib_50);

          var request = $.ajax({
  					url: "../controller/action.php",
  					async: false,
  					type: "POST",
  					data: {'update' : 1,'numAct': this.numAct,'interet':cde_table},
  					dataType: "html",
            success: function(data){
              console.log('update fini');
        		}

  				});
        }
        // Gestion de l'interet
        else if (champ=='STATUT') {
          var cde_table=this.getCDE_TABLEFromLIB(this.optionsStatut,lib_50);

          var request = $.ajax({
            url: "../controller/action.php",
            async: false,
            type: "POST",
            data: {'update' : 1,'numAct': this.numAct,'statut':cde_table},
            dataType: "html",
            success: function(data){
              console.log('update fini');
            }
          });
        }

      },
      handleSelectChangeTache(champ,rang){
        var lib_50=event.currentTarget.textContent;
        if (champ=='RESSOURCE') {
         var request = $.ajax({
           url: "../controller/action.php",
           async: false,
           type: "POST",
           data: {'update' : 1,'numAct': this.numAct,'ressource':lib_50,'rang':rang},
           dataType: "html",
           success: function(data){
             console.log('update fini');
           }

         });
       }
     },
     /* handleTextarea(texte){
        tinymce.triggerSave();
        if (texte==0) {
          var request = $.ajax({
            url: "../controller/action.php",
            async: false,
            type: "POST",
            data: {'update' : 1,'numAct': this.numAct,'preparation':event.currentTarget.value},
            dataType: "html",
            success: function(data){
              console.log('update fini');
            }

          });
        }
        else if (texte==1) {
          var request = $.ajax({
            url: "../controller/action.php",
            async: false,
            type: "POST",
            data: {'update' : 1,'numAct': this.numAct,'compte_rendu':event.currentTarget.value},
            dataType: "html",
            success: function(data){
              console.log(envent);
            }

          });
        }
      },*/

      handleTextareaTache(texte,rang){
        if (texte==0) {
         var request = $.ajax({
           url: "../controller/action.php",
           async: false,
           type: "POST",
           data: {'update' : 1,'numAct': this.numAct,'tache':event.currentTarget.value,'rang':rang},
           dataType: "html",
          });
        }
        else if (texte==1) {
          var request = $.ajax({
            url: "../controller/action.php",
            async: false,
            type: "POST",
            data: {'update' : 1,'numAct': this.numAct,'observation':event.currentTarget.value,'rang':rang},
            dataType: "html",
          });
        }
      },

      handleDtePrev_tache(rang,index){
        if (this.taches_PRE.taches_PRE_ID[index]===null) {
          this.taches_PRE.taches_PRE_ID[index]='';
        }
        var request = $.ajax({
					url: "../controller/action.php",
					async: false,
					type: "POST",
					data: {'update' : 1,'numAct': this.numAct,'dte_prev_tache':this.taches_PRE.taches_PRE_ID[index],'rang':rang},
					dataType: "html",
				});
      },

      handleDteReal_tache(rang,index){
        if (this.taches_REA.taches_REA_ID[index]===null) {
        this.taches_REA.taches_REA_ID[index]='';
        }
        var request = $.ajax({
					url: "../controller/action.php",
					async: false,
					type: "POST",
					data: {'update' : 1,'numAct': this.numAct,'dte_real_tache':this.taches_REA.taches_REA_ID[index],'rang':rang},
					dataType: "html",
				});
      },

      handleClose(){
        this.dialogTache.intervenant='';
        this.dialogTache.tache='';
        this.dialogTache.date_prev=new Date();
        this.dialogTache.date_real='';
        this.dialogTache.observation='';
      },
      verifChampsTache(){
        var complet=0;
        if ($('#dialogIntervenant').val()=='') {
          complet=1;
          this.$alert('Veuillez saisir un intervenant', 'Erreur', {
            confirmButtonText: 'OK'
          });
        }
        else if ($('#dialogTache').val()=='') {
          complet=1;
          this.$alert('Veuillez saisir une tâche', 'Erreur', {
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
      handleEnregistrementTache(){
        var complet = this.verifChampsTache();
        if (complet==0) {
          var temp=this;
          var request = $.ajax({
  					url: "../controller/action.php",
  					async: false,
  					type: "POST",
  					data: {'insertTache' : 1,'numAct': this.numAct,'intervenant':$('#dialogIntervenant').val(),'tache':$('#dialogTache').val()
            ,'date_prev': $('#dialogDate_prev').val(),'date_real':$('#dialogDate_real').val(),'observation': $('#dialogObservation').val()},
  					dataType: "json",
            success: function(data){
              console.log('update fini');
              temp.dialogFormTacheVisible = false;
              temp.listeTaches=data;
              temp.remplirVmodel();
        		}
  				});
        }
      },

      handleClose1(){
        this.dialogInterlocuteur.civilite='1';
        this.dialogInterlocuteur.prenom='';
        this.dialogInterlocuteur.nom='';
        this.dialogInterlocuteur.fonction='';
        this.dialogInterlocuteur.telFixe='';
        this.dialogInterlocuteur.telPortable='';
        this.dialogInterlocuteur.email='';
        this.dialogInterlocuteur.adr0='';
        this.dialogInterlocuteur.adr1='';
        this.dialogInterlocuteur.adr2='';
        this.dialogInterlocuteur.adr3='';
        this.dialogInterlocuteur.cp='';
        this.dialogInterlocuteur.pays='';
        this.dialogInterlocuteur.internet='';
        this.dialogInterlocuteur.fax='';
        this.dialogInterlocuteur.type='';
        this.dialogInterlocuteur.inactif='';
        this.dialogInterlocuteur.date_creat='';
        this.dialogInterlocuteur.date_MAJ='';
      },
      verifChampsInterlocuteur(){
        var complet=0;
        if ($('#dialogPrenom').val()=='') {
          complet=1;
          this.$alert('Veuillez saisir un prénom', 'Erreur', {
            confirmButtonText: 'OK'
          });
        }
        else if ($('#dialogNom').val()=='') {
          complet=1;
          this.$alert('Veuillez saisir un nom', 'Erreur', {
            confirmButtonText: 'OK'
          });
        }
        else if ($('#dialogFonction').val()=='') {
          complet=1;
          this.$alert('Veuillez saisir une fonction', 'Erreur', {
            confirmButtonText: 'OK'
          });
        }
        return complet;
      },

      handleAjouterInterlocuteurCollapse(){
        this.dialogFormInterlocuteurVisible = !this.dialogFormInterlocuteurVisible;
        this.handleAjouterInterlocuteurVisible = !this.dialogFormInterlocuteurVisible;
      },
      handleAjouterInterlocuteur(){
        this.handleAjouterInterlocuteurCollapse()
        var complet = this.verifChampsInterlocuteur();

        if (complet==0) {
          this.$alert('Interlocuteur bien ajouté à la liste. Veuillez rechercher la page pour pouvoir ajouter cet interlocuteur à l\'action', 'Erreur', {
            confirmButtonText: 'OK'
          });

          var temp=this;
          var request = $.ajax({
  					url: "../controller/action.php",
  					async: false,
  					type: "POST",
  					data: {'insertInterlocuteur' : 1, 
            'type': $('#dialogType').val(), 
            'tiersCont': this.listeInterlocteursPotentiels[0].TIERS, 
            'nom':$('#dialogNom').val(), 
            'fonction': $('#dialogFonction').val(), 
            'telFixe':$('#dialogTelFixe').val(), 
            'telPortable': $('#dialogTelPortable').val(), 
            'fax': $('#dialogFax').val(), 
            'email': $('#dialogEmail').val(), 
            'internet': $('#dialoginternet').val(), 
            'adr0': $('#dialogAdr0').val(), 
            'adr1': $('#dialogAdr1').val(), 
            'adr2': $('#dialogAdr2').val(), 
            'adr3': $('#dialogAdr3').val(), 
            'cp': $('#dialogCP').val(), 
            'pays': $('#dialogPays').val(), 
            'civilite':this.dialogInterlocuteur.civilite, 
            'prenom': $('#dialogPrenom').val(), 
            'date_creat':$('#dialogDate_creat').val(), 
            'date_MAJ': $('#dialogDate_MAJ').val(), 
            'inactif': $('#dialogInactif').val()}, 
  					dataType: "json",
            success: function(data){

              console.log(this.$refs.tableInterlocuteur)
              //this.$refs.tableInterlocuteur.append('')
              
        		}
  				});
        }
      },

      handleRetirerInterlocuteur(num_contac){
        var request = $.ajax({
          url: "../controller/action.php",
          async: false,
          type: "POST",
          data: {'removeInterlocuteur' : 1,'numAct': this.numAct,'num_contac':num_contac},
          dataType: "html",
          success: function(data){
            console.log('update fini');
            location.reload();
          }
        });
      },

      handleSupprimerTache(rang){
        var request = $.ajax({
          url: "../controller/action.php",
          async: false,
          type: "POST",
          data: {'deleteTache' : 1,'numAct': this.numAct,'rang':rang},
          dataType: "html",
          success: function(data){
            console.log('update fini');
            location.reload();
          }
        });
      },
      
      recupInterlocuteursPotentiels(){
        this.dialogFormInterlocuteurVisible = true;
        var temp = this;
        var request = $.ajax({
          url: "../controller/action.php",
          async: false,
          type: "POST",
          data: {'recupListeInterlocuteurs' : 1,'numAct': this.numAct, 'tiers' : this.action['CDE_CLI']},
          dataType: "json",
          success: function(data){
            temp.listeInterlocteursPotentiels=data;
          }
        });
      },

      handleSelectionChange(val) {
        this.multipleSelection = val;
      },
      handleEnregistrementInterlocuteurs(){
        if (this.multipleSelection.length>0) {
          var temp= this;
          var request = $.ajax({
            url: "../controller/action.php",
            async: false,
            type: "POST",
            data: {'ajouterInterlocuteurs' : 1,'numAct': this.numAct, 'listeInterlocteurs' : this.multipleSelection},
            dataType: "json",
            success: function(data){
              temp.dialogFormInterlocuteurVisible = false;
              temp.listeInterlocteurs=data;
              temp.remplirVmodel();
            }
          });
        }
      },

      remplirVmodel(){
        for (var i = 0; i < this.listeInterlocteurs.length; i++) {
          this.interlocuteurs.interlocuteurs_ID[i]=!!parseInt(this.listeInterlocteurs[i].VU);
        }
        for (var i = 0; i < this.listeTaches.length; i++) {
          this.taches_LIB.taches_LIB_ID[i]=this.listeTaches[i].TACHE;
        }
        for (var i = 0; i < this.listeTaches.length; i++) {
          this.taches_OBS.taches_OBS_ID[i]=this.listeTaches[i].TEXTE;
        }
        for (var i = 0; i < this.listeTaches.length; i++) {
          this.taches_INT.taches_INT_ID[i]=this.listeTaches[i].RESSOURCE;
        }
        for (var i = 0; i < this.listeTaches.length; i++) {
          this.taches_PRE.taches_PRE_ID[i]=this.listeTaches[i].DTE_PREV;
        }
        for (var i = 0; i < this.listeTaches.length; i++) {
          this.taches_REA.taches_REA_ID[i]=this.listeTaches[i].DTE_REAL;
        }
      }
    },
    mounted(){
      this.remplirVmodel();
      this.reactiviteDetail=true;
      var vm=this;
      var request = $.ajax({
        url: "../controller/action.php",
        async: false,
        type: "POST",
        data: {'ongletBase' : 1,'action' : this.numAct},
        dataType: "json",
        success: function(data){
          if(data){
          for (var i = 0; i < data.length; i++) {
            var img = data[i]['data'].split(',');
            var contentType= img[0];
            var file_name=img[1];
            const byteCharacters = atob(img[2]);
            const byteNumbers = new Array(byteCharacters.length);
            for (let i = 0; i < byteCharacters.length; i++) {
                byteNumbers[i] = byteCharacters.charCodeAt(i);
            }
            const byteArray = new Uint8Array(byteNumbers);
            const blob = new Blob([byteArray], {type: contentType});
            var objectURL = URL.createObjectURL(blob);

            vm.fileList.push({'name': file_name,'url':objectURL})
          }
          }
        }
      });
    }
  }).$mount('#app');

  </script>
</html>