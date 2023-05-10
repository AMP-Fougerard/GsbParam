#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: archivagecommande
#------------------------------------------------------------

CREATE TABLE archivagecommande(
        id               Char (32) NOT NULL ,
        dateCommande     Date ,
        nomPrenomClient  Char (32) ,
        adresseRueClient Char (32) ,
        cpClient         Char (5) ,
        villeClient      Char (32) ,
        mailClient       Char (50)
	,CONSTRAINT archivagecommande_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: categorie
#------------------------------------------------------------

CREATE TABLE categorie(
        id      Char (32) NOT NULL ,
        libelle Char (32)
	,CONSTRAINT categorie_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: compte
#------------------------------------------------------------

CREATE TABLE compte(
        mail  Varchar (50) NOT NULL ,
        pass  Varchar (255) ,
        admin Bool NOT NULL
	,CONSTRAINT compte_PK PRIMARY KEY (mail)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: commande
#------------------------------------------------------------

CREATE TABLE commande(
        mail         Varchar (50) NOT NULL ,
        id           Char (32) NOT NULL ,
        dateCommande Date ,
        etatCde      Char (1) NOT NULL
	,CONSTRAINT commande_PK PRIMARY KEY (mail,id)

	,CONSTRAINT commande_compte_FK FOREIGN KEY (mail) REFERENCES compte(mail)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: produit
#------------------------------------------------------------

CREATE TABLE produit(
        id              Char (32) NOT NULL ,
        description     Char (50) ,
        prix            Decimal (10) ,
        image           Char (100) ,
        stock           Int NOT NULL ,
        dateMiseEnRayon Date NOT NULL ,
        id_categorie    Char (32) NOT NULL
	,CONSTRAINT produit_PK PRIMARY KEY (id)

	,CONSTRAINT produit_categorie_FK FOREIGN KEY (id_categorie) REFERENCES categorie(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: unites
#------------------------------------------------------------

CREATE TABLE unites(
        id_unit       Int NOT NULL ,
        unit_intitule Varchar (50) NOT NULL
	,CONSTRAINT unites_PK PRIMARY KEY (id_unit)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: ProduitContenance
#------------------------------------------------------------

CREATE TABLE ProduitContenance(
        id            Char (32) NOT NULL ,
        id_contenance Int NOT NULL ,
        qte           Int NOT NULL ,
        isBase        Bool NOT NULL ,
        id_unit       Int NOT NULL
	,CONSTRAINT ProduitContenance_PK PRIMARY KEY (id,id_contenance)

	,CONSTRAINT ProduitContenance_produit_FK FOREIGN KEY (id) REFERENCES produit(id)
	,CONSTRAINT ProduitContenance_unites0_FK FOREIGN KEY (id_unit) REFERENCES unites(id_unit)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: avis
#------------------------------------------------------------

CREATE TABLE avis(
        mail         Varchar (50) NOT NULL ,
        idAvis       Int NOT NULL ,
        note         Float NOT NULL ,
        contenu_avis Int NOT NULL
	,CONSTRAINT avis_PK PRIMARY KEY (mail,idAvis)

	,CONSTRAINT avis_compte_FK FOREIGN KEY (mail) REFERENCES compte(mail)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: promotion
#------------------------------------------------------------

CREATE TABLE promotion(
        id_reduc  Float NOT NULL ,
        poidsReco Int NOT NULL
	,CONSTRAINT promotion_PK PRIMARY KEY (id_reduc)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: contenir
#------------------------------------------------------------

CREATE TABLE contenir(
        id            Char (32) NOT NULL ,
        id_contenance Int NOT NULL ,
        mail_commande Varchar (50) NOT NULL ,
        id_commande   Char (32) NOT NULL
	,CONSTRAINT contenir_PK PRIMARY KEY (id,id_contenance,mail_commande,id_commande)

	,CONSTRAINT contenir_ProduitContenance_FK FOREIGN KEY (id,id_contenance) REFERENCES ProduitContenance(id,id_contenance)
	,CONSTRAINT contenir_commande0_FK FOREIGN KEY (mail_commande,id_commande) REFERENCES commande(mail,id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: archivecontenir
#------------------------------------------------------------

CREATE TABLE archivecontenir(
        id                   Char (32) NOT NULL ,
        id_archivagecommande Char (32) NOT NULL
	,CONSTRAINT archivecontenir_PK PRIMARY KEY (id,id_archivagecommande)

	,CONSTRAINT archivecontenir_produit_FK FOREIGN KEY (id) REFERENCES produit(id)
	,CONSTRAINT archivecontenir_archivagecommande0_FK FOREIGN KEY (id_archivagecommande) REFERENCES archivagecommande(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Panier
#------------------------------------------------------------

CREATE TABLE Panier(
        id            Char (32) NOT NULL ,
        id_contenance Int NOT NULL ,
        mail          Varchar (50) NOT NULL
	,CONSTRAINT Panier_PK PRIMARY KEY (id,id_contenance,mail)

	,CONSTRAINT Panier_ProduitContenance_FK FOREIGN KEY (id,id_contenance) REFERENCES ProduitContenance(id,id_contenance)
	,CONSTRAINT Panier_compte0_FK FOREIGN KEY (mail) REFERENCES compte(mail)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: concerne
#------------------------------------------------------------

CREATE TABLE concerne(
        id     Char (32) NOT NULL ,
        mail   Varchar (50) NOT NULL ,
        idAvis Int NOT NULL
	,CONSTRAINT concerne_PK PRIMARY KEY (id,mail,idAvis)

	,CONSTRAINT concerne_produit_FK FOREIGN KEY (id) REFERENCES produit(id)
	,CONSTRAINT concerne_avis0_FK FOREIGN KEY (mail,idAvis) REFERENCES avis(mail,idAvis)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: sur
#------------------------------------------------------------

CREATE TABLE sur(
        id_reduc Float NOT NULL ,
        id       Char (32) NOT NULL
	,CONSTRAINT sur_PK PRIMARY KEY (id_reduc,id)

	,CONSTRAINT sur_promotion_FK FOREIGN KEY (id_reduc) REFERENCES promotion(id_reduc)
	,CONSTRAINT sur_produit0_FK FOREIGN KEY (id) REFERENCES produit(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: recommandé
#------------------------------------------------------------

CREATE TABLE recommande(
        id         Char (32) NOT NULL ,
        id_produit Char (32) NOT NULL
	,CONSTRAINT recommande_PK PRIMARY KEY (id,id_produit)

	,CONSTRAINT recommande_produit_FK FOREIGN KEY (id) REFERENCES produit(id)
	,CONSTRAINT recommande_produit0_FK FOREIGN KEY (id_produit) REFERENCES produit(id)
)ENGINE=InnoDB;

