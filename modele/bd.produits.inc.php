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
		try {
	        $monPdo = connexionPDO();
			$req = "select id, libelle from categorie where id='$idCategorie'";
			$res = $monPdo->query($req);
			$laLigne = $res->fetch(PDO::FETCH_ASSOC);
			return $laLigne;
		} catch (PDOException $e) {
	        print "Erreur !: " . $e->getMessage();
	        die();
		}
	}

	function getNomCateg($idCategorie)
	{
		try {
	        $monPdo = connexionPDO();
			$req = "select libelle from categorie where id='$idCategorie'";
			$res = $monPdo->query($req);
			$laLigne = $res->fetch(PDO::FETCH_ASSOC);
			return $laLigne['libelle'];
		} catch (PDOException $e) {
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
					$req = $monPdo -> prepare('SELECT p.`id`, c.`id_contenance`, p.`libelle`, p.`description`, c.`prix`, c.`qte`, c.`stock`, u.`unit_intitule`, p.`image`, p.`id_categorie`, m.`nom_marque`
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
			$req = $monPdo -> prepare('SELECT p.`id`, p.`libelle`, p.`description`, p.`image`, p.`id_categorie`, cont.`id_contenance` , cont.`prix`, cont.`qte`, cont.`stock`, u.`unit_intitule`, m.`nom_marque`
				FROM `produit` p
				JOIN `produitcontenance` cont ON cont.`id`=p.`id`
				JOIN `unites` u ON u.`id_unit`=cont.`id_unit`
				JOIN `marque` m ON m.`id_marque`=p.`id_marque`
				WHERE p.`id` = :id AND cont.`isBase`=1');
			$res = $req->execute(array('id' => $idProduit));
			$array = $req->fetch(PDO::FETCH_ASSOC);
			return $array;
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
	 * @param string $name nom du produit
	 * @param string $desc description du produit
	 * @param string $img lien de l'image du produit
	 * @param string $categ catégorie du produit
	 * @param int $marque id de la marque du produit
	 * @param double $prix prix du produit
	 * @param int $stock stock du produit
	 * @param double $cont volume du produit
	 * @param string $unit unité du produit
	 * @return boolean $tmp true/false
	*/
	function creerProduit($name,$desc,$img,$categ,$marque,$prix,$stock,$cont,$unit,$lesContenances)
	{
		$tmp = false;
		try 
		{
	        $monPdo = connexionPDO();
	        $req = $monPdo->prepare("select max(id) as 'id' from produit where id_categorie=:categ");
	        $res = $req->execute(array('categ'=>$categ));
	        $idProduitMax = $req->fetch(PDO::FETCH_ASSOC);
	        // var_dump($idProduitMax);
	        $char = strtolower(substr($categ,0,1));
	        // var_dump($char);
	        $nbr = str_replace($char, '', $idProduitMax['id']);
	        // var_dump($nbr);
	        $nbr++;
	        // var_dump($nbr);
	        if(strlen($nbr)==1)
	        	$id= strval($char."0".$nbr);
	        else
	        	$id= strval($char.$nbr);
	        // var_dump($id);
			$req = $monPdo->prepare("insert into produit(id, libelle, description,image,dateMiseEnRayon,id_categorie,id_marque) values (:id, :libel, :desc, :img, :date,:categ,:marque);");
			$res = $req->execute(array('id'=>$id,
				'libel'=>$name,
				'desc'=>$desc,
				'img'=>$img,
				'date'=>"0000-00-00",
				'categ'=>$categ,
				'marque'=>$marque));
			$req = $monPdo->prepare("insert into produitcontenance(id, id_contenance, prix,qte,stock,isBase,id_unit) values (:id, :idCont, :prix, :qte, :stock,:base,:unit);");
			$res = $req->execute(array('id'=>$id,
				'idCont'=>1,
				'prix'=>$prix,
				'qte'=>$cont,
				'stock'=>$stock,
				'base'=>1,
				'unit'=>$unit
			));
			if($lesContenances){
				if (creerContenancesProduit($id,$lesContenances)) {
					$tmp = true;
				}
			}else{
				$tmp = true;
			}
		}
		catch (PDOException $e) 
		{
        print "Erreur !: " . $e->getMessage();
        die();
		}
		return $tmp;
	}

	function creerContenancesProduit($id,$contenances)
	{
		$tmp = false;
		try 
		{
	        $monPdo = connexionPDO();
	        foreach($contenances as $uneContenance){
		       	$req = $monPdo->prepare("select max(id_contenance) as 'idCont' from produitcontenance where id=:id");
		        $res = $req->execute(array('id'=>$id));
		        $array = $req->fetch(PDO::FETCH_ASSOC);
		        $idCont= $array['idCont']+1;

		        $unit= $uneContenance["unit"];
				$idUnit=getIdUnit($unit);
				if($idUnit == null){
					$idUnit = addUnit($unit);
				}

		    	$req = $monPdo->prepare("insert into produitcontenance(id, id_contenance, prix, qte, stock, isBase, id_unit) values (:id, :idCont, :prix, :qte, :stock,:base,:unit);");
		    	$res = $req->execute(array('id'=>$id,
		    		'idCont'=>$idCont,
		    		'prix'=>$uneContenance["prix"],
		    		'qte'=>$uneContenance["qte"],
		        	'stock'=>$uneContenance["stock"],
		        	'base'=>0,
		        	'unit'=>$idUnit
		        ));
		        			}
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
	 * 
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
			$nbr = $res->fetch(PDO::FETCH_ASSOC);
			$nbr = $nbr['maxi'];
			if($nbr != null){
				//vérifie si le numéro de commande n'est pas déja attribuer
				$req = $monPdo->prepare('SELECT id FROM commande WHERE id=:id');
				$res = $req->execute(array('id'=>$nbr));
				$array = $req->fetch();
				$result = $array['id'];
				while($result !=  null){
					$nbr = (int)$result;
					//var_dump($nbr);
					$nbr ++;
					//var_dump($nbr);
					$nbr = strval($nbr);
					//var_dump($nbr);
					$dif = 6-strlen($nbr);
					//var_dump($dif);
					$nbr = str_repeat('0', $dif).strval($nbr);
					//var_dump($nbr);

					$req = $monPdo->prepare('SELECT id FROM commande WHERE id=:id');
					$res = $req->execute(array('id'=>$nbr));
					$array = $req->fetch();
					$result = $array['id'];
				}
			} else {
				$nbr="000001";
			}
			//recherche les élément du panier
			$lesIdProduits = getLesIdProduitsDuPanier($mail);
			if ( $lesIdProduits ){
				$idCommande = $nbr; 
				$date = date('Y/m/d'); // récupération de la date système

				$req = $monPdo->prepare("INSERT INTO `commande`(`mail`, `id`, `dateCommande`, `etatCde`) VALUES (:mail, :id, :dateC, 'E')");
				$res = $req->execute(array('mail'=>$mail,'id'=>$idCommande,'dateC'=>$date));
			
				foreach ($lesIdProduits as $unIdProduit) {
					// insertion produit commandé
					$qteProduit = getQteProduitPanier($unIdProduit,$mail);
					$req = $monPdo->prepare("INSERT INTO `contenir`(`id`, `id_contenance`, `mail_commande`, `id_commande`, `qte`) VALUES (:id,:idCont,:mail,:idCmd,:qte)") ;
					$res = $req->execute(array('id'=>$unIdProduit['id'],
						'idCont'=>$unIdProduit['id_contenance'],
						'mail'=>$mail,
						'idCmd'=>$idCommande,
						'qte'=>$qteProduit));

					//récupération de la quantité en stock
					$stock=getQteMaxStock($unIdProduit);
					
					//enlever la quantite commandés du stock
					$qteRestante=$stock-$qteProduit;
					$req = $monPdo->prepare("UPDATE `produitcontenance` SET `stock`=:qte WHERE `id`=:id AND `id_contenance`=:idCont ;") ;
					$res = $req->execute(array('id'=>$unIdProduit['id'],
						'idCont'=>$unIdProduit['id_contenance'],
						'qte'=>$qteRestante));
				}
				$tmp = true ;
			} 
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
		try {
	        $monPdo = connexionPDO();
			$req = 'select id, dateCommande, nomPrenomClient, adresseRueClient, cpClient, villeClient, mailClient from commande where YEAR(dateCommande)= '.$an.' AND MONTH(dateCommande)='.$mois;
			$res = $monPdo->query($req);
			$lesCommandes = $res->fetchAll(PDO::FETCH_ASSOC);
			return $lesCommandes;
		}
		catch (PDOException $e) {
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
	function supprimerContenanceProduit($idProduit)
	{
		$tmp = false;
		try 
		{
	        $monPdo = connexionPDO();
	        $req= $monPdo->prepare("SELECT `id_contenance` FROM produitcontenance WHERE `id` = :id AND `isBase`=0");
			$res = $req->execute(array('id'=>$idProduit));
			$array=$req->fetchAll(PDO::FETCH_ASSOC);
			foreach($array as $contenance){
				$id=$contenance['id_contenance'];
				$req= $monPdo->prepare("DELETE FROM contenir WHERE `id`=:idProd AND `id_contenance` = :id");
				$res = $req->execute(array('idProd'=>$idProduit,'id'=>$idProduit));
		        $req= $monPdo->prepare("DELETE FROM panier WHERE `id`=:idProd AND `id_contenance` = :id");
				$res = $req->execute(array('idProd'=>$idProduit,'id'=>$idProduit));
			}
		    $req= $monPdo->prepare("DELETE FROM produitcontenance WHERE `id` = :id AND `isBase`=0");
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
	function modifierProduit($idProduit,$name,$desc,$img,$categ,$marque,$prix,$stock,$cont,$unit,$lesContenances)
	{
		$tmp = false;
		try 
		{
	        $monPdo = connexionPDO();
	        $lAncienProduit= getProduit($idProduit);
	        $lAncienneCateg= $lAncienProduit['id_categorie'];
		    if($lAncienneCateg!=$categ){
		    	if(creerProduit($name,$desc,$img,$categ,$marque,$prix,$stock,$cont,$unit,$lesContenances) AND supprimerProduit($idProduit)){
					$tmp = true;
				}
		    } else {
		    	$id=$idProduit;
		    	$req = $monPdo->prepare("UPDATE produitcontenance set prix = :prix,qte = :qte, stock = :stock,id_unit = :unit where id=:id;");
				$res = $req->execute(array('id'=>$id,
					'prix'=>$prix,
					'qte'=>$cont,
					'stock'=>$stock,
					'unit'=>$unit,));

			    $req = $monPdo->prepare("UPDATE produit set libelle = :libel, description = :descr, image=:img, id_categorie=:categ, id_marque=:marque where id=:id ;");
				$res = $req->execute(array('id'=>$id,
					'libel'=>$name,
					'descr'=>$desc,
					'img'=>$img,
					'categ'=>$categ,
					'marque'=>$marque));
				if($lesContenances){
					if(supprimerContenanceProduit($id)){
						if(creerContenancesProduit($id,$lesContenances)){
							$tmp=true;
						}
					}	
				} else {
					$tmp=true;
				}
		    }
		} 
		catch (PDOException $e) 
		{
        print "Erreur !: " . $e->getMessage();
        die();
		}
		return $tmp; 
	}
	function getQteMaxStock($idProduit){
		try 
		{
	        $monPdo = connexionPDO();
		    $req= $monPdo->prepare("SELECT `stock` FROM `produitcontenance` WHERE `id` = :id AND `id_contenance` = :idCont ");
			$res = $req->execute(array('id'=>$idProduit['id'],'idCont'=>$idProduit['id_contenance']));
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

	function getArticleByPrix($prixMin,$prixMax){
		try {
	        $monPdo = connexionPDO();
		    $req= $monPdo->prepare("SELECT `id`,`id_contenance` FROM `produitcontenance` WHERE `prix` >= :Min AND `prix` <= :Max ");
			$res = $req->execute(array('Min'=>$prixMin,'Max'=>$prixMax));
			$array= $req->fetchAll(PDO::FETCH_ASSOC);
			return $array; 
		} catch (PDOException $e) {
	        print "Erreur !: " . $e->getMessage();
	        die();
		}
	}
	function getPrixArticlePlusChere(){
		try {
	        $monPdo = connexionPDO();
		    $req= $monPdo->prepare("SELECT MAX(`prix`) AS 'prixMax' FROM `produitcontenance` ");
			$res = $req->execute();
			$array= $req->fetch(PDO::FETCH_ASSOC);
			return $array['prixMax']; 
		} catch (PDOException $e) {
	        print "Erreur !: " . $e->getMessage();
	        die();
		}
	}
	function getNomsMarques(){
		try {
	        $monPdo = connexionPDO();
		    $req= $monPdo->prepare("SELECT `nom_marque` FROM `marque`");
			$res = $req->execute();
			$array= $req->fetchAll(PDO::FETCH_ASSOC);
			return $array; 
		} catch (PDOException $e) {
	        print "Erreur !: " . $e->getMessage();
	        die();
		}
	}
	function getIdMarque($nomMarque){
		try {
	        $monPdo = connexionPDO();
		    $req= $monPdo->prepare("SELECT `id_marque` FROM `marque` WHERE `nom_marque`=:marque");
			$res = $req->execute(array('marque'=>$nomMarque));
			$array= $req->fetch(PDO::FETCH_ASSOC);
			return $array['id_marque']; 
		} catch (PDOException $e) {
	        print "Erreur !: " . $e->getMessage();
	        die();
		}
	}
	function addMarque($nomMarque){
		try {
	        $monPdo = connexionPDO();
		    $req= $monPdo->prepare("INSERT INTO `marque`(`nom_marque`) VALUES (:marque)");
			$res = $req->execute(array('marque'=>$nomMarque));
			$id = getIdMarque($nomMarque);
			return $id;
		} catch (PDOException $e) {
	        print "Erreur !: " . $e->getMessage();
	        die();
		}
		
	}
	function getUnit(){
		try {
	        $monPdo = connexionPDO();
		    $req= $monPdo->prepare("SELECT `unit_intitule` AS 'unit' FROM `unites`");
			$res = $req->execute();
			$array= $req->fetchAll(PDO::FETCH_ASSOC);
			return $array; 
		} catch (PDOException $e) {
	        print "Erreur !: " . $e->getMessage();
	        die();
		}
	}
	function getIdUnit($unit){
		try {
	        $monPdo = connexionPDO();

		    $req= $monPdo->prepare("SELECT `id_unit` FROM `unites` WHERE `unit_intitule`=:unit");
			$res = $req->execute(array('unit'=>$unit));
			$array= $req->fetch(PDO::FETCH_ASSOC);
			return $array['id_unit']; 
		} catch (PDOException $e) {
	        print "Erreur !: " . $e->getMessage();
	        die();
		}
	}
	function addUnit($unit){
		try {
	        $monPdo = connexionPDO();
 			$req= $monPdo->prepare("SELECT MAX(`id_unit`) as 'id' FROM `unites`");
			$res = $req->execute();
			$array = $req -> fetch(PDO::FETCH_ASSOC);
			$id = $array['id']+1;
		    $req= $monPdo->prepare("INSERT INTO `unites`(`id_unit`,`unit_intitule`) VALUES (:id,:unit)");
			$res = $req->execute(array('id'=>$id,'unit'=>$unit));
			return $id;
		} catch (PDOException $e) {
	        print "Erreur !: " . $e->getMessage();
	        die();
		}
	}

	function getContenance($idProduit)
	{
		try 
		{
	        $monPdo = connexionPDO();
			$req = $monPdo -> prepare('SELECT cont.`id_contenance`, cont.`prix`, cont.`qte`, cont.`stock`, u.`unit_intitule`
				FROM `produitcontenance` cont
				JOIN `unites` u ON u.`id_unit`=cont.`id_unit`
				WHERE cont.`id` = :id AND cont.`isBase`=0');
			$res = $req->execute(array('id' => $idProduit));
			$array = $req->fetchAll(PDO::FETCH_ASSOC);
			return $array;
		}
		catch (PDOException $e) 
		{
        print "Erreur !: " . $e->getMessage();
        die();
		}
	}

	/**
	 * Retourne un tableau d'erreurs de saisie pour un produit
	 *
	 * @param string $desc description d'un produit
	 * @param double $prix prix d'un produit
	 * @param string $img url
	 * @return array $lesErreurs un tableau de chaînes d'erreurs
	*/
	function getErreursSaisieProduit($name,$desc,$img,$marque,$categ,$stock,$cont,$unit)
	{
		$lesErreurs = array();
		if($name=="")
		{
			$lesErreurs[]="Il faut saisir le champ nom";
		}
		if($desc=="")
		{
			$lesErreurs[]="Il faut saisir le champ description";
		}
		if($img=="")
		{
			$lesErreurs[]="Il faut saisir le champ image";
		}
		if($marque=="")
		{
			$lesErreurs[]="Il faut saisir le champ marque";
		}
		if($categ=="")
		{
			$lesErreurs[]="Il faut choisir une catégorie";
		}
		if($stock=="")
		{
			$lesErreurs[]="Il faut saisir le champ stock";
		}
		if($cont=="")
		{
			$lesErreurs[]="Il faut saisir le champ contenance";
		}
		if($unit=="")
		{
			$lesErreurs[]="Il faut saisir le champ unités";
		}
				return $lesErreurs;
	}
?>