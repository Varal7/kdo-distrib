<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>KDO Maroc</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/style.css" />
        <link rel=icon href=gift.ico>



    </head>
    <body>
      <?php
      $url =  $_SERVER['HTTP_HOST'].str_replace('admin.php','index.php',$_SERVER['SCRIPT_NAME']);
      require 'sql.php';
      require 'tools.php';


      function print_warning($string){
          echo  '<div class="alert alert-warning"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
'.$string.'</div>';
      }
      function print_info($string){
        echo  '<div class="alert alert-info"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
'.$string.'</div>';
      }
      function print_error($string){
        echo  '<div class="alert alert-danger"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
'.$string.'</div>';
      }

      function print_list(){
        global $db, $url;
        $sql ='select * from users';
        $ret = $db->query($sql);
        echo '<table class="table table-striped"><tr><th>#</th><th>Nom</th><th>Hash</th>';
        if (isset($_GET['cheat'])){
            echo '<th>Cible</th></tr>';
        }
        while($row = $ret->fetchArray(SQLITE3_ASSOC)){
            echo '<tr><td>'.$row['id'].'</td><td>'.$row['firstname'].'</td>'
                .'<td><a data-toggle="collapse" data-target="#collapse'.$row['id'].'">'.$row['hash'].'</a>'
                .'<div class="collapse" id="collapse'.$row['id'].'">';
                ?>
                <div class="well">
                  <p>Cher <strong><?php echo $row['firstname'] ?></strong>,</p>
                  <p>À l'occasion du nouvel an 2016 qui aura lieu pendant notre marche
                    au Maroc, nous procéderons au tradionnel échange de cadeaux.</p>
                  <p>Découvre la personne à qui tu offriras ton cadeau en cliquant sur ce lien :
                  <a href="index.php?hash=<?php echo $row['hash']; ?>">http://<?php echo $url; ?>?hash=<?php echo $row['hash'] ?></a></p>

                <p> À très bientôt,<br/>
                Victor Quach</p>


                </div>
                <?php
            echo '<div>'
                .'</td>';
            if (isset($_GET['cheat'])){
                echo '<td>'.$row['target'];
            }
            echo '</tr>';
        }
        echo '</table>';
      }
       ?>

      <div class="container">
        <div class="page-header">
          <h1 class="text-center">Distribution de cadeaux - Adminsitration</h1>
        </div>

        <div class="row text-center">
          <?php
           if (!checkShuffle()){
             print_warning("L'attribution n'est pas/plus correcte ! N'oubliez pas de (re)mélanger.");
           }
          ?>
        </div>

        <div>
          <?php
          print_list();
          ?>
        </div>
        <form role="form" method="POST" action="traitement.php">
        <div class="row" style="margin-top:20px">
          <div class="col-md-2 col-xs-0"></div>
          <div class="col-md-8 col-xs-12">
             <div class="input-group centered">
               <input type="text" id="firstname" name="firstname"  class="form-control text-center" placeholder="Prénom Nom" autofocus>
               <span class="input-group-btn">
                 <button class="btn btn-success" type="submit" name="add">
                   <span class="glyphicon glyphicon-plus" style="margin-right:10px;" aria-hidden="true"></span>
                   Ajouter
                 </button>
               </span>
             </div><!-- /input-group -->
           </div>
         </div>

         <div class="row text-center">
           <div class="col-md-2 col-xs-0"></div>
           <div class="col-md-8 col-xs-12">
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
         <div class="col-md-2 col-xs-0"></div>
          <div class="col-md-8 col-xs-12">
            <button style="display: block; width: 100%;" class="btn btn-info" name="shuffle" type="submit">
              <span class="glyphicon glyphicon-random" style="margin-right:10px;" aria-hidden="true"></span>
              Mélanger
            </button>
        </div>
      </div>
      <div class="row" style="margin-top:20px">
        <div class="col-md-2 col-xs-0"></div>
        <div class="col-md-8 col-xs-12">
          <div style="display: block; width: 100%;"  class="btn-group" role="group">
            <button style="display: block; width: 50%;" class="btn btn-warning" type="submit" name="last">
              <span class="glyphicon glyphicon-remove" style="margin-right:10px;" aria-hidden="true"></span>
              Supprimer dernier
            </button>
            <button style="display: block; width: 50%;" class="btn btn-danger" type="submit" name="all">
              <span class="glyphicon glyphicon-trash" style="margin-right:10px;" aria-hidden="true"></span>
              Tout supprimer</button>
          </div>
        </div>
      </div>
    </form>

      <script src="js/jquery.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <?php
      $db->close();
      unset($db); ?>
    </body>
  </html>
