	<div class="mb-3">
		<!--<img src="images/panier.gif" alt="Panier" title="panier" />-->
		<h2 class="text-center text-success my-auto mx-auto" style="width:200px">Mon panier</h2>
	</div>
<article class="container-fluid mb-3">
	<div id="panier" class="container-fluid">
		<form method="POST" action="index.php?uc=gererPanier&action=passerCommande" class="row">
			<div class="col-8">
			<?php
			foreach($lesProduitsDuPanier as $unProduit) {
				// récupération des données d'un produit
				$id = $unProduit['id'];
				$idCont = $unProduit['id_contenance'];
				$idProduit=array("id"=>$id,"idCont"=>$idCont);
				$libel=$unProduit['libelle'];
				$description = $unProduit['description'];
				$image = $unProduit['image'];
				$prix = $unProduit['prix'];
				$marque= $unProduit['nom_marque'];
				$qte=$unProduit['qte'];
				$qtePanier = getQteProduit($idProduit,$mail);
				$unit = $unProduit['unit_intitule'];
				$max = getQteMax($idProduit);
				// affichage
			?>
				<div class="container card card-body row mb-3" style="width:100%;height:300px;min-width:500px;">
					<img src="assets/<?php echo $image; ?>" alt="image descriptive" class="m-auto" style="width:200px;height:200px;" />
					<div class="" style="width:60%;">
						<h3 class="card-title text-center text-success"><?php echo $marque; ?></h3>
						<p class="text-center">
							<b><?php echo $libel; ?></b>
						</p>
						<p class="card-text small"><?php echo $description; ?></p>
						<p class="card-text my-auto mb-3"><?php echo '<b class="text-success">'.$prix.'€</b> - '.$qte.' '.$unit; ?></p>
						<div class="form-group py-auto mb-3">
							<label for="qte" class="card-text my-auto">Quantite :</label>
							<input id="qte" name="qte" type="number" class="form-control my-auto"  min="1" max="<?php echo $max; ?>" value="<?php echo $qtePanier; ?>" style="width:60px;" />
						</div>
						<div class="form-group">
							<a href="index.php?uc=voirProduits&action=voirUnProduit&produit=<?php echo $id; ?>" class="btn btn-success">
								Voir
							</a>
							<a href="index.php?uc=gererPanier&produit=<?php echo $id; ?>&action=supprimerUnProduit" class="btn border-success text-success" onclick="return confirm('Voulez-vous vraiment retirer cet article ?');">
								Retirer 
								<img src="assets/images/retirerpanier.png" title="Retirer du panier" alt="retirer du panier" />
							</a>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
			<div class="border col-4">
				<div id="boutons">
					<div class="commande">
						<button type="submit" class="btn btn-success">
							Commander
						</button>
					</div>
					<div class="commande">
						<a href="index.php?uc=gererPanier&action=viderPanier" class="btn text-success border-success" onclick="return confirm('Voulez-vous vraiment vider tout votre panier ?');" >
							Vider panier
						</a>
					</div>
				</div>
			</div>
		</form>
	</div>
</article>