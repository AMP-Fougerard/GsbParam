-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 07 mai 2023 à 14:27
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `gsbparam_2`
--

-- --------------------------------------------------------

--
-- Structure de la table `archivagecommande`
--

DROP TABLE IF EXISTS `archivagecommande`;
CREATE TABLE IF NOT EXISTS `archivagecommande` (
  `id` char(32) COLLATE utf8mb4_bin NOT NULL,
  `dateCommande` date DEFAULT NULL,
  `nomPrenomClient` char(32) COLLATE utf8mb4_bin DEFAULT NULL,
  `adresseRueClient` char(32) COLLATE utf8mb4_bin DEFAULT NULL,
  `cpClient` char(5) COLLATE utf8mb4_bin DEFAULT NULL,
  `villeClient` char(32) COLLATE utf8mb4_bin DEFAULT NULL,
  `mailClient` char(50) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `archivecontenir`
--

DROP TABLE IF EXISTS `archivecontenir`;
CREATE TABLE IF NOT EXISTS `archivecontenir` (
  `id` char(32) COLLATE utf8mb4_bin NOT NULL,
  `id_archivagecommande` char(32) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`,`id_archivagecommande`),
  KEY `archivecontenir_archivagecommande0_FK` (`id_archivagecommande`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

DROP TABLE IF EXISTS `avis`;
CREATE TABLE IF NOT EXISTS `avis` (
  `mail` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `idAvis` int(11) NOT NULL,
  `note` float NOT NULL,
  `contenu_avis` int(11) NOT NULL,
  PRIMARY KEY (`mail`,`idAvis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` char(32) COLLATE utf8mb4_bin NOT NULL,
  `libelle` char(32) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `libelle`) VALUES
('CH', 'Cheveux'),
('FO', 'Forme'),
('PS', 'Protection Solaire');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `mail` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `id` char(32) COLLATE utf8mb4_bin NOT NULL,
  `dateCommande` date DEFAULT NULL,
  `etatCde` char(1) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`mail`,`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

DROP TABLE IF EXISTS `compte`;
CREATE TABLE IF NOT EXISTS `compte` (
  `mail` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `pass` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`mail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `compte`
--

INSERT INTO `compte` (`mail`, `pass`, `admin`) VALUES
('a.fougerard@gmail.fr', '$2y$10$thuLWMDRfGPnO8St6vwu7OuojH9NbPmguDZO4ISoRvC.Z.pyvwahe', 0);

-- --------------------------------------------------------

--
-- Structure de la table `concerne`
--

DROP TABLE IF EXISTS `concerne`;
CREATE TABLE IF NOT EXISTS `concerne` (
  `id` char(32) COLLATE utf8mb4_bin NOT NULL,
  `mail` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `idAvis` int(11) NOT NULL,
  PRIMARY KEY (`id`,`mail`,`idAvis`),
  KEY `concerne_avis0_FK` (`mail`,`idAvis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `contenir`
--

DROP TABLE IF EXISTS `contenir`;
CREATE TABLE IF NOT EXISTS `contenir` (
  `id` char(32) COLLATE utf8mb4_bin NOT NULL,
  `id_contenance` int(11) NOT NULL,
  `mail_commande` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `id_commande` char(32) COLLATE utf8mb4_bin NOT NULL,
  `qte` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`,`id_contenance`,`mail_commande`,`id_commande`),
  KEY `contenir_commande0_FK` (`mail_commande`,`id_commande`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `marque`
--

DROP TABLE IF EXISTS `marque`;
CREATE TABLE IF NOT EXISTS `marque` (
  `id_marque` int(11) NOT NULL AUTO_INCREMENT,
  `nom_marque` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  PRIMARY KEY (`id_marque`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `marque`
--

INSERT INTO `marque` (`id_marque`, `nom_marque`) VALUES
(1, 'Laino'),
(2, 'Klorane'),
(3, 'Weleda'),
(4, 'Phytopulp'),
(5, 'Nuxe'),
(6, 'Avène'),
(7, 'Bioderma'),
(8, 'Futuro sport'),
(9, 'ISDIN'),
(10, 'La Roche Posay'),
(11, 'Microlife'),
(12, 'Melapi'),
(13, 'Mustela'),
(14, 'Uriage'),
(15, 'Somirel');

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `id` char(32) COLLATE utf8mb4_bin NOT NULL,
  `id_contenance` int(11) NOT NULL,
  `mail` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `qte` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`,`id_contenance`,`mail`),
  KEY `Panier_compte0_FK` (`mail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id` char(32) COLLATE utf8mb4_bin NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `description` char(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `image` char(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `dateMiseEnRayon` date NOT NULL,
  `id_categorie` char(32) COLLATE utf8mb4_bin NOT NULL,
  `id_marque` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `produit_categorie_FK` (`id_categorie`),
  KEY `produit_marque_FK` (`id_marque`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `libelle`, `description`, `image`, `dateMiseEnRayon`, `id_categorie`, `id_marque`) VALUES
('c01', 'Shampooing Douche BIO', 'Laino Shampooing Douche au Thé Vert BIO', 'images/laino-shampooing-douche-au-the-vert-bio-200ml.png', '0000-00-00', 'CH', 1),
('c02', 'Après shampooing', 'Klorane fibres de lin baume après shampooing', 'images/klorane-fibres-de-lin-baume-apres-shampooing-150-ml.jpg', '0000-00-00', 'CH', 2),
('c03', 'Shampooing orange', 'Weleda Kids 2in1 Shower & Shampoo Orange fruitée', 'images/weleda-kids-2in1-shower-shampoo-orange-fruitee-150-ml.jpg', '0000-00-00', 'CH', 3),
('c04', 'Shampooing vanille', 'Weleda Kids 2in1 Shower & Shampoo vanille douce', 'images/weleda-kids-2in1-shower-shampoo-vanille-douce-150-ml.jpg', '0000-00-00', 'CH', 3),
('c05', 'Shampooing sec', 'Klorane Shampooing sec à l\'extrait d\'ortie', 'images/klorane-shampooing-sec-a-l-extrait-d-ortie-spray-150ml.png', '0000-00-00', 'CH', 2),
('c06', 'Mousse volume', 'Phytopulp mousse volume intense', 'images/phytopulp-mousse-volume-intense-200ml.jpg', '0000-00-00', 'CH', 4),
('c07', 'Shampooing nutritif', 'Bio Beaute by Nuxe Shampooing nutritif', 'images/bio-beaute-by-nuxe-shampooing-nutritif-200ml.png', '0000-00-00', 'CH', 5),
('f01', 'Contour yeux', 'Nuxe Men Contour des Yeux Multi-Fonctions', 'images/nuxe-men-contour-des-yeux-multi-fonctions-15ml.png', '0000-00-00', 'FO', 5),
('f02', 'Tisane en sachet', 'Tisane romon nature sommirel bio sachet 20', 'images/tisane-romon-nature-sommirel-bio-sachet-20.jpg', '0000-00-00', 'FO', 15),
('f03', 'Crème pansement', 'La Roche Posay Cicaplast crème pansement', 'images/la-roche-posay-cicaplast-creme-pansement-40ml.jpg', '0000-00-00', 'FO', 10),
('f04', 'Stabilisateur cheville', 'Futuro sport stabilisateur pour cheville', 'images/futuro-sport-stabilisateur-pour-cheville-deluxe-attelle-cheville.png', '0000-00-00', 'FO', 8),
('f05', 'Pèse-personne électronique', 'Microlife pèse-personne électronique weegschaal', 'images/microlife-pese-personne-electronique-weegschaal-ws80.jpg', '0000-00-00', 'FO', 11),
('f06', 'Miel Liquide', 'Melapi Miel Thym Liquide 500g', 'images/melapi-miel-thym-liquide-500g.jpg', '0000-00-00', 'FO', 12),
('f07', 'Pollen', 'Meli Meliflor Pollen 200g', 'images/melapi-pollen-250g.jpg', '0000-00-00', 'FO', 12),
('p01', 'Spray solaire', 'Avène solaire Spray très haute protection', 'images/avene-solaire-spray-tres-haute-protection-spf50200ml.png', '0000-00-00', 'PS', 6),
('p02', 'Crème solaire', 'Mustela Solaire Lait très haute Protection', 'images/mustela-solaire-lait-tres-haute-protection-spf50-100ml.jpg', '0000-00-00', 'PS', 13),
('p03', 'Crème', 'Isdin Eryfotona aAK fluid', 'images/isdin-eryfotona-aak-fluid-100-50ml.jpg', '0000-00-00', 'PS', 9),
('p04', 'Spray visage', 'La Roche Posay Anthélios 50+ Brume Visage', 'images/la-roche-posay-anthelios-50-brume-visage-toucher-sec-75ml.png', '0000-00-00', 'PS', 10),
('p05', 'Huile Capillaire', 'Nuxe Sun Huile Lactée Capillaire Protectrice', 'images/nuxe-sun-huile-lactee-capillaire-protectrice-100ml.png', '0000-00-00', 'PS', 5),
('p06', 'Stick lèvres', 'Uriage Bariésun stick lèvres SPF30 4g', 'images/uriage-bariesun-stick-levres-spf30-4g.jpg', '0000-00-00', 'PS', 14),
('p07', 'Crème cicatrisante', 'Bioderma Cicabio creme SPF50+ 30ml', 'images/bioderma-cicabio-creme-spf50-30ml.png', '0000-00-00', 'PS', 7);

-- --------------------------------------------------------

--
-- Structure de la table `produitcontenance`
--

DROP TABLE IF EXISTS `produitcontenance`;
CREATE TABLE IF NOT EXISTS `produitcontenance` (
  `id` char(32) COLLATE utf8mb4_bin NOT NULL,
  `id_contenance` int(11) NOT NULL,
  `prix` double NOT NULL,
  `qte` int(11) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `isBase` tinyint(1) NOT NULL,
  `id_unit` int(11) NOT NULL,
  PRIMARY KEY (`id`,`id_contenance`),
  KEY `ProduitContenance_unites0_FK` (`id_unit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `produitcontenance`
--

INSERT INTO `produitcontenance` (`id`, `id_contenance`, `prix`, `qte`, `stock`, `isBase`, `id_unit`) VALUES
('c01', 1, 4, 1, 50, 1, 5),
('c02', 1, 11, 1, 0, 1, 5),
('c03', 1, 4, 1, 50, 1, 5),
('c04', 1, 4, 1, 50, 1, 5),
('c05', 1, 6, 1, 50, 1, 5),
('c06', 1, 18, 1, 50, 1, 5),
('c07', 1, 8, 1, 50, 1, 5),
('f01', 1, 12, 1, 50, 1, 5),
('f02', 1, 6, 20, 50, 1, 6),
('f02', 2, 12, 40, 5, 0, 6),
('f03', 1, 11, 1, 50, 1, 5),
('f04', 1, 27, 1, 50, 1, 5),
('f05', 1, 63, 1, 50, 1, 5),
('f06', 1, 7, 500, 50, 1, 3),
('f07', 1, 9, 200, 50, 1, 3),
('p01', 1, 22, 1, 50, 1, 5),
('p02', 1, 18, 1, 50, 1, 5),
('p03', 1, 29, 1, 50, 1, 5),
('p04', 1, 9, 1, 50, 1, 5),
('p05', 1, 15, 1, 50, 1, 5),
('p06', 1, 6, 4, 50, 1, 3),
('p07', 1, 14, 30, 50, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `promotion`
--

DROP TABLE IF EXISTS `promotion`;
CREATE TABLE IF NOT EXISTS `promotion` (
  `id_reduc` float NOT NULL,
  `poidsReco` int(11) NOT NULL,
  PRIMARY KEY (`id_reduc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `recommande`
--

DROP TABLE IF EXISTS `recommande`;
CREATE TABLE IF NOT EXISTS `recommande` (
  `id` char(32) COLLATE utf8mb4_bin NOT NULL,
  `id_produit` char(32) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`,`id_produit`),
  KEY `recommande_produit0_FK` (`id_produit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `sur`
--

DROP TABLE IF EXISTS `sur`;
CREATE TABLE IF NOT EXISTS `sur` (
  `id_reduc` float NOT NULL,
  `id` char(32) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id_reduc`,`id`),
  KEY `sur_produit0_FK` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `unites`
--

DROP TABLE IF EXISTS `unites`;
CREATE TABLE IF NOT EXISTS `unites` (
  `id_unit` int(11) NOT NULL,
  `unit_intitule` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id_unit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `unites`
--

INSERT INTO `unites` (`id_unit`, `unit_intitule`) VALUES
(1, 'ml'),
(2, 'L'),
(3, 'g'),
(4, 'kg'),
(5, 'paquets'),
(6, 'sachets');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `archivecontenir`
--
ALTER TABLE `archivecontenir`
  ADD CONSTRAINT `archivecontenir_archivagecommande0_FK` FOREIGN KEY (`id_archivagecommande`) REFERENCES `archivagecommande` (`id`),
  ADD CONSTRAINT `archivecontenir_produit_FK` FOREIGN KEY (`id`) REFERENCES `produit` (`id`);

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `avis_compte_FK` FOREIGN KEY (`mail`) REFERENCES `compte` (`mail`);

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_compte_FK` FOREIGN KEY (`mail`) REFERENCES `compte` (`mail`);

--
-- Contraintes pour la table `concerne`
--
ALTER TABLE `concerne`
  ADD CONSTRAINT `concerne_avis0_FK` FOREIGN KEY (`mail`,`idAvis`) REFERENCES `avis` (`mail`, `idAvis`),
  ADD CONSTRAINT `concerne_produit_FK` FOREIGN KEY (`id`) REFERENCES `produit` (`id`);

--
-- Contraintes pour la table `contenir`
--
ALTER TABLE `contenir`
  ADD CONSTRAINT `contenir_ProduitContenance_FK` FOREIGN KEY (`id`,`id_contenance`) REFERENCES `produitcontenance` (`id`, `id_contenance`),
  ADD CONSTRAINT `contenir_commande0_FK` FOREIGN KEY (`mail_commande`,`id_commande`) REFERENCES `commande` (`mail`, `id`);

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `Panier_ProduitContenance_FK` FOREIGN KEY (`id`,`id_contenance`) REFERENCES `produitcontenance` (`id`, `id_contenance`),
  ADD CONSTRAINT `Panier_compte0_FK` FOREIGN KEY (`mail`) REFERENCES `compte` (`mail`);

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `produit_categorie_FK` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id`),
  ADD CONSTRAINT `produit_marque_FK` FOREIGN KEY (`id_marque`) REFERENCES `marque` (`id_marque`);

--
-- Contraintes pour la table `produitcontenance`
--
ALTER TABLE `produitcontenance`
  ADD CONSTRAINT `ProduitContenance_produit_FK` FOREIGN KEY (`id`) REFERENCES `produit` (`id`),
  ADD CONSTRAINT `ProduitContenance_unites0_FK` FOREIGN KEY (`id_unit`) REFERENCES `unites` (`id_unit`);

--
-- Contraintes pour la table `recommande`
--
ALTER TABLE `recommande`
  ADD CONSTRAINT `recommande_produit0_FK` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id`),
  ADD CONSTRAINT `recommande_produit_FK` FOREIGN KEY (`id`) REFERENCES `produit` (`id`);

--
-- Contraintes pour la table `sur`
--
ALTER TABLE `sur`
  ADD CONSTRAINT `sur_produit0_FK` FOREIGN KEY (`id`) REFERENCES `produit` (`id`),
  ADD CONSTRAINT `sur_promotion_FK` FOREIGN KEY (`id_reduc`) REFERENCES `promotion` (`id_reduc`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
