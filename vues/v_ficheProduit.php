<script>
	function infoPrixStock(){
		liste = document.getElementById("contenance");
        idOption = liste.options[liste.selectedIndex].id;
        //console.log(idOption);
        elements = idOption.split(" ");
        prix = elements[1];
        stock = elements[2];
        if(stock<1){
        	text="Rupture de Stock";
        } else {
        	if(stock<=10){
        		text="En Stock (plus que "+stock+")";
        	} else {
        		text="En Stock";
        	}
        	document.getElementById("qte").setAttribute("max",stock);
        	if(parseInt(document.getElementById("qte").value, 10)>stock) {document.getElementById("qte").value=stock;}
        }
		document.getElementById("prixProduitContenance").innerHTML = "<b class=\"text-success\">"+prix+"€</b> - "+text;
	}
</script>
<article class="container mb-5" style="border: #CCC 1px solid; width: 50%;">
	<form method="POST" action="index.php?uc=gererPanier&action=ajouterAuPanier&categorie=<?php echo $idCateg ;?>&produit=<?php echo $id ;?>&cont=<?php echo $cont ;?>">
		<div class="row pt-1 justify-content-center align-items-center">
			<div class="col mx-auto">
				<img src="assets/<?php echo $image; ?>" alt="image descriptive" />
			</div>
			<div class="col">
				<h3 class="text-center text-success"><?php echo $libel; ?></h3>
				<p class="text-center"><b>Produit de la marque <?php echo $marque; ?> de la catégorie <?php echo $nomCat; ?></b></p>
				<p><u>Description :</u></p>
				<p class="small"><?php echo $description; ?></p>
				<!--<div class="container">
			    	<?php for ($i=0; $i < 5 ; $i++) { 
			    		if($moy>$i){
				    		echo '<span class="fa fa-star checked"></span>';
				    	} else {
				    		echo '<span class="fa fa-star"></span>';
				    	}
			    	}	
					echo " ".$avis; ?> avis
			    </div>
			    <a href="index.php?uc=voirProduits&action=donnerAvis"></a>-->
				<hr>
				<div class="form-group row">	
					<label for="contenance" class="my-auto" style="width:120px">Contenance :</label>
					<?php if($maxVariante>1) { ?>
						<select id="contenance" name="contenance" class="form-select my-auto" onchange="infoPrixStock();" style="width:150px">
							<?php foreach ($info as $idCont => $infoCont){
								if ($infoCont['isBase']){
									echo '<option value="'.$idCont.'" id="'.$idCont." ".$infoCont['prix']." ".$infoCont['stock'].'" class="text-center" selected >'.$infoCont['qte'].' '.$infoCont['unit'].'</option>';
								} else {
									echo '<option value="'.$idCont.'" id="'.$idCont." ".$infoCont['prix']." ".$infoCont['stock'].'" class="text-center" >'.$infoCont['qte'].' '.$infoCont['unit'].'</option>';
								}
							} ?>
						</select>
						<br><br>
						<?php echo "<p id=\"prixProduitContenance\"><b class=\"text-success\">".$prix."€</b> - ";
						if ($max<1)
							echo "Rupture de Stock</p>";
						else
							if ($max<=10)
								echo "En Stock (plus que ".$max.")</p>";
							else
								echo "En Stock</p>"; ?>
					<?php } else { 
						echo '<p class="col my-auto">'.$qte.' '.$unit.'</p>';
						echo "<p><b class=\"text-success\">".$prix."€</b> - "; 
						if ($max<1)
							echo "Rupture de Stock</p>";
						else
							if ($max<=10)
								echo "En Stock (plus que ".$max.")</p>";
							else
								echo "En Stock</p>";
					} ?>
				</div>
				<div class="input-group mb-4 mx-auto" style="width: 250px;">
				<?php if ($max<1) { ?>	
					<div class="input-group-append">
						<button disabled type="submit" class="btn btn-success" onclick="return false"> 
							Rajouter au panier <img src="assets/images/mettrepanier.png" TITLE="Ajouter au panier" alt="Mettre au panier"> 
						</button>
					</div>
				<?php } else { ?>
					<input id="qte" name="qte" type="number" class="form-control"  min="1" max="<?php echo $max; ?>" value="<?php echo $val; ?>" />
					<div class="input-group-append">
						<button type="submit" class="btn btn-success"> 
							Rajouter au panier <img src="assets/images/mettrepanier.png" TITLE="Ajouter au panier" alt="Mettre au panier" /> 
						</button>
					</div>
				<?php } ?>	
				</div>
				<div class="row py-2 border-dark text-center" style="background-color:#EEEEEE;">
					<input class="btn text-success border-success m-auto" style="width: 100px;" type="button" onclick="history.go(-1)" value="Retour" name="retour">
				</div>
			</div>
		</div>
	</form>
</article>