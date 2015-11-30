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



  <div class="container">
    <div class="page-header">
      <h1 class="text-center">Distribution des cadeaux</h1>
    </div>
    <h2 class="lead text-center">Brace yourselves. New year gifts are coming.</p>
    <?php
    require 'sql.php';



    function find_hash($hash) {
      global $db_id_target, $db_firstname, $db;
      $sql ='select * from users';
      $ret = $db->query($sql);
      while($row = $ret->fetchArray(SQLITE3_ASSOC)){
          if (md5('maroc'.$row['firstname']) == $hash){
              $db_id_target = $row['target'];
              $db_firstname = $row['firstname'];
              return true;
          }
      }
      return false;
    }

    function find_firstname_from_id($id) {
      global $db_target, $db;
      $sql ='select * from users';
      $ret = $db->query($sql);
      while($row = $ret->fetchArray(SQLITE3_ASSOC)){
        if ($id == $row['id']){
            $db_target = $row['firstname'];
            return true;
        }
       }
     }


    function print_warning($string){
        echo  '<div class="alert alert-warning">'.$string.'</div>';
    }
    function print_info($string){
      echo  '<div class="alert alert-info">'.$string.'</div>';
    }
    function print_error($string){
      echo  '<div class="alert alert-danger">'.$string.'</div>';
    }

    if (!isset($_GET['hash'])){
        print_warning("Tu n'as pas cliqué sur le bon lien ! (pas de hash)");
    }
    else if(!find_hash($_GET['hash'])){
        print_warning("Tu n'as pas cliqué sur le bon lien ! (hash incorrect)");
    }
    else if(!find_firstname_from_id($db_id_target)){
        print_error("Il n'y a pas de cible associée ! C'est étrange. Contacte Victor au plus vite.");
    }
    else{
    ?>



    <div class="row" style="margin-top:20px">
      <div class="col-md-3 col-xs-2"></div>
      <div class="col-md-6 col-xs-8">
         <div class="input-group centered">
           <span class="input-group-addon" id="basic-addon3">Je suis</span>

           <input type="text" id="firstname" name="firstname"  class="form-control text-center" placeholder="Ton prénom" disabled value="<?php echo $db_firstname; ?>">
           <span class="input-group-btn">
             <button class="btn btn-success" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" autofocus>
               <span class="glyphicon glyphicon-ok" style="margin-right:10px;" aria-hidden="true"></span>
               Confimer</button>
           </span>
         </div><!-- /input-group -->
         <div class="collapse" id="collapseExample">
           <div class="well">
             <span class="glyphicon glyphicon-gift" style="margin-right:10px;" aria-hidden="true"></span>
             <p>J'aurai le plaisir d'offir un cadeau à <strong><?php echo $db_target; ?>.</strong></p>
           </div>
         </div>
       </div><!-- /.col-lg-6 -->
     </div>


     <?php
   }

   $db->close();
   unset($db);
   ?>


    </div>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
