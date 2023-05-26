<div id="inscriptionClient container">
<form method="POST" action="index.php?uc=gererClient&action=inscription">
   <fieldset class="border px-5 mx-auto my-4" style="width:600px">
     <legend class="mx-auto">Inscription</legend>
     <p class="text-danger"><b>*</b> = obligatoire</p>
		<p class="form-group mx-auto">
			<label for="nom" class="col-3">Nom*</label>
			<input id="nom" type="text" name="nom" style="width:300px" value="<?php echo $nom ?>" size="30" maxlength="45">
		</p>
      <p class="form-group mx-auto">
         <label for="prenom" class="col-3">Prénom*</label>
         <input id="prenom" type="text" name="prenom" style="width:300px" value="<?php echo $prenom ?>" size="30" maxlength="45">
      </p>
		<p class="form-group mx-auto">
			<label for="rue" class="col-3">Rue*</label>
			<input id="rue" type="text" name="rue" style="width:300px" value="<?php echo $rue ?>" size="30" maxlength="45">
		</p>
		<p class="form-group mx-auto">
         <label for="cp" class="col-3">Code postal* </label>
         <input id="cp" type="text" name="cp" style="width:300px" value="<?php echo $cp ?>" size="5" maxlength="5">
      </p>
      <p class="form-group mx-auto">
         <label for="ville" class="col-3">Ville* </label>
         <input id="ville" type="text" name="ville" style="width:300px" value="<?php echo $ville ?>" size="30" maxlength="30">
      </p>
      <p class="form-group mx-auto">
         <label for="mail" class="col-3">Mail* </label>
         <input id="mail" type="text" style="width:300px" name="mail" value="<?php echo $mail ?>" size ="25" maxlength="25">
      </p> 
      <p class="form-group mx-auto">
         <label for="mdp1" class="col-3">Mot de passe* </label>
         <input id="mdp1" type="password" style="width:300px" name="mdp1" size ="25" maxlength="50">
      </p>
      <p class="form-group mx-auto">
         <label for="mdp2" class="col-3">Mot de passe a retaper* </label>
         <input id="mdp2" type="password" style="width:300px" name="mdp2" size ="25" maxlength="50">
      </p>
	  	<p class="form-group mx-auto">
         <input type="submit" class="btn btn-primary" value="Valider" name="valider">
         <input type="reset" class="btn btn-default border" value="Annuler" name="annuler"> 
      </p>
	  </fieldset>
</form>
</div>