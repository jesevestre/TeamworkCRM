<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../view/css/style.css">
    <script type="text/javascript" src="../js/vue.js"></script>

    <script src="../js/element-ui.js"></script>
    <script src="../js/element-ui-fr.js"></script>
    <link rel="stylesheet" type="text/css" href="../view/css/theme/element-ui.css">
    <script>
      ELEMENT.locale(ELEMENT.lang.fr)
    </script>
    <title>Squalp CRM</title>
  </head>
  <body>

    <div class="app" id="app" v-cloak>
      <div class="table-container">
        <el-input
          v-model="search"
          placeholder="Rechercher"
          prefix-icon="custom-icon el-icon-search"
          class="barreDeRecherche">
        </el-input>

        <el-table
         :data="tableData.filter(data => !search 
         || data.CDE_CLI.toLowerCase().includes(search.toLowerCase()) 
         || data.LIB_TYPE.toLowerCase().includes(search.toLowerCase())
         || data.NOM_CLI.toLowerCase().includes(search.toLowerCase())
         || data.ADRESSE_COMPLETE_CLIENT.toLowerCase().includes(search.toLowerCase()))"
         style="width: 100%"
         stripe
         height=95%
         class="tableCenter"
         
         empty-text="Aucun résultat !">
         <el-table-column
           prop="LIB_TYPE"
           label="Type"
           :filters="[{text: 'Client', value: 'Client'}, {text: 'Prospect', value: 'Prospect'}]"
           :filter-method="filterHandler"
           width="90"
           sortable>
         </el-table-column>
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
            text-align= "center"
            sortable>
          </el-table-column>
          <el-table-column
            prop="ADRESSE_COMPLETE_CLIENT"
            label="Adresse complète"
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
  <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
  <script type="text/javascript">

  new Vue({
    data: {
      tableData: <?php echo json_encode($listeClients);?>,
      search :'',
    },
    methods:{
      filterHandler(value, row){
        return row.LIB_TYPE === value;
      }
    }
  }).$mount('#app');

  </script>
</html>
