<?php

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

function myShuffle(){
  $n = getNum();
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

function checkShuffle(){
  global $db;
  $sql ='select * from users';
  $n = getNum();
  $ret = $db->query($sql);
  while($row = $ret->fetchArray(SQLITE3_ASSOC)){
      $tab[intval($row['id'])]=intval($row['target']);
  }
  for ($i = 1; $i <= $n ; $i++){
    if (($tab[$i]<1)||($tab[$i]>$n)){
      //echo $tab[$i].'pas entier';
      return false;

    }
    else if ($tab[$i]==$i){
      //echo 'pas dérangement';
      return false;
    }
  }
  for ($i = 1; $i <= $n ; $i++){
    for ($j = 1; $j < $i ; $j++){
      if ($tab[$i]==$tab[$j]){
        //echo 'pas permutation';
        return false;
      }
    }
  }
    return true;
}

 ?>
