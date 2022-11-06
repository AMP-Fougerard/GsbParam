<ul id="categories">
<?php
foreach( $lesCategories as $uneCategorie) 
{
	$idCategorie = $uneCategorie['id'];
	$libCategorie = $uneCategorie['libelle'];
	$uc=$_REQUEST['uc'];
?>
	<li>
		<a href="index.php?uc=<?php echo $uc ?>&categorie=<?php echo $idCategorie ?>&action=voirProduits">
		<?php echo $libCategorie ?></a>
	</li>
<?php
}
?>
</ul>

