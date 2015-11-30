<?php
$db = new SQLite3('gifts.db');

function has_firstname($firstname) {
  global $db_id_target, $db_firstname, $db;
  $sql ='select * from users';
  $ret = $db->query($sql);
  while($row = $ret->fetchArray(SQLITE3_ASSOC)){
      if ($row['firstname'] == $firstname){
          return true;
      }
  }
  return false;
}

function getNum(){
  global $db;
  $result = $db->query("SELECT COUNT(*) as count FROM users");
  $row = $result->fetchArray();
  return $row['count'];
}

function myShuffle($n){
  for ($i = 1; $i<=$n ; $i++){
    $tab[$i]=$i;
  }
  for ($i = $n; $i>0 ; $i--){
     $j = rand(1,$i-1);
     $cur = $tab[$i];
     $tab[$i]=$tab[$j];
     $tab[$j]=$cur;
  }
  return $tab;
}

function update($tab,$n){
  global $db;
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
  $number_users = getNum();
  update(myShuffle($number_users),$number_users);
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
