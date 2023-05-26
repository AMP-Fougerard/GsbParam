<div id="bandeau">
<!-- Images En-tête -->
<img src="assets/images/logo_admin.jpg" alt="GsbLogo" title="GsbLogo"/>
</div>
<!-- Phrase de connection -->
<?php $element = '<li><a href="index.php?uc=accueil"> Accueil </a></li>';
if(isset($_SESSION['admin']))
{
   echo '<h3> Administrateur : '.getNomAdmin($_SESSION['admin']).'</h3>';
   $element = $element.'<li><a href="index.php?uc=administrer&action=voirCategories"> Voir produit </a></li><li><a href="index.php?uc=administrer&action=rajouterProduit"> Rajouter un produit </a></li><li><a href="index.php?uc=administrer&action=seDeconnecter"> Se déconnecter </a></li>';
 } ?>
<ul id="menu">
   <?php echo $element  ?>
</ul>
<br/>