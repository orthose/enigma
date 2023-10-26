<?php session_start(); ?>
<!doctype html>
<html lang="fr">
<head>
  <?php require_once("./templates.php"); head(); ?>
  <script>
    function addField(tag) {
        const curField = tag.parentNode;
        if (curField.children[1].value !== "") {
            const nextField = curField.cloneNode(true);
            const nextName = parseInt(curField.children[1].name)+1;
            nextField.children[0].htmlFor = nextName;
            nextField.children[0].textContent = nextName;
            nextField.children[1].name = nextName;
            nextField.children[1].value = "";
            curField.after(nextField);
            tag.remove();
        }
    }
  </script>
</head>
<body>
<h1>Enigma</h1>
<?php
require_once("./config.php");

// Le token est-il valide ?
if (isset($_POST["token"])) {
    $_SESSION["connect"] = $config["token"] === $_POST["token"];
}

// Demande de déconnexion
else if (isset($_GET["logout"])) {
    unset($_SESSION);
    session_destroy();
}

// L'administrateur est-il connecté ?
if (!(isset($_SESSION["connect"]) && $_SESSION["connect"])) {
    echo <<<XML
    <form action='' method='post'>
    <field><input type='password' name='token' /></field>
    <input type='submit' value='Connexion' /></form>
    XML;
}

// L'administrateur est connecté 
else {
    // Suppression d'une énigme
    if (isset($_GET["del"]) && file_exists("./data/".$_GET["del"].".json")) { 
        unlink("./data/".$_GET["del"].".json"); 
    }
    // Création d'une nouvelle énigme
    else if (isset($_POST["new"]) && $_POST["new"] !== "") {
        $new = htmlspecialchars($_POST["new"]); unset($_POST["new"]);
        $reward = htmlspecialchars($_POST["reward"]); unset($_POST["reward"]);
        $passwords = array_filter($_POST, function($v) { return $v !== ""; });
        //$passwords = array_map(function($v) { return htmlspecialchars($v); }, $passwords);
        $data = array("passwords" => array_values($passwords), "reward" => $reward);
        file_put_contents("./data/".$new.".json", json_encode($data));
    }
    // Page de création d'une nouvelle énigme
    if (isset($_GET["new"]) && $_GET["new"] !== "") {
        $new = $_GET["new"];
        echo "<p id='enigma'>".$new."</p>";
        echo <<<XML
        <form action='admin.php' method='post'>
        <input type="hidden" name="new" value="$new" />
        <field><label for='1'>1</label><input type='text' name='1' />
        <input type='button' value='+' class="plus-button" onclick="addField(this)" 
            style="margin-top:0;margin-bottom:0;margin-right:15px" /></field>
        <field style="flex-direction:column">
        <label style="margin-top:20px;">Récompense</label>
        <textarea name="reward" rows="3" style="max-width:90%;"></textarea></field>
        <input type='submit' value='Envoyer' /></form>
        XML;
    }
    // Page de choix de création ou de suppression d'énigme
    else {
        echo <<<XML
        <form action='' method='get'>
        <field style="width:calc(100% - 80px);display:inline-block;margin-right:10px;">
        <input type='text' name='new' style="margin-left:0px" /></field>
        <input type='submit' value='+' class="plus-button" /></form>
        XML;

        echo "<form id='select-enigma' action='' method='get'>";
        $files = scandir("./data");
        foreach ($files as $fid) {
            if (!str_starts_with($fid, '.')) {
                $fid = pathinfo($fid, PATHINFO_FILENAME);
                echo "<field><input type='radio' id='$fid' name='del' value='$fid' /><label for='$fid'>$fid</label></field>";
            }
        }
        echo "<input type='submit' value='Supprimer' /></form>";
    }
}
?>
</body>
</html>