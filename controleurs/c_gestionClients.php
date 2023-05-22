<?php
// contrôleur qui gère les compte utilisateur
$action = $_REQUEST['action'];
switch($action)
{
	case 'sInscrire':
	{	
		$mail='';
		include("vues/v_inscription.php");
		break;
	}
	case 'inscription':
	{
		if (count($_POST)>0){
			$mail=$_POST['mail'];$mdp1=$_POST['mdp1'];$mdp2=$_POST['mdp2'];
		} else {
			$mail='';$mdp1='';$mdp2='';
		}
	 	$msgErreurs = getErreursSaisieClient($mail,$mdp1,$mdp2);
		if (count($msgErreurs)!=0)
		{
			include ("vues/v_erreurs.php");
			include ("vues/v_inscription.php");
		}
		else
		{
			if ( creerClient($mail,$mdp1) ){
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
	case 'voirProfil' :
	{
		if (isset($_SESSION['mail'])) {
			$mail=$_SESSION['mail'];
			$list='<li class="col-3 border text-center"><a href="index.php?uc=gererClient&action=voirProfil"> Mes informations </a></li>
		<li class="col-3 border bg-light text-center"><a href="index.php?uc=gererClient&action=voirCommande"> Mes commandes </a></li>
		<!--<li class="col-3 border bg-light text-center"><a href="index.php?uc=gererClient&action=voirAvis"> Mes avis </a></li>-->';
			$contenu='<div>
			<p>mail : '.$mail.'</p>
			<p>mot de passe : *******</p>
			</div>';
			include ("vues/v_profil.php");
		} else {
			$msgErreurs[] = "Un compte est nécessaire pour voir son profil";
			include ("vues/v_erreurs.php");
		}
		break;
	}
	case 'voirCommande' :
	{
		if (isset($_SESSION['mail'])) {
			$mail=$_SESSION['mail'];
			$list='<li class="col-3 border bg-light text-center"><a href="index.php?uc=gererClient&action=voirProfil"> Mes informations </a></li>
		<li class="col-3 border text-center"><a href="index.php?uc=gererClient&action=voirCommande"> Mes commandes </a></li>
		<!--<li class="col-3 border bg-light text-center"><a href="index.php?uc=gererClient&action=voirAvis"> Mes avis </a></li>-->';
			$lesCommandes=commandeClient($mail);
			include ("vues/v_profil.php");
		} else {
			$msgErreurs[] = "Un compte est nécessaire pour voir son profil";
			include ("vues/v_erreurs.php");
		}
		break;
	}
	case 'voirAvis' :
	{
		header('Location: ?uc=gererClient&action=voirProfil');
		if (isset($_SESSION['mail'])) {
			$mail=$_SESSION['mail'];
			$list='<li class="col-3 border bg-light text-center"><a href="index.php?uc=gererClient&action=voirProfil"> Mes informations </a></li>
		<li class="col-3 border bg-light text-center"><a href="index.php?uc=gererClient&action=voirCommande"> Mes commandes </a></li>
		<li class="col-3 border text-center"><a href="index.php?uc=gererClient&action=voirAvis"> Mes avis </a></li>';
			include ("vues/v_profil.php");
		} else {
			$msgErreurs[] = "Un compte est nécessaire pour voir son profil";
			include ("vues/v_erreurs.php");
		}
		break;
	}
}
?>

