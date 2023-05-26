<div id="connexionAdmin" class="container mt-5">
<form method="POST" action="index.php?uc=administrer&action=connection">
   <fieldset class="border px-5 mx-auto" style="width:500px">
     <legend class="mx-auto">Connexion Administration</legend>
      <p class="form-group mx-auto">
         <label for="mail" class="col-4">Mail :</label>
         <input id="mail" type="text"  name="mail" style="width:250px" size ="25" maxlength="25">
      </p>
      <p class="form-group mx-auto">
         <label for="mdp" class="col-4">Mot de passe :</label>
         <input id="mdp" type="password"  name="mdp" style="width:250px" size ="25" maxlength="100">
      </p>
	  	<p class="form-group mx-auto text-center">
         <input type="submit" value="Valider" name="valider">
         <input type="reset" value="Annuler" name="annuler"> 
      </p>
	  </fieldset>
</form>
</div>