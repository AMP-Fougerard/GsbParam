<?php
$action = $_REQUEST['action'];
switch($action)
{
	case 'voirPanier':
	{
		if (isset($_SESSION['mail'])){
			$mail=$_SESSION['mail'];
			$n= nbProduitsDuPanier($mail);
			$st= 0.0;
			$livraison=0.0;
			if(isset($_REQUEST['erreur'])){
				$msgErreurs[]="Erreur dans l'enregistrement de votre commande";
				include ("vues/v_erreurs.php");
			}
			if ($n > 0) {
				$desIdProduit = getLesIdProduitsDuPanier($mail);
				//var_dump($desIdProduit);
				$lesProduitsDuPanier = getLesProduitsDuTableau($desIdProduit);
				//var_dump($lesProduitsDuPanier);
				include("vues/v_panier.php");
			} else {
				$message = "panier vide !!";
				include ("vues/v_message.php");
			}
		} else {
			$message = "Merci de vous connecter à un compte";
			include ("vues/v_message.php");
		}
		break;
	}
	case 'ajouterAuPanier' :
	{
		if (isset($_SESSION['mail'])) {
			$mail=$_SESSION['mail'];
			$idDuProduit=$_REQUEST['produit'];
			$idContenance1produit=$_REQUEST['cont'];
			$qte=$_POST['qte'];
			if(isset($_POST['contenance'])){
				$idContenanceChoisi=$_POST['contenance'];
			} else {
				$idContenanceChoisi=$idContenance1produit;
			}
			$idProduit=array("id"=>$idDuProduit,"idCont"=>$idContenanceChoisi);
			$ok = ajouterAuPanier($idProduit,$mail,$qte);
			if(!$ok)
			{
				$message = "Cet article est déjà dans le panier !! <br>
				<a class=\"btn btn-primary\" href=\"index.php?uc=gererPanier&action=voirPanier\">Voir son panier</a><br>";
				include("vues/v_message.php");
			}
			else{
			// on recharge la même page ( NosProduits si pas categorie passée dans l'url')
				if (isset($_REQUEST['categorie'])) {
					$categorie = $_REQUEST['categorie'];
					header('Location:index.php?uc=voirProduits&action=voirProduits&ajP=1&categorie='.$categorie);
				}
				else {
					header('Location:index.php?uc=voirProduits&action=nosProduits&ajP=1');
				}
			}
		} else {
			$message = "Merci de vous connecter à un compte";
			include ("vues/v_message.php");
		}
		break;
	}
	case 'supprimerUnProduit':
	{
		if (isset($_SESSION['mail'])){
			$idProduit=$_REQUEST['produit'];
			$idContenance=$_REQUEST['cont'];
			$id=array('id'=>$idProduit,'idCont'=>$idContenance);
			retirerDuPanier($id,$_SESSION['mail']);
			header('Location: ?uc=gererPanier&action=voirPanier');
		} else {
			header('Location: ?uc=gererPanier&action=voirPanier');
		}
		break;
	}
	case 'viderPanier':
	{
		if (isset($_SESSION['mail'])){
			$n= nbProduitsDuPanier($_SESSION['mail']);
			if($n >0){
				supprimerPanier($_SESSION['mail']);
				$message = "panier vidé";
				include ("vues/v_message.php");
			} else {
				$message = "panier vide !!";
				include ("vues/v_message.php");
			}
		} else {
			header('Location: ?uc=gererPanier&action=voirPanier');
		}	
		break;
	}
	case 'passerCommande' :
		if (isset($_SESSION['mail'])){
			$mail=$_SESSION['mail'];
		    $n= nbProduitsDuPanier($mail);
			if($n>0) {   // les variables suivantes servent à l'affectation des attributs value du formulaire
				//var_dump($_POST);
				$ok=true;
				foreach ($_POST as $key => $qte) {
					$tmp=substr($key,3);
					//var_dump($tmp);
					$element=explode("Z", $tmp);
					//var_dump($element);
					$idProd=$element[0];
					//var_dump($idProd);
					$idCont=$element[1];
					//var_dump($idCont);
					$ids=array("id"=>$idProd,"idCont"=>$idCont);
					if (!modifierQteProduit($ids,$mail,$qte) ){
						$ok=false;
					}
				}
				if ($ok){
					header('Location: ?uc=gererPanier&action=confirmerCommande');
				}else{
					header('Location: ?uc=gererPanier&action=voirPanier&erreur=1');
				}	
			}
			else
			{
				$message = "panier vide !!";
				include ("vues/v_message.php");
			}
		} else {
			$msgErreurs[] = "Un compte est nécessaire pour commander";
			include ("vues/v_erreurs.php");
			$desIdProduit = getLesIdProduitsDuPanier();
			$lesProduitsDuPanier = getLesProduitsDuTableau($desIdProduit);
			include ("vues/v_panier.php");
		}
		break;
		
	case 'confirmerCommande' :
	{
		if (isset($_SESSION['mail'])){
			$mail=$_SESSION['mail'];
			$lesIdProduit = getLesIdProduitsDuPanier($mail);
			//var_dump($lesIdProduit);
			if ( creerCommande($mail, $lesIdProduit ) ){
				$message = "Commande enregistrée";
				supprimerPanier($mail);
			} else {
				$msgErreurs[] = "Une erreur est survenue lors de l'enregistrement de la commande";
				include ("vues/v_erreurs.php");
				$desIdProduit = getLesIdProduitsDuPanier($mail);
				$lesProduitsDuPanier = getLesProduitsDuTableau($desIdProduit);
				include ("vues/v_panier.php");
			}
			include ("vues/v_message.php");
		} else {
			header('Location: ?uc=gererPanier&action=voirPanier');
		}
		break;
	}
	default:
	{
		header('Location: ?uc=gererPanier&action=voirPanier');
	}
}


?>


