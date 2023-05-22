<div id="produits" class="container">
<?php
// parcours du tableau contenant les produits à afficher
foreach( $lesProduits as $unProduit) 
{ 	// récupération des informations du produit
	$id = $unProduit['id'];
	$libel = $unProduit['libelle'];
	$description = $unProduit['description'];
	$prix=$unProduit['prix'];
	$image = $unProduit['image'];
	$marque = $unProduit['nom_marque'];
	$stock = $unProduit['stock'];

	if(getNbrAvisProduit($id)){
		$avis=getNbrAvisProduit($id);
		$moy=round(getMoyNoteAvisProduit($id));
	} else {
		$avis=0;
		$moy=0;
	}
	// affichage d'un produit avec ses informations
	?>	
	<div class="cards card py-0" style="width:275px;height:400px;">
		<div class="card-body">
		    <h4 class="card-title text-success"><?php echo $marque ?></h4>
		    <p class="card-text"><?php echo $libel ?></p>
		    <div class="container">
		    	<img src="assets/<?php echo $image ?>" class="mx-auto d-block" alt=image style="width:50%;height:50%" />
		    </div>
		    <p class="card-text py-auto" style="height:50px;"><?php echo $description ?></p>
		    <!--<div class="container">
		    	<?php for ($i=0; $i < 5 ; $i++) { 
		    		if($moy>$i){
			    		echo '<span class="fa fa-star checked"></span>';
			    	} else {
			    		echo '<span class="fa fa-star"></span>';
			    	}
		    	}	
				echo " ".$avis; ?> avis
		    </div>-->
		</div>
		<div class="row py-2 border-dark text-center" style="background-color:#EEEEEE;">
			<div class="col">A partir de<br/><?php echo $prix."€" ?></div>
			<?php if($stock>1) {
				echo "<div class=\"col text-success my-auto\">En Stock</div>";
			} else {
				echo "<div class=\"col text-danger my-auto\">En Rupture</div>";
			} ?>
			<div class="col my-auto" >
				<a href="index.php?uc=voirProduits&action=voirUnProduit&produit=<?php echo $id ?>" class="btn border-success text-success">voir</a>
			</div>
		</div>
	</div>
<?php			
} // fin du foreach qui parcourt les produits
?>
</div>
