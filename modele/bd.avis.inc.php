<?php
function getMoyNoteAvisProduit($idProduit){
	try {
	    $monPdo = connexionPDO();
		$req = $monPdo -> prepare('SELECT AVG(`note`)
			FROM `avis` a
			JOIN `concerne` c ON c.`mail`=a.`mail` AND c.`idAvis`=a.`idAvis`
			WHERE c.`id` = :id
			GROUP BY c.`mail`=a.`mail` AND c.`idAvis`=a.`idAvis`');
		$res = $req->execute(array('id' => $idProduit));
		$moyProduit = $req->fetch(PDO::FETCH_ASSOC);
		return $moyProduit;
	}
	catch (PDOException $e) 
	{
    	print "Erreur !: " . $e->getMessage();
    	die();
	}
}
function getNbrAvisProduit($idProduit){
	try {
	    $monPdo = connexionPDO();
		$req = $monPdo -> prepare('SELECT count(*) AS "nbr" 
			FROM `concerne`
			WHERE `id` = :id');
		$res = $req->execute(array('id' => $idProduit));
		$nbr = $req->fetch(PDO::FETCH_ASSOC);
		$nbrAvis=$nbr['nbr'];
		return $nbrAvis;
	}
	catch (PDOException $e) 
	{
    	print "Erreur !: " . $e->getMessage();
    	die();
	}
}
function creerAvisProduit($idProduit,$mail,$note,$contenu){
	$tmp= false;
	try {
	    $monPdo = connexionPDO();
		$req = $monPdo -> prepare('SELECT count(`idAvis`) as "nbr"
			FROM `concerne`
			WHERE `id` = :id AND `mail` = :mail ');
		$res = $req->execute(array('id' => $idProduit, 'mail' => $mail));
		$nbr = $req->fetch(PDO::FETCH_ASSOC);
		$nbr=$nbr['nbr'];
		if (is_null($nbr)){
			$idAvis=1;
		} else {
			$idAvis=$nbr++;
		}
		$req = $monPdo -> prepare('INSERT INTO `avis`(`mail`,`idAvis`,`note`,`contenu_avis`) 
			VALUES (:mail,:idAvis,:note,:contenu)');
		$res = $req->execute(array('mail' => $mail,'idAvis'=>$idAvis,'note'=>$note,'contenu'=>$contenu));
		$req = $monPdo -> prepare('INSERT INTO `concerne`(`id`,`mail`,`idAvis`) 
			VALUES (:id,:mail,:idAvis)');
		$res = $req->execute(array('id' => $idProduit, 'mail' => $mail,'idAvis'=>$idAvis));
		$tmp= true;
	} catch (PDOException $e) {
    	print "Erreur !: " . $e->getMessage();
    	die();
	}
}
function getListeAvisProduit($idProduit){
	try {
	    $monPdo = connexionPDO();
		$req = $monPdo -> prepare('SELECT c.`id`, c.`mail`, a.`note`, a.`contenu_avis`
			FROM `avis` a
			JOIN `concerne` c ON c.`mail`=a.`mail` AND c.`idAvis`=a.`idAvis`
			WHERE c.`id` = :id
			ORDER BY DESC');
		$res = $req->execute(array('id' => $idProduit));
		$listeAvisProduit = $res->fetchAll(PDO::FETCH_ASSOC);
		return $listeAvisProduit;
	}
	catch (PDOException $e) 
	{
    	print "Erreur !: " . $e->getMessage();
    	die();
	}
}
?>