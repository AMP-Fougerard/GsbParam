﻿<?php
/**
 * @file fonctions.inc.php
 * @author Marielle Jouin <jouin.marielle@gmail.com>
 * @version    2.0
 * @date juin 2021
 * @details contient les fonctions qui ne font pas accès aux données de la BD

 * regroupe les fonctions pour gérer le panier, et les erreurs de saisie dans le formulaire de commande

 * @package  GsbParam\util
*/
/**
 * Initialise le panier
 *
 * Crée un tableau associatif $_SESSION['produits']en session dans le cas
 * où il n'existe pas déjà
*/
function initPanier()
{
	if(!isset($_SESSION['produits']))
	{
		$_SESSION['produits']= array();
		$_SESSION['quantite']= array();
	}
}
/**
 * Supprime le panier
 *
 * Supprime le tableau associatif $_SESSION['produits']
 */
function supprimerPanier()
{
	unset($_SESSION['produits']);
	unset($_SESSION['quantite']);
}
/**
 * Ajoute un produit au panier
 *
 * Teste si l'identifiant du produit est déjà dans la variable session 
 * ajoute l'identifiant à la variable de type session dans le cas où
 * où l'identifiant du produit n'a pas été trouvé
 
 * @param string $idProduit identifiant de produit
 * @return boolean $ok vrai si le produit n'était pas dans la variable, faux sinon 
*/
function ajouterAuPanier($idProduit)
{
	
	$ok = true;
	if(in_array($idProduit,$_SESSION['produits']))
	{
		$ok = false;
	}
	else
	{
		$_SESSION['produits'][]= $idProduit; // l'indice n'est pas précisé : il sera automatiquement celui qui suit le dernier occupé
		$_SESSION['quantite'][]= 1;
	}
	return $ok;
}
/**
 * Retourne les produits du panier
 *
 * Retourne le tableau des identifiants de produit
 
 * @return array $_SESSION['produits'] le tableau des id produits du panier 
*/
function getLesIdProduitsDuPanier()
{
	return $_SESSION['produits'];

}
/**
 * Retourne le nombre de produits du panier
 *
 * Teste si la variable de session existe
 * et retourne le nombre d'éléments de la variable session
 
 * @return int $n
*/
function nbProduitsDuPanier()
{
	$n = 0;
	if(isset($_SESSION['produits']))
	{
	$n = count($_SESSION['produits']);
	}
	return $n;
}
/**
 * Retire un de produits du panier
 *
 * Recherche l'index de l'idProduit dans la variable session
 * et détruit la valeur à ce rang
 
 * @param string $idProduit identifiant de produit
 
*/
function retirerDuPanier($idProduit)
{
		$index =array_search($idProduit,$_SESSION['produits']);
		unset($_SESSION['produits'][$index]);
		unset($_SESSION['quantite'][$index]);
}
/**
 * Retourne les quantités des produits du panier
 *
 * Retourne le tableau des quantité de produit
 
 * @return array $_SESSION['quantite'] le tableau des quantitées des produits du panier 
*/
function getQteProduit($idProduit)
{
	$index =array_search($idProduit,$_SESSION['produits']);
	return $_SESSION['quantite'][$index];
}
/**
 * Ajoute un produit à la quantité du produit
 *
 * Teste si l'identifiant du produit est déjà dans la variable session 
 * ajoute l'identifiant à la variable de type session dans le cas où
 * où l'identifiant du produit n'a pas été trouvé
 
 * @param string $idProduit identifiant de produit
 * @return boolean $ok vrai si le produit n'était pas dans la variable, faux sinon 
*/
function ajouterUnProduit($idProduit)
{
	
	$ok = true;
	if(!in_array($idProduit,$_SESSION['produits']))
	{
		$ok = false;
	}
	else
	{
		$index =array_search($idProduit,$_SESSION['produits']);
		$_SESSION['quantite'][$index]++;
	}
	return $ok;
}
/**
 * Enlever un produit à la quantité du produit
 *
 * Teste si l'identifiant du produit est déjà dans la variable session 
 * ajoute l'identifiant à la variable de type session dans le cas où
 * où l'identifiant du produit n'a pas été trouvé
 
 * @param string $idProduit identifiant de produit
 * @return boolean $ok vrai si le produit n'était pas dans la variable, faux sinon 
*/
function enleverUnProduit($idProduit)
{
	
	$ok = true;
	if(!in_array($idProduit,$_SESSION['produits']))
	{
		$ok = false;
	}
	else
	{
		$index =array_search($idProduit,$_SESSION['produits']);
		if ($_SESSION['quantite'][$index]>1){
			$_SESSION['quantite'][$index]--;
		} else {
			$ok = false;
		}
	}
	return $ok;
}

/**
 * teste si une chaîne a un format de code postal
 *
 * Teste le nombre de caractères de la chaîne et le type entier (composé de chiffres)
 
 * @param string $codePostal  la chaîne testée
 * @return boolean $ok vrai ou faux
*/
function estUnCp($codePostal)
{
   
   return strlen($codePostal)== 5 && estEntier($codePostal);
}
/**
 * teste si une chaîne est un entier
 *
 * Teste si la chaîne ne contient que des chiffres
 
 * @param string $valeur la chaîne testée
 * @return boolean $ok vrai ou faux
*/

function estEntier($valeur) 
{
	return preg_match("/[^0-9]/", $valeur) == 0;
}
/**
 * Teste si une chaîne a le format d'un mail
 *
 * Utilise les expressions régulières
 
 * @param string $mail la chaîne testée
 * @return boolean $ok vrai ou faux
*/
function estUnMail($mail)
{
return  preg_match ('#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#', $mail);
}
/**
 * Retourne un tableau d'erreurs de saisie pour une commande
 *
 * @param string $nom  chaîne testée
 * @param  string $rue chaîne
 * @param string $ville chaîne
 * @param string $cp chaîne
 * @param string $mail  chaîne 
 * @return array $lesErreurs un tableau de chaînes d'erreurs
*/
function getErreursSaisieCommande($nom,$rue,$ville,$cp,$mail)
{
	$lesErreurs = array();
	if($nom=="")
	{
		$lesErreurs[]="Il faut saisir le champ nom";
	}
	if($rue=="")
	{
	$lesErreurs[]="Il faut saisir le champ rue";
	}
	if($ville=="")
	{
		$lesErreurs[]="Il faut saisir le champ ville";
	}
	if($cp=="")
	{
		$lesErreurs[]="Il faut saisir le champ Code postal";
	}
	else
	{
		if(!estUnCp($cp))
		{
			$lesErreurs[]= "erreur de code postal";
		}
	}
	if($mail=="")
	{
		$lesErreurs[]="Il faut saisir le champ mail";
	}
	else
	{
		if(!estUnMail($mail))
		{
			$lesErreurs[]= "erreur de mail";
		}
	}
	return $lesErreurs;
}
/**
 * Retourne un tableau d'erreurs de saisie pour un produit
 *
 * @param string $desc description d'un produit
 * @param double $prix prix d'un produit
 * @param string $img url
 * @return array $lesErreurs un tableau de chaînes d'erreurs
*/
function getErreursSaisieProduit($desc,$prix,$img)
{
	$lesErreurs = array();
	if($desc=="")
	{
		$lesErreurs[]="Il faut saisir le champ description";
	}
	if($prix=="")
	{
	$lesErreurs[]="Il faut saisir le champ prix";
	}
	if($img=="")
	{
		$lesErreurs[]="Il faut saisir le champ image";
	}
	return $lesErreurs;
}
?>
