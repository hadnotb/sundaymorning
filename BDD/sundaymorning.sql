-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 22 sep. 2021 à 14:11
-- Version du serveur :  8.0.21
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

DROP DATABASE sundaymorning;
CREATE DATABASE sundaymorning;
USE sundaymorning;
--
-- Base de données : `sundaymorning2`
--

DELIMITER $$
--
-- Procédures
--
DROP PROCEDURE IF EXISTS `Sp_brandArtCatsearch`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_brandArtCatsearch` (`q` TEXT)  BEGIN
		Select  mart.libArticle, prix, img, mrq.libMarque, cat.libCategorie 
	from model_article mart
	inner join  marque mrq on mart.idMarque = mrq.idMarque
	inner join article art on mart.idArticle = art.idArticle
	inner join couleur col on art.idCouleur = col.idCouleur
	inner join taille tai on art.idTaille = tai.idTaille
    inner join categorie cat on cat.idCategorie = mart.idCategorie
	Where mrq.libMarque like concat("%",q,"%")
	 or mart.libArticle like concat("%",q,"%")
     or cat.libCategorie like concat("%",q,"%")
    Group by mart.libArticle ;
  
END$$

DROP PROCEDURE IF EXISTS `Sp_modelArticleLire`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_modelArticleLire` (`idArt` INT)  BEGIN
	SELECT mdar.libArticle, cat.libCategorie,GROUP_CONCAT(tai.libTaille SEPARATOR ";") AS artail , mdar.details, mdar.prix, GROUP_CONCAT(col.libCouleur SEPARATOR";") AS listcoul, GROUP_CONCAT(img.imgPath SEPARATOR";") as imgLst
	FROM model_article mdar 
	INNER JOIN article art on art.idArticle = mdar.idArticle
							AND art.nbEle > 0
	INNER JOIN couleur col on art.idCouleur = col.idCouleur
	INNER JOIN taille tai on art.idTaille = tai.idTaille
	INNER JOIN categorie cat on mdar.idCategorie = cat.idCategorie
	INNER JOIN marque mrq on mdar.idMarque = mrq.idMarque
    INNER JOIN image img on img.idArt = art.idArticle 
    WHERE mdar.idArticle = idArt;
END$$

DROP PROCEDURE IF EXISTS `Sp_readArticlebyBrand`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_readArticlebyBrand` (`idBrd` INT)  BEGIN
     Select  libArticle, prix, img, mrq.libMarque, nbEle
	from model_article mart
	inner join  marque mrq on mart.idMarque = mrq.idMarque
	inner join article art on mart.idArticle = art.idArticle
	inner join couleur col on art.idCouleur = col.idCouleur
	inner join taille tai on art.idTaille = tai.idTaille
	Where mrq.idMarque = idBrd
    Group by mart.libArticle ;
END$$

DROP PROCEDURE IF EXISTS `Sp_readArticlebyCat`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_readArticlebyCat` (`idCat` INT)  BEGIN
     Select  mart.libArticle, prix, img, mrq.libMarque, nbEle, cat.libCategorie
	from model_article mart
	inner join  marque mrq on mart.idMarque = mrq.idMarque
	inner join article art on mart.idArticle = art.idArticle
    inner join categorie cat on mart.idCategorie = cat.idCategorie
	Where cat.idCategorie = idCat 
    Group by mart.libArticle ;
END$$

DROP PROCEDURE IF EXISTS `Sp_readArticlebyColor`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_readArticlebyColor` (`idCol` INT)  BEGIN
    Select  mart.libArticle, prix, img, mrq.libMarque, nbEle
	from model_article mart
	inner join  marque mrq on mart.idMarque = mrq.idMarque
	inner join article art on mart.idArticle = art.idArticle
	inner join couleur col on art.idCouleur = col.idCouleur
	inner join taille tai on art.idTaille = tai.idTaille
	Where col.idCouleur = idCol 
    Group by mart.libArticle ;
END$$

DROP PROCEDURE IF EXISTS `Sp_readArticlebySize`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_readArticlebySize` (`idSze` INT)  BEGIN
     Select  mart.libArticle, prix, img, mrq.libMarque, nbEle
	from model_article mart
	inner join  marque mrq on mart.idMarque = mrq.idMarque
	inner join article art on mart.idArticle = art.idArticle
	inner join couleur col on art.idCouleur = col.idCouleur
	inner join taille tai on art.idTaille = tai.idTaille
	Where tai.idTaille = idSze 
    Group by mart.libArticle ;
END$$

DROP PROCEDURE IF EXISTS `Sp_readBrand`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_readBrand` ()  BEGIN
    Select *
    from marque;
END$$

DROP PROCEDURE IF EXISTS `sp_ReadCategory`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ReadCategory` ()  BEGIN
    Select *
    from categorie;
END$$

DROP PROCEDURE IF EXISTS `Sp_readColor`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_readColor` ()  BEGIN
    Select *
    from couleur;
END$$

DROP PROCEDURE IF EXISTS `Sp_readSize`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_readSize` ()  BEGIN
    Select *
    from taille;
END$$

DELIMITER ;


--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `idCategorie` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `libCategorie` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`idCategorie`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`idCategorie`, `libCategorie`) VALUES
(1, 'Pantalons'),
(2, 'Vestes'),
(3, 'Pulls'),
(4, 'Chemises'),
(5, 'Chaussures');

-- --------------------------------------------------------

--
-- Structure de la table `couleur`
--

DROP TABLE IF EXISTS `couleur`;
CREATE TABLE IF NOT EXISTS `couleur` (
  `idCouleur` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `libCouleur` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`idCouleur`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `couleur`
--

INSERT INTO `couleur` (`idCouleur`, `libCouleur`) VALUES
(1, 'noir'),
(2, 'blanc'),
(3, 'rouge'),
(4, 'vert'),
(5, 'jaune'),
(6, 'bleu');

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `idImg` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `idArt` int UNSIGNED NOT NULL,
  `idCoul` int UNSIGNED NOT NULL,
  `imgPath` varchar(128) NOT NULL,
  `imgNum` int UNSIGNED NOT NULL,
  PRIMARY KEY (`idImg`),
  KEY `fk_img_article` (`idArt`),
  KEY `fk_img_coul` (`idCoul`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `image`
--

INSERT INTO `image` (`idImg`, `idArt`, `idCoul`, `imgPath`, `imgNum`) VALUES
(1, 1, 1, 'article_1_bleu.jpg', 1),
(2, 2, 2, 'article_1_vert.jpg', 2);

-- --------------------------------------------------------

--
-- Structure de la table `marque`
--

DROP TABLE IF EXISTS `marque`;
CREATE TABLE IF NOT EXISTS `marque` (
  `idMarque` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `libMarque` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`idMarque`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `marque`
--

INSERT INTO `marque` (`idMarque`, `libMarque`) VALUES
(1, 'levi\'s'),
(2, 'vans'),
(3, 'samsoe'),
(4, 'carhart'),
(5, 'rick owens'),
(6, 'insane');

-- --------------------------------------------------------

--
-- Structure de la table `model`
--

DROP TABLE IF EXISTS `model`;
CREATE TABLE IF NOT EXISTS `model` (
  `idModel` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `libModel` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  `idMarque` int UNSIGNED DEFAULT NULL,
  `idCategorie` int UNSIGNED DEFAULT NULL,
  `prix` int UNSIGNED NOT NULL,
  `details` mediumtext COLLATE utf8mb4_general_ci,
  `img` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`idModel`),
  KEY `fk_marque` (`idMarque`),
  KEY `fk_categorie` (`idCategorie`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `model`
--

INSERT INTO `model` (`idModel`, `libModel`, `idMarque`, `idCategorie`, `prix`, `details`, `img`) VALUES
(1, 'Trouser Slim', 1, 1, 45, 'Blabla bli blou bla blo arianaaa gladiaa hamida choumicha habiba', 'article_1_bleu.jpg'),
(2, 'Jacket fill', 2, 2, 52, 'Blabla bli blou bla blo arianaaa gladiaa hamida choumicha habiba', 'article_1_vert.jpg'),
(3, 'Sweet fun', 3, 3, 40, 'Blabla bli blou bla blo arianaaa gladiaa hamida choumicha habiba', 'samsoe.jpg'),
(4, 'Chemise heat', 4, 4, 54, 'Blabla bli blou bla blo arianaaa gladiaa hamida choumicha habiba', 'samsoe1.jpg'),
(5, 'Sneakerboot', 5, 5, 66, 'Blabla bli blou bla blo arianaaa gladiaa hamida choumicha habiba', 'samsoe1.jpg'),
(6, 'Sarwel tchoul', 6, 1, 48, 'Blabla bli blou bla blo arianaaa gladiaa hamida choumicha habiba', 'samsoe.jpg'),
(7, 'Santiage cow', 4, 5, 74, 'Blabla bli blou bla blo arianaaa gladiaa hamida choumicha habiba', 'samsoe.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int NOT NULL,
  `role_label` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `role_label`) VALUES
(1, 'USER'),
(2, 'EDITOR'),
(3, 'ADMIN');

-- --------------------------------------------------------

--
-- Structure de la table `taille`
--

DROP TABLE IF EXISTS `taille`;
CREATE TABLE IF NOT EXISTS `taille` (
  `idTaille` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `libTaille` varchar(128) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`idTaille`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `taille`
--

INSERT INTO `taille` (`idTaille`, `libTaille`) VALUES
(1, 'XS'),
(2, 'S'),
(3, 'M'),
(4, 'L'),
(5, 'XL');

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `idArticle` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `idModel` int UNSIGNED NOT NULL,
  `idCouleur` int UNSIGNED NOT NULL,
  `idTaille` int UNSIGNED NOT NULL,
  `nbEle` int UNSIGNED NOT NULL,
  PRIMARY KEY (`idArticle`),
  UNIQUE `article` (`idModel`,`idCouleur`,`idTaille`),
  KEY `fk_modele` (`idModel`),
  KEY `fk_couleur` (`idCouleur`),
  KEY `fk_taille` (`idTaille`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`idModel`, `idCouleur`, `idTaille`, `nbEle`) VALUES
(1, 1, 4, 1),
(1, 2, 5, 2),
(1, 3, 4, 2),
(2, 1, 2, 1),
(2, 2, 2, 2),
(2, 3, 1, 1),
(3, 1, 2, 3),
(3, 2, 3, 1),
(3, 4, 4, 2),
(4, 4, 3, 0),
(4, 5, 3, 1),
(5, 5, 1, 2),
(5, 5, 2, 3),
(6, 1, 3, 1),
(6, 2, 2, 3),
(7, 3, 4, 2);

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `idUser` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `idArticle` int NOT NULL,
  PRIMARY KEY (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`idUser`, `firstname`, `lastname`, `email`, `password`, `created_at`, `idArticle`) VALUES
(3, 'michel', 'polnaref', 'michel.polnaref@gmail.com', '$2y$10$U69xMHJgcuCBq1begrxky.4L0iMWEKjdguSCumjHwoWaVE5xuSUC6', '2021-08-17 15:42:54', 0);

-- --------------------------------------------------------

--
-- Structure de la table `user_article`
--

DROP TABLE IF EXISTS `user_article`;
CREATE TABLE IF NOT EXISTS `user_article` (
  `idUser` int NOT NULL,
  `idArticle` int NOT NULL,
  UNIQUE KEY `idArticle` (`idArticle`),
  KEY `idUser` (`idUser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
CREATE TABLE IF NOT EXISTS `user_role` (
  `user_id` int NOT NULL,
  `role_id` int NOT NULL,
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user_role`
--

INSERT INTO `user_role` (`user_id`, `role_id`) VALUES
(3, 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `fk_article` FOREIGN KEY (`idModel`) REFERENCES `model` (`idModel`),
  ADD CONSTRAINT `fk_couleur` FOREIGN KEY (`idCouleur`) REFERENCES `couleur` (`idCouleur`),
  ADD CONSTRAINT `fk_taille` FOREIGN KEY (`idTaille`) REFERENCES `taille` (`idTaille`);

--
-- Contraintes pour la table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `fk_img_article` FOREIGN KEY (`idArt`) REFERENCES `model` (`idModel`),
  ADD CONSTRAINT `fk_img_coul` FOREIGN KEY (`idCoul`) REFERENCES `couleur` (`idCouleur`);

--
-- Contraintes pour la table `model`
--
ALTER TABLE `model`
  ADD CONSTRAINT `fk_categorie` FOREIGN KEY (`idCategorie`) REFERENCES `categorie` (`idCategorie`),
  ADD CONSTRAINT `fk_marque` FOREIGN KEY (`idMarque`) REFERENCES `marque` (`idMarque`);

--
-- Contraintes pour la table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `user_role_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
