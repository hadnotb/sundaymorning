CREATE DEFINER=`root`@`localhost` PROCEDURE `Sp_ModelsCreate`(libArticle text, idBrand int, idCat int, price int, details int, imgPath int, idImg int)
BEGIN
    INSERT INTO `sundaymorning`.`model_article` (`libArticle`, `idMarque`, `idCategorie`, `prix`, `details`, `img`, `idImg`) 
    VALUES (libArticle, idBrand, idBrand, price, details, imgPath, idImg);
END