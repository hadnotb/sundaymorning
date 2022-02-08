DELIMITER //
DROP PROCEDURE IF EXISTS Sp_ArticleCreate//
CREATE PROCEDURE Sp_ArticleCreate (idArt int, idCol int, idSz int, nbArt int) 
BEGIN
	INSERT INTO `sundaymorning`.`article` (idArticle, idCouleur, idTaille, nbEle) 
    VALUES (idArt, idCol, idSz, nbArt);
END//