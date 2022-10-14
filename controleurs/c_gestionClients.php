<?php
// contrôleur qui gère les compte utilisateur
$action = $_REQUEST['action'];
switch($action)
{
	case 'sInscrire':
	{
		include("vues/v_inscripion.php");
		break;
	}
	case 'inscription':
	{
		$nom =$_REQUEST['nom'];$rue=$_REQUEST['rue'];$ville =$_REQUEST['ville'];$cp=$_REQUEST['cp'];$mail=$_REQUEST['mail'];$mdp1=$_REQUEST['mdp1'];$mdp2=$_REQUEST['mdp2'];
	 	$msgErreurs = getErreursSaisieClient($nom,$rue,$ville,$cp,$mail,$mdp1,$mdp2);
		if (count($msgErreurs)!=0)
		{
			include ("vues/v_erreurs.php");
			include ("vues/v_inscription.php");
		}
		else
		{
			if ( creerClient($nom,$rue,$cp,$ville,$mail,$lesIdProduit) ){
				$message = "Inscription terminé";
			}
			include ("vues/v_message.php");
		}
  		break;
	}
	case 'seConnecter' :
	{
		include("vues/v_connexion.php");
		break;
	}
	case 'connection'
	{
		$mail =$_REQUEST['mail'];$mdp=$_REQUEST['mdp'];
	 	$msgErreurs = getErreursSaisieConnexion($mail,$mdp);
		if (count($msgErreurs)!=0)
		{
			include ("vues/v_erreurs.php");
			include ("vues/v_commande.php");
		}
		else
		{
			if ( connexion($mail,$mdp) ){
				$message = "Connexion établie";
			}
			include ("vues/v_message.php");
		}
		break;
	}
	case 'seDeconnecter' :
	{
		session_destroy(); 
		$massage = 'Déconnexion réussi' ;
		include("vues/v_message.php");
		break;
	}
}
?>

