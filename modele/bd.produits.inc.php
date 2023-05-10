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
			$req = 'SELECT p.`id`, p.`libelle`, p.`description`, c.`prix`, c.`stock`, p.`image`, p.`id_categorie`, m.`nom_marque`
				FROM `produit` p
				JOIN `produitcontenance` c ON c.`id` = p.`id`
				JOIN `marque` m ON m.`id_marque`=p.`id_marque`
				WHERE c.`isBase` = 1';
			$res = $monPdo -> query($req);
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
	    $req = $monPdo -> prepare('SELECT p.`id`, p.`libelle`, p.`description`, c.`prix`, c.`stock`, p.`image`, p.`id_categorie`, m.`nom_marque`
	    	FROM `produit` p
				JOIN `produitcontenance` c ON c.`id` = p.`id`
				JOIN `marque` m ON m.`id_marque`=p.`id_marque`
				WHERE p.`id_categorie` = :idCateg AND c.`isBase` = 1');
			$res = $req->execute(array('idCateg' => $idCategorie));
		$lesLignes = $req->fetchAll(PDO::FETCH_ASSOC);
		return $lesLignes; 
		} 
		catch (PDOException $e) 
		{
        print "Erreur !: " . $e->getMessage();
        die();
		}
	}

//TODO
/**
 * Retourne les produits concernés par le tableau des idProduits passée en argument
 *
 * @param array $desIdProduit tableau d'idProduit
 * @return array $lesProduits un tableau associatif contenant les infos des produits dont les id ont été passé en paramètre
*/
	function getLesProduitsDuTableau($desIdProduit)
	{
		try {
	        $monPdo = connexionPDO();
			$nbProduits = count($desIdProduit);
			$lesProduits=array();
			if($nbProduits != 0) {
				foreach($desIdProduit as $unIdProduit)
				{
					$req = $monPdo -> prepare('SELECT p.`id`, c.`id_contenance`, p.`libelle`, p.`description`, c.`prix`, c.`qte`, u.`unit_intitule`, p.`image`, p.`id_categorie`, m.`nom_marque`
						FROM `produit` p
						JOIN `produitcontenance` c ON c.`id` = p.`id`
						JOIN `marque` m ON m.`id_marque`=p.`id_marque`
						JOIN `unites` u ON u.`id_unit`=c.`id_unit`
						WHERE p.`id` = :id AND c.`id_contenance` = :idCont');
				$res = $req->execute(array('id' => $unIdProduit['id'],'idCont' => $unIdProduit['id_contenance']));
					$unProduit = $req->fetch(PDO::FETCH_ASSOC);
					$lesProduits[] = $unProduit;
				}
			}
			return $lesProduits;
		}catch (PDOException $e){
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
			$req = $monPdo -> prepare('SELECT p.`id`, p.`description`, c.`prix`, p.`image`, p.`id_categorie` FROM `produit` p
				JOIN `produitcontenance` c ON c.`id` = p.`id`
				WHERE id = :id AND isBase = 1');
			$res = $req->execute(array('id' => $idProduit));
			$unProduit = $res->fetch(PDO::FETCH_ASSOC);
			return $unProduit;
		}
		catch (PDOException $e) 
		{
        print "Erreur !: " . $e->getMessage();
        die();
		}
	}

	function getInfoProduit($idProduit)
	{
		try 
		{
	        $monPdo = connexionPDO();
			$req = $monPdo->prepare('SELECT p.`id`, p.`libelle`, p.`description`, p.`image`, p.`id_categorie`, cont.`id_contenance` , cont.`prix`, cont.`qte`, cont.`stock`, cont.`isBase`, u.`unit_intitule`, m.`nom_marque`, cat.`libelle` as "libelle_cat"
			FROM `produit` p
			JOIN `produitcontenance` cont ON cont.`id`=p.`id`
			JOIN `unites` u ON u.`id_unit`=cont.`id_unit`
			JOIN `marque` m ON m.`id_marque`=p.`id_marque`
			JOIN `categorie` cat ON cat.`id`=p.`id_categorie`
			WHERE p.`id` =:id ');
			$res = $req->execute(array('id'=>$idProduit));
			$unProduit = $req->fetchAll(PDO::FETCH_ASSOC);
			return $unProduit;
		}
		catch (PDOException $e) 
		{
        print "Erreur !: " . $e->getMessage();
        die();
		}
	}

	//TODO
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
	        $char = strtolower(substr($categ,0));
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
	function creerCommande($mail)
	{
		$tmp = false ;
		try 
		{
	        $monPdo = connexionPDO();
			// on récupère le dernier id de commande
			$req = 'select max(id) as "maxi" from commande';
			$res = $monPdo->query($req);
			$res = $res->fetch();
			if (!is_null($res)){
				$nbr = $res['maxi']+1;
			} else {
				$nbr = 1;
			}
						
			$idCommande = $nbr; 
			$date = date('Y/m/d'); // récupération de la date système

			$req = $monPdo->prepare("INSERT INTO `commande`(`mail`, `id`, `dateCommande`, `etatCde`) VALUES (:mail, :id, :dateC, 'E')");
			$res = $req->execute(array('mail'=>$mail,'id'=>$idCommande,'dateC'=>$date));

			//recherche les élément du panier
			$lesIdProduits = getLesIdProduitsDuPanier($mail);

			// insertion produits commandés
			foreach ($lesIdProduits as $unIdProduit) {
				$qteProduit = getQteProduit($unIdProduit,$mail);
				$req = $monPdo->prepare("INSERT INTO `contenir`(`id`, `id_contenance`, `mail_commande`, `id_commande`, `qte`) VALUES (:id,:idCont,:mail,:idCmd,:qte)") ;
				$res = $req->execute(array('id'=>$unIdProduit['id'],
					'idCont'=>$unIdProduit['id_contenance'],
					'mail'=>$mail,
					'idCmd'=>$idCommande,
					'qte'=>$qteProduit)
				);
			}

			$tmp = true ;
		} catch (PDOException $e) {
	        print "Erreur !: " . $e->getMessage();
	        die();
		}
		return $tmp;
	}

	//TODO
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
	        $req= $monPdo->prepare("DELETE FROM contenir WHERE `id` = :id");
			$res = $req->execute(array('id'=>$idProduit));
	        $req= $monPdo->prepare("DELETE FROM panier WHERE `id` = :id");
			$res = $req->execute(array('id'=>$idProduit));
		    $req= $monPdo->prepare("DELETE FROM produitcontenance WHERE `id` = :id");
			$res = $req->execute(array('id'=>$idProduit));
			$req= $monPdo->prepare("DELETE FROM produit WHERE `id` = :id");
			$res = $req->execute(array('id'=>$idProduit));

			$tmp = true;
		} 
		catch (PDOException $e) 
		{
        print "Erreur !: " . $e->getMessage();
        die();
		}
		return $tmp; 
	}

	//TODO
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
		        $char = strtolower(substr($categ,0));
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
	function getQteMax($idProduit){
		try 
		{
	        $monPdo = connexionPDO();
		    $req= $monPdo->prepare("SELECT `stock` FROM `produitcontenance` WHERE `id` = :id AND `id_contenance` = :idCont ");
			$res = $req->execute(array('id'=>$idProduit['id'],'idCont'=>$idProduit['idCont']));
			$stock= $req->fetch(PDO::FETCH_ASSOC);
			$qteStock= $stock['stock'];
			return $qteStock; 
		} 
		catch (PDOException $e) 
		{
        print "Erreur !: " . $e->getMessage();
        die();
		}
	}
?>