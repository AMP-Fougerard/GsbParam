<?php
// contrôleur qui gère les compte utilisateur
$action = $_REQUEST['action'];
switch($action)
{
	case 'sInscrire':
	{	
		$mail='';
		$nom='';$prenom='';$rue='';$cp='';$ville='';
		include("vues/v_inscription.php");
		break;
	}
	case 'inscription':
	{
		if (count($_POST)>0){
			$nom=$_POST['nom'];$prenom=$_POST['prenom'];$rue=$_POST['rue'];$cp=(string)$_POST['cp'];$ville=$_POST['ville'];
			$mail=$_POST['mail'];$mdp1=$_POST['mdp1'];$mdp2=$_POST['mdp2'];
		} else {
			$nom='';$prenom='';$rue='';$cp='';$ville='';
			$mail='';$mdp1='';$mdp2='';
		}
		var_dump($_POST);
	 	$msgErreurs = getErreursSaisieClient($nom,$prenom,$rue,$ville,$cp,$mail,$mdp1,$mdp2);
		if (count($msgErreurs)!=0){
			include ("vues/v_erreurs.php");
			include ("vues/v_inscription.php");
		} else {
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
		if (count($msgErreurs)!=0){
			include ("vues/v_erreurs.php");
			include ("vues/v_connexion.php");
		}else{
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
		ob_clean();
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
			$infoClient=getInfoClient($mail);
			$contenu='<div>
			<h3>'.$infoClient['nom'].' '.$infoClient['prenom'].'</h3>
			<p>mail : '.$mail.'</p>
			<p>mot de passe : *******</p>
			<p>rue : '.$infoClient['rue'].'</p>
			<p>cp : '.$infoClient['cp'].'</p>
			<p>ville : '.$infoClient['ville'].'</p>
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
			$contenu='';
			$lesCommandes=commandeClient($mail);
			//var_dump($lesCommandes);
			if($lesCommandes){
				foreach($lesCommandes as $command){
					$lesProduits=produitCommande($mail,$command['id']);
					//var_dump($lesProduits);
					if ($lesProduits) {
						$htmlCommande='<div class="container my-2">
						<h3 class="text-center">Commande du '.$command['dateCommande'].' d\'un montant de';
						$total=0.0;
						$htmlProd='';
						foreach ($lesProduits as $produit){
							$total+=$produit['prix']*$produit['qte'];
							$htmlProd=$htmlProd.'<div class="col-6 row"> 
								<img src="assets/'.$produit['image'].'" alt="image descriptive" class="col-4 py-auto img-responsive"/>
								<div class="col">
									<p class="mb-1 mt-3">'.$produit['libelle'].'</p>
									<p class="mb-1">'.$produit['nom_marque'].'</p>
									<p class="mb-1">'.$produit['contenu'].' '.$produit['unit_intitule'].'</p>
									<p class="mb-1">'.$produit['prix'].'€</p>
									<p class="mb-1">quantité : '.$produit['qte'].'</p>
								</div>
							</div>';

						}
						$htmlCommande=$htmlCommande.' '.number_format($total,2).'€</h3><div class="row border">'.$htmlProd.'</div></div>';
						$contenu=$contenu . $htmlCommande;
					}
				}
			}else{
				$contenu='<div class="container my-2"><h3 class="text-center">Aucune commande</h3></div>';
			}
			include ("vues/v_profil.php");
		} else {
			$msgErreurs[] = "Un compte est nécessaire pour voir son profil";
			include ("vues/v_erreurs.php");
		}
		break;
	}
	case 'voirAvis' :
	{
		ob_clean();
		header('Location: ?uc=gererClient&action=voirProfil');
		if (isset($_SESSION['mail'])) {
			$mail=$_SESSION['mail'];
			$list='<li class="col-3 border bg-light text-center"><a href="index.php?uc=gererClient&action=voirProfil"> Mes informations </a></li>
		<li class="col-3 border bg-light text-center"><a href="index.php?uc=gererClient&action=voirCommande"> Mes commandes </a></li>
		<li class="col-3 border text-center"><a href="index.php?uc=gererClient&action=voirAvis"> Mes avis </a></li>';
			$contenu='<div>
				en construction...
				</div>';
			include ("vues/v_profil.php");
		} else {
			$msgErreurs[] = "Un compte est nécessaire pour voir son profil";
			include ("vues/v_erreurs.php");
		}
		break;
	}
}
?>

