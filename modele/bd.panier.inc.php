<?php
function ajouterAuPanier($idProduit,$mail,$qte)
{
	$tmp = false;
	try {
      $monPdo = connexionPDO();
      $req = $monPdo->prepare('SELECT `id`,`id_contenance` FROM `panier`
      	WHERE `mail`=:mail AND `id`=:id AND `id_contenance`=:idCont');
		$res = $req->execute(array('mail'=>$mail, 'id'=>$idProduit['id'],'idCont'=>$idProduit['idCont']));
		$lesLignes = $req->fetchAll(PDO::FETCH_ASSOC);
		if (count($lesLignes)<=0){
			$req = $monPdo->prepare('INSERT INTO `panier`(`id`,`id_contenance`,`mail`,`qte`) VALUES(:id,:idCont,:mail,:qte)');
			$res = $req->execute(array('id'=>$idProduit['id'],'idCont'=>$idProduit['idCont'],'mail'=>$mail,'qte'=>$qte));
			$tmp = true ;
		}
	} 
	catch (PDOException $e) {
      print "Erreur !: " . $e->getMessage();
      die();
	}
	return $tmp;
}
function supprimerPanier($mail)
{
	$tmp = false;
	try {
      $monPdo = connexionPDO();
		$req = $monPdo->prepare('DELETE FROM `panier` WHERE `mail`=:mail');
		$res = $req->execute(array('mail'=>$mail));
		
		if (!is_null($res)){
			$tmp = true ;
		}
	} 
	catch (PDOException $e) {
      print "Erreur !: " . $e->getMessage();
      die();
	}
	return $tmp;
}
function getLesIdProduitsDuPanier($mail)
{
	try {
      $monPdo = connexionPDO();
		$req = $monPdo->prepare('SELECT `id`, `id_contenance` FROM `panier` WHERE mail=:mail');
		$res = $req->execute(array('mail'=>$mail));
		$lesLignes = $req->fetchAll(PDO::FETCH_ASSOC);
		return $lesLignes;
	} 
	catch (PDOException $e) {
      print "Erreur !: " . $e->getMessage();
      die();
	}
}

function nbProduitsDuPanier($mail)
{
	try {
      $monPdo = connexionPDO();
		$req = $monPdo->prepare('SELECT SUM(`qte`) as "qteTotal" FROM `panier` WHERE mail=:mail');
		$res = $req->execute(array('mail'=>$mail));
		$req = $req->fetch(PDO::FETCH_ASSOC);
		$nbr = $req['qteTotal'];
		return $nbr;
	} 
	catch (PDOException $e) {
      print "Erreur !: " . $e->getMessage();
      die();
	}	
}

function retirerDuPanier($idProduit,$mail)
{
	$tmp = false;
	try {
      $monPdo = connexionPDO();
		$req = $monPdo->prepare('DELETE FROM `panier` WHERE id=:id AND id_contenance=:idCont AND mail=:mail');
		$res = $req->execute(array('id'=>$idProduit['id'],'idCont'=>$idProduit['idCont'],'mail'=>$mail));
		if (!is_null($res)){
			$tmp = true ;
		}
	} 
	catch (PDOException $e) {
      print "Erreur !: " . $e->getMessage();
      die();
	}	
	return $tmp ;
}

function getQteProduit($idProduit,$mail)
{
	try {
      $monPdo = connexionPDO();
		$req = $monPdo->prepare('SELECT `qte` FROM `panier` WHERE id=:id AND id_contenance=:idCont AND mail=:mail');
		$res = $req->execute(array('id'=>$idProduit['id'],'idCont'=>$idProduit['id_contenance'],'mail'=>$mail));
		$res = $req->fetch(PDO::FETCH_ASSOC);
		$nbr = $res['qte'];
		return $nbr;
	} 
	catch (PDOException $e) {
      print "Erreur !: " . $e->getMessage();
      die();
	}	
}

function modifierQteProduit($idProduit,$mail,$qte)
{
	$tmp = false;
	try {
    	$monPdo = connexionPDO();
		$req = $monPdo->prepare('UPDATE `panier` SET `qte`=:qte WHERE `id`=:id AND `id_contenance`=:idCont AND `mail`=:mail');
		$res = $req->execute(array('qte'=>$qte,'id'=>$idProduit['id'],'idCont'=>$idProduit['idCont'],'mail'=>$mail));
		if (!is_null($res)){
			$tmp = true ;
		}
	} 
	catch (PDOException $e) {
      print "Erreur !: " . $e->getMessage();
      die();
	}
	return $tmp ;
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
function getErreursSaisieCommande($mail)
{
	$lesErreurs = array();
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
