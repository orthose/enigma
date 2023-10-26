<!doctype html>
<html lang="fr">
<head>
  <?php require_once("./templates.php"); head(); ?>
</head>
<body>
<?php
// Paramètre ?id référençant le nom de fichier sans l'extension du répertoire data/
if (isset($_GET["id"]) && file_exists("./data/".$_GET["id"].".json")) {
    echo "<p id='enigma'>".$_GET["id"]."</p>";
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
        echo "<p class='reward'>".$enigma["reward"]."</p>";
    }
}
?>
</body>
</html>