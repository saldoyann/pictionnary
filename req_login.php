<?php
  include('./base.php');
  $prenom = $_POST['prenom'];
  $pass = $_POST['pass'];
  $sql = "SELECT * FROM users WHERE prenom = :prenom AND password = :pass ";
  $req = $dbh->prepare($sql);
  $req->execute(array(
        'prenom'=>$prenom,
        'pass'=>$pass));
  $infos = $req->fetch();
  if($infos){
    session_start();
    $_SESSION['nom'] = $infos['nom'];
    $_SESION['email'] = $infos['email'];
    $_SESSION['prenom'] = $infos['prenom'];
    $_SESSION['profilepic'] = $infos['profilepic'];
    $_SESSION['couleur'] = $infos['couleur'];
    header('Location: ./main.php?action=connect');
  } else {
    header('Location: ./main.php?action=nomatch');
  }
?>
