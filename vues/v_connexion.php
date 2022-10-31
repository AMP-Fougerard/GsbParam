<div id="connexionClient">
<form method="POST" action="index.php?uc=gererClient&action=connection">
   <fieldset>
     <legend>Connexion</legend>
      <p>
         <label for="mail">mail* </label>
         <input id="mail" type="text"  name="mail" value="<?php echo $mail ?>" size ="25" maxlength="25">
      </p>
      <p>
         <label for="mdp">mot de passe* </label>
         <input id="mdp" type="password"  name="mdp" size ="25" maxlength="25">
      </p>
	  	<p>
         <input type="submit" value="Valider" name="valider">
         <input type="reset" value="Annuler" name="annuler"> 
      </p>
	  </fieldset>
</form>
</div>