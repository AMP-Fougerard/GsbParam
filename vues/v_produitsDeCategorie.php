<div id="produits">

<?php
// parcours du tableau contenant les produits à afficher
foreach( $lesProduits as $unProduit) 
{ 	// récupération des informations du produit
	$id = $unProduit['id'];
	$description = $unProduit['description'];
	$prix=$unProduit['prix'];
	$image = $unProduit['image'];
	// affichage d'un produit avec ses informations
	?>	
	<div class="card">
			<div class="photoCard"><img src="<?php echo $image ?>" alt=image /></div>
			<div class="descrCard"><?php echo $description ?></div>
			<div class="prixCard"><?php echo $prix."€" ?></div>
			<?php if ($_REQUEST['uc'] == 'administrer') {?>
				<div class="imgCard">
					<a href="index.php?uc=administrer&categorie=<?php echo $categorie ?>&produit=<?php echo $id ?>&action=modifierProduit">
						<img src="images/edit.png" TITLE="Modifier le produit" alt="Modifier"> 
					</a>
					<a href="index.php?uc=administrer&categorie=<?php echo $categorie ?>&produit=<?php echo $id ?>&action=effacerProduit">
						<img src="images/bin.png" TITLE="Effacer le produit" alt="Effacer" onclick="return confirm('Voulez-vous vraiment supprimer ce produit ?');"> 
					</a>
				</div>
			<?php } else { ?>
				<div class="imgCard">
					<a href="index.php?uc=voirProduits&categorie=<?php echo $categorie ?>&produit=<?php echo $id ?>&action=ajouterAuPanier">
						<img src="images/mettrepanier.png" TITLE="Ajouter au panier" alt="Mettre au panier"> 
					</a>
				</div>
			<?php } ?>
				
	</div>
<?php			
} // fin du foreach qui parcourt les produits
?>
</div>
