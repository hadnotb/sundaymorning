DELIMITER //
DROP PROCEDURE IF EXISTS Sp_ArticleDelete//
CREATE PROCEDURE Sp_ArticleDelete(id int) 
BEGIN
    Delete 
	from article
    where idArticle = id;
END//