<?php
  session_start();
  include('./base.php');
  $sql = $dbh->prepare("INSERT INTO DRAWINGS (id_createur, command_dessin, dessin) VALUES (:id_createur, :command_dessin, :dessin)");
  $sql->execute(array(
                'id_createur'=>$_SESSION['nom'],
                'command_dessin'=>$_POST['drawingCommands'],
                'dessin'=>$_POST['picture']
              ));
              
?>
