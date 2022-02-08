-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 10 déc. 2021 à 13:27
-- Version du serveur :  8.0.21
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

DROP DATABASE if exists sundaymorning;
CREATE DATABASE sundaymorning
CHARACTER SET utf8
COLLATE utf8_general_ci; 
USE sundaymorning;

--
-- Base de données : `sundaymorning`
--

DELIMITER $$
--
-- Procédures
--
DROP PROCEDURE IF EXISTS `Sp_ArticleCreate`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_ArticleCreate` (`idMod` INT, `idCol` INT, `idSz` INT, `nbArt` INT)  BEGIN
	INSERT INTO `sundaymorning`.`article` (idModel, idCouleur, idTaille, nbEle) 
    VALUES (idMod, idCol, idSz, nbArt);
END$$

DROP PROCEDURE IF EXISTS `Sp_ArticleDelete`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_ArticleDelete` (`id` INT)  BEGIN
    Delete 
	from article
    where idArticle = id;
END$$

DROP PROCEDURE IF EXISTS `Sp_ArticleRead`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_ArticleRead` (`id` INT)  BEGIN
    SELECT * 
	from article art
    Inner join model mdl on art.idModel = mdl.idModel
								AND art.idArticle = id
	Inner join taille tai on art.idTaille = tai.idTaille
								AND art.idArticle = id
	Inner join couleur col on art.idCouleur = col.idCouleur
								AND  art.idArticle = id
    where art.idArticle = id;
    
END$$

DROP PROCEDURE IF EXISTS `Sp_ArticlesRead`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_ArticlesRead` ()  BEGIN
    Select *  
	from article art
    inner join model mdl on art.idModel = mdl.idModel
    inner join taille tai on art.idTaille = tai.idTaille
    inner join couleur col on art.idCouleur = col.idCouleur;
END$$

DROP PROCEDURE IF EXISTS `Sp_ArticleUpdate`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_ArticleUpdate` (`idMod` INT, `idCol` INT, `idSz` INT, `nbEl` INT, `idArt` INT)  BEGIN
    update article 
	set idModel = idMod, idCouleur = idCol, idTaille = idSz, nbEle = nbEl
	where idArticle = idArt;
    
END$$

DROP PROCEDURE IF EXISTS `Sp_brandArtCatsearch`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_brandArtCatsearch` (`q` TEXT)  BEGIN
	Select  mart.libModel, prix, img, mrq.libMarque, cat.libCategorie 
	from model mart
	inner join  marque mrq on mart.idMarque = mrq.idMarque
	inner join article art on mart.idModel = art.idModel
	inner join couleur col on art.idCouleur = col.idCouleur
	inner join taille tai on art.idTaille = tai.idTaille
    inner join categorie cat on cat.idCategorie = mart.idCategorie
	Where mrq.libMarque like concat("%",q,"%")
	 or mart.libModel like concat("%",q,"%")
     or cat.libCategorie like concat("%",q,"%")
    Group by mart.libModel ;
  
END$$

DROP PROCEDURE IF EXISTS `Sp_BrandCreate`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_BrandCreate` (`libBr` TEXT)  BEGIN
    INSERT INTO `sundaymorning`.`marque` (`libMarque`) 
    VALUES (libBr);
    
END$$

DROP PROCEDURE IF EXISTS `Sp_BrandDelete`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_BrandDelete` (`id` INT)  BEGIN
    Delete 
	from marque
    where idMarque = id;
END$$

DROP PROCEDURE IF EXISTS `Sp_BrandRead`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_BrandRead` (`id` INT)  BEGIN
    SELECT * 
	from marque
    where idMarque = id;
    
END$$

DROP PROCEDURE IF EXISTS `Sp_BrandUpdate`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_BrandUpdate` (`libBr` TEXT, `idBr` INT)  BEGIN
    update marque 
	set libMarque = libBr
	where idMarque = idBr;
    
END$$

DROP PROCEDURE IF EXISTS `Sp_CategoryCreate`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_CategoryCreate` (`libCat` TEXT)  BEGIN
    INSERT INTO `sundaymorning`.`categorie` (`libCategorie`) 
    VALUES (libCat);
END$$

DROP PROCEDURE IF EXISTS `Sp_CategoryDelete`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_CategoryDelete` (`id` INT)  BEGIN
    Delete 
	from categorie
    where idCategorie = id;
END$$

DROP PROCEDURE IF EXISTS `Sp_CategoryRead`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_CategoryRead` (`id` INT)  BEGIN
    SELECT * 
	from categorie
    where idCategorie = id;
    
END$$

DROP PROCEDURE IF EXISTS `Sp_CategoryUpdate`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_CategoryUpdate` (`libCat` TEXT, `idCat` INT)  BEGIN
    update categorie 
	set libCategorie = libCat
    where idCategorie = idCat;
END$$

DROP PROCEDURE IF EXISTS `Sp_ColorCreate`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_ColorCreate` (`col` TEXT)  BEGIN
    INSERT INTO `sundaymorning`.`couleur` (`libCouleur`) 
    VALUES (col);
    
END$$

DROP PROCEDURE IF EXISTS `Sp_ColorDelete`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_ColorDelete` (`id` INT)  BEGIN
    Delete 
	from couleur
    where idCouleur = id;
END$$

DROP PROCEDURE IF EXISTS `Sp_ColorRead`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_ColorRead` (`id` INT)  BEGIN
    SELECT * 
	from couleur
    where idCouleur = id;
    
END$$

DROP PROCEDURE IF EXISTS `Sp_ColorUpdate`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_ColorUpdate` (`libCol` TEXT, `idCol` INT)  BEGIN
    update couleur 
	set libCouleur = libCol
    where idCouleur = idCol;
    
END$$

DROP PROCEDURE IF EXISTS `Sp_getSeveralRandomArticle`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_getSeveralRandomArticle` ()  BEGIN
Select * 
From model mart
inner join marque mrq on mrq.idMarque = mart.idMarque
order by rand();
END$$

DROP PROCEDURE IF EXISTS `Sp_modelArticleLire`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_modelArticleLire` (`idMod` INT)  BEGIN
	SELECT mdar.libModel, cat.libCategorie,GROUP_CONCAT(tai.libTaille SEPARATOR ";") AS artail , mdar.details, mdar.prix, GROUP_CONCAT(col.libCouleur SEPARATOR";") AS listcoul, GROUP_CONCAT(img.imgPath SEPARATOR";") as imgLst
	FROM model mdar 
	LEFT JOIN article art on art.idModel = mdar.idModel
							AND art.nbEle > 0
	LEFT JOIN couleur col on art.idCouleur = col.idCouleur
	LEFT JOIN taille tai on art.idTaille = tai.idTaille
	LEFT JOIN categorie cat on mdar.idCategorie = cat.idCategorie
	LEFT JOIN marque mrq on mdar.idMarque = mrq.idMarque
    LEFT JOIN image img on img.idArt = art.idModel
    WHERE mdar.idModel = idMod;
END$$

DROP PROCEDURE IF EXISTS `Sp_ModelDelete`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_ModelDelete` (`id` INT)  BEGIN
    Delete 
	from model
    where idModel = id;
END$$

DROP PROCEDURE IF EXISTS `Sp_ModelRead`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_ModelRead` (`id` INT)  BEGIN
    SELECT *
    from   model
    where idModel = id;
END$$

DROP PROCEDURE IF EXISTS `Sp_ModelsCreate`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_ModelsCreate` (`libMod` TEXT, `idBrand` INT, `idCat` INT, `price` INT, `details` TEXT, `imgPath` TEXT, `idImg` INT)  BEGIN
    INSERT INTO `sundaymorning`.`model` (`libModel`, `idMarque`, `idCategorie`, `prix`, `details`, `img`, `idImg`) 
    VALUES (libMod, idBrand, idCat, price, details, imgPath, idImg);
END$$

DROP PROCEDURE IF EXISTS `Sp_ModelsRead`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_ModelsRead` ()  BEGIN
    SELECT *
    from   model md
    inner join categorie cat
    on md.idCategorie = cat.idCategorie;
END$$

DROP PROCEDURE IF EXISTS `Sp_ModelUpdate`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_ModelUpdate` (`libMd` TEXT, `idBr` INT, `idCat` INT, `pr` INT, `dts` TEXT, `ima` TEXT, `idIma` INT, `idMod` INT)  BEGIN
    update model 
	set libModel = libMd, idMarque = idBr, idCategorie =idCat, prix =pr, details=dts, img =ima, idImg =idIma
	where idModel =idMod;
    
END$$

DROP PROCEDURE IF EXISTS `Sp_ProductAllRead`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_ProductAllRead` ()  BEGIN
    SELECT *
    FROM model mdar 
	LEFT JOIN article art on art.idModel = mdar.idModel
	LEFT JOIN couleur col on art.idCouleur = col.idCouleur
	LEFT JOIN taille tai on art.idTaille = tai.idTaille
	LEFT JOIN categorie cat on mdar.idCategorie = cat.idCategorie
	LEFT JOIN marque mrq on mdar.idMarque = mrq.idMarque
    LEFT JOIN image img on img.idArt = art.idModel ;
    
END$$

DROP PROCEDURE IF EXISTS `Sp_readArticlebyBrand`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_readArticlebyBrand` (`idBrd` INT)  BEGIN
     Select  libModel, prix, img, mrq.libMarque, nbEle
	from model mart
	inner join  marque mrq on mart.idMarque = mrq.idMarque
	inner join article art on mart.idModel = art.idModel
	inner join couleur col on art.idCouleur = col.idCouleur
	inner join taille tai on art.idTaille = tai.idTaille
	Where mrq.idMarque = idBrd
    Group by mart.libModel ;
END$$

DROP PROCEDURE IF EXISTS `Sp_readArticlebyCat`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_readArticlebyCat` (`idCat` INT)  BEGIN
	Select  mart.libModel, mart.prix, mart.img, mrq.libMarque, art.nbEle, cat.libCategorie, mart.idModel, mart.idCategorie
	from model mart
	inner join  marque mrq on mart.idMarque = mrq.idMarque
	left join article art on mart.idModel = art.idModel
    inner join categorie cat on mart.idCategorie = cat.idCategorie
	Where mart.idCategorie = idCat
    Group by mart.libModel ;
END$$

DROP PROCEDURE IF EXISTS `Sp_readArticlebyColor`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_readArticlebyColor` (`idCol` INT)  BEGIN
    Select  mart.libModel, prix, img, mrq.libMarque, nbEle
	from model mart
	inner join  marque mrq on mart.idMarque = mrq.idMarque
	inner join article art on mart.idModel = art.idModel
	inner join couleur col on art.idCouleur = col.idCouleur
	inner join taille tai on art.idTaille = tai.idTaille
	Where col.idCouleur = idCol 
    Group by mart.libModel ;
END$$

DROP PROCEDURE IF EXISTS `Sp_readArticlebySize`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_readArticlebySize` (`idSze` INT)  BEGIN
     Select  mart.libModel, prix, img, mrq.libMarque, nbEle
	from model mart
	inner join  marque mrq on mart.idMarque = mrq.idMarque
	inner join article art on mart.idModel = art.idModel
	inner join couleur col on art.idCouleur = col.idCouleur
	inner join taille tai on art.idTaille = tai.idTaille
	Where tai.idTaille = idSze 
    Group by mart.libModel ;
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

DROP PROCEDURE IF EXISTS `Sp_SizeCreate`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_SizeCreate` (`Sz` TEXT)  BEGIN
    INSERT INTO `sundaymorning`.`taille` (`libTaille`) 
    VALUES (Sz);
    
END$$

DROP PROCEDURE IF EXISTS `Sp_SizeDelete`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_SizeDelete` (`id` INT)  BEGIN
    Delete 
	from taille
    where idTaille = id;
END$$

DROP PROCEDURE IF EXISTS `Sp_SizeRead`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_SizeRead` (`id` INT)  BEGIN
    SELECT * 
	from taille
    where idTaille = id;
END$$

DELIMITER ;

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
  UNIQUE KEY `article` (`idModel`,`idCouleur`,`idTaille`),
  KEY `fk_modele` (`idModel`),
  KEY `fk_couleur` (`idCouleur`),
  KEY `fk_taille` (`idTaille`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`idArticle`, `idModel`, `idCouleur`, `idTaille`, `nbEle`) VALUES
(1, 40, 2, 3, 6),
(2, 39, 2, 2, 3),
(3, 40, 3, 3, 2),
(4, 39, 1, 1, 2),
(5, 41, 3, 3, 6),
(6, 42, 3, 5, 5);

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `idCategorie` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `libCategorie` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`idCategorie`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`idCategorie`, `libCategorie`) VALUES
(1, 'Pantalons'),
(2, 'Vestes'),
(3, 'Pulls'),
(4, 'Chemises'),
(5, 'Chaussures'),
(6, 'bracelet'),
(7, 'Nouvelle Categorie');

-- --------------------------------------------------------

--
-- Structure de la table `couleur`
--

DROP TABLE IF EXISTS `couleur`;
CREATE TABLE IF NOT EXISTS `couleur` (
  `idCouleur` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `libCouleur` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`idCouleur`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `couleur`
--

INSERT INTO `couleur` (`idCouleur`, `libCouleur`) VALUES
(1, 'black'),
(2, 'white'),
(3, 'red'),
(4, 'green'),
(5, 'yellow'),
(6, 'blue'),
(7, 'Bleu Ciel'),
(8, 'nouvelleCouleur');

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `idImg` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `idArt` int UNSIGNED NOT NULL,
  `idCoul` int UNSIGNED NOT NULL,
  `imgPath` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`idImg`),
  KEY `fk_img_article` (`idArt`),
  KEY `fk_img_coul` (`idCoul`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `marque`
--

DROP TABLE IF EXISTS `marque`;
CREATE TABLE IF NOT EXISTS `marque` (
  `idMarque` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `libMarque` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`idMarque`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `marque`
--

INSERT INTO `marque` (`idMarque`, `libMarque`) VALUES
(1, 'levi\'s'),
(2, 'vans'),
(3, 'samsoe'),
(4, 'carhart'),
(5, 'rick owens'),
(6, 'insane'),
(7, 'Floka'),
(8, 'Lacoste'),
(9, 'Nouvelle Marque'),
(10, 'MarqueNouvel');

-- --------------------------------------------------------

--
-- Structure de la table `model`
--

DROP TABLE IF EXISTS `model`;
CREATE TABLE IF NOT EXISTS `model` (
  `idModel` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `libModel` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `idMarque` int UNSIGNED DEFAULT NULL,
  `idCategorie` int UNSIGNED DEFAULT NULL,
  `prix` int UNSIGNED NOT NULL,
  `details` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `img` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `idImg` int NOT NULL,
  PRIMARY KEY (`idModel`),
  KEY `fk_marque` (`idMarque`),
  KEY `fk_categorie` (`idCategorie`),
  KEY `idImg` (`idImg`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `model`
--

INSERT INTO `model` (`idModel`, `libModel`, `idMarque`, `idCategorie`, `prix`, `details`, `img`, `idImg`) VALUES
(39, 'ModelA', 1, 1, 500, 'ModelA', 'ModelA52e4cf04cbfa12b415d381d7c54743324559b4a2.jpg', 1),
(40, 'Model2', 5, 4, 400, 'Model2', 'Model2a75e452024e97967a9465dceb0a36a41e069316f.jpg', 1),
(41, 'Model3', 4, 3, 400, 'Model3', 'Model323269cbb3e0fa608491fe12880143afe294cbbda.jpg', 1),
(42, 'Model6', 4, 4, 400, 'Model6', 'Model61d2ee12958dd61de863ca75bd8f7424e208d8108.jpg', 1),
(43, 'aaaa', 4, 3, 500, 'aaa', 'aaaa09796b8a76bcfbfc2c4e2a8314cc4096fdd89bb1.jpg', 1);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int NOT NULL,
  `role_label` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
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
  `libTaille` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`idTaille`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `taille`
--

INSERT INTO `taille` (`idTaille`, `libTaille`) VALUES
(1, 'XS'),
(2, 'S'),
(3, 'M'),
(4, 'L'),
(5, 'XL'),
(6, 'XXL'),
(7, 'XXXXL'),
(8, 'XXS'),
(9, 'nouvelleTaille');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `idUser` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `idArticle` int NOT NULL,
  PRIMARY KEY (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`idUser`, `firstname`, `lastname`, `email`, `password`, `created_at`, `idArticle`) VALUES
(3, 'michel', 'polnaref', 'michel.polnaref@gmail.com', '$2y$10$U69xMHJgcuCBq1begrxky.4L0iMWEKjdguSCumjHwoWaVE5xuSUC6', '2021-08-17 15:42:54', 0),
(4, 'aaa', 'bbb', 'a.b@gmail.com', '$2y$10$nrOjUE8gfu9WmXajBh0P5.sTJ936gKi4HE.i91bY1eQoxeMawwBNe', '2021-09-28 09:04:30', 0),
(5, 'aaac', 'bbbc', 'ac.b@gmail.com', '$2y$10$OT2qUYA13.cKX3c4fDS2UO6yFMLI/wf77g2KFhGJMu5aX86sjbRAG', '2021-09-28 09:08:45', 0),
(6, 'aaacd', 'bbbcd', 'acd.b@gmail.com', '$2y$10$wgf0w4wQdZfR3s1xTiAtruFryC9kgj2URN3hgabBbHnBkpKtiBGc2', '2021-09-28 09:14:01', 0),
(7, 'aaacdd', 'bbbcd', 'acdd.b@gmail.com', '$2y$10$NEJ70OLRmLkvIQu.k8qs8erT0dZkGcMftzZ3H4WWUGzmLEmu/wjgW', '2021-09-28 09:20:27', 0),
(8, 'beta', 'tabe', 'bet.tab@gmail.Com', '$2y$10$4RRYfi9WicQLya736Kkdfu9jow47.kSI/XrB24idP0e/aXAj8/N7y', '2021-09-28 09:40:42', 0),
(9, 'betaa', 'tabea', 'bet.atab@gmail.Com', '$2y$10$S6/nXdhJ9lhZyEUGLXs4ueQ0aee//rJ57HlZQWEujqk4SBVB/SRf6', '2021-09-28 09:52:12', 0),
(10, 'betaaa', 'tabeaa', 'bet.aatab@gmail.Com', '$2y$10$a..nYugm7iBU4sJGSeqpz.qGbJzas9k0OB/h3iZick.JQD5kZ1f9.', '2021-09-28 09:52:47', 0),
(11, 'hichem', 'adnot', 'hichem.adnot@gmail.com', '$2y$10$XNt3MtudoNaqI6Uq4ERSduL/sQACZHgAjQAG5aCxNu12yUPq.dQ.2', '2021-09-28 09:59:01', 0),
(12, 'Nouvel', 'Utilisateur1', 'nouvel_Utilisateur1@gmail.com', '$2y$10$8N3/0p2FanVWOyWBz0k7T.1gDnZMHWDkaMZFNcXponKsn/dc4j7MW', '2021-12-03 09:53:19', 0),
(13, 'Admin', 'Admin', 'admin@gmail.com', '$2y$10$8SksTyfUfu0257WHRRWRYeAyXGxBi9QQwvAsTPjHpYVWYLoVEbYzy', '2021-12-03 11:05:45', 0);

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
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `role_id` (`role_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user_role`
--

INSERT INTO `user_role` (`user_id`, `role_id`) VALUES
(3, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 3);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `fk_article` FOREIGN KEY (`idModel`) REFERENCES `model` (`idModel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_couleur` FOREIGN KEY (`idCouleur`) REFERENCES `couleur` (`idCouleur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_taille` FOREIGN KEY (`idTaille`) REFERENCES `taille` (`idTaille`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `fk_img_article` FOREIGN KEY (`idArt`) REFERENCES `model` (`idModel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_img_coul` FOREIGN KEY (`idCoul`) REFERENCES `couleur` (`idCouleur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `model`
--
ALTER TABLE `model`
  ADD CONSTRAINT `fk_categorie` FOREIGN KEY (`idCategorie`) REFERENCES `categorie` (`idCategorie`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_marque` FOREIGN KEY (`idMarque`) REFERENCES `marque` (`idMarque`) ON DELETE CASCADE ON UPDATE CASCADE;

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
