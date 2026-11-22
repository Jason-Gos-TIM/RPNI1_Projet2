<?php

$niveau = "";

include("$niveau" . "inc/config.inc.php");

$strRequete = $pdoConnexion->prepare("SELECT courriel, mot_de_passe FROM t_utilisateur");
$strRequete->execute();
$arrComptes = $strRequete->fetchAll();

var_dump($arrComptes);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include($niveau . "inc/fragments/head_links.php") ?>
    <title>Connexion</title>
    

</head>
<body>
    <?php include($niveau . "inc/fragments/navigation.php") ?>
    
</body>
</html>