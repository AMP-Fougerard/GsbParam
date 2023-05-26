<?php ob_start();
session_start();
include("vues/v_entete.html") ;
//require_once("modele/fonctions.inc.php");
require_once("modele/bd.produits.inc.php");
require_once("modele/bd.client.inc.php");
require_once("modele/bd.avis.inc.php");
require_once("modele/bd.panier.inc.php");

if(!isset($_REQUEST['uc']))
     $uc = 'accueil'; // si $_GET['uc'] n'existe pas , $uc reçoit une valeur par défaut
else
	$uc = $_REQUEST['uc'];


if ($uc=='administrer'){
	include("vues/v_bandeauAdmin.php") ;
} elseif(isset($_SESSION['mail'])) {
	include("vues/v_bandeauConnection.php") ;
} else {
	include("vues/v_bandeau.html") ;
}

//var_dump($_SESSION);
//var_dump($_REQUEST);
//var_dump($_POST);

if (isset($_SESSION['msg'])) {
	$message = $_SESSION['msg'];
	include ("vues/v_message.php");
	unset($_SESSION['msg']);
}

switch($uc)
{
	case 'accueil':
		{include("vues/v_accueil.html");break;}
	case 'voirProduits' :
		{include("controleurs/c_voirProduits.php");break;}
	case 'gererPanier' :
		{ include("controleurs/c_gestionPanier.php");break; }
	case 'gererClient' :
		{ include("controleurs/c_gestionClients.php");break; }
	case 'administrer' :
	  { include("controleurs/c_gestionProduits.php");break;  }
}
include("vues/v_pied.html") ;
?>

