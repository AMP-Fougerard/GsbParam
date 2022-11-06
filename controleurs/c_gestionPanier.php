<?php
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
		header('Location: ?uc=gererPanier&action=voirPanier');
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
				$msgErreurs[] = "Un compte est nécessaire pour commander";
				include ("vues/v_erreurs.php");
				$desIdProduit = getLesIdProduitsDuPanier();
				$lesProduitsDuPanier = getLesProduitsDuTableau($desIdProduit);
				include ("vues/v_panier.php");
			} else {
				header('Location: ?uc=gererPanier&action=confirmerCommande');
			}
		}
		else
		{
			$message = "panier vide !!";
			include ("vues/v_message.php");
		}
		break;
	case 'confirmerCommande' :
	{
		$lesIdProduit = getLesIdProduitsDuPanier();
		if ( creerCommande($_SESSION['mail'], $lesIdProduit ) ){
			$message = "Commande enregistrée";
			supprimerPanier();
		} else {
			$msgErreurs[] = "Une erreur est survenue lors de l'enregistrement de la commande";
			include ("vues/v_erreurs.php");
			$desIdProduit = getLesIdProduitsDuPanier();
			$lesProduitsDuPanier = getLesProduitsDuTableau($desIdProduit);
			include ("vues/v_panier.php");
		}
		include ("vues/v_message.php");
		break;
	}
	case 'ajouterProduit' :
	{
		$idProduit=$_REQUEST['produit'];
		if(ajouterUnProduit($idProduit)){
			header('Location: ?uc=gererPanier&action=voirPanier#produits');
		}
		
		break;
	}
	case 'diminuerProduit' :
	{
		$idProduit=$_REQUEST['produit'];
		if(enleverUnProduit($idProduit)){
			header('Location: ?uc=gererPanier&action=voirPanier#produits');
		}else{
			header('Location: ?uc=gererPanier&produit='.$idProduit.'&action=supprimerUnProduit#produits');
		}
		break;
	}
}


?>


