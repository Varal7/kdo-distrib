<?php
require 'sql.php';
require 'tools.php';

function update($tab){
  global $db;
  $n = getNum();
  for ($i = 1; $i<= $n ; $i++){
    $statement = $db->prepare('UPDATE users SET target=:target WHERE id=:id;');
    $statement->bindValue(':target', $tab[$i]);
    $statement->bindValue(':id', $i);
    $statement->execute();
  }
  header('Location: admin.php?shuffled=1');
}

if(isset($_POST['all'])){
  $result = $db->exec("DELETE FROM users;");
  header('Location: admin.php?deleted=all');
}
else if(isset($_POST['last'])){
  $result = $db->exec("DELETE FROM users WHERE id = (SELECT MAX(id) FROM users)");
  header('Location: admin.php?deleted=last');
}
else if(isset($_POST['shuffle'])){
  update(myShuffle());
  header('Location: admin.php?shuffled=1');
}
else if(isset($_POST['add'])){
  if (!isset($_POST['firstname'])){
    $err = "unset";
    header('Location: admin.php?unset=1');
  }
  else if($_POST['firstname']==""){
    $err = "empty";
    header('Location: admin.php?empty=1');

  }
  else if(has_firstname($_POST['firstname'])){
    $err = "doublon";
    header('Location: admin.php?doublon=1');

  }
  else{
    $firstname=htmlspecialchars($_POST['firstname']);
    $hash = md5('maroc'.$firstname);
    $statement = $db->prepare('INSERT INTO users (id,firstname, hash) VALUES (:id, :firstname, :hash);');
    $statement->bindValue(':id',getNum()+1);
    $statement->bindValue(':firstname', $firstname);
    $statement->bindValue(':hash', $hash);
    $statement->execute();
    header('Location: admin.php?success=1');
  }
}
else{
  echo "Rien à faire ici !";
}

$db->close();
unset($db);

?>
