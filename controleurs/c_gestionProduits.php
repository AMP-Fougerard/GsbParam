<?php
// contrôleur qui gère les compte utilisateur
if (isset($_REQUEST['action']))
	$action = $_REQUEST['action'];
else
	$action = null;

switch($action)
{
	case 'seConnecter':
	{
		if(!isset($_SESSION['id'])){
			include("vues/v_connexionAdmin.php");
		} else {
			header('Location:index.php?uc=administrer&action=voirCategories');
		}
		break;
	}
	case 'connection':
	{
		if(!isset($_SESSION['id'])){
			if(count($_POST)>0){
			$nom = $_POST['nom'];$mdp = $_POST['mdp'];
			}else{
				$nom = '';$mdp = '';
			}
			if(verifyExistAdmin($nom,$mdp)){
				$_SESSION['id'] = getIdAdmin($nom);
				header('Location:index.php?uc=administrer&action=voirCategories');
			} else {
				$msgErreurs[] = "Votre nom ou mot de passe est incorrect";
				include ("vues/v_erreurs.php");
				include("vues/v_connexionAdmin.php");
			}
		} else {
			header('Location:index.php?uc=administrer&action=voirCategories');
		}
		break;
	}
	case 'voirCategories':
	{
		if(isset($_SESSION['id'])){
			$lesCategories = getLesCategories();
			include("vues/v_categories.php");
		} else {
			header('Location:index.php?uc=administrer&action=seConnecter');
		}
		break;
	}
	case 'voirProduits':
	{
		if(isset($_SESSION['id'])){
			$lesCategories = getLesCategories();
			include("vues/v_categories.php");
	  		$categorie = $_REQUEST['categorie'];
			$lesProduits = getLesProduitsDeCategorie($categorie);
			include("vues/v_produitsDeCategorie.php");
		} else {
			header('Location:index.php?uc=administrer&action=seConnecter');
		}
		break;
	}
	case 'rajouterProduit':
	{
		if(isset($_SESSION['id'])){
			$id = '';$desc = '';$prix='';$img='';
			include("vues/v_formulaireProduit.php");
		} else {
			header('Location:index.php?uc=administrer&action=seConnecter');
		}
		break;
	}
	case 'confirmerProduit':
	{
		if(isset($_SESSION['id'])){
			$id = $_POST['id'];$desc = $_POST['desc'];$prix=$_POST['prix'];$categ=$_POST['categ'];
			if ($_FILES['img']['name'] == '')
				$img=$_POST['img'];
			else 
				$img='images/'.$_FILES['img']['name'];
			$msgErreurs = getErreursSaisieProduit($desc,$prix,$img);
			if (count($msgErreurs)==0){
				if(getProduit($_POST['id'])){
					if(modifierProduit($id,$desc,$prix,$img,$categ)){
						$_SESSION['msg']="Produit modifié";
						$tag=$_FILES['img']['tmp_name'];
					    $name = basename($_FILES["img"]["name"]);
					    // var_dump($_FILES);
					    if ($name != ''){
					    	if($_FILES["img"]["error"]==0 && move_uploaded_file($tag, 'images/'.$name))
					    		header('Location:index.php?uc=administrer&categorie='.$categ.'&action=voirProduits#produits');
							else {
								$msgErreurs[] = "Une erreur est survenue lors de l'ajout de l'image modifié du produit";
								include ("vues/v_erreurs.php");
								include ("vues/v_formulaireProduit.php");
							}
					    } else {
					    	header('Location:index.php?uc=administrer&categorie='.$categ.'&action=voirProduits#produits');
					    }
					} else {
						$msgErreurs[] = "Une erreur est survenue lors de la modification du produit";
						include ("vues/v_erreurs.php");
						include ("vues/v_formulaireProduit.php");
					}
				} else {
					if(creerProduit($desc,$prix,$img,$categ)){
						$_SESSION['msg']="Produit rajouté";
						$tag=$_FILES['img']['tmp_name'];
					    $name = basename($_FILES["img"]["name"]);
					    // var_dump($_FILES);
						if($_FILES["img"]["error"]==0 && move_uploaded_file($tag, 'images/'.$name))
							header('Location:index.php?uc=administrer&categorie='.$categ.'&action=voirProduits#produits');
						else {
							$msgErreurs[] = "Une erreur est survenue lors de l'ajout de l'image du produit";
							include ("vues/v_erreurs.php");
							include ("vues/v_formulaireProduit.php");
						}
					} else {
						$msgErreurs[] = "Une erreur est survenue lors de l'ajout du produit";
						include ("vues/v_erreurs.php");
						include ("vues/v_formulaireProduit.php");
					}
				}
			} else {
				include ("vues/v_erreurs.php");
				include ("vues/v_formulaireProduit.php");
			}
		} else {
			header('Location:index.php?uc=administrer&action=seConnecter');
		}
		break;
	}
	case 'modifierProduit':
	{
		if(isset($_SESSION['id'])){
			$leProduit = getProduit($_REQUEST['produit']);
			// var_dump($leProduit);
			$id = $leProduit['id'];$desc = $leProduit['description'];$prix = $leProduit['prix'];$img=$leProduit['image'];$categ = $leProduit['id_categorie'];	
			include("vues/v_formulaireProduit.php");
		} else {
			header('Location:index.php?uc=administrer&action=seConnecter');
		}
		break;
	}
	case 'effacerProduit':
	{
		if(isset($_SESSION['id'])){
			$id=$_REQUEST['produit'];
			if(supprimerProduit($id)){
				$_SESSION['msg']="Le produit à bien été effacer";
				header('Location:index.php?uc=administrer&categorie='.$_REQUEST['categorie'].'&action=voirProduits#produits');
			} else {
				$msgErreurs[] = "Une erreur est survenue lors de suppression du produit";
				include ("vues/v_erreurs.php");
				$categorie = $_REQUEST['categorie'];
				$lesProduits = getLesProduitsDeCategorie($categorie);
				include("vues/v_produitsDeCategorie.php");
			}
		} else {
			header('Location:index.php?uc=administrer&action=seConnecter');
		}
		break;
	}
	case 'seDeconnecter':
	{
		unset($_SESSION['id']);
		$_SESSION['msg']="Déconnexion réussi";
		header('Location:index.php?uc=accueil');
		break;
	}
	default:
	{
		header('Location:index.php?uc=administrer&action=seConnecter');
	}
}
?>