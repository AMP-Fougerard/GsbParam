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
	 * @param string $mail mail du client
	 
	*/
	function creerClient($mail,$mdp)
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
	}
	
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
	
	/**
	 * Retourne un tableau d'erreurs de saisie pour un client
	 * @param string $mail  chaîne 
	 * @param  string $mdp chaîne
	 * @param  string $mdp2 chaîne
	 * @return array $lesErreurs un tableau de chaînes d'erreurs
	*/
	function getErreursSaisieClient($mail,$mdp1,$mdp2)
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
					if ($mail!=$result['mail'])
					{
						$lesErreurs[]= "Ce mail n'existe pas";
					} 
					else 
					{
						if(!password_verify($mdp, $result['pass']))
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
			$req = $monPdo->prepare("select admin from compte where mail=:mail");
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

?>