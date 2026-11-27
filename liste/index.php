<?php

$niveau = "../";
$intNbListes = 0;

include("$niveau" . "inc/config.inc.php");

$intIdCompte = $_GET["id"] ?? 1;

$strRequete = $pdoConnexion->prepare("SELECT id_liste, nom_liste, id_couleur, id_utilisateur FROM t_liste WHERE id_utilisateur = :id");
$strRequete->execute([ "id" => $intIdCompte]);
$arrListes = $strRequete->fetchAll();


$strRequete = $pdoConnexion->prepare("SELECT id_couleur, hexadecimale FROM t_couleur");
$strRequete->execute();
$arrCouleurs = $strRequete->fetchAll();

$strRequete = $pdoConnexion->prepare("SELECT id_liste, COUNT(item) FROM t_item GROUP BY id_liste");
$strRequete->execute();
$arrItems = $strRequete->fetchAll();

$strRequete = $pdoConnexion->prepare("SELECT item, echeance, t_liste.id_couleur, hexadecimale, est_complete 
                                      FROM t_item   
                                      INNER JOIN t_liste ON t_liste.id_liste = t_item.id_liste
                                      INNER JOIN t_couleur ON t_couleur.id_couleur = t_liste.id_couleur
                                      WHERE echeance IS NOT NULL AND est_complete = false
                                      ORDER BY echeance ASC 
                                      LIMIT 3");
$strRequete->execute();
$arrItemsUrgent = $strRequete->fetchAll();
var_dump($arrItemsUrgent);

$arrCouleurs = array_column($arrCouleurs, 'hexadecimale', "id_couleur");
$arrItems = array_column($arrItems, 'COUNT(item)', "nom_liste");
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
    <h2>Urgent !</h2>
        <?php foreach($arrItemsUrgent as $arrItemUrgent) { ?>
        <li style="background-color:#<?php  echo $arrItemUrgent['hexadecimale'] ?>"><?php echo $arrItemUrgent['item'] . " " . $arrItemUrgent['echeance'] . " " . $arrItemUrgent['hexadecimale'] ?></li>
        <?php } ?>
    <h2>Listes :</h2>
    <?php foreach($arrListes as $arrListe) { ?>
        <form>
            <ul id="<?php echo 'list' .  $intNbListes ?>" style="background-color:#<?php  echo $arrCouleurs[$arrListe['id_couleur']] ?>" >
                <?php var_dump($arrListe["id_liste"]); ?>
                <input type="hidden" value="<?php echo $arrListe["id_liste"] ?>">
                <li >
                    <a href="item/index.php?id=<?php echo $arrListe['id_liste'] ?>">
                        <?php echo $arrListe['nom_liste'] ?>
                    </a>
                </li>
                <li><?php echo $arrCouleurs[$arrListe['id_couleur']] ?></li>
                <li><?php echo $arrItems[$arrListe["id_liste"]]?></li>  
                    
            </ul>
            <input type="submit" name="btn__supprimer" value="supprimer" formaction="" formmethod="GET"> 
        </form>
    <?php $intNbListes++;
    } ?>
</body>
</html>