<?php
// contrôleur qui gère les compte utilisateur
$action = $_REQUEST['action'];
switch($action)
{
	case 'sInscrire':
	{	
		$nom ='';$prenom='';$rue='';$ville ='';$cp='';$mail='';
		include("vues/v_inscription.php");
		break;
	}
	case 'inscription':
	{
		if (count($_POST)>0){
			$nom =$_POST['nom'];$prenom =$_POST['prenom'];$rue =$_POST['rue'];$ville =$_POST['ville'];$cp=$_POST['cp'];$mail=$_POST['mail'];$mdp1=$_POST['mdp1'];$mdp2=$_POST['mdp2'];
		} else {
			$nom ='';$prenom='';$rue='';$ville ='';$cp='';$mail='';$mdp1='';$mdp2='';
		}
	 	$msgErreurs = getErreursSaisieClient($nom,$prenom,$rue,$ville,$cp,$mail,$mdp1,$mdp2);
		if (count($msgErreurs)!=0)
		{
			include ("vues/v_erreurs.php");
			include ("vues/v_inscription.php");
		}
		else
		{
			if ( creerClient($nom,$prenom,$rue,$cp,$ville,$mail,$mdp1) ){
				$_SESSION['msg']="Inscription terminé";
				header('Location: ?uc=gererClient&action=seConnecter');
			} else {
				$msgErreurs[] = "Un problème est survenue lors de l'inscription";
				include ("vues/v_erreurs.php");
				include ("vues/v_inscription.php");
			}
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
		
		if (count($_POST)>0){
			$mail =$_POST['mail']; $mdp=$_POST['mdp'];
		} else {
			$mail=''; $mdp='';
		}
	 	$msgErreurs = getErreursSaisieConnexion($mail,$mdp);
		if (count($msgErreurs)!=0)
		{
			include ("vues/v_erreurs.php");
			include ("vues/v_connexion.php");
		}
		else
		{
			if ( connexion($mail) ){
				$message = "Connexion établie";
				$_SESSION['mail']=$mail;
				include ("vues/v_message.php");
				header('Location: ?uc=accueil');
			} else {
				$msgErreurs="Erreur dans la connexion à la base de donnée";
				include ("vues/v_erreurs.php");
				include ("vues/v_connexion.php");
			}
			
		}
		break;
	}
	case 'seDeconnecter' :
	{
		unset($_SESSION['mail']);
		$_SESSION['msg']="Déconnexion réussi";
		header('Location: ?uc=accueil');
		break;
	}
}
?>

