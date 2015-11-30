<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>KDO Maroc</title>
        <link rel="stylesheet" href="bootstrap.min.css" />
        <link rel="stylesheet" href="style.css" />


    </head>
    <body>

      <div class="container">
        <div class="page-header">
          <h1 class="text-center">Distribution de cadeaux - Adminsitration</h1>
        </div>

        <div>
          <?php
          require 'sql.php';



          function print_warning($string){
              echo  '<div class="alert alert-warning">'.$string.'</div>';
          }
          function print_info($string){
            echo  '<div class="alert alert-info">'.$string.'</div>';
          }
          function print_error($string){
            echo  '<div class="alert alert-danger">'.$string.'</div>';
          }

          function print_list(){
            global $db;
            $sql ='select * from users';
            $ret = $db->query($sql);
            echo '<table class="table table-striped"><tr><th>#</th><th>Nom</th><th>Hash</th><th>Cible</th></tr>';
            while($row = $ret->fetchArray(SQLITE3_ASSOC)){
                echo '<tr><td>'.$row['id'].'</td><td>'.$row['firstname']
                      .'</td><td>'.$row['hash'].'</td><td>'.$row['target'].'</tr>';
            }
            echo '</table>';
          }
          print_list();
          ?>
        </div>
        <form role="form" method="POST" action="traitement.php">
        <div class="row" style="margin-top:20px">
          <div class="col-md-3 col-xs-2"></div>
          <div class="col-md-6 col-xs-8">
             <div class="input-group centered">
               <input type="text" id="firstname" name="firstname"  class="form-control text-center" placeholder="Prénom Nom" autofocus>
               <span class="input-group-btn">
                 <button class="btn btn-success" type="submit" name="add">Ajouter</button>
               </span>
             </div><!-- /input-group -->
           </div>
         </div>

         <div class="row">
           <div class="col-md-3 col-xs-2"></div>
           <div class="col-md-6 col-xs-8">
         <?php
          if (isset($_GET['unset'])){

            print_error("Pas de nom défini");
          }
          if (isset($_GET['empty'])){
            print_error("Chaîne vide !");
          }
          if (isset($_GET['doublon'])){
            print_error("Ce nom est déjà pris.");
          }
         ?>
         </div>
       </div>
       </form>



     <form role="form" method="POST" action="traitement.php">
       <div class="row" style="margin-top:20px">
         <div class="col-md-3 col-xs-2"></div>
          <div class="col-md-6 col-xs-8">
            <button style="display: block; width: 100%;" class="btn btn-info" name="shuffle" type="submit">Mélanger</button>
        </div>
      </div>
      <div class="row" style="margin-top:20px">
        <div class="col-md-3 col-xs-2"></div>
        <div class="col-md-6 col-xs-8">
          <div style="display: block; width: 100%;"  class="btn-group" role="group">
            <button style="display: block; width: 50%;" class="btn btn-warning" type="submit" name="last">Supprimer dernier</button>
            <button style="display: block; width: 50%;" class="btn btn-danger" type="submit" name="all">Tout supprimer</button>
          </div>
        </div>
      </div>
       <div class="row">
         <div class="col-md-3 col-xs-2"></div>
         <div class="col-md-6 col-xs-8">
         <?php
          if ((isset($_GET['deleted'])) && ($_GET['deleted'] == "last")){
            print_warning("N'oubliez pas de (re)mélanger !");
          }
         ?>
       </div>
    </form>




      <script src="jquery.js"></script>
      <script src="bootstrap.min.js"></script>
      <?php
      $db->close();
      unset($db); ?>
    </body>
  </html>
