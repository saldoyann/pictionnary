<?php
session_start();
include('./base.php');
if(!isset($_SESSION['id'])) {
    header("Location: main.php");
} else {
 // ici, récupérer la liste des commandes dans la table DRAWINGS avec l'identifiant $_GET['id']
 $sql = $dbh->prepare("SELECT id, command_dessin FROM DRAWINGS WHERE id = :id");
 $sql->execute(array(
              'id'=>$_GET['id']));
 // l'enregistrer dans la variable $commands
$commands = $sql->fetch();


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>Pictionnary</title>
    <link rel="stylesheet" media="screen" href="css/styles.css" >
    <script>
        // la taille et la couleur du pinceau
        var size, color;
        // la dernière position du stylo
        var x0, y0;
        // le tableau de commandes de dessin à envoyer au serveur lors de la validation du dessin
        var drawingCommands = <?php echo $commands;?>;

        window.onload = function() {
            var canvas = document.getElementById('myCanvas');
            canvas.width = 400;
            canvas.height= 400;
            var context = canvas.getContext('2d');

            var start = function(c) {
                // complétez
            }

            var draw = function(c) {
                // complétez
            }

            var clear = function() {
                // complétez
            }

            // étudiez ce bout de code
            var i = 0;
            var iterate = function() {
                if(i>=drawingCommands.length)
                    return;
                var c = drawingCommands[i];
                switch(c.command) {
                    case "start":
                        start(c);
                        break;
                    case "draw":
                        draw(c);
                        break;
                    case "clear":
                        clear();
                        break;
                    default:
                        console.error("cette commande n'existe pas "+ c.command);
                }
                i++;
                setTimeout(iterate,30);
            };

            iterate();

        };

    </script>
</head>
<body>
<canvas id="myCanvas"></canvas>
</body>
</html>
}
