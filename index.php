<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Enigma</title>
  <!-- Responsive Web Site for smartphone -->
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <!-- Icônes -->
  <link rel="icon" type="image/png" href="favicon.png" sizes="512x512">
  <link rel="apple-touch-icon" type="image/png" href="favicon.png" sizes="512x512">
  <!-- Feuilles de style -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Ubuntu">
  <link href='style.css' rel='stylesheet'>
</head>
<body>
<?php
// Paramètre ?id référençant le nom de fichier sans l'extension du répertoire data/
if (isset($_GET["id"])) {
    echo "<h1>".$_GET["id"]."</h1>";
    echo "<form action='?id=".$_GET['id']."' method='post'>";
    $enigma = json_decode(file_get_contents("./data/".$_GET["id"].".json"), true);
    $npass = count($enigma["passwords"]);
    
    // Affichage des champs du formulaire
    for ($i = 0; $i < count($enigma["passwords"]); $i++) {
        // L'utilisateur a-t-il entré une réponse ?
        $value = isset($_POST[$i]) ? $_POST[$i] : "";
        // Le mot de passe de champ est-il correct ?
        $isvalid = $enigma["passwords"][$i] === $value;
        if ($isvalid) { $npass--; }
        // Style de l'entrée selon la classe
        $class = $value === "" ? "" : ($isvalid ? "good" : "bad");
        // Protection contre l'injection de script
        $value = htmlspecialchars($value, ENT_QUOTES);
        echo "<field><label for='$i'>".strval($i+1)."</label><input name='$i' type='text' value='$value' class='$class' /></field>";
    }
    echo "<input type='submit' value='Envoyer' />";
    echo "</form>";
    
    // Si tous les champs ont été trouvés alors la récompense est affichée
    if ($npass === 0) {
        echo "<p>".$enigma["reward"]."</p>";
    }
}
?>
</body>
</html>