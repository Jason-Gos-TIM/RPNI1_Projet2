<?php

$niveau = "../";
$intNbListes = 0;

include("$niveau" . "inc/config.inc.php");

$intIdCompte = $_GET["id"] ?? 1;

$strRequete = $pdoConnexion->prepare("SELECT id_liste, nom_liste, id_couleur FROM t_liste WHERE id_utilisateur = :id");
$strRequete->execute([ "id" => $intIdCompte]);
$arrListes = $strRequete->fetchAll();


$strRequete = $pdoConnexion->prepare("SELECT id_couleur, hexadecimale FROM t_couleur");
$strRequete->execute();
$arrCouleurs = $strRequete->fetchAll();

$arrCouleurs = array_column($arrCouleurs, 'hexadecimale', 'id_couleur');
var_dump($arrCouleurs);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include($niveau . "inc/fragments/head_links.php") ?>
    <title>Document</title>

</head>
<body>
    <?php include($niveau . "inc/fragments/navigation.php") ?>

    <ul>
        <?php foreach($arrListes as $arrListe) { ?>
            <li style="background-color:<?php  echo $arrCouleurs[$arrListe['id_couleur']] ?>" 
                id="<?php echo 'list' .  $intNbListes ?>">
                <a href="item/index.php?id=<?php echo $arrListe['id_liste'] ?>">
                    <?php echo $arrListe['nom_liste'] ?>
                </a>
            </li>
        <?php $intNbListes++;
         } ?>
    </ul>
    
</body>
</html>