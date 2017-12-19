<!DOCTYPE html>
<html>
<head>
    <meta charset=utf-8 />
    <title>Pictionnary</title>
    <link rel="stylesheet" media="screen" href="css/styles.css" >
    <link rel="stylesheet" media="screen" href="css/w3.css" >
</head>
  <body>
<div class="w3-display-container " style="height:50px">
<div class="w3-container w3-black">
<div class="w3-bar">
<div class="w3-bar-item"> Pictionnary </div>
<?php
// on démarre la session, si l'utilisateur n'est pas connecté alors on redirige vers la page main.php.
session_start();
if(!isset($_SESSION['prenom'])) {
    header("Location: main.php");
}
echo '<div class="w3-bar-item w3-right">Bonjour ' .$_SESSION['prenom'].' '.$_SESSION['nom'].'<br/></div>';
echo '<div class="w3-bar-item w3-right"><img src="'.$_SESSION['profilepic'].'" alt="photo de profil" id="photo_profil" style="width:50px; height:50px;"> <br/> </div>';
echo '<div class="w3-bar-item w3-left"><a href=\'./logout.php\'>Se déconnecter</a></div>';
echo '</div></div></div>';
?>
    <script>

        // les quatre tailles de pinceau possible.
        var sizes=[8,20,44,90];
        // la taille et la couleur du pinceau
        var size, color;
        // la dernière position du stylo
        var x0, y0;
        // le tableau de commandes de dessin à envoyer au serveur lors de la validation du dessin
        var drawingCommands = [];

        var setColor = function() {
            // on récupère la valeur du champs couleur
            color = document.getElementById('color').value;
            console.log("color:" + color);
        }

        var setSize = function() {
            // ici, récupèrez la taille dans le tableau de tailles, en fonction de la valeur choisie dans le champs taille.
            size = document.getElementById('size');
            if (size.value == 0){
              size = sizes[0];
            }
            else if (size.value == 1){
              size = sizes[1];
            }
            else if (size.value == 2){
              size = sizes[2];
            }
            else if (size.value == 3){
              size = sizes[3];
            }

            console.log("size:" + size);
        }


        window.onload = function() {
            var canvas = document.getElementById('myCanvas');
            canvas.width = 400;
            canvas.height= 400;
            var context = canvas.getContext('2d');

            setSize();
            setColor();
            document.getElementById('size').onchange = setSize;
            document.getElementById('color').onchange = setColor;

            var isDrawing = false;

            var startDrawing = function(e) {
                console.log("start");
                // crér un nouvel objet qui représente une commande de type "start", avec la position, la couleur
                var command = {};
                command.command="start";
                command.x=e.x;
                command.y = e.y;
                command.couleur = e.couleur;
                command.position = e.position;
                //c'est équivalent à:
                //command = {"command":"start", "x": e.x, ...};

                // Ce genre d'objet Javascript simple est nommé JSON. Pour apprendre ce qu'est le JSON, c.f. http://blog.xebia.fr/2008/05/29/introduction-a-json/

                // on l'ajoute à la liste des commandes
                drawingCommands.push(command);

                var newPos = getMousePos(canvas, e);

                // ici, dessinez un cercle de la bonne couleur, de la bonne taille, et au bon endroit.
                context.beginPath();
                context.lineWidth="2";
                context.fillStyle=color;
                context.arc(newPos.x, newPos.y, size, 0, 2 * Math.PI);
                context.fill();
                isDrawing = true;
            }

            var stopDrawing = function(e) {
                console.log("stop");
                isDrawing = false;
            }

            var draw = function(e) {
                if(isDrawing) {
                  var command2 = {};
                  command2.command2 = "draw";
                  command2.position = e.position;

                  var newPos = getMousePos(canvas, e);

                  drawingCommands.push(command2);
                    // ici, créer un nouvel objet qui représente une commande de type "draw", avec la position, et l'ajouter à la liste des commandes.
                    // ici, dessinez un cercle de la bonne couleur, de la bonne taille, et au bon endroit.
                    context.beginPath();
                    context.lineWidth="2";
                    context.fillStyle=color;
                    context.arc(newPos.x, newPos.y, size, 0, 2 * Math.PI);
                    context.fill();
                }
            }

            canvas.onmousedown = startDrawing;
            canvas.onmouseout = stopDrawing;
            canvas.onmouseup = stopDrawing;
            canvas.onmousemove = draw;

            document.getElementById('restart').onclick = function() {
                var command3 = {};
                command3.command3 = "clear";
                console.log("clear");
                // ici ajouter à la liste des commandes une nouvelle commande de type "clear"
                // ici, effacer le context, grace à la méthode clearRect.
                context.clearRect(0, 0, canvas.width, canvas.height);
            };

            document.getElementById('validate').onclick = function() {
                // la prochaine ligne transforme la liste de commandes en une chaîne de caractères, et l'ajoute en valeur au champs "drawingCommands" pour l'envoyer au serveur.
                document.getElementById('drawingCommands').value = JSON.stringify(drawingCommands);

                // ici, exportez le contenu du canvas dans un data url, et ajoutez le en valeur au champs "picture" pour l'envoyer au serveur.
                var data = canvas.toDataURL();
                if (data != ''){
                  image = new Image();
                  image.src = data;
                  document.getElementById('picture').value = image;
                }
            };
        };
    </script>
</head>

<div class="w3-display-container " style="height:650px;">
<div class="w3-card-4 w3-display-middle">
<div class="w3-container">
<canvas id="myCanvas" style="border:1px solid #000000; margin-top: 75px;"></canvas>

<script>
  function getMousePos(canvas, evt) {
    var rect = canvas.getBoundingClientRect();
    return {
      x: evt.clientX - rect.left,
      y: evt.clientY - rect.top
    };
  }
  var canvas = document.getElementById('myCanvas');
  var context = canvas.getContext('2d');

  canvas.addEventListener('mousemove', function(evt) {
    var mousePos = getMousePos(canvas, evt);
    var message = 'Mouse position: ' + mousePos.x + ',' + mousePos.y;
  }, false);
</script>
<form name="tools" action="req_paint.php" method="POST">
    <!-- ici, insérez un champs de type range avec id="size", pour choisir un entier entre 0 et 4) -->
    <!-- ici, insérez un champs de type color avec id="color", et comme valeur l'attribut  de session couleur (à l'aide d'une commande php echo).) -->
    <input id="size" type="range" min="0" max="4"/>
    <input type="color" id="color" <?php echo 'value="#'.$_SESSION["couleur"].'"' ?> />
    <input id="restart" type="button" value="Recommencer"/>
    <input type="hidden" id="drawingCommands" name="drawingCommands"/>
    <!-- à quoi servent ces champs hidden ? -->
    <input type="hidden" id="picture" name="picture"/>
    <input id="validate" type="submit" value="Valider"/>
</form>
</div></div></div>
</body>
</html>
