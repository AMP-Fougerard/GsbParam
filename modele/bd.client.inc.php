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

	        $id = getIdInexistant();

			$req1 = $monPdo->prepare("insert into login (mail,mdp) values (:mail,:mdp)");
			$res1 = $req1->execute(array('mail'=>$mail,'mdp'=>$hash));

			$req2 = $monPdo->prepare("insert into client (id,nom,prenom,adresseRue,cp,ville,mail) values (:id,:nom,:prenom,:rue,:cp,:ville,:mail)");
			$res2 = $req2->execute(array('id'=>$id,'nom'=>$nom,'prenom'=>$prenom,'rue'=>$rue,'cp'=>$cp,'ville'=>$ville,'mail'=>$mail));

			if (!is_null($res) && !is_null($res2)){
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
	/**
	 * Teste client
	 *
	 * Test un compte client à partir des arguments validés passés en paramètre, crée les lignes de commandes dans la table contenir à partir du
	 * tableau d'idClient passé en paramètre
	 * @param string $nom nom du client
	 * @param string $rue rue du client
	 * @param string $cp cp du client
	 * @param string $ville ville du client
	 * @param string $mail mail du client
	 
	*/
	function connexion($mail)
	{
		$tmp = false ;
		try 
		{
	        $monPdo = connexionPDO();
			$req = $monPdo->prepare("select mail,mdp from login where mail=:mail");
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
	/**
	 * Retourne un tableau d'erreurs de saisie pour un client
	 * @param string $nom  chaîne testée
	 * @param  string $rue chaîne
	 * @param string $ville chaîne
	 * @param string $cp chaîne
	 * @param string $mail  chaîne 
	 * @return array $lesErreurs un tableau de chaînes d'erreurs
	*/
	function getErreursSaisieClient($nom,$prenom,$rue,$ville,$cp,$mail,$mdp1,$mdp2)
	{
		$lesErreurs = array();
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
		$req = $monPdo->prepare("select mail,mdp from login where mail=:mail and mdp=:mdp");
		$res = $req->execute(array('mail'=>$mail,'mdp'=>$mdp));
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
					if (!$result)
					{
						$lesErreurs[]= "Ce mail n'existe pas";
					} 
					else 
					{
						if(password_verify($mdp, $result['mdp']))
						{
							$lesErreurs[]= "Le mot de passe est incorrect";
						}
						
					}
				}
			}
		}
		
		return $lesErreurs;
	}

	/**
	 * Retourne le nom du client en prenant comme paramètre un mail
	 * @param string $mail  chaîne testée
	 * @return array $res['nom'] chaîne de caractère
	*/
	function getNomClient($mail){
		$monPdo = connexionPDO();
		$req = $monPdo->prepare("select nom from client where mail=:mail");
		$res = $req->execute(array('mail'=>$mail));
		return $res['nom'];
	}

	/**
	 * Retourne un id aléatoire en héxadécimal qui n'existe pas dans la bdd
	 * Si l'id existe déja il fait une récursivité
	 * @return array $id chaîne de caractère 
	*/
	function getIdInexistant(){
		$monPdo = connexionPDO();
		$id = dechex(rand(10000,999999999999));
		$req = $monPdo->prepare("select id from client where id=:id");
		$res = $req->execute(array('id'=>$id));
		if (isset($res)){
			$id = getIdInexistant();
		}
		return $id;
	}
?>