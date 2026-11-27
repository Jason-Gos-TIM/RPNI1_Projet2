<?php

$niveau = "../../";
$intNbItems = 0;

include("$niveau" . "inc/config.inc.php");

$intIdListe = $_GET["id"] ?? 1;

$strRequete = $pdoConnexion->prepare("SELECT id_item, item, echeance, est_complete FROM t_item WHERE id_liste = :id");
$strRequete->execute([ "id" => $intIdListe]);
$arrItems = $strRequete->fetchAll();
var_dump($arrItems);

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
        <?php foreach ($arrItems as $arrItem) { ?>
            <table id="<?php echo 'list' .  $intNbItems ?>">
                <tr>
                    <td>Nom:</td>
                    <td><?php echo $arrItem['item'] ?></td>
                </tr>
                <?php  if($arrItem['echeance'] != NULL) { ?>
                <tr>
                    <td>Échéance:</td>
                    <td><?php echo $arrItem['echeance'] ?></td>
                </tr>
                <?php } else {
                echo " ";
                } ?>
                <tr>
                    <td><a href="option_Item.php?id=<?php echo $arrItem['id_item']?>">Modifier l'item</a></td>
                </tr>
            </table>
        <?php $intNbItems++;
         } ?>
    
</body>
</html>