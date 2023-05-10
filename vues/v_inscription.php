<div id="inscriptionClient container">
<form method="POST" action="index.php?uc=gererClient&action=inscription">
   <fieldset class="border px-5 mx-auto" style="width:600px">
     <legend class="mx-auto">Insciption</legend>
		<!--<p>
			<label for="nom">Nom*</label>
			<input id="nom" type="text" name="nom" value="<?php echo $nom ?>" size="30" maxlength="45">
		</p>
      <p>
         <label for="prenom">Prénom*</label>
         <input id="prenom" type="text" name="prenom" value="<?php echo $prenom ?>" size="30" maxlength="45">
      </p>
		<p>
			<label for="rue">rue*</label>
			 <input id="rue" type="text" name="rue" value="<?php echo $rue ?>" size="30" maxlength="45">
		</p>
		<p>
         <label for="cp">code postal* </label>
         <input id="cp" type="text" name="cp" value="<?php echo $cp ?>" size="5" maxlength="5">
      </p>
      <p>
         <label for="ville">ville* </label>
         <input id="ville" type="text" name="ville"  value="<?php echo $ville ?>" size="30" maxlength="30">
      </p>-->
      <p class="form-group mx-auto">
         <label for="mail" class="col-3">mail* </label>
         <input id="mail" type="text" style="width:300px" name="mail" value="<?php echo $mail ?>" size ="25" maxlength="25">
      </p> 
      <p class="form-group mx-auto">
         <label for="mdp1" class="col-3">mot de passe* </label>
         <input id="mdp1" type="password" style="width:300px" name="mdp1" size ="25" maxlength="50">
      </p>
      <p class="form-group mx-auto">
         <label for="mdp2" class="col-3">mot de passe a retaper* </label>
         <input id="mdp2" type="password" style="width:300px" name="mdp2" size ="25" maxlength="50">
      </p>
	  	<p class="form-group mx-auto">
         <input type="submit" class="btn btn-primary" value="Valider" name="valider">
         <input type="reset" class="btn btn-default border" value="Annuler" name="annuler"> 
      </p>
	  </fieldset>
</form>
</div>