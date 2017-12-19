<?php
  include('./header.php');
  include('./base.php');
  switch($_GET['action']){
    case "connect" :
      echo '
      <!DOCTYPE html>
      <html>
      <head>
          <meta charset=utf-8 />
          <title>Pictionnary</title>
          <link rel="stylesheet" media="screen" href="css/styles.css" >
          <link rel="stylesheet" media="screen" href="css/w3.css" >
      </head>
      ';
      break;
   case "nomatch":
      echo "L'identifiant ou le mot de passe rentré ne correspondent pas à un compte existant<br/>";
      echo "Veuillez réessayer ou vous inscrire";
      echo "</body>";
      echo "</html>";
      break;
    case "deconnexion":
      break;
    case "inscription":
    echo '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset=utf-8 />
        <title>Pictionnary</title>
        <link rel="stylesheet" media="screen" href="css/styles.css" >
        <link rel="stylesheet" media="screen" href="css/w3.css" >
    </head>
    <body>
    ';
      break;
  }

  if (isset($_SESSION['nom'])){
  $sql = $dbh->prepare("SELECT * FROM DRAWINGS WHERE id_createur = :id_createur");
  $sql->execute(array(
                'id_createur'=>$_SESSION['nom']));
  echo '<div class="w3-display-container " style="height:500px;">
        <div class="w3-card-4 w3-display-middle">
        <div class="w3-container">';
  echo '<ul class="w3-ul w3-center">';
  echo '          <li>
            <a href="./paint.php">Commencer un dessin</a>
            </li>';
  while ($dessin = $sql->fetch()) {
    echo '<li><a href="./guess.php?id='.$dessin['id'].'">Dessin n°' .$dessin['id'].' de '.$dessin['id_createur'].'</a></li>';
  }
  echo '</ul>';
  echo '</div></div></div>';
}
?>
  </body>
</html>
