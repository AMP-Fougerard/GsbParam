<?php
// contrôleur qui gère les compte utilisateur
$action = $_REQUEST['action'];
switch($action)
{
	case 'sInscrire':
	{
		$nom ='';$rue='';$ville ='';$cp='';$mail='';
		include("vues/v_inscription.php");
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
			if ( creerClient($nom,$rue,$cp,$ville,$mail,$mdp) ){
				$message = "Inscription terminé";
				$_SESSION['mail']=$mail;
			} else {
				$msgErreurs = "Un problème est survenue lors de l'inscription";
				include ("vues/v_erreurs.php");
				include ("vues/v_inscription.php");
			}
			include ("vues/v_message.php");
		}
  		break;
	}
	case 'seConnecter' :
	{
		$mail='';
		include("vues/v_connexion.php");
		break;
	}
	case 'connection' :
	{
		$mail =$_REQUEST['mail']; $mdp=$_REQUEST['mdp'];
	 	$msgErreurs = getErreursSaisieConnexion($mail,$mdp);
		if (count($msgErreurs)!=0)
		{
			include ("vues/v_erreurs.php");
			include ("vues/v_connexion.php");
		}
		else
		{
			if ( connexion($mail,$mdp) ){
				$message = "Connexion établie";
				$_SESSION['mail']=$mail;
			}
			header('Location: ?uc=accueil');
			include ("vues/v_message.php");
		}
		break;
	}
	case 'seDeconnecter' :
	{
		unset($_SESSION['mail']);
		$message = 'Déconnexion réussi';
		header('Location: ?uc=accueil');
		include("vues/v_message.php");
		break;
	}
}
?>

