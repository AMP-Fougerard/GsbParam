<?php

/** 
 * Mission 3 : architecture MVC GsbParam
 
 * @file bd.produits.inc.php
 * @author Marielle Jouin <jouin.marielle@gmail.com>
 * @version    2.0
 * @date juin 2021
 * @details contient les fonctions d'accès BD à la table produits
 */
include_once 'bd.inc.php';

	/**
	 * Retourne toutes les catégories sous forme d'un tableau associatif
	 *
	 * @return array $lesLignes le tableau associatif des catégories 
	*/
	function getLesCategories()
	{
		try 
		{
        $monPdo = connexionPDO();
		$req = 'select id, libelle from categorie';
		$res = $monPdo->query($req);
		$lesLignes = $res->fetchAll(PDO::FETCH_ASSOC);
		return $lesLignes;
		} 
		catch (PDOException $e) 
		{
        print "Erreur !: " . $e->getMessage();
        die();
		}
	}
	/**
	 * Retourne toutes les informations d'une catégorie passée en paramètre
	 *
	 * @param string $idCategorie l'id de la catégorie
	 * @return array $laLigne le tableau associatif des informations de la catégorie 
	*/
	function getLesInfosCategorie($idCategorie)
	{
		try 
		{
        $monPdo = connexionPDO();
		$req = "select id, libelle from categorie where id='$idCategorie'";
		$res = $monPdo->query($req);
		$laLigne = $res->fetch(PDO::FETCH_ASSOC);
		return $laLigne;
		} 
		catch (PDOException $e) 
		{
        print "Erreur !: " . $e->getMessage();
        die();
		}
	}
/**
 * Retourne sous forme d'un tableau associatif tous les produits 
 * 
 * @return array $lesLignes un tableau associatif  contenant les produits de la categ passée en paramètre
*/

	function getLesProduits()
	{
		try 
		{
        $monPdo = connexionPDO();
	    $req='select id, description, prix, image, id_categorie from produit';
		$res = $monPdo->query($req);
		$lesLignes = $res->fetchAll(PDO::FETCH_ASSOC);
		return $lesLignes; 
		} 
		catch (PDOException $e) 
		{
        print "Erreur !: " . $e->getMessage();
        die();
		}
	}
/**
 * Retourne sous forme d'un tableau associatif tous les produits de la
 * catégorie passée en argument
 * 
 * @param string $idCategorie  l'id de la catégorie dont on veut les produits
 * @return array $lesLignes un tableau associatif  contenant les produits de la categ passée en paramètre
*/
	function getLesProduitsDeCategorie($idCategorie)
	{
		try 
		{
        $monPdo = connexionPDO();
	    $req='select id, description, prix, image, id_categorie from produit where id_categorie ="'.$idCategorie.'"';
		$res = $monPdo->query($req);
		$lesLignes = $res->fetchAll(PDO::FETCH_ASSOC);
		return $lesLignes; 
		} 
		catch (PDOException $e) 
		{
        print "Erreur !: " . $e->getMessage();
        die();
		}
	}
/**
 * Retourne les produits concernés par le tableau des idProduits passée en argument
 *
 * @param array $desIdProduit tableau d'idProduits
 * @return array $lesProduits un tableau associatif contenant les infos des produits dont les id ont été passé en paramètre
*/
	function getLesProduitsDuTableau($desIdProduit)
	{
		try 
		{
        $monPdo = connexionPDO();
		$nbProduits = count($desIdProduit);
		$lesProduits=array();
		if($nbProduits != 0)
		{
			foreach($desIdProduit as $unIdProduit)
			{
				$req = 'select id, description, prix, image, id_categorie from produit where id = "'.$unIdProduit.'"';
				$res = $monPdo->query($req);
				$unProduit = $res->fetch(PDO::FETCH_ASSOC);
				$lesProduits[] = $unProduit;
			}
		}
		return $lesProduits;
		}
		catch (PDOException $e) 
		{
        print "Erreur !: " . $e->getMessage();
        die();
		}
	}
	/**
	 * Retourne un produit concerné par l'idProduit passée en argument
	 *
	 * @param string $idProduit id d'un Produit
	 * @return array $unProduits un tableau associatif contenant les infos des produits dont l'id a été passé en paramètre
	*/
	function getProduit($idProduit)
	{
		try 
		{
	        $monPdo = connexionPDO();
			$req = 'select id, description, prix, image, id_categorie from produit where id = "'.$idProduit.'"';
			$res = $monPdo->query($req);
			$unProduit = $res->fetch(PDO::FETCH_ASSOC);
			return $unProduit;
		}
		catch (PDOException $e) 
		{
        print "Erreur !: " . $e->getMessage();
        die();
		}
	}
	/**
	 * Créer un produit avec les informations passée en argument
	 * retourne true si le produit est créer, sinon false
	 *
	 * @return boolean $tmp true/false
	*/
	function creerProduit($desc,$prix,$img,$categ)
	{
		$tmp = false;
		try 
		{
	        $monPdo = connexionPDO();
	        $req = "select max(id) as 'id' from produit where id_categorie='$categ'";
	        $res = $monPdo->query($req);
	        $idProduitMax = $res->fetch(PDO::FETCH_ASSOC);
	        $char = strtolower($categ{0});
	        $nbr = str_replace($char, '', $idProduitMax['id']);
	        $nbr++;
	        if(strlen($nbr)==1)
	        	$id= strval($char."0".$nbr);
	        else
	        	$id= strval($char.$nbr);
			$req = "insert into produit values ('$id', '$desc', '$prix', '$img', '$categ');";
			$res = $monPdo->query($req);
			$tmp = true;
		}
		catch (PDOException $e) 
		{
        print "Erreur !: " . $e->getMessage();
        die();
		}
		return $tmp;
	}
	/**
	 * Crée une commande à partir des arguments validés passés en paramètre, crée les lignes de commandes dans la table contenir à partir du
	 * tableau d'idProduit passé en paramètre
	 * 
	 * @param string $mail mail du client
	 * @param array $lesIdProduit tableau associatif contenant les id des produits commandés
	 
	*/
	function creerCommande($mail, $lesIdProduits)
	{
		$tmp = false ;
		try 
		{
        $monPdo = connexionPDO();
		// on récupère le dernier id de commande
		$req = 'select id as maxi from commande';
		$res = $monPdo->query($req);
		$lesLignes = $res->fetchAll();
		$nbr = count($lesLignes)+1 ;
		while (testIdCmd($nbr)==false){
			$nbr++;
		}
		$idCommande = $nbr; 
		$date = date('Y/m/d'); // récupération de la date système
		$req = "insert into commande values ('$idCommande','$date')";
		$res = $monPdo->exec($req);
		// insertion produits commandés
		foreach($lesIdProduits as $unIdProduit)
		{
			$qteProduit=getQteProduit($unIdProduit);
			$req = "insert into contenir values ('$idCommande','$unIdProduit','$qteProduit')";
			$res = $monPdo->exec($req);
		}

		$id = getIdClient($mail);
		$req = "insert into effectuer values ('$id','$idCommande')";
		$res = $monPdo->exec($req);

		$tmp = true ;
		}
		catch (PDOException $e) 
		{
        print "Erreur !: " . $e->getMessage();
        die();
		}
		return $tmp;
	}
	/**
	 * Retourne les produits concernés par le tableau des idProduits passée en argument
	 *
	 * @param int $mois un numéro de mois entre 1 et 12
	 * @param int $an une année
	 * @return array $lesCommandes un tableau associatif contenant les infos des commandes du mois passé en paramètre
	*/
	function getLesCommandesDuMois($mois, $an)
	{
		try 
		{
        $monPdo = connexionPDO();
		$req = 'select id, dateCommande, nomPrenomClient, adresseRueClient, cpClient, villeClient, mailClient from commande where YEAR(dateCommande)= '.$an.' AND MONTH(dateCommande)='.$mois;
		$res = $monPdo->query($req);
		$lesCommandes = $res->fetchAll(PDO::FETCH_ASSOC);
		return $lesCommandes;
		}
		catch (PDOException $e) 
		{
        print "Erreur !: " . $e->getMessage();
        die();
		}
	}

	/**
	 * Test l'existence d'un id de commande
	 * Retourne true si l'id rentrer en paramètre n'existe pas déja sinon false
	 * 
	 * @param string $id id d'une commande
	 * @return boolean $rep true/false
	 */
	function testIdCmd($id){
		$rep=false;
		$monPdo = connexionPDO();
		$req = 'select id from commande where id= '.$id;
		$res = $monPdo->query($req);
		$laCommande = $res->fetch(PDO::FETCH_ASSOC);
		if (!$laCommande){
			$rep=true;
		}
		return $rep;
	}

	/**
	 * Supprime le produit ayant comme id l'id donnée en paramètre
	 * Si le produit est effacer alors on retourne true, sinon false
	 * 
	 * @param string $idProduit  l'id du produit
	 * @return boolean $tmp true/false
	*/
	function supprimerProduit($idProduit)
	{
		$tmp = false;
		try 
		{
	        $monPdo = connexionPDO();
		    $req="delete from produit where id ='$idProduit'";
			$res = $monPdo->query($req);
			$tmp = true;
		} 
		catch (PDOException $e) 
		{
        print "Erreur !: " . $e->getMessage();
        die();
		}
		return $tmp; 
	}
	/**
	 * Modifie le produit ayant comme id l'id donnée en paramètre avec les élèments donnée en plus en paramètre
	 * Si le produit est modifier alors on retourne true, sinon false
	 * 
	 * @param string $idProduit  l'id du produit
	 * @param string $desc  description du produit
	 * @param double $produit  prix du produit
	 * @param string $img  l'image du produit
	 * @param string $categ  catégorie du produit
	 * @return boolean $tmp true/false
	*/
	function modifierProduit($idProduit,$desc,$prix,$img,$categ)
	{
		$tmp = false;
		try 
		{
	        $monPdo = connexionPDO();
	        $lAncienProduit= getProduit($idProduit);
	        $lAncienneCateg= $lAncienProduit['id_categorie'];
		    if($lAncienneCateg!=$categ){
		    	$reqMin = "select min(id) from produit where id_categorie='$categ'";
		        $reqMax = "select max(id) from produit where id_categorie='$categ'";
		        $resMin = $monPdo->query($reqMin);
		        $resMax = $monPdo->query($reqMax);
		        $idProduitMin = $resMin->fetch(PDO::FETCH_ASSOC);
		        $idProduitMax = $resMax->fetch(PDO::FETCH_ASSOC);
		        $char = strtolower($categ{0});
		        $nbrMin = str_replace($char, '', $idProduitMin['min(id)']);
		        $nbrMax = str_replace($char, '', $idProduitMax['max(id)']);
		        $nbrMin--;
		        $nbrMax++;
		        if($nbrMin > 0)
		        	$nbr=$nbrMin;
		        else
		        	$nbr=$nbrMax;
		        if(strlen($nbr)==1)
		           	$id= $char."0".$nbr;
		        else
		           	$id= $char.$nbr;
		    } else {
		    	$id=$idProduit;
		    }
		    $req="update produit set id = '$id', description = '$desc', prix = '$prix', image = '$img', id_categorie = '$categ'  where id='$idProduit' ;";
			$res = $monPdo->query($req);
			$tmp = true;
		} 
		catch (PDOException $e) 
		{
        print "Erreur !: " . $e->getMessage();
        die();
		}
		return $tmp; 
	}
?>