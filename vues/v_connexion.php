<div id="connexionClient" class="container mt-5">
<form method="POST" action="index.php?uc=gererClient&action=connection">
   <fieldset class="border px-5 mx-auto" style="width:500px">
      <legend class="mx-auto">Connexion</legend>
      <p class="form-group mx-auto" >
         <label for="mail" class="col-4">Mail :</label>
         <input id="mail" type="text" name="mail" style="width:250px" size="25" maxlenght="25" value="<?php echo $mail ?>">
      </p>
      <p class="form-group mx-auto">
         <label for="mdp" class="col-4">Mot de passe :</label>
         <input id="mdp" type="password" name="mdp" style="width:250px" size="25" maxlenght="25">
      </p>
	  	<p class="form-group mx-auto text-center">
         <input type="submit" class="btn btn-primary" value="Valider" name="valider">
         <input type="reset" class="btn btn-default border" value="Annuler" name="annuler"> 
      </p>
	</fieldset>
</form>
</div>