﻿<?php
$action = $_REQUEST['action'];
switch($action)
{
	case 'voirPanier':
	{
		$n= nbProduitsDuPanier();
		if($n >0)
		{
			$desIdProduit = getLesIdProduitsDuPanier();
			$lesProduitsDuPanier = getLesProduitsDuTableau($desIdProduit);
			include("vues/v_panier.php");
		}
		else
		{
			$message = "panier vide !!";
			include ("vues/v_message.php");
		}
		break;
	}
	case 'supprimerUnProduit':
	{
		$idProduit=$_REQUEST['produit'];
		retirerDuPanier($idProduit);
		$desIdProduit = getLesIdProduitsDuPanier();
		$lesProduitsDuPanier = getLesProduitsDuTableau($desIdProduit);
		include("vues/v_panier.php");
		break;
	}
	case 'viderPanier':
	{
		$n= nbProduitsDuPanier();
		if($n >0){
			$message = "panier vidé";
			supprimerPanier();
			include ("vues/v_message.php");
		} else {
			$message = "panier vide !!";
			include ("vues/v_message.php");
		}
		break;
	}
	case 'passerCommande' :
	    $n= nbProduitsDuPanier();
		if($n>0)
		{   // les variables suivantes servent à l'affectation des attributs value du formulaire
			// ici le formulaire doit être vide, quand il est erroné, le formulaire sera réaffiché pré-rempli
			if(!isset($_SESSION['mail'])){
				$nom ='';$rue='';$ville ='';$cp='';$mail='';
				$message = "Vous n'avez pas encore de compte pour commander";
				include ("vues/v_message.php");
				include ("vues/v_inscription.php");
			} else {
				$nom ='';$rue='';$ville ='';$cp='';$mail='';
				include ("vues/v_commande.php");
			}
		}
		else
		{
			$message = "panier vide !!";
			include ("vues/v_message.php");
		}
		break;
	case 'confirmerCommande'	:
	{
		$nom =$_REQUEST['nom'];$rue=$_REQUEST['rue'];$ville =$_REQUEST['ville'];$cp=$_REQUEST['cp'];$mail=$_REQUEST['mail'];
	 	$msgErreurs = getErreursSaisieCommande($nom,$rue,$ville,$cp,$mail);
		if (count($msgErreurs)!=0)
		{
			include ("vues/v_erreurs.php");
			include ("vues/v_commande.php");
		}
		else
		{
			$lesIdProduit = getLesIdProduitsDuPanier();
			if ( creerCommande($nom,$rue,$cp,$ville,$mail, $lesIdProduit ) ){
				$message = "Commande enregistrée";
				supprimerPanier();
			}
			include ("vues/v_message.php");
		}
		break;
	}
}


?>


