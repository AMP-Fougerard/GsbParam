<div id="bandeau">
<!-- Images En-tête -->
<img src="assets/images/logo.jpg"	alt="GsbLogo" title="GsbLogo"/>
</div>
<!-- Phrase de connection -->
<h3> Bonjour, <?php echo strstr($_SESSION['mail'],'@',true); ?></h3>
<!--  Menu haut -->
<ul id="menu">
	<li><a href="index.php?uc=accueil"> Accueil </a></li>
	<li><a href="index.php?uc=voirProduits&action=voirCategories"> Nos produits par catégorie </a></li>
	<li><a href="index.php?uc=voirProduits&action=nosProduits"> Nos produits </a></li>
	<li><a href="index.php?uc=gererPanier&action=voirPanier"> Voir son panier </a></li>
	<li><a href="index.php?uc=gererClient&action=seDeconnecter"> Se déconnecter </a></li>
</ul>
<br>