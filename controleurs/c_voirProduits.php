<?php
// contrôleur qui gère l'affichage des produits
$action = $_REQUEST['action'];
switch($action)
{
	case 'voirCategories':
	{
  		$lesCategories = getLesCategories();
		include("vues/v_choixCategorie.php");
  		break;
	}
	case 'voirProduits' :
	{
		if(isset($_REQUEST['ajP'])) {
			if($_REQUEST['ajP']=1){
				$message = "Produit rajouté à votre panier";
				include ("vues/v_message.php");
			}
		}
		$lesCategories = getLesCategories();
		include("vues/v_choixCategorie.php");
  		$categorie = $_REQUEST['categorie'];
		$lesProduits = getLesProduitsDeCategorie($categorie);
		include("vues/v_produitsDeCategorie.php");
		break;
	}
	case 'nosProduits' :
	{
		$lesProduits = getLesProduits();
		include("vues/v_produits.php");
		break;
	}
	case 'voirUnProduit' :
	{
		$id= $_REQUEST['produit'];
		$infoProduit = getInfoProduit($id);
		//var_dump($infoProduit);
		$idVariante=0;
		$maxVariante= count($infoProduit);
		while ($infoProduit[$idVariante]['isBase']==0 && $idVariante<$maxVariante){
			$idVariante++;
		}
		$libel=$infoProduit[$idVariante]['libelle'];
		$image=$infoProduit[$idVariante]['image'];
		$description=$infoProduit[$idVariante]['description'];
		$cont=$infoProduit[$idVariante]['id_contenance'];
		$prix=$infoProduit[$idVariante]['prix'];
		$max=$infoProduit[$idVariante]['stock'];
		$unit=$infoProduit[$idVariante]['unit_intitule'];
		$qte=$infoProduit[$idVariante]['qte'];
		$marque=$infoProduit[$idVariante]['nom_marque'];
		$idCateg=$infoProduit[$idVariante]['id_categorie'];
		$nomCat=$infoProduit[$idVariante]['libelle_cat'];
		if(getNbrAvisProduit($id)){
			$avis=getNbrAvisProduit($id);
			$moy=round(getMoyNoteAvisProduit($id));
		} else {
			$avis=0;
			$moy=0;
		}
		$val=1;
		$info=array();
		if ($maxVariante>1){
			foreach ($infoProduit as $contDif) {
				$info[$contDif['id_contenance']]=array('stock'=>$contDif['stock'],'qte'=>$contDif['qte'],'stock'=>$contDif['stock'],'prix'=>$contDif['prix'],'unit'=>$contDif['unit_intitule'],'base'=>$contDif['isBase']);
			}
		}
		//var_dump($info);
		include("vues/v_ficheProduit.php");
		break;
	}
	/*case 'donnerAvis' :
	{
		include("vues/v_formulaireAvis.php");
		break;
	}
	case 'ajoutAvis' :
	{
		include("vues/v_produits.php");
		break;
	}*/
}
?>

