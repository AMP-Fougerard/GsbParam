<?php
session_start();
require_once("../modele/fonctions.inc.php");
require_once("../modele/fonctions.inc.php");
require_once("../modele/bd.produits.inc.php");
?>

<h1>TEST</h1>
<lu>
	<li>cliquer sur le bouton "Nos produits"</li>
	<li>cliquer sur le bouton "Nos produits par catégorie"</li>
	<!-- <li></li> -->
</lu>

<?php
// test accès à la table catégorie
	var_dump(getLesCategories());
// test accès à la table produits
	var_dump(getLesProduits());


?>