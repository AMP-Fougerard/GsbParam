<div id="formulaireProduit">
<form method="POST" action="index.php?uc=administrer&action=confirmerProduit" enctype="multipart/form-data">
   <fieldset>
     <legend>Fiche produit</legend>
     <!-- permet de récupérer l'ancienne id -->
     <input type="hidden" id="id" name="id" value="<?php echo $id ?>">
		<p>
			<label for="desc">Description*</label>
			<textarea id="desc" name="desc" cols="25" rows="3"><?php echo $desc ?></textarea>
		</p>
      <p>
         <label for="prix">Prix*</label>
         <input id="prix" type="number" name="prix" value="<?php echo $prix ?>" min="0.01" size="10" step="0.01">
      </p>
		<p>
			<label for="img">Image*</label>
         <input id="img" type="file" name="img" accept="image/png, .jpeg, .jpg, image/gif">
         <?php if ($img != ''){
            echo 'lien actuel : '.$img; 
            echo '<BR/>';
            echo '<img src="'.$img.'" alt=image />';
         } ?>
		</p>
      <!-- permet de récupérer l'ancienne image si rien n'est sélectionné dans le input 'file' -->
      <input type="hidden" id="img" name="img" value="<?php echo $img ?>">
		<p>
         <label for="categ">Catégorie*</label>
         <select id="categ" name="categ">
            <?php $lesCategories = getLesCategories();
               foreach($lesCategories as $uneCategorie){
                  $idCategorie = $uneCategorie['id'];
                  $libCategorie = $uneCategorie['libelle'];
                  if($categ==$idCategorie)
                     echo '<option value="'.$idCategorie.'" selected >'.$libCategorie.'</option>';
                  else
                     echo '<option value="'.$idCategorie.'" >'.$libCategorie.'</option>';
               }
            ?>
         </select>
      </p>
	  	<p>
         <input type="submit" value="Valider" name="valider">
         <?php if(isset($leProduit)){
            $value = 'Réinitialiser';
         } else {
            $value = 'Annuler';
         }      
          ?>
          <input type="reset" value="<?php echo $value; ?>" name="<?php echo strtolower($value); ?>"> 
      </p>
	  </fieldset>
</form>
</div>