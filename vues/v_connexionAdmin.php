<div id="connexionAdmin">
<form method="POST" action="index.php?uc=administrer&action=connection">
   <fieldset>
     <legend>Connexion Administration</legend>
      <p>
         <label for="nom">nom* </label>
         <input id="nom" type="text"  name="nom" size ="25" maxlength="25">
      </p>
      <p>
         <label for="mdp">mot de passe* </label>
         <input id="mdp" type="password"  name="mdp" size ="25" maxlength="100">
      </p>
	  	<p>
         <input type="submit" value="Valider" name="valider">
         <input type="reset" value="Annuler" name="annuler"> 
      </p>
	  </fieldset>
</form>
</div>