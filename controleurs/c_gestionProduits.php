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
		if(!isset($_SESSION['admin'])){
			include("vues/v_connexionAdmin.php");
		} else {
			ob_clean();
			header('Location:index.php?uc=administrer&action=voirCategories');
		}
		break;
	}
	case 'connection':
	{
		if(!isset($_SESSION['admin'])){
			if(count($_POST)>0){
			$mail = $_POST['mail'];$mdp = $_POST['mdp'];
			}else{
				$mail = '';$mdp = '';
			}
			$msgErreurs = getErreursSaisieConnexion($mail,$mdp);
			if (count($msgErreurs)!=0)
			{
				include ("vues/v_erreurs.php");
				include ("vues/v_connexion.php");
			} else {
				if(verifyAdmin($mail)){
					$_SESSION['admin'] = $mail ;
					header('Location:index.php?uc=administrer&action=voirCategories');
				} else {
					$msgErreurs[] = "Votre nom ou mot de passe est incorrect";
					include ("vues/v_erreurs.php");
					include("vues/v_connexionAdmin.php");
				}
			}
		} else {
			header('Location:index.php?uc=administrer&action=voirCategories');
		}
		break;
	}
	case 'voirCategories':
	{
		if(isset($_SESSION['admin'])){
			$lesCategories = getLesCategories();
			include("vues/v_categories.php");
		} else {
			ob_clean();
			header('Location:index.php?uc=administrer&action=seConnecter');
		}
		break;
	}
	case 'voirProduits':
	{
		if(isset($_SESSION['admin'])){
			$lesCategories = getLesCategories();
			include("vues/v_categories.php");
			$categorie = $_REQUEST['categorie'];
  			$nomCateg = getNomCateg($categorie);
			$lesProduits = getLesProduitsDeCategorie($categorie);
			include("vues/v_produitsDeCategorie.php");
		} else {
			ob_clean();
			header('Location:index.php?uc=administrer&action=seConnecter');
		}
		break;
	}
	case 'rajouterProduit':
	{
		if(isset($_SESSION['admin'])){
			$id = '';$name='';$desc = '';$marque='';;$prix='';$img='';$stock='';$cont='';$unit='';
			$lesContenances='';

			$action="Ajouter";
			$lesMarques=getNomsMarques();
			$lesUnit=getUnit();
			include("vues/v_formulaireProduit.php");
		} else {
			ob_clean();
			header('Location:index.php?uc=administrer&action=seConnecter');
		}
		break;
	}
	case 'modifierProduit':
	{
		if(isset($_SESSION['admin'])){
			$leProduit = getProduit($_REQUEST['produit']);
			// var_dump($leProduit);
			// var_dump($leProduit);
			$id = $leProduit['id'];
			$name=$leProduit['libelle'];
			$desc = $leProduit['description'];
			$prix = $leProduit['prix'];
			$img=$leProduit['image'];
			$categ = $leProduit['id_categorie'];
			$stock=$leProduit['stock'];
			$cont=$leProduit['qte'];
			$unit=$leProduit['unit_intitule'];
			$marque=$leProduit['nom_marque'];
			$contenances=getContenance($id);
			// var_dump($contenances);

			$lesContenances=array();
			foreach ($contenances as $value) {
				$lesContenances[$value['id_contenance']]=array("prix"=>$value['prix'],"stock"=>$value['stock'],"cont"=>$value['qte'],"unit"=>$value['unit_intitule']);
			}

			$action="Editer";
			$lesMarques=getNomsMarques();
			$lesUnit=getUnit();
			include("vues/v_formulaireProduit.php");
		} else {
			ob_clean();
			header('Location:index.php?uc=administrer&action=seConnecter');
		}
		break;
	}
	case 'confirmerProduit':
	{
		if(isset($_SESSION['admin'])){
			if(empty($_POST)){
				// var_dump($_POST);
				$id = $_POST['id'];
				$name= $_POST['name'];
				$desc = $_POST['desc'];
				$marque = $_POST['marque'];
				$prix = $_POST['prix'];
				$categ = $_POST['categ'];
				$stock = $_POST['stock'];
				$cont = $_POST['cont'];
				$unit = $_POST['unit'];

				$words=explode(" ",$_POST['btnconfirm']);
				$action=$words[0];
				$lesMarques=getNomsMarques();
				$lesUnit=getUnit();

				$lesContenances = array();
					foreach ($_POST as $key => $value){
						$array = explode("-",$key);
						$idCont = $array[0];
						if(count($array)==2){
							$lesContenances[$idCont] = array('prix' => $_POST[$idCont."-prix"],'stock' => $_POST[$idCont."-stock"],'qte' => $_POST[$idCont."-cont"],'unit' => $_POST[$idCont."-unit"]);
						}
					}
					// var_dump($lesContenances);

				if ($_FILES['img']['name'] == '')
					$img=$_POST['img'];
				else 
					$img='images/'.$_FILES['img']['name'];

				$msgErreurs = getErreursSaisieProduit($name,$desc,$img,$marque,$categ,$stock,$cont,$unit);
				if (count($msgErreurs)==0){
					$idMarque = getIdMarque($marque);
					// var_dump($idMarque);
					if($idMarque == null){
						$idMarque = addMarque($marque);
					}
					$idUnit=getIdUnit($unit);
					if($idUnit == null){
						$idUnit = addUnit($unit);
					}

					if(getProduit($_POST['id'])){
						if(modifierProduit($id,$name,$desc,$img,$categ,$idMarque,$prix,$stock,$cont,$idUnit,$lesContenances)){
							$_SESSION['msg']="Produit modifié";
							$tag=$_FILES['img']['tmp_name'];
						    $name = basename($_FILES["img"]["name"]);
						    // var_dump($_FILES);
						    if ($name != ''){
						    	if($_FILES["img"]["error"]==0 && move_uploaded_file($tag, 'assets/images/'.$name)){
						    		ob_clean();
						    		header('Location:index.php?uc=administrer&categorie='.$categ.'&action=voirProduits#produits');
								}else {
									$msgErreurs[] = "Une erreur est survenue lors de l'ajout de l'image modifié du produit";
									include ("vues/v_erreurs.php");
									include ("vues/v_formulaireProduit.php");
								}
						    } else {
						    	ob_clean();
						    	header('Location:index.php?uc=administrer&categorie='.$categ.'&action=voirProduits#produits');
						    }
						} else {
							$msgErreurs[] = "Une erreur est survenue lors de la modification du produit";
							include ("vues/v_erreurs.php");
							include ("vues/v_formulaireProduit.php");
						}
					} else {
						if(creerProduit($name,$desc,$img,$categ,$idMarque,$prix,$stock,$cont,$idUnit,$lesContenances) ) {
							$_SESSION['msg']="Produit rajouté";
							$tag=$_FILES['img']['tmp_name'];
						    $name = basename($_FILES["img"]["name"]);
						    // var_dump($_FILES);
							if($_FILES["img"]["error"]==0 && move_uploaded_file($tag, 'assets/images/'.$name)){
								ob_clean();
								header('Location:index.php?uc=administrer&categorie='.$categ.'&action=voirProduits#produits');
							}else {
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
			}else {
				// peut arriver si le fichier choisi est trop volumineux
				$msgErreurs[] = "Une erreur est survenue";
				include ("vues/v_erreurs.php");
				include ("vues/v_formulaireProduit.php");
			}
		} else {
			ob_clean();
			header('Location:index.php?uc=administrer&action=seConnecter');
		}
		break;
	}

	case 'effacerProduit':
	{
		if(isset($_SESSION['admin'])){
			$id=$_REQUEST['produit'];
			if(supprimerProduit($id)){
				$_SESSION['msg']="Le produit à bien été effacer";
				ob_clean();
				header('Location:index.php?uc=administrer&categorie='.$_REQUEST['categorie'].'&action=voirProduits#produits');
			} else {
				$msgErreurs[] = "Une erreur est survenue lors de suppression du produit";
				include ("vues/v_erreurs.php");
				$categorie = $_REQUEST['categorie'];
				$lesProduits = getLesProduitsDeCategorie($categorie);
				include("vues/v_produitsDeCategorie.php");
			}
		} else {
			ob_clean();
			header('Location:index.php?uc=administrer&action=seConnecter');
		}
		break;
	}
	case 'seDeconnecter':
	{
		unset($_SESSION['admin']);
		$_SESSION['msg']="Déconnexion réussi";
		ob_clean();
		header('Location:index.php?uc=accueil');
		break;
	}
	default:
	{
		ob_clean();
		header('Location:index.php?uc=administrer&action=seConnecter');
	}
}
?>