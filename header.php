<?php
session_start();
?>

<?php
if(isset($_SESSION['prenom'])){
  echo '<div class="w3-display-container " style="height:50px">';
  echo '<div class="w3-container w3-black">';
  echo '<div class="w3-bar">';
  echo '<div class="w3-bar-item"> Pictionnary </div>';
  echo '<div class="w3-bar-item w3-right">Bonjour ' .$_SESSION['prenom'].' '.$_SESSION['nom'].'<br/></div>';
  echo '<div class="w3-bar-item w3-right"><img src="'.$_SESSION['profilepic'].'" alt="photo de profil" id="photo_profil" style="width:50px; height:50px;"> <br/> </div>';
  echo '<div class="w3-bar-item w3-left"><a href=\'./logout.php\'>Se déconnecter</a></div>';
  echo '</div></div></div>';
}
else { ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>Pictionnary</title>
    <link rel="stylesheet" media="screen" href="css/styles.css" >
    <link rel="stylesheet" media="screen" href="css/w3.css" >
</head>
  <body>
      <h2>Connectez vous !</h2>
      <form class="inscription" method="POST" action="./req_login.php">
        <ul>
          <li>
            <label for="prenom">Prenom</label>
            <input type="text" name="prenom" id="prenom"/>
          </li>
          <li>
            <label for="pass">Mot de passe</label>
            <input type="password" name="pass" id="pass"/>
          </li>
          <li>
              <input type="submit" value="Soumettre Formulaire">
              <a href="./page_inscription.php">S'inscrire</a>
          </li>
        </ul>
      </form>
<?php
  }
?>
