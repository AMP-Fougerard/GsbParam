<?php

/** 
 * Mission 3 : architecture MVC GsbParam
 
 * @file bd.client.inc.php
 * @author Antonin Fougerard <antonin.fougerard@gmail.com>
 * @version    2.0
 * @date octobre 2022
 * @details contient les fonctions d'accès BD à la table clients
 */
include_once 'bd.inc.php';

	function estUnCp($codePostal)
	{
	   return strlen($codePostal)== 5 && estEntier($codePostal);
	}

	function estEntier($valeur) 
	{
		return preg_match("/[^0-9]/", $valeur) == 0;
	}

	function estUnMail($mail)
	{
	return  preg_match ('#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#', $mail);
	}

	/**
	 * Crée un compte client 
	 *
	 * Crée un compte client à partir des arguments validés passés en paramètre, l'identifiant est
	 * construit à partir du maximum existant ; crée les lignes de commandes dans la table contenir à partir du
	 * tableau d'idClient passé en paramètre
	 * @param string $nom nom du client
	 * @param string $rue rue du client
	 * @param string $cp cp du client
	 * @param string $ville ville du client
	 * @param string $mail mail du client 
	*/
	function creerClient($nom,$prenom,$rue,$cp,$ville,$mail,$mdp)
	{
		$tmp = false ;
		try 
		{
			$hash = password_hash($mdp, PASSWORD_DEFAULT);
	        $monPdo = connexionPDO();

			$req = $monPdo->prepare("INSERT INTO compte(mail,pass,nom,prenom,rue,cp,ville,admin) VALUES (:mail, :mdp, :nom, :prenom, :rue, :cp, :ville, '0');");
			$req->bindValue('mail',$mail,PDO::PARAM_STR);
			$req->bindValue('mdp',$hash,PDO::PARAM_STR);
			$req->bindValue('nom',$nom,PDO::PARAM_STR);
			$req->bindValue('prenom',$prenom,PDO::PARAM_STR);
			$req->bindValue('rue',$rue,PDO::PARAM_STR);
			$req->bindValue('cp',$cp,PDO::PARAM_STR);
			$req->bindValue('ville',$ville,PDO::PARAM_STR);
			$req->execute();
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
	 * Crée un compte client 
	 *
	 * Crée un compte client à partir des arguments validés passés en paramètre, l'identifiant est
	 * construit à partir du maximum existant ; crée les lignes de commandes dans la table contenir à partir du
	 * tableau d'idClient passé en paramètre
	 * @param string $mail mail du client 
	*/
	/*function creerClient($mail,$mdp)
	{
		$tmp = false ;
		try 
		{
			$hash = password_hash($mdp, PASSWORD_DEFAULT);
	        $monPdo = connexionPDO();

			$req = $monPdo->prepare("insert into compte (mail,pass,admin) values (:mail,:mdp,false)");
			$res = $req->execute(array('mail'=>$mail,'mdp'=>$hash));
			if (!is_null($res)){
				$tmp = true ;
			}
		}
		catch (PDOException $e) 
		{
	        print "Erreur !: " . $e->getMessage();
	        die();
		}
		return $tmp;
	}*/
	
	/**
	 * Teste client
	 *
	 * Test un compte client à partir des arguments validés passés en paramètre, crée les lignes de commandes dans la table contenir à partir du
	 * @param string $mail mail du client
	 
	*/
	function connexion($mail)
	{
		$tmp = false ;
		try 
		{
	        $monPdo = connexionPDO();
			$req = $monPdo->prepare("select mail from compte where mail=:mail");
			$res = $req->execute(array('mail'=>$mail));
			if (!is_null($res)){
				$tmp = true ;
			}
		}
		catch (PDOException $e) 
		{
	        print "Erreur !: " . $e->getMessage();
	        die();
		}
		return $tmp;
	}
	
	function commandeClient($mail)
	{
		try 
		{
	        $monPdo = connexionPDO();
			$req = $monPdo->prepare("SELECT `id`,`dateCommande`,`etatCde` FROM commande WHERE `mail`=:mail ORDER BY `dateCommande` DESC,`id` DESC ;");
			$res = $req->execute(array('mail'=>$mail));
			$lesLignes = $req->fetchAll(PDO::FETCH_ASSOC);
			return $lesLignes;
		}
		catch (PDOException $e) 
		{
	        print "Erreur !: " . $e->getMessage();
	        die();
		}
	}

	function produitCommande($mail,$id)
	{
		try 
		{
	        $monPdo = connexionPDO();
			$req = $monPdo->prepare("SELECT c.`id`,c.`id_contenance`, p.`image`, p.`libelle`, m.`nom_marque`, pc.`qte` AS 'contenu', u.`unit_intitule`, pc.`prix`, c.`qte`
				FROM contenir c
				JOIN produit p ON p.`id`=c.`id`
				JOIN produitcontenance pc ON pc.`id`=c.`id` AND pc.`id_contenance`=c.`id_contenance`
				JOIN unites u ON u.`id_unit`=pc.`id_unit`
				JOIN marque m ON m.`id_marque`=p.`id_marque`
				WHERE c.`mail_commande`=:mail AND c.`id_commande`=:id
				GROUP BY c.`id`,c.`id_contenance`;");
			$res = $req->execute(array('mail'=>$mail,'id'=>$id));
			$lesLignes = $req->fetchAll(PDO::FETCH_ASSOC);
			return $lesLignes;
		}
		catch (PDOException $e) 
		{
	        print "Erreur !: " . $e->getMessage();
	        die();
		}
	}

	function getInfoClient($mail){
		try 
		{
	        $monPdo = connexionPDO();
			$req = $monPdo->prepare("SELECT nom, prenom, rue, cp, ville FROM compte WHERE mail=:mail");
			$res = $req->execute(array('mail'=>$mail));
			$lesLignes = $req->fetch(PDO::FETCH_ASSOC);
			return $lesLignes;
		}
		catch (PDOException $e) 
		{
	        print "Erreur !: " . $e->getMessage();
	        die();
		}
	}

	/**
	 * Retourne un tableau d'erreurs de saisie pour un client
	 * @param string $mail  chaîne 
	 * @param  string $mdp chaîne
	 * @param  string $mdp2 chaîne
	 * @return array $lesErreurs un tableau de chaînes d'erreurs
	*/
	/*function getErreursSaisieClient($mail,$mdp1,$mdp2)
	{
		$lesErreurs= array();
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
		if($mdp1=="")
		{
			$lesErreurs[]="Il faut saisir le mot de passe";
		}
		else
		{
			if($mdp2=="")
			{
				$lesErreurs[]="Il faut saisir le deuxième mot de passe";
			}
			else
			{
				if($mdp1!=$mdp2)
				{
					$lesErreurs[]="Vos deux mot de passe ne sont pas les mêmes";
				}
			}
		}
		return $lesErreurs;
	}*/

	/**
	 * Retourne un tableau d'erreurs de saisie pour un client
	 * @param string $nom  chaîne testée
	 * @param  string $rue chaîne
	 * @param string $ville chaîne
	 * @param string $cp chaîne
	 * @param string $mail  chaîne 
	 * @param  string $mdp chaîne
	 * @param  string $mdp2 chaîne
	 * @return array $lesErreurs un tableau de chaînes d'erreurs
	*/
	function getErreursSaisieClient($nom,$prenom,$rue,$ville,$cp,$mail,$mdp1,$mdp2)
	{
		$lesErreurs= array();
		if($nom=="")
		{
			$lesErreurs[]="Il faut saisir le champ nom";
		}
		if($prenom=="")
		{
			$lesErreurs[]="Il faut saisir le champ prenom";
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
		if($mdp1=="")
		{
			$lesErreurs[]="Il faut saisir le mot de passe";
		}
		else
		{
			if($mdp2=="")
			{
				$lesErreurs[]="Il faut saisir le deuxième mot de passe";
			}
			else
			{
				if($mdp1!=$mdp2)
				{
					$lesErreurs[]="Vos deux mot de passe ne sont pas les mêmes";
				}
			}
		}
		return $lesErreurs;
	}

	/**
	 * Retourne un tableau d'erreurs de saisie pour une connexion
	 * @param string $mail  chaîne testée
	 * @param  string $mdp chaîne
	 * @return array $lesErreurs un tableau de chaînes d'erreurs
	*/
	function getErreursSaisieConnexion($mail,$mdp)
	{
		$lesErreurs = array();
		$monPdo = connexionPDO();
		$req = $monPdo->prepare("select mail,pass from compte where mail=:mail");
		$res = $req->execute(array('mail'=>$mail));
		$result = $req -> fetch(PDO::FETCH_ASSOC);

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
			else 
			{
				if($mdp=="")
				{
					$lesErreurs[]="Il faut saisir le champ mot de passe";
				} 
				else 
				{
					if($result){
						if(!password_verify($mdp, $result['pass']))
						{
							$lesErreurs[]= "Le mot de passe est incorrect";
						}
					} else {
						$lesErreurs[]= "Ce mail n'existe pas";
					}
				}
			}
		}
		
		return $lesErreurs;
	}
	
	/**
	 * Vérifie si les informations de l'administrateur entrer en paramètre existe dans la BD
	 * true si l'administrateur existe, false sinon
	 * 
	 * @param string $mail mail administrateur
	 * @param string $mdp chaine de caractère
	 * @return boolean $tmp true/false
	 */
	function verifyAdmin($mail)
	{
		$tmp = false;
		try 
		{
			$monPdo = connexionPDO();
			$req = $monPdo->prepare("select admin from compte where mail=:mail AND admin=1");
			$res = $req->execute(array('mail'=>$mail));
			$res = $req -> fetch(PDO::FETCH_ASSOC);
			if ($res){
				if ($res['admin'])
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
	function getNomAdmin($mail){
		try 
		{
			$monPdo = connexionPDO();
			$req = $monPdo->prepare("select nom from compte where mail=:mail AND admin=1");
			$res = $req->execute(array('mail'=>$mail));
			$array = $req -> fetch(PDO::FETCH_ASSOC);
			return $array['nom'];
		}
		catch (PDOException $e) 
		{
	        print "Erreur !: " . $e->getMessage();
	        die();
		}
	}
?>